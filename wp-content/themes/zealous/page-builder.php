<?php
/*
Template Name: Page Builder
*/
get_header();
?>

<main id="site-content" role="main">

<?php 
$acf_post_id = get_query_var('acf_post_id', get_the_ID());

if( have_rows('page_sections', $acf_post_id) ): 
    while( have_rows('page_sections', $acf_post_id) ): the_row();

        $layout = get_row_layout();
        $template_file = locate_template("template-parts/sections/{$layout}.php");

        if ($template_file) {
            include $template_file;
        } else {
            echo "<!-- Section template not found: {$layout} -->";
        }

    endwhile;
endif;
?>

</main>


<?php get_footer(); ?>
