<?php
$section_title = get_sub_field('section_title');
$description = get_sub_field('description');
$resoures = get_sub_field('resoures'); //type=post-object, filterby: 'post_type' => 'product_resources',
$bottom_text = get_sub_field('bottom_text');
$select_spacer = get_sub_field('select_spacer');
$padding_style = get_spacer_padding_style($select_spacer);


?>
<section class="faq-section-main" id="resource_download_section" <?php if ($padding_style) echo 'style="' . esc_attr($padding_style) . '"'; ?>>
    <div class="faq-right-s-box">
        <div class="faq-download-section">
            <?php if (!empty($section_title)) : ?>
                <h5><?php echo esc_html($section_title); ?></h5>
            <?php endif; ?>

            <?php if (!empty($description)) : ?>
                <?php echo $description; ?>
            <?php endif; ?>
            <div class="faq-download-row">
                <?php if (!empty($resoures)) : ?>

                    <?php foreach ($resoures as $post) : setup_postdata($post);

                        $resource_file = get_field('resource_file', $post->ID);
                        $featured_image = get_the_post_thumbnail_url($post->ID, 'thumbnail');
                        $fallback_image = get_stylesheet_directory_uri() . '/assets/images/File-type-icon.svg';

                        if ($resource_file) :
                            $file_url  = $resource_file['url'];
                            $file_name = $resource_file['filename'];
                            $file_size = size_format($resource_file['filesize'], 2);
                            $file_ext  = strtoupper(pathinfo($file_name, PATHINFO_EXTENSION));
                    ?>
                            <a href="<?php echo esc_url($file_url); ?>" class="product-guide-box" target="_blank">
                                <div class="product-guide-img-wrap ssss">
                                    <div class="product-guide-img">
                                        <div class="product-guide-sub-img"></div>
                                        <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium') ?: $fallback_image); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                                    </div>
                                </div>
                                <div class="user-guide-desc">
                                    <label><?php echo esc_html(get_the_title()); ?></label>
                                    <span><?php echo esc_html($file_name); ?></span>
                                    <i class="file-type">
                                        <?php echo esc_html($file_ext . ' ' . $file_size); ?>
                                    </i>
                                </div>
                            </a>
                    <?php
                        endif;

                    endforeach;

                    wp_reset_postdata(); ?>

                <?php endif; ?>
            </div>
            <?php if (!empty($bottom_text)) : ?>
                <p><?php echo esc_html($bottom_text); ?></p>
            <?php endif; ?>
        </div>
    </div>
</section>