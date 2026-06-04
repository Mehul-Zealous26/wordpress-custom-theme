<?php

/**
 * Section: Brand Categories Grid
 * Uses WooCommerce 'product_brand' taxonomy and ACF category assignments
 */
$brand_order = [
    'protect',
    'control',
    'guide'
];
// Fetch all brands
$brands = get_terms([
    'taxonomy'   => 'product_brand',
    'hide_empty' => false,
]);

if ($brands && ! is_wp_error($brands)) {

    // Reorder brands manually
    usort($brands, function ($a, $b) use ($brand_order) {
        return array_search($a->slug, $brand_order)
            <=> array_search($b->slug, $brand_order);
    });
}
$select_spacer = get_sub_field('select_spacer');
$padding_style = get_spacer_padding_style($select_spacer);

if ($brands && ! is_wp_error($brands)): ?>
    <section class="product-rang-list-main" <?php if ($padding_style) echo 'style="' . esc_attr($padding_style) . '"'; ?>>
        <div class="container-box">

            <?php foreach ($brands as $brand):

                // Brand title/description
                $brand_title = get_field('brand_title', 'product_brand_' . $brand->term_id) ?: $brand->name;

                // Use default taxonomy description instead of ACF
                $brand_desc  = $brand->description;

                // Get ordered categories using the custom function
                $categories = get_ordered_categories($brand->term_id, 'product_brand');
            ?>

                <div class="product-rang-list-box">
                    <div class="product-rang-list-text">
                        <?php if ($brand_title): ?>
                            <h2><?php echo esc_html($brand_title); ?></h2>
                        <?php endif; ?>
                        <?php if ($brand_desc): ?>
                            <p><?php echo wp_kses_post($brand_desc); ?></p>
                        <?php endif; ?>
                    </div>


                    <?php if ($categories): ?>
                        <div class="product-rang-list-row">
                            <?php foreach ($categories as $cat):
                                $thumb_id  = get_term_meta($cat->term_id, 'thumbnail_id', true);
                                $thumb_url = $thumb_id ? wp_get_attachment_url($thumb_id) : wc_placeholder_img_src();
                            ?>
                                <div class="product-rang-list-col product-box">
                                    <div class="product-rang-img product-box-img">
                                        <a href="<?php echo esc_url(get_term_link($cat)); ?>" class="">

                                            <img src="<?php echo esc_url($thumb_url); ?>" alt="<?php echo esc_attr($cat->name); ?>" />
                                    </div>
                                    </a>
                                    <a href="<?php echo esc_url(get_term_link($cat)); ?>" class="">
                                        <h6><?php echo esc_html($cat->name); ?></h6>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p>No categories assigned for this Product Family.</p>
                    <?php endif; ?>
                </div>

            <?php endforeach; ?>

        </div>
    </section>
<?php else: ?>
    <p>No brands found.</p>
<?php endif; ?>