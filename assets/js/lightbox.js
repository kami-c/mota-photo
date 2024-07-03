/* EXÉCUTION DE LA FONCTION D'AFFICHAGE DE LA LIGHTBOX */
function lightbox() {
    
    $('.link').hover( //  GESTION DES ÉVÈNEMENTS AU SURVOL DE '.link'

        function() {  // 1. Lorsque la souris entre dans l'élément 
            //  Récupération des données au survol
            const reference = $(this).data('reference');
            const category = $(this).data('category');
            const url = $(this).data('post-url');

            $(this).append( //  Ajout de contenu HTML (cf. maquette) sur '.link'
                '<div class="hover-info">' +
                    '<button class="hover-info__full"></button>' +
                    '<button class="hover-info__more"></button>' + // Remove onclick attribute
                    '<div class="info-container">'+
                        '<p class="info-container__reference">' + reference + '</p>' +
                        '<p class="info-container__category">' + category + '</p>' +
                    '</div>'+
                '</div>'
            );

            $(this).find('.hover-info__more').on('click', function(e) { // GESTION DE L'ÉVÈNEMENT AU CLIC DE '.hover-info__more'
                e.preventDefault();
                e.stopPropagation();
                window.open(url, '_blank');
            });
        },

        function() { // 2. Lorsque la souris quitte l'élément
            $(this).find('.hover-info').remove(); //  Retrait du contenu HTML à la fin du survol
        }
    );

    $('.link').on('click', function(e) { // GESTION DES ÉVÈNEMENTS AU CLIC SUR '.link'
        e.preventDefault();

        const images = $('.link'); // Sélection de toutes les images de la galerie
        let currentIndex = images.index($(this)); // Index de l'image courante

        function showNextImage() { //  AFFICHAGE DE L'IMAGE SUIVANTE DANS LA LIGHTBOX
            currentIndex++;
            if (currentIndex >= images.length) {
                currentIndex = 0; // Réinitialisation du compteur pour retourner à la première image = boucle pour créer un effet de carrousel
            }
            showImageAtIndex(currentIndex);
        }

        function showPrevImage() { // AFFICHAGE DE L'IMAGE PRÉCÉDENTE DANS LA LIGHTBOX
           currentIndex--;
           if (currentIndex < 0) {
               currentIndex = images.length - 1; // Récupération de l'index de la dernière image pour créer boucler et garder l'effet de carrousel
           }
           showImageAtIndex(currentIndex);
        }

        function showImageAtIndex(index) { // AFFICHAGE DE L'IMAGE EN COURS DANS LA LIGHTBOX
            $('.lightbox').remove(); // Suppression de toutes les lightbox précédemment ouvertes

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
        
            $('body').append(lightbox); // Ajout de la lightbox à la page

            $('.lightbox__image').on('load', function() { // GESTION DE L'AFFICHAGE DE L'IMAGE LORS DE SON CHARGEMENT
                $('.lightbox__container--loader').remove(); // Suppression du loader une fois l'image chargée
                $('.lightbox').fadeIn(); // Afficher la lightbox une fois que l'image est chargée
            });

            $('.lightbox__close').on('click', function(e) { // GESTION DES ÉVÈNEMENTS AU CLIC SUR '.lightbox__close'
                e.preventDefault();
                $('.lightbox').fadeOut(); // Fermeture de la lightbox
                $(this).remove();
            });

            $(document).on('keyup', function(e) { // GESTION DES ÉVÈNEMENTS LORS DE LA NAVIGATION AU CLAVIER
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

            $('.lightbox__next').on('click', function(e) { // GESTION DES ÉVÈNEMENTS AU CLIC SUR '.lightbox__next'
                e.preventDefault();
                showNextImage(); // Affichage de l'image suivante
            });
            
            
            $('.lightbox__prev').on('click', function(e) { // GESTION DES ÉVÈNEMENTS AU CLIC SUR '.lightbox__prev'
                e.preventDefault();
                showPrevImage(); // Affichage de l'image précédente
            });
        }

        $('link, .hover-info__more').on('click', function(e) {  // EMPÊCHER la propagation de l'événement de clic vers les éléments parents .link
            e.stopPropagation();
            window.open($(this).attr('href'), '_blank');
            $('.lightbox').remove();
        });

    showImageAtIndex(currentIndex); // AFFICHAGE DE L'IMAGE SÉLECTIONNÉE DANS LA LIGHTBOX
    });
}