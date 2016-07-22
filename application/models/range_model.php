<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Range_model extends CI_Model
{
    /*
     * Get data by primary key
     */

    public function get($range_id)
    {
        $query_string = "SELECT * FROM `range` WHERE range_id = ?";
        $array_data = array($range_id);
        $query = $this->db->query($query_string, $array_data);

        return ($query->num_rows() > 0) ? $query->row() : FALSE;
    }

    /*
     * Insert data into database
     */

    public function insert($post_data)
    {
        $query_string = "INSERT INTO `range` (range_low_limit, range_high_limit) VALUES(?, ?)";
        $array_data = array(
            $post_data['range_low_limit'],
            $post_data['range_high_limit']
        );
        $query = $this->db->query($query_string, $array_data);

        return ($query) ? TRUE : FALSE;
    }

    /*
     * Update data into database
     */

    public function update($range_id, $post_data)
    {
        $query_string = "UPDATE `range` SET range_low_limit=?, range_high_limit=? WHERE range_id = ?";
        $array_data = array(
            $post_data['range_low_limit'],
            $post_data['range_high_limit'],
            $range_id
        );
        $query = $this->db->query($query_string, $array_data);

        return ($query) ? TRUE : FALSE;
    }

    /*
     * Delete data from database
     */

    public function delete($range_id)
    {
        $query_string = "DELETE FROM `range` WHERE range_id = ?";
        $array_data = array($range_id);
        $query = $this->db->query($query_string, $array_data);

        return ($query) ? TRUE : FALSE;
    }

    /*
     * Check duplicated data
     */

    public function check_duplicated($data, $range_id = NULL)
    {
        $query_string = "SELECT * FROM `range` WHERE range_low_limit = ? AND range_high_limit = ?";
        if ( !is_null($range_id))
        {
            $query_string .= " AND range_id != '$range_id'";
        }
        $array_data = array(
            $data['range_low_limit'],
            $data['range_high_limit']
        );
        $query = $this->db->query($query_string, $array_data);

        return $query->num_rows();
    }

    /*
     * Check foreign key
     */

    public function check_foreign($range_id)
    {
        $query_string_promo_rule_detail = "SELECT range_id FROM promo_rule_detail WHERE range_id = ?";
        $query_string_pg_payment_discount_detail = "SELECT range_id FROM pg_payment_discount_detail WHERE range_id = ?";
        $array_data = array(
            $range_id
        );
        $query_promo_rule = $this->db->query($query_string_promo_rule_detail, $array_data);
        $query_pg_payment_discount = $this->db->query($query_string_pg_payment_discount_detail, $array_data);

        if ($query_promo_rule->num_rows() > 0 OR $query_pg_payment_discount->num_rows() > 0)
        {
            return TRUE;
        }
        return FALSE;
    }

    /*
     * Retrieve and generate a form_dropdown friendly array
     */

    public function dropdown()
    {
        $options = array('' => 'Select Range');
        $query_string = "SELECT * FROM `range`";
        $query = $this->db->query($query_string);

        foreach ($query->result() as $row)
        {
            $options[$row->range_id] = $row->range_low_limit.' - '.$row->range_high_limit;
        }

        return $options;
    }

}
