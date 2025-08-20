let jqry = $.noConflict();
jqry(function () {
    let copy_db = $('#copy_db_exp').val();
    let print_db = $('#print_db_exp').val();
    let excel_db = $('#excel_db_exp').val();
    let csv_db = $('#csv_db_exp').val();
    let pdf_db = $('#pdf_db_exp').val();
    let company_name = $('.company_name').text().trim();
    let outlet_info = $('.outlet_info').first().text().trim();

    let APPLICATION_DEMO_TYPE = $('#APPLICATION_DEMO_TYPE').val();


    $(document).on('click', '.dataFilterBy', function () {
        $('.content-wrapper').css('height', '100vh');
    });
    $(document).on('click', '.filter-overlay', function () {
        $('.content-wrapper').css('height', 'auto');
    });

    jqry('#datatable').DataTable({
        ordering: false,
        dom: '<"top-left-item col-sm-12 col-md-6"lf> <"top-right-item col-sm-12 col-md-6"B> t <"bottom-left-item col-sm-12 col-md-6 "i><"bottom-right-item col-sm-12 col-md-6 "p>',
        buttons: APPLICATION_DEMO_TYPE != 'Pharmacy' ? [
            {
            extend: "print",
            title: company_name,
            messageTop: function () {
                var dateText = '';
                if (outlet_info) {
                    dateText += '<div style="text-align:center;">' + outlet_info + '</div>';
                }
                dateText += getDateRangeText();
                var therapistName = gettherapist();
                if (therapistName) {
                    dateText += '<div style="text-align:left;">Stylist : <span style="color: green;">' + therapistName + '</span></div>';
                }
               
                return dateText
                    ? '<div style="text-align:center; font-weight:900;">' + dateText + '</div>'
                    : '';
            },
            text: '<span style="display: flex; align-items-center; gap: 8px;"><iconify-icon icon="solar:printer-broken" width="16"></iconify-icon> ' + print_db + '</span>',
            titleAttr: "Print",
            customize: function (win) {
                var css = 'table { border-collapse: collapse; width: 100%; } ' +
                        'th, td { border: 1px solid #dddddd; padding: 8px; text-align: center;font-weight: 900;color: #000000; }'+ 
                        'tr:last-child td { font-weight: 900;color: #000000; }' 
                        ;
                var head = win.document.head || win.document.getElementsByTagName('head')[0];
                var style = win.document.createElement('style');

                style.type = 'text/css';
                style.media = 'print';
                if (style.styleSheet){
                    style.styleSheet.cssText = css;
                } else {
                    style.appendChild(win.document.createTextNode(css));
                }

                head.appendChild(style);
            }
            },
            {
                extend: "copyHtml5",
                text: '<span style="display: flex; align-items-center; gap: 8px;"><iconify-icon icon="solar:copy-broken" width="16"></iconify-icon> ' + copy_db + '</span>',
                titleAttr: "Copy",
            },
            {
                extend: "excelHtml5",
                text: '<span style="display: flex; align-items-center; gap: 8px;"><iconify-icon icon="icon-park-solid:excel" width="16"></iconify-icon> '+excel_db+'</span>',
                titleAttr: "Excel",
                customize: function (xlsx) {
                    var dateText = getDateRangeText();
                    if (!dateText) return;

                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    var sheetData = sheet.getElementsByTagName('sheetData')[0];

                    // Create a new row at the top
                    var newRow = sheet.createElement('row');
                    newRow.setAttribute('r', 1); // row number

                    // Create a new cell
                    var newCell = sheet.createElement('c');
                    newCell.setAttribute('t', 'inlineStr');
                    newCell.setAttribute('r', 'A1'); // cell location

                    // Create inline string content
                    var is = sheet.createElement('is');
                    var t = sheet.createElement('t');
                    t.textContent = dateText;

                    // Build the structure
                    is.appendChild(t);
                    newCell.appendChild(is);
                    newRow.appendChild(newCell);

                    // Insert the new row at the top
                    var firstRow = sheetData.getElementsByTagName('row')[0];
                    sheetData.insertBefore(newRow, firstRow);
                }
            },
            {
                extend: "pdfHtml5",
                text: '<span style="display: flex; align-items-center; gap: 8px;"><iconify-icon icon="teenyicons:pdf-outline" width="16"></iconify-icon> ' + pdf_db + '</span>',
                titleAttr: "PDF",
                customize: function (doc) {
                    var dateText = getDateRangeText(1);
                    var therapistName = gettherapist();
                    if (therapistName) {
                        doc.content.splice(0, 0, {
                            text: 'Therapist: ' + therapistName,
                            alignment: 'center',
                            margin: [0, 0, 0, 12],
                            fontSize: 12,
                            bold: true
                        });
                    }
                    if (dateText) {
                        doc.content.splice(0, 0, {
                            text: dateText,
                            alignment: 'center',
                            margin: [0, 0, 0, 12],
                            fontSize: 12,
                            bold: true
                        });
                    }
                }
            }
        ] : [],
        language: {
            paginate: {
                previous: "Previous",
                next: "Next",
            },
        },
        paging: false
    });
});

function formatDate(dateStr) {
    if (!dateStr) return '';
    var parts = dateStr.split('-'); // [yyyy, mm, dd]
    return parts[2] + '/' + parts[1] + '/' + parts[0].slice(2); // dd/mm/yy
}

function getDateRangeText(type = 0) { // type 1 = only text, 0 with style
    var startDateElement = $('#startDate');
    var from = startDateElement.length ? startDateElement.val() : '';
    var endDateElement = $('#endDate');
    var to = endDateElement.length ? endDateElement.val() : '';

    if (from && to) {
        if (type === 1) {
            return 'From Date: ' + formatDate(from) + ' To Date: ' + formatDate(to);
        }else{
            return 'From Date: <span style="color: #000000;font-weight: 900;">' + formatDate(from) + '</span>&nbsp; To Date: <span style="color: #000000;font-weight: 900;">' + formatDate(to) + '</span>';
        }
    } else {
        return '';
    }
}

function gettherapist() {
    var therapistname = $('#therapist_name');
    if (therapistname.length) {
        therapistname = therapistname.text();
    } else {
        therapistname = '';
    }
    return therapistname ? therapistname : '';
}