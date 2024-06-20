<?php
/**
 * Home
 *
 */
get_header(); ?>

<main>
    
    <section class="hero-header">
        <h1 class="hero-header__title">PHOTOGRAPHE EVENT</h1>
        <?php // >>> IMAGE ALÉATOIRE EN FOND
        get_template_part( 'templates_part/hero_header' ) ?>
    </section>
    
    <section class="filter-container">
        <div class="filter-container__category-format">
            <div class="filter-container__wrapper">
                <form 
                action="<?php echo admin_url( 'admin-ajax.php' ); ?>"
                method="post"
                class="filter-container__form__categorie"
                >
                    <?php
            			$taxonomy = 'categorie';
            			$args = array(
            				'taxonomy'   => $taxonomy,
            				'hide_empty' => false,
            				'parent'     => 0, // Récupère uniquement les termes parents
            			);
                    
            			$terms = get_terms($args);

                        $default_value = 'all'; // Valeur par défaut

                        if (!empty($terms) && !is_wp_error($terms)) {
                            // Si des termes existent, utilise le slug du premier terme comme valeur par défaut
                            $default_value = esc_attr($terms[0]->term_id);
                        }
                    ?>

                    <select 
                    type="hidden"
                    id="filter-container__categorie" 
                    class="filter-container__categorie" 
                    name="categorie"
                    value="<?php echo $default_value; ?>"
                    >
                        <option value="all" selected>Catégories</option>
            			<option value=""></option>
            			
                        <?php
            			    if (!empty($terms) && !is_wp_error($terms)) {
            			    	foreach ($terms as $term) {
            			    		echo '<option class="option" id="' . $term->slug . '" value="' . esc_attr($term->term_id) . '">' . esc_html($term->name) . '</option>';
            			    	}
            			    }
                        ?>
            		</select>
                    <input type="hidden" name="nonce" value="<?php echo wp_create_nonce( 'categorie_filters' ); ?>"> 
                    <input type="hidden" name="action" value="categorie_filters">
                </form>
            </div>

            <div class="filter-container__wrapper">
                <?php // Formulaire de filtres de formats                
                mota_photo_format_filter()?>
            </div>
        </div>

        <?php //FILTRE DATES
        echo do_shortcode('[date_filter]'); ?> 
        <div class="filter-container__date">
            <div class="filter-container__wrapper">
                <form 
                class="filter-container__form__date"
                action="<?php echo admin_url('admin-ajax.php'); ?>"
                method="post"
                >
                    <select id="filter-container__date" name="filter-container__date">
                        <option value="" disabled selected>Trier par date</option>
	            		<option value=""></option>
                        <option class="option" value="DESC">à partir des plus récentes</option>
                        <option class="option" value="ASC">à partir des plus anciennes</option>
	            	</select>

                	<input type="hidden" name="action" value="filter-container__date_action">
	            	<?php wp_nonce_field( 'filter-container__date_nonce', 'filter-container__date_nonce_field' ); ?>
	            </form>
            </div>
        </div>
    </section>    

    <!-- <section class="photos-display"></section> -->


    <?php // >>> BLOC PHOTOS
    get_template_part( 'templates_part/photos_block' );
     ?>

    <button class="supplement">Charger plus</button>
</main>

<?php get_footer(); ?>
