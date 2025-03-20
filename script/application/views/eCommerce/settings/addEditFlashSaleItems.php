<link rel="stylesheet" href="<?php echo base_url() ?>frequent_changing/css/checkBotton.css">
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
                if(isset($flash_sale_item)){
                    $language = lang('edit') . ' ' . lang('flash_sale_items');
                }else{
                    $language = lang('add') . ' ' . lang('flash_sale_items');
                }
                ?>
                <h3 class="top-left-header mt-2"><?php echo $language ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('flash_sale_items'), 'secondSection'=> $language])?>
        </div>
    </section>

    <div class="box-wrapper">
        <div class="table-box"> 
            <!-- form start -->
            <?php echo form_open(base_url('ECommerce_setting/addEditFlashSaleItems')); ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('flash_sale_type'); ?> <span class="required_star">*</span></label>
                            <select name="flash_sale_id" id="flash_sale_id" class="form-control select2">
                                <option value=""><?php echo lang('select');?> <?php echo lang('flash_sale');?></option>
                                <?php if($flash_sales){
                                    foreach($flash_sales as $value){
                                ?>
                                    <option <?php echo isset($encrypted_id) && $encrypted_id == $this->custom->encrypt_decrypt($value->id, 'encrypt') ? 'selected' : ''?> value="<?php echo $this->custom->encrypt_decrypt($value->id, 'encrypt'); ?>"><?php echo $value->flash_sale_title ?></option>
                                <?php }} ?>
                            </select>
                        </div>
                        <?php if (form_error('flash_sale_id')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('flash_sale_id'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="row">
                    <?php if($items){
                        foreach($items as $item){
                            $found_item = false;
                            $discount_value = '';
                            if(isset($flash_sale_item) && $flash_sale_item){
                                $found_item =  array_search($item->id, array_column($flash_sale_item, 'item_id'));
                                if($found_item !== false) {
                                    $discount_value = $flash_sale_item[$found_item]->discount_price;
                                }
                            }
                    ?>
                    <div class="col-6">
                        <div class="flas_item_checkbox ">
                            <label class="container">
                                <span class="item_name"><?php echo $item->name;?></span>
                                <input type="checkbox" class="checkbox_user child_class flash_sale_item_checkbox" value="<?php echo $item->id;?>" name="item_id[]" <?php echo ($found_item !== false) ? 'checked' : ''; ?>>
                                <input type="hidden" class="flash_sale_item_checkbox_hidden" name="item_id_2[]" value="<?php echo ($found_item !== false) ? $item->id : ''; ?>">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <input type="text" name="discount_price[]" class="form-control" placeholder="<?php echo lang('discount'); ?> <?php echo lang('flat_or_percentage');?> <?php echo lang('10_p_or_10'); ?>" value="<?php echo $discount_value; ?>" autocomplete="off">
                        </div>
                    </div>
                    <div class="row">
                        <hr>
                    </div>
                    <?php }} ?>
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
                <a class="btn bg-blue-btn text-decoration-none" href="<?php echo base_url() ?>Unit/units">
                    <iconify-icon icon="solar:undo-left-round-broken"></iconify-icon>
                    <?php echo lang('back'); ?>
                </a>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>