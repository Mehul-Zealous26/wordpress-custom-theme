<?php get_header(); ?>

<h1>My Custom Theme</h1>

<?php
if (have_posts()) :
    while (have_posts()) :
        the_post();
        the_content();
    endwhile;
endif;
?>

<?php get_footer(); ?>