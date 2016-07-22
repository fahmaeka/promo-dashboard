<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Administrator Authentication Checker
 *
 * */

class Administrator
{

    function __construct()
    {
        $app =& get_instance();
        $app->load->model('login_model');
    }

    function Administrator()
	{
        $app =& get_instance();

        if (!$app->session->userdata('login') && current_url() != site_url('login'))
		{
            $app->session->set_flashdata('redirect', substr($app->uri->uri_string(), 1));
            redirect('login');
            exit;
        }
    }

    function current_user()
	{
        $app =& get_instance();

        $login = $app->session->userdata('login');
        
        return $login;
    }

    function list_menu($parent_id = NULL, $level = 0) {
        $app =& get_instance();

        $current_user = $this->current_user();
        if (!$current_user)
        {
            $app->session->sess_destroy();
            redirect('login');
            exit;
        }
        
        $query_string = "SELECT m.menu_id, m.menu_parent_id, m.menu_name, m.menu_slug, m.menu_icon "
                      . "FROM menu AS m "
                      . "JOIN customer_access c ON (m.menu_id = c.menu_id) ";
        if ($parent_id == NULL)
        {
            $query_string .= "WHERE m.menu_parent_id IS NULL AND m.menu_status = 1 ";
        }
        else
        {
            $query_string .= "WHERE m.menu_parent_id = $parent_id AND m.menu_status = 1 ";
        }

        $query_string .= "AND c.customer_type_id = '".$current_user['customer_type_id']."' ";
        $query_string .= "ORDER BY m.menu_precedence";
        
        $query = $app->db->query($query_string);

        if ($query->num_rows() > 0)
        {
            if ($level != 0)
            {
                echo '<ul class="sub-menu">'."\n";
            }

			$result = $query->result();
			
            foreach ($result as $row)
            {
                if ($level == 0)
                {
                    echo '<li><a href="'.base_url($row->menu_slug).'"><i class="fa fa-'.$row->menu_icon.'"></i> <span class="title">'.$row->menu_name.'</span></a>'."\n";
                }
                else
                {
                    echo '<li><a href="'.base_url($row->menu_slug).'"><i class="fa fa-angle-double-right"></i> <span class="title">'.$row->menu_name.'</span></a>'."\n";
                }
                $this->list_menu($row->menu_id, $level+1);
                echo '</li>'."\n";
            }
            echo '</ul>'."\n";
        }
    }
}