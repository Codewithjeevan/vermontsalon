<?php
/*
    ###########################################################
    # PRODUCT NAME:   Off POS
    ###########################################################
    # This is OutStock Controller
    ###########################################################
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class OutStock extends Cl_Controller {

    /**
     * load constructor
     * @access public
     * @return void
     */    
    public function __construct() {
        parent::__construct();
        $this->load->model('Authentication_model');
        $this->load->model('Common_model');
        $this->load->model('OutStock_model');
        $this->Common_model->setDefaultTimezone();
        $this->load->library('form_validation');
        if (!$this->session->has_userdata('user_id')) {
            redirect('Authentication/index');
        }
        if (!$this->session->has_userdata('outlet_id')) {
            $this->session->set_flashdata('exception_2', lang('please_click_green_button'));
            $this->session->set_userdata("clicked_controller", $this->uri->segment(1));
            $this->session->set_userdata("clicked_method", $this->uri->segment(2));
            redirect('Outlet/outlets');
        }

        $segment_2 = $this->uri->segment(2);
        $controller = "164";
        $function = "view";
        if (!in_array($segment_2, ['outStockList', 'addEditOutStock', 'addStockAdjustment', 'stockAvailability', 'getStockAdjustments'])) {
            $this->session->set_flashdata('exception_1', lang('no_access'));
            redirect('Authentication/userProfile');
        }
        if(!checkAccess($controller,$function)){
            $this->session->set_flashdata('exception_1',lang('no_access'));
            redirect('Authentication/userProfile');
        }

        $register_content = json_decode($this->session->userdata('register_content'));
        $register_status = $this->session->userdata('register_status');
        if ($register_content->register_purchase != '' && $register_status == 2) {
            $this->session->set_flashdata('exception', lang('please_open_register'));
            $this->session->set_userdata("clicked_controller", $this->uri->segment(1));
            $this->session->set_userdata("clicked_method", $this->uri->segment(2));
            redirect('Register/openRegister');
        }
    }

    /**
     * outStockList
     * @access public
     * @return void
     */
    public function outStockList() {
        $company_id = $this->session->userdata('company_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $data['out_stocks'] = $this->OutStock_model->getOutStockList($company_id, $outlet_id);
        $data['active_tab'] = 'out_stock';
        $data['main_content'] = $this->load->view('out_stock/outStockList', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    /**
     * stockAvailability
     * @access public
     * @return void
     */
    public function stockAvailability() {
        $company_id = $this->session->userdata('company_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $data['stock_report'] = $this->OutStock_model->getStockAvailabilityReport($company_id, $outlet_id);
        $data['active_tab'] = 'stock_availability';
        $data['main_content'] = $this->load->view('out_stock/stockAvailability', $data, TRUE);
        $this->load->view('userHome', $data);
    }

    public function getStockAdjustments() {
        if (!$this->input->is_ajax_request()) {
            show_404();
            return;
        }
        $company_id = $this->session->userdata('company_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $start_date = htmlspecialcharscustom($this->input->post('start_date'));
        $end_date = htmlspecialcharscustom($this->input->post('end_date'));
        $purchase_detail_id = (int)$this->input->post('purchase_detail_id');
        $result = $this->OutStock_model->getStockAdjustments($company_id, $outlet_id, $start_date, $end_date, $purchase_detail_id);
        echo json_encode($result);
    }

    /**
     * addStockAdjustment
     * @access public
     * @return void
     */
    public function addStockAdjustment() {
        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            show_404();
            return;
        }

        $this->output->set_content_type('application/json');

        $company_id = $this->session->userdata('company_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $item_id = (int)$this->input->post('item_id');
        $purchase_detail_id = (int)$this->input->post('purchase_detail_id');
        $quantity_plus = (float)$this->input->post('quantity_plus');
        $quantity_minus = (float)$this->input->post('quantity_minus');
        $adjustment_date_input = htmlspecialcharscustom($this->input->post('adjustment_date'));
        $reason = htmlspecialcharscustom($this->input->post('reason'));

        $response = ['status' => false, 'message' => 'Unable to adjust stock quantity'];

        if ($quantity_plus > 0 && $quantity_minus > 0) {
            $response['message'] = 'Use either plus or minus adjustments';
            echo json_encode($response);
            return;
        }

        if ($quantity_plus <= 0 && $quantity_minus <= 0) {
            $response['message'] = 'Enter quantity to add or remove';
            echo json_encode($response);
            return;
        }

        $net_quantity = $quantity_plus - $quantity_minus;
        if ($net_quantity == 0) {
            $response['message'] = 'Adjustment quantity cannot be zero';
            echo json_encode($response);
            return;
        }

        $purchase_detail = $this->Common_model->getDataById($purchase_detail_id, "tbl_purchase_details");

        if (!$purchase_detail || (int)$purchase_detail->item_id !== $item_id || (int)$purchase_detail->company_id !== (int)$company_id || (int)$purchase_detail->outlet_id !== (int)$outlet_id) {
            $response['message'] = 'Invalid purchase detail selected';
            echo json_encode($response);
            return;
        }

        $this->db->set('quantity_amount', "quantity_amount + ({$net_quantity})", FALSE);
        $this->db->where('id', $purchase_detail_id);
        $this->db->update('tbl_purchase_details');

        $adjustment_type = $net_quantity > 0 ? 'plus' : 'minus';
        if (!empty($adjustment_date_input)) {

            // date selected by user
            $date = date('Y-m-d', strtotime($adjustment_date_input));

            // current server time
            $time = date('H:i:s');

            // merge both
            $stock_in_date = $date . ' ' . $time;

        } else {
            // full current datetime
            $stock_in_date = date('Y-m-d H:i:s');
        }

        $stock_in_data = [
            'company_id' => $company_id,
            'outlet_id' => $outlet_id,
            'item_id' => $item_id,
            'purchase_detail_id' => $purchase_detail_id,
            'added_qty' => abs($net_quantity),
            'adjustment_type' => $adjustment_type,
            'adjustment_date' => $stock_in_date,
            'reason' => $reason,
            'user_id' => $this->session->userdata('user_id'),
            'created_at' => date('Y-m-d H:i:s'),
            'del_status' => 'Live',
        ];

        $this->Common_model->insertInformation($stock_in_data, 'tbl_stock_in');

        $response = ['status' => true, 'message' => 'Stock quantity adjusted successfully'];
        echo json_encode($response);
        return;
    }

    /**
     * addEditOutStock
     * @access public
     * @param string
     * @return void
     */
    public function addEditOutStock($encrypted_id = "") {
        $encrypted_id = $this->input->post('encrypted_id') ? $this->input->post('encrypted_id') : $encrypted_id;
        $id = $this->custom->encrypt_decrypt($encrypted_id, 'decrypt');
        $company_id = $this->session->userdata('company_id');
        $outlet_id = $this->session->userdata('outlet_id');
        $data = [];
        $data['reference_no'] = $this->OutStock_model->generateOutStockRefNo($outlet_id);
        $data['available_items'] = $this->OutStock_model->getAvailablePurchaseDetails($company_id, $outlet_id);
        $data['out_stock_date'] = date('Y-m-d');
        $data['rows'] = [];
        $data['encrypted_id'] = $encrypted_id;

        if ($id) {
            $existing = $this->OutStock_model->getOutStock($id);
            if ($existing) {
                $data['reference_no'] = $existing->reference_id;
                $data['out_stock_date'] = $existing->out_stock_date ?: date('Y-m-d');
                $purchase_detail = $this->Common_model->getDataById($existing->purchase_detail_id, "tbl_purchase_details");
                $available_qty = ($purchase_detail ? $purchase_detail->quantity_amount : 0) + $existing->out_stock_qty;
                $item_label = getItemNameCodeBrandByItemId($existing->item_id);
                $data['rows'][] = [
                    'item_label' => $item_label,
                    'item_id' => $existing->item_id,
                    'purchase_id' => $existing->purchase_id,
                    'purchase_detail_id' => $existing->purchase_detail_id,
                    'out_stock_qty' => $existing->out_stock_qty,
                    'unit_type' => $existing->purchase_unit_name,
                    'available_qty' => $available_qty,
                    'reference' => $existing->reference_id,
                    'out_stock_date' => $existing->out_stock_date,
                ];
            }
        }

        
        if ($this->input->server('REQUEST_METHOD') === 'POST') {
            $reference_no = htmlspecialcharscustom($this->input->post($this->security->xss_clean('reference_no')));
            $out_stock_date = htmlspecialcharscustom($this->input->post($this->security->xss_clean('out_stock_date')));
            $item_ids = $this->input->post('item_id');
            if (!$item_ids || empty($item_ids)) {
                $this->session->set_flashdata('exception_1', 'Please add at least one item to stock out');
                redirect('OutStock/addEditOutStock/' . $encrypted_id);
            }

            $is_edit = $id && isset($existing);
            $rows = [];
            foreach ($item_ids as $index => $item_id) {
                if ($is_edit && $index > 0) {
                    break;
                }
                $rows[] = [
                    'item_id' => $item_id,
                    'purchase_id' => $this->input->post('purchase_id')[$index],
                    'purchase_detail_id' => $this->input->post('purchase_detail_id')[$index],
                    'unit_type' => $this->input->post('unit_type')[$index],
                    'out_stock_qty' => (float)$this->input->post('out_stock_qty')[$index],
                ];
            }

            $error = "";
            $prepared_ops = [];
            foreach ($rows as $row) {
                $purchase_detail = $this->Common_model->getDataById($row['purchase_detail_id'], "tbl_purchase_details");
                
                if (!$purchase_detail && $is_edit) {
                    $purchase_detail = $this->db->select('*')->from('tbl_purchase_details')
                        ->where('id', $row['purchase_detail_id'])
                        ->get()->row();
                }
                if (!$purchase_detail) {
                    $error = 'Invalid purchase detail';
                    break;
                }
                if ($row['out_stock_qty'] <= 0) {
                    $error = 'Quantity must be greater than zero';
                    break;
                }
                $available_qty = $purchase_detail->quantity_amount;
                if ($is_edit && $purchase_detail->id == $existing->purchase_detail_id) {
                    $available_qty += $existing->out_stock_qty;
                }
                if ($available_qty < $row['out_stock_qty']) {
                    $error = 'Requested quantity exceeds available stock';
                    break;
                }
                $prepared_ops[] = $row;
            }

            if ($error) {
                $this->session->set_flashdata('exception_1', $error);
                redirect('OutStock/addEditOutStock/' . $encrypted_id);
            }

            if ($is_edit && !empty($prepared_ops)) {
                $first_row = $prepared_ops[0];
                $adjustment_qty = $existing->out_stock_qty - $first_row['out_stock_qty'];
                if ($adjustment_qty !== 0) {
                    $this->db->set('quantity_amount', "quantity_amount + ({$adjustment_qty})", FALSE);
                    $this->db->where("id", $first_row['purchase_detail_id']);
                    $this->db->update("tbl_purchase_details");
                }
            } else {
                foreach ($prepared_ops as $index => $row) {
                    $this->db->set('quantity_amount', "quantity_amount - {$row['out_stock_qty']}", FALSE);
                    $this->db->where("id", $row['purchase_detail_id']);
                    $this->db->update("tbl_purchase_details");
                }
            }

            $common_data = [
                'reference_id' => $reference_no,
                'out_stock_date' => $out_stock_date,
                'company_id' => $company_id,
                'outlet_id' => $outlet_id,
                'user_id' => $this->session->userdata('user_id'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            if ($is_edit && !empty($prepared_ops)) {
                $first_row = $prepared_ops[0];
                $update_data = array_merge($common_data, [
                    'purchase_id' => $first_row['purchase_id'],
                    'purchase_detail_id' => $first_row['purchase_detail_id'],
                    'item_id' => $first_row['item_id'],
                    'unit_type' => $first_row['unit_type'],
                    'out_stock_qty' => $first_row['out_stock_qty'],
                ]);
                $this->Common_model->updateInformation($update_data, $id, "tbl_out_stock");
                $this->session->set_flashdata('exception', lang('update_success'));
            } else {
                foreach ($prepared_ops as $row) {
                    $save_data = array_merge($common_data, [
                        'purchase_id' => $row['purchase_id'],
                        'purchase_detail_id' => $row['purchase_detail_id'],
                        'item_id' => $row['item_id'],
                        'unit_type' => $row['unit_type'],
                        'out_stock_qty' => $row['out_stock_qty'],
                        'created_at' => date('Y-m-d H:i:s'),
                        'del_status' => 'Live',
                    ]);
                    $this->Common_model->insertInformation($save_data, "tbl_out_stock");
                }
                $this->session->set_flashdata('exception', lang('insertion_success'));
            }

            redirect('OutStock/outStockList');
        }

        $data['main_content'] = $this->load->view('out_stock/addEditOutStock', $data, TRUE);
        $this->load->view('userHome', $data);
    }
}
