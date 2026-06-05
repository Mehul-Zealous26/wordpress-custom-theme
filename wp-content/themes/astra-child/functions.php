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
        'page_title' => 'Theme Settings',
        'menu_title' => 'Theme Settings',
        'menu_slug' => 'theme-settings',
        'capability' => 'edit_posts',
        'redirect' => 'false'
    ));
}

add_action('wp_ajax_filter_products', 'filter_products_callback');
add_action('wp_ajax_nopriv_filter_products', 'filter_products_callback');

function filter_products_callback()
{
    $category = isset($_POST['category']) ? $_POST['category'] : '';
    $color = isset($_POST['color']) ? $_POST['color'] : '';
    $size = isset($_POST['size']) ? $_POST['size'] : '';
    $brand = isset($_POST['brand']) ? $_POST['brand'] : '';
    $min_price = isset($_POST['minPrice']) ? $_POST['minPrice'] : 0;
    $max_price = isset($_POST['maxPrice']) ? $_POST['maxPrice'] : 100000;

    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'tax_query' => array(),
        'meta_query' => array(),
    );

    $active_taxonomies = [$category, $color, $size, $brand];
    if (count($active_taxonomies) > 1) {
        $args['tax_query']['relation'] = 'AND';
    }

    if (!empty($category)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'product_cat',
            'field' => 'slug',
            'terms' => $category,
        );
    }

    if (!empty($color)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'pa_color',
            'field' => 'slug',
            'terms' => $color,
        );
    }

    if (!empty($size)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'pa_size',
            'field' => 'slug',
            'terms' => $size,
        );
    }

    if (!empty($brand)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'product_brand',
            'field' => 'slug',
            'terms' => $brand,
        );
    }

    if (isset($min_price) || isset($max_price)) {
        $args['meta_query'][] = array(
        'key' => '_price',
        'value' => array($min_price, $max_price),
        'compare' => 'BETWEEN',
        'type' => 'NUMERIC',
    );
    }

    $query = new WP_Query(($args));

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            wc_get_template_part('content', 'product');
        }
    } else {
        echo '<p>No Products Found</p>';
    }

    wp_reset_postdata();
    wp_die();
}

add_action('wp_enqueue_scripts', 'custom_filter_scripts');
function custom_filter_scripts()
{
    wp_enqueue_script(
        'product-filter',
        get_stylesheet_directory_uri() . '/assets/js/script.js',
        array('jquery'), // tell to load first jquery
        null,
        true
    );

    wp_localize_script(
        'product-filter',
        'filter_ajax',
        array(
            'ajax_url' => admin_url('admin-ajax.php')
        )
    );
}

add_action('woocommerce_before_shop_loop', 'filter_dropdown', 5); //hook is load filter Dropdown before Product loop
function filter_dropdown()
{
    if (is_shop()) {
        $categories = get_terms(array('taxonomy' => 'product_cat'));
        $color = get_terms(array('taxonomy' => 'pa_color'));
        $size = get_terms(array('taxonomy' => 'pa_size'));
        $brand = get_terms(array('taxonomy' => 'product_brand'));

        echo '<div style="margin-bottom: 30px;">';
        echo '<label for="category-filter">Filter by Category: </label>';
        echo '<select id="category-filter">';
        echo '<option value="">All Products</option>';
        if (!empty($categories)) {
            foreach ($categories as $category) {
                echo '<option value = "' . $category->slug . '">' . $category->name . '</option>';
            }
        }
        echo '</select>';
        echo '</div>';

        echo '<div style="margin-bottom: 30px;">';
        echo '<label for="color-filter">Filter by color: </label>';
        echo '<select id="color-filter">';
        echo '<option value="">All Colors</option>';
        if (!empty($color)) {
            foreach ($color as $colors) {
                echo '<option value = "' . $colors->slug . '">' . $colors->name . '</option>';
            }
        }
        echo '</select>';
        echo '</div>';

        echo '<div style="margin-bottom: 30px;">';
        echo '<label for="size-filter">Filter by size: </label>';
        echo '<select id="size-filter">';
        echo '<option value="">All Sizes</option>';
        if (!empty($size)) {
            foreach ($size as $sizes) {
                echo '<option value = "' . $sizes->slug . '">' . $sizes->name . '</option>';
            }
        }
        echo '</select>';
        echo '</div>';

        echo '<div style="margin-bottom: 30px;">';
        echo '<label for="brand-filter">Filter by Brand: </label>';
        echo '<select id="brand-filter">';
        echo '<option value="">All Brands</option>';
        if (!empty($brand)) {
            foreach ($brand as $brands) {
                echo '<option value = "' . $brands->slug . '">' . $brands->name . '</option>';
            }
        }
        echo '</select>';
        echo '</div>';

        echo '<div class="price-filter-box" style="margin-bottom: 30px; display: flex; align-items: flex-end; gap: 10px;">';
        echo '<div>';
        echo '<label for="min-price" style="display:block;">Min Price ($):</label>';
        echo '  <input type="number" id="min-price" value="0" min="0" style="width: 80px; padding: 5px;">';
        echo '</div>';
        echo '<div>';
        echo '<label for="max-price" style="display:block;">Max Price ($):</label>';
        echo '      <input type="number" id="max-price" value="1000" min="0" style="width: 80px; padding: 5px;">';
        echo '</div>';
        echo '  <button type="button" id="price-filter" style="padding: 6px 12px; background: #000; color: #fff; border: none; cursor: pointer;">Filter Price</button>';
        echo '</div>';
    }
}

add_action('woocommerce_before_shop_loop', 'ajax_container_open', 12);
function ajax_container_open()
{
    if (is_shop()) {
        echo '<div id="products-container" class="products columns-5 ">';
    }
}

add_action('woocommerce_after_shop_loop', 'ajax_container_close', 5);
function ajax_container_close()
{
    if (is_shop()) {
        echo '</div>';
    }
}
