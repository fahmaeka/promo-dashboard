<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Promo_rule_period_model extends CI_Model
{
    /*
     * Get data by primary key
     */

    public function get($promo_rule_period_id)
    {
        $query_string = "SELECT * FROM promo_rule_period WHERE promo_rule_period_id = ?";
        $array_data = array($promo_rule_period_id);
        $query = $this->db->query($query_string, $array_data);

        return ($query->num_rows() > 0) ? $query->row() : FALSE;
    }

    /*
     * Get data by promo_rule_id
     */

    public function get_by_promo_rule($promo_rule_id)
    {
        $query_string = "SELECT * FROM promo_rule_period WHERE promo_rule_id = ?";
        $array_data = array($promo_rule_id);
        $query = $this->db->query($query_string, $array_data);

        return ($query->num_rows() > 0) ? $query : FALSE;
    }

    /*
     * Insert data into database
     */

    public function insert($post_data)
    {
        $query_string = "INSERT INTO promo_rule_period (promo_rule_id, promo_rule_start_time, promo_rule_end_time) VALUES(?, ?, ?)";
        $array_data = array(
            $post_data['promo_rule_id'],
            $post_data['promo_rule_start_time'],
            $post_data['promo_rule_end_time']
        );
        $query = $this->db->query($query_string, $array_data);

        return ($query) ? TRUE : FALSE;
    }

    /*
     * Update data into database
     */

    public function update($promo_rule_period_id, $post_data)
    {
        $query_string = "UPDATE promo_rule_period SET promo_rule_id=?, promo_rule_period_start_time=?, promo_rule_period_end_time=? WHERE promo_rule_period_id = ?";
        $array_data = array(
            $post_data['promo_rule_id'],
            $post_data['promo_rule_period_start_time'],
            $post_data['promo_rule_period_end_time'],
            $promo_rule_period_id
        );
        $query = $this->db->query($query_string, $array_data);

        return ($query) ? TRUE : FALSE;
    }

    /*
     * Delete data from database
     */

    public function delete($promo_rule_period_id)
    {
        $query_string = "DELETE FROM promo_rule_period WHERE promo_rule_period_id = ?";
        $array_data = array($promo_rule_period_id);
        $query = $this->db->query($query_string, $array_data);

        return ($query) ? TRUE : FALSE;
    }

    /*
     * Delete data from database
     */

    public function delete_by_promo_rule($promo_rule_id)
    {
        $query_string = "DELETE FROM promo_rule_period WHERE promo_rule_id = ?";
        $array_data = array($promo_rule_id);
        $query = $this->db->query($query_string, $array_data);

        return ($query) ? TRUE : FALSE;
    }

}
