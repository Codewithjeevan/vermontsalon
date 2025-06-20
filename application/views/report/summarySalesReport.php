<input type="hidden" value="<?php echo lang('The_date_field_is_required'); ?>" id="The_date_field_is_required">
<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/report.css">
<style>
    .dataTable thead tr th:last-child,
    .dataTable tbody tr td:last-child {
        text-align: center !important;
    }
</style>
<div class="main-content-wrapper">

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('summary_sales_report'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection' => lang('report'), 'secondSection' => lang('summary_sales_report')]) ?>
        </div>
    </section>


    <div class="box-wrapper">
        <!-- Report Header Start -->
        <div class="report_header">
            <h3 class="company_name">
                <?php echo escape_output($this->session->userdata('business_name')); ?>
            </h3>
            <h5 class="outlet_info">
                <strong><?php echo lang('summary_sales_report'); ?></strong>
            </h5>
            <?php if (isset($outlet_id) && $outlet_id) {
                $outlet_info = getOutletInfoById($outlet_id);
            } ?>
            <h5 class="outlet_info">
                <?php if (isset($outlet_id) && $outlet_id) { ?>
                    <strong><?php echo lang('outlet'); ?>: </strong> <?= escape_output($outlet_info->outlet_name); ?>
                <?php } ?>
            </h5>
            <h5 class="outlet_info ">
                <?php if (isset($outlet_id) && $outlet_id) { ?>
                    <strong><?php echo lang('address'); ?>: </strong> <?= escape_output($outlet_info->address); ?>
                <?php } ?>
            </h5>
            <h5 class="outlet_info">
                <?php if (isset($outlet_id) && $outlet_id) { ?>
                    <strong><?php echo lang('email'); ?>: </strong> <?= escape_output($outlet_info->email); ?>
                <?php } ?>
            </h5>
            <h5 class="outlet_info">
                <?php if (isset($outlet_id) && $outlet_id) { ?>
                    <strong><?php echo lang('phone'); ?>: </strong> <?= escape_output($outlet_info->phone); ?>
                <?php } ?>
            </h5>
            <?php if (isset($start_date) && $start_date != '' && $start_date != '1970-01-01' || isset($end_date) && $end_date != '' && $end_date != '1970-01-01') { ?>
                <h5 class="outlet_info">
                    <strong><?php echo lang('date'); ?>:</strong>
                    <?php
                    if (!empty($start_date) && $start_date != '1970-01-01') {
                        echo dateFormat($start_date);
                    }
                    if ((isset($start_date) && isset($end_date)) && ($start_date != '1970-01-01' && $end_date != '1970-01-01')) {
                        echo ' - ';
                    }
                    if (!empty($end_date) && $end_date != '1970-01-01') {
                        echo dateFormat($end_date);
                    }
                    ?>
                </h5>
            <?php } ?>
            <h5 class="outlet_info">
                <?php if (isset($report_generate_time) && $report_generate_time) {
                    echo $report_generate_time;
                } ?>
            </h5>
        </div>
        <!-- Report Header End -->
        <div class="table-box">
            <!-- /.box-header -->
            <div class="table-responsive">
                <input type="hidden" class="datatable_name" data-filter="yes"
                    data-title="<?php echo lang('summary_sales_report'); ?>" data-id_name="datatable">
                <table id="datatable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th><?= lang('date') ?></th>
                            <th class="text-center"><?= lang('total_bill_amt') ?></th>
                            <th class="text-center"><?= lang('dis_amt') ?></th>

                             <!-- Dynamic tax columns -->
                            <?php foreach ($tax_settings as $tax): ?>
                                <th class="text-center">
                                    <?= html_escape($tax['tax']) ?>
                                    (<?= html_escape($tax['tax_rate']) ?>%)
                                </th>
                            <?php endforeach; ?>

                            <!-- Payment columns -->
                            <?php foreach ($payment_methods as $method): ?>
                                <th class="text-center">
                                    <?= html_escape($method->name) ?> Amt
                                </th>
                            <?php endforeach; ?>

                           
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Grand totals
                        $totalPayable = 0;
                        $disAmount = 0;
                        $totalsTax = [];
                        foreach ($tax_settings as $t) {
                            $totalsTax[$t['tax']] = 0;
                        }

                        if (!empty(@$saleReport)):
                            foreach ($saleReport as $row):
                                $totalPayable += $row->total_payable;
                                $disAmount += $row->total_discount_amount;

                                // --- Safe parse of grouped tax JSON ---
                                $raw = $row->sale_vat_objects_grouped ?? '';
                                $parts = $raw !== '' ? explode('|||', $raw) : [];
                                $daily = array_fill_keys(array_keys($totalsTax), 0);

                                foreach ($parts as $json) {
                                    if (trim($json) === '')
                                        continue;
                                    $objs = json_decode($json, true);
                                    if (!is_array($objs))
                                        continue;
                                    foreach ($objs as $o) {
                                        $type = $o['tax_field_type'] ?? null;
                                        $amt = (float) ($o['tax_field_amount'] ?? 0);
                                        if (isset($daily[$type])) {
                                            $daily[$type] += $amt;
                                            $totalsTax[$type] += $amt;
                                        }
                                    }
                                }
                                // --- end parse ---
                                ?>
                                <tr>
                                    <td><?= date('d-m-Y', strtotime($row->sale_date)) ?></td>
                                    <td class="text-center"><?= getAmtCustom($row->total_payable) ?></td>
                                    <td class="text-center"><?= getAmtCustom($row->total_discount_amount) ?></td>

                                    <!-- taxes -->
                                    <?php foreach ($tax_settings as $tax):
                                        $amt = $daily[$tax['tax']] ?? 0;
                                        ?>
                                        <td class="text-center"><?= getAmtCustom($amt) ?></td>
                                    <?php endforeach; ?>

                                    <!-- payments -->
                                    <?php foreach ($payment_methods as $method):
                                        $fld = 'total_' . strtolower(str_replace(' ', '_', $method->name)) . '_amount';
                                        $fld = preg_replace('/[^a-z0-9_]/', '', $fld);
                                        $amt = $row->$fld ?? 0;
                                        ?>
                                        <td class="text-center"><?= getAmtCustom($amt) ?></td>
                                    <?php endforeach; ?>

                                    
                                </tr>
                                <?php
                            endforeach;
                        endif;
                        ?>

                        <!-- Grand-total row -->
                        <tr>
                            <th class="text-right"><?= lang('total') ?></th>
                            <th class="text-center"><?= getAmtCustom($totalPayable) ?></th>
                            <th class="text-center"><?= getAmtCustom($disAmount) ?></th>

                            <?php foreach ($tax_settings as $tax):
                                $amt = $totalsTax[$tax['tax']] ?? 0;
                                ?>
                                <th class="text-center"><?= getAmtCustom($amt) ?></th>
                            <?php endforeach; ?>

                            <!-- payment totals -->
                            <?php foreach ($payment_methods as $method):
                                $fld = 'total_' . strtolower(str_replace(' ', '_', $method->name)) . '_amount';
                                $fld = preg_replace('/[^a-z0-9_]/', '', $fld);
                                $amt = array_sum(array_column($saleReport, $fld));
                                ?>
                                <th class="text-center"><?= getAmtCustom($amt) ?></th>
                            <?php endforeach; ?>

                            <!-- tax totals -->
                            
                        </tr>
                    </tbody>
                </table>

            </div>
            <!-- /.box-body -->
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
        <?php echo form_open(base_url() . 'Report/summarySalesReport', $arrayName = array('id' => 'saleReport')) ?>
        <div class="row">
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <input autocomplete="off" type="text" name="startDate" id="startDate" readonly
                        class="form-control customDatepicker" placeholder="<?php echo lang('start_date'); ?>"
                        value="<?php echo set_value('startDate'); ?>">
                </div>
                <div class="alert alert-error error-msg startDate_err_msg_contnr ">
                    <p id="startDate_err_msg"></p>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <input autocomplete="off" type="text" id="endDate" name="endDate" readonly
                        class="form-control customDatepicker" placeholder="<?php echo lang('end_date'); ?>"
                        value="<?php echo set_value('endDate'); ?>">
                </div>
                <div class="alert alert-error error-msg endDate_err_msg_contnr ">
                    <p id="endDate_err_msg"></p>
                </div>
            </div>
            <?php
            if (isLMni()):
                ?>
                <div class="col-sm-12 col-md-6 mb-2">
                    <div class="form-group">
                        <select class="form-control select2 ir_w_100" id="outlet_id" name="outlet_id">
                            <?php
                            $role = $this->session->userdata('role');
                            if ($role == '1') {
                                ?>
                                <option value=""><?php echo lang('select_outlet') ?></option>
                            <?php } ?>
                            <?php
                            $outlets = getOutletsForReport();
                            foreach ($outlets as $value):
                                ?>
                                <option <?= set_select('outlet_id', $value->id) ?>
                                    value="<?php echo escape_output($value->id) ?>">
                                    <?php echo escape_output($value->outlet_name) ?>
                                </option>
                                <?php
                            endforeach;
                            ?>
                        </select>
                    </div>
                </div>
                <?php
            endif;
            ?>
            <div class="clear-fix"></div>
            <div class="col-12 mb-2">
                <button type="submit" name="submit" value="submit" class="new-btn saleReport">
                    <iconify-icon icon="solar:hourglass-broken" width="22"></iconify-icon>
                    <?php echo lang('submit'); ?>
                </button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>




<?php $this->view('updater/reuseJs_w_pagination'); ?>
<script src="<?php echo base_url(); ?>frequent_changing/js/report-js/master_report_validation.js"></script>