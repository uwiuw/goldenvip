<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Business extends CI_Controller
{
    public function index()
    {
        $this->reservation();
    }
    
    public function reservation()
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
			
        $data['title']="Member | Home Page";
        $data['page'] = "business/reservation";
        $data['nav'] = "reservation";
        $data['template']=base_url()."asset/theme/mygoldenvip/";
		$data['destination'] = $this->Mix->dropdown_menu('uid','destination','tx_rwmembermlm_destination');
        
        $this->load->vars($data);
        $this->load->view('member/template');
    }
	
	function list_hotel()
	{
		$post_data = array();
		$data = array();
		$u = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','username',$this->session->userdata('member'),'uid');
		if(isset($u['username']))
		{
			$uid_member = $this->Mix->read_row_ret_field_by_value('fe_users','uid',$u['username'],'username');
			$post_data['uid_member'] = $uid_member['uid'];
			
			$name_reservation = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','firstname',$this->session->userdata('member'),'uid');
			$post_data['name_reservation'] = $name_reservation['firstname'] ;
			$post_data['check_in'] = $this->input->post('datepicker');
			$post_data['check_out'] = $this->input->post('datepicker1');
			$post_data['reservation'] = $this->input->post('compliment');
			$post_data['payment'] = 'Cash';
			$post_data['hidden'] = '1';
			
			if($this->input->post('compliment') == 'Personal Account')
			{
				$post_data['payment'] = $this->input->post('select_payment');
				$post_data['reservation'] = $this->input->post('compliment');
			}
			
			if($this->input->post('compliment') == '0')
			{
				$post_data['payment'] = $this->input->post('select_payment');
				$post_data['reservation'] = "Personal Account";
			}
			 
			$this->Mix->add_with_array($post_data,'tx_rwadminhotel_booking'); // insert into tx_rwadminhotel_booking
			
		}
		// 	else ny buat username di tabel fe_user
		$destination = $this->input->post('destination');
		$sql = "select uid,hotel_name,star,location from tx_rwadminhotel_hotel 
				where uid_destination = '".$destination."' order by star asc";
				
		$data['city'] = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_destination','destination',$destination,'uid');
		
		$data['listhotel'] = $this->Mix->read_more_rows_by_sql($sql);
		//debug_data($data);
		
		is_member(); # Hanya member yang boleh memasuki halaman ini
        $data['title']="Member | Home Page";
        $data['page'] = "business/list_hotel";
        $data['nav'] = "reservation";
        $data['template']=base_url()."asset/theme/mygoldenvip/";
		$data['destination'] = $this->Mix->dropdown_menu('uid','destination','tx_rwmembermlm_destination');
        
        $this->load->vars($data);
        $this->load->view('member/template');
	}
    function set_reservation()
	{
		$data = array();
		$post_data = array();
		$profit = $this->input->post('profit');
		
		$u = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','username',$this->session->userdata('member'),'uid');
		$e = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','email',$this->session->userdata('member'),'uid');
		
		$uid_member = $this->Mix->read_row_ret_field_by_value('fe_users','uid',$u['username'],'username');
		$sql = "select uid from tx_rwadminhotel_booking where hidden = '1' and uid_member = '".$uid_member['uid']."' ";
		$uid = $this->Mix->read_rows_by_sql($sql);
		
		$uid = $uid['uid'];		
		$d1 = $this->Mix->read_row_ret_field_by_value('tx_rwadminhotel_booking','check_in',$uid,'uid');
		$d2 = $this->Mix->read_row_ret_field_by_value('tx_rwadminhotel_booking','check_out',$uid,'uid');
		$night  = diffDay($d1['check_in'],$d2['check_out']);
				
		$data['qty'] = $this->input->post('jumlah');
		$data['rate'] = $data['qty'] * $profit * $night  ;
		$data['email'] = $e['email'];
		$data['uid_room'] = $this->input->post('uid_room');
		
		$this->Mix->update_record('uid',$uid,$data,'tx_rwadminhotel_booking');
		
		$res = $this->Mix->read_row_ret_field_by_value('tx_rwadminhotel_booking','reservation',$uid,'uid');
		if($res['reservation']=='Compliment')
		{
			$post_data['tulisan'] = "I Agree To Us My Complimentry  To : ";
		}
		else
		{
			$post_data['tulisan'] = "I Agree To Us My Repeat To :";
		}
		
		is_member(); # Hanya member yang boleh memasuki halaman ini
        $post_data['title']="Member | Reservation | Use Reservation For ? ";
        $post_data['page'] = "business/set_reservation";
        $post_data['nav'] = "reservation";
        $post_data['template']=base_url()."asset/theme/mygoldenvip/";
		$post_data['destination'] = $this->Mix->dropdown_menu('uid','destination','tx_rwmembermlm_destination');
        
        $this->load->vars($post_data);
        $this->load->view('member/template');
	}
	
	function save_reservation()
	{
		is_member(); # Hanya member yang boleh memasuki halaman ini
		
		$u = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','username',$this->session->userdata('member'),'uid');
		$uid_member = $this->Mix->read_row_ret_field_by_value('fe_users','uid',$u['username'],'username');
		$sql = "select uid from tx_rwadminhotel_booking where hidden = '1' and uid_member = '".$uid_member['uid']."' ";
		$uid = $this->Mix->read_rows_by_sql($sql);
		
		$data['hidden'] = '0';
		$data['date_booking'] = date('Y-m-d H:i:s');
		$data['pa'] = '1';
		$data['receipt'] = '1';
		$uid2 = $uid['uid'];
		
		$this->Mix->update_record('uid',$uid2,$data,'tx_rwadminhotel_booking');
		$this->update_hotel($uid2);
		$this->disable_complimentary();
        $post_data['title']="Member | Reservation | Use Reservation For ? ";
        $post_data['page'] = "business/save_reservation";
        $post_data['nav'] = "reservation";
        $post_data['template']=base_url()."asset/theme/mygoldenvip/";
		$post_data['destination'] = $this->Mix->dropdown_menu('uid','destination','tx_rwmembermlm_destination');
        
        $this->load->vars($post_data);
        $this->load->view('member/template');
	}
	
	function update_hotel($uid)
	{
		$uid_room = $this->Mix->read_row_ret_field_by_value('tx_rwadminhotel_booking','uid_room',$uid,'uid');
		$qty = $this->Mix->read_row_ret_field_by_value('tx_rwadminhotel_booking','qty',$uid,'uid');
		$stok = $this->Mix->read_row_ret_field_by_value('tx_rwadminhotel_cat_room','stok',$uid_room['uid_room'],'uid');
		$data['stok'] = $stok['stok']-$qty['qty'];
		
		$this->Mix->update_record('uid',$uid_room['uid_room'],$data,'tx_rwadminhotel_cat_room'); 
	}
	
	function disable_complimentary()
	{
		$uid = $this->session->userdata('member');
		$data['compliment'] = '1';
		$this->Mix->update_record('uid',$uid,$data,'tx_rwmembermlm_member'); 
	}
}
?>