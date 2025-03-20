<link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/local/jquery-ui.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>frequent_changing/css/drag_drop.css">
<div class="main-content-wrapper">
    <div id="ajax-message"></div>
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
                <h3 class="top-left-header mt-2"><?php echo lang('banner_sorting'); ?></h3>
            </div>
            <?php $this->view('updater/breadcrumb', ['firstSection'=> lang('banner'), 'secondSection'=> lang('banner_sorting')])?>
        </div>
    </section>


    <div class="box-wrapper">
        <div class="table-box">
            <div>
                <ul class="sort_banner list-group">
                    <?php 
                        foreach ($banners as $banner){ 
                    ?>
                        <li class="list-group-item"  data-id="<?php echo escape_output($banner->id) ?>">
                            <span class="handle">
                                <iconify-icon icon="jam:move" width="16"></iconify-icon>
                            </span>
                            <img src="<?php echo base_url();?>uploads/eCommerce/banners/<?php echo $banner->banner_img;?>" alt="banner-img" width="100" height="60">
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/plugins/jQueryUI/jquery-ui.min.js"></script>
<script src="<?php echo base_url(); ?>frequent_changing/eCommerce/js/banner_sorting.js"></script>
