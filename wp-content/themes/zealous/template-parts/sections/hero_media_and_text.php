<?php
$layout                   = get_sub_field('layout');
$bg_image_companion       = get_sub_field('bg_image_companion');
$pre_title                = get_sub_field('pre_title');
$title                    = get_sub_field('title');
$description              = get_sub_field('description');
$primary_button           = get_sub_field('primary_button');
$secondary_button         = get_sub_field('secondary_button');

$upload_gif               = get_sub_field('upload_gif');
$media_type               = get_sub_field('select_media_type_h');
$banner_image             = get_sub_field('banner_image');
$banner_image_gif         = get_sub_field('banner_image_gif');
$hosted_video             = get_sub_field('hosted_video');
$embed_video              = get_sub_field('embed_video');
$enable_hotspot           = get_sub_field('enable_hotspot');

$image_video_layout_style = get_sub_field('image_video_layout_style');
$layout_class             = $image_video_layout_style ? $image_video_layout_style : ' ';
$title_alignment          = get_sub_field('title_alignment');
$title_alignment_class    = ($title_alignment === 'p-f-video-mdv') ? 'p-f-video-mdv' : '';
$background_color         = get_sub_field('background_color');
$select_spacer            = get_sub_field('select_spacer');
$padding_style            = get_spacer_padding_style($select_spacer);

/* --------------------------------
 * GIF MODE CHECK
 * -------------------------------- */
$is_gif_mode = ($upload_gif == 1 || $upload_gif === true || $media_type === 'banner_image_gif' || $media_type === 'gif');

/* --------------------------------
 * MEDIA CHECK
 * -------------------------------- */
if ($is_gif_mode) {
    $has_media = (!empty($banner_image_gif) && !empty($banner_image_gif['url']));
} else {
    $has_media = (
        ($media_type === 'image'        && !empty($banner_image)  && !empty($banner_image['url'])) ||
        ($media_type === 'hosted_video' && !empty($hosted_video)) ||
        ($media_type === 'embed_video'  && !empty($embed_video))
    );
}

$is_bg_layout = ($layout === 'main-banner-bg');
$bg_class     = $is_bg_layout ? 'main-banner-bg' : '';
$bg_style     = ($is_bg_layout && !empty($banner_image['url']))
    ? 'background: url(' . esc_url($banner_image['url']) . ') center no-repeat; background-size: cover;'
    : '';
?>

<section
    class="main-banner-section full-height-banner <?php echo esc_attr($layout_class . ' ' . $bg_class . ' ' . $background_color); ?>"
    <?php if ($bg_style || $padding_style): ?> style="<?php
        echo esc_attr($bg_style);
        echo ($bg_style && $padding_style) ? ' ' : '';
        echo esc_attr($padding_style);
    ?>" <?php endif; ?>
    id="hero_media_and_text">

    <div class="container-box">

        <!-- ── TEXT COLUMN ── -->
        <div class="main-banner-text-box sub-title-with-text main-banner-col <?php echo esc_attr($title_alignment_class); ?> text-content-section">

            <?php if (!empty($pre_title)): ?>
                <div class="sub-heading"><?php echo esc_html($pre_title); ?></div>
            <?php endif; ?>

            <?php if (!empty($title)): ?>
                <?php echo $title; ?>
            <?php endif; ?>

            <?php echo $description; ?>

            <?php if (!empty($primary_button) || !empty($secondary_button)): ?>
                <div class="button-box">

                    <?php if (!empty($primary_button)):
                        $target = !empty($primary_button['target']) ? $primary_button['target'] : '_self';
                    ?>
                        <a href="<?php echo esc_url($primary_button['url']); ?>"
                           target="<?php echo esc_attr($target); ?>"
                           rel="<?php echo ($target === '_blank') ? 'noopener noreferrer' : ''; ?>"
                           class="btn secondary-btn">
                            <?php echo esc_html($primary_button['title']); ?>
                        </a>
                    <?php endif; ?>

                    <?php if (!empty($secondary_button)):
                        $target = !empty($secondary_button['target']) ? $secondary_button['target'] : '_self';
                    ?>
                        <a href="<?php echo esc_url($secondary_button['url']); ?>"
                           target="<?php echo esc_attr($target); ?>"
                           rel="<?php echo ($target === '_blank') ? 'noopener noreferrer' : ''; ?>"
                           class="btn primary-btn">
                            <?php echo esc_html($secondary_button['title']); ?>
                        </a>
                    <?php endif; ?>

                </div>
            <?php endif; ?>

        </div>

        <!-- ── MEDIA COLUMN ── -->
        <?php if ($has_media): ?>

            <div class="main-banner-img-box main-banner-col">

                <?php
                /* --------------------------------
                 * GIF
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
                elseif ($media_type === 'embed_video' && !empty($embed_video)):

                    // 1. Direct Bunny CDN MP4 URL
                    if (strpos($embed_video, 'b-cdn.net') !== false && strpos($embed_video, '.mp4') !== false) {

                        echo '<div style="width:100%;aspect-ratio:16/9;">
                            <video
                                style="width:100%;height:100%;display:block;object-fit:contain;"
                                playsinline loop muted preload="metadata" controls>
                                <source src="' . esc_url($embed_video) . '" type="video/mp4">
                            </video>
                        </div>';

                    // 2. Pasted iframe (Bunny or any provider)
                    } elseif (strpos($embed_video, '<iframe') !== false) {

                        $embed_video = preg_replace('/<div[^>]*>(\s*<iframe)/i', '$1', $embed_video);
                        $embed_video = preg_replace('/<\/iframe>\s*<\/div>/i', '</iframe>', $embed_video);
                        $embed_video = str_replace('responsive=true', 'responsive=false', $embed_video);
                        $embed_video = preg_replace(
                            '/(<iframe)([^>]*)\sstyle="[^"]*"/i',
                            '$1$2 style="width:100%;height:100%;border:0;display:block;"',
                            $embed_video
                        );
                        $embed_video = '<div style="width:100%;aspect-ratio:16/9;overflow:hidden;">'
                            . $embed_video
                            . '</div>';

                        echo wp_kses($embed_video, [
                            'div'    => ['style' => true, 'class' => true],
                            'iframe' => [
                                'src' => true, 'width' => true, 'height' => true,
                                'frameborder' => true, 'allow' => true, 'allowfullscreen' => true,
                                'loading' => true, 'style' => true, 'title' => true, 'class' => true,
                            ],
                        ]);

                    // 3. YouTube / Vimeo oEmbed URL
                    } else {

                        $oembed = wp_oembed_get($embed_video);

                        if ($oembed) {
                            echo $oembed;
                        } else {
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
                elseif ($media_type === 'hosted_video' && !empty($hosted_video)):
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