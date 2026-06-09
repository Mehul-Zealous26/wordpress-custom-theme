<?php
$hotspot_image_slider = get_sub_field('hotspot_image');
$enable_hotspot = get_sub_field('enable_hotspot');
$view_type = get_sub_field('view_type') ? get_sub_field('view_type') : 'slider';

// Robust unique ID generation to prevent duplicate ID conflicts on the same page
static $hotspot_slider_instance = 0;
$hotspot_slider_instance++;
$unique_id = 'hotspot-slider-' . $hotspot_slider_instance . '-' . rand(100, 999);

$select_spacer = get_sub_field('select_spacer');
$padding_style = get_spacer_padding_style($select_spacer);
$gallery_title = get_sub_field('title');
$gallery_pre_title = get_sub_field('pre_title');

// Check if more than 4 slides are present
$has_many_slides = is_array($hotspot_image_slider) && count($hotspot_image_slider) > 4;
?>

<?php if ($hotspot_image_slider): ?>
    <style>
    @media (max-width: 767px) {
        .more-than-4-slides .swiper-pagination {
            display: none !important;
        }
    }
    </style>
    <section class="hotspot-section hotspot-layout-<?php echo esc_attr($view_type); ?>"
        data-hotspot-layout="acf-<?php echo esc_attr($view_type); ?>"
        data-enable-hotspot="<?php echo $enable_hotspot ? '1' : '0'; ?>" id="hotspot_image_slider_<?php echo esc_attr($unique_id); ?>">

        <?php if ($view_type === 'gallery'): ?>
            <div class="hotspot-gallery-box" <?php if ($padding_style)
                echo 'style="' . esc_attr($padding_style) . '"'; ?>>
                <div class="container-box">
                    <div class="sub-title-with-text w-600 text-content-section">
                        <?php if ($gallery_pre_title): ?>
                            <div class="sub-heading">
                                <?php echo esc_html($gallery_pre_title); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($gallery_title): ?>

                            <?php echo ($gallery_title); ?>

                        <?php endif; ?>
                    </div>
                    <?php
                    $index = 0;
                    foreach ($hotspot_image_slider as $slide):
                        $image = $slide['upload_image'];
                        if ($image):
                            ?>
                            <div class="hotspot-gallery-item">
                                <div class="hotspot-image-wrap hotspot-image-wrapper" data-slide-index="<?php echo esc_attr($index); ?>"
                                    data-image="<?php echo esc_attr($image['url']); ?>" style="position: relative;">
                                    <img class="hotspot-image" src="<?php echo esc_url($image['url']); ?>"
                                        alt="<?php echo esc_attr($image['alt']); ?>" data-image="<?php echo esc_attr($image['url']); ?>"
                                        style="width: 100%; height: auto; display: block;">
                                    <?php
                                    // Render hotspots if enabled and class exists
                                    if ($enable_hotspot && class_exists('Hotspot_ACF_Bridge')) {
                                        // Get layout context for unique key matching
                                        // Use the actual layout name, not get_row_layout() which might be wrong
                                        $layout_name = 'hotspot_image_slider';
                                        // Get the flexible content row index (1-based, convert to 0-based)
                                        $layout_index = get_row_index() - 1;
                                        // Image index within the repeater (0-based)
                                        echo Hotspot_ACF_Bridge::render_hotspots($image['url'], null, $layout_name, $layout_index, $index);
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                            $index++;
                        endif;
                    endforeach;
                    ?>
                </div>
            </div>
            <?php if (current_user_can('edit_posts') && $enable_hotspot): ?>
                <button type="button" id="add-hotspot-button" class="add-hotspot-btn" style="display:none;">
                    + Add Hotspot
                </button>
            <?php endif; ?>

        <?php else: ?>
            <div class="hotspot-sider hotspot-sider-1<?php echo $has_many_slides ? ' more-than-4-slides' : ''; ?>" id="<?php echo esc_attr($unique_id); ?>">
                <div class="hotspot-sider-box swiper">
                    <div class="swiper-wrapper">
                        <?php
                        $index = 0;
                        foreach ($hotspot_image_slider as $slide):
                            $image = $slide['upload_image'];
                            if ($image):
                                ?>
                                <div class="swiper-slide">
                                    <div class="hotspot-image-wrap hotspot-image-wrapper"
                                        data-slide-index="<?php echo esc_attr($index); ?>"
                                        data-image="<?php echo esc_attr($image['url']); ?>">
                                        <img class="hotspot-image" src="<?php echo esc_url($image['url']); ?>"
                                            alt="<?php echo esc_attr($image['alt']); ?>"
                                            data-image="<?php echo esc_attr($image['url']); ?>">
                                        <?php
                                        // Render hotspots if enabled and class exists
                                        if ($enable_hotspot && class_exists('Hotspot_ACF_Bridge')) {
                                            // Get layout context for unique key matching
                                            // Use the actual layout name, not get_row_layout() which might be wrong
                                            $layout_name = 'hotspot_image_slider';
                                            // Get the flexible content row index (1-based, convert to 0-based)
                                            $layout_index = get_row_index() - 1;
                                            // Image index within the repeater (0-based)
                                            echo Hotspot_ACF_Bridge::render_hotspots($image['url'], null, $layout_name, $layout_index, $index);
                                        }
                                        ?>
                                    </div>
                                </div>

                                <?php
                                $index++;
                            endif;
                        endforeach;
                        ?>
                    </div>
                    <div class="slider-bottom-cont hotspot-slider">
                        <div class="swiper-pagination"></div>
                        <div class="sider-arrow-box">
                            <div class="swiper-button-prev product-slider-prev slider-arrow"></div>
                            <div class="swiper-button-next product-slider-next slider-arrow"></div>
                        </div>
                    </div>

                    <?php if (current_user_can('edit_posts') && $enable_hotspot): ?>
                        <!-- Admin-only button - single button for all images -->
                        <button type="button" id="add-hotspot-button" class="add-hotspot-btn" style="display:none;">
                            + Add Hotspot
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </section>
<?php endif; ?>

<script>
    (function () {
        function initSlider() {
            const sliderId = '<?php echo esc_js($unique_id); ?>';
            const swiperEl = document.querySelector('#' + sliderId + ' .hotspot-sider-box');

            if (!swiperEl) return;
            if (swiperEl.classList.contains('swiper-initialized')) return; // Avoid double initialization

            const swiper = new Swiper(swiperEl, {
                slidesPerView: 1,
                centeredSlides: false,
                grabCursor: true,
                loop: false,
                spaceBetween: 0,

                navigation: {
                    nextEl: '#' + sliderId + ' .product-slider-next',
                    prevEl: '#' + sliderId + ' .product-slider-prev',
                },

                pagination: {
                    el: '#' + sliderId + ' .swiper-pagination',
                    clickable: true,
                },

                breakpoints: {
                    768: {
                        slidesPerView: 1.5,
                        spaceBetween: 0,
                    }
                },

                speed: 800
            });
        }

        if (typeof Swiper !== 'undefined') {
            initSlider();
        } else {
            window.addEventListener('load', initSlider);
        }
    })();
</script>