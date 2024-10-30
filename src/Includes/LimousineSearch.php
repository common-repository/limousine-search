<?php

namespace LimousineSearch\Includes;

use LimousineSearch\Admin\Admin;
use LimousineSearch\Front\Front;

class LimousineSearch
{
	protected Loader $loader;

	protected string $pluginName;

	protected string $version;

	public function __construct(string $version, string $pluginName)
    {
		$this->version = $version;
		$this->pluginName = $pluginName;
        $this->loader = new Loader();

		$this->setLocale();
		$this->defineAdminHooks();
		$this->defineFrontHooks();
	}

	private function setLocale(): void
    {
		$i18n = new I18n($this->getPluginName());

		$this->loader->addAction('plugins_loaded', $i18n, 'load');
	}

	private function defineAdminHooks(): void
    {
		$admin = new Admin($this->getPluginName(), $this->getVersion());

		$this->loader->addAction('admin_enqueue_scripts', $admin, 'enqueueStyles');
		$this->loader->addAction('admin_enqueue_scripts', $admin, 'enqueueScripts');
		$this->loader->addAction('admin_menu', $admin, 'registerMenu');
        $this->loader->addAction('admin_init', $admin, 'registerSettings');
	}

	private function defineFrontHooks(): void
    {
		$front = new Front($this->getPluginName(), $this->getVersion());
        $front->addShortcodes();

		$this->loader->addAction('wp_enqueue_scripts', $front, 'enqueueStyles');
		$this->loader->addAction('wp_enqueue_scripts', $front, 'enqueueScripts');
	}

	public function run(): void
    {
		$this->loader->run();
	}

	public function getPluginName(): string
    {
		return $this->pluginName;
	}

	public function getLoader(): Loader
    {
		return $this->loader;
	}

	public function getVersion(): string
    {
		return $this->version;
	}

}
