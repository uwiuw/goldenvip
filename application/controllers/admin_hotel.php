<?php

/**
 * C:\xampplite\htdocs\goldenvip\typo3conf\ext\rw_admin_hotel_mlm\pi1\class.tx_rwadminhotelmlm_pi1.php
 */
class Admin_hotel extends CI_Controller
{

    /**
     * model for this controller
     * @var CI_Adhotel
     */
    private $model;

    private function _loadDependency($modelfile = 'Adhotel') {

        $this->model = load_class($modelfile, 'models');
        $this->model->session = $this->session;

    }

    function index()
    {
        $this->_loadDependency();
        if ($this->model->is_hotel_logged_in()) {
            if ($_GET["cmd"]) {
                $this->_profile_ajax();
            } else {
                $this->profile();
            }
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
            if ($_GET["cmd"]) {
                $this->_profile_ajax();
            } else {
                $page = 'Profile';
                $hotelid = $this->session->userdata('hotel');
                $data = $this->model->getHotels($hotelid);

                $data = $this->add_default_data($data);
                $data['title'] = "Golden VIP: " . ucfirst($page);
                $data['page'] = strtolower($page);
                $data['menu'] = $this->model->get_admin_hotel_nav($data['page'], base_url());

                /**
                 * Based on page HTML
                 * @todo make mechanisme to edit form when default or when edit
                 */
                $action = $this->input->get('action');
                if ($_POST['aksi'] == 'edit') {
                    $data = $this->_profile_aksi_edit($data);
                } elseif ($_POST['aksi'] == 'save') {
                    $data = $this->_profile_aksi_save($data);
                } else {
                    $data = $this->_profile_aksi_normal($data);
                }
                $data['current_url'] = current_url();
                $this->load->vars($data);
                $this->load->view('admin_hotel/template');
            }
        } else {
            $this->member_login();
        }

    }

    private function _profile_aksi_save($data) {
        $hotelid = $this->session->userdata('hotel');

        $fileName = strtolower($_FILES['image']['name']);
        $file_edit = str_replace(" ", "_", $fileName);
        $random_digit = rand(0000, 9999);
        $upload_path = FCPATH . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR . 'tx_rwadminhotel_mlm/';

        $new_file_name = $random_digit . "_" . $file_edit;
        $fileType = $_FILES['image']['type'];
        $fileSize = $_FILES['image']['size'];
        $fileError = $_FILES['image']['error'];

        $move = move_uploaded_file($_FILES['image']['tmp_name'], $upload_path . $new_file_name);

//tidak ada file yg diupload
        if ($_POST['destination_detail'] == "") {
//1 : destination tidak ada
            $updateArray = array(
                'hotel_name' => $_POST['hotel_name'],
                'location' => $_POST['location'],
                'uid_destination' => $_POST['destination'],
                'star' => $_POST['star'],
                'description' => $_POST['desc'],
                'map' => '' . $_POST['map'] . '',
                'email' => $_POST['email']
            );
        } else {
//2 : destination berganti
            $updateArray = array(
                'hotel_name' => $_POST['hotel_name'],
                'location' => $_POST['location'],
                'uid_destination' => $_POST['destination'],
                'star' => $_POST['star'],
                'description' => $_POST['desc'],
                'map' => '' . $_POST['map'] . '',
                'email' => $_POST['email'],
                'uid_destination_detail' => $_POST['uid_destination_detail']
            );
        }

        if ($fileName) {
//if request provide new image
            $updateArray['image'] = $new_file_name;
        }
        $this->db->where('uid', $hotelid);
        $this->db->update('tx_rwadminhotel_hotel', $updateArray);
        $url = current_url() . '/';

    }

    private function _profile_aksi_normal($data) {
        $uid_destination = $data['uid_destination'];
        $sql = "SELECT * FROM tx_rwmembermlm_destination WHERE uid=$uid_destination";
        $city = $this->Mix->read_rows_by_sql($sql);
        $destination = $city['destination'];
        $disable = ' disabled="1" ';
        $data['disable'] = $disable;
        $star = $data['star'];
        $data['star'] = <<<HTML
<input type="text" value="$star" $disable size="50"/>
HTML;
        $data['destination'] = <<<HTML
<input type="text" $name='destination' value="$destination" $disable size="50"/>
HTML;

        $data['form_button'] = <<<HTML
<input type="hidden" name="aksi" value="edit" />
<tr class="even">
    <td colspan="2"><input type="submit" name="submit" value="Edit"/></td>
</tr>
HTML;
        $data['form_action'] = current_url() . '?action=edit';

        return $data;

    }

