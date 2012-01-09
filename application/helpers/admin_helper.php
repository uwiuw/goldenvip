<?php

if (!function_exists("is_admin")) {

    function is_admin()
    {
        $CI = & get_instance();
        if ($CI->session->userdata('admin') == 'admin-on') {
            return TRUE;
        } else {
            redirect('_admin/login','refresh');
        }
    }

}

if (!function_exists("is_member")) {

    function is_member()
    {
        $CI = & get_instance();
        if ($CI->session->userdata('is_member') == 'member-on') {
            return TRUE;
        } else {
            redirect('member/back-office','refresh');
        }
    }

}

if (!function_exists("is_profile")) {

    function is_profile()
    {
        $CI = & get_instance();
        if ($CI->session->userdata('open_profile') == 'status-open') {
            return TRUE;
        } else {
            redirect('member/lock_profile','refresh');
        }
    }

}

if (!function_exists("is_login")) {

    function is_login()
    {
        $CI = & get_instance();
        if ($CI->session->userdata('is_member') == 'member-on') 
		{
            redirect('member','refresh');
        } 
        else if($CI->session->userdata('admin') == 'admin-on')
        {
            redirect('_admin','refresh');
        }
        else if($CI->session->userdata('admin-tour')== 'aktif')
        {
            redirect('admin-tour/home','refresh');
        }
        else
        {
            return TRUE;
        }

    }

}

if (!function_exists("check_user")) {

    function check_user($u='x', $p='x')
    { 
         
        $CI = & get_instance();
        $p = md5($p);
        $data = array();
        
        $sql = "select username, password from tx_rwmembermlm_member where username = '" . $u . "' and password = '" . $p . "' and valid = '1' and hidden = '0'";
        $data = $CI->Mix->read_rows_by_sql($sql);
        if (!empty($data)) {
            return TRUE;
        } else {
            return FALSE;
        }

    }

}

if (!function_exists("admin_login")) {

    function admin_login($u='x', $p='x')
    { 
         
        $CI = & get_instance();
        $p = md5($p);
        $data = array();
        
        $sql = "select username, password from be_users where username = '" . $u . "' and password = '" . $p . "' and admin = '1'";
        $data = $CI->Mix->read_rows_by_sql($sql);
        if (!empty($data)) {
            return TRUE;
        } else {
            return FALSE;
        }

    }

}
