<!-- Main content -->
<section class="main-content-wrapper">
<h3 class="display_none">&nbsp;</h3>
    <?php
    if ($this->session->flashdata('exception')) {
        echo '<section class="alert-wrapper"><div class="alert alert-success alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-body"><i class="m-right fa fa-check"></i>';
        echo escape_output($this->session->flashdata('exception'));unset($_SESSION['exception']);
        echo '</div></div></section>';
    }
    ?>

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('e_commerce_setting'); ?> <?php echo lang('contact_information'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('e_commerce_setting'), 'secondSection'=> lang('contact_information')])?>
        </div>
    </section>


    <div class="box-wrapper">
        <div class="table-box">
            <?php
            echo form_open_multipart(base_url('ECommerce_setting/frontendContact')); ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('title'); ?> <span class="required_star">*</span></label>
                            <input  autocomplete="off" type="text" id="title" name="title" class="form-control" placeholder="<?php echo lang('title'); ?>" value="<?php echo escape_output(isset($contact_data->title) && $contact_data->title ? $contact_data->title : set_value('title')); ?>">
                        </div>
                        <?php if (form_error('title')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('title'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('description'); ?> <span class="required_star">*</span></label>
                            <textarea id="footer" name="description" class="form-control" placeholder="<?php echo lang('description'); ?>"><?php echo escape_output(isset($contact_data->description) && $contact_data->description ? $contact_data->description : set_value('description')); ?></textarea>
                        </div>
                        <?php if (form_error('description')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('description'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('location'); ?> <span class="required_star">*</span></label>
                            <input id="footer" name="location_name" class="form-control" placeholder="<?php echo lang('location'); ?>" value="<?php echo escape_output(isset($contact_data->location_name) && $contact_data->location_name ? $contact_data->location_name : set_value('location_name')); ?>">
                        </div>
                        <?php if (form_error('location_name')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('location_name'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('contact_number'); ?> <span class="required_star">*</span></label>
                            <input id="footer" name="contact_number" class="form-control" placeholder="<?php echo lang('contact_number'); ?>" value="<?php echo escape_output(isset($contact_data->contact_number) && $contact_data->contact_number ? $contact_data->contact_number : set_value('contact_number')); ?>">
                        </div>
                        <?php if (form_error('contact_number')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('contact_number'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('email_address'); ?> <span class="required_star">*</span></label>
                            <input id="footer" name="email_address" class="form-control" placeholder="<?php echo lang('email_address'); ?>" value="<?php echo escape_output(isset($contact_data->email_address) && $contact_data->email_address ? $contact_data->email_address : set_value('email_address')); ?>">
                        </div>
                        <?php if (form_error('email_address')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('email_address'); ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('location_link'); ?> <span class="required_star">*</span></label>
                            <textarea id="footer" name="location" class="form-control" placeholder="<?php echo lang('location_link'); ?>"><?php echo escape_output(isset($contact_data->location) && $contact_data->location ? $contact_data->location : set_value('location')); ?></textarea>
                        </div>
                        <?php if (form_error('location')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('location'); ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" name="submit" value="submit" class="btn bg-blue-btn">
                    <iconify-icon icon="solar:upload-minimalistic-broken"></iconify-icon>
                    <?php echo lang('submit'); ?>
                </button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</section>
