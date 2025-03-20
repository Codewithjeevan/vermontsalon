<link rel="stylesheet" href="<?php echo base_url()?>frequent_changing/css/checkBotton2.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/item.css">
<div class="main-content-wrapper">
<div class="ajax-message"></div>

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


    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header"><?php echo lang('flash_sale_items'); ?></h3>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('flash_sale_items'); ?>" data-id_name="datatable">
                <div class="btn_list m-right d-flex">
                    <button type="button" class="dataFilterBy new-btn"><iconify-icon icon="solar:filter-broken"  width="22"></iconify-icon> <?php echo lang('filter_by');?></button>
                </div>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('e_commerce_setting'), 'secondSection'=> lang('flash_sale_items')])?>
        </div>
    </section>



    <div class="box-wrapper">
        <form action="<?php echo base_url();?>Item/bulkDelete" method="POST">
            <!-- <div class="text-right d-flex justify-content-end page_sort_but_wrp">
                <a href="<?php echo base_url() ?>Item/addEditItem"
                    class="new-btn mb-2 ms-1"><iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon> <?php echo lang('add_item'); ?>
                </a>
                <div class="dropdown ms-1">
                    <button class="new-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <iconify-icon icon="solar:hourglass-broken" width="22"></iconify-icon>
                        <?php echo lang('other_options');?>
                    </button>
                    <ul class="dropdown-menu p-2">
                        <li>
                            <a href="<?php echo base_url() ?>Item/uploadItem" class="dropdown-item new-btn">
                                <iconify-icon icon="solar:upload-broken" width="22"></iconify-icon>
                                <?php echo lang('upload_item'); ?>
                            </a>
                        </li>
                        <li class="mt-1">
                            <a href="<?php echo base_url() ?>Item/uploadItemPhoto" class="dropdown-item new-btn">
                                <iconify-icon icon="solar:upload-broken" width="22"></iconify-icon>
                                <?php echo lang('upload_photo'); ?>
                            </a>
                        </li>
                        <li class="mt-1">
                            <a href="<?php echo base_url() ?>Item/itemBarcodeGenerator" class="dropdown-item new-btn">
                                <iconify-icon icon="solar:printer-2-broken" width="22"></iconify-icon>
                                <?php echo lang('item_barcode'); ?>
                            </a>
                        </li>
                        <li class="mt-1">
                            <a href="<?php echo base_url() ?>Item/itemBarcodeGeneratorLabel" class="dropdown-item new-btn">
                                <iconify-icon icon="solar:printer-2-broken" width="22"></iconify-icon> 
                                <?php echo lang('Print_Labels');?>
                            </a>
                        </li>
                    </ul>
                </div>
                <button type="submit" class="new-btn mb-2 ms-1">
                    <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="22"></iconify-icon>
                    <?php echo lang('Delete_Item');?>
                </button>
            </div> -->
            <!-- End Filter Options -->
            <div class="table-box item_page_indicator">
                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered table-striped items_ajax_page">
                        <thead>
                            <tr>
                                <th class="w-5" data-orderable="false">
                                    <label  class="container "> <?php echo lang('select_all'); ?>
                                        <input class="checkbox_itemAll" type="checkbox" id="checkbox_itemAll">
                                        <span class="checkmark"></span>
                                    </label>
                                </th>
                                <th class="w-5 text-left"><?php echo lang('sn'); ?></th>
                                <th class="w-20"><?php echo lang('name'); ?> (<?php echo lang('code'); ?>)</th>
                                <th class="w-10"><?php echo lang('type'); ?></th>
                                <th class="w-10"><?php echo lang('category'); ?></th>
                                <th class="w-12"><?php echo lang('purchase_price'); ?></th>
                                <th class="w-12"><?php echo lang('sale_price'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- DataTables -->
<?php $this->load->view('updater/reuseJs')?>


