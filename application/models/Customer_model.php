<?php
/*
  ###########################################################
  # PRODUCT NAME:   Off POS
  ###########################################################
  # AUTHER:   Doorsoft
  ###########################################################
  # EMAIL:   info@doorsoft.co
  ###########################################################
  # COPYRIGHTS:   RESERVED BY Door Soft
  ###########################################################
  # WEBSITE:   http://www.doorsoft.co
  ###########################################################
  # This is Sale_model Model
  ###########################################################
 */
class Customer_model extends CI_Model
{

    /**
     * make_datatables
     * @access public
     * @param int
     * @param string
     * @return object
     */
    public function make_datatables($outlet_id, $delivery_status = "")
    {
        $this->make_query();
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST["length"], $_POST["start"]);
        }
        return $this->db->get()->result();
    }

    /**
     * getDrawData
     * @access public
     * @param no
     * @return string
     */
    public function getDrawData(){
        return $_POST["draw"];
    }


    /**
     * getSaleList
     * @access public
     * @param int
     * @return object
     */
    public function getCustomerList($outlet_id) {
        $result = $this->db->query("SELECT s.*,u.full_name,c.name as customer_name
            FROM tbl_sales s
            INNER JOIN tbl_customers c ON(s.customer_id=c.id)
            LEFT JOIN tbl_users u ON(s.user_id=u.id)
            WHERE s.del_status = 'Live' ORDER BY s.id DESC")->result();
        return $result;
    }

    /**
     * get_all_data
     * @access public
     * @param int
     * @param string
     * @return object
     */
    public function get_all_data($outlet_id, $delivery_status=""){
        $company_id = $this->session->userdata('company_id');
        $this->db->select("*");
        $this->db->from('tbl_customers');
        $this->db->where("tbl_customers.company_id", $company_id);
        $this->db->where("tbl_customers.del_status", "Live");
        return $this->db->count_all_results();
    }

     /**
   * get_filtered_data
   * @access public
   * @param int
   * @param string
   * @return object
   */
    public function get_filtered_data($outlet_id, $delivery_status=""){
        $this->make_query();
        $result = $this->db->get();
        return $result->num_rows();
    }

    /**
     * make_query
     * @access public
     * @param int
     * @param string
     * @return object
     */
    public function make_query()
    {
        $company_id = $this->session->userdata('company_id');

        $this->db->select("
        c.id, 
        c.name, 
        c.phone, 
        c.email, 
        c.price as customer_price, 
        c.address, 
        c.opening_balance, 
        c.opening_balance_type,
        c.credit_limit, 
        c.gst_number, 
        c.customer_type, 
        c.discount, 
        c.price_type,
        c.same_or_diff_state, 
        c.del_status, 
        c.added_date, 
        u.full_name AS added_by,
        CASE 
            WHEN c.opening_balance_type = 'Credit' THEN 
                - c.opening_balance 
                + COALESCE(sale_sum.due_amount_sum, 0) 
                - COALESCE(due_receive_sum.amount_sum, 0) 
                - COALESCE(return_sum.total_return_amount_sum, 0)
            ELSE 
                c.opening_balance 
                + COALESCE(sale_sum.due_amount_sum, 0) 
                - COALESCE(due_receive_sum.amount_sum, 0) 
                - COALESCE(return_sum.total_return_amount_sum, 0)
        END AS opening_balance
    ");

        $this->db->from("tbl_customers c");

        $this->db->join("(SELECT customer_id, COALESCE(SUM(due_amount), 0) AS due_amount_sum 
                      FROM tbl_sales 
                      WHERE del_status = 'Live' 
                      GROUP BY customer_id) AS sale_sum",
            "c.id = sale_sum.customer_id",
            "left"
        );

        $this->db->join("(SELECT customer_id, COALESCE(SUM(amount), 0) AS amount_sum 
                      FROM tbl_customer_due_receives 
                      WHERE del_status = 'Live' 
                      GROUP BY customer_id) AS due_receive_sum",
            "c.id = due_receive_sum.customer_id",
            "left"
        );

        $this->db->join("(SELECT customer_id, COALESCE(SUM(due), 0) AS total_return_amount_sum 
                      FROM tbl_sale_return 
                      WHERE del_status = 'Live' 
                      GROUP BY customer_id) AS return_sum",
            "c.id = return_sum.customer_id",
            "left"
        );

        $this->db->join("tbl_users u", "u.id = c.user_id", "left");

        $this->db->where("c.company_id", $company_id);
        $this->db->where("c.del_status", "Live");

        $this->db->group_by("c.id");
        $this->db->order_by("c.id", "DESC");
    }

}