
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
let csrf_name_ = $("#csrf_name_").val();
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


const sessionPriceSelectors = 'input[name="session_price[]"]';
const sessionTableBody = '#session_table_body';
const remainingBalanceSelector = '#remaining_balance';
const packageAssignmentErrorSelector = '#package_assignment_error';
const isEditMode = $('#edit_id').val() ? true : false;
let baseSessionCount = parseInt($('#session_count').val(), 10) || 0;

function toNumber(value) {
    if (value === null || value === undefined) return 0;
    const cleaned = String(value).replace(/,/g, '').trim();
    const parsed = parseFloat(cleaned);
    return isNaN(parsed) ? 0 : parsed;
}

function getTotalPrice() {
    return toNumber($('#total').val());
}

function sanitizeSessionPriceInput(element) {
    const raw = element.value || '';
    const filtered = raw.replace(/[^0-9.]/g, '');
    const firstDot = filtered.indexOf('.');
    const normalized = firstDot === -1
        ? filtered
        : filtered.slice(0, firstDot + 1) + filtered.slice(firstDot + 1).replace(/\./g, '');

    if (normalized === raw) {
        return raw;
    }

    const caret = element.selectionStart || 0;
    const caretLeft = raw.slice(0, caret).replace(/[^0-9.]/g, '');
    element.value = normalized;
    const newPosition = Math.min(normalized.length, caretLeft.length);
    element.setSelectionRange(newPosition, newPosition);
    return normalized;
}

function updateRemainingBalanceDisplay(amount) {
    if (!isEditMode) return;
    const value = amount < 0 ? 0 : amount;
    $(remainingBalanceSelector).val(value.toFixed(2));
}

function getUsedTotal() {
    let usedTotal = 0;
    $(sessionTableBody).find('tr').each(function () {
        const status = $(this).find('select[name="status[]"]').val();
        if (status === '1') {
            const price = toNumber($(this).find(sessionPriceSelectors).val());
            usedTotal += price;
        }
    });
    return usedTotal;
}

function getRemainingFromUsed() {
    const remaining = getTotalPrice() - getUsedTotal();
    return remaining < 0 ? 0 : remaining;
}

function getBaseSessionRowCount() {
    return $(sessionTableBody).find('tr').filter(function () {
        return !$(this).data('remaining-row');
    }).length;
}

function getBaseUsedCount() {
    let count = 0;
    $(sessionTableBody).find('tr').each(function () {
        if ($(this).data('remaining-row')) {
            return;
        }
        const status = $(this).find('select[name="status[]"]').val();
        if (status === '1') {
            count++;
        }
    });
    return count;
}

function markFixedRows() {
    $(sessionTableBody).find('tr.disabled-row').find(sessionPriceSelectors).each(function () {
        $(this).data('userEdited', true);
    });
    $(sessionTableBody).find('tr[data-remaining-row="1"]').find(sessionPriceSelectors).each(function () {
        $(this).data('userEdited', true);
    });
}

function buildSessionRow(index, priceValue) {
    const empClone = $('#employee_id').prop('outerHTML');
    return `<tr>
                <td>
                <input type="text" name="session_name[]" class="form-control" value="Session ${index}" readonly>
                <input type="hidden" name="session_id[]" value="${index}">
                <input type="hidden" name="pack_session_id[]" value="">
                </td>
                <td><input type="text" name="session_price[]" class="form-control" value="${priceValue}"></td>
                <td>${empClone}</td>
                <td><input type="datetime-local" name="in_time[]" class="form-control"></td>
                <td><input type="number" name="time_frame[]" class="form-control time_frame_input" min="0" step="1" placeholder="Minutes"></td>
                <td><input type="datetime-local" name="out_time[]" class="form-control"></td>
                <td>
                    <select name="status[]" class="form-select" style="height: 45px;" data-current-status="0">
                        <option value="0">Available</option>
                        <option value="1">Used</option>
                    </select>
                </td>
            </tr>`;
}

