// >>> jQuery <<< //
( function( $ ) {

    // >>> Exécution après chargement du complet du DOM
    $(() => {
        
        // >>> EXCÉCUTION DES FONCTIONS DE LA MODALE DE CONTACT <<< //
        // >>> cf. contact.js
        openCloseModal()
        addRef()
        
        // >>> FILTRES
        filters()
        console.log("Filters OK")

        // >>> LIGHTBOX
        Lightbox.init()
        console.log("Lightbox OK")
    })

} )( jQuery )
