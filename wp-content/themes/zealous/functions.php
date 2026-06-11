<?php 
function my_child_theme_styles() { 
    wp_enqueue_style( 
        'parent-style', 
        get_template_directory_uri() . '/style.css' ); 

    wp_enqueue_style(
        'swiper-css',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css'
    );

    wp_enqueue_script(
        'swiper-js',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
        array(),
        null,
        true
    );

    wp_enqueue_script(
        'custom-script',
        get_template_directory_uri() . '/assets/js/script.js',
        array('swiper-js'),
        '1.0',
        true    
    );
} 
add_action('wp_enqueue_scripts', 'my_child_theme_styles');
?>