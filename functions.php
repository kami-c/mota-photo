<?php
// Ajout du titre du site
function mota_photo__wp_title($title) {
    $title .= get_bloginfo( 'name', 'display' );
    return $title;
}
add_filter('wp_title', 'mota_photo__wp_title', 10, 2);


// Compatibilité rétrospective pour ajout de support de thème
global $wp_version;
if ( version_compare( $wp_version, '3.0', '>=' ) ) :
	add_theme_support( 'automatic-feed-links' ); 
else :
	automatic_feed_links();
endif;

// Déclaration du thème
if ( ! function_exists( 'mota_photo_style' )):

    function mota_photo_style() {

        // jQuery
        wp_deregister_script('jquery' ); // version 3.4.1
        wp_enqueue_script(
            'jquery', 
            'https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js', 
            false, 
            '3.7.1', 
            true
        );

        // Fenêtre modale de contact
        wp_enqueue_script(
            'contact',
            get_stylesheet_directory_uri() . '/assets/js/contact.js',
            array('jquery'),
            null,
            true
        );

        // Javascript
        wp_enqueue_script(
            'script',
            get_template_directory_uri() . '/assets/js/script.js',
            array( 'jquery' ),
            true
        );

        // CSS
        wp_enqueue_style( 
            'style',
            get_template_directory_uri() . '/style.css',
            array()
        );
    }
add_action('wp_enqueue_scripts','mota_photo_style');
endif;

// Déclaration des emplacements de menu
register_nav_menus( array(
	'main' => __('Menu principal'),
	'footer' => __('Bas de page'),
) );
