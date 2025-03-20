<?php
$ecommerce_setting   = getECommerceSetting();
$content_hide_show   = json_decode(isset($ecommerce_setting->homepage_content_show_hide) && $ecommerce_setting->homepage_content_show_hide ? $ecommerce_setting->homepage_content_show_hide : '');
$closable_notice     = json_decode(isset($ecommerce_setting->closable_notice) && $ecommerce_setting->closable_notice ? $ecommerce_setting->closable_notice : '');
?>
<!-- Hero area -->
<div class="container">
    <div class="banner_slider">
        <?php if (!empty($banners)) { 
        foreach ($banners as $banner) { ?>
        <div class="hero_area bg_2" style="background-image: url('<?php echo base_url('uploads/eCommerce/banners/') . escape_output($banner->banner_img); ?>');" 
            role="img" aria-label="Banner Image">
            <div class="container banner_both_padding">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="hero_content">
                            <?php if($banner->banner_heading){?>
                                <h1><?php echo escape_output($banner->banner_heading); ?></h1>
                            <?php } ?>
                            <?php if($banner->banner_title){?>
                                <p><?php echo escape_output($banner->banner_title); ?></p>
                            <?php }?>
                            <?php if($banner->button_link){?>
                            <div class="hero_btn">
                                <a class="default_btn rounded" href="<?php echo !empty($banner->button_link) ? escape_output($banner->button_link) : '#'; ?>">
                                    <?php echo escape_output($banner->button_text); ?>
                                </a>
                            </div>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php }} ?>
    </div>
</div>

<!-- Closable Notice -->
<?php if($closable_notice && $closable_notice->closable_notice_status == 'Enable' && $closable_notice->closable_notice_text){?>
<section class="closable_notice_section section_bg_2">
    <div class="container">
        <div class="notice_text">
            <marquee direction="left"><?php echo escape_output($closable_notice->closable_notice_text);?></marquee>
        </div>
    </div>
</section>
<?php } ?>

<!-- Top Category -->
<?php if(isset($content_hide_show->top_category) && $content_hide_show->top_category !='' && $top_sale_category){?>
<section class="features_area  section_padding section_bg_2">
    <div class="container">
        <div class="d-flex justify-content-between">
            <h2 class="section_title_3"><?php echo lang('Top_Category_this_week');?></h2>
        </div>
        <div class="top_category_slider">
            <?php 
            if($top_sale_category){
                foreach($top_sale_category as $category){
            ?>
            <a href="<?php echo base_url();?>e-category/<?php echo $this->custom->encrypt_decrypt($category->category_id, 'encrypt'); ?>" class="top_category_el">
                <div class="single_feature">
                    <div class="feature_icon">
                        <?php if($category->item_photo){?>
                        <img loading="lazy" src="<?php echo base_url()?>uploads/items/<?php echo $category->item_photo;?>" alt="icon">
                        <?php }else{?>
                        <img loading="lazy" src="<?php echo base_url()?>uploads/site_settings/default-picture.png" alt="icon">
                        <?php }?>
                    </div>
                    <div class="feature_content">
                        <?php if($category->parent_name){?>
                            <h4><?php echo escape_output($category->parent_name . '('. $category->item_name);?></h4>
                        <?php } else {?>
                            <h4><?php echo escape_output($category->item_name);?></h4>
                        <?php } ?>
                        <p>Orders over <?php echo getAmtCustomMain(floatval($category->item_sale_price) * floatval($category->total_sold)); ?></p>
                    </div>
                </div>
            </a>
            <?php }} ?>
        </div>
    </div>
</section>
<?php } ?>

<!-- Flash Sales -->
<?php if(isset($content_hide_show->flash_sale) && $content_hide_show->flash_sale !='' && $flash_sales){?>
<div class="top_arrival_wrp section_padding">
    <div class="container">
        <h2 class="section_title_3"><?php echo $flash_sales[0]->flash_sale_title;?></h2>
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="flash_counter">
                <div class="end_in"><?php echo $flash_sales[0]->flash_sale_title;?></div>
                <div class="single_count" id="count_day">00</div>
                <div class="time_sep">:</div>
                <div class="single_count" id="count_hour">00</div>
                <div class="time_sep">:</div>
                <div class="single_count" id="count_minute">00</div>
                <div class="time_sep">:</div>
                <div class="single_count" id="count_second">00</div>
            </div>
        </div>
        <div class="flash_sale">
            <?php 
            if($flash_sales){
                foreach($flash_sales as $sale){
            ?>
            <div class="flash_sale_el common_cart_trigger">
                <div class="single_toparrival">
                    <div class="topariv_img">
                        <div class="discount">
                            <p><?php echo escape_output($sale->discount_price);?></p>
                        </div>
                        <?php
                        $file_path = FCPATH . 'uploads/items/'. $sale->item_photo;
                        if(file_exists($file_path) && $sale->item_photo){ 
                        ?>
                            <img loading="lazy"  src="<?php echo base_url();?>uploads/items/<?php echo $sale->item_photo; ?>" alt="product">
                        <?php } else {?>
                            <img loading="lazy"  src="<?php echo base_url();?>uploads/site_settings/default-picture.png" alt="product">
                        <?php } ?>
                        <div class="prod_soh">
                            <div class="adto_wish" data-pro-id="<?php echo $this->custom->encrypt_decrypt($sale->item_id, 'encrypt'); ?>">
                                <i class="bi bi-suit-heart"></i>
                            </div>
                            <div class="adto_quick open_quickview" data-pro-id="<?php echo $this->custom->encrypt_decrypt($sale->item_id, 'encrypt'); ?>">
                                <i class="las la-eye"></i>
                            </div>
                        </div>
                    </div>
                    <div class="topariv_cont">
                        <a href="<?php echo base_url();?>e-product-details/<?php echo $this->custom->encrypt_decrypt($sale->item_id, 'encrypt'); ?>">
                            <?php if($sale->parent_name){?>
                                <h4><?php echo escape_output($sale->parent_name . '-'. $sale->item_name);?></h4>
                            <?php } else {?>
                                <h4><?php echo escape_output($sale->item_name);?></h4>
                            <?php } ?>
                        </a>
                        <div class="rating">
                            <div class="d-flex align-items-center justify-content-start">
                                <div class="rating_star">
                                <?php for ($i = 5; $i >= 1; $i--) { ?>  
                                    <span class="product-id" 
                                        data-product-id="<?php echo ($sale->item_id); ?>" 
                                        data-ratting="<?php echo $i; ?>">
                                        <i class="<?php echo ($sale->avg_rating >= $i) ? 'bi bi-star-fill current-r' : 'bi bi-star'; ?>"></i>
                                    </span>  
                                <?php } ?>  
                                </div>
                                <p class="rating_count mb-0">(<?php echo getAmt($sale->avg_rating); ?>)</p>
                            </div>
                        </div>
                    </div>
                    <div class="full_atc_btn">
                        <div class="price mb-1 mt-2">
                            <?php if($sale->discount_price){?>
                                <span class="old_price"><?php echo getAmtCustomMain($sale->sale_price);?></span>
                            <?php } ?>
                            <?php 
                            $org_price = 0;
                            $discount_amt = removePercentage($sale->discount_price);
                            if(isPercentage($sale->discount_price)){
                                $org_price = $sale->sale_price * (100 - intval($discount_amt)) / 100;
                            }else{
                                $org_price = $sale->sale_price  - intval($discount_amt);
                            }
                            ?>
                            <span class="org_price"><?php echo getAmtCustomMain($org_price);?></span>
                        </div>
                        <button class="add-to-cart" type="button" data-type="<?php echo escape_output($sale->type);?>" data-product-id="<?php echo $this->custom->encrypt_decrypt($sale->item_id, 'encrypt');?>" data-sp="<?php echo $this->custom->encrypt_decrypt($org_price, 'encrypt');?>">
                            <span class="me-1">
                                <i class="bi bi-cart3"></i>
                            </span>
                            <?php echo lang('add_cart');?>
                        </button>
                    </div>
                </div>
            </div>
            <?php 
            }}
            ?>
        </div>
    </div>
</div>
<?php } ?>

<!-- Best Selling -->
<?php if(isset($content_hide_show->best_selling) && $content_hide_show->best_selling !='' && $top_sale){?>
<div class="top_arrival_wrp best_selling1 section_padding">
    <div class="container">
        <h2 class="section_title_3"><?php echo lang('Best_Selling');?></h2>
        <div class="flash_sale">
            <?php 
            if($top_sale){
                foreach($top_sale as $sale){
            ?>
            <div class="flash_sale_el common_cart_trigger">
                <div class="single_toparrival">
                    <div class="topariv_img">
                        <?php
                        $file_path = FCPATH . 'uploads/items/'. $sale->photo;
                        if(file_exists($file_path) && $sale->photo){ 
                        ?>
                            <img loading="lazy"  src="<?php echo base_url();?>uploads/items/<?php echo $sale->photo; ?>" alt="product">
                        <?php } else {?>
                            <img loading="lazy"  src="<?php echo base_url();?>uploads/site_settings/default-picture.png" alt="product">
                        <?php } ?>
                        <div class="prod_soh">
                            <div class="adto_wish" data-pro-id="<?php echo $this->custom->encrypt_decrypt($sale->item_id, 'encrypt'); ?>">
                                <i class="bi bi-suit-heart"></i>
                            </div>
                            <div class="adto_quick open_quickview" data-pro-id="<?php echo $this->custom->encrypt_decrypt($sale->item_id, 'encrypt'); ?>">
                                <i class="las la-eye"></i>
                            </div>
                        </div>
                    </div>
                    <div class="topariv_cont">
                        <a href="<?php echo base_url();?>e-product-details/<?php echo $this->custom->encrypt_decrypt($sale->item_id, 'encrypt'); ?>">
                            <?php if($sale->parent_name){?>
                                <h4><?php echo escape_output($sale->parent_name . '-'. $sale->item_name);?></h4>
                            <?php } else {?>
                                <h4><?php echo escape_output($sale->item_name);?></h4>
                            <?php } ?>
                        </a>
                        <div class="rating">
                            <div class="d-flex align-items-center justify-content-start">
                                <div class="rating_star">
                                    <?php for ($i = 5; $i >= 1; $i--) { ?>  
                                    <span class="product-id" 
                                        data-product-id="<?php echo ($sale->item_id); ?>" 
                                        data-ratting="<?php echo $i; ?>">
                                        <i class="<?php echo ($sale->avg_rating >= $i) ? 'bi bi-star-fill current-r' : 'bi bi-star'; ?>"></i>
                                    </span>  
                                    <?php } ?>  
                                </div>
                                <p class="rating_count mb-0">(<?php echo getAmt($sale->avg_rating); ?>)</p>
                            </div>
                        </div>
                    </div>
                    <div class="full_atc_btn">
                        <div class="price mb-1 mt-2">
                            <?php if($sale->discount_price){?>
                                <span class="old_price"><?php echo getAmtCustomMain($sale->sale_price);?></span>
                            <?php } ?>
                            <?php 
                            $org_price = 0;
                            $discount_amt = removePercentage($sale->discount_price);
                            if(isPercentage($sale->discount_price)){
                                $org_price = $sale->sale_price * (100 - intval($discount_amt)) / 100;
                            }else{
                                $org_price = $sale->sale_price  - intval($discount_amt);
                            }
                            ?>
                            <span class="org_price"><?php echo getAmtCustomMain($org_price);?></span>
                        </div>
                        <button class="add-to-cart" type="button" data-type="<?php echo escape_output($sale->type);?>" data-product-id="<?php echo $this->custom->encrypt_decrypt($sale->item_id, 'encrypt');?>" data-sp="<?php echo $this->custom->encrypt_decrypt($sale->sale_price, 'encrypt');?>">
                            <span class="me-1">
                                <i class="bi bi-cart3"></i>
                            </span>
                            add cart
                        </button>
                    </div>
                </div>
            </div>
            <?php 
            }}
            ?>
        </div>
    </div>
</div>
<?php } ?>

<!-- Offer deal -->
<?php if(isset($content_hide_show->offer_product) && $content_hide_show->offer_product !=''){?>
<!-- <div class="offer_wrp section_padding_b">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="single_offercard">
                    <div class="offertext">
                        <h3 class="offer_pers">30% offer</h3>
                        <h4>Free Shipping</h4>
                        <p>Attractive Natural Furniture</p>
                        <a href="shop-grid.html" class="default_btn rounded xs_btn">Shop Now</a>
                    </div>
                    <div class="offerimg">
                        <img loading="lazy"  src="<?php echo base_url()?>frequent_changing/eCommerce/frontend/images/sofa-1.png" alt="product">
                    </div>
                </div>
            </div>
            <div class="col-sm-6 mt-3 mt-sm-0">
                <div class="single_offercard bg_2">
                    <div class="offertext">
                        <h3 class="offer_pers">50% offer</h3>
                        <h4>Flash Sale</h4>
                        <p>Attractive Natural Furniture</p>
                        <a href="shop-grid.html" class="default_btn rounded xs_btn">Shop Now</a>
                    </div>
                    <div class="offerimg">
                        <img loading="lazy"  src="<?php echo base_url()?>frequent_changing/eCommerce/frontend/images/sofa-2.png" alt="product">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->
<?php } ?>

<!-- Latest Best Top -->
<?php if(isset($content_hide_show->latest_best_top) && $content_hide_show->latest_best_top !='' && $latest_sale){?>
<div class="best_selling section_padding section_bg_2">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="bestprod_title d-flex align-items-center justify-content-between">
                    <div class="text_xl text-uppercase text-semibold"><?php echo lang('Latest');?></div>
                    <div class="seemore_2">
                        <a href="<?php echo base_url();?>e-product-type/latest-selling"><?php echo lang('See_More');?> <span><i class="las la-angle-right"></i></span></a>
                    </div>
                </div>
                <div class="bestprod_wrp">
                    <?php if($latest_sale){
                        foreach($latest_sale as $key=>$sale){
                    ?>
                    <div class="single_bestprod common_cart_trigger">
                        <div class="bestprod_img">
                            <?php
                            $file_path = FCPATH . 'uploads/items/'. $sale->photo;
                            if(file_exists($file_path) && $sale->photo){ 
                            ?>
                                <img loading="lazy"  src="<?php echo base_url();?>uploads/items/<?php echo $sale->photo; ?>" alt="product">
                            <?php } else {?>
                                <img loading="lazy"  src="<?php echo base_url();?>uploads/site_settings/default-picture.png" alt="product">
                            <?php } ?>
                            <div class="horizontal_icon">
                                <div class="adto_wish1" data-pro-id="<?php echo $this->custom->encrypt_decrypt($sale->item_id, 'encrypt'); ?>">
                                    <i class="bi bi-suit-heart"></i>
                                </div>
                                <div class="adto_quick1 open_quickview" data-pro-id="<?php echo $this->custom->encrypt_decrypt($sale->item_id, 'encrypt'); ?>">
                                    <i class="las la-eye"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bestprod_content">
                            <a href="<?php echo base_url();?>e-product-details/<?php echo $this->custom->encrypt_decrypt($sale->item_id, 'encrypt'); ?>" class="default_link">
                                <?php if($sale->parent_name){?>
                                    <h4 class="text_lg mb-2"><?php echo escape_output($sale->parent_name . '('. $sale->item_name);?></h4>
                                <?php } else {?>
                                    <h4 class="text_lg mb-2"><?php echo escape_output($sale->item_name);?></h4>
                                <?php } ?>
                            </a>
                            <div class="price mb-0">
                                <?php if($sale->discount_price){?>
                                    <span class="old_price"><?php echo getAmtCustomMain($sale->sale_price);?></span>
                                <?php } ?>
                                <?php 
                                $org_price = 0;
                                $discount_amt = removePercentage($sale->discount_price);
                                if(isPercentage($sale->discount_price)){
                                    $org_price = $sale->sale_price * (100 - intval($discount_amt)) / 100;
                                }else{
                                    $org_price = $sale->sale_price  - intval($discount_amt);
                                }
                                ?>
                                <span class="org_price"><?php echo getAmtCustomMain($org_price);?></span>
                            </div>
                            <div class="rating">
                                <div class="d-flex align-items-center justify-content-start">
                                    <div class="rating_star">
                                    <?php for ($i = 5; $i >= 1; $i--) { ?>  
                                    <span class="product-id" 
                                        data-product-id="<?php echo ($sale->item_id); ?>" 
                                        data-ratting="<?php echo $i; ?>">
                                        <i class="<?php echo ($sale->avg_rating >= $i) ? 'bi bi-star-fill current-r' : 'bi bi-star'; ?>"></i>
                                    </span>  
                                    <?php } ?>  
                                    </div>
                                    <p class="rating_count">(<?php echo getAmt($sale->avg_rating); ?>)</p>
                                </div>
                            </div>
                            <div class="full_atc_btn">
                                <button class="add-to-cart" type="button" data-type="<?php echo escape_output($sale->type);?>" data-product-id="<?php echo $this->custom->encrypt_decrypt($sale->item_id, 'encrypt');?>" data-sp="<?php echo $this->custom->encrypt_decrypt($sale->sale_price, 'encrypt');?>">
                                    <span class="me-1">
                                        <i class="bi bi-cart3"></i>
                                    </span>
                                    <?php echo lang('add_cart');?>
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php } } ?>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mt-4 mt-md-0">
                <div class="bestprod_title d-flex align-items-center justify-content-between">
                    <div class="text_xl text-uppercase text-semibold"><?php echo lang('Best_Selling');?></div>
                    <div class="seemore_2">
                        <a href="<?php echo base_url();?>e-product-type/best-selling"><?php echo lang('See_More');?> <span><i class="las la-angle-right"></i></span></a>
                    </div>
                </div>
                <div class="bestprod_wrp">
                    <?php if($top_sale){
                        foreach($top_sale as $key=>$sale){
                            if($key == 3){
                                break;
                            }
                    ?>
                    <div class="single_bestprod common_cart_trigger">
                        <div class="bestprod_img">
                            <?php
                            $file_path = FCPATH . 'uploads/items/'. $sale->photo;
                            if(file_exists($file_path) && $sale->photo){ 
                            ?>
                                <img loading="lazy"  src="<?php echo base_url();?>uploads/items/<?php echo $sale->photo; ?>" alt="product">
                            <?php } else {?>
                                <img loading="lazy"  src="<?php echo base_url();?>uploads/site_settings/default-picture.png" alt="product">
                            <?php } ?>
                            <div class="horizontal_icon">
                                <div class="adto_wish1" data-pro-id="<?php echo $this->custom->encrypt_decrypt($sale->item_id, 'encrypt'); ?>">
                                    <i class="bi bi-suit-heart"></i>
                                </div>
                                <div class="adto_quick1 open_quickview" data-pro-id="<?php echo $this->custom->encrypt_decrypt($sale->item_id, 'encrypt'); ?>">
                                    <i class="las la-eye"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bestprod_content">
                            <a href="<?php echo base_url();?>e-product-details/<?php echo $this->custom->encrypt_decrypt($sale->item_id, 'encrypt'); ?>" class="default_link">
                                <?php if($sale->parent_name){?>
                                    <h4 class="text_lg mb-2"><?php echo escape_output($sale->parent_name . '('. $sale->item_name);?></h4>
                                <?php } else {?>
                                    <h4 class="text_lg mb-2"><?php echo escape_output($sale->item_name);?></h4>
                                <?php } ?>
                            </a>
                            <div class="price mb-0">
                                <?php if($sale->discount_price){?>
                                    <span class="old_price"><?php echo getAmtCustomMain($sale->sale_price);?></span>
                                <?php } ?>
                                <?php 
                                $org_price = 0;
                                $discount_amt = removePercentage($sale->discount_price);
                                if(isPercentage($sale->discount_price)){
                                    $org_price = $sale->sale_price * (100 - intval($discount_amt)) / 100;
                                }else{
                                    $org_price = $sale->sale_price  - intval($discount_amt);
                                }
                                ?>
                                <span class="org_price"><?php echo getAmtCustomMain($org_price);?></span>
                            </div>
                            <div class="rating">
                                <div class="d-flex align-items-center justify-content-start">
                                    <div class="rating_star">
                                    <?php for ($i = 5; $i >= 1; $i--) { ?>  
                                    <span class="product-id" 
                                        data-product-id="<?php echo ($sale->item_id); ?>" 
                                        data-ratting="<?php echo $i; ?>">
                                        <i class="<?php echo ($sale->avg_rating >= $i) ? 'bi bi-star-fill current-r' : 'bi bi-star'; ?>"></i>
                                    </span>  
                                    <?php } ?>  
                                    </div>
                                    <p class="rating_count">(<?php echo getAmt($sale->avg_rating); ?>)</p>
                                </div>
                            </div>
                            <div class="full_atc_btn">
                                <button class="add-to-cart" type="button" data-type="<?php echo escape_output($sale->type);?>" data-product-id="<?php echo $this->custom->encrypt_decrypt($sale->item_id, 'encrypt');?>" data-sp="<?php echo $this->custom->encrypt_decrypt($sale->sale_price, 'encrypt');?>">
                                    <span class="me-1">
                                        <i class="bi bi-cart3"></i>
                                    </span>
                                    <?php echo lang('add_cart');?>
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php } } ?>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mt-4 mt-md-0 d-block d-md-none d-lg-block">
                <div class="bestprod_title d-flex align-items-center justify-content-between">
                    <div class="text_xl text-uppercase text-semibold"><?php echo lang('Top_rated');?></div>
                    <div class="seemore_2">
                        <a href="<?php echo base_url();?>e-product-type/top-rated"><?php echo lang('See_More');?> <span><i class="las la-angle-right"></i></span></a>
                    </div>
                </div>
                <div class="bestprod_wrp">
                    <?php if($top_rated){
                        foreach($top_rated as $key=>$sale){
                    ?>
                    <div class="single_bestprod common_cart_trigger">
                        <div class="bestprod_img">
                            <?php
                            $file_path = FCPATH . 'uploads/items/'. $sale->photo;
                            if(file_exists($file_path) && $sale->photo){ 
                            ?>
                                <img loading="lazy"  src="<?php echo base_url();?>uploads/items/<?php echo $sale->photo; ?>" alt="product">
                            <?php } else {?>
                                <img loading="lazy"  src="<?php echo base_url();?>uploads/site_settings/default-picture.png" alt="product">
                            <?php } ?>
                            <div class="horizontal_icon" data-pro-id="<?php echo $this->custom->encrypt_decrypt($sale->item_id, 'encrypt'); ?>">
                                <div class="adto_wish1">
                                    <i class="bi bi-suit-heart"></i>
                                </div>
                                <div class="adto_quick1 open_quickview" data-pro-id="<?php echo $this->custom->encrypt_decrypt($sale->item_id, 'encrypt'); ?>">
                                    <i class="las la-eye"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bestprod_content">
                            <a href="<?php echo base_url();?>e-product-details/<?php echo $this->custom->encrypt_decrypt($sale->item_id, 'encrypt'); ?>" class="default_link">
                                <?php if($sale->parent_name){?>
                                    <h4 class="text_lg mb-2"><?php echo escape_output($sale->parent_name . '('. $sale->item_name);?></h4>
                                <?php } else {?>
                                    <h4 class="text_lg mb-2"><?php echo escape_output($sale->item_name);?></h4>
                                <?php } ?>
                            </a>
                            <div class="price mb-0">
                                <?php if($sale->discount_price){?>
                                    <span class="old_price"><?php echo getAmtCustomMain($sale->sale_price);?></span>
                                <?php } ?>
                                <?php 
                                $org_price = 0;
                                $discount_amt = removePercentage($sale->discount_price);
                                if(isPercentage($sale->discount_price)){
                                    $org_price = $sale->sale_price * (100 - intval($discount_amt)) / 100;
                                }else{
                                    $org_price = $sale->sale_price  - intval($discount_amt);
                                }
                                ?>
                                <span class="org_price"><?php echo getAmtCustomMain($org_price);?></span>
                            </div>
                            <div class="rating">
                                <div class="d-flex align-items-center justify-content-start">
                                    <div class="rating_star">
                                    <?php for ($i = 5; $i >= 1; $i--) { ?>  
                                    <span class="product-id" 
                                        data-product-id="<?php echo ($sale->item_id); ?>" 
                                        data-ratting="<?php echo $i; ?>">
                                        <i class="<?php echo ($sale->avg_rating >= $i) ? 'bi bi-star-fill current-r' : 'bi bi-star'; ?>"></i>
                                    </span>  
                                    <?php } ?>  
                                    </div>
                                    <p class="rating_count">(<?php echo getAmt($sale->avg_rating); ?>)</p>
                                </div>
                            </div>
                            <div class="full_atc_btn">
                                <button class="add-to-cart" type="button" data-type="<?php echo escape_output($sale->type);?>" data-product-id="<?php echo $this->custom->encrypt_decrypt($sale->item_id, 'encrypt');?>" data-sp="<?php echo $this->custom->encrypt_decrypt($sale->sale_price, 'encrypt');?>">
                                    <span class="me-1">
                                        <i class="bi bi-cart3"></i>
                                    </span>
                                    <?php echo lang('add_cart');?>
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php } } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<!-- Testimonial/Ratting -->
<?php if(isset($content_hide_show->ratting) && $content_hide_show->ratting !='' && $customer_ratting){?>
<div class="testimonial_section section_padding">
    <div class="container">
        <div class="row">
            <?php if($customer_ratting){
                foreach($customer_ratting as $key=>$ratting){
            ?>
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="testimonial_section_card">
                    <p><i class="bi bi-quote quote-icon-left"></i> <?php echo escape_output($ratting->review);?> <i class="bi bi-quote quote-icon-right"></i></p>
                    <div class="rating_star">
                        <?php for ($i = 5; $i >= 1; $i--) { ?>  
                        <span class="product-id">
                            <i class="<?php echo ($ratting->rating >= $i) ? 'bi bi-star-fill current-r' : 'bi bi-star'; ?>"></i>
                        </span>  
                        <?php } ?> 
                    </div>
                    <div class="customer-name">
                        <p>John Deo</p>
                    </div>
                    <div class="testimonial_footer">
                        <?php
                        $file_path = FCPATH . 'uploads/items/'. $ratting->photo;
                        if(file_exists($file_path) && $ratting->photo){ 
                        ?>
                            <img loading="lazy"  src="<?php echo base_url();?>uploads/items/<?php echo $ratting->photo; ?>" alt="product">
                        <?php } else {?>
                            <img loading="lazy"  src="<?php echo base_url();?>uploads/site_settings/default-picture.png" alt="product">
                        <?php } ?>

                        <div class="content">
                            <h5><?php echo escape_output($ratting->item_name);?></h5>
                            <p class="price"><?php echo getAmt($ratting->sale_price);?></p>
                        </div>
                    </div>
                </div>
            </div>
            <?php }} ?>
        </div>
    </div>
</div>
<?php } ?>

<!-- Service Time -->
<?php if($service_time){?>
<div class="service_time section_padding_b section_padding_t">
    <div class="container">
        <div class="row justify-content-center">
            <?php foreach($service_time as $time){?>
            <div class="col-lg-3 col-md-4 col-sm-4 col-12 text-center">
                <?php
                $file_path = FCPATH . 'uploads/eCommerce/frontend/service_image/'. $time->service_image;
                if(file_exists($file_path) && $time->service_image){ 
                ?>
                    <img src="<?php echo base_url()?>uploads/eCommerce/frontend/service_image/<?php echo $time->service_image; ?>" alt="service">
                <?php } else {?>
                    <img src="<?php echo base_url()?>frequent_changing/eCommerce/frontend/images/service-time/Services-1.png" alt="service">
                <?php } ?>
                <h4 class="text-uppercase"><?php echo escape_output($time->title);?></h4>
                <p><?php echo escape_output($time->description);?></p>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php } ?>