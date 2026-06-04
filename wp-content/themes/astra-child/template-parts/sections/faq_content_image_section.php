<?php
$title = get_sub_field('title');
$description = get_sub_field('description');
$image = get_sub_field('image');
$select_spacer = get_sub_field('select_spacer');
$padding_style = get_spacer_padding_style($select_spacer);
?>

<section class="faq-section-main" id="faq_content_image_section" <?php if ($padding_style) echo 'style="' . esc_attr($padding_style) . '"'; ?>>
    <div class="faq-right-s-box">
        <div class="faq-section-center">

            <?php if (!empty($title)) : ?>
                <h5><?php echo esc_html($title); ?></h5>
            <?php endif; ?>

            <?php if (!empty($description)) : ?>
                <?php echo $description; ?>
            <?php endif; ?>

            <?php if (!empty($image)) : ?>
                <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt'] ?: $title); ?>">
            <?php endif; ?>

        </div>
    </div>
</section>