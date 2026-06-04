<?php
$select_spacer = get_sub_field('select_spacer');
$padding_style = get_spacer_padding_style($select_spacer);
$enable_global_content = get_sub_field('enable_global_content');
if ($enable_global_content) {
    $pre_title = get_field('installation_support_pre_title', 'option');
    $title = get_field('installation_support_title', 'option');
    $description = get_field('installation_support_description', 'option');
} else {
    $pre_title = get_sub_field('pre_title');
    $title = get_sub_field('title');
    $description = get_sub_field('description');
}
?>

<section class="customer-support-main" <?php if ($padding_style)
    echo 'style="' . esc_attr($padding_style) . '"'; ?>
    id="installation_support">
    <div class="container-box">
        <div class="sub-title-with-text w-600 text-content-section">
            <?php if ($pre_title) { ?>
                <div class="sub-heading"><?php echo esc_html($pre_title); ?></div>
            <?php } ?>
            <?php if ($title) { ?>
                <?php echo ($title); ?>
            <?php } ?>
            <?php if ($description) { ?>
                <?php echo ($description); ?>
            <?php } ?>
        </div>
        <?php if ($enable_global_content && have_rows('global_installation_card', 'option')): ?>
            <div class="customer-support-box-new">
                <?php while (have_rows('global_installation_card', 'option')):
                    the_row();
                    $global_sub_title = get_sub_field('global_sub_title');
                    $global_title = get_sub_field('global_title');
                    $global_image = get_sub_field('global_image');
                    ?>
                    <div class="customer-support-col-new">
                        <div class="customer-support-img-box">
                            <span></span>
                            <?php if ($global_image): ?>
                                <img src="<?php echo esc_url($global_image['url']); ?>"
                                    alt="<?php echo esc_attr($global_image['alt']); ?>">
                            <?php endif; ?>
                        </div>
                        <div class="customer-support-des-new">
                            <?php if ($global_sub_title): ?>
                                <span><?php echo esc_html($global_sub_title); ?></span>
                            <?php endif; ?>
                            <?php if ($global_title): ?>
                                     <?php echo ($global_title); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php elseif (have_rows('installation_card')): ?>
            <div class="customer-support-box-new">
                <?php while (have_rows('installation_card')):
                    the_row();
                    $sub_ttile = get_sub_field('sub_ttile');
                    $title = get_sub_field('title');
                    $image = get_sub_field('image');
                    ?>
                    <div class="customer-support-col-new">
                        <div class="customer-support-img-box">
                            <span></span>
                            <?php if ($image): ?>
                                <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                            <?php endif; ?>
                        </div>
                        <div class="customer-support-des-new text-content-section">
                            <?php if ($sub_ttile): ?>
                                <span><?php echo esc_html($sub_ttile); ?></span>
                            <?php endif; ?>
                            <?php if ($title): ?>
                                <?php echo ($title); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </div>
</section>