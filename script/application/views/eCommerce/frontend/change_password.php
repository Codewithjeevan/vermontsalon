<!-- breadcrumbs -->
<div class="container">
    <div class="breadcrumbs">
        <a href="<?php echo base_url();?>e-home"><i class="las la-home"></i></a>
        <a href="<?php echo base_url();?>e-account"><?php echo lang('my_account');?></a>
        <a href="<?php echo base_url();?>e-change-password" class="active"><?php echo lang('change_password');?></a>
    </div>
</div>

<!-- account -->
<div class="my_account_wrap section_padding_b">   
    <div class="container">
        <div class="row">
            <!--  account sidebar  -->
            <?php $this->view('eCommerce/frontend/customer_profile_sidebar')?>
            <!-- account content -->
            <div class="col-lg-9">
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
                <div class="acprof_info_wrap shadow_sm">
                    <h4 class="text_xl mb-3"><?php echo lang('change_password');?></h4>
                    <?php echo form_open(base_url() . 'e-change-password') ?>
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div class="single_billing_inp">
                                    <label for="old_password"><?php echo lang('current_password');?></label>
                                    <div class="position-relative">
                                        <input id="old_password" type="password" placeholder="<?php echo lang('enter_current_password');?>" name="old_password" value="<?php echo set_value('old_password');?>">
                                        <span class="icon"><i class="bi bi-eye-slash ey_ctrl"></i></span>
                                    </div>
                                    <?php if (form_error('old_password')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <span class="error_paragraph"><?php echo form_error('old_password'); ?></span>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="single_billing_inp">
                                    <label for="new_password"><?php echo lang('new_password');?></label>
                                    <div class="position-relative">
                                        <input id="new_password" type="password" placeholder="<?php echo lang('enter_new_password');?>" name="new_password" value="<?php echo set_value('new_password');?>">
                                        <span class="icon"><i class="bi bi-eye-slash ey_ctrl"></i></span>
                                    </div>
                                    <?php if (form_error('new_password')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <span class="error_paragraph"><?php echo form_error('new_password'); ?></span>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-12 acprof_subbtn">
                                <button type="submit" name="submit" value="submit" class="default_btn rounded small"><?php echo lang('save_changes');?></button>
                            </div>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>