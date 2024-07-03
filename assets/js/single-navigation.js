/* jQuery */
( function( $ ) {

    // Exécution après chargement du complet du DOM
    $(() => {

        function singleNav() {
            const previousButton = document.querySelector('.button__previous');
            const nextButton = document.querySelector('.button_next');
        
            if (previousButton) { // Récupération de la valeur de 'data-image-url' du bouton précédent
                const previousImageUrl = previousButton.getAttribute('data-image-url');
                if (previousImageUrl) { // Ajout de la valeur de 'previousImageUrl' sur la propriété background-image de '.button__previous::before'
                    previousButton.style.setProperty('--previous-image-url', `url(${previousImageUrl})`);
                }
            }
        
            if (nextButton) {  // Récupération de la valeur de 'data-image-url' du bouton suivant
                const nextImageUrl = nextButton.getAttribute('data-image-url');
                if (nextImageUrl) { // Ajout de la valeur de 'nextImageUrl' sur la propriété background-image de '.button_next::after'
                    nextButton.style.setProperty('--next-image-url', `url(${nextImageUrl})`);
                }
            }
        };
        
        // EXÉCUTION DE LA FONCTION D'AFFICHAGE POUR LA NAVIGATION
        singleNav();
    })

} )( jQuery )