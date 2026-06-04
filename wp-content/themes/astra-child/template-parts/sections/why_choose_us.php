<?php
$enable_global_content = get_sub_field('enable_global_content');
if ($enable_global_content) {
    $pre_title = get_field('why_choose_us_pre_title', 'option');
    $title = get_field('why_choose_us_title', 'option');
    $description = get_field('why_choose_us_description', 'option');
} else {
    $pre_title = get_sub_field('pre_title');
    $title = get_sub_field('title');
    $description = get_sub_field('description');
}
$background_color = get_sub_field('background_color');
$select_spacer = get_sub_field('select_spacer');
$padding_style = get_spacer_padding_style($select_spacer);
?>

<section class="project-slider-section <?php echo esc_attr($background_color); ?>" id="why_choose_us" <?php if ($padding_style)
                                                                                                            echo 'style="' . esc_attr($padding_style) . '"'; ?>>
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
        <?php if (!wp_is_mobile()) { ?>
            <div class="slider-bottom-cont">
                <div class="swiper-pagination"></div>
                <div class="sider-arrow-box">
                    <div class="swiper-button-prev why-choose-slider-prev slider-arrow"></div>
                    <div class="swiper-button-next why-choose-slider-next slider-arrow"></div>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="why-choose-slider">
        <div class="why-choose-slider-box swiper">
            <?php
            // Check if global content is enabled from edit page
            if ($enable_global_content && have_rows('global_cards', 'option')): ?>
                <div class="swiper-wrapper">
                    <?php while (have_rows('global_cards', 'option')):
                        the_row();
                        $card_title = get_sub_field('global_card_title');
                        $card_description = get_sub_field('global_card_description');
                        $card_image = get_sub_field('global_card_image');
                        $thumbnail_icon = get_sub_field('global_thumbnail_icon');
                    ?>
                        <div class="swiper-slide">
                            <?php if ($card_title) { ?>
                                <div class="dark-tag"><?php echo esc_html($card_title); ?></div>
                            <?php } ?>
                            <?php if ($card_description) { ?>
                                <p><?php echo esc_html($card_description); ?></p>
                            <?php } ?>
                            <?php if ($thumbnail_icon) { ?>
                                <div class="dark-bg-icon">
                                    <img src="<?php echo esc_url($thumbnail_icon['url']); ?>" alt="Icon Image">
                                </div>
                            <?php } ?>
                            <?php if ($card_image) { ?>
                                <img class="why-choose-img" src="<?php echo esc_url($card_image['url']); ?>" alt="Icon Image">
                            <?php } ?>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php elseif (have_rows('cards')): ?>
                <div class="swiper-wrapper">
                    <?php while (have_rows('cards')):
                        the_row();
                        $card_title = get_sub_field('card_title');
                        $card_description = get_sub_field('card_description');
                        $card_image = get_sub_field('card_image');
                        $thumbnail_icon = get_sub_field('thumbnail_icon');
                    ?>
                        <div class="swiper-slide">
                            <?php if ($card_title) { ?>
                                <div class="dark-tag"><?php echo esc_html($card_title); ?></div>
                            <?php } ?>
                            <?php if ($card_description) { ?>
                                <p><?php echo esc_html($card_description); ?></p>
                            <?php } ?>
                            <?php if ($thumbnail_icon) { ?>
                                <div class="dark-bg-icon">
                                    <img src="<?php echo esc_url($thumbnail_icon['url']); ?>" alt="Icon Image">
                                </div>
                            <?php } ?>
                            <?php if ($card_image) { ?>
                                <img class="why-choose-img" src="<?php echo esc_url($card_image['url']); ?>" alt="Icon Image">
                            <?php } ?>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
            <?php
            // Count cards for slider controls
            $card_count = 0;
            if ($enable_global_content) {
                $global_cards = get_field('global_cards', 'option');
                if ($global_cards && is_array($global_cards)) {
                    $card_count = count($global_cards);
                }
            } else {
                $cards = get_sub_field('cards');
                if ($cards && is_array($cards)) {
                    $card_count = count($cards);
                }
            }
            ?>

            <?php if (wp_is_mobile()) { ?>
                <div class="slider-bottom-cont">
                    <div class="swiper-pagination"></div>
                    <div class="sider-arrow-box">
                        <div class="swiper-button-prev why-choose-slider-prev slider-arrow"></div>
                        <div class="swiper-button-next why-choose-slider-next slider-arrow"></div>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>
</section>