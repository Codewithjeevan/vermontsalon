<?php 
$invoice_configuration = $this->session->userdata('invoice_configuration');
$inv_config = json_decode($invoice_configuration);
?>

<style>
    .disabled-row>td:not(:last-child) {
        background-color: #e9ecef;
        pointer-events: none;
        opacity: 0.6;
    }
</style>

<script src="<?php echo base_url(); ?>frequent_changing/js/add_edit_package.js"></script>
<input type="hidden" id="print_format" value="<?php echo $inv_config->invoice_format_or_size; ?>">
<div class="main-content-wrapper">
<?php
    if ($this->session->flashdata('exception')) {
        echo '<section class="alert-wrapper">
        <div class="alert alert-success alert-dismissible fade show"> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <div class="alert-body">
        <i class="m-right fa fa-check"></i>';
        echo escape_output($this->session->flashdata('exception'));unset($_SESSION['exception']);
        echo '</div></div></section>';
    }
    ?>


    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <a href="<?php echo base_url('Sale/package'); ?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back </a>
                <h3 class="top-left-header mt-2"><?php echo lang('add_edit_sale_package'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('customer'), 'secondSection'=> lang('add_edit_sale_package')])?>
        </div>
    </section>

    <div style="display: none;">
        <select id="employee_id" name="employee_id[]" class="form-select" style="height: 45px;">
            <option value="">-Select Employee-</option>
            <?php foreach ($users as $key => $value) {
                echo '<option value="'.$value->id.'">'.$value->full_name.'</option>';
            } ?>
        </select>


    </div>


    <div class="box-wrapper">
        <div class="table-box">
            <?php echo form_open(base_url('Sale/addEditSalePackage')); ?>

            <div style="display: none;">
                <input type="date" id="purchase_date" name="purchase_date" value="<?php echo date('Y-m-d'); ?>">
                <input type="hidden" id="session_count" name="session_count" value="<?= @$editdata->session_count ? @$editdata->session_count : 0 ?>">
                <input type="hidden" id="outlet_id" name="outlet_id" value="<?= $this->session->userdata('outlet_id'); ?>">
                <input type="hidden" id="user_id" name="user_id" value="<?= $this->session->userdata('user_id'); ?>">
                <input type="hidden" id="edit_id" name="edit_id" value="<?= @$editdata->id ? @$editdata->id : NULL ?>">
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('select_customer'); ?> <span class="required_star">*</span></label>
                            <select id="walk_in_customer" name="customer_id"  required class="customer_data" tabindex="2"></select>
                        </div>
                        <?php if (form_error('name')) { ?>
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph"><?php echo form_error('name'); ?></span>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('select_pacakge'); ?> <span class="required_star">*</span></label>
                            <select id="select_pacakge" name="package_id"  class="package_data select2" required tabindex="2">
                                <option value=""><?php echo lang('select_pacakge'); ?></option>
                                <?php foreach ($packages as $item) { ?>
                                    <option
                                        value="<?php echo escape_output($item->id) ?>"
                                        data-session="<?php echo $item->session_count ?>"
                                        data-price="<?php echo $item->sale_price ?>"
                                        <?php if (@$editdata->package_id == $item->id) { echo 'Selected'; } ?>
                                    ><?php echo escape_output($item->name) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <?php if (form_error('name')) { ?>
                        <div class="callout callout-danger my-2">
                            <span class="error_paragraph"><?php echo form_error('name'); ?></span>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="session_id">Session List</label>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="session_table">
                                    <thead>
                                        <tr>
                                            <th><?php echo lang('session'); ?></th>
                                            <th><?php echo lang('price'); ?></th>
                                            <th><?php echo lang('employee'); ?></th>
                                            <th><?php echo lang('in_time'); ?></th>
                                            <th><?php echo lang('out_time'); ?></th>
                                            <th><?php echo lang('status'); ?></th>
                                            <th><?php echo lang('invoice'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody id="session_table_body">
                                        <?php 
                                            if(isset($editdata->sessions) && count(@$editdata->sessions) > 0){
                                                foreach(@$editdata->sessions as $key => $value){ ?>
                                                    <tr class="<?= $value->status == '1' ? 'disabled-row' : '' ?>"
                                                        data-employee-id="<?= escape_output($value->employee_id) ?>"
                                                        data-in-time="<?= escape_output($value->in_time) ?>"
                                                        data-out-time="<?= escape_output($value->out_time) ?>">
                                                        <td>
                                                            <input type="text" name="session_name[]" class="form-control" value="<?php echo  $value->session_name ? escape_output($value->session_name) : 'Session '.($key+1).''; ?>" readonly>
                                                            <input type="hidden" name="session_id[]" value="<?php echo escape_output($value->session_id); ?>">
                                                            <input type="hidden" name="pack_session_id[]" value="<?php echo escape_output($value->id); ?>">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="session_price[]" class="form-control" value="<?php echo escape_output($value->price); ?>" readonly>
                                                        </td>
                                                        <td>
                                                            <select name="employee_id[]" class="form-select employee_select" style="height: 45px;">
                                                                <option value=""><?php echo lang('select_employee'); ?></option>
                                                                <?php foreach ($users as $user) { ?>
                                                                    <option value="<?php echo escape_output($user->id); ?>" <?= $value->employee_id == $user->id ? 'Selected' : '' ?>><?php echo escape_output($user->full_name); ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="datetime-local" name="in_time[]" class="form-control" value="<?php echo escape_output($value->in_time); ?>">
                                                        </td>
                                                        <td>
                                                            <input type="datetime-local" name="out_time[]" class="form-control" value="<?php echo escape_output($value->out_time); ?>">
                                                        </td>
                                                        <td>
                                                            <select name="status[]" class="form-select" style="height: 45px;" data-current-status="<?php echo escape_output($value->status); ?>">
                                                                <option value="0" <?= $value->status == '0' ? 'Selected' : '' ?>>Available</option>
                                                                <option value="1" <?= $value->status == '1' ? 'Selected' : '' ?>>Used</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn bg-blue-btn" onclick="printInvoice('<?php echo $value->id; ?>')">
                                                                <iconify-icon icon="bi:printer-fill"></iconify-icon>
                                                            </button>
                                                        </td>
                                                    </tr>
                                        <?php   }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('total'); ?></label>
                            <input type="text" readonly id="total" name="total_amt" class="form-control" value="<?= @$editdata->total_amt ?? 0 ?>" readonly/>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label><?php echo lang('advance_payment'); ?> <span class="required_star">*</span></label>
                            <select id="payment_method" name="payment_method"  class="select2" tabindex="2">
                                <option value="Cash" <?= @$editdata->payment_method == "Cash" || @$editdata->payment_method == "" ? 'Selected' : '' ?>>Cash</option>
                                <option value="Card" <?= @$editdata->payment_method == "Card" ? 'Selected' : '' ?>>Card</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex gap-3">
                        <div class="form-group">
                            <label for="">&nbsp;</label>
                            <button class="btn bg-blue-btn" <?= @$editdata->status == 1 || @$editdata->status == 2 ? 'disabled' : '' ?>>Pay Now</button>
                        </div>
                        <?php if(@$editdata && @$editdata->status == 0) : ?>
                        <div class="form-group">
                            <label for="">&nbsp;</label>
                            <button type="button" onclick="cancelnow('<?= bin2hex(@$editdata->id) ?>')" id="cancel_now" class="btn bg-red-btn" >Cancel Now</button>
                        </div>
                        <?php endif; ?>
                        <?php if(@$editdata) : ?>
                        <div>
                            <label for="">&nbsp;</label>
                            <button class="btn bg-blue-btn" type="button" onclick="printAdvanceInvoice('<?= bin2hex(@$editdata->id) ?>')" >Print Invoice</button>                           
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <?php if(@$editdata && @$editdata->status == 2) : ?>
                    <div class="col-md-12">
                        <h5 class="text-danger">This package is cancelled</h5>
                        <p class="m-0">Cancelled At: <?= date('d M Y', strtotime(@$editdata->cancelled_at)); ?></p>
                        <p class="m-0">Reason: <?= @$editdata->note ?></p>
                        <p class="m-0">Remaning Balance: <?= @$editdata->remaining_amount ?></p>
                        <p class="m-0">Remaning Session: <?= @$editdata->remaining_session ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- <div class="box-footer">
            <button type="submit" name="submit" value="submit" class="btn bg-blue-btn">
                <iconify-icon icon="solar:upload-minimalistic-broken"></iconify-icon>
                <?php echo lang('submit'); ?>
            </button>
            <input type="hidden" id="set_save_and_add_more" name="add_more">
            <button type="submit" name="submit" value="submit" class="btn bg-blue-btn" id="save_and_add_more">
                <iconify-icon icon="solar:undo-right-round-broken"></iconify-icon>
                <?php echo lang('save_and_add_more'); ?>
            </button>
            <a class="btn bg-blue-btn text-decoration-none" href="<?php echo base_url() ?>Customer/customers">
                <iconify-icon icon="solar:undo-left-round-broken"></iconify-icon>
                <?php echo lang('back'); ?>
            </a>
        </div> -->
        <?php echo form_close(); ?>
    </div>
</div>

<script>
    
    $(document).ready(function () {
        const $first = $('#walk_in_customer');
        getAllCustomers($first, <?= @$editdata->customer_id ?>, true);
    });
    
</script>
