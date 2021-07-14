<?php 
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<div class="wrap">
    <form method="post" action="options.php">
        <?php settings_fields( CCD_PLUGIN_MENU_PAGE );?>
        <?php do_settings_sections( CCD_PLUGIN_MENU_PAGE );?>
        <?php submit_button();?>
    </form>
</div>