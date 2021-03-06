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
class Admin_hotel extends CI_Controller {

    //put your code here
    public function index() {
        $this->hotel_management();
    }

    function hotel_management() {
        is_admin();
        $limit = $_GET['per_page'];
        if ($limit == 0):
            $limit = 10;
        else:
            $limit = $limit + 10;
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
        $config['base_url'] = site_url('_admin/hotel/pagination/?page');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['num_links'] = $num_links;
        $config['full_tag_open'] = "<div id='pagination'>";
        $config['full_tag_close'] = "</div>";
        $config['page_query_string'] = TRUE;

        $this->pagination->initialize($config);
        $data['limit'] = $limit;
        //debug_data($data);
        $this->load->view('panel/page/hotel/management', $data);
    }

    function add_new_data_hotel() {
        is_admin();
        $data['destination'] = $this->Mix->read_package_by_pid();
        $data['compliment'] = array('1' => '--yes--', '0' => '--No--');
        $data['by_core'] = array('1' => '--yes--', '0' => '--No--');
        $data['star'] = array('' => '-- select --', '4' => '4', '5' => '5');
        $this->load->vars($data);
        $this->load->view('panel/page/hotel/add_new_hotel');
    }

    function member_profit() {
        is_admin();
        $limit = $_GET['per_page'];
        if ($limit == 0):
            $limit = 10;
        else:
            $limit = $limit + 10;
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
                a.payed = 0 and
                a.check_in < curdate()
                order by a.uid asc limit 0,$limit";
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
                a.payed = 0 and
                a.check_in < curdate()
                order by a.name_reservation";
        $jumlah_data = $this->Mix->read_more_rows_by_sql($sql2);

        $this->load->library('pagination');
        $total_rows = count($jumlah_data);
        $per_page = 10;
        $num_links = $total_rows / $per_page;
        $config['base_url'] = site_url('_admin/hotel/member_profit/?page');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['num_links'] = $num_links;
        $config['full_tag_open'] = "<div id='pagination'>";
        $config['full_tag_close'] = "</div>";
        $config['page_query_string'] = TRUE;

        $this->pagination->initialize($config);
        $data['limit'] = $limit;
//        debug_data($data);
        $this->load->view('panel/page/hotel/member_profit', $data);
    }

    function golden_vip_rate() {
        is_admin();
        $limit = $_GET['per_page'];
        if ($limit == 0):
            $limit = 10;
        else:
            $limit = $limit + 10;
        endif;
//        with limit
        $sql = "select 
                a.uid,
                a.category_name,
                a.published_rate,
                a.rate as golden_rate,
                a.retail_rate as retail,
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
        $config['base_url'] = site_url('_admin/hotel/golden_vip_rate/?page');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['num_links'] = $num_links;
        $config['full_tag_open'] = "<div id='pagination'>";
        $config['full_tag_close'] = "</div>";
        $config['page_query_string'] = TRUE;

        $this->pagination->initialize($config);
        $data['limit'] = $limit;
//        debug_data($data);
        $this->load->view('panel/page/hotel/golden_vip_rate', $data);
    }

    function destination() {
        is_admin();
        $limit = $_GET['per_page'];
        if ($limit == 0):
            $limit = 10;
        else:
            $limit = $limit + 10;
        endif;
//        with limit
        $sql = "select 
                a.uid,
                a.destination,
                case a.hidden when 1 then 'lampumati' else 'lampunyala' end as lampu
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
        $config['base_url'] = site_url('_admin/hotel/destination/?page');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['num_links'] = $num_links;
        $config['full_tag_open'] = "<div id='pagination'>";
        $config['full_tag_close'] = "</div>";
        $config['page_query_string'] = TRUE;

        $this->pagination->initialize($config);
        $data['limit'] = $limit;
//        debug_data($data);
        $this->load->view('panel/page/hotel/destination', $data);
    }

