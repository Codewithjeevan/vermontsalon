<!-- Trac Order page -->
<div class="section_padding_b trac_order_page">
    <div class="container">
        <div class="seconpage_banner">
            <h2><?php echo lang('Trac_Your_Order');?></h2>
            <div class="breadcrumbs">
                <a href="javascript:void(0)"><i class="las la-home"></i></a>
                <a href="javascript:void(0)" class="active"><?php echo lang('Trac_Order');?></a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 m-auto">
                <form action="<?php echo base_url('e-track-order'); ?>" method="POST" class="row tract_form">
                    <div class="col-7 col-md-7 col-lg-8">
                        <div class="form-group">
                            <input type="text" name="order_number" class="form-control" placeholder="<?php echo lang('Enter_Order_No');?>" required>
                        </div>
                    </div>
                    <div class="col-5 col-md-5 col-lg-4">
                        <button name="submit" value="submit" type="submit" class="default_btn xs_btn rounded"><?php echo lang('Trac_Order');?></button>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <img src="<?php echo base_url()?>frequent_changing/eCommerce/frontend/images/image 12.png" alt="img" class="img-fluid">
            </div>
        </div>
    </div>
</div>
