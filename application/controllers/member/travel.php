<?php
class Travel extends CI_Controller
{
	function index()
	{
		$this->get_data_package();
		//$this->get_pdf();
	}
	
	function get_data_package()
	{
		$data['destination'] = $this->Mix->read_package_by_pid('2');
		$data['pid'] = '2';
		$data['title']="Member | Home Page | Reservation";
        $data['page'] = "travel/reservation";
        $data['nav'] = "reservation";
		$data['template']=base_url()."asset/theme/mygoldenvip/";
		$m = $this->Mix->read_row_by_one('uid',$this->session->userdata('member'),'tx_rwmembermlm_member');
		if($m['package'] != '2')
		{
			$data['set_compliment'] = '0';
		}
		else
		{
			$data['set_compliment'] = '1';
		}
		
		$this->load->vars($data);
        $this->load->view('member/template');
	}
function package_selected()
	{
		is_member();
		/* check : 	jika terdapat data dengan inisiasi hidden 1 artinya dahulu user pernah akan reservasi tetapi tidak sampai akhir, 
					hapus data tersebut */
		$check = $this->Mix->read_row_by_two('uid_member',$this->session->userdata('member'),'hidden','1','tx_rwagen_travelbooking');
		if(!empty($check))
		{
			$this->Mix->dell_one_by_one('uid',$check['uid'],'tx_rwagen_travelbooking');
		}
		/* end dari pengecekan */
		$data = array();
		$insert = array();
		$tujuan = $this->input->post('destination');
		$tanggal = $this->input->post('datepicker');
		/* insert into table booking by travel */
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
		$this->Mix->add_with_array($insert,'tx_rwagen_travelbooking');
		/* end */
				
		$sql = "select a.uid,a.time_sch, a.qty, a.booking, b.nama, c.name, d.destination
				from tx_rwagen_travelschedule a, 
				tx_rwagen_travelpackage b, 
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
        $data['page'] = "travel/package_selected";
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
		$check = $this->Mix->read_row_by_two('uid_member',$this->session->userdata('member'),'hidden','1','tx_rwagen_travelbooking');
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
			
			$d = $this->Mix->read_row_ret_field_by_value('tx_rwagen_travelschedule','booking',$this->input->post('uid_sch'),'uid'); 
			$q = $this->Mix->read_row_ret_field_by_value('tx_rwagen_travelschedule','qty',$this->input->post('uid_sch'),'uid'); 
			
			$qty = $qty + $d['booking'];
			if($qty > $q['qty'])
			{
				echo "<b>sorry is not enough quota <b>"; 
				redirect('member/reservation/travel','refresh');
			}
			else
			{
				$quote['booking'] = $qty;
				$this->Mix->update_record('uid',$this->input->post('uid_sch'),$quote,'tx_rwagen_travelschedule');
				$this->Mix->update_record('uid',$check['uid'],$up,'tx_rwagen_travelbooking');
			}
			
		}
		/* data halaman */
		$data['page'] = "travel/use_this_reservation_for";
		$data['title']="Member | Home Page | Reservation";
        $data['nav'] = "reservation";
        $this->load->vars($data);
       	$this->load->view('member/template');
	}
	
	function set_for_myself()
	{
		is_member();
		$check = $this->Mix->read_row_by_two('uid_member',$this->session->userdata('member'),'hidden','1','tx_rwagen_travelbooking');
		if(!empty($check))
		{
			$up['hidden'] = '0';
			if($check['qty'] == 1)
			{
				$this->set_data_final_booking_travel_click_myself();
				disable_complimentary();
				$this->Mix->update_record('uid',$check['uid'],$up,'tx_rwagen_travelbooking');
				$this->get_pdf($check['uid'],$check['qty']);
				
				//$data['title']="Member | Reservation | Thank you ";
				//$data['page'] = "business/save_reservation";
				//$data['nav'] = "reservation";
				//$this->load->vars($data);
				//$this->load->view('member/template');
			}
			else
			{
				$this->set_data_final_booking_travel_click_myself();
				$this->set_for_other($check['qty'],1, 'and Myself');
			}
		}
		else
		{
			redirect('member/reservation/travel','refresh');

		}
	}
	
	function set_data_final_booking_travel_click_myself()
	{
		$sql = "select a.uid as uid_booking, b.uid as uid_sch, c.harga from tx_rwagen_travelbooking a, tx_rwagen_travelschedule b, tx_rwagen_travelpackage c
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
		# menambahkan data pada tabel travel booking detail
		$this->Mix->add_with_array($data,'tx_rwagen_travelbookingdetails');
	}
	
	function set_for_other($qty = '1',$myself = 0,$me = '')
	{
		is_member();
		$data = array();
		$check = $this->Mix->read_row_by_two('uid_member',$this->session->userdata('member'),'hidden','1','tx_rwagen_travelbooking');
		if(!empty($check))
		{
			$sql = "select a.uid,a.time_sch, a.qty, a.booking, b.nama as package, c.name as travel, d.destination, b.harga as retail_rate
					from tx_rwagen_travelschedule a, 
					tx_rwagen_travelpackage b, 
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
			$data['page'] = "travel/set_for_other";
			$data['title']="Member | Home Page | Reservation";
			$data['nav'] = "reservation";
			$this->load->vars($data);
			$this->load->view('member/template');
		}
		else
		{
			redirect('member/reservation/travel','refresh');
		}
	}
	
	function set_reservation()
	{
		is_member();
		$data = array();
		$check = $this->Mix->read_row_by_two('uid_member',$this->session->userdata('member'),'hidden','1','tx_rwagen_travelbooking');
		if(!empty($check))
		{
			$sql = "select a.uid as uid_booking, b.uid as uid_sch, c.harga from tx_rwagen_travelbooking a, tx_rwagen_travelschedule b, tx_rwagen_travelpackage c
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
				$this->Mix->add_with_array($data,'tx_rwagen_travelbookingdetails');
			}
			
			$up['hidden'] = '0';
			$this->Mix->update_record('uid',$get_data_sch['uid_booking'],$up,'tx_rwagen_travelbooking');
			$this->get_pdf($check['uid'],$check['qty']);
			
			//$page['title']="Member | Reservation | Thank you ";
			//$page['page'] = "business/save_reservation";
			//$page['nav'] = "reservation";
			
			//$this->load->vars($page);
			//$this->load->view('member/template');
		}
		else
		{
			redirect('member/reservation/travel','refresh');
		}
	}
	
	function get_pdf($uid = 0, $limit = 0)
	{
		$sql = "select a.uid, a.uid_sch, a.payment, b.nama, b.rate as price, a.qty, c.time_sch, 
				d.nama as package, d.deskripsi, e.name as agen, a.reservation
				from tx_rwagen_travelbooking a,
				tx_rwagen_travelbookingdetails b,
				tx_rwagen_travelschedule c,
				tx_rwagen_travelpackage d,
				tx_rwagen_agen e
				where a.uid='$uid' 
				and a.uid = b.pid
				and a.uid_sch = c.uid 
				and c.package = d.uid 
				and e.uid = c.agen limit 0,$limit";
		$data = $this->Mix->read_more_rows_by_sql($sql);
		foreach($data as $row)
		{
			$pdf['payment'] = $row['payment'];
			$pdf['price'] = $row['price'];
			$pdf['qty'] = $row['qty'];
			$pdf['package'] = $row['package'];
			$pdf['deskripsi'] = $row['deskripsi'];
			$pdf['depart'] = $row['time_sch'];
			$pdf['status'] = $row['reservation'];
			$pdf['id_booking'] = $row['uid'];
			$pdf['agen'] = $row['agen'];
		}
		
		//debug_data($pdf);
		 
		$this->fpdf->FPDF('P','cm','A4');
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
		foreach($data as $row)
		{
			$this->fpdf->text(6.6,$y,': '.$row['nama']);
			$y = $y+ 0.5;
		}
		
		
		$this->fpdf->text(1.6,$y+0.5,'Status ');
		$this->fpdf->text(6.6,$y+0.5,': '.$pdf['status']);
		
		$this->fpdf->text(1.6,$y+1,'Depart ');
		$this->fpdf->text(6.6,$y+1,': '.$pdf['depart']);
		  
		$this->fpdf->text(1.6,$y+1.5,"Package ");
		$this->fpdf->text(6.6,$y+1.5,": ".$pdf['package']);
		
		$this->fpdf->text(1.6,$y+2,'Agen ');
		$this->fpdf->text(6.6,$y+2,': '.$pdf['agen']);
		
		$this->fpdf->text(1.6,$y+2.5,'Qty ');
		$this->fpdf->text(6.6,$y+2.5,': '.$pdf['qty']);
		
		$this->fpdf->text(1.6,$y+3,'Price ');
		$this->fpdf->text(6.6,$y+3,': USD '.$pdf['price']);
		
		$this->fpdf->text(1.6,$y+3.5,'Payment ');
		$this->fpdf->text(6.6,$y+3.5,': '.$pdf['payment']);
		
		$this->fpdf->Output();
		 
	}
}