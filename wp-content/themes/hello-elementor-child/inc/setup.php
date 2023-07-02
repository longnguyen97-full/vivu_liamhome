<?php

/**
 * Enqueue CSS, JS
 */
add_action('wp_enqueue_scripts', 'hec_enqueue_scripts');
function hec_enqueue_scripts()
{
    // CSS
    wp_enqueue_style('hello-elementor', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('grids', get_stylesheet_directory_uri() . assets('css/grids.css'));
    wp_enqueue_style('sizes', get_stylesheet_directory_uri() . assets('css/sizes.css'));
    wp_enqueue_style('custom', get_stylesheet_directory_uri() . assets('css/custom.css'));
    wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css', [], '5.0.2');
    // Javascript
    wp_enqueue_script('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js', [], '5.0.2');
    wp_enqueue_script('sweetalert2', 'https://cdn.jsdelivr.net/npm/sweetalert2@11', [], '11');
}
