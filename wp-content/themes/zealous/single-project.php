<?php
get_header();

$background_image = get_field('background_image');
$project_title = get_field('project_title');
$client_name = get_field('client_name');
$location = get_field('location');
?>

<section class="project-detail">
    <img src="<?php echo $background_image['url']; ?>" alt="">
    <h1><?php echo $project_title; ?></h1>
    <p><?php echo $client_name; ?></p>
    <p><?php echo $location; ?></p>
</section>

<?php get_footer(); ?>