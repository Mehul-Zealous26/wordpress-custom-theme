<?php

// if (get_row_layout() == 'applications') :
$enable_global_content = get_sub_field('enable_global_content');
$select_spacer = get_sub_field('select_spacer');
$padding_style = get_spacer_padding_style($select_spacer);
if ($enable_global_content) {
    $layout = get_field('layout', 'option'); // layout-normal : Normal Layout, layout-reverse : Reverse Layout
    $pretitle = get_field('application_pretitle', 'option');
    $title = get_field('application_title', 'option');
    $sub_title = get_field('application_title', 'option');
    $category_text = get_field('application_category_text', 'option');
    $sub_category_text = get_field('application_category_text', 'option');
    $application_text = get_field('application_text', 'option');
    $normal_applications = get_field('normal_applications', 'option');
    $reverse_applications = get_field('reverse_applications', 'option');
} else {
    $layout = get_sub_field('layout'); // layout-normal : Normal Layout, layout-reverse : Reverse Layout
    $pretitle = get_sub_field('pretitle');
    $title = get_sub_field('title');
    $sub_title = get_sub_field('sub_title');
    $category_text = get_sub_field('category_text');
    $sub_category_text = get_sub_field('sub_category_text');
    $application_text = get_sub_field('application_text');
    $normal_applications = get_sub_field('normal_applications');
    $reverse_applications = get_sub_field('reverse_applications');
}

$post_type = 'application';
$taxonomy = 'application_categories';
$has_applications = !empty($normal_applications) || !empty($reverse_applications);
// Get selected application IDs based on layout
$selected_apps = ($layout === 'layout-normal') ? $normal_applications : $reverse_applications;
$selected_app_ids = !empty($selected_apps) ? wp_list_pluck($selected_apps, 'ID') : array();

