<?php

/**
 * Section: Mega Menu - Products
 * Dynamically loads Product Families and their assigned Categories (from ACF)
 */

if (!function_exists('get_field'))
    return; // Ensure ACF is active

// Fetch all product families (taxonomy or custom ACF group)
$families = get_terms([
    'taxonomy' => 'product_brand', // change if you use product_brand or another taxonomy
    'hide_empty' => false,
]);

if (!$families || is_wp_error($families)) {
    echo '<p>No product families found.</p>';
    return;
}
?>

<div class="mega-menu-main">
    <div class="mega-menu-box product-menu">
        <div class="mega-menu-left">
            <div class="m-menu-back">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/menua-arrow-back.svg"
                    alt="Back Arrow"> Products
            </div>
            <?php if (have_rows('product_mega_menu', 'option')) { ?>
                <?php while (have_rows('product_mega_menu', 'option')):
                    the_row(); ?>
                    <div class="mega-menu-top">
                        <div>
                            <?php
                            $product_range_title = get_sub_field('product_range_title');
                            $product_range_description = get_sub_field('product_range_description');
                            // $view_all_link = get_sub_field('view_all_link');
                            ?>

                            <?php if ($product_range_title): ?>
                                <h5><?php echo esc_html($product_range_title); ?></h5>
                            <?php endif; ?>

                            <?php if ($product_range_description): ?>
                                <p><?php echo esc_html($product_range_description); ?></p>
                            <?php endif; ?>
                        </div>

                        <?php
                        $view_all_link = get_sub_field('view_all_link'); // type = link
                        if ($view_all_link):
                            $link_url = $view_all_link['url'];
                            $link_target = $view_all_link['target'] ? $view_all_link['target'] : '_self';
                            ?>
                            <a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>"
                                class="top-link-btn">
                                View All
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/double-right-arrow-red.svg"
                                    alt="Button Arrow">
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            <?php } ?>

            <div class="mega-menu-link-row">

                <?php
                // Display WordPress menus using slugs
                $menus = [
                    ['slug' => 'protect', 'name' => 'Protect'],
                    ['slug' => 'control', 'name' => 'Control'],
                    ['slug' => 'guide', 'name' => 'Guide'],
                ];

                foreach ($menus as $menu):
                    $menu_items = wp_get_nav_menu_items($menu['slug']);
                    if (!$menu_items)
                        continue;
                    ?>

                    <div class="mega-menu-link-col">
                        <div class="mega-menu-sub-title"><?php echo esc_html($menu['name']); ?></div>
                        <div class="mega-menu-sub-links">
                            <?php foreach ($menu_items as $menu_item): ?>
                                <a href="<?php echo esc_url($menu_item->url); ?>">
                                    <?php echo esc_html($menu_item->title); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>

                <?php endforeach; ?>
            </div>
        </div>
        <div class="mega-menu-right">
            <?php if (have_rows('product_mega_menu', 'option')): ?>
                <div class="mega-menu-top">
                    <?php while (have_rows('product_mega_menu', 'option')):
                        the_row();

                        $title_right = get_sub_field('title_right');
                        $subtitle_right = get_sub_field('subtitle_right');
                        $view_all_link_right = get_sub_field('view_all_link_right');
                        $category_menu_title_right = get_sub_field('category_menu_title_right');

                        ?>
                        <div>
                            <?php if ($title_right): ?>
                                <h5><?php echo esc_html($title_right); ?></h5>
                            <?php endif; ?>

                            <?php if ($subtitle_right): ?>
                                <p><?php echo esc_html($subtitle_right); ?></p>
                            <?php endif; ?>
                        </div>

                        <?php if ($view_all_link_right): ?>
                            <a href="<?php echo esc_url($view_all_link_right['url']); ?>" class="top-link-btn"
                                target="<?php echo esc_attr($view_all_link_right['target'] ? $view_all_link_right['target'] : '_self'); ?>">
                                <?php echo esc_html($view_all_link_right['title']); ?>
                                <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/double-right-arrow-red.svg'); ?>"
                                    alt="Button Arrow">
                            </a>
                        <?php endif; ?>

                    <?php endwhile; ?>
                </div>
            <?php endif; ?>

            <?php
            class Anchor_Only_Walker extends Walker_Nav_Menu
            {
                public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
                {
                    $output .= '<a href="' . esc_url($item->url) . '">' . esc_html($item->title) . '</a>';
                }
            }
            ?>
            <div class="mega-menu-right-link">
                <?php if (have_rows('product_mega_menu', 'option')): ?>
                    <?php while (have_rows('product_mega_menu', 'option')):
                        the_row();
                        $category_menu_title_right = get_sub_field('category_menu_title_right');
                        ?>
                        <div class="mega-menu-sub-title"><?php echo esc_html($category_menu_title_right) ?></div>
                    <?php endwhile; ?>
                <?php endif; ?>
                <?php
                wp_nav_menu([
                    'menu' => 'Safety System',
                    'container' => false,
                    'items_wrap' => '%3$s',
                    'walker' => new Anchor_Only_Walker(),
                ]);

                ?>
            </div>

            <?php if (have_rows('product_mega_menu', 'option')) { ?>
                <?php while (have_rows('product_mega_menu', 'option')):
                    the_row(); ?>
                    <?php
                    $product_slider_title = get_sub_field('product_slider_title');
                    $parent_product_slider = get_sub_field('parent_product_slider'); //type=post-object
                    ?>
                    <div class="mega-menu-feat-prod-section">
                        <div class="mega-menu-sub-title"><?php echo esc_html($product_slider_title); ?></div>
                        <div class="mega-menu-feat-prod-slider swiper">
                            <div class="swiper-wrapper">
                                <?php if ($parent_product_slider && is_array($parent_product_slider)): ?>
                                    <?php foreach ($parent_product_slider as $product_post):
                                        $product = wc_get_product($product_post->ID);
                                        if (!$product)
                                            continue;

                                        $product_id = $product->get_id();
                                        $product_title = $product->get_name();
                                        $product_excerpt = get_the_excerpt($product_id);
                                        $product_image = get_the_post_thumbnail($product_id, 'medium');

                                        $product_link = get_permalink($product_id);

                                        // Count variations and accessories
                                        $variation_count = 0;
                                        if ($product->is_type('variable')) {
                                            $variation_count = count($product->get_available_variations());
                                        }

                                        $accessories_count = 0;
                                        if (have_rows('page_sections', $product_id)) {
                                            while (have_rows('page_sections', $product_id)) {
                                                the_row();
                                                if (get_row_layout() == 'related_accessories_section') {
                                                    $accessories_product = get_sub_field('accessories_product_1');
                                                    if ($accessories_product) {
                                                        $accessories_count = is_array($accessories_product) ? count($accessories_product) : 1;
                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                        <div class="swiper-slide product-box">
                                            <a href="<?php echo esc_url($product_link); ?>">
                                                <div class="product-rang-img product-box-img">
                                                    <?php
                                                    if (has_term('new', 'product_tag', $product_id)) {
                                                        echo '<div class="product-tag new-tag">New</div>';
                                                    }
                                                    if (!$product_image) {
                                                        echo '<img src="' . get_template_directory_uri() . '/assets/images/default-image.jpeg" alt="' . esc_attr($product_title) . '">';
                                                    } else {
                                                        echo $product_image;
                                                    }
                                                    ?>
                                                </div>
                                                <div class="Product-box-desc">
                                                    <h5><?php echo esc_html($product_title); ?></h5>
                                                    <hr>
                                                    <p><?php echo esc_html(wp_trim_words($product_excerpt, 15, '...')); ?></p>
                                                    <hr>
                                                    <div class="product-box-available">
                                                        <label>available</label>
                                                        <div class="available-tags">
                                                            <span><?php echo $variation_count; ?> Models</span>
                                                            <span><?php echo $accessories_count; ?> Accessories</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            <div class="swiper-button-next menu-feat-prod-next carousel-arrow"></div>
                            <div class="swiper-button-prev menu-feat-prod-prev carousel-arrow"></div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php } ?>
        </div>
        <div class="mobi-call-section">
            <div class="mobi-call-text">
                <a href="#">Need a hand?</a> Call us now
            </div>
            <div class="mobi-call-nub">
                <a href="#"> <img
                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/head-contact-icon.svg"
                        alt="call Icon">1300 55 33 20</a>
            </div>
        </div>
    </div>
</div>