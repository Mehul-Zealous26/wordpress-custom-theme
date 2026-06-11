<?php
$title = get_sub_field("title");
$sub_heading = get_sub_field("sub_heading");
$description = get_sub_field("description");
$view_now = get_sub_field("view_now");
$banner_image = get_sub_field("banner_image");
?>
<section class="main-banner-section full-height-banner">
    <div class="container-box">
        <div class="main-banner-text-box sub-title-with-text main-banner-col">
            <div class="sub-heading"><?php echo $title; ?></div>
            <h1><?php echo $sub_heading; ?></h1>
            <p><?php echo $description; ?></p>
            <ul>
                <?php
                if (have_rows("sub_heading_list")) :
                    while (have_rows("sub_heading_list")) : the_row();
                        $list = get_sub_field("list");
                ?>
                        <li><?php echo $list; ?></li>
                <?php
                    endwhile;
                endif;
                ?>
            </ul>
            <div class="button-box">
                <a href="<?php echo $view_now; ?>" class="btn secondary-btn">View Now</a>
                <a href="<?php echo $view_now; ?>" class="btn primary-btn">View Now</a>
            </div>
        </div>
        <div class="main-banner-img-box main-banner-col">
            <img src="<?php echo $banner_image['url']; ?>" alt="">
        </div>
    </div>
</section>