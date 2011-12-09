<?php
class Vip extends CI_Controller
{
	public function index()
	{
		$this->holy_land();
	}
	
	public function holy_land()
    {
        is_member(); # Hanya member yang boleh memasuki halaman ini
		
		$u = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','username',$this->session->userdata('member'),'uid');
		$uid_member = $this->Mix->read_row_ret_field_by_value('fe_users','uid',$u['username'],'username');
		$sql = "select uid from tx_rwadminhotel_booking where hidden = '1' and uid_member = '".$uid_member['uid']."' ";
		$uid = $this->Mix->read_rows_by_sql($sql);
		
		if(!empty($uid))
		{
			$this->Mix->dell_one_by_one('uid',$uid['uid'],'tx_rwadminhotel_booking');
		}
			
        $data = $this->get_data_package('4');
        
        $this->load->vars($data);
        $this->load->view('member/template');
    }
	
	function non_holyland()
	{
		is_member(); # Hanya member yang boleh memasuki halaman ini
		
		$u = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','username',$this->session->userdata('member'),'uid');
		$uid_member = $this->Mix->read_row_ret_field_by_value('fe_users','uid',$u['username'],'username');
		$sql = "select uid from tx_rwadminhotel_booking where hidden = '1' and uid_member = '".$uid_member['uid']."' ";
		$uid = $this->Mix->read_rows_by_sql($sql);
		
		if(!empty($uid))
		{
			$this->Mix->dell_one_by_one('uid',$uid['uid'],'tx_rwadminhotel_booking');
		}
			
        $data = $this->get_data_package('5');
        
        $this->load->vars($data);
        $this->load->view('member/template');
	}
	
	function get_data_package($pid)
	{
		$data['title']="Member | Home Page | Reservation";
        $data['page'] = "vip/reservation";
        $data['nav'] = "reservation";
		if($pid == '4')
		{
			$data['selected'] = 'Holy Land';
		}
		else
		{
			$data['selected'] = 'Non Holy Land';
		}
		$data['pid'] = $pid;
		$data['template']=base_url()."asset/theme/mygoldenvip/";
		$data['destination'] = $this->Mix->read_package_by_pid($pid);
		$m = $this->Mix->read_row_by_one('uid',$this->session->userdata('member'),'tx_rwmembermlm_member');
		if($m['package'] < '3')
		{
			$data['set_compliment'] = '0';
		}
		else
		{
			$data['set_compliment'] = '1';
		}
		
		return $data;
	}
	
	function package_selected()
	{
		is_member();
		/* check : 	jika terdapat data dengan inisiasi hidden 1 artinya dahulu user pernah akan reservasi tetapi tidak sampai akhir, 
					hapus data tersebut */
		$check = $this->Mix->read_row_by_two('uid_member',$this->session->userdata('member'),'hidden','1','tx_rwagen_vipbooking');
		if(!empty($check))
		{
			$this->Mix->dell_one_by_one('uid',$check['uid'],'tx_rwagen_vipbooking');
		}
		/* end dari pengecekan */
		$data = array();
		$insert = array();
		$tujuan = $this->input->post('destination');
		$tanggal = $this->input->post('datepicker');
		/* insert into table booking by vip */
		$insert['hidden'] = '1';
		$insert['uid_member'] = $this->session->userdata('member');
		$insert['payed'] = 0;
		if($this->input->post('compliment') == '0')
		{
			$insert['reservation'] = 'Personal Account';
			$insert['payment'] = $this->input->post('select_payment');
		}
		else
		{
			if($this->input->post('compliment')=='Compliment')
			{
				$insert['reservation'] = $this->input->post('compliment');
				$insert['payment'] = 'Cash';
			}
			else
			{
				$insert['reservation'] = $this->input->post('compliment');
				$insert['payment'] = $this->input->post('select_payment');
			}
		}
		if($this->input->post('payment')=='Credit Card')
		{
			$insert['credit_card_number'] = 0;
			$insert['nameOnCC'] = 0;
			$insert['validThru'] = 0;
			$insert['signature'] = 0;
		}
		$this->Mix->add_with_array($insert,'tx_rwagen_vipbooking');
		/* end */
				
		$sql = "select a.uid,a.time_sch, a.qty, a.booking, b.nama, c.name, d.destination
				from tx_rwagen_vipschedule a, 
				tx_rwagen_vippackage b, 
				tx_rwagen_agen c, 
				tx_rwmembermlm_destination d
				
				where a.pid = d.uid and
				a.package = b.uid and
				a.agen = c.uid and
				a.hidden = 0 and
				d.uid = '$tujuan' and
				a.time_sch = '$tanggal'";
		
		$data['sch'] = $this->Mix->read_more_rows_by_sql($sql);
		/* data halaman */
		$data['title']="Member | Home Page | Reservation";
        $data['page'] = "vip/package_selected";
        $data['nav'] = "reservation";
        $this->load->vars($data);
       	$this->load->view('member/template');
	}
	
