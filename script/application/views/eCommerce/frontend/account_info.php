<!-- breadcrumbs -->
<div class="container">
    <div class="breadcrumbs">
        <a href="<?php echo base_url();?>e-home"><i class="las la-home"></i></a>
        <a href="<?php echo base_url();?>e-account"><?php echo lang('my_account');?></a>
        <a href="<?php echo base_url();?>e-account-info" class="active"><?php echo lang('Profile_Information');?></a>
    </div>
</div>

<!-- account wrapper -->
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
                    <h4 class="text_xl mb-3"><?php echo lang('Profile_Information');?></h4>
                    <?php echo form_open(base_url() . 'e-account-info') ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="single_billing_inp">
                                    <label><?php echo lang('full_name');?> <span class="required_star">*</span></label>
                                    <input type="text" placeholder="<?php echo lang('full_name');?>" name="name" value="<?php echo isset($customer_info) && $customer_info->name ? $customer_info->name : set_value('name') ;?>">
                                    <?php if (form_error('name')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <span class="error_paragraph"><?php echo form_error('name'); ?></span>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="single_billing_inp">
                                    <label><?php echo lang('email_address');?> <span class="required_star">*</span></label>
                                    <input type="text" placeholder="<?php echo lang('email_address');?>" name="email" value="<?php echo isset($customer_info) && $customer_info->email ? $customer_info->email : set_value('email') ;?>">
                                    <?php if (form_error('email')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <span class="error_paragraph"><?php echo form_error('email'); ?></span>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="single_billing_inp">
                                    <label><?php echo lang('phone_number');?> <span class="required_star">*</span></label>
                                    <input type="text" placeholder="<?php echo lang('phone_number');?>" name="phone" value="<?php echo isset($customer_info) && $customer_info->phone ? $customer_info->phone : set_value('phone') ;?>">
                                    <?php if (form_error('phone')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <span class="error_paragraph"><?php echo form_error('phone'); ?></span>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="single_billing_inp">
                                    <label><?php echo lang('address');?> <span class="required_star">*</span></label>
                                    <textarea type="text" placeholder="<?php echo lang('address');?>" name="address"><?php echo isset($customer_info) && $customer_info->address ? $customer_info->address : set_value('address') ;?></textarea>
                                    <?php if (form_error('address')) { ?>
                                    <div class="callout callout-danger my-2">
                                        <span class="error_paragraph"><?php echo form_error('address'); ?></span>
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