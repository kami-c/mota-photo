<section class="post">
    <article class="post__info">
		<h2 class="post__info--title"><?php the_title();?></h2>
		<p class="post__info--details">Référence : <span class="reference"><?php the_field('reference'); ?></span></p>
		<p class="post__info--details"><?php the_terms($post->ID, 'categorie', 'Catégorie : ');?></p>
		<p class="post__info--details"><?php the_terms($post->ID, 'format', 'Format : ');?></p>
        <p class="post__info--details">Type : <?php the_field('type'); ?></p>
		<p class="post__info--details">Année : <?php the_date('Y'); ?></p>
    </article>

	<?php $content = get_the_content(); // Image active
        $content = apply_filters('the_content', $content); // Application des filtres
        $content = str_replace(array('<p>', '</p>'), '', $content); // Suppression de la balise auto <p></p> sur contenu
        $content = preg_replace('/<img(.*?)class="(.*?)"(.*?)>/', '<img$1class="$2 post__img"$3>', $content); // ajout de la class "post_img"
        echo $content;
    ?>
</section>

<section class="info">
    <div class="info__contact">
        <p>Cette photo vous intéresse ?</p>
        <button class="info__contact--submit modale">Contact</button>
    </div>
    <div class="info__navigation">
        <div class="info__navigation--button">
            <?php
            // RÉCUPÉRATION DE TOUS LES POSTS PHOTOS PAR DATE DE PRISE DE VUE
            $posts = get_posts(array(
                'post_type' => 'photos',
                'orderby' => 'date',
                'order' => 'DESC',
                'posts_per_page' => -1 // récupération de tous les posts
            ));  
            // INDEX DU POST ACTUEL
            $current_post_index = 0; // INITIALISATION DU COMPTEUR : 0 par défaut
            $current_post_id = get_the_ID(); // RÉCUPÉRATION DE L'ID DU POST ACTUEL
            foreach ($posts as $index => $post) { 
                if ($post->ID == $current_post_id) {
                    $current_post_index = $index;
                    break;
                }
            }    
            // FONCTION DE RÉCUPÉRATION DU POST PRÉCÉDENT PAR RAPPORT AU POST ACTUEL
            function get_previous_post_circular($posts, $current_post_index) {
                $total_posts = count($posts);
                $previous_post_index = ($current_post_index - 1 + $total_posts) % $total_posts;
                return $posts[$previous_post_index];
            }    
            // FONCTION DE RÉCUPÉRATION DU POST SUIVANT PAR RAPPORT AU POST ACTUEL
            function get_next_post_circular($posts, $current_post_index) {
                $total_posts = count($posts);
                $next_post_index = ($current_post_index + 1) % $total_posts;
                return $posts[$next_post_index];
            }    
            // RÉCUPÉRATION DU POST PRÉCÉDENT
            $previous_post = get_previous_post_circular($posts, $current_post_index);
            // RÉCUPÉRATION DU POST SUIVANT
            $next_post = get_next_post_circular($posts, $current_post_index);
            ?>
            <div class="button__previous">
                <?php // >>> MISE EN PLACE DE L'AFFICHAGE DE L'IMAGE DU POST PRÉCÉDENT
                // VÉRIFICATION SI LE POST PRÉCÉDENT EXISTE
                if ($previous_post) {
                    // ASSOCIATION DE L'ID À LA PHOTO DU POST PRÉCÉDENT
                    $previous_post_thumbnail = get_the_post_thumbnail($previous_post->ID, 'thumbnail');
                    if ($previous_post_thumbnail) {
                        // AJOUT DU LIEN DU POST PRÉCÉDENT SUR IMAGE POUR ACCESSIBILITÉ ?>
                        <a href="<?php echo get_permalink($previous_post->ID); ?>">
                        <?php // AJOUT DE LA CLASS CSS POUR ADAPTER L'IMAGE
                        $previous_post_thumbnail = preg_replace('/<img(.*?)class="(.*?)"(.*?)>/', '<img$1class="$2 nav-post-img-previous"$3>', $previous_post_thumbnail);
                        // AFFICHAGE DE L'IMAGE DU POST PRÉCÉDENT
                        echo $previous_post_thumbnail;
                    } else {
                        echo '<p>Il n\'y a pas d\'image attachée au post précédent.</p>';
                    }
                } else {
                    echo '<p>Il n\'y a pas de post précédent.</p>';
                }
                ?>
 
                <?php // >>> MISE EN PLACE DU BOUTON DU POST PRÉCÉDENT
                if ($previous_post) : ?>
                    <a href="<?php echo get_permalink($previous_post->ID); ?>" class="previous">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/Line-6.webp" alt="Previous">
                    </a>
                <?php endif; ?>
            </div>
                 
            <div class="button_next">
                <?php
                // VÉRIFICATION SI LE POST SUIVANT EXISTE
                if ($next_post) {
                    // ASSOCIATION DE L'ID À LA PHOTO DU POST SUIVANT
                    $next_post_thumbnail = get_the_post_thumbnail($next_post->ID, 'thumbnail');
                    if ($next_post_thumbnail) {
                        // AJOUT DU LIEN DU POST SUIVANT SUR IMAGE POUR ACCESSIBILITÉ ?>
                        <a href="<?php echo get_permalink($next_post->ID); ?>">
                        <?php // AJOUT DE LA CLASS CSS POUR ADAPTER L'IMAGE
                        $next_post_thumbnail = preg_replace('/<img(.*?)class="(.*?)"(.*?)>/', '<img$1class="$2 nav-post-img-next"$3>', $next_post_thumbnail);
                        // AFFICHAGE DU POST SUIVANT
                        echo $next_post_thumbnail;
                    } else {
                        echo '<p>Il n\'y a pas d\'image attachée au post suivant.</p>';
                    }
                } else {
                    echo '<p>Il n\'y a pas de post suivant.</p>';
                }
                ?>
 
                <?php // >>> MISE EN PLACE DU BOUTON DU POST SUIVANT
                if ($next_post) : ?>
                    <a href="<?php echo get_permalink($next_post->ID); ?>" class="next">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/Line-7.webp" alt="Next">
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<section class="suggestion"> 
    <h3>Vous aimerez aussi</h3>

    <div class="suggestion__content">
        <?php content_img();?>
    </div>
