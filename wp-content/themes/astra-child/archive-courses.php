<?php get_header(); ?>
<h1 class=" heading">All Courses</h1>
<div class="movie-container">
    <?php
        if ( have_posts() ) :
            while ( have_posts() ) : the_post();
    ?>
    <div class="movie-card">
        <div class="movie-content">
            <h2><?php the_title(); ?></h2>
        <p>
            <strong>Course Name</strong>
            <?php echo get_field('course_name') ?>
        </p>
        <p>
            <strong>Course Duration</strong>
            <?php echo get_field('course_duration') ?>
        </p>
        <p>
            <strong>Course Fees</strong>
            <?php echo get_field('course_fees') ?>
        </p>
        <p>
            <strong>trainer name</strong>
            <?php echo get_field('trainer_name') ?>
        </p>
        <p>
            <strong>start Date</strong>
            <?php echo get_field('start_date') ?>
        </p>
        </div>
    </div>
    <?php
        endwhile;
    endif;
    ?>
</div>

<?php get_footer();?>
