<?php 
// TAXONOMIES
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
add_action( 'init', 'mota_photo_register_taxonomies'); ?>