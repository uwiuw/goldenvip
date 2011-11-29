<?php
class Member extends CI_Controller
{
	function index()
	{
		is_member();
		$this->homepage();
	}
	
	function homepage() # home
	{
		is_member(); # Hanya member yang boleh memasuki halaman ini
		$data['title']="Member | Home Page";
		$data['page'] = "homepage";
		$data['nav'] = "homepage";
		$data['template']=base_url()."asset/theme/mygoldenvip/"; 
		
		$this->load->vars($data);
		$this->load->view('member/old/template');
	}
	
	function join_now() # join now
	{
		is_login();
		$data['title']="Member | Home Page";
		$data['page'] = "join-now";
		$data['nav'] = "homepage";
		$data['country'] = $this->Mix->dropdown_menu('uid','country','tx_rwmembermlm_phonecountrycode');
		$data['bank'] = $this->Mix->dropdown_menu('uid','bank','tx_rwmembermlm_bank');
		$data['package'] = $this->Mix->dropdown_menu('uid','package','tx_rwmembermlm_package');
		$data['template']=base_url()."asset/theme/mygoldenvip/"; 
		
		$this->load->vars($data);
		$this->load->view('public/old/template');
	}
	
	function join_now_saving() # simpan data member baru
	{
		is_login();
		$u = $this->input->post('username'); 
		$ac = getUsernameMLM($u);
		if(!empty($ac))
		{
			echo "username exist";
		}
		else
		{
			$data['pid']='67';
			$data['firstname']=$this->input->post('firstname');
			$data['lastname']=$this->input->post('lastname');
			$d =$this->input->post('d');
			$y =$this->input->post('y');
			$m =$this->input->post('m');
			$data['crdate'] = $d."-".$m."-".$y;
			$data['email']=$this->input->post('email');
			$data['username']=$this->input->post('username');
			$data['password']=$this->input->post('password1');
			$data['country']=$this->input->post('country');
			$data['mobilephone']=$this->input->post('countrycode2')."-".$this->input->post('mobilephone');
			$data['homephone']=$this->input->post('countrycode1')."-".$this->input->post('homephone');
			$data['province']=$this->input->post('province');
			$data['city']=$this->input->post('city');
			$data['address']=$this->input->post('address');
			$data['regional']=$this->input->post('regional');
			$data['sponsor']=$this->input->post('distributor');
			
			$data['upline']=get_leaf_left($data['sponsor']);
			
			
			 
			$vc['voucher_code']=$this->input->post('vc');
			$data['voucher_code']=$this->input->post('vc');
			$data['bank_name']=$this->input->post('bank');
			$data['bank_account_number']=$this->input->post('bank_account_number');
			$data['name_on_bank_account']=$this->input->post('name_on_bank_account');
			$dist = array();
			if($this->input->post('package')=='1' or $this->input->post('package') =='2')
			{
				$data['package']=$this->input->post('package');
				# kiri
				$data['placement'] = '1';
				# ambil point dari package yang bersangkutan
				$sql = "select point_left from tx_rwmembermlm_member where uid='".$this->input->post('distributor')."'";
				$lastpoint = $this->Mix->read_rows_by_sql($sql);
				
				$sql = "select point from tx_rwmembermlm_package where uid='".$this->input->post('package')."'";
				$pluspoint = $this->Mix->read_rows_by_sql($sql);
				$dist['point_left'] = $pluspoint['point'];
			}
			else
			{ 
				$data['package']=$this->input->post('package3');
				# kiri
				$data['placement'] = '1';
				# ambil point dari package yang bersangkutan
				$sql = "select point_left from tx_rwmembermlm_member where uid='".$this->input->post('distributor')."'";
				$lastpoint = $this->Mix->read_rows_by_sql($sql);
				
				$sql = "select point from tx_rwmembermlm_package where uid='".$this->input->post('package')."'";
				$pluspoint = $this->Mix->read_rows_by_sql($sql);
				$dist['point_left'] = $pluspoint['point'] + $lastpoint['point_left'] ;
				echo $lastpoint['point_left']." ".$pluspoint['point'];
			}
			
			$sql = "select uid from tx_rwmembermlm_vouchercode where voucher_code='".$this->input->post('vc')."' and distributor='".$data['sponsor']."' and status='0' ";
			$check = $this->Mix->read_rows_by_sql($sql);
			if(empty($check))
			{
				$check  = $this->Mix->update_record('distributor',$data['sponsor'],$vc,'tx_rwmembermlm_vouchercode');
				$this->Mix->add_with_array($data,'tx_rwmembermlm_member');
				$this->Mix->update_record('uid',$this->input->post('distributor'),$dist,'tx_rwmembermlm_member');
				$fast['uid_member'] = $this->input->post('distributor');
				$fast['uid_downline'] = $data['upline']+1;
				$fast['bonus'] = '100';
				$this->Mix->add_with_array($fast,'tx_rwmembermlm_historyfastbonus');
				
			} 
		}
	}
	
	function check_login() # validasi login
	{
		if($this->input->post('name') and $this->input->post('pwd'))
		{
			$name = $this->input->post('name');
			$pwd = $this->input->post('pwd');
			if(check_user($name,$pwd))
			{
				$d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','uid',$name,'username'); # ambil userId
				$data['member'] = $d['uid'];
				$d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','firstname',$name,'username'); # ambil firstname
				$data['name'] = $d['firstname'];
				$d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','lastname',$name,'username'); # ambil lastname
				$data['name'] =$data['name']." ".$d['lastname']; 
				$d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','regional',$name,'username');  # ambil lastname
				$idregional =$d['regional'];
				$d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_city','city',$idregional,'uid');  # ambil regional {city}
				$data['regional'] = $d['city'];
				$this->session->set_userdata($data);
				
				redirect('member','refresh');
			}
			else
			{
				redirect('member/back-office','refresh');
			}
		}
		else
		{
			redirect('member/back-office','refresh');
		}
	}
	
	function back_office()
	{
		is_login(); # redirect ke halaman member jika member telah login
		$this->member_login();	
	}
	
	
	function member_login() # login {back office}
	{
		$data['title']="Member | Back Office";
		$data['page'] = "member-login";
		$data['nav'] = "back-office";
		$data['template']=base_url()."asset/theme/mygoldenvip/"; 
		
		$this->load->vars($data);
		$this->load->view('public/template');
	}
	
	function member_logout() # logout
	{
		$this->session->unset_userdata("member");
		$this->session->unset_userdata("name");
		redirect('member/back-office','refresh');
	}
}