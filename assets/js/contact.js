/* ---------------------------- FENÊTRE MODALE ---------------------------- */
function openCloseModal() { 

    // >>> VARIABLE 
    const modalLink = $('.modale')

    /// >>> GESTION DE LA FENÊTRE MODALE
    $(".modale").on("click", function(e) {
        e.preventDefault();

        // >>> RÉCUPÉRATION DE "contact.php"
        $.ajax({
            url: 'contact',
            dataType: 'html',
            success: function(data) {
                const contact = data;

                // >>> OUVERTURE LA MODALE
                $(".modal").fadeIn();
            },
        });

        // >>> GESTION DE FERMETURE DE LA MODALE
        $(window).on("click", function(event) {
            if ($(event.target).is(".modal")) {
                $(".modal").fadeOut();
            }
        });
    });
}
