<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_type_model extends CI_Model
{
    /*
     * Get data by primary key
     */

    public function get($customer_type_id)
    {
        $query_string = "SELECT * FROM customer_type WHERE customer_type_id = ?";
        $array_data = array($customer_type_id);
        $query = $this->db->query($query_string, $array_data);

        return ($query->num_rows() > 0) ? $query->row() : FALSE;
    }

    /*
     * Insert data into database
     */

    public function insert($post_data)
    {
        $query_string = "INSERT INTO customer_type (customer_type_name) VALUES(?)";
        $array_data = array($post_data['customer_type_name']);
        $query = $this->db->query($query_string, $array_data);

        return ($query) ? $this->db->insert_id() : FALSE;
    }

    /*
     * Update data into database
     */

    public function update($customer_type_id, $post_data)
    {
        $query_string = "UPDATE customer_type SET customer_type_name = ? WHERE customer_type_id = ?";
        $array_data = array(
            $post_data['customer_type_name'],
            $customer_type_id
        );
        $query = $this->db->query($query_string, $array_data);

        return ($query) ? TRUE : FALSE;
    }

    /*
     * Delete data from database
     */

    public function delete($customer_type_id)
    {
        $query_string = "DELETE FROM customer_type WHERE customer_type_id = ?";
        $array_data = array($customer_type_id);
        $query = $this->db->query($query_string, $array_data);

        return ($query) ? TRUE : FALSE;
    }

    /*
     * Check duplicated data
     */

    public function check_duplicated($data, $customer_type_id = NULL)
    {
        $query_string = "SELECT customer_type_id FROM customer_type WHERE customer_type_name = ?";
        if ( !is_null($customer_type_id))
        {
            $query_string .= " AND customer_type_id != '$customer_type_id'";
        }
        $array_data = array(
            $data['customer_type_name']
        );
        $query = $this->db->query($query_string, $array_data);

        return $query->num_rows();
    }

    /*
     * Check foreign key
     */

    public function check_foreign($customer_type_id)
    {
        $query_string = "SELECT customer_type_id FROM customer WHERE customer_type_id = ?";
        $array_data = array(
            $customer_type_id
        );
        $query = $this->db->query($query_string, $array_data);

        if ($query->num_rows > 0)
        {
            return TRUE;
        }
        return FALSE;
    }

    /*
     * Retrieve and generate a form_dropdown friendly array
     */

    public function dropdown($key = NULL)
    {
        $options = array('' => 'Select');
        $query_string = "SELECT customer_type_id, customer_type_name FROM customer_type";
        $query = $this->db->query($query_string);

        foreach ($query->result() as $row)
        {
            if (!is_null($key))
            {
                $options[$row->{$key}] = $row->customer_type_name;
            }
            else
            {
                $options[$row->customer_type_id] = $row->customer_type_name;
            }
        }

        return $options;
    }

}
