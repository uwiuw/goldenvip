<?php
class Test extends CI_Controller
{
	public function index()
	{
		$this->daterangepicker();
	}
	function timepicker()
	{
		$this->load->view('test/timepicker');
	}
	function daterangepicker()
	{
		$this->load->view('test/daterangepicker');
	}
}