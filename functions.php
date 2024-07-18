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

// Déclaration du thème personnalisé
if ( ! function_exists( 'mota_photo_style' )):

    function mota_photo_style_and_scripts() {

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
            1.0,
            true
        );

        /*
	// Récupération des données des photos 
        $image_data = mota_photo_photo_block();

        // Définition du nombre total de photos dans $image_data
        $total_images = (is_array($image_data) || $image_data instanceof Countable) ? count($image_data) : 0;

        $images_per_page = 0; 

        // Nombre de photos par page en fonction du type de page
        if (is_home()) {
            $images_per_page = 8;
        } elseif (is_single()) {
            $images_per_page = 2;
        }
	*/

        if (is_home() || is_single()) {
        // Filtres
		    wp_enqueue_script(
		    	'ajax-filters',
		    	get_stylesheet_directory_uri() . '/assets/js/filters.js',
		    	array('jquery'),
		    	1.0,
		    	true
		    );

		    // Lightbox
		    wp_enqueue_script(
		    	'lightbox',
		    	get_stylesheet_directory_uri() . '/assets/js/lightbox.js',
		    	array('jquery'),
		    	1.0,
		    	true
		    );

		    // Navigation
		    wp_enqueue_script(
		    	'navigation',
		    	get_stylesheet_directory_uri() . '/assets/js/single-navigation.js',
		    	array('jquery'),
		    	1.0,
		    	true
		    );

            // Localisation des données Javascript pour utilisation côté client
		    wp_localize_script(
		    	'ajax-filters',
		    	'filters_object',
		    	array('ajax_url' => admin_url('admin-ajax.php'))
		    );
        }

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
add_action('wp_enqueue_scripts','mota_photo_style_and_scripts');
endif;


// Déclaration des emplacements de menu
register_nav_menus( array(
	'main' => __('Menu principal'),
	'footer' => __('Bas de page'),
) );

// GESTIONNAIRE DES TYPES DE CONTENUS PERSONNALISÉS (CPT)
require get_template_directory() . '/inc/cpt.php';

// GESTIONNAIRE DES TAXONOMIES
require get_template_directory() . '/inc/taxonomies.php';

// GESTIONNAIRE DE WP_QUERY
require get_template_directory() . '/inc/wp-query-filters.php';

// Chargement supplémentaire de photos via requête AJAX
/*function load_more_posts() {
    $paged = $_POST['page'];
    $args = array(
        'posts_per_page' => 8,
        'paged' => $paged
    );
 
    require get_template_directory() . '/templates-parts/photos-block.php';
}
add_action('wp_ajax_load_more', 'load_more_posts');
add_action('wp_ajax_nopriv_load_more', 'load_more_posts');*/
