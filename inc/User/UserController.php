<?php 
namespace Inc\User;

if ( ! defined( 'ABSPATH' ) ) exit;

class UserController
{
    public function register()
    {
        // add custom file types support
        add_filter( 'upload_mimes', array( $this, 'add_custom_file_types_supprot' ) );

        // add svg support
        add_filter( 'wp_prepare_attachment_for_js', array( $this, 'add_svg_media_thumbnails' ), 10, 3 );

        // filter wordpress filetype security check
        add_filter('wp_check_filetype_and_ext',  array( $this, 'wp_check_filetype_and_ext' ) , 5, 5);

        // Add Custom user fields to ccd_client user role
        add_action( 'show_user_profile', array( $this, 'add_custom_user_fields' ) );
        add_action( 'edit_user_profile', array( $this, 'add_custom_user_fields' ) );

        // handle custom user fields update / form post
        add_action( 'personal_options_update', array( $this, 'update_custom_user_fields' ) );
        add_action( 'edit_user_profile_update', array( $this, 'update_custom_user_fields' ) );
    }

    public function add_custom_user_fields( $user )
    {
        if( in_array( 'ccd_client', $user->roles ) ){
            require_once ( CCD_PLUGIN_PATH . 'templates/user/user-custom-fields.php' );
        }
    }

    public function add_custom_file_types_supprot( $types )
    {
        $mimes['svg']       =  array( 'image/svg', 'image/svg+xml' );
        $mimes['ai']        =  array( 'image/vnd.adobe.illustrator', 'application/postscript' );
        $mimes['eps']       =  array( 'application/postscript', 'image/x-eps' );
        $mimes['ttf']       =  array( 'application/x-font-ttf', 'application/x-font-truetype' );
        $mimes['otf']       =  array( 'application/x-font-opentype', 'font/opentype' );
        $mimes['woff']      =  'application/font-woff';
        $mimes['woff2']     =  'application/font-woff2';
        $mimes['eot']       =  'application/vnd.ms-fontobject';
        $mimes['sfnt']      =  'application/font-sfnt';
        
        return array_merge( $types, $mimes );
    }

    public function add_svg_media_thumbnails( $response, $attachment, $meta )
    {
        if( $response['type'] === 'image' && $response['subtype'] === 'svg+xml' && class_exists('SimpleXMLElement') ){
            try {
                $path = get_attached_file($attachment->ID);
                if(@file_exists($path))
                {
                    $svg    = new SimpleXMLElement(@file_get_contents($path));
                    $src    = $response['url'];
                    $width  = (int) $svg['width'];
                    $height = (int) $svg['height'];

                    //media gallery
                    $response['image'] = compact( 'src', 'width', 'height' );
                    $response['thumb'] = compact( 'src', 'width', 'height' );

                    //media single
                    $response['sizes']['full'] = array(
                        'height'        => $height,
                        'width'         => $width,
                        'url'           => $src,
                        'orientation'   => $height > $width ? 'portrait' : 'landscape',
                    );
                }
            }
            catch(Exception $e){

                if( defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG == true ){
                    error_log( $e );
                }

            }
        }

        return $response;
    }


    public function wp_check_filetype_and_ext( $filetype_and_ext, $file, $filename ) 
    {
        
        if(!$filetype_and_ext['ext'] || !$filetype_and_ext['type'] || !$filetype_and_ext['proper_filename']) {
            $extension = pathinfo($filename)['extension'];
            $mime_type = mime_content_type($file);
            $allowed_ext = array(
                'svg'   => array( 'image/svg', 'image/svg+xml' ),
                'eps'   => array( 'application/postscript', 'image/x-eps' ),
                'ai'    => array( 'image/vnd.adobe.illustrator', 'application/postscript' ),
                'ttf'   => array( 'application/x-font-ttf', 'application/x-font-truetype' ),
                'otf'   => array( 'application/x-font-opentype', 'font/opentype' ),
                'woff'  => array( 'application/font-woff' ),
                'woff2' => array( 'application/font-woff2' ),
                'eot'   => array( 'application/vnd.ms-fontobject' ),
                'sfnt'  => array( 'application/font-sfnt' ),
            );
            if($allowed_ext[$extension]) {
                if(in_array($mime_type, $allowed_ext[$extension])) {
                    $filetype_and_ext['ext'] = $extension;
                    $filetype_and_ext['type'] = $mime_type;
                    $filetype_and_ext['proper_filename'] = $filename;
                }
            }
        }
        return $filetype_and_ext;
    }


    public function update_custom_user_fields( $user_id )
    {
        $user = get_user_by('id', $user_id );
        if( in_array( 'ccd_client', $user->roles ) ){
            
            if( isset($_POST['ccd_client_google_web_console_id']) ){
                update_user_meta( $user_id, 'ccd_client_google_web_console_id', sanitize_text_field($_POST['ccd_client_google_web_console_id']) );
            }
            
            if( isset($_POST['ccd_client_png_files']) ){
                update_user_meta( $user_id, 'ccd_client_png_files', sanitize_text_field($_POST['ccd_client_png_files']) );
            }
            
            if( isset($_POST['ccd_client_eps_files']) ){
                update_user_meta( $user_id, 'ccd_client_eps_files', sanitize_text_field($_POST['ccd_client_eps_files']) );
            }
            
            if( isset($_POST['ccd_client_font_files']) ){
                update_user_meta( $user_id, 'ccd_client_font_files', sanitize_text_field($_POST['ccd_client_font_files']) );
            }

        }
    }

}