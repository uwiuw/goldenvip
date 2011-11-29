<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	/**
	 * 	Index Page for this controller.
	 *
	 *	contact : archievenolgede@ymail.com
	 *	15/10/2011
	 */
	function index()
	{
		$this->homepage();
	}
	function homepage()	# home uri
	{
		$uri = $this->uri->segment('2');
		if($uri=='post_data')
		{
			is_login(); # check valid user {member or admin} 
			$url = $this->uri->segment('3');
			$this->post_data($url);
		}
		else
		{
			$data['title']="MyGoldenVIp.com";
			$data['page'] = "homepage";
			$data['nav'] = "homepage";
			$data['template']=base_url()."asset/theme/mygoldenvip/"; 
			
			$this->load->vars($data);
			$this->load->view('public/template');
		}
	}
	function about()
	{
		$data['title']="MyGoldenVIp.com";
		$data['page'] = "about";
		$data['nav'] = "about";
		$data['template']=base_url()."asset/theme/mygoldenvip/"; 
		
		$this->load->vars($data);
		$this->load->view('public/template');
	}
	function products()
	{
		$data['title']="MyGoldenVIp.com";
		$data['page'] = "products";
		$data['nav'] = "products";
		$data['template']=base_url()."asset/theme/mygoldenvip/"; 
		
		$this->load->vars($data);
		$this->load->view('public/template');
	}
	function news()
	{
		$data['title']="MyGoldenVIp.com";
		$data['page'] = "news";
		$data['nav'] = "news";
		$data['template']=base_url()."asset/theme/mygoldenvip/"; 
		
		$this->load->vars($data);
		$this->load->view('public/template');
	}
	function faq()
	{
		$data['title']="MyGoldenVIp.com";
		$data['page'] = "faq";
		$data['nav'] = "faq";
		$data['template']=base_url()."asset/theme/mygoldenvip/"; 
		
		$this->load->vars($data);
		$this->load->view('public/template');
	}
	function contact()
	{
		$data['title']="MyGoldenVIp.com";
		$data['page'] = "contact";
		$data['nav'] = "contact";
		$data['template']=base_url()."asset/theme/mygoldenvip/"; 
		
		$this->load->vars($data);
		$this->load->view('public/template');
	}
	
	function post_data($data) # fungsi untuk redirect url path
	{
		switch($data)
		{
			case "del_dist": # site_url/segment_2/del_dist/segment_4
				$this->del_dist();
				break;
			case "get_member";
				$this->get_member();
				break;
			case "get_phone_code":
				$this->get_phone_code();
				break;
			case "get_province":
				$this->get_province();
				break;
			case "get_city":
				$this->get_city();
				break;
			case "get_regional":
				$this->get_regional();
				break;
			case "search_distributor":
				$this->search_distributor();
				break;
			case "get_vc_by_dist":
				$this->get_vc_by_dist();
				break;
			case "get_distributor":
				$this->get_distributor();
				break;
			case "get_pck2":
				$this->get_pck2();
				break;	
			case "get_pck3":
				$this->get_pck3();
				break;
			
		}
	}
	
	# call action function from site_url/segment_2/segment_3/uri
	
	function del_dist()
	{
		$uri = $this->uri->segment('4');
		echo "data telah berhasil dihapus";
	}
	function get_member()
	{
		$uid = $this->uri->segment('4');
		$pid = $this->uri->segment('5');
		$data['page'] = getMemberByUid($uid,$pid);
		$data['bank'] = $this->Mix->dropdown_menu('uid','bank','tx_rwmembermlm_bank');
		$data['country'] = $this->Mix->dropdown_menu('uid','country','tx_rwmembermlm_phonecountrycode');
		$data['province'] = $this->Mix->dropdown_menu('uid','province','tx_rwmembermlm_province');
		$data['city'] = $this->Mix->dropdown_menu('uid','city','tx_rwmembermlm_city');
		$data['code'] = $this->Mix->dropdown_menu('uid','code','tx_rwmembermlm_phonecountrycode'); 
		
		$this->load->vars($data);
		$this->load->view('panel/page/distributor/get_member');
	}
	function get_phone_code()
	{
		$url = $this->uri->segment('4');
		$code = $this->Mix->dropdown_menu('uid','code','tx_rwmembermlm_phonecountrycode'); 	
		echo $code[$url];
	}
	function get_province()
	{
		$url = $this->uri->segment('4');
		$province = $this->Mix->read_province($url);
		$id = "id='province' onchange='get_city();'";
		echo form_dropdown('province',$province,'0',$id);
	}
	function get_city()
	{
		$url = $this->uri->segment('4');
		$city = $this->Mix->read_city($url);
		$id = "id='city'";
		echo form_dropdown('city',$city,'1',$id);
		 
	}
	function get_regional()
	{
		$url = $this->uri->segment('4');
		$regional = $this->Mix->read_city($url);
		$id = "id='regional' onchange='regional_change();'";
		echo form_dropdown('regional',$regional,'1',$id); 
	}
	function search_distributor()
	{
		$val = $this->input->post('reg');
		$cat = $this->input->post('cat');
		$sql = "select m.uid, m.pid, m.firstname, m.lastname, m.email, m.username, m.mobilephone, c.city from tx_rwmembermlm_member m, tx_rwmembermlm_city c where c.uid = m.regional and m.usercategory='".$cat."' and m.firstname like '%".$val."%' and m.pid = '67'";
		$data = $this->Mix->read_more_rows_by_sql($sql);
		$i=1;
		if(!empty($data))
		{
			foreach($data as $row)
			{
			echo "
				<tr valign='top'> 
					<td width='7%'>
						$i.
					</td>
					<td class='name-data'>
					   ".$row['firstname'].' '.$row['lastname']."             
					</td>
					<td>
						".$row['email']."
					</td>
					<td>
						".$row['username']."
					</td>
					<td>
						".$row['mobilephone']."
					</td>
					<td>
						".$row['city']."
					</td>
					<td>
					<a href='javascript:void();' onclick='load(\"_admin/post_data/get_member/".$row['uid']."/".$row['pid']."\",\"#site-content\")' class='browse'></a><a href='javascript:void();' onclick=\"dialog_box_delete('".$row['uid']."','".$row['firstname'].' '.$row['lastname']."');\" class='del-data'></a>
					</td>
				</tr>  ";
				$i++;
			} 
		}
		else
		{
			echo "<tr><td colspan='7'>Not Found</td></tr>";
		}
	}
	
	function get_vc_by_dist()
	{
		$url = $this->uri->segment('4');
		$data = get_vc_member($url);
		$this->load->view('panel/page/distributor/dist_vc',$data);
	}
	
	function get_distributor()
	{
		$url = $this->uri->segment('4');
		$distributor = $this->Mix->read_disrtibutor($url);
		$id = "id='distributor' onchange='get_vc()'";
		echo form_dropdown('distributor',$distributor,'1',$id);
	}
	
	function get_pck2()
	{
		$url = $this->uri->segment('4'); 
		$package2 = $this->Mix->dropdown_menu('uid','package','tx_rwmembermlm_package','0',$url);
		$id = "id='package2' onchange='select_package2()'";
		
		echo form_dropdown('package2',$package2,'1',$id);
	}
	
	function get_pck3()
	{
		$url = $this->uri->segment('4'); 
		$package3 = $this->Mix->dropdown_menu('uid','package','tx_rwmembermlm_package','0',$url);
		$id = "id='package3'";
		echo form_dropdown('package3',$package3,'1',$id);
	}
}