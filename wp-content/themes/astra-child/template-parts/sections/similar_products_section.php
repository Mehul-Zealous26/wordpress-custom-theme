<?php
// Robust unique ID generation to prevent duplicate ID conflicts on the same page
static $similar_products_instance = 0;
$similar_products_instance++;
$similar_products_unique_id = 'similar-products-' . $similar_products_instance . '-' . rand(100, 999);

global $template;
$current_id = isset($section_post_id) ? $section_post_id : get_the_ID();

$sections = get_field('page_sections', $current_id);

if (isset($template) && basename($template) === 'variation-detail.php') {
    $variation = wc_get_product($variation_id);
    $parent_id = $variation ? $variation->get_parent_id() : 0;
}

$enable_global_content = get_sub_field('enable_global_content');
$clone_parent = get_sub_field('clone_parent');
if ($enable_global_content) {
    $pretitle = get_field('similar_products_pretitle', 'option');
    $title = get_field('similar_products_title', 'option');
    $description = get_field('similar_products_description', 'option');
    $parent_products = get_field('similar_parent_products', 'option');
} else {
    if ($clone_parent) {
        if (have_rows('page_sections', $parent_id)):
            while (have_rows('page_sections', $parent_id)):
                the_row();
                $layout = get_row_layout();
                if ($layout === 'similar_products_section') {
                    $pretitle = get_sub_field('pretitle');
                    $title = get_sub_field('title');
                    $description = get_sub_field('description');
                    $parent_products = get_sub_field('parent_products');
                }
            endwhile;
        endif;
    } else {
        $pretitle = get_sub_field('pretitle');
        $title = get_sub_field('title');
        $description = get_sub_field('description');
        $parent_products = get_sub_field('parent_products');
    }
}

