$(function () {
    "use strict";
    let base_url = $('#base_url_').val();

    $(document).on('keyup', '#imei_serial', function () {
        let imei_serial_no = $(this).val().trim(); // Ensure no extra spaces
        let resultsContainer = $('.search-results'); // Reference the results container
    
        if (imei_serial_no.length === 0) {
            resultsContainer.html('').hide(); // Clear and hide results if input is empty
            return;
        }
    
        $.ajax({
            type: "POST",
            url: base_url + "WarrantyProducts/searchWarrantyProducts",
            data: {
                imei_serial_no: imei_serial_no,
            },
            dataType: "json",
            success: function (response) {
                if (response.status === 'success') {
                    let imeiHtml = '';
                    if (response.data && response.data.length > 0) {
                        $.each(response.data, function (i, v) {
                            imeiHtml += `<li class="single_item" data-item-name="${$.trim(v.item_name)}"
                             data-item-code="${$.trim(v.item_code)}" 
                             data-expiry_imei_serial="${$.trim(v.expiry_imei_serial)}" 
                             data-customer-id="${$.trim(v.customer_id)}"
                            ><small class="font-s-12">Product: ${$.trim(v.item_name)} (${$.trim(v.item_code)}) - ${$.trim(v.expiry_imei_serial)}</small><br>
                            <small class="font-s-12">Customer: ${v.customer_name} ${v.customer_phone ? '(' + v.customer_phone + ')' : ''}</small><br>
                            <small class="font-s-12">Sale: ${v.sale_no} - ${v.date_time}</small>
                            </li>`;
                        });
                    } else {
                        imeiHtml = `<li>No results found</li>`;
                    }
                    resultsContainer.html(imeiHtml).show(); // Populate and show results
                } else {
                    console.error("Error fetching data:", response.message || "Unknown error");
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX error:", status, error);
            }
        });
    });


    $(document).on('click', '.single_item', function () {
        let item_name = $(this).attr('data-item-name');
        let expiry_imei_serial = $(this).attr('data-expiry_imei_serial');
        let customer_id = $(this).attr('data-customer-id');
        $('.product_name').val(item_name);
        $('.product_serial_no').val(expiry_imei_serial);
        $('#customer_id').val(customer_id).trigger('change');
        $('#imei_serial').val('');
        $('.search-results').html('');
        $('.search-results').hide();
    });



    $(document).on('keyup', '#imei_serial_search', function () {
        let imei_serial_no = $(this).val().trim(); // Ensure no extra spaces
        let resultsContainer = $('.search-results'); // Reference the results container
    
        if (imei_serial_no.length === 0) {
            resultsContainer.html('').hide(); // Clear and hide results if input is empty
            return;
        }
    
        $.ajax({
            type: "POST",
            url: base_url + "WarrantyProducts/searchWarrantyProducts",
            data: {
                imei_serial_no: imei_serial_no,
            },
            dataType: "json",
            success: function (response) {
                if (response.status === 'success') {
                    let imeiHtml = '';
                    if (response.data && response.data.length > 0) {
                        $.each(response.data, function (i, v) {
                            imeiHtml += `<li data-item-name="${$.trim(v.item_name)}"
                             data-item-code="${$.trim(v.item_code)}" 
                             data-expiry_imei_serial="${$.trim(v.expiry_imei_serial)}" 
                             data-customer-id="${$.trim(v.customer_id)}"
                            ><small class="font-s-12">Product: ${$.trim(v.item_name)} (${$.trim(v.item_code)}) - ${$.trim(v.expiry_imei_serial)}</small><br>
                            <small class="font-s-12">Customer: ${v.customer_name} ${v.customer_phone ? '(' + v.customer_phone + ')' : ''}</small><br>
                            <small class="font-s-12">Sale: ${v.sale_no} - ${v.date_time}</small>
                            <div>
                                <button ${v.activate_warranty == 'Yes' ? 'disabled' : ''} type="button" class="btn small_btn bg-blue-btn warranty_active_btn">${v.activate_warranty == 'Yes' ? 'Warranty Activated' : 'Activate Warranty'}</button> 
                                <button ${v.activate_warranty == 'Yes' ? '' : 'disabled'} type="button" class="btn small_btn bg-red-btn delete-color warranty_deactive_btn mt-1">Deactive Warranty</button>
                                </div>
                            </li>`;
                        });
                    } else {
                        imeiHtml = `<li>No results found</li>`;
                    }
                    resultsContainer.html(imeiHtml).show(); // Populate and show results
                } else {
                    console.error("Error fetching data:", response.message || "Unknown error");
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX error:", status, error);
            }
        });
    });

    $(document).on('click', '.warranty_active_btn', function () {
        let imei_serial_no = $(this).parent().parent().attr('data-expiry_imei_serial').trim(); // Ensure no extra spaces
        $.ajax({
            type: "POST",
            url: base_url + "WarrantyProducts/warrantyProductActive",
            data: {
                imei_serial_no: imei_serial_no,
            },
            dataType: "json",
            success: function (response) {
                if (response.status === 'success') {
                    $('.warranty_active_btn').attr('disabled', true);
                    $('.warranty_deactive_btn').attr('disabled', false);
                    $('.warranty_active_btn').text('Warranty Activated');
                    toastr['success']('Warranty Activated.', 'Success');                    
                }
            }
        });
    });
    $(document).on('click', '.warranty_deactive_btn', function () {
        let imei_serial_no = $(this).parent().parent().attr('data-expiry_imei_serial').trim(); // Ensure no extra spaces
        $.ajax({
            type: "POST",
            url: base_url + "WarrantyProducts/warrantyProductActive",
            data: {
                imei_serial_no: imei_serial_no,
            },
            dataType: "json",
            success: function (response) {
                if (response.status === 'success') {
                    $('.warranty_active_btn').attr('disabled', false);
                    $('.warranty_deactive_btn').attr('disabled', true);
                    $('.warranty_active_btn').text('Activate Warranty');
                    toastr['success']('Warranty Deactivated.', 'Success');                    
                }
            }
        });
    });
    
    
})