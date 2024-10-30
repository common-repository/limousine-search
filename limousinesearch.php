<?php
/**
 * @link              https://www.limousinesearch.com
 * @since             2.0.3
 * @package           Limousinesearch
 *
 * @wordpress-plugin
 * Plugin Name:       Limousine Search
 * Plugin URI:        https://www.limousinesearch.com
 * Description:       Easy integration between WP and Limousine Search
 * Version:           2.0.3
 * Author:            Limousine Search
 * Author URI:        https://www.limousinesearch.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       limousinesearch
 * Domain Path:       /languages
 */

use LimousineSearch\Includes;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define('LIMOUSINESEARCH_VERSION', '2.0.3');
define('LIMOUSINESEARCH_NAME', 'limousine-search');
define('LIMOUSINESEARCH_DIR', WP_PLUGIN_DIR . '/limousine-search');

require plugin_dir_path(__FILE__) . '/vendor/autoload.php';

function limousineSearchActivate() {
	Includes\Activate::run();
}

function limousineSearchDeactivate() {
    Includes\Deactivate::run();
}

register_activation_hook(__FILE__, 'limousineSearchActivate');
register_deactivation_hook(__FILE__, 'limousineSearchDeactivate');

function startLimousineSearch()
{
	$plugin = new Includes\LimousineSearch(LIMOUSINESEARCH_VERSION, LIMOUSINESEARCH_NAME);
	$plugin->run();
}

startLimousineSearch();
