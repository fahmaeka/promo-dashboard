<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{
    /*
     * Get data by primary key
     */

    public function get($customer_id)
    {
        $select_field = "customer_id, customer_type_id, customer_username, customer_email, customer_status";
        $query_string = "SELECT $select_field FROM customer WHERE customer_id = ?";
        $array_data = array($customer_id);
        $query = $this->db->query($query_string, $array_data);

        return ($query->num_rows() > 0) ? $query->row() : FALSE;
    }

    /*
     * Insert data into database
     */

    public function insert($post_data)
    {
        $fields = "customer_type_id, customer_username, customer_password, customer_email, customer_status";
        $query_string = "INSERT INTO customer ($fields) VALUES(?,?,?,?,?)";
        $array_data = array(
            $post_data['customer_type_id'],
            $post_data['customer_username'],
            md5($post_data['customer_password']),
            $post_data['customer_email'],
            $post_data['customer_status']
        );
        $query = $this->db->query($query_string, $array_data);

        return ($query) ? TRUE : FALSE;
    }

    /*
     * Update data into database
     */

    public function update($customer_id, $post_data)
    {
        //$fields = "customer_type_id=?, customer_username=?, customer_email=?, customer_status=?";
        $fields = "customer_type_id=?, customer_email=?, customer_status=?";
        if (isset($post_data['customer_password']) && $post_data['customer_password'] != '') {
            $fields .= ", customer_password='".md5($post_data['customer_password'])."'";
        }
        $array_data = array(
            $post_data['customer_type_id'],
            //$post_data['customer_username'],
            $post_data['customer_email'],
            $post_data['customer_status'],
            $customer_id
        );
        $query_string = "UPDATE customer SET $fields WHERE customer_id = ?";
        $query = $this->db->query($query_string, $array_data);

        return ($query) ? TRUE : FALSE;
    }

    /*
     * Delete data from database
     */

    public function delete($customer_id)
    {
        $query_string = "DELETE FROM customer WHERE customer_id = ?";
        $array_data = array($customer_id);
        $query = $this->db->query($query_string, $array_data);

        return ($query) ? TRUE : FALSE;
    }

    /*
     * Check duplicated data
     */

    public function check_duplicated($data, $customer_id = NULL)
    {
        $query_string = "SELECT customer_id FROM customer WHERE customer_username = ?";
        if ( !is_null($customer_id))
        {
            $query_string .= " AND customer_id != '$customer_id'";
        }
        $array_data = array(
            $data['customer_username']
        );
        $query = $this->db->query($query_string, $array_data);

        return $query->num_rows();
    }

    /*
     * Retrieve and generate a form_dropdown friendly array
     */

    public function dropdown()
    {
        $options = array('' => 'Select');
        $query_string = "SELECT customer_id, customer_name FROM customer";
        $query = $this->db->query($query_string);

        foreach ($query->result() as $row)
        {
            $options[$row->customer_id] = $row->customer_name;
        }

        return $options;
    }

    /*
     * Delete sessions
     */

    public function delete_session($customer_id)
    {
        $id_length = strlen($customer_id);
        $identifier = '"customer_id";s:'.$id_length.':"'.$customer_id.'"';
        $query_string = 'DELETE FROM sessions WHERE user_data LIKE "%'.addslashes($identifier).'%"';
        $query = $this->db->query($query_string);

        return ($query) ? TRUE : FALSE;
    }

}
