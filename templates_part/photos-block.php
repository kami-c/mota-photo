<section class="photo-bloc">

    <?php

    $args = array( // ARGUMENTS DES PHOTOS À RÉCUPÉRER
        'post_type'             => 'photos',
        'posts_per_page'        => -1,
        'orderby'               => 'DESC',
    );    

    if ( isset($args) && $args ) {

        $id_query = new WP_Query( $args ); // EXCÉCUTION DE LA WP_QUERY

        $image_data = array(); // TABLEAU DE DONNÉES

        if( $id_query->have_posts() ) : // CONDITION : S'il y a des posts à afficher  
            while( $id_query->have_posts() ) : // LOOP : Tant qu'il y a des posts à chaque itération
                $id_query->the_post(); // APPLIQUER LA WP_QUERY SUR LES POSTS

                $image_id = get_post_thumbnail_id();
                $image_url = wp_get_attachment_image_src($image_id, 'full');

                $title = get_the_title($image_id);
                $alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);

                $terms = wp_get_object_terms(get_the_ID(), 'categorie', array('fields' => 'slugs'));
                $categories = !is_wp_error($terms) ? implode(', ', $terms) : '';

                $reference = get_field('reference', get_the_ID());

                $image_data[] = array(
                    'id' => $image_id,
                    'url' => $image_url[0],
                    'title' => $title,
                    'alt' => $alt,
                    'reference' => $reference,
                    'category' => $categories
                );

            endwhile;
            
        // REMISE À ZÉRO DE LA REQUÊTE
        wp_reset_postdata();
        else :
            echo 'Aucun post trouvé';
        endif;
    }

    foreach ($image_data as $image) : ?>

        <div class="photo-bloc__img">
            <a
            href="<?php echo esc_url($image['url']); ?>" class="link"
            data-title="<?php echo esc_attr($image['title']); ?>"
            data-reference="<?php echo esc_attr($image['reference']); ?>"
            data-category="<?php echo esc_attr($image['category']); ?>" ?>
                <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" class="image"/>
            </a>
        </div>

    <?php endforeach; ?>
</section>