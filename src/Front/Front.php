<?php

namespace LimousineSearch\Front;

use LimousineSearch\Includes\Api;
use LimousineSearch\Includes\Helper;

class Front
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
		wp_enqueue_style($this->pluginName, Helper::resource('css/front.css'), [], $this->version, 'all');
	}

	public function enqueueScripts(): void
    {
		wp_enqueue_script($this->pluginName, Helper::resource('js/front.js'), ['jquery'], $this->version, false);
	}

    public function addShortcodes(): void
    {
        add_shortcode($this->pluginName . '_reservation', function ($atts = [], $content = null) {
            return Helper::safeView('front.shortcodes.reservation');
        });


        add_shortcode($this->pluginName . '_iframe', function ($atts = [], $content = null) {
            $slug = get_option($this->pluginName . '_company_slug');

            return Helper::safeView('front.shortcodes.iframe', [
                'url' => "https://iframe.limousinesearch.com/$slug",
            ]);
        });

        add_shortcode($this->pluginName . '_iframe_quote', function ($atts = [], $content = null) {
            $slug = get_option($this->pluginName . '_company_slug');

            return Helper::safeView('front.shortcodes.iframe', [
                'url' => "https://iframe.limousinesearch.com/$slug/quote",
            ]);
        });
    }
}
