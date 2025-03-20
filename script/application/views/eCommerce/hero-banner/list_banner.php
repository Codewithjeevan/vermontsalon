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
                <h3 class="top-left-header"><?php echo lang('list_banner'); ?> </h3>
                <input type="hidden" class="datatable_name" data-title="<?php echo lang('list_banner'); ?>" data-id_name="datatable">
                <div class="btn_list m-right d-flex">
                    <a class="new-btn me-1" href="<?php echo base_url() ?>ECommerce_setting/sortBanner">
                        <iconify-icon icon="solar:checklist-broken" width="22"></iconify-icon> <?php echo lang('banner_sorting'); ?>
                    </a>
                    <a class="new-btn me-1" href="<?php echo base_url() ?>ECommerce_setting/addEditBanner">
                        <iconify-icon icon="solar:add-circle-broken" width="22"></iconify-icon> <?php echo lang('add_banner'); ?>
                    </a>
                </div>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('banner'), 'secondSection'=> lang('list_banner')])?>
        </div>
    </section>

    
    <div class="box-wrapper">
        <div class="table-box">
            <div class="table-responsive">
                <table id="datatable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="w-5"><?php echo lang('sn'); ?></th>
                            <th class="w-30"><?php echo lang('banner_img'); ?></th>
                            <th class="w-30"><?php echo lang('banner_heading'); ?></th>
                            <th class="w-30"><?php echo lang('banner_title'); ?></th>
                            <th class="w-30"><?php echo lang('button_text'); ?></th>
                            <th class="w-30"><?php echo lang('button_link'); ?></th>
                            <th class="w-20"><?php echo lang('added_by'); ?></th>
                            <th class="w-10"><?php echo lang('added_date'); ?></th>
                            <th class="w-5"><?php echo lang('actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if ($list_banners && !empty($list_banners)) {
                                $i = count($list_banners);
                            }
                            foreach ($list_banners as $banner) {
                            ?>
                        <tr>
                            <td class="op_center"><?php echo $i--; ?></td>
                            <td>
                                <?php
                                $file_path = FCPATH . 'uploads/eCommerce/banners/'. $banner->banner_img;
                                $file_path2 = base_url().'uploads/eCommerce/banners/'. $banner->banner_img;
                                if(file_exists($file_path) && $banner->banner_img){ ?>
                                    <img src="<?php echo $file_path2; ?>" width="200" height="100" alt="banner-img" class="border-dashes_eaeaea img-fluid object-fit-cover">
                                <?php } else {?>
                                    <img src="<?php echo base_url();?>uploads/site_settings/Gallery-PNG-File.png" width="200" height="100" alt="banner-img" class="border-dashes_eaeaea img-fluid object-fit-cover">
                                <?php  } ?>
                            </td>
                            <td><?php echo escape_output($banner->banner_heading); ?></td>
                            <td><?php echo escape_output($banner->banner_title); ?></td>
                            <td><?php echo escape_output($banner->button_text); ?></td>
                            <td><?php echo escape_output($banner->button_link); ?></td>
                            <td><?php echo escape_output($banner->added_by); ?></td>
                            <td><?php echo dateFormat($banner->added_date); ?></td>
                            <td class="text-center">
                                <div class="btn_group_wrap">
                                    <a class="btn btn-warning" href="<?php echo base_url() ?>ECommerce_setting/addEditBanner/<?php echo $this->custom->encrypt_decrypt($banner->id, 'encrypt'); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-original-title="<?php echo lang('edit'); ?>">
                                        <i class="far fa-edit"></i>
                                    </a>
                                    <a class="delete btn btn-danger" href="<?php echo base_url() ?>ECommerce_setting/deleteBanner/<?php echo $this->custom->encrypt_decrypt($banner->id, 'encrypt'); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="<?php echo lang('delete'); ?>">
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
<?php $this->view('updater/reuseJs')?>
