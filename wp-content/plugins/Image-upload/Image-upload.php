<?php

/** 
 * Plugin name: Image-upload
 * Description: A simple plugin that uplod your images.
 * Version: 1.0
 * Author: zealous team 
 */

add_action("admin_menu", "create_plugin_menu");

function create_plugin_menu()
{
    add_menu_page(
        'My Plugin Page',
        'Image Upload',
        'manage_options',
        'image-upload',
        'my_plugin_page_callback',
    );
}

function my_plugin_page_callback()
{
?>
    <h2 style="font-size: 20px;">Image Upload </h2>
    <form method="post" enctype="multipart/form-data">
        <div>
            <span style="font-size: large;">Image</span> : <input type="file" name="my_file" style="margin-bottom:10px;"><br>
            <button type="submit" name="upload_btn">Upload</button>
        </div>
    </form>
<?php

    if (isset($_POST['upload_btn'])) {
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        $uploaded_file = ($_FILES['my_file']);
        $errors = array();
        if (empty($uploaded_file['name'])) {
            $errors[] = 'Please Select a file to upload';
        } else {
            $file_verify = wp_check_filetype_and_ext($uploaded_file['tmp_name'], $uploaded_file['name']);
            $allowed_types = array('image/jpeg', 'image/webp', 'image/png');

            if (!in_array($file_verify['type'], $allowed_types)) {
                $errors[] = 'Invalid Format, only JPG, PNG, WEBP are allowed';
            }

            $max_size = 2 * 1024 * 1024;
            if ($uploaded_file['size'] > $max_size) {
                $errors[] = 'The file is too large. Maximum size allowed is 2MB.';
            }

            if (empty($errors)) {
                $move_file = wp_handle_upload($uploaded_file, array('test_form' => false));
                if (isset($move_file['error'])) {
                    echo '<h3 style="color:red;">Upload Failed: ' .($move_file['error']) . '</h3>';
                } elseif (isset($move_file['url'])) {
                    echo "<h3>Upload Successful</h3>";
                    echo '<img src="' . ($move_file['url']) . '" width="300">';
                }
            } else {
                foreach ($errors as $error) {
                    echo '<h3 style="color:red;">Error: '.($error) . '</h3>';
                }
            }
        }
    }
}
?>