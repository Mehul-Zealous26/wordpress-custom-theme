<?php

/**
 * Section: Mega Menu - Applications
 * Dynamically loads Application Categories and Featured Applications
 */

if (!function_exists('get_field'))
    return; // Ensure ACF is active

// Try different possible taxonomy names for application categories
$possible_taxonomies = ['applications_categories', 'application_categories', 'application_category', 'application_cat'];
$application_categories = [];

foreach ($possible_taxonomies as $taxonomy) {
    if (taxonomy_exists($taxonomy)) {
        $application_categories = get_terms([
            'taxonomy' => $taxonomy,
            'hide_empty' => false,
        ]);
        if (!is_wp_error($application_categories) && !empty($application_categories)) {
            break;
        }
    }
}

// If no categories found, create some dummy content to show the structure
if (empty($application_categories) || is_wp_error($application_categories)) {
    $application_categories = [
        (object) ['name' => 'Industrial Applications', 'term_id' => 1],
        (object) ['name' => 'Commercial Applications', 'term_id' => 2],
        (object) ['name' => 'Residential Applications', 'term_id' => 3],
    ];
}
?>

<div class="mega-menu-main">
    <div class="mega-menu-box product-menu">
        <div class="mega-menu-left">
            <div class="m-menu-back">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/menua-arrow-back.svg"
                    alt="Back Arrow"> Applications
            </div>
            <div class="mega-menu-link-row">

                <?php
                $menus = [
                    ['slug' => 'application-categories', 'name' => 'Application Categories'],
                    ['slug' => 'application', 'name' => 'Applications']
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

                <!-- COLUMN 3: Other -->
                <div class="mega-menu-link-col">
                    <div class="mega-menu-sub-title">Other</div>
                    <div class="mega-menu-sub-links">
                        <a href="<?php echo site_url('/applications/'); ?>">
                            View All
                        </a>
                    </div>
                </div>

            </div>
        </div>
        <div class="mega-menu-right">
            <?php if (have_rows('application_mega_menu', 'option')) { ?>
                <?php while (have_rows('application_mega_menu', 'option')):
                    the_row(); ?>
                    <?php
                    $application_slider_title = get_sub_field('application_slider_title');
                    $application_product_slider = get_sub_field('application_product_slider'); //type=post-object
                    ?>
                    <div class="mega-menu-sub-title"><?php echo esc_html($application_slider_title); ?></div>
                    <div class="menu-feat-section">
                        <?php if ($application_product_slider && is_array($application_product_slider)): ?>
                            <?php foreach ($application_product_slider as $application_post):
                                $application_id = $application_post->ID;
                                $application_title = get_the_title($application_id);
                                $application_url = get_permalink($application_id);
                                $application_image = get_the_post_thumbnail_url($application_id, 'medium');
                                if (!$application_image) {
                                    $application_image = get_template_directory_uri() . '/assets/images/default-image.jpeg';
                                }

                                // Get application category
                                $categories = get_the_terms($application_id, 'applications_categories');
                                $category_name = 'Featured Application';
                                if ($categories && !is_wp_error($categories)) {
                                    $category_name = $categories[0]->name;
                                }

                                // Get location info
                                $locations = get_the_terms($application_id, 'location');
                                $location_name = '';
                                $location_text = '';
                                if ($locations && !is_wp_error($locations)) {
                                    $location = $locations[0];
                                    $location_name = $location->name;
                                    $location_text = get_field('location_text', 'location_' . $location->term_id);
                                }
                                ?>
                                <div class="menu-feat-col">
                                    <div class="menu-feat-img">
                                        <img src="<?php echo esc_url($application_image); ?>"
                                            alt="<?php echo esc_attr($application_title); ?>">
                                        <div class="menu-feat-tag">
                                            <span><?php echo esc_html($category_name); ?></span>
                                        </div>
                                    </div>
                                    <div class="menu-feat-desc">
                                        <div class="menu-feat-title"><?php echo esc_html($application_title); ?></div>
                                        <?php if ($location_name): ?>
                                            <div class="menu-feat-sub-des">
                                                <b><?php echo esc_html($location_name); ?></b>
                                                <?php if ($location_text): ?>
                                                    <span><?php echo esc_html($location_text); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <a href="<?php echo esc_url($application_url); ?>">
                                            View Application
                                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/double-right-arrow-red.svg"
                                                alt="Button Arrow">
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
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