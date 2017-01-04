<?php

/**
 * The processing of feeds pull and pushed
 *
 * This plugin looks after the pull and push of the XML feeds of the ttcms to the product platform
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Ttcms_Content_Feeds
 *
 * @wordpress-plugin
 * Plugin Name:       [TT - DEVELOPMENT] Content Feeds
 * Plugin URI:        http://olemediagroup.com
 * Description:       ImportXML feeds from ttcms
 * Version:           1.0.1
 * Author:            TT
 * Author URI:        http://olemediagroup.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ttcms_content_feeds
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The cron functions
 */


/**
 * The code that runs during plugin activation.
 */
function activate_ttcms_content() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ttcms-pf-activator.php';
	Ttcms_Content_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_ttcms_content() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ttcms-pf-deactivator.php';
	Ttcms_Content_Deactivator::deactivate();
}

//register_activation_hook( __FILE__, 'activate_plugin_name' );

register_activation_hook( __FILE__, 'my_ttcms_content' ); function my_ttcms_content() {
    file_put_contents(__DIR__.'/my_loggg.txt', ob_get_contents());
}
register_deactivation_hook( __FILE__, 'deactivate_ttcms_content' );

/**
 * The core plugin class that is used to define internationalization,
 * dashboard-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ttcms-pf.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ttcms_content() {

	$plugin = new Ttcms_Content();
	$plugin->run();

}
run_ttcms_content();

