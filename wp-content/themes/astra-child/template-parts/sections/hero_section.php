<?php
$media_type = get_sub_field('media_type');
$hero_title = get_sub_field('hero_title');
$hero_description = get_sub_field('hero_description');
$hero_image = get_sub_field('hero_image');
$hero_video_url = get_sub_field('hero_video_url');
?>

<div class="hero-section">

    <div class="hero-content">
        <h1><?php echo ($hero_title); ?></h1>
        <p><?php echo ($hero_description); ?></p>
    </div>

    <div class="hero-media">
        <?php if ($media_type === "image" ): ?>
            <img src="<?php echo ($hero_image['url']); ?>"
                 alt="<?php echo ($hero_image['alt']); ?>">
        <?php endif; ?>

        <?php if ($media_type === "video"): ?>
            <?php echo ($hero_video_url); ?>
        <?php endif; ?>
    </div>

</div>