<input type="hidden" value="<?php echo lang('The_date_field_is_required');?>" id="The_date_field_is_required">
<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/report.css">
<style>
    .dataTable thead tr th:last-child{
        text-align: center !important;
    }
    .dataTable tbody tr td:last-child{
        text-align: center !important;
    }
</style>
<div class="main-content-wrapper">

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('therapist_report'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('report'), 'secondSection'=> lang('therapist_report')])?>
        </div>
    </section>


    <div class="box-wrapper">
        <!-- Report Header Start -->
        <div class="report_header">
            <h3 class="company_name">
                <?php echo escape_output($this->session->userdata('business_name'));?> 
            </h3>
            <h5 class="outlet_info">
                <strong><?php echo lang('therapist_report'); ?></strong>
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
            <h5 class="outlet_info" >
                <?php if(isset($userdata)  && $userdata){ ?>
                    <strong><?php echo lang('therapist'); ?>: </strong> <span id="therapist_name"><?= escape_output($userdata->full_name); ?></span>
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
            <input type="hidden" class="datatable_name"  data-filter="yes" data-title="<?php echo lang('therapist_report'); ?>" data-id_name="datatable">
                <table id="datatable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center" style="text-align: center !important;"><?php echo lang('invoice_no'); ?></th>
                            <th>Items</th>
                            <th>Qty</th>
                            <th>Rate</th>
                            <th><?php echo lang('bill_amt'); ?></th>
                            <th>Dis.</th>
                            <th>Mode</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $totalPayable = 0;
                        $paidAmount = 0;
                        $dueAmount = 0;
                        $disAmount = 0;
                        $subTotal = 0;
                        $chargeTotal = 0;
                        $totalTax = 0;
                        $key = 0;
                        $totalAmounts = []; // store total per payment method
                        if (isset($saleReport)):
                            foreach ($saleReport as $key => $value) {
                                $key++;
                                $totalPayable += $value->total_payable;
                                $paidAmount += $value->paid_amount;
                                $dueAmount += $value->due_amount;
                                $disAmount += $value->total_discount_amount;
                                $subTotal += $value->sub_total;
                                $totalTax += $value->vat;
                                $chargeTotal += $value->delivery_charge;
                                $payments = explode(',', $value->payment_amounts);

                                foreach ($payments as $pay) {
                                    $pay = trim($pay);
                                    if (empty($pay)) continue;

                                    list($method, $amount) = explode(':', $pay);
                                    $method = trim($method);
                                    $amount = floatval(trim($amount));

                                    // Add amount to total
                                    if (!isset($totalAmounts[$method])) {
                                        $totalAmounts[$method] = 0;
                                    }
                                    $totalAmounts[$method] += $amount;
                                }
                                ?>
                                <tr>
                                    <td class="text-center" style="text-align: center !important;"><?php echo escape_output(@$value->sale_no); ?></td>
                                    <td><?php echo @$value->item_name; ?></td>
                                    <td>1</td>
                                    <td><?= getAmtCustom($value->total_payable) ?></td>
                                    <td><?php echo getAmtCustom(@$value->total_payable); ?></td>
                                    <td><?php echo getAmtCustom(@$value->total_discount_amount); ?></td>
                                    <td><?php echo $value->payment_methods; ?></td>
                                </tr>
                                <?php
                            }
                        endif;
                        ?>
                        <tr>
                            <th class="text-center" style="border-right: 0px;font-weight: bold"><?php echo lang('total'); ?></th>
                            <th style="border-left: 0px;"></th>
                            <th><?= $key ?></th>
                            <th><?= getAmtCustom($subTotal) ?></th>
                            <th><?php echo getAmtCustom($totalPayable); ?></th>
                            <th><?php echo getAmtCustom($disAmount); ?></th>
                            <th></th>
                        </tr>

                        
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>Discount</th>
                            <th><?php echo getAmtCustom($disAmount); ?></th>
                        </tr>
                        <?php foreach($totalAmounts as $method => $amount) { ?>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th><?= $method ?></th>
                            <th><?= $amount ?></th>
                        </tr>
                        <?php } ?>
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
        <?php echo form_open(base_url() . 'Report/therapistReport', $arrayName = array('id' => 'saleReport')) ?>
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
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <select  class="form-control select2 op_width_100_p" id="user_id" name="user_id">
                        <option value="">Select stylish</option>
                        <?php
                        foreach ($users as $value) {
                            ?>
                            <option value="<?php echo escape_output($value->id) ?>" <?php echo set_select('user_id', $value->id); ?>><?php echo escape_output($value->full_name) ?> <?= $value->phone ? '('. $value->phone .')' : '' ?></option>
                        <?php } ?>
                    </select>
                    <div class="alert alert-error error-msg user_id_err_msg_contnr ">
                        <p id="user_id_err_msg"></p>
                    </div>
                </div>
            </div>

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
