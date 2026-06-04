<?php
$pretitle = get_sub_field('pretitle');
$title = get_sub_field('title');
$description = get_sub_field('description');
$primary_button = get_sub_field('primary_button');
$secondary_button = get_sub_field('secondary_button');
$error_text = get_sub_field('error_text');
$select_spacer = get_sub_field('select_spacer');
$padding_style = get_spacer_padding_style($select_spacer);
?>

<section class="error-404-section" <?php if ($padding_style)
    echo 'style="' . esc_attr($padding_style) . '"'; ?>
    id="error_hero_section">
    <div class="container-box">
        <?php if ($error_text): ?>
            <div class="text-404">
                <?php echo esc_html($error_text); ?>
            </div>
        <?php endif; ?>
        <div class="sub-title-with-text sub-title-with-text-center text-content-section">
            <?php if ($pretitle): ?>
                <div class="sub-heading">
                    <?php echo esc_html($pretitle); ?>
                </div>
            <?php endif; ?>
            <?php if ($title): ?>
                <?php echo ($title); ?>
            <?php endif; ?>
            <?php if ($description): ?>
                <?php echo ($description); ?>
            <?php endif; ?>
            <?php if ($primary_button || $secondary_button): ?>
                <div class="button-box">

                    <?php if ($secondary_button):
                        $target = !empty($secondary_button['target']) ? $secondary_button['target'] : '_self';
                        ?>
                        <a href="<?php echo esc_url($secondary_button['url']); ?>" target="<?php echo esc_attr($target); ?>"
                            rel="<?php echo ($target === '_blank') ? 'noopener noreferrer' : ''; ?>" class="btn secondary-btn">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/back-arrow.svg"
                                alt="Accordion Arrow">
                            <?php echo esc_html($secondary_button['title']); ?>
                        </a>
                    <?php endif; ?>

                    <?php if ($primary_button):
                        $target = !empty($primary_button['target']) ? $primary_button['target'] : '_self';
                        ?>
                        <a href="<?php echo esc_url($primary_button['url']); ?>" target="<?php echo esc_attr($target); ?>"
                            rel="<?php echo ($target === '_blank') ? 'noopener noreferrer' : ''; ?>" class="btn primary-btn">
                            <?php echo esc_html($primary_button['title']); ?>
                        </a>
                    <?php endif; ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
</section>