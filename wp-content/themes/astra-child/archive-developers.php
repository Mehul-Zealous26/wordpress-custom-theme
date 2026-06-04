<?php get_header(); ?>
<section class="students-section">
    <?php

    $developers_page = get_page_by_path('developers');

    ?>

    <div class="section-title">

        <h2>
            <?php echo get_field('section_title', $developers_page->ID); ?>
        </h2>

        <p>
            <?php echo get_field('section_description', $developers_page->ID); ?>
        </p>

    </div>

    <div class="students-container">

        <?php

        $args = array(
            'post_type' => 'developers',
            'posts_per_page' => -1
        );

        $developers = new WP_Query($args);

        if ($developers->have_posts()) :

            while ($developers->have_posts()) : $developers->the_post();

        ?>

                <div class="student-card">

                    <?php

                    $developer_image = get_field('developer_image');

                    if ($developer_image) {

                    ?>

                        <img src="<?php echo $developer_image['url']; ?>" alt="">

                    <?php

                    }

                    ?>

                    <h3><?php the_title(); ?></h3>

                    <span>
                        <?php echo get_field('developer_designation'); ?>
                    </span>

                    <p>
                        <?php echo get_field('developer_skills'); ?>
                    </p>

                </div>

        <?php

            endwhile;

            wp_reset_postdata();

        endif;

        ?>

    </div>
</section>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: Arial, sans-serif;
        background: #f5f7fb;
    }

    /* SECTION */
    .students-section {
        width: 90%;
        margin: 80px auto;
    }

    .section-title {
        text-align: center;
        margin-bottom: 50px;
    }

    .section-title h2 {
        font-size: 42px;
        color: #597ac2;
        margin-bottom: 15px;
    }

    .section-title p {
        color: #6b7280;
        font-size: 18px;

    }

    /* CARDS */

    .students-container {
        display: grid;
        grid-template-columns:
            repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px;

    }

    .student-card {
        background: white;
        padding: 35px 25px;
        border-radius: 15px;
        text-align: center;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        transition: 0.3s;
    }

    .student-card:hover {
        transform: translateY(-8px);
    }

    .student-card img {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 20px;
        border: 4px solid #6984bd;
    }

    .student-card h3 {
        font-size: 24px;
        color: #111827;
        margin-bottom: 10px;
    }

    .student-card span {
        display: block;
        color: #2563eb;
        font-weight: bold;
        margin-bottom: 15px;
    }

    .student-card p {
        color: #6b7280;
        line-height: 1.7;

    }
</style>

<?php get_footer(); ?>