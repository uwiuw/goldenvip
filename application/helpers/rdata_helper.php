<?php

if(!function_exists('read_row_by_one'))
{
	function read_row_by_one()
	{
		$CI =& get_instance();
		$data = $CI->Mix->read_row_by_one($field='id',$val='1',$tb='post');
		return $data;
    }
}

if(!function_exists('read_rows'))
{
	function read_rows()
	{
		$CI =& get_instance();
		$data = $CI->Mix->read_rows($tb='post');
		return $data;
    }
}

?>