$select_spacer = get_sub_field('select_spacer');
$padding_style = get_spacer_padding_style($select_spacer);
?>
<section class="product-slider-section" id="similar_products_section" <?php if ($padding_style)
    echo 'style="' . esc_attr($padding_style) . '"'; ?>>
    <div class="container-box">
        <div class="sub-title-with-text w-600 text-content-section">
            <?php if ($pretitle) { ?>
                <div class="sub-heading">
                    <?php echo esc_html($pretitle); ?>
                </div>
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
    $products = is_array($parent_products) ? $parent_products : [$parent_products];
    $product_count = count($products);
    ?>
    <div class="prodct-cat-list product-slider-main"<?php echo $product_count > 4 ? ' more-than-4-slides-similar' : ''; ?> id="<?php echo esc_attr($similar_products_unique_id); ?>">
        <div class="product-slider-box similar-product-swiper swiper">
            <div class="swiper-wrapper">
                <?php
                if ($parent_products):
                    $products = is_array($parent_products) ? $parent_products : [$parent_products];
                    foreach ($products as $post_obj):
                        $product = wc_get_product($post_obj->ID);
                        if (!$product)
                            continue;

                        // Get main product image with fallback
                        $image_url = wp_get_attachment_image_url($product->get_image_id(), 'full');
                        if (!$image_url) {
                            $image_url = get_template_directory_uri() . '/assets/images/default-image.jpeg';
                        }
                        $models_count = $product->is_type('woosg') ? count(get_post_meta($post_obj->ID, 'woosg_ids', true) ?: []) : count($product->get_children());
                        $accessories_count = 0;
                        if (have_rows('page_sections', $post_obj->ID)) {
                            while (have_rows('page_sections', $post_obj->ID)) {
                                the_row();
                                if (get_row_layout() == 'related_accessories_section') {
                                    $accessories_product = get_sub_field('accessories_product_1');
                                    if ($accessories_product) {
                                        $accessories_count += is_array($accessories_product) ? count($accessories_product) : 1;
                                    }
                                }
                            }
                        }
                        ?>
                        <div class="product-box swiper-slide">
                            <a href="<?php echo esc_url(get_permalink($post_obj->ID)); ?>">
                                <div class="product-rang-img product-box-img js-square-ready">
                                    <?php
                                    if (has_term('new', 'product_tag', $post_obj->ID)) {
                                        echo '<div class="product-tag new-tag">New</div>';
                                    }
                                    ?>
                                    <img class="product-d-img" src="<?php echo esc_url($image_url); ?>"
                                        alt="<?php echo esc_attr($post_obj->post_title); ?>">
                                    <?php
                                    // Get hover image with fallback priority: gallery > feature > default
                                    $hover_image = '';
                                    $gallery_ids = $product->get_gallery_image_ids();

                                    if (!empty($gallery_ids)) {
                                        // Use first gallery image
                                        $hover_image = wp_get_attachment_image_url($gallery_ids[0], 'full');
                                    } else {
                                        // No gallery - use feature image
                                        $feature_image = wp_get_attachment_image_url($product->get_image_id(), 'full');
                                        if ($feature_image) {
                                            $hover_image = $feature_image;
                                        } else {
                                            // No feature image - use default
                                            $hover_image = get_template_directory_uri() . '/assets/images/default-image.jpeg';
                                        }
                                    }

                                    if ($hover_image) {
                                        echo '<img class="product-hover-img" src="' . esc_url($hover_image) . '" alt="' . esc_attr($post_obj->post_title) . '">';
                                    }
                                    ?>
                                </div>
                                <div class="Product-box-desc">
                                    <h5>
                                        <div class="product-custom-title"><?php echo esc_html($post_obj->post_title); ?></div>
                                    </h5>
                                    <hr>
                                    <p class="product-excerpt">
                                        <?php
                                        $excerpt = !empty($post_obj->post_excerpt)
                                            ? $post_obj->post_excerpt
                                            : wp_trim_words($post_obj->post_content, 20);

                                        echo esc_html(!empty(trim($excerpt)) ? $excerpt : 'No Content Available');
                                        ?>
                                    </p>
                                    <hr>
                                    <div class="product-box-available">
                                        <label>available</label>
                                        <div class="available-tags">
                                            <span><?php echo $models_count; ?> Models</span>
                                            <span><?php echo $accessories_count; ?> Accessories</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php
                    endforeach;
                endif;
                ?>
            </div>
            <?php
            $product_count = $parent_products ? count($parent_products) : 0;
            if ($product_count > 4): ?>
                <div class="slider-bottom-cont">
                    <div class="swiper-pagination similar-swiper-pagination-<?php echo esc_attr($similar_products_unique_id); ?>"></div>
                    <div class="sider-arrow-box">
                        <div class="swiper-button-prev similar-slider-prev-<?php echo esc_attr($similar_products_unique_id); ?> slider-arrow"></div>
                        <div class="swiper-button-next similar-slider-next-<?php echo esc_attr($similar_products_unique_id); ?> slider-arrow"></div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php if ($product_count > 4): ?>
<style>
@media (max-width: 767px) {
    .more-than-4-slides-similar .swiper-pagination {
        display: none !important;
    }
}
</style>
<?php endif; ?>
<script>
    (function () {
        var sliderId = '<?php echo esc_js($similar_products_unique_id); ?>';

        function initSimilarProductsSwiper() {
            var wrapper = document.getElementById(sliderId);
            if (!wrapper) return;

            var swiperEl = wrapper.querySelector('.product-slider-box');
            if (!swiperEl) return;
            if (swiperEl.classList.contains('swiper-initialized')) return;

            var nextEl = wrapper.querySelector('.similar-slider-next-' + sliderId);
            var prevEl = wrapper.querySelector('.similar-slider-prev-' + sliderId);
            var paginationEl = wrapper.querySelector('.similar-swiper-pagination-' + sliderId);

            var swiperConfig = {
                slidesPerView: 'auto',
                centeredSlides: false,
                grabCursor: true,
                loop: true,
                loopedSlides: 10,
                spaceBetween: 16,
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

            new Swiper(swiperEl, swiperConfig);
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
            initSimilarProductsSwiper();
        } else {
            window.addEventListener('load', initSimilarProductsSwiper);
        }
    })();
</script>