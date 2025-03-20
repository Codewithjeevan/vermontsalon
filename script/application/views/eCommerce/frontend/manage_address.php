<!-- breadcrumbs -->
<div class="container">
    <div class="breadcrumbs">
        <a href="<?php echo base_url();?>e-home"><i class="las la-home"></i></a>
        <a href="<?php echo base_url();?>e-account"><?php echo lang('my_account');?></a>
        <a href="<?php echo base_url();?>e-manage-address" class="active"><?php echo lang('Manage_Address');?></a>
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
                    <h4 class="text_xl mb-3"><?php echo lang('Manage_Address');?></h4>
                    <?php echo form_open(base_url() . 'e-manage-address') ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="single_billing_inp">
                                    <label><?php echo lang('shipping_address');?></label>
                                    <textarea type="text" placeholder="<?php echo lang('shipping_address');?>" name="shipping_address"><?php echo isset($customer_info->shipping_address) && $customer_info->shipping_address ? $customer_info->shipping_address : ''?></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="single_billing_inp">
                                    <label><?php echo lang('billing_address');?></label>
                                    <textarea type="text" placeholder="<?php echo lang('billing_address');?>" name="billing_address"><?php echo isset($customer_info->shipping_address) && $customer_info->shipping_address ? $customer_info->shipping_address : ''?></textarea>
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