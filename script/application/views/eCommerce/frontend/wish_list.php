<!-- breadcrumbs -->
<div class="container">
    <div class="breadcrumbs">
        <a href="index-1.html"><i class="las la-home"></i></a>
        <a href="#" class="active"><?php echo lang('Wishlist');?></a>
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
                <div class="shop_cart_wrap wishlist">
                    <?php if($wishlist){
                        foreach($wishlist as $item){
                    ?>
                    <div class="single_shop_cart common_cart_trigger d-flex align-items-center flex-wrap mt-0 px-3 mb-3">
                        <div class="cart_img mb-4 mb-md-0">
                            <img loading="lazy"  src="<?php echo base_url()?>uploads/items/<?php echo escape_output($item->photo); ?>" alt="product">
                        </div>
                        <div class="cart_cont">
                            <a href="<?php echo base_url();?>e-product-details/<?php echo $this->custom->encrypt_decrypt($item->id, 'encrypt'); ?>">
                                <?php if($item->parent_name){?>
                                    <h5><?php echo escape_output($item->parent_name . '-'. $item->name);?></h5>
                                <?php } else {?>
                                    <h5><?php echo escape_output($item->name);?></h5>
                                <?php } ?>
                            </a>
                        </div>
                        <div class="cart_price ms-md-auto ms-0">
                            <p><?php echo getAmt(floatval($item->sale_price)); ?></p>
                        </div>
                        <div class="wish_cart_btn ms-md-auto ms-0 mt-3 mt-md-0">
                            <button class="list_product_btn add-to-cart" data-type="<?php echo escape_output($item->type);?>" data-product-id="<?php echo $this->custom->encrypt_decrypt($item->id, 'encrypt');?>" data-sp="<?php echo $this->custom->encrypt_decrypt($item->sale_price, 'encrypt');?>"><span class="icon">
                                <i class="bi bi-cart3"></i>
                            </span><?php echo lang('add_to_cart')?></button>
                        </div>
                        <div class="cart_remove ms-auto align-self-end align-self-md-center wishlist_remove" data-product-id="<?php echo $this->custom->encrypt_decrypt($item->id, 'encrypt');?>">
                            <i class="bi bi-trash"></i>
                        </div>
                    </div>
                    <?php }} ?>
                </div>
            </div>
        </div>
    </div>
</div>