	function use_this_reservation_for()
	{
		is_member();
		$qty = '1';
		$data = array();
		/* check : 	jika terdapat data dengan inisiasi hidden 1 maka data tersebut akan di update untuk qty dan uid_sch */
		$check = $this->Mix->read_row_by_two('uid_member',$this->session->userdata('member'),'hidden','1','tx_rwagen_vipbooking');
		if(!empty($check))
		{
			if($check['reservation']!='Compliment')
			{
				$qty = $this->input->post('qty');
				$data['tulisan'] = "I Agree To Us My Repeat To :";
			}
			else
			{
				$data['tulisan'] = "I Agree To Us My Complimentry  To : ";
			}
			$up['uid_sch'] = $this->input->post('uid_sch');
			$up['qty'] = $qty;
			
			$d = $this->Mix->read_row_ret_field_by_value('tx_rwagen_vipschedule','booking',$this->input->post('uid_sch'),'uid'); 
			$q = $this->Mix->read_row_ret_field_by_value('tx_rwagen_vipschedule','qty',$this->input->post('uid_sch'),'uid'); 
			
			$qty = $qty + $d['booking'];
			if($qty > $q['qty'])
			{
				echo "<b>sorry is not enough quota <b>"; 
				redirect('member/reservation/vip','refresh');
			}
			else
			{
				$quote['booking'] = $qty;
				$this->Mix->update_record('uid',$this->input->post('uid_sch'),$quote,'tx_rwagen_vipschedule');
				$this->Mix->update_record('uid',$check['uid'],$up,'tx_rwagen_vipbooking');
			}
			
		}
		/* data halaman */
		$data['page'] = "vip/use_this_reservation_for";
		$data['title']="Member | Home Page | Reservation";
        $data['nav'] = "reservation";
        $this->load->vars($data);
       	$this->load->view('member/template');
	}
	
	function set_for_myself()
	{
		is_member();
		$check = $this->Mix->read_row_by_two('uid_member',$this->session->userdata('member'),'hidden','1','tx_rwagen_vipbooking');
		if(!empty($check))
		{
			$up['hidden'] = '0';
			if($check['qty'] == 1)
			{
				$this->set_data_final_booking_vip_click_myself();
				disable_complimentary();
				$this->Mix->update_record('uid',$check['uid'],$up,'tx_rwagen_vipbooking');
			}
			else
			{
				$this->set_data_final_booking_vip_click_myself();
				$this->set_for_other($check['qty'],1, 'and Myself');
			}
			$data['title']="Member | Reservation | Thank you ";
			$data['page'] = "business/save_reservation";
			$data['nav'] = "reservation";
        
			$this->load->vars($data);
			$this->load->view('member/template');
		}
		else
		{
			redirect('member/reservation/vip','refresh');
		}
	}
	
