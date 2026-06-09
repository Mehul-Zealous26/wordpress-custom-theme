<?php
$enable_global_content = get_sub_field('enable_global_content');

if ($enable_global_content) {
    $pre_title = get_field('stat_pre_title', 'option');
    $title = get_field('stat_title', 'option');
    $description = get_field('stat_description', 'option');
} else {
    $pre_title = get_sub_field('pre_title');
    $title = get_sub_field('title');
    $description = get_sub_field('description');
}

$layout_style = get_sub_field('layout_style');
$reverse_row = get_sub_field('reverse_row');
$background_color = get_sub_field('background_color'); // NEW
$select_spacer = get_sub_field('select_spacer');
$padding_style = get_spacer_padding_style($select_spacer);

/**
 * Layout Class Mapping
 */
$section_classes = 'stats-section';

if ($layout_style === 'box') {
    $section_classes .= ' stats-section-full stats-section-box';
} elseif ($layout_style === 'line') {
    $section_classes .= ' stats-section-full stats-section-line';
} elseif ($layout_style === 'line_dark') {
    $section_classes .= ' stats-section-full stats-section-line';
}

/**
 * Background Color (for ALL layouts)
 */
if (!empty($background_color) && $background_color !== 'normal') {
    $section_classes .= ' ' . $background_color;
}

/**
 * Reverse Row ONLY for default layout
 */
if (($layout_style === 'default' || empty($layout_style)) && $reverse_row) {
    $section_classes .= ' reverse-row';
}
?>

<section class="<?php echo esc_attr($section_classes); ?>" <?php if ($padding_style)
       echo 'style="' . esc_attr($padding_style) . '"'; ?> id="stats_highlight">

    <div class="container-box">

        <div class="stats-section-left">
            <div class="sub-title-with-text text-content-section">

                <?php if ($pre_title): ?>
                    <div class="sub-heading"><?php echo esc_html($pre_title); ?></div>
                <?php endif; ?>

                <?php if ($title): ?>
                    <?php echo ($title); ?>
                <?php endif; ?>

                <?php if ($description): ?>
                    <?php echo ($description); ?>
                <?php endif; ?>

            </div>
        </div>

        <?php
        $repeater_source = $enable_global_content ? 'option' : '';

        if (have_rows('stats_repeator', $repeater_source)): ?>
            <div class="stats-section-right">

                <?php while (have_rows('stats_repeator', $repeater_source)):
                    the_row();

                    $item_title = get_sub_field('title');
                    $item_description = get_sub_field('description');
                    $stat_card_button = get_sub_field('stat_card_button');
                    $pre_text_number = get_sub_field('pre_text_number');
                    $counts = get_sub_field('counts');
                    $post_text_number = get_sub_field('post_text_number');

                    ?>

                    <div class="counter-section-box">

                        <div class="count-box <?php echo !empty($pre_text_number) ? 'price-s' : ''; ?>"
                            data-target="<?php echo esc_attr($counts ? $counts : '0'); ?>"
                            data-prefix="<?php echo esc_attr($pre_text_number); ?>"
                            data-suffix="<?php echo !empty($post_text_number) ? esc_attr($post_text_number) : ''; ?>">
                            0
                        </div>

                        <div class="counter-info">

                            <?php if ($item_title): ?>
                                <span><?php echo esc_html($item_title); ?></span>
                            <?php endif; ?>

                            <?php if (!empty($item_description)): ?>
                                <?php echo $item_description; ?>
                            <?php endif; ?>

                            <?php
                            /**
                             * Button ONLY for default layout
                             */
                            if (
                                ($layout_style === 'default' || empty($layout_style)) &&
                                !empty($stat_card_button) &&
                                !empty($stat_card_button['url']) &&
                                !empty($stat_card_button['title'])
                            ): ?>

                                <a href="<?php echo esc_url($stat_card_button['url']); ?>" class="btn btn-xs secondary-btn"
                                    target="<?php echo esc_attr($stat_card_button['target'] ?? '_self'); ?>">
                                    <?php echo esc_html($stat_card_button['title']); ?>
                                </a>

                            <?php endif; ?>

                        </div>

                    </div>

                <?php endwhile; ?>

            </div>
        <?php endif; ?>

    </div>
</section>