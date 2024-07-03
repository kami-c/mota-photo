/* GESTIONNAIRE DES FILTRES */

( function( $ ) {

    // Exécution après chargement du complet du DOM
    $(() => {
        function filters() {
            //Si le nombre d'images par page du tableau image.Data est supérieur à 0
            if (typeof imageData !== 'undefined' && imageData.imagesPerPage > 0) {
                let imagesPerPage = imageData.imagesPerPage;
                let totalImages = imageData.totalImages;
                let allDataImages = imageData.allDataImages;
                let currentPage = 1;
            
                // AFFICHAGE DES PHOTOS EN FONCTION DES FILTRES SÉLECTIONNÉS
                function updateImages(category, format, dateOrder, append = false) {
                    let $container = $('#photo-container');
                    if (!append) {
                        $container.empty();
                    }
                
                    // TRI EN PAR CATÉGORIE/FORMAT
                    let filteredImages = allDataImages.filter(function(image) {
                        let categoryMatch = category === 'all' || image.category.includes(category);
                        let formatMatch = format === 'all' || image.format.includes(format);
                        return categoryMatch && formatMatch;
                    });
                
                    // TRI EN PAR DATE
                    if (dateOrder === 'asc') {
                        filteredImages.sort(function(a, b) {
                            return new Date(a.date) - new Date(b.date);
                        });
                    } else {
                        filteredImages.sort(function(a, b) {
                            return new Date(b.date) - new Date(a.date);
                        });
                    }
                
                    // PAGINATION
                    let start = (currentPage - 1) * imagesPerPage;
                    let end = Math.min(start + imagesPerPage, filteredImages.length);
                    let currentImages = filteredImages.slice(start, end);
                
                    // PERSONNALISATION DE L'AFFICHAGE DE CHAQUE PHOTO
                    currentImages.forEach(function(image) {
                        let $div = $('<div>', { class: 'photo-bloc__img' });
                        $div.html(`
                            <a href="${image.url}" class="link"
                               data-title="${image.title}"
                               data-reference="${image.reference}"
                               data-category="${image.category}"
                               data-post-url="${image.post_url}">
                                <img src="${image.url}" alt="${image.alt}" class="image"/>
                            </a>
                        `);
                        $container.append($div);
                    });
                
                    // APPEL DE LA FONCTION LIGHTBOX
                    lightbox();
                
                    // GESTION DU BOUTON 'Charger plus'
                    if (end >= filteredImages.length) {
                        $('.load-more').hide();
                        let message = '<p id="no-more-photos-message" style="margin: 40px auto 40px auto; display:flex; justify-content: center;">Il n\'y a plus de photos à afficher</p>';
                        $('#no-more-photos-message').remove();
                        $('.load-more').after(message);
                    } else {
                        $('.load-more').show();
                        $('#no-more-photos-message').remove();
                    }
                }
            
                // GESTIONNAIRE D'ÉCOUTEURS D'ÉVÈNEMENTS
                $('#filter-container__categorie').on('change', function() {
                    let selectedCategory = $(this).val();
                    currentPage = 1;
                    let selectedFormat = $('#filter-container__format').val();
                    let selectedDate = $('#filter-container__date').val();
                    updateImages(selectedCategory, selectedFormat, selectedDate);
                });
            
                $('#filter-container__format').on('change', function() {
                    let selectedFormat = $(this).val();
                    currentPage = 1;
                    let selectedCategory = $('#filter-container__categorie').val();
                    let selectedDate = $('#filter-container__date').val();
                    updateImages(selectedCategory, selectedFormat, selectedDate);
                });
            
                $('#filter-container__date').on('change', function() {
                    let selectedDate = $(this).val();
                    currentPage = 1;
                    let selectedCategory = $('#filter-container__categorie').val();
                    let selectedFormat = $('#filter-container__format').val();
                    updateImages(selectedCategory, selectedFormat, selectedDate);
                });
            
                $('.load-more').on('click', function() {
                    currentPage++;
                    let selectedCategory = $('#filter-container__categorie').val();
                    let selectedFormat = $('#filter-container__format').val();
                    let selectedDate = $('#filter-container__date').val();
                    updateImages(selectedCategory, selectedFormat, selectedDate, true);
                });
            
                // AFFICHAGE INITIAL DES PHOTOS
                updateImages('all', 'all', 'desc');
            }
        };
        filters();
    })

} )( jQuery )