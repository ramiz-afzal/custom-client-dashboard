<?php 
namespace Inc\Base;

if ( ! defined( 'ABSPATH' ) ) exit;

class SettingsLink
{
    public function register()
    {
        add_filter( 'plugin_action_links_' . CCD_PLUGIN_BASENAME , array( $this, 'settings_link' ) );
    }
    
    public function settings_link( $links )
    {
        $setting_link = '<a href="admin.php?page='.CCD_PLUGIN_MENU_PAGE.'">Settings</a>';
        return  array_merge( array( $setting_link ), $links ); 
    }
}