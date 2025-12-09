
let stripePayementStatus = false;
let paypalPayementStatus = false;
let no_permission_for_this_module = $('#no_permission_for_this_module').val();
let pharmacy_search_place_holder_pos = $('#pharmacy_search_place_holder_pos').val();
let other_search_place_holder_pos = $('#other_search_place_holder_pos').val();
let The = $('#The').val();
let field_is_required = $('#field_is_required').val();
let The_discount_code_field_required = $('#The_discount_code_field_required').val();
let The_coupon_code_field_required = $('#The_coupon_code_field_required').val();
let print_format = $('#print_format').val();
let invoice_print = $('#invoice_print').val();
let Place_Order = $("#Place_Order").val();
let direct_cart = $("#direct_cart").val();
let base_url = $('#base_url').val();
let warning = $('#alert').val();
let phone_ln = $('#phone_ln').val();
let email_ln = $('#email_ln').val();
let ok = $('#ok').val();
let yes = $('#yes').val();
let cancel = $('#cancel').val();
let sure_delete_this_sale = $('#sure_delete_this_sale').val();
let no_access = $('#no_access').val();
let default_cursor_position = $('#default_cursor_position').val();
let please_select_an_order = $('#please_select_an_order').val();
let please_select_hold_sale = $('#please_select_hold_sale').val();
let sure_delete_this_hold = $('#sure_delete_this_hold').val();
let are_you_delete_all_hold_sale = $('#are_you_delete_all_hold_sale').val();
let no_hold = $('#no_hold').val();
let select_a_customer = $('#select_a_customer').val();
let edit_warning = $('#edit_warning').val();
let collect_tax = $('#collect_tax').val();
let collect_gst = $('#tax_is_gst').val();
let gst_state_code = $('#gst_state_code').val();
let csrf_value_ = $("#csrf_value_").val();
let op_precision = $("#op_precision").val();
let op_decimals_separator = $("#op_decimals_separator").val();
let op_thousands_separator = $("#op_thousands_separator").val();
let allow_less_sale = $("#allow_less_sale").val();
let check_issue_date_lan = $("#check_issue_date_lan").val();
let check_no_lan = $("#check_no_lan").val();
let check_expiry_date_lan = $("#check_expiry_date_lan").val();
let mobile_no_lan = $("#mobile_no_lan").val();
let transaction_no_lan = $("#transaction_no_lan").val();
let card_holder_name_lan = $("#card_holder_name_lan").val();
let card_holding_number_lan = $("#card_holding_number_lan").val();
let paypal_email_lan = $("#paypal_email_lan").val();
let stripe_email_lan = $("#stripe_email_lan").val();
let note_lan = $("#note_lan").val();
let cart_empty = $("#cart_empty").val();
let sms_enable_status = $("#sms_enable_status").val();
let smtp_enable_status = $("#smtp_enable_status").val();
let send_invoice_whatsapp = $("#send_invoice_whatsapp").val();
let product_display = $("#product_display").val();
let dummy_data_delete_alert = $("#dummy_data_delete_alert").val();
let select = $("#select").val();
let customer = $("#customer").val();
let edit_mode = $("#old_sale_id").val();
let session_uer_id = $("#session_uer_id").val();
let role = $("#role").val();
let grocery_experience = $("#grocery_experience").val();
let view_purchase_price = $("#view_purchase_price").val();
let Alternative_Medicine_will_shown_here = $("#Alternative_Medicine_will_shown_here").val();
let already_added = $("#already_added").val();
let default_customer = $("#default_customer").val();
let edit_sale_customer = Number($("#edit_sale_customer").val());
let invoice_logo_session = $("#invoice_logo_session").val();
let business_name = $("#business_name").val();
let outlet_address = $("#outlet_address").val();
let outlet_name = $("#outlet_name").val();
let outlet_id = $("#outlet_id").val();
let outlet_email = $("#outlet_email").val();
let outlet_phone = $("#outlet_phone").val();
let tax_title = $("#tax_title").val();
let tax_registration_no = $("#tax_registration_no").val();
let invoice_ln = $("#invoice_ln").val();
let bill_to_ln = $("#bill_to_ln").val();
let invoice_no_ln = $("#invoice_no_ln").val();
let date_ln = $("#date_ln").val();
let op_date_format = $("#op_date_format").val();
let item_ln = $("#item_ln").val();
let code_ln = $("#code_ln").val();
let brand_ln = $("#brand_ln").val();
let sn_ln = $("#sn_ln").val();
let unit_price_ln = $("#unit_price_ln").val();
let qty_ln = $("#qty_ln").val();
let discount_ln = $("#discount_ln").val();
let total_ln = $("#total_ln").val();
let term_conditions = $("#term_conditions").html();
let invoice_footer = $("#invoice_footer").text();
let given_amount_ln = $("#given_amount_ln").val();
let change_amount_ln = $("#change_amount_ln").val();
let payment_method_ln = $("#payment_method_ln").val();
let due_amount_ln = $("#due_amount_ln").val();
let paid_amount_ln = $("#paid_amount_ln").val();
let total_payable_ln = $("#total_payable_ln").val();
let charge_ln = $("#charge_ln").val();
let letter_head_gap = $("#letter_head_gap").val();
let letter_footer_gap = $("#letter_footer_gap").val();
let tax_ln = $("#tax_ln").val();
let sub_total_ln = $("#sub_total_ln").val();
let authorized_signature_ln = $("#authorized_signature_ln").val();
let challan_ln = $("#challan_ln").val();


