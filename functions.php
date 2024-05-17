<?php

// Déclaration du style du thème 
function theme_enqueue_styles() {
    wp_enqueue_style ( 
        'motaphoto',
        get_template_directory_uri() . '/style.css'
    );
}

add_action('wp_enqueue_script','wp_enqueue_style');