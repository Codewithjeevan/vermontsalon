
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

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header"><?php echo lang('list'); ?> <?php echo lang('flash_sale_items');?></h3>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('flash_sale_items'); ?>" data-id_name="datatable">
                <div class="btn_list m-right d-flex">
                    <a class="new-btn me-1" href="<?php echo base_url() ?>ECommerce_setting/addEditFlashSaleItems">
                    <iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon> <?php echo lang('add'); ?> <?php echo lang('flash_sale_items');?>
                    </a>
                </div>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('flash_sale_items'), 'secondSection'=> lang('list') . ' ' . lang('flash_sale_items')])?>
        </div>
    </section>



    <div class="box-wrapper">
        <div class="table-box">
            <div class="table-responsive">
                <table id="datatable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="w-5"><?php echo lang('sn'); ?></th>
                            <th class="w-15"><?php echo lang('flash_sale_title'); ?></th>
                            <th class="w-15"><?php echo lang('item'); ?></th>
                            <th class="w-15"><?php echo lang('discount'); ?></th>
                            <th class="w-10"><?php echo lang('stock_limit'); ?></th>
                            <th class="w-10"><?php echo lang('status'); ?></th>
                            <th class="w-15"><?php echo lang('added_by'); ?></th>
                            <th class="w-10"><?php echo lang('added_date'); ?></th>
                            <th class="w-5"><?php echo lang('actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if ($flash_sale_items && !empty($flash_sale_items)) {
                                $i = count($flash_sale_items);
                            }
                            foreach ($flash_sale_items as $flash_item) {
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $i--; ?></td>
                            <td><?php echo escape_output($flash_item->flash_sale_title); ?></td>
                            <td><?php echo escape_output($flash_item->parent_name ? $flash_item->parent_name . '-'. $flash_item->item_name : $flash_item->item_name); ?></td>
                            <td><?php echo $flash_item->discount_price; ?></td>
                            <td><?php echo getAmtP($flash_item->stock_limit); ?></td>
                            <td><?php echo escape_output($flash_item->status); ?></td>
                            <td><?php echo escape_output($flash_item->added_by); ?></td>
                            <td><?php echo dateFormat($flash_item->added_date); ?></td>
                            <td>
                                <div class="btn_group_wrap">
                                    <a class="btn btn-warning" href="<?php echo base_url() ?>ECommerce_setting/addEditFlashSaleItems/<?php echo $this->custom->encrypt_decrypt($flash_item->id, 'encrypt'); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-original-title="<?php echo lang('edit'); ?>">
                                        <i class="far fa-edit"></i>
                                    </a>
                                    <a class="delete btn btn-danger" href="<?php echo base_url() ?>ECommerce_setting/deleteFlashSaleItem/<?php echo $this->custom->encrypt_decrypt($flash_item->id, 'encrypt'); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('delete'); ?>">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php $this->view('updater/reuseJs'); ?>