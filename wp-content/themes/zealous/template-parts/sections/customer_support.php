<?php
$select_spacer = get_sub_field('select_spacer');
$padding_style = get_spacer_padding_style($select_spacer);
$background_color = get_sub_field('background_color');

// Inside your flexible content loop
if (get_row_layout() == 'customer_support'):

    $enable_global_content = get_sub_field('enable_global_content');

    if ($enable_global_content) {
        $pretitle = get_field('customer_support_pretitle', 'option');
        $title = get_field('customer_support_title', 'option');
        $layout_type = get_field('layout_type', 'option');
        $disable_image = get_field('disable_image', 'option');
        $cards = get_field('customer_support_card', 'option');
    } else {
        $pretitle = get_sub_field('pretitle');
        $title = get_sub_field('title');
        $layout_type = get_sub_field('layout_type');
        $disable_image = get_sub_field('disable_image');
        $cards = get_sub_field('customer_support_card');
    }
    ?>

    <section class="customer-support-main  <?php echo esc_attr($background_color); ?>" <?php if ($padding_style)
           echo 'style="' . esc_attr($padding_style) . '"'; ?> id="customer_support">
        <div class="container-box">

            <!-- Section Heading -->
            <div class="sub-title-with-text w-600 text-content-section ">
                <?php if ($pretitle): ?>
                    <div class="sub-heading"><?php echo esc_html($pretitle); ?></div>
                <?php endif; ?>

                <?php if ($title): ?>
                    <?php echo ($title); ?>
                <?php endif; ?>
            </div>

            <?php if ($cards): ?>

                <!-- ============================== -->
                <!-- LAYOUT 1: NUMBER LAYOUT -->
                <!-- ============================== -->
                <?php if ($layout_type == 'number_layout'): ?>
                    <div class="customer-support-box-with-number ">
                        <?php foreach ($cards as $card): ?>
                            <div class="customer-support-number-col text-content-section">

                                <div class="customer-support-l ">
                                    <?php if (!empty($card['support_number'])): ?>
                                        <h4 class="support-number"><?php echo esc_html($card['support_number']); ?></h4>
                                    <?php endif; ?>

                                    <?php if (!empty($card['card_title'])): ?>
                                        <div class="support-number-title"><?php echo ($card['card_title']); ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="customer-support-r">
                                    <?php if (!empty($card['card_description'])): ?>
                                        <div class="support-number-desc">
                                            <?php echo ($card['card_description']); ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($card['card_link'])):
                                        $target = !empty($card['card_link']['target']) ? $card['card_link']['target'] : '_self';
                                        ?>
                                        <a href="<?php echo esc_url($card['card_link']['url']); ?>"
                                            class="btn secondary-btn double-right-btn" target="<?php echo esc_attr($target); ?>">
                                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/double-right-arrow-gray-lg.svg"
                                                alt="">
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>


                <!-- ============================== -->
                <!-- LAYOUT 2: IMAGE LAYOUT -->
                <!-- ============================== -->
                <?php if ($layout_type == 'image_layout'): ?>

                    <?php
                    // Check if at least one image exists (for wrapper class)
                    $has_any_image = false;

                    if (!$disable_image) {
                        foreach ($cards as $card) {
                            if (!empty($card['card_image'])) {
                                $has_any_image = true;
                                break;
                            }
                        }
                    }
                    ?>

                    <div
                        class="customer-support-box <?php echo (!$disable_image && $has_any_image ? 'support-box-with-img' : ''); ?>">

                        <?php foreach ($cards as $card):
                            // Check if THIS card has an image (regardless of disable_image setting)
                            $card_has_image = !empty($card['card_image']);
                            ?>
                            <div class="customer-support-col">

                                <!-- IMAGE BLOCK (per card) -->
                                <?php if ($card_has_image && !$disable_image): ?>
                                    <div class="customer-support-img">
                                        <img src="<?php echo esc_url($card['card_image']['url']); ?>" alt="">
                                    </div>
                                <?php else: ?>
                                    <div class="customer-support-img">
                                        <img class="customer-no-img"
                                            src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/default-image.jpeg'); ?>"
                                            alt="">
                                    </div>
                                <?php endif; ?>

                                <!-- CONTENT -->
                                <div class="customer-support-desc text-content-section">
                                    <?php if (!empty($card['card_title'])): ?>
                                        <?php echo ($card['card_title']); ?>
                                    <?php endif; ?>

                                    <?php if (!empty($card['card_description'])): ?>
                                        <?php echo ($card['card_description']); ?>
                                    <?php endif; ?>
                                </div>

                                <!-- BUTTON -->
                                <div class="customer-support-action">
                                    <hr>
                                    <?php if (!empty($card['card_link'])):
                                        $target = !empty($card['card_link']['target']) ? $card['card_link']['target'] : '_self';
                                        ?>
                                        <a href="<?php echo esc_url($card['card_link']['url']); ?>"
                                            class="btn btn-sm secondary-btn double-right-btn" target="<?php echo esc_attr($target); ?>">
                                            <?php echo esc_html($card['card_link']['title']); ?>
                                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/double-right-black-new.svg"
                                                alt="">
                                        </a>
                                    <?php endif; ?>
                                </div>

                            </div>
                        <?php endforeach; ?>

                    </div>
                <?php endif; ?>

            <?php endif; ?>

        </div>
    </section>

<?php endif; ?>