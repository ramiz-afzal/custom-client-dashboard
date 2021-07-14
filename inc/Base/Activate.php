<?php 
namespace Inc\Base;

if ( ! defined( 'ABSPATH' ) ) exit;

class Activate
{
    public static function activate()
    {
        // add custom user role
        add_role( 'ccd_client', 'Client', get_role( 'subscriber' )->capabilities );

        flush_rewrite_rules();
    }
}