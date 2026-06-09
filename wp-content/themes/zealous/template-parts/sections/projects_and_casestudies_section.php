<?php
// Robust unique ID generation to prevent duplicate ID conflicts on the same page
static $projects_casestudies_instance = 0;
$projects_casestudies_instance++;
$projects_cs_unique_id = 'projects-cs-' . $projects_casestudies_instance . '-' . rand(100, 999);

$select_spacer = get_sub_field('select_spacer');
$padding_style = get_spacer_padding_style($select_spacer);
$enable_global_content = get_sub_field('enable_global_content');
if ($enable_global_content) {
    $pretitle = get_field('projects_and_casestudies_pretitle', 'option');
    $title = get_field('projects_and_casestudies_title', 'option');
    $description = get_field('projects_and_casestudies_description', 'option');
    $related_projects = get_field('related_projects', 'option');
    // $projects_and_casestudies_tab_title = get_field('projects_and_casestudies_tab_title', 'option');
} else {
    $pretitle = get_sub_field('pretitle');
    $title = get_sub_field('title');
    $description = get_sub_field('description');
    $related_projects = get_sub_field('related_projects'); //type=post-object and assinged to post_type=project_nd_casestudy
}
?>

<section class="project-slider-section" id="projects_and_casestudies_section_<?php echo esc_attr($projects_cs_unique_id); ?>" <?php if ($padding_style)
    echo 'style="' . esc_attr($padding_style) . '"'; ?>>
    <div class="container-box">
        <div class="sub-title-with-text text-content-section w-600">
            <?php if ($pretitle) { ?>
                <div class="sub-heading"><?php echo esc_html($pretitle); ?></div>
            <?php } ?>
            <?php if ($title) { ?>
                <?php echo ($title); ?>
            <?php } ?>
            <?php if ($description) { ?>
                <?php echo ($description); ?>
            <?php } ?>
        </div>
    </div>
    <?php
    $projects = is_array($related_projects) ? $related_projects : [$related_projects];
    $product_count = count($projects);
    ?>
    <div class="project-slider-main<?php echo $product_count > 4 ? ' more-than-4-slides-proj' : ''; ?>" id="<?php echo esc_attr($projects_cs_unique_id); ?>">
        <div class="project-slider-box swiper">
            <div class="swiper-wrapper">
                <?php if ($related_projects): ?>
                    <?php foreach ($related_projects as $project): ?>
                        <?php
                        $project_id = $project->ID;
                        $project_title = get_the_title($project_id);
                        $project_url = get_permalink($project_id);
                        $project_image = get_the_post_thumbnail_url($project_id, 'full');
                        if (!$project_image) {
                            $project_image = get_template_directory_uri() . '/assets/images/default-image.jpeg';
                        }
                        $project_categories = get_the_terms($project_id, 'projects_categories');
                        ?>
                        <div class="project-section-box swiper-slide">
                            <a href="<?php echo esc_url($project_url); ?>">
                                <div class="project-img-tag">
                                    <?php if ($project_image): ?>
                                        <img src="<?php echo esc_url($project_image); ?>"
                                            alt="<?php echo esc_attr($project_title); ?>">
                                    <?php endif; ?>
                                    <?php if ($project_categories && !is_wp_error($project_categories)): ?>
                                        <div class="project-tag">
                                            <?php foreach ($project_categories as $category): ?>
                                                <span><?php echo esc_html($category->name); ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="project-info-box">
                                    <h3>
                                        <div class="product-custom-title-case"><?php echo esc_html($project_title); ?></div>
                                    </h3>
                                    <?php
                                    $locations = get_the_terms($project_id, 'location');
                                    $company_name = get_field('company_name_value', $project_id);
                                    if ($locations && !is_wp_error($locations)) {
                                        $location = $locations[0];
                                        if ($company_name) {
                                            echo '<label>' . esc_html($company_name) . '</label>';
                                        } else {
                                            echo '<label>' . 'N/A' . '</label>';
                                        }
                                        $location_value = get_field('location_text', 'location_' . $location->term_id);
                                        if ($location_value) {
                                            echo '<span>' . esc_html($location_value) . '</span>';
                                        } else {
                                            echo '<span>' . 'N/A' . '</span>';
                                        }
                                    }
                                    ?>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="slider-bottom-cont project-slider">
                <div class="swiper-pagination cs-swiper-pagination-<?php echo esc_attr($projects_cs_unique_id); ?>"></div>
                <div class="sider-arrow-box">
                    <div class="swiper-button-prev cs-slider-prev-<?php echo esc_attr($projects_cs_unique_id); ?> slider-arrow"><svg
                            class="swiper-navigation-icon" width="11" height="20" viewBox="0 0 11 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M0.38296 20.0762C0.111788 19.805 0.111788 19.3654 0.38296 19.0942L9.19758 10.2796L0.38296 1.46497C0.111788 1.19379 0.111788 0.754138 0.38296 0.482966C0.654131 0.211794 1.09379 0.211794 1.36496 0.482966L10.4341 9.55214C10.8359 9.9539 10.8359 10.6053 10.4341 11.007L1.36496 20.0762C1.09379 20.3474 0.654131 20.3474 0.38296 20.0762Z"
                                fill="currentColor"></path>
                        </svg></div>
                    <div class="swiper-button-next cs-slider-next-<?php echo esc_attr($projects_cs_unique_id); ?> slider-arrow"><svg
                            class="swiper-navigation-icon" width="11" height="20" viewBox="0 0 11 20" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M0.38296 20.0762C0.111788 19.805 0.111788 19.3654 0.38296 19.0942L9.19758 10.2796L0.38296 1.46497C0.111788 1.19379 0.111788 0.754138 0.38296 0.482966C0.654131 0.211794 1.09379 0.211794 1.36496 0.482966L10.4341 9.55214C10.8359 9.9539 10.8359 10.6053 10.4341 11.007L1.36496 20.0762C1.09379 20.3474 0.654131 20.3474 0.38296 20.0762Z"
                                fill="currentColor"></path>
                        </svg></div>
                </div>
            </div>
            <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
        </div>
    </div>
