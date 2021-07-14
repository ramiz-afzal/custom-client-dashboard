<?php
/**
 * Plugin Name:       Custom Client Dahsboard
 * Plugin URI:        https://kristall.io/
 * Description:       Creates custom user role for clients and provides access protection
 * Version:           1.0.0
 * Requires at least: 5.5
 * Requires PHP:      7.2
 * Author:            Kristall Studios
 * Author URI:        https://kristall.io/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

 
// Direct access protection
defined('ABSPATH') or die();

// composer autoload
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

// plugin activation hook
function ccd_plugin_activation(){
    Inc\Base\Activate::activate();
}
register_activation_hook( __FILE__, 'ccd_plugin_activation' );

// plugin deactivation
function ccd_plugin_deactivation(){
    Inc\Base\Deactivate::deactivate();
}
register_deactivation_hook( __FILE__, 'ccd_plugin_deactivation' );

// plugins defaults
define( 'CCD_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'CCD_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'CCD_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define( 'CCD_PLUGIN_MENU_PAGE', 'custom-client-dashboard-settings' );

function wrrite_to_error_log( $label, $data ){
    ob_start();
    echo "$label :\n";
    var_dump($data);
    $log = ob_get_clean();
    error_log( $log );
}

// load plugin services
if( class_exists('Inc\\Init') ){
    Inc\Init::register_services();
}