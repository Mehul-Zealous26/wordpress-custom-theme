<?php
// Robust unique ID generation to prevent duplicate ID conflicts on the same page
static $new_product_sku_instance = 0;
$new_product_sku_instance++;
$new_product_sku_unique_id = 'new-product-sku-' . $new_product_sku_instance . '-' . rand(100, 999);

$pre_title = get_sub_field('new_product_sku_pre_title');
$title = get_sub_field('new_product_sku_title');
$description = get_sub_field('new_product_sku_description');
$new_product_sku_slider = get_sub_field('new_product_sku_slider');
$select_spacer = get_sub_field('select_spacer');
$padding_style = get_spacer_padding_style($select_spacer);
?>

<section class="product-slider-section" id="new_product_sku_section" <?php if ($padding_style)
    echo 'style="' . esc_attr($padding_style) . '"'; ?> id="new_product_sku_section">
    <div class="container-box">
        <div class="sub-title-with-text w-600 text-content-section">
            <?php if ($pre_title): ?>
                <div class="sub-heading"><?php echo esc_html($pre_title); ?></div>

            <?php endif; ?>

            <?php if ($title): ?>
                <?php echo ($title); ?>

            <?php endif; ?>

            <?php if ($description): ?>
                <?php echo wp_kses_post($description); ?>

            <?php endif; ?>
        </div>
    </div>
    <?php if ($new_product_sku_slider):
          $products = is_array($new_product_sku_slider) ? $new_product_sku_slider : [$new_product_sku_slider];
                    $product_count = count($products); ?>