</section>
<?php if ($product_count > 4): ?>
<style>
@media (max-width: 767px) {
    .more-than-4-slides-proj .swiper-pagination {
        display: none !important;
    }
}
</style>
<?php endif; ?>
<script>
    (function () {
        var sliderId = '<?php echo esc_js($projects_cs_unique_id); ?>';

        function initProjectSwiper() {
            var wrapper = document.getElementById(sliderId);
            if (!wrapper) return;

            var slider = wrapper.querySelector('.project-slider-box');
            if (!slider) return;
            if (slider.classList.contains('swiper-initialized')) return;
            if (slider.offsetParent === null) return;

            var nextEl = wrapper.querySelector('.cs-slider-next-' + sliderId);
            var prevEl = wrapper.querySelector('.cs-slider-prev-' + sliderId);
            var paginationEl = wrapper.querySelector('.cs-swiper-pagination-' + sliderId);

            var swiperConfig = {
                slidesPerView: 'auto',
                centeredSlides: false,
                grabCursor: true,
                loop: true,
                loopedSlides: 10,
                spaceBetween: 24,
                slidesOffsetBefore: 0,
                slidesOffsetAfter: 0,
                speed: 800,
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                },
                on: {
                    init: function () { toggleSliderBottom(this, wrapper); },
                    resize: function () { toggleSliderBottom(this, wrapper); },
                    update: function () { toggleSliderBottom(this, wrapper); }
                }
            };

            if (nextEl && prevEl) {
                swiperConfig.navigation = { nextEl: nextEl, prevEl: prevEl };
            }
            if (paginationEl) {
                swiperConfig.pagination = { el: paginationEl, clickable: true };
            }

            new Swiper(slider, swiperConfig);
        }

        function toggleSliderBottom(swiperInstance, wrapper) {
            var container = wrapper ? wrapper.querySelector('.slider-bottom-cont') : null;
            if (!container) return;
            if (swiperInstance.isLocked) {
                container.classList.add('swiper-pagination-lock');
            } else {
                container.classList.remove('swiper-pagination-lock');
            }
        }

        if (typeof Swiper !== 'undefined') {
            initProjectSwiper();
        } else {
            window.addEventListener('load', initProjectSwiper);
        }
    })();
</script>