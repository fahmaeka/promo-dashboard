<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Buyingrequest_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * login
     *
     * @return bool
     * */
    public function login($username, $password)
    {
        if (empty($username) || empty($password))
        {
            $this->session->set_flashdata('error_message', error_message('Please enter any username and password.'));
            return FALSE;
        }

        $check_username = $this->check_username($username);

        if ($check_username !== FALSE)
        {
            $customer_id = $check_username->customer_id;
            $check_password = $this->check_password($username, $password);

            if ($check_password !== FALSE)
            {
                $user = $this->get_user($customer_id);
                $check_user_access_to_menu = $this->check_login_access_to_menu($user->customer_type_id);
                if ($check_user_access_to_menu > 0) {
                    $this->session->set_userdata('login', array(
                        'customer_id' => $user->customer_id,
                        'customer_username' => $user->customer_username,
                        'customer_firstname' => $user->customer_firstname,
						'customer_lastname' => $user->customer_lastname,
                        'customer_email' => $user->customer_email,
                        'customer_type_id' => $user->customer_type_id,
                    ));
                    $this->session->set_flashdata('success_message', success_message('Logged in successfully.'));

                    return TRUE;
                }
                else
                {
                    $this->session->set_flashdata('error_message', error_message('You didn\'t have access.'));
                    return FALSE;
                }
            }
            else
            {
                $this->session->set_flashdata('error_message', error_message('Username and Password did not match.'));
                return FALSE;
            }
        }
        else
        {
            $this->session->set_flashdata('error_message', error_message('Username not available.'));
            return FALSE;
        }
    }

    /*
     * Get user by id
     */

    public function get_user($customer_id)
    {
        $query_string = "SELECT customer_id, customer_type_id, customer_username, customer_firstname, customer_lastname, customer_email FROM customer WHERE customer_id = ?";
        $array_data = array($customer_id);
        $query = $this->db->query($query_string, $array_data);

        return ($query->num_rows() == 1) ? $query->row() : FALSE;
    }

    /*
     * Check username
     */

    public function check_username($username)
    {
        $query_string = "SELECT customer_id FROM customer "
                        . "INNER JOIN customer_access ON(customer.customer_type_id = customer_access.customer_type_id) "
                        . "WHERE customer.customer_username = ? AND customer.customer_status=1";
        $array_data = array(
            $username
        );
        $query = $this->db->query($query_string, $array_data);

        return ($query->num_rows() > 0) ? $query->row() : FALSE;
    }

    /*
     * Check password
     */

    public function check_password($username, $password)
    {
        $query_string = "SELECT customer_id FROM customer WHERE customer_username = ? AND customer_password = ?";
        $array_data = array(
            $username,
            md5($password)
        );
        $query = $this->db->query($query_string, $array_data);

        return ($query->num_rows() == 1) ? $query->row() : FALSE;
    }

    /*
     * Check login access to menu
     */

    public function check_login_access_to_menu($customer_type_id)
    {
        $query_string = "SELECT customer_access_id FROM customer_access "
                        . "INNER JOIN menu ON(menu.menu_id = customer_access.menu_id) "
                        . "WHERE customer_access.customer_type_id = ? AND menu.menu_status = 1";
        $array_data = array(
            $customer_type_id
        );
        $query = $this->db->query($query_string, $array_data);
        return $query->num_rows();
    }

    /*
     * Check login access
     */

    public function check_login_access($customer_type_id, $slug)
    {
        $query_string = "SELECT menu.menu_id FROM menu "
                        . "INNER JOIN customer_access ON(menu.menu_id = customer_access.menu_id) "
                        . "WHERE customer_access.customer_type_id = ? AND menu.menu_slug = ?";
        $array_data = array(
            $customer_type_id,
            $slug
        );
        $query = $this->db->query($query_string, $array_data);

        return ($query->num_rows() == 1) ? TRUE : FALSE;
    }
	
	function get_customer_type_by_id($customer_type_id = '')
	{
		$query = "SELECT customer_type_id, customer_type_name FROM customer_type ";
		$values = array();
		if(!empty($customer_type_id))
		{
			$query .= "WHERE customer_type_id = ?";
			$values = array($customer_type_id);
		}
		
		$result = $this->db->query($query, $values);
		return $result->result_array();
	}
	
	public function get_customer_by_id($customer_id)
    {
        $query_string = "SELECT customer_id, c.customer_type_id, customer_username, customer_title, customer_gender, customer_firstname, customer_lastname, customer_dob,
		customer_address, customer_phone, customer_email, customer_type_name, customer_password
		FROM customer c JOIN customer_type ct ON ct.customer_type_id = c.customer_type_id
		WHERE customer_id = ?";
        $array_data = array($customer_id);
        $query = $this->db->query($query_string, $array_data);

        return $query->row_array();
    }
	
	public function update_customer_by_id($post, $customer_id)
    {
        $query_string = "UPDATE customer SET 
		customer_title = ?, 
		customer_gender = ?, 
		customer_firstname = ?, 
		customer_lastname = ?, 
		customer_dob = ?,
		customer_address = ?, 
		customer_phone = ?, 
		customer_email = ? ";
        $array_data = array($post['customer_title'], $post['customer_gender'], $post['customer_firstname'], $post['customer_lastname'], 
		$post['customer_dob'], $post['customer_address'], $post['customer_phone'], $post['customer_email']);
		/* if(!empty($post['customer_password']))
		{
			$query_string .= ",customer_password = ? ";
			array_push($array_data, md5($post['customer_password']));
		} */
		$query_string .= "WHERE customer_id = ?";
		array_push($array_data, $customer_id);

        $query = $this->db->query($query_string, $array_data);
    }
	
	public function update_change_password($post, $customer_id)
    {
        $query_string = "UPDATE customer SET 
		customer_password = ? ";
        $array_data = array(md5($post['new_password']));
		
		$query_string .= "WHERE customer_id = ?";
		array_push($array_data, $customer_id);

        $query = $this->db->query($query_string, $array_data);
    }

}
