<?php
// >>> AJOUT DU TITRE DU SITE
function mota_photo__wp_title($title) {
    $title .= get_bloginfo( 'name', 'display' );
    return $title;
}
add_filter('wp_title', 'mota_photo__wp_title', 10, 2);


// >>> COMPATIBILITÉ RÉTROSPECTIVE POUR AJOUT DE SUPPORT DE THÈME
global $wp_version;
if ( version_compare( $wp_version, '3.0', '>=' ) ) :
	add_theme_support( 'automatic-feed-links' ); 
else :
	automatic_feed_links();
endif;

// >>> DÉCLARATION DU THÈME PERSONNALISÉ
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
            null,
            true
        );

        // Javascript
        wp_enqueue_script(
            'script',
            get_template_directory_uri() . '/assets/js/script.js',
            array( 'jquery' ),
            true // true : chargement en bas de page (footer) - false : chargement dans l'en-tête de page (header)
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


// >>> DÉCLARATION DES EMPLACEMENTS DE MENU
register_nav_menus( array(
	'main' => __('Menu principal'),
	'footer' => __('Bas de page'),
) );


// >>> TYPES DE CONTENUS PERSONNALISÉS (CPT) : Photos
function mota_photo_register_custom_post_types() {
	    
    $labels_photo = array (
		'name'                      => 'Photos',
		'singular_name'             => 'Photo',
		'menu_name'                 => __('Photos', 'mota_photo'),
        'name_admin_bar'            => __('Photos', 'mota_photo'),
		'all_items'                 => __('Toutes les photos', 'mota_photo'),
		'edit_item'                 => __('Modifier la photo', 'mota_photo'),
		'view_item'                 => __('Voir la photo', 'mota_photo'),
		'view_items'                => __('Voir les photos', 'mota_photo'),
		'add_new_item'              => __('Ajouter une nouvelle photo', 'mota_photo'),
		'add_new'                   => __('Ajouter une photo', 'mota_photo'),
		'new_item'                  => __('Nouvelle photo', 'mota_photo'),
		'parent_item_colon'         => 'Photo parent :',
		'search_items'              => __('Rechercher des photos', 'mota_photo'),
		'not_found'                 => __('Aucune photo trouvée', 'mota_photo'),
		'not_found_in_trash'        => __( 'Aucune photo trouvée dans la corbeille', 'mota_photo'),
		'archives'                  => __('Archives des photos', 'mota_photo'),
		'attributes'                => __('Attributs des photos', 'mota_photo'),
		'insert_into_item'          => __('Insérer dans photo', 'mota_photo'),
		'uploaded_to_this_item'     => __('Téléversé sur cette photo', 'mota_photo'),
		'filter_items_list'         => __('Filtrer la liste des photos', 'mota_photo'),
		'filter_by_date'            => __('Filtrer les photos par date', 'mota_photo'),
		'items_list_navigation'     => __('Navigation dans la liste des photos', 'mota_photo'),
		'items_list'                => __('Liste des photos', 'mota_photo'),
		'item_published'            => __('Photo publiée', 'mota_photo'),
		'item_published_privately'  => __('Photo publiée en privé', 'mota_photo'),
		'item_reverted_to_draft'    => __('Photo repassée en brouillon', 'mota_photo'),
		'item_scheduled'            => __('Photo planifiée', 'mota_photo'),
		'item_updated'              => __('Photo mise à jour', 'mota_photo'),
		'item_link'                 => __('Lien de la photo', 'mota_photo'),
		'item_link_description'     => __('Un lien vers une photo', 'mota_photo'),
	);

    $args_photo = array(
        'labels'                    => $labels_photo,
        'label'                     => __('Photos', 'mota_photo'),
        'description'               => __('Photos', 'mota_photo'),
	    'public'                    => true,
	    'show_in_rest'              => false,
        'show_ui'                   => true,
        'show_in_menu'              => true,
        'show_in_admin_bar'         => true,
        'show_in_nav_menus'         => true,
        'can_export'                => true,
        'has_archive'               => true,
        'exclude_from_search'       => false,
        'publicly_queryable'        => true,
        'capability_type'           => 'post',
	    'menu_position'             => 5,
	    'menu_icon'                 => 'dashicons-format-image',
	    'supports'                  => array(
        	0 => 'title',
        	1 => 'editor',
			2 => 'thumbnail',
        	3 => 'custom-fields'			
        ),
        'hierarchical'              => false,
	    'taxonomies'                => array(
	        0 => 'categorie', // renommer en categorie plutot que category pour ne pas afficher les catégories d'articles
	        1 => 'format',
	    ),
	    'delete_with_user'          => false,
    );

    register_post_type('photos', $args_photo);
};
add_action( 'init', 'mota_photo_register_custom_post_types');

// >>> AJOUT D'UNE FONCTION POUR LA PRISE EN CHARGE DES MINIATURES DANS LE THÈME
function mota_photo_setup() {
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'mota_photo_setup');

// >>> TAXONOMIES : Catégories et formats
function mota_photo_register_taxonomies() {

    // Catégories photos
	$labels = array(
		'name'                      => __('Catégories'),
		'singular_name'             => __('Catégorie'),
		'menu_name'                 => __('Catégories'),
        'name_admin_bar'            => __('Catégories'),
		'all_items'                 => __('Tous les catégories'),
		'edit_item'                 => __('Modifier les catégories'),
		'view_item'                 => __('Voir les catégories'),
		'update_item'               => __('Mettre à jour les catégories'),
		'add_new_item'              => __('Ajouter une catégorie'),
		'new_item_name'             => __('Nom de la nouvelle catégorie'),
		'search_items'              => __('Rechercher dans les catégories'),
		'popular_items'             => __('Catégories populaires'),
		'separate_items_with_commas'=> __('Séparer les catégories avec une virgule'),
		'add_or_remove_items'       => __('Ajouter ou retirer catégories'),
		'choose_from_most_used'     => __('Choisir parmi les catégories les plus utilisés'),
		'not_found'                 => __('Aucune une catégorie photo trouvé'),
		'no_terms'                  => __('Aucune une catégorie photo'),
		'items_list_navigation'     => __('Navigation dans la liste des catégories'),
		'items_list'                => __('Liste des catégories'),
		'back_to_items'             => __('← Aller à « Catégories »'),
		'item_link'                 => __('Lien des catégories'),
		'item_link_description'     => __('Un lien vers une catégorie'),
    );
    $args = array(
        'hierarchical'              => true, 
        'labels'                    => $labels,
	    'public'                    => true,
        'show_ui'                   => true,
        'show_admin_column'         => true,
	    'show_in_menu'              => true,
	    'show_in_rest'              => false,
        'query_var'                 => true,
        'rewrite'                   => array( 'slug' => 'categorie', 'with_front' => TRUE  )
    );
    register_taxonomy('categorie', array(0 => 'photos'), $args);

	// Formats
	$labels = array (
		'name'                      => __('Formats'),
		'singular_name'             => __('Format'),
		'menu_name'                 => __('Formats'),
		'all_items'                 => __('Tous les Formats'),
		'edit_item'                 => __('Modifier Format'),
		'view_item'                 => __('Voir Format'),
		'update_item'               => __('Mettre à jour Format'),
		'add_new_item'              => __('Ajouter Format'),
		'new_item_name'             => __('Nom du nouveau Format'),
		'search_items'              => __('Rechercher Formats'),
		'popular_items'             => __('Formats populaire'),
		'separate_items_with_commas'=> __('Séparer les formats avec une virgule'),
		'add_or_remove_items'       => __('Ajouter ou retirer formats'),
		'choose_from_most_used'     => __('Choisir parmi les formats les plus utilisés'),
		'not_found'                 => __('Aucun formats trouvé'),
		'no_terms'                  => __('Aucun formats'),
		'items_list_navigation'     => __('Navigation dans la liste Formats'),
		'items_list'                => __('Liste Formats'),
		'back_to_items'             => __('← Aller à « formats »'),
		'item_link'                 => __('Lien Format'),
		'item_link_description'     => __('Un lien vers un format'),
    );
    $args = array (
        'hierarchical'              => true, 
        'labels'                    => $labels,
	    'public'                    => true,
        'show_ui'                   => true,
        'show_admin_column'         => true,
	    'show_in_menu'              => true,
	    'show_in_rest'              => false,
        'query_var'                 => true,
        'rewrite'                   => array( 'slug' => 'format', 'with_front' => TRUE )
    );
    register_taxonomy( 'format', array(0 => 'photos',),  $args);
};

add_action( 'init', 'mota_photo_register_taxonomies');
