// >>> GESTIONNAIRE DES FILTRES
function filters() {

    // const photos = $('.photo-bloc')
    // const format = $('#filter-container__format')
    // const date = $('#filter-container__date')
    const formCat = $('.filter-container__form__categorie')
    console.log("Contenu FormCat" , formCat)

    // >>> CATÉGORIES
    $(formCat).change(function(e) {

        e.preventDefault(); // Blocage de l'envoi du formulaire

        // const categoryFilter = Array.from($('.filter-container__categorie'));
        // console.log(categoryFilter)

        // L'URL qui réceptionne les requêtes Ajax dans l'attribut "action" de <form>
        const ajaxurl = $(formCat).attr('action');
        console.log("URL : " , ajaxurl)
        
        // const categorie = $(this).val();
        // console.log(categorie)

        // Données du formulaire
        const data = {
            action: $(this).find('input[name=action]').val(),
            nonce:  $(this).find('input[name=nonce]').val(),
            postid: $(this).find('input[name=categorie]').val(),
        }

        console.log(data)
    
        fetch(ajaxurl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'Cache-Control': 'no-cache',
            },
            body: new URLSearchParams(data
                // {   action: 'mota_photo_category_filter_home',
                //     category: categorie
                // }
            )
        })

        .then(response => response.json())
        .then(body => {
            console.log(body);

            // En cas d'erreur
            if (!body.success) {
                alert(response.data);
                return;
            }

            // Et en cas de réussite
            $(this).hide(); // Cacher le formulaire
            $('.photo-bloc').html(body.data); // Et afficher le HTML
        });
    });
    

    // >>> FORMATS
    // format = $('#filter-container__format');
    // console.log(format)
    // console.log(format.options)

    // $(format).on('submit', function(e) {
    //     e.preventDefault();

    //     const ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
    //     console.log(ajaxurl);

    //     // const data = $(this).serialize();
    //     // console.log(data)

    //     // let format = $(this).val();
    //     // console.log(format)

    //     // $(this).find('select[name=action]').val()
    //     // console.log(this)

    //     $.ajax({
    //         type: 'POST',
    //         url: ajaxurl,
    //         dataType: 'json',
    //         data: {
    //             action: 'mota_photo_format_filter',
    //             nonce: $('format_nonce_field').val()
    //         },
    //         success: function(response) {
    //             $('photo_block').html(response);
    //             console.log('Réponse Ajax reçue :', response);
    //         },

    //         error: function(xhr, status, error) {
    //             console.error(xhr.responseText + ': ' + status.responseText + ': ' + error.responseText);
    //             alert('Erreur ' + xhr.status + ': ' + xhr.statusText);
    //         }
    //     });

    // });

    // // >>> TRI PAR DATES
    // $('.filter-container__form__date').on('submit', function(e) {
    //     e.preventDefault();

    //     const orderby = $(this).attr('action');
    //     // console.log(ajaxurl);

    //     // let orderby = $(this).val();
    //     console.log(orderby)

    //     $.ajax({
    //         type: 'POST',
    //         url: ajax_object.ajax_url,
    //         data: {
    //             action: 'filter-container__date_action',
    //             orderby_date: orderby,
    //             nonce: $('filter-container__date_nonce_field').val()
    //         },
    //         success: function(response) {
    //             $('.photo-bloc').html(response);
    //         },

    //         error: function(xhr, status, error) {
    //             console.error(xhr.responseText);
    //             alert('Erreur ' + xhr.status + ': ' + xhr.statusText);
    //         }
    //     });
    // });
}