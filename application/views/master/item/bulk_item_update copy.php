<link rel="stylesheet" href="<?php echo base_url()?>frequent_changing/css/checkBotton2.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/item.css">
<input type="hidden" id="status_change" value="<?php echo lang('status_change');?>">

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/crop/croppie.css">
<script src="<?php echo base_url(); ?>assets/bower_components/crop/croppie.js"></script>

<div class="main-content-wrapper">
    <?php
    if ($this->session->flashdata('exception')) {
        echo '<section class="alert-wrapper"><div class="alert alert-success alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
        <div class="alert-body"><i class="icon fa fa-check me-2"></i>';
        echo escape_output($this->session->flashdata('exception'));unset($_SESSION['exception']);
        echo '</div></div></section>';
    }
    ?>
    <?php
    if ($this->session->flashdata('exception_error')) {

        echo '<section class="alert-wrapper"><div class="alert alert-danger alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
        <div class="alert-body"><i class="icon fa fa-times me-2"></i>';
        echo escape_output($this->session->flashdata('exception_error'));unset($_SESSION['exception_error']);
        echo '</div></div></section>';
    }
    ?>
    <div class="ajax-message"></div>


    <section class="content-header"> 
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header"><?php echo lang('bulk_item_update'); ?></h3>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('bulk_item_update'); ?>" data-id_name="datatable">
                <div class="btn_list m-right d-flex">
                    <button type="button" class="dataFilterBy new-btn"><iconify-icon icon="solar:filter-broken"  width="22"></iconify-icon> <?php echo lang('filter_by');?></button>
                </div>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('item'), 'secondSection'=> lang('bulk_item_update')])?>
        </div>
    </section>

    <div class="box-wrapper"> 
        <form action="<?php echo base_url();?>Item/bulkItemUpdate" method="POST">
            <!-- End Filter Options -->
            <div class="table-box item_page_indicator">
                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="w-5 text-left"><?php echo lang('sn'); ?></th>
                                <th class="w-20"><?php echo lang('name'); ?> (<?php echo lang('code'); ?>)</th>
                                <th class="w-12"><?php echo lang('sale_price'); ?></th>
                                <th class="w-12"><?php echo lang('whole_sale_price'); ?></th>
                                <th class="w-5"><?php echo lang('update_action'); ?></th>
                                <th class="w-12"><?php echo lang('status'); ?></th>
                                <th class="w-12"><?php echo lang('image'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($bulk_item_update && !empty($bulk_item_update)) {
                                $i = count($bulk_item_update);
                            foreach ($bulk_item_update as $value) {
                            ?>
                            <tr>
                                <td><?php echo $i--; ?></td>
                                <td><?php echo $value->name . " " . "(" . $value->code . ")"; ?></td>
                                <td>
                                    <div class="form-group">
                                        <input  autocomplete="off" type="text" onfocus="this.select();" name="sale_price[]" class="form-control integerchk sale_price" placeholder="<?php echo lang('sale_price'); ?>" value="<?php echo $value->sale_price ?>">  
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input <?php echo $value->type == 'Service_Product' ? 'readonly' : '' ?>  autocomplete="off" type="text" onfocus="this.select();" name="whole_sale_price[]" class="form-control integerchk whole_sale_price" placeholder="<?php echo lang('whole_sale_price'); ?>" value="<?php echo $value->whole_sale_price ?>">  
                                    </div>
                                </td>
                                
                                <td>
                                    <button data_id="<?php echo $this->custom->encrypt_decrypt($value->id, 'encrypt') ?>" class="btn bg-blue-btn single_item_btn" type="button"><?php echo lang('update');?></button>
                                </td>
                                <td>
                                    <div data_id="<?php echo $this->custom->encrypt_decrypt($value->id, 'encrypt') ?>">
                                        <div class="form-group">
                                            <select name="status_trigger" id="status_trigger" class="form-control select2">';
                                                <option <?php echo $value->enable_disable_status == 'Enable' ? 'selected' : '' ?> value="Enable"><?php echo lang('enable');?></option>
                                                <option <?php echo $value->enable_disable_status == 'Disable' ? 'selected' : '' ?> value="Disable"><?php echo lang('disable');?></option>
                                            </select>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bulk_img_up">
                                            <?php 
                                            $file_path = FCPATH . 'uploads/items/' . $value->photo; // Use FCPATH to get the absolute path
                                            if (file_exists($file_path) && $value->photo) { ?>
                                                <img class="image_setter_<?php echo $value->id;?>" src="<?php echo base_url();?>uploads/items/<?php echo $value->photo ?>" alt="item-image" width="85" height="85">
                                            <?php }else{ ?>
                                                <img class="image_setter_<?php echo $value->id;?>" src="<?php echo base_url();?>uploads/site_settings/image_thumb.png" alt="item-image" width="85" height="85">
                                            <?php } ?>
                                        </div>
                                        <a data_old_photo="<?php echo $value->photo ?>" href="javascript:void(0)" data_id="<?php echo $this->custom->encrypt_decrypt($value->id, 'encrypt') ?>" class="bulk_img_up ms-3 tippyBtnCall cursor-pointer add_image_for_crop" data-tippy-content="<?php echo lang('image_update'); ?>">
                                            <i class="fa-regular fa-image"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php }} ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- DataTables -->


<!-- Image Modal -->
<div class="modal fade" id="AddItemImageModal" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    <?php echo lang('image_cropper'); ?>
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        <i data-feather="x">×</i>
                    </span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" class="item_image_id">
                    <input type="hidden" class="item_old_photo">
                    <div class="col-md-12 text-center">
                        <div id="upload-demo" class="upload_demo_single"></div>
                    </div>
                    <div class="col-md-12 text-center">
                        <strong><?php echo lang('select_image'); ?></strong>
                        <br>
                        <input type="file" class="form-control" id="upload">
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-blue-btn upload-result"><?php echo lang('update'); ?></button>
                <button type="button" class="btn bg-blue-btn" data-bs-dismiss="modal"><?php echo lang('close'); ?></button>
            </div>
        </div>
    </div>
</div>

<?php $this->view('updater/reuseJs')?>
<script src="<?php echo base_url(); ?>frequent_changing/js/bulk_price_update.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/items.js"></script>




