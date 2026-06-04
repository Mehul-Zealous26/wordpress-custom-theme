<?php
$layout = get_sub_field('layout');
$pre_title = get_sub_field('pre_title');
$title = get_sub_field('title');
$description = get_sub_field('description');
$primary_button = get_sub_field('primary_button');
$secondary_button = get_sub_field('secondary_button');
$first_image = get_sub_field('first_image');
$second_image = get_sub_field('second_image');
$image_box_text = get_sub_field('image_box_text'); //type=group
$card_background_color = get_sub_field('card_background_color');
$layout_direction = get_sub_field('layout_direction');
$section_background_color = get_sub_field('section_background_color');
$select_spacer = get_sub_field('select_spacer');
$padding_style = get_spacer_padding_style($select_spacer);
?>
<?php
if ($layout == 'layout-one') {
    ?>
    <section class="product-f-video <?php echo esc_attr($section_background_color . " " . $layout_direction); ?>" <?php if ($padding_style)
               echo 'style="' . esc_attr($padding_style) . '"'; ?> id="image_gallery_content">
        <!--  reverse-row -->
        <div class="container-box">
            <div class="product-f-video-left sub-title-with-text text-content-section">
                <?php if ($pre_title): ?>
                    <div class="sub-heading">
                        <?php echo esc_html($pre_title); ?>
                    </div>
                <?php endif; ?>
                <?php if ($title): ?>
                    <?php echo ($title); ?>
                <?php endif; ?>
                <?php if ($description): ?>
                    <div>
                        <?php echo ($description); ?>
                    </div>
                <?php endif; ?>
                <div class="button-box">
                    <?php if ($primary_button): ?>
                        <a href="<?php echo esc_url($primary_button['url']); ?>" class="btn secondary-btn"
                            target="<?php echo esc_attr($primary_button['target'] ?? '_self'); ?>">
                            <?php echo esc_html($primary_button['title']); ?>
                        </a>
                    <?php endif; ?>

                    <?php if ($secondary_button): ?>
                        <a href="<?php echo esc_url($secondary_button['url']); ?>" class="btn primary-btn"
                            target="<?php echo esc_attr($secondary_button['target'] ?? '_self'); ?>">
                            <?php echo esc_html($secondary_button['title']); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="product-m-img">
                <div class="img-box-3">

                    <div class="img-box-text <?php echo $card_background_color; ?>">
                        <!-- yellow-bg / brand-bg / light-gray-bg -->
                        <?php if (have_rows('image_box_text')): ?>
                            <?php while (have_rows('image_box_text')):
                                the_row();
                                $sub_title = get_sub_field('sub_title');
                                $title = get_sub_field('title');
                                ?>
                                <?php if ($sub_title): ?>
                                    <span><?php echo esc_html($sub_title); ?></span>
                                <?php endif; ?>
                                <?php if ($title): ?>
                                    <h4><?php echo esc_html($title); ?></h4>
                                <?php endif; ?>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                    <div class="img-box-1">
                        <?php if ($first_image): ?>
                            <img src="<?php echo esc_url($first_image['url']); ?>"
                                alt="<?php echo esc_attr($first_image['alt']); ?>">
                        <?php endif; ?>
                    </div>
                    <div class="img-box-2">
                        <?php if ($second_image): ?>
                            <img src="<?php echo esc_url($second_image['url']); ?>"
                                alt="<?php echo esc_attr($second_image['alt']); ?>">
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php } else if ($layout == 'layout-two') { ?>
        <section class="product-f-video <?php echo esc_attr($section_background_color . " " . $layout_direction); ?>" <?php if ($padding_style)
                   echo 'style="' . esc_attr($padding_style) . '"'; ?>>
            <div class="container-box">
                <div class="product-f-video-left sub-title-with-text text-content-section">
                <?php if ($pre_title): ?>
                        <div class="sub-heading">
                        <?php echo esc_html($pre_title); ?>
                        </div>
                <?php endif; ?>
                <?php if ($title): ?>
                    <?php echo ($title); ?>
                <?php endif; ?>
                <?php if ($description): ?>

                    <?php echo ($description); ?>

                <?php endif; ?>
                   <div class="button-box">
                    <?php if ($primary_button): ?>
                        <a href="<?php echo esc_url($primary_button['url']); ?>" class="btn secondary-btn"
                            target="<?php echo esc_attr($primary_button['target'] ?? '_self'); ?>">
                            <?php echo esc_html($primary_button['title']); ?>
                        </a>
                    <?php endif; ?>

                    <?php if ($secondary_button): ?>
                        <a href="<?php echo esc_url($secondary_button['url']); ?>" class="btn primary-btn"
                            target="<?php echo esc_attr($secondary_button['target'] ?? '_self'); ?>">
                            <?php echo esc_html($secondary_button['title']); ?>
                        </a>
                    <?php endif; ?>
                </div>
                </div>
                <div class="product-m-img">
                    <div class="img-box-2-col">
                        <div class="img-box-f">
                        <?php if ($first_image): ?>
                                <img src="<?php echo esc_url($first_image['url']); ?>"
                                    alt="<?php echo esc_attr($first_image['alt']); ?>">
                        <?php endif; ?>
                        </div>
                        <div class="img-box-s">
                        <?php if ($second_image): ?>
                                <img src="<?php echo esc_url($second_image['url']); ?>"
                                    alt="<?php echo esc_attr($second_image['alt']); ?>">
                        <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

<?php } ?>