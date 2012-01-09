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
		is_admin();
		$this->load->view('panel/template');
	}
	
	function login()
	{
		is_login();
		$this->load->view('panel/login');
	}
	
	function check_login()
	{
		if($this->input->post('log') and $this->input->post('pwd'))
		{
			$name = $this->input->post('log');
			$pwd = $this->input->post('pwd');
			if(admin_login($name,$pwd))
			{
				$data['admin'] ='admin-on';
				$this->session->set_userdata($data);
				redirect('_admin/login','refresh');
			}
			else
			{
				$this->session->set_flashdata('info','Re-check your valid Username and Password !!');
				redirect('_admin/login','refresh');
			}
		}
		else
		{
			$this->session->set_flashdata('info','Blank__');
			redirect('_admin/login','refresh');
		}		
	}
	
	function logout()
	{
		$this->session->unset_userdata('admin');
		redirect('_admin/login','refresh');
	}
	
	function home_page()
	{
		is_admin();
		$this->load->view('panel/page/home_page');
	}
	
	#	Distributor
	function list_distributor()
	{
		is_admin();
                $limit = $_GET['per_page'];
                $nilai = 20;
                if($limit==0):
                    $limit = $nilai;
                else:
                    $limit=$limit+$nilai;
                endif;
		$data['data'] = getAccountMLM('3',$limit);
		$data['path'] = "Distributor";
                $data['nilai']=$nilai;
                $this->load->library('pagination');
               
                $sum_rows = getAccountMLM();
                $total_rows = count($sum_rows);
                $per_page = $nilai;
                $num_links = $total_rows / $per_page;
                $config['base_url']= site_url('_admin/distributor/?page');
                $config['total_rows'] = $total_rows;
                $config['per_page'] = $per_page;
                $config['num_links'] = $num_links;
                $config['full_tag_open'] = "<div id='pagination'>";
                $config['full_tag_close'] = "</div>";
                $config['page_query_string'] = TRUE;

                $this->pagination->initialize($config);
                $data['limit'] = $limit;
                
		$this->load->view('panel/page/list_account',$data); 
	}
		# delete data distributor
	function del_distributor()
	{
		is_admin();
		echo $this->session->userdata('del_uid');
		#$this->session->unset_userdata('del_uid');
	}
	
	# Member
	function list_member()
	{
		is_admin();
                $nilai = 20;
                $limit = $_GET['per_page'];
                if($limit==0):
                    $limit = $nilai;
                else:
                    $limit=$limit+$nilai;
                endif;
		$data['data'] = getAccountMLM('4',$limit);
                $data['nilai']=$nilai;
                $this->load->library('pagination');
               
                $sum_rows = getAccountMLM('4');
                $total_rows = count($sum_rows);
                $per_page = $nilai;
                $num_links = $total_rows / $per_page;
                $config['base_url']= site_url('_admin/member/?page');
                $config['total_rows'] = $total_rows;
                $config['per_page'] = $per_page;
                $config['num_links'] = $num_links;
                $config['full_tag_open'] = "<div id='pagination'>";
                $config['full_tag_close'] = "</div>";
                $config['page_query_string'] = TRUE;
                $this->pagination->initialize($config);
                $data['limit'] = $limit;
		$data['path'] = "Member";
		$this->load->view('panel/page/list_account',$data); 
	}
	
	# voucher code management
	function list_voucher()
	{
		is_admin();
		$data['data'] = getAccountMLM(); // data yang diambil adalah data distributor itu defaultnya jika disii parameter 4 maka ia akan menampilkan data member
		$sql = "select a.* from tx_rwmembermlm_vouchercode a, tx_rwmembermlm_member b 
where a.distributor = b.uid ";
		$data['total_data'] = $this->Mix->read_more_rows_by_sql($sql);
		
		$sql = "select count(a.uid) as data_used from tx_rwmembermlm_vouchercode a, tx_rwmembermlm_member b 
where a.distributor = b.uid and status='1' ";
		$data['data_used'] = $this->Mix->read_rows_by_sql($sql);
		
		$sql = "select count(a.uid) as data_unused from tx_rwmembermlm_vouchercode a, tx_rwmembermlm_member b 
where a.distributor = b.uid and status='0'";
		$data['data_unused'] = $this->Mix->read_rows_by_sql($sql);
		
		$this->load->view('panel/page/distributor/list_voucher',$data); 
	}
	
	# voucher code generate
	function generate_vc()
	{
		is_admin();
		$data['data'] = getAccountMLM(); 
		$this->load->view('panel/page/distributor/generate_vc',$data); 
	}
	
	# take_post_and_generate_vc
	function take_post_and_generate_vc()
	{
		is_admin();
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
					$data['crdate'] = mktime(date('H'),date('i'),date('s'),date('m'),date('d'),date('y'));
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
	
	function update_data_member()
	{
		is_admin();
		$data = array();
		$uid = $this->input->post('uid');
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
		echo "
				<script type=\"text/javascript\">
					jQuery(function(){
						jQuery('#info-saving').addClass('update-nag');
					});
				</script>
			";
		echo "Data has been update";
	}
	
        # MLM Extra
        function member_migration()
        {
            is_admin();
            $sql = "select
                    a.uid,
                    a.firstname,
                    a.lastname,
                    a.username,
                    a.email,
                    a.mobilephone,
                    a.regional,
                    a.package
                    from 
                    tx_rwmembermlm_member a
                    where
                    a.hidden = 0 and
                    a.valid = 1 and
                    a.package < 3 or
                    a.package > 12
                    order by a.firstname";
            $data['member'] = $this->Mix->read_more_rows_by_sql($sql);
            $this->load->vars($data);
            $this->load->view('panel/page/mlm_extra/member_migration');
        }
        
        function member_set_new_grade()
        {
            is_admin();
            # get upline
            # check fast bonus!
            $uid = $_GET['id'];
            $pack = $_GET['pack'];
            $data['package'] = $pack;
            if($pack == '13')
            {
                $this->Mix->update_record('uid',$uid,$data,'tx_rwmembermlm_member');
                echo "Member has been migrate to Travel package";
            }
            
            if($pack == '12')
            {
                $upline = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','sponsor',$uid,'uid'); // ambil uid sponsor dari uid member
                $comission = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member','commission',$upline['sponsor'],'uid');
                $bonus = $comission['commission']+50;
                
                $insert_into_fast['crdate'] = mktime(date('H'),date('i'),date('s'),date('m'),date('d'),date('y'));;
                $insert_into_fast['uid_member'] = $upline['sponsor'];
                $insert_into_fast['uid_downline'] = $uid;
                $insert_into_fast['deleted'] = 0;
                $insert_into_fast['hidden']=0;
                $insert_into_fast['paid'] = 0;
                $insert_into_fast['bonus'] = 50;
                $insert_into_fast['pid']=67;
                
                $data_update_upline['commission'] = $bonus;
                
                $this->Mix->update_record('uid',$uid,$data,'tx_rwmembermlm_member');
                $this->Mix->update_record('uid',$upline['sponsor'],$data_update_upline,'tx_rwmembermlm_member');
                $this->Mix->add_with_array($insert_into_fast,'tx_rwmembermlm_historyfastbonus');
                
                echo "Member has been migrate to VIP package";
            }
        }
        
        function searching_form()
        {
            is_admin();
            $pilihan = $this->input->post('search');
            switch ($pilihan)
            {
              case "migration":
                  is_admin();
                  $this->search_migration();
                  break;
              case "Distributor":
                  is_admin();
                  $this->search_distributor();
                  break;
              case "Member":
                  is_admin();
                  $this->search_member();
                  break;
              case "display_vocher_code":
                  is_admin();
                  $this->display_voucher_code();
                  break;
            }
        }
        
        function search_migration()
        {
            is_admin();
            $name = $this->input->post('reg');
            $sql = "select
                    a.uid,
                    a.firstname,
                    a.lastname,
                    a.username,
                    a.email,
                    a.mobilephone,
                    a.regional,
                    a.package
                    from 
                    tx_rwmembermlm_member a
                    where
                    a.hidden = 0 and
                    a.valid = 1 and
                    (a.package < 3 or a.package > 12) and
                    (a.firstname like '%$name%' or a.lastname like '%$name%' or a.username like '%$name%')
                    order by a.firstname";
            $data['member'] = $this->Mix->read_more_rows_by_sql($sql);
            
            $this->load->vars($data);
            $this->load->view('panel/page/mlm_extra/member_migration');
        }
        
        function search_distributor()
        {
            is_admin();
            $val = $this->input->post('reg');
            $sql = "select 
                    m.uid, 
                    m.pid, 
                    m.firstname, 
                    m.lastname, 
                    m.email, 
                    m.username, 
                    m.mobilephone, 
                    c.city 
                    from 
                    tx_rwmembermlm_member m, 
                    tx_rwmembermlm_city c 
                    where 
                    c.uid = m.regional and 
                    m.usercategory='3' and 
                    m.firstname like '%".$val."%' and m.pid = '67'";
            $data['data'] = $this->Mix->read_more_rows_by_sql($sql);
            $data['path'] = "Distributor";
            $this->load->view('panel/page/list_account',$data); 
        }
        
        function search_member()
        {
            is_admin();
            $val = $this->input->post('reg');
            $sql = "select 
                    m.uid, 
                    m.pid, 
                    m.firstname, 
                    m.lastname, 
                    m.email, 
                    m.username, 
                    m.mobilephone, 
                    c.city 
                    from 
                    tx_rwmembermlm_member m, 
                    tx_rwmembermlm_city c 
                    where 
                    c.uid = m.regional and 
                    m.usercategory='4' and 
                    m.firstname like '%".$val."%' and m.pid = '67'";
            $data['data'] = $this->Mix->read_more_rows_by_sql($sql);
            $data['path'] = "Member";
            $this->load->view('panel/page/list_account',$data); 
        }
        
        function display_voucher_code()
        {
            is_admin();
            $val = $this->input->post('distributor');
            $data['data'] = getAccountMLM(); // data yang diambil adalah data distributor itu defaultnya jika disii parameter 4 maka ia akan menampilkan data member
            
            $sql = "select 
                    a.* 
                    from 
                    tx_rwmembermlm_vouchercode a, 
                    tx_rwmembermlm_member b 
                    where 
                    a.distributor = b.uid and
                    a.distributor = '$val'";
            $data['total_data'] = $this->Mix->read_more_rows_by_sql($sql);

            $sql = "select 
                    count(a.uid) as data_used 
                    from 
                    tx_rwmembermlm_vouchercode a, 
                    tx_rwmembermlm_member b 
                    where 
                    a.distributor = b.uid and 
                    status='1' and
                    a.distributor = '$val'";
            $data['data_used'] = $this->Mix->read_rows_by_sql($sql);

            $sql = "select 
                    count(a.uid) as data_unused 
                    from tx_rwmembermlm_vouchercode a, 
                    tx_rwmembermlm_member b 
                    where 
                    a.distributor = b.uid and 
                    status='0' and
                    a.distributor = '$val'";
            $data['data_unused'] = $this->Mix->read_rows_by_sql($sql);

            $this->load->view('panel/page/distributor/list_voucher',$data);
        }
}