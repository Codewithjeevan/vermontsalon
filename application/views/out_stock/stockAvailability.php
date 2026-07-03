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
                <h3 class="top-left-header mt-2">Stock Availability Report</h3>
            </div>
            <div class="col-auto d-flex gap-2">
                <button type="button" class="dataFilterBy new-btn"><iconify-icon icon="solar:filter-broken" width="22"></iconify-icon> <?php echo lang('filter_by'); ?></button>
                <a href="<?php echo base_url('OutStock/addEditOutStock'); ?>" class="btn bg-blue-btn">
                    <iconify-icon icon="solar:add-circle-broken" width="18"></iconify-icon>
                    Add Stock Out
                </a>
            </div>
        </div>
    </section>

    <div class="box-wrapper mt-3">
        <div class="table-box">
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="stockAvailabilityTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Item</th>
                                <th>Purchase Stock</th>
                                <th>Consumption Stock</th>
                                <th>Available Stock</th>
                                <th>Amount (per unit)</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($stock_report)) { ?>
                                <?php foreach ($stock_report as $index => $report) {
                                    $available_qty = floatval($report->available_qty);
                                    $consumed_qty = floatval($report->consumed_qty);
                                    $purchased_qty = floatval($report->purchased_qty);
                                    $has_purchase = (int)$report->last_purchase_detail_id > 0;
                                ?>
                                    <tr>
                                        <td><?php echo $index + 1; ?></td>
                                        <td>
                                            <?php echo escape_output($report->item_name); ?>
                                            <?php if (!empty($report->item_code)) { ?>
                                                (<?php echo escape_output($report->item_code); ?>)
                                            <?php } ?>
                                        </td>
                                        <td><?php echo getAmtPCustom($purchased_qty); ?></td>
                                        <td><?php echo getAmtPCustom($consumed_qty); ?></td>
                                        <td><?php echo getAmtPCustom($available_qty); ?></td>
                                        <td><?php echo getAmtStock($report->unit_price); ?></td>
                                        <td class="d-flex gap-2 flex-wrap">
                                            <?php if ($has_purchase) { ?>
                                                <button type="button" class="btn bg-blue-btn stock-adjust-btn"
                                                        data-item-id="<?php echo $report->item_id; ?>"
                                                        data-purchase-detail-id="<?php echo $report->last_purchase_detail_id; ?>"
                                                        data-item-label="<?php echo escape_output($report->item_name); ?>"
                                                        data-unit-name="<?php echo escape_output($report->unit_name); ?>"
                                                        data-available="<?php echo $available_qty; ?>">
                                                    Adjust Stock
                                                </button>
                                                <button type="button" class="btn btn-primary stock-adjustment-history-row-btn"
                                                        data-purchase-detail-id="<?php echo $report->last_purchase_detail_id; ?>"
                                                        data-item-name="<?php echo escape_output($report->item_name); ?>">
                                                    <iconify-icon icon="solar:document-search-broken" width="16"></iconify-icon>
                                                    History
                                                </button>
                                            <?php } else { ?>
                                                <span class="text-muted">Unavailable</span>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted">No stock report data available.</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stock adjustment modal -->
<div class="modal fade" id="stockAdjustmentModal" tabindex="-1" aria-labelledby="stockAdjustmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="stockAdjustmentModalLabel" class="modal-title">Adjust Stock Quantity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i></button>
            </div>
            <form id="stockAdjustmentForm">
                <div class="modal-body">
                    <input type="hidden" name="item_id" id="adjustItemId">
                    <input type="hidden" name="purchase_detail_id" id="adjustPurchaseDetailId">
                    <div class="mb-3">
                        <label class="form-label">Item</label>
                        <input type="text" class="form-control" id="adjustItemLabel" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Available Quantity</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="adjustAvailableQty" disabled>
                            <span class="input-group-text" id="adjustUnitName"></span>
                        </div>
                    </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Quantity to Add</label>
                        <input type="number" step="0.01" min="0" class="form-control" name="quantity_plus" id="adjustQuantityPlus" value="0">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Quantity to Remove</label>
                        <input type="number" step="0.01" min="0" class="form-control" name="quantity_minus" id="adjustQuantityMinus" value="0">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Adjustment Date</label>
                    <input type="date" class="form-control" name="adjustment_date" id="adjustmentDate">
                </div>
                    <div class="mb-3">
                        <label class="form-label">Reason (optional)</label>
                        <textarea name="reason" id="adjustReason" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn bg-blue-btn">Save Adjustment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="stockAdjustmentHistoryModal" tabindex="-1" aria-labelledby="stockAdjustmentHistoryLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="stockAdjustmentHistoryLabel" class="modal-title">Stock Adjustments</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i></button>
            </div>
            <div class="modal-body">
                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="adjustmentHistoryStart">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">End Date</label>
                        <input type="date" class="form-control" id="adjustmentHistoryEnd">
                    </div>
                    <div class="col-md-4 d-flex align-items-end gap-2">
                        <button type="button" class="btn bg-blue-btn" id="stockAdjustmentHistoryFilter">Filter</button>
                        <button type="button" class="btn btn-primary" id="stockAdjustmentHistoryClear">Clear</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Item</th>
                                <th>Direction</th>
                                <th>Quantity</th>
                                <th>Current Qty</th>
                                <th>Reason</th>
                            </tr>
                        </thead>
                        <tbody id="stockAdjustmentHistoryBody">
                            <tr>
                                <td colspan="6" class="text-center text-muted">No adjustments loaded.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="filter-overlay"></div>
<div id="product-filter" class="filter-modal">
    <div class="filter-modal-body">
        <header>
                <h3 class="filter-modal-title"><span><?php echo lang('FilterOptions'); ?></span></h3>
                <button type="button" class="close-filter-modal" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        <i data-feather="x"></i>
                    </span>
                </button>
        </header>
        <?php echo form_open(base_url() . 'OutStock/stockAvailability') ?>
        <div class="row">
            <div class="col-sm-12 col-md-12 mb-2">
                <div class="form-group">
                    <select name="category_id" id="category_id" class="form-control select2 width_100_p">
                        <option value=""><?php echo lang('category'); ?></option>
                        <?php foreach ($itemCategories as $ctry) { ?>
                            <option value="<?php echo escape_output($ctry->id) ?>" <?php echo set_select('category_id', $ctry->id, ($selected_category_id == $ctry->id)); ?>><?php echo escape_output($ctry->name) ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <button type="submit" name="submit" value="submit" class="new-btn">
                    <iconify-icon icon="solar:hourglass-broken" width="22"></iconify-icon>
                    <?php echo lang('submit'); ?>
                </button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

<script>
    window.stockAdjustmentUrl = '<?php echo base_url('OutStock/addStockAdjustment'); ?>';
    window.stockAdjustmentHistoryUrl = '<?php echo base_url('OutStock/getStockAdjustments'); ?>';
</script>
<?php $this->load->view('updater/reuseJs2'); ?>
<script src="<?php echo base_url(); ?>frequent_changing/js/stock_availability_list.js"></script>

