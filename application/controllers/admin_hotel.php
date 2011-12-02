<?php

class Admin_hotel extends CI_Controller
{

    /**
     * model for this controller
     * @var CI_Adhotel
     */
    private $model;

    private function _loadDependency() {

        $this->model = load_class('Adhotel', 'models');
        $this->model->session = $this->session;

    }

    function index()
    {
        $this->_loadDependency();
        if ($this->model->is_hotel_logged_in()) {
            $this->profile();
        } else {
            $this->member_login();
        }

    }

    # home page

    function homepage()
    {
        $data['title'] = "Member | Home Page";
        $data['page'] = "profile";
        $this->load->vars($data);
        $this->load->view('admin_hotel/profile');

    }

    function login()
    {
        $this->member_login();

    }

    function profile()
    {
        $this->_loadDependency();
        if ($this->model->is_hotel_logged_in()) {
            $page = 'Profile';
            $hotelid = $this->session->userdata('hotel');
            $data = $this->model->getHotels($hotelid);

            $data = $this->add_default_data($data);
            $data['title'] = "Golden VIP: " . ucfirst($page);
            $data['page'] = strtolower($page);
            $data['menu'] = $this->model->get_admin_hotel_nav($data['page'], base_url());

            /** based on page HTML * */
            $city = $this->model->get_admin_hotel_destination($data['uid_destination']);
            $data['destination'] = $city['city'];

            //@todo make mechanisme to edit form when default or when edit
            $action = $this->input->get('action');
            if ($action == 'edit') {
                $data['form_button'] = $this->model->get_input_button($page . '_doedit');
                $data['form_action'] = current_url();
            } else {
                $data['disable'] = ' disabled="1" ';
                $data['form_button'] = $this->model->get_input_button($page . '_showdefault');
                $data['form_action'] = current_url() . '?action=edit';
            }
            $this->load->vars($data);
            $this->load->view('admin_hotel/template');
        } else {
            $this->member_login();
        }

    }

    function member_login()
    {
        $this->_loadDependency();
        $data['page'] = "member_login";
        $data['asset_url'] = base_url() . "asset";
        $data['actionformurl'] = base_url() . "admin-hotel/check-login";

        $this->load->vars($data);
        $this->load->view('admin_hotel/template');

    }

    function member_logout()
    {
        $this->session->unset_userdata("username");
        $this->session->unset_userdata("password");
        $this->session->unset_userdata("hotel");
        redirect('admin_hotel/login', 'refresh');

    }

    /**
     * @todo buat menghormati ssl dan metode login dari website sebelumnya
     */
    function check_login()
    {
        if ($this->input->post('user') and $this->input->post('pass')) {
             
            $tablename = 'fe_users';
            $name = $this->input->post('user');
            $pwd = $this->input->post('pass');
            if ($data = check_hotel_user($tablename, $name, $pwd)) {
                $tablename = 'tx_rwadminhotel_hotel';
                $data['hotel'] = $data[$tablename];
                $data['user'] = $name;

                $this->session->set_userdata($data);
                redirect('admin-hotel/login/sub-menu-admin/profile', 'refresh');
            } else {
                redirect('admin-hotel/login', 'refresh');
            }
        } else {
            redirect('admin-hotel/login', 'refresh');
        }

    }

    function room_management() {
        $this->_loadDependency();
        if ($this->model->is_hotel_logged_in()) {
            $page = 'roommanagementpage';
            $hotelid = $this->session->userdata('hotel');
            $data = $this->model->getHotels($hotelid);

            $data = $this->add_default_data($data);
            $data['title'] = "Golden VIP: " . ucfirst($page);
            $data['page'] = strtolower($page);
            $data['menu'] = $this->model->get_admin_hotel_nav($data['page'], base_url());

            $data['form_action'] = current_url();

            /** based on page HTML */
//          @todo make mechanisme to edit form when default or when edit
            $data['form_button'] = $this->model->get_input_button($page);

            $this->load->vars($data);
            $this->load->view('admin_hotel/template');
        } else {
            $this->member_login();
        }

    }

    function rooms_pics_updating() {
        $this->_loadDependency();
        if ($this->model->is_hotel_logged_in()) {
            $page = 'roomspicsupdating';
            $hotelid = $this->session->userdata('hotel');
            $data = $this->model->getHotels($hotelid);

            $data = $this->add_default_data($data);
            $data['title'] = "Golden VIP: " . ucfirst($page);
            $data['page'] = strtolower($page);
            $data['menu'] = $this->model->get_admin_hotel_nav($data['page'], base_url());

            $data['form_action'] = current_url();

            /** based on page HTML */
//          @todo make mechanisme to edit form when default or when edit
            $data['form_button'] = $this->model->get_input_button($page);

            $this->load->vars($data);
            $this->load->view('admin_hotel/template');
        } else {
            $this->member_login();
        }
    }

    function add_default_data($data) {
        if (empty($data) || !is_array($data)) {
            $data = array();
        }
        $base_url = base_url();
        $data['base_url'] = $base_url;
        $data['asset_url'] = $base_url . "asset";
        $data['logo'] = $this->model->get_logo($data['asset_url']);
        $data['upload_url'] = $base_url . 'upload';
        $data['adminhotel_url'] = $base_url . 'admin-hotel';
        $data['logout_url'] = $base_url . 'admin-hotel/logout';
        return $data;

    }

}