<?php
if($products){
    foreach($products as $product){
?>
<div class="col-md-4 col-sm-6">
    <div class="single_toparrival common_cart_trigger m-0">
        <div class="topariv_img">
            <?php
            $file_path = FCPATH . 'uploads/items/'. $product->photo;
            if(file_exists($file_path) && $product->photo){ 
            ?>
                <img loading="lazy" src="<?php echo base_url();?>uploads/items/<?php echo $product->photo; ?>" alt="product">
            <?php } else {?>
                <img loading="lazy" src="<?php echo base_url();?>uploads/site_settings/default-picture.png" alt="product">
            <?php } ?>
            <div class="prod_soh">
                <div class="adto_wish">
                    <i class="bi bi-suit-heart"></i>
                </div>
                <div class="adto_quick open_quickview" data-pro-id="<?php echo $this->custom->encrypt_decrypt($product->id, 'encrypt'); ?>">
                    <i class="las la-eye"></i>
                </div>
            </div>
        </div>
        <div class="topariv_cont">
            <a href="<?php echo base_url();?>e-product-details/<?php echo $this->custom->encrypt_decrypt($product->id, 'encrypt'); ?>">
                <?php if($product->parent_name){?>
                    <h4><?php echo escape_output($product->parent_name . '-'. $product->name);?></h4>
                <?php } else {?>
                    <h4><?php echo escape_output($product->name);?></h4>
                <?php } ?>
            </a>
            <div class="rating">
                <div class="d-flex align-items-center justify-content-start">
                    <div class="rating_star">
                    <?php for ($i = 5; $i >= 1; $i--) { ?>  
                        <span class="product-id" 
                            data-product-id="<?php echo ($product->id); ?>" 
                            data-ratting="<?php echo $i; ?>">
                            <i class="<?php echo ($product->avg_rating >= $i) ? 'bi bi-star-fill current-r' : 'bi bi-star'; ?>"></i>
                        </span>  
                    <?php } ?>  
                    </div>
                    <p class="rating_count mb-0">(<?php echo getAmt($product->avg_rating); ?>)</p>
                </div>
            </div>
        </div>
        <div class="full_atc_btn">
            <div class="price mb-1 mt-2">
                <span class="org_price"><?php echo getAmtCustomMain($product->sale_price);?></span>
            </div>
            <button class="add-to-cart" type="button" data-type="<?php echo escape_output($product->type);?>" data-product-id="<?php echo $this->custom->encrypt_decrypt($product->id, 'encrypt');?>" data-sp="<?php echo $this->custom->encrypt_decrypt($product->sale_price, 'encrypt');?>">
                <span class="me-1">
                    <i class="bi bi-cart3"></i>
                </span>
                <?php echo lang('add_to_cart');?>
            </button>
        </div>
        <!-- Rest of your product card HTML -->
    </div>
</div>
<?php } } ?>