<?php
$layout = get_sub_field('layout');
$editor_right = get_sub_field('editor_right'); // true / false

$upload_gif = get_sub_field('upload_gif');
$media_type = get_sub_field('media_type');

$banner_image = get_sub_field('banner_image');
$banner_image_gif = get_sub_field('banner_image_gif');

$hosted_video = get_sub_field('hosted_video');
$embed_video = get_sub_field('embed_video');

$pretitle = get_sub_field('pretitle');
$title = get_sub_field('title');
$short_desc = get_sub_field('short_desc');

$primary_button = get_sub_field('primary_button');
$secondary_button = get_sub_field('secondary_button');

$image_video_layout_style = get_sub_field('image_video_layout_style');
$background_type = get_sub_field('background_type');

$enable_hotspot = get_sub_field('enable_hotspot');

$select_spacer = get_sub_field('select_spacer');
$padding_style = get_spacer_padding_style($select_spacer);

/* --------------------------------
 * GIF MODE CHECK
 * -------------------------------- */
$is_gif_mode = ($upload_gif == 1 || $upload_gif === true || $media_type === 'banner_image_gif' || $media_type === 'gif');

/* --------------------------------
 * MEDIA CHECK
 * -------------------------------- */
if ($is_gif_mode) {

    $has_media = (
        !empty($banner_image_gif) &&
        !empty($banner_image_gif['url'])
    );
} else {

    $has_media = (
        ($media_type === 'image' && !empty($banner_image) && !empty($banner_image['url'])) ||
        ($media_type === 'hosted_video' && !empty($hosted_video)) ||
        ($media_type === 'embed_video' && !empty($embed_video))
    );
}

/* --------------------------------
 * LAYOUT CLASS HANDLING
 * -------------------------------- */
$video_layout_class = !empty($image_video_layout_style)
    ? $image_video_layout_style
    : 'product-f-video';

$layout_class = !empty($layout) ? $layout : '';

$background_class = !empty($background_type)
    ? $background_type
    : '';

/**
 * These layouts MUST NOT receive reverse-row
 */
$restricted_layouts = [
    'product-f-video p-f-video-full',
    'product-f-video p-f-video-full p-f-video-full-sm'
];

if (
    $layout === 'reverse-row' &&
    in_array($video_layout_class, $restricted_layouts, true)
) {
    $layout_class = '';
}

/* --------------------------------
 * SECTION CLASSES
 * -------------------------------- */
$section_classes = [
    $video_layout_class,
    $layout_class,
    $background_class
];

if (!$has_media) {
    $section_classes[] = 'product-f-text';
}
?>

<?php if ($editor_right == 1 || $editor_right === true) { ?>

    <section class="product-f-video p-f-video-md v-top left-right-text" id="text_with_image_video" <?php if (!empty($padding_style))
                                                                                                        echo 'style="' . esc_attr($padding_style) . '"'; ?>>

        <div class="container-box">

            <?php if (!empty($pretitle) || !empty($title)): ?>

                <div class="product-f-video-left sub-title-with-text text-content-section">

                    <?php if (!empty($pretitle)): ?>
                        <div class="sub-heading">
                            <span><?php echo esc_html($pretitle); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($title)): ?>
                        <?php echo ($title); ?>
                    <?php endif; ?>

                </div>

            <?php endif; ?>

            <?php if (!empty($short_desc)): ?>

                <div class="product-f-video-right text-content-section text-content-section">
                    <?php echo ($short_desc); ?>
                </div>

            <?php endif; ?>

        </div>
    </section>

