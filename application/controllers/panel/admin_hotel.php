<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of admin_hotel
 *
 * @author aceng nursamsudin
 */
class Admin_hotel extends CI_Controller{
    //put your code here
    public function index()
    {
        $this->hotel_management();
    }
    function hotel_management()
    {
        is_admin();
        $limit = $_GET['per_page'];
        if($limit==0):
            $limit = 10;
        else:
            $limit=$limit+10;
        endif;
        $sql = "select
                c.uid,
                c.hotel_name, 
                a.destination,
                b.destination_detail,
                c.star,
                case c.compliment when 1 then 'Yes' else 'No' end as compliment,
                c.hidden
                from
                tx_rwadminhotel_hotel c left join 
                tx_rwmembermlm_destination_detail b on c.uid_destination_detail = b.uid ,
                tx_rwmembermlm_destination a
                where
                c.uid_destination = a.uid 
                order by c.hotel_name limit 0,$limit";
        $data['d_hotel'] = $this->Mix->read_more_rows_by_sql($sql);
        
        $this->load->library('pagination');
        $total_rows = $this->db->count_all('tx_rwadminhotel_hotel');
        $per_page = 10;
        $num_links = $total_rows / $per_page;
        $config['base_url']= site_url('_admin/hotel/pagination/?page');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['num_links'] = $num_links;
        $config['full_tag_open'] = "<div id='pagination'>";
        $config['full_tag_close'] = "</div>";
        $config['page_query_string'] = TRUE;
        
        $this->pagination->initialize($config);
        $data['limit'] = $limit;
        //debug_data($data);
        $this->load->view('panel/page/hotel/management',$data);
    }
    
    function add_new_data_hotel()
    {
       $data['destination'] = $this->Mix->read_package_by_pid();
       $data['compliment'] = array('1'=>'--yes--','0'=>'--No--');
       $data['by_core'] = array('1'=>'--yes--','0'=>'--No--');
       $data['star'] = array(''=>'-- select --', '4'=>'4','5'=>'5');
       $this->load->vars($data);
       $this->load->view('panel/page/hotel/add_new_hotel');
    }
    
    function member_profit()
    {
        is_admin();
        $limit = $_GET['per_page'];
        if($limit==0):
            $limit = 10;
        else:
            $limit=$limit+10;
        endif;
//        with limit
        $sql = "select 
                a.uid,
                a.hidden,
                a.uid_member,
                a.date_booking,
                b.username,
                a.name_reservation,
                c.category_name,
                d.hotel_name,
                case a.payed when 1 then 'Paid' else 'No' end as Paid
                from
                tx_rwadminhotel_booking a,
                fe_users b,
                tx_rwadminhotel_cat_room c,
                tx_rwadminhotel_hotel d
                where
                a.uid_member = b.uid and
                a.uid_room = c.uid and
                c.uid_hotel = d.uid and 
                a.payed = 0
                order by a.name_reservation limit 0,$limit";
        $data['d_member_profit'] = $this->Mix->read_more_rows_by_sql($sql);
        
//        with out limit
        $sql2 = "select 
                a.uid,
                a.hidden,
                a.uid_member,
                a.date_booking,
                b.username,
                a.name_reservation,
                c.category_name,
                d.hotel_name,
                case a.payed when 1 then 'Paid' else 'No-Paid' end as Paid
                from
                tx_rwadminhotel_booking a,
                fe_users b,
                tx_rwadminhotel_cat_room c,
                tx_rwadminhotel_hotel d
                where
                a.uid_member = b.uid and
                a.uid_room = c.uid and
                c.uid_hotel = d.uid and 
                a.payed = 0
                order by a.name_reservation";
        $jumlah_data = $this->Mix->read_more_rows_by_sql($sql2);
        
        $this->load->library('pagination');
        $total_rows = count($jumlah_data);
        $per_page = 10;
        $num_links = $total_rows / $per_page;
        $config['base_url']= site_url('_admin/hotel/member_profit/?page');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['num_links'] = $num_links;
        $config['full_tag_open'] = "<div id='pagination'>";
        $config['full_tag_close'] = "</div>";
        $config['page_query_string'] = TRUE;
        
        $this->pagination->initialize($config);
        $data['limit'] = $limit;
//        debug_data($data);
        $this->load->view('panel/page/hotel/member_profit',$data);
    }
    
