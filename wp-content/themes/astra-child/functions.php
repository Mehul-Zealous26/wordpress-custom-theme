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
    $categories = $_POST['categories'] ?? [];
    $subcategories = $_POST['subcategories'] ?? [];
    $colors = $_POST['colors'] ?? [];
    $sizes = $_POST['sizes'] ?? [];
    $brands = $_POST['brands'] ?? [];
    $priceRanges = $_POST['priceRange'] ?? [];
    $stockStatus = $_POST['stockStatus'] ?? [];

    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'tax_query' => array(),
        'meta_query' => array(),
    );

    $active_taxonomies = array_filter([$categories, $subcategories, $colors, $sizes, $brands]);
    if (count($active_taxonomies) > 1) {
        $args['tax_query']['relation'] = 'AND';
    }

    if (!empty($categories)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'product_cat',
            'field' => 'slug',
            'terms' => $categories,
        );
    }

    if (!empty($subcategories)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'product_cat',
            'field' => 'slug',
            'terms' => $subcategories,
        );
    }

    if (!empty($colors)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'pa_color',
            'field' => 'slug',
            'terms' => $colors,
        );
    }

    if (!empty($sizes)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'pa_size',
            'field' => 'slug',
            'terms' => $sizes,
        );
    }

    if (!empty($brands)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'product_brand',
            'field' => 'slug',
            'terms' => $brands,
        );
    }

    if (!empty($priceRanges)) {
        $range = explode('-', $priceRanges[0]);
        $args['meta_query'][] = array(
            'key' => '_price',
            'value' => array($range[0], $range[1]),
            'compare' => 'BETWEEN',
            'type' => 'NUMERIC'
        );
    }

    if (!empty($stockStatus)) {
    $args['meta_query'][] = array(
        'key' => '_stock_status',
        'value' => $stockStatus,
        'compare' => 'IN'
    );
}

    var_dump($stockStatus);
    $query = new WP_Query(($args));
    //var_dump($query);
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
        $categories = get_terms(['taxonomy' => 'product_cat', 'parent' => 0]);
        $subcategories = [];
        $parent_category = get_term_by('slug', 'clothes', 'product_cat');
        if ($parent_category) {
            $parent_id = $parent_category->term_id;
            $subcategories = get_terms([
                'taxonomy' => 'product_cat',
                'parent' => $parent_id
            ]);
        }
        $color = get_terms(array('taxonomy' => 'pa_color', 'hide_empty' => false));
        $size = get_terms(array('taxonomy' => 'pa_size', 'hide_empty' => false));
        $brand = get_terms(array('taxonomy' => 'product_brand', 'hide_empty' => false));

        echo '<div style="margin-bottom: 5px;">';
        echo '<label><b>Filter by Category: </b></label><br>';
        if (!empty($categories)) {
            foreach ($categories as $category) {
        ?>
                <label>
                    <input type="checkbox" class="category-filter" value="<?php echo $category->slug; ?>"><?php echo '&nbsp' . $category->name . "<br>"; ?>
                </label>
        <?php
            }
        }
        echo '</div>';

        ?>
        <div id="subcategory-wrapper" style="display:none;">
            <label><b>Filter by SubCategory: </b></label><br>
            <?php
            if (!empty($subcategories)) {
                foreach ($subcategories as $subcategory) {
            ?>
                    <label>
                        <input type="checkbox"
                            class="subcategory-filter"
                            value="<?php echo $subcategory->slug; ?>">
                        <?php echo $subcategory->name ?>
                    </label>
                    <br>
            <?php
                }
            }
            ?>
        </div>
        <?php

        echo '<div id="color-wrapper" style="margin-bottom: 5px;">';
        echo '<label><b>Filter by Color:</b></label><br>';
        if (!empty($color)) {
            foreach ($color as $colors) {
        ?>
                <label>
                    <input type="checkbox" class="color-filter" value="<?php echo $colors->slug; ?>"><?php echo '&nbsp' . $colors->name . "<br>"; ?>
                </label>
            <?php
            }
        }
        echo '</div>';

        echo '<div id="size-wrapper" style="margin-bottom: 5px;">';
        echo '<label for="size-filter"><b>Filter by Size: </b></label><br>';
        if (!empty($size)) {
            foreach ($size as $sizes) {
            ?>
                <label>
                    <input type="checkbox" class="size-filter" value="<?php echo $sizes->slug; ?>"><?php echo '&nbsp' . $sizes->name . "<br>"; ?>
                </label>
            <?php
            }
        }
        echo '</div>';

        echo '<div id="brand-wrapper" style="margin-bottom: 5px;">';
        echo '<label for="brand-filter"><b>Filter by Brand: </b></label><br>';
        if (!empty($brand)) {
            foreach ($brand as $brands) {
            ?>
                <label>
                    <input type="checkbox" class="brand-filter" value="<?php echo $brands->slug; ?>"><?php echo '&nbsp' . $brands->name . "<br>"; ?>
                </label>
        <?php
            }
        }
        echo '</div>';

        echo '<b>Filter by Price: </b><br>';
        ?>
        <input type="checkbox" class="price-filter" value="0-500"> ₹0 - ₹500 <br>
        <input type="checkbox" class="price-filter" value="500-1000"> ₹500 - ₹1000 <br>
        <input type="checkbox" class="price-filter" value="1000-100000"> ₹1000 - ₹100000<br>
        <?php

        echo '<b>Stock Status</b><br>';
        echo '<label><input type="checkbox" class="stock-filter" value="instock"> In Stock</label><br>';
        echo '<label><input type="checkbox" class="stock-filter" value="outofstock"> Out Of Stock</label><br>';
    }
}

add_action('woocommerce_before_shop_loop', 'ajax_container_open', 12);
function ajax_container_open()
{
    if (is_shop()) {
        echo '<div id="products-container" class="products columns-4">';
    }
}

add_action('woocommerce_after_shop_loop', 'ajax_container_close', 5);
function ajax_container_close()
{
    if (is_shop()) {
        echo '</div>';
    }
}
