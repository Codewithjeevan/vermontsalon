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
                if(isset($flash_sale)){
                    $language = lang('edit') . ' ' . lang('flash_sale');
                }else{
                    $language = lang('add') . ' ' . lang('flash_sale');
                }
                ?>
                <h3 class="top-left-header mt-2"><?php echo $language ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('unit'), 'secondSection'=> $language])?>
        </div>
    </section>


    <div class="box-wrapper">
        <div class="table-box"> 
            <!-- form start -->
            <?php echo form_open(base_url('ECommerce_setting/addEditFlashSale/' . (isset($flash_sale) ? $this->custom->encrypt_decrypt($flash_sale->id, 'encrypt') : ''))); ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('flash_sale_title'); ?> <span class="required_star">*</span></label>
                            <input  autocomplete="off" type="text" name="flash_sale_title" class="form-control" placeholder="<?php echo lang('flash_sale_title'); ?>" value="<?= isset($flash_sale) && $flash_sale ? $flash_sale->flash_sale_title : set_value('flash_sale_title') ?>">
                        </div>
                        <?php if (form_error('flash_sale_title')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('flash_sale_title'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('start_date'); ?> <span class="required_star">*</span></label>
                            <input  autocomplete="off" type="text" name="start_date" class="form-control customDatepicker" placeholder="<?php echo lang('start_date'); ?>" value="<?= isset($flash_sale) && $flash_sale ? $flash_sale->start_date : set_value('start_date') ?>">
                        </div>
                        <?php if (form_error('start_date')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('start_date'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('end_date'); ?> <span class="required_star">*</span></label>
                            <input  autocomplete="off" type="text" name="end_date" class="form-control customDatepicker" placeholder="<?php echo lang('end_date'); ?>" value="<?= isset($flash_sale) && $flash_sale ? $flash_sale->end_date : set_value('end_date') ?>">
                        </div>
                        <?php if (form_error('end_date')) { ?>
                            <div class="callout callout-danger my-2">
                                <span class="error_paragraph"><?php echo form_error('end_date'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('status'); ?> <span class="required_star">*</span></label>
                            <select name="status" id="status" class="form-control select2">
                                <option <?= isset($flash_sale) && $flash_sale ? ($flash_sale->status == 'Active' ? 'selected' : '') : set_select('status', 'Active') ?> value="Active"><?php echo lang('Active');?></option>
                                <option <?= isset($flash_sale) && $flash_sale ? ($flash_sale->status == 'Inactive' ? 'selected' : '') : set_select('status', 'Inactive') ?> value="Inactive"><?php echo lang('Inactive');?></option>
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
                <a class="btn bg-blue-btn text-decoration-none" href="<?php echo base_url() ?>Unit/units">
                    <iconify-icon icon="solar:undo-left-round-broken"></iconify-icon>
                    <?php echo lang('back'); ?>
                </a>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>