    function area_in_detail() {
        is_admin();
        $limit = $_GET['per_page'];
        if ($limit == 0):
            $limit = 10;
        else:
            $limit = $limit + 10;
        endif;
//        with limit
        $sql = "select
                a.uid,
                b.destination,
                a.destination_detail,
                case a.hidden when 1 then 'lampumati' else 'lampunyala' end as lampu
                from
                tx_rwmembermlm_destination_detail a,
                tx_rwmembermlm_destination b
                where
                a.uid_destination = b.uid
                order by a.destination_detail limit 0,$limit";
        $data['d_area_in_detail'] = $this->Mix->read_more_rows_by_sql($sql);
        //        with out limit
        $sql2 = "select
                a.uid,
                b.destination,
                a.destination_detail,
                case a.hidden when 1 then 'lampumati' else 'lampunyala' end as lampu
                from
                tx_rwmembermlm_destination_detail a,
                tx_rwmembermlm_destination b
                where
                a.uid_destination = b.uid";

        $jumlah_data = $this->Mix->read_more_rows_by_sql($sql2);

        $jumlah_data = $this->Mix->read_more_rows_by_sql($sql2);

        $this->load->library('pagination');
        $total_rows = count($jumlah_data);
        $per_page = 10;
        $num_links = $total_rows / $per_page;
        $config['base_url'] = site_url('_admin/hotel/area_in_detail/?page');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['num_links'] = $num_links;
        $config['full_tag_open'] = "<div id='pagination'>";
        $config['full_tag_close'] = "</div>";
        $config['page_query_string'] = TRUE;

        $this->pagination->initialize($config);
        $data['limit'] = $limit;
//        debug_data($data);
        $this->load->view('panel/page/hotel/area_in_detail', $data);
    }

    function saving_destination() {
        is_admin();
        $data['destination'] = $this->input->post('destination');
        $sql = "select * from tx_rwmembermlm_destination where destination like '%" . $data['destination'] . "%'";
        $d = $this->Mix->read_rows_by_sql($sql);
        if (empty($d)):
            $data['pid'] = 0;
            $tb = 'tx_rwmembermlm_destination';
            $this->Mix->add_with_array($data, $tb);
            echo "New destination has been save";
        else:
            echo "sorry destination already exists";
        endif;
    }

    function update_destination() {
        is_admin();
        $uid = $this->input->post('uid');
        $data['destination'] = $this->input->post('destination');
        $sql = "select * from tx_rwmembermlm_destination where destination like '%" . $data['destination'] . "%'";
        $d = $this->Mix->read_rows_by_sql($sql);
        if (empty($d)):
            $data['pid'] = 0;
            $tb = 'tx_rwmembermlm_destination';
            $this->Mix->update_record('uid', $uid, $data, $tb);
            echo "Destination has been update";
        else:
            echo "Sorry the same name of destination already exists, please check your data.";
        endif;
    }

    function read_address() {
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
            case "edit_destination_hotel":
                $uid = $_GET['uid'];
                $this->edit_destination_hotel($uid);
                break;
            case "lampu_destination":
                $uid = $_GET['uid'];
                $this->lampu_destination($uid);
                break;
            case "lampu_destination_detail":
                $uid = $_GET['uid'];
                $this->lampu_destination_detail($uid);
                break;
            case "area_in_detail_destination":
                $uid = $_GET['uid'];
                $this->area_in_detail_destination($uid);
                break;
        endswitch;
    }

    function get_detail($uid) {
        is_admin();
        $data = array();
        $sql = "select
                d.uid as idu,
                c.uid,
                c.hotel_name, 
                d.username,
                c.email,
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
                tx_rwmembermlm_destination a,
                fe_users d
                where
                c.uid_destination = a.uid and
                d.tx_rwadminhotel_hotel = c.uid and
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
        if ($data['d_hotel']['destination_detail'] != ''):
            $sql3 = "select 
                    uid,
                    destination_detail
                    from
                    tx_rwmembermlm_destination_detail
                    where 
                    uid_destination = '" . $data['d_hotel']['uid_destination'] . "'";
            $data['destination_detail'] = $this->Mix->read_rows_by_sql_to_dropdown($sql3, 'destination_detail');
        endif;
        $data['compliment'] = array('1' => '--yes--', '0' => '--No--');
        $data['by_core'] = array('1' => '--yes--', '0' => '--No--');
        $data['star'] = array('' => '-- select --', '4' => '4', '5' => '5');
        $this->load->vars($data);
        $this->load->view('panel/page/hotel/get_detail');
    }

