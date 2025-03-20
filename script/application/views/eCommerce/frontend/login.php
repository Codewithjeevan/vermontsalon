<!-- breadcrumbs -->
<div class="container">
    <div class="breadcrumbs">
        <a href="<?php echo base_url();?>"><i class="las la-home"></i></a>
        <a href="<?php echo base_url();?>e-login" class="active"><?php echo lang('login');?></a>
    </div>
</div>

<!--Login wrap-->
<div class="register_wrap section_padding_b">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-7 col-md-9">
                <?php if ($this->session->flashdata('exception')) : ?>
                <section class="alert-wrapper">
                    <div class="alert alert-success alert-dismissible fade show">
                        <div class="alert-body">
                            <?= escape_output($this->session->flashdata('exception')); ?>
                            <?php unset($_SESSION['exception']); ?>
                        </div>
                    </div>
                </section>
                <?php endif; ?>
                <?php if ($this->session->flashdata('exception_error')) : ?>
                <section class="alert-wrapper">
                    <div class="alert alert-danger alert-dismissible fade show">
                        <div class="alert-body">
                            <?= escape_output($this->session->flashdata('exception_error')); ?>
                            <?php unset($_SESSION['exception_error']); ?>
                        </div>
                    </div>
                </section>
                <?php endif; ?>
                <div class="register_form padding_default shadow_sm">
                    <h4 class="title_2"><?php echo lang('login');?></h4>
                    <p class="mb-4 text_md"><?php echo lang('Login_if_you_a_running_customer');?></p>
                    <?php echo form_open(base_url() . 'e-login') ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="single_billing_inp">
                                    <label><?php echo lang('email_address');?> <span class="required_star">*</span></label>
                                    <input type="email" name="email" placeholder="<?php echo lang('email_address');?>" value="<?php echo set_value('email');?>">
                                    <?php if (form_error('email')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <span class="error_paragraph"><?php echo form_error('email'); ?></span>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="single_billing_inp">
                                    <label><?php echo lang('Password');?> <span class="required_star">*</span></label>
                                    <input type="password" name="password" placeholder="<?php echo lang('Password');?>" value="<?php echo set_value('password');?>">
                                    <?php if (form_error('password')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <span class="error_paragraph"><?php echo form_error('password'); ?></span>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-12 mt-2 d-flex justify-content-end align-items-center">
                                <a href="<?php echo base_url();?>e-forgot-password" class="text-color"><?php echo lang('forgot_password');?>?</a>
                            </div>
                            <div class="col-12 mt-3">
                                <button type="submit" name="submit" value="submit" class="default_btn xs_btn rounded px-4 d-block w-100"><?php echo lang('login');?></button>
                            </div>
                        </div>
                    <?php echo form_close(); ?>
                    <p class="text-center mt-3 mb-0"><?php echo lang('Don_t_have_an_account');?> <a href="<?php echo base_url();?>e-register" class="text-color"><?php echo lang('Register_Now');?></a></p>
                </div>
            </div>
        </div>
    </div>
</div>
