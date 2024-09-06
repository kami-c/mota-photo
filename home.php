<?php
/**
 * Home
 */
get_header(); ?>

<main>
    <section class="hero-header">
        <h1 class="hero-header__title">PHOTOGRAPHE EVENT</h1>
        <?php mota_photo_hero_header_filter(); // IMAGE ALÉATOIRE EN FOND ?>
    </section>
    <section class="filter-container">
        <form
        action="filters"
        method="post"
        id="filters"
        class="filter-container__form"
        aria-label="Filtres de tri">
            <div class="filter-container__category-format">
                <select id="filter-container__categorie" name="category" aria-label="Catégorie">
                    <option value="all">Catégories</option>
                    <?php
                    $categories = get_terms(array(
                        'taxonomy'      => 'categorie',
                        'hide_empty'    => false,
                        'parent'        => 0,
                    ));

                    echo '<option value="" disabled></option>';
                    foreach ($categories as $categorie) {
                        echo '<option value="' . esc_attr($categorie->slug) . '">' . esc_html($categorie->name) . '</option>';
                    }
                    ?>
                </select>

                <select id="filter-container__format" name="format" aria-label="Format">
                    <option value="all">Formats</option>
                    <?php 
                    $formats = get_terms(array(
                        'taxonomy'          => 'format',
                        'hide_empty'         => false,
                        'parent'             => 0,
                    ));

                    echo '<option value="" disabled></option>';
                    foreach ($formats as $term) {
                            echo '<option value="' . esc_attr($term->slug) . '">' . esc_html($term->name) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="filter-container__date">
                <select id="filter-container__date" name="date" aria-label="Date">
                    <option value="all">Trier par date</option>
                    <option value=""></option>
                    <option value="desc">Du plus récent au plus ancien</option>
                    <option value="asc">Du plus ancien au plus récent</option>
	    	    </select>
            </div>
            <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('filter_nonce'); ?>">
        </form>
    </section>
    <div class="photo-bloc">
        <div id="photo-container"></div>
    </div>
    <button id="load-more" class="load-more" data-page="1">Charger plus</button>
</main>

<?php get_footer(); ?>
