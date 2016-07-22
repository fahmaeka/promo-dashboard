<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model
{
    /*
     * Get data by primary key
     */

    public function get($menu_id)
    {
        $fields = "menu_id, menu_parent_id, menu_name, menu_slug, menu_icon, menu_precedence, menu_status";
        $query_string = "SELECT $fields FROM menu WHERE menu_id = ?";
        $array_data = array($menu_id);
        $query = $this->db->query($query_string, $array_data);

        return ($query->num_rows() > 0) ? $query->row() : FALSE;
    }

    /*
     * Get parent menu
     */

    public function get_parent($menu_id = NULL)
    {
        $fields = "menu_id, menu_parent_id, menu_name, menu_slug, menu_icon, menu_precedence, menu_status";
        $query_string = "SELECT $fields FROM menu WHERE menu_id = ? ORDER BY menu_precedence";
        $array_data = array($menu_id);
        $query = $this->db->query($query_string, $array_data);

        return ($query->num_rows() > 0) ? $query : FALSE;
    }

    /*
     * Get sub menu
     */

    public function get_sub($menu_parent_id = NULL)
    {
        $fields = "menu_id, menu_parent_id, menu_name, menu_slug, menu_icon, menu_precedence, menu_status";
        if ($menu_parent_id == NULL)
        {
            $query_string = "SELECT $fields FROM menu WHERE menu_parent_id IS NULL OR menu_parent_id = 0 ORDER BY menu_precedence";
        }
        else
        {
            $query_string = "SELECT $fields FROM menu WHERE menu_parent_id = ? ORDER BY menu_precedence";
        }
        $array_data = array($menu_parent_id);
        $query = $this->db->query($query_string, $array_data);

        return ($query->num_rows() > 0) ? $query : FALSE;
    }

    /*
     * Insert data into database
     */

    public function insert($post_data)
    {
        $fields = "menu_parent_id, menu_name, menu_slug, menu_icon, menu_precedence, menu_status";
        $query_string = "INSERT INTO menu ($fields) VALUES(?,?,?,?,?,?)";
        $array_data = array(
            $post_data['menu_parent_id'],
            $post_data['menu_name'],
            $post_data['menu_slug'],
            $post_data['menu_icon'],
            $post_data['menu_precedence'],
            $post_data['menu_status']
        );
        $query = $this->db->query($query_string, $array_data);

        return ($query) ? TRUE : FALSE;
    }

    /*
     * Update data into database
     */

    public function update($menu_id, $post_data)
    {
        $fields = "menu_parent_id=?, menu_name=?, menu_slug=?, menu_icon=?, menu_precedence=?, menu_status=?";
        $array_data = array(
            $post_data['menu_parent_id'],
            $post_data['menu_name'],
            $post_data['menu_slug'],
            $post_data['menu_icon'],
            $post_data['menu_precedence'],
            $post_data['menu_status'],
            $menu_id
        );
        $query_string = "UPDATE menu SET $fields WHERE menu_id = ?";
        $query = $this->db->query($query_string, $array_data);

        return ($query) ? TRUE : FALSE;
    }

    /*
     * Delete data from database
     */

    public function delete($menu_id)
    {
        $query_string = "DELETE FROM menu WHERE menu_id = ?";
        $array_data = array($menu_id);
        $query = $this->db->query($query_string, $array_data);

        return ($query) ? TRUE : FALSE;
    }

    /*
     * Check foreign key
     */

    public function check_foreign($menu_id)
    {
        $query_string = "SELECT menu_id FROM customer_access WHERE menu_id = ?";
        $array_data = array(
            $menu_id
        );
        $query = $this->db->query($query_string, $array_data);

        if ($query->num_rows > 0)
        {
            return TRUE;
        }
        return FALSE;
    }

    /*
     * Check duplicated data
     */

    public function check_duplicated($data, $menu_id = NULL)
    {
        $query_string = "SELECT menu_id FROM menu WHERE menu_name=? AND menu_slug=?";
        if ( !is_null($menu_id))
        {
            $query_string .= " AND menu_id != '$menu_id'";
        }
        $array_data = array(
            $data['menu_name'],
            $data['menu_slug']
        );
        $query = $this->db->query($query_string, $array_data);

        return $query->num_rows();
    }

    /*
     * Retrieve and generate a form_dropdown friendly array
     */

    public function dropdown($key = NULL)
    {
        $options = array('' => 'Select');
        $query_string = "SELECT menu_id, menu_name FROM menu";
        $query = $this->db->query($query_string);

        foreach ($query->result() as $row)
        {
            if (!is_null($key))
            {
                $options[$row->{$key}] = $row->menu_name;
            }
            else
            {
                $options[$row->menu_id] = $row->menu_name;
            }
        }

        return $options;
    }

}
