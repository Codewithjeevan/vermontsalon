$(function () {
    "use strict";
    var copy_db = $('#copy_db_exp').val() || 'Copy';
    var print_db = $('#print_db_exp').val() || 'Print';
    var excel_db = $('#excel_db_exp').val() || 'Excel';
    var csv_db = $('#csv_db_exp').val() || 'CSV';
    var pdf_db = $('#pdf_db_exp').val() || 'PDF';

    var stockAvailabilityTable = $('#stockAvailabilityTable').DataTable({
        responsive: true,
        dom: '<"top-left-item col-sm-12 col-md-6"lf> <"top-right-item col-sm-12 col-md-6"B> t <"bottom-left-item col-sm-12 col-md-6 "i><"bottom-right-item col-sm-12 col-md-6 "p>',
        buttons: [{
            extend: "print",
            text: '<span style="display:flex;align-items:center;gap:6px;"><iconify-icon icon="solar:printer-broken" width="16"></iconify-icon> ' + print_db + '</span>',
            titleAttr: "Print",
        },
        {
            extend: "copyHtml5",
            text: '<span style="display:flex;align-items:center;gap:6px;"><iconify-icon icon="solar:copy-broken" width="16"></iconify-icon> ' + copy_db + '</span>',
            titleAttr: "Copy",
        },
        {
            extend: "excelHtml5",
            text: '<span style="display:flex;align-items:center;gap:6px;"><iconify-icon icon="icon-park-solid:excel" width="16"></iconify-icon> ' + excel_db + '</span>',
            titleAttr: "Excel",
        },
        {
            extend: "csvHtml5",
            text: '<span style="display:flex;align-items:center;gap:6px;"><iconify-icon icon="teenyicons:csv-outline" width="16"></iconify-icon> ' + csv_db + '</span>',
            titleAttr: "CSV",
        },
        {
            extend: "pdfHtml5",
            text: '<span style="display:flex;align-items:center;gap:6px;"><iconify-icon icon="teenyicons:pdf-outline" width="16"></iconify-icon> ' + pdf_db + '</span>',
            titleAttr: "PDF",
        }],
        order: [[1, 'asc']],
        columnDefs: [
            { orderable: false, targets: 6 },
            { searchable: false, targets: 6 }
        ],
        language: {
            paginate: {
                previous: "Previous",
                next: "Next",
            }
        },
        initComplete: function () {
            $('#stockAvailabilityTable [data-bs-toggle="tooltip"]').tooltip();
        },
    });

    stockAvailabilityTable.buttons().container().appendTo('#stockAvailabilityTable_wrapper .col-md-6:eq(0)');

    var stockAdjustmentUrl = window.stockAdjustmentUrl || '';
    var stockAdjustmentHistoryUrl = window.stockAdjustmentHistoryUrl || '';
    var $adjustModal = $('#stockAdjustmentModal');
    var $adjustHistoryModal = $('#stockAdjustmentHistoryModal');

    function resetAdjustmentForm() {
        $('#adjustQuantityPlus').val('0');
        $('#adjustQuantityMinus').val('0');
        $('#adjustReason').val('');
        $('#adjustmentDate').val(new Date().toISOString().split('T')[0]);
    }

    $('.stock-adjust-btn').on('click', function () {
        var $button = $(this);
        $('#adjustItemId').val($button.data('item-id'));
        $('#adjustPurchaseDetailId').val($button.data('purchase-detail-id'));
        $('#adjustItemLabel').val($button.data('item-label'));
        $('#adjustAvailableQty').val($button.data('available'));
        $('#adjustUnitName').text($button.data('unit-name'));
        resetAdjustmentForm();
        $adjustModal.modal('show');
    });

    $('#stockAdjustmentForm').on('submit', function (e) {
        e.preventDefault();
        if (!stockAdjustmentUrl) {
            toastr.error('Adjustment endpoint missing');
            return;
        }
        var $form = $(this);
        $.ajax({
            url: stockAdjustmentUrl,
            method: 'POST',
            dataType: 'json',
            data: $form.serialize()
        }).done(function (response) {
            if (response.status) {
                toastr.success(response.message);
                $adjustModal.modal('hide');
                setTimeout(function () {
                    location.reload();
                }, 800);
            } else {
                toastr.error(response.message);
            }
        }).fail(function () {
            toastr.error('Unable to adjust stock right now');
        });
    });

    var currentAdjustmentFilter = { purchaseDetailId: null, itemName: null };

    function loadAdjustmentHistory(startDate, endDate, purchaseDetailId, itemName) {
        purchaseDetailId = purchaseDetailId || currentAdjustmentFilter.purchaseDetailId;
        itemName = itemName || currentAdjustmentFilter.itemName;
        if (!stockAdjustmentHistoryUrl) {
            return;
        }
        var titleText = itemName ? 'Stock Adjustments - ' + itemName : 'Stock Adjustments';
        $('#stockAdjustmentHistoryLabel').text(titleText);
        var payload = {
            start_date: startDate,
            end_date: endDate
        };
        if (purchaseDetailId) {
            payload.purchase_detail_id = purchaseDetailId;
        }
        $.ajax({
            url: stockAdjustmentHistoryUrl,
            method: 'POST',
            dataType: 'json',
            data: payload
        }).done(function (response) {
            var rows = '';
            if (Array.isArray(response) && response.length) {
                response.forEach(function (item) {
                    var direction = item.adjustment_type === 'minus' ? '<span class="badge bg-danger">−</span>' : '<span class="badge bg-success">+</span>';
                    var qty = parseFloat(item.added_qty).toFixed(2);
                    var currentQty = item.current_qty !== null ? parseFloat(item.current_qty).toFixed(2) : '-';
                    rows += '<tr>' +
                        '<td>' + item.adjustment_date + '</td>' +
                        '<td>' + (item.item_name || 'Unknown') + '</td>' +
                        '<td class="text-center">' + direction + '</td>' +
                        '<td>' + qty + '</td>' +
                        '<td>' + currentQty + '</td>' +
                        '<td>' + (item.reason ? item.reason : '-') + '</td>' +
                        '</tr>';
                });
            } else {
                rows = '<tr><td colspan="6" class="text-center text-muted">No adjustments found.</td></tr>';
            }
            $('#stockAdjustmentHistoryBody').html(rows);
        }).fail(function () {
            $('#stockAdjustmentHistoryBody').html('<tr><td colspan="6" class="text-center text-danger">Unable to load data.</td></tr>');
        });
    }

    $('.stock-adjustment-history-row-btn').on('click', function () {
        var purchaseDetailId = $(this).data('purchase-detail-id');
        var itemName = $(this).data('item-name');
        currentAdjustmentFilter.purchaseDetailId = purchaseDetailId;
        currentAdjustmentFilter.itemName = itemName;
        loadAdjustmentHistory($('#adjustmentHistoryStart').val(), $('#adjustmentHistoryEnd').val(), purchaseDetailId, itemName);
        $adjustHistoryModal.modal('show');
    });

    $('#stockAdjustmentHistoryFilter').on('click', function () {
        loadAdjustmentHistory($('#adjustmentHistoryStart').val(), $('#adjustmentHistoryEnd').val());
    });

    $('#stockAdjustmentHistoryClear').on('click', function () {
        $('#adjustmentHistoryStart').val('');
        $('#adjustmentHistoryEnd').val('');
        loadAdjustmentHistory('', '');
    });

    resetAdjustmentForm();
});
