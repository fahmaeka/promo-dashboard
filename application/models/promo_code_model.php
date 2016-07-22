<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Promo_code_model extends CI_Model
{
    /*
     * Get data by primary key
     */

    public function get($promo_code_id)
    {
        $fields = "promo_code_id, promo_id,promo_code_value, promo_code_count, promo_code_max_count, promo_code_start_date, promo_code_expired, promo_code_updated_date, promo_code_updated_by, promo_code_created_date, promo_code_created_by";
        $query_string = "SELECT $fields FROM promo_code WHERE promo_code_id = ?";
        $array_data = array($promo_code_id);
        $query = $this->db->query($query_string, $array_data);

        return ($query->num_rows() > 0) ? $query->row() : FALSE;
    }

    /*
     * Get data by promo_rule_id
     */

    public function get_by_promo_rule($promo_rule_id)
    {
        $fields = "promo_code_id, promo_rule_id, customer_id, promo_code_value, promo_code_count, promo_code_max_count, promo_code_updated_date, promo_code_updated_by, promo_code_created_date, promo_code_created_by";
        $query_string = "SELECT $fields FROM promo_code WHERE promo_rule_id = ?";
        $array_data = array($promo_rule_id);
        $query = $this->db->query($query_string, $array_data);

        return ($query->num_rows() > 0) ? $query : FALSE;
    }

    /*
     * Insert data into database
     */

    public function insert($post_data)
    {
        $fields = "promo_id, promo_code_value, promo_code_count, promo_code_max_count, promo_code_start_date, promo_code_expired, promo_code_updated_date, promo_code_updated_by, promo_code_created_date, promo_code_created_by";
        $query_string = "INSERT INTO promo_code ($fields) VALUES(?,?,?,?,?,?,?,?,?,?)";
        $array_data = array(
            $post_data['promo_id'],
            $post_data['promo_code_prefix'],
            $post_data['promo_code_count'],
            $post_data['promo_code_max_count'],
            $post_data['promo_code_start_date'],
            $post_data['promo_code_expired'],
            date('Y-m-d H:i:s'),
            $post_data['promo_code_updated_by'],
            date('Y-m-d H:i:s'),
            $post_data['promo_code_created_by']
        );
        $query = $this->db->query($query_string, $array_data);

        return ($query) ? TRUE : FALSE;
    }

    /*
     * Update data into database
     */

    public function update($promo_code_id, $post_data)
    {
        $fields = "promo_id=?, promo_code_value=?, promo_code_max_count=?, promo_code_start_date=?, promo_code_expired=?, promo_code_updated_date=?, promo_code_updated_by=?";
        $query_string = "UPDATE promo_code SET $fields WHERE promo_code_id = ?";
        $array_data = array(
            $post_data['promo_id'],
            $post_data['promo_code_prefix'],
            $post_data['promo_code_max_count'],
            $post_data['promo_code_start_date'],
            $post_data['promo_code_expired'],
            date('Y-m-d H:i:s'),
            $post_data['promo_code_updated_by'],
            $promo_code_id
        );
        $query = $this->db->query($query_string, $array_data);

        return ($query) ? TRUE : FALSE;
    }

    /*
     * Delete data from database
     */

    public function delete($promo_code_id)
    {
        $query_string = "DELETE FROM promo_code WHERE promo_code_id = ?";
        $array_data = array($promo_code_id);
        $query = $this->db->query($query_string, $array_data);

        return ($query) ? TRUE : FALSE;
    }

    /*
     * Delete data from database
     */

    public function delete_by_promo_rule($promo_rule_id)
    {
        $query_string = "DELETE FROM promo_code WHERE promo_rule_id = ?";
        $array_data = array($promo_rule_id);
        $query = $this->db->query($query_string, $array_data);

        return ($query) ? TRUE : FALSE;
    }

    /*
     * Check duplicated data
     */

    public function check_duplicated($data)
    {
        $query_string = "SELECT promo_code_value FROM promo_code WHERE promo_code_value = ?";
        $array_data = array(
            $data['promo_code_prefix']
        );
        $query = $this->db->query($query_string, $array_data);

        return $query->num_rows();
    }
    

    public function check_count($data)
    {
        $query_string = "SELECT promo_code_count FROM promo_code WHERE promo_code_count = ?";
        $array_data = array(
            $data['promo_code_count']
        );
        $query = $this->db->query($query_string, $array_data);

        return $query->num_rows();
    }

}
