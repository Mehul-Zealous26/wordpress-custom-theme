<?php
$pre_title = get_sub_field('pre_title');
$title = get_sub_field('title');
$description = get_sub_field('description');
$first_button = get_sub_field('first_button');
$second_button = get_sub_field('second_button');
$select_spacer = get_sub_field('select_spacer');
$padding_style = get_spacer_padding_style($select_spacer);

$current_product_id = get_the_ID();
$resources = new WP_Query([
    'post_type' => 'product_resources',
    'posts_per_page' => -1,
    'meta_query' => [
        [
            'key' => 'parent_product_list',
            'value' => $current_product_id,
            'compare' => 'LIKE'
        ]
    ]
]);

if ($resources->have_posts()):
?>
    <section class="product-guide-section" id="product_resources_section" <?php if ($padding_style)
                                                                                echo 'style="' . esc_attr($padding_style) . '"'; ?> id="product_resources_section">
        <div class="container-box">
            <div class="sub-title-with-text w-600 text-content-section">
                <?php if ($pre_title) { ?>
                    <div class="sub-heading">
                        <?php echo esc_html($pre_title); ?>
                    </div>
                <?php } ?>
                <?php if ($title) { ?>
                    <?php echo ($title); ?>
                <?php } ?>
                <?php if ($description) { ?>
                    <?php echo ($description); ?>
                <?php } ?>
            </div>
            <div class="product-guide-main">
                <?php
                while ($resources->have_posts()):
                    $resources->the_post();
                    $resource_file = get_field('resource_file');
                    $featured_image = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
                    $fallback_image = get_template_directory_uri() . '/assets/images/default-image.jpeg';

                    if ($resource_file):
                        $file_url = $resource_file['url'];
                        $file_name = $resource_file['filename'];
                        $file_size = size_format($resource_file['filesize']);
                        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
                ?>
                        <a href="<?php echo esc_url($file_url); ?>" class="product-guide-box" target="_blank">
                            <div class="product-guide-img-wrap">
                                <div class="product-guide-img">
                                    <div class="product-guide-sub-img"></div>
                                    <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium') ?: $fallback_image); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                                </div>
                            </div>
                            <div class="user-guide-desc">
                                <label><?php echo esc_html($file_name); ?></label>
                                <span><?php echo esc_html(get_the_title()); ?></span>
                                <i>.<?php echo esc_html($file_ext); ?> <?php echo esc_html($file_size); ?></i>
                            </div>
                        </a>
                <?php
                    endif;
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
            <?php if ($first_button || $second_button) { ?>
                <div class="button-box">

                    <?php if ($first_button) {
                        $target = $first_button['target'] ? $first_button['target'] : '_self';
                    ?>
                        <a href="<?php echo esc_url($first_button['url']); ?>" target="<?php echo esc_attr($target); ?>"
                            class="btn secondary-btn">
                            <?php echo esc_html($first_button['title']); ?>
                        </a>
                    <?php } ?>

                    <?php if ($second_button) {
                        $target = $second_button['target'] ? $second_button['target'] : '_self';
                    ?>
                        <a href="<?php echo esc_url($second_button['url']); ?>" target="<?php echo esc_attr($target); ?>"
                            class="btn primary-btn">
                            <?php echo esc_html($second_button['title']); ?>
                        </a>
                    <?php } ?>

                </div>
            <?php } ?>
        </div>
    </section>
<?php endif; ?>