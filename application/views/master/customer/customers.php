<div class="main-content-wrapper">
    <?php
    if ($this->session->flashdata('exception')) {
        echo '<section class="alert-wrapper"><div class="alert alert-success alert-dismissible fade show"> 
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
    <div class="alert-body"><i class="icon fa fa-check me-2"></i>';
        echo escape_output($this->session->flashdata('exception'));
        unset($_SESSION['exception']);
        echo '</div></div></section>';
    }
    ?>
    <input type="hidden" id="base_url_hidden" value="<?php echo base_url(); ?>">

    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header"><?php echo lang('list_customer'); ?> </h3>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('list_customer'); ?>"
                    data-id_name="datatable">
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection' => lang('customer'), 'secondSection' => lang('list_customer')]) ?>
        </div>
    </section>


    <div class="box-wrapper">
        <div class="text-right d-flex justify-content-end">
            <a class="new-btn me-1" href="<?php echo base_url() ?>Customer/addEditCustomer">
                <iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon>
                <?php echo lang('add_customer'); ?>
            </a>
            <a class="new-btn me-1" href="<?php echo base_url() ?>customer/uploadCustomer">
                <iconify-icon icon="solar:cloud-upload-broken" width="22"></iconify-icon>
                <?php echo lang('upload_customer'); ?>
            </a>
            <a class="new-btn me-1" href="<?php echo base_url() ?>customer/debitCustomers">
                <iconify-icon icon="solar:minus-circle-broken" width="22"></iconify-icon>
                <?php echo lang('debit_customers'); ?>
            </a>
            <a class="new-btn me-1" href="<?php echo base_url() ?>customer/creditCustomers">
                <iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon>
                <?php echo lang('credit_customers'); ?>
            </a>
        </div>


        <div class="table-box">
            <!-- /.box-header -->
            <div class="table-responsive">
                <table id="customerdatatable" class="table table-bordered table-striped customers_ajax_page">
                    <thead>
                        <tr>
                            <th class="op_width_1_p op_center"><?php echo lang('id'); ?></th>
                            <th class="w-15"><?php echo lang('customer_name'); ?></th>
                            <th class="w-10"><?php echo lang('phone'); ?></th>
                            <th class="w-10"><?php echo lang('email'); ?></th>
                            <th class="w-10 text-center"><?php echo lang('opening_balance'); ?></th>
                            <th class="w-10"><?php echo lang('added_by'); ?></th>
                            <th class="w-10"><?php echo lang('added_date'); ?></th>
                            <th class="w-5 text-center"><?php echo lang('actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('updater/reuseJs2')?>
<script src="<?php echo base_url(); ?>frequent_changing/js/customers.js"></script>