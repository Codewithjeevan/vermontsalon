<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/add_edit_purchase.css">
<div class="main-content-wrapper">
    <?php if ($this->session->flashdata('exception')) { ?>
        <section class="alert-wrapper">
            <div class="alert alert-success alert-dismissible fade show">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <div class="alert-body">
                    <i class="m-right fa fa-check"></i>
                    <?php echo escape_output($this->session->flashdata('exception')); unset($_SESSION['exception']); ?>
                </div>
            </div>
        </section>
    <?php } ?>
    <?php if ($this->session->flashdata('exception_1')) { ?>
        <section class="alert-wrapper">
            <div class="alert alert-danger alert-dismissible fade show">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <div class="alert-body">
                    <i class="m-right fa fa-exclamation-triangle"></i>
                    <?php echo escape_output($this->session->flashdata('exception_1')); unset($_SESSION['exception_1']); ?>
                </div>
            </div>
        </section>
    <?php } ?>

    <section class="content-header">
        <div class="row justify-content-between align-items-center">
            <div class="col-auto">
                <h3 class="top-left-header mt-2"><?php echo $encrypted_id ? 'Edit Stock Out' : 'Add Stock Out'; ?></h3>
            </div>
            <div class="col-auto">
                <a href="<?php echo base_url('OutStock/outStockList'); ?>" class="btn bg-blue-btn">
                    <iconify-icon icon="solar:undo-left-round-broken" width="18"></iconify-icon>
                    Back to list
                </a>
            </div>
        </div>
    </section>

    <div class="box-wrapper">
        <div class="table-box">
            <!-- <php echo form_open(base_url('OutStock/addEditOutStock/' . $encrypted_id), $arrayName = array('id' => 'out_stock_form')); ?> -->

            <form action="/OutStock/addEditOutStock"  method="post" enctype="multipart/form-data">
            <input type="hidden" name="encrypted_id" value="<?php echo escape_output($encrypted_id); ?>">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label>Reference No</label>
                            <input autocomplete="off" type="text" readonly name="reference_no" class="form-control" value="<?php echo escape_output($reference_no); ?>">
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label>Out Stock Date</label>
                            <input autocomplete="off" type="text" name="out_stock_date" class="form-control customDatepicker" value="<?php echo escape_output($out_stock_date); ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="form-group">
                            <label>Items</label>
                            <select class="form-control select2" name="item_id" id="item_id">
                                <option value=""><?php echo lang('select'); ?></option>
                                <?php foreach ($available_items as $value) {
                                    $item_label = ($value->item_name ? $value->item_name : '') . ($value->brand_name ? ' - ' . $value->brand_name : '') . ' - ' . $value->item_code;
                                ?>
                                    <option value="<?php echo escape_output($value->item_id); ?>"
                                        data-purchase-detail-id="<?php echo escape_output($value->id); ?>"
                                        data-purchase-id="<?php echo escape_output($value->purchase_id); ?>"
                                        data-available="<?php echo escape_output($value->quantity_amount); ?>"
                                        data-unit-type="<?php echo escape_output($value->unit_type); ?>"
                                        data-item-label="<?php echo escape_output($item_label); ?>"
                                        data-reference="<?php echo escape_output($value->reference_no); ?>"
                                        data-purchase-date="<?php echo escape_output($value->purchase_date); ?>">
                                        <?php echo escape_output($item_label); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 d-flex align-items-end">
                        <button type="button" class="new-btn mt-1" id="add_out_stock_item">
                            <iconify-icon icon="solar:add-circle-broken" width="18"></iconify-icon>
                            Add Item
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive" id="purchase_cart">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th><?php echo lang('sn'); ?></th>
                                        <th>Item</th>
                                        <th>Reference / Date</th>
                                        <th>Available Qty</th>
                                        <th>Out Qty</th>
                                        <th>Unit Type</th>
                                        <th><?php echo lang('actions'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($rows)) {
                                        foreach ($rows as $key => $row) { ?>
                                            <tr class="rowCount" data-counter="<?php echo $key + 1; ?>">
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <p id="sl_<?php echo $key + 1; ?>"><?php echo $key + 1; ?></p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>
                                                        <?php echo escape_output($row['item_label']); ?>
                                                    </div>
                                                    <input type="hidden" name="item_id[]" value="<?php echo escape_output($row['item_id']); ?>">
                                                    <input type="hidden" name="purchase_id[]" value="<?php echo escape_output($row['purchase_id']); ?>">
                                                    <input type="hidden" name="purchase_detail_id[]" value="<?php echo escape_output($row['purchase_detail_id']); ?>">
                                                    <input type="hidden" name="unit_type[]" value="<?php echo escape_output($row['unit_type']); ?>">
                                                </td>
                                                <td>
                                                    <div><?php echo escape_output($row['reference']); ?></div>
                                                    <small class="text-muted"><?php echo escape_output($row['out_stock_date']); ?></small>
                                                </td>
                                                <td>
                                                    <div>
                                                        <?php echo getAmtCustom($row['available_qty']); ?>
                                                    </div>
                                                    <input type="hidden" name="available_qty[]" value="<?php echo escape_output($row['available_qty']); ?>">
                                                </td>
                                                <td>
                                                    <input type="number" min="0.01" step="0.01" class="form-control out-stock-qty" name="out_stock_qty[]" value="<?php echo escape_output($row['out_stock_qty']); ?>" data-available="<?php echo escape_output($row['available_qty']); ?>">
                                                </td>
                                                <td>
                                                    <?php echo escape_output($row['unit_type']); ?>
                                                </td>
                                                <td>
                                                    <button type="button" class="new-btn remove_out_stock_row">
                                                        <iconify-icon icon="solar:trash-bin-minimalistic-broken" width="18"></iconify-icon>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php }
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" name="submit" value="submit" class="btn bg-blue-btn">
                    <iconify-icon icon="solar:upload-minimalistic-broken" width="18"></iconify-icon>
                    Save out stock
                </button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>frequent_changing/js/out_stock.js"></script>
