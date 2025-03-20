<?php
$ln_dir = glob("application/language/*",GLOB_ONLYDIR);
$company = getCompanyInfo();
$sms_setting = isset($company->sms_details) && $company->sms_details?json_decode($company->sms_details):'';

if($ecommerce){
    if($ecommerce->social_link){
        $social_links = json_decode($ecommerce->social_link);
    }else{
        $social_links = '';
    }
    if($ecommerce->android_app_link){
        $android_app_link = json_decode($ecommerce->android_app_link);
    }else{
        $android_app_link = '';
    }
    if($ecommerce->smtp_email_setting){
        $smtp_setting = json_decode($ecommerce->smtp_email_setting);
    }else{
        $smtp_setting = '';
    }
    if($ecommerce->sms_setting){
        $sms_setting = json_decode($ecommerce->sms_setting);
    }else{
        $sms_setting = '';
    }
    if($ecommerce->seo_meta_contetn){
        $seo_meta = json_decode($ecommerce->seo_meta_contetn);
    }else{
        $seo_meta = '';
    }
    if($ecommerce->promotional_content){
        $promotional_content = json_decode($ecommerce->promotional_content);
    }else{
        $promotional_content = '';
    }
    if($ecommerce->preloader_content){
        $preloader = json_decode($ecommerce->preloader_content);
    }else{
        $preloader = '';
    }
    if($ecommerce->closable_notice){
        $closable_notice = json_decode($ecommerce->closable_notice);
    }else{
        $closable_notice = '';
    }
    if($ecommerce->homepage_content_show_hide){
        $homepage_content_show_hide = json_decode($ecommerce->homepage_content_show_hide);
    }else{
        $homepage_content_show_hide = '';
    }
    if($ecommerce->payment_getway_setting){
        $payment_getway = json_decode($ecommerce->payment_getway_setting);
    }else{
        $payment_getway = '';
    }
}
?>
<link rel="stylesheet" href="<?php echo base_url() ?>frequent_changing/eCommerce/css/eCommerce_setting.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/cropper/cropper.min.css">
<link rel="stylesheet" href="<?php echo base_url() ?>frequent_changing/css/checkBotton.css">