    function get_detail_destination($uid=0) {
        is_admin();
        $sql3 = "select 
                    uid,
                    destination_detail
                    from
                    tx_rwmembermlm_destination_detail
                    where 
                    uid_destination = '" . $uid . "'";
        $data = $this->Mix->read_rows_by_sql_to_dropdown($sql3, 'destination_detail');
        if (!empty($data)):
            echo form_dropdown('destination_detail', $data);
        else:
            echo "&nbsp;";
        endif;
    }

    function update_data_hotel() {
        is_admin();
        if ($this->input->post('uid')):
            $uid = $this->input->post('uid');
            $data['hotel_name'] = $this->input->post('hotel_name');
            $data['uid_destination'] = $this->input->post('destination');
            $data['star'] = $this->input->post('star');
            $data['compliment'] = $this->input->post('compliment');
            $data['management_by'] = $this->input->post('management_by') . " ";
            if ($this->input->post('email')):
                $data['email'] = $this->input->post('email');
            endif;
            if ($this->input->post('destination_detail')):
                $data['uid_destination_detail'] = $this->input->post('destination_detail');
            else:
                $data['uid_destination_detail'] = 0;
            endif;
            $tb = 'tx_rwadminhotel_hotel';
            $this->Mix->update_record('uid', $uid, $data, $tb);
            if ($this->input->post('pwd')):
                $up_data_fe_user['password'] = md5($this->input->post('pwd'));
                $val = $this->input->post('idu');
                $tb = 'fe_users';
                $this->Mix->update_record('uid', $val, $up_data_fe_user, $tb);
            endif;
            echo "Data has been update";
        else:
            $data['hotel_name'] = $this->input->post('hotel_name');
            $ins_data_fe_users['username'] = $this->input->post('username');
            $sql = "select * from tx_rwadminhotel_hotel where hotel_name like '%" . $data['hotel_name'] . "%' ";
            $sql2 = "select * from fe_users where username like '%" . $ins_data_fe_users['username'] . "%'";
            $d = $this->Mix->read_rows_by_sql($sql);
            $ins_d = $this->Mix->read_rows_by_sql($sql2);
            if (empty($d)):
                if (empty($ins_d)):
                    $ins_data_fe_users['usergroup'] = '1';
                    $pwd = $this->input->post('pwd');
                    $pwd2 = $this->input->post('pwd2');
                    if ($pwd != $pwd2):
                        echo "Password not same";
                    else:
                        $ins_data_fe_users['password'] = md5($pwd);
                        $data['email'] = $this->input->post('email');
                        $data['uid_destination'] = $this->input->post('destination');
                        $data['star'] = $this->input->post('star');
                        $data['compliment'] = $this->input->post('compliment');
                        $data['management_by'] = $this->input->post('management_by') . " ";
                        if ($this->input->post('destination_detail')):
                            $data['uid_destination_detail'] = $this->input->post('destination_detail');
                        else:
                            $data['uid_destination_detail'] = 0;
                        endif;
                        $tb = 'tx_rwadminhotel_hotel';
                        $this->Mix->add_with_array($data, $tb);
                        $d = $this->Mix->read_rows_by_sql($sql);

                        $tb = 'fe_users';
                        $ins_data_fe_users['tx_rwadminhotel_hotel'] = $d['uid'];
                        $ins_data_fe_users['pid'] = '66';
                        $ins_data_fe_users['cruser_id'] = '1';
                        $this->Mix->add_with_array($ins_data_fe_users, $tb);

                        echo "Data has been save";
                    endif;
                else:
                    echo "sorry username is already exists";
                endif;
            else:
                echo "Sorry data is already exists";
            endif;
        endif;
    }

