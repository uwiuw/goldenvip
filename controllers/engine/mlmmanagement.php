<?php
class Mlmmanagement extends CI_Controller
{
	public function index()
	{
		$this->get_direct_sponsor();
	}	  
	function test()
	{
		$this->load->view('test/data');
	}
	function get_voucher()
	{
		$voucher = get_voucher_code(4);
		echo "
		<pre>";
		print_r($voucher);
		echo "</pre>";
	}
	function get_direct_sponsor()
	{
		$sponsor = '106';
		$data['sponsor'] = $sponsor;
		$data['geneology'] = getDirectSponsored($sponsor,'67','4');
		$this->load->view('test/data',$data);
	}
}