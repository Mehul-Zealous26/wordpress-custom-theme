<?php

$image = get_sub_field('banner_image');

?>

<div class="banner">

    <h2><?php echo get_sub_field('banner_heading'); ?></h2>

    <h4><?php echo get_sub_field('banner_description'); ?></h4>

    <?php if ($image) : ?>

        <img src="<?php echo $image['url']; ?>">

    <?php endif; ?>

</div>