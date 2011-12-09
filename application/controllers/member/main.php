<?php
class Main extends CI_Controller
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
		$data['page'] = "public/homepage";
		$data['nav'] = "homepage";
		$data['template']=base_url()."asset/theme/mygoldenvip/"; 
		
		$this->load->vars($data);
		$this->load->view('member/template');
	}
	
    function profile()
	{
		is_member();
		$data['title']="Member | Home Page";
		$data['page'] = "public/profile";
		$data['nav'] = "profile";
		$data['template']=base_url()."asset/theme/mygoldenvip/"; 
		$data['member'] = getMemberByUid($this->session->userdata('member'));
		$data['bank'] = $this->Mix->dropdown_menu('uid','bank','tx_rwmembermlm_bank');
		$data['country'] = $this->Mix->dropdown_menu('uid','country','tx_rwmembermlm_phonecountrycode');
		$data['province'] = $this->Mix->dropdown_menu('uid','province','tx_rwmembermlm_province');
		$data['city'] = $this->Mix->dropdown_menu('uid','city','tx_rwmembermlm_city');
		$data['code'] = $this->Mix->dropdown_menu('uid','code','tx_rwmembermlm_phonecountrycode');
		#$sql = "select voucher_code,status, crdate from tx_rwmembermlm_vouchercode where distributor='".$this->session->userdata('member')."' and hidden = '0' ";
		$sql = "select a.voucher_code, a.status, a.crdate, b.firstname, b.lastname
				from tx_rwmembermlm_vouchercode a
				left join tx_rwmembermlm_member b on a.voucher_code = b.voucher_code
				where a.distributor='".$this->session->userdata('member')."' ";
		$data['total_data'] = $this->Mix->read_more_rows_by_sql($sql);
		$sql = "select count(uid) as c_uid from tx_rwmembermlm_vouchercode where status='1' and distributor='".$this->session->userdata('member')."'";
		$data['data_used'] = $this->Mix->read_rows_by_sql($sql);
		$sql = "select count(uid) as c_uid from tx_rwmembermlm_vouchercode where status='0' and distributor='".$this->session->userdata('member')."'";
		$data['data_unused'] = $this->Mix->read_rows_by_sql($sql);
		
		$this->load->vars($data);
		$this->load->view('member/template');
	}
        
	function report() # report page
	{
		is_member(); # Hanya member yang boleh memasuki halaman ini
		$data['title']="Member | Home Page";
		$data['page'] = "public/report_genealogy";
		$data['nav'] = "report";
		$data['template']=base_url()."asset/theme/mygoldenvip/"; 
		
		$this->load->vars($data);
		$this->load->view('member/template');
	}
	
	function commision()
	{
		is_member(); # Hanya member yang boleh memasuki halaman ini
		$data['title']="Member | Home Page";
		$data['page'] = "public/commision";
		$data['nav'] = "report";
		$data['template']=base_url()."asset/theme/mygoldenvip/"; 
		
		$this->load->vars($data);
		$this->load->view('member/template');
	}
	
	function direct_sponsored()
	{
		is_member(); # Hanya member yang boleh memasuki halaman ini
		$data['title']="Member | Home Page";
		$data['page'] = "public/direct_sponsored";
		$data['nav'] = "report";
		$data['template']=base_url()."asset/theme/mygoldenvip/"; 
		
		$this->load->vars($data);
		$this->load->view('member/template');
	}
        
        /*
         * member more function redirect page
         */
        
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
		#is_login();
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
			
			$data['crdate'] = mktime(date('H'),date('i'),date('s'),date('m'),date('d'),date('y'));
			$data['email']=$this->input->post('email');
			$data['username']=$this->input->post('username');
			$data['password']=md5($this->input->post('password1'));
			$data['country']=$this->input->post('country');
			$data['mobilephone']=$this->input->post('countrycode2')."-".$this->input->post('mobilephone');
			$data['homephone']=$this->input->post('countrycode1')."-".$this->input->post('homephone');
			$data['province']=$this->input->post('province');
			$data['city']=$this->input->post('city');
			$data['address']=$this->input->post('address');
			$data['regional']=$this->input->post('regional');
			$data['sponsor']=$this->input->post('distributor');
			$data['usercategory']=$this->input->post('usercategory');
			$data['valid']='1';
			
			$d =$this->input->post('d');
			$y =$this->input->post('y');
			$m =$this->input->post('m');
			
			$data['dob']= "$y-$m-$d";
			
			$vc['status']='1';
			$data['voucher_code']=$this->input->post('vc');
			$data['bank_name']=$this->input->post('bank');
			$data['bank_account_number']=$this->input->post('bank_account_number');
			$data['name_on_bank_account']=$this->input->post('name_on_bank_account');
			$dist = array();
			if($this->input->post('placement') == '1')
			{
				$data['upline']=get_leaf_left($data['sponsor']);
				$data['placement'] = '1';
				# ambil point dari package yang bersangkutan untuk posisi kiri
				$lastpoint = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','point_left',$this->input->post('distributor'),'uid');
				# update point_left distributor or sponsor
				$pluspoint = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_package','point',$this->input->post('package'),'uid');
				$dist['point_left'] = $pluspoint['point']+$lastpoint['point_left'];
			}
			else
			{
				$data['upline']=get_leaf_right($data['sponsor']);
				$data['placement'] = '2';
				# ambil point dari package yang bersangkutan untuk posisi kanan
				$lastpoint = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','point_right',$this->input->post('distributor'),'uid');
				# update point_right distributor or sponsor
				$pluspoint = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_package','point',$this->input->post('package'),'uid');
				$dist['point_right'] = $pluspoint['point']+$lastpoint['point_right'];
			}
			
			if($this->input->post('package')=='1' or $this->input->post('package') =='2')
			{
				if($this->input->post('package') =='2')
				{
					$data['grade'] = '3';
					$data['permanent_grade'] = '1'; // 1 grade abal-abal
				}
				else
				{
					$data['grade'] = '1';
					$data['permanent_grade'] = '2';
				}
				$data['package']=$this->input->post('package');
			}
			else
			{ 
				$data['package']=$this->input->post('package3');
				$data['grade'] = '4';
				$data['permanent_grade'] = '1';
			}
			
			/*$up_sponsor = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','sponsor',$data['sponsor'],'uid');
			if($up_sponsor['sponsor'] != '0')
			{
				$sql = "select * from tx_rwmembermlm_vouchercode where voucher_code='".$this->input->post('vc')."' and distributor='".$up_sponsor['sponsor']."' and status='0' ";
			}
			else
			{
				$sql = "select * from tx_rwmembermlm_vouchercode where voucher_code='".$this->input->post('vc')."' and distributor='".$data['sponsor']."' and status='0' ";
			}
			*/
			$sql = "select * from tx_rwmembermlm_vouchercode where voucher_code='".$this->input->post('vc')."' and status='0' ";
			$check = $this->Mix->read_rows_by_sql($sql);
			if(!empty($check))
			{
				$check  = $this->Mix->update_record('voucher_code',$this->input->post('vc'),$vc,'tx_rwmembermlm_vouchercode');
				$this->Mix->add_with_array($data,'tx_rwmembermlm_member');
				#$this->Mix->update_record('uid',$this->input->post('distributor'),$dist,'tx_rwmembermlm_member');
				
				
				$d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_package','fee_dollar',$data['package'],'uid');
				$fast['bonus'] = $d['fee_dollar'];
				$fast['uid_member'] = $this->input->post('distributor');
				#$fast['uid_downline'] = $data['upline']+1;
				$d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','uid',$data['username'],'username');
				$fast['uid_downline'] = $d['uid'];
				$fast['crdate'] = mktime(date('H'),date('i'),date('s'),date('m'),date('d'),date('y'));
				$fast['pid']='67';
				$this->Mix->add_with_array($fast,'tx_rwmembermlm_historyfastbonus');
				update_point($d['uid'],$data['package']);
				
				$mentor_bonus = $this->get_mentor_bonus($this->input->post('package'),$d['uid'],$data['sponsor']); // get mentor bonus
				
				$d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','commission',$data['sponsor'],'uid');
				
				$dx = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_package','fee_dollar',$data['package'],'uid');
				$com['commission'] = $d['commission']+$dx['fee_dollar']+$mentor_bonus;
				
				$this->Mix->update_record('uid',$data['sponsor'],$com,'tx_rwmembermlm_member');
				redirect('member/thank-you-registering','refresh');
			} 
			else
			{
				redirect('member/join-now','refresh');
			}
			 
		}
	}
	
	function get_mentor_bonus($pack,$uid_downline,$uid_upline)
	{
		$d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','package',$uid_upline,'uid'); // ambil paket upline
		$bonus = 0;
		if($pack > 1)
		{
			$data = array();
			if($d['package']=='2' and $pack == '2')
			{
				$bonus = 10;
				$mb['hidden'] = '0';
				$mb['uid_member'] = $uid_upline;
				$mb['uid_downline'] = $uid_downline;
				$mb['bonus'] = $bonus;
				$mb['paid'] = '1';
				$mb['deleted'] = '0';
				$mb['pid'] = '67';
				$this->Mix->add_with_array($mb,'tx_rwmembermlm_historymentorbonus');
			}
			
			if($d['package'] > '2' and $pack > 2)
			{
				$bonus = 20;
				$mb['hidden'] = '0';
				$mb['uid_member'] = $uid_upline;
				$mb['uid_downline'] = $uid_downline;
				$mb['bonus'] = $bonus;
				$mb['paid'] = '1';
				$mb['deleted'] = '0';
				$mb['pid'] = '67';
				$this->Mix->add_with_array($mb,'tx_rwmembermlm_historymentorbonus');
			}
		}
		
		return $bonus;
	}
	
	function thankyou() # thank you page
	{
		is_member(); # Hanya member yang boleh memasuki halaman ini
		$data['title']="Thank you for join us";
		$data['page'] = "thankyou";
		$data['nav'] = "thank you";
		$data['template']=base_url()."asset/theme/mygoldenvip/"; 
		
		$this->load->vars($data);
		$this->load->view('public/old/template');
	}
	
	function member_logout() # logout
	{
		$this->session->unset_userdata("member");
		$this->session->unset_userdata("name");
		$this->session->unset_userdata("regional");
		$this->session->unset_userdata("ucat");
		redirect('member/back-office','refresh');
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
				$d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','usercategory',$name,'username');  # ambil lastname
				$data['ucat'] =$d['usercategory'];
				$this->session->set_userdata($data);
				
				if($this->input->post('id_auto'))
				{
					redirect('member/profile','refresh');
				}
				else
				{
					redirect('member','refresh');
				}
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
}