function buildRemainingBalanceRow(priceValue) {
    const empClone = $('#employee_id').prop('outerHTML');
    const rowIndex = $(sessionTableBody).find('tr').length + 1;
    return `<tr data-remaining-row="1">
                <td>
                <input type="text" name="session_name[]" class="form-control" value="Remaining Balance" readonly>
                <input type="hidden" name="session_id[]" value="${rowIndex}">
                <input type="hidden" name="pack_session_id[]" value="">
                </td>
                <td><input type="text" name="session_price[]" class="form-control" value="${priceValue}" data-user-edited="1"></td>
                <td>${empClone}</td>
                <td><input type="datetime-local" name="in_time[]" class="form-control"></td>
                <td><input type="number" name="time_frame[]" class="form-control time_frame_input" min="0" step="1" placeholder="Minutes"></td>
                <td><input type="datetime-local" name="out_time[]" class="form-control"></td>
                <td>
                    <select name="status[]" class="form-select" style="height: 45px;" data-current-status="0">
                        <option value="0">Available</option>
                        <option value="1">Used</option>
                    </select>
                </td>
            </tr>`;
}

function ensureRemainingBalanceRows(remaining) {
    if (!isEditMode) return;
    const total = getTotalPrice();
    if (total <= 0 || remaining <= 0) return;

    const $remainingRows = $(sessionTableBody).find('tr[data-remaining-row="1"]');
    const hasAvailableRemaining = $remainingRows.filter(function () {
        return $(this).find('select[name="status[]"]').val() === '0';
    }).length > 0;

    if (remaining > 0 && !hasAvailableRemaining) {
        $(sessionTableBody).append(buildRemainingBalanceRow(remaining.toFixed(2)));
        markFixedRows();
    }
}

function rebalanceSessionPrices($changedInput) {
    const total = getTotalPrice();
    if (total <= 0) {
        updateRemainingBalanceDisplay(0);
        return;
    }

    if ($changedInput && $changedInput.length) {
        $changedInput.data('userEdited', true);
        let currentVal = toNumber($changedInput.val());
        if (currentVal < 0) currentVal = 0;
        $changedInput.val(currentVal === 0 ? '0.00' : $changedInput.val());
    }

    const $inputs = $(sessionTableBody).find(sessionPriceSelectors);
    let fixedTotal = 0;
    $inputs.each(function () {
        const $input = $(this);
        const status = $input.closest('tr').find('select[name="status[]"]').val();
        if ($input.data('userEdited') || status === '1') {
            let value = toNumber($input.val());
            if (value < 0) {
                value = 0;
                $input.val('0.00');
            }
            fixedTotal += value;
        }
    });

    if ($changedInput && $changedInput.length && fixedTotal > total) {
        const currentVal = toNumber($changedInput.val());
        const otherFixed = fixedTotal - currentVal;
        let adjusted = total - otherFixed;
        if (adjusted < 0) adjusted = 0;
        $changedInput.val(adjusted.toFixed(2));
        fixedTotal = otherFixed + adjusted;
    }

    let remaining = total - fixedTotal;
    if (remaining < 0) remaining = 0;

    if (isEditMode) {
        ensureRemainingBalanceRows(getRemainingFromUsed());
    }

    const $autoInputs = $(sessionTableBody).find(sessionPriceSelectors).filter(function () {
        const status = $(this).closest('tr').find('select[name="status[]"]').val();
        return status === '0' && !$(this).data('userEdited');
    });
    const autoCount = $autoInputs.length;
    if (autoCount > 0) {
        const per = remaining / autoCount;
        $autoInputs.each(function () {
            $(this).val(per.toFixed(2));
        });
    }

    const recalculatedTotal = $(sessionTableBody).find(sessionPriceSelectors).toArray().reduce((sum, input) => {
        return sum + toNumber($(input).val());
    }, 0);
    updateRemainingBalanceDisplay(getRemainingFromUsed());
}

function syncRemainingBalance() {
    const total = getTotalPrice();
    if (total <= 0) {
        updateRemainingBalanceDisplay(0);
        return;
    }
    if (isEditMode) {
        ensureRemainingBalanceRows(getRemainingFromUsed());
    }
    updateRemainingBalanceDisplay(getRemainingFromUsed());
}

