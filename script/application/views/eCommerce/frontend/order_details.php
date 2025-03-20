<!-- breadcrumbs -->
<div class="container">
    <div class="breadcrumbs">
        <a href="<?php echo base_url();?>e-home"><i class="las la-home"></i></a>
        <a href="<?php echo base_url();?>e-account"><?php echo lang('my_account');?></a>
        <a href="<?php echo base_url();?>e-change-password" class="active"><?php echo lang('order_details_1');?></a>
    </div>
</div>

<!-- account -->
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
                <div class="order_detail_wrapper shadow_sm">
                    <h4 class="od_title"><?php echo lang('order_details_1');?></h4>
                    <!-- order details -->
                    <div class="orderdet_info d-flex align-items-center justify-content-between flex-wrap">
                        <div class="single_orderdet">
                            <h5><?php echo lang('sold_by');?></h5>
                            <p class="text-color"><?php echo escape_output($get_customer_order['sale']->business_name);?></p>
                        </div>
                        <div class="single_orderdet">
                            <h5><?php echo lang('order_number');?></h5>
                            <p><?php echo escape_output($get_customer_order['sale']->sale_no);?></p>
                        </div>
                        <div class="single_orderdet">
                            <h5><?php echo lang('Order_Date');?></h5>
                            <p><?php echo dateFormatMaster($get_customer_order['sale']->date_time);?></p>
                        </div>
                    </div>
                    <!-- product details -->
                    <?php foreach($get_customer_order['sale_details'] as $detail): ?>
                    <div class="order_prodetails d-flex align-items-center flex-wrap">
                        <div class="orderprod_img">
                            <?php if($detail->photo): ?>
                                <img loading="lazy" src="<?php echo base_url('uploads/items/'.$detail->photo);?>" alt="<?php echo escape_output($detail->name);?>">
                            <?php else: ?>
                                <img loading="lazy" src="<?php echo base_url('uploads/site_settings/default-picture.png');?>" alt="default">
                            <?php endif; ?>
                        </div>
                        <div class="single_orderdet pdname">
                            <h5><?php echo escape_output($detail->name);?></h5>
                        </div>
                        <div class="single_orderdet w-xs-33 ms-md-auto ms-0 mt-3 mt-md-0">
                            <h5><?php echo getAmtCustomMain($detail->menu_price_without_discount);?></h5>
                        </div>
                        <div class="single_orderdet w-xs-33 ms-auto mt-3 mt-md-0">
                            <h5><?php echo lang('qty');?>: <?php echo escape_output($detail->qty);?></h5>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="profile_info_wrap mt-4">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="single_prof_info shadow_sm">
                                <div class="prof_info_title">
                                    <h4><?php echo lang('shipping_address');?></h4>
                                </div>
                                <div class="prfo_info_cont">
                                    <?php if($customer_info->shipping_address){?>
                                        <p><?php echo escape_output($customer_info->shipping_address);?></p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="single_prof_info shadow_sm">
                                <div class="prof_info_title">
                                    <h4><?php echo lang('billing_address');?></h4>
                                </div>
                                <div class="prfo_info_cont">
                                    <?php if($customer_info->billing_address){?>
                                        <p><?php echo escape_output($customer_info->billing_address);?></p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="single_prof_info shadow_sm mb-0">
                                <div class="prof_info_title">
                                    <h4><?php echo lang('Total_Summary');?></h4>
                                </div>
                                <div class="prfo_info_cont">
                                    <div class="d-flex justify-content-between">
                                        <p class="mb-0"><?php echo lang('subtotal');?></p>
                                        <p class="text-semibold mb-0"><?php echo getAmt($get_customer_order['sale']->sub_total);?></p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p class=" mb-0"><?php echo lang('tax');?></p>
                                        <p class="text-semibold mb-0"><?php echo getAmt($get_customer_order['sale']->vat);?></p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p class=" mb-0"><?php echo lang('shipping_fee');?></p>
                                        <p class="text-semibold mb-0"><?php echo getAmt($get_customer_order['sale']->delivery_charge);?></p>
                                    </div>
                                    <hr class="my-2">
                                    <div class="d-flex justify-content-between">
                                        <p class="text-semibold mb-0"><?php echo lang('total');?></p>
                                        <?php
                                        $total = floatval($get_customer_order['sale']->sub_total) + floatval($get_customer_order['sale']->vat) + floatval($get_customer_order['sale']->delivery_charge);
                                        ?>
                                        <p class="text-semibold mb-0"><?php echo getAmt($total);?></p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p><?php echo lang('Paid_by_Cash_on_Delivery');?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>