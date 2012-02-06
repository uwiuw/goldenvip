<?php

if (!function_exists('get_vc_member')) {

    function get_vc_member($uid = '0') {
        $CI = & get_instance();
        $sql = "select * from tx_rwmembermlm_vouchercode where distributor = '" . $uid . "'";
        $data['data'] = $CI->Mix->read_more_rows_by_sql($sql);
        return $data;
    }

}

if (!function_exists('generate_voucher_code')) {

    function generate_voucher_code() {
        $len = 18;
        $base = 'ABCDEFGHJKLMNPQRSTWXYZ2345789';
        $max = strlen($base) - 1;
        $activatecode = '';
        mt_srand((double) microtime() * 1000000);
        while (strlen($activatecode) < $len)
            $activatecode .= $base{mt_rand(0, $max)};
        return $activatecode;
    }

}
if (!function_exists('get_voucher_code')) {

    function get_voucher_code($count) {
        $voucher = array();
        for ($i = 0; $i < $count; $i++) {
            $v = generate_voucher_code();
            if (check_valid_voucher($v)) {
                $voucher[$i] = $v;
            } else {
                $i--;
            }
        }
        return $voucher;
    }

}
if (!function_exists('check_valid_voucher')) {

    function check_valid_voucher($voucher, $status = "", $distributor = "") {
        $w = "";
        if ($status == "0" or $status == "1") { //$status != "" 
            $w .= " and status=$status";
        }
        if ($distributor != "") {
            $w .= " and distributor=$distributor";
        }

        $sql = "SELECT count(uid) as c_uid 
				FROM tx_rwmembermlm_vouchercode
				WHERE deleted = 0 and hidden = 0 AND voucher_code = '$voucher'
				$w
				";
        $CI = & get_instance();
        $result = $CI->Mix->read_rows_by_sql($sql);
        //echo $sql;

        if ($result["c_uid"] > 0) {
            return false; //belum terpakai / ada
        } else {
            return true; //sudah terpakai /  tidak ada
        }
    }

}
?>