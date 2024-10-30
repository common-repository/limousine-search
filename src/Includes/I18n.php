<?php

namespace LimousineSearch\Includes;

class I18n
{
    private string $pluginName;

    public function __construct(string $pluginName)
    {
        $this->pluginName = $pluginName;
    }

	public function load(): void
    {
        $directory = dirname(dirname(dirname(__FILE__))) . '/languages/';

		load_plugin_textdomain($this->pluginName, false, $directory);
	}
}
