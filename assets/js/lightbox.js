/* * * * * * * * * *
*   LIGHTBOX.JS    *
 * * * * * * * * * */

function lightbox() {

    // Lors du survol de l'image
    $('.link').hover(
        function() {
            // Fonction exécutée lorsque survol commence
            const reference = $(this).data('reference');
            const category = $(this).data('category');
            
            // Afficher les informations dans un élément dédié
            $(this).append('<div class="hover-info">' +
                                '<p class="hover-info__reference">' + reference +'</p>' +
                                '<p class="hover-info__category">' + category + '</p>' +
                            '</div>');
        }, 
        function() {
            // Fonction exécutée lorsque survol termine
            $(this).find('.hover-info').remove(); // Supprimer les informations lorsque le survol se termine
        }
    );

    // Lors du clic sur image
    $('.link').on('click', function(e) {
        e.preventDefault();

        const images = $('.link'); // Sélectionnez toutes les images de la galerie
        let currentIndex = images.index($(this)); // Index de l'image actuellement ouverte

        // Fonction pour afficher l'image suivante dans la lightbox
        function showNextImage() {
            currentIndex++;
            if (currentIndex >= images.length) {
                currentIndex = 0; // Revenir au début de la galerie si on dépasse la dernière image
            }
            showImageAtIndex(currentIndex);
        }

        // Fonction pour afficher l'image précédente dans la lightbox
        function showPrevImage() {
           currentIndex--;
           if (currentIndex < 0) {
               currentIndex = images.length - 1; // Aller à la dernière image si on dépasse la première image
           }
           showImageAtIndex(currentIndex);
        }

        function showImageAtIndex(index) {

            const imageUrl = $(images[index]).attr('href');
            const imageTitle = $(images[index]).data('title');

            const imageReference = $(images[index]).data('reference');
            const imageCategory = $(images[index]).data('category');

            // Afficher le loader pendant le chargement de l'image
            const loader = '<div class="lightbox__loader"></div>';
            $('body').append(loader);

            const lightbox = '<div class="lightbox">' +
                                '<button class="lightbox__close">Fermer</button>' +
                                '<button class="lightbox__next">Suivant</button>' +
                                '<button class="lightbox__prev">Précédent</button>' +
                                '<div class="lightbox__container">' +
                                    '<img src="' + imageUrl + '" alt="' + imageTitle + '" />' +
                                    '<p class="reference">' + imageReference + '</p>' +
                                    '<p class="category">'+ imageCategory + '</p>' +
                                '</div>' +
                            '</div>';
        
            // Ajouter la boîte de dialogue à la page
            $('body').append(lightbox);

            // Cacher le loader une fois que l'image est chargée
            $('.lightbox__image').on('load', function() {
                $('.lightbox__loader').remove(); // Supprimer le loader
                $('.lightbox').fadeIn(); // Afficher la lightbox une fois que l'image est chargée
            });

            // Afficher la lightbox
            $('.lightbox').fadeIn();

            // Fermer la lightbox en cliquant sur le bouton Fermer
            $('.lightbox__close').on('click', function(e) {
                e.preventDefault();
                $('.lightbox').fadeOut();
                $(this).remove();
            });

            // Gestion de la navigation avec le clavier
            $(document).on('keyup', function(e) {
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

            // NEXT
            $('.lightbox__next').on('click', function(e) {
                e.preventDefault();
                showNextImage();
            });
            
            // PREVIOUS
            $('.lightbox__prev').on('click', function(e) {
                e.preventDefault();
                showPrevImage();
            });
        }

    // Afficher la première image sélectionnée dans la lightbox
    showImageAtIndex(currentIndex);
        
    });
    return false;
}