<div class="main-content-wrapper">
    <?php
    if ($this->session->flashdata('exception')) {
        echo '<section class="alert-wrapper"><div class="alert alert-success alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
        <div class="alert-body"><i class="icon fa fa-check me-2"></i>';
        echo escape_output($this->session->flashdata('exception'));unset($_SESSION['exception']);
        echo '</div></div></section>';
    }
    ?>
    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('e_commerce_setting'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('e_commerce_setting'), 'secondSection'=> lang('e_commerce_setting')])?>
        </div>
    </section>

    
    <div class="box-wrapper ecommerce_setting">
        <div class="table-box">
            <?php
            $attributes = array('id' => 'restaurant_setting_form');
            echo form_open_multipart(base_url('ECommerce_setting/eCommerceSetting/'.$this->custom->encrypt_decrypt($ecommerce->id, 'encrypt'))); ?>
            <div class="box-body">
                <h3 class="ecom_title_header"><?php echo lang('common_setting');?></h3>
                <hr>
                <div class="row">
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('default_language'); ?> <span class="required_star">*</span></label>
                            <select name="default_language" id="default_language" class="form-congrol select2">
                                <option value=""><?php echo lang('select')?></option>
                                    <?php
                                    foreach ($ln_dir as $value){
                                        $separete = explode("language/", $value);
                                        $selected = '';
                                        if(set_value('default_language')) {
                                            // If form validation failed, keep the submitted value
                                            if(set_value('default_language') == ucfirstcustom($separete[1])) {
                                                $selected = 'selected';
                                            }
                                        } else if(isset($ecommerce) && $ecommerce) {
                                            // Otherwise use the saved value from database
                                            if(ucfirstcustom($separete[1]) == $ecommerce->default_language) {
                                                $selected = 'selected';
                                            }
                                        }
                                    ?>
                                    <option <?php echo $selected?> value="<?php echo ucfirstcustom($separete[1]) ?>"><?php echo ucfirstcustom($separete[1]) ?></option>
                                    <?php } ?>
                            </select>
                        </div>
                        <?php if (form_error('default_language')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('default_language'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('available_language'); ?> <span class="required_star">*</span></label>
                            <select name="available_language[]" id="available_language" class="form-congrol select2" multiple data-placeholder="<?php echo lang('select'); ?>">
                                <?php
                                foreach ($ln_dir as $value){
                                    $separete = explode("language/", $value);
                                    $data = '';
                                    if(set_value('available_language')) {
                                        if(set_value('available_language') && is_array(set_value('available_language')) && in_array(ucfirstcustom($separete[1]), set_value('available_language'))) {
                                            $data = 'selected';
                                        }
                                    }
                                    else if($ecommerce->available_language){
                                        if(in_array(ucfirstcustom($separete[1]), explode(",",$ecommerce->available_language))){
                                            $data = 'selected';
                                        }
                                    }
                                ?>
                                <option value="<?php echo ucfirstcustom($separete[1]) ?>" <?php echo $data; ?>><?php echo ucfirstcustom($separete[1]) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <?php if (form_error('available_language')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('available_language'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('order_advance'); ?> <span class="required_star">*</span></label>
                            <select name="order_advance" id="order_advance" class="form-congrol select2">
                                <option value=""><?php echo lang('select');?></option>
                                <option <?php echo (set_value('order_advance') ? set_value('order_advance') == 'Full Payment' : $ecommerce->order_advance == 'Full Payment') ? 'selected' : '' ?> value="Full Payment"><?php echo lang('Full_Payment');?></option>
                                <option <?php echo (set_value('order_advance') ? set_value('order_advance') == 'Only Delivary' : $ecommerce->order_advance == 'Only Delivary') ? 'selected' : '' ?> value="Only Delivary"><?php echo lang('Only_Delivary');?></option>
                                <option <?php echo (set_value('order_advance') ? set_value('order_advance') == 'Delivary 50%' : $ecommerce->order_advance == 'Delivary 50%') ? 'selected' : '' ?> value="Delivary 50%"><?php echo lang('Delivary_half_amount');?></option>
                                <option <?php echo (set_value('order_advance') ? set_value('order_advance') == 'Total Due' : $ecommerce->order_advance == 'Total Due') ? 'selected' : '' ?> value="Total Due"><?php echo lang('Total_Due');?></option>
                                <option <?php echo (set_value('order_advance') ? set_value('order_advance') == 'Delivary Search' : $ecommerce->order_advance == 'Delivary Search') ? 'selected' : '' ?> value="Delivary Search"><?php echo lang('Delivary_Search');?></option>
                            </select>
                        </div>
                        <?php if (form_error('order_advance')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('order_advance'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('otp_on_signup'); ?> <span class="required_star">*</span></label>
                            <select name="otp_on_signup" id="otp_on_signup" class="form-congrol select2">
                                <option value=""><?php echo lang('select');?></option>
                                <option <?php echo (set_value('otp_on_signup') ? set_value('otp_on_signup') == 'Yes' : $ecommerce->otp_on_signup == 'Yes') ? 'selected' : '' ?> value="Yes"><?php echo lang('yes');?></option>
                                <option <?php echo (set_value('otp_on_signup') ? set_value('otp_on_signup') == 'No' : $ecommerce->otp_on_signup == 'No') ? 'selected' : '' ?> value="No"><?php echo lang('no');?></option>
                            </select>
                        </div>
                        <?php if (form_error('otp_on_signup')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('otp_on_signup'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('otp_on_login'); ?> <span class="required_star">*</span></label>
                            <select name="otp_on_login" id="otp_on_login" class="form-congrol select2">
                                <option value=""><?php echo lang('select');?></option>
                                <option <?php echo (set_value('otp_on_login') ? set_value('otp_on_login') == 'Yes' : $ecommerce->otp_on_login == 'Yes') ? 'selected' : '' ?> value="Yes"><?php echo lang('yes');?></option>
                                <option <?php echo (set_value('otp_on_login') ? set_value('otp_on_login') == 'No' : $ecommerce->otp_on_login == 'No') ? 'selected' : '' ?> value="No"><?php echo lang('no');?></option>
                            </select>
                        </div>
                        <?php if (form_error('otp_on_login')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('otp_on_login'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <h3 class="ecom_title_header pt-3"><?php echo lang('app_link');?></h3>
                <hr>
                <div class="row">
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('android_app_link'); ?> (<?php echo lang('ketp_it_blank');?>)</label>
                            <input  autocomplete="off" type="text" id="android_app_link" name="android_app_link"
                            class="form-control" placeholder="<?php echo lang('android_app_link'); ?>"
                            value="<?php echo isset($android_app_link->android_app_link) && $android_app_link->android_app_link ? ($android_app_link->android_app_link) : set_value('android_app_link')?>">
                        </div>
                        <?php if (form_error('android_app_link')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('android_app_link'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('ios_app_link'); ?> (<?php echo lang('ketp_it_blank');?>)</label>
                            <input  autocomplete="off" type="text" id="ios_app_link" name="ios_app_link"
                            class="form-control" placeholder="<?php echo lang('ios_app_link'); ?>"
                            value="<?php echo isset($android_app_link->ios_app_link) && $android_app_link->ios_app_link ? ($android_app_link->ios_app_link) : set_value('ios_app_link')?>">
                        </div>
                        <?php if (form_error('ios_app_link')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('ios_app_link'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <h3 class="ecom_title_header pt-3"><?php echo lang('social_link'); ?></h3>
                <hr>
                <div class="row">
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('facebook'); ?> (<?php echo lang('ketp_it_blank');?>)</label>
                            <input  autocomplete="off" type="text" id="facebook" name="facebook"
                            class="form-control" placeholder="<?php echo lang('facebook'); ?>"
                            value="<?php echo isset($social_links->facebook) && $social_links->facebook ? trim($social_links->facebook) : set_value('facebook')?>">
                        </div>
                        <?php if (form_error('facebook')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('facebook'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('instagram'); ?> (<?php echo lang('ketp_it_blank');?>)</label>
                            <input  autocomplete="off" type="text" id="instagram" name="instagram"
                            class="form-control" placeholder="<?php echo lang('instagram'); ?>"
                            value="<?php echo isset($social_links->instagram) && $social_links->instagram ? trim($social_links->instagram) : set_value('instagram')?>">
                        </div>
                        <?php if (form_error('instagram')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('instagram'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('twitter'); ?> (<?php echo lang('ketp_it_blank');?>)</label>
                            <input  autocomplete="off" type="text" id="twitter" name="twitter"
                            class="form-control" placeholder="<?php echo lang('twitter'); ?>"
                            value="<?php echo isset($social_links->twitter) && $social_links->twitter ? trim($social_links->twitter) : set_value('twitter');?>">
                        </div>
                        <?php if (form_error('twitter')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('twitter'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('tiktok'); ?> (<?php echo lang('ketp_it_blank');?>)</label>
                            <input  autocomplete="off" type="text" id="tiktok" name="tiktok"
                            class="form-control" placeholder="<?php echo lang('tiktok'); ?>"
                            value="<?php echo isset($social_links->tiktok) && $social_links->tiktok ? trim($social_links->tiktok) : set_value('tiktok');?>">
                        </div>
                        <?php if (form_error('tiktok')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('tiktok'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <h3 class="ecom_title_header pt-3"><?php echo lang('SMTP_Email_Setting');?></h3>
                <hr>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label><?php echo lang('email_service_type'); ?> <span class="required_star">*</span></label>
                            <select class="form-control select2 smtp_type" name="smtp_type">
                                <option value="Gmail" <?php echo (set_value('smtp_type') ? set_value('smtp_type') == 'Gmail' : (isset($smtp_setting->smtp_type) && escape_output($smtp_setting->smtp_type) == 'Gmail')) ? 'selected' : '' ?>><?php echo lang('Gmail'); ?></option>
                                <option value="Sendinblue" <?php echo (set_value('smtp_type') ? set_value('smtp_type') == 'Sendinblue' : (isset($smtp_setting->smtp_type) && escape_output($smtp_setting->smtp_type) == 'Sendinblue')) ? 'selected' : '' ?>><?php echo lang('Sendinblue'); ?></option>
                                <option value="SendGrid" <?php echo (set_value('smtp_type') ? set_value('smtp_type') == 'SendGrid' : (isset($smtp_setting->smtp_type) && escape_output($smtp_setting->smtp_type) == 'SendGrid')) ? 'selected' : '' ?>><?php echo lang('SendGrid'); ?></option>
                                <option value="Elastic Email" <?php echo (set_value('smtp_type') ? set_value('smtp_type') == 'Elastic Email' : (isset($smtp_setting->smtp_type) && escape_output($smtp_setting->smtp_type) == 'Elastic Email')) ? 'selected' : '' ?>><?php echo lang('Elastic_Email'); ?></option>
                            </select>
                        </div>
                        <?php if (form_error('smtp_type')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('smtp_type'); ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label><?php echo lang('SMTP_Host');?> <span class="required_star">*</span></label>
                            <input type="text" name="host_name" placeholder="<?php echo lang('SMTP_Host');?>"  value="<?php echo isset($smtp_setting->host_name) && $smtp_setting->host_name ? (APPLICATION_MODE == "demo" ? 'XXXXXXXXXXXXXXXXXXXX' : $smtp_setting->host_name) : set_value('host_name')?>" id="host_name" class="form-control">
                        </div>
                        <?php if (form_error('host_name')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('host_name'); ?></span>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label><?php echo lang('Port_Address');?> <span class="required_star">*</span></label>
                            <input type="text" name="port_address" value="<?php echo isset($smtp_setting->port_address) && $smtp_setting->port_address ?(APPLICATION_MODE == "demo" ? 'XXXXXXXXXXXXXXXXXXXX' : $smtp_setting->port_address) : set_value('port_address')?>"  placeholder="<?php echo lang('Port_Address');?>" id="port_address" class="form-control">
                        </div>
                        <?php if (form_error('port_address')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('port_address'); ?></span>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label><?php echo lang('encryption');?> <span class="required_star">*</span></label>
                            <input type="text" name="encryption" value="<?php echo isset($smtp_setting->encryption) && $smtp_setting->encryption ? (APPLICATION_MODE == "demo" ? 'XXXXXXXXXXXXXXXXXXXX' : $smtp_setting->encryption) : set_value('encryption')?>"  placeholder="<?php echo lang('encryption'); ?>" id="encryption" class="form-control">
                        </div>
                        <?php if (form_error('encryption')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('encryption'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="clearfix"></div>


                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label><?php echo lang('username');?> <span class="required_star">*</span></label>
                            <input type="text" name="user_name" value="<?php echo isset($smtp_setting->user_name) && $smtp_setting->user_name ? (APPLICATION_MODE == "demo" ? 'XXXXXXXXXXXXXXXXXXXX' : $smtp_setting->user_name) : set_value('user_name')?>" placeholder="<?php echo lang('username');?>" id="user_name" class="form-control">
                        </div>
                        <?php if (form_error('user_name')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('user_name'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label><?php echo lang('password');?> <span class="required_star">*</span></label>
                            <input type="text" name="password" value="<?php echo isset($smtp_setting->password) && $smtp_setting->password ? (APPLICATION_MODE == "demo" ? 'XXXXXXXXXXXXXXXXXXXX' : $smtp_setting->password) : set_value('password')?>" placeholder="<?php echo lang('password');?>" id="password" class="form-control">
                        </div>
                        <?php if (form_error('password')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('password'); ?></span>
                            </div>
                        <?php } ?>
                    </div>


                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label><?php echo lang('from_name');?> <span class="required_star">*</span></label>
                            <input type="text" name="from_name" value="<?php echo isset($smtp_setting->from_name) && $smtp_setting->from_name ? (APPLICATION_MODE == "demo" ? 'XXXXXXXXXXXXXXXXXXXX' : $smtp_setting->from_name) : set_value('from_name')?>" placeholder="<?php echo lang('from_name');?>" id="from_name" class="form-control">
                        </div>
                        <?php if (form_error('from_name')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('from_name'); ?></span>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label><?php echo lang('from_email');?> <span class="required_star">*</span></label>
                            <input type="email" name="from_email" value="<?php echo isset($smtp_setting->from_email) && $smtp_setting->from_email?(APPLICATION_MODE == "demo" ? 'XXXXXXXXXXXXXXXXXXXX' : $smtp_setting->from_email):set_value('from_email')?>" placeholder="<?php echo lang('from_email');?>" id="from_email" class="form-control">
                        </div>
                        <?php if (form_error('from_email')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('from_email'); ?></span>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="clearfix"></div>
                    <div class="col-md-12 sendinblue_part">
                        <div class="form-group mb-3">
                            <label><?php echo lang('api_key');?> <span class="required_star">*</span></label>
                            <input type="text" name="api_key" value="<?php echo isset($smtp_setting->api_key) && $smtp_setting->api_key ? (APPLICATION_MODE == "demo" ? 'XXXXXXXXXXXXXXXXXXXX' : $smtp_setting->api_key) : set_value('api_key')?>" placeholder="<?php echo lang('api_key');?>" id="api_key" class="form-control">
                        </div>
                        <?php if (form_error('api_key')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('api_key'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="clearfix"></div>

                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label><?php echo lang('status');?> <span class="required_star">*</span></label>
                            <select class="form-control select2 width_100_p" name="smtp_enable_status">
                                <option <?php echo isset($smtp_setting->smtp_enable_status) && $smtp_setting->smtp_enable_status == "Enable" ? 'selected' : ''?><?php echo set_select('smtp_enable_status', "Enable"); ?>  value="Enable"><?php echo lang('Enable'); ?></option>
                                <option  <?php echo isset($smtp_setting->smtp_enable_status) && $smtp_setting->smtp_enable_status == "Disable" ? 'selected' : ''?><?php echo set_select('smtp_enable_status', "Disable"); ?>   value="Disable"><?php echo lang('Disable'); ?></option>
                            </select>
                        </div>
                        <?php if (form_error('smtp_enable_status')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('smtp_enable_status'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                </div>


                <h3 class="ecom_title_header pt-3"><?php echo lang('sms_settings');?></h3>
                <hr>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label><?php echo lang('sms_service_provider')?> <span class="required_star">*</span><small class="show_text"></small></label>
                            <select name="sms_service_provider"  class="form-control select2 sms_service_provider">
                                <option value="" data-text_singup="" data-signup_url=""><?php echo lang('None')?></option>
                                <option <?php echo set_select('sms_service_provider',"1")?>  <?=(isset($sms_setting->sms_service_provider) && $sms_setting->sms_service_provider && $sms_setting->sms_service_provider=="1"?'selected':'')?> value="1" data-text_singup="<?php echo lang('gotothisurlforsignupaccount')?>" data-signup_url="<?php echo getSMSSignupUrl(1)?>"><?php echo lang('Twilio')?></option>
                                <option <?php echo set_select('sms_service_provider',"2")?>  <?=(isset($sms_setting->sms_service_provider) && $sms_setting->sms_service_provider && $sms_setting->sms_service_provider=="2"?'selected':'')?> value="2" data-text_singup="<?php echo lang('gotothisurlforsignupaccount')?>" data-signup_url="<?php echo getSMSSignupUrl(2)?>"><?php echo lang('Mobishastra')?></option>
                                <option <?php echo set_select('sms_service_provider',"3")?>  <?=(isset($sms_setting->sms_service_provider) && $sms_setting->sms_service_provider && $sms_setting->sms_service_provider=="3"?'selected':'')?> value="3" data-text_singup="<?php echo lang('gotothisurlforsignupaccount')?>" data-signup_url="<?php echo getSMSSignupUrl(3)?>"><?php echo lang('mim_sms')?></option>
                                <option <?php echo set_select('sms_service_provider',"4")?>  <?=(isset($sms_setting->sms_service_provider) && $sms_setting->sms_service_provider && $sms_setting->sms_service_provider=="4"?'selected':'')?> value="4" data-text_singup="<?php echo lang('gotothisurlforsignupaccount')?>" data-signup_url="<?php echo getSMSSignupUrl(4)?>"><?php echo lang('text_local')?></option>
                            </select>
                            <?php if (form_error('sms_service_provider')) { ?>
                                <div class="alert alert-error txt-uh-21">
                                    <p><?php echo form_error('sms_service_provider'); ?></p>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            
                <div  class="row div_hide div_1">
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label><?php echo lang('SID'); ?> <span class="required_star">*</span></label>
                            <input type="text" name="field_1_0" value="<?=(isset($sms_setting->field_1_0) && $sms_setting->field_1_0 ? (APPLICATION_MODE == "demo" ? 'XXXXXXXXXXXXXXXXXXXX' : $sms_setting->field_1_0) :set_value('field_1_0'))?>" onfocus="select();" placeholder="<?php echo lang('SID'); ?>" id="field_1_0" class="form-control">
                        </div>
                        <?php if (form_error('field_1_0')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('field_1_0'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label><?php echo lang('Token'); ?> <span class="required_star">*</span></label>
                            <input type="text" name="field_1_1" value="<?=(isset($sms_setting->field_1_1) && $sms_setting->field_1_1? (APPLICATION_MODE == "demo" ? 'XXXXXXXXXXXXXXXXXXXX' : $sms_setting->field_1_1) : set_value('field_1_1'))?>" onfocus="select();" placeholder="<?php echo lang('Token'); ?>" id="field_1_1" class="form-control">
                        </div>
                        <?php if (form_error('field_1_1')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('field_1_1'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label><?php echo lang('Twilio_Number'); ?> <span class="required_star">*</span></label>
                            <input type="text" name="field_1_2" value="<?=(isset($sms_setting->field_1_2) && $sms_setting->field_1_2 ? (APPLICATION_MODE == "demo" ? 'XXXXXXXXXXXXXXXXXXXX' : $sms_setting->field_1_2) : set_value('field_1_2'))?>" onfocus="select();" placeholder="<?php echo lang('Twilio_Number'); ?>" id="field_1_2" class="form-control">
                        </div>
                        <?php if (form_error('field_1_2')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('field_1_2'); ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div  class="row div_hide div_2">
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label><?php echo lang('profile_id'); ?> <span class="required_star">*</span></label>
                            <input type="text" name="field_2_0" value="<?=(isset($sms_setting->field_2_0) && $sms_setting->field_2_0 ? (APPLICATION_MODE == "demo" ? 'XXXXXXXXXXXXXXXXXXXX' : $sms_setting->field_2_0) : set_value('field_2_0'))?>" onfocus="select();" placeholder="<?php echo lang('profile_id'); ?>" id="field_2_0" class="form-control">
                        </div>
                        <?php if (form_error('field_2_0')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('field_2_0'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label><?php echo lang('password'); ?> <span class="required_star">*</span></label>
                            <input type="text" name="field_2_1" value="<?=(isset($sms_setting->field_2_1) && $sms_setting->field_2_1 ? (APPLICATION_MODE == "demo" ? 'XXXXXXXXXXXXXXXXXXXX' : $sms_setting->field_2_1) :set_value('field_2_1'))?>" onfocus="select();" placeholder="<?php echo lang('password'); ?>" id="field_2_1" class="form-control">
                        </div>
                        <?php if (form_error('field_2_1')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('field_2_1'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label><?php echo lang('sender_id'); ?> <span class="required_star">*</span></label>
                            <input type="text" name="field_2_2" value="<?=(isset($sms_setting->field_2_2) && $sms_setting->field_2_2 ? (APPLICATION_MODE == "demo" ? 'XXXXXXXXXXXXXXXXXXXX' : $sms_setting->field_2_2) : set_value('field_2_2'))?>" onfocus="select();" placeholder="<?php echo lang('sender_id'); ?>" id="field_2_2" class="form-control">
                        </div>
                        <?php if (form_error('field_2_2')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('field_2_2'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label><?php echo lang('country_code'); ?> <span class="required_star">*</span></label>
                                <select name="field_2_3" id="field_2_3" class="form-control select2">
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+93"?'selected':'')?> value="+93" data-select2-id="10">Afghanistan (+93)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+355"?'selected':'')?> value="+355" data-select2-id="11">Albania (+355)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+213"?'selected':'')?> value="+213" data-select2-id="12">Algeria (+213)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+376"?'selected':'')?> value="+376" data-select2-id="13">Andorra (+376)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+244"?'selected':'')?> value="+244" data-select2-id="14">Angola (+244)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+54"?'selected':'')?> value="+54" data-select2-id="15">Argentina (+54)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+374"?'selected':'')?> value="+374" data-select2-id="16">Armenia (+374)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+297"?'selected':'')?> value="+297" data-select2-id="17">Aruba (+297)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+61"?'selected':'')?> value="+61" data-select2-id="18">Australia (+61)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+43"?'selected':'')?> value="+43" data-select2-id="19">Austria (+43)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+994"?'selected':'')?> value="+994" data-select2-id="20">Azerbaijan (+994)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+973"?'selected':'')?> value="+973" data-select2-id="21">Bahrain (+973)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+880"?'selected':(isset($sms_setting->field_2_3)?'':'selected'))?> value="+880" data-select2-id="2">Bangladesh (+880)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+375"?'selected':'')?> value="+375" data-select2-id="22">Belarus (+375)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+32"?'selected':'')?> value="+32" data-select2-id="23">Belgium (+32)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+501"?'selected':'')?> value="+501" data-select2-id="24">Belize (+501)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+229"?'selected':'')?> value="+229" data-select2-id="25">Benin (+229)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+975"?'selected':'')?> value="+975" data-select2-id="26">Bhutan (+975)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+591"?'selected':'')?> value="+591" data-select2-id="27">Bolivia (+591)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+387"?'selected':'')?> value="+387" data-select2-id="28">Bosnia and Herzegovina (+387)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+267"?'selected':'')?> value="+267" data-select2-id="29">Botswana (+267)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+55"?'selected':'')?> value="+55" data-select2-id="30">Brazil (+55)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+673"?'selected':'')?> value="+673" data-select2-id="31">Brunei (+673)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+359"?'selected':'')?> value="+359" data-select2-id="32">Bulgaria (+359)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+226"?'selected':'')?> value="+226" data-select2-id="33">Burkina Faso (+226)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+257"?'selected':'')?> value="+257" data-select2-id="34">Burundi (+257)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+855"?'selected':'')?> value="+855" data-select2-id="35">Cambodia (+855)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+237"?'selected':'')?> value="+237" data-select2-id="36">Cameroon (+237)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+238"?'selected':'')?> value="+238" data-select2-id="37">Cape Verde (+238)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+236"?'selected':'')?> value="+236" data-select2-id="38">Central African Republic (+236)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+235"?'selected':'')?> value="+235" data-select2-id="39">Chad (+235)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+56"?'selected':'')?> value="+56" data-select2-id="40">Chile (+56)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+86"?'selected':'')?> value="+86" data-select2-id="41">China (+86)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+57"?'selected':'')?> value="+57" data-select2-id="42">Colombia (+57)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+269"?'selected':'')?> value="+269" data-select2-id="43">Comoros (+269)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+242"?'selected':'')?> value="+242" data-select2-id="44">Congo (+242)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+682"?'selected':'')?> value="+682" data-select2-id="45">Cook Islands (+682)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+506"?'selected':'')?> value="+506" data-select2-id="46">Costa Rica (+506)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+385"?'selected':'')?> value="+385" data-select2-id="47">Croatia (+385)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+53"?'selected':'')?> value="+53" data-select2-id="48">Cuba (+53)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+357"?'selected':'')?> value="+357" data-select2-id="49">Cyprus (+357)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+420"?'selected':'')?> value="+420" data-select2-id="50">Czech Republic (+420)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+243"?'selected':'')?> value="+243" data-select2-id="51">Democratic Republic of Congo (+243)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+45"?'selected':'')?> value="+45" data-select2-id="52">Denmark (+45)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+253"?'selected':'')?> value="+253" data-select2-id="53">Djibouti (+253)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+593"?'selected':'')?> value="+593" data-select2-id="54">Ecuador (+593)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+20"?'selected':'')?> value="+20" data-select2-id="55">Egypt (+20)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+503"?'selected':'')?> value="+503" data-select2-id="56">El Salvador (+503)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+240"?'selected':'')?> value="+240" data-select2-id="57">Equatorial Guinea (+240)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+372"?'selected':'')?> value="+372" data-select2-id="58">Estonia (+372)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+251"?'selected':'')?> value="+251" data-select2-id="59">Ethiopia (+251)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+500"?'selected':'')?> value="+500" data-select2-id="60">Falkland (Malvinas) Islands (+500)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+298"?'selected':'')?> value="+298" data-select2-id="61">Faroe Islands (+298)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+679"?'selected':'')?> value="+679" data-select2-id="62">Fiji (+679)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+358"?'selected':'')?> value="+358" data-select2-id="63">Finland (+358)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+33"?'selected':'')?> value="+33" data-select2-id="64">France (+33)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+594"?'selected':'')?> value="+594" data-select2-id="65">French Guiana (+594)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+241"?'selected':'')?> value="+241" data-select2-id="66">Gabon (+241)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+220"?'selected':'')?> value="+220" data-select2-id="67">Gambia (+220)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+995"?'selected':'')?> value="+995" data-select2-id="68">Georgia (+995)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+49"?'selected':'')?> value="+49" data-select2-id="69">Germany (+49)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+233"?'selected':'')?> value="+233" data-select2-id="70">Ghana (+233)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+350"?'selected':'')?> value="+350" data-select2-id="71">Gibraltar (+350)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+30"?'selected':'')?> value="+30" data-select2-id="72">Greece (+30)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+299"?'selected':'')?> value="+299" data-select2-id="73">Greenland (+299)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+590"?'selected':'')?> value="+590" data-select2-id="74">Guadeloupe (+590)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+502"?'selected':'')?> value="+502" data-select2-id="75">Guatemala (+502)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+224"?'selected':'')?> value="+224" data-select2-id="76">Guinea (+224)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+245"?'selected':'')?> value="+245" data-select2-id="77">Guinea-Bissau (+245)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+592"?'selected':'')?> value="+592" data-select2-id="78">Guyana (+592)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+509"?'selected':'')?> value="+509" data-select2-id="79">Haiti (+509)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+504"?'selected':'')?> value="+504" data-select2-id="80">Honduras (+504)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+852"?'selected':'')?> value="+852" data-select2-id="81">Hong Kong (+852)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+36"?'selected':'')?> value="+36" data-select2-id="82">Hungary (+36)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+354"?'selected':'')?> value="+354" data-select2-id="83">Iceland (+354)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+91"?'selected':'')?> value="+91" data-select2-id="84">India (+91)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+62"?'selected':'')?> value="+62" data-select2-id="85">Indonesia (+62)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+98"?'selected':'')?> value="+98" data-select2-id="86">Iran (+98)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+964"?'selected':'')?> value="+964" data-select2-id="87">Iraq (+964)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+353"?'selected':'')?> value="+353" data-select2-id="88">Ireland (+353)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+972"?'selected':'')?> value="+972" data-select2-id="89">Israel (+972)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+39"?'selected':'')?> value="+39" data-select2-id="90">Italy (+39)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+225"?'selected':'')?> value="+225" data-select2-id="91">Ivory Coast (+225)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+81"?'selected':'')?> value="+81" data-select2-id="92">Japan (+81)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+962"?'selected':'')?> value="+962" data-select2-id="93">Jordan (+962)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+254"?'selected':'')?> value="+254" data-select2-id="94">Kenya (+254)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+686"?'selected':'')?> value="+686" data-select2-id="95">Kiribati (+686)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+965"?'selected':'')?> value="+965" data-select2-id="96">Kuwait (+965)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+996"?'selected':'')?> value="+996" data-select2-id="97">Kyrgyzstan (+996)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+856"?'selected':'')?> value="+856" data-select2-id="98">Laos (+856)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+371"?'selected':'')?> value="+371" data-select2-id="99">Latvia (+371)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+961"?'selected':'')?> value="+961" data-select2-id="100">Lebanon (+961)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+266"?'selected':'')?> value="+266" data-select2-id="101">Lesotho (+266)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+231"?'selected':'')?> value="+231" data-select2-id="102">Liberia (+231)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+218"?'selected':'')?> value="+218" data-select2-id="103">Libya (+218)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+423"?'selected':'')?> value="+423" data-select2-id="104">Liechtenstein (+423)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+370"?'selected':'')?> value="+370" data-select2-id="105">Lithuania (+370)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+352"?'selected':'')?> value="+352" data-select2-id="106">Luxembourg (+352)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+853"?'selected':'')?> value="+853" data-select2-id="107">Macau (+853)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+389"?'selected':'')?> value="+389" data-select2-id="108">Macedonia (+389)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+261"?'selected':'')?> value="+261" data-select2-id="109">Madagascar (+261)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+265"?'selected':'')?> value="+265" data-select2-id="110">Malawi (+265)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+60"?'selected':'')?> value="+60" data-select2-id="111">Malaysia (+60)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+960"?'selected':'')?> value="+960" data-select2-id="112">Maldives (+960)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+223"?'selected':'')?> value="+223" data-select2-id="113">Mali (+223)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+356"?'selected':'')?> value="+356" data-select2-id="114">Malta (+356)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+596"?'selected':'')?> value="+596" data-select2-id="115">Martinique (+596)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+222"?'selected':'')?> value="+222" data-select2-id="116">Mauritania (+222)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+230"?'selected':'')?> value="+230" data-select2-id="117">Mauritius (+230)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+52"?'selected':'')?> value="+52" data-select2-id="118">Mexico (+52)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+373"?'selected':'')?> value="+373" data-select2-id="119">Moldova (+373)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+377"?'selected':'')?> value="+377" data-select2-id="120">Monaco (+377)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+976"?'selected':'')?> value="+976" data-select2-id="121">Mongolia (+976)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+382"?'selected':'')?> value="+382" data-select2-id="122">Montenegro (+382)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+212"?'selected':'')?> value="+212" data-select2-id="123">Morocco (+212)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+258"?'selected':'')?> value="+258" data-select2-id="124">Mozambique (+258)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+95"?'selected':'')?> value="+95" data-select2-id="125">Myanmar (+95)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+264"?'selected':'')?> value="+264" data-select2-id="126">Namibia (+264)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+977"?'selected':'')?> value="+977" data-select2-id="127">Nepal (+977)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+31"?'selected':'')?> value="+31" data-select2-id="128">Netherlands (+31)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+599"?'selected':'')?> value="+599" data-select2-id="129">Netherlands Antilles (+599)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+64"?'selected':'')?> value="+64" data-select2-id="130">New Zealand (+64)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+505"?'selected':'')?> value="+505" data-select2-id="131">Nicaragua (+505)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+227"?'selected':'')?> value="+227" data-select2-id="132">Niger (+227)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+234"?'selected':'')?> value="+234" data-select2-id="133">Nigeria (+234)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+47"?'selected':'')?> value="+47" data-select2-id="134">Norway (+47)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+968"?'selected':'')?> value="+968" data-select2-id="135">Oman (+968)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+92"?'selected':'')?> value="+92" data-select2-id="136">Pakistan (+92)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+680"?'selected':'')?> value="+680" data-select2-id="137">Palau (+680)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+970"?'selected':'')?> value="+970" data-select2-id="138">Palestine (+970)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+507"?'selected':'')?> value="+507" data-select2-id="139">Panama (+507)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+675"?'selected':'')?> value="+675" data-select2-id="140">Papua New Guinea (+675)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+595"?'selected':'')?> value="+595" data-select2-id="141">Paraguay (+595)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+51"?'selected':'')?> value="+51" data-select2-id="142">Peru (+51)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+63"?'selected':'')?> value="+63" data-select2-id="143">Philippines (+63)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+48"?'selected':'')?> value="+48" data-select2-id="144">Poland (+48)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+351"?'selected':'')?> value="+351" data-select2-id="145">Portugal (+351)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+974"?'selected':'')?> value="+974" data-select2-id="146">Qatar (+974)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+262"?'selected':'')?> value="+262" data-select2-id="147">Reunion (+262)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+40"?'selected':'')?> value="+40" data-select2-id="148">Romania (+40)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+7"?'selected':'')?> value="+7" data-select2-id="149">Russian Federation (+7)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+250"?'selected':'')?> value="+250" data-select2-id="150">Rwanda (+250)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+685"?'selected':'')?> value="+685" data-select2-id="151">Samoa (+685)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+378"?'selected':'')?> value="+378" data-select2-id="152">San Marino (+378)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+239"?'selected':'')?> value="+239" data-select2-id="153">Sao Tome and Principe (+239)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+966"?'selected':'')?> value="+966" data-select2-id="154">Saudi Arabia (+966)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+221"?'selected':'')?> value="+221" data-select2-id="155">Senegal (+221)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+381"?'selected':'')?> value="+381" data-select2-id="156">Serbia (+381)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+248"?'selected':'')?> value="+248" data-select2-id="157">Seychelles (+248)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+232"?'selected':'')?> value="+232" data-select2-id="158">Sierra Leone (+232)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+65"?'selected':'')?> value="+65" data-select2-id="159">Singapore (+65)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+421"?'selected':'')?> value="+421" data-select2-id="160">Slovakia (+421)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+386"?'selected':'')?> value="+386" data-select2-id="161">Slovenia (+386)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+677"?'selected':'')?> value="+677" data-select2-id="162">Solomon Islands (+677)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+252"?'selected':'')?> value="+252" data-select2-id="163">Somalia (+252)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+27"?'selected':'')?> value="+27" data-select2-id="164">South Africa (+27)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+82"?'selected':'')?> value="+82" data-select2-id="165">South Korea (+82)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+211"?'selected':'')?> value="+211" data-select2-id="166">South Sudan (+211)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+34"?'selected':'')?> value="+34" data-select2-id="167">Spain (+34)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+94"?'selected':'')?> value="+94" data-select2-id="168">Sri Lanka (+94)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+249"?'selected':'')?> value="+249" data-select2-id="169">Sudan (+249)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+597"?'selected':'')?> value="+597" data-select2-id="170">Suriname (+597)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+268"?'selected':'')?> value="+268" data-select2-id="171">Swaziland (+268)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+46"?'selected':'')?> value="+46" data-select2-id="172">Sweden (+46)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+41"?'selected':'')?> value="+41" data-select2-id="173">Switzerland (+41)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+963"?'selected':'')?> value="+963" data-select2-id="174">Syria (+963)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+886"?'selected':'')?> value="+886" data-select2-id="175">Taiwan (+886)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+992"?'selected':'')?> value="+992" data-select2-id="176">Tajikistan (+992)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+255"?'selected':'')?> value="+255" data-select2-id="177">Tanzania (+255)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+66"?'selected':'')?> value="+66" data-select2-id="178">Thailand (+66)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+228"?'selected':'')?> value="+228" data-select2-id="179">Togo (+228)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+676"?'selected':'')?> value="+676" data-select2-id="180">Tonga (+676)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+216"?'selected':'')?> value="+216" data-select2-id="181">Tunisia (+216)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+90"?'selected':'')?> value="+90" data-select2-id="182">Turkey (+90)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+993"?'selected':'')?> value="+993" data-select2-id="183">Turkmenistan (+993)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+256"?'selected':'')?> value="+256" data-select2-id="184">Uganda (+256)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+380"?'selected':'')?> value="+380" data-select2-id="185">Ukraine (+380)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+971"?'selected':'')?> value="+971" data-select2-id="186">United Arab Emirates (+971)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+44"?'selected':'')?> value="+44" data-select2-id="187">United Kingdom (+44)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+1"?'selected':'')?> value="+1" data-select2-id="188">United States of America (+1)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+598"?'selected':'')?> value="+598" data-select2-id="189">Uruguay (+598)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+998"?'selected':'')?> value="+998" data-select2-id="190">Uzbekistan (+998)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+678"?'selected':'')?> value="+678" data-select2-id="191">Vanuatu (+678)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+58"?'selected':'')?> value="+58" data-select2-id="192">Venezuela (+58)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+84"?'selected':'')?> value="+84" data-select2-id="193">Vietnam (+84)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+967"?'selected':'')?> value="+967" data-select2-id="194">Yemen (+967)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+260"?'selected':'')?> value="+260" data-select2-id="195">Zambia (+260)</option>
                                    <option <?=(isset($sms_setting->field_2_3) && $sms_setting->field_2_3 && $sms_setting->field_2_3=="+263"?'selected':'')?> value="+263" data-select2-id="196">Zimbabwe (+263)</option>
                            </select>
                        </div>
                        <?php if (form_error('field_2_3')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('field_2_3'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    
                </div>
                <div  class="row div_hide div_3">
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label><?php echo lang('api_key'); ?> <span class="required_star">*</span></label>
                            <input type="text" name="field_3_1" value="<?=(isset($sms_setting->field_3_1) && $sms_setting->field_3_1? (APPLICATION_MODE == "demo" ? 'XXXXXXXXXXXXXXXXXXXX' : $sms_setting->field_3_1) : set_value('field_3_1'))?>" onfocus="select();" placeholder="<?php echo lang('api_key'); ?>" id="field_3_1" class="form-control">
                        </div>
                        <?php if (form_error('field_3_1')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('field_3_1'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label><?php echo lang('sender_id'); ?> <span class="required_star">*</span></label>
                            <input type="text" name="field_3_2" value="<?=(isset($sms_setting->field_3_2) && $sms_setting->field_3_2 ? (APPLICATION_MODE == "demo" ? 'XXXXXXXXXXXXXXXXXXXX' : $sms_setting->field_3_2) : set_value('field_3_2'))?>" onfocus="select();" placeholder="<?php echo lang('sender_id'); ?>" id="field_3_2" class="form-control">
                        </div>
                        <?php if (form_error('field_3_2')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('field_3_2'); ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div  class="row div_hide div_4">
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label><?php echo lang('profile_id'); ?> <span class="required_star">*</span></label>
                            <input type="text" name="field_4_0" value="<?=(isset($sms_setting->field_4_0) && $sms_setting->field_4_0 ? (APPLICATION_MODE == "demo" ? 'XXXXXXXXXXXXXXXXXXXX' : $sms_setting->field_4_0) : set_value('field_4_0'))?>" onfocus="select();" placeholder="<?php echo lang('profile_id'); ?>" id="field_4_0" class="form-control">
                        </div>
                        <?php if (form_error('field_4_0')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('field_4_0'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label><?php echo lang('api_key'); ?> <span class="required_star">*</span></label>
                            <input type="text" name="field_4_1" value="<?=(isset($sms_setting->field_4_1) && $sms_setting->field_4_1 ? (APPLICATION_MODE == "demo" ? 'XXXXXXXXXXXXXXXXXXXX' : $sms_setting->field_4_1) : set_value('field_4_1'))?>" onfocus="select();" placeholder="<?php echo lang('api_key'); ?>" id="field_4_1" class="form-control">
                        </div>
                        <?php if (form_error('field_4_1')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('field_4_1'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label><?php echo lang('sender_id'); ?> <span class="required_star">*</span></label>
                            <input type="text" name="field_4_2" value="<?=(isset($sms_setting->field_4_2) && $sms_setting->field_4_2 ? (APPLICATION_MODE == "demo" ? 'XXXXXXXXXXXXXXXXXXXX' : $sms_setting->field_4_2) : set_value('field_4_2'))?>" onfocus="select();" placeholder="<?php echo lang('sender_id'); ?>" id="field_4_2" class="form-control">
                        </div>
                        <?php if (form_error('field_4_2')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('field_4_2'); ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>


                <h3 class="ecom_title_header pt-3"><?php echo lang('SEO_Meta_Setting');?></h3>
                <hr>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label><?php echo lang('meta_author'); ?></label>
                            <input type="text" name="meta_author" placeholder="<?php echo lang('meta_author'); ?>"  value="<?php echo isset($seo_meta->meta_author) && $seo_meta->meta_author ? $seo_meta->meta_author : set_value('meta_author')?>" id="meta_author" class="form-control">
                        </div>
                        <?php if (form_error('meta_author')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('meta_author'); ?></span>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label><?php echo lang('meta_description'); ?></label>
                            <input type="text" name="meta_description" value="<?php echo isset($seo_meta->meta_description) && $seo_meta->meta_description ? $seo_meta->meta_description : set_value('meta_description')?>"  placeholder="<?php echo lang('meta_description'); ?>" id="meta_description" class="form-control">
                        </div>
                        <?php if (form_error('meta_description')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('meta_description'); ?></span>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label><?php echo lang('meta_keywords');?></label>
                            <input type="text" name="meta_keywords" value="<?php echo isset($seo_meta->meta_keywords) && $seo_meta->meta_keywords ? $seo_meta->meta_keywords : set_value('meta_keywords')?>"  placeholder="<?php echo lang('meta_keywords');?>" id="meta_keywords" class="form-control">
                        </div>
                        <?php if (form_error('meta_keywords')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('meta_keywords'); ?></span>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label><?php echo lang('meta_og_type');?></label>
                            <input type="text" name="meta_og_type" value="<?php echo isset($seo_meta->meta_og_type) && $seo_meta->meta_og_type ? $seo_meta->meta_og_type : set_value('meta_og_type')?>" placeholder="<?php echo lang('meta_og_type');?>" id="meta_og_type" class="form-control">
                        </div>
                        <?php if (form_error('meta_og_type')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('meta_og_type'); ?></span>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label><?php echo lang('meta_og_title');?></label>
                            <input type="text" name="meta_og_title" value="<?php echo isset($seo_meta->meta_og_title) && $seo_meta->meta_og_title ? $seo_meta->meta_og_title : set_value('meta_og_title')?>" placeholder="<?php echo lang('meta_og_title');?>" id="meta_og_title" class="form-control">
                        </div>
                        <?php if (form_error('meta_og_title')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('meta_og_title'); ?></span>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label><?php echo lang('meta_og_site_name');?></label>
                            <input type="text" name="meta_og_site_name" value="<?php echo isset($seo_meta->meta_og_site_name) && $seo_meta->meta_og_site_name ? $seo_meta->meta_og_site_name : set_value('meta_og_site_name')?>" placeholder="<?php echo lang('meta_og_site_name');?>" id="meta_og_site_name" class="form-control">
                        </div>
                        <?php if (form_error('meta_og_site_name')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('meta_og_site_name'); ?></span>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="form-label-action">
                                <label><?php echo lang('meta_img'); ?> <span class="required_star">(Max 1 MB, Type: jpeg/gif/png)</span></label>
                            </div>
                            <div class="d-flex">
                                <input  type="file" name="meta_img" class="form-control m-0" id="meta_img">
                                <input type="hidden" name="meta_img_2" id="meta_img_2">
                                <?php
                                    $logoPath = !empty($seo_meta->meta_img) ? base_url().'uploads/eCommerce/seo_meta/'.$seo_meta->meta_img : '';
                                ?>
                                <a href="javascript:void(0)" data-file_path="<?php echo escape_output($logoPath)?>" data-id="1" class="new-btn ms-2 show_preview">
                                    <iconify-icon icon="solar:eye-bold-duotone" width="18"></iconify-icon>
                                </a>
                            </div>
                            <input  type="hidden" name="meta_img_p" class="form-control" value="<?= isset($seo_meta->meta_img) && $seo_meta->meta_img ? $seo_meta->meta_img : '' ?>">
                        </div>
                        <?php if (form_error('meta_img')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('meta_img'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <h3 class="ecom_title_header pt-3"><?php echo lang('payment_getway_setting');?></h3>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <h5><?php echo lang('Strip');?></h5>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <label> <?php echo lang('status'); ?> <span
                            class="required_star">*</span></label>
                            <select  class="form-control select2" name="action_type_stripe" id="action_type_stripe">
                                <?php if(isset($payment_getway) && $payment_getway){?>
                                    <option value=""><?php echo lang('select'); ?> <?php echo lang('status'); ?></option>
                                    <option <?php echo (isset($payment_getway->action_type_stripe) && escape_output($payment_getway->action_type_stripe) == 'Enable') || set_select('action_type_stripe', 'Enable') ? 'selected' : '';?> value="Enable"><?php echo lang('Enable'); ?></option>
                                    <option <?php echo (isset($payment_getway->action_type_stripe) && escape_output($payment_getway->action_type_stripe) == 'Disable') || set_select('action_type_stripe', 'Disable') ? 'selected' : '';?> value="Disable"><?php echo lang('Disable'); ?></option>
                                <?php } else{ ?>
                                    <option value=""><?php echo lang('select'); ?> <?php echo lang('status'); ?></option>
                                    <option <?php echo set_select('action_type_stripe', 'Enable'); ?> value="Enable"><?php echo lang('Enable'); ?></option>
                                    <option <?php echo set_select('action_type_stripe', 'Disable'); ?> value="Disable"><?php echo lang('Disable'); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <?php if (form_error('action_type_stripe')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('action_type_stripe'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="clear-fix"></div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label> <?php echo lang('Stripe_Secret_Key'); ?> <span
                            class="required_star">*</span></label>
                            <input type="text" class="form-control" name="stripe_api_key" id="stripe_api_key" placeholder="<?php echo lang('Stripe_Secret_Key'); ?>" value="<?php echo escape_output(APPLICATION_MODE == "demo" ? 'XXXXXXXXXXXXXXXXXXXX' : (isset($payment_getway->stripe_api_key) && $payment_getway->stripe_api_key ? $payment_getway->stripe_api_key : (set_value('stripe_api_key') ? set_value('stripe_api_key') : '')));?>">
                        </div>
                        <?php if (form_error('stripe_api_key')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('stripe_api_key'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label> <?php echo lang('Stripe_Publishable_Key'); ?> <span
                            class="required_star">*</span></label>
                            <input type="text" class="form-control" name="stripe_publishable_key" id="stripe_publishable_key" placeholder="<?php echo lang('Stripe_Publishable_Key'); ?>" value="<?php echo escape_output(APPLICATION_MODE == "demo" ? 'XXXXXXXXXXXXXXXXXXXX' : (isset($payment_getway->stripe_publishable_key) && $payment_getway->stripe_publishable_key ? $payment_getway->stripe_publishable_key : (set_value('stripe_publishable_key') ? set_value('stripe_publishable_key') : '')));?>">
                        </div>
                        <?php if (form_error('stripe_publishable_key')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('stripe_publishable_key'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <h5><?php echo lang('Paypal'); ?></h5>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <label> <?php echo lang('status'); ?> <span
                            class="required_star">*</span></label>
                            <select  class="form-control select2" name="action_type_paypal" id="action_type_paypal">
                                <?php if(isset($payment_getway) && $payment_getway){?>
                                    <option value=""><?php echo lang('select'); ?> <?php echo lang('status'); ?></option>
                                    <option <?php echo set_select('action_type_paypal', 'Enable', (isset($payment_getway->action_type_paypal) && $payment_getway->action_type_paypal == 'Enable')); ?> value="Enable"><?php echo lang('Enable'); ?></option>
                                    <option <?php echo set_select('action_type_paypal', 'Disable', (isset($payment_getway->action_type_paypal) && $payment_getway->action_type_paypal == 'Disable')); ?> value="Disable"><?php echo lang('Disable'); ?></option>
                                <?php } else{ ?>
                                    <option value=""><?php echo lang('select'); ?> <?php echo lang('status'); ?></option>
                                    <option <?php echo set_select('action_type_stripe', 'Enable'); ?> value="Enable"><?php echo lang('Enable'); ?></option>
                                    <option <?php echo set_select('action_type_stripe', 'Disable'); ?> value="Disable"><?php echo lang('Disable'); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <?php if (form_error('action_type_paypal')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('action_type_paypal'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="clear-fix"></div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label> <?php echo lang('paypal_user_name'); ?> <span
                            class="required_star">*</span></label>
                            <input type="text" class="form-control" name="paypal_user_name" placeholder="<?php echo lang('paypal_user_name'); ?>" value="<?php echo escape_output(APPLICATION_MODE == "demo" ? 'XXXXXXXXXXXXXXXXXXXX' : (isset($payment_getway->paypal_user_name) && $payment_getway->paypal_user_name ? $payment_getway->paypal_user_name : set_value('paypal_user_name')));?>">
                        </div>
                        <?php if (form_error('paypal_user_name')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('paypal_user_name'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label> <?php echo lang('paypal_password'); ?> <span
                            class="required_star">*</span></label>
                            <input type="text" class="form-control" name="paypal_password" placeholder="<?php echo lang('paypal_password'); ?>" value="<?php echo escape_output(APPLICATION_MODE == "demo" ? 'XXXXXXXXXXXXXXXXXXXX' : (isset($payment_getway->paypal_password) && $payment_getway->paypal_password ? $payment_getway->paypal_password : set_value('paypal_password')));?>">
                        </div>
                        <?php if (form_error('paypal_password')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('paypal_password'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label> <?php echo lang('paypal_signature'); ?> <span
                            class="required_star">*</span></label>
                            <input type="text" class="form-control" name="paypal_signature" placeholder="<?php echo lang('paypal_signature'); ?>" value="<?php echo escape_output(APPLICATION_MODE == "demo" ? 'XXXXXXXXXXXXXXXXXXXX' : (isset($payment_getway->paypal_signature) && $payment_getway->paypal_signature ? $payment_getway->paypal_signature : set_value('paypal_signature')));?>">
                        </div>
                        <?php if (form_error('paypal_signature')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('paypal_signature'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                
                <h3 class="ecom_title_header pt-3"><?php echo lang('Closable_Notice_Setting');?></h3>
                <hr>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label><?php echo lang('closable_notice_status');?> <span class="required_star">*</span></label>
                            <select name="closable_notice_status" id="closable_notice_status" class="form-control select2">
                                <option <?php echo isset($closable_notice->closable_notice_status) && $closable_notice->closable_notice_status ? ($closable_notice->closable_notice_status == 'Enable' ? 'selected' : '') : set_select('closable_notice_status', 'Enable') ?>  value="Enable"><?php echo lang('Enable')?></option>
                                <option <?php echo isset($closable_notice->closable_notice_status) && $closable_notice->closable_notice_status ? ($closable_notice->closable_notice_status == 'Disable' ? 'selected' : '') : set_select('closable_notice_status', 'Disable') ?> value="Disable"><?php echo lang('Disable')?></option>
                            </select>
                        </div>
                        <?php if (form_error('closable_notice_status')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('closable_notice_status'); ?></span>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label><?php echo lang('closable_notice_text');?></label>
                            <textarea type="text" name="closable_notice_text"  placeholder="<?php echo lang('closable_notice_text'); ?>" id="closable_notice_text" class="form-control"><?php echo isset($closable_notice->closable_notice_text) && $closable_notice->closable_notice_text ? $closable_notice->closable_notice_text : set_value('closable_notice_text')?></textarea>
                        </div>
                        <?php if (form_error('closable_notice_text')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('closable_notice_text'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <h3 class="ecom_title_header pt-3"><?php echo lang('Promotional_Product_Setting');?></h3>
                <hr>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label><?php echo lang('promotional_notice_status');?> <span class="required_star">*</span></label>
                            <select name="promotional_notice_status" id="promotional_notice_status" class="form-control select2">
                                <option <?php echo isset($promotional_content->promotional_notice_status) && $promotional_content->promotional_notice_status == 'Enable' ? 'selected' : '' ?> value="Enable"><?php echo lang('Enable')?></option>
                                <option <?php echo isset($promotional_content->promotional_notice_status) && $promotional_content->promotional_notice_status == 'Disable' ? 'selected' : '' ?> value="Disable"><?php echo lang('Disable')?></option>
                            </select>
                        </div>
                        <?php if (form_error('promotional_notice_status')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('promotional_notice_status'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                

                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="form-label-action">
                                <label><?php echo lang('promotional_notice_image'); ?> <span class="required_star">(Max 1 MB, Type: jpeg/gif/png)</span></label>
                            </div>
                            <div class="d-flex">
                                <input  type="file" name="promotional_notice_image" class="form-control m-0" id="promotional_notice_image">
                                <input type="hidden" name="promotional_notice_image_2" id="promotional_notice_image_2">
                                <?php
                                    $logoPath2 = !empty($promotional_content->promotional_notice_image) ? base_url().'uploads/eCommerce/promotional_content/'.$promotional_content->promotional_notice_image : '';
                                ?>
                                <a href="javascript:void(0)" data-file_path="<?php echo escape_output($logoPath2)?>" data-id="1" class="new-btn ms-2 show_preview">
                                    <iconify-icon icon="solar:eye-bold-duotone" width="18"></iconify-icon>
                                </a>
                            </div>
                            <input  type="hidden" name="promotional_notice_image_p" class="form-control" value="<?= isset($promotional_content->promotional_notice_image) && $promotional_content->promotional_notice_image ? $promotional_content->promotional_notice_image : '' ?>">
                        </div>
                        <?php if (form_error('promotional_notice_image')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('promotional_notice_image'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <h3 class="ecom_title_header pt-3"><?php echo lang('preloader_setting');?></h3>
                <hr>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label><?php echo lang('preloader_status');?> <span class="required_star">*</span></label>
                            <select name="preloader_status" id="preloader_status" class="form-control select2">
                                <option <?php echo isset($preloader->preloader_status) && $preloader->preloader_status == 'Enable' ? 'selected' : '' ?> value="Enable"><?php echo lang('Enable')?></option>
                                <option <?php echo isset($preloader->preloader_status) && $preloader->preloader_status == 'Disable' ? 'selected' : '' ?> value="Disable"><?php echo lang('Disable')?></option>
                            </select>
                        </div>
                        <?php if (form_error('preloader_status')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('preloader_status'); ?></span>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="form-group">
                            <div class="form-label-action">
                                <?php
                                    $logoPath2 = !empty($preloader->preloader_image) ? base_url().'uploads/eCommerce/preloader_image/'.$preloader->preloader_image : '';
                                ?>
                                <input  type="hidden" name="preloader_image_p" class="form-control" value="<?= isset($preloader->preloader_image) && $preloader->preloader_image ? $preloader->preloader_image : '' ?>">
                                <label><?php echo lang('preloader_image'); ?> <span class="required_star">(Max 1 MB, Type: jpeg/gif/png)</span></label>
                            </div>
                            <div class="d-flex">
                                <input type="file" accept="image/*" name="preloader_image" class="form-control">
                                <div class="ps-2">
                                    <a data-file_path="<?php echo $logoPath2;?>"  data-id="1" class="new-btn h-40  show_preview" href="javascript:void(0)"><iconify-icon icon="solar:eye-bold-duotone" width="18"></iconify-icon></a>
                                </div>
                            </div>
                        </div>
                        <?php if (form_error('preloader_image')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('preloader_image'); ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <h3 class="ecom_title_header pt-3"><?php echo lang('home_page_content_show_hide');?></h3>
                <hr>
                <div class="col-12 mb-3">
                    <div class="form-group radio_button_problem">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="top_category" value="Top Category" name="top_category" <?php echo isset($homepage_content_show_hide->top_category) && $homepage_content_show_hide->top_category == 'Top Category' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="top_category">Top Category</label>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="flash_sale" value="Flash Sale" name="flash_sale" <?php echo isset($homepage_content_show_hide->flash_sale) && $homepage_content_show_hide->flash_sale == 'Flash Sale' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="flash_sale">Flash Sale</label>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="best_selling" value="Best Selling" name="best_selling" <?php echo isset($homepage_content_show_hide->best_selling) && $homepage_content_show_hide->best_selling == 'Best Selling' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="best_selling">Best Selling</label>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="offer_product" value="Offer Product" name="offer_product" <?php echo isset($homepage_content_show_hide->offer_product) && $homepage_content_show_hide->offer_product == 'Offer Product' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="offer_product">Offer Product</label>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="latest_best_top" value="Latest Best Top" name="latest_best_top" <?php echo isset($homepage_content_show_hide->latest_best_top) && $homepage_content_show_hide->latest_best_top == 'Latest Best Top' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="latest_best_top">Latest/Best/Top</label>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="ratting" value="Ratting" name="ratting" <?php echo isset($homepage_content_show_hide->ratting) && $homepage_content_show_hide->ratting == 'Ratting' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="ratting">Ratting</label>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mt-3">
                            <label>Product Search Option <span class="required_star">*</span></label>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="product_name_only" value="Product Name Only" name="product_search_display_option" <?php echo isset($homepage_content_show_hide->product_search_display_option) && $homepage_content_show_hide->product_search_display_option == 'Product Name Only' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="product_name_only">Only Product Name</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="product_name_image" value="Product Name with Image" name="product_search_display_option" <?php echo isset($homepage_content_show_hide->product_search_display_option) && $homepage_content_show_hide->product_search_display_option == 'Product Name with Image' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="product_name_image">Product Name with Image</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <h3 class="ecom_title_header pt-3"><?php echo lang('footer_description');?></h3>
                <hr>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label><?php echo lang('footer_description');?></label>
                            <textarea type="text" name="footer_description"  placeholder="<?php echo lang('footer_description'); ?>" id="footer_description" class="form-control"><?php echo isset($ecommerce->footer_description) && $ecommerce->footer_description ? $ecommerce->footer_description : set_value('footer_description')?></textarea>
                        </div>
                        <?php if (form_error('footer_description')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('footer_description'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                </div>


                <h3 class="ecom_title_header pt-3"><?php echo lang('short_cut_link');?></h3>
                <hr>
                <div class="row">
                    <div class="col-md-3">
                        <a href="<?php echo base_url();?>ECommerce_setting/listArea" target="_blank" class="btn bg-blue-btn w-100"><?php echo lang('area');?></a>
                    </div>
                    <div class="col-md-3">
                        <a href="<?php echo base_url();?>ECommerce_setting/listBanner" target="_blank" class="btn bg-blue-btn w-100"><?php echo lang('hero_banner');?></a>
                    </div>
                    <div class="col-md-3">
                        <a href="<?php echo base_url();?>Delivery_partner/listPartner" target="_blank" class="btn bg-blue-btn w-100"><?php echo lang('delivary_partner');?></a>
                    </div>
                    <div class="col-md-3">
                        <a href="<?php echo base_url();?>ECommerce_setting/frontendWhiteLabel" target="_blank" class="btn bg-blue-btn w-100"><?php echo lang('website_whitelabel');?></a>
                    </div>
                </div>

                

            </div>
            <div class="box-footer">
                <button type="submit" name="submit" value="submit" class="btn bg-blue-btn">
                    <iconify-icon icon="solar:upload-minimalistic-broken"></iconify-icon>
                    <?php echo lang('submit'); ?>
                </button>
            </div>
        <?php echo form_close(); ?>
        </div>
    </div>
</div>


<div class="modal fade" id="logo_preview"  aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><?php echo lang('meta_img');?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12  op_center op_padding_10">
                        <img id="show_id" src="" alt="img" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-blue-btn"
                     data-bs-dismiss="modal"><?php echo lang('close');?></button>
            </div>
        </div>
    </div>
</div>

<div id="crop_image_modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo lang('banner');?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div id="meta_img_container" class="img-container">
                    <img src="" alt="Crop Image">
                </div>
                <div id="promotional_notice_img_container" class="img-container">
                    <img src="" alt="Crop Image">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-blue-btn" id="crop_result_meta"><?php echo lang('crop');?></button>
                <button type="button" class="btn bg-blue-btn" id="crop_result_promo"><?php echo lang('crop');?></button>
            </div>
        </div>
    </div>
</div>


<script src="<?php echo base_url(); ?>assets/cropper/cropper.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/eCommerce/js/eCommerce_setting.js"></script>
