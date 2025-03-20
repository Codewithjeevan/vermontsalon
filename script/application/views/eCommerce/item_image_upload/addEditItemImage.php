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
                if(isset($item_image)){
                    $language = lang('edit_item_image');
                }else{
                    $language = lang('add_item_image');
                }
                ?>
                <h3 class="top-left-header mt-2"><?php echo $language ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('item_image'), 'secondSection'=> $language])?>
        </div>
    </section>


    <div class="box-wrapper">
        <div class="table-box"> 
            <!-- form start -->
            <?php echo form_open(base_url('ECommerce_setting/addEditItemImage/' . (isset($item_image) ? $this->custom->encrypt_decrypt($item_image->id, 'encrypt') : ''))); ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('item'); ?> <span class="required_star">*</span></label>
                            <select name="item_id" id="item_id" class="form-control select2">
                                <option value=""><?php echo lang('select'); ?></option>
                                <?php if($items){
                                    foreach($items as $item){
                                ?>
                                <option <?php echo isset($item_image) && $item_image ? ($item_image->item_id == $item->id ? 'selected' : '') : '' ?> value="<?php echo $item->id; ?>"><?php echo ($item->parent_name ? $item->parent_name .'-'. $item->name : $item->name) . '(' . escape_output($item->code) . ')'; ?></option>
                                <?php }} ?>
                            </select>
                        </div>
                        <?php if (form_error('item_id')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('item_id'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <div class="form-label-action">
                                <label><?php echo lang('banner_img'); ?> <span class="required_star">(Max 1 MB, Type: jpeg/gif/png)</span></label>
                            </div>
                            <div class="d-flex">
                                <input  type="file" name="banner_img" class="form-control m-0" id="crop_image">
                                <input type="hidden" name="banner_img_2" id="cropped_logo">
                                <?php
                                    $logoPath = !empty($item_image->image) ? base_url().'uploads/eCommerce/item_images/'.$item_image->image : '';
                                ?>
                                <a href="javascript:void(0)" data-file_path="<?php echo escape_output($logoPath)?>" data-id="1" class="new-btn ms-2 show_preview">
                                    <iconify-icon icon="solar:eye-bold-duotone" width="18"></iconify-icon>
                                </a>
                            </div>
                            <input  type="hidden" name="banner_img_p" class="form-control" value="<?= isset($item_image) && $item_image ? $item_image->image : '' ?>">
                        </div>
                        <?php if (form_error('banner_img')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('banner_img'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('status'); ?> <span class="required_star">*</span></label>
                            <select name="status" id="status" class="form-control select2">
                                <option <?= isset($item_image) && $item_image ? ($item_image->status == 'Enable' ? 'selected' : '') : '' ?> value="Enable"><?php echo lang('enable');?></option>
                                <option <?= isset($item_image) && $item_image ? ($item_image->status == 'Disable' ? 'selected' : '') : '' ?> value="Disable"><?php echo lang('disable');?></option>
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
                <a class="btn bg-blue-btn text-decoration-none" href="<?php echo base_url() ?>ECommerce_setting/listItemImage">
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
                <h4 class="modal-title" id="myModalLabel"><?php echo lang('item_image');?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12  op_center op_padding_10">
                        <img class="img-fluid" src="" alt="invoice-logo" id="show_id">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-blue-btn" data-bs-dismiss="modal"><?php echo lang('close');?></button>
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
                <div class="img-container">
                    <img class="img-fluid displayNone" src="-" alt="">
                </div>
                <br>
                <button id="crop_result" class="btn bg-blue-btn"><?php echo lang('crop');?></button>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/cropper/cropper.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/eCommerce/js/cropper_custom.js"></script>