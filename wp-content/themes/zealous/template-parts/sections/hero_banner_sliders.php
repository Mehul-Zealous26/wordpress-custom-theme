<?php
$layout_alingment = get_sub_field('layout_alingment');
$layout_slider = get_sub_field('layout_slider');
$background_color = get_sub_field('background_color');
$banner_slides = get_sub_field('banner_slides');
$slide_count   = is_array($banner_slides) ? count($banner_slides) : 0;
$select_spacer = get_sub_field('select_spacer');
$padding_style = get_spacer_padding_style($select_spacer);
?>
<?php if ($layout_slider == 'normal-slider') { ?>
    <section class="main-banner-section <?php echo ($layout_alingment === 'content-center') ? 'main-banner-section-center ' : '' . $background_color; ?>" <?php if ($padding_style) echo 'style="' . esc_attr($padding_style) . '"'; ?> id="hero_banner_sliders">

        <div class="main-banner-swiper swiper">
            <div class="swiper-wrapper">
                <?php if (have_rows('banner_slides')): ?>
                    <?php while (have_rows('banner_slides')): the_row();
                        $slide_type = get_sub_field('slide_type');
                        $slide_image = get_sub_field('slide_image');
                        $slide_video = get_sub_field('slide_video');
                        $slide_title = get_sub_field('slide_title');
                        $slide_content = get_sub_field('slide_content');
                        $primary_button = get_sub_field('primary_button');
                        $secondary_button = get_sub_field('secondary_button');
                    ?>
                        <div class="banner-slider swiper-slide">
                            <?php if ($slide_type === 'video' && $slide_video): ?>
                                <video class="banner-slider-img" autoplay muted loop>
                                    <source src="<?php echo esc_url($slide_video['url']); ?>" type="<?php echo esc_attr($slide_video['mime_type']); ?>">
                                </video>
                            <?php elseif ($slide_image): ?>
                                <img class="banner-slider-img" src="<?php echo esc_url($slide_image['url']); ?>" alt="<?php echo esc_attr($slide_image['alt'] ?: $slide_title); ?>">
                            <?php endif; ?>

                            <div class="banner-slider-container-full text-content-section">
                                <?php if ($slide_title): ?>
                                    <?php echo ($slide_title); ?>
                                <?php endif; ?>

                                <?php if ($slide_content): ?>
                                    <?php echo ($slide_content); ?>
                                <?php endif; ?>

                                <?php if ($primary_button || $secondary_button): ?>
                                    <div class="banner-btn">
                                        <?php if ($primary_button):
                                            $target = $primary_button['target'] ? $primary_button['target'] : '_self';
                                            ?>
                                            <a href="<?php echo esc_url($primary_button['url']); ?>" class="btn trans-btn" target="<?php echo esc_attr($target); ?>">
                                                <?php echo esc_html($primary_button['title']); ?>
                                            </a>
                                        <?php endif; ?>

                                        <?php if ($secondary_button): ?>
                                            <a href="<?php echo esc_url($secondary_button['url']); ?>" class="btn secondary-btn" <?php echo $secondary_button['target'] ? 'target="' . esc_attr($secondary_button['target']) . '"' : ''; ?>>
                                                <?php echo esc_html($secondary_button['title']); ?>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
            <?php if ($slide_count > 1): ?>
            <div class="banner-slider-cont">
                <div class="swiper-button-prev banner-slider-prev"></div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next banner-slider-next"></div>
            </div>
            <?php endif; ?>
        </div>
        </div>
    </section>
<?php } elseif ($layout_slider == 'floating-slider') { ?>
    <section class="main-banner-section multi-img-slider-main  main-banner-section-full <?php echo $background_color; ?>" <?php if ($padding_style) echo 'style="' . esc_attr($padding_style) . '"'; ?>>
        <div class="container-box">
            <div class="main-banner-text-box sub-title-with-text main-banner-col text-content-section">
                <?php

                $floating_slide_pre_title = get_sub_field('floating_slide_pre_title');
                $floating_slide_title = get_sub_field('floating_slide_title');
                $floating_slide_content = get_sub_field('floating_slide_content');
                $floating_primary_button = get_sub_field('floating_primary_button');
                $floating_secondary_button = get_sub_field('floating_secondary_button');
                ?>

                <?php if ($floating_slide_pre_title): ?>
                    <div class="sub-heading"><?php echo esc_html($floating_slide_pre_title); ?></div>
                <?php endif; ?>

                <?php if ($floating_slide_title): ?>
                <?php echo ($floating_slide_title); ?>
                <?php endif; ?>

                <?php if ($floating_slide_content): ?>
               <?php echo ($floating_slide_content); ?>
                <?php endif; ?>

                <?php if ($floating_primary_button || $floating_secondary_button): ?>
                    <div class="button-box">
                        <?php if ($floating_secondary_button): ?>
                            <a href="<?php echo esc_url($floating_secondary_button['url']); ?>" class="btn secondary-btn" <?php echo $floating_secondary_button['target'] ? 'target="' . esc_attr($floating_secondary_button['target']) . '"' : ''; ?>>
                                <?php echo esc_html($floating_secondary_button['title']); ?>
                            </a>
                        <?php endif; ?>

                        <?php if ($floating_primary_button): ?>
                            <a href="<?php echo esc_url($floating_primary_button['url']); ?>" class="btn primary-btn" <?php echo $floating_primary_button['target'] ? 'target="' . esc_attr($floating_primary_button['target']) . '"' : ''; ?>>
                                <?php echo esc_html($floating_primary_button['title']); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="multi-img-slider">
            <div class="swiper">
                <div class="swiper-wrapper">
                    <?php if (have_rows('floating_banner_slides')): ?>
                        <?php while (have_rows('floating_banner_slides')): the_row();
                            $slide_image = get_sub_field('slide_image');
                        ?>
                            <?php if ($slide_image): ?>
                                <div class="swiper-slide">
                                    <img src="<?php echo esc_url($slide_image['url']); ?>" alt="<?php echo esc_attr($slide_image['alt']); ?>">
                                </div>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
<?php } ?>