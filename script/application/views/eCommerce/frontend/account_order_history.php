<!-- breadcrumbs -->
<div class="container">
    <div class="breadcrumbs">
        <a href="<?php echo base_url('e-home');?>"><i class="las la-home"></i></a>
        <a href="<?php echo base_url('e-account');?>"><?php echo lang('my_account');?></a>
        <a href="<?php echo base_url('e-account-order-history');?>" class="active"><?php echo lang('order_history');?></a>
    </div>
</div>


<div class="my_account_wrap section_padding_b">   
    <div class="container">
        <div class="row">
            <!--  account sidebar  -->
            <?php $this->view('eCommerce/frontend/customer_profile_sidebar')?>

            <!-- account content -->
            <div class="col-lg-9">
                <?php if ($this->session->flashdata('exception')) : ?>
                <section class="alert-wrapper">
                    <div class="alert alert-success alert-dismissible fade show">
                        <div class="alert-body">
                            <?= escape_output($this->session->flashdata('exception')); ?>
                            <?php unset($_SESSION['exception']); ?>
                        </div>
                    </div>
                </section>
                <?php endif; ?>
                <?php if ($this->session->flashdata('exception_error')) : ?>
                <section class="alert-wrapper">
                    <div class="alert alert-danger alert-dismissible fade show">
                        <div class="alert-body">
                            <?= escape_output($this->session->flashdata('exception_error')); ?>
                            <?php unset($_SESSION['exception_error']); ?>
                        </div>
                    </div>
                </section>
                <?php endif; ?>

                <div class="acorder_wrapper">
                    <h4><?php echo lang('my_orders');?></h4>
                    <?php if($get_customer_order){
                        foreach($get_customer_order as $order){
                    ?>
                    <div class="single_prof_recorder mt-0 mb-4 shadow_sm">
                        <div class="prorder_img">
                            <?php if($order->photos){
                                for($i = 0; $i < count($order->photos); $i++){
                            ?>
                            <img loading="lazy"  src="<?php echo base_url()?>uploads/items/<?php echo $order->photos[$i];?>" alt="Product-Photo">
                            <?php }} ?>
                        </div>
                        <div class="prorder_btn">
                            <a href="<?php echo base_url();?>e-account-order-details/<?php echo $this->custom->encrypt_decrypt($order->id, 'encrypt'); ?>"><?php echo lang('View_Order');?></a>
                        </div>
                        <div class="prorder_txt prorder_odnumber">
                            <h5><?php echo lang('order_number');?></h5>
                            <p><?php echo escape_output($order->sale_no);?></p>
                        </div>
                        <div class="prorder_txt prorder_purchased">
                            <h5><?php echo lang('purchased');?></h5>
                            <p><?php echo dateFormatMaster($order->date_time);?></p>
                        </div>
                        <div class="prorder_txt prorder_qnty d-none d-sm-block">
                            <h5><?php echo lang('quantity');?></h5>
                            <p>x<?php echo escape_output($order->total_quantity);?></p>
                        </div>
                        <div class="prorder_txt prorder_total">
                            <h5><?php echo lang('total');?></h5>
                            <p><?php echo getAmt($order->total_payable);?></p>
                        </div>
                        <div class="prorder_txt prorder_status">
                            <h5 class="d-none d-md-block"><?php echo lang('status');?></h5>
                            <h5 class="d-block d-md-none"><span class="me-2 d-inline-block d-sm-none font-normal text_xs">x<?php echo escape_output($order->total_quantity);?></span> <?php echo getAmt($order->total_payable);?></h5>
                            <?php if($order->delivery_status == 'Cash Received'){
                                echo '<p class="text-green">Delivered</p>';
                            }else if($order->delivery_status == 'Sent'){
                                echo '<p class="text-warning">Sent</p>';
                            }else if($order->delivery_status == 'Returned'){
                                echo '<p class="text-color">Cancelled</p>';
                            }
                            ?>
                        </div>
                    </div>
                    <?php }} ?>
                </div>
            </div>
        </div>
    </div>
</div>
