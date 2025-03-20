<?php
    $status = '';
    $comment = '';
    $heading_cls = '';
    $heading_message = '';
    if($order_result->delivery_status == 'Sent'){
        $status = 'pending';
        $comment = 'Order Pending';
        $heading_cls = 'bg-warning';
        $heading_message = 'Order Pending';
    }else if($order_result->delivery_status == 'Cash Received'){
        $status = '';
        $comment = 'Order Delivered';
        $heading_cls = 'bg-success';
        $heading_message = 'Order Delivared';
    }else if($order_result->delivery_status == 'Returned'){
        $status = 'reject';
        $comment = 'Order Returned';
        $heading_cls = 'bg-danger';
        $heading_message = 'Order Returned';
    
    }
?>
<!-- Trac Order page -->
 <div class="section_padding_b trac_order_page">
    <div class="container">
        <div class="seconpage_banner">
            <h2><?php echo lang('Order_Tracking');?></h2>
            <div class="breadcrumbs">
                <a href="javascript:void(0)"><i class="las la-home"></i></a>
                <a href="<?php echo base_url('e-track-order');?>" class="active"><?php echo lang('Order_Tracking');?></a>
            </div>
        </div>
        <div class="row">
            <!-- track order -->
            <div class="container track_orders_heading">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4><?php echo lang('order_placed');?></h4>
                        <p><?php echo dateFormatMaster($order_result->sale_date);?></p>
                    </div>
                    <div>
                        <h4><?php echo lang('total');?></h4>
                        <p><?php echo getAmtCustomMain($order_result->total_payable);?></p>
                    </div>
                    <div>
                        <h4><?php echo lang('Ship_To');?></h4>
                        <p><?php echo escape_output($order_result->customer_name .'-'.$order_result->phone);?></p>
                    </div>
                    <div>
                        <h4><?php echo lang('Order_No');?></h4>
                        <p><?php echo escape_output($order_result->sale_no);?></p>
                    </div>
                </div> 
            </div>
            <div class="track_orders section_padding_b shadow_sm">
                <div class="container">
                    <div class="padding_default">
                        <div class="track_status">
                            <h4 class="title_3 text-uppercase <?php echo $heading_cls; ?>"><?php echo $heading_message; ?></h4>
                            <div class="track_path">
                                <div class="single_track">
                                    <h5 class="text_lg"><?php echo lang('order_placement');?></h5>
                                    <p class="mb-0 text_md"><?php echo dateFormatMaster($order_result->date_time);?></p>
                                </div>
                                <div class="single_track">
                                    <h5 class="text_lg"><?php echo lang('order_processing');?></h5>
                                    <p class="mb-0 text_md"><?php echo dateFormatMaster($order_result->sale_date);?></p>
                                </div>
                                <div class="single_track">
                                    <h5 class="text_lg"><?php echo lang('order_shipping');?></h5>
                                    <p class="mb-0 text_md"><?php echo dateFormatMaster($order_result->sale_date);?></p>
                                </div>
                                <div class="single_track <?php echo $status;?>">
                                    <h5 class="text_lg"><?php echo lang('order_delivery');?></h5>
                                    <p class="mb-0 text_md"><?php echo escape_output($comment);?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