function getAllCustomers($sel, customer_id = '', if_ignore = false) {
    return $.ajax({
        url: base_url + "Sale/getCustomersAjax",
        method: "GET",
        data: { search: '', page: 1 }
    })
        .done(function (response) {
            if (customer_id) {
                const cust = response.data.find(c => c.id == customer_id);
                if (cust) {
                    const option = new Option(
                        `${cust.name}${cust.phone ? ' (' + cust.phone + ')' : ''}${cust.customer_price ? ' (' + cust.customer_price + ')' : ''}`,
                        cust.id,
                        true,  // selected
                        true   // defaultSelected
                    );
                    $sel.append(option).trigger('change');
                }
            }
        })
        .always(function () {
            $('.loader1').slideUp(500);
        });
}

$(document).ready(function () {
    $('.customer_data').each(function () {
        const $this = $(this);
        $this.select2({
            ajax: {
                url: base_url + "Sale/getCustomersAjax",
                dataType: 'json',
                delay: 250,
                data: params => ({
                    search: params.term || '',
                    page: params.page || 1
                }),
                processResults: (data, params) => {
                    params.page = params.page || 1;
                    return {
                        results: data.data.map(v => ({
                            id: v.id,
                            text: `${v.name}${v.phone ? ' (' + v.phone + ')' : ''}${v.customer_price ? ' (' + v.customer_price + ')' : ''}`,
                            ...v
                        })),
                        pagination: { more: data.more }
                    };
                },
                cache: true
            },
            placeholder: "Select customer",
            minimumInputLength: 0
        });

        // blank-search trigger on open
        $this.on('select2:open', () => {
            const $search = $('.select2-container--open .select2-search__field');
            if (!$search.val()) $search.trigger('input');
        });
    });
});


$(document).ready(function () {
    const $first = $('#walk_in_customer');
    getAllCustomers($first, '10', true);
});


$(document).on('change', '.package_data', function () {
    let session_count = $('option:selected', this).data('session');
    let emp_clone = $('#employee_id').prop('outerHTML');
    let price = $('option:selected', this).data('price');
    let session_price = parseFloat(price) / parseFloat(session_count);
    $('#total').val(price.toFixed(2));
    $('#session_count').val(session_count);
    let allRows = "";

    for (let i = 1; i <= session_count; i++) {
        allRows += `<tr>
                        <td>
                        <input type="text" name="session_name[]" class="form-control" value="Session ${i}" readonly>
                        <input type="hidden" name="session_id[]" value="${i}">
                        </td>
                        <td><input type="text" name="session_price[]" class="form-control" value="${session_price.toFixed(2)}" readonly></td>
                        <td>${emp_clone}</td>
                        <td><input type="datetime-local" name="in_time[]" class="form-control"></td>
                        <td><input type="datetime-local" name="out_time[]" class="form-control"></td>
                        <td>
                            <select name="status[]" class="form-select" style="height: 45px;">
                                <option value="0">Available</option>
                                <option value="1">Used</option>
                            </select>
                        </td>
                    </tr>`;
    }

    $('#session_table tbody').html(allRows);


});


function printInvoice(sale_id) {
    var print_format = $('#print_format').val();
    if (invoice_print == "live_server_print") {
        $.ajax({
            url: base_url + "Authentication/callPrintServer",
            method: "post",
            dataType: "json",
            data: {
                sale_id: sale_id,
            },
            success: function (data) {
                if (data.printer_server_url) {
                    $.ajax({
                        url: data.printer_server_url + "print_server/off_pos_printer_server.php",
                        method: "post",
                        dataType: "json",
                        data: {
                            content_data: JSON.stringify(data.content_data), print_type: data.print_type,
                        },
                        success: function (data) { },
                        error: function () { },
                    });
                }
            }
        });
    } else {
        if (print_format == "56mm") {
            open(base_url + "Sale/print_invoice/" + sale_id + '/package', 'Print Invoice', 'width=480,height=550');
        } else if (print_format == "80mm") {
            open(base_url + "Sale/print_invoice/" + sale_id + '/package', 'Print Invoice', 'width=685,height=550');
        } else if (print_format == "A4 Print") {
            open(base_url + "Sale/print_invoice/" + sale_id + '/package', 'Print Invoice', 'width=1600,height=550');
        } else if (print_format == "Half A4 Print") {
            open(base_url + "Sale/print_invoice/" + sale_id + '/package' , 'Print Invoice', 'width=1600,height=550');
        } else if (print_format == "Letter Head") {
            open(base_url + "Sale/print_invoice/" + sale_id + '/package', 'Print Invoice', 'width=1600,height=550');
        } else if (print_format == "TCM") {
            open(base_url + "Sale/print_invoice/" + sale_id + '/package', 'Print Invoice', 'width=1600,height=550');
        }
        // $("#finalize_order_cancel_button").click();
    }
}

function printAdvanceInvoice(sale_id) {  
    open(base_url + "Sale/print_advance_invoice/"+ sale_id, 'Print Invoice', 'width=685,height=550');
}

function cancelnow(id) {
    Swal.fire({
        title: "Are you sure?",
        text: "You want to cancel this package sale.",
        icon: "warning",
        input: "textarea", // <-- Input box
        inputPlaceholder: "Enter reason for cancellation...",
        inputAttributes: {
            "aria-label": "Enter reason for cancellation"
        },
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Cancel",
        cancelButtonText: "No",
        preConfirm: (note) => {
            if (!note) {
                Swal.showValidationMessage("Please enter a reason!");
            }
            return note;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: base_url + "Sale/cancel_package_sale",
                method: "post",
                dataType: "json",
                data: {
                    sale_id: id,
                    note: result.value   // <-- Note is here
                },
                success: function (data) {
                    Swal.fire({
                        title: "Cancelled!",
                        text: "The package sale has been cancelled successfully.",
                        icon: "success"
                    }).then(() => {
                        location.reload();
                    });
                }
            });
        }
    });
}
