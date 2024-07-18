/* GESTIONNAIRE DE FILTRES */
( function( $ ) {
    $(() => {
        function filters() {

            $('#filters').on('change', 'select', function(){
                let category = $('#filter-container__categorie').val();
                let format = $('filter-container__format').val();
                let order = $('filter-container__date').val();
                
                $.ajax({
                    url: filters_object.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'ajax_filter',
                        category: category,
                        format: format,
                        order: order
                    },
                    success: function(data){
                        $('#photo-container').html(data);
                    },
                    error: function(xhr, status, error) {
                        console.log('Erreur AJAX : ' + status + ' - ' + error);
                    }
                });
            });
        };
        
        filters();
    })

} )( jQuery )
