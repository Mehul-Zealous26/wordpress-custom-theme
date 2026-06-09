<?php
$select_video_type = get_sub_field('select_video_type'); //type=select
// echo $select_video_type; exit;
$hosted_video = get_sub_field('hosted_video');  //type=file
$embeded_video = get_sub_field('embeded_video'); //type=oEmbed
$select_spacer = get_sub_field('select_spacer');
$padding_style = get_spacer_padding_style($select_spacer);
?>

<section class="video-section-main" <?php if ($padding_style) echo 'style="' . esc_attr($padding_style) . '"'; ?> id="background_video">
    <div class="container-box">
        <?php if ($select_video_type === 'hosted-video' && $hosted_video): ?>
            <video controls>
                <source src="<?php echo esc_url($hosted_video['url']); ?>" type="<?php echo esc_attr($hosted_video['mime_type']); ?>">
            </video>
        <?php elseif ($select_video_type === 'embeded-video' && $embeded_video): ?>
            <?php echo $embeded_video; ?>
        <?php endif; ?>
    </div>
</section>