$(document).on('change', '.package_data', function () {
    const session_count = parseInt($('option:selected', this).data('session'), 10) || 0;
    const price = toNumber($('option:selected', this).data('price'));
    const session_price = session_count > 0 ? price / session_count : 0;
    $('#total').val(price.toFixed(2));
    $('#session_count').val(session_count);
    baseSessionCount = session_count;

    let allRows = "";
    for (let i = 1; i <= session_count; i++) {
        allRows += buildSessionRow(i, session_price.toFixed(2));
    }
    $('#session_table tbody').html(allRows);
    rebalanceSessionPrices();
});

$(document).on('input', `${sessionTableBody} ${sessionPriceSelectors}`, function () {
    sanitizeSessionPriceInput(this);
    rebalanceSessionPrices($(this));
});

$(document).on('click', '#add_remaining_balance_row_btn', function () {
    const remaining = getRemainingFromUsed();
    if (remaining <= 0) {
        return;
    }
    $(sessionTableBody).append(buildRemainingBalanceRow(remaining.toFixed(2)));
    markFixedRows();
    rebalanceSessionPrices();
});

$(document).on('change', `${sessionTableBody} select[name="status[]"]`, function () {
    rebalanceSessionPrices();
    const remaining = getRemainingFromUsed();
    ensureRemainingBalanceRows(remaining);
    updateRemainingBalanceDisplay(remaining);
});

$(document).on('change', '#walk_in_customer, #select_pacakge', function () {
    $(packageAssignmentErrorSelector).hide().text('');
});

$(document).on('click', '#pay_now_button', function (event) {
    event.preventDefault();
    const $button = $(this);
    if ($button.prop('disabled')) {
        return;
    }

    const customerId = $('#walk_in_customer').val();
    const packageId = $('#select_pacakge').val();
    const $form = $button.closest('form');
    const $error = $(packageAssignmentErrorSelector);
    $error.hide().text('');

    if (!customerId || !packageId) {
        $form.submit();
        return;
    }

    if ($button.data('checking')) {
        return;
    }

    const payload = {
        customer_id: customerId,
        package_id: packageId
    };
    const packageSaleId = $('#edit_id').val();
    if (packageSaleId) {
        payload.package_sale_id = packageSaleId;
    }
    payload[csrf_name_] = csrf_value_;

    $button.data('checking', true);
    $button.prop('disabled', true);

    $.ajax({
        url: base_url + 'Sale/checkCustomerPackageAssignment',
        method: 'POST',
        dataType: 'json',
        data: payload,
        success: function (response) {
            if (response.csrf_value_) {
                csrf_value_ = response.csrf_value_;
                $('#csrf_value_').val(csrf_value_);
            }

            if (response.status === 'error') {
                $error.text(response.message || 'This customer already has an active package assignment.').show();
                return;
            }

            $form.submit();
        },
        error: function () {
            $error.text('Unable to verify package assignment right now.').show();
        },
        complete: function () {
            $button.removeData('checking');
            $button.prop('disabled', false);
        }
    });
});

$(document).ready(function () {
    if (isEditMode) {
        baseSessionCount = getBaseSessionRowCount();
        $('#walk_in_customer, #select_pacakge').prop('disabled', true);
        $('#walk_in_customer, #select_pacakge').css('cursor', 'not-allowed');
        $('#walk_in_customer').next('.select2').find('.select2-selection').css('cursor', 'not-allowed');
    }
    markFixedRows();
    syncRemainingBalance();
});

function parseDateTimeLocal(value) {
    if (!value || value.indexOf('T') === -1) return null;
    const parts = value.split('T');
    const dateParts = parts[0].split('-').map(Number);
    const timeParts = parts[1].split(':').map(Number);
    if (dateParts.length !== 3 || timeParts.length < 2) return null;
    return new Date(dateParts[0], dateParts[1] - 1, dateParts[2], timeParts[0], timeParts[1], 0, 0);
}

