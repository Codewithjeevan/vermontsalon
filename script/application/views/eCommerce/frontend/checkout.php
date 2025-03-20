<!-- breadcrumbs -->
<div class="container">
    <div class="breadcrumbs">
        <a href="<?php echo base_url('e-home');?>"><i class="las la-home"></i></a>
        <a href="javascript:void(0);"><?php echo lang('Shop');?></a>
        <a href="<?php echo base_url('e-checkout');?>" class="active"><?php echo lang('checkOut');?></a>
    </div>
</div>

<!-- cart area -->
<div class="cart_area section_padding_b">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-lg-7 col-md-6">
                <h4 class="shop_cart_title mb-4 ps-3"><?php echo lang('billing_details');?></h4>
                <div class="billing_form">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="single_billing_inp">
                                <label for="full_name"><?php echo lang('full_name');?> <span>*</span></label>
                                <input type="text" id="full_name" name="full_name" placeholder="<?php echo lang('full_name');?>" value="<?php echo escape_output($customer_info->name); ?>">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="single_billing_inp">
                                <label for="phone_number"><?php echo lang('phone_number');?> <span>*</span></label>
                                <input type="text" id="phone_number" name="phone_number" placeholder="<?php echo lang('phone_number');?>" value="<?php echo escape_output($customer_info->phone); ?>">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="single_billing_inp">
                                <label for="email_addr"><?php echo lang('email_address');?> </label>
                                <input type="text" id="email_addr" name="email_address" placeholder="<?php echo lang('email_address');?>" value="<?php echo escape_output($customer_info->email); ?>">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="single_billing_inp">
                                <label for="address"><?php echo lang('address');?> <span>*</span></label>
                                <textarea type="text" id="address" name="address" placeholder="<?php echo lang('address');?>"><?php echo escape_output($customer_info->address); ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-5 col-md-6">
                <h4 class="shop_cart_title ps-3"><?php echo lang('your_order');?></h4>
                <div class="checkout_order mt-4">
                    <h4><?php echo lang('product');?></h4>
                    <?php 
                        $cart = $this->cart->contents();
                        $total_tax = 0;
                        if(count($cart) > 0){
                        foreach ($cart as $item) {
                            $total_tax += floatval($item['options']['single_item_total_tax']) * floatval($item['qty']);

                    ?>
                    <div class="single_check_order common_calculation_cls">
                        <div class="checkorder_cont">
                            <h5><?php echo $item['name']?></h5>
                        </div>
                        <p class="checkorder_qnty"><span class="cart_count"><?php echo $item['qty']?></span> x <span class="price" data-p="<?php echo $item['price']; ?>" data-next-v="<?php echo $item['options']['single_item_total_tax'];?>"><?php echo getAmt(floatval($item['price'])) ;?></span></p>
                        <div class="checkorder_price cart_price">
                            <p><?php echo getAmt(floatval($item['price']) * floatval($item['qty'])) ;?></p>
                        </div>
                    </div>
                    <?php }} ?>
                    <div class="single_check_order subs">
                        <div class="checkorder_cont subtotal-h">
                            <h5><?php echo lang('subtotal');?></h5>
                        </div>
                        <p class="checkorder_price cart_sub_total">0</p>
                    </div>

                    <?php 
                    $delivary_charge = 0;
                    $areas_html = '';
                    if($areas){
                        foreach ($areas as $key=>$area) {
                            if($key == 0){
                                $delivary_charge = $area->delivary_charge;
                            }
                            $areas_html .='<option area-val="'.$area->delivary_charge.'" value="'.$area->id.'">'.$area->area_name.'</option>';
                        }
                    }
                    ?>

                    <div class="single_check_order subs">
                        <div class="checkorder_cont subtotal-h">
                            <h5><?php echo lang('shipping');?></h5>
                        </div>
                        <p class="checkorder_price delivery_charge"><?php echo getAmt($delivary_charge);?></p>
                    </div>
                    <div class="single_check_order subs">
                        <div class="checkorder_cont subtotal-h">
                            <h5><?php echo lang('tax');?></h5>
                        </div>
                        <p class="checkorder_price tax_amount"></p>
                    </div>
                    <div class="single_check_order total">
                        <div class="checkorder_cont">
                            <h5><?php echo lang('total');?></h5>
                        </div>
                        <p class="checkorder_price grand_total" id="finalize_total_due">0</p>
                    </div>
                    <div>
                        <label for="area"><?php echo lang('area');?></label>
                        <select name="area" id="area_select" class="form-control select2">
                            <?php echo $areas_html;?>
                        </select>
                    </div>
                    <div class="mt-3">
                        <label for="delivary_partner"><?php echo lang('delivery_partner');?></label>
                        <select name="delivary_partner" id="delivary_partner" class="form-control select2">
                            <option value=""><?php echo lang('select');?> <?php echo lang('delivery_partner');?></option> 
                            <?php 
                            if($delivary_partner){
                                foreach ($delivary_partner as $partner) {
                                    echo '<option value="'.$partner->id.'">'.$partner->partner_name.'</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="payment-method-section mt-3">
                        <div class="d-flex flex-column gap10px payment_card">
                            <input type="hidden" class="payment_process" value="400">
                            <label>
                                <input type="radio" class="payment_method" name="payment_method" value="cash_on_delivery" checked="">
                                <span><?php echo lang('cash_on_delivary');?></span>
                            </label>
                            <label>
                                <input type="radio" class="payment_method" name="payment_method" value="paypal">
                                <span><?php echo lang('paypal');?></span>
                            </label>
                            <label>
                                <input type="radio" class="payment_method" name="payment_method" value="stripe">
                                <span><?php echo lang('stripe');?></span>
                            </label>
                        </div>
                    </div>
                    <div class="checkorder_btn mt-3">
                        <button type="button" id="place_order" class="default_btn rounded w-100"><?php echo lang('place_order');?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>