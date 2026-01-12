$(document).ready(function () {
    const cartBody = $('#purchase_cart tbody');
    const addButton = $('#add_out_stock_item');

    function refreshSerial() {
        cartBody.find('tr').each(function (index) {
            $(this).find('td:first p').text(index + 1);
        });
    }

    function formatQty(value) {
        const parsed = parseFloat(value);
        if (Number.isFinite(parsed)) {
            return parsed;
        }
        return 0;
    }

    addButton.on('click', function () {
        const selected = $('#item_id option:selected');
        const itemId = selected.val();
        if (!itemId) {
            toastr.warning('Select item first');
            return;
        }
        const purchaseDetailId = selected.data('purchase-detail-id');
        const purchaseId = selected.data('purchase-id');
        const itemLabel = selected.data('item-label');
        const reference = selected.data('reference') || '';
        const purchaseDate = selected.data('purchase-date') || '';
        const availableQty = formatQty(selected.data('available'));
        const unitType = selected.data('unit-type') || '';
        const rowCount = cartBody.find('tr').length + 1;

        const row = `
            <tr class="rowCount" data-counter="${rowCount}">
                <td>
                    <div class="d-flex align-items-center">
                        <p id="sl_${rowCount}">${rowCount}</p>
                    </div>
                </td>
                <td>
                    <div>${itemLabel}</div>
                    <input type="hidden" name="item_id[]" value="${itemId}">
                    <input type="hidden" name="purchase_id[]" value="${purchaseId}">
                    <input type="hidden" name="purchase_detail_id[]" value="${purchaseDetailId}">
                    <input type="hidden" name="unit_type[]" value="${unitType}">
                </td>
                <td>
                    <div>${reference}</div>
                    <small class="text-muted">${purchaseDate}</small>
                </td>
                <td>
                    <div class="available_qty_text">${availableQty}</div>
                    <input type="hidden" name="available_qty[]" value="${availableQty}">
                </td>
                <td>
                    <input type="number" min="0.01" step="0.01" class="form-control out-stock-qty" name="out_stock_qty[]" value="${availableQty}" data-available="${availableQty}">
                </td>
                <td>${unitType}</td>
                <td>
                    <button type="button" class="new-btn remove_out_stock_row">
                        <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="18"></iconify-icon>
                    </button>
                </td>
            </tr>`;
        cartBody.append(row);
        $('#item_id').val('').trigger('change');
    });

    $(document).on('click', '.remove_out_stock_row', function () {
        $(this).closest('tr').remove();
        refreshSerial();
    });

    $(document).on('input', '.out-stock-qty', function () {
        const available = formatQty($(this).data('available'));
        const current = formatQty($(this).val());
        if (current > available) {
            $(this).val(available);
            toastr.warning('Quantity cannot exceed available stock');
        }
    });


    
  
});
