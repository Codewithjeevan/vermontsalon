<?php
/*
  ###########################################################
  # PRODUCT NAME:   OFF POS
  ###########################################################
  # This is OutStock_model Model
  ###########################################################
 */
class OutStock_model extends CI_Model {

    /**
     * generateOutStockRefNo
     * @access public
     * @param int
     * @return string
     */
    public function generateOutStockRefNo($outlet_id) {
        $count = $this->db->query("SELECT count(id) as count
            FROM tbl_out_stock where outlet_id=$outlet_id")->row('count');
        $code = str_pad($count + 1, 6, '0', STR_PAD_LEFT);
        return 'OS-' . $code;
    }

    /**
     * getAvailablePurchaseDetails
     * @access public
     * @param int
     * @param int
     * @return object
     */
    public function getAvailablePurchaseDetails($company_id, $outlet_id) {
        $sql = "
            SELECT pd.id, pd.purchase_id, pd.item_id, pd.quantity_amount, pd.quantity_amount AS amount_quantity, pd.unit_price, pd.item_type,
                pd.expiry_imei_serial, p.reference_no, p.date as purchase_date,
                i.name as item_name, i.code as item_code, i.unit_type, i.type, i.expiry_date_maintain,
                pu.unit_name as purchase_unit, b.name as brand_name
            FROM tbl_purchase_details pd
            JOIN tbl_purchase p ON p.id = pd.purchase_id
            JOIN tbl_items i ON i.id = pd.item_id
            LEFT JOIN tbl_brands b ON b.id = i.brand_id
            LEFT JOIN tbl_units pu ON pu.id = i.purchase_unit_id
            JOIN (
                SELECT item_id, MIN(id) as min_id
                FROM tbl_purchase_details
                WHERE company_id = ? AND outlet_id = ? AND quantity_amount > 0 AND del_status = 'Live'
                GROUP BY item_id
            ) first_pd ON first_pd.item_id = pd.item_id AND first_pd.min_id = pd.id
            WHERE pd.company_id = ? AND pd.outlet_id = ? AND pd.quantity_amount > 0 AND pd.del_status = 'Live'
            ORDER BY pd.id DESC
        ";
        $bindings = [$company_id, $outlet_id, $company_id, $outlet_id];
        $result = $this->db->query($sql, $bindings);
        return $result->result();
    }

    /**
     * getStockAvailabilityReport
     * @access public
     * @param int
     * @param int
     * @return object
     */
    public function getStockAvailabilityReport($company_id, $outlet_id, $category_id = '') {
        $category_filter = "";
        if (!empty($category_id)) {
            $category_filter = " AND i.category_id = ? ";
        }

        $sql = "
            SELECT
                pd.item_id,
                i.name AS item_name,
                i.code AS item_code,
                COALESCE(SUM(pd.quantity_amount), 0) AS available_qty,
                COALESCE(consumed.consumed_qty, 0) AS consumed_qty,
                COALESCE(SUM(pd.current_qty), 0) AS purchased_qty,
                COALESCE(last_pd.last_purchase_detail_id, 0) AS last_purchase_detail_id,
                COALESCE(last_pd.unit_price, 0) AS unit_price,
                COALESCE(u.unit_name, '') AS unit_name
            FROM tbl_purchase_details pd
            JOIN tbl_items i ON i.id = pd.item_id AND i.del_status = 'Live'
            LEFT JOIN tbl_units u ON u.id = i.purchase_unit_id
            LEFT JOIN (
                SELECT pd2.item_id, SUM(os.out_stock_qty) AS consumed_qty
                FROM tbl_out_stock os
                JOIN tbl_purchase_details pd2 ON pd2.id = os.purchase_detail_id
                WHERE os.company_id = ? AND os.outlet_id = ? AND os.del_status = 'Live'
                GROUP BY pd2.item_id
            ) consumed ON consumed.item_id = pd.item_id
            LEFT JOIN (
                SELECT pd3.item_id, pd3.id AS last_purchase_detail_id, pd3.unit_price
                FROM tbl_purchase_details pd3
                JOIN (
                    SELECT item_id, MAX(id) AS last_id
                    FROM tbl_purchase_details
                    WHERE company_id = ? AND outlet_id = ? AND del_status = 'Live'
                    GROUP BY item_id
                ) last_ids ON last_ids.item_id = pd3.item_id AND last_ids.last_id = pd3.id
                WHERE pd3.company_id = ? AND pd3.outlet_id = ? AND pd3.del_status = 'Live'
            ) last_pd ON last_pd.item_id = pd.item_id
            WHERE pd.company_id = ? AND pd.outlet_id = ? AND pd.del_status = 'Live' {$category_filter}
            GROUP BY pd.item_id, i.name, i.code, consumed.consumed_qty, last_pd.last_purchase_detail_id, last_pd.unit_price, u.unit_name
            HAVING (COALESCE(SUM(pd.quantity_amount), 0) + COALESCE(consumed.consumed_qty, 0)) > 0
            ORDER BY i.name ASC
        ";

        $bindings = [
            $company_id,
            $outlet_id,
            $company_id,
            $outlet_id,
            $company_id,
            $outlet_id,
            $company_id,
            $outlet_id,
        ];

        if (!empty($category_id)) {
            $bindings[] = $category_id;
        }

        $result = $this->db->query($sql, $bindings);
        return $result->result();
    }

    /**
     * getOutStockList
     * @access public
     * @param int
     * @param int
     * @return object
     */
    public function getOutStockList($company_id, $outlet_id) {
        $this->db->select("os.*, i.name as item_name, i.code as item_code, b.name as brand_name,pui.unit_name as purchase_unit_name");
        $this->db->from("tbl_out_stock os");
        $this->db->join("tbl_items i", "i.id = os.item_id", "left");
        $this->db->join("tbl_brands b", "b.id = i.brand_id", "left");
        $this->db->join('tbl_units pui','pui.id = i.purchase_unit_id','left');
        $this->db->where("os.company_id", $company_id);
        $this->db->where("os.outlet_id", $outlet_id);
        $this->db->where("os.del_status", "Live");
        $this->db->order_by("os.id", "DESC");
        $result = $this->db->get();
        return $result->result();
    }

    /**
     * getStockAdjustments
     * @access public
     * @param int $company_id
     * @param int $outlet_id
     * @param string $start_date
     * @param string $end_date
     * @return array
     */
    public function getStockAdjustments($company_id, $outlet_id, $start_date = "", $end_date = "", $purchase_detail_id = "") {
        $this->db->select("si.*, i.name as item_name, pd.quantity_amount as current_qty");
        $this->db->from("tbl_stock_in si");
        $this->db->join("tbl_items i","i.id = si.item_id","left");
        $this->db->join("tbl_purchase_details pd","pd.id = si.purchase_detail_id","left");
        $this->db->where("si.company_id", $company_id);
        $this->db->where("si.outlet_id", $outlet_id);
        $this->db->where("si.del_status", "Live");
        if ($start_date) {
            $this->db->where("si.adjustment_date >= ", date('Y-m-d 00:00:00', strtotime($start_date)));
        }
        if ($end_date) {
            $this->db->where("si.adjustment_date <= ", date('Y-m-d 23:59:59', strtotime($end_date)));
        }
        if ($purchase_detail_id) {
            $this->db->where("si.purchase_detail_id", $purchase_detail_id);
        }
        $this->db->order_by("si.id", "DESC");
        return $this->db->get()->result();
    }

    /**
     * getOutStock
     * @access public
     * @param int
     * @return object
     */
    public function getOutStock($id) {
        $this->db->select("os.*,pui.unit_name as purchase_unit_name");
        $this->db->from("tbl_out_stock os");
        $this->db->join("tbl_items i", "i.id = os.item_id", "left");
        $this->db->join("tbl_brands b", "b.id = i.brand_id", "left");
        $this->db->join('tbl_units pui','pui.id = i.purchase_unit_id','left');
        $this->db->where("os.id", $id);
        $this->db->where("os.del_status", "Live");
        return $this->db->get()->row();
    }
}
