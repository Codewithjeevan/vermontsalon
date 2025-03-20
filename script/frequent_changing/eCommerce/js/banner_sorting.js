$(document).ready(function(){
    "use strict";
    let base_url = $('#base_url_').val();
    let target = $('.sort_banner');

    
    let ok = $("#ok").val();
    let warning = $('#warning').val();

    target.sortable({
        handle: '.handle',
        placeholder: 'highlight',
        axis: "y",
        update: function (e, ui){
            let sortData = target.sortable('toArray',{ attribute: 'data-id'});
            $.ajax({
                type: "POST",
                url: base_url+'ECommerce_setting/sortBannerUpdate',
                data: {
                    ids: sortData.join(',')
                },
                success: function (response) {
                    if(response.success){
                        $('#ajax-message').html("");
                        $('#ajax-message').html(`
                        <section class="alert-wrapper">
                            <div class="alert alert-success alert-dismissible fade show"> 
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                <div class="alert-body">
                                    <i class="m-right fa fa-check"></i>
                                    ${response.message}
                                </div>
                            </div>
                        </section>
                        `);
                        setTimeout(function(){
                            $('#ajax-message').html("");
                        }, 2000);
                    }
                    
                }
            });
        }
    });
});
