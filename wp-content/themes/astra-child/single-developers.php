<?php get_header(); ?>

<section class="single-developer">

    <?php

    if (have_posts()) :

        while (have_posts()) : the_post();

    ?>

            <div class="developer-card">

                <?php

                $developer_image = get_field('developer_image');

                if ($developer_image) {

                ?>

                    <img src="<?php echo $developer_image['url']; ?>" alt="">

                <?php

                }

                ?>

                <h1><?php the_title(); ?></h1>

                <h3>
                    <?php echo get_field('developer_designation'); ?>
                </h3>

                <p>
                    <?php echo get_field('developer_skills'); ?>
                </p>

            </div>

    <?php

        endwhile;

    endif;

    ?>

</section>

<style>
    .single-developer {

        width: 80%;
        margin: 60px auto;

    }

    .developer-card {

        background: white;
        padding: 40px;
        border-radius: 15px;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);

    }

    .developer-card img {

        width: 180px;
        height: 180px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 20px;

    }

    .developer-card h1 {

        font-size: 36px;
        margin-bottom: 10px;

    }

    .developer-card h3 {

        color: blue;
        margin-bottom: 20px;

    }

    .developer-card p {

        font-size: 18px;
        color: #555;

    }
</style>

<?php get_footer(); ?>