<div class="prodct-cat-list product-slider-main<?php echo $product_count > 4 ? ' more-than-4-slides-sku' : ''; ?>" id="<?php echo esc_attr($new_product_sku_unique_id); ?>">            <div class="product-slider-box swiper">
                <div class="swiper-wrapper">
                    <?php
                  

                    foreach ($products as $post_obj):
                        $product = wc_get_product($post_obj->ID);
                        if (!$product)
                            continue;

                        // Get featured image - for variations, get from parent product
                        $image_id = $product->get_image_id();
                        if (!$image_id && $product->is_type('variation')) {
                            $parent_product = wc_get_product($product->get_parent_id());
                            $image_id = $parent_product ? $parent_product->get_image_id() : 0;
                        }
                        $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'full') : get_template_directory_uri() . '/images/product-img.svg';

                        ?>
                        <div class="product-box swiper-slide">
                            <div class="product-rang-img product-box-img js-square-ready">
                                <a href="<?php echo esc_url(get_permalink($post_obj->ID)); ?>"
                                    class="product-rang-img product-box-img js-square-ready">
                                    <?php
                                    $new_tag = get_field('new_tag', $post_obj->ID);
                                    if ($new_tag): ?>
                                        <div class="product-tag new-tag"><?php echo esc_html($new_tag); ?></div>
                                    <?php endif; ?>
                                    <?php if ($image_url && $image_url !== get_template_directory_uri() . '/images/product-img.svg') { ?>
                                        <img class="product-d-img" src="<?php echo esc_url($image_url); ?>"
                                            alt="<?php echo esc_attr($post_obj->post_title); ?>">
                                        <img class="product-hover-img" src="<?php echo esc_url($image_url); ?>"
                                            alt="<?php echo esc_attr($post_obj->post_title); ?>">

                                    <?php } else {
                                        $default_image_url = get_template_directory_uri() . '/assets/images/default-image.jpeg';
                                        ?>
                                        <img class="product-d-img" src="<?php echo esc_url($default_image_url); ?>"
                                            alt="<?php echo esc_attr($post_obj->post_title); ?>">
                                        <img class="product-hover-img" src="<?php echo esc_url($default_image_url); ?>"
                                            alt="<?php echo esc_attr($post_obj->post_title); ?>">
                                    <?php } ?>
                                </a>
                            </div>
                            <div class="Product-box-desc">
                                <div class="product-list-title-box">
                                    <?php
                                    $product_item_code = get_field('product_item_code', $post_obj->ID);
                                    $variation_product_title = get_field('variation_product_title', $post_obj->ID);
                                    if ($product->is_type('variation')) {
                                        $parent_id = $product->get_parent_id();
                                        $parent_product = wc_get_product($parent_id);
                                        $clean_title = $parent_product ? $parent_product->get_title() : $product->get_title();
                                    } else {
                                        // For simple products use normal title
                                        $clean_title = $product->get_title();
                                    }
                                    ?>
                                    <div class="product-list-sub-title">
                                        <?php echo esc_html($product_item_code ?: '-'); ?>
                                    </div>
                                    <h5>
                                        <a href="<?php echo esc_url(get_permalink($post_obj->ID)); ?>"
                                            class="product-custom-title">
                                            <?php
                                            echo esc_html(
                                                !empty($variation_product_title)
                                                ? $variation_product_title
                                                : $clean_title
                                            );
                                            ?>
                                        </a>
                                </div>
                                <hr>
                                <div class="product-list-var-col">
                                    <div class="product-list-var-title">SKU:</div>
                                    <div class="product-list-var-detail">
                                        <span>
                                            <?php echo esc_html(!empty($product) && $product->get_sku() ? $product->get_sku() : '-'); ?>
                                        </span>
                                    </div>
                                </div>
                                <?php
                                // 1. ACF selected attributes (clean slugs: color, sizing, weight, etc.)
                                $selected_attributes = get_sub_field('custom_attributes');
                                $selected_attributes = is_array($selected_attributes) ? $selected_attributes : [];

                                // 2. Get all product attributes
                                $all_attrs = $product->get_attributes();

                                foreach ($selected_attributes as $slug):

                                    // Determine if this is a taxonomy attribute or custom text
                                    $taxonomy = taxonomy_exists('pa_' . $slug) ? 'pa_' . $slug : $slug;

                                    // Get proper label
                                    $label = taxonomy_exists($taxonomy) ? wc_attribute_label($taxonomy) : ucfirst($slug);
                                    /** -------------------------------
                                     * COLOR HANDLER
                                     * ------------------------------- */
                                    if ($taxonomy === 'pa_colour') {

                                        // Get SKU-specific color slugs
                                        $variation_attributes = $product->get_attributes();
                                        $color_slugs = [];
                                        if (isset($variation_attributes['pa_colour'])) {
                                            $attr = $variation_attributes['pa_colour'];
                                            if (is_object($attr) && $attr->is_taxonomy()) {
                                                $color_slugs = wp_get_post_terms($product->get_id(), 'pa_colour', ['fields' => 'slugs']);
                                            } else {
                                                $color_slugs = is_array($attr) ? $attr : [$attr];
                                            }
                                        }

                                        ?>
                                        <hr>
                                        <div class="product-list-var-col">
                                            <div class="product-list-var-title"><?php echo esc_html($label); ?>:</div>
                                            <div class="product-list-var-detail">
                                                <span>
                                                    <?php
                                                    // Remove empty / null / false values
                                                    $color_slugs = array_filter($color_slugs);

                                                    if (!empty($color_slugs)) {
                                                        foreach ($color_slugs as $color_slug) {

                                                            $color_term = get_term_by('slug', $color_slug, 'pa_colour');
                                                            if ($color_term) {
                                                                $color_name = $color_term->name;
                                                                $color_hex = get_field('color_palette', $color_term) ?: '#cccccc';
                                                                ?>
                                                                <i class="product-list-var-color"
                                                                    style="background-color: <?php echo esc_attr($color_hex); ?>;"></i>
                                                                <?php echo esc_html($color_name); ?>
                                                                <?php
                                                            }
                                                        }
                                                    } else {
                                                        echo '-';
                                                    }
                                                    ?>

                                                </span>
                                            </div>
                                        </div>
                                        <?php

                                        continue;
                                    }


                                    /** -------------------------------
                                     * GET ATTRIBUTE VALUE
                                     * ------------------------------- */
                                    $attribute_obj = $all_attrs[$taxonomy] ?? null;
                                    $value = '-'; // default
                                    if (is_object($attribute_obj) && method_exists($attribute_obj, 'is_taxonomy') && $attribute_obj->is_taxonomy()) {
                                        // Global taxonomy attribute — get term names, not slugs
                                        $terms = wc_get_product_terms($product->get_id(), $taxonomy, ['fields' => 'names']);
                                        $value = !empty($terms) ? implode(', ', $terms) : '-';
                                    } else {
                                        // Custom text attribute
                                        if ($attribute_obj) {
                                            $value = is_array($attribute_obj) ? implode(', ', $attribute_obj) : $attribute_obj;

                                            // Optional: replace "-" or other slug characters with spaces for readability
                                            $value = str_replace(['-', '_'], [' ', ' '], $value);

                                            // Optional: add formatting for Sizing specifically
                                            if ($slug === 'sizing') {
                                                // Example: "150cmw-x-200cmh" → "150cm (w) x 200cm (h)"
                                                $value = str_replace(['w', 'h', '-x-'], ['(w)', '(h)', ' x '], $value);
                                            }
                                        }
                                        if (!$value)
                                            $value = '-';
                                    }

                                    ?>

                                    <hr>
                                    <div class="product-list-var-col">
                                        <div class="product-list-var-title"><?php echo esc_html($label); ?>:</div>
                                        <div class="product-list-var-detail">
                                            <span><?php echo esc_html($value); ?></span>
                                        </div>
                                    </div>

                                <?php endforeach; ?>




                                <hr>
                                <?php if (is_user_logged_in()): ?>
                                    <div class="product-list-var-col">
                                        <div class="product-list-var-title">Stock:</div>
                                        <div class="product-list-var-detail">
                                            <?php
                                            if ($product->is_on_backorder()) {
                                                $stock_status = 'back-order';
                                                $stock_text = 'BACK ORDER';
                                            } elseif ($product->is_in_stock()) {
                                                $stock_status = 'in-stock';
                                                $stock_text = 'In stock';
                                            } elseif ($product->backorders_allowed()) {
                                                $stock_status = 'back-order';
                                                $stock_text = 'BACK ORDER';
                                            } else {
                                                $stock_status = 'out-of-stock';
                                                $stock_text = 'Out of stock';
                                            }
                                            ?>
                                            <div class="product-list-var-stock-tag <?php echo esc_attr($stock_status); ?>">
                                                <i></i><?php echo esc_html($stock_text); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="product-list-var-col">
                                        <div class="product-list-var-title">Price: <span>(Excl GST)</span></div>
                                        <div class="product-list-var-detail">
                                            <span>
                                                <?php
                                                $price = $product->get_price();
                                                echo !empty($price)
                                                    ? esc_html(get_woocommerce_currency_symbol() . number_format((float) $price, 2))
                                                    : '-';
                                                ?>
                                            </span>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="prodct-cat-list-btn">
                                <?php
                                $parent_id = $product->get_parent_id();
                                ?>

                                <a href="<?php echo get_permalink($parent_id); ?>"
                                    class="btn btn-sm secondary-btn double-right-btn">
                                    View Product Family Page
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/double-right-black-new.svg"
                                        alt="Button Arrow">
                                </a>

                                <a href="<?php echo get_permalink($product->get_id()); ?>"
                                    class="btn btn-sm primary-btn double-right-btn">
                                    View SKU Page <img
                                        src="<?php echo get_template_directory_uri(); ?>/assets/images/double-right-white-new.svg"
                                        alt="Button Arrow">
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php if ($product_count > 4): ?>
                    <div class="slider-bottom-cont">
                        <div class="swiper-pagination sku-swiper-pagination-<?php echo esc_attr($new_product_sku_unique_id); ?>"></div>
                        <div class="sider-arrow-box">
                            <div class="swiper-button-prev sku-slider-prev-<?php echo esc_attr($new_product_sku_unique_id); ?> slider-arrow"></div>
                            <div class="swiper-button-next sku-slider-next-<?php echo esc_attr($new_product_sku_unique_id); ?> slider-arrow"></div>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    <?php endif; ?>

</section>
<?php if ($product_count > 4): ?>
<style>
@media (max-width: 767px) {
    .more-than-4-slides-sku .swiper-pagination {
        display: none !important;
    }
}
</style>
<?php endif; ?>
<script>
    (function () {
        var sliderId = '<?php echo esc_js($new_product_sku_unique_id); ?>';

        function initSkuSwiper() {
            var wrapper = document.getElementById(sliderId);
            if (!wrapper) return;

            var swiperEl = wrapper.querySelector('.product-slider-box');
            if (!swiperEl) return;
            if (swiperEl.classList.contains('swiper-initialized')) return;

            var nextEl = wrapper.querySelector('.sku-slider-next-' + sliderId);
            var prevEl = wrapper.querySelector('.sku-slider-prev-' + sliderId);
            var paginationEl = wrapper.querySelector('.sku-swiper-pagination-' + sliderId);

            var swiperConfig = {
                slidesPerView: 'auto',
                centeredSlides: false,
                grabCursor: true,
                loop: true,
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
            initSkuSwiper();
        } else {
            window.addEventListener('load', initSkuSwiper);
        }
    })();
</script>