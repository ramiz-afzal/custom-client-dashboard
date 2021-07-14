<?php 
namespace Inc\Base;

if ( ! defined( 'ABSPATH' ) ) exit;

class Deactivate
{
    public static function deactivate()
    {
        // remove custom user role
        if( wp_roles()->is_role( 'ccd_client' ) ){
            remove_role( 'ccd_client' );
        }

        flush_rewrite_rules();
    }
}