</section>


<?php function content_img() {
    //  RECHERCHE DE L'ID DE L'IMAGE EN COURS
    $current_post_id = get_the_ID();
    // RÉCUPATION DES TERMES DE LA TAXONOMIE DE L'IMAGE EN COURS
    $terms = get_the_terms($current_post_id, 'categorie');
    // VÉRIFICATION DES DONNÉES DANS LA VARIABLE $TERMS
    if (!empty($terms) && !is_wp_error($terms)) {
        // SÉLECTION DU PREMIER TERME DANS LE TABLEAU
        $current_term = $terms[0];
        $term_slug = $current_term->slug; // 'slug' et non'term_id' sinon pas de retour d'image possible // rewrite
    
        // ARGUMENTS À RÉCUPÉRER
        $args = array(
            'post_type' => 'photos',
            'posts_per_page' => 2,
            'orderby' => 'rand',
            'tax_query' => array(
                array(
                    'taxonomy' => 'categorie',
                    'field'    => 'slug', // ou 'term_id'
                    'terms'    => $term_slug,
                ),
            ),
        );
    // EXCÉCUTION DE LA REQUÊTE WP Query AVEC ARGUMENTS
    $id_query = new WP_Query( $args );
    // VÉRIFICATION S'IL Y A DES POSTS À AFFICHER
    if( $id_query->have_posts() ) :
     // VÉRIFICATION DANS UNE BOUCLE S'IL Y A DES POSTS À CHAQUE ITÉRATION    
     while( $id_query->have_posts() ) : 
     // PRÉPARATION DES POSTS EN FONCTION DES TEMPLATES DU POST EN COURS
     $id_query->the_post();
    
     // GESTION DE L'AFFICHAGE DU CONTENU
     $content = get_the_content(); // Récupération du contenu : image active
     $content = apply_filters('the_content', $content);// Application des filtres
     $content = str_replace(array('<p>', '</p>'), '', $content); // Suppression de la balise auto <p></p> sur contenu
     $content = preg_replace('/<img(.*?)class="(.*?)"(.*?)>/', '<img$1class="$2 suggestion__content--img"$3>', $content); // ajout de la class "post_img"
     echo $content; // Affichage du contenu
     endwhile;
    // RÉINITIALISATION DE LA REQUÊTE PRINCIPALE
    wp_reset_postdata();
    else :
        echo 'Aucun post trouvé';
    endif;
    } else {
        echo 'Aucun terme trouvé pour cette taxonomie.';
    }
}
?>
