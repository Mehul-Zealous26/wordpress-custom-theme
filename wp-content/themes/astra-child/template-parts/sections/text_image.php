<?php
$layout = get_sub_field('layout');
$title = get_sub_field('title');
$description = get_sub_field('description');
$image = get_sub_field('image');
$editor_right = get_sub_field('editor_right');
$gallery = get_field('gallery');
$location = get_sub_field('location');
$link = get_sub_field('product_link');
$faqs = get_field('faqs');
?>

<div class="text-image <?php echo $layout; ?>">

    <div class="content">
        <h2><?php echo $title; ?></h2>
        <?php echo $description; ?>
        <h6>Location : <?php echo $location; ?></h6>
        <h6><?php echo $link; ?></ h6>
            <div class="image">
                <?php if ($image): ?>
                    <img src="<?php echo $image['url']; ?>" alt="">
                <?php endif; ?>
            </div>
    </div>

    <div class="faqs">
        <h2>Frequently Asked Questions ?</h2>
        <div class="faqs">
            <?php if ($faqs): ?>
                <?php foreach ($faqs as $faq): ?>
                    <h3><?php echo $faq['question']; ?></h3>
                    <p><?php echo $faq['answer']; ?></p>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <?php if ($gallery): ?>
        <div class="image">
            <h4>Gallery</h4>
            <?php foreach ($gallery as $gallery_image): ?>
                <img src="<?php echo $gallery_image['url']; ?>" alt="<?php echo $gallery_image['alt']; ?>">
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

