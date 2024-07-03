/* GESTIONNAIRE DE LA MODALE DE CONTACT */

// FONCTION D'OUVERTURE/FERMETURE DE LA MODALE
function openCloseModal() {  
    // REQUÊTE AJAX pour récupérer "contact.php"
    $.ajax({
        url: 'contact',
        dataType: 'html',
        success: function(data) {},

        // SI PROBLÈME AVEC REQUÊTE
        error: function(xhr, status, error) {
            console.error('Erreur lors du chargement de contact.php : ' + status + ' - ' + error);
        }
    });

    // ÉCOUTEUR D'ÉVÈNEMENTS sur la classe .modale : au clic
    $(".modale").on("click", function(e) {
        // BLOCAGE DU RECHARGEMENT DE LA PAGE
        e.preventDefault();

        // OUVERTURE DE LA MODALE avec animation en fadeIn
        $(".modal").fadeIn();
    });

    // ÉCOUTEUR D'ÉVÈNEMENTS des clics sur la fenêtre en dehors de la modale
    $(window).on("click", function(event) {
        // CONDITION pour vérifier SI l'élément cliqué à la class .modal (width : 100% donc présent sur toute la fenêtre)
        if ($(event.target).is(".modal")) {
            // FERMETURE DE LA MODALE avec une animation en fadeOut
            $(".modal").fadeOut();
        }
    });
}

// FONCTION D'AJOUT DE LA RÉFÉRENCE DE LA PHOTO CONSULTÉE
function addRef() {  
    // RÉCUPÉRATION DE LA RÉFÉRENCE PHOTO dans le post en cours
    const currentReference = $('.reference').text();

    // CHAMP DE RÉFÉRENCE PHOTO DU FORMAULAIRE SÉLECTIONNÉ
    const reference = $('.reference-field');
    
    // AJOUT DE LA RÉFÉRENCE DANS LE FORMULAIRE au champ dédié
    reference.val(currentReference);
}

