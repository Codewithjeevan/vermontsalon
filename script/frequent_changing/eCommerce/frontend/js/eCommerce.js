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

    // Payment Get way initial Status
    let stripePayementStatus = false;
    let paypalPayementStatus = false;
    



    $(document).on('click', '.newsletter_submit', function(){
        let newsletter_email = $('.newsletter_email').val();
        let error = false;
        if(newsletter_email == ''){
            error = true;
        }
        if(error){
            toastr['error']('Enter Email Address', 'Error');
        }else{
            $.ajax({
                type: "POST",
                url: base_url+"ECommerce_frontend/newsLetterSubmit",
                data: {
                    newsletter_email: newsletter_email
                },
                dataType: "json",
                success: function (response) {
                    if(response.status == 'success'){
                        toastr['success'](response.message, 'Success');
                    }else{
                        toastr['error'](response.message, 'Error');
                    }
                }
            });
        }
    });



    $(document).on('change', '.lan_name', function(){
        let lan_name = $(this).val();
        $.ajax({
            type: "POST",
            url: base_url+"ECommerce_frontend/setlanguage",
            data: {
                lan_name: lan_name
            },
            dataType: "json",
            success: function (response) {
                if(response.status == 'success'){
                    window.location.href = base_url+'e-home';
                }
            }
        });
    });

    $(document).on('keyup', '#slider-range', function(){
        alert('ok')
    })

    // single product view slider
    $('.product_view_slider').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.product_viewslid_nav',
        infinite: false
    });

    // single product view slider nav
    $('.product_viewslid_nav').slick({
        slidesToShow: 5,
        slidesToScroll: 1,
        prevArrow: '<button type="button" class="slick-prev"><i class="las la-angle-left"></i></button>',
        nextArrow: '<button type="button" class="slick-next"><i class="las la-angle-right"></i></button>',
        asNavFor: '.product_view_slider',
        focusOnSelect: true,
        centerMode: false,
        centerPadding: '0px',
        infinite: false,
        responsive: [{
            breakpoint: 576,
            settings: {
                slidesToShow: 3,
            }
        }]
    });

    $(document).on('click', '.open_quickview', function () {
        $('#product_quickview').addClass('active');
        $('body').css('overflow-y', 'hidden');
        let product_id = $(this).attr('data-pro-id');
        $.ajax({
            type: "POST",
            url: base_url + "ECommerce_frontend/getProductInformation",
            data: {
                product_id: product_id,
            },
            dataType: "json",
            success: function (response) {
                if (response.status == 'success') {
                    $('.modal_product_name').text(response.data.parent_name ? response.data.parent_name+'-'+response.data.name:response.data.name);
                    if(response.data.type == 'Variation_Product'){
                        $('.modal_p_stock').val(0);
                    }else{
                        $('.modal_p_stock').val(response.stock);
                    }
                     
                    if(response.data.brand_name){
                        $('.modal_product_brand').text(response.data.brand_name);
                    }else{
                        $('.modal_product_brand').parent().css('display', 'none');
                    }
                    if(response.data.category_name){
                        $('.modal_product_category').text(response.data.category_name);
                    }else{
                        $('.modal_product_category').parent().css('display', 'none');
                    }
                    if (response.data.description) {
                        $('.modal_product_details').text(response.data.description);
                        $('.modal_product_details').parent().removeClass('d-none');
                    } else {
                        $('.modal_product_details').parent().addClass('d-none');
                    }
                    // Display rating stars based on product rating
                    let modal_rating_html = '';
                    for(let i=5; i>=1; i--) {
                        modal_rating_html += `<span class="product-id" 
                            data-product-id="${response.data.id}" 
                            data-ratting="${i}">
                            <i class="${response.data.avg_rating >= i ? 'bi bi-star-fill current-r' : 'bi bi-star'}"></i>
                        </span>`;
                    }
                    $('.modal_product_ratting .rating_star').html(modal_rating_html);
                    $('.modal_product_ratting .rating_count').text(`(${isNaN(parseFloat(response.data.avg_rating)) ? '0.0' : parseFloat(response.data.avg_rating).toFixed(1)})`);
                    let org_price = 0;
                    if (typeof response.data.discount_price === 'string' && response.data.discount_price.includes('%')) { 
                        org_price = response.data.sale_price * (100 - parseInt(response.data.discount_price)) / 100;
                    } else {
                        if(response.data.discount_price){
                            org_price = response.data.sale_price - parseFloat(response.data.discount_price);
                        }else{
                            org_price = response.data.sale_price;
                        }
                    }
                    
                    if(response.data.discount_price){
                        $('.modal_product_org_price').text(curreny + ' ' + parseFloat(org_price).toFixed(2));
                        $('.modal_product_prev_price').text(curreny + ' ' + parseFloat(response.data.sale_price).toFixed(2));
                    }else{
                        $('.modal_product_org_price').text(curreny + ' ' + parseFloat(response.data.sale_price).toFixed(2));
                        $('.modal_product_prev_price').css('display', 'none');
                    }
                    if(response.data.discount_price){
                        $('.disc_tag').text(response.data.discount_price);
                    }else{
                        $('.disc_tag').css('display', 'none');
                    }
                    $('.add-to-cart-quick').attr('data-product-id', response.data.id);
                    $('.adto_wish-quick').attr('data-pro-id', response.data.id);
                    $('.add-to-cart-quick').attr('data-sp', org_price);
                    if(response.data.type != 'Variation_Product'){
                        $('.modal_product_quantity').text('1');
                        if (response.stock > 0) {
                            $('.modal_product_stock').removeClass('text-danger').addClass('text-green').text('In Stock');
                        } else {
                            $('.modal_product_stock').removeClass('text-success').addClass('text-danger').text('Stock Out');
                        }
                    }else{
                        $('.modal_product_stock').removeClass('text-green text-success text-danger').text('N/A');
                        $('.modal_product_quantity').text('0');
                    } 
                    
                    let img_list = '';
                    // Destroy existing slick instances if they exist
                    if ($('.product_view_slider3').hasClass('slick-initialized')) {
                        $('.product_view_slider3').slick('unslick');
                    }
                    if ($('.product_viewslid_nav3').hasClass('slick-initialized')) {
                        $('.product_viewslid_nav3').slick('unslick');
                    }

                    // Build image lists based on product type
                    if (response.data.type == 'Variation_Product') {
                        // For variation products, use single photo
                        let product_image = response.data.photo ? 
                            `${base_url}uploads/items/${response.data.photo}` : 
                            `${base_url}uploads/site_settings/default-picture.png`;
                        
                        img_list = `<div class="single_viewslider">
                            <img loading="lazy" src="${product_image}" alt="${response.data.name}">
                        </div>`;
                    } else {
                        // For regular products, use product_image array
                        if (response.product_image && response.product_image.length > 0) {
                            $.each(response.product_image, function (ind, val) {
                                img_list += `<div class="single_viewslider">
                                    <img loading="lazy" src="${base_url}uploads/eCommerce/item_images/${val.image}" alt="product">
                                </div>`;
                            });
                        } else {
                            if(response.data.photo){
                                img_list = `<div class="single_viewslider">
                                    <img loading="lazy" src="${base_url}uploads/items/${response.data.photo}" alt="product">
                                </div>`;
                            }else{
                                img_list = `<div class="single_viewslider">
                                    <img loading="lazy" src="${base_url}uploads/site_settings/default-picture.png" alt="product">
                                </div>`;
                            }
                        }
                    }

                    // Update DOM with new images
                    $('.product_view_slider3').html(img_list);
                    
                    // Create navigation slider HTML using the same logic
                    let img_list2 = '';
                    if (response.data.type == 'Variation_Product') {
                        let product_image = response.data.photo ? 
                            `${base_url}uploads/items/${response.data.photo}` : 
                            `${base_url}uploads/site_settings/default-picture.png`;
                            
                        img_list2 = `<div class="single_viewslid_nav">
                            <img loading="lazy" src="${product_image}" alt="${response.data.name}">
                        </div>`;
                    } else {
                        if (response.product_image && response.product_image.length > 0) {
                            $.each(response.product_image, function (ind, val) {
                                img_list2 += `<div class="single_viewslid_nav">
                                    <img loading="lazy" src="${base_url}uploads/eCommerce/item_images/${val.image}" alt="product">
                                </div>`;
                            });
                        } else {

                            if(response.data.photo){
                                img_list2 = `<div class="single_viewslid_nav">
                                    <img loading="lazy" src="${base_url}uploads/items/${response.data.photo}" alt="product">
                                </div>`;
                            }else{
                                img_list2 = `<div class="single_viewslid_nav">
                                    <img loading="lazy" src="${base_url}uploads/site_settings/default-picture.png" alt="product">
                                </div>`;
                            }
                        }
                    }
                    $('.product_viewslid_nav3').html(img_list2);
                    
                    // single product view slider
                    $('.product_view_slider3').slick({
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        arrows: false,
                        fade: true,
                        asNavFor: '.product_viewslid_nav3',
                        infinite: false
                    });
                    // single product view slider nav
                    $('.product_viewslid_nav3').slick({
                        slidesToShow: 5,
                        slidesToScroll: 1,
                        prevArrow: '<button type="button" class="slick-prev"><i class="las la-angle-left"></i></button>',
                        nextArrow: '<button type="button" class="slick-next"><i class="las la-angle-right"></i></button>',
                        asNavFor: '.product_view_slider3',
                        focusOnSelect: true,
                        centerMode: false,
                        centerPadding: '0px',
                        infinite: false,
                        responsive: [{
                            breakpoint: 576,
                            settings: {
                                slidesToShow: 3,
                            }
                        }]
                    });





                    // Variation Product Show
                    
                    if(response.data.type == 'Variation_Product'){
                        $('#variation_show_parent').css('display', 'show');
                        let variation_html = '';
                        if(response.data.variations){
                            $.each(response.data.variations, function (ind, val) {
                                variation_html += `<div class="single_size_opt mt-2">
                                                    <input type="radio" hidden name="variation_items" class="size_inp" id="variation_items_${val.id}">
                                                    <label for="variation_items_${val.id}">${val.name}</label>
                                                </div>`;
                            });
                            $('#variation_show').html(variation_html);
                        }else{
                            $('#variation_show').html('No Record Exist');
                        }
                    }else{
                        $('#variation_show_parent').css('display', 'none');
                    }
                    
                }
            }
        });
    });

    // search suggest
    $('#show_suggest, #show_suggest_2').on('focus', function(){
        $(this.id === 'show_suggest' ? '.search_suggest' : '.search_result_product').addClass('active');
    });


    // Search Option
    let search_option = $('#produt_search_option').val();
    $('#show_suggest, #show_suggest_2').on('keyup', function(){
        let current_id = this.id;
        let search_value = $(this).val();
        if(search_value.length > 0) {
            $.ajax({
                type: "GET",
                url: base_url + "ECommerce_frontend/getProductSearch", 
                data: { search: search_value },
                dataType: 'json',
                success: function (response) {
                    if(response.status === 'success' && response.data) {
                        let search_html = '';
                        response.data.forEach(function(item){
                            let imageHtml = '';
                            if(search_option !== 'Product Name Only') {
                                let product_image = item.photo ? 
                                    base_url + 'uploads/items/' + item.photo : 
                                    base_url + 'uploads/site_settings/default-picture.png';
                                imageHtml = `<div class="sresult_img">
                                    <img loading="lazy" src="${product_image}" alt="${item.name}">
                                </div>`;
                            }
                            search_html += `<a href="${base_url}e-product-details/${item.id}" class="single_sresult_product">
                                ${imageHtml}
                                <div class="sresult_content">
                                    <h4>${item.name}</h4>
                                    <div class="price">
                                        <span class="org_price">${curreny} ${parseFloat(item.sale_price).toFixed(2)}</span>
                                    </div>
                                    <div class="d-flex">
                                        <span class="cat_brnd ${item.category_name == '' ? 'd-none' : ''}">Category: ${item.category_name}</span>
                                        <span class="cat_brnd ${item.brand_name == '' ? 'd-none' : ''}">Brand: ${item.brand_name}</span>
                                    </div>
                                </div>
                            </a>`;
                        });
                        if(current_id == 'show_suggest'){
                            $('.search_result_product').html(search_html);
                        }else{
                            $('.search_result_product_2').html(search_html);
                        }
                    } else {
                        if(current_id == 'show_suggest'){
                            $('.search_result_product').html('<div class="text-center p-3">No products found</div>');
                        }else{
                            $('.search_result_product_2').html('<div class="text-center p-3">No products found</div>');
                        }
                    }
                },
                error: function() {
                    if(current_id == 'show_suggest'){
                        $('.search_result_product').html('<div class="text-center p-3">Error occurred while searching</div>');
                    }else{
                        $('.search_result_product_2').html('<div class="text-center p-3">Error occurred while searching</div>');
                    }
                }
            });
        } else {
            $('.search_result_product').empty();
        }
    });

    // Handle keyboard navigation for search results
    let currentFocus = -1;
    $(document).on('keydown', function(e) {
        const searchInput = $('#show_suggest');
        if (!searchInput.is(':focus')) return;
        const results = $('.single_sresult_product');
        const resultsLength = results.length;
        if (resultsLength > 0) {
            if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
                e.preventDefault();
                // Remove existing focus
                results.removeClass('search-item-focus');
                // Calculate new focus position
                if (e.key === 'ArrowDown') {
                    currentFocus++;
                    if (currentFocus >= resultsLength) currentFocus = 0;
                } else {
                    currentFocus--;
                    if (currentFocus < 0) currentFocus = resultsLength - 1;
                }
                // Add focus to new item
                const focusedItem = results.eq(currentFocus);
                focusedItem.addClass('search-item-focus');
                // Handle scrolling
                const container = $('.search_suggest');
                const containerTop = container.offset().top;
                const containerHeight = container.height();
                const itemTop = focusedItem.offset().top;
                const itemHeight = focusedItem.outerHeight();
                if (itemTop < containerTop) {
                    container.scrollTop(container.scrollTop() - (containerTop - itemTop));
                } else if ((itemTop + itemHeight) > (containerTop + containerHeight)) {
                    container.scrollTop(container.scrollTop() + ((itemTop + itemHeight) - (containerTop + containerHeight)));
                }
            } else if (e.key === 'Enter' && currentFocus > -1) {
                e.preventDefault();
                results.eq(currentFocus).get(0).click();
            }
        }
    });

    // Reset focus when input is focused
    $('#show_suggest').on('focus', function() {
        currentFocus = -1;
        $('.single_sresult_product').removeClass('search-item-focus');
    });

    // Handle mouse interactions
    $(document).on('mouseenter', '.single_sresult_product', function() {
        $('.single_sresult_product').removeClass('search-item-focus');
        $(this).addClass('search-item-focus');
        currentFocus = $('.single_sresult_product').index(this);
    });
    // Add hover effect for search results
    $(document).on('mouseenter', '.single_sresult_product', function() {
        $('.single_sresult_product').removeClass('search-item-focus');
        $(this).addClass('search-item-focus');
        currentFocus = $('.single_sresult_product').index(this);
    });
    // Prevent background from being removed
    $(document).on('mouseleave', '.single_sresult_product', function() {
        if(currentFocus === $('.single_sresult_product').index(this)) {
            $(this).addClass('search-item-focus');
        }
    });
    // Add this to handle blur and focus events
    $('#show_suggest').on('focus', function() {
        currentFocus = -1;
    });
    // Add CSS for visual feedback with transition
    $('<style>')
        .text(`
            .search-item-focus { 
                background-color: #f0f0f0 !important; 
                border-radius: 4px;
                transition: background-color 0.2s ease;
            }
            .single_sresult_product {
                transition: background-color 0.2s ease;
            }
        `)
        .appendTo('head');



    $(document).on('change', 'input[name="variation_items"]', function(){
        let variation_id = $(this).attr('id').replace('variation_items_', '');
        $('.add-to-cart1').attr('data-product-id', variation_id);
        $('.add-to-cart2').attr('data-product-id', variation_id);
        $.ajax({
            type: "POST", 
            url: base_url + "ECommerce_frontend/getProductStockCheck",
            data: {
                variation_id: variation_id
            },
            dataType: "json",
            success: function(response) {
                if(response.status == 'success') {
                    $('.modal_p_stock').val(response.data);
                    $('.modal_product_quantity').text('1');

                    $('.modal_product_org_price').text(`${curreny} ${parseFloat(response.p_info.sale_price).toFixed(precision)}`);
                    $('.product_base_info .org_price').text(`${curreny} ${parseFloat(response.p_info.sale_price).toFixed(precision)}`);

                    $('.add-to-cart1').attr('data-sp', response.p_info.sale_price);
                    $('.add-to-cart2').attr('data-sp', response.p_info.sale_price);

                    // Configure slick slider with product images
                    let sliderHtml = '';
                    let navHtml = '';

                    // Build main slider HTML
                    if (response.product_image && response.product_image.length > 0) {
                        response.product_image.forEach(item => {
                            sliderHtml += `<div class="single_viewslider">
                                <img loading="lazy" src="${base_url}uploads/eCommerce/item_images/${item.image}" alt="product">
                            </div>`;
                            navHtml += `<div class="single_viewslid_nav">
                                <img loading="lazy" src="${base_url}uploads/eCommerce/item_images/${item.image}" alt="product">
                            </div>`;
                        });
                    } else {
                        // Default image if no images exist
                        sliderHtml = `<div class="single_viewslider">
                            <img loading="lazy" src="${base_url}uploads/site_settings/default-picture.png" alt="product">
                        </div>`;
                        navHtml = `<div class="single_viewslid_nav">
                            <img loading="lazy" src="${base_url}uploads/site_settings/default-picture.png" alt="product">
                        </div>`;
                    }

                    if ($('.product_view_slider3').hasClass('slick-initialized')) {
                        $('.product_view_slider3').slick('unslick');
                    }
                    if ($('.product_viewslid_nav3').hasClass('slick-initialized')) {
                        $('.product_viewslid_nav3').slick('unslick');
                    }

                    // Update DOM with slider HTML
                    $('.product_view_slider3').html(sliderHtml);
                    $('.product_viewslid_nav3').html(navHtml);

                    $('.product_view_slider3').slick({
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        arrows: false,
                        fade: true,
                        asNavFor: '.product_viewslid_nav3',
                        infinite: false
                    });
                    // single product view slider nav
                    $('.product_viewslid_nav3').slick({
                        slidesToShow: 5,
                        slidesToScroll: 1,
                        prevArrow: '<button type="button" class="slick-prev"><i class="las la-angle-left"></i></button>',
                        nextArrow: '<button type="button" class="slick-next"><i class="las la-angle-right"></i></button>',
                        asNavFor: '.product_view_slider3',
                        focusOnSelect: true,
                        centerMode: false,
                        centerPadding: '0px',
                        infinite: false,
                        responsive: [{
                            breakpoint: 576,
                            settings: {
                                slidesToShow: 3,
                            }
                        }]
                    });

                    if ($('.product_view_slider2').hasClass('slick-initialized')) {
                        $('.product_view_slider2').slick('unslick');
                    }
                    if ($('.product_viewslid_nav2').hasClass('slick-initialized')) {
                        $('.product_viewslid_nav2').slick('unslick');
                    }

                    $('.product_view_slider2 ').html(sliderHtml);
                    $('.product_viewslid_nav2').html(navHtml);

                    $('.product_view_slider2').slick({
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        arrows: false,
                        fade: true,
                        asNavFor: '.product_viewslid_nav2',
                        infinite: false
                    });
                    // single product view slider nav
                    $('.product_viewslid_nav2').slick({
                        slidesToShow: 5,
                        slidesToScroll: 1,
                        prevArrow: '<button type="button" class="slick-prev"><i class="las la-angle-left"></i></button>',
                        nextArrow: '<button type="button" class="slick-next"><i class="las la-angle-right"></i></button>',
                        asNavFor: '.product_view_slider2',
                        focusOnSelect: true,
                        centerMode: false,
                        centerPadding: '0px',
                        infinite: false,
                        responsive: [{
                            breakpoint: 576,
                            settings: {
                                slidesToShow: 3,
                            }
                        }]
                    });


                    if(response.data > 0) {
                        $('.modal_product_stock').removeClass('text-danger')
                            .addClass('text-green')
                            .text('In Stock');
                        $('.stock_setter').removeClass('text-danger')
                            .addClass('text-green')
                            .text('In Stock');
                    } else {
                        $('.modal_product_stock').removeClass('text-green')
                            .addClass('text-danger')
                            .text('Stock Out');
                        $('.stock_setter').removeClass('text-green')
                            .addClass('text-danger')
                            .text('Stock Out');
                    }
                }
            }
        });
    });
    

    $(document).on('click', '.modal_product_quantity_increase', function(){

        let product_quantity = parseFloat($('.modal_product_quantity').text()) || 0;
        let available_stock = $('.modal_p_stock').val();
        if(available_stock > product_quantity){
            $('.modal_product_quantity').text(parseFloat(product_quantity) + 1);
        }else{
            toastr['error']('Stock is over', 'Error');
        }

    });
    $(document).on('click', '.modal_product_quantity_decrease', function(){
        let product_quantity = parseFloat($('.modal_product_quantity').text()) || 0;
        if(parseFloat(product_quantity) != 1){
            $('.modal_product_quantity').text(parseFloat(product_quantity) - 1);
        }
    });
    $(document).on('click', '.product_quantity_increase', function(){
        let product_quantity = parseFloat($('.product_quantity').text()) || 0;
        $('.product_quantity').text(parseFloat(product_quantity) + 1);
    });
    $(document).on('click', '.product_quantity_decrease', function(){
        let product_quantity = parseFloat($('.product_quantity').text()) || 0;
        if(parseFloat(product_quantity) != 1){
            $('.product_quantity').text(parseFloat(product_quantity) - 1);
        }
    });


    $(document).on('click', '.ey_ctrl', function () {
        let icon = $(this);
        let input = icon.closest('div').find('input');
        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            icon.removeClass('bi-eye-slash').addClass('bi-eye');
        } else {
            input.attr('type', 'password');
            icon.removeClass('bi-eye').addClass('bi-eye-slash');
        }
    });

    $(document).on('change', '#area_select', function () {
        let area_amt = $(this).find(":selected").attr('area-val');
        $('.delivery_charge').text(parseFloat(area_amt).toFixed(precision));
        shoppingCartCalculation();
    });

    
    

    $(document).on('click', '.add-to-cart, .add-to-cart1, .add-to-cart2', function(){
        let productType = $(this).attr('data-type');
        let productId = $(this).attr('data-product-id');
        let productSP = $(this).attr('data-sp');
        let quantity  = 1;
        let increase_decrease  = 'Increase';
        // Detect which button was clicked
        if($(this).hasClass('add-to-cart')){
            quantity  = 1;
        }else if($(this).hasClass('add-to-cart1')){
            quantity  = parseFloat($('.modal_product_quantity').text());
        }else if($(this).hasClass('add-to-cart2')){
            quantity  = parseFloat($('.product_quantity').text());
        }

        if($(this).hasClass('add-to-cart') && productType == 'Variation_Product'){
            $(this).closest('.common_cart_trigger').find('.open_quickview').click();
            return false;
        }

        $.ajax({
            url: base_url+'ECommerce_frontend/addToCart',
            type: 'POST',
            data: { 
                product_id: productId, 
                quantity: quantity, 
                productSP: productSP, 
                increase_decrease: increase_decrease,
            },
            dataType: 'json',
            success: function(response) {
                if(response.status === 'success') {
                    toastr['success'](response.message, 'Success');
                    cartDataShow()
                } else {
                    toastr['error'](response.message, 'Error');
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: " + status + error);
            }
        });
    });




    function cartDataShow(){
        $.ajax({
            url: base_url+'ECommerce_frontend/cartDataShow',
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                if(response.data == ''){
                    $('.cartsdrop_wrap').html(`<div class="text-muted text-center no_cart_data"> <i class="bi bi-cart-x"></i> <br> No Product in cart</div>`);
                    $('.shopcart .cart_droptitle').addClass('d-none');
                    $('.shopcart .total_cartdrop').addClass('d-none');
                    $('.shopcart .cartdrop_footer ').addClass('d-none');
                    $('.total_cart_item').html(0);
                }else{
                    
                    $('.cartsdrop_wrap').html(response.data);
                    $('.subtotal_show').html(response.subtotal);
                    $('.total_cart_item').html(response.total_item);
                    $('.shopcart .cart_droptitle').removeClass('d-none');
                    $('.shopcart .total_cartdrop').removeClass('d-none');
                    $('.shopcart .cartdrop_footer ').removeClass('d-none');
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: " + status + error);
            }
        });
    }
    cartDataShow()


    $(document).on('click', '.remove_cart', function () {
        let productId = $(this).attr('data-product-id');
        $.ajax({
            url: base_url+'ECommerce_frontend/removeFromCart',
            type: 'POST',
            data: { product_id: productId},
            dataType: 'json',
            success: function(response) {
                if(response.status === 'success') {
                    toastr['success'](response.message, 'Success');
                    cartDataShow()
                } else {
                    toastr['danger'](response.message, 'Error');
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: " + status + error);
            }
        });
    });


    $(document).on('click', '.cart_remove', function () {
        let productId = $(this).attr('data-product-id');
        $.ajax({
            url: base_url+'ECommerce_frontend/removeFromCart',
            type: 'POST',
            data: { product_id: productId},
            dataType: 'json',
            success: function(response) {
                if(response.status === 'success') {
                    toastr['success'](response.message, 'Success');
                    location.reload()
                    cartDataShow()
                } else {
                    toastr['danger'](response.message, 'Error');
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: " + status + error);
            }
        });
    });


    function shoppingCartCalculation(){
        let inline_price = 0;
        let inline_tax = 0;
        let inline_quantity = 0;
        let inline_subtotal = 0;
        let subtotal_tax = 0;
        let subtotal_sum = 0;
        let grand_total = 0;

        // Calculate for each cart item
        $('.common_calculation_cls').each(function(){
            // Parse values with error handling
            inline_price = parseFloat($(this).find('.price').attr('data-p').trim()) || 0;
            inline_tax = parseFloat($(this).find('.price').attr('data-next-v').trim()) || 0;
            inline_quantity = parseFloat($(this).find('.cart_count').text().trim()) || 0;
            // Calculate subtotals
            inline_subtotal = inline_price * inline_quantity;
            subtotal_tax += inline_tax * inline_quantity;
            subtotal_sum += inline_subtotal;

            // Update item subtotal display
            $(this).find('.cart_price p').text(inline_subtotal.toFixed(precision));
        });

        // Update cart totals
        $('.cart_sub_total').text(subtotal_sum.toFixed(precision));

        // Handle delivery charge with proper error checking
        let deliveryText = $('.delivery_charge').text().trim();
        let delivery_charge = isNaN(parseFloat(deliveryText)) ? 0 : 
                            parseFloat(deliveryText.replace(/[^0-9.-]/g, '')) || 0;

        // Calculate and display grand total
        grand_total = subtotal_sum + delivery_charge + subtotal_tax;
        
        $('.tax_amount').text(subtotal_tax.toFixed(precision));
        $('.grand_total').text(grand_total.toFixed(precision));
    }
    setTimeout(function(){
        shoppingCartCalculation();
    }, 200)

    $(document).on('click', '.cart_qnty_btn_minus', function(){
        // Real time updater
        let cartCount = $(this).parent().find('.cart_count');
        let quantity_1 = parseFloat(cartCount.text().trim().replace(/[^0-9.]/g, '')) || 0;
        if(parseFloat(quantity_1) == 1){
            toastr['error']('Minimum 1 Quantity required to be countinue', 'Error');
            return false;
        }else{
            $(this).parent().find('.cart_count').text(quantity_1 - 1);
            // Cart Updater
            let productId = $(this).attr('data-product-id');
            let productSP = $(this).attr('data-sp');
            let quantity  = 1;
            let increase_decrease  = 'Decrease';
            $.ajax({
                url: base_url+'ECommerce_frontend/addToCart',
                type: 'POST',
                data: { product_id: productId, quantity: quantity, productSP: productSP, increase_decrease: increase_decrease },
                dataType: 'json',
                success: function(response) {
                    if(response.status === 'success') {
                        cartDataShow()
                    } else {
                        toastr['danger'](response.message, 'Error');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: " + status + error);
                }
            });
            shoppingCartCalculation();
        }
    });

    $(document).on('click', '.cart_qnty_btn_plus', function(){
        // Real time updater
        let cartCount = $(this).parent().find('.cart_count');
        let quantity_1 = parseFloat(cartCount.text().trim().replace(/[^0-9.]/g, '')) || 0;
        $(this).parent().find('.cart_count').text(quantity_1 + 1);
        shoppingCartCalculation();
        // Cart Updater
        let productId = $(this).attr('data-product-id');
        let productSP = $(this).attr('data-sp');
        let quantity  = 1;
        let increase_decrease  = 'Increase';
        $.ajax({
            url: base_url+'ECommerce_frontend/addToCart',
            type: 'POST',
            data: { product_id: productId, quantity: quantity, productSP: productSP, increase_decrease: increase_decrease },
            dataType: 'json',
            success: function(response) {
                if(response.status === 'success') {
                    cartDataShow()
                } else {
                    toastr['danger'](response.message, 'Error');
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: " + status + error);
            }
        });
    });


    $(document).on('click', '.adto_wish, .adto_wish1, .adto_wish-quick', function(){
        let product_id = $(this).attr('data-pro-id');
        $.ajax({
            url: base_url+'ECommerce_frontend/addToWishlist',
            type: 'POST',
            data: { product_id: product_id },
            dataType: 'json',
            success: function(response) {
                if(response.status === 'login') {
                    window.location.href = base_url+response.message;
                } else if(response.status == 'success'){
                    toastr['success'](response.message, 'Success');
                    $('.wish_list_count').text('').text(response.wishlist_count);
                } else {
                    toastr['error'](response.message, 'Error');
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: " + status + error);
            }
        });
    });
    $(document).on('click', '.wishlist_remove', function(){
        let product_id = $(this).attr('data-product-id');
        $.ajax({
            url: base_url+'ECommerce_frontend/removeFromWishlist',
            type: 'POST',
            data: { product_id: product_id },
            dataType: 'json',
            success: function(response) {
                if(response.status == 'success'){
                    toastr['success'](response.message, 'Success');
                    location.reload();
                } else {
                    toastr['error'](response.message, 'Error');
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: " + status + error);
            }
        });
    });

    function stripePayment(info) {
        if (info.credit_card_no == "") {
            toastr["error"]("Credit Card No Required", "");
            return false;
        }
        if (info.holder_name == "") {
            toastr["error"]("Card Holder Name Required", "");
            return false;
        }
        if (info.payment_month == "") {
            toastr["error"]("Payment Month Required", "");
            return false;
        }
        if (info.payment_year == "") {
            toastr["error"]("Payment Year Required", "");
            return false;
        }
        if (info.payment_cvc == "") {
            toastr["error"]("Payment CVV Required", "");
            return false;
        }
        let stripe_publish_key = $('#stripe_publish_key').val();
        Stripe.setPublishableKey(stripe_publish_key);
        Stripe.createToken({
            number: info.credit_card_no,
            cvc: info.payment_cvc,
            exp_month: info.payment_month,
            exp_year: info.payment_year,
        },
            stripeResponseHandler
        );
    }

    function stripeResponseHandler(status, response) {
        if (response.error) {
            toastr["error"](response.error.message, "");
        } else {
            toastr["warning"]("Please wait untill getting response, Don't click anywhere", "Warning");
            $('.close_quickview1').css('display', 'none');
            $('#online_payment').prop('disabled', true);
            /* token contains id, last4, and card type */
            let token = response["id"];
            let amount = parseFloat($("#finalize_total_due").text());
            $.ajax({
                url: base_url + "ECommerce_frontend/stripePayment",
                method: "POST",
                data: {
                    token: token,
                    amount: amount,
                },
                success: function (response) {
                    let data = JSON.parse(response);
                    if (data.status == "error") {
                        toastr["error"]("Amount Must be grater than 0", "");
                        stripePayementStatus = false;
                    }
                    if (data.paid == true) {
                        stripePayementStatus = true;
                        toastr["success"]("Payment Successfully", "");
                        $('.payment_process').attr('value', '200');
                        addPaymentCashToPaid('stripe');
                        $('.close_quickview1').css('display', 'block');
                        $('.close_quickview1').click();
                        $('#online_payment').prop('disabled', false);
                        $('#place_order').click();
                    } else {
                        toastr["error"]("Something Went Wrong! Please try again", "");
                        stripePayementStatus = false;
                    }
                },
            });
        }
    }


    function paypalPayment(info) {
        if (info.credit_card_no == "") {
            toastr["error"]("Credit Card No Required", "");
            return false;
        }
        if (info.holder_name == "") {
            toastr["error"]("Card Holder Name Required", "");
            return false;
        }
        if (info.payment_month == "") {
            toastr["error"]("Payment Month Required", "");
            return false;
        }
        if (info.payment_year == "") {
            toastr["error"]("Payment Year Required", "");
            return false;
        }
        if (info.payment_cvc == "") {
            toastr["error"]("Payment CVV Required", "");
            return false;
        }
        let amount = Number($("#finalize_total_due").text());
        $.ajax({
            url: base_url + "ECommerce_frontend/paypalPayment",
            method: "POST",
            data: {
                info : info,
                amount: amount,
            },
            success: function (response) {
                let data = JSON.parse(response);
                if (data.status == "error" && data.code == 701) {
                    toastr["error"]("Amount Must be grater than 0", "");
                    paypalPayementStatus = false;
                }
                if (data.code == 200) {
                    paypalPayementStatus = true;
                    toastr["success"]("Payment Successfully", "");
                    addPaymentCashToPaid('paypal');
                } else {
                    toastr["error"]("Something Went Wrong! Maybe Wrong Credentials!", "");
                    paypalPayementStatus = false;
                }
            },
        });
    }

    // Stripe Payment
    function addPaymentCashToPaid(type) {
        if (type == "stripe" && stripePayementStatus == true) {
            $("#finalize_amount_input").val($("#finalize_total_due").text());
            $("#add_payment").click();
            $('#finalize_order_button').click();
        } else if (type == "paypal" && paypalPayementStatus == true) {
            $("#finalize_amount_input").val($("#finalize_total_due").text());
            $("#add_payment").click();
            $('#finalize_order_button').click();
        } else {
            toastr["error"]("Pay first. Your Payment Not Complete!", "");
        }
    }


    $(document).on("click", "#online_payment", function () {
        // Card Payment info
        let credit_card_no = $("#credit_card_no").val();
        let holder_name = $("#holder_name").val();
        let payment_month = $("#payment_month").val();
        let payment_year = $("#payment_year").val();
        let payment_cvc = $("#payment_cvc").val();
        // Get payment method value when radio button changes
        let account_type = $('input[name="payment_method"]:checked').val();

        // Stripe
        if (account_type == 'stripe') {
            stripePayment({
                credit_card_no: credit_card_no,
                holder_name: holder_name,
                payment_month: payment_month,
                payment_year: payment_year,
                payment_cvc: payment_cvc,
            });
        }

        if (account_type == 'paypal') {
            paypalPayment({
                credit_card_no: credit_card_no,
                holder_name: holder_name,
                payment_month: payment_month,
                payment_year: payment_year,
                payment_cvc: payment_cvc,
            });
        }
    });

    // Stripe Payment
    function addPaymentCashToPaid(type) {
        if (type == "stripe" && stripePayementStatus == true) {
            $("#finalize_amount_input").val($("#finalize_total_due").text());
            $("#add_payment").click();
            $('#finalize_order_button').click();
        } else if (type == "paypal" && paypalPayementStatus == true) {
            $("#finalize_amount_input").val($("#finalize_total_due").text());
            $("#add_payment").click();
            $('#finalize_order_button').click();
        } else {
            toastr["error"]("Pay first. Your Payment Not Complete!", "");
        }
    }

    function paypalPayment(info) {
        if (info.credit_card_no == "") {
            toastr["error"]("Credit Card No Required", "");
            return false;
        }
        if (info.holder_name == "") {
            toastr["error"]("Card Holder Name Required", "");
            return false;
        }
        if (info.payment_month == "") {
            toastr["error"]("Payment Month Required", "");
            return false;
        }
        if (info.payment_year == "") {
            toastr["error"]("Payment Year Required", "");
            return false;
        }
        if (info.payment_cvc == "") {
            toastr["error"]("Payment CVV Required", "");
            return false;
        }
        let amount = Number($("#finalize_total_due").text());
        $.ajax({
            url: base_url + "Sale/paypalPayment",
            method: "POST",
            data: {
                info : info,
                amount: amount,
            },
            success: function (response) {
                let data = JSON.parse(response);
                if (data.status == "error" && data.code == 701) {
                    toastr["error"]("Amount Must be grater than 0", "");
                    paypalPayementStatus = false;
                }
                if (data.code == 200) {
                    paypalPayementStatus = true;
                    toastr["success"]("Payment Successfully", "");
                    addPaymentCashToPaid('paypal');
                } else {
                    toastr["error"]("Something Went Wrong! Maybe Wrong Credentials!", "");
                    paypalPayementStatus = false;
                }
            },
        });
    }


    $(document).on("click", "#place_order", function () {
        let account_type = $('input[name="payment_method"]:checked').val();
        let area_select = $('#area_select').val();
        let delivary_partner = $('#delivary_partner').val();
        let payment_process = $('.payment_process').val();
        let grand_total = parseFloat($('.grand_total').text() || 0);
        let error = false;
        if((account_type == 'stripe' || account_type == 'paypal') && payment_process == '400'){
            toastr['error']('Complete your payment', 'Error');
            error = true;
        }
        if(delivary_partner == ''){
            toastr['error']('Delivary Partner field is required', 'Error');
            error = true;
        }
        if(grand_total == 0){
            toastr['error']('Grand total is Zero', 'Error');
            error = true;
        }
        if(error == true){
            return false;
        }else{
            $.ajax({
                type: "POST",
                url: base_url+"ECommerce_frontend/placeOrder",
                data: {
                    account_type: account_type,
                    area_select: area_select,
                    delivary_partner: delivary_partner,
                },
                dataType: "json",
                success: function (response) {
                    if(response.status == 'success'){
                        toastr['success'](response.message, 'Success');
                        window.location.href = base_url+'e-account';
                    }else{
                        toastr['error'](response.message, 'Error');
                    } 
                }
            });
        }
    });

    
    $(".rating_star span").on("mouseenter", function () {
        let rating = $(this).data("ratting");
        $(this).parent().children("span").each(function () {
            $(this).find("i").removeClass("bi-star bi-star-fill");
            if ($(this).data("ratting") <= rating) {
                $(this).find("i").addClass("bi-star-fill");
            } else {
                $(this).find("i").addClass("bi-star");
            }
        });
    });
    
    $(".rating_star span").on("mouseleave", function () {
        $(this).parent().children("span").each(function () {
            let isCurrent = $(this).find("i").hasClass("current-r");
            $(this).find("i").removeClass("bi-star bi-star-fill");
            if (isCurrent) {
                $(this).find("i").addClass("bi-star-fill");
            } else {
                $(this).find("i").addClass("bi-star");
            }
        });
    });

    $(".rating_star span").on("click", function () {
        let productId = $(this).data("product-id");
        let rating = $(this).data("ratting");
        let parentDiv = $(this).parent();
        parentDiv.attr("data-selected-rating", rating);
        $.ajax({
            url: base_url+"e-ratting-submit",
            type: "POST",
            data: { item_id: productId, rating: rating },
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    toastr['success']('Thank you for your rating!', 'Success');
                } else {
                    parentDiv.find('i').removeClass('bi-star-fill').addClass('bi-star');
                    toastr['error'](response.message, 'Error');
                }
            }
        });
    });


    $(document).on('change', '.payment_method', function(e){
        let payment_method = $(this).val();
        if(payment_method == 'paypal' || payment_method == 'stripe'){
            $('#payment_method_modal').addClass('active');
            $('body').css('overflow-y', 'hidden')
        }
    });

    //placeholder customization
    let search_here_ecommerce_txt = $("#search_here_ecommerce_txt").val();
    superplaceholder({
        el: show_suggest,
        sentences: [search_here_ecommerce_txt],
        options: {
            loop: true,
            startOnFocus: false
        }
    })


});