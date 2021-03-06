<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Admin_tour extends CI_Controller {

    function index() {
        $this->login();
    }

    function login() {
        /* menjalankan halaman untuk login user
         * uri admin-tour/login
         */
        is_login();
        $data['title'] = "MyGoldenVIP &raquo; login";
        $data['page'] = "login";
        $this->load->vars($data);
        $this->load->view('admin_tour/template');
    }

    function logout() {
        $this->session->unset_userdata('admin-tour');
        $this->session->unset_userdata('real-name');
        $this->session->unset_userdata('id_agen');
        $this->session->unset_userdata('nama_agen');
        $this->session->unset_userdata('username');
        redirect('admin-tour');
    }

    function check_login() {
        /*
         * cek validasi user yang masuk kedalam sistem
         * admin-tour/check_login
         */
        $user = $this->input->post('user');
        $pass = md5($this->input->post('pass'));
        if ($this->input->post('user')):
            $cek_user = $this->Mix->read_row_by_one('username', $user, 'be_admin_tour');
            if (!empty($cek_user) and $cek_user['hidden'] == '0'):
                if ($pass == $cek_user['password']):
                    $data['admin-tour'] = 'aktif';
                    $data['username'] = $user;
                    $data['real-name'] = $cek_user['real_name'];
                    $data['id_agen'] = $cek_user['uid_agen'];
                    $agen = $this->Mix->read_row_ret_field_by_value('tx_rwagen_agen', 'name', $cek_user['uid_agen'], 'uid');
                    $data['nama_agen'] = $agen['name'];
                    $this->session->set_userdata($data);
                    redirect('admin-tour');
                else:
                    $this->session->set_flashdata('info', 'incorect username or password');
                    redirect('admin-tour/login', 'refresh');
                endif;
            else:
                $this->session->set_flashdata('info', 'incorect username or password');
                redirect('admin-tour/login', 'refresh');
            endif;
        else :
            $this->session->set_flashdata('info', 'incorect username or password');
            redirect('admin-tour/login', 'refresh');
        endif;
    }

    private function is_admin_tour() {
        /*
         * cek apakah yang masuk adalah admin tour
         * jika bukan maka arahkan ke halaman login admin tour
         */
        if ($this->session->userdata('admin-tour') == 'aktif') {
            return TRUE;
        } else {
            redirect("admin-tour/login");
        }
    }

    function get_package() {
        /*
         * halaman utama dari admin-tour
         */
        $this->is_admin_tour();

        $limit = $_GET['per_page'];
        $nilai = 10;
        if ($limit == 0):
            $limit = $nilai;
        else:
            $limit = $limit + $nilai;
        endif;

        $data['title'] = "MyGoldenVIP &raquo; home";
        $data['page'] = "get_package";
        $data['nav'] = 'pm';
        $uid_agen = $this->session->userdata('id_agen');

        # ambil data untuk paket travel
        $sql = "select a.*, 
                    b.destination as tujuan
                    from
                    tx_rwagen_travelpackage a,
                    tx_rwmembermlm_destination b,
                    tx_rwagen_agen c
                    where
                    a.agen = c.uid and
                    a.destination = b.uid and
                    c.uid = '$uid_agen'
                    order by a.uid desc";
        $data['travelpackage'] = $this->Mix->read_more_rows_by_sql($sql);

        # ambil data untuk paket vip
        $sql = "select a.*, 
                    b.destination as tujuan
                    from
                    tx_rwagen_vippackage a,
                    tx_rwmembermlm_destination b,
                    tx_rwagen_agen c
                    where
                    a.agen = c.uid and
                    a.destination = b.uid and
                    c.uid = '$uid_agen'
                    order by a.uid desc";
        $data['vippackage'] = $this->Mix->read_more_rows_by_sql($sql);

        $data['package_agen'] = array_merge($data['travelpackage'], $data['vippackage']);

        $this->load->library('pagination');
        $total_rows = count($data['package_agen']);
        $per_page = $nilai;
        $num_links = $total_rows / $per_page;
        $config['base_url'] = site_url('admin-tour/package-management/?page');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['num_links'] = $num_links;
        $config['full_tag_open'] = "<div id='pagination'>";
        $config['full_tag_close'] = "</div>";
        $config['page_query_string'] = TRUE;

        $this->pagination->initialize($config);
        $data['limit'] = $limit;
        $data['nilai'] = $nilai;
        $this->load->vars($data);
        $this->load->view('admin_tour/template');
    }

    function get_member_booking() {
        /*
         * mengambil data member yang melakukan booking
         * status member yang mengambil booking terdiri atas :
         * member yang memakai compliment nya
         * member yang memakai point rewards
         * member yang memakai personal account
         * melakukan pembatalan booking
         * melakukan agreement booking
         */
        $this->is_admin_tour();

        $limit = $_GET['per_page'];
        $nilai = 10;
        if ($limit == 0):
            $limit = $nilai;
        else:
            $limit = $limit + $nilai;
        endif;

        $data['title'] = "MyGoldenVIP &raquo; booking";
        $data['page'] = "get_member_booking";
        $data['nav'] = 'booking_member';
        $uid = $this->session->userdata('id_agen');
        $sql = "select 
                    a.uid,
                    b.uid as id,
                    b.nama,
                    c.time_sch as depart,
                    e.destination,
                    d.nama as package,
                    a.reservation,
                    b.email
                    from
                    tx_rwagen_vipbooking a,
                    tx_rwagen_vipbookingdetails b,
                    tx_rwagen_vipschedule c,
                    tx_rwagen_vippackage d,
                    tx_rwmembermlm_destination e
                    where
                    b.pid = a.uid and
                    a.uid_sch = c.uid and
                    c.package = d.uid and
                    d.destination = e.uid and
                    a.hidden = 0 and
                    b.hidden = 0 and
                    d.hidden = 0 and
                    d.agen = $uid 
                    order by a.uid desc";
        $data['booking_vip'] = $this->Mix->read_more_rows_by_sql($sql);

        $sql = "select 
                    a.uid,
                    b.uid as id,
                    b.nama,
                    c.time_sch as depart,
                    e.destination,
                    d.nama as package,
                    a.reservation,
                    b.email
                    from
                    tx_rwagen_travelbooking a,
                    tx_rwagen_travelbookingdetails b,
                    tx_rwagen_travelschedule c,
                    tx_rwagen_travelpackage d,
                    tx_rwmembermlm_destination e
                    where
                    b.pid = a.uid and
                    a.uid_sch = c.uid and
                    c.package = d.uid and
                    d.destination = e.uid and
                    a.hidden = 0 and
                    b.hidden = 0 and
                    d.hidden = 0 and
                    d.agen = $uid 
                    order by a.uid desc";
        $data['booking_travel'] = $this->Mix->read_more_rows_by_sql($sql);

        $data['booking_num'] = array_merge($data['booking_vip'], $data['booking_travel']);

        $this->load->library('pagination');
        $total_rows = count($data['booking_num']);
        $per_page = $nilai;
        $num_links = $total_rows / $per_page;
        $config['base_url'] = site_url('admin-tour/booking/?page');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['num_links'] = $num_links;
        $config['full_tag_open'] = "<div id='pagination'>";
        $config['full_tag_close'] = "</div>";
        $config['page_query_string'] = TRUE;

        $this->pagination->initialize($config);
        $data['limit'] = $limit;
        $data['nilai'] = $nilai;

        $this->load->vars($data);
        $this->load->view('admin_tour/template');
    }

    function set_schedule() {
        /*
         * membuat jadwal ketersediaan paket-paket travel maupaun vip
         * set tanggal
         * set quantity
         * set package
         */
        $this->is_admin_tour();
        $data['title'] = "MyGoldenVIP &raquo; add package";
        $data['page'] = "set_schedule";
        $data['nav'] = 'set_sch';
        $data['mygoldenvip'] = array('' => '--- Select ---', '1' => 'Travel', '2' => 'VIP');
        $uid_agen = $this->session->userdata('id_agen');
        # ambil data untuk paket travel
        $sql = "select a.uid, 
                    a.nama
                    from
                    tx_rwagen_travelpackage a,
                    tx_rwmembermlm_destination b,
                    tx_rwagen_agen c
                    where
                    a.agen = c.uid and
                    a.destination = b.uid and
                    c.uid = '$uid_agen'";
        $travelpack = $this->Mix->read_more_rows_by_sql($sql);
        $travelpackage[] = '-- Select --';
        foreach ($travelpack as $row):
            $travelpackage[$row['uid']] = $row['nama'];
        endforeach;

        $data['travelpackage'] = $travelpackage;

        # ambil data untuk paket vip
        $sql = "select a.uid, 
                    a.nama
                    from
                    tx_rwagen_vippackage a,
                    tx_rwmembermlm_destination b,
                    tx_rwagen_agen c
                    where
                    a.agen = c.uid and
                    a.destination = b.uid and
                    c.uid = '$uid_agen'";
        $vippack = $this->Mix->read_more_rows_by_sql($sql);
        $vippackage[] = '-- Select --';
        foreach ($vippack as $row):
            $vippackage[$row['uid']] = $row['nama'];
        endforeach;

        $data['vippackage'] = $vippackage;
        $uid_agen = $this->session->userdata('id_agen');
        $this->load->vars($data);
        $this->load->view('admin_tour/template');
    }

    function save_schedule() {
        $this->is_admin_tour();
        $data['time_sch'] = $this->input->post('datepicker');
        $data['qty'] = $this->input->post('qty');
        $pack = $this->input->post('mygoldenvippackage');
        $data['hidden'] = 0;
        $tb = '';
        if ($pack == 1):
            $data['package'] = $this->input->post('destination_travel');
            $tb = 'tx_rwagen_travelschedule';
        elseif ($pack == 2) :
            $data['package'] = $this->input->post('destination_vip');
            $tb = 'tx_rwagen_vipschedule';
        else:
            $this->session->set_flashdata('info', "Data can't blank");
            redirect('admin-tour/time-schedule', 'refresh');
        endif;

        $this->Mix->add_with_array($data, $tb);
        $this->session->set_flashdata('info', "Data has been save");
        redirect('admin-tour/time-schedule', 'refresh');
    }

    function last_schedule() {
        $this->is_admin_tour();

        $limit = $_GET['per_page'];
        $nilai = 10;
        if ($limit == 0):
            $limit = $nilai;
        else:
            $limit = $limit + $nilai;
        endif;
        $uid_agen = $this->session->userdata('id_agen');
        $data['title'] = "MyGoldenVIP &raquo; Update Report";
        $data['page'] = "last_schedule";
        $data['nav'] = 'last_sch';
        $sql = "select 
                    a.uid,
                    a.time_sch,
                    c.destination,
                    b.nama,
                    d.package,
                    a.qty,
                    a.booking,
                    a.hidden
                    from
                    tx_rwagen_travelschedule a,
                    tx_rwagen_travelpackage b,
                    tx_rwmembermlm_destination c,
                    tx_rwmembermlm_package d
                    where
                    a.package = b.uid and
                    b.destination = c.uid and
                    c.pid = d.uid and
                    b.agen = '" . $uid_agen . "'
                    order by a.time_sch desc";
        $data['last_sch_travel'] = $this->Mix->read_more_rows_by_sql($sql);

        $sql = "select 
                    a.uid,
                    a.time_sch,
                    c.destination,
                    b.nama,
                    d.package,
                    a.qty,
                    a.booking,
                    a.hidden
                    from
                    tx_rwagen_vipschedule a,
                    tx_rwagen_vippackage b,
                    tx_rwmembermlm_destination c,
                    tx_rwmembermlm_package d
                    where
                    a.package = b.uid and
                    b.destination = c.uid and
                    c.pid = d.uid and
                    b.agen = '" . $uid_agen . "'
                    order by a.time_sch desc";
        $data['last_sch_vip'] = $this->Mix->read_more_rows_by_sql($sql);

        $data['update_sch_tour'] = array_merge($data['last_sch_travel'], $data['last_sch_vip']);

        $this->load->library('pagination');
        $total_rows = count($data['update_sch_tour']);
        $per_page = $nilai;
        $num_links = $total_rows / $per_page;
        $config['base_url'] = site_url('admin-tour/package-management/?page');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $per_page;
        $config['num_links'] = $num_links;
        $config['full_tag_open'] = "<div id='pagination'>";
        $config['full_tag_close'] = "</div>";
        $config['page_query_string'] = TRUE;

        $this->pagination->initialize($config);
        $data['limit'] = $limit;
        $data['nilai'] = $nilai;

        $uid_agen = $this->session->userdata('id_agen');
        $this->load->vars($data);
        $this->load->view('admin_tour/template');
    }

    function update_package() {
        /*
         * perbaharui 
         * harga paket
         * destination
         * description
         * tour guide
         */
        $this->is_admin_tour();
        $uid = $this->input->post('uid');
        $data['nama'] = $this->input->post('package');
        $p = $this->input->post('p');
        $data['harga'] = $this->input->post('published_rate');
        $data['retail_rate'] = $this->input->post('retail_rate');
        $data['destination'] = $this->input->post('destination');
        $data['deskripsi'] = $this->input->post('description');
        if ($this->input->post('filename')):
            $data['itienary'] = $this->input->post('filename');
        endif;
        if ($p == 1):
            $this->Mix->update_record('uid', $uid, $data, 'tx_rwagen_travelpackage');
            $this->edit_package_travel($uid, true);
        else:
            $this->Mix->update_record('uid', $uid, $data, 'tx_rwagen_vippackage');
            $this->edit_package_vip($uid, true);
        endif;
    }

    function add_package() {
        /*
         * membuat paket untuk travel maupun vip
         * set paket
         * set destination
         * set harga (published rated)
         * set description (fasilitas)
         * set tour guide
         * 
         */
        $this->is_admin_tour();
        $data['title'] = "MyGoldenVIP &raquo; add package";
        $data['page'] = "add_package";
        $data['nav'] = 'pm';
        $data['mygoldenvip'] = array('' => '--- Select ---', '1' => 'Travel', '2' => 'VIP');

        $sql = "select 
                    * 
                    from 
                    `tx_rwmembermlm_destination` 
                    where pid <> 0 and
                    pid = 2
                    order by uid";
        $data['destination_travel'] = $this->Mix->read_package_destination($sql);

        $sql = "select 
                    * 
                    from 
                    `tx_rwmembermlm_destination` 
                    where pid <> 0 and
                    pid > 2
                    order by uid";
        $data['destination_vip'] = $this->Mix->read_package_destination($sql);

        $uid_agen = $this->session->userdata('id_agen');
        $this->load->vars($data);
        $this->load->view('admin_tour/template');
    }

    function save_data_package() {
        $this->is_admin_tour();
        $data = array();
        $data['agen'] = $this->session->userdata('id_agen');
        $data['nama'] = $this->input->post('package');
        $data['harga'] = $this->input->post('published_rate');
        $data['retail_rate'] = $this->input->post('retail_rate');
        $data['hidden'] = 0;
        $data['deskripsi'] = $this->input->post('description');
        if ($this->input->post('filename')):
            $data['itienary'] = $this->input->post('filename');
        endif;
        $pack = $this->input->post('mygoldenvippackage');
        if ($pack == 1) {
            $sql = "select * from tx_rwagen_travelpackage where nama like'%" . $data['nama'] . "%' and agen like '%" . $data['agen'] . "%' ";
            $d = $this->Mix->read_rows_by_sql($sql);
            if (empty($d)) {
                $data['destination'] = $this->input->post('destination_travel');
                $this->Mix->add_with_array($data, 'tx_rwagen_travelpackage');
                echo "Package has been saved.";
            } else {
                echo "Package is already exists";
            }
        } else if ($pack == 2) {
            $sql = "select * from tx_rwagen_vippackage where nama like'%" . $data['nama'] . "%' and agen like '%" . $data['agen'] . "%' ";
            $d = $this->Mix->read_rows_by_sql($sql);
            if (empty($d)) {
                $data['destination'] = $this->input->post('destination_vip');
                $this->Mix->add_with_array($data, 'tx_rwagen_vippackage');
                echo "Package has been saved.";
            } else {
                echo "Package is already exists";
            }
        } else {
            $this->session->set_flashdata('info', "My Golden VIP Package can't be empty ");
            redirect('admin-tour/package-management/add-package', 'refresh');
        }

        //$this->session->set_flashdata('info',"New Package has been saved");
        //redirect('admin-tour/package-management/add-package','refresh');
    }

    function do_upload_file() {
        $this->is_admin_tour();
        $uploaddir = './upload/itienary/' . $this->session->userdata('id_agen') . '/';

        $dir = BASEPATH . '../upload/itienary/' . $this->session->userdata('id_agen');
        if (!file_exists($dir)) {
            mkdir($dir);
        }

        $file = $uploaddir . basename($_FILES['uploadfile']['name']);
        //debug_data($_FILES['uploadfile']);
        if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) {
            echo "success";
        } else {
            echo "error";
        }
    }

    function account_settings() {
        $this->is_admin_tour();
        $data['title'] = "MyGoldenVIP &raquo; home";
        $data['page'] = "account_setting";
        $data['nav'] = 'um';
        $uid_agen = $this->session->userdata('id_agen');
        $agen = $this->Mix->read_row_ret_field_by_value('be_admin_tour', 'real_name', $uid_agen, 'uid');

        $data['real_name'] = $agen['real_name'];
        $uid_agen = $this->session->userdata('id_agen');
        $data['username'] = $this->session->userdata('username');
        $this->load->vars($data);
        $this->load->view('admin_tour/template');
    }

    function account_settings_update() {
        $data = array();
        $uid_agen = $this->session->userdata('id_agen');
        if ($this->input->post('password')) {
            $data['password'] = md5($this->input->post('password'));
            $this->Mix->update_record('uid', $uid_agen, $data, 'be_admin_tour');
        }

        if ($this->input->post('name')) {
            $data['real_name'] = $this->input->post('name');
            $this->Mix->update_record('uid', $uid_agen, $data, 'be_admin_tour');
        }

        echo "Account has been update";
    }

    /*
     * fungsi yang berada dibawah adalah fungsi hasil dari pembacaan method GET
     * fungsi-fungsi tersebut akan diarahkan pada root fungsi get_form
     */

    function get_form() {
        $this->is_admin_tour();
        /* menangkap method post dari halaman untuk memporses data */
        $pilihan = $_GET['search'];
        $uid = $_GET['uid'];
        switch ($pilihan) {
            case md5($uid . "travel-edit") . "" . $uid:
                $this->is_admin_tour();
                $this->edit_package_travel($uid);
                break;
            case md5($uid . "vip-edit") . "" . $uid:
                $this->is_admin_tour();
                $this->edit_package_vip($uid);
                break;
            case md5('hidden-package-vip' . $uid) . "" . $uid:
                $this->is_admin_tour();
                $this->hidden_package_vip($uid);
                break;
            case md5('active-package-vip' . $uid) . "" . $uid:
                $this->is_admin_tour();
                $this->active_package_vip($uid);
                break;
            case md5('hidden-package-travel' . $uid) . "" . $uid:
                $this->is_admin_tour();
                $this->hidden_package_travel($uid);
                break;
            case md5('active-package-travel' . $uid) . "" . $uid:
                $this->is_admin_tour();
                $this->active_package_travel($uid);
                break;
            case md5('hidden-sch-vip' . $uid) . "" . $uid:
                $this->is_admin_tour();
                $this->hidden_sch_vip($uid);
                break;
            case md5('active-sch-vip' . $uid) . "" . $uid:
                $this->is_admin_tour();
                $this->active_sch_vip($uid);
                break;
            case md5('hidden-sch-travel' . $uid) . "" . $uid:
                $this->is_admin_tour();
                $this->hidden_sch_travel($uid);
                break;
            case md5('active-sch-travel' . $uid) . "" . $uid:
                $this->is_admin_tour();
                $this->active_sch_travel($uid);
                break;
            case md5('browse-sch-vip' . $uid) . "" . $uid:
                $this->is_admin_tour();
                $this->brwose_sch_vip($uid);
                break;
            case md5('browse-sch-travel' . $uid) . "" . $uid:
                $this->is_admin_tour();
                $this->brwose_sch_travel($uid);
                break;
            case md5('cancel-booking' . $uid) . "" . $uid:
                $this->is_admin_tour();
                $this->cancel_booking($uid);
                break;
        }
    }

    function edit_package_travel($uid, $info = false) {
        # ambil data untuk paket travel
        $sql = "select a.*, 
                    case a.itienary when a.itienary <> 0 then a.itienary else 'No file attachment' end as file,
                    b.destination as tujuan
                    from
                    tx_rwagen_travelpackage a,
                    tx_rwmembermlm_destination b,
                    tx_rwagen_agen c
                    where
                    a.agen = c.uid and
                    a.destination = b.uid and
                    a.uid = '$uid'";
        $data['package'] = $this->Mix->read_rows_by_sql($sql);
        $data['title'] = "MyGoldenVIP &raquo; home";
        $data['page'] = "edit_package";
        $data['nav'] = 'pm';
        $data['p'] = '1';
        $sql = "select 
                    * 
                    from 
                    `tx_rwmembermlm_destination` 
                    where pid <> 0 and
                    pid = 2
                    order by uid";
        $data['destination'] = $this->Mix->read_package_destination($sql);
        if ($info):
            $data['info'] = "Data has been update";
        endif;
        $this->load->vars($data);
        $this->load->view('admin_tour/template');
    }

    function edit_package_vip($uid, $info = false) {
        # ambil data untuk paket vip
        $sql = "select a.*, 
                    case a.itienary when a.itienary <> 0 then a.itienary else 'No file attachment' end as file,
                    b.destination as tujuan
                    from
                    tx_rwagen_vippackage a,
                    tx_rwmembermlm_destination b,
                    tx_rwagen_agen c
                    where
                    a.agen = c.uid and
                    a.destination = b.uid and
                    a.uid = '$uid'";
        $data['package'] = $this->Mix->read_rows_by_sql($sql);
        $data['title'] = "MyGoldenVIP &raquo; home";
        $data['page'] = "edit_package";
        $data['nav'] = 'pm';
        $data['p'] = '2';
        $sql = "select 
                    * 
                    from 
                    `tx_rwmembermlm_destination` 
                    where pid <> 0 and
                    pid > 2
                    order by uid";
        $data['destination'] = $this->Mix->read_package_destination($sql);
        if ($info):
            $data['info'] = "Data has been update";
        endif;
        $this->load->vars($data);
        $this->load->view('admin_tour/template');
    }

    function hidden_package_vip($uid) {
        $this->is_admin_tour();
        $data['hidden'] = 1;
        $this->Mix->update_record('uid', $uid, $data, 'tx_rwagen_vippackage');
        redirect('admin-tour/package-management');
    }

    function active_package_vip($uid) {
        $this->is_admin_tour();
        $data['hidden'] = 0;
        $this->Mix->update_record('uid', $uid, $data, 'tx_rwagen_vippackage');
        redirect('admin-tour/package-management');
    }

    function hidden_package_travel($uid) {
        $this->is_admin_tour();
        $data['hidden'] = 1;
        $this->Mix->update_record('uid', $uid, $data, 'tx_rwagen_travelpackage');
        redirect('admin-tour/package-management');
    }

    function active_package_travel($uid) {
        $this->is_admin_tour();
        $data['hidden'] = 0;
        $this->Mix->update_record('uid', $uid, $data, 'tx_rwagen_travelpackage');
        redirect('admin-tour/package-management');
    }

    function hidden_sch_vip($uid) {
        $this->is_admin_tour();
        $data['hidden'] = 1;
        $this->Mix->update_record('uid', $uid, $data, 'tx_rwagen_vipschedule');
        redirect('admin-tour/update-report');
    }

    function active_sch_vip($uid) {
        $this->is_admin_tour();
        $data['hidden'] = 0;
        $this->Mix->update_record('uid', $uid, $data, 'tx_rwagen_vipschedule');
        redirect('admin-tour/update-report');
    }

    function hidden_sch_travel($uid) {
        $this->is_admin_tour();
        $data['hidden'] = 1;
        $this->Mix->update_record('uid', $uid, $data, 'tx_rwagen_travelschedule');
        redirect('admin-tour/update-report');
    }

    function active_sch_travel($uid) {
        $this->is_admin_tour();
        $data['hidden'] = 0;
        $this->Mix->update_record('uid', $uid, $data, 'tx_rwagen_travelschedule');
        redirect('admin-tour/update-report');
    }

    function brwose_sch_vip($uid_sch) {
        $this->is_admin_tour();
        $data['title'] = "MyGoldenVIP &raquo; detail booking";
        $data['page'] = "get_member_booking";
        $data['nav'] = 'booking_member';
        $uid = $this->session->userdata('id_agen');
        $sql = "select 
                    a.uid,
                    b.uid as id,
                    b.nama,
                    c.time_sch as depart,
                    e.destination,
                    d.nama as package,
                    a.reservation,
                    b.email
                    from
                    tx_rwagen_vipbooking a,
                    tx_rwagen_vipbookingdetails b,
                    tx_rwagen_vipschedule c,
                    tx_rwagen_vippackage d,
                    tx_rwmembermlm_destination e
                    where
                    b.pid = a.uid and
                    a.uid_sch = c.uid and
                    c.package = d.uid and
                    d.destination = e.uid and
                    a.hidden = 0 and
                    b.hidden = 0 and
                    d.hidden = 0 and
                    d.agen = $uid and
                    c.uid = $uid_sch
                    order by a.uid desc";
        $data['booking_vip'] = $this->Mix->read_more_rows_by_sql($sql);
        //debug_data($data['booking_vip']);
        $data['limit'] = 5000;
        $data['nilai'] = 5000;
        $this->load->vars($data);
        $this->load->view('admin_tour/template');
    }

    function brwose_sch_travel($uid_sch) {
        $this->is_admin_tour();
        $data['title'] = "MyGoldenVIP &raquo; detail booking";
        $data['page'] = "get_member_booking";
        $data['nav'] = 'booking_member';
        $uid = $this->session->userdata('id_agen');
        $sql = "select 
                    a.uid,
                    b.uid as id,
                    b.nama,
                    c.time_sch as depart,
                    e.destination,
                    d.nama as package,
                    a.reservation,
                    b.email
                    from
                    tx_rwagen_travelbooking a,
                    tx_rwagen_travelbookingdetails b,
                    tx_rwagen_travelschedule c,
                    tx_rwagen_travelpackage d,
                    tx_rwmembermlm_destination e
                    where
                    b.pid = a.uid and
                    a.uid_sch = c.uid and
                    c.package = d.uid and
                    d.destination = e.uid and
                    a.hidden = 0 and
                    b.hidden = 0 and
                    d.hidden = 0 and
                    d.agen = $uid and
                    c.uid = $uid_sch
                    order by a.uid desc";
        $data['booking_travel'] = $this->Mix->read_more_rows_by_sql($sql);
        //debug_data($data['booking_travel']);
        $data['limit'] = 5000;
        $data['nilai'] = 5000;
        $this->load->vars($data);
        $this->load->view('admin_tour/template');
    }

    function cancel_booking($uid) {
        $this->is_admin_tour();
        $data['hidden'] = 1;
        $p = $_GET['p'];
        if ($p == 1) {
            $this->Mix->update_record('uid', $uid, $data, 'tx_rwagen_travelbookingdetails');
            $pid_detail = $this->Mix->read_row_ret_field_by_value('tx_rwagen_travelbookingdetails', 'pid', $uid, 'uid');
            $sql = "select 
                    count(b.uid) as qty_detail, 
                    a.qty
                    from
                    tx_rwagen_travelbooking a,
                    tx_rwagen_travelbookingdetails b
                    where
                    b.pid = a.uid and
                    a.uid = '" . $pid_detail['pid'] . "' and
                    b.hidden = 1";
            $q = $this->Mix->read_rows_by_sql($sql);
            if ($q['qty_detail'] == $q['qty']):
                $this->Mix->update_record('uid', $pid_detail['pid'], $data, 'tx_rwagen_travelbooking');
            endif;
            $uid_sch = $this->Mix->read_row_ret_field_by_value('tx_rwagen_travelbooking', 'uid_sch', $pid_detail['pid'], 'uid'); // uid schedule
            $res = $this->Mix->read_row_ret_field_by_value('tx_rwagen_travelbooking', 'reservation', $pid_detail['pid'], 'uid'); // reservation
            $booking = $this->Mix->read_row_ret_field_by_value('tx_rwagen_travelschedule', 'booking', $uid_sch['uid_sch'], 'uid');
            $up['booking'] = $booking['booking'] - 1;
            $this->Mix->update_record('uid', $uid_sch['uid_sch'], $up, 'tx_rwagen_travelschedule');
            if ($res['reservation']== 'Redeem'):
                $this->reset_point_rewards($pid_detail['pid'], $p);
//            echo "here";
            endif;
           // echo $res['reservation'];
//            debug_data($res);
            redirect('admin-tour/booking');
        }
        else if ($p == 2) {
            $this->Mix->update_record('uid', $uid, $data, 'tx_rwagen_vipbookingdetails');
            $pid_detail = $this->Mix->read_row_ret_field_by_value('tx_rwagen_vipbookingdetails', 'pid', $uid, 'uid');
            $sql = "select 
                    count(b.uid) as qty_detail, 
                    a.qty
                    from
                    tx_rwagen_vipbooking a,
                    tx_rwagen_vipbookingdetails b
                    where
                    b.pid = a.uid and
                    a.uid = '" . $pid_detail['pid'] . "' and
                    b.hidden = 1";
            $q = $this->Mix->read_rows_by_sql($sql);
            if ($q['qty_detail'] == $q['qty']):
                $this->Mix->update_record('uid', $pid_detail['pid'], $data, 'tx_rwagen_vipbooking');
            endif;
            $uid_sch = $this->Mix->read_row_ret_field_by_value('tx_rwagen_vipbooking', 'uid_sch', $pid_detail['pid'], 'uid'); // uid schedule
            $res = $this->Mix->read_row_ret_field_by_value('tx_rwagen_vipbooking', 'reservation', $pid_detail['pid'], 'uid'); // reservation
            $booking = $this->Mix->read_row_ret_field_by_value('tx_rwagen_vipschedule', 'booking', $uid_sch['uid_sch'], 'uid');
            $up['booking'] = $booking['booking'] - 1;
            $this->Mix->update_record('uid', $uid_sch['uid_sch'], $up, 'tx_rwagen_vipschedule');
            if ($res['reservation']== 'Redeem'):
                $this->reset_point_rewards($pid_detail['pid'], $p);
            endif;
            # nambah ke kuantitas
            # mengurangi daftar booking
            redirect('admin-tour/booking');
        }
        else {
            redirect('admin-tour/booking', 'refresh');
        }
    }

    function reset_point_rewards($id_booking, $p) {
        $this->is_admin_tour();
        if ($p == 1):
            $sch = "tx_rwagen_travelschedule";
            $package = "tx_rwagen_travelpackage";
            $booking = "tx_rwagen_travelbooking";
        elseif ($p == 2):
            $sch = "tx_rwagen_vipschedule";
            $package = "tx_rwagen_vippackage";
            $booking = "tx_rwagen_vipbooking";
        else:
            redirect('admin-tour/booking');
        endif;
        $sql = "UPDATE 
                tx_rwmembermlm_member 
                SET 
                pointrewards =
                pointrewards -
                (
                        select
                        c.point
                        from
                        $sch a,
                        $package b,
                        tx_rwmembermlm_destination c,
                        $booking d
                        where
                        a.package = b.uid and
                        b.destination = c.uid and
                        d.uid_sch = a.uid and
                        d.uid = $id_booking
                )
                WHERE 
                uid in (select uid_member from $booking where uid = $id_booking)";
        $this->db->query($sql);
    }

}

?>
