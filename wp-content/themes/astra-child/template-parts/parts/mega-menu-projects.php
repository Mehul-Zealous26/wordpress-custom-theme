<?php

/**
 * Section: Mega Menu - Projects
 * Dynamically loads Project Categories and Featured Projects
 */

if (!function_exists('get_field'))
    return; // Ensure ACF is active

// Try different possible taxonomy names for project categories
// $possible_taxonomies = ['projects_categories', 'project_categories', 'project_category', 'project_cat'];
// $project_categories = [];

// foreach ($possible_taxonomies as $taxonomy) {
//     if (taxonomy_exists($taxonomy)) {
//         $project_categories = get_terms([
//             'taxonomy'   => $taxonomy,
//             'hide_empty' => false,
//         ]);
//         if (!is_wp_error($project_categories) && !empty($project_categories)) {
//             break;
//         }
//     }
// }

$menus = [
    ['slug' => 'project-categories', 'name' => 'Project Categories'],
    ['slug' => 'project-industries', 'name' => 'Project Industries'],
    ['slug' => 'recent-projects', 'name' => 'Recent Projects'],
];
?>

<div class="mega-menu-main">
    <div class="mega-menu-box product-menu">
        <div class="mega-menu-left">
            <div class="m-menu-back">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/menua-arrow-back.svg"
                    alt="Back Arrow"> Projects
            </div>
            <div class="mega-menu-link-row">
                <?php
                // Display WordPress menus using slugs
                $menus = [
                    ['slug' => 'project-categories', 'name' => 'Project Categories'],
                    ['slug' => 'project-industries', 'name' => 'Project Industries'],
                    ['slug' => 'recent-projects', 'name' => 'Recent Projects'],
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
                        <a href="<?php echo site_url('/projects/'); ?>">
                            View All
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="mega-menu-right">
            <?php if (have_rows('project_mega_menu', 'option')) { ?>
                <?php while (have_rows('project_mega_menu', 'option')):
                    the_row(); ?>
                    <?php
                    $project_slider_title = get_sub_field('project_slider_title');
                    $project_product_slider = get_sub_field('project_product_slider'); //type=post-object
                    ?>
                    <div class="mega-menu-sub-title"><?php echo esc_html($project_slider_title); ?></div>
                    <div class="menu-feat-section">
                        <?php if ($project_product_slider && is_array($project_product_slider)): ?>
                            <?php foreach ($project_product_slider as $project_post):
                                $project_id = $project_post->ID;
                                $project_title = get_the_title($project_id);
                                $project_url = get_permalink($project_id);
                                $project_image = get_the_post_thumbnail_url($project_id, 'medium');
                                if (!$project_image) {
                                    $project_image = get_template_directory_uri() . '/assets/images/default-image.jpeg';
                                }

                                // Get project category
                                $categories = get_the_terms($project_id, 'projects_categories');
                                $category_name = 'Featured Project';
                                if ($categories && !is_wp_error($categories)) {
                                    $category_name = $categories[0]->name;
                                }

                                // Get location info
                                $locations = get_the_terms($project_id, 'location');
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
                                        <img src="<?php echo esc_url($project_image); ?>" alt="<?php echo esc_attr($project_title); ?>">
                                        <div class="menu-feat-tag">
                                            <span><?php echo esc_html($category_name); ?></span>
                                        </div>
                                    </div>
                                    <div class="menu-feat-desc">
                                        <div class="menu-feat-title"><?php echo esc_html($project_title); ?></div>
                                        <?php $company_name_value = get_field('company_name_value', $project_id); ?>
                                        <?php if ($company_name_value): ?>
                                            <div class="menu-feat-sub-des">
                                                <b><?php echo esc_html($company_name_value); ?></b>
                                                <?php if ($location_text): ?>
                                                    <span><?php echo esc_html($location_text); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <a href="<?php echo esc_url($project_url); ?>">
                                            View Project
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