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
                <h3 class="top-left-header"><?php echo lang('list_expense'); ?> </h3>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('list_expense'); ?>" data-id_name="datatable">
                <div class="btn_list m-right d-flex">
                    <a class="new-btn me-1" href="<?php echo base_url() ?>Expense/addEditExpense">
                    <iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon> <?php echo lang('add_expense'); ?>
                    </a>
                    <button type="button" class="dataFilterBy new-btn"><iconify-icon icon="solar:filter-broken"  width="22"></iconify-icon> <?php echo lang('filter_by');?></button>
                </div>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('expense'), 'secondSection'=> lang('list_expense')])?>
        </div>
    </section>

    
    <div class="box-wrapper">
        <div class="table-box">
            <div class="table-responsive">
                <table id="datatable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="w-5"><?php echo lang('sn'); ?></th>
                            <th class="w-10"><?php echo lang('date'); ?></th>
                            <th class="w-10 text-center"><?php echo lang('amount'); ?></th>
                            <th class="w-10"><?php echo lang('category'); ?></th>
                            <th class="w-10"><?php echo lang('payment_methods'); ?></th>
                            <th class="w-15"><?php echo lang('responsible_person'); ?></th>
                            <th class="w-20"><?php echo lang('note'); ?></th>
                            <th class="w-10"><?php echo lang('added_by'); ?></th>
                            <th class="w-10"><?php echo lang('added_date'); ?></th>
                            <th class="w-5"><?php echo lang('actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if ($expenses && !empty($expenses)) {
                                $i = count($expenses);
                            }
                            foreach ($expenses as $expnss) {
                            ?>
                        <tr>
                            <td class="op_center"><?php echo $i--; ?></td>
                            <td><?php echo date($this->session->userdata('date_format'), strtotime($expnss->date)); ?>
                            </td>
                            <td class="text-center"><?php echo getAmtCustom($expnss->amount); ?></td>
                            <td><?php echo expenseItemName($expnss->category_id); ?></td>
                            <td><?php echo getPaymentName($expnss->payment_method_id); ?></td>
                            <td><?php echo employeeName($expnss->employee_id); ?></td>
                            <td><?php if ($expnss->note != NULL) echo escape_output($expnss->note); ?></td>
                            <td><?php echo escape_output($expnss->added_by); ?></td>
                            <td><?php echo date($this->session->userdata('date_format'), strtotime($expnss->added_date != '' ? $expnss->added_date : '')); ?></td>
                            <td class="text-center">
                                <div class="btn_group_wrap">
                                    <a class="btn btn-warning" href="<?php echo base_url() ?>Expense/addEditExpense/<?php echo $this->custom->encrypt_decrypt($expnss->id, 'encrypt'); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-original-title="<?php echo lang('edit'); ?>">
                                        <i class="far fa-edit"></i>
                                    </a>
                                    <a class="delete btn btn-danger" href="<?php echo base_url() ?>Expense/deleteExpense/<?php echo $this->custom->encrypt_decrypt($expnss->id, 'encrypt'); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('delete'); ?>">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </a>
                                </div>

                            </td>
                        </tr>
                        <?php }  ?>
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
        <?php echo form_open(base_url() . 'Expense/expenses') ?>
        <div class="row">
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <input  autocomplete="off" type="text" id="startDate" name="startDate" readonly class="form-control customDatepicker" placeholder="<?php echo lang('start_date'); ?>" value="<?php echo isset($_POST['startDate']) && $_POST['startDate'] ? $_POST['startDate'] : '' ?>">
                </div>
                <div class="alert alert-error error-msg startDate_err_msg_contnr ">
                    <p id="startDate_err_msg"></p>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <input  autocomplete="off" type="text" id="endDate" name="endDate" readonly class="form-control customDatepicker" placeholder="<?php echo lang('end_date'); ?>" value="<?php echo isset($_POST['endDate']) && $_POST['endDate'] ? $_POST['endDate'] : '' ?>">
                </div>
                <div class="alert alert-error error-msg endDate_err_msg_contnr ">
                    <p id="endDate_err_msg"></p>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 mb-2">
                <div class="form-group">
                    <select  class="form-control select2 op_width_100_p" id="user_id" name="user_id">
                        <?php
                            $role = $this->session->userdata('role');
                            if($role == '1'){
                        ?>
                        <option value=""><?php echo lang('select_employee') ?></option>
                        <?php } ?>
                        <?php foreach ($users as $value) { ?>
                            <option 
                                <?php echo (isset($user_id) && $user_id == $value->id) ? 'selected' : set_select('user_id', $value->id); ?>  
                                value="<?php echo escape_output($value->id); ?>">
                                <?php echo escape_output($value->full_name); ?>
                            </option>
                        <?php } ?>
                    </select>
                    <div class="alert alert-error error-msg user_id_err_msg_contnr ">
                        <p id="user_id_err_msg"></p>
                    </div>
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



<?php $this->view('updater/reuseJs')?>
