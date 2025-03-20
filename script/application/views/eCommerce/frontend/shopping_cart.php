<div class="section_padding_b shopping_cart_page">
    <div class="container">
        <div class="seconpage_banner">
            <h2><?php echo lang('My_Shopping_Cart');?></h2>
            <div class="breadcrumbs">
                <a href="<?php echo base_url('e-home')?>"><i class="las la-home"></i></a>
                <a href="<?php echo base_url()?>e-shopping-cart" class="active"><?php echo lang('cart');?></a>
            </div>
        </div>
        <div class="row">
            <!-- shopping cart -->
            <div class="cart_area section_padding_b">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="my_shopping_cart_wrap">
                                <h4 class="shop_cart_title sopcart_ttl">
                                    <span><?php echo lang('product');?></span>
                                    <span><?php echo lang('price');?></span>
                                    <span><?php echo lang('quantity');?></span>
                                    <span><?php echo lang('total_price');?></span>
                                </h4>
                                <?php 
                                    $cart = $this->cart->contents();
                                    $total_tax = 0;
                                    foreach ($cart as $item) {
                                        $total_tax += floatval($item['options']['single_item_total_tax']) * floatval($item['qty']);

                                ?>
                                    <div class="shop_cart_wrap">
                                        <div class="single_shop_cart common_calculation_cls">
                                            <div class="cart_cont d-flex">
                                                <div class="cart_img mb-4 mb-md-0">
                                                    <img loading="lazy"  src="<?php echo base_url()?>uploads/items/<?php echo $item['options']['cart_photo'];?>" alt="product">
                                                </div>
                                                <a href="<?php echo base_url();?>e-product-details/<?php echo $this->custom->encrypt_decrypt($item['id'], 'encrypt');?>">
                                                    <h5><?php echo escape_output($item['name']);?></h5>
                                                </a>
                                            </div>
                                            <p class="price text-center" data-p="<?php echo $item['price']; ?>" data-next-v="<?php echo $item['options']['single_item_total_tax'];?>"><?php echo getAmt($item['price']);?></p>
                                            <div class="cart_qnty text-center">
                                                <div class="cart_qty_wrap">
                                                    <span class="cart_qnty_btn cart_qnty_btn_minus" data-product-id="<?php echo $this->custom->encrypt_decrypt($item['id'], 'encrypt');?>" data-sp="<?php echo $this->custom->encrypt_decrypt($item['price'], 'encrypt');?>">
                                                        <i class="las la-minus"></i>
                                                    </span>
                                                    <span class="cart_count"><?php echo escape_output($item['qty']);?></span>
                                                    <span class="cart_qnty_btn cart_qnty_btn_plus" data-product-id="<?php echo $this->custom->encrypt_decrypt($item['id'], 'encrypt');?>" data-sp="<?php echo $this->custom->encrypt_decrypt($item['price'], 'encrypt');?>">
                                                        <i class="las la-plus"></i>
                                                    </span>
                                                </div>
                                                
                                            </div>
                                            <div class="d-flex">
                                                <div class="cart_price ms-auto">
                                                    <p><?php echo getAmt(floatval($item['price']) * floatval($item['qty'])) ;?></p>
                                                </div>
                                                <div class="cart_remove ms-auto" data-product-id="<?php echo $this->custom->encrypt_decrypt($item['id'], 'encrypt');?>">
                                                    <i class="bi bi-x-lg"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-lg-3 mt-4 mt-lg-0">
                            <div class="cart_summary">
                                <h4><?php echo lang('Order_Summary');?></h4>
                                <div class="cartsum_text d-flex justify-content-between">
                                    <p class="text-semibold"><?php echo lang('subtotal');?></p>
                                    <p class="text-semibold cart_sub_total">0</p>
                                </div>
                                <div class="cartsum_text d-flex justify-content-between">
                                    <p><?php echo lang('tax');?></p>
                                    <p class="tax_amount">0</p>
                                </div>
                                <div class="cart_sum_total d-flex justify-content-between">
                                    <p><?php echo lang('total');?></p>
                                    <p class="grand_total">0</p>
                                </div>
                                <div class="cart_sum_pros">
                                    <a href="<?php echo base_url();?>e-checkout" ><?php echo lang('Proccees_to_checkout');?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>