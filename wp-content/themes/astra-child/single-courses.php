<?php get_header(); ?>

<style>
    body {
        background: #f4f7fb;
        font-family: Arial, sans-serif;
    }

    .single-movie {

        width: 40%;
        max-width: 850px;
        margin: 40px auto;
        background: #fff;
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);

    }

    .single-movie img {

        width: 100%;
        height: 350px;
        object-fit: cover;
        border-radius: 12px;

    }

    .single-movie h1 {

        margin: 20px 0 15px;
        font-size: 32px;
        color: #222;

    }

    .single-movie p {

        font-size: 16px;
        margin: 12px 0;
        color: #555;
        line-height: 1.6;

    }

    .single-movie strong {

        color: #111;

    }
</style>

<?php

if (have_posts()) :

    while (have_posts()) : the_post();

?>

        <div class="single-movie">

            <?php

            $movie_image = get_field('movie_banner');

            if ($movie_image) {
            ?>
                <img src="<?php echo $movie_image['url']; ?>" alt="">
            <?php
            }

            ?>

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

<?php

    endwhile;

endif;

?>

<?php get_footer(); ?>