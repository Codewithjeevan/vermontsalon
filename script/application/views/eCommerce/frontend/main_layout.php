<?php
$all_category        = getAllCategory();
$all_brand           = getAllBrand();
$wishlist            = getWishlistCount();
$outlet_list         = getOutletList();
$company_info        = getCompanyDateFroECommerce();
$ecommerce_setting   = getECommerceSetting();
$social_link         = json_decode(isset($ecommerce_setting->social_link) && $ecommerce_setting->social_link ? $ecommerce_setting->social_link : '');
$closable_notice     = json_decode(isset($ecommerce_setting->closable_notice) && $ecommerce_setting->closable_notice ? $ecommerce_setting->closable_notice : '');
$android_app_link    = json_decode(isset($ecommerce_setting->android_app_link) && $ecommerce_setting->android_app_link ? $ecommerce_setting->android_app_link : '');
$seo_meta_contetn    = json_decode(isset($ecommerce_setting->seo_meta_contetn) && $ecommerce_setting->seo_meta_contetn ? $ecommerce_setting->seo_meta_contetn : '');
$website_whitelabel  = json_decode(isset($ecommerce_setting->website_whitelabel) && $ecommerce_setting->website_whitelabel ? $ecommerce_setting->website_whitelabel : '');
$promotional_content = json_decode(isset($ecommerce_setting->promotional_content) && $ecommerce_setting->promotional_content ? $ecommerce_setting->promotional_content : '');
$preloader           = json_decode(isset($ecommerce_setting->preloader_content) && $ecommerce_setting->preloader_content ? $ecommerce_setting->preloader_content : '');
$payment_get_way     = json_decode(isset($ecommerce_setting->payment_getway_setting) && $ecommerce_setting->payment_getway_setting ? $ecommerce_setting->payment_getway_setting : '');
$content_hide_show   = json_decode(isset($ecommerce_setting->homepage_content_show_hide) && $ecommerce_setting->homepage_content_show_hide ? $ecommerce_setting->homepage_content_show_hide : '');
$available_language  = explode(",", $ecommerce_setting->available_language);
$frontend_language   = $this->session->userdata('language');
$frontend_outlet_id  = $this->session->userdata('frontend_outlet_id');
$customer_id         = $this->session->userdata('customer_id');
$customer_email      = $this->session->userdata('customer_email');

// pre($frontend_outlet_id);

if($frontend_language == ''){
    $language_set = $ecommerce_setting->default_language;
}else{
    $language_set = $frontend_language;
}

