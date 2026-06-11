<section class="main-banner-section project-banner project-detail-banner">
    <div class="main-banner-swiper swiper">
        <div class="swiper-wrapper">
            <?php
            if (have_rows("banner_swiper")) :
                while (have_rows("banner_swiper")) : the_row();
                    $projects = get_sub_field("projects");
                    if ($projects):
                        foreach ($projects as $project):
                            $project_id = $project->ID;
                            $background_image = get_field("background_image", $project_id);
                            $project_title = get_field("project_title", $project_id);
                            $client_name = get_field("client_name", $project_id);
                            $location = get_field("location", $project_id);
                            $view_Project = get_field("view_project",$project_id);
            ?>
                            <div class="banner-slider swiper-slide">
                                <div class="banner-btn">
                                    <a href="<?php echo $view_Project; ?>" class="btn secondary-btn double-right-btn">View Project</a>
                                </div>
                                <img class="banner-slider-img" src="<?php echo $background_image['url']; ?>" alt="Banner Image">
                                <div class="">
                                    <div class="project-banner-cont">
                                        <h2><?php echo $project_title; ?></h2>

                                    </div>
                                    <div class="project-banner-info">
                                        <label for=""><?php echo $client_name; ?></label>
                                        <span><?php echo $location; ?></span>
                                    </div>
                                </div>
                            </div>
            <?php
                        endforeach;
                    endif;
                endwhile;
            endif;
            ?>
        </div>
        <div class="banner-slider-cont" style="padding-bottom: 50px;">
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>  

