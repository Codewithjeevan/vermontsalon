<?php
/*
    ###########################################################
    # PRODUCT NAME:   Off POS
    ###########################################################
    # AUTHER:   Door Soft
    ###########################################################
    # EMAIL:   info@doorsoft.co
    ###########################################################
    # COPYRIGHTS:   RESERVED BY Door Soft
    ###########################################################
    # WEBSITE:   https://www.doorsoft.co
    ###########################################################
    # This is ECommerce_setting Controller
    ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class ECommerce_setting extends Cl_Controller {
    /**
     * load constructor
     * @access public
     * @return void
     */    
    public function __construct() {
        parent::__construct();
        $this->load->model('Authentication_model');
        $this->load->model('Common_model');
        $this->load->model('ECommerce_model');
        $this->load->library('form_validation');
        $this->Common_model->setDefaultTimezone();
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        $segment_2 = $this->uri->segment(2);
        $segment_3 = $this->uri->segment(3);
        $controller = "10";
        $function = "";
        // if(($segment_2 == "emailConfiguration")){
        //     $function = "edit";
        // }else{
        //     $this->session->set_flashdata('exception_1',lang('no_access'));
        //     redirect('Authentication/userProfile');
        // }
        if(!checkAccess($controller,$function)){
            $this->session->set_flashdata('exception_1',lang('no_access'));
            redirect('Authentication/userProfile');
        }
    }





    /**
     * eCommerceSetting
     * @access public
     * @param int
     * @return void
     */

    public function eCommerceSetting($encrypted_id = ''){
        $id = 1;
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('default_language', lang('default_language'), 'required|max_length[25]');
            $this->form_validation->set_rules('available_language[]', lang('available_language'), 'required|max_length[300]');
            $this->form_validation->set_rules('order_advance', lang('order_advance'), 'required|max_length[25]');
            $this->form_validation->set_rules('otp_on_signup', lang('otp_on_signup'), 'required|max_length[25]');
            $this->form_validation->set_rules('otp_on_login', lang('otp_on_login'), 'required|max_length[25]');
            $this->form_validation->set_rules('android_app_link', lang('android_app_link'), 'max_length[255]');
            $this->form_validation->set_rules('ios_app_link', lang('ios_app_link'), 'max_length[255]');
            $this->form_validation->set_rules('facebook', lang('facebook'), 'max_length[255]');
            $this->form_validation->set_rules('instagram', lang('instagram'), 'max_length[255]');
            $this->form_validation->set_rules('twitter', lang('twitter'), 'max_length[255]');
            $this->form_validation->set_rules('tiktok', lang('tiktok'), 'max_length[255]');
            
            // SMTP Validation
            $smtp_type = htmlspecialcharscustom($this->input->post($this->security->xss_clean('smtp_type')));
            $this->form_validation->set_rules('smtp_type', lang('smtp_type'), 'required|max_length[25]');
            $this->form_validation->set_rules('host_name', lang('host_name'), 'required|max_length[100]');
            $this->form_validation->set_rules('port_address', lang('port_address'), 'required|max_length[100]');
            $this->form_validation->set_rules('encryption', lang('encryption'), 'required|max_length[10]');
            $this->form_validation->set_rules('user_name', lang('user_name'), 'required|max_length[55]');
            $this->form_validation->set_rules('password', lang('password'), 'required|max_length[55]');
            $this->form_validation->set_rules('from_name', lang('from_name'), 'required|max_length[55]');
            $this->form_validation->set_rules('from_email', lang('from_email'), 'required|max_length[55]');
            if($smtp_type == 'Sendinblue'){
                $this->form_validation->set_rules('api_key', lang('api_key'), 'required|max_length[300]');
            }else{
                $this->form_validation->set_rules('api_key', lang('api_key'), 'max_length[300]');
            }
            $this->form_validation->set_rules('smtp_enable_status', lang('smtp_enable_status'), 'required|max_length[25]');

            // SMS Validation
            $this->form_validation->set_rules('sms_service_provider',lang('sms_service_provider'), "max_length[50]");
            $sms_service_provider = htmlspecialcharscustom($this->input->post($this->security->xss_clean('sms_service_provider')));
            if($sms_service_provider == 1){
                $this->form_validation->set_rules('field_1_0',lang('SID'), "required|max_length[250]");
                $this->form_validation->set_rules('field_1_1',lang('Token'), "required|max_length[250]");
                $this->form_validation->set_rules('field_1_2',lang('Twilio_Number'), "required|max_length[250]");
            }else if($sms_service_provider == 2){
                $this->form_validation->set_rules('field_2_0',lang('profile_id'), "required|max_length[250]");
                $this->form_validation->set_rules('field_2_1',lang('password'), "required|max_length[250]");
                $this->form_validation->set_rules('field_2_2',lang('sender_id'), "required|max_length[250]");
                $this->form_validation->set_rules('field_2_3',lang('country_code'), "required|max_length[250]");
            }else if($sms_service_provider == 3){
                $this->form_validation->set_rules('field_3_1',lang('api_key'), "required|max_length[250]");
                $this->form_validation->set_rules('field_3_2',lang('sender_id'), "required|max_length[250]");
            }else if($sms_service_provider == 4){
                $this->form_validation->set_rules('field_4_0',lang('profile_id'), "required|max_length[250]");
                $this->form_validation->set_rules('field_4_1',lang('api_key'), "required|max_length[250]");
                $this->form_validation->set_rules('field_4_2',lang('sender_id'), "required|max_length[250]");
            }


            // Payment Getway Setting
            $this->form_validation->set_rules('action_type_stripe', lang('status'), 'required|max_length[55]');
            $this->form_validation->set_rules('stripe_api_key', lang('Stripe_Secret_Key'), 'required');
            $this->form_validation->set_rules('stripe_publishable_key', lang('Stripe_Publishable_Key'), 'required');
            $this->form_validation->set_rules('action_type_paypal', lang('status'), 'required|max_length[55]');
            $this->form_validation->set_rules('paypal_user_name', lang('paypal_user_name'), 'required');
            $this->form_validation->set_rules('paypal_password', lang('paypal_password'), 'required');
            $this->form_validation->set_rules('paypal_signature', lang('paypal_signature'), 'required');

            // SEO Meta validation
            $this->form_validation->set_rules('meta_author', lang('meta_author'), 'max_length[100]');
            $this->form_validation->set_rules('meta_description', lang('meta_description'), 'max_length[300]');
            $this->form_validation->set_rules('meta_keywords', lang('meta_keywords'), 'max_length[255]');
            $this->form_validation->set_rules('meta_og_type', lang('meta_og_type'), 'max_length[100]');
            $this->form_validation->set_rules('meta_og_title', lang('meta_og_title'), 'max_length[100]');
            $this->form_validation->set_rules('meta_og_site_name', lang('meta_og_site_name'), 'max_length[100]');

            // Preloader Image Validate
            $this->form_validation->set_rules('preloader_image', lang('preloader_image'), 'callback_validate_preloader_image|max_length[500]');
            
            // Closable notice
            $this->form_validation->set_rules('closable_notice_status', lang('closable_notice_status'), 'max_length[10]');
            
            // Product Search Option
            $this->form_validation->set_rules('product_search_display_option', lang('product_search_display_option'), 'required|max_length[100]');

            // Footer Description
            $this->form_validation->set_rules('footer_description', lang('footer_description'), 'required|max_length[255]');

            if ($this->form_validation->run() == TRUE) {
                $data = array();
                $data['default_language'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('default_language')));
                $available_language = $this->input->post($this->security->xss_clean('available_language'));
                if($available_language){
                    $available_language_list = implode(',', $available_language);
                    $data['available_language'] = $available_language_list;
                }
                $data['order_advance'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('order_advance')));
                $data['otp_on_signup'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('otp_on_signup')));
                $data['otp_on_login'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('otp_on_login')));

                $app_link = [];
                $app_link['android_app_link'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('android_app_link')));
                $app_link['ios_app_link'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('ios_app_link')));
                $data['android_app_link'] = json_encode($app_link);

                $social_link = [];
                $social_link['facebook'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('facebook')));
                $social_link['instagram'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('instagram')));
                $social_link['twitter'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('twitter')));
                $social_link['tiktok'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('tiktok')));
                $data['social_link'] = json_encode($social_link);

                $smtp = [];
                $smtp['smtp_type'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('smtp_type')));
                $smtp['host_name'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('host_name')));
                $smtp['port_address'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('port_address')));
                $smtp['encryption'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('encryption')));
                $smtp['user_name'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('user_name')));
                $smtp['password'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('password')));
                $smtp['from_name'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('from_name')));
                $smtp['from_email'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('from_email')));
                $smtp['api_key'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('api_key')));
                $smtp['smtp_enable_status'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('smtp_enable_status')));
                $data['smtp_email_setting'] = json_encode($smtp);


                $sms_info_json = array();
                $sms_info_json['field_1_0'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('field_1_0')));
                $sms_info_json['field_1_1'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('field_1_1')));
                $sms_info_json['field_1_2'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('field_1_2')));
                $sms_info_json['field_2_0'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('field_2_0')));
                $sms_info_json['field_2_1'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('field_2_1')));
                $sms_info_json['field_2_2'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('field_2_2')));
                $sms_info_json['field_2_3'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('field_2_3')));
                $sms_info_json['field_3_0'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('field_3_0')));
                $sms_info_json['field_3_1'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('field_3_1')));
                $sms_info_json['field_3_2'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('field_3_2')));
                $sms_info_json['field_4_0'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('field_4_0')));
                $sms_info_json['field_4_1'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('field_4_1')));
                $sms_info_json['field_4_2'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('field_4_2')));
                $sms_info_json['sms_service_provider'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('sms_service_provider')));



                $seo_meta = array();
                $seo_meta['meta_author'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('meta_author')));
                $seo_meta['meta_description'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('meta_description')));
                $seo_meta['meta_keywords'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('meta_keywords')));
                $seo_meta['meta_og_type'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('meta_og_type')));
                $seo_meta['meta_og_title'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('meta_og_title')));
                $seo_meta['meta_og_site_name'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('meta_og_site_name')));

                // Base64 Image Convert Into Image
                if ($_POST['meta_img_2'] != '') {
                    $img_data = escape_output($_POST['meta_img_2']);
                    list($type, $img_data) = explode(';', $img_data);
                    list(, $img_data) = explode(',', $img_data);
                    $img_data = base64_decode($img_data);
                    $imageName = time() . '.png';
                    createDirectory('uploads/eCommerce/seo_meta');
                    $imagePath = 'uploads/eCommerce/seo_meta/' . $imageName;
                    file_put_contents($imagePath, $img_data);
                    $seo_meta['meta_img'] = htmlspecialcharscustom($imageName);
                    // if ($id) {
                    //     $ecommerce = $this->Common_model->getDataById(1, 'tbl_ecommerce');
                    //     if ($ecommerce && !empty($ecommerce->banner_img)) {
                    //         $oldImagePath = FCPATH . 'uploads/eCommerce/banners/' . $ecommerce->banner_img;
                    //         if (file_exists($oldImagePath)) {
                    //             unlink($oldImagePath); // Delete the old image correctly
                    //         }
                    //     }
                    // }
                } else {
                    $seo_meta['meta_img'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('meta_img_p')));
                }
                $data['seo_meta_contetn'] = json_encode($seo_meta);


                $promotional_content = array();
                $promotional_content['promotional_notice_status'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('promotional_notice_status')));
                // Base64 Image Convert Into Image
                if ($_POST['promotional_notice_image_2'] != '') {
                    $img_data2 = escape_output($_POST['promotional_notice_image_2']);
                    list($type, $img_data2) = explode(';', $img_data2);
                    list(, $img_data2) = explode(',', $img_data2);
                    $img_data2 = base64_decode($img_data2);
                    $imageName = time() . '.png';
                    createDirectory('uploads/eCommerce/promotional_content');
                    $imagePath = 'uploads/eCommerce/promotional_content/' . $imageName;
                    file_put_contents($imagePath, $img_data2);
                    $promotional_content['promotional_notice_image'] = htmlspecialcharscustom($imageName);
                    // if ($id) {
                    //     $ecommerce = $this->Common_model->getDataById(1, 'tbl_ecommerce');
                    //     if ($ecommerce && !empty($ecommerce->banner_img)) {
                    //         $oldImagePath = FCPATH . 'uploads/eCommerce/banners/' . $ecommerce->banner_img;
                    //         if (file_exists($oldImagePath)) {
                    //             unlink($oldImagePath); // Delete the old image correctly
                    //         }
                    //     }
                    // }
                } else {
                    $promotional_content['promotional_notice_image'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('promotional_notice_image_p')));
                }
                $data['promotional_content'] = json_encode($promotional_content);

                // Preloader Gif
                $preloader = array();
                $preloader['preloader_status'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('preloader_status')));
                if ($_FILES['preloader_image']['name'] != "") {
                    $preloader['preloader_image'] = $this->session->userdata('preloader_image');
                    $this->session->unset_userdata('preloader_image');
                }else{
                    $preloader['preloader_image'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('preloader_image_p')));
                }
                $data['preloader_content'] = json_encode($preloader);

                // Closable Notice
                $notice = array();
                $notice['closable_notice_status'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('closable_notice_status')));
                $notice['closable_notice_text'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('closable_notice_text')));
                $data['closable_notice'] = json_encode($notice);


                // Homepage Content Show Hide
                // Register Information
                $homepage_content_show_hide = array();
                $homepage_content_show_hide['top_category'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('top_category')));
                $homepage_content_show_hide['flash_sale'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('flash_sale')));
                $homepage_content_show_hide['best_selling'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('best_selling')));
                $homepage_content_show_hide['offer_product'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('offer_product')));
                $homepage_content_show_hide['latest_best_top'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('latest_best_top')));
                $homepage_content_show_hide['ratting'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('ratting')));
                $homepage_content_show_hide['product_search_display_option'] =htmlspecialcharscustom($this->input->post($this->security->xss_clean('product_search_display_option')));
                $data['homepage_content_show_hide'] = json_encode($homepage_content_show_hide);


                // Payment Getway Setting
                $payment_api = array();
                $payment_api['action_type_stripe'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('action_type_stripe')));   
                $payment_api['stripe_api_key'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('stripe_api_key')));
                $payment_api['stripe_publishable_key'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('stripe_publishable_key')));

                $payment_api['action_type_paypal'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('action_type_paypal'))); 
                $payment_api['paypal_user_name'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('paypal_user_name')));
                $payment_api['paypal_password'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('paypal_password')));
                $payment_api['paypal_signature'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('paypal_signature')));
                $data['payment_getway_setting'] = json_encode($payment_api); 

                // Footer Description
                $data['footer_description'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('footer_description')));   


                if ($id == "") {
                    $this->Common_model->insertInformation($data, "tbl_ecommerce");
                    $this->session->set_flashdata('exception', lang('Information_added_successfully'));
                } else {
                    $this->Common_model->updateInformation($data, $id, "tbl_ecommerce");
                    $this->session->set_flashdata('exception', lang('Information_updated_successfully'));
                }
                redirect('ECommerce_setting/eCommerceSetting');
            } else {
                $data = array();
                $data['ecommerce'] = $this->Common_model->getDataById($id, 'tbl_ecommerce');
                $data['main_content'] = $this->load->view('eCommerce/settings/eCommerce_setting', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        } else {
            $data = array();
            $data['ecommerce'] = $this->Common_model->getDataById($id, 'tbl_ecommerce');
            $data['main_content'] = $this->load->view('eCommerce/settings/eCommerce_setting', $data, TRUE);
            $this->load->view('userHome', $data);
        } 
    } 


    /**
     * validate_preloader_image
     * @access public
     * @param no
     * @return void
     */
    public function validate_preloader_image() {
        if ($_FILES['preloader_image']['name'] != "") {
            // Fix typo in upload path
            $config['upload_path'] = './uploads/eCommerce/preloader_image';
            $config['allowed_types'] = 'jpg|jpeg|png|ico|gif';
            $config['max_size'] = '1000';
            $config['encrypt_name'] = TRUE;
            $config['detect_mime'] = TRUE;
            $this->load->library('upload', $config);

            if(createDirectory('uploads/eCommerce/preloader_image')){
                // Delete the old file if it exists
                $old_file = $this->session->userdata('preloader_image');
                if ($old_file && file_exists($config['upload_path'] . '/' . $old_file)) {
                    unlink($config['upload_path'] . '/' . $old_file);
                }

                if ($this->upload->do_upload("preloader_image")) {
                    $upload_info = $this->upload->data();
                    $file_name = $upload_info['file_name'];
                    $config['image_library'] = 'gd2';
                    // Fix path to match upload_path
                    $config['source_image'] = './uploads/eCommerce/preloader_image/' . $file_name;
                    $config['maintain_ratio'] = false;
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();
                    $this->session->set_userdata('preloader_image', $file_name);
                } else {
                    $this->form_validation->set_message('validate_preloader_image', $this->upload->display_errors());
                    return FALSE; // Return FALSE on upload failure
                }
            } else {
                $this->form_validation->set_message('validate_preloader_image', 'Failed to create upload directory');
                return FALSE;
            }
        }
        return TRUE; // Return TRUE if validation passes
    }


    /**
     * addEditFlashSale
     * @access public
     * @param int
     * @return void
     */

    public function addEditFlashSale($encrypted_id = ''){
        $company_id = $this->session->userdata('company_id');
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('flash_sale_title', lang('flash_sale_title'), 'required|max_length[100]');
            $this->form_validation->set_rules('start_date', lang('start_date'), 'required|max_length[25]');
            $this->form_validation->set_rules('end_date', lang('end_date'), 'required|max_length[25]');
            $this->form_validation->set_rules('status', lang('status'), 'required|max_length[10]');
            if ($this->form_validation->run() == TRUE) {
                $data = array();
                $data['flash_sale_title'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('flash_sale_title')));
                $data['start_date'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('start_date')));
                $data['end_date'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('end_date')));
                $data['status'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('status')));
                $data['user_id'] = $this->session->userdata('user_id');
                $data['company_id'] = $this->session->userdata('company_id');
                if ($id == "") {
                    $data['added_date'] = date('Y-m-d H:i:s');
                    $this->Common_model->insertInformation($data, "tbl_flash_sales");
                    $this->session->set_flashdata('exception', lang('Information_added_successfully'));
                } else {
                    $this->Common_model->updateInformation($data, $id, "tbl_flash_sales");
                    $this->session->set_flashdata('exception', lang('Information_updated_successfully'));
                }
                redirect('ECommerce_setting/listFlashSale');
            } else {
                if ($id == "") {
                    $data = array();
                    $data['main_content'] = $this->load->view('eCommerce/settings/addEditFlashSale', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['flash_sale'] = $this->Common_model->getDataById($id, 'tbl_flash_sales');
                    $data['main_content'] = $this->load->view('eCommerce/settings/addEditFlashSale', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['main_content'] = $this->load->view('eCommerce/settings/addEditFlashSale', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['flash_sale'] = $this->Common_model->getDataById($id, 'tbl_flash_sales');
                $data['main_content'] = $this->load->view('eCommerce/settings/addEditFlashSale', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        } 
    } 
    /**
     * deleteFlashSale
     * @access public
     * @param int
     * @return void
     */

    public function deleteFlashSale($id){
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->Common_model->deleteStatusChange($id, "tbl_flash_sales");
        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('ECommerce_setting/listFlashSale');
    } 
    /**
     * listFlashSale
     * @access public
     * @param int
     * @return void
     */

    public function listFlashSale(){
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['flash_sales'] = $this->Common_model->getAllByCompanyIdWithAddedBy($company_id, "tbl_flash_sales");
        $data['main_content'] = $this->load->view('eCommerce/settings/listFlashSale', $data, TRUE);
        $this->load->view('userHome', $data);
    } 
    /**
     * addEditFlashSaleItems
     * @access public
     * @param int
     * @return void
     */

    public function addEditFlashSaleItems($encrypted_id = ''){
        $company_id = $this->session->userdata('company_id');
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('flash_sale_id', lang('flash_sale_type'), 'required|max_length[100]');
            if ($this->form_validation->run() == TRUE) {
                $flash_id = htmlspecialcharscustom($this->input->post($this->security->xss_clean('flash_sale_id')));
                $flash_sale_id = $this->custom->encrypt_decrypt($flash_id, 'decrypt');
                $this->Common_model->hardDeleteByColumnName($flash_sale_id, "flash_sale_id", "tbl_flash_sale_items");
                if(isset($_POST['item_id_2']) && is_array($_POST['item_id_2'])) {
                    foreach($_POST['item_id_2'] as $i => $item_id) {
                        if($item_id) {
                            $data = array();
                            $data['flash_sale_id'] = $flash_sale_id;
                            $data['item_id'] = $item_id;
                            $data['discount_price'] = $_POST['discount_price'][$i];
                            $data['added_date'] = date('Y-m-d H:i:s');
                            $data['user_id'] = $this->session->userdata('user_id');
                            $data['company_id'] = $this->session->userdata('company_id');
                            $this->Common_model->insertInformation($data, "tbl_flash_sale_items");
                        }
                    }
                }
                $this->session->set_flashdata('exception', lang('Information_added_successfully'));
                redirect('ECommerce_setting/addEditFlashSaleItems');
            } else {
                if ($id == "") {
                    $data = array();
                    $data['items'] = $this->Common_model->getItemWithVariationForDrowdown();
                    $data['flash_sales'] = $this->Common_model->getAllByCompanyIdWithAddedBy($company_id, "tbl_flash_sales");
                    $data['main_content'] = $this->load->view('eCommerce/settings/addEditFlashSaleItems', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['items'] = $this->Common_model->getItemWithVariationForDrowdown();
                    $data['flash_sale_item'] = $this->ECommerce_model->getAllFlashSaleItemById($id);
                    $data['flash_sales'] = $this->Common_model->getAllByCompanyIdWithAddedBy($company_id, "tbl_flash_sales");
                    $data['main_content'] = $this->load->view('eCommerce/settings/addEditFlashSaleItems', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['items'] = $this->Common_model->getItemWithVariationForDrowdown();
                $data['flash_sales'] = $this->Common_model->getAllByCompanyIdWithAddedBy($company_id, "tbl_flash_sales");
                $data['main_content'] = $this->load->view('eCommerce/settings/addEditFlashSaleItems', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['items'] = $this->Common_model->getItemWithVariationForDrowdown();
                $data['flash_sale_item'] = $this->ECommerce_model->getAllFlashSaleItemById($id);
                // pre($data['flash_sale_item']);
                $data['flash_sales'] = $this->Common_model->getAllByCompanyIdWithAddedBy($company_id, "tbl_flash_sales");
                $data['main_content'] = $this->load->view('eCommerce/settings/addEditFlashSaleItems', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        } 
    } 
    // /**
    //  * deleteFlashSaleItem
    //  * @access public
    //  * @param int
    //  * @return void
    //  */

    // public function deleteFlashSaleItem($id){
    //     $id = $this->custom->encrypt_decrypt($id, 'decrypt');
    //     $this->Common_model->deleteStatusChange($id, "tbl_flash_sale_items");
    //     $this->session->set_flashdata('exception', lang('delete_success'));
    //     redirect('ECommerce_setting/listFlashSaleItem');
    // } 
    // /**
    //  * listFlashSaleItem
    //  * @access public
    //  * @param int
    //  * @return void
    //  */

    // public function listFlashSaleItem(){
    //     $company_id = $this->session->userdata('company_id');
    //     $data = array();
    //     $data['flash_sale_items'] = $this->ECommerce_model->getAllFlashSaleItems ($company_id);
    //     $data['main_content'] = $this->load->view('eCommerce/settings/listFlashSaleItem', $data, TRUE);
    //     $this->load->view('userHome', $data);
    // } 
   
    /**
     * flashSalesItems
     * @access public
     * @param int
     * @return void
     */

    public function flashSalesItems(){
        $id = '';
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('meta_og_title', lang('meta_og_title'), 'max_length[100]');
            if ($this->form_validation->run() == TRUE) {
                $data = array();
                $seo_meta['meta_og_site_name'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('meta_og_site_name')));
                if ($id == "") {
                    $this->Common_model->insertInformation($data, "tbl_ecommerce");
                    $this->session->set_flashdata('exception', lang('Information_added_successfully'));
                } else {
                    $this->Common_model->updateInformation($data, $id, "tbl_ecommerce");
                    $this->session->set_flashdata('exception', lang('Information_updated_successfully'));
                }
                redirect('ECommerce_setting/eCommerceSetting');
            } else {
                $data = array();
                $data['ecommerce'] = $this->Common_model->getDataById($id, 'tbl_ecommerce');
                $data['main_content'] = $this->load->view('eCommerce/settings/eCommerce_setting', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        } else {
            $data = array();
            $data['items'] = '';
            $data['main_content'] = $this->load->view('eCommerce/settings/flash_items', $data, TRUE);
            $this->load->view('userHome', $data);
        } 
    } 



    /**
     * addEditArea
     * @access public
     * @param int
     * @return void
     */
    public function addEditArea($encrypted_id = ''){
        $company_id = $this->session->userdata('company_id');
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('area_name', lang('area_name'), 'required|max_length[50]');
            $this->form_validation->set_rules('delivary_charge', lang('delivary_charge'), 'required|max_length[11]');
            if ($this->form_validation->run() == TRUE) {
                $add_more = $this->input->post($this->security->xss_clean('add_more'));
                $data = array();
                $data['area_name'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('area_name')));
                $data['delivary_charge'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('delivary_charge')));
                $data['user_id'] = $this->session->userdata('user_id');
                $data['company_id'] = $this->session->userdata('company_id');
                if ($id == "") {
                    $data['added_date'] = date('Y-m-d H:i:s');
                    $this->Common_model->insertInformation($data, "tbl_areas");
                    $this->session->set_flashdata('exception',lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($data, $id, "tbl_areas");
                    $this->session->set_flashdata('exception', lang('update_success'));
                }
                if($add_more == 'add_more'){
                    redirect('ECommerce_setting/addEditArea');
                }else{
                    redirect('ECommerce_setting/listArea');
                }
            } else {
                if ($id == "") {
                    $data = array();
                    $data['main_content'] = $this->load->view('eCommerce/area/addEditArea', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['areas'] = $this->Common_model->getDataById($id, "tbl_areas");
                    $data['main_content'] = $this->load->view('eCommerce/area/addEditArea', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['main_content'] = $this->load->view('eCommerce/area/addEditArea', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['areas'] = $this->Common_model->getDataById($id, "tbl_areas");
                $data['main_content'] = $this->load->view('eCommerce/area/addEditArea', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }

    /**
     * deleteArea
     * @access public
     * @param int
     * @return void
     */
    public function deleteArea($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->Common_model->deleteStatusChange($id, "tbl_areas");
        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('ECommerce_setting/listArea');
    }

    /**
     * listArea
     * @access public
     * @param int
     * @return void
     */
    public function listArea($encrypt_id = ''){
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['list_areas'] = $this->Common_model->getAllByCompanyIdWithAddedBy($company_id, "tbl_areas");
        $data['main_content'] = $this->load->view('eCommerce/area/list_area', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    /**
     * addEditBanner
     * @access public
     * @param int
     * @return void
     */
    public function addEditBanner($encrypted_id = ''){
        $company_id = $this->session->userdata('company_id');
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('banner_heading', lang('banner_heading'), 'max_length[250]');
            $this->form_validation->set_rules('banner_title', lang('banner_title'), 'max_length[250]');
            $this->form_validation->set_rules('button_text', lang('button_text'), 'max_length[25]');
            $this->form_validation->set_rules('button_link', lang('button_link'), 'max_length[250]');
            $this->form_validation->set_rules('status', lang('status'), 'required|max_length[10]');
            if ($this->form_validation->run() == TRUE) {
                $add_more = $this->input->post($this->security->xss_clean('add_more'));
                $data = array();
                $data['banner_heading'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('banner_heading')));
                $data['banner_title'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('banner_title')));
                $data['button_text'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('button_text')));
                $data['button_link'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('button_link')));
                $data['status'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('status')));

                // Base64 Image Convert Into Image
                if ($_POST['banner_img_2'] != '') {
                    $img_data = escape_output($_POST['banner_img_2']);
                    list($type, $img_data) = explode(';', $img_data);
                    list(, $img_data) = explode(',', $img_data);
                    $img_data = base64_decode($img_data);
                    $imageName = time() . '.png';
                    createDirectory('uploads/eCommerce/banners');
                    $imagePath = 'uploads/eCommerce/banners/' . $imageName;
                    file_put_contents($imagePath, $img_data);
                    $data['banner_img'] = htmlspecialcharscustom($imageName);
                    if ($id) {
                        $old_banner = $this->Common_model->getDataById($id, 'tbl_banners');
                        if ($old_banner && !empty($old_banner->banner_img)) {
                            $oldImagePath = FCPATH . 'uploads/eCommerce/banners/' . $old_banner->banner_img;
                            if (file_exists($oldImagePath)) {
                                unlink($oldImagePath); // Delete the old image correctly
                            }
                        }
                    }
                } else {
                    $data['banner_img'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('banner_img_p')));
                }
                $data['user_id'] = $this->session->userdata('user_id');
                $data['company_id'] = $this->session->userdata('company_id');
                if ($id == "") {
                    $data['added_date'] = date('Y-m-d H:i:s');
                    $this->Common_model->insertInformation($data, "tbl_banners");
                    $this->session->set_flashdata('exception',lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($data, $id, "tbl_banners");
                    $this->session->set_flashdata('exception', lang('update_success'));
                }
                if($add_more == 'add_more'){
                    redirect('ECommerce_setting/addEditBanner');
                }else{
                    redirect('ECommerce_setting/listBanner');
                }
            } else {
                if ($id == "") {
                    $data = array();
                    $data['main_content'] = $this->load->view('eCommerce/hero-banner/addEditBanner', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['banners'] = $this->Common_model->getDataById($id, "tbl_banners");
                    $data['main_content'] = $this->load->view('eCommerce/hero-banner/addEditBanner', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['main_content'] = $this->load->view('eCommerce/hero-banner/addEditBanner', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['banners'] = $this->Common_model->getDataById($id, "tbl_banners");
                $data['main_content'] = $this->load->view('eCommerce/hero-banner/addEditBanner', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }

    /**
     * deleteBanner
     * @access public
     * @param int
     * @return void
     */
    public function deleteBanner($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $old_banner = $this->Common_model->getDataById($id, 'tbl_banners');
        if ($old_banner && !empty($old_banner->banner_img)) {
            $oldImagePath = FCPATH . 'uploads/eCommerce/banners/' . $old_banner->banner_img;
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath); // Delete the old image correctly
            }
        }
        $this->Common_model->deleteStatusChange($id, "tbl_banners");
        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('ECommerce_setting/listBanner');
    }

    /**
     * listBanner
     * @access public
     * @param int
     * @return void
     */
    public function listBanner(){
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['list_banners'] = $this->Common_model->getAllByCompanyIdWithAddedBy($company_id, "tbl_banners");
        $data['main_content'] = $this->load->view('eCommerce/hero-banner/list_banner', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    /**
     * sortBanner
     * @access public
     * @param no
     * @return void
     */
    public function sortBanner() {
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['banners'] = $this->ECommerce_model->getBannerBySorted($company_id, 'tbl_banners');
        $data['main_content'] = $this->load->view('eCommerce/hero-banner/sort_banner', $data, TRUE);
        $this->load->view('userHome', $data);
    }

     /**
     * sortBannerUpdate
     * @access public
     * @param no
     * @return void
     */
    public function sortBannerUpdate() {
        $data = array();
        if($this->input->post($this->security->xss_clean('ids'))){
            $arr = explode(',',$this->input->post('ids'));
            foreach($arr as $sortOrder => $id){
                $category = $this->db->query("SELECT id, sort_id FROM tbl_banners where id=$id")->row();
                $data['sort_id'] = $sortOrder+1;
                $this->Common_model->updateInformation($data, $id, 'tbl_banners');
            }
            $response = [
                'success'=>true,'message'=>'Banner Successfully Sorted'
            ];
            $this->output->set_content_type('application/json')->set_output(json_encode($response));
        }
    }

    /**
     * addEditFaq
     * @access public
     * @param int
     * @return void
     */
    public function addEditFaq($encrypted_id = ''){
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('title', lang('title'), 'max_length[250]');
            $this->form_validation->set_rules('description', lang('description'), 'max_length[500]');
            if ($this->form_validation->run() == TRUE) {
                $add_more = $this->input->post($this->security->xss_clean('add_more'));
                $data = array();
                $data['title'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('title')));
                $data['description'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('description')));
                $data['status'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('status')));
                $data['user_id'] = $this->session->userdata('user_id');
                $data['company_id'] = $this->session->userdata('company_id');
                if ($id == "") {
                    $data['added_date'] = date('Y-m-d H:i:s');
                    $this->Common_model->insertInformation($data, "tbl_faqs");
                    $this->session->set_flashdata('exception',lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($data, $id, "tbl_faqs");
                    $this->session->set_flashdata('exception', lang('update_success'));
                }
                if($add_more == 'add_more'){
                    redirect('ECommerce_setting/addEditFaq');
                }else{
                    redirect('ECommerce_setting/listFaq');
                }
            } else {
                if ($id == "") {
                    $data = array();
                    $data['main_content'] = $this->load->view('eCommerce/faq/addEditFaq', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['faq'] = $this->Common_model->getDataById($id, "tbl_faqs");
                    $data['main_content'] = $this->load->view('eCommerce/faq/addEditFaq', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['main_content'] = $this->load->view('eCommerce/faq/addEditFaq', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['faq'] = $this->Common_model->getDataById($id, "tbl_faqs");
                $data['main_content'] = $this->load->view('eCommerce/faq/addEditFaq', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }

    /**
     * deleteFaq
     * @access public
     * @param int
     * @return void
     */
    public function deleteFaq($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->Common_model->deleteStatusChange($id, "tbl_banners");
        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('ECommerce_setting/listFaq');
    }

    /**
     * listFaq
     * @access public
     * @param int
     * @return void
     */
    public function listFaq(){
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['list_faqs'] = $this->Common_model->getAllByCompanyIdWithAddedBy($company_id, "tbl_faqs");
        $data['main_content'] = $this->load->view('eCommerce/faq/list_faq', $data, TRUE);
        $this->load->view('userHome', $data);
    }


    /**
     * addEditServiceTime
     * @access public
     * @param int
     * @return void
     */
    public function addEditServiceTime($encrypted_id = ''){
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('title', lang('title'), 'max_length[250]');
            $this->form_validation->set_rules('description', lang('description'), 'max_length[250]');
            $this->form_validation->set_rules('status', lang('status'), 'max_length[25]');
            $this->form_validation->set_rules('service_image', lang('service_image'), 'callback_validate_service_image|max_length[500]');
            if ($this->form_validation->run() == TRUE) {
                $add_more = $this->input->post($this->security->xss_clean('add_more'));
                $data = array();
                $data['title'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('title')));
                $data['description'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('description')));
                $data['status'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('status')));
                if ($_FILES['service_image']['name'] != "") {
                    $data['service_image'] = $this->session->userdata('service_image');
                    $this->session->unset_userdata('service_image');
                }else{
                    $data['service_image'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('service_image_p')));
                }  
                $data['user_id'] = $this->session->userdata('user_id');
                $data['company_id'] = $this->session->userdata('company_id');
                if ($id == "") {
                    $data['added_date'] = date('Y-m-d H:i:s');
                    $this->Common_model->insertInformation($data, "tbl_service_times");
                    $this->session->set_flashdata('exception',lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($data, $id, "tbl_service_times");
                    $this->session->set_flashdata('exception', lang('update_success'));
                }
                if($add_more == 'add_more'){
                    redirect('ECommerce_setting/addEditServiceTime');
                }else{
                    redirect('ECommerce_setting/listServiceTime');
                }
            } else {
                if ($id == "") {
                    $data = array();
                    $data['main_content'] = $this->load->view('eCommerce/service_times/addEditServiceTime', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['service_time'] = $this->Common_model->getDataById($id, "tbl_service_times");
                    $data['main_content'] = $this->load->view('eCommerce/service_times/addEditServiceTime', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['main_content'] = $this->load->view('eCommerce/service_times/addEditServiceTime', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['service_time'] = $this->Common_model->getDataById($id, "tbl_service_times");
                $data['main_content'] = $this->load->view('eCommerce/service_times/addEditServiceTime', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }

    public function validate_service_image() {
        if ($_FILES['service_image']['name'] != "") {
            $config['upload_path'] = './uploads/eCommerce/service_image';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = '1000';
            $config['encrypt_name'] = TRUE;
            $config['detect_mime'] = TRUE;
            $this->load->library('upload', $config);
            if(createDirectory('uploads/eCommerce/service_image')){
                // Delete the old file if it exists
                $old_file = $this->session->userdata('service_image');
                if ($old_file && file_exists($config['upload_path'] . '/' . $old_file)) {
                    unlink($config['upload_path'] . '/' . $old_file);
                }
                if ($this->upload->do_upload("service_image")) {
                    $upload_info = $this->upload->data();
                    $file_name = $upload_info['file_name'];
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = './uploads/eCommerce/service_image/' . $file_name;
                    $config['maintain_ratio'] = false;
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();
                    $this->session->set_userdata('service_image', $file_name);
                } else {
                    $this->form_validation->set_message('validate_service_image', $this->upload->display_errors());
                    return TRUE;
                }
            } else {
                echo "Something went wrong";
            }
        }
    }      


    /**
     * deleteServiceTime
     * @access public
     * @param int
     * @return void
     */
    public function deleteServiceTime($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $old_banner = $this->Common_model->getDataById($id, 'tbl_service_times');
        if ($old_banner && !empty($old_banner->banner_img)) {
            $oldImagePath = FCPATH . 'uploads/eCommerce/banners/' . $old_banner->banner_img;
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath); // Delete the old image correctly
            }
        }
        $this->Common_model->deleteStatusChange($id, "tbl_service_times");
        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('ECommerce_setting/listBanner');
    }

    /**
     * listServiceTime
     * @access public
     * @param int
     * @return void
     */
    public function listServiceTime(){
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['list_service_times'] = $this->Common_model->getAllByCompanyIdWithAddedBy($company_id, "tbl_service_times");
        $data['main_content'] = $this->load->view('eCommerce/service_times/list_service_times', $data, TRUE);
        $this->load->view('userHome', $data);
    }




    /**
     * addEditItemImage
     * @access public
     * @param int
     * @return void
     */
    public function addEditItemImage($encrypted_id = ''){
        $company_id = $this->session->userdata('company_id');
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('item_id', lang('item'), 'required|max_length[11]');
            $this->form_validation->set_rules('status', lang('status'), 'required|max_length[55]');
            if ($this->form_validation->run() == TRUE) {
                $add_more = $this->input->post($this->security->xss_clean('add_more'));
                $data = array();
                $data['item_id'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('item_id')));
                $data['status'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('status')));
                // Base64 Image Convert Into Image
                if ($_POST['banner_img_2'] != '') {
                    $img_data = escape_output($_POST['banner_img_2']);
                    list($type, $img_data) = explode(';', $img_data);
                    list(, $img_data) = explode(',', $img_data);
                    $img_data = base64_decode($img_data);
                    $imageName = time() . '.png';
                    createDirectory('uploads/eCommerce/item_images');
                    $imagePath = 'uploads/eCommerce/item_images/' . $imageName;
                    file_put_contents($imagePath, $img_data);
                    $data['image'] = htmlspecialcharscustom($imageName);
                    if ($id) {
                        $old_image = $this->Common_model->getDataById($id, 'tbl_item_images');
                        if ($old_image && !empty($old_image->image)) {
                            $oldImagePath = FCPATH . 'uploads/eCommerce/item_images/' . $old_image->image;
                            if (file_exists($oldImagePath)) {
                                unlink($oldImagePath); // Delete the old image correctly
                            }
                        }
                    }
                } else {
                    $data['image'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('banner_img_p')));
                }
                $data['user_id'] = $this->session->userdata('user_id');
                $data['company_id'] = $this->session->userdata('company_id');
                if ($id == "") {
                    $data['added_date'] = date('Y-m-d H:i:s');
                    $this->Common_model->insertInformation($data, "tbl_item_images");
                    $this->session->set_flashdata('exception',lang('insertion_success'));
                } else {
                    $this->Common_model->updateInformation($data, $id, "tbl_item_images");
                    $this->session->set_flashdata('exception', lang('update_success'));
                }
                if($add_more == 'add_more'){
                    redirect('ECommerce_setting/addEditItemImage');
                }else{
                    redirect('ECommerce_setting/listItemImage');
                }
            } else {
                if ($id == "") {
                    $data = array();
                    $data['items'] = $this->ECommerce_model->getAllItemsWithOutParentVariation();
                    $data['main_content'] = $this->load->view('eCommerce/item_image_upload/addEditItemImage', $data, TRUE);
                    $this->load->view('userHome', $data);
                } else {
                    $data = array();
                    $data['encrypted_id'] = $encrypted_id;
                    $data['items'] = $this->ECommerce_model->getAllItemsWithOutParentVariation();
                    $data['item_image'] = $this->Common_model->getDataById($id, "tbl_item_images");
                    $data['main_content'] = $this->load->view('eCommerce/item_image_upload/addEditItemImage', $data, TRUE);
                    $this->load->view('userHome', $data);
                }
            }
        } else {
            if ($id == "") {
                $data = array();
                $data['items'] = $this->ECommerce_model->getAllItemsWithOutParentVariation();
                $data['main_content'] = $this->load->view('eCommerce/item_image_upload/addEditItemImage', $data, TRUE);
                $this->load->view('userHome', $data);
            } else {
                $data = array();
                $data['encrypted_id'] = $encrypted_id;
                $data['items'] = $this->ECommerce_model->getAllItemsWithOutParentVariation();
                $data['item_image'] = $this->Common_model->getDataById($id, "tbl_item_images");
                $data['main_content'] = $this->load->view('eCommerce/item_image_upload/addEditItemImage', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        }
    }

    /**
     * deleteItemImage
     * @access public
     * @param int
     * @return void
     */
    public function deleteItemImage($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $old_banner = $this->Common_model->getDataById($id, 'tbl_item_images');
        if ($old_banner && !empty($old_banner->banner_img)) {
            $oldImagePath = FCPATH . 'uploads/eCommerce/item_images/' . $old_banner->banner_img;
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath); // Delete the old image correctly
            }
        }
        $this->Common_model->deleteStatusChange($id, "tbl_item_images");
        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('ECommerce_setting/listBanner');
    }

    /**
     * listItemImage
     * @access public
     * @param int
     * @return void
     */
    public function listItemImage(){
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['list_item_images'] = $this->ECommerce_model->getAllListItemImages($company_id);
        $data['main_content'] = $this->load->view('eCommerce/item_image_upload/list_item_images', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    /**
     * frontendContact
     * @access public
     * @param int
     * @return void
     */
    public function frontendContact($encrypted_id = ''){
        $ecommerce_setting = 1;
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('title', lang('title'), 'required|max_length[50]');
            $this->form_validation->set_rules('description', lang('description'), 'required|max_length[250]');
            $this->form_validation->set_rules('location_name', lang('location_name'), 'required|max_length[100]');
            $this->form_validation->set_rules('contact_number', lang('contact_number'), 'required|max_length[75]');
            $this->form_validation->set_rules('email_address', lang('email_address'), 'required|max_length[75]');
            $this->form_validation->set_rules('location', lang('location'), 'required');
            if ($this->form_validation->run() == TRUE) {
                $contact_data = array();
                $return = array();
                $contact_data['title'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('title')));
                $contact_data['description'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('description')));
                $contact_data['location_name'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('location_name')));
                $contact_data['contact_number'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('contact_number')));
                $contact_data['email_address'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('email_address')));
                $contact_data['location'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('location')));
                $return['contact_information']  = json_encode($contact_data);
                $this->Common_model->updateInformation($return, $ecommerce_setting, "tbl_ecommerce");
                $this->session->set_flashdata('exception', lang('update_success'));
                redirect('ECommerce_setting/frontendContact');
            } else {
                $data = array();
                $contact_info = $this->Common_model->getDataById($ecommerce_setting, "tbl_ecommerce");
                $data['contact_data'] = json_decode(isset($contact_info->contact_information) && $contact_info->contact_information ? $contact_info->contact_information : '');
                $data['main_content'] = $this->load->view('eCommerce/contact/addEditFrontendContact', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        } else {
            $data = array();
            $contact_info = $this->Common_model->getDataById($ecommerce_setting, "tbl_ecommerce");
            $data['contact_data'] = json_decode(isset($contact_info->contact_information) && $contact_info->contact_information ? $contact_info->contact_information : '');
            $data['main_content'] = $this->load->view('eCommerce/contact/addEditFrontendContact', $data, TRUE);
            $this->load->view('userHome', $data);
        }
    }

    /**
     * contactList
     * @access public
     * @param no
     * @return void
     */
    public function contactList() {
        $company_id = $this->session->userdata('company_id');
        $data = array();
        $data['contacts'] = $this->ECommerce_model->getAllData($company_id, "tbl_contacts");
        $data['main_content'] = $this->load->view('eCommerce/contact/contact_list', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    /**
     * deleteContact
     * @access public
     * @param int
     * @return void
     */
    public function deleteContact($id) {
        $id = $this->custom->encrypt_decrypt($id, 'decrypt');
        $this->Common_model->deleteStatusChange($id, "tbl_contacts");
        $this->session->set_flashdata('exception', lang('delete_success'));
        redirect('ECommerce_setting/contactList');
    }



     /**
     * frontendWhiteLabel
     * @access public
     * @param int
     * @return void
     */
    public function frontendWhiteLabel($id = '') {
        $ecommerce_setting = 1;
        if (htmlspecialcharscustom($this->input->post('submit'))) {
            $this->form_validation->set_rules('site_name', lang('site_name'), 'required|max_length[50]');
            $this->form_validation->set_rules('site_footer', lang('site_footer'), 'required|max_length[250]');
            $this->form_validation->set_rules('site_title', lang('site_title'), 'required|max_length[50]');
            $this->form_validation->set_rules('site_link', lang('site_link'), 'required|max_length[50]');
            $this->form_validation->set_rules('site_logo', lang('site_logo'), 'callback_validate_site_logo|max_length[500]');
            $this->form_validation->set_rules('site_favicon', lang('site_favicon'), 'callback_validate_site_favicon|max_length[500]');
            if ($this->form_validation->run() == TRUE) {
                $data_whielabel = array();
                $data_whielabel['site_name'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('site_name')));
                $data_whielabel['site_footer'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('site_footer')));
                $data_whielabel['site_title'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('site_title')));
                $data_whielabel['site_link'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('site_link')));
                if ($_FILES['site_logo']['name'] != "") {
                    $data_whielabel['site_logo'] = $this->session->userdata('site_logo');
                    $this->session->unset_userdata('site_logo');
                }else{
                    $data_whielabel['site_logo'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('site_logo_p')));
                }
                if ($_FILES['site_favicon']['name'] != "") {
                    $data_whielabel['site_favicon'] = $this->session->userdata('site_favicon');
                    $this->session->unset_userdata('site_favicon');
                }else{
                    $data_whielabel['site_favicon'] = htmlspecialcharscustom($this->input->post($this->security->xss_clean('site_favicon_p')));
                }
                $return['website_whitelabel']  = json_encode($data_whielabel);
                $this->Common_model->updateInformation($return, $ecommerce_setting, "tbl_ecommerce");
                $this->session->set_flashdata('exception', lang('update_success'));
                $this->session->set_userdata($data_whielabel);
                redirect('ECommerce_setting/frontendWhiteLabel');
            } else {
                $data = array();
                $data['outlet_information'] = $this->Common_model->getDataById($ecommerce_setting, "tbl_ecommerce");
                $data['main_content'] = $this->load->view('eCommerce/whitelabel/frontend_whitelabel', $data, TRUE);
                $this->load->view('userHome', $data);
            }
        } else {
            $data = array();
            $data['outlet_information'] = $this->Common_model->getDataById($ecommerce_setting, "tbl_ecommerce");
            $data['main_content'] = $this->load->view('eCommerce/whitelabel/frontend_whitelabel', $data, TRUE);
            $this->load->view('userHome', $data);
        }
    }

    /**
     * validate_site_logo
     * @access public
     * @param no
     * @return void
     */
    public function validate_site_logo() {
        if ($_FILES['site_logo']['name'] != "") {
            $config['upload_path'] = './uploads/site_settings';
            $config['allowed_types'] = 'jpg|jpeg|png|ico';
            $config['max_size'] = '1000';
            $config['encrypt_name'] = TRUE;
            $config['detect_mime'] = TRUE;
            $this->load->library('upload', $config);


            if(createDirectory('uploads/site_settings')){
                // Delete the old file if it exists
                $old_file = $this->session->userdata('site_logo');
                if ($old_file && file_exists($config['upload_path'] . '/' . $old_file)) {
                    unlink($config['upload_path'] . '/' . $old_file);
                }

                if ($this->upload->do_upload("site_logo")) {
                    $upload_info = $this->upload->data();
                    $file_name = $upload_info['file_name'];
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = './uploads/site_settings/' . $file_name;
                    $config['maintain_ratio'] = false;
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();
                    $this->session->set_userdata('site_logo', $file_name);
                } else {
                    $this->form_validation->set_message('validate_site_logo', $this->upload->display_errors());
                    return TRUE;
                }
            } else {
                echo "Something went wrong";
            }
        }
    }
    

    /**
     * validate_site_favicon
     * @access public
     * @param no
     * @return void
     */
    public function validate_site_favicon() {
        if ($_FILES['site_favicon']['name'] != "") {
            $config['upload_path'] = './uploads/site_settings';
            $config['allowed_types'] = 'jpg|jpeg|png|ico';
            $config['max_size'] = '1000';
            $config['max_width'] = 16;
            $config['max_height'] = 16;
            $config['encrypt_name'] = TRUE;
            $config['detect_mime'] = TRUE;
            $this->load->library('upload', $config);

            if(createDirectory('uploads/site_settings')){
                // Delete the old file if it exists
                $old_file = $this->session->userdata('site_favicon');
                if ($old_file && file_exists($config['upload_path'] . '/' . $old_file)) {
                    unlink($config['upload_path'] . '/' . $old_file);
                }

                if ($this->upload->do_upload("site_favicon")) {
                    $upload_info = $this->upload->data();
                    $file_name = $upload_info['file_name'];
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = './uploads/site_settings/' . $file_name;
                    $config['maintain_ratio'] = false;
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();
                    $this->session->set_userdata('site_favicon', $file_name);
                } else {
                    $this->form_validation->set_message('validate_site_favicon', $this->upload->display_errors());
                    return TRUE;
                }
            } else {
                echo "Something went wrong";
            }
        }
    }

}
