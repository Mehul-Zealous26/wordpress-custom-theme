<?php
$layout_style = get_sub_field('layout_style'); //product-animation : Product Animation, project-animation : Project Animation
$background_image = get_sub_field('background_image'); //type=image, return format=array
$bg_url = !empty($background_image['url']) ? $background_image['url'] : '';
$product_animation_pretitle = get_sub_field('product_animation_pretitle');
$product_animation_title = get_sub_field('product_animation_title');
$description = get_sub_field('description');
$primary_button = get_sub_field('primary_button');
$secondary_button = get_sub_field('secondary_button');
$first_animation_image = get_sub_field('first_animation_image');
$second_animation_image = get_sub_field('second_animation_image');
$parent_product = get_sub_field('parent_product'); //type=post-object, filter-by-post-type=product
$child_product = get_sub_field('child_product');
$project_animation_pretitle = get_sub_field('project_animation_pretitle');
$project_animation_title = get_sub_field('project_animation_title');
$first_project_card = get_sub_field('first_project_card'); //type=post-object, post_type=project_nd_casestudy, single select 
$second_project_card = get_sub_field('second_project_card'); //type=post-object, post_type=project_nd_casestudy, single select 
$project_center_image = get_sub_field('project_center_image');
$select_spacer = get_sub_field('select_spacer');
$padding_style = get_spacer_padding_style($select_spacer);
?>
<?php if ($layout_style === 'product-animation'): ?>
    <section class="product-animation" id="product_hero_animation"
        style="background: url('<?php echo esc_url($bg_url); ?>') center no-repeat; background-size: cover; <?php echo esc_attr($padding_style); ?>">
        <div class="container-box">
            <div class="product-animation-left">
                <div class="sub-title-with-text text-content-section">
                    <?php if (!empty($product_animation_pretitle)): ?>
                        <div class="sub-heading">
                            <?php echo esc_html($product_animation_pretitle); ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty(trim($product_animation_title))): ?>
                        <?php echo ($product_animation_title); ?>
                    <?php endif; ?>
                    <?php if (!empty(trim($description))): ?>
                        <div>
                            <?php echo ($description); ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($primary_button) || !empty($secondary_button)): ?>
                        <div class="button-box">

                            <?php if (!empty($primary_button['url']) && !empty($primary_button['title'])):
                                $target = !empty($primary_button['target']) ? $primary_button['target'] : '_self';
                            ?>
                                <a href="<?php echo esc_url($primary_button['url']); ?>" target="<?php echo esc_attr($target); ?>"
                                    rel="<?php echo ($target === '_blank') ? 'noopener noreferrer' : ''; ?>" class="btn trans-btn">
                                    <?php echo esc_html($primary_button['title']); ?>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($secondary_button['url']) && !empty($secondary_button['title'])):
                                $target = !empty($secondary_button['target']) ? $secondary_button['target'] : '_self';
                            ?>
                                <a href="<?php echo esc_url($secondary_button['url']); ?>" target="<?php echo esc_attr($target); ?>"
                                    rel="<?php echo ($target === '_blank') ? 'noopener noreferrer' : ''; ?>"
                                    class="btn secondary-btn">
                                    <?php echo esc_html($secondary_button['title']); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="product-animation-right">
                <img class="animation-img1" src="<?php echo esc_url($first_animation_image['url']); ?>" alt="Image">
                <img class="animation-img2" src="<?php echo esc_url($second_animation_image['url']); ?>" alt="Image">
                <?php
                $parent_product = get_sub_field('parent_product'); // Post Object (product)

                if ($parent_product):

                    $product_id = $parent_product->ID;
                    $product = wc_get_product($product_id);

                    if (!$product)
                        return;

                    $product_title = $product->get_name();
                    $product_link = get_permalink($product_id);
                    $product_excerpt = get_the_excerpt($product_id);

                    // Featured image (fallback included)
                    $featured_img = get_the_post_thumbnail(
                        $product_id,
                        'medium',
                        ['class' => 'product-d-img']
                    );

                    if (!$featured_img) {
                        $featured_img = '<img class="product-d-img" src="' .
                            esc_url(get_template_directory_uri() . '/assets/images/default-image.jpeg') .
                            '" alt="' . esc_attr($product_title) . '">';
                    }

                    // Hover image (first gallery image)
                    $hover_img = '';
                    $gallery_ids = $product->get_gallery_image_ids();
                    if (!empty($gallery_ids)) {
                        $hover_img = wp_get_attachment_image($gallery_ids[0], 'full', false, [
                            'class' => 'product-hover-img'
                        ]);
                    }

                    // Models count
                    $models_count = $product->is_type('woosg')
                        ? count(get_post_meta($product_id, 'woosg_ids', true) ?: [])
                        : count($product->get_children());

                    // Accessories count
                    $accessories_count = 0;
                    if (have_rows('page_sections', $product_id)) {
                        while (have_rows('page_sections', $product_id)) {
                            the_row();
                            if (get_row_layout() === 'related_accessories_section') {
                                $accessories_product = get_sub_field('accessories_product_1');
                                if ($accessories_product) {
                                    $accessories_count += is_array($accessories_product)
                                        ? count($accessories_product)
                                        : 1;
                                }
                            }
                        }
                    }
                ?>

                    <div class="product-box pre-product">
                        <a href="<?php echo esc_url($product_link); ?>">
                            <div class="product-rang-img product-box-img">
                                <?php if (has_term('new', 'product_tag', $product_id)): ?>
                                    <div class="product-tag new-tag">New</div>
                                <?php endif; ?>
                                <?php echo $featured_img; ?>
                                <?php if ($hover_img)
                                    echo $hover_img; ?>
                            </div>

                            <div class="Product-box-desc">
                                <h5><?php echo esc_html($product_title); ?></h5>
                                <hr>
                                <p>
                                    <?php echo esc_html($product_excerpt ? wp_trim_words($product_excerpt, 18, '...') : 'NA'); ?>
                                </p>
                                <hr>
                                <div class="product-box-available">
                                    <label>available</label>

                                    <div class="available-tags">
                                        <span><?php echo esc_html($models_count); ?> Models</span>
                                        <span><?php echo esc_html($accessories_count); ?> Accessories</span>
                                    </div>
                                </div>
                            </div>

                        </a>
                    </div>

                <?php endif; ?>
                <!--For Sku-->
                <?php
                // $child_product = get_sub_field('child_product'); // Post Object (product variation)
                if ($child_product && $child_product->post_type === 'product_variation'):
                    $variation_obj = wc_get_product($child_product->ID);
                    if ($variation_obj):
                        $variation_id = $variation_obj->get_id();
                        $variation_sku = $variation_obj->get_sku();
                        $variation_image = wp_get_attachment_image_url($variation_obj->get_image_id(), 'full');
                        $parent_id = $variation_obj->get_parent_id();

                        if (!$variation_image) {
                            $parent_img = wp_get_attachment_image_url(get_post_thumbnail_id($parent_id), 'full');
                            $variation_image = $parent_img ?: get_template_directory_uri() . '/assets/images/default-image.jpeg';
                        }

                        if ($variation_obj->is_on_backorder()) {
                            $stock_status = 'back-order';
                            $stock_label = 'BACK ORDER';
                        } elseif ($variation_obj->is_in_stock()) {
                            $stock_status = 'in-stock';
                            $stock_label = 'In stock';
                        } elseif ($variation_obj->backorders_allowed()) {
                            $stock_status = 'back-order';
                            $stock_label = 'BACK ORDER';
                        } else {
                            $stock_status = 'out-of-stock';
                            $stock_label = 'Out of stock';
                        }
                        $custom_title = get_field('variation_product_title', $variation_id);
                        $final_title = $custom_title ?: get_the_title($parent_id);
                        $product_item_code = get_field('product_item_code', $parent_id);
                        $sizing = get_field('sizing', $variation_id);

                        $url_params = [];
                        foreach ($variation_obj->get_attributes() as $att_key => $att_value) {
                            $url_params['attribute_' . $att_key] = sanitize_title(str_replace(['–', '—', ' '], '-', $att_value));
                        }
                        $sku_url = add_query_arg($url_params, get_permalink($parent_id));
                        // Check if variation has its own unique SKU (not falling back to parent)
                        // $has_own_sku = !empty($variation_sku) && $variation_sku !== $parent_sku;
                ?>
                        <div class="product-box product-sku-anima">
                            <div class="product-rang-img product-box-img" style="height: 182.578px;">
                                <?php // if (is_user_logged_in() && $in_cart === 'no' && $has_own_sku): 
                                ?>
                                <div class="wishlist-icon-box" data-sku="<?php echo esc_attr($variation_sku); ?>">
                                    <i></i>
                                </div>
                                <?php // endif; 
                                ?>
                                <img src="<?php echo esc_url($variation_image); ?>" alt="<?php echo esc_attr($final_title); ?>">
                            </div>
                            <div class="Product-box-desc">
                                <div class="product-list-title-box">
                                    <div class="product-list-sub-title"><?php echo esc_html($product_item_code ?: 'NA'); ?></div>
                                    <h5><?php echo esc_html($final_title); ?></h5>
                                </div>
                                <hr>
                                <div class="product-list-var-col">
                                    <div class="product-list-var-title">SKU:</div>
                                    <div class="product-list-var-detail">
                                        <span><?php echo esc_html($variation_sku ?: 'NA'); ?></span>
                                    </div>
                                </div>
                                <hr>
                                <?php if ($sizing): ?>
                                    <div class="product-list-var-col">
                                        <div class="product-list-var-title">Sizing:</div>
                                        <div class="product-list-var-detail">
                                            <span><?php echo esc_html($sizing); ?></span>
                                        </div>
                                    </div>
                                    <hr>
                                <?php endif; ?>
                                <div class="product-list-var-col">
                                    <div class="product-list-var-title">Stock:</div>
                                    <div class="product-list-var-detail">
                                        <div class="product-list-var-stock-tag <?php echo esc_attr($stock_status); ?>">
                                            <i></i><?php echo esc_html($stock_label); ?>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="product-list-var-col">
                                    <div class="product-list-var-title">Price: <span>(Excl GST)</span></div>
                                    <div class="product-list-var-detail">
                                        <span><?php echo get_woocommerce_currency_symbol() . number_format($variation_obj->get_price(), 2); ?></span>
                                    </div>
                                </div>
                            </div>
                            <?php
                            // Check if item is in cart
                            $in_cart = 'no';
                            $cart_qty = 1;
                            if (WC()->cart && !empty(WC()->cart->get_cart())) {
                                foreach (WC()->cart->get_cart() as $cart_item) {
                                    if ($cart_item['data']->get_sku() === $variation_sku) {
                                        $in_cart = 'yes';
                                        $cart_qty = $cart_item['quantity'];
                                        break;
                                    }
                                }
                            }
                            ?>
                            <div class="prodct-cat-list-btn" data-variation-id="<?php echo esc_attr($variation_id); ?>"
                                data-in-cart="<?php echo esc_attr($in_cart); ?>">
                                <a href="#"
                                    class="btn btn-xs secondary-btn double-right-btn plus-icon add-to-cart-trigger <?php echo (empty($variation_sku) || (!$variation_obj->is_in_stock() && !$variation_obj->backorders_allowed())) ? 'disabled' : ''; ?>"
                                    data-variation-id="<?php echo esc_attr($variation_id); ?>">
                                    Add to order
                                    <span><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/plus-gray.svg"
                                            alt="Plus icon"></span>
                                </a>
                                <div class="add-cart-box add-cart-sm" style="display:none;">
                                    <a href="#" class="icon-box remove-from-cart"><img
                                            src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/trash-red-icon.svg"
                                            alt="Trash Icon"></a>
                                    <div class="number-input-box">
                                        <input type="number" class="quantity-input" value="<?php echo esc_attr($cart_qty); ?>"
                                            min="1" max="10">
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php endif;
                endif; ?>
            </div>
        </div>
    </section>
