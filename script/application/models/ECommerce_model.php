<?php
/*
  ###########################################################
  # PRODUCT NAME:   OFF POS
  ###########################################################
  # AUTHER:   Doorsoft
  ###########################################################
  # EMAIL:   info@doorsoft.co
  ###########################################################
  # COPYRIGHTS:   RESERVED BY Door Soft
  ###########################################################
  # WEBSITE:   http://www.doorsoft.co
  ###########################################################
  # This is ECommerce_model Model
  ###########################################################
 */
class ECommerce_model extends CI_Model {
  /**
   * getAllActiveServiceTime
   * @access public
   * @return void
   * Added By Azhar
   */
  public function getAllActiveBanner() {
    $this->db->select("*");
    $this->db->from('tbl_banners');
    $this->db->where("status", "Enable");
    $this->db->where("del_status", "Live");
    $this->db->order_by('sort_id');
    return $this->db->get()->result();
  }
  /**
   * getOrderByOrderNumber
   * @access public
   * @return void
   * Added By Azhar
   */
  public function getOrderByOrderNumber($order_no) {
    $this->db->select("s.sale_no,s.delivery_status,s.sale_date, s.date_time, s.total_payable, c.name as customer_name, c.id as customer_id, c.shipping_address, c.billing_address, c.phone, c.email");
    $this->db->from('tbl_sales s');
    $this->db->from('tbl_customers c', 'c.id = s.customer_id', 'left');
    $this->db->where("s.sale_no", $order_no);
    $this->db->where("s.del_status", "Live");
    return $this->db->get()->row();
  }
  public function getAllActiveServiceTime() {
    $this->db->select("*");
    $this->db->from('tbl_service_times');
    $this->db->where("status", "Enable");
    $this->db->where("del_status", "Live");
    $this->db->limit(20);
    return $this->db->get()->result();
  }
  /**
   * getProduct
   * @access public
   * @return void
   * Added By Azhar
   */
  public function getProduct($id) {
    $this->db->select("i.*, ii.name as parent_name");
    $this->db->from('tbl_items i');
    $this->db->join("tbl_items ii", "i.parent_id = ii.id", "left");
    $this->db->where("i.id", $id);
    $this->db->where("i.del_status", 'Live');
    $result = $this->db->get(); 
    return $result->row();
  }
  public function getArea($id) {
    $this->db->select("*");
    $this->db->from('tbl_areas');
    $this->db->where("id", $id);
    $this->db->where("del_status", 'Live');
    $result = $this->db->get(); 
    return $result->row();
  }
  public function getAllData($company_id, $table_name) {
    $this->db->select("*");
    $this->db->from($table_name);
    $this->db->where("company_id", $company_id);
    $this->db->where("del_status", 'Live');
    $this->db->order_by("id", 'DESC');
    $result = $this->db->get(); 
    if($result != false){  
        return $result->result();
    }else{
        return false;
    }
  }

  // Check if customer purchased this product
  public function hasPurchased($customer_id, $item_id) {
    $this->db->select('s.id');
    $this->db->from('tbl_sales s');
    $this->db->join('tbl_sales_details sd', 's.id = sd.sales_id');
    $this->db->where('s.customer_id', $customer_id);
    $this->db->where('sd.food_menu_id', $item_id);
    $query = $this->db->get();
    return $query->num_rows() > 0;
  }

  public function addRating($customer_id, $item_id, $rating) {
    $data = [
      'customer_id' => $customer_id,
      'item_id' => $item_id,
      'rating' => $rating,
      'created_at' => date('Y-m-d H:i:s'),
      'del_status' => 'Live'
    ];
    $this->db->where('customer_id', $customer_id);
    $this->db->where('item_id', $item_id);
    $query = $this->db->get('tbl_product_ratings');
    if ($query->num_rows() > 0) {
      $this->db->where('customer_id', $customer_id);
      $this->db->where('item_id', $item_id);
      return $this->db->update('tbl_product_ratings', $data);
    } else {
      return $this->db->insert('tbl_product_ratings', $data);
    }
  }

