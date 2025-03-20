<!-- breadcrumbs -->
<div class="container">
    <div class="breadcrumbs">
        <a href="<?php echo base_url();?>e-home"><i class="las la-home"></i></a>
        <a href="<?php echo base_url();?>e-forgot-password" class="active"><?php echo lang('forgot_password');?></a>
    </div>
</div>

<!-- forgot password -->
<div class="section_padding mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-7">
                <?php echo form_open(base_url() . 'e-forgot-password-submit', $arrayName = array('id' => 'login_form', 'enctype' => 'multipart/form-data')) ?>
                <div class="padding_default shadow_sm">
                    <h2 class="title_2"><?php echo lang('reset_password');?></h2>
                    <p class="text_md mb-4"><?php echo lang('Please_enter_your_email_address_below_to_receive_a_link');?></p>
                    <div class="single_billing_inp mb-0">
                        <label><?php echo lang('email_address');?> <span class="required_star">*</span></label>
                        <input type="email" name="email" placeholder="<?php echo lang('email_address');?>">
                    </div>
                    <div class="mt-4">
                        <button type="submit" value="submit" name="submit" class="default_btn rounded small"><?php echo lang('reset_my_password');?></button>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>