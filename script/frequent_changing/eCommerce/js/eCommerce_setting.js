$(function () {
    "use strict";
    
    $(document).on('change', '.smtp_type', function(){
        smtpShowHide();
    });
    function smtpShowHide(){
        let smtp_type = $('.smtp_type').val();
        if(smtp_type == 'Gmail'){
            $('.sendinblue_part').hide();
        }else if(smtp_type == 'Sendinblue'){
            $('.sendinblue_part').show();
        }
    }
    smtpShowHide();



    $(document).on('change', '.sms_service_provider', function(){
        smsShowHide();
    });
    function smsShowHide(){
        let  sms_service_provider = $(".sms_service_provider").val();
        let  text_singup = $(".sms_service_provider").find(':selected').attr("data-text_singup");
        let  signup_url = $(".sms_service_provider").find(':selected').attr("data-signup_url");
        $(".div_hide").hide();
        $(".div_"+sms_service_provider).show(300);
        if(signup_url){
            $(".show_text").html(' (<a target="_blank" href="'+signup_url+'">'+text_singup+' '+signup_url+'</a>)');
        }else{
            $(".show_text").html('');
        }

        if(sms_service_provider == '1'){
            // Twilo
        }else if(sms_service_provider == '2'){
            // Movisastra
        }else if(sms_service_provider == '3'){
            // Mim
        }else if(sms_service_provider == '4'){
            // Text Local
        }
    }
    smsShowHide();

    // Meta Image Crop Logic
    $(document).on('change', '#meta_img', async function() {
        $('#crop_image_modal').modal('show');
        $('#crop_result_meta').show();
        $('#crop_result_promo').hide();
        $('#crop_result_preloader').hide();
        $('#meta_img_container').show();
        $('#promotional_notice_img_container').hide();
        $('#crop_image_modal .modal-title').text('Meta Image');
        await new Promise(r => setTimeout(r, 500));
        let file = this.files[0];
        let reader = new FileReader();
        reader.onloadend = function () {
            $('#meta_img_container > img').show();
            let cropImg = $('#meta_img_container > img');
            if (cropImg.data('cropper')) {
                cropImg.cropper('replace', reader.result);
            } else {
                cropImg.cropper({
                    movable: true,
                    zoomable: true,
                    rotatable: false,
                    scalable: false,
                }).cropper('replace', reader.result);
            }
        };
        if (file) {
            reader.readAsDataURL(file);
        }
    });
    
    $(document).on('click', '#crop_result_meta', function() {
        let cropImg = $('#meta_img_container > img');
        let imgBlob = cropImg.cropper('getCroppedCanvas').toDataURL();
        $('#meta_img_2').val(imgBlob);
        $('#show_meta_id').attr('src', imgBlob);
        $('#crop_image_modal').modal('hide');
    });
    
    // Promotional Image Crop Logic
    $(document).on('change', '#promotional_notice_image', async function() {
        $('#crop_image_modal').modal('show');
        $('#crop_result_promo').show();
        $('#crop_result_meta').hide();
        $('#crop_result_preloader').hide();
        $('#promotional_notice_img_container').show();
        $('#meta_img_container').hide();
        $('#crop_image_modal .modal-title').text('Promotinal Image');
        await new Promise(r => setTimeout(r, 500));
        let file = this.files[0];
        let reader = new FileReader();
        reader.onloadend = function () {
            $('#promotional_notice_img_container > img').show();
            let cropImg = $('#promotional_notice_img_container > img');
            if (cropImg.data('cropper')) {
                cropImg.cropper('replace', reader.result);
            } else {
                cropImg.cropper({
                    movable: true,
                    zoomable: true,
                    rotatable: false,
                    scalable: false,
                }).cropper('replace', reader.result);
            }
        };
        if (file) {
            reader.readAsDataURL(file);
        }
    });
    
    $(document).on('click', '#crop_result_promo', function() {
        let cropImg = $('#promotional_notice_img_container > img');
        let imgBlob = cropImg.cropper('getCroppedCanvas').toDataURL();
        $('#promotional_notice_image_2').val(imgBlob);
        $('#show_promo_id').attr('src', imgBlob);
        $('#crop_image_modal').modal('hide');
    });

    
    
    // Close Modal Function
    function closeModal(modalId) {
        $('#' + modalId + '_modal').modal('hide');
    }

    $(document).on("click", ".show_preview", function (e) {
        e.preventDefault();
        let file_path = $(this).attr("data-file_path");
        $("#show_id").attr("src", file_path);
        $("#logo_preview").modal("show");
    });


});