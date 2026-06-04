<?php
$pre_title = get_sub_field('pre_title');
$title = get_sub_field('title');
$description = get_sub_field('description');
$primary_button = get_sub_field('primary_button');
$secondary_button = get_sub_field('secondary_button');
$latest_blogs = get_sub_field('latest_blogs'); //type =post object
$select_spacer = get_sub_field('select_spacer');
$padding_style = get_spacer_padding_style($select_spacer);
if ($latest_blogs):
    ?>

    <section class="latest-blog-section" <?php if ($padding_style)
        echo 'style="' . esc_attr($padding_style) . '"'; ?>
        id="latest_blog_section">
        <div class="container-box">
            <div class="title-text-with-btn">
                <?php if ($pre_title): ?>
                    <div class="sub-title-with-text w-600 text-content-section">
                        <div class="sub-heading"><?php echo esc_html($pre_title); ?></div>
                        <?php echo ($title); ?>
                        <?php echo ($description); ?>
                    </div>
                <?php endif; ?>

                <div class="title-btn">

                    <?php if ($secondary_button):
                        $target = !empty($secondary_button['target']) ? $secondary_button['target'] : '_self';
                        ?>
                        <a href="<?php echo esc_url($secondary_button['url']); ?>" target="<?php echo esc_attr($target); ?>"
                            rel="<?php echo ($target === '_blank') ? 'noopener noreferrer' : ''; ?>" class="btn secondary-btn">
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
            </div>
            <div class="latest-blog-box">
                <?php if ($latest_blogs): ?>
                    <?php foreach ($latest_blogs as $post):
                        setup_postdata($post); ?>
                        <a href="<?php echo get_permalink(); ?>" class="blog-list-box">
                            <div class="blog-img-box">
                                <?php if (has_post_thumbnail(get_the_ID())): ?>
                                    <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>"
                                        alt="<?php echo get_the_title(); ?>">
                                <?php else: ?>
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/new-img.jpg"
                                        alt="<?php echo get_the_title(); ?>">
                                <?php endif; ?>
                            </div>
                            <div class="blog-list-info">
                                <div class="blog-list-date"><?php echo get_the_date('l, j F Y'); ?></div>
                                <h6><?php echo get_the_title(); ?></h6>
                                <div class="blog-list-tags">
                                    <?php
                                    $tags = get_the_tags();
                                    if ($tags) {
                                        foreach ($tags as $tag) {
                                            echo '<span>' . esc_html($tag->name) . '</span>';
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </a>
                    <?php endforeach;
                    wp_reset_postdata(); ?>
                <?php endif; ?>
                <div class="clr"></div>
            </div>
            <div class="latest-blog-box latest-blog-slider swiper">
                <div class="swiper-wrapper">
                    <?php if ($latest_blogs): ?>
                        <?php foreach ($latest_blogs as $post):
                            setup_postdata($post); ?>
                            <a href="<?php echo get_permalink(); ?>" class="blog-list-box swiper-slide">
                                <div class="blog-img-box">
                                    <?php if (has_post_thumbnail(get_the_ID())): ?>
                                        <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>"
                                            alt="<?php echo get_the_title(); ?>">
                                    <?php else: ?>
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/new-img.jpg"
                                            alt="<?php echo get_the_title(); ?>">
                                    <?php endif; ?>
                                </div>
                                <div class="blog-list-info">
                                    <div class="blog-list-date"><?php echo get_the_date('l, j F Y'); ?></div>
                                    <h6><?php echo get_the_title(); ?></h6>
                                    <div class="blog-list-tags">
                                        <?php
                                        $tags = get_the_tags();
                                        if ($tags) {
                                            foreach ($tags as $tag) {
                                                echo '<span>' . esc_html($tag->name) . '</span>';
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach;
                        wp_reset_postdata(); ?>
                    <?php endif; ?>
                </div>
                <div class="slider-bottom-cont">
                    <div class="swiper-pagination"></div>
                    <div class="sider-arrow-box">
                        <div class="swiper-button-prev latest-blog-slider-prev slider-arrow"></div>
                        <div class="swiper-button-next latest-blog-slider-next slider-arrow"></div>
                    </div>
                </div>
                <div class="clr"></div>
            </div>
        </div>
    </section>
<?php endif; ?>