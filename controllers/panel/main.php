<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	/**
	 * 	Index Page for this controller.
	 *
	 *	contact : archievenolgede@ymail.com
	 *	19/11/2011
	 */
	public function index()
	{ 
		$this->load->view('panel/template');
	}
	function home_page()
	{
		$this->load->view('panel/page/home_page');
	}
	
	#	Distributor
	function list_distributor()
	{
		$data['data'] = getAccountMLM(); 
		$data['path'] = "Distributor";
		$data['cat'] = '3';
		$this->load->view('panel/page/list_account',$data); 
	}
		# delete data distributor
	function del_distributor()
	{
		echo $this->session->userdata('del_uid');
		#$this->session->unset_userdata('del_uid');
	}
	
	# Member
	function list_member()
	{
		$data['data'] = getAccountMLM('4'); 
		$data['path'] = "Member";
		$data['cat'] = '4';
		$this->load->view('panel/page/list_account',$data); 
	}
	
	# voucher code management
	function list_voucher()
	{
		$data['data'] = getAccountMLM(); 
		$sql = "select * from tx_rwmembermlm_vouchercode";
		$data['total_data'] = $this->Mix->read_more_rows_by_sql($sql);
		
		$sql = "select count(uid) as c_uid from tx_rwmembermlm_vouchercode where status='1'";
		$data['data_used'] = $this->Mix->read_rows_by_sql($sql);
		
		$sql = "select count(uid) as c_uid from tx_rwmembermlm_vouchercode where status='0'";
		$data['data_unused'] = $this->Mix->read_rows_by_sql($sql);
		
		$this->load->view('panel/page/distributor/list_voucher',$data); 
	}
		# voucher code generate
	function generate_vc()
	{
		$data['data'] = getAccountMLM(); 
		$this->load->view('panel/page/distributor/generate_vc',$data); 
	}
		# take_post_and_generate_vc
	function take_post_and_generate_vc()
	{
		if($this->input->post("distributor") and $this->input->post("number_vc"))
		{
			$int_vc = $this->input->post("number_vc");
			if(is_numeric($int_vc))
			{
				# check is valid distributor ?
				# get pid from distributor!
				$data = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','pid',$this->input->post("distributor"),'uid');
				if(empty($data))
				{
					echo "invalid input";
				}
				else
				{
					$data['crdate'] = date('Y-m-d');
					$data['distributor'] = $this->input->post("distributor");
					$vc = get_voucher_code($int_vc);
					foreach($vc as $row)
					{
						$data['voucher_code'] = $row;
						$this->Mix->add_with_array($data,'tx_rwmembermlm_vouchercode');
					}
					echo "Data Successfully inserted";
				}
			}
			else
			{
				echo "invalid input \"for number of voucher\" ";
			}
		}
		else
		{
			echo "invalid input";
		}
	}
	
}