<?php

/**
 * Numbered Hotspot Section (ACF Dynamic)
 * Displays numbered list items on left with corresponding numbered hotspot dots on image (right)
 */

$show_in_tabs = get_sub_field('show_in_tabs');
$layout = get_sub_field('layout');
$background_type = get_sub_field('background_type');
$select_spacer = get_sub_field('select_spacer');
$padding_style = function_exists('get_spacer_padding_style')
    ? get_spacer_padding_style($select_spacer)
    : '';

$inherit_from_group_product = get_sub_field('inherit_from_group_product');

$pretitle = get_sub_field('pretitle');
$title = get_sub_field('title');
$description = get_sub_field('description');
$numbered_items = get_sub_field('numbered_items');
$hotspot_image = get_sub_field('hotspot_image');
$enable_hotspot = get_sub_field('enable_hotspot');

/* --------------------------------
 * Layout + Background Handling
 * -------------------------------- */

$layout_class = $layout ?: '';
$background_class = $background_type ?: '';

$section_classes = [
    'product-f-video',
    'sport-md',
    'numbered-hotspot-section',
    $layout_class,
    $background_class
];

if ($show_in_tabs) {
    $section_classes[] = 'section-in-tabs';
}
?>

<?php if ($numbered_items && $hotspot_image): ?>
    <section id="numbered_hotspot_section" class="<?php echo esc_attr(implode(' ', array_filter($section_classes))); ?>"
        <?php if ($padding_style)
            echo 'style="' . esc_attr($padding_style) . '"'; ?>>
        <div class="container-box">
            <!-- Left Side: Numbered List -->
            <div class="product-f-video-left sub-title-with-text text-content-section">
                <div>
                    <div class="sport-desktop">
                        <?php if ($pretitle): ?>
                            <div class="sub-heading">
                                <?php echo esc_html($pretitle); ?>
                            </div>
                            <?php
                        endif; ?>

                        <?php if ($title): ?>
                            <?php echo ($title); ?>
                            <?php
                        endif; ?>

                        <?php if ($description): ?>
                            <?php echo ($description); ?>
                        <?php endif; ?>
                    </div>
                    <div class="sport-number-text">
                        <?php
                        $item_index = 0;
                        foreach ($numbered_items as $item):
                            $number = $item['number'] ?? ($item_index + 1);
                            $item_title = $item['title'] ?? '';
                            $item_description = $item['description'] ?? '';
                            $learn_more_link = $item['learn_more_link'] ?? '';
                            ?>
                            <div class="sport-number-box" data-item-index="<?php echo esc_attr($item_index); ?>">
                                <h6>
                                    <span><?php echo esc_html(str_pad($number, 2, '0', STR_PAD_LEFT)); ?></span>
                                    <?php echo esc_html($item_title); ?>
                                </h6>
                                <p>
                                    <?php echo esc_html($item_description); ?>
                                    <?php if ($learn_more_link): ?>
                                        <a href="<?php echo esc_url($learn_more_link['url'] ?? '#'); ?>">
                                            <?php echo esc_html($learn_more_link['title'] ?? 'Learn More'); ?>
                                        </a>
                                        <?php
                                    endif; ?>
                                </p>
                            </div>
                            <?php
                            $item_index++;
                        endforeach;
                        ?>
                    </div>
                </div>
            </div>

            <!-- Right Side: Image with Numbered Hotspot Dots -->
            <div class="product-f-video-right hotspot-img-box">
                <?php if ($enable_hotspot): ?>
                    <div class="hotspot-image-wrap hotspot-image-wrapper hotspot-image-container numbered-hotspot-container"
                        data-image="<?php echo esc_attr($hotspot_image['url']); ?>" data-enable-hotspot="1"
                        data-hotspot-type="numbered">
                        <div class="hotspot-image-center">
                            <img class="hotspot-image" src="<?php echo esc_url($hotspot_image['url']); ?>"
                                alt="<?php echo esc_attr($hotspot_image['alt']); ?>"
                                data-image="<?php echo esc_attr($hotspot_image['url']); ?>">

                            <div class="sport-number-count hotspot-overlay" data-hotspot-type="numbered">
                                <?php
                                // Render numbered hotspots if enabled
                                if (class_exists('Hotspot_ACF_Bridge')) {
                                    // Normalize image URL - use full URL consistently
                                    $image_url = $hotspot_image['url'] ?? '';
                                    if (empty($image_url) && isset($hotspot_image['ID'])) {
                                        $image_url = wp_get_attachment_image_url($hotspot_image['ID'], 'full');
                                    }

                                    // Normalize URL to match admin format (remove size params, query strings)
                                    $image_url = preg_replace('/-\d+x\d+\.(jpg|jpeg|png|gif|webp)/i', '.$1', $image_url);
                                    $image_url = strtok($image_url, '?'); // Remove query params
                        
                                    // Pass ACF layout context so the bridge can find the exact hotspot set
                                    $layout_name = function_exists('get_row_layout') ? get_row_layout() : 'numbered_hotspot_section';
                                    $layout_index = function_exists('get_row_index') ? max(0, get_row_index() - 1) : 0;
                                    $image_index = 0;

                                    $rendered_dots = Hotspot_ACF_Bridge::render_numbered_hotspots(
                                        $image_url,
                                        count($numbered_items),
                                        get_the_ID(),
                                        $layout_name,
                                        $layout_index,
                                        $image_index
                                    );

                                    // Always output debug info in HTML comments (visible in page source)
                                    $hotspot_data = get_post_meta(get_the_ID(), '_acf_hotspot_data', true);
                                    echo '<!-- Numbered Hotspot Debug -->';
                                    echo '<!-- Image URL (normalized): ' . esc_html($image_url) . ' -->';
                                    echo '<!-- Hotspot data exists: ' . (!empty($hotspot_data) ? 'Yes (' . strlen($hotspot_data) . ' chars)' : 'No') . ' -->';
                                    if (!empty($hotspot_data)) {
                                        $decoded = json_decode($hotspot_data, true);
                                        if ($decoded && is_array($decoded)) {
                                            echo '<!-- Saved image URLs: ' . esc_html(implode(' | ', array_keys($decoded))) . ' -->';
                                            echo '<!-- Dots found for this image: ' . (isset($decoded[$image_url]) ? 'Yes (' . count($decoded[$image_url]) . ' dots)' : 'No') . ' -->';
                                        } else {
                                            echo '<!-- JSON decode failed: ' . esc_html(json_last_error_msg()) . ' -->';
                                        }
                                    }
                                    $dot_count = empty($rendered_dots) ? 0 : substr_count($rendered_dots, 'sport-number-count-box');
                                    echo '<!-- Rendered dots count: ' . $dot_count . ' -->';
                                    echo '<!-- End Debug -->';

                                    // Output dots
                                    echo $rendered_dots;
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <?php if (current_user_can('edit_posts')): ?>
                        <!-- Numbered dots will be auto-created by admin.js based on repeater count -->

                        <?php
                    endif; ?>
                    <?php
                else: ?>
                    <img src="<?php echo esc_url($hotspot_image['url']); ?>"
                        alt="<?php echo esc_attr($hotspot_image['alt']); ?>">
                    <?php
                endif; ?>
            </div>

            <!-- Left Side: Numbered List Mobile-->
            <div class="product-f-video-left sub-title-with-text sport-mobile text-content-section">
                <div>
                    <?php if ($pretitle): ?>
                        <div class="sub-heading">
                            <?php echo esc_html($pretitle); ?>
                        </div>
                        <?php
                    endif; ?>

                    <?php if ($title): ?>
                        <?php echo ($title); ?>
                        <?php
                    endif; ?>

                    <?php if ($description): ?>
                        <?php echo esc_html($description); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <script>
        jQuery(document).ready(function ($) {
            // Scope to this specific section
            const $section = $('.numbered-hotspot-section');

            if ($section.length === 0) return;

            // Hide all descriptions initially
            $section.find('.sport-number-box p').hide();

            function activateItem(index) {
                // Remove active class from all in this section
                $section.find('.sport-number-box, .sport-number-count-box').removeClass('active');
                $section.find('.sport-number-box p').slideUp(300);

                // Add active class to selected
                $section.find('.sport-number-box').eq(index)
                    .addClass('active')
                    .find('p').slideDown(300);

                $section.find('.sport-number-count-box').eq(index).addClass('active');
            }

            // Wait for image to load, then activate first item
            const $image = $section.find('.hotspot-image');

            function initHotspots() {
                const dotCount = $section.find('.sport-number-count-box').length;
                const itemCount = $section.find('.sport-number-box').length;

                console.log('Numbered Hotspot: Found', dotCount, 'dots and', itemCount, 'items');

                // Ensure dots are visible
                $section.find('.sport-number-count-box').css({
                    'display': 'flex',
                    'visibility': 'visible',
                    'opacity': '1'
                });

                if (dotCount > 0) {
                    activateItem(0);
                } else if (itemCount > 0) {
                    console.warn('Numbered Hotspot: No dots found! Make sure you saved the page after adding dots in admin.');
                }
            }

            if ($image.length && $image[0].complete) {
                // Image already loaded
                setTimeout(initHotspots, 100);
            } else {
                // Wait for image to load
                $image.on('load', function () {
                    setTimeout(initHotspots, 100);
                });
                // Fallback timeout
                setTimeout(initHotspots, 500);
            }

            // LEFT side click (numbered list)
            $section.find('.sport-number-box').on('click', function () {
                if ($(this).hasClass('active')) return;
                const index = $section.find('.sport-number-box').index($(this));
                activateItem(index);
            });

            // RIGHT side click (numbered dots on image)
            $section.on('click', '.sport-number-count-box', function (e) {
                e.stopPropagation();
                if ($(this).hasClass('active')) return;
                const index = $section.find('.sport-number-count-box').index($(this));
                activateItem(index);
            });
        });
    </script>
    <?php
endif; ?>