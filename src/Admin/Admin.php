<?php

namespace LimousineSearch\Admin;

use DateTime;
use DateTimeZone;
use LimousineSearch\Exceptions\UnauthorizedException;
use LimousineSearch\Includes\Api;
use LimousineSearch\Includes\Helper;

class Admin
{
	private string $pluginName;

	private string $version;

	public function __construct(string $pluginName, string $version)
    {
		$this->pluginName = $pluginName;
		$this->version = $version . uniqid();
	}

	public function enqueueStyles(): void
    {
		wp_enqueue_style($this->pluginName, Helper::resource('css/admin.css'), [], $this->version, 'all');
	}

	public function enqueueScripts(): void
    {
        wp_enqueue_script($this->pluginName, Helper::resource('js/admin.js'), ['jquery'], $this->version, false);
    }

    public function registerSettings(): void
    {
        register_setting($this->pluginName, $this->pluginName . '_settings', function ($input) {
            try {
                $apiToken = $input[$this->pluginName . '_api_token'] ?? '';

                $company = (new Api($this->pluginName, $apiToken))->company();

                $now = new DateTime(null, new DateTimeZone($company->getTimezone()));

                update_option($this->pluginName . '_company', $company);
                update_option($this->pluginName . '_company_slug', $company->getSlug());
                update_option($this->pluginName . '_company_updated_at', $now->format('m/d/Y H:i:s'));
            } catch (UnauthorizedException $e) {
                add_settings_error(
                    $this->pluginName . '_messages',
                    400,
                    __('This Api token seems to be wrong. We couldn\'t connect with Limousine Search', $this->pluginName),
                    'error'
                );

                update_option($this->pluginName . '_company', '');
                update_option($this->pluginName . '_company_slug', '');
                update_option($this->pluginName . '_company_updated_at', '');
            } finally {
                return $input;
            }
        });

        add_settings_section(
            $this->pluginName . '_settings',
            __('Settings', $this->pluginName),
            '',
            $this->pluginName
        );

        add_settings_field(
            $this->pluginName . '_api_token',
            __('Api Token', $this->pluginName),
            function ($args) {
                echo Helper::safeView('admin.fields.text', [
                    'pluginName' => $this->pluginName,
                    'name' => $this->pluginName . '_api_token',
                    'description' => __('Api token you create on Limousine Search Dashboard', $this->pluginName),
                ]);
            },
            $this->pluginName,
            $this->pluginName . '_settings',
        );
    }

    public function registerMenu(): void
    {
        add_menu_page(
            'Limousine Search',
            'Limousine Search',
            'manage_options',
            $this->pluginName,
            function () {
                echo Helper::safeView('admin.main', [
                    'pluginName' => $this->pluginName,
                ]);
            },
            '' //Icon Link
        );
    }
}