    function golden_vip_rate()
    {
        is_admin();
        $limit = $_GET['per_page'];
        if($limit==0):
            $limit = 10;
        else:
            $limit=$limit+10;
        endif;
//        with limit
        $sql = "select 
                a.uid,
                a.category_name,
                a.published_rate,
                a.rate as retail,
                a.retail_rate as golden_rate,
                b.hotel_name
                from
                tx_rwadminhotel_cat_room a,
                tx_rwadminhotel_hotel b
                where
                a.uid_hotel = b.uid and
                a.hidden = 0
                order by b.hotel_name limit 0,$limit";
        $data['d_golden_rate'] = $this->Mix->read_more_rows_by_sql($sql);
        //        with out limit
        $sql2 = "select 
                a.category_name,
                a.published_rate,
                a.rate,
                a.retail_rate,
                b.hotel_name
                from
                tx_rwadminhotel_cat_room a,
                tx_rwadminhotel_hotel b
                where
                a.uid_hotel = b.uid and
                a.hidden = 0
                order by b.hotel_name";
        
        $jumlah_data = $this->Mix->read_more_rows_by_sql($sql2);
        
        $this->load->library('pagination');
        $total_rows = count($jumlah_data);
        $per_page = 10;
        $num_links = $total_rows / $per_page;
        $config['base_url']= site_url('_admin/hotel/golden_vip_rate/?page');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['num_links'] = $num_links;
        $config['full_tag_open'] = "<div id='pagination'>";
        $config['full_tag_close'] = "</div>";
        $config['page_query_string'] = TRUE;
        
        $this->pagination->initialize($config);
        $data['limit'] = $limit;
//        debug_data($data);
        $this->load->view('panel/page/hotel/golden_vip_rate',$data);
    }
    
    function destination()
    {
         is_admin();
        $limit = $_GET['per_page'];
        if($limit==0):
            $limit = 10;
        else:
            $limit=$limit+10;
        endif;
//        with limit
        $sql = "select 
                a.uid,
                a.destination
                from
                tx_rwmembermlm_destination a
                where 
                pid = 0
                order by a.destination limit 0,$limit";
        $data['d_golden_rate'] = $this->Mix->read_more_rows_by_sql($sql);
        //        with out limit
        $sql2 = "select 
                a.uid,
                a.destination
                from
                tx_rwmembermlm_destination a
                where 
                pid = 0";
        
        $jumlah_data = $this->Mix->read_more_rows_by_sql($sql2);
        
        $this->load->library('pagination');
        $total_rows = count($jumlah_data);
        $per_page = 10;
        $num_links = $total_rows / $per_page;
        $config['base_url']= site_url('_admin/hotel/destination/?page');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['num_links'] = $num_links;
        $config['full_tag_open'] = "<div id='pagination'>";
        $config['full_tag_close'] = "</div>";
        $config['page_query_string'] = TRUE;
        
        $this->pagination->initialize($config);
        $data['limit'] = $limit;
//        debug_data($data);
        $this->load->view('panel/page/hotel/destination',$data);
    }
    
    function saving_destination()
    {
        $data['destination'] = $this->input->post('destination');
        $sql = "select * from tx_rwmembermlm_destination where destination like '%".$data['destination']."%'";
        $d = $this->Mix->read_rows_by_sql($sql);
        if(empty($d)):
            $data['pid'] = 0;
            $tb = 'tx_rwmembermlm_destination';
            $this->Mix->add_with_array($data,$tb);
            echo "New destination has been save";
        else:
            echo "sorry destination already exists";
        endif;
    }
    function read_address()
    {
        is_admin();
        $act = $_GET['act'];
        switch ($act):
            case "get_detail":
                $uid = $_GET['uid'];
                $this->get_detail($uid);
                break;
            case "get_detail_destination":
                $uid = $_GET['uid'];
                $this->get_detail_destination($uid);
                break;
            case "switch_data_hotel":
                $this->switch_status_data_hotel();
                break;
            case "paid_profit":
                $uid = $_GET['uid'];
                $this->paid_profit($uid);
                break;
            case "edit_golden_rate":
                $uid = $_GET['uid'];
                $this->edit_golden_rate($uid);
                break;
        endswitch;
    }
    
