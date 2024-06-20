<?php 

// FILTRES DE TRI par date
function mota_photo_date_filter() {

	$orderby_date = isset($_POST['orderby_date']) ? sanitize_text_field($_POST['orderby_date']) : 'DESC';

	$args = array(
		'post_type'      => 'photos',
		'orderby'        => 'date',
		'order'          => $orderby_date,
		'posts_per_page' => -1
	);

	$query = new WP_Query($args);

	if ($query->have_posts()) {
		while ($query->have_posts()) {
			$query->the_post();
		}

	 // GESTION DE L'AFFICHAGE DU CONTENU
     $content = get_the_content(); // Récupération du contenu : image active
     $content = apply_filters('the_content', $content);// Application des filtres
     $content = str_replace(array('<p>', '</p>'), '', $content); // Suppression de la balise auto <p></p> sur contenu
     $content = preg_replace('/<img(.*?)class="(.*?)"(.*?)>/', '<img$1class="$2 suggestion__content--img"$3>', $content); // ajout de la class "post_img"
    //  echo $content; // Affichage du contenu

		wp_reset_postdata();
    } else {
        echo '<p>Aucun article trouvé.</p>';
    }
}

add_action('wp_ajax_my_filter_action', 'mota_photo_date_filter');
add_action('wp_ajax_nopriv_my_filter_action', 'mota_photo_date_filter');

function mota_photo_date_filter_shortcode() {
    add_shortcode('date_filter', 'mota_photo_date_filter');
}
add_action('init', 'mota_photo_date_filter_shortcode');
