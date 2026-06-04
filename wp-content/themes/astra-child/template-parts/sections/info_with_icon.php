<?php
$variant = get_sub_field('layout_variant');
$icon_bg = get_sub_field('icon_bg_style');

// Add class conditionally
$section_class = 'product-f-video';

if ($variant === 'layout_3') {
    $section_class .= ' reverse-row';
}

$pretitle = get_sub_field('pretitle');
$title = get_sub_field('title');
$first_description = get_sub_field('first_description');
$second_description = get_sub_field('second_description');
$background_color = get_sub_field('background_color');
$right_image = get_sub_field('right_image');

// Image Grid (layout 3)
$image_box_1 = get_sub_field('image_box_1');
$image_box_2 = get_sub_field('image_box_2');
$image_box_title = get_sub_field('image_box_title');
$image_box_heading = get_sub_field('image_box_heading');
$image_box_bg_color = get_sub_field('image_box_bg_color');

// Buttons
$btn1 = get_sub_field('button_1');
$btn2 = get_sub_field('button_2');

// Spacer
$select_spacer = get_sub_field('select_spacer');
$padding_style = get_spacer_padding_style($select_spacer);

// Icon layout class
$icon_class = ($variant === 'layout_2' || $variant === 'layout_3')
    ? 'text-with-icon-box text-with-icon-left'
    : 'text-with-icon-box';

    $classes = [$icon_class];

    if (!empty($icon_bg)) {
        $classes[] = $icon_bg;
    }

$final_class = implode(' ', $classes);
?>

<section class="<?php echo esc_attr($section_class . ' ' . $background_color); ?> product-f-text" 
    <?php if (!empty($padding_style)) echo 'style="' . esc_attr($padding_style) . '"'; ?>>
    <div class="container-box">

        <!-- LEFT CONTENT -->
        <div class="product-f-video-left sub-title-with-text">

            <?php if ($pretitle): ?>
                <div class="sub-heading"><?php echo esc_html($pretitle); ?></div>
            <?php endif; ?>

            <?php if ($title): ?>
                <h3><?php echo $title; ?></h3>
            <?php endif; ?>

            <?php if ($first_description): ?>
                <div class="mulit-col-text">
                    <div class="text-content-section">
                    <?php echo $first_description; ?>
                    </div>
                    <div class="text-content-section">
                    <?php echo $second_description; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- FEATURE CARDS -->
            <?php if (have_rows('feature_cards')): ?>
                <div class="<?php echo esc_attr($final_class); ?>">

                    <?php while (have_rows('feature_cards')): the_row();

                        $f_title = get_sub_field('feature_title');
                        $f_desc = get_sub_field('feature_description');
                        $f_img = get_sub_field('feature_image');

                        // Skip empty row
                        if (empty($f_title) && empty($f_desc) && empty($f_img)) {
                            continue;
                        }
                    ?>

                        <div class="text-with-icon-col">

                            <div class="text-title-icon">

                                <?php if (!empty($f_img['url'])): ?>
                                    <div class="text-with-icon">
                                        <img src="<?php echo esc_url($f_img['url']); ?>"
                                             alt="<?php echo esc_attr($f_title ?: 'Icon'); ?>">
                                    </div>
                                <?php endif; ?>

                                <?php if ($f_title): ?>
                                    <h4><?php echo esc_html($f_title); ?></h4>
                                <?php endif; ?>

                            </div>

                            <?php if ($f_desc): ?>
                                <?php echo $f_desc; ?>
                            <?php endif; ?>

                        </div>

                    <?php endwhile; ?>

                </div>
            <?php endif; ?>

            <!-- BUTTONS -->
            <?php if ($btn1 || $btn2): ?>
                <div class="button-box">

                    <?php if (!empty($btn1['url'])): ?>
                        <a href="<?php echo esc_url($btn1['url']); ?>"
                           class="btn secondary-btn"
                           target="<?php echo esc_attr($btn1['target'] ?: '_self'); ?>">
                            <?php echo esc_html($btn1['title']); ?>
                        </a>
                    <?php endif; ?>

                    <?php if (!empty($btn2['url'])): ?>
                        <a href="<?php echo esc_url($btn2['url']); ?>"
                           class="btn primary-btn"
                           target="<?php echo esc_attr($btn2['target'] ?: '_self'); ?>">
                            <?php echo esc_html($btn2['title']); ?>
                        </a>
                    <?php endif; ?>

                </div>
            <?php endif; ?>

        </div>

        <!-- RIGHT SIDE -->
        <?php if ($variant === 'layout_3'): ?>

            <?php if ($image_box_1 || $image_box_2 || $image_box_title || $image_box_heading): ?>
                <div class="product-m-img">
                <div class="img-box-3">

                   
                    <!-- IMAGE 1 -->
                    <?php if (!empty($image_box_1['url'])): ?>
                        <div class="img-box-1">
                            <img src="<?php echo esc_url($image_box_1['url']); ?>" alt="Image">
                        </div>
                    <?php endif; ?>
                    
                    <!-- TEXT CARD FIRST -->
                    <?php if ($image_box_title || $image_box_heading): ?>
                        <div class="img-box-text <?php echo esc_attr($image_box_bg_color ?: 'light-gray-bg'); ?>">

                            <?php if ($image_box_title): ?>
                                <span><?php echo esc_html($image_box_title); ?></span>
                            <?php endif; ?>

                            <?php if ($image_box_heading): ?>
                                <h4><?php echo wp_kses_post($image_box_heading); ?></h4>
                            <?php endif; ?>

                        </div>
                    <?php endif; ?>

                    <!-- IMAGE 2 -->
                    <?php if (!empty($image_box_2['url'])): ?>
                        <div class="img-box-2">
                            <img src="<?php echo esc_url($image_box_2['url']); ?>" alt="Image">
                        </div>
                    <?php endif; ?>

                </div>
            </div>
            <?php endif; ?>

        <?php else: ?>

            <?php if (!empty($right_image['url'])): ?>
                <div class="product-f-video-right">
                    <img src="<?php echo esc_url($right_image['url']); ?>" alt="Image">
                </div>
            <?php endif; ?>

        <?php endif; ?>

    </div>
</section>