	function set_data_final_booking_vip_click_myself()
	{
		$sql = "select a.uid as uid_booking, b.uid as uid_sch, c.harga from tx_rwagen_vipbooking a, tx_rwagen_vipschedule b, tx_rwagen_vippackage c
				where a.hidden = '1' and
				a.uid_sch = b.uid and
				b.package  = c.uid
				and a.uid_member = '".$this->session->userdata('member')."'";
		$get_data_sch = $this->Mix->read_rows_by_sql($sql);
		$get_data_member = $this->Mix->read_row_by_one('uid',$this->session->userdata('member'),'tx_rwmembermlm_member');
		$data['nama'] = $get_data_member['firstname']." ".$get_data_member['lastname'];
		$data['email'] = $get_data_member['email'];
		$data['insurance'] = '1';
		$data['hidden'] = '0';
		$data['pid'] = $get_data_sch['uid_booking'];
		$data['rate'] = $get_data_sch['harga']+100;
		# menambahkan data pada tabel vip booking detail
		$this->Mix->add_with_array($data,'tx_rwagen_vipbookingdetails');
	}
	
	function set_for_other($qty = '1',$myself = 0,$me = '')
	{
		is_member();
		$data = array();
		$check = $this->Mix->read_row_by_two('uid_member',$this->session->userdata('member'),'hidden','1','tx_rwagen_vipbooking');
		if(!empty($check))
		{
			$sql = "select a.uid,a.time_sch, a.qty, a.booking, b.nama as package, c.name as travel, d.destination, b.harga as retail_rate
					from tx_rwagen_vipschedule a, 
					tx_rwagen_vippackage b, 
					tx_rwagen_agen c, 
					tx_rwmembermlm_destination d
					
					where a.pid = d.uid and
					a.package = b.uid and
					a.agen = c.uid and
					a.uid='".$check['uid_sch']."'";
			/* data halaman */
			if($check['reservation']!='Compliment'){$data['compliment_only'] = '0'; $qty=$check['qty']-$myself;}
			else{$data['compliment_only'] = '1';$data['hidden'] = '<input type="hidden" name="compliment" value="1">';}
			$data['me'] = $me;
			$data['qty'] = $qty;
			$data['sch'] = $this->Mix->read_rows_by_sql($sql);
			$data['received'] = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','firstname',$this->session->userdata('member'),'uid');
			$data['page'] = "vip/set_for_other";
			$data['title']="Member | Home Page | Reservation";
			$data['nav'] = "reservation";
			$this->load->vars($data);
			$this->load->view('member/template');
		}
		else
		{
			redirect('member/reservation/vip','refresh');
		}
	}
	
	function set_reservation()
	{
		is_member();
		$data = array();
		$check = $this->Mix->read_row_by_two('uid_member',$this->session->userdata('member'),'hidden','1','tx_rwagen_vipbooking');
		if(!empty($check))
		{
			$sql = "select a.uid as uid_booking, b.uid as uid_sch, c.harga from tx_rwagen_vipbooking a, tx_rwagen_vipschedule b, tx_rwagen_vippackage c
					where a.hidden = '1' and
					a.uid_sch = b.uid and
					b.package  = c.uid
					and a.uid_member = '".$this->session->userdata('member')."'";
			$get_data_sch = $this->Mix->read_rows_by_sql($sql);
			$get_data_member = $this->Mix->read_row_by_one('uid',$this->session->userdata('member'),'tx_rwmembermlm_member');
			$data['hidden'] = '0';
			$data['pid'] = $get_data_sch['uid_booking'];
			$data['rate'] = $get_data_sch['harga'];
			
			$data['email'] = $this->input->post('email');
			$data['insurance'] = '1';
			
			for($i=1;$i<=$this->input->post('qty');$i++)
			{
				$data['nama'] = $this->input->post('name'.$i);
				$data['rate'] = $this->input->post('rate')+(100*$this->input->post('mega'.$i));
				$this->Mix->add_with_array($data,'tx_rwagen_vipbookingdetails');
			}
			
			$up['hidden'] = '0';
			$this->Mix->update_record('uid',$get_data_sch['uid_booking'],$up,'tx_rwagen_vipbooking');
			$page['title']="Member | Reservation | Thank you ";
			$page['page'] = "business/save_reservation";
			$page['nav'] = "reservation";
		
			$this->load->vars($page);
			$this->load->view('member/template');
		}
		else
		{
			redirect('member/reservation/vip','refresh');
		}
	}
}