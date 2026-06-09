<?php
/**
 * Section: Product Range Banner
 */

$banner_title = get_sub_field('banner_title_left');
$banner_description = get_sub_field('banner_description_left');
$button1 = get_sub_field('action_button');
$button2 = get_sub_field('action_button2');
$button3 = get_sub_field('action_button3');
$banner_image = get_sub_field('banner_image');
?>

<section class="product-rang-banner with-banner-img" <?php if ($banner_image): ?>style="background: url('<?php echo esc_url($banner_image['url']); ?>') center no-repeat; background-size: cover;"
    <?php endif; ?> id="page_banner">
    <div class="container-full">
        <div class="product-rang-box">
            <div class="breadcrumbs-box">
                <?php custom_breadcrumbs(); ?>
            </div>

            <div class="product-rang-banner-text text-content-section">
                <?php if ($banner_title): ?>
                    <?php echo ($banner_title); ?>
                <?php endif; ?>

                <?php if ($banner_description): ?>
                    <?php echo ($banner_description); ?>
                <?php endif; ?>
            </div>

            <div class="product-rang-banner-tag product-rang-tag-box">
                <?php if ($button1): ?>
                    <span><a href="<?php echo esc_url($button1['url']); ?>"
                            target="<?php echo esc_attr($button1['target'] ?: '_self'); ?>"><?php echo esc_html($button1['title']); ?></a></span>
                <?php endif; ?>
                <?php if ($button2): ?>
                    <span><a href="<?php echo esc_url($button2['url']); ?>"
                            target="<?php echo esc_attr($button2['target'] ?: '_self'); ?>"><?php echo esc_html($button2['title']); ?></a></span>
                <?php endif; ?>
                <?php if ($button3): ?>
                    <span><a href="<?php echo esc_url($button3['url']); ?>"
                            target="<?php echo esc_attr($button3['target'] ?: '_self'); ?>"><?php echo esc_html($button3['title']); ?></a></span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>