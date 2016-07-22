<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Promo_model extends CI_Model
{
    

    public function get($promo_id)
    {
        $query_string = "SELECT * FROM promo WHERE promo_id = ?";
        $array_data = array($promo_id);
        $query = $this->db->query($query_string, $array_data);

        return ($query->num_rows() > 0) ? $query->row() : FALSE;
    }

    

    public function get_payment_promo_id($promo_id)
    {
        $query_string = "SELECT pp.pg_payment_id, pg.pg_name, py.payment_name FROM promo_payment AS pp JOIN pg_payment AS p ON pp.pg_payment_id = p.pg_payment_id JOIN pg AS pg ON p.pg_id = pg.pg_id JOIN payment AS py ON py.payment_id = p.payment_id WHERE promo_id = ?";
        $array_data = array($promo_id);
        $query = $this->db->query($query_string, $array_data);

        return $query->result_array();
    }

    public function get_id_promo_page($promo_id)
    {
        $query_string = "SELECT promo_id FROM promo WHERE promo_name = ?";
        $array_data = array($promo_id['promo_name']);
        $query = $this->db->query($query_string, $array_data);

        return $query->result_array();
    }

    public function get_payment()
    {
        $query_string = "SELECT pg_payment_id, pg_name, payment_name FROM pg_payment AS pp JOIN payment AS p ON pp.payment_id = p.payment_id JOIN pg AS pg ON pg.pg_id = pp.pg_id WHERE pg_payment_status = 1";
        $query = $this->db->query($query_string);

        return $query->result_array();
    }

    

    public function get_id_payment($data)
    {
        $query_string = "SELECT pg_payment_id, pg_name, payment_name FROM pg_payment AS pp JOIN payment AS p ON pp.payment_id = p.payment_id JOIN pg AS pg ON pg.pg_id = pp.pg_id WHERE pg_payment_status = 1";
        $array_data = array($data);
        $query = $this->db->query($query_string, $array_data);

        return $query->result_array();
    }

    

    public function insert($post_data)
    {
        $current_user = $this->session->userdata('login');
        $query_string = "INSERT INTO promo "
                . "(promo_name, promo_updated_date, promo_updated_by, promo_created_date, promo_created_by, promo_status) "
                . "VALUES (?, ?, ?, ?, ?, ?)";
        $array_data = array(
            $post_data['promo_name'],
            date('Y-m-d H:i:s'),
            $current_user['customer_id'],
            date('Y-m-d H:i:s'),
            $current_user['customer_id'],
            $post_data['promo_status']
        );
        $query = $this->db->query($query_string, $array_data);

        return ($query) ? TRUE : FALSE;
    }

    

    public function insert_payment($promo,$pay)
    {
        $query_string = "INSERT INTO promo_payment "
                . "(promo_id, pg_payment_id) "
                . "VALUES (?, ?)";
        $array_data = array(
            $promo['promo_id'],
            $pay
        );
        $query = $this->db->query($query_string, $array_data);

        return ($query) ? TRUE : FALSE;
    }

    public function insert_payment_update($promo,$pay)
    {
        $query_string = "INSERT INTO promo_payment "
                . "(promo_id, pg_payment_id) "
                . "VALUES (?, ?)";
        $array_data = array(
            $promo,
            $pay
        );
        $query = $this->db->query($query_string, $array_data);

        return ($query) ? TRUE : FALSE;
    }

    

    public function update($post_data)
    {
        $current_user = $this->session->userdata('login');
        $query_string = "UPDATE promo SET promo_name=?, promo_updated_date=?, promo_updated_by=?, promo_status=? WHERE promo_id = ?";
        $array_data = array(
            $post_data['promo_name'],
            date('Y-m-d H:i:s'),
            $current_user['customer_id'],
            $post_data['promo_status'],
            $post_data['promo_id']
        );
        $query = $this->db->query($query_string, $array_data);

        return ($query) ? TRUE : FALSE;
    }


    public function check_foreign_payment($promo_id)
    {
        $query_string = "SELECT promo_id FROM promo_payment WHERE promo_id = ?";
        $array_data = array(
            $promo_id
        );
        $query = $this->db->query($query_string, $array_data);

        if ($query->num_rows() > 0)
        {
            return TRUE;
        }
        return FALSE;
    }

    public function check_foreign_rule($promo_id)
    {
        $query_string = "SELECT promo_id FROM promo_rule WHERE promo_id = ?";
        $array_data = array(
            $promo_id
        );
        $query = $this->db->query($query_string, $array_data);

        if ($query->num_rows() > 0)
        {
            return TRUE;
        }
        return FALSE;
    }


    public function delete_by_promo_id($promo_id)
    {
        $query_string = "DELETE FROM promo_payment WHERE promo_id = ?";
        $array_data = array($promo_id);
        $query = $this->db->query($query_string, $array_data);

        return ($query) ? TRUE : FALSE;
    }



    public function delete($promo_id)
    {
        $query_string = "DELETE FROM promo WHERE promo_id = ?";
        $array_data = array($promo_id);
        $query = $this->db->query($query_string, $array_data);

        return ($query) ? TRUE : FALSE;
    }



    public function dropdown($key = NULL)
    {
        $options = array('' => 'Select');
        $query_string = "SELECT promo_id, promo_name FROM promo WHERE promo_status = 1";
        $query = $this->db->query($query_string);

        foreach ($query->result() as $row)
        {
            if (!is_null($key))
            {
                $options[$row->{$key}] = $row->promo_name;
            }
            else
            {
                $options[$row->promo_id] = $row->promo_name;
            }
        }

        return $options;
    }

    

    public function check_duplicated($data, $promo_id = NULL)
    {
        $query_string = "SELECT promo_name FROM promo WHERE promo_name=?";
        if ( !is_null($promo_id))
        {
            $query_string .= " AND promo_id != '$promo_id'";
        }
        $array_data = array(
            $data['promo_name'],
        );
        $query = $this->db->query($query_string, $array_data);

        return $query->num_rows();
    }
}
