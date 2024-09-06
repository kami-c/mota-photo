/* GESTIONNAIRE DE FILTRES */
( function( $ ) {
    $(() => {
        function filters() {

            let currentPage = 1;

            function loadFilters() {
                $('#filters').on('change', 'select', function() {
                    currentPage = 1;
                    $('#photo-container').html('');
                    loadImages(true);
                });
            }
    
            function loadMore() {
                $('#load-more').on('click', function() {
                    currentPage++;
                    loadImages();
                });
            }

            function loadImages(reset = false) {
                let categorie = $('#filter-container__categorie').val();
                let format = $('#filter-container__format').val();
                let order = $('#filter-container__date').val();
                let nonce = $('#filters input[name="nonce"]').val();

                categorie = (categorie === 'all') ? '' : categorie;
                format = (format === 'all') ? '' : format;
                order = (order === 'all') ? '' : order;

                $.ajax({
                    url: filters_object.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'ajax_filter',
                        categorie: categorie,
                        format: format,
                        order: order,
                        paged: currentPage,
                        nonce: nonce
                    },
                    
                    success: function(data){                        
                        $('#load-more')
                            .prop('disabled', false)
                            .text('Charger plus')
                            .removeClass('load-more--disabled');

                        if (!data || data.trim() === '' || data.includes('Il n\'y a pas d\'autres photos')) {
                            $('#load-more')
                                .prop('disabled', true)
                                .text('Il n\'y a pas d\'autres photos à charger')
                                .removeClass('load-more')
                                .addClass('load-more--disabled');
                        } else {
                            if (reset) {
                                $('#photo-container').html(data);
                            } else {
                                $('#photo-container').append(data);
                            }
                            lightbox();
                        }
                    },
                    
                    error: function(xhr, status, error) {
                        console.log('Erreur AJAX : ' + status + ' - ' + error);
                    }
                });
            }
            loadImages(true);
            loadFilters();
            loadMore();
        };
        filters();
    })
} )( jQuery ) 