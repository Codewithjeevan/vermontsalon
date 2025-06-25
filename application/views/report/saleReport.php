<input type="hidden" value="<?php echo lang('The_date_field_is_required');?>" id="The_date_field_is_required">
<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/report.css">
<div class="main-content-wrapper">

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('food_sales_report'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('report'), 'secondSection'=> lang('food_sales_report')])?>
        </div>
    </section>


    <div class="box-wrapper">
        <!-- Report Header Start -->
        <div class="report_header">
            <h3 class="company_name">
                <?php echo escape_output($this->session->userdata('business_name'));?> 
            </h3>
            <h5 class="outlet_info">
                <strong><?php echo lang('food_sales_report'); ?></strong>
            </h5>
            <?php if(isset($outlet_id)  && $outlet_id){
                $outlet_info = getOutletInfoById($outlet_id); 
            }?>
            <h5 class="outlet_info">
                <?php if(isset($outlet_id) && $outlet_id){ ?>
                    <strong><?php echo lang('outlet'); ?>: </strong> <?= escape_output($outlet_info->outlet_name); ?>
                <?php }?>
            </h5>
            <h5 class="outlet_info ">
                <?php if(isset($outlet_id)  && $outlet_id){ ?>
                    <strong><?php echo lang('address'); ?>: </strong> <?= escape_output($outlet_info->address); ?>
                <?php } ?>
            </h5>
            <h5 class="outlet_info">
                <?php if(isset($outlet_id)  && $outlet_id){ ?>
                    <strong><?php echo lang('email'); ?>: </strong> <?= escape_output($outlet_info->email); ?>
                <?php } ?>
            </h5>
            <h5 class="outlet_info">
                <?php if(isset($outlet_id)  && $outlet_id){ ?>
                    <strong><?php echo lang('phone'); ?>: </strong> <?= escape_output($outlet_info->phone); ?>
                <?php } ?>
            </h5>
            <?php if(isset($start_date) && $start_date != '' && $start_date != '1970-01-01' || isset($end_date) && $end_date != '' && $end_date != '1970-01-01'){ ?>
            <h5 class="outlet_info">
                <strong><?php echo lang('date');?>:</strong>
                <?php
                    if(!empty($start_date) && $start_date != '1970-01-01') {
                        echo dateFormat($start_date);
                    }
                    if((isset($start_date) && isset($end_date)) && ($start_date != '1970-01-01' && $end_date != '1970-01-01')){
                        echo ' - ';
                    }
                    if(!empty($end_date) && $end_date != '1970-01-01') {
                        echo dateFormat($end_date);
                    }
                ?>
            </h5>
            <?php } ?>
            <h5 class="outlet_info">
                <?php if(isset($report_generate_time) && $report_generate_time){
                    echo $report_generate_time;
                } ?>
            </h5>
        </div>
        <!-- Report Header End -->
        <div class="table-box">
            <!-- /.box-header -->
            <div class="table-responsive">
            <input type="hidden" class="datatable_name"  data-filter="yes" data-title="<?php echo lang('food_sales_report'); ?>" data-id_name="datatable">
      <table id="datatable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                        <th class="w-5"><?= lang('sn')          ?></th>
                        <th>     <?= lang('invoice_no')    ?></th>
                        <th>     <?= lang('date_and_time') ?></th>
                        <th>     <?= lang('items')         ?></th>    
                        <th class="text-center"><?= lang('bill_amt')          ?></th>
                        <th class="text-center"><?= lang('discount')      ?></th>
                        <!-- Dynamic tax headers -->
                        <?php foreach ($tax_settings as $tax): ?>
                            <th class="text-center">
                            <?= html_escape($tax['tax']) ?>
                            (<?= html_escape($tax['tax_rate']) ?>%)
                            </th>
                        <?php endforeach; ?>
                        <th class="text-center"><?= lang('net_amt_aed')      ?></th>
                        <th>     <?= lang('pay_mode') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // grand‐totals init
                        $totals = [
                            'sub_total'       => 0,
                            'charge'          => 0,
                            'discount'        => 0,
                            'total_payable'   => 0,
                            'paid_amount'     => 0,
                            'due_amount'      => 0,
                        ];
                        $taxTotals = [];
                        foreach ($tax_settings as $t) {
                            $taxTotals[$t['tax']] = 0;
                        }

                        if (! empty($saleReport)):
                            foreach ($saleReport as $i => $row):
                            // accumulate simple totals
                            $totals['sub_total']     += $row->sub_total;
                            $totals['charge']        += $row->delivery_charge;
                            $totals['discount']      += $row->total_discount_amount;
                            $totals['total_payable'] += $row->total_payable;
                            $totals['paid_amount']   += $row->paid_amount;
                            $totals['due_amount']    += $row->due_amount;

                            // parse this sale’s tax JSON
                            $perTax = array_fill_keys(array_keys($taxTotals), 0);
                            $json   = $row->sale_vat_objects ?: '[]';
                            $objs   = json_decode($json, true);
                            if (is_array($objs)) {
                                foreach ($objs as $o) {
                                $type = $o['tax_field_type']   ?? '';
                                $amt  = floatval($o['tax_field_amount'] ?? 0);
                                if (isset($perTax[$type])) {
                                    $perTax[$type]    += $amt;
                                    $taxTotals[$type] += $amt;
                                }
                                }
                            }
                        ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= escape_output($row->sale_no) ?></td>
                            <td><?= dateFormat($row->date_time)  ?></td>

                            <!-- Items list (as you had it) -->
                            <td>
                            <?php 
                                            $saleItems = getSaleReportItemsBySaleId($row->id);
                                            if($saleItems){
                                                foreach($saleItems as $item){
                                                    echo escape_output($item->name). '('. $item->qty . ')'. "<br>";
                                                }
                                            }
                                        ?>
                            </td>

                            <!-- comma-sep payment methods -->
                            
                            
                                <td class="text-center"><?= getAmtCustom($row->total_payable)        ?></td>
                                <td class="text-center"><?= getAmtCustom($row->total_discount_amount) ?></td>
                            <!-- per‐tax columns -->
                            <?php foreach ($tax_settings as $tax): ?>
                            <td class="text-center">
                                <?= getAmtCustom($perTax[$tax['tax']]) ?>
                            </td>
                            <?php endforeach; ?>
                            <td class="text-center"><?= getAmtCustom($row->sub_total) ?></td>
                            <td><?= escape_output($row->payment_methods) ?></td>
                        </tr>
                        <?php
                            endforeach;
                        endif;
                        ?>

                        <!-- footer row -->
                         <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th class="text-right"><?= lang('total') ?></th>

                            <th class="text-center"><?= getAmtCustom($totals['total_payable']) ?></th>
                            <th class="text-center"><?= getAmtCustom($totals['discount'])      ?></th>
                            <?php foreach ($tax_settings as $tax): ?>
                                <th class="text-center">
                                    <?= getAmtCustom($taxTotals[$tax['tax']]) ?>
                                </th>
                            <?php endforeach; ?>
                            <th class="text-center"><?= getAmtCustom($totals['sub_total'])     ?></th>
                            <th></th> <!-- placeholder for the Pay Mode column -->
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
        <?php echo form_open(base_url() . 'Report/saleReport', $arrayName = array('id' => 'saleReport')) ?>
        <div class="row">
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <input  autocomplete="off" type="text" name="startDate" id="startDate" readonly class="form-control customDatepicker" placeholder="<?php echo lang('start_date'); ?>" value="<?php echo set_value('startDate'); ?>">
                </div>
                <div class="alert alert-error error-msg startDate_err_msg_contnr ">
                    <p id="startDate_err_msg"></p>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <input  autocomplete="off" type="text" id="endDate" name="endDate" readonly class="form-control customDatepicker" placeholder="<?php echo lang('end_date'); ?>" value="<?php echo set_value('endDate'); ?>">
                </div>
                <div class="alert alert-error error-msg endDate_err_msg_contnr ">
                    <p id="endDate_err_msg"></p>
                </div>
            </div>
            <?php
                if(isLMni()):
            ?>
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <select  class="form-control select2 ir_w_100" id="outlet_id" name="outlet_id">
                        <?php
                            $role = $this->session->userdata('role');
                            if($role == '1'){
                        ?>
                        <option value=""><?php echo lang('select_outlet') ?></option>
                        <?php } ?>
                        <?php
                        $outlets = getOutletsForReport();
                        foreach ($outlets as $value):
                            ?>
                            <option <?= set_select('outlet_id',$value->id)?>  value="<?php echo escape_output($value->id) ?>"><?php echo escape_output($value->outlet_name) ?></option>
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
<script src="<?php echo base_url();?>frequent_changing/js/report-js/master_report_validation.js"></script>
