<?php
$contact_pre_title_left = get_sub_field('contact_pre_title_left');
$contact_title_left = get_sub_field('contact_title_left');
$contact_description_left = get_sub_field('contact_description_left');
$form_shortcode_right = get_sub_field('form_shortcode_right');
$contact_heading_right = get_sub_field('contact_heading_right');
$contact_subheading_right = get_sub_field('contact_subheading_right');
$contact_info_text_right = get_sub_field('contact_info_text_right');
$select_spacer = get_sub_field('select_spacer');
$padding_style = get_spacer_padding_style($select_spacer);
?>

<div class="contact-section-top" <?php if ($padding_style)
                                        echo 'style="' . esc_attr($padding_style) . '"'; ?>
    id="get_in_contact">
    <div class="container-box">
        <div class="contact-left">
            <div class="sub-title-with-text text-content-section">
                <?php if ($contact_pre_title_left): ?>
                    <div class="sub-heading"><?php echo esc_html($contact_pre_title_left); ?></div>
                <?php endif ?>
                <?php if ($contact_title_left): ?>
                    <?php echo ($contact_title_left); ?>
                <?php endif ?>
                <?php if ($contact_description_left): ?>
                    <?php echo $contact_description_left; ?>
                <?php endif ?>
            </div>
            <?php if (have_rows('contact_card_left')): ?>
                <div class="contact-info-section">
                    <?php while (have_rows('contact_card_left')):
                        the_row();
                        $contact_icon = get_sub_field('contact_icon');
                        $contact_text = get_sub_field('contact_text');
                        $contact_subtext = get_sub_field('contact_subtext');
                        $button_link = get_sub_field('button_link');
                    ?>
                        <div class="contact-info-inner">
                            <?php if ($contact_icon): ?>
                                <i><img src="<?php echo esc_url($contact_icon['url']); ?>"
                                        alt="<?php echo esc_html($contact_icon['title']) ?>"></i>
                            <?php endif ?>
                            <div class="contact-info">
                                <?php if ($contact_text): ?>
                                    <h6><?php echo esc_html($contact_text) ?></h6>
                                <?php endif ?>
                                <?php if ($contact_subtext): ?>
                                    <p><?php echo esc_html($contact_subtext) ?></p>
                                <?php endif ?>
                                <a href="<?php echo esc_url($button_link['url']) ?>"
                                    class="btn btn-sm secondary-btn"><?php echo esc_html($button_link['title']) ?></a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="contact-right footer-contact-form-main">
            <div class="form-head">
                <?php if ($contact_heading_right): ?>
                    <h3><?php echo esc_html($contact_heading_right); ?></h3>
                <?php endif ?>
                <?php if ($contact_subheading_right): ?>
                    <p><?php echo esc_html($contact_subheading_right); ?></p>
                <?php endif ?>
            </div>
            <?php if ($form_shortcode_right): ?>
                <?php echo do_shortcode($form_shortcode_right); ?>
            <?php endif ?>
            <?php if ($contact_info_text_right): ?>
                <div class="footer-form-info">
                    <p><?php echo esc_html($contact_info_text_right); ?></p>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>