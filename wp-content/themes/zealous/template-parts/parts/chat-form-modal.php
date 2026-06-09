<?php
$card_contact_modal_title = get_field('card_contact_modal_title', 'option');
$card_contact_modal_description = get_field('card_contact_modal_description', 'option');
$card_contact_modal_shortcode = get_field('card_contact_modal_shortcode', 'option');
?>

<div class="chat-form-main">
    <div class="overlay-box"></div>
    <div class="chat-form-box">
        <a href="#" class="icon-box icon-box-xs chat-form-close">
            <img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/close-icon.svg" alt="Close">
        </a>

        <div class="sub-title-with-text text-content-section">
            <?php echo ($card_contact_modal_title ?: 'Contact us'); ?>

            <?php if ($card_contact_modal_description): ?>
                <?php echo ($card_contact_modal_description); ?>
            <?php endif; ?>
        </div>

        <?php
        echo do_shortcode(
            $card_contact_modal_shortcode ?: '[wpforms id="736"]'
        );
        ?>
    </div>
</div>