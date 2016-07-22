<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Action_model extends CI_Model
{
    /*
     * Get user action by menu
     */

    public function get_user_action_by_menu($menu_id, $customer_type_id)
    {
        $sql = "SELECT action_value FROM action AS ac 
                JOIN customer_action AS ca ON ac.action_id = ca.action_id 
                WHERE menu_id = ? AND customer_type_id = ? ORDER BY action_precedence ASC";

        $query = $this->db->query($sql, array($menu_id, $customer_type_id));

        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
    
    public function check_user_action_access($action_id, $customer_type_id)
    {
        $sql = 'SELECT customer_action_id FROM customer_action WHERE action_id = ? AND customer_type_id = ?';
        
        $query = $this->db->query($sql, array($action_id, $customer_type_id));
        
        return ($query->num_rows() > 0) ? TRUE : FALSE;
    }
    
    public function show_log($param)
    {
        $action = '<li>
                        <a href="#" class="show_transaction_log" data-toggle="modal" data-target="#transaction_log_modal" data_id="'.$param['transaction_detail_id'].'" transaction_payment_id="'.$param['transaction_payment_id'].'">Show Log</a>
                    </li>';
                    
        return $action;
    }
    
    public function show_detail($param)
    {
        $action = '<li>
                        <a href="#" class="show_transaction_detail" data-toggle="modal" data-target="#transaction_detail_modal" data_id="'.$param['transaction_detail_id'].'">Show Detail</a>
                    </li>';
                    
        return $action;
    }
    
    public function input_invoice($param)
    {
        //if invoice number empty add action input invoice number
        if($param['invoice_status_id'] == 13 || $param['invoice_status_id'] == 14)
        {
            $action = '<li>
                                <a href="#" class="input_invoice" data-toggle="modal" data-target="#input_invoice_modal" data_id="'.$param['transaction_detail_id'].'">Input Invoice</a>
                            </li>';
        }
        else
        {
            $action = '';
        }
        
        return $action;
    }
    
    public function void_invoice($param)
    {
        if($param['invoice_status_id'] == 17)
        {
            //add void action
            $action = '<li>
                        <a href="#" class="void_invoice" data-toggle="modal" data-target="#void_invoice_modal" data_id="'.$param['transaction_detail_id'].'">Void Invoice</a>
                    </li>';
        }
        else
        {
            $action = '';
        }
        
        return $action;
    }
    
    public function settle_invoice($param)
    {
        if($param['invoice_status_id'] == 17)
        {
            //add settle action
            $action = '<li>
                                <a href="#" class="settle_invoice" data-toggle="modal" data-target="#settle_invoice_modal" data_id="'.$param['transaction_detail_id'].'">Settle Invoice</a>
                            </li>';
        }
        else
        {
            $action = '';
        }
        
        return $action;
    }
    
    public function send_email_booking($param)
    {
        //only available when status pending = 1
        if($param['transaction_status_id'] == 1)
        {
            $action = '<li>
                                        <a href="#" class="send_email_booking" data-toggle="modal" data-target="#send_email_booking_modal" data_id="'.$param['transaction_id'].'">Send Email Booking</a>
                                    </li>';
        }
        else
        {
            $action = '';
        }
        
        return $action;
    }
    
    public function send_email_confirmation($param)
    {
        //only available when status confirmed = 3
        if($param['transaction_status_id'] == 3)
        {
            $action = '<li>
                                            <a href="#" class="send_email_confirmation" data-toggle="modal" data-target="#send_email_confirmation_modal" data_id="'.$param['transaction_id'].'">Send Email Confirmation</a>
                                        </li>';
        }
        else
        {
            $action = '';
        }
        
        return $action;
    }
    
    public function refund($param)
    {
        //only available when status confirmed = 3, failed booking 9, failed issued 12
        if($param['transaction_status_id'] == 3 || $param['transaction_status_id'] == 9 || $param['transaction_status_id'] == 12)
        {
            $action = '<li>
                    <a href="#" class="refund" data-toggle="modal" data-target="#refund_modal" data_id="'.$param['transaction_detail_id'].'">Refund</a>
                </li>';
        }
        else
        {
            $action = '';
        }
        
        return $action;
    }
    
    public function refunded($param)
    {
        //only available when status refund
        if($param['transaction_status_id'] == 15)
        {
            $action = '<li>
                    <a href="#" class="refunded" data-toggle="modal" data-target="#refunded_modal" data_id="'.$param['transaction_detail_id'].'">Refunded</a>
                </li>';
        }
        else
        {
            $action = '';
        }
        
        return $action;
    }
    
    public function manage_transfer($param)
    {
        if($param['payment_status_id'] == 8)
        {
            $action = '<li>
                        <a href="#" class="manage_transfer" data-toggle="modal" data-target="#manage_transfer_modal" data_id="'.$param['transaction_payment_id'].'" pg_payment_id = "'.$param['pg_payment_id'].'">Manage Transfer</a>
                    </li>';
        }
        else
        {
            $action = '';
        }
        
        return $action;
    }
    
    public function change_timelimit($param)
    {
        //set max timelimit = 15 minutes before supplier timelimit
        $max_timelimit = date('Y-m-d H:i:s',strtotime($param['transaction_payment_timelimit_supplier'].'-15 minutes'));
        
        //can only update timelimit if status pending
        if($param['transaction_payment_timelimit'] <= $max_timelimit && ($param['transaction_status_id'] == 1 || $param['transaction_status_id'] == 11) && $max_timelimit > date('Y-m-d H:i:s'))
        {
            $action = '<li>
                            <a href="#" class="change_timelimit" data-toggle="modal" data-target="#change_timelimit_modal" data_id="'.$param['transaction_payment_id'].'" data_transaction_detail_id = "'.$param['transaction_detail_id'].'" data_timelimit_supplier="'.$param['transaction_payment_timelimit_supplier'].'">Change Time Limit</a>
                        </li>';
        }
        else
        {
            $action = '';
        }
        
        return $action;
    }
    
    public function confirm_flight($param)
    {
        if($param['payment_status_id'] == 6 && $param['transaction_status_id'] == 1 && $param['product_id'] == 2)
        {
            $action = '<li>
                        <a href="#" class="confirm_flight" data-toggle="modal" data-target="#confirm_flight_modal" data_id="'.$param['transaction_detail_id'].'">Confirm Flight</a>
                    </li>';
        }
        else
        {
            $action = '';
        }
        
        return $action;
    }
    
    public function payment_url($param)
    {
        if($param['payment_status_id'] == 19)
        {
            $action = '<li>
                        <a href="'.APPS_SECURE_PATH.'checkout/payment/'.$param['transaction_reference'].'" target="_blank">Payment URL</a>
                    </li>';
        }
        else
        {
            $action = '';
        }
        
        return $action;
    }
	
	public function doku($param)
    {
        if($param['payment_status_id'] == 19)
        {
            $action = '<li>
                            <a href="#" class="doku" data-toggle="modal" data-target="#doku_modal" data_id="'.$param['transaction_payment_id'].'">Check Transaction Doku</a>
                        </li>';
        }
        else
        {
            $action = '';
        }
        
        return $action;
    }
    
    public function finish_url($param)
    {
        if($param['transaction_status_id'] == 3)
        {
            $action = '<li>
                         <a href="'.APPS_SECURE_PATH.'checkout/finish/'.$param['transaction_reference'].'" target="_blank">Finish URL</a>
                    </li>';
        }
        else
        {
            $action = '';
        }
        
        return $action;
    }
}
