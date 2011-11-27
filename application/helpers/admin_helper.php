<?php
if(!function_exists("is_admin"))
{
	function is_admin()
	{
	}
}

if(!function_exists("is_member"))
{
	function is_member()
	{
		$CI =& get_instance();
		if($CI->session->userdata('member'))
		{
			return TRUE;
		}
		else
		{
			redirect('member/back-office');
		}
		
	}
}

if(!function_exists("is_login"))
{
	function is_login()
	{
		$CI =& get_instance();
		if($CI->session->userdata('name'))
		{
			redirect('member');
		}
		else
		{
			return TRUE;
		}
	}
}

if(!function_exists("check_user"))
{
	
	function check_user($u='x',$p='x')
	{
		$CI =& get_instance();
		$p = md5($p);
		$data = array();
		$sql = "select username, password from tx_rwmembermlm_member where username = '".$u."' and password = '".$p."' and valid = '1' and hidden = '0'";
		$data = $CI->Mix->read_rows_by_sql($sql);
		if(!empty($data))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
}

?>