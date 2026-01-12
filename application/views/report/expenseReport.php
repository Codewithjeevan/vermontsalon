<!-- shuvo -->
<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/report.css">
<style>
    .category-header-cell {
        background-color: #f3f4f6;
        font-weight: 600;
        border-top: 1px solid #e1e1e1;
    }
    .category-header-cell.empty-cell {
        padding: 0;
        border: none;
        visibility: hidden;
    }
    .category-total-row td {
        background-color: #fdfdfd;
        font-weight: 600;
    }
    .category-row td {
        border-top: 2px solid transparent;
    }
</style>

<div class="main-content-wrapper">

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mt-2"><?php echo lang('expense_report'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('report'), 'secondSection'=> lang('expense_report')])?>
        </div>
    </section>


    <div class="box-wrapper">
        <?php
        $groupedExpenses = [];
        $grandTotal = 0;
        if (isset($expenseReport) && !empty($expenseReport)) {
            foreach ($expenseReport as $expense) {
                $categoryName = trim($expense->categoryName);
                if ($categoryName === '') {
                    $categoryName = lang('expense_category');
                }
                if (!isset($groupedExpenses[$categoryName])) {
                    $groupedExpenses[$categoryName] = [
                        'items' => [],
                        'total' => 0,
                    ];
                }
                $groupedExpenses[$categoryName]['items'][] = $expense;
                $groupedExpenses[$categoryName]['total'] += $expense->amount;
                $grandTotal += $expense->amount;
            }
        }
        ?>
    
        <!-- Report Header Start -->
        <div class="report_header">
            <h3 class="company_name"><?php echo escape_output($this->session->userdata('business_name'));?> </h3>
            <h5 class="outlet_info">
                <strong><?php echo lang('expense_report'); ?></strong>
            </h5>
            <?php if(isset($outlet_id) && $outlet_id){
                $outlet_info = getOutletInfoById($outlet_id); 
            }?>
            <h5 class="outlet_info">
                <?php if(isset($outlet_id) && $outlet_id){ ?>
                    <strong><?php echo lang('outlet'); ?>: </strong> <?= escape_output($outlet_info->outlet_name); ?>
                <?php }?>
            </h5>
            <h5 class="outlet_info">
                <?php if(isset($outlet_id) && $outlet_id){ ?>
                    <strong><?php echo lang('address'); ?>: </strong> <?= escape_output($outlet_info->address); ?>
                <?php } ?>
            </h5>
            <h5 class="outlet_info">
                <?php if(isset($outlet_id) && $outlet_id){ ?>
                    <strong><?php echo lang('email'); ?>: </strong> <?= escape_output($outlet_info->email); ?>
                <?php } ?>
            </h5>
            <h5 class="outlet_info">
                <?php if(isset($outlet_id) && $outlet_id){ ?>
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
                <?php if(isset($expense_item_id) && $expense_item_id){ ?>
                    <strong><?php echo lang('expense_category'); ?>: </strong> <?php echo getExpenseCategoryName($expense_item_id); ?>
                <?php } ?>
            </h5>
            <h5 class="outlet_info">
                <?php if(isset($report_generate_time) && $report_generate_time){
                    echo $report_generate_time;
                } ?>
            </h5>
        </div>
        <!-- Report Header End -->



        <div class="table-box">
            <div class="table-actions mb-3 d-flex justify-content-between">
                <div></div>
                <div>
                    <button type="button" class="dataFilterBy new-btn manual-filter-btn">
                        <iconify-icon icon="solar:filter-broken" width="22"></iconify-icon>
                        <?php echo lang('filter_by'); ?>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                <input type="hidden" class="datatable_name"  data-filter="yes" data-title="<?php echo lang('expense_report'); ?>" data-id_name="datatable">
                    <table id="datatable"  class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="w-5"><?php echo lang('sn'); ?></th>
                                <th><?php echo lang('reference_no'); ?></th>
                                <th><?php echo lang('date_and_time'); ?></th>
                                <th class="text-center"><?php echo lang('amount'); ?></th>
                                <th><?php echo lang('category'); ?></th>
                                <th><?php echo lang('responsible_person'); ?></th>
                                <th><?php echo lang('note'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($groupedExpenses)): ?>
                                <?php $sn = 1; ?>
                                <?php foreach ($groupedExpenses as $categoryName => $categoryData): ?>
                                    <tr class="category-row">
                                        <td class="category-header-cell">
                                            <strong><?php echo lang('category'); ?>:</strong> <?php echo escape_output($categoryName); ?>
                                        </td>
                                        <?php for ($i = 1; $i < 7; $i++): ?>
                                            <td class="category-header-cell empty-cell"></td>
                                        <?php endfor; ?>
                                    </tr>
                                    <?php foreach ($categoryData['items'] as $expense): ?>
                                        <tr>
                                            <td><?php echo $sn++; ?></td>
                                            <td><?php echo escape_output($expense->reference_no); ?></td>
                                            <td><?php echo dateFormat($expense->added_date); ?></td>
                                            <td class="text-center"><?php echo getAmtCustom($expense->amount); ?></td>
                                            <td><?php echo escape_output($expense->categoryName); ?></td>
                                        <td><?php echo escape_output($expense->EmployeedName); ?></td>
                                        <td><?php echo !empty($expense->note) ? escape_output($expense->note) : '-'; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tr class="category-total-row">
                                        <td></td>
                                        <td></td>
                                        <td class="op_right"><?php echo lang('total'); ?></td>
                                        <td class="text-center"><?php echo getAmtCustom($categoryData['total']); ?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">
                                        <?php echo lang('no_data_found'); ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <tr>
                                <th></th>
                                <th></th>
                                <th class="op_right"><?php echo lang('total'); ?> </th>
                                <th class="text-center"><?php echo getAmtCustom($grandTotal) ?></th>
                                <th></th>
                                <th></th>
                                <th></th>
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
        <?php echo form_open(base_url() . 'Report/expenseReport') ?>
        <div class="row">
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <input  autocomplete="off" type="text" name="startDate" readonly class="form-control customDatepicker" placeholder="<?php echo lang('start_date'); ?>" value="<?php echo set_value('startDate'); ?>">
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <input  autocomplete="off" type="text" id="endMonth" name="endDate" readonly class="form-control customDatepicker" placeholder="<?php echo lang('end_date'); ?>" value="<?php echo set_value('endDate'); ?>">
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <select  class="form-control select2 op_width_100_p" id="expense_item_id" name="expense_item_id">
                        <option value=""><?php echo lang('expense_category'); ?></option>
                        <?php
                        foreach ($expense_items as $value) {
                            ?>
                            <option value="<?php echo escape_output($value->id) ?>" <?php echo set_select('expense_item_id', $value->id); ?>><?php echo escape_output($value->name) ?></option>
                        <?php } ?>
                    </select>
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
            <div class="col-12 mb-2">
                <button type="submit" name="submit" value="submit" class="new-btn">
                    <iconify-icon icon="solar:hourglass-broken" width="22"></iconify-icon>
                    <?php echo lang('submit'); ?>
                </button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

<?php $this->view('updater/reuseJs_w_pagination'); ?>