$wl = $website_whitelabel;
$site_name = '';
$site_footer = '';
$site_title = '';
$site_link = '';
$site_logo = '';
$site_favicon = '';
if($wl){
    if($wl->site_name){
        $site_name = $wl->site_name;
    }
    if($wl->site_footer){
        $site_footer = $wl->site_footer;
    }
    if($wl->site_title){
        $site_title = $wl->site_title;
    }
    if(isset($wl->site_link) && $wl->site_link){
        $site_link = $wl->site_link;
    }
    if($wl->site_logo){
        $site_logo = base_url()."uploads/site_settings/".$wl->site_logo;
    }
    if($wl->site_favicon){
        $site_favicon = base_url()."uploads/site_settings/".$wl->site_favicon;
    }
}
// pre(getAllSessionData());
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--======== Title & Favicon =======-->
    <title><?php echo escape_output($site_name); ?></title>
    <link rel="shortcut icon" href="<?php echo $site_favicon; ?>" type="image/x-icon">

    <!--======== Meta Seo =======-->
    <meta name="distribution" content="Global">
    <meta name="description" content="<?php echo isset($seo_meta_contetn->meta_description) &&  $seo_meta_contetn->meta_description ? $seo_meta_contetn->meta_description : '';?>">
    <meta name="author" content="<?php echo isset($seo_meta_contetn->meta_author) &&  $seo_meta_contetn->meta_author ? $seo_meta_contetn->meta_author : '';?>">
    <meta name="keywords" content="<?php echo isset($seo_meta_contetn->meta_keywords) &&  $seo_meta_contetn->meta_keywords ? $seo_meta_contetn->meta_keywords : '';?>">
    <meta property="og:type" content="<?php echo isset($seo_meta_contetn->meta_og_type) &&  $seo_meta_contetn->meta_og_type ? $seo_meta_contetn->meta_og_type : '';?>">
    <meta property="og:title" content="<?php echo isset($seo_meta_contetn->meta_og_title) &&  $seo_meta_contetn->meta_og_title ? $seo_meta_contetn->meta_og_title : '';?>" />
    <meta property="og:description" content="<?php echo isset($seo_meta_contetn->meta_og_site_name) &&  $seo_meta_contetn->meta_og_site_name ? $seo_meta_contetn->meta_og_site_name : '';?>" />
    
    <!--======== Css =======-->
    <link rel="stylesheet" href="<?php echo base_url()?>frequent_changing/eCommerce/frontend/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>frequent_changing/eCommerce/frontend/node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?php echo base_url()?>frequent_changing/eCommerce/frontend/css/jquery-ui.css">
    <link rel="stylesheet" href="<?php echo base_url()?>frequent_changing/eCommerce/frontend/css/slick.css">
    <link rel="stylesheet" href="<?php echo base_url()?>frequent_changing/eCommerce/frontend/node_modules/line-awesome/dist/line-awesome/css/line-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/notify/toastr.css?var=1.6" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url()?>frequent_changing/eCommerce/frontend/css/nice-select.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/select2/dist/css/select2.min.css?var=1.6">
    <link rel="stylesheet" href="<?php echo base_url()?>frequent_changing/eCommerce/frontend/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url()?>frequent_changing/eCommerce/frontend/css/responsive.css">
    <script src="<?php echo base_url()?>frequent_changing/eCommerce/frontend/js/jquery-3.5.1.min.js"></script>
    <script src="<?php echo base_url()?>frequent_changing/js/superplaceholder.js"></script>
    <style>
		:root {
            --theamColor: #0063D1;
            --hoverTheamColor: #619adb;
            --theamHoverColor: #264653;
            --theamActiveColor: rgb(168 140 233);
        }
        /* .search_suggest {
            max-height: 300px;
            overflow-y: auto;
            position: relative;
        } */
	</style>

</head>

