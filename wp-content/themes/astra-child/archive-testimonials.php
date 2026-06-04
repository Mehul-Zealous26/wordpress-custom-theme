<?php get_header(); ?>
<section class="testimonial-section">

    <div class="section-title">
        <h2>Client Testimonials</h2>
        <p>What our clients say about our services.</p>
    </div>

    <div class="testimonial-container">

        <?php

        $args = array(
            'post_type' => 'testimonials',
            'posts_per_page' => -1
        );

        $testimonials = new WP_Query($args);

        if ($testimonials->have_posts()) :

            while ($testimonials->have_posts()) :

                $testimonials->the_post();

        ?>

                <div class="testimonial-card">

                    <?php

                    $image = get_field('client_image');

                    if ($image) {

                    ?>

                        <img src="<?php echo $image['url']; ?>" alt="">

                    <?php } ?>

                    <h3><?php the_title(); ?></h3>

                    <span>
                        <?php echo get_field('client_position'); ?>
                    </span>

                    <p>
                        <?php echo get_field('client_review'); ?>
                    </p>

                </div>

        <?php

            endwhile;

            wp_reset_postdata();

        endif;

        ?>

    </div>

</section>

<?php get_footer(); ?>