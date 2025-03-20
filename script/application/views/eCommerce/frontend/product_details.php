    <!-- breadcrumbs -->
    <div class="container">
        <div class="breadcrumbs">
            <a href="<?php echo base_url();?>e-home"><i class="las la-home"></i></a>
            <a href="<?php echo base_url();?>e-category/<?php echo $this->custom->encrypt_decrypt($product_info->category_id, 'encrypt'); ?>">
                <?php echo escape_output($product_info->category_name);?>
            </a>
            <a href="javascript:void(0)" class="active"><?php echo escape_output($product_info->parent_name ? $product_info->parent_name . '-'. $product_info->name : $product_info->name);?></a>
        </div>
    </div>

    <!-- product view -->
    <div class="product_view_wrap section_padding_b">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="product_view_slider product_view_slider2">
                        <?php if($product_image): ?>
                            <?php foreach($product_image as $image): ?>
                                <div class="single_viewslider single_viewslider2">
                                    <?php
                                    $file_path = FCPATH . 'uploads/eCommerce/item_images/'. $image->image;
                                    if(file_exists($file_path) && $image->image): ?>
                                        <img loading="lazy" src="<?php echo base_url();?>uploads/eCommerce/item_images/<?php echo $image->image; ?>" alt="product">
                                    <?php else: ?>
                                        <img loading="lazy" src="<?php echo base_url();?>uploads/site_settings/default-picture.png" alt="product">
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <?php if($product_info->type == 'Variation_Product'): ?>
                                <?php
                                $file_path = FCPATH . 'uploads/items/'. $product_info->photo;
                                if(file_exists($file_path) && $product_info->photo): ?>
                                    <img loading="lazy" src="<?php echo base_url();?>uploads/items/<?php echo $product_info->photo;?>" alt="product">
                                <?php else: ?>
                                    <img loading="lazy" src="<?php echo base_url();?>uploads/site_settings/default-picture.png" alt="product">
                                <?php endif; ?>
                            <?php else: ?>
                                <img loading="lazy" src="<?php echo base_url();?>uploads/site_settings/default-picture.png" alt="product">
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    <div class="product_viewslid_nav product_viewslid_nav2">
                        <?php if($product_image): ?>
                            <?php foreach($product_image as $image): ?>
                                <div class="single_viewslid_nav">
                                    <?php
                                    $file_path = FCPATH . 'uploads/eCommerce/item_images/'. $image->image;
                                    if(file_exists($file_path) && $image->image): ?>
                                        <img loading="lazy" src="<?php echo base_url();?>uploads/eCommerce/item_images/<?php echo $image->image; ?>" alt="product">
                                    <?php else: ?>
                                        <img loading="lazy" src="<?php echo base_url();?>uploads/site_settings/default-picture.png" alt="product">
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <?php if($product_info->type == 'Variation_Product'): ?>
                                <?php
                                $file_path = FCPATH . 'uploads/items/'. $product_info->photo;
                                if(file_exists($file_path) && $product_info->photo): ?>
                                    <img loading="lazy" src="<?php echo base_url();?>uploads/items/<?php echo $product_info->photo;?>" alt="product">
                                <?php else: ?>
                                    <img loading="lazy" src="<?php echo base_url();?>uploads/site_settings/default-picture.png" alt="product">
                                <?php endif; ?>
                            <?php else: ?>
                                <img loading="lazy" src="<?php echo base_url();?>uploads/site_settings/default-picture.png" alt="product">
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="product_info_wrapper">
                        <div class="product_base_info">
                            <h1><?php echo escape_output($product_info->parent_name ? $product_info->parent_name . '-'. $product_info->name : $product_info->name);?></h1>
                            <div class="rating">
                                <div class="d-flex align-items-center">
                                    <div class="rating_star">
                                    <?php for ($i = 5; $i >= 1; $i--) { ?>  
                                    <span class="product-id" 
                                        data-product-id="<?php echo ($product_info->id); ?>" 
                                        data-ratting="<?php echo $i; ?>">
                                        <i class="<?php echo ($product_info->avg_rating >= $i) ? 'bi bi-star-fill current-r' : 'bi bi-star'; ?>"></i>
                                    </span>  
                                    <?php } ?>  
                                    </div>
                                    <p class="rating_count">(<?php echo getAmt($product_info->avg_rating); ?>)</p>
                                </div>
                            </div>
                            <div class="product_other_info">
                                <input type="hidden" class="modal_p_stock"  value="<?php echo $stock;?>">
                                <?php if($product_info->type != 'Variation_Product'){?>
                                    <?php if($stock > 0){?>
                                        <p><span><?php echo lang('Availability');?>:</span><span class="text-green stock_setter">In Stock</span></p>
                                    <?php } else {?>
                                        <p><span><?php echo lang('Availability');?>:</span><span class="text-danger stock_setter">Out of Stock</span></p>
                                    <?php }?>
                                <?php } else {?>
                                    <p><span><?php echo lang('Availability');?>:</span><span class="stock_setter">N/A</span></p>
                                <?php }?>
                                <p><span><?php echo lang('category');?>:</span><?php echo escape_output($product_info->category_name);?></p>
                            </div>
                            <div class="price mt-3 mb-3 d-flex align-items-center">

                                <?php if($product_info->discount_price){?>
                                    <span class="prev_price ms-0"><?php echo getAmtCustomMain($product_info->sale_price);?></span>
                                <?php } ?>
                                <?php 
                                $org_price = 0;
                                $discount_amt = removePercentage($product_info->discount_price);
                                if(isPercentage($product_info->discount_price)){
                                    $org_price = $product_info->sale_price * (100 - intval($discount_amt)) / 100;
                                }else{
                                    $org_price = $product_info->sale_price  - intval($discount_amt);
                                }
                                ?>
                                <span class="org_price ms-2"><?php echo getAmtCustomMain($org_price);?></span>
                                <?php if($product_info->discount_price){?>
                                    <div class="disc_tag ms-3"><?php echo $product_info->discount_price;?></div>
                                <?php } ?>
                            </div>
                            <?php if($product_info->description){?>
                            <div class="pd_dtails">
                                <p><?php echo escape_output($product_info->description);?></p>
                            </div>
                            <?php } ?>



                            <?php if($product_variation){?>
                            <div class="shop_filter border-bottom-0 pb-0">
                                <div class="size_selector mb-3">
                                    <h5><strong><?php echo lang('variations');?>:</strong></h5>
                                    <div class="d-flex align-items-center flex-wrap" id="variation_show_2"> 
                                        <?php 
                                            foreach($product_variation as $variation){
                                        ?>
                                        <div class="single_size_opt mt-2">
                                            <input type="radio" hidden name="variation_items" class="size_inp" id="variation_items_<?php echo escape_output($variation->id);?>">
                                            <label for="variation_items_<?php echo escape_output($variation->id);?>"><?php echo escape_output($variation->name);?></label>
                                        </div>
                                        <?php  } ?>
                                    </div>
                                </div>
                            </div>
                            <?php  } ?>
                            <div class="cart_qnty ms-md-auto">
                                <p><strong><?php echo lang('quantity');?></strong></p>
                                <div class="d-flex align-items-center">
                                    <div class="cart_qnty_btn product_quantity_decrease">
                                        <i class="las la-minus"></i>
                                    </div>
                                    <div class="cart_count product_quantity">1</div>
                                    <div class="cart_qnty_btn product_quantity_increase">
                                        <i class="las la-plus"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product_buttons">
                            <a href="javascript:void(0)" class="default_btn small rounded me-sm-3 me-2 px-4 add-to-cart2" data-type="<?php echo escape_output($product_info->type);?>" data-product-id="<?php echo $this->custom->encrypt_decrypt($product_info->id, 'encrypt');?>" data-sp="<?php echo $this->custom->encrypt_decrypt($product_info->sale_price, 'encrypt');?>">
                            <?php echo lang('add_to_cart');?>
                            </a>
                        </div>
                        <div class="d-flex">
                            <a href="javascript:void(0)" class="me-3 adto_wish1" data-pro-id="<?php echo $this->custom->encrypt_decrypt($product_info->id, 'encrypt'); ?>">
                                <i class="bi bi-suit-heart"></i>
                                <?php echo lang('Add_to_wishlist');?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="product_view_tabs mt-4">
                <div class="pv_tab_buttons" class="spec_text">
                    <div class="pbt_single_btn active" data-target=".info"><?php echo lang('Product_Info');?></div>
                    <div class="pbt_single_btn" data-target=".review"><?php echo lang('Review');?></div>
                </div>
                <div class="pb_tab_content info active">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="pbt_info_text">
                                <?php if($product_info->description){?>
                                <div class="pd_dtails">
                                    <p><?php echo escape_output($product_info->description);?></p>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb_tab_content review">
                    <div class="review_header d-flex align-items-center justify-content-between">
                        <p class="m-0 text-semibold"><?php echo lang('Product_Reviews');?></p>
                    </div>
                    <div class="review_cont_wrap">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="ratting_box">
                                    <h5><?php echo lang('ratting');?></h5>
                                    <div class="rating_star">
                                    <?php for ($i = 5; $i >= 1; $i--) { ?>  
                                    <span class="product-id" 
                                        data-product-id="<?php echo ($product_info->id); ?>" 
                                        data-ratting="<?php echo $i; ?>">
                                        <i class="<?php echo ($product_info->avg_rating >= $i) ? 'bi bi-star-fill current-r' : 'bi bi-star'; ?>"></i>
                                    </span>  
                                    <?php } ?>  
                                    </div>
                                    <div class="form-group mt-3">
                                        <label class="form-label"><strong><?php echo lang('Review');?></strong></label>
                                        <textarea rows="6" name="" id="" class="form-control" placeholder="Enter at least 10 character"></textarea>
                                    </div>
                                    <button type="button" class="default_btn small rounded me-sm-3 me-2 px-4 mt-3">
                                        <?php echo lang('Post_Your_Review');?>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="review_rating">
                                    <div class="total_rating">
                                        <div class="trating_number">
                                            <span class="avrage"><?php echo getAmt($product_info->avg_rating);?></span>
                                            <span class="from">/5</span>
                                        </div>
                                        <div class="rating_star">
                                        <?php for ($i = 5; $i >= 1; $i--) { ?>  
                                        <span class="product-id" 
                                            data-product-id="<?php echo ($product_info->id); ?>" 
                                            data-ratting="<?php echo $i; ?>">
                                            <i class="<?php echo ($product_info->avg_rating >= $i) ? 'bi bi-star-fill current-r' : 'bi bi-star'; ?>"></i>
                                        </span>  
                                        <?php } ?>  
                                        </div>
                                        <div class="rating_count"><?php echo getAmt($product_info->sum_ratting);?> <?php echo lang('rattings');?></div>
                                    </div>
                                    <div class="overall_rating">
                                        <div class="single_ovrating d-flex align-items-center">
                                            <?php 
                                                if($product_info->avg_rating && $product_info->rating_count){
                                                    $total_ration = ($product_info->avg_rating / ($product_info->rating_count * 5)) * 100;
                                                }else{
                                                    $total_ration = 0;
                                                }
                                            ?>
                                            <div class="rating_pbox"><span style="width: <?php echo $total_ration?>%"></span></div>
                                            <p class="rating_count"><?php echo $total_ration;?></p>
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

    <!-- top new arrival -->
    <div class="top_arrival_wrp best_selling1 section_padding">
        <div class="container">
            <h2 class="section_title_3"><?php echo lang('Related_Products');?></h2>
            <div class="flash_sale">
                <?php  if($products){
                    foreach($products as $pro){
                        $org_price = 0;
                        $discount_amt = removePercentage($pro->discount_price);
                        if(isPercentage($pro->discount_price)){
                            $org_price = $pro->sale_price * (100 - intval($discount_amt)) / 100;
                        }
                ?>
                <div class="flash_sale_el common_cart_trigger">
                    <div class="single_toparrival">
                        <div class="topariv_img">
                            <div class="discount">
                                <p><?php echo escape_output($pro->discount_price);?></p>
                            </div>
                            <?php
                            $file_path = FCPATH . 'uploads/items/'. $pro->photo;
                            if(file_exists($file_path) && $pro->photo){ 
                            ?>
                                <img loading="lazy"  src="<?php echo base_url();?>uploads/items/<?php echo $pro->photo; ?>" alt="product">
                            <?php } else {?>
                                <img loading="lazy"  src="<?php echo base_url();?>uploads/site_settings/default-picture.png" alt="product">
                            <?php } ?>
                            <div class="prod_soh">
                                <div class="adto_wish" data-pro-id="<?php echo $this->custom->encrypt_decrypt($pro->id, 'encrypt'); ?>">
                                    <i class="bi bi-suit-heart"></i>
                                </div>
                                <div class="adto_quick open_quickview" data-pro-id="<?php echo $this->custom->encrypt_decrypt($pro->id, 'encrypt'); ?>">
                                    <i class="las la-eye"></i>
                                </div>
                            </div>
                        </div>
                        <div class="topariv_cont">
                            <a href="<?php echo base_url();?>e-product-details/<?php echo $this->custom->encrypt_decrypt($pro->id, 'encrypt'); ?>">
                                <?php if($pro->parent_name){?>
                                    <h4><?php echo escape_output($pro->parent_name . '-'. $pro->name);?></h4>
                                <?php } else {?>
                                    <h4><?php echo escape_output($pro->name);?></h4>
                                <?php } ?>
                            </a>
                            <div class="rating">
                                <div class="d-flex align-items-center justify-content-start">
                                    <div class="rating_star">
                                        <?php for ($i = 5; $i >= 1; $i--) { ?>  
                                        <span class="product-id" 
                                            data-product-id="<?php echo ($pro->id); ?>" 
                                            data-ratting="<?php echo $i; ?>">
                                            <i class="<?php echo ($pro->avg_rating >= $i) ? 'bi bi-star-fill current-r' : 'bi bi-star'; ?>"></i>
                                        </span>  
                                        <?php } ?>  
                                    </div>
                                    <p class="rating_count mb-0">(<?php echo getAmt($pro->avg_rating); ?>)</p>
                                </div>
                            </div>
                        </div>
                        <div class="full_atc_btn">
                            <div class="price mb-1 mt-2">
                                <?php if($pro->discount_price){?>
                                    <span class="prev_price ms-0"><?php echo getAmtCustomMain($pro->sale_price);?></span>
                                    <span class="org_price ms-2"><?php echo getAmtCustomMain($org_price);?></span>
                                <?php } else {?>
                                    <span class="org_price ms-2"><?php echo getAmtCustomMain($pro->sale_price);?></span>
                                <?php }?>
                            </div>
                            <button class="add-to-cart" type="button" data-type="<?php echo escape_output($pro->type);?>" data-product-id="<?php echo $this->custom->encrypt_decrypt($pro->id, 'encrypt');?>" data-sp="<?php echo $this->custom->encrypt_decrypt($org_price > 0 ? $org_price : $pro->sale_price, 'encrypt');?>">
                                <span class="me-1">
                                    <i class="bi bi-cart3"></i>
                                </span>
                                <?php echo lang('add_to_cart');?>
                            </button>
                        </div>
                    </div>
                </div>
                <?php }}?>
            </div>
        </div>
    </div>