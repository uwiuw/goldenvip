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
		$sql = "select count(uid) as req from tx_rwmembermlm_member where sponsor = '".$this->session->userdata('member')."' and valid = '0' and hidden = '1'";
		$data['mreq'] = $this->Mix->read_rows_by_sql($sql);
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
		$data['bank'] = $this->Mix->dropdown_menu('bank','bank','tx_rwmembermlm_bank');
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
		//is_login();
		$u = $this->input->post('username'); 
		$ac = getUsernameMLM($u);
		if(!empty($ac))
		{
			$this->session->set_flashdata('info','Sorry, Username Already Exist.');
			redirect('member/join-now','refresh');
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
			$data['valid']='0';
			$data['hidden'] = '1';
			$d =$this->input->post('d');
			$y =$this->input->post('y');
			$m =$this->input->post('m');
			
			$data['dob']= "$y-$m-$d";
			
			$data['voucher_code']=$this->input->post('vc');
			$data['bank_name']=$this->input->post('bank_name');
			$data['bank_account_number']=$this->input->post('bank_account_number');
			$data['name_on_bank_account']=$this->input->post('name_on_bank_account');
			$dist = array();
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
				$data['package']=$this->input->post('package');
				if($this->input->post('package2'))
				{
					$data['package']=$this->input->post('package2');
				}
				$data['grade'] = '4';
				$data['permanent_grade'] = '1';
			}
			$this->Mix->add_with_array($data,'tx_rwmembermlm_member');
			$this->session->set_flashdata('info','Thank you for registering, please check your mail.');
			redirect('member/join-now','refresh');
		}
	}
	
	function set_active_member()
	{
		is_member();
		if($this->input->post('uid'))
		{
			if($this->input->post('voucher_code') && ($this->input->post('valid') == '1') && $this->input->post('placement'))
			{
				$data['valid'] = '1';
				$data['hidden'] = '0';
				$data['voucher_code'] = $this->input->post('voucher_code');
				if($this->input->post('placement') == '1')
				{
					$data['upline']=get_leaf_left($this->session->userdata('member')); // sponsor = distributor
					$data['placement'] = '1';
				}
				else
				{
					$data['upline']=get_leaf_right($this->session->userdata('member'));
					$data['placement'] = '2';
				}
				
				# chekc voucher code
				$sql = "select * from tx_rwmembermlm_vouchercode where voucher_code='".$this->input->post('voucher_code')."' and status='0' ";
				$check = $this->Mix->read_rows_by_sql($sql);
				if(!empty($check))
				{
					$this->Mix->update_record('uid',$this->input->post('uid'),$data,'tx_rwmembermlm_member');
					$vc['status'] = '1';
					$this->Mix->update_record('uid',$check['uid'],$vc,'tx_rwmembermlm_vouchercode');
					$d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_package','fee_dollar',$this->input->post('package'),'uid');
					$fast['bonus'] = $d['fee_dollar'];
					$fast['uid_member'] = $this->session->userdata('member'); 
					//$d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','uid',$this->input->post('uid'),'username');
					$fast['uid_downline'] = $this->input->post('uid');
					$fast['crdate'] = mktime(date('H'),date('i'),date('s'),date('m'),date('d'),date('y'));
					$fast['pid']='67';
					$this->Mix->add_with_array($fast,'tx_rwmembermlm_historyfastbonus'); // set fast bonus
					
					update_point($this->input->post('uid'),$this->input->post('package')); # package
					MatchingBonus($this->input->post('uid'), '67');
					
					$mentor_bonus = $this->get_mentor_bonus($this->input->post('package'),$this->input->post('uid'),$this->session->userdata('member')); // get mentor bonus
					$d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','commission',$this->session->userdata('member'),'uid');
					$dx = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_package','fee_dollar',$this->input->post('package'),'uid');
					$com['commission'] = $d['commission']+$dx['fee_dollar']+$mentor_bonus;
					$this->Mix->update_record('uid',$this->session->userdata('member'),$com,'tx_rwmembermlm_member'); // update commision
					
					$this->session->set_flashdata('info','Member now has been active.');
					redirect('member/thank-you-registering','refresh');
				} 
				else
				{
					$this->session->set_flashdata('error','Sorry voucher code is incorrect or has been used.');
					redirect('member/post_data/browse-member-request/'.$this->input->post('uid'),'refresh');
				}
			}
			else
			{
				$this->session->set_flashdata('error',"Please complete form, update your status member (Valid / Not Valid) soon, voucher code can't blank");
				redirect('member/post_data/browse-member-request/'.$this->input->post('uid'),'refresh');
			}
		}
		else
		{
			redirect('member','refresh');
		}
		
	}
	
	function join_by_member()
	{
		is_member();
		$u = $this->input->post('username'); 
		$ac = getUsernameMLM($u);
		if(!empty($ac))
		{
			$this->session->set_flashdata('info','Sorry, Username Already Exist.');
			redirect('member/post_data/join-now/'.$this->session->userdata('member'),'refresh');
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
			
			$data['sponsor']=$this->session->userdata('member');
			
			$data['usercategory']=$this->input->post('usercategory');
			$data['voucher_code'] = $this->input->post('vc');
			$data['valid']='1';
			$data['hidden'] = '0';
			$d =$this->input->post('d');
			$y =$this->input->post('y');
			$m =$this->input->post('m');
			
			$data['dob']= "$y-$m-$d";
			
			
			$data['voucher_code']=$this->input->post('vc');
			$data['bank_name']=$this->input->post('bank_name');
			$data['bank_account_number']=$this->input->post('bank_account_number');
			$data['name_on_bank_account']=$this->input->post('name_on_bank_account');
			$dist = array();
			
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
				$data['package']=$this->input->post('package');
				if($this->input->post('package2'))
				{
					$data['package']=$this->input->post('package2');
				}
				$data['grade'] = '4';
				$data['permanent_grade'] = '1';
			}
			
			if($this->input->post('vc') && $this->input->post('placement'))
			{
				$data['valid'] = '1';
				$data['hidden'] = '0';
				if($this->input->post('placement') == '1')
				{
					$data['upline']=get_leaf_left($this->session->userdata('member')); // sponsor = distributor
					$data['placement'] = '1';
				}
				else
				{
					$data['upline']=get_leaf_right($this->session->userdata('member'));
					$data['placement'] = '2';
				}
				
				$sql = "select * from tx_rwmembermlm_vouchercode where voucher_code='".$this->input->post('vc')."' and status='0' ";
				$check = $this->Mix->read_rows_by_sql($sql);
				if(!empty($check))
				{
					
					$this->Mix->add_with_array($data,'tx_rwmembermlm_member');		
					$d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_package','fee_dollar',$this->input->post('package'),'uid');
					
					$fast['bonus'] = $d['fee_dollar'];
					$fast['uid_member'] = $this->session->userdata('member'); 
					$d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','uid',$data['username'],'username');
					$fast['uid_downline'] = $d['uid'];
					$fast['crdate'] = mktime(date('H'),date('i'),date('s'),date('m'),date('d'),date('y'));
					$fast['pid']='67';
					$this->Mix->add_with_array($fast,'tx_rwmembermlm_historyfastbonus'); // set fast bonus
					
					$vc['status'] = '1';
					$check  = $this->Mix->update_record('uid',$check['uid'],$vc,'tx_rwmembermlm_vouchercode');
					
					update_point($d['uid'],$this->input->post('package')); # package
					MatchingBonus($d['uid'], '67');
					
					$mentor_bonus = $this->get_mentor_bonus($this->input->post('package'),$d['uid'],$this->session->userdata('member')); // get mentor bonus
					$d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','commission',$this->session->userdata('member'),'uid');
					$dx = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_package','fee_dollar',$this->input->post('package'),'uid');
					$com['commission'] = $d['commission']+$dx['fee_dollar']+$mentor_bonus;
					$this->Mix->update_record('uid',$data['sponsor'],$com,'tx_rwmembermlm_member'); // update commision
					
					$this->session->set_flashdata('info','Member now has been active.');
					redirect('member/thank-you-registering','refresh');
				} 
				else
				{
					$this->session->set_flashdata('info','Please complete form. Voucher Code is not active, try again.');
					redirect('member/post_data/join-now/'.$this->session->userdata('member'),'refresh');
				}
			}
			else
			{
				$this->session->set_flashdata('info','Sorry, pelease complete form.');
				redirect('member/post_data/join-now/'.$this->session->userdata('member'),'refresh');
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
				$mb['paid'] = '0';
				$mb['deleted'] = '0';
				$mb['pid'] = '67';
				$this->Mix->add_with_array($mb,'tx_rwmembermlm_historymentorbonus');
			}
			
			if($d['package'] > '2' and $pack == '2')
			{
				$bonus = 20;
				$mb['hidden'] = '0';
				$mb['uid_member'] = $uid_upline;
				$mb['uid_downline'] = $uid_downline;
				$mb['bonus'] = $bonus;
				$mb['paid'] = '0';
				$mb['deleted'] = '0';
				$mb['pid'] = '67';
				$this->Mix->add_with_array($mb,'tx_rwmembermlm_historymentorbonus');
			}
			
			// point rewards
			if($d['package'] > '2' and $pack > '2')
			{
				$pb['pid'] = '67';
				$pb['crdate'] = date('Y-m-d');
				$pb['uid_member'] = $uid_upline;
				$pb['uid_downline'] = $uid_downline;
				$pb['point'] = 1000;
				$pb['hidden'] = '0';
				$this->Mix->add_with_array($pb,'tx_rwmembermlm_pointrewards');
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
				setGradeMember($this->session->userdata('member'),'67');
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
		$data['title']="Golden VIP : VIP";
		$data['page'] = "back-office";
		$data['nav'] = "back-office";
		$data['template']=base_url()."asset/theme/mygoldenvip/"; 
		
		$this->load->vars($data);
		$this->load->view('public/old/template');
	}
	function list_member_request()
	{
		is_member(); # Hanya member yang boleh memasuki halaman ini
		$sql = "select * from `tx_rwmembermlm_member` where sponsor = '".$this->session->userdata('member')."' and valid = '0' and hidden = '1'";
		$data['list_member'] = $this->Mix->read_more_rows_by_sql($sql);
		$data['title']="Member | List Request";
		$data['page'] = "public/list_member_request";
		$data['nav'] = "homepage";
		$data['template']=base_url()."asset/theme/mygoldenvip/"; 
		$this->load->vars($data);
		$this->load->view('member/template');
	}
	
	function update_profile()
	{
		is_member();
		
		$data = array();
		$uid = $this->session->userdata('member');
		if($this->input->post('password'))
		{
			$data['password'] = md5($this->input->post('password'));
		}
		$data['firstname'] =  $this->input->post('firstname');
		$data['lastname'] = $this->input->post('lastname');
		$data['dob'] = $this->input->post('dob');
		$data['email'] = $this->input->post('email');
		$data['country'] = $this->input->post('country');
		$this->input->post('contrycode');
		$data['homephone'] = $this->input->post('contrycode')." ".$this->input->post('homephone');
		$data['mobilephone'] = $this->input->post('contrycode')." ".$this->input->post('mobilephone');
		$data['province'] = $this->input->post('province');
		$data['city'] = $this->input->post('city');
		$data['address'] = $this->input->post('address');
		$data['regional'] = $this->input->post('regional');
		$data['bank_account_number'] = $this->input->post('bank_account_number');
		$data['bank_name'] = $this->input->post('bank_name');
		$data['name_on_bank_account'] = $this->input->post('name_on_bank_account');
		$this->Mix->update_record('uid',$uid,$data,'tx_rwmembermlm_member');
		$this->session->set_flashdata('info','Data has been update');
		redirect('member/profile','refresh');
	}
}