    function get_detail($uid)
    {
        is_admin();
        $data = array();
        $sql = "select
                c.uid,
                c.hotel_name, 
                a.destination,
                a.uid as uid_destination,
                b.uid as uid_destination_detail,
                b.destination_detail,
                c.star,
                c.compliment ,
                c.hidden,
                c.management_by
                from
                tx_rwadminhotel_hotel c left join 
                tx_rwmembermlm_destination_detail b on c.uid_destination_detail = b.uid ,
                tx_rwmembermlm_destination a
                where
                c.uid_destination = a.uid and
                c.uid = $uid";
        $sql2 = "select
                uid,
                destination
                from
                tx_rwmembermlm_destination
                where
                pid < 1 and
                hidden = 0
                order by destination asc";
        $data['d_hotel'] = $this->Mix->read_rows_by_sql($sql);
        $data['destination'] = $this->Mix->read_package_by_pid();
        if($data['d_hotel']['destination_detail']!=''):
            $sql3 = "select 
                    uid,
                    destination_detail
                    from
                    tx_rwmembermlm_destination_detail
                    where 
                    uid_destination = '".$data['d_hotel']['uid_destination']."'";
            $data['destination_detail']=$this->Mix->read_rows_by_sql_to_dropdown($sql3,'destination_detail');
        endif;
        $data['compliment'] = array('1'=>'--yes--','0'=>'--No--');
        $data['by_core'] = array('1'=>'--yes--','0'=>'--No--');
        $data['star'] = array(''=>'-- select --', '4'=>'4','5'=>'5');
        $this->load->vars($data);
        $this->load->view('panel/page/hotel/get_detail');
    }
    
    function get_detail_destination($uid=0)
    {
        is_admin();
        $sql3 = "select 
                    uid,
                    destination_detail
                    from
                    tx_rwmembermlm_destination_detail
                    where 
                    uid_destination = '".$uid."'";
        $data=$this->Mix->read_rows_by_sql_to_dropdown($sql3,'destination_detail');
        if(!empty($data)):
            echo form_dropdown('destination_detail',$data);
        else:
            echo "&nbsp;";
        endif;
    }
    
    function update_data_hotel()
    {
        is_admin();
        if($this->input->post('uid')):
            $uid = $this->input->post('uid');
            $data['hotel_name'] = $this->input->post('hotel_name');
            $data['uid_destination'] = $this->input->post('destination');
            $data['star'] = $this->input->post('star');
            $data['compliment'] = $this->input->post('compliment');
            $data['management_by'] = $this->input->post('management_by')." ";
            if($this->input->post('destination_detail')):
                $data['uid_destination_detail'] = $this->input->post('destination_detail');
            else:
                $data['uid_destination_detail'] = 0;
            endif;
            $tb = 'tx_rwadminhotel_hotel';
            $this->Mix->update_record('uid',$uid,$data,$tb);
            echo "Data has been update";
        else:
            $data['hotel_name'] = $this->input->post('hotel_name');
            $sql = "select * from tx_rwadminhotel_hotel where hotel_name like '%".$data['hotel_name']."%' ";
            $d = $this->Mix->read_rows_by_sql($sql);
            if(empty($d)):
                $data['uid_destination'] = $this->input->post('destination');
                $data['star'] = $this->input->post('star');
                $data['compliment'] = $this->input->post('compliment');
                $data['management_by'] = $this->input->post('management_by')." ";
                if($this->input->post('destination_detail')):
                    $data['uid_destination_detail'] = $this->input->post('destination_detail');
                else:
                    $data['uid_destination_detail'] = 0;
                endif;
                $tb = 'tx_rwadminhotel_hotel';
                $this->Mix->add_with_array($data,$tb);
                echo "Data has been save";
           else:
               echo "Sorry data is already exists";
           endif;
        endif;
        
    }
    
    function update_data_golden_rate()
    {
        is_admin();
        $uid = $this->input->post('uid');
        $data['category_name'] = $this->input->post('category_name');
        $data['rate'] = $this->input->post('retail');
        $data['retail_rate'] = $this->input->post('golden_rate');
        $tb = 'tx_rwadminhotel_cat_room';
        $this->Mix->update_record('uid',$uid,$data,$tb);
        echo " Data has been update";
    }
    
    function searching_form()
    {
        is_admin();
        $name = $this->input->post('search');
        $limit = $_GET['per_page'];
        if($limit==0):
            $limit = 10;
        else:
            $limit=$limit+10;
        endif;
       
        $sql = "select
                c.uid,
                c.hotel_name, 
                a.destination,
                b.destination_detail,
                c.star,
                case c.compliment when 1 then 'Yes' else 'No' end as compliment,
                c.hidden
                from
                tx_rwadminhotel_hotel c left join 
                tx_rwmembermlm_destination_detail b on c.uid_destination_detail = b.uid ,
                tx_rwmembermlm_destination a
                where
                c.uid_destination = a.uid and
                c.hotel_name like '%$name%'
                order by c.hotel_name 
                ";
        $data['d_hotel'] = $this->Mix->read_more_rows_by_sql($sql);
        
        $this->load->library('pagination');
        $total_rows = 0;
        $per_page = 10;
        $num_links = $total_rows / $per_page;
        $config['base_url']= site_url('_admin/hotel/pagination/?page');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['num_links'] = $num_links;
        $config['full_tag_open'] = "<div id='pagination'>";
        $config['full_tag_close'] = "</div>";
        $config['page_query_string'] = TRUE;
        
        $this->pagination->initialize($config);
        $data['limit'] = $limit;
        //debug_data($data);
        $this->load->view('panel/page/hotel/management',$data);
    }
    
