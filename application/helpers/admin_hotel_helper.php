<?php

if (!function_exists("is_hotelmember")) {

    function is_hotelmember()
    {
        $CI = & get_instance();
        if ($CI->session->userdata('hotel')) {
            return TRUE;
        } else {
            redirect('admin-hotel/login');
        }

    }

}

if (!function_exists("check_hotel_user")) {

    function check_hotel_user($tablename, $u='x', $p='x')
    {
        $CI = & get_instance();
        $p = md5($p);
         
        $data = array();
        $sql = "select username, password, tx_rwadminhotel_hotel from $tablename where username = '" . $u . "' and password = '" . $p . "'";
        $data = $CI->Mix->read_rows_by_sql($sql);

        if (!empty($data)) {
            return $data;
        } else {
            return FALSE;
        }

    }

}