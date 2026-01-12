$(function () {
    "use strict";
    var copy_db = $('#copy_db_exp').val() || 'Copy';
    var print_db = $('#print_db_exp').val() || 'Print';
    var excel_db = $('#excel_db_exp').val() || 'Excel';
    var csv_db = $('#csv_db_exp').val() || 'CSV';
    var pdf_db = $('#pdf_db_exp').val() || 'PDF';

    var outStockTable = $('#outStockTable').DataTable({
        responsive: true,
        dom: '<"top-left-item col-sm-12 col-md-6"lf> <"top-right-item col-sm-12 col-md-6"B> t <"bottom-left-item col-sm-12 col-md-6 "i><"bottom-right-item col-sm-12 col-md-6 "p>',
        buttons: [{
            extend: "print",
            text: '<span style="display: flex; align-items:center; gap:6px;"><iconify-icon icon="solar:printer-broken" width="16"></iconify-icon> ' + print_db + '</span>',
            titleAttr: "Print",
        },
        {
            extend: "copyHtml5",
            text: '<span style="display: flex; align-items:center; gap:6px;"><iconify-icon icon="solar:copy-broken" width="16"></iconify-icon> ' + copy_db + '</span>',
            titleAttr: "Copy",
        },
        {
            extend: "excelHtml5",
            text: '<span style="display: flex; align-items:center; gap:6px;"><iconify-icon icon="icon-park-solid:excel" width="16"></iconify-icon> ' + excel_db + '</span>',
            titleAttr: "Excel",
        },
        {
            extend: "csvHtml5",
            text: '<span style="display: flex; align-items:center; gap:6px;"><iconify-icon icon="teenyicons:csv-outline" width="16"></iconify-icon> ' + csv_db + '</span>',
            titleAttr: "CSV",
        },
        {
            extend: "pdfHtml5",
            text: '<span style="display: flex; align-items:center; gap:6px;"><iconify-icon icon="teenyicons:pdf-outline" width="16"></iconify-icon> ' + pdf_db + '</span>',
            titleAttr: "PDF",
        }],
        order: [[3, "desc"]],
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
            $('#outStockTable [data-bs-toggle="tooltip"]').tooltip();
        },
    });

    $('#outStockFilterDate').on('change', function () {
        outStockTable.column(3).search(this.value).draw();
    });

    $('#clearOutStockDate').on('click', function () {
        $('#outStockFilterDate').val('');
        outStockTable.column(3).search('').draw();
    });
});
