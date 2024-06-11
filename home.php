<?php
/**
 * Home
 *
 */
get_header(); ?>

<div class="hero-header">
    <h1 class="hero-header__title">PHOTOGRAPHE EVENT</h1>

<? // >>> GESTIONNAIRE HERO-HEADER <<<

    // ARGUMENTS DE RÉCUPÉRATION DES PHOTOS
    $args = array(
        'post_type'        => 'photos',
        'posts_per_page'   => 1,
        'orderby'          => 'rand',
        'tax_query'        => array(
            array(
                'taxonomy' => 'format',
                'field'    => 'slug',
                'terms'    => 'paysage',
            ),
        ),
    );
    // EXÉCUTION DE LA REQUÊTE WP QUERY
    $photo_query = new WP_Query($args);

    // RÉCUPÉRATION DES URLS DES IMAGES DANS UN TABLEAU
    $image_url = array();

    // VÉRIFICATION S'IL Y A DES POSTS À AFFICHER
    if ($photo_query->have_posts()) :
        // VÉRIFICATION DANS UNE BOUCLE S'IL Y A DES POSTS À CHAQUE ITÉRATION  
        while ($photo_query->have_posts()) : 
          // PRÉPARATION DES POSTS
          $photo_query->the_post();

            // GESTIONNAIRE D'AFFICHAGE D'IMAGE DU HERO HEADER
            if (has_post_thumbnail()) {
                $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                $image_url = apply_filters('the_post_thumbnail_url', $image_url); 
                $image_url = '<img src="' . esc_url($image_url) . '" alt="' . esc_attr(get_the_title()) . '">';
                $image_url = preg_replace( // ajout de la class "hero-header__img"
                    '/<img(.*?)(src="[^"]*")(.*?)>/',
                    '<img class="hero-header__img" $2$1$3>',
                    $image_url
                );

                echo $image_url; // AFFICHAGE DU HERO-HEADER
            } else {
                echo 'Aucune image disponible.';
            }
        endwhile;
        // RÉINITIALISATION DE LA REQUÊTE PRINCIPALE
        wp_reset_postdata();
    endif;
?>
</div>

<main>
</main>

<?php get_footer(); ?>
