<?php

function my_child_theme_css()
{

    wp_enqueue_style(
        'parent-style',
        get_template_directory_uri() . '/style.css'
    );

    wp_enqueue_style(
        'child-style',
        get_stylesheet_uri(),
        array('parent-style')
    );
}

add_action('wp_enqueue_scripts', 'my_child_theme_css');

/**
 * Summary of create_movie_post_type
 * @return void
 */
function create_movie_post_type()
{
    register_post_type(
        'movies',
        array(
            'labels' => array(
                'name' => 'Movies',
                'singular_name' => 'Movie'
            ),
            'public' => true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-video-alt2',
            'supports' => array('title', 'editor', 'thumbnail')
        )

    );
}

add_action('init', 'create_movie_post_type');

/**
 * Summary of create_course_post_type
 * @return void
 */
function create_course_post_type()
{

    register_post_type(
        'courses',

        array(

            'labels' => array(
                'name' => 'Courses',
                'singular_name' => 'Course'
            ),

            'public' => true,

            'has_archive' => true,

            'menu_icon' => 'dashicons-welcome-learn-more',

            'supports' => array('title', 'editor', 'thumbnail')

        )

    );
}
add_action('init', 'create_course_post_type');

// function create_developer_post_type() {
//     register_post_type('developers',
//         array(
//             'labels' => array(
//                 'name' => 'Developers',
//                 'singular_name' => 'Developer'
//             ),

//             'public'=> true,

//             'has_archive' => true,

//             'menu_icon' => 'dashicons-admin-users',

//             'supports'=> array('title', 'editor', 'thumbnail')
//         )
//     );
// }

// add_action('init', 'create_developer_post_type');

/**
 * Summary of custom_theme_styles
 * @return void
 */
function custom_theme_styles()
{
    wp_enqueue_style(
        'testimonials-style',
        get_stylesheet_directory_uri() . '/assets/css/testimonials.css'
    );
}

add_action('wp_enqueue_scripts', 'custom_theme_styles');

/**
 * Summary of custom_woocommerce_styles
 * @return void
 */
function custom_woocommerce_styles()
{

    wp_enqueue_style(
        'woocommerce-style',
        get_stylesheet_directory_uri() . '/assets/css/woocommerce.css'
    );
}

add_action('wp_enqueue_scripts', 'custom_woocommerce_styles');

/**
 * Summary of custom_product_image_field
 * @return void
 */
function custom_product_image_field()
{
    global $product;
    if ($product->get_id() == 236) {
?>
        <p>
            <label>Upload Your Image</label><br>
            <input type="file" name="custom_product_image">
        </p>
<?php
    }
}

add_action('woocommerce_before_add_to_cart_button', 'custom_product_image_field');

/**
 * Summary of custom_save_image_to_cart
 * @param mixed $cart_item_data
 * @param mixed $product_id
 */
function custom_save_image_to_cart($cart_item_data, $product_id)
{

    if ($product_id == 236 && !empty($_FILES['custom_product_image']['name'])) {
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');
        require_once(ABSPATH . 'wp-admin/includes/image.php');

        $attachment_id = media_handle_upload('custom_product_image', 0);

        if (!is_wp_error($attachment_id)) {
            $cart_item_data['uploaded_image'] = wp_get_attachment_url($attachment_id);
        }
    }

    return $cart_item_data;
}

add_filter('woocommerce_add_cart_item_data', 'custom_save_image_to_cart', 10, 2);

/**
 * Summary of custom_display_image_in_cart
 * @param mixed $item_data
 * @param mixed $cart_item
 */
function custom_display_image_in_cart($item_data, $cart_item)
{
    if (!empty($cart_item['uploaded_image'])) {
        $item_data[] = array(
            'key'   => 'Uploaded Image',
            'value' => '<a href="' .
                esc_url($cart_item['uploaded_image']) .
                '" target="_blank">View Image</a>'
        );
    }
    return $item_data;
}
add_filter('woocommerce_get_item_data', 'custom_display_image_in_cart', 10, 2);

/**
 * Summary of custom_save_image_to_order
 * @param mixed $item
 * @param mixed $values
 * @return void
 */
function custom_save_image_to_order($item, $values)
{
    if (!empty($values['uploaded_image'])) {
        $item->add_meta_data(
            'Uploaded Image',
            $values['uploaded_image']
        );
    }
}
add_action('woocommerce_checkout_create_order_line_item', 'custom_save_image_to_order', 10, 2);

/**
 * Summary of show_product_features
 * @return void
 */
function show_product_features()
{

    if (have_rows('product_features')) {
        echo '<h5>Product Features</h5>';
        echo '<ul>';

        while (have_rows('product_features')) {
            the_row();
            echo '<li>' . get_sub_field('feature_name') . '</li>';
        }
        echo '</ul>';
    }
}

add_action(
    'woocommerce_single_product_summary',
    'show_product_features',
    25
);

/**
 * Summary of show_product_spec_name_value
 * @return void
 */
function show_product_spec_name_value()
{
    if (have_rows('product_features')) {
        echo '<h6>Product features</h6>';
        echo '<ul>';
        while (have_rows('product_specifications')) {
            the_row();
            echo '<li>' . get_sub_field('spec_name') . ': ' . get_sub_field('spec_value')  . '</li>';
        }
        echo '</ul>';
    }
}

add_action('woocommerce_single_product_summary', 'show_product_spec_name_value', 25);

/**
 * Summary of show_product_gallery
 * @return void
 */
function show_product_gallery()
{
    $gallery = get_field('product_gallery');
    echo '<h4>Gallery</h4>';
    if ($gallery) {
    
        echo '<div class="product-gallery">';

        foreach ($gallery as $image) {
            
            echo '<img src="' . $image['url'] . '" alt="' . $image['alt'] . '">';
        }
        echo '</div>';
    }
}

add_action('woocommerce_single_product_summary', 'show_product_gallery', 25);

if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title'=> 'Theme Settings',
        'menu_title'=> 'Theme Settings',
        'menu_slug'=> 'theme-settings',
        'capability'=> 'edit_posts',
        'redirect' => 'false'
    ));
}
