<?php
$title = get_sub_field('title');
$bottom_content = get_sub_field('bottom_content');
$select_spacer = get_sub_field('select_spacer');
$padding_style = get_spacer_padding_style($select_spacer);
?>

<section class="faq-section-main" id="rtl_image_text_block" <?php if ($padding_style)
    echo 'style="' . esc_attr($padding_style) . '"'; ?>>
    <div class="faq-right-s-box">

        <div class="faq-img-text-section text-content-section">

            <?php if (!empty($title)): ?>
                <?php echo ($title); ?>
            <?php endif; ?>

            <?php if (have_rows('image_text_rows')): ?>

                <?php while (have_rows('image_text_rows')):
                    the_row();
                    $row_image = get_sub_field('row_image');
                    $row_content = get_sub_field('row_content');
                    ?>

                    <?php if (!empty($row_image) || !empty($row_content)): ?>
                        <div class="faq-img-text-row">

                            <?php if (!empty($row_image)): ?>
                                <div class="faq-img-text-col">
                                    <img src="<?php echo esc_url($row_image['url']); ?>"
                                        alt="<?php echo esc_attr($row_image['alt'] ?? ''); ?>">
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($row_content)): ?>
                                <div class="faq-img-text-col">
                                    <?php echo ($row_content); ?>
                                </div>
                            <?php endif; ?>

                        </div>
                    <?php endif; ?>

                <?php endwhile; ?>

            <?php endif; ?>

            <?php if (!empty($bottom_content)): ?>
                <div class="faq-img-text-info text-content-section">
                    <?php echo $bottom_content; ?>
                </div>
            <?php endif; ?>

        </div>

    </div>
</section>