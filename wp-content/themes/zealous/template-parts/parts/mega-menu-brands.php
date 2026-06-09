<?php
$menu_name = 'Brand Menu'; // Menu name in WP Admin
$menu = wp_get_nav_menu_object($menu_name);

if ($menu):
    $menu_items = wp_get_nav_menu_items($menu->term_id);
    if ($menu_items):
        ?>
        <div class="mega-menu-box brand-menu">
            <div class="m-menu-back">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/menua-arrow-back.svg" alt="Back Arrow">
                Brand
            </div>
            <?php foreach ($menu_items as $item):

                /* --------------------------------
                 * IMAGE
                 * -------------------------------- */
                $image = '';

                // If menu item links to a post/page
                if ($item->type === 'post_type') {
                    $thumb = get_the_post_thumbnail_url($item->object_id, 'medium');

                    if ($thumb) {
                        $image = $thumb;
                    }
                }

                // Fallback image
                if (empty($image)) {
                    $image = get_stylesheet_directory_uri() . '/assets/images/default-image.jpeg';
                }

                /* --------------------------------
                 * DESCRIPTION (priority system)
                 * -------------------------------- */
                $description = '';

                // Menu item description (BEST METHOD)
                if (!empty($item->description)) {
                    $description = $item->description;
                }

                // Fallback = page/post excerpt
                elseif ($item->type === 'post_type') {

                    $post_obj = get_post($item->object_id);

                    if ($post_obj) {

                        // manual excerpt
                        if (!empty($post_obj->post_excerpt)) {
                            $description = $post_obj->post_excerpt;
                        }
                        // auto excerpt from content (optional fallback)
                        else {
                            $description = wp_trim_words(
                                wp_strip_all_tags($post_obj->post_content),
                                18,
                                '...'
                            );
                        }
                    }
                }
                ?>

                <a href="<?php echo esc_url($item->url); ?>" class="brand-menu-col">
                    <div class="brand-menu-img">
                        <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($item->title); ?>">
                    </div>

                    <?php if (!empty(esc_html($item->title))): ?>
                        <b><?php echo esc_html($item->title); ?></b>
                    <?php else: ?>
                        <b>No Page Title</b>
                    <?php endif; ?>

                    <?php if (!empty($description)): ?>
                        <p><?php echo esc_html($description); ?></p>
                    <?php endif; ?>
                </a>

            <?php endforeach; ?>
            <div class="mobi-call-section">
                <div class="mobi-call-text">
                    <a href="#">Need a hand?</a> Call us now
                </div>
                <div class="mobi-call-nub">
                    <a href="#"> <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/head-contact-icon.svg"
                            alt="call Icon">1300 55 33 20</a>
                </div>
            </div>
        </div>
        <?php
    endif;
endif;
?>