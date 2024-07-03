<div class="photo-post">
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
                    'posts_per_page' => -1
                ));  
            
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

                <div class="button__previous" data-image-url="<?php echo esc_url(get_the_post_thumbnail_url($previous_post->ID, 'thumbnail')); // AJOUT DE L'URL DE L'IMAGE À AFFICHER ?>">
                    <?php if ($previous_post) : // VÉRIFICATION SI LE POST PRÉCÉDENT EXISTE ?>
                        <a href="<?php echo get_permalink($previous_post->ID); // AJOUT DE L'URL DU POST PRÉCÉDENT ?>" class="previous">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/Line-6.webp" alt="Previous">
                        </a>
                    <?php endif; ?>
                </div>
                    
                <div class="button_next" data-image-url="<?php echo esc_url(get_the_post_thumbnail_url($next_post->ID, 'thumbnail')); // AJOUT DE L'URL DE L'IMAGE À AFFICHER ?>">
                    <?php if ($next_post) : // VÉRIFICATION SI LE POST SUIVANT EXISTE ?>
                        <a href="<?php echo get_permalink($next_post->ID); // AJOUT DE L'URL DU POST SUIVANT?>" class="next">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/Line-7.webp" alt="Next">
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            </section>
                            
    <section class="suggestion"> 
        <h3>Vous aimerez aussi</h3>
        
        <? $image_data = mota_photo_photo_block();
        if (!empty($image_data)) : ?>
            <div class="photo-bloc">
                <div id="photo-container"></div>
            </div>
        <?else :
            // Si aucune photo n'est trouvée, afficher le message de non trouvé
            echo '<p class="not-found">Il n\'y a pas d\'autres photos dans cette catégorie.</p>';
        endif;
        ?>
    </section>
</div>