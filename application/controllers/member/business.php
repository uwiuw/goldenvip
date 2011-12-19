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
		
		$m = $this->Mix->read_row_by_one('uid',$this->session->userdata('member'),'tx_rwmembermlm_member');
		if($m['package'] !='1' and $m['package'] !='0')
		{
			$data['set_compliment'] = '0';
		}
		else
		{
			$data['set_compliment'] = '1';
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
		if($this->input->post('destination_detail'))
		{
			$w = "uid_destination = '".$this->input->post('destination')."' and uid_destination_detail = '".$this->input->post('destination_detail')."'";
		}
		else
		{
			$w = "uid_destination = '".$this->input->post('destination')."'";
		}
		$destination = $this->input->post('destination');
		
		$sql = "select uid,hotel_name,star,location from tx_rwadminhotel_hotel 
				where $w order by star asc";
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
		
		if(!empty($uid))
		{
			
			if($this->input->post('name'))
			{
				$data['name_reservation'] = $this->input->post('name');
				$data['email'] = $this->input->post('email');
				$data['insurance'] = $this->input->post('mega');
			}
			
			$data['hidden'] = '0';
			$data['date_booking'] = date('Y-m-d H:i:s');
			$data['pa'] = '1';
			$data['receipt'] = '1';
			$uid2 = $uid['uid'];
			
			$this->Mix->update_record('uid',$uid2,$data,'tx_rwadminhotel_booking');
			$this->update_hotel($uid2);
			disable_complimentary();
			
			$this->get_pdf($uid['uid']);
		}
		else
		{
			redirect('member/reservation/business','refresh');
		}
		
        //$post_data['title']="Member | Reservation | Use Reservation For ? ";
        //$post_data['page'] = "business/save_reservation";
        //$post_data['nav'] = "reservation";
        //$post_data['template']=base_url()."asset/theme/mygoldenvip/";
		//$post_data['destination'] = $this->Mix->dropdown_menu('uid','destination','tx_rwmembermlm_destination');
        
        //$this->load->vars($post_data);
        //$this->load->view('member/template');
	}
	
	function update_hotel($uid)
	{
		$uid_room = $this->Mix->read_row_ret_field_by_value('tx_rwadminhotel_booking','uid_room',$uid,'uid');
		$qty = $this->Mix->read_row_ret_field_by_value('tx_rwadminhotel_booking','qty',$uid,'uid');
		$stok = $this->Mix->read_row_ret_field_by_value('tx_rwadminhotel_cat_room','stok',$uid_room['uid_room'],'uid');
		$data['stok'] = $stok['stok']-$qty['qty'];
		
		$this->Mix->update_record('uid',$uid_room['uid_room'],$data,'tx_rwadminhotel_cat_room'); 
	}
	
	function set_for_other()
	{
		is_member();
		$data = array();
		$u = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','username',$this->session->userdata('member'),'uid');
		$uid_member = $this->Mix->read_row_ret_field_by_value('fe_users','uid',$u['username'],'username');
		$check = $this->Mix->read_row_by_two('uid_member',$uid_member['uid'],'hidden','1','tx_rwadminhotel_booking');
		if(!empty($check))
		{
			$sql = "select c.username, d.firstname,a.qty, a.check_in, a.rate as retail_rate, a.check_out, a.uid_room, a.uid_member, b.category_name from 
					tx_rwadminhotel_booking a,
					tx_rwadminhotel_cat_room b,
					fe_users c,
					tx_rwmembermlm_member d
					where 
					a.uid_room = b.uid and
					c.uid = a.uid_member and
					d.username = c.username and
					a.uid_member = '".$uid_member['uid']."' and 
					a.hidden = '1'";
			/* data halaman */
			if($check['reservation']!='Compliment'){$data['compliment_only'] = '0'; $qty=$check['qty']-$myself;}
			else{$data['compliment_only'] = '1';$data['hidden'] = '<input type="hidden" name="compliment" value="1">';}
			$data['sch'] = $this->Mix->read_rows_by_sql($sql);
			$data['qty'] = 1;
			$data['page'] = "business/set_for_other";
			$data['title']="Member | Home Page | Reservation";
			$data['nav'] = "reservation";
			$this->load->vars($data);
			$this->load->view('member/template');
		}
		else
		{
			redirect('member/reservation/business','refresh');
		}
	}
	 
	 function get_pdf($uid = 0)
	{
		$sql = "select a.uid as id_booking, a.name_reservation as name, a.reservation as status ,
				a.check_in, a.check_out,c.hotel_name,b.category_name as room, 
				a.qty, a.rate as price, a.payment 
				from tx_rwadminhotel_booking a INNER JOIN tx_rwadminhotel_cat_room b ON a.uid_room=b.uid 
				INNER JOIN tx_rwadminhotel_hotel c ON b.uid_hotel=c.uid 
				where a.deleted=0
				and a.uid='".$uid."'";
		$pdf = $this->Mix->read_rows_by_sql($sql); 
		
		$this->fpdf->FPDF('P','cm','LEGAL');
        $this->fpdf->SetTopMargin(2);
		$this->fpdf->SetLeftMargin(2);
		$this->fpdf->Ln();
        $this->fpdf->AddPage();
		$this->fpdf->Image(base_url().'upload/pics/logo.jpg',1.6,1.4,3.5);      
        $this->fpdf->ln(0); 
		$this->fpdf->SetFont('Arial','i',12);
		$this->fpdf->text(8.6,3,'Payment of Receipt ');
		
		$this->fpdf->text(1.6,4,'ID Booking ');
		$this->fpdf->text(6.6,4,': '.$pdf['id_booking']);
		
		$y = 4.5;
		$this->fpdf->text(1.6,4.5,'Name Reservation '); 
		$this->fpdf->text(6.6,$y,': '.$pdf['name']);
		
		$this->fpdf->text(1.6,$y+0.5,'Status ');
		$this->fpdf->text(6.6,$y+0.5,': '.$pdf['status']);
		
		//$this->fpdf->text(1.6,$y+1,'Depart ');
		//$this->fpdf->text(6.6,$y+1,': '.$pdf['depart']);
		
		$this->fpdf->text(1.6,$y+1.5,'Check-In ');
		$this->fpdf->text(6.6,$y+1.5,': '.$pdf['check_in']);
		
		$this->fpdf->text(1.6,$y+2,'Check-Out ');
		$this->fpdf->text(6.6,$y+2,': '.$pdf['check_out']);
		
		$this->fpdf->text(1.6,$y+2.5,"Hotel's Name ");
		$this->fpdf->text(6.6,$y+2.5,": ".$pdf['hotel_name']);
		
		$this->fpdf->text(1.6,$y+3,'Room Type ');
		$this->fpdf->text(6.6,$y+3,': '.$pdf['room']);
		
		$this->fpdf->text(1.6,$y+3.5,'Qty ');
		$this->fpdf->text(6.6,$y+3.5,': '.$pdf['qty']);
		
		$this->fpdf->text(1.6,$y+4,'Price ');
		$this->fpdf->text(6.6,$y+4,': IDR '.$pdf['price']);
		
		$this->fpdf->text(1.6,$y+4.5,'Payment ');
		$this->fpdf->text(6.6,$y+4.5,': '.$pdf['payment']);
		
		$this->fpdf->Output();
	
		 
	}
}
?>