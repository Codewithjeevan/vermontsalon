$(function () {
    "use strict";

    let base_url = $('#base_url').val();
    let select = $('#select').val();
    let warning = $('#warning').val();
    let no_permission_for_this_module = $('#no_permission_for_this_module').val();
    let the_name_field_is_required = $('#the_name_field_is_required').val();
    
    $(document).on('keydown', '.integerchkPercent', function(e){
        let keys = e.charCode || e.keyCode || 0;
        // allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
        // home, end, period, and numpad decimal
        return (
            keys == 8 ||
            keys == 9 ||
            keys == 13 ||
            keys == 46 ||
            keys == 110 ||
            keys == 86 ||
            keys == 190 ||
            (keys >= 35 && keys <= 40) ||
            (keys >= 48 && keys <= 57) ||
            (keys >= 96 && keys <= 105));
    });

    $(document).on('keyup', '.integerchkPercent', function(e){
        let input = $(this).val();
        let ponto = input.split('.').length;
        let slash = input.split('-').length;
        if (ponto > 2)
            $(this).val(input.substr(0,(input.length)-1));
        $(this).val(input.replace(/[^0-9.%]/,''));
        if(slash > 2)
            $(this).val(input.substr(0,(input.length)-1));
        if (ponto ==2)
            $(this).val(input.substr(0,(input.indexOf('.')+4)));
        if(input == '.')
            $(this).val("");

    });


    $(document).on('click', '.add_group_by_ajax', function(){
        $.ajax({
            url: base_url+"Master/checkAccess",
            method: "GET",
            async: false,
            dataType: 'json',
            data: { controller: "154", function: "add" },
            success: function (response) {
                if (response == false) {
                    Swal.fire({
                        title: warning +" !",
                        text: no_permission_for_this_module,
                        showDenyButton: false,
                        showCancelButton: false,
                        confirmButtonText: 'OK',
                    });
                } else {
                    $('#addCustomerGroupModal').modal('show');
                }
            }
        });
    });


    $(document).on('click', '#addGroup', function(){
        $.ajax({
            url: base_url+"Master/checkAccess",
            method: "GET",
            async: false,
            dataType: 'json',
            data: { controller: "154", function: "add" },
            success: function (response) {
                if (response == false) {
                    Swal.fire({
                        title: warning +" !",
                        text: no_permission_for_this_module,
                        showDenyButton: false,
                        showCancelButton: false,
                        confirmButtonText: 'OK',
                    });
                } else {
                    let name = $('#group_name').val();
                    let description = $('#description_group').val();
                    let error = false;
                    if (name == '') {
                        error = true;
                        $('.group_name_err_msg').text(the_name_field_is_required);
                        $('.group_name_err_msg_contnr').show(200).delay(6000).hide(200, function () {});
                    } 
                    if (error == false) {
                        $.ajax({
                            type: "POST",
                            url: base_url+"Ajax/addGroupByAjax",
                            data: {
                                name: name,
                                description: description,
                            },
                            success: function (response) {
                                if (response) {
                                    let json = $.parseJSON(response);
                                    let html = '<option>'+select+'</option>';
                                    $.each(json.groups, function (i, v) {
                                        html += '<option value="' + v.id + '">' + v.group_name +
                                            '</option>';
                                    });
                                    $("#group_id").html(html);
                                    $("#group_id").val(json.id).change();
                                    $("#addCustomerGroupModal").modal('hide');
                                    $('#group_name').val('');
                                    $('#description_group').val('');
                                }
                            }
                        });
                    }
                }
            }
        });
    })



    


    const newDocumentRowContainer = $('#newCustomerDocumentRows');

    const appendDocumentRow = () => {
        const row = `<div class="document-row row g-2 align-items-end mb-2">
            <div class="col-md-5">
                <input type="text" name="document_label[]" class="form-control form-control-sm" placeholder="Label">
            </div>
            <div class="col-md-5">
                <input type="file" name="document_file[]" class="form-control form-control-sm">
            </div>
            <div class="col-md-2 text-end">
                <button type="button" class="btn btn-outline-danger btn-sm remove-document-row">
                    <iconify-icon icon="solar:trash-bin-trash-bold"></iconify-icon>
                </button>
            </div>
        </div>`;
        newDocumentRowContainer.append(row);
    };

    $(document).on('click', '#addCustomerDocumentRow', function () {
        appendDocumentRow();
    });

    $(document).on('click', '.remove-document-row', function () {
        $(this).closest('.document-row').remove();
    });

    $(document).on('click', '.delete-existing-document', function () {
        const documentId = $(this).data('id');
        const documentRow = $(this).closest('.document-existing-row');
        if (!documentId) {
            return;
        }
        Swal.fire({
            title: 'Delete document?',
            text: 'This will permanently remove the file for this customer.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (!result.isConfirmed) {
                return;
            }
            $.ajax({
                url: base_url + 'Customer/deleteCustomerDocument',
                method: 'POST',
                dataType: 'json',
                data: { document_id: documentId },
                success: function (response) {
                    if (response && response.status === 'success') {
                        documentRow.remove();
                    } else {
                        Swal.fire({
                            title: warning + ' !',
                            text: response && response.message ? response.message : 'Unable to delete document',
                            icon: 'warning'
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        title: warning + ' !',
                        text: 'Server error while deleting document',
                        icon: 'error'
                    });
                }
            });
        });
    });

    if (newDocumentRowContainer.length && !newDocumentRowContainer.children('.document-row').length) {
        appendDocumentRow();
    }
});
