<?php 
// TYPES DE CONTENUS PERSONNALISÉS (CPT)
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

function mota_photo_setup() {
    // Ajouter la prise en charge des miniatures dans le thème
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'mota_photo_setup');
?>