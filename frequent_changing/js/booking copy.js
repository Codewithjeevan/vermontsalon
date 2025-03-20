document.addEventListener('DOMContentLoaded', function() {
    
    flatpickr('.customDateTimePicker', {
        enableTime: true,
        dateFormat: 'Y-m-d H:i',
        time_24hr: true
    });

    // Calender Call
    let base_url = $("#base_url").val();
    let calendarEl = document.getElementById('calendar');
    let calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: function(fetchInfo, successCallback, failureCallback) {
            // Fetch events from the server
            $.ajax({
                url: base_url+'Booking/bookingData',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        successCallback(response.message); // Pass the events array
                    } else {
                        failureCallback();
                    }
                },
                error: function() {
                    failureCallback();
                }
            });
        }
    });
    calendar.render();


    // Booking Modal Call
    jQuery(document).on('click', '#add_booking_triger', function(){
        jQuery('#add_booking').modal('show');
        jQuery('#booking_edit_hidden_id').val('');
        jQuery('#add_booking .modal-title').text('Add Booking');
        // clearBookingModal();
    });
    // Booking Modal Call
    jQuery(document).on('click', '.edit_booking', function(){
        jQuery('#add_booking').modal('show');
        jQuery('#add_booking .modal-title').text('Edit Booking');
        let book_id = $(this).attr('data-id');
        jQuery('#booking_edit_hidden_id').val(book_id);
        $.ajax({
            url: base_url + "Booking/editBooking",
            method: "POST",
            data: {
                book_id: book_id,
            },
            success: function (response) {
                if(response.status == 'success'){
                    jQuery("#customer_id").val(response.data.customer_id).trigger("change");
                    jQuery("#service_seller_id").val(response.data.service_seller_id).trigger("change");
                    jQuery("#outlet_id").val(response.data.outlet_id).trigger("change");
                    jQuery("#start_date").val(response.data.start_date);
                    jQuery("#end_date").val(response.data.end_date);
                    jQuery("#note").val(response.data.note);
                    $('.select2').select2();
                }else if(response.status == 'error'){
                    toastr['error'](response.data, 'Error');
                }
            }
        });
    });

    // Booking Modal Call
    jQuery(document).on('click', '.delete_booking', function(){
        let book_id = $(this).attr('data-id');
        Swal.fire({
            title: 'Alert!',
            text: 'Are you sure you want to delete this booking?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: 'Yes',
            denyButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: base_url + "Booking/deleteBooking",
                    method: "POST",
                    data: {
                        book_id: book_id,
                    },
                    success: function (response) {
                        if(response.status == 'success'){
                            toastr['success'](response.data, 'Success');
                            getAllBooking();
                        }
                    }
                });
            }
        });
    });


    jQuery(document).on('click', '.add_booking_submit', function(){
        let outlet_id = jQuery('#outlet_id').val();
        let customer_id = jQuery('#customer_id').val();
        let service_seller_id = jQuery('#service_seller_id').val();
        let start_date = jQuery('#start_date').val();
        let end_date = jQuery('#end_date').val();
        let note = jQuery('#note').val();
        let edit_booking_id = jQuery('#booking_edit_hidden_id').val();

        $.ajax({
            url: base_url + "Booking/addBooking",
            method: "POST",
            data: {
                outlet_id: outlet_id,
                customer_id: customer_id,
                service_seller_id: service_seller_id,
                start_date: start_date,
                end_date: end_date,
                note: note,
                edit_booking_id: edit_booking_id,
            },
            success: function (response) {
                if(response.status == 'success'){
                    jQuery('#add_booking').modal('hide');
                    getAllBooking();
                    clearBookingModal();
                    toastr['success']('Booking added successfully', 'Success');
                }else if(response.status == 'error'){
                    $.each(response.errors, function (ind, val) { 
                        if(ind == 'outlet_id' && val != ''){
                            jQuery("#outlet_id_err_msg").html(`${val}`);
                            jQuery(".outlet_id_err_msg_contnr").show(200).delay(6000).hide(200, function () {});
                        }else if(ind == 'customer_id' && val != ''){
                            jQuery("#customer_id_err_msg").html(`${val}`);
                            jQuery(".customer_id_err_msg_contnr").show(200).delay(6000).hide(200, function () {});
                        }else if(ind == 'service_seller_id' && val != ''){
                            jQuery("#service_seller_id_err_msg").html(`${val}`);
                            jQuery(".service_seller_id_err_msg_contnr").show(200).delay(6000).hide(200, function () {});
                        }else if(ind == 'start_date' && val != ''){
                            jQuery("#start_date_err_msg").html(`${val}`);
                            jQuery(".start_date_err_msg_contnr").show(200).delay(6000).hide(200, function () {});
                        }else if(ind == 'end_date' && val != ''){
                            jQuery("#end_date_err_msg").html(`${val}`);
                            jQuery(".end_date_err_msg_contnr").show(200).delay(6000).hide(200, function () {});
                        }else if(ind == 'note' && val != ''){
                            jQuery("#note_err_msg").html(`${val}`);
                            jQuery(".note_err_msg_contnr").show(200).delay(6000).hide(200, function () {});
                        }
                    });
                }
            }
        });
    });

    function clearBookingModal(){
        jQuery('#outlet_id').val('').trigger("change");
        jQuery('#customer_id').val('').trigger("change");
        jQuery('#service_seller_id').val('').trigger("change");
        jQuery('#start_date').val('');
        jQuery('#end_date').val('');
        jQuery('#note').val('');
        $('.select2').select2();
    }


    function getAllBooking(){
        // $.ajax({
        //     type: "GET",
        //     url: base_url+'Booking/getAllBooking',
        //     dataType: "json",
        //     success: function (response) {
        //         $(".html_content").html(response);
        //         $('#datatable').DataTable().destroy();
        //         $('#datatable').DataTable({
        //             'autoWidth': false,
        //             'ordering': false,
        //             'paging': true, 
        //             'language': {
        //                 'paginate': {
        //                     'next': 'Next',
        //                     'previous': 'Previous'
        //                 }
        //             }
        //         }); 
        //     }
        // });

        $.ajax({
            type: "GET",
            url: base_url + 'Booking/getAllBooking',
            dataType: "json", 
            success: function (response) {
                jQuery(".html_content").html(response); 
                jQuery('#datatable').DataTable({
                    'autoWidth': false,
                    'ordering': false,
                    'paging': true, 
                    'language': {
                        'paginate': {
                            'next': 'Next', 
                            'previous': 'Previous'
                        }
                    }
                });
            }
        });



        initTooltips();
  function initTooltips() {
    $('[data-toggle="tooltip"]').tooltip();
  }

    //get data using ajax datatable
    $("#datatable").DataTable({
        processing: true,
        serverSide: true,
        ordering: true,
        paging: true,
        
        ajax: {
            url: base_url + "Booking/getAllBooking",
            type: "POST",
            dataType: "json",
            data: {
                category_id: category_id,
                supplier_id: supplier_id,
                get_csrf_token_name: get_csrf_hash,
            },
        },
            columnDefs: [
                { orderable: true, targets: [ 4, 6, 7 ] }
            ],
            
            dom: '<"top-left-item col-sm-12 col-md-6"lf> <"top-right-item col-sm-12 col-md-6"B> t <"bottom-left-item col-sm-12 col-md-6 "i><"bottom-right-item col-sm-12 col-md-6 "p>',
            
            buttons: APPLICATION_DEMO_TYPE != 'Pharmacy'  ? [{
                extend: "print",
                text: '<span style="display: flex; align-items-center; gap: 8px;"><iconify-icon icon="solar:printer-broken" width="16"></iconify-icon> '+print_db+'</span>',
                titleAttr: "print",
            },
            {
                extend: "copyHtml5",
                text: '<span style="display: flex; align-items-center; gap: 8px;"><iconify-icon icon="solar:copy-broken" width="16"></iconify-icon> '+copy_db+'</span>',
                titleAttr: "Copy",
            },
            {
                extend: "excelHtml5",
                text: '<span style="display: flex; align-items-center; gap: 8px;"><iconify-icon icon="icon-park-solid:excel" width="16"></iconify-icon> '+excel_db+'</span>',
                titleAttr: "Excel",
            },
            {
                extend: "csvHtml5",
                text: '<span style="display: flex; align-items-center; gap: 8px;"><iconify-icon icon="teenyicons:csv-outline" width="16"></iconify-icon> '+csv_db+'</span>',
                titleAttr: "CSV",
            },
            {
                extend: "pdfHtml5",
                text: '<span style="display: flex; align-items-center; gap: 8px;"><iconify-icon icon="teenyicons:pdf-outline" width="16"></iconify-icon> '+pdf_db+'</span>',
                titleAttr: "PDF",
            }
            ] : [],

            language: {
                paginate: {
                    previous: "Previous",
                    next: "Next",
                }
            },
            // Use drawCallback to initialize tooltips after each draw
            // Use initComplete to initialize tooltips after DataTable initialization is complete
            initComplete: function() {
            $('#datatable [data-bs-toggle="tooltip"]').tooltip();
            $('.select2').select2();
            },

        });




    }
    // getAllBooking();


    
});