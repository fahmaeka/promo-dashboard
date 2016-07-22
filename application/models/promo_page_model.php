<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Promo_page_model extends CI_Model
{
    /*
     * Get data by primary key
     */

    public function get($promo_page_id)
    {
        $query_string = "SELECT * FROM promo_page WHERE promo_page_id = ?";
        $array_data = array($promo_page_id);
        $query = $this->db->query($query_string, $array_data);

        return ($query->num_rows() > 0) ? $query->row() : FALSE;
    }

    /*
     * Get data id promo page
     */

    public function get_id_promo_page($data)
    {
        $query_string = "SELECT promo_page_id FROM promo_page WHERE promo_page_name = ?";
        $array_data = array($data['promo_page_name']);
        $query = $this->db->query($query_string, $array_data);

        return $query->result_array();
    }

    /*
     * Insert data into database
     */

    public function insert($post_data)
    {
        $current_user = $this->session->userdata('login');
        $language_id = 1;
        $query_string = "INSERT INTO promo_page "
                . "(language_id, promo_page_name, promo_page_description, promo_page_content, promo_page_thumbnail, promo_page_image, promo_page_start_date, promo_page_end_date, promo_page_slug, promo_page_is_customer, promo_page_register, promo_page_updated_date, promo_page_updated_by, promo_page_created_date, promo_page_created_by, promo_page_status) "
                . "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $array_data = array(
            $language_id,
            $post_data['promo_page_name'],
            $post_data['promo_page_description'],
            $post_data['promo_page_content'],
            $post_data['promo_page_thumbnail'],
            $post_data['promo_page_image'],
            $post_data['promo_page_start_date'],
            $post_data['promo_page_end_date'],
            $post_data['promo_page_slug'],
            $post_data['promo_page_is_customer'],
            $post_data['promo_page_register'],
            date('Y-m-d H:i:s'),
            $current_user['customer_id'],
            date('Y-m-d H:i:s'),
            $current_user['customer_id'],
            $post_data['promo_page_status']
        );
        $query = $this->db->query($query_string, $array_data);

        return ($query) ? TRUE : FALSE;
    }

    /*
     * Update data into database
     */

    public function update($post_data, $promo_page_id)
    {
        $current_user = $this->session->userdata('login');
        $query_string = "UPDATE promo_page SET promo_page_name=?, promo_page_description=?, promo_page_content=?, promo_page_thumbnail=?, promo_page_image=?, promo_page_start_date=?, promo_page_end_date=?, promo_page_slug=?, promo_page_is_customer=?, promo_page_register=?, promo_page_updated_date=?, promo_page_updated_by=?, promo_page_status=? WHERE promo_page_id = ?";
        $array_data = array(
            $post_data['promo_page_name'],
            $post_data['promo_page_description'],
            $post_data['promo_page_content'],
            $post_data['promo_page_thumbnail'],
            $post_data['promo_page_image'],
            $post_data['promo_page_start_date'],
            $post_data['promo_page_end_date'],
            $post_data['promo_page_slug'],
            $post_data['promo_page_is_customer'],
            $post_data['promo_page_register'],
            date('Y-m-d H:i:s'),
            $current_user['customer_id'],
            $post_data['promo_page_status'],
            $promo_page_id
        );
        $query = $this->db->query($query_string, $array_data);

        return ($query) ? TRUE : FALSE;
    }

    /*
     * Delete data from database
     */

    public function delete($promo_page_id)
    {
        $query_string = "DELETE FROM promo_page WHERE promo_page_id = ?";
        $array_data = array($promo_page_id);
        $query = $this->db->query($query_string, $array_data);

        return ($query) ? TRUE : FALSE;
    }

    /*
     * Check duplicated data
     */

    public function check_duplicated($data, $promo_page_id = NULL)
    {
        $query_string = "SELECT promo_page_id FROM promo_page WHERE promo_page_name=?";
        if ( !is_null($promo_page_id))
        {
            $query_string .= " AND promo_page_id != '$promo_page_id'";
        }
        $array_data = array(
            $data['promo_page_name'],
        );
        $query = $this->db->query($query_string, $array_data);

        return $query->num_rows();
    }
}
