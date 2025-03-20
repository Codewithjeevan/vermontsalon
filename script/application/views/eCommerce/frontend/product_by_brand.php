<input type="hidden" value="<?php echo $url_name;?>" class="url_name">
<input type="hidden" value="Yes" class="initial_load">
<input type="hidden" value="<?php echo $brand_id;?>" class="initial_filter_id">
<!-- breadcrumbs -->
<div class="container">
    <div class="breadcrumbs">
        <a href="<?php echo base_url();?>"><i class="las la-home"></i></a>
        <a href="#" class="javascript:void(0);"><?php echo lang('Shop');?></a>
        <a href="#" class="active"><?php echo escape_output($brand_name);?></a>
    </div>
</div>


<!-- shop grid view -->
<div class="shop_wrap section_padding_b">
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-lg-4 position-relative">
                <div class="filter_box py-3 px-3 shadow_sm">
                    <div class="close_filter d-block d-lg-none"><i class="las la-times"></i></div>
                    <div class="shop_filter d-block d-sm-none">
                        <h4 class="filter_title"><?php echo lang('Sort_by');?></h4>
                        <div class="sorting_filter mb-2">
                            <select class="nice_select product_sorting">
                                <option value="Default"><?php echo lang('Default_sorting');?></option>
                                <option value="Low-To-High"><?php echo lang('Price_low_high');?></option>
                                <option value="High-To-Low"><?php echo lang('Price_high_low');?></option>
                            </select>
                        </div>
                    </div>
                    <div class="shop_filter">
                        <h4 class="filter_title"><?php echo lang('category');?></h4>
                        <div class="filter_list">
                            <?php if($categories){
                                foreach($categories as $category){
                            ?>
                            <div class="custom_check d-flex align-items-center mb-2">
                                <div class="checkbox-wrapper">
                                    <input type="checkbox" class="check_inp custom-checkbox" name="product_category" id="cat-<?php echo escape_output($category->id);?>">
                                    <label class="checkbox-label" for="cat-<?php echo escape_output($category->id);?>">
                                        <span class="checkbox-custom">
                                            <i class="las la-check check-icon"></i>
                                        </span>
                                        <span class="label-text"><?php echo escape_output($category->name);?></span>
                                    </label>
                                </div>
                            </div>
                            <?php }} ?>
                        </div>
                    </div>
                    <div class="shop_filter">
                        <h4 class="filter_title"><?php echo lang('brand');?></h4>
                        <div class="filter_list">
                            <?php if($brands){
                                foreach($brands as $brand){
                            ?>
                            <div class="custom_check d-flex align-items-center mb-2">
                                <div class="checkbox-wrapper">
                                    <input <?php echo isset($brand_id) && $brand_id == $brand->id ? 'checked' : ''?> type="checkbox" class="check_inp custom-checkbox" name="product_brand" id="bnd-<?php echo escape_output($brand->id);?>">
                                    <label class="checkbox-label" for="bnd-<?php echo escape_output($brand->id);?>">
                                        <span class="checkbox-custom">
                                            <i class="las la-check check-icon"></i>
                                        </span>
                                        <span class="label-text"><?php echo escape_output($brand->name);?></span>
                                    </label>
                                </div>
                            </div>
                            <?php }} ?>
                        </div>
                    </div>
                    <div class="shop_filter">
                        <h4 class="filter_title"><?php echo lang('price');?></h4>
                        <div class="price-range-slider">
                            <div id="slider-range" class="range-bar"></div>
                            <p class="range-value">
                                <input type="text" id="amount" readonly>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8">
                <div class="d-flex align-items-center">
                    <div class="d-block d-lg-none">
                        <button class="default_btn py-2 me-3 rounded" id="mobile_filter_btn"><?php echo lang('filter');?></button>
                    </div>
                    <div class="sorting_filter d-none d-sm-block">
                        <select class="nice_select product_sorting">
                            <option value="Default"><?php echo lang('Default_sorting');?></option>
                            <option value="Low-To-High"><?php echo lang('Price_low_high');?></option>
                            <option value="High-To-Low"><?php echo lang('Price_high_low');?></option>
                        </select>
                    </div>
                    <div class="view_filter d-flex align-items-center ms-auto">
                        <p class="m-0"><strong>0</strong> <?php echo lang('Result_Found');?></p>
                    </div>
                </div>
                <div class="shop_products">
                    <div class="row gy-4">
                    </div>
                    <div class="pagination_wrp d-flex align-items-center justify-content-center mt-4">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url()?>frequent_changing/eCommerce/frontend/js/filter_product.js"></script>