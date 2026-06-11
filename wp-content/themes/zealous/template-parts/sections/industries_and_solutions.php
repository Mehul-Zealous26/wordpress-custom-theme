<?php
$pretitle = get_sub_field('pretitle');
$title = get_sub_field('title');
?>
<section class="category-tab-section" id="industries_and_soutions">
    <div class="container-box">
        <div class="sub-title-with-text sub-title-with-text-center w-600">
            <div class="sub-heading"><?php echo $pretitle; ?></div>
            <h2><?php echo $title; ?></h2>
        </div>
        <div class="category-tab-box-main">
            <div class="category-tab">
                <div class="category-tab-content active" id="retail">
                    <div class="category-tab-inner">
                        <?php $i = 0;
                        if (have_rows('image_slider')) :
                            while (have_rows('image_slider')) : the_row();
                                $image = get_sub_field('banner_image');
                                $arrow = get_sub_field('banner_sub_content_image');
                                $banner_title = get_sub_field('banner_title');
                                $banner_description = get_sub_field('banner_description');
                        ?>
                                <div class="category-sub-content <?php echo ($i == 0) ? 'active' : ''; ?>" id="content-tab-<?php echo $i; ?>">
                                    <div class="category-sub-card">
                                        <?php if ($image): ?>
                                            <img class="category-sub-card-img" src="<?php echo $image['url']; ?>">
                                        <?php endif; ?>
                                        <h3><?php echo $banner_title; ?></h3>
                                        <p><?php echo $banner_description; ?></p>
                                        <a href="#" class="btn double-right-btn"><?php echo get_sub_field('banner_sub_content') ?>
                                            <?php
                                            if ($arrow): ?>
                                                <img src="<?php echo $arrow['url']; ?>">
                                            <?php endif; ?>
                                        </a>
                                    </div>
                                </div>
                        <?php $i++;
                            endwhile;
                        endif;
                        ?>
                        <ul class="category-sub-tabs">
                            <?php $i = 0; ?>
                            <?php if (have_rows("image_slider")) :
                                while (have_rows("image_slider")) : the_row();
                                    $tab_name = get_sub_field('tab_name');
                            ?>
                                    <li class="industry-tab <?php echo ($i == 0) ? 'active' : ''; ?>" id="nav-tab-<?php echo $i; ?>">
                                        <?php echo $tab_name; ?>
                                    </li>
                            <?php
                                    $i++;
                                endwhile;
                            endif;
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>