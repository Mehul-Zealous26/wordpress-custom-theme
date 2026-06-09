<?php
$enable_global_content = get_sub_field('enable_global_content');
$select_spacer = get_sub_field('select_spacer');
$padding_style = get_spacer_padding_style($select_spacer);

/**
 * Data Source Mapping
 */
if ($enable_global_content) {
    $title = get_field('logo_slider_title', 'option');
    $logo_items = get_field('logo_slider_items', 'option');
    $image_key = 'logo_slide_images';
    $section_id = 'logo_slider';
} else {
    $title = get_sub_field('title');
    $logo_items = get_sub_field('logo_images');
    $image_key = 'slide_images';
    $section_id = '';
}
?>
<?php
$has_valid_image = false;

if (!empty($logo_items)) {
    foreach ($logo_items as $item) {
        $image = $item[$image_key] ?? null;

        if (!empty($image['url'])) {
            $has_valid_image = true;
            break;
        }
    }
}

//Hide 
if (!$has_valid_image) {
    return;
}
?>
<section class="trusted-section-main" <?php if ($padding_style)
    echo 'style="' . esc_attr($padding_style) . '"'; ?>
    <?php if ($section_id)
        echo 'id="' . esc_attr($section_id) . '"'; ?>>

    <div class="container-box text-content-section">

        <?php if ($title): ?>
             <?php echo ($title); ?>
        <?php endif; ?>

        <?php if (!empty($logo_items)): ?>

            <?php
            // Split into 3 equal groups
            $chunks = array_chunk($logo_items, ceil(count($logo_items) / 3));

            // Ensure always 3 rows
            $chunks = array_pad($chunks, 3, []);

            // Direction pattern
            $directions = ['rtl', 'ltr', 'rtl'];
            ?>

            <div class="trusted-slider-main">
                <div class="trusted-slider-rtl">

                    <?php foreach ($chunks as $index => $items): ?>
                        <div class="swiper-container swiper--<?php echo $directions[$index]; ?>">
                            <div class="swiper-wrapper">

                                <?php foreach ($items as $item):
                                    $image = $item[$image_key] ?? null;

                                    if (empty($image['url']))
                                        continue;
                                    ?>

                                        <div class="swiper-slide">
                                                    <img src="<?php echo esc_url($image['url']); ?>"
                                                alt="<?php echo esc_attr($image['alt'] ?? ''); ?>">
                                        </div>
                                        <?php endforeach; ?>

                                </div>
                                </div>
                        <?php endforeach; ?>

                    </div>
                </div>

        <?php endif; ?>

    </div>
</section>