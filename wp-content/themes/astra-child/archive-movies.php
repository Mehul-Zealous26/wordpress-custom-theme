<?php get_header(); ?>

<h1 class="heading">All Movies</h1>
<div class="movie-container">
    <?php
        if (have_posts()) :
            while (have_posts()) : the_post();

    ?>
            <div class="movie-card">
                <div class="movie-image">
                    <?php
                    $movie_image = get_field('movie_banner');
                    if ($movie_image) {
                    ?>
                        <img src="<?php echo $movie_image['url']; ?>" alt="">
                    <?php
                    }
                    ?>
                </div>
                <div class="movie-content">
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
            </div>
    <?php
        endwhile;
    endif;
    ?>
</div>

<?php get_footer(); ?>