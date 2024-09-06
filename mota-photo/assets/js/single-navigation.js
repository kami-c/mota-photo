/* jQuery */
( function( $ ) {
    $(() => {

        function singleNav() {
            const previousButton = document.querySelector('.button__previous');
            const nextButton = document.querySelector('.button_next');
        
            if (previousButton) { 
                const previousImageUrl = previousButton.getAttribute('data-image-url'); // Récupération de la valeur de 'data-image-url' du bouton précédent
                if (previousImageUrl) { 
                    previousButton.style.setProperty('--previous-image-url', `url(${previousImageUrl})`); // Ajout de la valeur de 'previousImageUrl' sur la propriété background-image de '.button__previous::before'
                }
            }
        
            if (nextButton) {  
                const nextImageUrl = nextButton.getAttribute('data-image-url');// Récupération de la valeur de 'data-image-url' du bouton suivant
                if (nextImageUrl) { 
                    nextButton.style.setProperty('--next-image-url', `url(${nextImageUrl})`);// Ajout de la valeur de 'nextImageUrl' sur la propriété background-image de '.button_next::after'
                }
            }
        };
        
        singleNav();
    })
} )( jQuery )