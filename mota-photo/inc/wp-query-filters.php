<? /* GESTIONNAIRE DES WP_QUERY */

// Affichage de l'image de fond au format paysage du hero-header dans home.php
function mota_photo_hero_header_filter() {
    $args = array(
        'post_type'         => 'photos',
        'posts_per_page'    => 1,
        'orderby'           => 'rand',
        'tax_query'         => array(
            array(
                'taxonomy' => 'format',
                'field'    => 'slug', // ou 'term_id'
                'terms'    => 'paysage',
            ),
        ),
    );

    $photo_query = new WP_Query($args);
    $image = array();

    if ($photo_query->have_posts()) :
        while ($photo_query->have_posts()) : $photo_query->the_post();

            if (has_post_thumbnail()) {
                $image = get_the_post_thumbnail_url(get_the_ID(), 'full');
                $image = apply_filters('the_post_thumbnail_url', $image);
                $image = '<img src="' . esc_url($image) . '" alt="' . esc_attr(get_the_title()) . '">';
                $image = preg_replace(
                    '/<img(.*?)(src="[^"]*")(.*?)>/',
                    '<img class="hero-header__img" $2$1$3>',
                    $image
                );

                echo $image; // AFFICHAGE DU HERO-HEADER
            } else {
                echo 'Aucune image disponible';
            }
        endwhile;
        wp_reset_postdata();
    endif;
}

// Affichage dynamique des photos
function ajax_filter() {

    // Sécurité
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'filter_nonce')) {
        wp_die();
    }

    // Récupération des données avec validation
    $categorie = isset($_POST['categorie']) ? sanitize_text_field($_POST['categorie']) : '';
    if ($categorie !== 'all' && $categorie && !term_exists($categorie, 'categorie')) {
        wp_die('Catégorie invalide');
    }
    $format = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : '';
    if ($format !== 'all' && $format && !term_exists($format, 'format')) {
        wp_die('Format invalide');
    }
    $order = isset($_POST['order']) && $_POST['order'] !== 'all' ? sanitize_text_field($_POST['order']) : 'desc';

    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
    if ($paged <= 0) {
        wp_die('Page invalide');
    }

    // Arguments de requête
        $args = array(
            'post_type'         => 'photos',
            'orderby'           => 'date',
            'order'             => $order,
            'posts_per_page'    => 8,
            'paged'             => $paged,
        );

        $tax_query = array();

        if (!empty($categorie) && $categorie !== 'all') {
            $args['tax_query'][] = array(
                'taxonomy' => 'categorie',
                'field' => 'slug',
                'terms' => $categorie,
            );
        }

        if (!empty($format) && $format !== 'all') {
            $args['tax_query'][] = array(
                'taxonomy' => 'format',
                'field' => 'slug',
                'terms' => $format,
            );
        }

        if (!empty($tax_query)) {
            $args['tax_query'] = $tax_query;
        }
    
    $query = new WP_Query($args);
    $image_data = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            $image_id = get_post_thumbnail_id();
            $image_url = wp_get_attachment_image_src($image_id, 'full');
            $title = get_the_title();
            $alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
            $terms_categories = wp_get_object_terms(get_the_ID(), 'categorie', array('fields' => 'slugs'));
            $categories = !is_wp_error($terms_categories) ? implode(', ', $terms_categories) : '';
            $terms_formats = wp_get_object_terms(get_the_ID(), 'format', array('fields' => 'slugs'));
            $formats = !is_wp_error($terms_formats) ? implode(', ', $terms_formats) : '';
            $reference = get_field('reference');
            $post_url = get_permalink();
            $post_date = get_the_date('Y');
                
            $image_data[] = array(
                'id'            => $image_id,
                'url'           => $image_url[0],
                'title'         => $title,
                'alt'           => $alt,
                'reference'     => $reference,
                'category'      => $categories,
                'format'        => $formats,
                'post_url'      => $post_url,
                'date'          => $post_date
            );                    
        }
        wp_reset_postdata();
    } else {
        echo json_encode(array('Il n\'y a pas d\'autres photos.'));
    }
    require get_template_directory() . '/templates-parts/photos-block.php';
    
    wp_die();

}
add_action('wp_ajax_nopriv_ajax_filter', 'ajax_filter');
add_action('wp_ajax_ajax_filter', 'ajax_filter');
?>