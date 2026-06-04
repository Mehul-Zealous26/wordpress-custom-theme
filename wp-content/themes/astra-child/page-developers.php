<?php get_header(); ?>

<section class="developers-section">

    <div class="section-title">
        <h2><?php the_title(); ?></h2>
        <p>
            Meet our talented developers with modern web development skills.
        </p>
    </div>

    <div class="developers-container">

        <!-- Developer 1 -->
        <div class="developer-card">

            <?php
            $image = get_field('developer_1_image');

            if ($image) {
            ?>
                <img src="<?php echo $image['url']; ?>" alt="">
            <?php } ?>

            <h3>
                <?php echo get_field('developer_1_name'); ?>
            </h3>

            <span>Frontend Developer</span>

            <p>
                <?php echo get_field('developer_1_skills'); ?>
            </p>

        </div>

        <!-- Developer 2 -->
        <div class="developer-card">

            <?php
            $image = get_field('developer_2_image');

            if ($image) {
            ?>
                <img src="<?php echo $image['url']; ?>" alt="">
            <?php } ?>

            <h3>
                <?php echo get_field('developer_2_name'); ?>
            </h3>

            <span>Backend Developer</span>

            <p>
                <?php echo get_field('developer_2_skills'); ?>
            </p>

        </div>

        <!-- Developer 3 -->
        <div class="developer-card">

            <?php
            $image = get_field('developer_3_image');

            if ($image) {
            ?>
                <img src="<?php echo $image['url']; ?>" alt="">
            <?php } ?>

            <h3>
                <?php echo get_field('developer_3_name'); ?>
            </h3>

            <span>WordPress Developer</span>

            <p>
                <?php echo get_field('developer_3_skills'); ?>
            </p>

        </div>

        <!-- Developer 4 -->
        <div class="developer-card">

            <?php
            $image = get_field('developer_4_image');

            if ($image) {
            ?>
                <img src="<?php echo $image['url']; ?>" alt="">
            <?php } ?>

            <h3>
                <?php echo get_field('developer_4_name'); ?>
            </h3>

            <span>Laravel Developer</span>

            <p>
                <?php echo get_field('developer_4_skills'); ?>
            </p>

        </div>

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
        background-color: #f4f7fb;
    }

    .developers-section {
        width: 90%;
        margin: 80px auto;
    }

    /* TITLE */

    .section-title {
        text-align: center;
        margin-bottom: 60px;
    }

    .section-title h2 {
        font-size: 45px;
        color: #1e3a8a;
        margin-bottom: 15px;
    }

    .section-title p {
        font-size: 18px;
        color: #6b7280;
    }

    /* GRID */

    .developers-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 30px;
    }

    /* CARD */

    .developer-card {
        background: #fff;
        padding: 35px 25px;
        border-radius: 18px;
        text-align: center;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        transition: 0.4s;
    }

    .developer-card:hover {
        transform: translateY(-10px);
    }

    .developer-card img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 5px solid #2563eb;
        margin-bottom: 20px;
    }

    .developer-card h3 {
        font-size: 24px;
        color: #111827;
        margin-bottom: 10px;
    }

    .developer-card span {
        display: inline-block;
        margin-bottom: 15px;
        color: #2563eb;
        font-weight: bold;
        font-size: 15px;
    }

    .developer-card p {
        color: #6b7280;
        line-height: 1.7;
        font-size: 15px;
    }

    /* RESPONSIVE */

    @media(max-width:768px) {
        .section-title h2 {
            font-size: 35px;
        }
    }
</style>

<?php get_footer(); ?>