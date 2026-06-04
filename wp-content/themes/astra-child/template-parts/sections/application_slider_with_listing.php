<?php
$application_slides = get_sub_field('application_slides');
$application_listing_title = get_sub_field('application_listing_title');
$application_listing_description = get_sub_field('application_listing_description');
$select_spacer = get_sub_field('select_spacer');
$padding_style = get_spacer_padding_style($select_spacer);
?>
<section class="main-banner-section project-banner">
    <div class="main-banner-swiper swiper">
        <div class="swiper-wrapper">
            <?php if ($application_slides): ?>
                <?php foreach ($application_slides as $application): ?>
                    <?php
                    $application_id = $application->ID;
                    $application_title = get_the_title($application_id);
                    $application_url = get_permalink($application_id);
                    $application_image = get_the_post_thumbnail_url($application_id, 'full');
                    if (!$application_image) {
                        $application_image = get_template_directory_uri() . '/assets/images/default-image.jpeg';
                    }
                    ?>
                    <div class="banner-slider swiper-slide">
                        <img class="banner-slider-img" src="<?php echo esc_url($application_image); ?>"
                            alt="<?php echo esc_attr($application_title); ?>">
                        <div class="project-banner-cont">
                            <h1><?php echo esc_html($application_title); ?></h1>
                            <div class="banner-btn">
                                <a href="<?php echo esc_url($application_url); ?>"
                                    class="btn secondary-btn double-right-btn">View Application <img
                                        src="<?php echo get_template_directory_uri(); ?>/assets/images/double-right-black-new.svg"
                                        alt="Button Arrow"></a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="banner-slider-cont">
            <div class="swiper-button-prev banner-slider-prev"></div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next banner-slider-next"></div>
        </div>
    </div>
</section>
<section class="project-section" <?php if ($padding_style)
    echo 'style="' . esc_attr($padding_style) . '"'; ?>>
    <div class="container-box">
        <div class="sub-title-with-text w-600 text-content-section">
            <?php echo ($application_listing_title); ?>
            <?php echo ($application_listing_description); ?>
        </div>
        <div class="product-list-filter-section filter-section-border">
            <div class="plf-section-left">
            </div>
            <div class="plf-section-right" id="application-sortby-filter">
                <div class="sort-by-box">
                    <label id="sort_label">Sort by:</label>
                    <select id="sort_by" class="select-drop">
                        <option value="recommended">Recommended</option>
                        <option value="latest">Newest First</option>
                        <option value="oldest">Oldest First</option>
                        <option value="title_asc">A → Z</option>
                        <option value="title_desc">Z → A</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="pdf-filter-box">
            <div class="project-section-main" id="application-list">
                <?php
                $applications_query = new WP_Query([
                    'post_type' => 'application',
                    'post_status' => 'publish',
                    'posts_per_page' => 12,
                    'orderby' => 'date',
                    'order' => 'DESC'
                ]);

                if ($applications_query->have_posts()):
                    while ($applications_query->have_posts()):
                        $applications_query->the_post();
                        $application_id = get_the_ID();
                        $application_title = get_the_title();
                        $application_url = get_permalink();
                        $application_image = get_the_post_thumbnail_url($application_id, 'full');
                        if (!$application_image) {
                            $application_image = get_template_directory_uri() . '/assets/images/default-image.jpeg';
                        }
                        ?>
                        <div class="project-section-box">
                            <a href="<?php echo esc_url($application_url); ?>">
                                <div class="project-img-tag">
                                    <img src="<?php echo esc_url($application_image); ?>"
                                        alt="<?php echo esc_attr($application_title); ?>">
                                </div>
                                <div class="project-info-box">
                                    <h3>
                                        <div class="product-custom-title-case"><?php echo esc_html($application_title); ?></div>
                                    </h3>
                                </div>
                            </a>
                        </div>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                else:
                    ?>
                    <p>No applications found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>