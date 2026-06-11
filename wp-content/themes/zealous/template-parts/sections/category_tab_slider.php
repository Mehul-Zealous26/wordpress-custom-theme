<?php
$heading = get_sub_field("heading");
$sub_heading = get_sub_field("sub_heading");
?>
<section class="category-tab-section">
    <div class="container-box">
        <div class="sub-title-with-text sub-title-with-text-center w-600">
            <div class="sub-heading"><?php echo $heading; ?></div>
            <h2><?php echo $sub_heading; ?></h2>
        </div>
        <div class="category-tab-box-main">
            <div class="category-tab-title-box">
                <div class="category-tab-title"><span>1.</span> Select your business model</div>
                <div class="category-tab-title"><span>2.</span> Select your Area</div>
                <div class="category-tab-title last"><span>3.</span> Browse your item</div>
            </div>
            <div class="category-tab">
                <ul class="category-tab-list">
                    <?php
                    $i = 0;
                    if (have_rows("tab_slider")) :
                        while (have_rows("tab_slider")) : the_row();
                            $tab1_name = get_sub_field("tab1_name");
                    ?>
                            <li class="industry-tab <?php echo ($i == 0) ? 'active' : ''; ?>">
                                <?php echo $tab1_name; ?>
                            </li>
                    <?php
                            $i++;
                        endwhile;
                    endif;
                    ?>
                </ul>
                <div class="category-tab-inner">
                    <ul class="category-sub-tabs">
                        <?php
                        $i = 0;
                        if (have_rows("tab_slider")) :
                            while (have_rows("tab_slider")) : the_row();
                                $tab2_name = get_sub_field("tab2_name");
                        ?>
                                <li class="<?php echo ($i == 0) ? 'active' : ''; ?>">
                                    <?php echo $tab2_name; ?>
                                </li>
                        <?php
                                $i++;
                            endwhile;
                        endif;
                        ?>
                    </ul>
                    <?php
                    $i = 0;
                    if (have_rows("tab_slider")) :
                        while (have_rows("tab_slider")) : the_row();
                            $banner_image = get_sub_field('banner_image');
                            $banner_title = get_sub_field('banner_title');
                            $banner_description = get_sub_field('banner_description');
                            $banner_sub_content = get_sub_field('banner_sub_content');
                            $banner_sub_content_image = get_sub_field('banner_sub_content_image');
                    ?>
                            <div class="category-sub-content <?php echo ($i == 0) ? 'active' : ''; ?>" id="content-tab-<?php echo $i; ?>">
                                <div class="category-sub-card">
                                    <?php if ($banner_image) : ?>
                                        <img class="category-sub-card-img" src="<?php echo $banner_image['url']; ?>" alt="<?php echo $banner_title; ?>">
                                    <?php endif; ?>
                                    <h3><?php echo $banner_title; ?></h3>
                                    <p><?php echo $banner_description; ?></p>
                                    <hr>
                                    <a href="#" class="btn double-right-btn">
                                        <?php echo $banner_sub_content; ?>
                                        <?php if ($banner_sub_content_image) : ?>
                                            <img src="<?php echo $banner_sub_content_image; ?>" alt="Arrow">
                                        <?php endif; ?>
                                    </a>
                                </div>
                            </div>
                    <?php
                            $i++;
                        endwhile;
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>