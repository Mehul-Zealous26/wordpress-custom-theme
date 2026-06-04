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
                <strong>Actor:</strong>
                <?php echo get_field('actor_name'); ?>
            </p>
            <p class="rating">
                ⭐ Rating:
                <?php echo get_field('rating'); ?>/10
            </p>
            <p>
                <strong>Release Date:</strong>
                <?php echo get_field('release_year'); ?>
            </p>
            <p>
                <strong>Genre:</strong>
                <?php
                $genres = get_the_terms(get_the_ID(), 'genre');
                if ($genres) {
                    foreach ($genres as $genre) {
                        echo $genre->name . ' ';
                    }
                }
                ?>
            </p>

        </div>

<?php

    endwhile;

endif;

?>

<?php get_footer(); ?>