<body>

    <!-- Input -->
    <input type="hidden" id="base_url" value="<?php echo base_url();?>">
    <input type="hidden" id="curreny_frontend" value="<?php echo escape_output($company_info->currency);?>">
    <input type="hidden" id="precision" value="<?php echo $company_info->precision; ?>">
    <input type="hidden" id="stripe_publish_key" value="<?php echo $payment_get_way->stripe_publishable_key; ?>">
    <input type="hidden" id="produt_search_option" value="<?php echo $content_hide_show->product_search_display_option; ?>">
    <input type="hidden" id="search_here_ecommerce_txt" value="<?php echo lang('search_here_ecommerce');?>">

    <!-- Preloader -->
    <?php if($preloader && $preloader->preloader_status == 'Enable' && $preloader->preloader_image){?>
    <div class="preloader">
        <img src="<?php echo base_url()?>uploads/eCommerce/preloader_image/<?php echo $preloader->preloader_image; ?>" alt="preloader">
    </div>
    <?php } ?>


    <!-- top header -->
    <div class="top_heaeder">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between">
                <div class="tophead_items">
                    <a href="tel:<?php echo escape_output($company_info->phone); ?>" class="me-0 pe-2"> 
                        <span>
                            <i class="bi bi-telephone"></i>
                        </span>
                        call: <?php echo escape_output($company_info->phone); ?>
                    </a>
                    <a href="mailto:<?php echo escape_output($company_info->email); ?>" class="text-lowercase"> 
                        <span>
                            <i class="bi bi-envelope"></i>
                        </span> 
                        <?php echo escape_output($company_info->email); ?>
                    </a>
                </div>
                <div class="tophead_items">
                    <a href="<?php echo base_url();?>e-track-order"><?php echo lang('Track_My_Order');?></a>
                    <div class="ms-3">
                        <select class="nice_select lan_name" name="lan_name">
                            <?php
                            $dir = glob("application/language/*",GLOB_ONLYDIR);
                            foreach ($dir as $value){
                                $separete = explode("language/", $value);
                                if (in_array(ucfirst($separete[1]), $available_language)){
                            ?>
                            <option <?php echo ucfirst($language_set) ==  ucfirst($separete[1]) ?  'selected' : '' ?>><?php echo ucfirstcustom($separete[1])?></option>
                            <?php }} ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- header -->
    <header>
        <div class="container">
            <div class="d-flex align-items-center justify-content-sm-between">
                <div class="logo">
                    <a href="<?php echo base_url();?>e-home">
                        <img loading="lazy"  src="<?php echo $site_logo; ?>" alt="logo">
                    </a>
                </div>
                <div class="search_wrap d-none d-lg-block">
                    <div class="search d-flex">
                        <div class="search_input">
                            <input type="text" placeholder="<?php echo lang('search_here_ecommerce');?>" id="show_suggest">
                        </div>
                        <div class="search_subimt">
                            <button>
                                <span class="d-none d-sm-inline-block">
                                    <i class="bi bi-search"></i>
                                </span>
                            </button>
                        </div>
                        <div class="search_suggest shadow-sm">
                            <div class="search_result_product">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="header_icon d-flex align-items-center ms-auto ms-sm-0">
                    <a href="<?php echo base_url()?>e-wish-list" class="icon_wrp text-center wishlist ms-0">
                        <span class="icon">
                            <i class="bi bi-suit-heart"></i>
                        </span>
                        <span class="icon_text"><?php echo lang('wish_list');?></span>
                        <span class="pops wish_list_count"><?php echo $wishlist ?? 0 ?></span>
                    </a>
                    <div class="shopcart">
                        <a href="<?php echo base_url()?>e-shopping-cart" class="icon_wrp text-center d-none d-lg-block">
                            <span class="icon">
                                <i class="bi bi-cart3"></i>
                            </span>
                            <span class="icon_text"><?php echo lang('cart')?></span>
                            <span class="pops total_cart_item">0</span>
                        </a>
                        <div class="shopcart_dropdown">
                            <div class="cart_droptitle">
                                <h4 class="text_lg"><span class="total_cart_item"></span> <?php echo lang('items')?></h4>
                            </div>
                            <div class="cartsdrop_wrap">
                            </div>
                            <div class="total_cartdrop">
                                <h4 class="text_lg text-uppercase mb-0"><?php echo lang('sub_total')?>:</h4>
                                <h4 class="text_lg mb-0 ms-2 subtotal_show"></h4>
                            </div>
                            <div class="cartdrop_footer d-flex mt-3">
                                <a href="<?php echo base_url();?>e-shopping-cart" class="default_btn w-50 text_xs px-1"><?php echo lang('view_cart')?></a>
                                 <a href="<?php echo base_url();?>e-checkout" class="default_btn second ms-3 w-50 text_xs px-1"><?php echo lang('checkOut');?></a>
                            </div>
                        </div>
                    </div>
                    <div class="position-relative myacwrap home-1">
                        <a href="<?php echo base_url();?>e-account" class="icon_wrp text-center myacc">
                            <span class="icon">
                                <i class="bi bi-person"></i>
                            </span>
                            <span class="icon_text"><?php echo lang('account');?></span>
                        </a>
                        <div class="myacc_cont">
                            <?php if(!$customer_id && !$customer_email){?>
                            <div class="ac_join">
                                <div class="account_btn">
                                    <div class="d-flex justify-content-between">
                                        <a href="<?php echo base_url();?>e-register" class="default_btn"><?php echo lang('Sign_Up');?></a>
                                        <a href="<?php echo base_url();?>e-login" class="default_btn second"><?php echo lang('Sign_In');?></a>
                                    </div>
                                    <a href="<?php echo base_url('Authentication/index');?>" class="mt-1 w-100 default_btn second"><?php echo lang('Admin');?> <?php echo lang('login');?></a>
                                </div>
                            </div>
                            <?php } ?>
                            <?php if($customer_id && $customer_email){?>
                            <div class="ac_links pt-0">
                                  <a href="<?php echo base_url();?>e-account" class="myac">
                                    <i class="lar la-id-card"></i>
                                    <?php echo lang('my_account');?>
                                </a>
                                <a href="<?php echo base_url();?>e-account-order-history">
                                    <i class="las la-gift"></i>
                                    <?php echo lang('My_Order');?>
                                </a>
                                <a href="<?php echo base_url();?>e-wish-list">
                                    <i class="lar la-heart"></i>
                                    <?php echo lang('My_Wishlist');?>
                                </a>
                                <a href="<?php echo base_url();?>e-shopping-cart">
                                    <i class="bi bi-cart3"></i>
                                    <?php echo lang('My_Cart');?>
                                </a>
                                <a href="<?php echo base_url();?>e-logout">
                                    <i class="las la-power-off"></i>
                                    <?php echo lang('Log_out');?>
                                </a>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- navbar -->
    <nav class="d-none d-lg-block">
        <div class="container">
            <div class="d-flex">
                <div class="all_category">
                    <div class="bars text-white d-flex align-items-center justify-content-center">
                        <span class="icon">
                            <i class="bi bi-ui-radios-grid"></i>
                        </span>
                        <span class="icon_text"><?php echo lang('All_categories');?></span>
                        <span class="all_cat_angle">
                            <i class="las la-angle-down"></i>
                        </span>
                    </div>
                    <div class="sub_categories_wrp">
                        <div class="sub_categories">
                            <h5 class="d-block position-relative d-lg-none subcats_title">
                                <?php echo lang('All_categories');?>
                            </h5>
                            <?php if($all_category){
                                foreach($all_category as $category){
                            ?>
                            <a href="<?php echo base_url();?>e-category/<?php echo $this->custom->encrypt_decrypt($category->id, 'encrypt');?>" class="singlecats">
                                <span class="txt"><?php echo escape_output($category->name); ?></span>
                            </a>
                            <?php }} ?>
                        </div>
                    </div>
                </div>
                <ul class="nav_bar flex-grow-1">
                    <li><a href="<?php echo base_url();?>e-home"><?php echo lang('home');?></a></li>
                    <li class="withsubs">
                        <a href="#"><?php echo lang('Brand');?> <span><i class="las la-angle-down"></i></span></a>
                        <ul class="subnav">
                            <?php if($all_brand){
                                foreach($all_brand as $brand){
                            ?>
                            <li><a href="<?php echo base_url();?>e-brand/<?php echo $this->custom->encrypt_decrypt($brand->id, 'encrypt');?>"><?php echo escape_output($brand->name)?></a></li>
                            <?php }} ?>
                        </ul>
                    </li>
                    <li><a href="<?php echo base_url();?>e-faq"><?php echo lang('Faq');?></a></li>
                    <li><a href="<?php echo base_url();?>e-contact"><?php echo lang('contact');?></a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Mobile bottom bar -->
    <div class="mobile_bottombar d-block d-lg-none">
        <div class="header_icon">
            <a href="javascript:void(0)" class="icon_wrp text-center open_menu">
                <span class="icon">
                    <i class="las la-bars"></i>
                </span>
                <span class="icon_text"><?php echo lang('Menu');?></span>
            </a>
            <a href="javascript:void(0)" class="icon_wrp text-center open_category">
                <span class="icon">
                   <i class="bi bi-list-ul"></i>
                </span>
                <span class="icon_text"><?php echo lang('category');?></span>
            </a>
            <a href="javascript:void(0)" class="icon_wrp text-center" id="src_icon">
                <span class="icon">
                   <i class="bi bi-search"></i>
                </span>
                <span class="icon_text"><?php echo lang('search');?></span>
            </a>
            <a href="javascript:void(0)" class="icon_wrp crt text-center" id="openCart">
                <span class="icon">
                    <i class="bi bi-cart3"></i>
                </span>
                <span class="icon_text"><?php echo lang('cart');?></span>
                <span class="pops total_cart_item">0</span>
            </a>
        </div>
    </div>

    <!-- Mobile menu -->
    <div class="mobile_menwrap d-lg-none" id="mobile_menwrap">
        <div class="mobile_menu_2">
            <h5 class="mobile_title">
                <?php echo lang('Menu');?>
                <span class="sidebarclose" id="menuclose">
                    <i class="las la-times"></i>
                </span>
            </h5>
            <ul>
                <li>
                    <a href="<?php echo base_url();?>">
                        <?php echo lang('home');?>
                    </a>
                </li>
                <li class="withsub">
                    <a href="javascript:void(0)">
                        <?php echo lang('Brand');?>
                    </a>
                    <div class="submn">
                        <?php if($all_brand){
                            foreach($all_brand as $brand){
                        ?>
                            <a href="<?php echo base_url();?>e-brand/<?php echo $this->custom->encrypt_decrypt($brand->id, 'encrypt');?>"><?php echo escape_output($brand->name)?></a>
                        <?php }} ?>
                    </div>
                </li>
                <li class="withsub">
                    <a href="javascript:void(0)">
                        <?php echo lang('my_account');?>
                    </a>
                    <div class="submn">
                        <?php if(!$customer_id && !$customer_email){?>
                        <a href="<?php echo base_url();?>e-login"><?php echo lang('Sign_In');?></a>
                        <a href="<?php echo base_url();?>e-register"><?php echo lang('Sign_Up');?></a>
                        <?php } else {?>
                        <a href="<?php echo base_url();?>e-account"><?php echo lang('my_account');?></a>
                        <a href="<?php echo base_url();?>e-account-order-history"><?php echo lang('My_Order');?></a>
                        <a href="<?php echo base_url();?>e-wish-list"><?php echo lang('My_Wishlist');?></a>
                        <a href="<?php echo base_url();?>e-shopping-cart"><?php echo lang('My_Cart');?></a>
                        <a href="<?php echo base_url();?>e-change-password"><?php echo lang('change_password');?></a>
                        <a href="<?php echo base_url();?>e-logout"><?php echo lang('Log_out');?></a>
                        <?php } ?>
                    </div>
                </li>
                <li class="withsub">
                    <a href="javascript:void(0)">
                        <?php echo lang('Other_Pages');?>
                    </a>
                    <div class="submn">
                        <a href="<?php echo base_url();?>e-faq"><?php echo lang('Faq');?></a>
                        <a href="<?php echo base_url();?>e-contact"><?php echo lang('contact');?></a>
                        <a href="<?php echo base_url();?>e-track-order"><?php echo lang('Track_Order');?></a>
                        <a href="<?php echo base_url();?>e-checkout"><?php echo lang('checkOut');?></a>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <!--  Mobile cart -->
    <div class="mobile_menwrap d-lg-none" id="mobileCart">
        <div class="mobile_cart_wrap d-flex flex-column">
            <h5 class="mobile_title">
                Cart
                <span class="sidebarclose" id="mobileCartClose">
                    <i class="las la-times"></i>
                </span>
            </h5>
            <div class="px-3 py-3 flex-grow-1 d-flex flex-column">
                <div class="cart_droptitle">
                    <h4 class="text_lg"><span class="total_cart_item">0</span> <?php echo lang('items');?></h4>
                </div>
                <div class="cartsdrop_wrap">
                </div>
                <div class="mt-auto">
                    <div class="total_cartdrop">
                        <h4 class="text_lg text-uppercase mb-0"><?php echo lang('sub_total');?>:</h4>
                        <h4 class="text_lg mb-0 ms-2 subtotal_show">0</h4>
                    </div>
                    <div class="cartdrop_footer mt-3 d-flex">
                        <a href="<?php echo base_url();?>e-shopping-cart" class="default_btn w-50 text_xs px-1"><?php echo lang('View_Cart');?></a>
                        <a href="<?php echo base_url()?>e-checkout" class="default_btn second ms-3 w-50 text_xs px-1"><?php echo lang('checkOut');?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile searchbar -->
    <div class="mobile_search_bar">
        <div class="mobile_search_text">
            <p><?php echo lang('what_you_are_looking_for');?></p>
            <span class="close_mbsearch" id="close_mbsearch">
                <i class="las la-times"></i>
            </span>
        </div>
        <form>
            <input type="text" placeholder="<?php echo lang('search_here_ecommerce');?>" id="show_suggest_2">
            <button>
                <i class="icon-search-left"></i>
            </button>
        </form>
        <div class="search_result_product search_result_product_2">
        </div>
    </div>

    <!-- Mobile category -->
    <div class="mobile_menwrap d-lg-none" id="mobile_catwrap">
        <div class="sub_categories">
            <h5 class="mobile_title">
                <?php echo lang('All_categories');?>
                <span class="sidebarclose" id="catclose">
                    <i class="las la-times"></i>
                </span>
            </h5>
            <?php if($all_category){
                foreach($all_category as $category){
            ?>
            <a href="<?php echo base_url();?>e-category/<?php echo $this->custom->encrypt_decrypt($category->id, 'encrypt');?>" class="singlecats">
                <span class="txt"><?php echo escape_output($category->name); ?></span>
            </a>
            <?php }} ?>
        </div>
    </div>


    <!-- Main content -->
    <?php
        if (isset($main_content)) {
            echo $main_content;
        }
    ?>
    <!-- footer area -->
    <footer class="white">
        <div class="container">
            <div class="footer-content-wrap">
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-6 mb-4 mb-md-0">
                        <div class="footer_logo">
                            <img loading="lazy"  src="<?php echo $site_logo ?>" alt="easy shop">
                        </div>
                        <div class="footet_text">
                            <p><?php echo escape_output($ecommerce_setting->footer_description);?></p>
                        </div>
                        <div class="footer_newslet">
                            <h4><?php echo lang('Newsletter');?></h4>
                            <form class="footernews_form">
                                <input type="text" placeholder="Your email address" name="newsletter_email" class="newsletter_email">
                                <button type="button" class="newsletter_submit">
                                    <i class="bi bi-send"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 mb-4 mb-md-0">
                        <div class="footer_download">
                            <h4 class="footer_title"><?php echo lang('Support');?></h4>
                            <div class="footer_contact">
                                <?php if($company_info->address){?>
                                <p>
                                    <span class="icn"><i class="las la-map-marker-alt"></i></span>
                                    <?php echo escape_output($company_info->address); ?>
                                </p>
                                <?php } ?>
                                <?php if($company_info->phone){?>
                                <p class="phn">
                                    <span class="icn"><i class="las la-phone"></i></span>
                                    <?php echo escape_output($company_info->phone); ?>
                                </p>
                                <?php } ?>
                                <?php if($company_info->email){?>
                                <p class="eml">
                                    <span class="icn"><i class="lar la-envelope"></i></span>
                                    <?php echo escape_output($company_info->email); ?>
                                </p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 mb-3 mb-md-0">
                        <div class="footer_menu">
                            <h4 class="footer_title"><?php echo lang('my_account');?></h4>
                            <a href="<?php echo base_url();?>e-account-order-history"><?php echo lang('My_Order');?></a>
                            <a href="<?php echo base_url();?>e-wish-list"><?php echo lang('My_Wishlist');?></a>
                            <a href="<?php echo base_url();?>e-track-order"><?php echo lang('Track_Order');?></a>
                            <a href="<?php echo base_url();?>e-account"><?php echo lang('Manage_Account');?></a>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 mb-3 mb-md-0">
                        <div class="footer_menu">
                            <h4 class="footer_title"><?php echo lang('Download_App');?></h4>
                            <div class="row">
                                <div class="col-6">
                                    <img src="<?php echo base_url()?>frequent_changing/eCommerce/frontend/images/footer-image/Qr Code.png" alt="img" class="img-fluid">
                                </div>
                                <div class="col-6">
                                    <?php if($android_app_link->android_app_link){?>
                                    <a href="<?php echo $android_app_link->android_app_link; ?>" target="_blank">
                                        <img src="<?php echo base_url()?>frequent_changing/eCommerce/frontend/images/footer-image/png-transparent-google-play-store-logo-google-play-app-store-android-wallets-text-label-logo.png" alt="android-app-link" class="mb-1 img-fluid">
                                    </a>
                                    <?php } ?>
                                    <?php if($android_app_link->ios_app_link){?>
                                    <a href="<?php echo $android_app_link->ios_app_link; ?>" target="_blank">
                                        <img src="<?php echo base_url()?>frequent_changing/eCommerce/frontend/images/footer-image/download-appstore.png" alt="ios-app-link" class="mb-1 img-fluid">
                                    </a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                        <div class="footer_social col-lg-6 col-lg-12">
                            <div class="footer_icon d-flex">
                                <?php if($social_link->facebook){ ?> 
                                <a target="_blank" href="<?php echo $social_link->facebook; ?>" class="facebook"><i class="lab la-facebook-f"></i></a>
                                <?php } ?>
                                <?php if($social_link->twitter){ ?>
                                <a target="_blank" href="<?php echo $social_link->twitter; ?>" class="twitter"><i class="lab la-twitter"></i></a>
                                <?php } ?>
                                <?php if($social_link->instagram){ ?>
                                <a target="_blank" href="<?php echo $social_link->instagram; ?>" class="instagram"><i class="lab la-instagram"></i></a>
                                <?php } ?>
                                <?php if($social_link->tiktok){ ?>
                                <a target="_blank" href="<?php echo $social_link->tiktok; ?>" class="instagram"><i class="bi bi-tiktok"></i></a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- copyright -->
    <div class="copyright_wrap">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-12">
                    <p class="copyright_text"><?php echo escape_output($site_footer); ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Product quick view modal -->
    <div class="product_quickview" id="product_quickview">
        <div class="prodquick_wrap position-relative">
            <div class="close_quickview">
                <i class="las la-times"></i>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="product_view_slider product_view_slider3" id="product_view_slider">
                    </div>
                    <div class="product_viewslid_nav product_viewslid_nav3" id="product_viewslid_nav">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="product_info_wrapper">
                        <div class="product_base_info">
                            <h1 class="modal_product_name"></h1>
                            <div class="rating">
                                <div class="d-flex align-items-center modal_product_ratting">
                                    <div class="rating_star">
                                    </div>
                                    <p class="rating_count">0</p>
                                </div>
                            </div>
                            <div class="product_other_info">
                                <input type="hidden" class="modal_p_stock">
                                <p><span class="text-semibold"><?php echo lang('Availability');?>:</span><span class="text-green modal_product_stock"></span> </p>
                                <p><span class="text-semibold"><?php echo lang('brand');?>:</span><span class="modal_product_brand"></span></p>
                                <p><span class="text-semibold"><?php echo lang('category');?>:</span> <span class="modal_product_category"></span></p>
                            </div>
                            <div class="price mt-3 mb-3 d-flex align-items-center">
                                <span class="prev_price ms-0 modal_product_prev_price">00</span>
                                <span class="org_price ms-2 modal_product_org_price">00</span>
                                <div class="disc_tag ms-3"></div>
                            </div>
                            <div class="pd_dtails">
                                <p class="modal_product_details"></p>
                            </div>
                            <div class="shop_filter border-bottom-0 pb-0" id="variation_show_parent">
                                <div class="size_selector mb-3">
                                    <h5><?php echo lang('variations');?></h5>
                                    <div class="modal_size_wrap d-flex align-items-center flex-wrap" id="variation_show">
                                    </div>
                                </div>
                            </div>
                            <div class="cart_qnty ms-md-auto">
                                <p><?php echo lang('Qty_Amount');?></p>
                                <div class="d-flex align-items-center">
                                    <div class="cart_qnty_btn modal_product_quantity_decrease">
                                        <i class="las la-minus"></i>
                                    </div>
                                    <div class="cart_count modal_product_quantity">1</div>
                                    <div class="cart_qnty_btn modal_product_quantity_increase">
                                        <i class="las la-plus"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product_buttons">
                            <a href="javascript:void(0)" class="default_btn me-sm-3 me-2 px-2 px-lg-4 add-to-cart1 add-to-cart-quick" type="button" data-product-id="" data-sp="">
                                <i class="icon-cart me-2"></i> 
                                <?php echo lang('add_to_cart');?>
                            </a>
                            <a href="javascript:void(0)" class="default_btn second px-3 px-ms-4 adto_wish-quick">
                                <i class="icon-heart me-2"></i>
                                <?php echo lang('Wishlist');?>
                            </a>
                        </div>
                        <div class="share_icons footer_icon d-flex">
                            <?php if($social_link->facebook){?>
                            <a href="<?php echo $social_link->facebook;?>"><i class="lab la-facebook-f"></i></a>
                            <?php } ?>
                            <?php if($social_link->twitter){?>
                            <a href="<?php echo $social_link->twitter;?>"><i class="lab la-twitter"></i></a>
                            <?php } ?>
                            <?php if($social_link->instagram){?>
                            <a href="<?php echo $social_link->instagram;?>"><i class="lab la-instagram"></i></a>
                            <?php } ?>
                            <?php if($social_link->tiktok){ ?>
                            <a href="<?php echo $social_link->tiktok;?>"><i class="bi bi-tiktok"></i></a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Payment Method Modal -->
    <div class="product_quickview" id="payment_method_modal">
        <div class="prodquick_wrap position-relative">
            <div class="close_quickview close_quickview1">
                <i class="las la-times"></i>
            </div>
            <form id="payment-form">
                <h3><?php echo lang('Online_Payment_By');?> <span class="payment_method_name"></span></h3>
                <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group mb-3">
                            <label for="credit_card_no"><?php echo lang('Card_Number');?></label>
                            <input type="text" class="form-control" id="credit_card_no" placeholder="4242 4242 4242 4242" maxlength="19" value="4242 4242 4242 4242">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group mb-3">
                            <label for="holder_name"><?php echo lang('Card_Holder_Name');?></label>
                            <input type="text" class="form-control" id="holder_name" placeholder="Name on card">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <label><?php echo lang('Expiration_Date');?></label>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group mb-3">
                                    <select class="form-control select2 me-2" id="payment_month">
                                        <option value=""><?php echo lang('month');?></option>
                                        <?php for($i = 1; $i <= 12; $i++): ?>
                                            <option value="<?php echo sprintf('%02d', $i); ?>"><?php echo sprintf('%02d', $i); ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group mb-3">
                                    <select class="form-control select2" id="payment_year">
                                        <option value=""><?php echo lang('year');?></option>
                                        <?php 
                                        $current_year = date('Y');
                                        for($i = $current_year; $i <= $current_year + 10; $i++): 
                                        ?>
                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                        <div class="form-group mb-3">
                            <label for="payment_cvc"><?php echo lang('cvc');?></label>
                            <input type="text" class="form-control" id="payment_cvc" placeholder="123" maxlength="4">
                        </div>
                    </div>  
                    <div class="col-12">
                        <button type="button" class="default_btn" id="online_payment"><?php echo lang('pay');?></button>
                    </div>    
                </div>
            </form>
        </div>
    </div>

    <!-- Promotional Product -->
    <?php if(isset($promotional_content->promotional_notice_status) && ($promotional_content->promotional_notice_status == 'Enable' && $promotional_content->promotional_notice_image)){?>
    <div class="popup_wrap popup_wrap_promotional_product">
        <div class="popup_container">
            <div class="popup_content popup_content_2">
                <img class="img-fluid" src="<?php echo base_url().'uploads/eCommerce/promotional_content/'. $promotional_content->promotional_notice_image; ?>" alt="">
                <div class="close_popup">
                    <i class="las la-times"></i>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>

    <!-- Outlet Session Set -->
    <?php if(!$frontend_outlet_id){?>
    <div class="popup_wrap popup_wrap_outlet active">
        <div class="popup_container">
            <div class="popup_content">
                <h3><?php echo lang('Select_Your_Nearest_Outlet');?></h3>
                <?php echo form_open(base_url() . 'ECommerce_frontend/setOutlet') ?>
                <div class="row">
                    <div class="col-12">
                        <select name="frontend_outlet_id" id="frontend_outlet_id" class="nice_select ">
                            <option value=""><?php echo lang('select_outlet');?></option>
                            <?php foreach($outlet_list as $outlet){?>
                            <option value="<?php echo escape_output($outlet->id);?>"><?php echo escape_output($outlet->outlet_name);?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-12 mt-3 text-center">
                        <button type="submit" class="default_btn"><?php echo lang('submit');?></button>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    <?php }?>


    <!-- all js -->
    <script src="<?php echo base_url(); ?>frequent_changing/js/stripe.js"></script>
    <script src="<?php echo base_url()?>frequent_changing/eCommerce/frontend/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url()?>frequent_changing/eCommerce/frontend/js/jquery-ui.min.js"></script>
    <script src="<?php echo base_url()?>frequent_changing/eCommerce/frontend/js/slick.min.js"></script>
    <script src="<?php echo base_url()?>frequent_changing/eCommerce/frontend/js/jquery.nice-select.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/notify/toastr.js"></script>
    <script src="<?php echo base_url(); ?>assets/bower_components/select2/dist/js/select2.full.min.js"></script>
    <script src="<?php echo base_url()?>frequent_changing/eCommerce/frontend/js/app.js"></script>
    <script src="<?php echo base_url()?>frequent_changing/eCommerce/frontend/js/eCommerce.js"></script>

</body>

</html>