function formatDateTimeLocal(date) {
    const pad = (n) => String(n).padStart(2, '0');
    const yyyy = date.getFullYear();
    const mm = pad(date.getMonth() + 1);
    const dd = pad(date.getDate());
    const hh = pad(date.getHours());
    const min = pad(date.getMinutes());
    return `${yyyy}-${mm}-${dd}T${hh}:${min}`;
}

function updateOutTimeFromFrame($row) {
    const inTimeVal = $row.find('input[name="in_time[]"]').val();
    const frameVal = $row.find('input[name="time_frame[]"]').val();
    if (!inTimeVal || frameVal === '' || isNaN(frameVal)) return;
    const minutes = parseInt(frameVal, 10);
    if (minutes < 0) return;
    const dt = parseDateTimeLocal(inTimeVal);
    if (!dt) return;
    dt.setMinutes(dt.getMinutes() + minutes);
    $row.find('input[name="out_time[]"]').val(formatDateTimeLocal(dt));
}

$(document).on('input', '#session_table_body input[name="time_frame[]"]', function () {
    updateOutTimeFromFrame($(this).closest('tr'));
});

$(document).on('change', '#session_table_body input[name="in_time[]"]', function () {
    const $row = $(this).closest('tr');
    const frameVal = $row.find('input[name="time_frame[]"]').val();
    if (frameVal !== '' && !isNaN(frameVal)) {
        updateOutTimeFromFrame($row);
    }
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

$(document).on('change', '#session_table_body select[name="status[]"]', function () {
    const $select = $(this);
    const newStatus = $select.val();
    const previousStatus = $select.data('current-status') || $select.attr('data-current-status') || '0';
    const $row = $select.closest('tr');
    const packSessionId = $row.find('input[name="pack_session_id[]"]').val();
    const employeeId = $row.find('select[name="employee_id[]"]').val();
    const inTime = $row.find('input[name="in_time[]"]').val();
    const outTime = $row.find('input[name="out_time[]"]').val();

    if (!employeeId || !inTime || !outTime) {
        $select.val(previousStatus);
        return;
    }

    if (!packSessionId) {
        toggleSessionRowState($row, newStatus);
        $select.data('current-status', newStatus);
        return;
    }

    updatePackageSessionStatus(packSessionId, newStatus, $row, $select, previousStatus);
});

function toggleSessionRowState($row, status) {
    if (status === '1') {
        $row.addClass('disabled-row');
    } else {
        $row.removeClass('disabled-row');
    }
}


function updatePackageSessionStatus(packSessionId, status, $row, $select, previousStatus) {
    const payload = {
        pack_session_id: packSessionId,
        status: status,
        session_id: $row.find('input[name="session_id[]"]').val(),
        session_name: $row.find('input[name="session_name[]"]').val(),
        session_price: $row.find('input[name="session_price[]"]').val(),
        employee_id: $row.find('select[name="employee_id[]"]').val(),
        time_frame: $row.find('input[name="time_frame[]"]').val(),
        in_time: $row.find('input[name="in_time[]"]').val(),
        out_time: $row.find('input[name="out_time[]"]').val(),
        payment_method: $('#payment_method').val()
    };
    payload[csrf_name_] = csrf_value_;
    $.ajax({
        url: base_url + "Sale/updatePackageSessionStatus",
        method: "POST",
        dataType: "json",
        data: payload,
        success: function (response) {
            if (response.status === 'success') {
                toggleSessionRowState($row, status);
                $select.data('current-status', status);
            } else {
                $select.val(previousStatus);
                $select.data('current-status', previousStatus);
                Swal.fire('Oops!', response.message || 'Unable to update session status right now.', 'error');
            }
            if (response.csrf_value_) {
                csrf_value_ = response.csrf_value_;
                $('#csrf_value_').val(csrf_value_);
            }
        },
        error: function () {
            $select.val(previousStatus);
            $select.data('current-status', previousStatus);
            Swal.fire('Oops!', 'Unable to update session status. Try again later.', 'error');
        }
    });
}
