<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_access_model extends CI_Model
{
    /*
     * Get data by primary key
     */

    public function get($customer_access_id)
    {
        $query_string = "SELECT customer_access_id, customer_type_id, menu_id FROM customer_access WHERE customer_access_id = ?";
        $array_data = array($customer_access_id);
        $query = $this->db->query($query_string, $array_data);

        return ($query->num_rows() > 0) ? $query->row() : FALSE;
    }

    /*
     * Get data by customer_type_id
     */

    public function get_by_customer_type($customer_type_id)
    {
        $query_string = "SELECT customer_access_id, customer_type_id, menu_id FROM customer_access WHERE customer_type_id = ?";
        $array_data = array($customer_type_id);
        $query = $this->db->query($query_string, $array_data);

        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

    /*
     * Insert data into database
     */

    public function insert($post_data)
    {
        $query_string = "INSERT INTO customer_access (customer_type_id, menu_id) VALUES(?,?)";
        $array_data = array(
            $post_data['customer_type_id'],
            $post_data['menu_id']
        );
        $query = $this->db->query($query_string, $array_data);

        return ($query) ? TRUE : FALSE;
    }

    /*
     * Update data into database
     */

    public function update($customer_access_id, $post_data)
    {
        $query_string = "UPDATE customer_access SET customer_type_id=?, menu_id=? WHERE customer_access_id=?";
        $array_data = array(
            $post_data['customer_type_id'],
            $post_data['menu_id'],
            $customer_access_id
        );
        $query = $this->db->query($query_string, $array_data);

        return ($query) ? TRUE : FALSE;
    }

    /*
     * Delete data from database
     */

    public function delete($customer_access_id)
    {
        $query_string = "DELETE FROM customer_access WHERE customer_access_id = ?";
        $array_data = array($customer_access_id);
        $query = $this->db->query($query_string, $array_data);

        return ($query) ? TRUE : FALSE;
    }

    /*
     * Delete data from database
     */

    public function delete_by_customer_type($customer_type_id)
    {
        $query_string = "DELETE FROM customer_access WHERE customer_type_id = ?";
        $array_data = array($customer_type_id);
        $query = $this->db->query($query_string, $array_data);

        return ($query) ? TRUE : FALSE;
    }
}
