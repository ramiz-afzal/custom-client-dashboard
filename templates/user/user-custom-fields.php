<?php

    $client_file_array          = array();
    $client_file_array['png']   = array();
    $client_file_array['eps']   = array();
    $client_file_array['font']   = array();

    $client_file_ids          = array();
    $client_file_ids['png']   = explode( ',', get_user_meta( $user->ID, 'ccd_client_png_files', true ));
    $client_file_ids['eps']   = explode( ',', get_user_meta( $user->ID, 'ccd_client_eps_files', true ));
    $client_file_ids['font']  = explode( ',', get_user_meta( $user->ID, 'ccd_client_font_files', true ));

    foreach( $client_file_ids as $file_type => $ids_array ){

        foreach( $ids_array as $id ){
            
            $file_path = get_attached_file( $id );
            $file_post = get_post( $id );
            $file_meta = get_post_meta( $id );

            // var_dump( $file_path );

            if( isset($file_path) && isset($file_post) && isset($file_meta) ){

                $file_attr = array( 
                    'id' => $id, 
                    'filename' => $file_post->post_name, 
                    'path' => $file_path,
                    'icon' => wp_get_attachment_image_src($id)[0],
                );
                $attached_file = array_merge( $file_attr, $file_meta );
                array_push( $client_file_array[$file_type], $attached_file );

            }

        }

    }
?>

<h3>Client Information</h3>
<table class="form-table">
    <tr>
        <th>
            <label for="ccd_client_google_web_console_id">Google Web Console ID</label>
        </th>
        <td>
            <input type="text" id="ccd_client_google_web_console_id" name="ccd_client_google_web_console_id" value="<?php echo get_user_meta( $user->ID, 'ccd_client_google_web_console_id', true );?>">
        </td>
    </tr>
    <tr>
        <th>
            <label for="ccd_client_google_web_console_id">.PNG Files</label>
        </th>
        <td>
            <div id="ccd_client_png_files">
            <div class="cdd_client_selected_files">
                <?php
                if( count($client_file_array['png']) > 0 ){
                    foreach( $client_file_array['png'] as $file ){
                        ?>
                            <a href="<?php echo $file['path']; ?>" class="cdd_client_file">
                                <button class="cdd_client_file_remove" data-attachment-id="<?php echo $file['id']; ?>">X</button>
                                <img class="cdd_client_file_icon" src="<?php echo $file['icon']; ?>">
                                <p class="cdd_client_label"><?php echo $file['filename']; ?></p>
                            </a>
                        <?php
                    }
                }else{
                    ?>
                        <p>No files found.</p>
                    <?php
                }
                ?>
                </div>
                <input type="hidden" class="ccd_selected_files" name="ccd_client_png_files" value="<?php echo get_user_meta( $user->ID, 'ccd_client_png_files', true );?>">
                <a href="#" class="button ccd_upload_client_content" data-user-id="<?php echo $user->ID; ?>" data-content-type="png" data-field-id="ccd_client_png_files">Add File</a>
            </div>
        </td>
    </tr>
    <tr>
        <th>
            <label for="ccd_client_google_web_console_id">Vector (EPS) Files</label>
        </th>
        <td>
            <div id="ccd_client_eps_files">
                <div class="cdd_client_selected_files">
                <?php
                if( count($client_file_array['eps']) > 0 ){
                    foreach( $client_file_array['eps'] as $file ){
                        ?>
                            <a href="<?php echo $file['path']; ?>" class="cdd_client_file">
                                <button class="cdd_client_file_remove" data-attachment-id="<?php echo $file['id']; ?>">X</button>
                                <img class="cdd_client_file_icon" src="<?php echo $file['icon']; ?>">
                                <p class="cdd_client_label"><?php echo $file['filename']; ?></p>
                            </a>
                        <?php
                    }
                }else{
                    ?>
                        <p>No files found.</p>
                    <?php
                }
                ?>
                </div>
                <input type="hidden" class="ccd_selected_files" name="ccd_client_eps_files" value="<?php echo get_user_meta( $user->ID, 'ccd_client_eps_files', true );?>">
                <a href="#" class="button ccd_upload_client_content" data-user-id="<?php echo $user->ID; ?>" data-content-type="eps" data-field-id="ccd_client_eps_files">Add File</a>
            </div>
        </td>
    </tr>
    <tr>
        <th>
            <label for="ccd_client_google_web_console_id">Font FIles</label>
        </th>
        <td>
            <div id="ccd_client_font_files">
                <div class="cdd_client_selected_files">
                <?php
                if( count($client_file_array['font']) > 0 ){
                    foreach( $client_file_array['font'] as $file ){
                        ?>
                            <a href="<?php echo $file['path']; ?>" class="cdd_client_file">
                                <button class="cdd_client_file_remove" data-attachment-id="<?php echo $file['id']; ?>">X</button>
                                <img class="cdd_client_file_icon" src="<?php echo $file['icon']; ?>">
                                <p class="cdd_client_label"><?php echo $file['filename']; ?></p>
                            </a>
                        <?php
                    }
                }else{
                    ?>
                        <p>No files found.</p>
                    <?php
                }
                ?>
                </div>
                <input type="hidden" class="ccd_selected_files" name="ccd_client_font_files" value="<?php echo get_user_meta( $user->ID, 'ccd_client_font_files', true );?>">
                <a href="#" class="button ccd_upload_client_content" data-user-id="<?php echo $user->ID; ?>" data-content-type="font" data-field-id="ccd_client_font_files">Add File</a>
            </div>
        </td>
    </tr>
</table>