<?php elseif ($layout_style === 'project-animation'): ?>
    <section class="project-animation" style="<?php echo esc_attr($padding_style); ?>">
        <div class="container-box">
            <div class="sub-title-with-text w-600 text-content-section">
                <?php if (!empty($project_animation_pretitle)): ?>
                    <div class="sub-heading">
                        <?php echo esc_html($project_animation_pretitle); ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($project_animation_title)): ?>

                    <?php echo ($project_animation_title); ?>

                <?php endif; ?>
            </div>
            <div class="project-animation-box">
                <div class="project-animation-left">
                    <?php
                    // $first_project_card = get_sub_field('first_project_card');

                    if ($first_project_card):
                        $post_id = $first_project_card->ID;

                        $permalink = get_permalink($post_id);
                        $title = get_the_title($post_id);
                        $thumbnail = get_the_post_thumbnail_url($post_id, 'full');

                        // Example ACF fields (adjust names as needed)
                        $client_name = get_field('client_name', $post_id);
                        $location = get_field('location', $post_id);
                        $project_categories = get_the_terms($post_id, 'projects_categories');
                    ?>

                        <div class="project-section-box">
                            <a href="<?php echo esc_url($permalink); ?>">
                                <div class="project-img-tag">
                                    <?php if ($thumbnail): ?>
                                        <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr($title); ?>">
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
                                    <h3><?php echo esc_html($title); ?></h3>

                                    <?php
                                    $locations = get_the_terms($post_id, 'location');
                                    $company_name = get_field('company_name_value', $post_id);
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

                    <?php endif; ?>
                </div>
                <?php if (!empty($project_center_image)): ?>
                    <div class="project-animation-item">
                        <img src="<?php echo esc_url($project_center_image['url']); ?>"
                            alt="<?php echo esc_attr($project_center_image['alt'] ?? 'Banner Image'); ?>">
                    </div>
                <?php endif; ?>
                <div class="project-animation-right">
                    <?php
                    $second_project_card = get_sub_field('second_project_card');

                    if ($second_project_card):
                        $post_id = $second_project_card->ID;

                        $permalink = get_permalink($post_id);
                        $title = get_the_title($post_id);
                        $thumbnail = get_the_post_thumbnail_url($post_id, 'full');

                        // ACF fields (adjust names)
                        $client_name = get_field('client_name', $post_id);
                        $location = get_field('location', $post_id);

                        // Taxonomy (adjust if needed)
                        $project_categories = get_the_terms($post_id, 'projects_categories');
                    ?>

                        <div class="project-section-box">
                            <a href="<?php echo esc_url($permalink); ?>">
                                <div class="project-img-tag">

                                    <?php
                                    $thumbnail = $thumbnail ?: get_stylesheet_directory_uri() . '/assets/images/new-img.jpg';
                                    ?>
                                    <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr($title); ?>">

                                    <?php if ($project_categories && !is_wp_error($project_categories)): ?>
                                        <div class="project-tag">
                                            <?php foreach ($project_categories as $category): ?>
                                                <span><?php echo esc_html($category->name); ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>

                                </div>

                                <div class="project-info-box">
                                    <h3><?php echo esc_html($title); ?></h3>

                                    <?php
                                    $locations = get_the_terms($post_id, 'location');
                                    $company_name = get_field('company_name_value', $post_id);
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

                    <?php endif; ?>
                </div>

            </div>
        </div>
    </section>
<?php endif; ?>