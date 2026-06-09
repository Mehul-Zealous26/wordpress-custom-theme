<?php
$pre_title = get_sub_field('pre_title');
$title = get_sub_field('title');
$description = get_sub_field('description');
$select_spacer = get_sub_field('select_spacer');
$padding_style = get_spacer_padding_style($select_spacer);
?>

<section class="product-f-video p-f-video-md v-top" <?php if ($padding_style)
    echo 'style="' . esc_attr($padding_style) . '"'; ?>>
    <div class="container-box">
        <div class="product-f-video-left sub-title-with-text text-content-section">
            <?php if ($pre_title) { ?>
                <div class="sub-heading">
                    <?php echo esc_html($pre_title); ?>
                </div>
            <?php } ?>

            <?php if ($title) { ?>
                <?php echo ($title); ?>
            <?php } ?>

            <?php if ($description) { ?>
                    <?php echo ($description); ?>
            <?php } ?>
        </div>

        <div class="product-f-video-right career-right-section">
            <div class="tab-main-box">

                <!-- Tabs -->
                <div class="tab-main-top">
                    <div class="tab active" data-filter="all">View All</div>

                    <?php
                    $categories = get_terms(array(
                        'taxonomy' => 'career_categories',
                        'hide_empty' => false
                    ));

                    if (!empty($categories)):
                        foreach ($categories as $category):
                            ?>
                            <div class="tab" data-filter="<?php echo esc_attr($category->slug); ?>">
                                <?php echo esc_html($category->name); ?>
                            </div>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </div>

                <!-- Careers -->
                <div class="tab-main-content">
                    <?php
                    $careers = new WP_Query(array(
                        'post_type' => 'career',
                        'posts_per_page' => -1,
                        'post_status' => 'publish'
                    ));

                    if ($careers->have_posts()):
                        while ($careers->have_posts()):
                            $careers->the_post();

                            // ✅ PER CAREER FIELD (IMPORTANT)
                            $hide_job_description = get_field('hide_job_description', get_the_ID());

                            $career_categories = wp_get_post_terms(get_the_ID(), 'career_categories');
                            $career_tags = wp_get_post_terms(get_the_ID(), 'career_tags');
                            $career_location = wp_get_post_terms(get_the_ID(), 'career_location');

                            $full_half_time = get_field('full_half_time');

                            $labels = [
                                'part-time' => 'Part Time',
                                'full-time' => 'Full Time',
                            ];

                            $view_on_seek = get_field('view_on_seek');

                            $category_classes = array();
                            if (!empty($career_categories)) {
                                foreach ($career_categories as $cat) {
                                    $category_classes[] = $cat->slug;
                                }
                            }
                            $category_class_string = implode(' ', $category_classes);
                            ?>

                            <div class="tab-inner <?php echo esc_attr($category_class_string); ?>">
                                <div class="career-info-top">

                                    <div class="career-info-top-left">
                                        <?php if (!empty($career_categories)): ?>
                                            <div class="sub-heading no-dots">
                                                <?php echo esc_html($career_categories[0]->name); ?>
                                            </div>
                                        <?php endif; ?>

                                        <div class="career-info-head">
                                            <h5>
                                                <a href="<?php the_permalink(); ?>">
                                                    <?php the_title(); ?>
                                                </a>
                                            </h5>

                                            <?php if (!empty($career_tags)): ?>
                                                <?php foreach ($career_tags as $tag): ?>
                                                    <span><?php echo esc_html($tag->name); ?></span>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php if (!$hide_job_description || $view_on_seek): ?>

                                    <div class="career-info-top-right d-desk-xs-f">
                                        <?php if (!$hide_job_description): ?>
                                            <a href="<?php the_permalink(); ?>" class="btn secondary-btn btn-xs">
                                                View Job Description
                                            </a>
                                        <?php endif; ?>

                                        <?php if ($view_on_seek):
                                            $target = $view_on_seek['target'] ? $view_on_seek['target'] : '_self';
                                            ?>
                                            <a href="<?php echo esc_url($view_on_seek['url']); ?>" class="btn secondary-btn btn-xs"
                                                target="<?php echo esc_attr($target); ?>">
                                                <?php echo esc_html($view_on_seek['title']); ?>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                     <?php endif; ?>
                                </div>

                                <?php
                                $excerpt = trim(get_the_excerpt());
                                if (!empty($excerpt)): ?>
                                    <p><?php echo wp_trim_words($excerpt, 30); ?></p>
                                <?php endif; ?>

                                <div class="career-sub-info">
                                    <span>
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/location-icon.svg"
                                            alt="">
                                        <?php echo !empty($career_location)
                                            ? esc_html($career_location[0]->name)
                                            : 'Location'; ?>
                                    </span>

                                    <?php if ($full_half_time && $full_half_time !== 'select-shift'): ?>
                                        <span>
                                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/time-icon.svg"
                                                alt="">
                                            <?php echo esc_html($labels[$full_half_time]); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
<?php if (!$hide_job_description || $view_on_seek): ?>

                                <div class="career-info-top-right d-mob-xs-f">
                                    <?php if (!$hide_job_description): ?>
                                        <a href="<?php the_permalink(); ?>" class="btn secondary-btn btn-xs">
                                            View Job Description
                                        </a>
                                    <?php endif; ?>

                                    <?php if ($view_on_seek):
                                        $target = $view_on_seek['target'] ? $view_on_seek['target'] : '_self';
                                        ?>
                                        <a href="<?php echo esc_url($view_on_seek['url']); ?>" class="btn secondary-btn btn-xs"
                                            target="<?php echo esc_attr($target); ?>">
                                            <?php echo esc_html($view_on_seek['title']); ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
 <?php endif; ?>
                            </div>

                            <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>