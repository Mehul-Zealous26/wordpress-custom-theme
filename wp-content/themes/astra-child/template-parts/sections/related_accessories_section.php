<?php
$pre_title     = get_sub_field('accessories_pre_title');
$title         = get_sub_field('accessories_title');
$description   = get_sub_field('accessories_description');
$product       = get_sub_field('accessories_product_1');
$select_spacer = get_sub_field('select_spacer');
$padding_style = get_spacer_padding_style($select_spacer);

if (!empty($product)) :
?>
    <section class="sku-var-section" id="related_accessories_section" <?php if ($padding_style) echo 'style="' . esc_attr($padding_style) . '"'; ?>>
        <div class="container-box">
            <div class="sub-title-with-text w-600 text-content-section">
                <?php if ($pre_title) : ?>
                    <div class="sub-heading"><?php echo esc_html($pre_title); ?></div>
                <?php else : ?>
                    <div class="sub-heading">Products</div>
                <?php endif; ?>

                <?php if ($title) : ?>
                    <div class="title-count-box"><?php echo ($title); ?></div>
                <?php endif; ?>

                <?php if ($description) : ?>
                    <?php echo ($description); ?>
                <?php endif; ?>
            </div>

            <div class="prodct-cat-list modal-var-list">
                <?php
                $products = is_array($product) ? $product : [$product];

                foreach ($products as $single_product) :
                    $wc_product = wc_get_product($single_product->ID);
                    if (!$wc_product) continue;

                    $is_variation = $wc_product->get_type() === 'variation';
                    $product_id   = $wc_product->get_id();
                    $product_sku  = trim((string) $wc_product->get_sku());
                    $has_valid_sku = !empty($product_sku);
                    $parent_id    = $is_variation ? $wc_product->get_parent_id() : $product_id;

                    // -------------------------
                    // VARIATION URL
                    // -------------------------
                    if ($is_variation) {
                        $url_params = [];
                        foreach ($wc_product->get_attributes() as $att_key => $att_value) {
                            $url_params['attribute_' . $att_key] = $att_value;
                        }
                        $variation_url = add_query_arg($url_params, get_permalink($parent_id));
                    } else {
                        $variation_url = get_permalink($product_id);
                    }

                    // -------------------------
                    // VARIATION TITLE
                    // -------------------------
                    if ($is_variation) {
                        $variation_title = get_field('variation_product_title', $product_id);
                        if (!$variation_title) {
                            $variation_title = get_the_title($parent_id);
                        }
                    } else {
                        $variation_title = get_the_title($product_id);
                    }

                    // -------------------------
                    // IMAGE
                    // -------------------------
                    $image_url = wp_get_attachment_image_url($wc_product->get_image_id(), 'full');
                    if (!$image_url) {
                        $image_url = get_the_post_thumbnail_url($parent_id, 'full');
                    }
                    if (!$image_url) {
                        $image_url = get_template_directory_uri() . '/assets/images/default-image.jpeg';
                    }

                    // -------------------------
                    // CART STATUS
                    // -------------------------
                    $in_cart  = 'no';
                    $cart_qty = 1;
                    $cart_key = '';

                    if (WC()->cart && !empty(WC()->cart->get_cart())) {
                        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                            if ((int)$cart_item['variation_id'] === (int)$product_id || (int)$cart_item['product_id'] === (int)$product_id) {
                                $in_cart  = 'yes';
                                $cart_qty = $cart_item['quantity'];
                                $cart_key = $cart_item_key;
                                break;
                            }
                        }
                    }

                    // -------------------------
                    // STOCK
                    // -------------------------
                    if ($wc_product->is_on_backorder()) {
                        $stock_status = 'back-order';
                        $stock_text   = 'BACK ORDER';
                    } elseif ($wc_product->is_in_stock()) {
                        $stock_status = 'in-stock';
                        $stock_text   = 'In stock';
                    } elseif ($wc_product->backorders_allowed()) {
                        $stock_status = 'back-order';
                        $stock_text   = 'BACK ORDER';
                    } else {
                        $stock_status = 'out-of-stock';
                        $stock_text   = 'Out of stock';
                    }

                    // -------------------------
                    // PRICE & ITEM CODE
                    // -------------------------
                    $price             = wc_price($wc_product->get_price());
                    $product_item_code = get_field('product_item_code', $product_id) ?: get_field('product_item_code', $parent_id);
                ?>

                    <div class="product-box">

                        <div class="product-rang-img product-box-img">
                            <?php if (is_user_logged_in() && $in_cart === 'no' && $has_valid_sku): ?>
                                <div class="wishlist-icon-box" data-sku="<?php echo esc_attr($product_sku); ?>">
                                    <span></span>
                                </div>
                            <?php endif; ?>
                            <a href="<?php echo esc_url($variation_url); ?>">
                                <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($variation_title); ?>">
                            </a>
                        </div>

                        <div class="Product-box-desc">
                            <div class="product-list-title-box">
                                <div class="product-list-sub-title"><?php echo esc_html($product_item_code ?: '-'); ?></div>
                                <h5>
                                    <a href="<?php echo esc_url($variation_url); ?>">
                                        <div class="product-custom-title"><?php echo esc_html($variation_title); ?></div>
                                    </a>
                                </h5>
                            </div>

                            <hr>

                            <div class="product-list-var-col">
                                <div class="product-list-var-title">SKU:</div>
                                <div class="product-list-var-detail">
                                    <span><?php echo esc_html($has_valid_sku ? $product_sku : 'N/A'); ?></span>
                                </div>
                            </div>

                            <?php if (is_user_logged_in()): ?>
                                <hr>
                                <div class="product-list-var-col">
                                    <div class="product-list-var-title">Stock:</div>
                                    <div class="product-list-var-detail">
                                        <div class="product-list-var-stock-tag <?php echo esc_attr($stock_status); ?>">
                                            <i></i><?php echo esc_html($stock_text); ?>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="product-list-var-col">
                                    <div class="product-list-var-title">Price: <span>(Excl GST)</span></div>
                                    <div class="product-list-var-detail">
                                        <span><?php echo wp_kses_post($price); ?></span>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <?php if (is_user_logged_in()): ?>
                            <div class="prodct-cat-list-btn"
                                data-product-id="<?php echo esc_attr($product_id); ?>"
                                data-cart-key="<?php echo esc_attr($cart_key); ?>"
                                data-in-cart="<?php echo esc_attr($in_cart); ?>">

                                <a href="#"
                                    class="btn btn-sm secondary-btn double-right-btn plus-icon add-to-cart-trigger <?php echo (!$has_valid_sku || ($wc_product->get_stock_status() === 'outofstock' && !$wc_product->backorders_allowed())) ? 'disabled' : ''; ?>"
                                    data-variation-id="<?php echo esc_attr($product_id); ?>">
                                    Add to order
                                    <span>
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/plus-gray.svg" alt="Plus icon">
                                    </span>
                                </a>

                                <div class="add-cart-box add-cart-sm" style="display:none;">
                                    <a href="#" class="icon-box remove-from-cart">
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/trash-red-icon.svg" alt="Trash Icon">
                                    </a>
                                    <div class="number-input-box">
                                        <input type="number" class="quantity-input" value="<?php echo esc_attr($cart_qty); ?>" min="1" max="10">
                                    </div>
                                </div>

                            </div>
                        <?php endif; ?>

                    </div><!-- .product-box -->

                <?php endforeach; ?>
            </div><!-- .prodct-cat-list -->
        </div><!-- .container-box -->
    </section>
<?php endif; ?>