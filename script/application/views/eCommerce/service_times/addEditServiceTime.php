<link rel="stylesheet" href="<?php echo base_url(); ?>assets/cropper/cropper.min.css">

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
                <?php 
                if(isset($service_time)){
                    $language = lang('edit') . ' ' . lang('service_time');
                }else{
                    $language = lang('add') . ' ' . lang('service_time');
                }
                ?>
                <h3 class="top-left-header mt-2"><?php echo $language ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('service_time'), 'secondSection'=> $language])?>
        </div>
    </section>


    <div class="box-wrapper">
        <div class="table-box"> 
            <!-- form start -->
            <?php echo form_open_multipart(base_url('ECommerce_setting/addEditServiceTime/' . (isset($service_time) ? $this->custom->encrypt_decrypt($service_time->id, 'encrypt') : ''))); ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('title'); ?></label>
                            <input  autocomplete="off" type="text" name="title" class="form-control" placeholder="<?php echo lang('title'); ?>" value="<?= isset($service_time) && $service_time ? $service_time->title : set_value('title') ?>">
                        </div>
                        <?php if (form_error('title')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('title'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('description'); ?></label>
                            <input  autocomplete="off" type="text" name="description" class="form-control" placeholder="<?php echo lang('description'); ?>" value="<?= isset($service_time) && $service_time ? $service_time->description : set_value('description') ?>">
                        </div>
                        <?php if (form_error('description')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('description'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <div class="form-label-action">
                                <input type="hidden" name="service_image_p" value="<?php echo escape_output(isset($service_time->service_image) && $service_time->service_image ? $service_time->service_image : '')?>">
                                <label><?php echo lang('service_image'); ?> Recommanded size 80X80</label>
                            </div>
                            <div class="d-flex">
                                <input type="file" accept="image/*" name="service_image" class="form-control">
                                <div class="ps-2">
                                    <a data-file_path="<?php echo base_url();?>/uploads/eCommerce/service_image/<?php echo escape_output(isset($service_time->service_image) && $service_time->service_image ? $service_time->service_image : '');?>"  data-id="1" class="new-btn h-40  show_preview" href="javascript:void(0)"><iconify-icon icon="solar:eye-bold-duotone" width="18"></iconify-icon></a>
                                </div>
                            </div>
                        </div>
                        <?php if (form_error('service_image')) { ?>
                            <div class="callout callout-danger my-2">
                                <?php echo form_error('service_image'); ?>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('status'); ?> <span class="required_star">*</span></label>
                            <select name="status" id="status" class="form-control select2">
                                <option <?= isset($service_time) && $service_time ? ($service_time->status == 'Enable' ? 'selected' : '') : '' ?> value="Enable"><?php echo lang('enable');?></option>
                                <option <?= isset($service_time) && $service_time ? ($service_time->status == 'Disable' ? 'selected' : '') : '' ?> value="Disable"><?php echo lang('disable');?></option>
                            </select>
                        </div>
                        <?php if (form_error('status')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('status'); ?></span>
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
                <input type="hidden" id="set_save_and_add_more" name="add_more">
                <button type="submit" name="submit" value="submit" class="btn bg-blue-btn" id="save_and_add_more">
                    <iconify-icon icon="solar:undo-right-round-broken"></iconify-icon>
                    <?php echo lang('save_and_add_more'); ?>
                </button>
                <a class="btn bg-blue-btn text-decoration-none" href="<?php echo base_url() ?>ECommerce_setting/listBanner">
                    <iconify-icon icon="solar:undo-left-round-broken"></iconify-icon>
                    <?php echo lang('back'); ?>
                </a>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>


<div class="modal fade" id="logo_preview"  aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><?php echo lang('banner');?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <?php
                $logoPath = !empty(isset($service_time->service_image) && $service_time->service_image ? $service_time->service_image : ''  ) ? base_url().'uploads/eCommerce/banners/'.(isset($service_time->service_image) && $service_time->service_image ? $service_time->service_image : '') : '';
            ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12  op_center op_padding_10">
                        <img class="img-fluid" src="<?php echo $logoPath ?>" alt="invoice-logo" id="show_id">
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

<script src="<?php echo base_url(); ?>assets/cropper/cropper.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/eCommerce/js/cropper_custom.js"></script>