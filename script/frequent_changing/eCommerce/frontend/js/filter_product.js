$(function () {
    "use strict";

    // Plugin Call
    $(".select2").select2();
    toastr.options = {
        positionClass: 'toast-bottom-right'
    };

    // Hidden Input field value for ecommerce
    let base_url = $('#base_url').val();
    let curreny = $('#curreny_frontend').val();
    let precision = $('#precision').val();


    
    function loadProducts(page = 1) {
        let url_name = $('.url_name').val();
        let initial_load = $('.initial_load').val();
        let initial_filter_id = $('.initial_filter_id').val();
    
        let searc_type = '';
        if(url_name == 'e-brand'){
            searc_type = 'brand';
        }else if(url_name == 'e-category'){
            searc_type = 'category';
        }else{
            searc_type = '';
        }

        let initial_filter_by = '';
        if(initial_load == 'Yes'){
            initial_filter_by = initial_filter_id;
        }else{
            initial_filter_by = '';
        }

        let categories = [];
        let brands = [];
        let priceRangeWithCurrency = $('#amount').val();
        let priceRange = priceRangeWithCurrency.replace(/[^0-9]/g, ',')
            .split(',')
            .filter(num => num !== '')
            .join(',');
        
        // Get selected categories
        $('input[name="product_category"]:checked').each(function() {
            let categoryId = $(this).attr('id');
            if(categoryId) {
                categories.push(categoryId.replace('cat-', ''));
            }
        });
        
        // Get selected brands
        $('input[name="product_brand"]:checked').each(function() {
            let brandId = $(this).attr('id');
            if(brandId) {
                brands.push(brandId.replace('bnd-', ''));
            }
        });

        // Get product sorting value
        let sorting = $('.product_sorting').val() || 'Default';

        // Make AJAX request
        $.ajax({
            url: base_url + 'ECommerce_frontend/filterProducts',
            type: 'GET',
            dataType: 'json',
            data: {
                page: page,
                categories: categories,
                brands: brands,
                price_range: priceRange,
                type: searc_type,
                main_id: initial_filter_by,
                sorting: sorting
            },
            success: function(response) {
                if(response) {
                    $('.shop_products .row').html(response.products_html);
                    $('.pagination_wrp').html(response.pagination);
                    $('.view_filter strong').text(response.total_products);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error loading products:', error);
                toastr.error('Error loading products. Please try again.');
                $('.pagination_wrp').empty();
                $('.view_filter strong').text('0');
            }
        });
    }
    loadProducts();

    // Filter change events
    $(document).on('change', 'input[name="product_category"], input[name="product_brand"]', function() {
        $('.initial_load').val('No');
        loadProducts();
    });

    // Price range change
    $(document).on('slidechange', '#slider-range', function() {
        $('.initial_load').val('No');
        loadProducts();
    });

    $(".product_sorting").on("change", function() {
        loadProducts();
    });

    // Pagination click
    $(document).on('click', '.single_paginat', function() {
        if(!$(this).hasClass('active')) {
            let page = $(this).data('page');
            loadProducts(page);
            $('html, body').animate({
                scrollTop: $('.shop_products').offset().top - 100
            }, 500);
        }
    });


    





    




});