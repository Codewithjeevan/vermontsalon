let jqry = $.noConflict();
jqry(function () {
    let copy_db = $('#copy_db_exp').val();
    let print_db = $('#print_db_exp').val();
    let excel_db = $('#excel_db_exp').val();
    let csv_db = $('#csv_db_exp').val();
    let pdf_db = $('#pdf_db_exp').val();
    let company_name = $('.company_name').text().trim();
    let outlet_info = $('.outlet_info').first().text().trim();
    // A table with data-export-header prints/exports only the lines of that element on top, nothing else
    let export_header = jqry('#datatable').data('export-header');
    let export_lines = export_header ? getHeaderLines(export_header) : [];

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
            title: export_header ? (export_lines[0] || '') : company_name,
            messageTop: function () {
                if (export_header) {
                    return export_lines.slice(1).map(function (line) {
                        return '<div style="text-align:center; font-weight:bold;">' + line + '</div>';
                    }).join('');
                }
                var headerHtml = getReportHeaderHtml();
                var therapistName = gettherapist();
                if (headerHtml) {
                    var output = '<div style="text-align:center; font-weight:bold;">' + headerHtml + '</div>';
                    if (therapistName) {
                        output += '<div style="text-align:left;">Therapist: <span style="color: green;">' + therapistName + '</span></div>';
                    }
                    return output;
                }
                var dateText = '';
                if (outlet_info) {
                    dateText += '<div style="text-align:center;">' + outlet_info + '</div>';
                }
                dateText += getDateRangeText();
                if (therapistName) {
                    dateText += '<div style="text-align:left;">Therapist: <span style="color: green;">' + therapistName + '</span></div>';
                }
               
                return dateText
                    ? '<div style="text-align:center; font-weight:bold;">' + dateText + '</div>'
                    : '';
            },
            text: '<span style="display: flex; align-items-center; gap: 8px;"><iconify-icon icon="solar:printer-broken" width="16"></iconify-icon> ' + print_db + '</span>',
            titleAttr: "Print",
            customize: function (win) {
                var css = 'table { border-collapse: collapse; width: 100%; } ' +
                        'th, td { border: 1px solid #dddddd; padding: 8px; text-align: center; }'+ 
                        'tr:last-child td { font-weight: bold;color: #000; }' 
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
                if (export_header) {
                    jqry(win.document.body).find('h1').css('text-align', 'center');
                }
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
                // The export header lines become the title rows, so DataTables' own title row is skipped
                title: export_header ? '' : '*',
                createEmptyCells: !!export_header,
                customize: function (xlsx, config, dt) {
                    if (export_header) {
                        buildExcelLayout(xlsx, dt, export_lines);
                        return;
                    }

                    var headerLines = getReportHeaderLines();
                    if (!headerLines.length) {
                        var dateText = getDateRangeText(1);
                        if (dateText) headerLines = [dateText];
                    }
                    if (!headerLines.length) return;

                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    var sheetData = sheet.getElementsByTagName('sheetData')[0];
                    var mergeCells = sheet.getElementsByTagName('mergeCells')[0];
                    var shift = headerLines.length;
                    var shiftRef = function (ref) {
                        return ref.replace(/\d+/g, function (n) { return parseInt(n, 10) + shift; });
                    };

                    // Push down the rows DataTables already wrote (title, headings, data),
                    // otherwise they share row numbers with the header rows and Excel drops the header
                    var colCount = 1;
                    jqry('row', sheet).each(function () {
                        var row = jqry(this);
                        row.attr('r', shiftRef(row.attr('r')));
                        row.children('c').each(function () {
                            jqry(this).attr('r', shiftRef(jqry(this).attr('r')));
                        });
                        colCount = Math.max(colCount, row.children('c').length);
                    });
                    jqry('mergeCell, autoFilter', sheet).each(function () {
                        jqry(this).attr('ref', shiftRef(jqry(this).attr('ref')));
                    });

                    // One row per header line (company, report, outlet, address, date...), centred across the table
                    var lastCol = excelColumnName(colCount);
                    var firstRow = sheetData.getElementsByTagName('row')[0];
                    headerLines.forEach(function (line, i) {
                        var rowNum = i + 1;
                        var newRow = sheet.createElement('row');
                        newRow.setAttribute('r', rowNum);

                        var newCell = sheet.createElement('c');
                        newCell.setAttribute('t', 'inlineStr');
                        newCell.setAttribute('r', 'A' + rowNum);
                        newCell.setAttribute('s', '51'); // DataTables' centred style, same as the title row

                        var is = sheet.createElement('is');
                        var t = sheet.createElement('t');
                        t.textContent = line;
                        is.appendChild(t);
                        newCell.appendChild(is);
                        newRow.appendChild(newCell);
                        sheetData.insertBefore(newRow, firstRow);

                        if (colCount > 1) {
                            var mergeCell = sheet.createElement('mergeCell');
                            mergeCell.setAttribute('ref', 'A' + rowNum + ':' + lastCol + rowNum);
                            mergeCells.appendChild(mergeCell);
                        }
                    });
                    mergeCells.setAttribute('count', mergeCells.getElementsByTagName('mergeCell').length);
                }
            },
            {
                extend: "pdfHtml5",
                text: '<span style="display: flex; align-items-center; gap: 8px;"><iconify-icon icon="teenyicons:pdf-outline" width="16"></iconify-icon> ' + pdf_db + '</span>',
                titleAttr: "PDF",
                title: export_header ? '' : '*',
                customize: function (doc) {
                    if (export_header) {
                        doc.content.splice(0, 0, {
                            text: export_lines.join('\n'),
                            alignment: 'center',
                            margin: [0, 0, 0, 12],
                            fontSize: 12,
                            bold: true
                        });
                        return;
                    }
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
            return 'From Date: <span style="color: green;">' + formatDate(from) + '</span>&nbsp; To Date: <span style="color: green;">' + formatDate(to) + '</span>';
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

function getReportHeaderLines() {
    return getHeaderLines(jqry('#datatable').data('report-header'));
}

function getHeaderLines(selector) { // text of each child of the header element, one line each
    if (!selector) {
        return [];
    }
    var header = jqry(selector);
    if (!header.length) {
        return [];
    }
    var lines = [];
    header.children().each(function () {
        var elementText = jqry(this).text().replace(/\s+/g, ' ').trim();
        if (elementText) {
            lines.push(elementText);
        }
    });
    return lines;
}

function getReportHeaderHtml() {
    var lines = getReportHeaderLines();
    if (!lines.length) {
        return '';
    }
    return lines.map(function (line) {
        return '<div>' + line + '</div>';
    }).join('');
}

function excelColumnName(colNumber) { // 1 => A, 15 => O, 27 => AA
    var name = '';
    while (colNumber > 0) {
        var mod = (colNumber - 1) % 26;
        name = String.fromCharCode(65 + mod) + name;
        colNumber = Math.floor((colNumber - 1) / 26);
    }
    return name;
}

// Plain bordered sheet for tables with data-export-header: the title lines on top (merged, centred),
// headings split on <br> over two rows, then the data, with the .bottom-line row in bold
function buildExcelLayout(xlsx, dt, titleLines) {
    var sheet = xlsx.xl.worksheets['sheet1.xml'];
    var sheetData = sheet.getElementsByTagName('sheetData')[0];
    var mergeCells = sheet.getElementsByTagName('mergeCells')[0];
    var style = addExcelLayoutStyles(xlsx.xl['styles.xml']);

    var headings = dt.columns().header().toArray().map(function (th) {
        return th.innerHTML.split(/<br\s*\/?>/i).map(function (part) {
            return jqry('<div>').html(part).text().replace(/\s+/g, ' ').trim();
        });
    });
    var colCount = headings.length;
    var lastCol = excelColumnName(colCount);
    var headingRowCount = Math.max.apply(null, headings.map(function (lines) { return lines.length; }));
    var widths = headings.map(function (lines) {
        return Math.max.apply(null, lines.map(function (line) { return line.length; }));
    });

    // With no title row, DataTables wrote the headings in row 1 and the data below; rebuild the sheet around the data rows
    var rows = Array.prototype.slice.call(sheetData.getElementsByTagName('row'));
    var dataRows = rows.slice(1);
    rows.forEach(function (row) {
        sheetData.removeChild(row);
    });

    var rowNum = 0;
    var appendTextRow = function (values, styleId) {
        rowNum++;
        var row = sheet.createElement('row');
        row.setAttribute('r', rowNum);
        for (var col = 0; col < colCount; col++) { // every cell is written so the borders cover merged and empty ones too
            var cell = sheet.createElement('c');
            cell.setAttribute('t', 'inlineStr');
            cell.setAttribute('r', excelColumnName(col + 1) + rowNum);
            cell.setAttribute('s', styleId);
            var is = sheet.createElement('is');
            var t = sheet.createElement('t');
            t.textContent = values[col] || '';
            is.appendChild(t);
            cell.appendChild(is);
            row.appendChild(cell);
        }
        sheetData.appendChild(row);
    };

    titleLines.forEach(function (line) {
        appendTextRow([line], style.heading);
        var mergeCell = sheet.createElement('mergeCell');
        mergeCell.setAttribute('ref', 'A' + rowNum + ':' + lastCol + rowNum);
        mergeCells.appendChild(mergeCell);
    });
    mergeCells.setAttribute('count', mergeCells.getElementsByTagName('mergeCell').length);

    for (var i = 0; i < headingRowCount; i++) {
        appendTextRow(headings.map(function (lines) { return lines[i]; }), style.heading);
    }

    // Exported rows come in the same order as the filtered table rows
    var rowNodes = dt.rows({ search: 'applied', order: 'applied' }).nodes().toArray();
    dataRows.forEach(function (row, index) {
        rowNum++;
        var isTotal = jqry(rowNodes[index]).hasClass('bottom-line');
        row.setAttribute('r', rowNum);
        jqry(row).children('c').each(function (col) {
            var isText = this.getAttribute('t') === 'inlineStr';
            this.setAttribute('r', excelColumnName(col + 1) + rowNum);
            this.setAttribute('s', isText ? (isTotal ? style.totalText : style.text) : (isTotal ? style.totalNumber : style.number));
            widths[col] = Math.max(widths[col], jqry(this).text().length);
        });
        sheetData.appendChild(row);
    });

    jqry('cols col', sheet).each(function (col) {
        this.setAttribute('width', widths[col] + 3);
    });
}

// Adds the bordered styles used by buildExcelLayout to DataTables' styles.xml and returns their indexes.
// fontId 2 = bold, borderId 1 = thin border on every side, numFmtId 4 = #,##0.00 (all built in)
function addExcelLayoutStyles(styles) {
    var cellXfs = styles.getElementsByTagName('cellXfs')[0];
    var xfs = {
        heading:     { fontId: 2, numFmtId: 0, align: 'center' },
        text:        { fontId: 0, numFmtId: 0, align: 'left' },
        number:      { fontId: 0, numFmtId: 4 },
        totalText:   { fontId: 2, numFmtId: 0, align: 'left' },
        totalNumber: { fontId: 2, numFmtId: 4 }
    };
    var ids = {};
    Object.keys(xfs).forEach(function (name) {
        var xf = styles.createElement('xf');
        xf.setAttribute('numFmtId', xfs[name].numFmtId);
        xf.setAttribute('fontId', xfs[name].fontId);
        xf.setAttribute('fillId', 0);
        xf.setAttribute('borderId', 1);
        xf.setAttribute('applyFont', 1);
        xf.setAttribute('applyBorder', 1);
        xf.setAttribute('applyNumberFormat', 1);
        if (xfs[name].align) {
            xf.setAttribute('applyAlignment', 1);
            var alignment = styles.createElement('alignment');
            alignment.setAttribute('horizontal', xfs[name].align);
            alignment.setAttribute('vertical', 'center');
            xf.appendChild(alignment);
        }
        cellXfs.appendChild(xf);
        ids[name] = cellXfs.getElementsByTagName('xf').length - 1;
    });
    cellXfs.setAttribute('count', cellXfs.getElementsByTagName('xf').length);
    return ids;
}
