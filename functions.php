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
        wp_enqueue_script( 'jquery' );

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
	'main' => 'Menu principal',
	'footer' => 'Menu bas de page',
) );

