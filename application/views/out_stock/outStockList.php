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
                <h3 class="top-left-header mt-2">Stock Out List</h3>
            </div>
            <div class="col-auto">
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
                    <table class="table table-bordered" id="outStockTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Reference</th>
                                <th>Item</th>
                                <th>Date</th>
                                <th>Qty</th>
                                <th>Unit Type</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($out_stocks)) { ?>
                                <?php foreach ($out_stocks as $key => $stock) { ?>
                                    <tr>
                                        <td><?php echo $key + 1; ?></td>
                                        <td><?php echo escape_output($stock->reference_id); ?></td>
                                        <td>
                                            <?php echo escape_output($stock->item_name ?? ''); ?>
                                            <?php if (!empty($stock->brand_name)) { ?>
                                                - <?php echo escape_output($stock->brand_name); ?>
                                            <?php } ?>
                                        </td>
                                        <td><?php echo escape_output($stock->out_stock_date); ?></td>
                                        <td><?php echo $stock->out_stock_qty; ?></td>
                                        <td><?php echo escape_output($stock->purchase_unit_name); ?></td>
                                        <td>
                                            <a href="<?php echo base_url() . 'OutStock/addEditOutStock/' . $this->custom->encrypt_decrypt($stock->id, 'encrypt'); ?>" class="btn btn-warning">
                                                <i class="far fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="7" class="text-center">No stock out records found.</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/buttons.print.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/jszip.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/pdfmake.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/dataTable/vfs_fonts.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/js/out_stock_list.js"></script>