    private function _profile_aksi_edit($data) {
        $citydata = $this->model->get_admin_hotel_destination($data['uid_destination']);
        $hotelid = $this->session->userdata('hotel');
        $query = "SELECT * FROM tx_rwadminhotel_hotel WHERE uid=$hotelid";
        $rec1 = $this->Mix->read_rows_by_sql($query);

        if ($rec1['uid_destination_detail'] != 0) {

            $query = "SELECT a.*,b.destination_detail,c.destination
                FROM tx_rwadminhotel_hotel a
                LEFT JOIN tx_rwmembermlm_destination_detail b
                ON a.uid_destination_detail=b.uid
                INNER JOIN tx_rwmembermlm_destination c
                ON a.uid_destination=c.uid WHERE a.uid=$hotelid";
        } else {

            $query = "SELECT a.*,b.uid as uid_destination, b.destination
                FROM tx_rwadminhotel_hotel a
                LEFT JOIN tx_rwmembermlm_destination b
                ON a.uid_destination=b.uid
                WHERE a.uid=$hotelid";
        }

        $temp = $this->Mix->read_rows_by_sql($query);

        $data = array_merge($data, $temp);
        $data['form_button'] = <<<HTML
<tr class="even">
    <td colspan="2">
        <input type="hidden" name="aksi" value="save">
        <input type="submit" name="submit" value="Save">&nbsp;&nbsp;
        <input type="button" value="Back" onclick="history.go(-1)">
    </td>
</tr>
HTML;

        extract($citydata);
        $uid_destination = $data['uid_destination'];

        if ($uid_destination) {
            $query = "SELECT * FROM tx_rwmembermlm_destination_detail WHERE uid_destination=$uid_destination";
            $temp = $this->Mix->read_rows_data_by_sql($query);
        }
        if (count($temp)) {
//uid
            $option = $this->_getSelectForm($temp, 'uid', 'destination_detail');
            if ($temp) {
                $uidDestDetail = $data['uid_destination'];
            }

            $data['DestDetail'] = <<<HTML
<tr class="odd">
    <td>Detail Destination</td>
    <td>
        <select name="destination_detail" id="destination_detail">
            $option
        </select>
    </td>
</tr>
HTML;
            $option = '';
        } else {
            $uidDestDetail = "";
            $DestDetail = "Not Found";
            $data['DestDetail'] = <<<HTML
<tr class="odd">
    <td>Detail Destination</td>
    <td>
        <select name="destination_detail" id="destination_detail">
            <option value="">-- Not Found --</option>
        </select>
    </td>
</tr>
HTML;
        }

        /*
         * City
         * * **************************************************** */
        $query = "SELECT * FROM tx_rwmembermlm_destination WHERE deleted=0";
        $temp = $this->Mix->read_rows_data_by_sql($query);

        $option = $this->_getSelectForm($temp, 'uid', 'destination');
        $destination = $data['destination'];
        $data['destination'] = <<<HTML
<select name="destination" id="destination">
    <option value="$uid_city">-- $destination --</option>
    $option
</select>
HTML;
        /* Star
         * * *************************************************** */
        $temp = array(4, 5);
        $option = '';
        foreach ($temp as $v) {
            $option .= "<option value='$v'>$v</option>";
        }
        $star = $data['star'];
        $data['star'] = <<<HTML
<select id="star" name="star">
    <option value="$star">-- $star --</option>
    $option
</select>
HTML;
        /*         * *************************************************** */
        $data['form_action'] = current_url();
        $data['upload_button'] = '<br/><input type="file" name="image" size="36">';
        return $data;

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

            $data = $this->add_default_data($data);
            $data['title'] = "Golden VIP: " . ucfirst($page);
            $data['page'] = strtolower($page);
            $data['menu'] = $this->model->get_admin_hotel_nav($data['page'], base_url());

            $data['form_action'] = current_url();

            if ($_POST['aksi'] == 'tambah') {
                $data = $this->_room_management_tambah($data);
            } elseif ($_GET['action'] == 'edit') {
                $data = $this->_room_management_edit($data);
            } elseif ($_GET['action'] == 'add') {
                $data = $this->_room_management_add($data);
            } elseif ($_GET['action'] == 'delete') {
                $this->_room_management_delete();
            } else {
                $data = $this->_room_management_normal($data);
            }

            /** based on page HTML */
//          @todo make mechanisme to edit form when default or when edit
            $this->load->vars($data);
            $this->load->view('admin_hotel/template');
        } else {
            $this->member_login();
        }

    }

    private function _room_management_edit($data) {
        $hotelid = $this->session->userdata('hotel');
        $buildroom = $_GET['buildroom'];
        if ($_POST['submit']) {
            $roomCat = $_POST['roomCat'];
            $maxPeople = $_POST['maxPeople'];
            $published_rate = $_POST['published_rate'];
            $retail_rate = $_POST['retail_rate'];
            $roomStok = $_POST['roomStok'];
            $facilities = $_POST['facilities'];
            $query = <<<HTML
UPDATE tx_rwadminhotel_cat_room SET
    category_name='$roomCat',
    max_people='$maxPeople',
    published_rate='$published_rate',
    retail_rate='$retail_rate',
    stok='$roomStok',
    facilities='$facilities'
    WHERE uid="$buildroom"
HTML;

            $this->db->query($query);
        }

        $query = <<<HTML
SELECT * FROM tx_rwadminhotel_cat_room WHERE uid="$buildroom" AND uid_hotel="$hotelid" AND deleted=0
HTML;
        $queryO = $this->db->query($query);
        $obj = $queryO->result();
        extract(get_object_vars($obj[0]));

        foreach (array(1, 2, 3, 4, 5) as $k => $v) {
            if ($v === $maxPeople) {
                $option = "<option value='$v'>$v</option>" . $option;
            } else {
                $option .= "<option value='$v'>$v</option>";
            }
        }

        $data['table'] = <<<HTML
<form method="POST" action="" id="form-edit" class="et-form" name="add">
    <table id="tablesorter-demo" class="tablesorter" border="0" cellpadding="0" cellspacing="1">
        <tbody>
            <tr class="even">
                <td>Room Type</td>
                <td><input type="text" name="roomCat" value="$category_name" id="category"></td>
                <td>
                    <div id="errorCat" style="color: red;"></div>
                </td>
            </tr>
            <tr class="odd">
                <td>Max People</td>
                <td><select name="maxPeople" id="maxPeople">$option</select></td>
                <td><div id="errorMaxPeople" style="color: red;"></div></td>
            </tr>
            <tr class="even">
                <td>Published Rates</td>
                <td><input type="text" id="published_rate" name="published_rate" value="$published_rate">&nbsp;USD / IDR</td>
                <td>
                    <div id="errorPublishedRate" style="color: red;"></div>
                </td>
            </tr>
            <tr class="odd">
                <td>Retail Rates</td>
                <td><input type="text" onkeypress="validate(event)" id="retail_rate" name="retail_rate" value="$retail_rate">&nbsp;IDR (Just Number)</td>
                <td>
                    <div id="errorRate" style="color: red;"></div>
                </td>
            </tr>
            <tr class="even">
                <td>Allotments</td>
                <td><input type="text" onkeypress="validate(event)" name="roomStok" value="$stok" id="stok"></td>
                <td>
                    <div id="errorstok" style="color: red;"></div>
                </td>
            </tr>
            <tr class="odd">
                <td>Facilities</td>
                <td>
                    <textarea name="facilities" cols="40" rows="10" id="facilities">$facilities</textarea>
                </td>
                <td>
                    <div id="errorFacilities" style="color: red;"></div>
                </td>
            </tr>

        </tbody>
    </table>
    <input type="submit" value="Save" name="submit" id="submit_photo" class="et-form-btn">
    <input type="button" value="Back" onclick="history.go(-1);">
</form>
HTML;
        return $data;

    }

    private function _room_management_tambah($data) {
        $hotelid = $this->session->userdata('hotel');
        extract($_POST);
        $input = array(
            'uid_hotel' => $hotelid,
            'category_name' => $roomCat,
            'max_people' => $maxPeople,
            'published_rate' => $published_rate,
            'retail_rate' => $retail_rate,
            'stok' => $roomStok,
            'facilities' => $roomStok
        );

        $this->db->insert('tx_rwadminhotel_cat_room', $input);

        $url = current_url() . '/';
        redirect($url, 'location');

    }

    private function _room_management_delete($data) {
        $buildroom = $_GET['buildroom'];
        $query = "DELETE FROM tx_rwadminhotel_cat_room WHERE uid=$buildroom";
        $query = $this->db->query($query);
        $url = current_url() . '/';
        redirect($url, 'location');

    }

    private function _room_management_add($data) {
        $url = current_url();
        $data['table'] = <<<HTML
<form method="POST" action="" id="form-edit" class="et-form" name="add">
    <table id="tablesorter-demo" class="tablesorter" border="0" cellpadding="0" cellspacing="1">
        <tbody>
            <tr class="even">
                <td>Room Type</td>
                <td><input type="text" name="roomCat" value="" id="category"></td>
                <td>
                    <div id="errorCat" style="color: red;"></div>
                </td>
            </tr>
            <tr class="odd">
                <td>Max People</td>
                <td><select name="maxPeople" id="maxPeople">
                        <option value="">-- Select --</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                    </td>
                <td>
                    <div id="errorMaxPeople" style="color: red;"></div>
                </td>
            </tr>
            <tr class="even">
                <td>Published Rates</td>
                <td><input type="text" id="published_rate" name="published_rate">&nbsp;USD / IDR</td>
                <td>
                    <div id="errorPublishedRate" style="color: red;"></div>
                </td>
            </tr>
            <tr class="odd">
                <td>Retail Rates</td>
                <td><input type="text" onkeypress="validate(event)" id="retail_rate" name="retail_rate">&nbsp;IDR (Just Number)</td>
                <td>
                    <div id="errorRate" style="color: red;"></div>
                </td>
            </tr>
            <tr class="even">
                <td>Allotments</td>
                <td><input type="text" onkeypress="validate(event)" name="roomStok" value="" id="stok"></td>
                <td>
                    <div id="errorstok" style="color: red;"></div>
                </td>
            </tr>
            <tr class="odd">
                <td>Facilities</td>
                <td>
                    <textarea name="facilities" cols="40" rows="10" id="facilities"></textarea>
                </td>
                <td>
                    <div id="errorFacilities" style="color: red;"></div>
                </td>
            </tr>
            <input type="hidden" name="aksi" value="tambah">
        </tbody>
    </table>
    <input type="button" value="Save" onclick="check()">&nbsp;
    <input type="button" value="Back" onclick="history.go(-1);">
</form>
HTML;
        return $data;

    }

    private function _room_management_normal($data) {
        $base_url = base_url();
        $base_url = substr_replace($base_url, '', strlen($base_url) - 1);
        $asset_url = $base_url . '/asset/';
        $adminhotel_url = $base_url . '/admin-hotel';

        $hotelid = $this->session->userdata('hotel');
        $query = <<<HTML
SELECT * FROM tx_rwadminhotel_cat_room WHERE uid_hotel="$hotelid" AND deleted=0
HTML;
        $queryO = $this->db->query($query);
        $items = $queryO->result();
        if (count($items)) {
            $number = 0;
            foreach ($items as $k => $v) {
                $number++;

                extract(get_object_vars($v));

                $goldenvipRate = number_format($rowRoom['rate'], 0, "", ".");
                $published_rate = number_format($published_rate, 0, "", ".");
                $retail_rate = number_format($retail_rate, 0, "", ".");
                $html .= <<<HTML

        <tr class="even">
            <td>$number</td>
            <td>$category_name</td>
            <td>$published_rate</td>
            <td>$retail_rate</td>
            <td>$stok</td>
            <td><a href="$adminhotel_url/login/sub-menu-admin/room-management/?action=edit&buildroom=$uid" >
                <img src=$asset_url/admin_hotel/edit-icon.png width=15px; title="Edit"></a>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <img onclick=deletedRecord("$base_url/admin-hotel/login/sub-menu-admin/room-management/","$title","$uid","Room");
                    src=$base_url/asset/admin_hotel/delete.png width=15px; title="Delete">
            </td>
        </tr>
HTML;
            } //end foreach
            $data['table'] = <<<HTML
<div id="pack" style="border: 1px solid rgb(187, 187, 187); overflow: auto; width: 100%; height: 400px;">
    <table id="tablesorter-demo" class="tablesorter" border="0" cellpadding="0" cellspacing="1" width="1000px">
        <thead>
            <tr>
                <th class="header">No.</th>
                <th class="header headerSortDown">Room Type</th>
                <th class="header headerSortDown">Published Rates (USD / IDR)</th>
                <th class="header headerSortDown">Retail Rates (IDR)</th>
                <th class="header headerSortDown">Alot</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            $html
        </tbody>
    </table>
    <a href="$adminhotel_url/login/sub-menu-admin/room-management/?action=add" >
        <div id="tk"><img src="$asset_url/admin_hotel/add-icon.png" width=15px; title="Add Room">Add Room</div>
    </a>
</div>
HTML;
        }


        return $data;

    }

    function periode_print() {
        $this->_loadDependency();
        if ($this->model->is_hotel_logged_in()) {
            $page = 'periodeprint';
            $hotelid = $this->session->userdata('hotel');
            $data = $this->model->getHotels($hotelid);

            $data = $this->add_default_data($data);
            $data['title'] = "Golden VIP: " . ucfirst($page);

            if ($_POST['print_booking_now'] == '1') {
                $data = $this->_periode_print_bookingnow($data);
            } else {
                $data = $this->_periode_print_normal($data);
            }

            $data['page'] = strtolower($page);
            /** based on page HTML */
            $this->load->vars($data);
            $this->load->view('admin_hotel/template');
        } else {
            $this->member_login();
        }

    }

    function _periode_print_bookingnow($data) {

        $this->load->library('FPDF');
        $layout_pdf = new FPDF('P', 'mm', 'A4');
        $layout_pdf->AddPage();
        $layout_pdf->SetFont('times', 'U', 10);
        $layout_pdf->SetTextColor(0, 0, 0);
        $layout_pdf->SetXY(20, 8);
        $layout_pdf->Cell(155, 10, "Date Booking For " . $_POST['datepicker'] . " / " . $_POST['datepicker1'], 0, 0, 'C');
        $layout_pdf->SetFillColor(0, 0, 0);
        $layout_pdf->SetFont('times', 'B', 7);
        $layout_pdf->SetTextColor(0, 0, 0);
        $layout_pdf->SetXY(5, 20);
        $layout_pdf->Cell(10, 10, "No", 1, 1, 'C');
        $layout_pdf->SetXY(15, 20);
        $layout_pdf->Cell(26, 10, "Name", 1, 1, 'C');
        $layout_pdf->SetXY(41, 20);
        $layout_pdf->Cell(18, 10, "Date Booking", 1, 1, 'C');
        $layout_pdf->SetXY(59, 20);
        $layout_pdf->Cell(25, 10, "Room", 1, 1, 'C');
        $layout_pdf->SetXY(84, 20);
        $layout_pdf->Cell(15, 10, "Check-in", 1, 1, 'C');
        $layout_pdf->SetXY(99, 20);
        $layout_pdf->Cell(15, 10, "Check-Out", 1, 1, 'C');
        $layout_pdf->SetXY(114, 20);
        $layout_pdf->Cell(10, 10, "Qty", 1, 1, 'C');
        $layout_pdf->SetXY(124, 20);
        $layout_pdf->Cell(20, 10, "Reservation", 1, 1, 'C');
        $layout_pdf->SetXY(144, 20);
        $layout_pdf->Cell(40, 10, "Email", 1, 1, 'C');
        $layout_pdf->SetXY(184, 20);
        $layout_pdf->Cell(20, 10, "Price", 1, 1, 'C');
        $layout_pdf->SetFont('arial', '', 10);

        $datepicker = $_POST['datepicker'];
        $datepicker1 = $_POST['datepicker1'];

        $hotelid = $this->session->userdata('hotel');
        $query = <<<HTML
SELECT a.*,b.category_name,c.username,c.email as emailMember,c.middle_name,c.last_name,
        d.firstname,d.username,d.lastname,d.dob,d.email as emailnya
    FROM tx_rwadminhotel_booking a
    INNER JOIN tx_rwadminhotel_cat_room b ON a.uid_room=b.uid
    INNER JOIN fe_users c ON a.uid_member=c.uid
    INNER JOIN tx_rwmembermlm_member d ON c.username=d.username
    WHERE a.date_booking
    BETWEEN "$datepicker" AND "$datepicker1"
        AND a.deleted = 0
        AND b.uid_hotel=$hotelid
        ORDER BY uid DESC
HTML;

        $obj = $this->db->query($query);


        $query = <<<HTML
SELECT a.*,b.category_name FROM tx_rwadminhotel_booking a LEFT JOIN tx_rwadminhotel_cat_room b ON a.uid_room=b.uid
HTML;

        $obj2 = $this->db->query($query);

        $lists = $obj->result();
        $count = count($lists);
        if ($count > 0) {

            $index = 0;
            foreach ($lists as $k => $list) {
                $list = get_object_vars($list);
                $book[$index][0] = $list['name_reservation'];
                $book[$index][1] = $list['date_booking'];
                $book[$index][2] = $list['category_name'];
                $book[$index][3] = $list['check_in'];
                $book[$index][4] = $list['check_out'];
                $book[$index][5] = $list['qty'];
                $book[$index][6] = $list['status'];
                $book[$index][7] = $list['reservation'];
                $book[$index][8] = $list['sale_compliment'];
                $book[$index][9] = $list['email'];
                $book[$index][10] = "IDR " . number_format($list['rate'], 0, "", ".");
                $index++;
            }

            for ($i = 0; $i < $count; $i++) {
                $height = ($i * 6) + 30;
                $layout_pdf->SetFont('times', '', 5.5);
                $layout_pdf->SetTextColor(0, 0, 0);
                $layout_pdf->SetXY(5, $height);
                $layout_pdf->Cell(10, 6, $i + 1, 1, 1, 'C');
                $layout_pdf->SetXY(15, $height);
                $layout_pdf->Cell(26, 6, $book[$i][0], 1, 1, 'C');
                $layout_pdf->SetXY(41, $height);
                $layout_pdf->Cell(18, 6, $book[$i][1], 1, 1, 'C');
                $layout_pdf->SetXY(59, $height);
                $layout_pdf->Cell(25, 6, $book[$i][2], 1, 1, 'C');
                $layout_pdf->SetXY(84, $height);
                $layout_pdf->Cell(15, 6, $book[$i][3], 1, 1, 'C');
                $layout_pdf->SetXY(99, $height);
                $layout_pdf->Cell(15, 6, $book[$i][4], 1, 1, 'C');
                $layout_pdf->SetXY(114, $height);
                $layout_pdf->Cell(10, 6, $book[$i][5], 1, 1, 'C');

                $layout_pdf->SetXY(124, $height);
                $layout_pdf->Cell(20, 6, $book[$i][7], 1, 1, 'C');

                $layout_pdf->SetXY(144, $height);
                $layout_pdf->Cell(40, 6, $book[$i][9], 1, 1, 'C');
                $layout_pdf->SetXY(184, $height);
                $layout_pdf->Cell(20, 6, $book[$i][10], 1, 1, 'C');
            }
            $layout_pdf->Output();
        }

        $data = $this->_periode_print_normal($data);
        return $data;

    }

    function _periode_print_normal($data) {
        $data['menu'] = $this->model->get_admin_hotel_nav('booking', base_url());
        $data['form_action'] = current_url();

        return $data;

    }

    function booking() {
        $this->_loadDependency();
        if ($this->model->is_hotel_logged_in()) {
            $page = 'booking';
            $hotelid = $this->session->userdata('hotel');
            $data = $this->model->getHotels($hotelid);

            $data = $this->add_default_data($data);
            $data['title'] = "Golden VIP: " . ucfirst($page);
            $data['page'] = strtolower($page);
            $data['menu'] = $this->model->get_admin_hotel_nav($data['page'], base_url());
            $data['form_action'] = current_url();

            if ($_POST['canceled'] == '1') {
                $this->_booking_canceled($data);
            } elseif ($_GET['tx_rwadminhotelmlm_pi1']['action'] == 'cancel') {
                $data = $this->_booking_cancel($data);
            } elseif ($_GET['tx_rwadminhotelmlm_pi1']['action'] == "valid") {
                $this->_booking_validity($data, 'valid');
            } elseif ($_GET['tx_rwadminhotelmlm_pi1']['action'] == "not_valid") {
                $this->_booking_validity($data, 'not valid');
            } else {
                $data = $this->_booking_normal($data);
            }

            /** based on page HTML */
            $this->load->vars($data);
            $this->load->view('admin_hotel/template');
        } else {
            $this->member_login();
        }

    }

    private function _booking_canceled($data) {
        $base_url = base_url();
        $base_url = substr_replace($base_url, '', strlen($base_url) - 1);

        $qty = ($_POST['total'] - $_POST['total_cancel']);
        $total_cancel = $_POST['total_cancel'];
        $uidBooking = $_GET['tx_rwadminhotelmlm_pi1']['uidBooking'];

        $query = "UPDATE tx_rwadminhotel_booking SET qty='$qty',canceled='$total_cancel' WHERE uid=$uidBooking";
        $this->db->query($query);

        $url = current_url() . '/';
        redirect($url, 'location');

    }

    private function _booking_cancel($data) {

        $base_url = base_url();
        $base_url = substr_replace($base_url, '', strlen($base_url) - 1);
        $adminhotel_url = $base_url . '/admin-hotel/';
        $action = $_GET['tx_rwadminhotelmlm_pi1']['action'];
        $uidBooking = $_GET['tx_rwadminhotelmlm_pi1']['uidBooking'];
        $total = $_GET['tx_rwadminhotelmlm_pi1']['total'];

        for ($i = 1; $i <= $total; $i++) {
            $option .= "<option value='$i'>$i</option>";
        }
        $option = "<option>0</option>" . $option;

        $data['table'] = <<<HTML
<table id="tablesorter-demo" class="tablesorter" border="0" cellpadding="0" cellspacing="1">
    <tbody>
        <form method="POST" action="">
            <tr class="even">
                <td>ID Booking</td>
                <td><input type="text" name="id_booking" value="$uidBooking" disabled="1" size="50"></td>
            </tr>
            <tr class="odd">
                <td>Total Canceled</td>
                <td><select name="total_cancel" style="width: 100px;">
                        $option
                    </select>
                </td>
            </tr>
            <input type="hidden" name="canceled" value="1">
            <input type="hidden" name="total" value="$total">
            <tr class="even">
                <td colspan="2"><input type="submit" value="Cancel Room"></td>
            </tr>
        </form>
    </tbody>
</table>
HTML;
        return $data;

    }

    private function _booking_validity($data, $update_to) {
        $base_url = base_url();
        $base_url = substr_replace($base_url, '', strlen($base_url) - 1);
        $adminhotel_url = $base_url . '/admin-hotel/';
        $action = $_GET['tx_rwadminhotelmlm_pi1']['action'];
        $uidBooking = $_GET['tx_rwadminhotelmlm_pi1']['uidBooking'];

        $hotelid = $this->session->userdata('hotel');

        $query = <<<HTML
SELECT a.*,b.category_name,c.hotel_name
    FROM tx_rwadminhotel_booking a
    INNER JOIN tx_rwadminhotel_cat_room b ON a.uid_room=b.uid
    INNER JOIN tx_rwadminhotel_hotel c
    ON b.uid_hotel=c.uid
    WHERE a.uid_member="$hotelid"
    AND a.deleted=0 ORDER BY uid DESC
HTML;
        $queryO = $this->db->query($query);
        $recHotel = $queryO->result();
        if ($recHotel['star'] == '5') {
            $points = 10;
        } else {
            $points = 5;
        }

        $query = <<<HTML
SELECT * FROM tx_rwadminhotel_booking WHERE uid=$uidBooking
HTML;
        $queryO2 = $this->db->query($query);
        $recs = $queryO2->result();

        foreach ($recs as $k => $rec) {
            $rec = get_object_vars($rec);
            $uid_member = $rec['uid_member'];
            $tgl1 = $rec['check_in'];
            $tgl2 = $rec['check_out'];
            $query = <<<HTML
 SELECT * FROM fe_users WHERE uid=$uid_member
HTML;
            $queryO3 = $this->db->query($query);
            $recMember = $queryO3->result();
            $username = $recMember[0]->username;

            $query = <<<HTML
SELECT * FROM tx_rwmembermlm_member WHERE username="$username"
HTML;

            $queryO4 = $this->db->query($query);
            $recMember1 = $queryO4->result();

            $cv = $recMember1[0]->cv;
            $pecah1 = explode("-", $tgl1);
            $date1 = $pecah1[2];
            $month1 = $pecah1[1];
            $year1 = $pecah1[0];
            $pecah2 = explode("-", $tgl2);
            $date2 = $pecah2[2];
            $month2 = $pecah2[1];
            $year2 = $pecah2[0];
            $jd1 = GregorianToJD($month1, $date1, $year1);
            $jd2 = GregorianToJD($month2, $date2, $year2);
            $selisih = abs($jd2 - $jd1);
            $total = $cv + ($selisih * $points);

            $query = <<<HTML
SELECT * FROM tx_rwadminhotel_booking WHERE uid="$uidBooking" AND reservation = "Compliment"
HTML;
            $queryO5 = $this->db->query($query);
            $cekCompliment = $queryO5->result();

            $query = <<<HTML
UPDATE tx_rwadminhotel_booking SET status='$update_to' WHERE uid=$uidBooking
HTML;
            $this->db->query($query);

            if ($cekCompliment) {
                $query = <<<HTML
UPDATE tx_rwmembermlm_member SET cv='0' WHERE username="$username"
HTML;
                $this->db->query($query);
            }
        }

        $url = current_url() . '/';
        redirect($url, 'location');

    }

    private function _booking_normal($data) {
        $base_url = base_url();
        $base_url = substr_replace($base_url, '', strlen($base_url) - 1);
        $adminhotel_url = $base_url . '/admin-hotel/';
        $action = $_GET['tx_rwadminhotelmlm_pi1']['action'];

        $hotelid = $this->session->userdata('hotel');
        $query = <<<HTML
SELECT a.*,b.category_name,c.username,c.email,c.middle_name,c.last_name,d.firstname,
    d.username,d.lastname,d.dob,d.email
    FROM tx_rwadminhotel_booking a
    INNER JOIN tx_rwadminhotel_cat_room b ON a.uid_room=b.uid
    INNER JOIN fe_users c ON a.uid_member=c.uid
    INNER JOIN tx_rwmembermlm_member d ON c.username=d.username
    WHERE a.deleted = 0 AND b.uid_hotel=$hotelid
HTML;
        $queryO = $this->db->query($query);

        if ($queryO) {

            foreach ($queryO->result() as $obj) {
                $number++;

                $reservation = empty($obj->reservation) ? 'Personal Account' : $obj->reservation;
                $signature = empty($obj->signature) ? 'Not Valid' : "<img src=$base_url/uploads/tx_rwadminhotel_mlm/" . $obj->signature . " width=150px; height=70px;>";

                if ($status == 'valid') {
                    $linkvalid = <<<HTML
<a href="$base_url/admin-hotel/login/sub-menu-admin/bookings/?tx_rwadminhotelmlm_pi1%5Baction%5D=not_valid&amp;
tx_rwadminhotelmlm_pi1%5BuidBooking%5D=$uid" >Not Show</a>
HTML;
                } else {
                    $linkvalid = <<<HTML
<a href="$base_url/admin-hotel/login/sub-menu-admin/bookings/?tx_rwadminhotelmlm_pi1%5Baction%5D=valid&amp;
tx_rwadminhotelmlm_pi1%5BuidBooking%5D=$uid" >Show</a>
HTML;
                }

                $HTML .= <<<HTML
<tr class="even">
    <td>$number</td>
    <td>$obj->name_reservation</td>
    <td>$reservation</td>
    <td>$obj->check_in</td>
    <td>$obj->check_out</td>
    <td>$obj->category_name</td>
    <td>$obj->date_booking</td>
    <td>$obj->credit_card_number</td>
    <td>$obj->qty</td>
    <td>$obj->canceled</td>
    <td>$reservation</td>
    <td>$obj->email</td>
    <td>$obj->rate</td>
    <td>$obj->signature</td>
    <td>$obj->status</td>
    <td>$linkvalid
&nbsp;&nbsp;<a href="$base_url/admin-hotel/login/sub-menu-admin/bookings/?tx_rwadminhotelmlm_pi1%5Baction%5D=cancel&amp;
tx_rwadminhotelmlm_pi1%5BuidBooking%5D=$obj->uid&amp;
tx_rwadminhotelmlm_pi1%5Btotal%5D=$obj->qty" >Cancel</a></td>
</tr>
HTML;
            }
        }

        $printLink = <<<HTML
<form method="POST" action="">
<table>
    <tbody>
        <tr>
            <td>
                <div class="teksnya">Teks</div>
            </td>
            <td>:</td>
            <td><input type="text" name="search" class="search_book"></td>
            <td rowspan="3"><input type="submit" class="button_search_book" name="submit" value="search"></td>
            <td rowspan="3">
                <div id="print">
                    <a href="$base_url/admin-hotel/login/sub-menu-admin/bookings/periode-print/">Print</a>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="teksnya">Category</div>
            </td>
            <td>:</td>
            <td><select name="category" class="search_book_cat">
                    <option value="">-- Select Category --</option>
                    <option value="member">Member (First Name)</option>
                    <option value="date_booking">Date Booking (yy-mm-dd)</option>
                    <option value="room">Room</option>
                    <option value="check_in">Check In (yy-mm-dd)</option>
                    <option value="check_out">Check Out (yy-mm-dd)</option>
                    <option value="uid">ID Booking</option>
                </select>
            </td>
        </tr>
    </tbody>
</table>
</form>

HTML;
        $HTML = <<<HTML
<div id="pack" style="border: 1px solid rgb(187, 187, 187); overflow: auto; width: 100%; height: 500px; ">
    $printLink
    <table id="tablesorter-demo" class="tablesorter" border="0" cellpadding="0" cellspacing="1">
        <thead>
            <tr>
                <th class="header">No.</th>
                <th class="header headerSortDown">Name</th>
                <th class="header headerSortDown">Status</th>
                <th class="header headerSortDown">Check In</th>
                <th class="header headerSortDown">Check Out</th>
                <th class="header headerSortDown">Room</th>
                <th class="header headerSortDown">Date Booking</th>
                <th class="header headerSortDown">Credit Card Number</th>
                <th class="header headerSortDown">Qty</th>
                <th class="header headerSortDown">Canceled</th>
                <th class="header headerSortDown">Reservation</th>
                <th class="header headerSortDown">Email</th>
                <th class="header headerSortDown">Price</th>
                <th class="header headerSortDown">Signature</th>
                <th class="header headerSortDown">Conf.</th>
                <th class="header headerSortDown">Action</th>
            </tr>
        </thead>
        <tbody>
            $HTML
        </tbody>
    </table>
</div>
HTML;
        $data['table'] = $HTML;

        return $data;

    }

    function hotels_pics_updating() {
        $this->_loadDependency();
        if ($this->model->is_hotel_logged_in()) {
            $page = 'hotelspicsupdating';
            $hotelid = $this->session->userdata('hotel');
            $data = $this->model->getHotels($hotelid);

            $data = $this->add_default_data($data);
            $data['title'] = "Golden VIP: " . ucfirst($page);
            $data['page'] = strtolower($page);
            $data['menu'] = $this->model->get_admin_hotel_nav($data['page'], base_url());

            $data['form_action'] = current_url();

            if ($_POST['action_foto'] == 'add') {
                $data = $this->_hotels_pics_updating_add($data);
            } elseif ($_POST['action_foto'] == 'save') {
                $this->_hotels_pics_updating_save();
            } elseif ($_GET['tx_rwadminhotelmlm_pi1']['action'] == 'delete'
                & false != ($uid = $_GET['tx_rwadminhotelmlm_pi1']['uidRoom'])) {
                $this->_hotels_pics_updating_delete();
            } elseif ($_POST['action_foto'] == 'simpanedit') {
                $this->_hotels_pics_updating_simpanedit();
            } elseif ($_GET['tx_rwadminhotelmlm_pi1']['action'] == 'edit'
                && false != ($uid = $_GET['tx_rwadminhotelmlm_pi1']['uid'])) {
                $data = $this->_hotels_pics_updating_edit($uid, $data);
            } else {
                $data['form_button'] = $this->_hotels_pics_updating_button($data);
                $data = $this->_hotels_pics_updating_normal($data);
            }

            /** based on page HTML */
            $this->load->vars($data);
            $this->load->view('admin_hotel/template');
        } else {
            $this->member_login();
        }

    }

    private function _hotels_pics_updating_add($data) {
        $url = current_url();
        $data['table'] = <<<HTML
<form method="POST" action="$url" enctype="multipart/form-data">
    <tr class="even">
        <td>Title</td>
        <td><input type="text" name="title" size="50"/></td>
    </tr>
    <tr class="odd">
        <td>Foto</td>
        <td><input type="file" name="image" size="50"/></td>
    </tr>
    <input type="hidden" name="action_foto" value="save" />
    <tr class="even">
        <td colspan="2"><input type="submit" value="save" /></td>
    </tr>
</form>
HTML;

        return $data;

    }

    private function _hotels_pics_updating_delete() {
        $uidRoom = $_GET['tx_rwadminhotelmlm_pi1']['uidRoom'];
        $query = "DELETE FROM tx_rwadminhotel_foto_hotel WHERE uid=$uidRoom";
        $query = $this->db->query($query);
        $url = current_url() . '/';
        redirect($url, 'location');

    }

    private function _hotels_pics_updating_save() {
        $hotelid = $this->session->userdata('hotel');
        $fileName = strtolower($_FILES['image']['name']);
        $file_edit = str_replace(" ", "_", $fileName);
        $random_digit = rand(0000, 9999);
        $upload_path = FCPATH . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR . 'tx_rwadminhotel_mlm/';

        $new_file_name = $random_digit . "_" . $file_edit;
        $fileType = $_FILES['image']['type'];
        $fileSize = $_FILES['image']['size'];
        $fileError = $_FILES['image']['error'];

        $move = move_uploaded_file($_FILES['image']['tmp_name'], $upload_path . $new_file_name);

        $uid = $_POST['uid'];
        $title = $_POST['title'];

        if ($fileName == "") {
//bila tidak ada file image yg baru
            $query = "INSERT INTO tx_rwadminhotel_foto_hotel(uid_hotel,title,image) VALUES ('$hotelid','$title','$new_file_name')";
            $query = $this->db->query($query);
        } else {
            $query = "INSERT INTO tx_rwadminhotel_foto_hotel(uid_hotel,title,image) VALUES ('$hotelid','$title','$new_file_name')";
            $query = $this->db->query($query);
        }

        $url = current_url() . '/';

        redirect($url, 'refresh');

    }

    private function _hotels_pics_updating_simpanedit() {
        $fileName = strtolower($_FILES['image']['name']);
        $file_edit = str_replace(" ", "_", $fileName);
        $random_digit = rand(0000, 9999);
        $upload_path = FCPATH . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR . 'tx_rwadminhotel_mlm/';

        $new_file_name = $random_digit . "_" . $file_edit;
        $fileType = $_FILES['image']['type'];
        $fileSize = $_FILES['image']['size'];
        $fileError = $_FILES['image']['error'];
        $move = move_uploaded_file($_FILES['image']['tmp_name'], $upload_path . $new_file_name);

        $uid = $_POST['uid'];
        $title = $_POST['title'];
        $hotelid = $this->session->userdata('hotel');
        if ($fileName == "") {
//bila tidak ada file image yg baru
            $query = "UPDATE tx_rwadminhotel_foto_hotel SET uid_hotel='$hotelid',title='$title' WHERE uid=$uid";
            $query = $this->db->query($query);
        } else {
            $query = "UPDATE tx_rwadminhotel_foto_hotel " .
                "SET uid_hotel='$hotelid',title='$title',image='$new_file_name' WHERE uid=$uid";
            $query = $this->db->query($query);
        }

        $url = current_url();
        header('location: ' . $url);

    }

    private function _hotels_pics_updating_pagenation(array $data) {
        $hotelid = $this->session->userdata('hotel');
        $base_url = base_url();
        $upload_url = $base_url . 'upload';
        $page_url = $base_url . 'admin-hotel/login/sub-menu-admin/hotels-pics-updating';
        $limit = 3;
        $page = $_GET['tx_rwadminhotelmlm_pi1']['page'];

        if (empty($page)) {
            $posisi = 0;
            $page = 1;
        } else {
            $posisi = ($page - 1) * $limit;
        }
        $this->pagenya = $page;

        $queryFoto = "SELECT * FROM tx_rwadminhotel_foto_hotel WHERE deleted=0 AND uid_hotel=$hotelid LIMIT $posisi, 3";
        $queryFoto = $this->Mix->read_rows_data_by_sql($queryFoto);

        $queryCount = "SELECT * FROM tx_rwadminhotel_foto_hotel WHERE deleted=0 AND uid_hotel=$hotelid";
        $this->count = $this->db->query($queryCount)->num_rows;
        $this->jmlHalaman = ceil($this->count / $limit);

//creating hotels
        $index = 1;
        foreach ($queryFoto as $k => $v) {
            $evenodd = ($evenodd === 'even') ? 'odd' : 'even';
            extract($v);
            $HTML .= <<<HTML
<tr class="$evenodd">
    <td>$index</td>
    <td>$title</td>
    <td><img src=$upload_url/tx_rwadminhotel_mlm/$image width=150px; height=100px;></td>
    <td align="center">
        <a href="$base_url/admin-hotel/login/sub-menu-admin/hotels-pics-updating/?tx_rwadminhotelmlm_pi1%5Baction%5D=edit&amp;
tx_rwadminhotelmlm_pi1%5Buid%5D=$uid" >
        <img src=$base_url/asset/admin_hotel/edit-icon.png width=15px; title="Edit"></a>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <img onclick=deletedRecord("$base_url/admin-hotel/login/sub-menu-admin/hotels-pics-updating/","$title","$uid","Room");
            src=$base_url/asset/admin_hotel/delete.png width=15px; title="Delete">
    </td>
</tr>
HTML;
            $index++;
        }

        $data['table'] = $HTML;

        /**
         * Pagination
         */
        $paging_no = $page - 1;
        $no = ($limit * $paging_no) + 1;
        $prev = $page - 1;
        if ($page != '1') {
            $PagePrev = <<<HTML
<a href="$page_url/?tx_rwadminhotelmlm_pi1%5Bpage%5D=$prev" >&nbsp;&nbsp;Prev&nbsp;&raquo;</a>
HTML;
        } else {
            $PagePrev = "<b>&laquo;
&nbsp;
Prev&nbsp;
&nbsp;
</b>";
        }
        for ($i = 1; $i <= $this->jmlHalaman; $i++)
            if ($i != $this->pagenya) {
                $pageCenter .= <<<HTML
<a href="$page_url/?tx_rwadminhotelmlm_pi1%5Bpage%5D=$i" >&nbsp;$i&nbsp;</a>
HTML;
            } else {
                $pageCenter .= "<b>&nbsp;
$i&nbsp;
</b>";
            }
        $next = ($page) + 1;
        if ($page != $this->jmlHalaman) {
            $PageNext = <<<HTML
<a href="$page_url/?tx_rwadminhotelmlm_pi1%5Bpage%5D=$next" >&nbsp;&nbsp;Next&nbsp;&raquo;</a>
HTML;
        } else {
            $PageNext = "<b>&nbsp;
&nbsp;
Next&nbsp;
&raquo;
</b>";
        }

        $data['pagination'] = <<<HTML
<div id="pagination">
    $PagePrev
    $pageCenter
    $PageNext
</div>
HTML;

        return $data;

    }

    private function _hotels_pics_updating_normal($data) {
        $base_url = base_url();
        $base_url = substr_replace($base_url, '', strlen($base_url) - 1);
        $adminhotel_url = $base_url . '/admin-hotel/';
        $hotelid = $this->session->userdata('hotel');
        $data = $this->_hotels_pics_updating_pagenation($data);

        return $data;

    }

    private function _hotels_pics_updating_button($data) {
        extract($data);

        if ($_POST['action_foto']) {

        } else {
            $o = <<<HTML
<form method="POST" action="$form_action">
    <input type="hidden" name="action_foto" value="add"/>
    <input type="submit" value="Add" />
</form>
HTML;
        }

        return $o;

    }

    private function _rooms_pics_updating_normal($data) {
        $base_url = base_url();
        $base_url = substr_replace($base_url, '', strlen($base_url) - 1);
        $hotelid = $this->session->userdata('hotel');

        $query = "SELECT a.*, b.category_name
            FROM tx_rwadminhotel_foto a
            INNER JOIN tx_rwadminhotel_cat_room b
                ON a.category=b.uid
            WHERE a.deleted=0 AND a.uid_hotel=" . $hotelid;
        $items = $this->Mix->read_rows_data_by_sql($query);
        if (is_array($items) && count($items)) {
            foreach ($items as $k => $v) {
                $number++;
                extract($v);
                if (empty($image)) {
                    $image = 'Logo_Core.jpg';
                }
                $imageintable = <<<HTML
<img src=$base_url/upload/tx_rwadminhotel_mlm/$image width=150px; height=100px;>
HTML;
                $HTML .= <<<HTML
<tr class="even">
    <td>$number</td>
    <td>$category_name</td>
    <td>$title</td>
    <td>$imageintable</td>
    <td align="center">
        <a href="$base_url/admin-hotel/login/sub-menu-admin/rooms-pics-updating/?tx_rwadminhotelmlm_pi1%5Baction%5D=edit&amp;
tx_rwadminhotelmlm_pi1%5Buid%5D=$uid" >
        <img src=$base_url/asset/admin_hotel/edit-icon.png width=15px; title="Edit"></a>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <img onclick=deletedRecord("$base_url/admin-hotel/login/sub-menu-admin/rooms-pics-updating/","deluxe&nbsp;double&nbsp;1","$uid","Room");
                src=$base_url/asset/admin_hotel/delete.png width=15px; title="Delete"></td>
</tr>
HTML;
            }
        }

        $data['table'] = $HTML;
        $data['form_button'] = <<<HTML
<form method="POST" action="">
    <input type="hidden" name="action_foto" value="add"/>
    <input type="submit" value="Add" />
</form>
HTML;
        return $data;

    }

    private function _hotels_pics_updating_edit($uid, $data)
    {
        $upload_url = base_url() . 'upload';
        $query = "SELECT * FROM tx_rwadminhotel_foto_hotel WHERE deleted=0 AND uid=$uid";
        $output = $this->Mix->read_rows_by_sql($query);
        $form_action = $data['form_action'] . '/';

        $data['form_button'] = '';
        extract($output);

        $data['table'] = <<<HTML
<form method="POST" action="$form_action" enctype="multipart/form-data">
    <input type="hidden" name="uid" value="$uid" />
    <tr class="even">
        <td>Title</td>
        <td><input type="text" name="title" value="$title" size="50"/></td>
    </tr>
    <tr class="odd">
        <td>Image</td>
        <td><img src=$upload_url/tx_rwadminhotel_mlm/$image width=150px; height=100px;></td>
    </tr>
    <tr class="even">
        <td>Foto</td>
        <td><input type="file" name="image" size="50"/></td>
    </tr>
    <input type="hidden" name="action_foto" value="simpanedit" />
    <tr class="even">
        <td colspan="2"><input type="submit" value="save" /></td>
    </tr>
</form>
HTML;


        return $data;

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
            if ($_POST['action_foto'] == 'add') {
                $data = $this->_rooms_pics_updating_add($data);
            } elseif ($_POST['action_foto'] == 'save') {

                $data = $this->_rooms_pics_updating_save($data);
            } elseif ($_GET['tx_rwadminhotelmlm_pi1']['action'] == 'delete'
                & false != ($uid = $_GET['tx_rwadminhotelmlm_pi1']['uidRoom'])) {
                $data = $this->_rooms_pics_updating_delete($uid);
            } elseif ($_POST['action_foto'] == 'simpanedit') {
                $data = $this->_rooms_pics_updating_simpanedit($uid, $data);
            } elseif ($_GET['tx_rwadminhotelmlm_pi1']['action'] == 'edit'
                && false != ($uid = $_GET['tx_rwadminhotelmlm_pi1']['uid'])) {
                $data = $this->_rooms_pics_updating_edit($uid, $data);
            } else {
                $data = $this->_rooms_pics_updating_normal($data);
            }

            /** based on page HTML */
//          @todo make mechanisme to edit form when default or when edit

            $this->load->vars($data);
            $this->load->view('admin_hotel/template');
        } else {
            $this->member_login();
        }

    }

    private function _rooms_pics_updating_delete($uid) {
        $query = "DELETE FROM tx_rwadminhotel_foto WHERE uid=$uid";
        $query = $this->db->query($query);
        $url = current_url() . '/';
        redirect($url, 'location');
        die();

    }

    private function _rooms_pics_updating_simpanedit() {
        $hotelid = $this->session->userdata('hotel');
        $fileName = strtolower($_FILES['image']['name']);
        $file_edit = str_replace(" ", "_", $fileName);
        $random_digit = rand(0000, 9999);
        $upload_path = FCPATH . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR . 'tx_rwadminhotel_mlm/';

        $new_file_name = $random_digit . "_" . $file_edit;
        $fileType = $_FILES['image']['type'];
        $fileSize = $_FILES['image']['size'];
        $fileError = $_FILES['image']['error'];

        $move = move_uploaded_file($_FILES['image']['tmp_name'], $upload_path . $new_file_name);

        $uid = $_POST['uid'];
        $title = $_POST['title'];
        $category = $_POST['category'];

        if ($fileName == "") {
//bila tidak ada file image yg baru
            $query = "UPDATE tx_rwadminhotel_foto SET uid_hotel='$hotelid',title='$title',category='$category' WHERE uid=$uid";
        } else {
            $query = "UPDATE tx_rwadminhotel_foto " .
                "SET uid_hotel='$hotelid',title='$title',category='$category', image='$new_file_name' WHERE uid=$uid";
        }
        $query = $this->db->query($query);

        $url = current_url() . '/';
        redirect($url, 'location');

    }

    private function _rooms_pics_updating_edit($uid, $data)
    {
        $upload_url = base_url() . 'upload';
        $query = "SELECT * FROM tx_rwadminhotel_foto WHERE deleted=0 AND uid=$uid";
        $query = "SELECT a.*,b.category_name FROM tx_rwadminhotel_foto a INNER JOIN
            tx_rwadminhotel_cat_room b ON a.category=b.uid WHERE a.deleted=0 AND a.uid=$uid";
        $queryO = $this->db->query($query);
        $items = $queryO->result();

        $form_action = $data['form_action'] . '/';
        $data['form_button'] = '';

        $title = $items[0]->title;
        $uid = $items[0]->uid;
        $image = $items[0]->image;
        if ($items[0]->category) {
            $hotelid = $this->session->userdata('hotel');
            $query = "SELECT * FROM tx_rwadminhotel_cat_room WHERE uid_hotel=$hotelid";
            $queryO = $this->db->query($query);
            $cats = $queryO->result();

            foreach ($cats as $k => $v) {
                $cat = $v->uid;
                $cat_name = $v->category_name;
                if ($cat == $items[0]->category) {
                    $options = "<option value='$cat'>$cat_name</option>" . $options;
                } else {
                    $options .= <<<HTML
<option value="$cat">$cat_name</option>
HTML;
                }
            }
        } else {
            $options = <<<HTML
            <option value="26">-- Deluxe Room --</option>
HTML;
        }

        $data['table'] = <<<HTML
<form method="POST" action="$form_action" enctype="multipart/form-data">
    <input type="hidden" name="uid" value="$uid" />
    <tr class="even">
        <td>Title</td>
        <td><input type="text" name="title" value="$title" size="50"></td>
    </tr>
    <tr class="odd">
        <td>category</td>
        <td>
            <select name="category">
                $options
            </select>
        </td>
    </tr>
    <tr class="even">
        <td>Image</td>
        <td><img src=$upload_url/tx_rwadminhotel_mlm/$image width=150px; height=100px;></td>
    </tr>
    <tr class="even">
        <td>Foto</td>
        <td><input type="file" name="image" size="50"></td>
    </tr>
    <input type="hidden" name="action_foto" value="simpanedit">
    <tr class="even">
        <td colspan="2"><input type="submit" value="save"></td>
    </tr>
</form>
HTML;


        return $data;

    }

    private function _rooms_pics_updating_save() {
        $hotelid = $this->session->userdata('hotel');
        $fileName = strtolower($_FILES['image']['name']);
        $file_edit = str_replace(" ", "_", $fileName);
        $random_digit = rand(0000, 9999);
        $upload_path = FCPATH . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR . 'tx_rwadminhotel_mlm/';

        $new_file_name = $random_digit . "_" . $file_edit;
        $fileType = $_FILES['image']['type'];
        $fileSize = $_FILES['image']['size'];
        $fileError = $_FILES['image']['error'];

        $move = move_uploaded_file($_FILES['image']['tmp_name'], $upload_path . $new_file_name);

        $title = $_POST['title'];
        $category = $_POST['category'];

        if ($fileName == "") {
//bila tidak ada file image yg baru
            $query = "INSERT INTO tx_rwadminhotel_foto(uid_hotel,title,category) VALUES ('$hotelid','$title', '$category' )";
            $query = $this->db->query($query);
        } else {
            $query = "INSERT INTO tx_rwadminhotel_foto(uid_hotel,title,category,image) VALUES ('$hotelid','$title','$category','$new_file_name')";
            $query = $this->db->query($query);
        }

        $url = current_url() . '/';
        redirect($url, 'location');

    }

    private function _rooms_pics_updating_add($data) {
        $url = current_url();
        $hotelid = $this->session->userdata('hotel');
        $query = "SELECT * FROM tx_rwadminhotel_cat_room WHERE deleted=0 AND uid_hotel=$hotelid";
        $queryObj = $this->db->query($query);
        $output = $queryObj->result();

        if ($output) {
            $option = '<option>-- Select Category --</option>';
            foreach ($output as $k => $v) {
                $cat = $v->category_name;
                $uid = $v->uid;
                $option .= "<option value='$uid'>$cat</option>";
            }
        } else {
            $option = '<option>-- Select Category --</option>';
        }

        $data['table'] = <<<HTML
<form method="POST" action="$url" enctype="multipart/form-data">
    <tr class="even">
        <td>Title</td>
        <td><input type="text" name="title" size="50"/></td>
    </tr>
    <tr class="odd">
        <td>Category</td>
        <td>
            <select name="category">
                $option
            </select>
         </td>
    </tr>
    <tr class="odd">
        <td>Foto</td>
        <td><input type="file" name="image" size="50"/></td>
    </tr>
    <input type="hidden" name="action_foto" value="save" />
    <tr class="even">
        <td colspan="2"><input type="submit" value="save" /></td>
    </tr>
</form>
HTML;

        return $data;

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

    private function _getSelectForm(array $temp, $vkey, $vtitle) {
        foreach ($temp as $v) {
            $value = $v[$vkey];
            $title = $v[$vtitle];
            $option .= "<option value='$value'>$title</option>";
        }

        return $option;

    }

    private function _profile_ajax() {
        switch ($_GET['cmd'])
        {
            case 'getDestinationProfile':
                $this->_profile_ajax_getDestinationProfile();
                break;
            case 'getCity':
                $this->_profile_ajax_getCity();
                break;
            default:
//                echo 'belum diimplementasikan' . $_GET['cmd'];
                break;
        }

        die();

    }

    private function _profile_ajax_getCity() {
        $propinsi = $_GET['propinsi'];
        if ($propinsi) {
            $query = "SELECT * FROM tx_rwmembermlm_city WHERE uid_province=$propinsi";
            $queryObj = $this->db->query($query);
            $r = $queryObj->result();
            foreach ($r as $k => $v) {
                $uid = $v->uid;
                $title = $v->city;
                echo "<option value='$uid'>$title</option>";
            }
        }

    }

    private function _profile_ajax_getDestinationProfile() {
        $destination = $_GET['destination'];
        if ($destination) {
            $query = "SELECT * FROM tx_rwmembermlm_destination_detail WHERE uid_destination=$destination";
            $queryObj = $this->db->query($query);
            $r = $queryObj->result();

            if (count($r)) {
                $query = "SELECT * FROM tx_rwmembermlm_destination_detail WHERE uid_destination=$destination ORDER BY destination_detail ASC";
                $queryObj = $this->db->query($query);
                $r = $queryObj->result();
                foreach ($r as $k => $v) {
                    $uid = $v->uid;
                    $destination_detail = $v->destination_detail;
                    echo "<option value='$uid'>$destination_detail</option>";
                }
            } else {
                echo "<option value=''>Not Found</option>";
            }
        }

    }

}