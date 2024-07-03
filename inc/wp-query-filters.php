<? // >>> GESTIONNAIRE DE REQUÊTES

// WP_QUERY permettant l'affichage de l'image de fond au format paysage du hero-header dans home.php
function mota_photo_hero_header_filter() {
    // RÉCUPÉRATION DES PHOTOS
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
    // EXÉCUTION DE LA REQUÊTE WP QUERY
    $photo_query = new WP_Query($args);

    // Tableau pour stocker les URLs des images
    $image = array();

    // Boucle pour afficher les articles
    if ($photo_query->have_posts()) :
        while ($photo_query->have_posts()) : $photo_query->the_post();

            // Affichage de l'image
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

// WP_QUERY permettant l'affichage des photos
function mota_photo_photo_block() {
    $image_data = array();

    if (is_home()) {
        $args = array(
            'post_type'      => 'photos',
            'posts_per_page' => -1,
            'orderby'        => 'date',
            'order'          => 'DESC',
        );
    } else {
        $current_post_id = get_the_ID();
        $terms = get_the_terms($current_post_id, 'categorie');

        if (!empty($terms) && !is_wp_error($terms)) {
            $current_term = $terms[0];
            $term_slug = $current_term->slug;

            $args = array(
                'post_type'      => 'photos',
                'posts_per_page' => 2,
                'post__not_in'   => array($current_post_id),
                'orderby'        => 'rand',
                'tax_query'      => array(
                    array(
                        'taxonomy' => 'categorie',
                        'field'    => 'slug',
                        'terms'    => $term_slug,
                    ),
                ),
            );
        }
    }

    if (isset($args)) {
        $query = new WP_Query($args);

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
        }
    }

    if (isset($image) && is_array($image)) :
        require get_template_directory() . '/templates-parts/photos-block.php';
    endif;

    return $image_data;
}
?>