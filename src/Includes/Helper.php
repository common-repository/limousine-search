<?php

namespace LimousineSearch\Includes;

class Helper
{
	public static function resource(string $file): string
    {
        return str_replace(
            'src/Includes/',
            'resources/',
            plugin_dir_url(__FILE__) . trim($file, '/')
        );
    }

    public static function view(string $file): string
    {
        return vsprintf('%s/resources/views/%s.php', [
            LIMOUSINESEARCH_DIR,
            str_replace('.', '/', $file),
        ]);
    }

    public static function safeView(string $file, array $with = []): string
    {
        ob_start();

        foreach ($with as $key => $value) {
            ${$key} = $value;
        }

        include self::view($file);

        return ob_get_clean();
    }
}