// Get categories from selected applications only, ordered by selection
$parent_categories = array();
if (!empty($selected_app_ids)) {
    foreach ($selected_app_ids as $app_id) {
        $terms = wp_get_object_terms($app_id, $taxonomy);
        if (!is_wp_error($terms)) {
            foreach ($terms as $term) {
                if ($term->parent == 0 && !isset($parent_categories[$term->term_id])) {
                    $parent_categories[$term->term_id] = $term;
                }
            }
        }
    }
    $parent_categories = array_values($parent_categories);
}
?>
<?php
// Stop rendering if admin selected no applications
if (empty($selected_app_ids)) {
    return;
}
?>
<?php if ($enable_global_content) ?>
<?php if ($layout === 'layout-normal') { ?>
    <section class="category-tab-section" <?php if ($padding_style)
        echo 'style="' . esc_attr($padding_style) . '"'; ?>
        id="applications">
        <div class="container-box">
            <div class="sub-title-with-text sub-title-with-text-center w-600">
                <?php if (!empty($pretitle)) { ?>
                    <div class="sub-heading"><?php echo $pretitle; ?></div>
                <?php } ?>
                <?php if (!empty($title)) { ?>
                    <h2><?php echo $title; ?></h2>
                <?php } ?>
            </div>
            <div class="category-tab-box-main">
                <div class="category-tab-title-box">
                    <?php if ($category_text) { ?>
                        <div class="category-tab-title"><span>1.</span> <?php echo $category_text ?></div>
                    <?php } else { ?>
                        <div class="category-tab-title"><span>1.</span>Select your business model</div>
                    <?php } ?>
                    <?php if ($sub_category_text) { ?>
                        <div class="category-tab-title"><span>2.</span> <?php echo $sub_category_text ?></div>
                    <?php } else { ?>
                        <div class="category-tab-title"><span>2.</span>Select your Area</div>
                    <?php } ?>
                    <?php if ($application_text) { ?>
                        <div class="category-tab-title last"><span>3.</span> <?php echo $application_text ?></div>
                    <?php } else { ?>
                        <div class="category-tab-title last"><span>3.</span>Browse your item</div>
                    <?php } ?>
                </div>
                <div class="category-tab">
                    <ul class="category-tab-list">
                        <?php
                        $first = true;
                        if (!empty($parent_categories)):
                            foreach ($parent_categories as $parent_cat):
                                // Check if this category has subcategories with applications
                                $child_categories = get_terms(array(
                                    'taxonomy' => $taxonomy,
                                    'parent' => $parent_cat->term_id,
                                    'hide_empty' => false
                                ));

                                $has_subcategory_with_apps = false;
                                if (!empty($child_categories)) {
                                    foreach ($child_categories as $child_cat) {
                                        $child_posts = get_posts(array(
                                            'post_type' => $post_type,
                                            'posts_per_page' => 1,
                                            'post__in' => $selected_app_ids,
                                            'orderby' => 'post__in',
                                            'tax_query' => array(
                                                array(
                                                    'taxonomy' => $taxonomy,
                                                    'field' => 'term_id',
                                                    'terms' => $child_cat->term_id
                                                )
                                            )
                                        ));
                                        if (!empty($child_posts)) {
                                            $has_subcategory_with_apps = true;
                                            break;
                                        }
                                    }
                                }

                                // Only show categories that have subcategories with applications
                                if ($has_subcategory_with_apps):
                                    ?>
                                    <li class="<?php echo $first ? 'active' : ''; ?>"
                                        data-tab="<?php echo esc_attr($parent_cat->slug); ?>">
                                        <?php echo esc_html($parent_cat->name); ?>
                                    </li>
                                    <?php
                                    $first = false;
                                endif;
                            endforeach;
                        else:
                            ?>
                            <li class="active" data-tab="no-categories">No Categories Found</li>
                        <?php endif; ?>
                    </ul>

                    <?php
                    $first_content = true;
                    if (!empty($parent_categories)):
                        foreach ($parent_categories as $parent_cat):
                            // Check if this category has subcategories with applications
                            $child_categories = get_terms(array(
                                'taxonomy' => $taxonomy,
                                'parent' => $parent_cat->term_id,
                                'hide_empty' => false
                            ));

                            $has_subcategory_with_apps = false;
                            if (!empty($child_categories)) {
                                foreach ($child_categories as $child_cat) {
                                    $child_posts = get_posts(array(
                                        'post_type' => $post_type,
                                        'posts_per_page' => 1,
                                        'post__in' => $selected_app_ids,
                                        'orderby' => 'post__in',
                                        'tax_query' => array(
                                            array(
                                                'taxonomy' => $taxonomy,
                                                'field' => 'term_id',
                                                'terms' => $child_cat->term_id
                                            )
                                        )
                                    ));
                                    if (!empty($child_posts)) {
                                        $has_subcategory_with_apps = true;
                                        break;
                                    }
                                }
                            }

                            // Only show content for categories that have subcategories with applications
                            if ($has_subcategory_with_apps):
                                ?>
                                <div class="category-tab-content <?php echo $first_content ? 'active' : ''; ?>"
                                    id="<?php echo esc_attr($parent_cat->slug); ?>" <?php echo !$first_content ? 'style="display: none;"' : ''; ?>>
                                    <div class="category-tab-inner">
                                        <?php if (!empty($child_categories)): ?>
                                            <ul class="category-sub-tabs">
                                                <?php
                                                $first_child = true;
                                                if (!empty($child_categories)):
                                                    foreach ($child_categories as $child_cat):
                                                        // Check if subcategory has applications
                                                        $child_posts = get_posts(array(
                                                            'post_type' => $post_type,
                                                            'posts_per_page' => 1,
                                                            'post__in' => $selected_app_ids,
                                                            'orderby' => 'post__in',
                                                            'tax_query' => array(
                                                                array(
                                                                    'taxonomy' => $taxonomy,
                                                                    'field' => 'term_id',
                                                                    'terms' => $child_cat->term_id
                                                                )
                                                            )
                                                        ));

                                                        // Only show subcategories with applications
                                                        if (!empty($child_posts)):
                                                            ?>
                                                            <li class="<?php echo $first_child ? 'active' : ''; ?>"
                                                                data-sub="<?php echo esc_attr($parent_cat->slug . '-' . $child_cat->slug); ?>">
                                                                <?php echo esc_html($child_cat->name); ?>
                                                            </li>
                                                            <?php
                                                            $first_child = false;
                                                        endif;
                                                    endforeach;
                                                endif;
                                                ?>
                                            </ul>

                                            <?php
                                            $first_sub_content = true;
                                            if (!empty($child_categories)):
                                                foreach ($child_categories as $child_cat):
                                                    $posts = get_posts(array(
                                                        'post_type' => $post_type,
                                                        'posts_per_page' => 1,
                                                        'post__in' => $selected_app_ids,
                                                        'orderby' => 'post__in',
                                                        'tax_query' => array(
                                                            array(
                                                                'taxonomy' => $taxonomy,
                                                                'field' => 'term_id',
                                                                'terms' => $child_cat->term_id
                                                            )
                                                        )
                                                    ));

                                                    // Only show content for subcategories with applications
                                                    if (!empty($posts)):
                                                        ?>
                                                        <div class="category-sub-content <?php echo $first_sub_content ? 'active' : ''; ?>"
                                                            id="<?php echo esc_attr($parent_cat->slug . '-' . $child_cat->slug); ?>" <?php echo !$first_sub_content ? 'style="display: none;"' : ''; ?>>
                                                            <div class="category-sub-card">
                                                                <?php $post = $posts[0]; ?>
                                                                <?php if (has_post_thumbnail($post->ID)): ?>
                                                                    <img class="category-sub-card-img"
                                                                        src="<?php echo get_the_post_thumbnail_url($post->ID, 'full'); ?>"
                                                                        alt="<?php echo esc_attr($post->post_title); ?>">
                                                                <?php endif; ?>
                                                                <h3><?php echo esc_html($post->post_title); ?></h3>
                                                                <p><?php echo wp_trim_words($post->post_content, 20); ?></p>
                                                                <hr>
                                                                <a href="<?php echo get_permalink($post->ID); ?>" class="btn double-right-btn">
                                                                    Explore Now
                                                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/double-right-arrow-lg.svg"
                                                                        alt="arrow Image">
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        $first_sub_content = false;
                                                    endif;
                                                endforeach;
                                            endif; ?>
                                        <?php else:
                                            $posts = get_posts(array(
                                                'post_type' => $post_type,
                                                'posts_per_page' => 1,
                                                'post__in' => $selected_app_ids,
                                                'orderby' => 'post__in',
                                                'tax_query' => array(
                                                    array(
                                                        'taxonomy' => $taxonomy,
                                                        'field' => 'term_id',
                                                        'terms' => $parent_cat->term_id
                                                    )
                                                )
                                            ));
                                            ?>
                                            <div class="category-sub-content active">
                                                <div class="category-sub-card">
                                                    <?php if (!empty($posts)):
                                                        $post = $posts[0]; ?>
                                                        <?php if (has_post_thumbnail($post->ID)): ?>
                                                            <img class="category-sub-card-img"
                                                                src="<?php echo get_the_post_thumbnail_url($post->ID, 'full'); ?>"
                                                                alt="<?php echo esc_attr($post->post_title); ?>">
                                                        <?php endif; ?>
                                                        <h3><?php echo esc_html($post->post_title); ?></h3>
                                                        <p><?php echo wp_trim_words($post->post_content, 20); ?></p>
                                                    <?php else: ?>
                                                        <h3>No Application Found</h3>
                                                        <p>No applications available for this category.</p>
                                                    <?php endif; ?>
                                                    <hr>
                                                    <a href="<?php echo !empty($posts) ? get_permalink($posts[0]->ID) : get_term_link($parent_cat); ?>"
                                                        class="btn double-right-btn">
                                                        Explore Now
                                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/double-right-arrow-lg.svg"
                                                            alt="arrow Image">
                                                    </a>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php
                                $first_content = false;
                            endif;
                        endforeach;
                    endif; ?>
                </div>
            </div>
        </div>
    </section>
<?php } else if ($layout === 'layout-reverse') { ?>
        <section class="category-tab-section" <?php if ($padding_style)
            echo 'style="' . esc_attr($padding_style) . '"'; ?>>
            <div class="container-box">
                <div class="sub-title-with-text sub-title-with-text-center w-600 text-content-section">
                <?php if (!empty($pretitle)) { ?>
                        <div class="sub-heading"><?php echo $pretitle; ?></div>
                <?php } ?>
                <?php if (!empty($title)) { ?>
                        <?php echo $title; ?>
                <?php } ?>
                </div>
                <div class="category-tab-box-main category-tab-reverse category-tab-box-2">
                    <div class="category-tab">
                        <ul class="category-tab-list">
                            <?php
                            $first_item = true;
                            if (!empty($parent_categories)):
                                foreach ($parent_categories as $parent_cat):
                                    // Check if parent category has applications directly assigned
                                    $parent_posts = get_posts(array(
                                        'post_type' => $post_type,
                                        'posts_per_page' => 1,
                                        'post__in' => $selected_app_ids,
                                        'orderby' => 'post__in',
                                        'tax_query' => array(
                                            array(
                                                'taxonomy' => $taxonomy,
                                                'field' => 'term_id',
                                                'terms' => $parent_cat->term_id
                                            )
                                        )
                                    ));

                                    // Only show categories that have applications directly assigned
                                    if (!empty($parent_posts)):
                                        ?>
                                        <li class="<?php echo $first_item ? 'active' : ''; ?>"
                                            data-tab="<?php echo esc_attr($parent_cat->slug); ?>">
                                        <?php echo esc_html($parent_cat->name); ?>
                                        </li>
                                        <?php
                                        $first_item = false;
                                    endif;
                                endforeach;
                            endif;
                            ?>
                        </ul>

                        <?php
                        $first_content = true;
                        if (!empty($parent_categories)):
                            foreach ($parent_categories as $parent_cat):
                                // Check if parent category has applications directly assigned
                                $parent_posts = get_posts(array(
                                    'post_type' => $post_type,
                                    'posts_per_page' => 1,
                                    'post__in' => $selected_app_ids,
                                    'orderby' => 'post__in',
                                    'tax_query' => array(
                                        array(
                                            'taxonomy' => $taxonomy,
                                            'field' => 'term_id',
                                            'terms' => $parent_cat->term_id
                                        )
                                    )
                                ));

                                // Only show content for categories that have applications directly assigned
                                if (!empty($parent_posts)):
                                    ?>
                                    <div class="category-tab-content <?php echo $first_content ? 'active' : ''; ?>"
                                        id="<?php echo esc_attr($parent_cat->slug); ?>" <?php echo !$first_content ? 'style="display: none;"' : ''; ?>>
                                        <div class="category-tab-inner">
                                            <div class="category-sub-content active">
                                                <div class="category-sub-card">
                                                <?php $post = $parent_posts[0]; ?>
                                                <?php if (has_post_thumbnail($post->ID)): ?>
                                                        <img class="category-sub-card-img"
                                                            src="<?php echo get_the_post_thumbnail_url($post->ID, 'full'); ?>"
                                                            alt="<?php echo esc_attr($post->post_title); ?>">
                                                <?php endif; ?>
                                                    <h3><?php echo esc_html($post->post_title); ?></h3>
                                                    <p><?php echo wp_trim_words($post->post_content, 20); ?></p>
                                                    <hr>
                                                    <a href="<?php echo get_permalink($post->ID); ?>" class="btn double-right-btn">
                                                        Explore Now
                                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/double-right-arrow-lg.svg"
                                                            alt="arrow Image">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    $first_content = false;
                                endif;
                            endforeach;
                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </section>
<?php } ?>