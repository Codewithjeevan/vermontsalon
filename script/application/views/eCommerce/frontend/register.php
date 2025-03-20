<!-- breadcrumbs -->
<div class="container">
    <div class="breadcrumbs">
        <a href="<?php echo base_url('e-home');?>"><i class="las la-home"></i></a>
        <a href="#" class="active"><?php echo lang('register');?></a>
    </div>
</div>

<!--register wrapper-->
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
                    <h4 class="title_2"><?php echo lang('Create an account');?></h4>
                    <p class="mb-4 text_md"><?php echo lang('Create_Register_here');?></p>
                    <?php echo form_open(base_url() . 'e-register') ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="single_billing_inp">
                                    <label><?php echo lang('full_name');?> <span class="required_star">*</span></label>
                                    <input type="text" placeholder="<?php echo lang('full_name');?>" value="<?php echo set_value('name');?>" name="name">
                                    <?php if (form_error('name')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <span class="error_paragraph"><?php echo form_error('name'); ?></span>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="single_billing_inp">
                                    <label><?php echo lang('email_address');?> <span class="required_star">*</span></label>
                                    <input type="email" placeholder="<?php echo lang('email_address');?>" value="<?php echo set_value('email');?>" name="email">
                                    <?php if (form_error('email')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <span class="error_paragraph"><?php echo form_error('email'); ?></span>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="single_billing_inp">
                                    <label><?php echo lang('password');?> <span class="required_star">*</span></label>
                                    <input type="password" placeholder="<?php echo lang('password');?>" value="<?php echo set_value('password');?>" name="password">
                                    <?php if (form_error('password')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <span class="error_paragraph"><?php echo form_error('password'); ?></span>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="single_billing_inp">
                                    <label><?php echo lang('confirm_password');?> <span class="required_star">*</span></label>
                                    <input type="password" placeholder="<?php echo lang('confirm_password');?>" value="<?php echo set_value('confirm_password');?>" name="confirm_password">
                                    <?php if (form_error('confirm_password')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <span class="error_paragraph"><?php echo form_error('confirm_password'); ?></span>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <button type="submit" name="submit" value="submit" class="default_btn xs_btn rounded px-4 d-block w-100">
                                    <?php echo lang('create_account');?>
                                </button>
                            </div>
                        </div>
                    <?php echo form_close(); ?>
                    <p class="text-center mt-3 mb-0"><?php echo lang('Already_have_an_account');?> <a href="<?php echo base_url();?>e-login" class="text-color"><?php echo lang('login_now');?></a></p>
                </div>
            </div>
        </div>
    </div>
</div>