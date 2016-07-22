<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Rule_model extends CI_Model
{
    /*
     * Get data by primary key
     */

    public function get($rule_id)
    {
        $query_string = "SELECT * FROM rule WHERE rule_id = ?";
        $array_data = array($rule_id);
        $query = $this->db->query($query_string, $array_data);

        return ($query->num_rows() > 0) ? $query->row() : FALSE;
    }

    /*
     * Insert data into database
     */

    public function insert($post_data)
    {
        $query_string = "INSERT INTO rule (rule_name, rule_status) VALUES(?, ?)";
        $array_data = array(
            $post_data['rule_name'],
            $post_data['rule_status']
        );
        $query = $this->db->query($query_string, $array_data);

        return ($query) ? $this->db->insert_id() : FALSE;
    }

    /*
     * Update data into database
     */

    public function update($rule_id, $post_data)
    {
        $query_string = "UPDATE rule SET rule_name=?, rule_status=? WHERE rule_id = ?";
        $array_data = array(
            $post_data['rule_name'],
            $post_data['rule_status'],
            $rule_id
        );
        $query = $this->db->query($query_string, $array_data);

        return ($query) ? TRUE : FALSE;
    }

    /*
     * Delete data from database
     */

    public function delete($rule_id)
    {
        $query_string = "DELETE FROM rule WHERE rule_id = ?";
        $array_data = array($rule_id);
        $query = $this->db->query($query_string, $array_data);

        return ($query) ? TRUE : FALSE;
    }

    /*
     * Check duplicated data
     */

    public function check_duplicated($data, $rule_id = NULL)
    {
        $query_string = "SELECT * FROM rule WHERE rule_name = ? AND rule_status = ?";
        if ( !is_null($rule_id))
        {
            $query_string .= " AND rule_id != '$rule_id'";
        }
        $array_data = array(
            $data['rule_name'],
            $data['rule_status']
        );
        $query = $this->db->query($query_string, $array_data);

        return $query->num_rows();
    }

    /*
     * Check foreign key
     */

    public function check_foreign($rule_id)
    {
        $query_string_promo_rule = "SELECT rule_id FROM promo_rule WHERE rule_id = ?";
        $query_string_rule_attribute = "SELECT rule_id FROM rule_attribute WHERE rule_id = ?";
        $query_string_pg_payment_rule = "SELECT rule_id FROM pg_payment_rule WHERE rule_id = ?";
        $query_string_pg_payment_discount = "SELECT rule_id FROM pg_payment_discount WHERE rule_id = ?";
        $array_data = array(
            $rule_id
        );
        $query_promo_rule = $this->db->query($query_string_promo_rule, $array_data);
        $query_rule_attribute = $this->db->query($query_string_rule_attribute, $array_data);
        $query_pg_payment_rule = $this->db->query($query_string_pg_payment_rule, $array_data);
        $query_pg_payment_discount = $this->db->query($query_string_pg_payment_discount, $array_data);

        if ($query_promo_rule->num_rows() > 0 OR $query_rule_attribute->num_rows() > 0 OR $query_pg_payment_rule->num_rows() > 0 OR $query_pg_payment_discount->num_rows() > 0)
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
        $query_string = "SELECT rule_id, rule_name FROM rule WHERE rule_status = 1";
        $query = $this->db->query($query_string);

        foreach ($query->result() as $row)
        {
            if (!is_null($key))
            {
                $options[$row->{$key}] = $row->rule_name;
            }
            else
            {
                $options[$row->rule_id] = $row->rule_name;
            }
        }

        return $options;
    }

}