  public function getProductRating($item_id) {
    $this->db->select('AVG(rating) as avg_rating, COUNT(id) as total_ratings');
    $this->db->where('item_id', $item_id);
    $this->db->where('del_status', 'Live');
    $query = $this->db->get('tbl_product_ratings');
    return $query->row();
  }
  public function getProductReviews($item_id) {
    $this->db->where('item_id', $item_id);
    $this->db->where('del_status', 'Live');
    $query = $this->db->get('tbl_product_ratings');
    return $query->result();
  }
  /**
   * getBannerBySorted
   * @access public
   * @return void
   * Added By Azhar
   */
  public function getBannerBySorted($company_id) {
    $result = $this->db->query("SELECT * 
      FROM tbl_banners 
      WHERE company_id=$company_id AND del_status = 'Live'  
      ORDER BY sort_id")->result();
    return $result;
  }

  /**
   * getAllProductsByBrandId
   * @access public
   * @return void
   * Added By Azhar
   */
  public function getAllProductsByBrandId($brand_id) {
    $this->db->select("i.id,i.name,i.code,i.type,i.alternative_name,i.generic_name,i.sale_price,i.photo,i.description,i.brand_id,b.name as brand_name, fsi.discount_price, fsi.stock_limit, AVG(pr.rating) AS avg_rating, ii.name as parent_name");
    $this->db->from('tbl_items i');
    $this->db->join("tbl_items ii", "i.parent_id = ii.id", "left");
    $this->db->join('tbl_brands b', 'b.id = i.brand_id', 'left');
    $this->db->join("tbl_product_ratings pr", "pr.item_id = i.id", "left");
    $this->db->join("tbl_flash_sale_items fsi", "fsi.item_id = i.id", "left");
    $this->db->where("i.enable_disable_status", "Enable");
    $this->db->where("i.brand_id", $brand_id);
    $this->db->where("i.type !=", '0');
    $this->db->where("i.del_status", "Live");
    $this->db->group_by('i.id');
    $this->db->order_by('i.id', 'DESC');
    return $this->db->get()->result();
  }
  /**
   * getAllProductsByCategoryId
   * @access public
   * @return void
   * Added By Azhar
   */
  public function getAllProductsByCategoryId($category_id) {
    $this->db->select("i.id,i.name,i.code,i.type,i.alternative_name,i.generic_name,i.sale_price,i.photo,i.description,i.category_id,c.name as category_name, AVG(pr.rating) AS avg_rating, fsi.discount_price, ii.name as parent_name");
    $this->db->from('tbl_items i');
    $this->db->join("tbl_items ii", "i.parent_id = ii.id", "left");
    $this->db->join('tbl_item_categories c', 'c.id = i.category_id', 'left');
    $this->db->join("tbl_product_ratings pr", "pr.item_id = i.id", "left");
    $this->db->join("tbl_flash_sale_items fsi", "fsi.item_id = i.id", "left");
    $this->db->where("i.enable_disable_status", "Enable");
    $this->db->where("i.category_id", $category_id);
    $this->db->where("i.type !=", '0');
    $this->db->where("i.del_status", "Live");
    $this->db->group_by('i.id');
    $this->db->order_by('i.id', 'DESC');
    return $this->db->get()->result();
  }
  /**
   * getAllBrands
   * @access public
   * @return void
   * Added By Azhar
   */
  public function getAllBrands() {
    $this->db->select("id,name");
    $this->db->from('tbl_brands');
    $this->db->where("del_status", "Live");
    $this->db->order_by('id', 'DESC');
    return $this->db->get()->result();
  }
  /**
   * getAllCategories
   * @access public
   * @return void
   * Added By Azhar
   */
  public function getAllCategories() {
    $this->db->select("id,name");
    $this->db->from('tbl_item_categories');
    $this->db->where("del_status", "Live");
    $this->db->order_by('id', 'DESC');
    return $this->db->get()->result();
  }
  /**
   * getAllItems
   * @access public
   * @return void
   * Added By Azhar
   */
  public function getAllItems() {
    $this->db->select("i.id,i.name,i.code,i.type, ii.name as parent_name");
    $this->db->from('tbl_items i');
    $this->db->join("tbl_items ii", "i.parent_id = ii.id", "left");
    $this->db->where("i.del_status", "Live");
    $this->db->order_by('i.id', 'DESC');
    return $this->db->get()->result();
  }
  /**
   * getAllItemsWithOutParentVariation
   * @access public
   * @return void
   * Added By Azhar
   */
  public function getAllItemsWithOutParentVariation() {
    $this->db->select("i.id,i.name,i.code,i.type, ii.name as parent_name");
    $this->db->from('tbl_items i');
    $this->db->join("tbl_items ii", "i.parent_id = ii.id", "left");
    $this->db->where("i.del_status", "Live");
    $this->db->where("i.type !=", "Variation_Product");
    $this->db->where("i.type !=", "Service_Product");
    $this->db->order_by('i.id', 'DESC');
    return $this->db->get()->result();
  }
  /**
   * getProductInformationById
   * @access public
   * @return void
   * Added By Azhar
   */
public function getProductInformationById($id) {
    $this->db->select("i.id,i.name, ii.name as parent_name,i.code,i.type,i.sale_price,i.photo,i.description,c.name as category_name,i.category_id,b.name as brand_name, AVG(pr.rating) AS avg_rating, SUM(pr.rating) sum_ratting, COUNT(pr.item_id) as rating_count, fsi.discount_price");
    $this->db->from('tbl_items i');
    $this->db->join("tbl_items ii", "i.parent_id = ii.id", "left");
    $this->db->join('tbl_item_categories c', 'c.id = i.category_id', 'left');
    $this->db->join("tbl_flash_sale_items fsi", "fsi.item_id = i.id", "left");
    $this->db->join("tbl_product_ratings pr", "pr.item_id = i.id", "left");
    $this->db->join('tbl_brands b', 'b.id = i.brand_id', 'left');
    $this->db->where("i.id", $id);
    $this->db->where("i.del_status", "Live");
    return $this->db->get()->row();
}

  /**
   * getWish
   * @access public
   * @return void
   * Added By Azhar
   */
  public function getWishlist() {
    $customer_id = $this->session->userdata('customer_id');
    $this->db->select("i.id, i.name, i.type, i.sale_price, i.photo, ii.name as parent_name");
    $this->db->from('tbl_wishlist w');
    $this->db->join('tbl_items i', 'i.id = w.product_id', 'left');
    $this->db->join("tbl_items ii", "i.parent_id = ii.id", "left");
    $this->db->where("w.customer_id", $customer_id);
    $this->db->where("w.del_status", "Live");
    $this->db->order_by('id', 'DESC');
    return $this->db->get()->result();
  }


  /**
   * getProductStockCheck
   * @access public
   * @return void
   * Added By Azhar
   */
  public function getProductStockCheck($product_id) {
    $result = $this->db->query("SELECT p.name as item_name,
    (SELECT GROUP_CONCAT(st.expiry_imei_serial SEPARATOR '||') as dd
    FROM tbl_stock_detail st
    WHERE p.id=st.item_id AND st.type=1  AND st.expiry_imei_serial!='' 
    AND st.expiry_imei_serial NOT IN (SELECT st2.expiry_imei_serial FROM tbl_stock_detail st2 
      WHERE st2.item_id=p.id AND st2.type=2 
      AND st2.expiry_imei_serial!='')) as allimei,
    (SELECT IFNULL(SUM(st3.stock_quantity),0) FROM tbl_stock_detail st3
    WHERE p.id=st3.item_id   AND st3.type=1) as stock_qty,
    (SELECT IFNULL(SUM(st4.stock_quantity),0) FROM tbl_stock_detail st4
    WHERE p.id=st4.item_id AND st4.type=2) as out_qty
    FROM tbl_items p WHERE p.id='$product_id' AND p.del_status='Live'")->row();
    if($result){
      return (float)$result->stock_qty - (float)$result->out_qty;
    }else{
      return false;
    }

    $outlet_id = $this->session->userdata('outlet_id');
    $result = $this->db->query("SELECT p.name as item_name,
    (SELECT GROUP_CONCAT(st.expiry_imei_serial SEPARATOR '||') as dd
    FROM tbl_stock_detail st
    WHERE p.id=st.item_id AND st.type=1  AND st.expiry_imei_serial!='' AND st.outlet_id='$outlet_id'
    AND st.expiry_imei_serial NOT IN (SELECT st2.expiry_imei_serial FROM tbl_stock_detail st2 
        WHERE st2.item_id=p.id AND st2.type=2 
        AND st2.expiry_imei_serial!='' AND st2.outlet_id='$outlet_id')) as allimei,
    (SELECT IFNULL(SUM(st3.stock_quantity),0) FROM tbl_stock_detail st3
    WHERE p.id=st3.item_id   AND st3.type=1 AND st3.outlet_id='$outlet_id') as stock_qty,
    (SELECT IFNULL(SUM(st4.stock_quantity),0) FROM tbl_stock_detail st4
    WHERE p.id=st4.item_id AND st4.type=2 AND st4.outlet_id='$outlet_id') as out_qty
    FROM tbl_items p WHERE p.id='$item_id' AND p.del_status='Live'")->row();

    if($result){
        return (float)$result->stock_qty - (float)$result->out_qty;
    }else{
        return false;
    }


  }
  public function getProductStockCheckByOutlet($product_id) {
    $outlet_id = $this->session->userdata('frontend_outlet_id');
    $result = $this->db->query("SELECT p.name as item_name,
    (SELECT GROUP_CONCAT(st.expiry_imei_serial SEPARATOR '||') as dd
    FROM tbl_stock_detail st
    WHERE p.id=st.item_id AND st.type=1  AND st.expiry_imei_serial!='' AND st.outlet_id='$outlet_id'
    AND st.expiry_imei_serial NOT IN (SELECT st2.expiry_imei_serial FROM tbl_stock_detail st2 
        WHERE st2.item_id=p.id AND st2.type=2 
        AND st2.expiry_imei_serial!='' AND st2.outlet_id='$outlet_id')) as allimei,
    (SELECT IFNULL(SUM(st3.stock_quantity),0) FROM tbl_stock_detail st3
    WHERE p.id=st3.item_id   AND st3.type=1 AND st3.outlet_id='$outlet_id') as stock_qty,
    (SELECT IFNULL(SUM(st4.stock_quantity),0) FROM tbl_stock_detail st4
    WHERE p.id=st4.item_id AND st4.type=2 AND st4.outlet_id='$outlet_id') as out_qty
    FROM tbl_items p WHERE p.id='$product_id' AND p.del_status='Live'")->row();

    if($result){
        return (float)$result->stock_qty - (float)$result->out_qty;
    }else{
        return false;
    }


  }

  /**
   * getAllListItemImages
   * @access public
   * @param int
   * @param string
   * @return object
   * Added By Azhar
   */
  public function getAllListItemImages($company_id) {
    $this->db->select("ii.*, u.full_name as added_by, i.name as item_name, i.code, i.type, iii.name as parent_name");
    $this->db->from('tbl_item_images ii');
    $this->db->join("tbl_items i", "i.id = ii.item_id", 'left');
    $this->db->join("tbl_items iii", "i.parent_id = iii.id", "left");
    $this->db->join("tbl_users u", "u.id = ii.user_id", 'left');
    $this->db->where("ii.company_id", $company_id);
    $this->db->where("ii.del_status", 'Live');
    $this->db->order_by("ii.id", 'DESC');
    $result = $this->db->get(); 
    if($result != false){  
        return $result->result();
    }else{
        return false;
    }
  }

  /**
   * getAllProductImages
   * @access public
   * @param int
   * @param string
   * @return object
   * Added By Azhar
   */
  public function getAllProductImages($product_id) {
    $this->db->select("ii.image");
    $this->db->from('tbl_item_images ii');
    $this->db->where("ii.item_id", $product_id);
    $this->db->where("ii.status", 'Enable');
    $this->db->where("ii.del_status", 'Live');
    $this->db->order_by("ii.id", 'DESC');
    $result = $this->db->get(); 
    if($result != false){  
        return $result->result();
    }else{
        return false;
    }
  }
  /**
   * searchProducts
   * @access public
   * @param int
   * @param string
   * @return object
   * Added By Azhar
   */
  public function searchProducts($search_value) {
    $this->db->select("i.id, i.name, i.code, i.type, i.sale_price, i.photo, i.enable_disable_status, 
                       i.del_status, c.name as category_name, b.name as brand_name, 
                       AVG(pr.rating) as avg_rating, fsi.discount_price");
    $this->db->from('tbl_items i');
    $this->db->join('tbl_brands b', 'b.id = i.brand_id', 'left');
    $this->db->join('tbl_item_categories c', 'c.id = i.category_id', 'left');
    $this->db->join('tbl_product_ratings pr', 'pr.item_id = i.id', 'left');
    $this->db->join('tbl_flash_sale_items fsi', 'fsi.item_id = i.id', 'left');
    $this->db->where("i.company_id", 1);
    $this->db->where("i.parent_id", '0');
    $this->db->where("i.del_status", "Live");
    $this->db->where("i.enable_disable_status", "Enable");
    $this->db->where("i.type !=", "0");

    if($search_value) {
      $keywords = explode(' ', trim($search_value));
      $valid_keywords = array_filter($keywords, function($keyword) {
        return strlen($keyword) >= 2;
      });

      if(!empty($valid_keywords)) {
        $this->db->group_start();
        foreach($valid_keywords as $keyword) {
          $this->db->group_start();
          $this->db->like("LOWER(i.name)", strtolower($keyword));
          $this->db->or_like("LOWER(i.code)", strtolower($keyword));
          $this->db->or_like("LOWER(i.type)", strtolower($keyword));
          $this->db->or_like("LOWER(c.name)", strtolower($keyword));
          $this->db->or_like("LOWER(b.name)", strtolower($keyword));
          $this->db->or_like("LOWER(i.description)", strtolower($keyword));
          $this->db->group_end();
        }
        $this->db->group_end();
      } else {
        // If no valid keywords, return empty result
        return array();
      }
    }

    $this->db->group_by('i.id');
    $this->db->order_by('i.id', 'DESC');
    return $this->db->get()->result();
  }

  /**
     * getCustomerLoginCheck
     * @access public
     * @param string
     * @param string
     * @return object
     */
    public function getCustomerLoginCheck($email_address, $password) {
      $this->db->select("*");
      $this->db->from("tbl_customers");
      $this->db->where("email", $email_address);
      $this->db->where("password", $password);
      $this->db->where("del_status", 'Live');
      return $this->db->get()->row();
  }
  /**
     * getCustomerEmail
     * @access public
     * @param string
     * @param string
     * @return object
     */
    public function getCustomerEmail($email_address) {
      $this->db->select("*");
      $this->db->from("tbl_customers");
      $this->db->where("email", $email_address);
      $this->db->where("del_status", 'Live');
      return $this->db->get()->row();
  }
   /**
     * updateCustomerPassword
     * @access public
     * @param string
     * @param int
     * @return void
     */
    public function updateCustomerPassword($new_password, $customer_id) {
      $this->db->set('password', $new_password);
      $this->db->where('id', $customer_id);
      $this->db->update('tbl_customers');
  }
   /**
     * updateDataById
     * @access public
     * @param string
     * @param int
     * @return void
     */
    public function updateDataById($new_password, $customer_id) {
      $this->db->set('password', $new_password);
      $this->db->where('id', $customer_id);
      $this->db->update('tbl_customers');
  }
   /**
     * passwordCheckForCustomer
     * @access public
     * @param string
     * @param int
     * @return object
     */
    public function passwordCheckForCustomer($old_password, $customer_id) {
      $row = $this->db->query("SELECT * FROM tbl_customers WHERE id= $customer_id AND `password` = '$old_password'")->row();
      return $row;
  }

  /**
     * getDataById
     * @access public
     * @param string
     * @param string
     * @return object
     */
    public function getDataById($id, $tbl) {
      $this->db->select("*");
      $this->db->from("$tbl");
      $this->db->where("id", $id);
      $this->db->where("del_status", 'Live');
      return $this->db->get()->row();
  }
  /**
     * getCustomerOrder
     * @access public
     * @param string
     * @param string
     * @return object
     */
      public function getCustomerOrder($customer_id) {
          $this->db->select("s.id, s.sale_no, s.date_time, s.delivery_status, s.total_payable");
          $this->db->from("tbl_sales s");
          $this->db->where("s.customer_id", $customer_id);
          $this->db->where("s.del_status", 'Live');
          $this->db->order_by("s.id", 'DESC');
          $sales = $this->db->get()->result();
          foreach($sales as $sale) {
            $this->db->select("sd.qty, i.photo");
            $this->db->from("tbl_sales_details sd");
            $this->db->join("tbl_items i", 'sd.food_menu_id = i.id', 'left');
            $this->db->where("sd.sales_id", $sale->id);
            $details = $this->db->get()->result();
            $total_qty = 0;
            $photos = array();
            foreach($details as $detail) {
              $total_qty += $detail->qty;
              if($detail->photo) {
                $photos[] = $detail->photo;
              }
            }   
            $sale->total_quantity = $total_qty;
            $sale->photos = $photos;
          }
          return $sales;
      }
    /**
     * getCustomerOrderDetails
     * @access public
     * @param string
     * @param string
     * @return object
     */
    public function getCustomerOrderDetails($id) {
      $this->db->select("s.sale_no, s.date_time, s.sub_total, s.vat, s.delivery_charge, s.total_payable, c.business_name");
      $this->db->from("tbl_sales s");
      $this->db->join("tbl_companies c", "c.id = s.company_id", "left");
      $this->db->where("s.id", $id);
      $this->db->where("s.del_status", 'Live');
      $sale = $this->db->get()->row();

      $this->db->select("i.name, i.type, i.photo, sd.qty, sd.menu_price_without_discount");
      $this->db->from("tbl_sales s");
      $this->db->join("tbl_sales_details sd", "s.id = sd.sales_id", "left");
      $this->db->join("tbl_items i", "i.id = sd.food_menu_id", "left");
      $this->db->where("s.id", $id);
      $this->db->where("s.del_status", 'Live');
      $sale_details = $this->db->get()->result();

      $result = [
        'sale' => $sale,
        'sale_details' => $sale_details,
      ];
      return $result;
    }
  /**
     * getAllAreas
     * @access public
     * @param string
     * @param string
     * @return object
     */
    public function getAllAreas() {
      $this->db->select("*");
      $this->db->from("tbl_areas");
      $this->db->where("company_id", 1);
      $this->db->where("del_status", 'Live');
      return $this->db->get()->result();
  }
  /**
     * getAllDelivaryPartner
     * @access public
     * @param string
     * @param string
     * @return object
     */
    public function getAllDelivaryPartner() {
      $this->db->select("*");
      $this->db->from("tbl_delivery_partners");
      $this->db->where("company_id", 1);
      $this->db->where("del_status", 'Live');
      return $this->db->get()->result();
  }
  /**
     * getAllFlashSaleItems
     * @access public
     * @param string
     * @param string
     * @return object
     */
    public function getAllFlashSaleItems($company_id) {
      $this->db->select("fsi.id, fsi.discount_price, fsi.stock_limit, fsi.status, fsi.added_date, i.name as item_name, ii.name as parent_name, i.type, fs.flash_sale_title,  u.full_name as added_by");
      $this->db->from('tbl_flash_sale_items fsi');
      $this->db->join("tbl_items i", "i.id = fsi.item_id", 'left');
      $this->db->join("tbl_items ii", "i.parent_id = ii.id", "left");
      $this->db->join("tbl_flash_sales fs", "fs.id = fsi.flash_sale_id", 'left');
      $this->db->join("tbl_users u", "u.id = fsi.user_id", 'left');
      $this->db->where("fsi.company_id", $company_id);
      $this->db->where("fsi.del_status", 'Live');
      $this->db->order_by("fsi.id", 'DESC');
      $result = $this->db->get(); 
      return $result->result();
  }

  public function getMostSoldCategories() {
    $this->db->select("c.id AS category_id, c.name AS category_name, i.name AS item_name, ii.name as parent_name, i.id AS item_id, i.photo AS item_photo, i.type, i.sale_price AS item_sale_price, SUM(s.qty) AS total_sold, c.id as category_id");
    $this->db->from("tbl_sales_details s");
    $this->db->join("tbl_items i", "s.food_menu_id = i.id", "left");
    $this->db->join("tbl_items ii", "i.parent_id = ii.id", "left");
    $this->db->join("tbl_item_categories c", "i.category_id = c.id", "left");
    $this->db->where("s.created_at >=", "DATE_SUB(NOW(), INTERVAL 7 DAY)", false);
    $this->db->where("s.del_status", "Live");
    $this->db->where("i.del_status", "Live");
    $this->db->where("c.del_status", "Live");
    // Product type wise get
    $this->db->where("i.type !=", "Variation_Product");
    $this->db->group_by("c.id");
    $this->db->order_by("total_sold", "DESC");
    $this->db->limit(20);
    $query = $this->db->get();
    return $query->result();
  }



  // Example for getTopRatedProducts method
  public function getTopRatedProducts($limit = 'All', $per_page = null, $offset = null, $category_ids = null, $brand_ids = null, $price_range = null) {
    $this->db->select("i.*, AVG(pr.rating) as avg_rating, COUNT(s.id) as total_sold");
    $this->db->from("tbl_items i");
    $this->db->join("tbl_product_ratings pr", "pr.item_id = i.id", "left");
    $this->db->join("tbl_sales_details s", "s.food_menu_id = i.id AND s.del_status = 'Live'", "left");
    if($category_ids) {
      $this->db->where_in('i.category_id', $category_ids);
    }
    if($brand_ids) {
      $this->db->where_in('i.brand_id', $brand_ids);
    }   
    if($price_range) {
      $this->db->where('i.sale_price >=', $price_range[0]);
      $this->db->where('i.sale_price <=', $price_range[1]);
    }
    $this->db->where("i.del_status", "Live");
    $this->db->where("i.enable_disable_status", "Enable");
    $this->db->where("i.type !=", "0");
    $this->db->having("avg_rating >", 0);
    $this->db->group_by("i.id");
    $this->db->order_by("avg_rating", "DESC");

    $this->db->order_by("total_sold", "DESC");
    if($limit !== 'All') {
      $this->db->limit($per_page, $offset);
    }
    return $this->db->get()->result();
  }

public function getTopRatedProductsCount($category_ids = null, $brand_ids = null, $price_range = null) {
    $this->db->select('COUNT(DISTINCT i.id) as total');
    $this->db->from('tbl_items i');
    $this->db->join('tbl_product_ratings pr', 'pr.item_id = i.id', 'left');
    if($category_ids) {
      $this->db->where_in('i.category_id', $category_ids);
    }
    if($brand_ids) {
      $this->db->where_in('i.brand_id', $brand_ids);
    }
    if($price_range) {
      $this->db->where('i.sale_price >=', $price_range[0]);
      $this->db->where('i.sale_price <=', $price_range[1]);
    }
    $this->db->where('pr.rating >', 0);
    $this->db->where("i.del_status", "Live");
    $this->db->where("i.enable_disable_status", "Enable");
    return $this->db->get()->row()->total;
  }
  
  public function getMostSoldProducts($limit = 'All', $per_page = null, $offset = null, $category_ids = null, $brand_ids = null, $price_range = null) {
    $this->db->select("i.*, SUM(s.qty) as total_sold, AVG(pr.rating) as avg_rating");
    $this->db->from("tbl_items i");
    $this->db->join("tbl_sales_details s", "s.food_menu_id = i.id AND s.del_status = 'Live'", "left");
    $this->db->join("tbl_product_ratings pr", "pr.item_id = i.id", "left");
    if($category_ids) {
      $this->db->where_in('i.category_id', $category_ids);
    }
    if($brand_ids) {
      $this->db->where_in('i.brand_id', $brand_ids);
    }   
    if($price_range) {
      $this->db->where('i.sale_price >=', $price_range[0]);
      $this->db->where('i.sale_price <=', $price_range[1]);
    }
    $this->db->where("i.del_status", "Live");
    $this->db->where("i.enable_disable_status", "Enable");
    $this->db->where("i.type !=", "0");
    $this->db->group_by("i.id");
    $this->db->having("total_sold >", 0);
    $this->db->order_by("total_sold", "DESC");
    $this->db->order_by("avg_rating", "DESC");
    if($limit !== 'All') {
      $this->db->limit($per_page, $offset);
    }
    return $this->db->get()->result();
  }

  public function getMostSoldProductsCount($category_ids = null, $brand_ids = null, $price_range = null) {
    $this->db->select('COUNT(DISTINCT i.id) as total');
    $this->db->from('tbl_items i');
    $this->db->join('tbl_sales_details s', 's.food_menu_id = i.id AND s.del_status = "Live"', 'left');
    if($category_ids) {
      $this->db->where_in('i.category_id', $category_ids);
    }
    if($brand_ids) {
      $this->db->where_in('i.brand_id', $brand_ids);
    }
    if($price_range) {
      $this->db->where('i.sale_price >=', $price_range[0]);
      $this->db->where('i.sale_price <=', $price_range[1]);
    }
    $this->db->where("i.del_status", "Live");
    $this->db->where("i.enable_disable_status", "Enable");
    $this->db->having("COUNT(s.id) >", 0);
    return $this->db->get()->row()->total;
  }
  public function getLatestSaleProducts($limit = 'All', $per_page = null, $offset = null, $category_ids = null, $brand_ids = null, $price_range = null) {
    $this->db->select("i.*, s.created_at as sale_date, AVG(pr.rating) as avg_rating, fsi.discount_price");
    $this->db->from("tbl_items i");
    $this->db->join("tbl_sales_details s", "s.food_menu_id = i.id AND s.del_status = 'Live'", "left");
    $this->db->join("tbl_product_ratings pr", "pr.item_id = i.id", "left");
    $this->db->join("tbl_flash_sale_items fsi", "fsi.item_id = i.id", "left");
    
    if($category_ids) {
        $this->db->where_in('i.category_id', $category_ids);
    }
    if($brand_ids) {
      $this->db->where_in('i.brand_id', $brand_ids);
    }   
    if($price_range) {
      $this->db->where('i.sale_price >=', $price_range[0]);
      $this->db->where('i.sale_price <=', $price_range[1]);
    }
    $this->db->where("i.del_status", "Live");
    $this->db->where("i.enable_disable_status", "Enable");
    $this->db->where("i.type !=", "0");
    $this->db->where("s.created_at IS NOT NULL");
    $this->db->group_by("i.id");
    $this->db->order_by("s.created_at", "DESC");
    if($limit !== 'All') {
      $this->db->limit($per_page, $offset);
    }
    return $this->db->get()->result();
  }

  public function getLatestSaleProductsCount($category_ids = null, $brand_ids = null, $price_range = null) {
    $this->db->select('COUNT(DISTINCT i.id) as total');
    $this->db->from('tbl_items i');
    $this->db->join('tbl_sales_details s', 's.food_menu_id = i.id AND s.del_status = "Live"', 'left');
    if($category_ids) {
      $this->db->where_in('i.category_id', $category_ids);
    }
    if($brand_ids) {
      $this->db->where_in('i.brand_id', $brand_ids);
    }
    if($price_range) {
      $this->db->where('i.sale_price >=', $price_range[0]);
      $this->db->where('i.sale_price <=', $price_range[1]);
    }
    $this->db->where("i.del_status", "Live");
    $this->db->where("i.enable_disable_status", "Enable");
    $this->db->where("s.created_at IS NOT NULL");
    return $this->db->get()->row()->total;
  }

  public function getMostSoldProducts1($fetch_type = '') {
    $this->db->select("i.id AS item_id, i.name AS item_name, ii.name as parent_name, i.type, i.sale_price, i.photo, SUM(s.qty) AS total_sold, AVG(pr.rating) AS avg_rating, fsi.discount_price, fsi.stock_limit");
    $this->db->from("tbl_sales_details s");
    $this->db->join("tbl_items i", "s.food_menu_id = i.id", "left");
    $this->db->join("tbl_items ii", "i.parent_id = ii.id", "left");
    $this->db->join("tbl_product_ratings pr", "pr.item_id = i.id", "left");
    $this->db->join("tbl_flash_sale_items fsi", "fsi.item_id = i.id", "left");
    $this->db->where("s.del_status", "Live");
    $this->db->where("i.del_status", "Live");
    $this->db->group_by("i.id");
    $this->db->order_by("total_sold", "DESC");
    if($fetch_type != 'All' && $fetch_type != ''){
      $this->db->limit($fetch_type);
    }
    $query = $this->db->get();
    return $query->result();
  }

  


  public function getTopRatedProducts1($fetch_type = '') {
    $this->db->select("i.id AS item_id, i.name AS item_name, ii.name as parent_name, i.type,
        i.sale_price, i.photo, 
        COALESCE(SUM(s.qty), 0) AS total_sold, 
        COALESCE(AVG(pr.rating), 0) AS avg_rating, 
        fsi.discount_price, fsi.stock_limit");
    $this->db->from("tbl_items i");
    $this->db->join("tbl_items ii", "i.parent_id = ii.id", "left");
    $this->db->join("tbl_sales_details s", "s.food_menu_id = i.id AND s.del_status = 'Live'", "left");
    $this->db->join("tbl_product_ratings pr", "pr.item_id = i.id AND pr.del_status = 'Live'", "left");
    $this->db->join("tbl_flash_sale_items fsi", "fsi.item_id = i.id AND fsi.del_status = 'Live'", "left");
    $this->db->where("i.del_status", "Live");
    $this->db->where("i.enable_disable_status", "Enable");
    $this->db->having("avg_rating >", 0);
    $this->db->group_by("i.id");
    $this->db->order_by("avg_rating", "DESC");
    $this->db->order_by("total_sold", "DESC");
    if($fetch_type != 'All' && $fetch_type != '' && is_numeric($fetch_type)){
      $this->db->limit((int)$fetch_type);
    }
    $query = $this->db->get();
    return $query->result();
  }

public function getLatestSaleProducts1($fetch_type = '') {
    $this->db->select("i.id AS item_id, i.name AS item_name, ii.name as parent_name, i.type, i.sale_price, i.photo, s.sale_date, sd.qty, COALESCE(AVG(pr.rating), 0) AS avg_rating, fsi.discount_price, fsi.stock_limit");
    $this->db->from("tbl_sales_details sd");
    $this->db->join("tbl_sales s", "s.id = sd.sales_id", "left");
    $this->db->join("tbl_items i", "sd.food_menu_id = i.id", "left");
    $this->db->join("tbl_items ii", "i.parent_id = ii.id", "left");
    $this->db->join("tbl_product_ratings pr", "pr.item_id = i.id", "left");
    $this->db->join("tbl_flash_sale_items fsi", "fsi.item_id = i.id", "left");
    $this->db->where("sd.del_status", "Live");
    $this->db->where("i.del_status", "Live");
    $this->db->group_by("sd.food_menu_id");
    $this->db->order_by("s.sale_date", "DESC");
    if($fetch_type != 'All' && $fetch_type != ''){
      $this->db->limit($fetch_type);
    }
    $query = $this->db->get();
    return $query->result();
}


  public function fetchFlashSale1(){
    $this->db->select("i.id AS item_id, i.name AS item_name, ii.name as parent_name, i.type, i.photo AS item_photo, i.sale_price, i.type AS item_type, i.code AS item_code, i.description, fsi.discount_price, fsi.stock_limit, AVG(pr.rating) AS avg_rating, fs.flash_sale_title");
    $this->db->from("tbl_flash_sale_items fsi");
    $this->db->join("tbl_items i", "fsi.item_id = i.id", "left");
    $this->db->join("tbl_items ii", "i.parent_id = ii.id", "left");
    $this->db->join("tbl_product_ratings pr", "pr.item_id = i.id", "left");
    $this->db->join("tbl_flash_sales fs", "fsi.flash_sale_id = fs.id", "left");
    $this->db->where("fs.status", "Active");
    $this->db->where("fsi.del_status", "Live");
    $this->db->where("NOW() BETWEEN fs.start_date AND fs.end_date");
    // Type wise get
    $this->db->where("i.type !=", "Variation_Product");
    $this->db->group_by("i.id");
    $query = $this->db->get();
    return $query->result();
  } 
  public function getFlashSaleDate(){
    $this->db->select("*");
    $this->db->from("tbl_flash_sales");
    $this->db->where("status", "Active");
    $this->db->order_by("id", 'DESC');
    $this->db->limit(1);
    $query = $this->db->get();
    return $query->row();
  } 
public function customerRatting($limit = '') {
    $this->db->select("pr.*, i.name as item_name, i.type, i.sale_price, i.photo, c.name as customer_name, fsi.discount_price, fsi.stock_limit");
    $this->db->from("tbl_product_ratings pr");
    $this->db->join("tbl_items i", "i.id = pr.item_id", "left");
    $this->db->join("tbl_customers c", "c.id = pr.customer_id", "left");
    $this->db->join("tbl_flash_sale_items fsi", "fsi.item_id = i.id", "left");
    $this->db->where("fsi.del_status", "Live");
    $this->db->where("pr.rating", 5.00);
    $this->db->where("pr.review !=", '');
    $this->db->where("pr.del_status", "Live");
    $this->db->group_by("pr.customer_id, pr.item_id");
    if($limit){
      $this->db->limit($limit);
    }
    $query = $this->db->get();
    return $query->result();
}
public function getProductVariations($id = '') {
  $this->db->select("id, name, type, sale_price, photo, code, description, enable_disable_status");
  $this->db->from("tbl_items");
  $this->db->where("parent_id", $id);
  $this->db->where("del_status", "Live");
  $query = $this->db->get();
  return $query->result();
}

public function getAllFaq() {
  $this->db->select("*");
  $this->db->from("tbl_faqs");
  $this->db->where("status", "Enable");
  $this->db->where("del_status", "Live");
  $this->db->order_by("id", "DESC");
  $query = $this->db->get();
  return $query->result();
}

public function getAllFlashSaleItemById($id) {
  $this->db->select("flash_sale_id,item_id,discount_price");
  $this->db->from('tbl_flash_sale_items');
  $this->db->where("flash_sale_id", $id);
  $this->db->where("del_status", "Live");
  return $this->db->get()->result();
}

















  // Filter Issue
  public function filterProducts($type = null, $main_id = null, $category_ids = null, $brand_ids = null, $price_range = null, $sorting = null, $limit = null, $offset = null) {
    $this->db->select("i.id,i.name,i.code,i.type,i.alternative_name,i.generic_name,i.sale_price,i.photo,i.description,i.brand_id,b.name as brand_name, fsi.discount_price, fsi.stock_limit, AVG(pr.rating) AS avg_rating, ii.name as parent_name");
    $this->db->from('tbl_items i');
    $this->db->join("tbl_items ii", "i.parent_id = ii.id", "left");
    $this->db->join('tbl_brands b', 'b.id = i.brand_id', 'left');
    $this->db->join("tbl_product_ratings pr", "pr.item_id = i.id", "left");
    $this->db->join("tbl_flash_sale_items fsi", "fsi.item_id = i.id", "left");
    $this->db->where("i.enable_disable_status", "Enable");
    if($type == 'e-brand'){
      if($main_id){
        $this->db->where("i.brand_id", $main_id);
      }
    }else if($type == 'e-category'){
      if($main_id){
        $this->db->where("i.category_id", $main_id);
      }
    }
    $this->db->where("i.type !=", '0');
    $this->db->where("i.del_status", "Live");
    if($category_ids) {
      $this->db->where_in('i.category_id', $category_ids);
    }
    if($brand_ids) {
      $this->db->where_in('i.brand_id', $brand_ids);
    }
    if($price_range && is_array($price_range) && count($price_range) == 2) {
      $min_price = floatval($price_range[0]);
      $max_price = floatval($price_range[1]);
      if($min_price >= 0 && $max_price > 0 && $max_price >= $min_price) {
        $this->db->where('i.sale_price >=', $min_price);
        $this->db->where('i.sale_price <=', $max_price);
      }
    }
    $this->db->group_by('i.id');
    if($sorting == 'Low-To-High') {
      $this->db->order_by('i.sale_price', 'ASC');
    } else if($sorting == 'High-To-Low') {
      $this->db->order_by('i.sale_price', 'DESC'); 
    } else {
      $this->db->order_by('i.id', 'DESC');
    }
    if($limit) {
      $this->db->limit($limit, $offset);
    }
    return $this->db->get()->result();
  }

  public function filterProductsCount($type = null, $main_id = null, $category_ids = null, $brand_ids = null, $price_range = null) {
    $this->db->from('tbl_items i');
    $this->db->where("i.enable_disable_status", "Enable");
    if($type == 'e-brand'){
      if($main_id){
        $this->db->where("i.brand_id", $main_id);
      }
    }else if($type == 'e-category'){
      if($main_id){
        $this->db->where("i.category_id", $main_id);
      }
    }
    $this->db->where("i.type !=", '0');
    $this->db->where("i.del_status", "Live");
    if($category_ids) {
      $this->db->where_in('i.category_id', $category_ids);
    }
    if($brand_ids) {
      $this->db->where_in('i.brand_id', $brand_ids);
    }
    if($price_range && is_array($price_range) && count($price_range) == 2) {
      $min_price = floatval($price_range[0]);
      $max_price = floatval($price_range[1]);
      if($min_price >= 0 && $max_price > 0 && $max_price >= $min_price) {
        $this->db->where('i.sale_price >=', $min_price);
        $this->db->where('i.sale_price <=', $max_price);
      }
    }
    return $this->db->count_all_results();
  }

  public function filterProductsByType($type = null, $category_ids = null, $brand_ids = null, $price_range = null, $sorting = null, $limit = null, $offset = null) {
    if($type == 'latest-selling'){
      $this->db->select("i.id,i.name,i.code,i.type,i.alternative_name,i.generic_name,i.sale_price,i.photo,i.description,i.brand_id,b.name as brand_name, fsi.discount_price, fsi.stock_limit, AVG(pr.rating) AS avg_rating, ii.name as parent_name, sd.created_at as sale_date");
      $this->db->from('tbl_items i');
      $this->db->join("tbl_items ii", "i.parent_id = ii.id", "left");
      $this->db->join('tbl_brands b', 'b.id = i.brand_id', 'left');
      $this->db->join("tbl_product_ratings pr", "pr.item_id = i.id", "left");
      $this->db->join("tbl_flash_sale_items fsi", "fsi.item_id = i.id", "left");
      $this->db->join("tbl_sales_details sd", "sd.food_menu_id = i.id", "left");
      $this->db->join("tbl_sales s", "s.id = sd.sales_id AND s.del_status = 'Live'", "left");
      $this->db->where("i.enable_disable_status", "Enable");
      $this->db->where("i.type !=", '0');
      $this->db->where("i.del_status", "Live");
      $this->db->where("sd.created_at IS NOT NULL");
      if($category_ids) {
        $this->db->where_in('i.category_id', $category_ids);
      }
      if($brand_ids) {
        $this->db->where_in('i.brand_id', $brand_ids);
      }
      if($price_range) {
        $prices = explode(',', $price_range);
        if(count($prices) == 2) {
          $min_price = floatval(trim($prices[0]));
          $max_price = floatval(trim($prices[1]));
          if($min_price > $max_price) {
            $temp = $min_price;
            $min_price = $max_price;
            $max_price = $temp;
          }
          $this->db->where('i.sale_price >=', $min_price);
          $this->db->where('i.sale_price <=', $max_price);
        }
      }
      $this->db->group_by("i.id");
      $this->db->order_by("sd.created_at", "DESC");
      if($sorting == 'Low-To-High') {
        $this->db->order_by('i.sale_price', 'ASC');
      } else if($sorting == 'High-To-Low') {
        $this->db->order_by('i.sale_price', 'DESC'); 
      }
      if($limit) {
        $this->db->limit($limit, $offset);
      }
      return $this->db->get()->result();
    }else if($type == 'best-selling'){
      $this->db->select("i.id,i.name,i.code,i.type,i.alternative_name,i.generic_name,i.sale_price,i.photo,i.description,i.brand_id,b.name as brand_name, fsi.discount_price, fsi.stock_limit, AVG(pr.rating) AS avg_rating, ii.name as parent_name, COUNT(sd.id) as total_sold");
      $this->db->from('tbl_items i');
      $this->db->join("tbl_items ii", "i.parent_id = ii.id", "left");
      $this->db->join('tbl_brands b', 'b.id = i.brand_id', 'left');
      $this->db->join("tbl_product_ratings pr", "pr.item_id = i.id", "left");
      $this->db->join("tbl_flash_sale_items fsi", "fsi.item_id = i.id", "left");
      $this->db->join("tbl_sales_details sd", "sd.food_menu_id = i.id AND sd.del_status = 'Live'", "left");
      $this->db->where("i.enable_disable_status", "Enable");
      $this->db->where("i.type !=", '0');
      $this->db->where("i.del_status", "Live");
      
      if($category_ids) {
        $this->db->where_in('i.category_id', $category_ids);
      }
      if($brand_ids) {
        $this->db->where_in('i.brand_id', $brand_ids);
      }
      if($price_range) {
        $prices = explode(',', $price_range);
        if(count($prices) == 2) {
          $min_price = floatval(trim($prices[0]));
          $max_price = floatval(trim($prices[1]));
          if($min_price > $max_price) {
            $temp = $min_price;
            $min_price = $max_price;
            $max_price = $temp;
          }
          $this->db->where('i.sale_price >=', $min_price);
          $this->db->where('i.sale_price <=', $max_price);
        }
      }
      
      $this->db->group_by("i.id");
      $this->db->having("total_sold >", 0);
      $this->db->order_by("total_sold", "DESC");
      
      if($sorting == 'Low-To-High') {
        $this->db->order_by('i.sale_price', 'ASC');
      } else if($sorting == 'High-To-Low') {
        $this->db->order_by('i.sale_price', 'DESC'); 
      }
      
      if($limit) {
        $this->db->limit($limit, $offset);
      }
      return $this->db->get()->result();

    }else if($type == 'top-rated'){
      $this->db->select("i.id,i.name,i.code,i.type,i.alternative_name,i.generic_name,i.sale_price,i.photo,i.description,i.brand_id,b.name as brand_name, fsi.discount_price, fsi.stock_limit, AVG(pr.rating) AS avg_rating, ii.name as parent_name, COUNT(s.id) as total_sold");
      $this->db->from('tbl_items i');
      $this->db->join("tbl_items ii", "i.parent_id = ii.id", "left");
      $this->db->join('tbl_brands b', 'b.id = i.brand_id', 'left');
      $this->db->join("tbl_product_ratings pr", "pr.item_id = i.id", "left");
      $this->db->join("tbl_flash_sale_items fsi", "fsi.item_id = i.id", "left");
      $this->db->join("tbl_sales_details s", "s.food_menu_id = i.id AND s.del_status = 'Live'", "left");
      $this->db->where("i.enable_disable_status", "Enable");
      $this->db->where("i.type !=", '0');
      $this->db->where("i.del_status", "Live");
      if($category_ids) {
        $this->db->where_in('i.category_id', $category_ids);
      }
      if($brand_ids) {
        $this->db->where_in('i.brand_id', $brand_ids);
      }
      if($price_range) {
        $prices = explode(',', $price_range);
        if(count($prices) == 2) {
          $min_price = floatval(trim($prices[0]));
          $max_price = floatval(trim($prices[1]));
          if($min_price > $max_price) {
            $temp = $min_price;
            $min_price = $max_price;
            $max_price = $temp;
          }
          $this->db->where('i.sale_price >=', $min_price);
          $this->db->where('i.sale_price <=', $max_price);
        }
      }
      $this->db->having("avg_rating >", 0);
      $this->db->group_by("i.id");
      $this->db->order_by("avg_rating", "DESC");
      $this->db->order_by("total_sold", "DESC");
      if($sorting == 'Low-To-High') {
        $this->db->order_by('i.sale_price', 'ASC');
      } else if($sorting == 'High-To-Low') {
        $this->db->order_by('i.sale_price', 'DESC'); 
      } else {
        $this->db->order_by('i.id', 'DESC');
      }
      if($limit) {
        $this->db->limit($limit, $offset);
      }
      return $this->db->get()->result();
    }
  }

  public function filterProductsCountByType($type = null, $category_ids = null, $brand_ids = null, $price_range = null) {
    if($type == 'latest-selling'){
      $this->db->select("i.id");
      $this->db->from('tbl_items i');
      $this->db->join("tbl_sales_details sd", "sd.food_menu_id = i.id", "left");
      $this->db->join("tbl_sales s", "s.id = sd.sales_id AND s.del_status = 'Live'", "left");
      $this->db->where("i.enable_disable_status", "Enable");
      $this->db->where("i.type !=", '0');
      $this->db->where("i.del_status", "Live");
      $this->db->where("sd.created_at IS NOT NULL");
      if($category_ids) {
        $this->db->where_in('i.category_id', $category_ids);
      }
      if($brand_ids) {
        $this->db->where_in('i.brand_id', $brand_ids);
      }
      if($price_range) {
        $prices = explode(',', $price_range);
        if(count($prices) == 2) {
          $min_price = floatval(trim($prices[0]));
          $max_price = floatval(trim($prices[1]));
          if($min_price > $max_price) {
            $temp = $min_price;
            $min_price = $max_price;
            $max_price = $temp;
          }
          $this->db->where('i.sale_price >=', $min_price);
          $this->db->where('i.sale_price <=', $max_price);
        }
      }
      $this->db->group_by("i.id");
      return $this->db->get()->num_rows();
    }else if($type == 'best-selling'){
      $this->db->select("i.id, COUNT(sd.id) as total_sold");
      $this->db->from('tbl_items i');
      $this->db->join("tbl_sales_details sd", "sd.food_menu_id = i.id AND sd.del_status = 'Live'", "left");
      $this->db->where("i.enable_disable_status", "Enable");
      $this->db->where("i.type !=", '0');
      $this->db->where("i.del_status", "Live");
      if($category_ids) {
        $this->db->where_in('i.category_id', $category_ids);
      }
      if($brand_ids) {
        $this->db->where_in('i.brand_id', $brand_ids);
      }
      if($price_range) {
        $prices = explode(',', $price_range);
        if(count($prices) == 2) {
          $min_price = floatval(trim($prices[0]));
          $max_price = floatval(trim($prices[1]));
          if($min_price > $max_price) {
            $temp = $min_price;
            $min_price = $max_price;
            $max_price = $temp;
          }
          $this->db->where('i.sale_price >=', $min_price);
          $this->db->where('i.sale_price <=', $max_price);
        }
      }
      $this->db->group_by("i.id");
      $this->db->having("total_sold >", 0);
      return $this->db->get()->num_rows();
      
    }else if($type == 'top-rated'){
      $this->db->select("i.*, AVG(pr.rating) as avg_rating");
      $this->db->from('tbl_items i');
      $this->db->join("tbl_product_ratings pr", "pr.item_id = i.id", "left");
      $this->db->where("i.enable_disable_status", "Enable");
      $this->db->where("i.type !=", '0');
      $this->db->where("i.del_status", "Live");
      if($category_ids) {
        $this->db->where_in('i.category_id', $category_ids);
      }
      if($brand_ids) {
        $this->db->where_in('i.brand_id', $brand_ids);
      }
      if($price_range) {
        $prices = explode(',', $price_range);
        if(count($prices) == 2) {
          $min_price = floatval(trim($prices[0]));
          $max_price = floatval(trim($prices[1]));
          if($min_price > $max_price) {
            $temp = $min_price;
            $min_price = $max_price;
            $max_price = $temp;
          }
          $this->db->where('i.sale_price >=', $min_price);
          $this->db->where('i.sale_price <=', $max_price);
        }
      }
      $this->db->group_by("i.id");
      $this->db->having("avg_rating >", 0);
      return $this->db->get()->num_rows();
    }
  }
}

