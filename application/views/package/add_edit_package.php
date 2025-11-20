<script src="<?php echo base_url(); ?>frequent_changing/js/add_edit_package.js"></script>
<div class="main-content-wrapper">
<?php
    if ($this->session->flashdata('exception')) {
        echo '<section class="alert-wrapper">
        <div class="alert alert-success alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-body">
        <i class="m-right fa fa-check"></i>';
        echo escape_output($this->session->flashdata('exception'));unset($_SESSION['exception']);
        echo '</div></div></section>';
    }
    ?>


    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('add_edit_sale_package'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('customer'), 'secondSection'=> lang('add_edit_sale_package')])?>
        </div>
    </section>



    <div class="box-wrapper">
        <div class="table-box">
            <?php echo form_open(base_url('Customer/addEditSalePackage')); ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('select_customer'); ?> <span class="required_star">*</span></label>
                            <select id="walk_in_customer" name="customer"  class="customer_data" tabindex="2"></select>
                        </div>
                        <?php if (form_error('name')) { ?>
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph"><?php echo form_error('name'); ?></span>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('select_pacakge'); ?> <span class="required_star">*</span></label>
                            <select id="select_pacakge" name="package"  class="package_data select2" tabindex="2">
                                <option value=""><?php echo lang('select_pacakge'); ?></option>
                            </select>
                        </div>
                        <?php if (form_error('name')) { ?>
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph"><?php echo form_error('name'); ?></span>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('phone'); ?> <span class="required_star">*</span></label>
                            <input  autocomplete="off" type="text" name="phone"
                                class="form-control" placeholder="Phone"
                                value="">
                        </div>
                        <?php if (form_error('phone')) { ?>
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph"><?php echo form_error('phone'); ?></span>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <button type="submit" name="submit" value="submit" class="btn bg-blue-btn">
                <iconify-icon icon="solar:upload-minimalistic-broken"></iconify-icon>
                <?php echo lang('submit'); ?>
            </button>
            <input type="hidden" id="set_save_and_add_more" name="add_more">
            <button type="submit" name="submit" value="submit" class="btn bg-blue-btn" id="save_and_add_more">
                <iconify-icon icon="solar:undo-right-round-broken"></iconify-icon>
                <?php echo lang('save_and_add_more'); ?>
            </button>
            <a class="btn bg-blue-btn text-decoration-none" href="<?php echo base_url() ?>Customer/customers">
                <iconify-icon icon="solar:undo-left-round-broken"></iconify-icon>
                <?php echo lang('back'); ?>
            </a>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