    function update_data_golden_rate() {
        is_admin();
        $uid = $this->input->post('uid');
        $data['category_name'] = $this->input->post('category_name');
        $data['rate'] = $this->input->post('golden_rate');
        $data['retail_rate'] = $this->input->post('retail');
        $tb = 'tx_rwadminhotel_cat_room';
        $this->Mix->update_record('uid', $uid, $data, $tb);
        echo " Data has been update";
    }

    function searching_form() {
        is_admin();
        $name = $this->input->post('search');
        $limit = $_GET['per_page'];
        if ($limit == 0):
            $limit = 10;
        else:
            $limit = $limit + 10;
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
        $config['base_url'] = site_url('_admin/hotel/pagination/?page');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['num_links'] = $num_links;
        $config['full_tag_open'] = "<div id='pagination'>";
        $config['full_tag_close'] = "</div>";
        $config['page_query_string'] = TRUE;

        $this->pagination->initialize($config);
        $data['limit'] = $limit;
        //debug_data($data);
        $this->load->view('panel/page/hotel/management', $data);
    }

    function searching_form_member_profit() {
        is_admin();
        $name = $this->input->post('search');
        $limit = $_GET['per_page'];
        if ($limit == 0):
            $limit = 10;
        else:
            $limit = $limit + 10;
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
        $config['base_url'] = site_url('_admin/hotel/member_profit/?page');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['num_links'] = $num_links;
        $config['full_tag_open'] = "<div id='pagination'>";
        $config['full_tag_close'] = "</div>";
        $config['page_query_string'] = TRUE;

        $this->pagination->initialize($config);
        $data['limit'] = $limit;
        //debug_data($data);
        $this->load->view('panel/page/hotel/member_profit', $data);
    }

