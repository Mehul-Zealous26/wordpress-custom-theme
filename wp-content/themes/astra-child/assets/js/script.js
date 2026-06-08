jQuery(document).ready(function ($) {
    $(document).on('change', '.category-filter', function () {

    let categories = [];

    $('.category-filter:checked').each(function () {
        categories.push($(this).val());
    });

    if (categories.includes('clothes')) {
        $('#subcategory-wrapper').show();
        $('#size-wrapper').show();
        $('#color-wrapper').show();
    } else {
        $('#subcategory-wrapper').hide();
        $('#size-wrapper').hide();
        $('#color-wrapper').hide();
    }

    productFilter();
});

    $(document).on('change', '.category-filter, .subcategory-filter, .color-filter, .size-filter, .brand-filter, stock-filter', function () {
        productFilter();
    }
);

    $(document).on('change', '.price-filter', function () {
        productFilter();
    });

    function productFilter() {
    let categories = [];
    let subcategories = [];
    let colors = [];
    let sizes = [];
    let brands = [];
    let priceRange = [];
    let stockStatus = [];

    $('.category-filter:checked').each(function () {
        categories.push($(this).val());
    });

    $('.subcategory-filter:checked').each(function(){
        subcategories.push($(this).val());
    });

    $('.color-filter:checked').each(function () {
        colors.push($(this).val());
    });

    $('.size-filter:checked').each(function () {
        sizes.push($(this).val());
    });

    $('.brand-filter:checked').each(function () {
        brands.push($(this).val());
    });

    $('.price-filter:checked').each(function(){
        priceRange.push($(this).val());
    });

    $('.stock-filter:checked').each(function(){
    stockStatus.push($(this).val());
    });

    //console.log(priceRange);
    $.ajax({
        url: filter_ajax.ajax_url,
        type: 'POST',
        data: {
            action: 'filter_products',
            categories: categories,
            subcategories: subcategories,
            colors: colors,
            sizes: sizes,
            brands: brands,
            priceRange: priceRange,
            stockStatus: stockStatus,
        },
        success: function (response) {
            $('#products-container').html(response);
        }
    });
}
});


