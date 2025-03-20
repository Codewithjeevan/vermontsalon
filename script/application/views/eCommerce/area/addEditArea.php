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
                if(isset($areas)){
                    $language = lang('edit_area');
                }else{
                    $language = lang('add_area');
                }
                ?>
                <h3 class="top-left-header mt-2"><?php echo $language ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('area'), 'secondSection'=> $language])?>
        </div>
    </section>


    <div class="box-wrapper">
        <div class="table-box"> 
            <!-- form start -->
            <?php echo form_open(base_url('ECommerce_setting/addEditArea/' . (isset($areas) ? $this->custom->encrypt_decrypt($areas->id, 'encrypt') : ''))); ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('area_name'); ?> <span class="required_star">*</span></label>
                            <input  autocomplete="off" type="text" name="area_name" class="form-control" placeholder="<?php echo lang('area_name'); ?>" value="<?= isset($areas) && $areas ? $areas->area_name : set_value('area_name') ?>">
                        </div>
                        <?php if (form_error('area_name')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('area_name'); ?></span>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('delivary_charge'); ?></label>
                            <input  autocomplete="off"  name="delivary_charge" class="form-control integerchk" placeholder="<?php echo lang('delivary_charge'); ?>" value="<?= isset($areas) && $areas ? $areas->delivary_charge : set_value('delivary_charge') ?>">
                        </div> 
                        <?php if (form_error('delivary_charge')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph" class="error_paragraph"><?php echo form_error('delivary_charge'); ?></span>
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
                <a class="btn bg-blue-btn text-decoration-none" href="<?php echo base_url() ?>ECommerce_setting/listArea">
                    <iconify-icon icon="solar:undo-left-round-broken"></iconify-icon>
                    <?php echo lang('back'); ?>
                </a>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>