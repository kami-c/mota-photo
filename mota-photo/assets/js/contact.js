/* GESTIONNAIRE DE LA MODALE DE CONTACT */
function openCloseModal() {  

    $.ajax({
        url: 'contact',
        dataType: 'html',
        success: function(data) {},

        error: function(xhr, status, error) {
            console.error('Erreur lors du chargement de contact.php : ' + status + ' - ' + error);
        }
    });

    $(".modale").on("click", function(e) {
        e.preventDefault();
        $(".modal").fadeIn();
    });

    $(window).on("click", function(event) {
        if ($(event.target).is(".modal")) {
            $(".modal").fadeOut();
        }
    });
}

// FONCTION D'AJOUT DE LA RÉFÉRENCE DE LA PHOTO CONSULTÉE
function addRef() {  
    const currentReference = $('.reference').text();
    const reference = $('.reference-field');
    
    reference.val(currentReference);
}