    function searching_form_member_profit()
    {
        is_admin();
        $name = $this->input->post('search');
        $limit = $_GET['per_page'];
        if($limit==0):
            $limit = 10;
        else:
            $limit=$limit+10;
        endif;
        $sql = "select 
                a.uid,
                a.hidden,
                a.uid_member,
                a.date_booking,
                b.username,
                a.name_reservation,
                c.category_name,
                d.hotel_name,
                case a.payed when 1 then 'Paid' else 'No-Paid' end as Paid
                from
                tx_rwadminhotel_booking a,
                fe_users b,
                tx_rwadminhotel_cat_room c,
                tx_rwadminhotel_hotel d
                where
                a.uid_member = b.uid and
                a.uid_room = c.uid and
                c.uid_hotel = d.uid and 
                a.payed = 0 and
                b.username like '%$name%'
                order by a.name_reservation";
        $data['d_member_profit'] = $this->Mix->read_more_rows_by_sql($sql);
        
        $this->load->library('pagination');
        $total_rows = 0;
        $per_page = 10;
        $num_links = $total_rows / $per_page;
        $config['base_url']= site_url('_admin/hotel/member_profit/?page');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['num_links'] = $num_links;
        $config['full_tag_open'] = "<div id='pagination'>";
        $config['full_tag_close'] = "</div>";
        $config['page_query_string'] = TRUE;
        
        $this->pagination->initialize($config);
        $data['limit'] = $limit;
        //debug_data($data);
        $this->load->view('panel/page/hotel/member_profit',$data);
    }
    
    function switch_status_data_hotel()
    {
        is_admin();
        $uid = $_GET['uid'];
        $d = $this->Mix->read_row_ret_field_by_value('tx_rwadminhotel_hotel','hidden',$uid,'uid');
        if($d['hidden'] == '0')
        {
            $data['hidden'] = '1';
            $this->Mix->update_record('uid',$uid,$data,'tx_rwadminhotel_hotel');
            echo "
                    <script type=\"text/javascript\">
                        jQuery(function(){
                        jQuery('#info-saving').addClass('update-nag');
                        jQuery('#hide$uid').removeClass('lampunyala');
                        jQuery('#hide$uid').addClass('lampumati');
                        jQuery('#browsemember$uid').hide();
                       });
                    </script>
            ";
            echo "Hotel account has been Hide, and can't access their privillage page.";
        }
        else
        {
            $data['hidden'] = '0';
            $this->Mix->update_record('uid',$uid,$data,'tx_rwadminhotel_hotel');
            echo "
                    <script type=\"text/javascript\">
                        jQuery(function(){
                        jQuery('#info-saving').addClass('update-nag');
                        jQuery('#hide$uid').removeClass('lampumati');
                        jQuery('#hide$uid').addClass('lampunyala');
                        jQuery('#browsemember$uid').fadeIn();
                        jQuery('#browsemember$uid').removeClass('hidden-data');
                      });
                    </script>
            ";
            echo "Now Hotel account can access their privillage page.";
        }
    }
    
    function  paid_profit($uid = 0)
    {
        is_admin();
        $data['payed'] = 1;
        $tb = 'tx_rwadminhotel_booking';
        $this->Mix->update_record('uid',$uid,$data,$tb);
        echo "
                    <script type=\"text/javascript\">
                        jQuery(function(){
                        jQuery('#info-saving').addClass('update-nag');
                        jQuery('#hide$uid').hide();
                       });
                    </script>
            ";
        echo "Data has been update";
    }
    
    function edit_golden_rate($uid)
    {
        is_admin();
        $sql = "select 
                a.uid,
                a.category_name,
                a.published_rate,
                a.rate as retail,
                a.retail_rate as golden_rate,
                b.hotel_name
                from
                tx_rwadminhotel_cat_room a,
                tx_rwadminhotel_hotel b
                where
                a.uid_hotel = b.uid and
                a.hidden = 0 and
                a.uid = '$uid'
                order by b.hotel_name";
        $data['data']=$this->Mix->read_rows_by_sql($sql);
//        debug_data($data);
        $this->load->view('panel/page/hotel/edit_golden_rate',$data);
    }
}

?>
