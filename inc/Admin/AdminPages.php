<?php 
namespace Inc\Admin;

if ( ! defined( 'ABSPATH' ) ) exit;

class AdminPages
{
    public function register()
    {
        /* Add Admin Page */
        add_action( 'admin_menu', array( $this, 'add_admin_page' ) );

        /* Setting sections for admin page */
        add_action( 'admin_init', array( $this, 'add_admin_settings_section' ) );
            
        /* settings feilds setup */
        add_action( 'admin_init', array( $this, 'add_admin_settings_field' ) );
    }


    public function add_admin_page()
    {
        if( function_exists( 'add_menu_page' ) ){
            
            $page_title         = 'Custom Client Dashboard Settings';
            $menu_title         = 'CCD Setings';
            $capability         = 'manage_options';
            $menu_slug          = CCD_PLUGIN_MENU_PAGE;
            $function           = array( $this, 'load_admin_page_template' );
            $icon_url           = 'dashicons-admin-generic';
            $position           = 99;

            add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
        }
    }


    public function load_admin_page_template()
    {
        require_once ( CCD_PLUGIN_PATH . 'templates/admin/admin-management-page.php' );
    }

    
    public function add_admin_settings_section()
    {
        $id             = 'ccd_setting_section';
        $title          = 'Custom Client Dahsboard Settings';
        $callback       = '';
        $page           = CCD_PLUGIN_MENU_PAGE;
        add_settings_section( $id, $title, $callback, $page );   
    }


    public function add_admin_settings_field()
    {
        $settings_fields = AdminFields::get_settings_fields();

        foreach($settings_fields as $field){

            $id                 = $field['id'];
            $title              = $field['title'];
            $callback           = array( $this, 'setting_fields_render_callback' );
            $page               = CCD_PLUGIN_MENU_PAGE;
            $section            = 'ccd_setting_section';
            $args               = $field;
            add_settings_field( $id, $title, $callback, $page, $section, $args );
            register_setting( CCD_PLUGIN_MENU_PAGE, $field['id'] );
        }
    }


    public function setting_fields_render_callback( $arguments )
    {
        AdminFields::render_field( $arguments );
    }

}