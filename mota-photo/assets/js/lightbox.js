/* EXÉCUTION DE LA FONCTION D'AFFICHAGE DE LA LIGHTBOX */
function lightbox() {
    
    $('.link').hover( // Overlay sur photos
    
        function() {
            const reference = $(this).data('reference');
            const category = $(this).data('category');
            const url = $(this).data('post-url');
        
            $(this).append(
                '<div class="hover-info">' +
                    '<button class="hover-info__full"></button>' +
                    '<button class="hover-info__more"></button>' +
                    '<div class="info-container">'+
                        '<p class="info-container__reference">' + reference + '</p>' +
                        '<p class="info-container__category">' + category + '</p>' +
                    '</div>'+
                '</div>'
            );
        
            $(this).find('.hover-info__more').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                window.open(url, '_blank');
            });
        },
    
        function() {
            $(this).find('.hover-info').remove();
        }
    );

    $('.link').on('click', function(e) {
        e.preventDefault();
    
        const images = $('.link');
        let currentIndex = images.index($(this));
    
        function showNextImage() {
            currentIndex++;
            if (currentIndex >= images.length) {
                currentIndex = 0;
            }
            showImageAtIndex(currentIndex);
        }
    
        function showPrevImage() {
           currentIndex--;
           if (currentIndex < 0) {
               currentIndex = images.length - 1;
           }
           showImageAtIndex(currentIndex);
        }
    
        function showImageAtIndex(index) { // AFFICHAGE DE L'IMAGE EN COURS DANS LA LIGHTBOX
            $('.lightbox').remove();
        
            // Récupération des données à afficher dans la lightbox
            const imageUrl = $(images[index]).attr('href');
            const imageTitle = $(images[index]).data('title');
            const imageReference = $(images[index]).data('reference');
            const imageCategory = $(images[index]).data('category');
            // Création du contenu HTML de la lightbox
            const lightbox = '<div class="lightbox">' +
                                '<button class="lightbox__close">Fermer</button>' +
                                '<button class="lightbox__next">Suivant</button>' +
                                '<button class="lightbox__prev">Précédent</button>' +
                                '<div class="lightbox__container">' +
                                    '<div class="lightbox__container--loader"></div>' +
                                    '<img class="lightbox__image" src="' + imageUrl + '" alt="' + imageTitle + '" />' +
                                    '<p class="reference">' + imageReference + '</p>' +
                                    '<p class="category">'+ imageCategory + '</p>' +
                                '</div>' +
                            '</div>';
        
            $('body').append(lightbox);
            $('.lightbox__image').on('load', function() { // GESTION DE L'AFFICHAGE DE L'IMAGE LORS DE SON CHARGEMENT
                $('.lightbox__container--loader').remove();
                $('.lightbox').fadeIn();
            });
        
            $('.lightbox__close').on('click', function(e) {
                e.preventDefault();
                $('.lightbox').fadeOut();
                $(this).remove();
            });
        
            $(document).on('keyup', function(e) { // NAVIGATION AU CLAVIER
                if (e.key === 'Escape') {
                    $('.lightbox').fadeOut(function() {
                        $(this).remove();
                    });
                } else if (e.key === 'ArrowRight' || e.key === 'ArrowDown') {
                    showNextImage();
                } else if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') {
                    showPrevImage();
                }
            });
        
            $('.lightbox__next').on('click', function(e) {
                e.preventDefault();
                showNextImage();
            });
            $('.lightbox__prev').on('click', function(e) {
                e.preventDefault();
                showPrevImage();
            });
        }
    
        $('link, .hover-info__more').on('click', function(e) {
            e.stopPropagation();
            window.open($(this).attr('href'), '_blank');
            $('.lightbox').remove();
        });
    
    showImageAtIndex(currentIndex);
    });
}