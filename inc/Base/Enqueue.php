<?php
namespace Inc\Base;

if ( ! defined( 'ABSPATH' ) ) exit;

class Enqueue
{
    public function register()
    {
        // load admin resourse
        if( is_admin() ){
            add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_files' ) );
        }

        // load plugin resources
        add_action( 'wp_enqueue_scripts', array( $this, 'load_resources' ) );
    }
	
    
    public function enqueue_admin_files()
    {
        //plugin files
        wp_enqueue_style( 'ccd-admin-styles', CCD_PLUGIN_URL . 'assets/css/admin-styles.css', array(), '1.0.0' );
        wp_enqueue_script( 'ccd-admin-script', CCD_PLUGIN_URL . 'assets/js/admin-scripts.js', array(), '1.0.0', true );     

        // enqueue media
        if ( ! did_action( 'wp_enqueue_media' ) ) {
            wp_enqueue_media();
        }
    }


    public function load_resources()
    {
        //plugin files
        wp_enqueue_style( 'ccd-styles', CCD_PLUGIN_URL . 'assets/css/main.css', array(), '1.0.0' );
        wp_enqueue_script( 'ccd-script', CCD_PLUGIN_URL . 'assets/js/main.js', array(), '1.0.0', true );

        // $nonce_val = wp_create_nonce('ccd_admin_ajax_check');
        // $admin_js_object = array(
        //     'ajax_url' => admin_url( 'admin-ajax.php' ),
        //     'nonce'    => $nonce_val,
        // );
        // wp_localize_script( 'ccd-script', 'ccd_admin_ajax_obj', $admin_js_object );  
    }
}