// >>> jQuery <<< //
( function( $ ) {

    // >>> Exécution après chargement du complet du DOM
    $(() => {
        
        // >>> EXCÉCUTION DES FONCTIONS DE LA MODALE DE CONTACT <<< //
        // >>> cf. contact.js
        openCloseModal()
        addRef()

        // >>> FILTERS
        // >>> cf. filters.js
        filters()

        // >>> LIGHTBOX
        // >>> cf. lightbox.js
        lightbox()
    })

} )( jQuery )
