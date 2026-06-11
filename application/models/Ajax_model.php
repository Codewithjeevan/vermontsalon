<?php
/*
  ###########################################################
  # PRODUCT NAME: 	OFF POS
  ###########################################################
  # AUTHER:		Doorsoft
  ###########################################################
  # EMAIL:		info@doorsoft.co
  ###########################################################
  # COPYRIGHTS:		RESERVED BY Door Soft
  ###########################################################
  # WEBSITE:		http://www.doorsoft.co
  ###########################################################
  # This is Ajax_model Model
  ###########################################################
 */
class Ajax_model extends CI_Model {

    /**
     * getUserInformation
     * @access public
     * @param string
     * @param string
     * @return object
     */
    public function getUserInformation($email_address, $password) {
        $this->db->select("*");
        $this->db->from("tbl_users");
        $this->db->where("email_address", $email_address);
        $this->db->where("password", $password);
        $this->db->where("active_status", 'Active');
        $this->db->where("del_status", 'Live');
        return $this->db->get()->row();
    }

    /**
     * getLastPurchasePrice
     * Returns the most recent unit_price for the given item from
     * tbl_purchase_details (joined with tbl_purchase for the latest date)
     * scoped to the current outlet/company.
     *
     * @access public
     * @param int $item_id
     * @return object|null
     */
    public function getLastPurchasePrice($item_id) {
        $outlet_id  = $this->session->userdata('outlet_id');
        $company_id = $this->session->userdata('company_id');
        $this->db->select('pd.unit_price, pd.quantity_amount, p.date, p.reference_no');
        $this->db->from('tbl_purchase_details pd');
        $this->db->join('tbl_purchase p', 'p.id = pd.purchase_id', 'left');
        $this->db->where('pd.item_id', $item_id);
        $this->db->where('pd.del_status', 'Live');
        if ($outlet_id != '') {
            $this->db->where('pd.outlet_id', $outlet_id);
        }
        if ($company_id != '') {
            $this->db->where('pd.company_id', $company_id);
        }
        $this->db->order_by('p.date', 'DESC');
        $this->db->order_by('pd.id', 'DESC');
        $this->db->limit(1);
        return $this->db->get()->row();
    }

}