<?php } else { ?>

    <section class="<?php echo esc_attr(implode(' ', array_filter($section_classes))); ?>" id="text_with_image_video" <?php if (!empty($padding_style))
                                                                                                                            echo 'style="' . esc_attr($padding_style) . '"'; ?>>

        <div class="container-box">

            <?php if (
                !empty($pretitle) ||
                !empty($title) ||
                !empty($short_desc) ||
                !empty($primary_button) ||
                !empty($secondary_button)
            ): ?>

                <div class="product-f-video-left sub-title-with-text text-content-section normal-bullets text-content-section">

                    <?php if (!empty($pretitle)): ?>
                        <div class="sub-heading">
                            <span><?php echo esc_html($pretitle); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($title)): ?>
                        <?php echo ($title); ?>
                    <?php endif; ?>

                    <?php if (!empty($short_desc)): ?>
                        <?php echo ($short_desc); ?>
                    <?php endif; ?>

                    <?php if (!empty($primary_button) || !empty($secondary_button)): ?>

                        <div class="button-box">

                            <?php if (
                                !empty($primary_button) &&
                                !empty($primary_button['url']) &&
                                !empty($primary_button['title'])
                            ): ?>

                                <a href="<?php echo esc_url($primary_button['url']); ?>" class="btn secondary-btn"
                                    target="<?php echo esc_attr($primary_button['target'] ?? '_self'); ?>">

                                    <?php echo esc_html($primary_button['title']); ?>

                                </a>

                            <?php endif; ?>

                            <?php if (
                                !empty($secondary_button) &&
                                !empty($secondary_button['url']) &&
                                !empty($secondary_button['title'])
                            ): ?>

                                <a href="<?php echo esc_url($secondary_button['url']); ?>" class="btn primary-btn"
                                    target="<?php echo esc_attr($secondary_button['target'] ?? '_self'); ?>">

                                    <?php echo esc_html($secondary_button['title']); ?>

                                </a>

                            <?php endif; ?>

                        </div>

                    <?php endif; ?>

                </div>

            <?php endif; ?>

            <?php if ($has_media): ?>

                <div class="product-f-video-right">

                    <?php
                    /* --------------------------------
                     * GIF IMAGE MODE
                     * -------------------------------- */
                    if (
                        $is_gif_mode &&
                        !empty($banner_image_gif) &&
                        !empty($banner_image_gif['url'])
                    ):
                    ?>

                        <img src="<?php echo esc_url($banner_image_gif['url']); ?>"
                            alt="<?php echo esc_attr(!empty($banner_image_gif['alt']) ? $banner_image_gif['alt'] : $title); ?>">

                    <?php
                    /* --------------------------------
                         * EMBED VIDEO
                         * -------------------------------- */
                    elseif (
                        $media_type === 'embed_video' &&
                        !empty($embed_video)
                    ):

                        // 1. Direct Bunny CDN MP4 URL
                        if (strpos($embed_video, 'b-cdn.net') !== false && strpos($embed_video, '.mp4') !== false) {

                            echo '<div style="width:100%;aspect-ratio: 9 / 16;">
            <video
                style="width:100%;height:100%;display:block;object-fit:contain;"
                playsinline
                loop
                muted
                preload="metadata"
                controls>
                <source src="' . esc_url($embed_video) . '" type="video/mp4">
            </video>
        </div>';

                            // 2. Admin pasted Bunny iframe or any iframe
                        } elseif (strpos($embed_video, '<iframe') !== false) {

                            // Remove Bunny wrapping div
                            $embed_video = preg_replace('/<div[^>]*>(\s*<iframe)/i', '$1', $embed_video);
                            $embed_video = preg_replace('/<\/iframe>\s*<\/div>/i', '</iframe>', $embed_video);

                            // Disable responsive mode (causes black bars)
                            $embed_video = str_replace('responsive=true', 'responsive=false', $embed_video);

                            // Force iframe styles
                            $embed_video = preg_replace(
                                '/(<iframe)([^>]*)\sstyle="[^"]*"/i',
                                '$1$2 style="width:100%;height:100%;border:0;display:block;"',
                                $embed_video
                            );

                            // Wrap with aspect-ratio container
                            $embed_video = '<div style="width:100%;aspect-ratio: 9 / 16;overflow:hidden;">'
                                . $embed_video
                                . '</div>';

                            echo wp_kses($embed_video, [
                                'div' => [
                                    'style' => true,
                                    'class' => true,
                                ],
                                'iframe' => [
                                    'src' => true,
                                    'width' => true,
                                    'height' => true,
                                    'frameborder' => true,
                                    'allow' => true,
                                    'allowfullscreen' => true,
                                    'loading' => true,
                                    'style' => true,
                                    'title' => true,
                                    'class' => true,
                                ],
                            ]);

                            // 3. YouTube / Vimeo oEmbed URL
                        } else {

                            $embed = wp_oembed_get($embed_video);

                            if ($embed) {

                                echo $embed;
                            } else {

                                // Fallback iframe
                                echo '<iframe
                src="' . esc_url($embed_video) . '"
                style="width:100%;height:100%;border:0;display:block;"
                loading="lazy"
                allow="accelerometer; gyroscope; autoplay; encrypted-media; picture-in-picture;"
                allowfullscreen>
            </iframe>';
                            }
                        }
                    /* --------------------------------
                         * HOSTED VIDEO
                         * -------------------------------- */
                    elseif (
                        $media_type === 'hosted_video' &&
                        !empty($hosted_video)
                    ):
                    ?>

                        <video controls preload="metadata" width="100%">
                            <source src="<?php echo esc_url($hosted_video); ?>" type="video/mp4">
                        </video>

                    <?php
                    /* --------------------------------
                         * IMAGE
                         * -------------------------------- */
                    elseif (
                        $media_type === 'image' &&
                        !empty($banner_image) &&
                        !empty($banner_image['url'])
                    ):

                        hotspot_render_image($banner_image, $enable_hotspot);

                    endif;
                    ?>

                </div>

            <?php endif; ?>

        </div>
    </section>

<?php } ?>