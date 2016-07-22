<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Promo_rule_model extends CI_Model
{
    
    public function get($promo_rule_id)
    {
        $query_string = "SELECT * FROM promo_rule WHERE promo_rule_id = ?";
        $array_data = array($promo_rule_id);
        $query = $this->db->query($query_string, $array_data);

        return ($query->num_rows() > 0) ? $query->row() : FALSE;
    }

    public function getrule($promo_rule_id)
    {
        $query_string = "SELECT * FROM promo_rule WHERE rule_id = ?";
        $array_data = array($promo_rule_id);
        $query = $this->db->query($query_string, $array_data);

        return ($query->num_rows() > 0) ? $query->row() : FALSE;
    }

    public function get_id_rule($promo_rule_id)
    {
        $query_string = "SELECT rule_id, promo_id FROM promo_rule WHERE promo_id = ?";
        $array_data = array($promo_rule_id);
        $query = $this->db->query($query_string, $array_data);

        return ($query->num_rows() > 0) ? $query->row() : FALSE;
    }

    public function get_id_rule_delete($promo_rule_id)
    {
        $query_string = "SELECT promo_rule_id FROM promo_rule WHERE promo_rule_id = ?";
        $array_data = array($promo_rule_id);
        $query = $this->db->query($query_string, $array_data);

        return ($query->num_rows() > 0) ? $query->row() : FALSE;
    }

    public function get_rule($promo_rule_id)
    {
        $query_string = "SELECT promo_rule_id FROM promo_rule WHERE rule_id = ?";
        $array_data = array($promo_rule_id['rule_id']);
        $query = $this->db->query($query_string, $array_data);

        return ($query->num_rows() > 0) ? $query->row() : FALSE;
    }

    public function get_by_promo_rule($promo_rule_id)
    {
        $query_string = "SELECT pr.promo_rule_id, rule_id, promo_id, prd.range_id, prd.promo_rule_detail_fixed_value, prd.promo_rule_detail_percent, prd.promo_rule_detail_max_value,prd.promo_rule_detail_id 
        FROM promo_rule AS pr JOIN promo_rule_detail AS prd ON prd.promo_rule_id = pr.promo_rule_id 
        WHERE pr.promo_rule_id = ?";
        $array_data = array($promo_rule_id);
        $query = $this->db->query($query_string, $array_data);

        return ($query->num_rows() > 0) ? $query : FALSE;
    }

    
    public function insert($post_data)
    {
        $current_user = $this->session->userdata('login');
        $fields = "rule_id, promo_id, promo_rule_updated_date, promo_rule_updated_by, promo_rule_created_date, promo_rule_created_by, promo_rule_status";
        $query_string = "INSERT INTO promo_rule ($fields) VALUES(?,?,?,?,?,?,?)";
        $array_data = array(
            $post_data['rule_id'],
            $post_data['promo_id'],
            date('Y-m-d H:i:s'),
            $current_user['customer_id'],
            date('Y-m-d H:i:s'),
            $current_user['customer_id'],
            $post_data['promo_rule_status']
        );
        $query = $this->db->query($query_string, $array_data);

        return ($query) ? $this->db->insert_id() : FALSE;
    }

    public function insert_rule_detail($post_data)
    {
        $query_string = "INSERT INTO promo_rule_detail (promo_rule_id, range_id, promo_rule_detail_fixed_value, promo_rule_detail_percent, promo_rule_detail_max_value) VALUES(?, ?, ?, ?, ?)";
        $array_data = array(
            $post_data['promo_rule_id'],
            $post_data['range_id'],
            $post_data['promo_rule_detail_fixed_value'],
            $post_data['promo_rule_detail_percent'],
            $post_data['promo_rule_detail_max_value']
        );
        $query = $this->db->query($query_string, $array_data);

        return ($query) ? TRUE : FALSE;
    }

    public function update_rule_detail($post_data, $post)
    {
        $fields = "promo_rule_id=?, range_id=?, promo_rule_detail_fixed_value=?, promo_rule_detail_percent=?, promo_rule_detail_max_value=?";
        $query_string = "UPDATE promo_rule_detail SET $fields WHERE promo_rule_detail_id = ?";
        $array_data = array(
            $post_data['promo_rule_id'],
            $post_data['range_id'],
            $post_data['promo_rule_detail_fixed_value'],
            $post_data['promo_rule_detail_percent'],
            $post_data['promo_rule_detail_max_value'],
            $post['promo_rule_detail_id']
        );
        $query = $this->db->query($query_string, $array_data);

        return ($query) ? TRUE : FALSE;
    }

    
    public function update($post_data)
    {
        $current_user = $this->session->userdata('login');
        $fields = "rule_id=?, promo_id=?, promo_rule_updated_date=?, promo_rule_updated_by=?, promo_rule_status=?";
        $query_string = "UPDATE promo_rule SET $fields WHERE promo_rule_id = ?";
        $array_data = array(
            $post_data['rule_id'],
            $post_data['promo_id'],
            date('Y-m-d H:i:s'),
            $current_user['customer_id'],
            $post_data['promo_rule_status'],
            $post_data['promo_rule_id']
        );
        $query = $this->db->query($query_string, $array_data);

        //return ($query) ? TRUE : FALSE;

        return ($query) ? $this->db->insert_id() : FALSE;
    }
    

    public function delete($promo_rule_id)
    {
        $query_string = "DELETE FROM promo_rule WHERE promo_rule_id = ?";
        $array_data = array($promo_rule_id);
        $query = $this->db->query($query_string, $array_data);

        return ($query) ? TRUE : FALSE;
    }

    public function delete_after_duplicated($data)
    {
        $query_string = "DELETE FROM promo_rule WHERE promo_rule_id = ?";
        $array_data = array($data['promo_rule_id']);
        $query = $this->db->query($query_string, $array_data);

        return ($query) ? TRUE : FALSE;
    }

    public function delete_insert_duplicated($data)
    {
        $query_string = "DELETE FROM promo_rule_detail WHERE promo_rule_id = ?";
        $array_data = array($data['promo_rule_id']);
        $query = $this->db->query($query_string, $array_data);

        return ($query) ? TRUE : FALSE;
    }

    public function delete_by_promo_rule($promo_rule_id)
    {
        $query_string = "DELETE FROM promo_rule_detail WHERE promo_rule_id = ?";
        $array_data = array($promo_rule_id);
        $query = $this->db->query($query_string, $array_data);

        return ($query) ? TRUE : FALSE;
    }

    /*
     * Check duplicated data
     */

    public function check_duplicated($data, $range)
    {
        $query_string = "SELECT * FROM promo_rule AS r JOIN promo_rule_detail AS pd ON r.promo_rule_id=pd.promo_rule_id WHERE promo_id=? AND rule_id=? AND range_id=?";
        
        $array_data = array(
            $data['promo_id'],
            $data['rule_id'],
            $range['range_id']
        );
        $query = $this->db->query($query_string, $array_data);

        return $query->num_rows();
    }

    public function check_promo_range($range)
    {
        $query_string = "SELECT * FROM promo_rule_detail WHERE promo_rule_id=? AND range_id=?";
        
        $array_data = array(
            $range['promo_rule_id'],
            $range['range_id']
        );
        $query = $this->db->query($query_string, $array_data);

        return $query->num_rows();
    }

    /*
     * Check foreign key
     */

    public function check_foreign($promo_rule_id)
    {
        $query_string = "SELECT promo_rule_id FROM promo_rule WHERE promo_rule_id = ?";
        $array_data = array(
            $promo_rule_id
        );
        $query = $this->db->query($query_string, $array_data);

        if ($query->num_rows() > 0)
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
        $query_string = "SELECT pr.promo_rule_id, p.promo_name FROM promo_rule AS pr JOIN promo AS p ON pr.promo_id=p.promo_id";
        $query = $this->db->query($query_string);

        foreach ($query->result() as $row)
        {
            if (!is_null($key))
            {
                $options[$row->{$key}] = $row->promo_name;
            }
            else
            {
                $options[$row->promo_rule_id] = $row->promo_name;
            }
        }

        return $options;
    }
}
