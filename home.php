<?php
/**
 * Home
 */
get_header(); ?>

<main>
    <section class="hero-header">
        <h1 class="hero-header__title">PHOTOGRAPHE EVENT</h1>
        <?php mota_photo_hero_header_filter(); // >>> IMAGE ALÉATOIRE EN FOND ?>
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
                    foreach ($categories as $category) {
                        echo '<option value="' . esc_attr($category->slug) . '">' . esc_html($category->name) . '</option>';
                    }
                    ?>
                </select>
                <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('category_filters'); ?>">

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
                <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('format_filters'); ?>">
            </div>
            <div class="filter-container__date">
                <select id="filter-container__date" name="date" aria-label="Date">
                    <option value="all">Trier par date</option>
                    <option value=""></option>
                    <option value="desc">Du plus récent au plus ancien</option>
                    <option value="asc">Du plus ancien au plus récent</option>
	    	    </select>
            </div>
        </form>
    </section>
    <div class="photo-bloc">
        <div id="photo-container"></div>
    </div>
    <button class="load-more">Charger plus</button>
</main>

<?php get_footer(); ?>
