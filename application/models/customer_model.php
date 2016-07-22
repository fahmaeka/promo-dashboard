<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * Class to utilize customer(*) tables
 *
 * @package     CodeIgniter
 * @author      Romdoni Agung Purbayanto <donnydiunindra@gmail.com>
 */
class Customer_model extends CI_Model
{

	public function __construct() 
	{
		parent:: __construct();
	}

	/* Added By Yosia */
	
	/*
	* function to validate customer by username only
	*
	* @param array
	* @return array
	*/
	public function validate_username($post)
	{
        $sql = "SELECT 
        			customer_id,
					customer_username,
        			customer_firstname, 
        			customer_lastname, 
        			customer_address, 
        			customer_phone, 
        			customer_email 
        		FROM customer 
        		WHERE customer_username = ? AND customer_status = 1";
        $q = $this->db->query($sql, array($post['username']));
        
        return $q->result_array();
	}
	
	/*
	* function to validate customer by username and password
	*
	* @param array
	* @return array
	*/
	public function validate_login($post)
	{
        $sql = "SELECT 
        			customer_id,
					customer_username,
        			customer_firstname, 
        			customer_lastname, 
        			customer_address, 
        			customer_phone, 
        			customer_email 
        		FROM customer 
        		WHERE customer_username = ? AND customer_password = ? AND customer_status = 1";
        $q = $this->db->query($sql, array($post['username'], $post['password']));
        
        return $q->result_array();
	}
	
	/*
	* function to get customer detail by customer id
	*
	* @param array
	* @return array
	*/
	public function get_customer_detail($customer_id)
	{
        $sql = "SELECT 
        			customer_id,
					customer_username,
					customer_title,
					customer_gender,
        			customer_firstname, 
        			customer_lastname, 
					customer_dob,	
        			customer_address, 
        			customer_phone, 
        			customer_email,
					customer_created_date
        		FROM customer 
        		WHERE customer_id = ? AND customer_status = 1";
        $q = $this->db->query($sql, array($customer_id));
        
        return $q->result_array()[0];
	}
	
	/*
	* function to update profile in my account
	*
	* @param array
	* @return boolean
	*/
	
	public function update_profile($post, $customer_id)
	{
        $sql = "UPDATE customer
				SET
					customer_title = ?,
					customer_gender = ?,
					customer_firstname = ?,
					customer_lastname = ?,
					customer_dob = ?,
					customer_phone = ?
        		WHERE customer_id = ?";
        $q = $this->db->query($sql, array($post['title'], $post['gender'],$post['first_name'],$post['last_name'],$post['dob'],$post['phone'], $customer_id));
		
		return $q;
	}
	
	/*
	* function to check password if it's correct
	*
	* @param array
	* @return boolean
	*/
	
	function check_password_profile($password, $customer_id)
    {
        $sql = "
			SELECT customer_id 
			FROM customer
			WHERE customer_password = ? and customer_id = ?
		";
		
		$result = $this->db->query($sql, array($password, $customer_id))->result_array();
		
        if(count($result) == 1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
	
	
	/*
	* function to check if reference code is existed in database
	*
	* @param string
	* @return boolean / array
	*/
	
	public function check_tokenkey($customer_tokenkey)
    {
        $sql = "
			SELECT
				customer_tokenkey, customer_email, customer_password
			FROM
				customer
			WHERE 
				customer_tokenkey = ?
		";
		
		$result = $this->db->query($sql, array($customer_tokenkey))->result_array();
		
		return $result;
    }
	
	/*
	* function to check if email is existed (for Forgot Password)
	*
	* @param string
	* @return boolean / array
	*/
	
	public function check_email($customer_email)
    {
        $sql = "
			SELECT
				customer_email
			FROM
				customer
			WHERE 
				customer_email LIKE ? 
		";
		
		$result = $this->db->query($sql, array($customer_email))->row_array();
		
		return $result;
    }
	
	/*
	* function to check if email is existed and active/inactive in database (for Forgot Password)
	* Status : 1 = Active, 0 = Inactive
	*
	* @param string
	* @return boolean / array
	*/
	
	public function check_email_with_condition($customer_email, $status = '')
    {
        $sql = "
			SELECT
				customer_email
			FROM
				customer
			WHERE 
				customer_email LIKE ? 
				AND customer_status = ?
		";
		
		$result = $this->db->query($sql, array($customer_email, $status))->row_array();
		
		return $result;
    }
	
	/* Added By Yosia */
	
	function check_registration($email)
    {
        $sql = "SELECT customer_id, customer_email, customer_status FROM customer WHERE customer_email = ?";
        $query = $this->db->query($sql, array($email))->result_array();
        
        if(!empty($query))
        {
            return $query[0];
        }
        else
        {
            return FALSE;
        }
    }
	
	function update_token_key($email, $tokenkey)
    {
        $sql = "UPDATE customer SET customer_tokenkey = ? WHERE customer_email = ?";
		$this->db->query($sql, array($tokenkey, $email));
    }

	function insert_customer($email, $password, $title, $first_name, $last_name, $dob, $phone, $tokenkey)
    {
        //check gender
        $gender = $this->functions->check_gender_by_title($title);
        
        $sql='INSERT INTO customer 
        (customer_type_id, customer_username, customer_password, customer_title, customer_gender, customer_firstname, customer_lastname, customer_dob, customer_phone, customer_email, customer_tokenkey, customer_status)
        VALUES
        (?,?,?,?,?,?,?,?,?,?,?,?)';
        $this->db->query($sql, array(1, $email, $password, $title, $gender, $first_name, $last_name, $dob, $phone, $email, $tokenkey, 0));
        
        $customer_id = $this->db->insert_id();
        
        return $customer_id;
    }
	
	function check_activation_key($activation_key)
    {
        $field = "SELECT customer_id, customer_email, customer_password, customer_status FROM customer WHERE customer_tokenkey = ?";
        $array_insert = array($activation_key);
        $result = $this->db->query($field, $array_insert);

        return $result->row_array();
    }
	
    function activate_email($activation_key)
    {
        $table = "UPDATE customer SET customer_status = 1 WHERE customer_tokenkey = ?";
		$array = array($activation_key);
		$this->db->query($table, $array);
    }

}