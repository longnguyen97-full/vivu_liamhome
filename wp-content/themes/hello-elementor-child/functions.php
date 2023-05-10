<?php

add_action('wp_enqueue_scripts', 'enqueue_hello_elementor_styles');
function enqueue_hello_elementor_styles()
{
    wp_enqueue_style('hello-elementor', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('grids', get_template_directory_uri() . '/grids.css');
}
