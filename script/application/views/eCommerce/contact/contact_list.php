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
                <h3 class="top-left-header"><?php echo lang('contact'); ?> </h3>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('contact_list'); ?>" data-id_name="datatable">
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('contact'), 'secondSection'=> lang('contact_list')])?>
        </div>
    </section>



    <div class="box-wrapper">
        <div class="table-box">
            <div class="table-responsive">
                <table id="datatable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="w-5"><?php echo lang('sn'); ?></th>
                            <th class="w-10"><?php echo lang('name'); ?></th>
                            <th class="w-15"><?php echo lang('email'); ?></th>
                            <th class="w-30"><?php echo lang('subject'); ?></th>
                            <th class="w-40"><?php echo lang('message'); ?></th>
                            <th class="w-5"><?php echo lang('actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                                if ($contacts && !empty($contacts)) {
                                    $i = count($contacts);
                                }
                                foreach ($contacts as $value) {
                                    ?>
                        <tr>
                            <td class="text-center"><?php echo $i--; ?></td>
                            <td><?php echo escape_output($value->name); ?></td>
                            <td><?php echo escape_output($value->email_phone); ?></td>
                            <td><?php echo escape_output($value->subject); ?></td>
                            <td><?php echo escape_output($value->message); ?></td>
                            <td>
                                <div class="btn_group_wrap">
                                    <a class="delete btn btn-danger" href="<?php echo base_url() ?>ECommerce_setting/deleteContact/<?php echo $this->custom->encrypt_decrypt($value->id, 'encrypt'); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('delete'); ?>">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $this->view('updater/reuseJs'); ?>