    function switch_status_data_hotel() {
        is_admin();
        $uid = $_GET['uid'];
        $d = $this->Mix->read_row_ret_field_by_value('tx_rwadminhotel_hotel', 'hidden', $uid, 'uid');
        if ($d['hidden'] == '0') {
            $data['hidden'] = '1';
            $this->Mix->update_record('uid', $uid, $data, 'tx_rwadminhotel_hotel');
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
        } else {
            $data['hidden'] = '0';
            $this->Mix->update_record('uid', $uid, $data, 'tx_rwadminhotel_hotel');
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

    function paid_profit($uid = 0) {
        is_admin();
        $data['payed'] = 1;
        $tb = 'tx_rwadminhotel_booking';
        $this->Mix->update_record('uid', $uid, $data, $tb);
        echo "
                    <script type=\"text/javascript\">
                        jQuery(function(){
                        jQuery('#info-saving').addClass('update-nag');
                        jQuery('#hide$uid').hide();
                       });
                    </script>
            ";
        $update_point['hidden'] = '0';
        $tb = "tx_rwmembermlm_pointrewards";
        $this->Mix->update_record('uid_trx_hotel', $uid, $update_point, $tb);
        echo "Data has been update";
    }

    function edit_golden_rate($uid) {
        is_admin();
        $sql = "select 
                a.uid,
                a.category_name,
                a.published_rate,
                a.rate as golden_rate,
                a.retail_rate as retail,
                b.hotel_name
                from
                tx_rwadminhotel_cat_room a,
                tx_rwadminhotel_hotel b
                where
                a.uid_hotel = b.uid and
                a.hidden = 0 and
                a.uid = '$uid'
                order by b.hotel_name";
        $data['data'] = $this->Mix->read_rows_by_sql($sql);
//        debug_data($data);
        $this->load->view('panel/page/hotel/edit_golden_rate', $data);
    }

    function edit_destination_hotel($uid) {
        is_admin();
        $sql = "select 
                a.uid,
                a.destination
                from
                tx_rwmembermlm_destination a
                where 
                pid = 0 and
                a.uid = $uid";
        $data['destination'] = $this->Mix->read_rows_by_sql($sql);
        $this->load->view('panel/page/hotel/edit_destination_hotel', $data);
    }

    function lampu_destination($uid) {
        is_admin();
        $uid = $_GET['uid'];
        $d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_destination', 'hidden', $uid, 'uid');
        if ($d['hidden'] == 0):
            $data['hidden'] = '1';
            $this->Mix->update_record('uid', $uid, $data, 'tx_rwmembermlm_destination');
            echo "<script type='text/javascript'>
                    jQuery(function(){
                        jQuery('#browsedestination$uid').hide();
                        jQuery('#hide$uid').removeClass('lampunyala');
                        jQuery('#hide$uid').addClass('lampumati');
                    });
                  </script>";
        else:
            $data['hidden'] = '0';
            $this->Mix->update_record('uid', $uid, $data, 'tx_rwmembermlm_destination');
            echo "<script type='text/javascript'>
                jQuery(function(){
                    jQuery('#browsedestination$uid').show();
                    jQuery('#hide$uid').removeClass('lampumati');
                    jQuery('#hide$uid').addClass('lampunyala');
                });
              </script>";
        endif;
    }

    function lampu_destination_detail($uid) {
        is_admin();
        $uid = $_GET['uid'];
        $d = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_destination_detail', 'hidden', $uid, 'uid');
        if ($d['hidden'] == 0):
            $data['hidden'] = '1';
            $this->Mix->update_record('uid', $uid, $data, 'tx_rwmembermlm_destination_detail');
            echo "<script type='text/javascript'>
                    jQuery(function(){
                        jQuery('#browsedestination$uid').hide();
                        jQuery('#hide$uid').removeClass('lampunyala');
                        jQuery('#hide$uid').addClass('lampumati');
                    });
                  </script>";
        else:
            $data['hidden'] = '0';
            $this->Mix->update_record('uid', $uid, $data, 'tx_rwmembermlm_destination_detail');
            echo "<script type='text/javascript'>
                jQuery(function(){
                    jQuery('#browsedestination$uid').show();
                    jQuery('#hide$uid').removeClass('lampumati');
                    jQuery('#hide$uid').addClass('lampunyala');
                });
              </script>";
        endif;
    }

    function area_in_detail_destination($uid=0) {
        is_admin();
        $data = array();

        $data['uid_destination'] = '';
        $data['uid'] = '';
        $data['destination_detail'] = '';
        $data['action'] = 'saving_area_in_detail';
        $data['val_btn'] = "save";
        if ($uid != 0):
            $sql = "select
                    a.uid,
                    b.uid as uid_destination,
                    a.destination_detail
                    from
                    tx_rwmembermlm_destination_detail a,
                    tx_rwmembermlm_destination b
                    where
                    a.uid_destination = b.uid and
                    a.uid = $uid ";
            $data = $this->Mix->read_rows_by_sql($sql);
            $data['val_btn'] = 'update';
            $data['action'] = 'update_area_in_detail';
        endif;
        $data['destination'] = $this->Mix->read_package_by_pid();
        $this->load->view('panel/page/hotel/area_in_detail_destination', $data);
    }

    function saving_area_in_detail() {
        is_admin();
        $tb = "tx_rwmembermlm_destination_detail";
        $data['uid_destination'] = $this->input->post('destination');
        $data['destination_detail'] = $this->input->post('area_in_detail');
        $this->Mix->add_with_array($data, $tb);
        echo "New area has been saved";
    }

    function update_area_in_detail() {
        is_admin();
        $tb = "tx_rwmembermlm_destination_detail";
        $data['uid_destination'] = $this->input->post('destination');
        $data['destination_detail'] = $this->input->post('area_in_detail');
        $val = $this->input->post('read_data');
        $this->Mix->update_record('uid', $val, $data, $tb);
        echo "Area in detail has been update";
    }

}

?>
