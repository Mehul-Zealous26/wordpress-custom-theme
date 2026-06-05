jQuery(document).ready(function ($) {
    $(document).on('change', '#category-filter, #color-filter, #size-filter, #brand-filter', function() {
        productFilter();
    });
    
    $(document).on('click', '#price-filter',function() {
        productFilter();
    })

    function productFilter(){
        let category = $('#category-filter').val();
        let color = $('#color-filter').val();
        let size = $('#size-filter').val();
        let brand = $('#brand-filter').val();
        let price = $('#price-filter').val();
        let minPrice = $('#min-price').val();
        let maxPrice = $('#max-price').val();
        
        $.ajax({
            url: filter_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'filter_products',
                category: category,
                color: color,
                size: size,
                brand: brand,
                price: price,
                minPrice: minPrice,
                maxPrice: maxPrice,
            },
            success: function(response) {
                $('#products-container').html(response);
            }
        });

    }
});


