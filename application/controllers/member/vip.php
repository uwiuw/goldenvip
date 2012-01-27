<?php

class Vip extends CI_Controller {

    public function index() {
        $this->holy_land();
    }

    public function holy_land() {
        is_member(); # Hanya member yang boleh memasuki halaman ini

        $u = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member', 'username', $this->session->userdata('member'), 'uid');
        $uid_member = $this->Mix->read_row_ret_field_by_value('fe_users', 'uid', $u['username'], 'username');
        $sql = "select uid from tx_rwadminhotel_booking where hidden = '1' and uid_member = '" . $uid_member['uid'] . "' ";
        $uid = $this->Mix->read_rows_by_sql($sql);

        if (!empty($uid)) {
            $this->Mix->dell_one_by_one('uid', $uid['uid'], 'tx_rwadminhotel_booking');
        }

        $data = $this->get_data_package('4');

        $this->load->vars($data);
        $this->load->view('member/template');
    }

    function non_holyland() {
        is_member(); # Hanya member yang boleh memasuki halaman ini

        $u = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member', 'username', $this->session->userdata('member'), 'uid');
        $uid_member = $this->Mix->read_row_ret_field_by_value('fe_users', 'uid', $u['username'], 'username');
        $sql = "select uid from tx_rwadminhotel_booking where hidden = '1' and uid_member = '" . $uid_member['uid'] . "' ";
        $uid = $this->Mix->read_rows_by_sql($sql);

        if (!empty($uid)) {
            $this->Mix->dell_one_by_one('uid', $uid['uid'], 'tx_rwadminhotel_booking');
        }

        $data = $this->get_data_package('5');

        $this->load->vars($data);
        $this->load->view('member/template');
    }

    function get_data_package($pid) {
        $data['title'] = "Member | Home Page | Reservation";
        $data['page'] = "vip/reservation";
        $data['nav'] = "reservation";
        if ($pid == '4') {
            $data['selected'] = 'Holyland';
        } else {
            $data['selected'] = 'Non Holyland';
        }
        $data['pid'] = $pid;
        $data['template'] = base_url() . "asset/theme/mygoldenvip/";
        $data['destination'] = $this->Mix->read_package_by_pid($pid);
        $m = $this->Mix->read_row_by_one('uid', $this->session->userdata('member'), 'tx_rwmembermlm_member');
        if ($m['package'] < '3') {
            $data['set_compliment'] = '0';
        } else {
            $data['set_compliment'] = '1';
        }

        /*
         * cek apakah ada point yang bisa ditukar ?
         */
        $sql = "select 
                sum(a.point)- b.pointrewards as total_point
                from 
                tx_rwmembermlm_pointrewards a,
                tx_rwmembermlm_member b
                where 
                a.uid_member = b.uid and
                a.uid_member = '" . $this->session->userdata('member') . "' and 
                a.hidden = '0' and 
                a.paid ='0'";
        $point = $this->Mix->read_rows_by_sql($sql);

        if ($point['total_point'] == '0'):
            /*
             * update data point di table point rewards paid jadi 1
             * dan update member.pointrewards jadi 0
             * artinya reset kembali point rewards
             */
            $sql = "UPDATE 
                    tx_rwmembermlm_pointrewards
                    SET 
                    paid=1 
                    where 
                    hidden = 0 and
                    uid_member = '" . $this->session->userdata('member') . "'";
            $this->db->query($sql);
            $sql2 = "UPDATE 
                    tx_rwmembermlm_member
                    SET 
                    pointrewards=0 
                    where 
                    uid = '" . $this->session->userdata('member') . "'";
            $this->db->query($sql2);
        endif;

        $sql = "select 
                *
                from
                tx_rwmembermlm_destination
                where
                pid > 2 and
                point < '" . $point['total_point'] . "'";
        $cek_point = $this->Mix->read_rows_by_sql($sql);
        if (!empty($cek_point)):
            $data['opt_point'] = "<option value='Redeem'>Redeem Point</option>";
        else:
            $data['opt_point'] = '';
        endif;

        return $data;
    }

    function package_selected() {
        is_member();
        /* check : 	jika terdapat data dengan inisiasi hidden 1 artinya dahulu user pernah akan reservasi tetapi tidak sampai akhir, 
          hapus data tersebut */
        $check = $this->Mix->read_row_by_two('uid_member', $this->session->userdata('member'), 'hidden', '1', 'tx_rwagen_vipbooking');
        if (!empty($check)) {
            $this->Mix->dell_one_by_one('uid', $check['uid'], 'tx_rwagen_vipbooking');
        }
        /* end dari pengecekan */
        $data = array();
        $insert = array();
        $tujuan = $this->input->post('destination');
        $tanggal = $this->input->post('datepicker');
        /* insert into table booking by vip */
        $insert['hidden'] = '1';
        $insert['uid_member'] = $this->session->userdata('member');
        $insert['payed'] = 0;
        if ($this->input->post('compliment') == '0') {
            $insert['reservation'] = 'Personal Account';
            $insert['payment'] = $this->input->post('select_payment');
        } else {
            if ($this->input->post('compliment') == 'Compliment') {
                $insert['reservation'] = $this->input->post('compliment');
                $insert['payment'] = 'Cash';
            } else {
                $insert['reservation'] = $this->input->post('compliment');
                $insert['payment'] = $this->input->post('select_payment');
            }
        }
        if ($this->input->post('payment') == 'Credit Card') {
            $insert['credit_card_number'] = 0;
            $insert['nameOnCC'] = 0;
            $insert['validThru'] = 0;
            $insert['signature'] = 0;
        }

        if ($this->input->post('select_payment') == 'Redeem') {
            /*
             * cek apakah terdapat point rewards yang bisa ditukar dengan destination yang dituju?
             * pointreward.point-member.point > destination.point
             */
            $sql = "select 
                    sum(a.point)- b.pointrewards as total_point
                    from 
                    tx_rwmembermlm_pointrewards a,
                    tx_rwmembermlm_member b
                    where 
                    a.uid_member = b.uid and
                    a.uid_member = '" . $this->session->userdata('member') . "' and 
                    a.hidden = '0' and 
                    a.paid ='0'";
            $point = $this->Mix->read_rows_by_sql($sql);

            $sql = "select 
                *
                from
                tx_rwmembermlm_destination
                where
                pid = 2 and
                point < '" . $point['total_point'] . "'";

            $cek_point = $this->Mix->read_rows_by_sql($sql);
            if (!empty($cek_point)):
                $insert['reservation'] = $this->input->post('select_payment');
                $insert['payment'] = 'Cash';
            else:
                echo "Sorry no point found to redeem, ";
                redirect('member/reservation/travel', 'refresh');
            endif;
        }

        $this->Mix->add_with_array($insert, 'tx_rwagen_vipbooking');
        /* end */

        $sql = "select 
                a.uid,
                a.time_sch, 
                a.qty, 
                a.booking, 
                b.nama, 
                c.name, 
                d.destination
                from 
                tx_rwagen_vipschedule a, 
                tx_rwagen_vippackage b, 
                tx_rwagen_agen c, 
                tx_rwmembermlm_destination d
                where 
                b.destination = d.uid and
                a.package = b.uid and
                b.agen = c.uid and
                a.hidden = 0 and
                d.uid = '$tujuan' and
                a.time_sch = '$tanggal'";

        $data['sch'] = $this->Mix->read_more_rows_by_sql($sql);
        /* data halaman */
        $data['title'] = "Member | Home Page | Reservation";
        $data['page'] = "vip/package_selected";
        $data['nav'] = "reservation";
        $this->load->vars($data);
        $this->load->view('member/template');
    }

    function use_this_reservation_for() {
        is_member();
        $qty = '1';
        $data = array();
        /* check : 	jika terdapat data dengan inisiasi hidden 1 maka data tersebut akan di update untuk qty dan uid_sch ny pada tabel booking */
        $check = $this->Mix->read_row_by_two('uid_member', $this->session->userdata('member'), 'hidden', '1', 'tx_rwagen_vipbooking');
        if (!empty($check)) {
            if ($check['reservation'] != 'Compliment') {
                $qty = $this->input->post('qty');
                $data['tulisan'] = "I Agree To Us My Repeat To :";
            } else {
                $data['tulisan'] = "I Agree To Us My Complimentry  To : ";
            }
        }
        /* data halaman */
        $data['uid_sch'] = $this->input->post('uid_sch');
        $data['qty'] = $qty;
        $data['uidnum'] = $check['uid'];
        $data['page'] = "vip/use_this_reservation_for";
        $data['title'] = "Member | Home Page | Reservation";
        $data['nav'] = "reservation";
        $this->load->vars($data);
        $this->load->view('member/template');
    }

    function set_for_myself() {
        is_member();
        $check = $this->Mix->read_row_by_two('uid_member', $this->session->userdata('member'), 'hidden', '1', 'tx_rwagen_vipbooking');
        if (!empty($check)) {
            $up['hidden'] = '0';
            if ($_GET['qty'] == 1) {
                $this->check_qty();
                $allow = 1;
                $this->set_data_final_booking_vip_click_myself($allow);
                if ($check['reservation'] != 'Personal Account') {
                    disable_complimentary();
                }
                $this->Mix->update_record('uid', $check['uid'], $up, 'tx_rwagen_vipbooking');
                $this->get_pdf($check['uid'], $_GET['qty']);
            } else {
                $qty = $_GET['qty'];
                if (empty($qty)) {
                    echo "<b>sorry you can't reserverd, please try again. <b>";
                    redirect('member/reservation/vip', 'refresh');
                }
                $this->set_data_final_booking_vip_click_myself();
                $this->set_for_other($_GET['qty'], 1, 'and Myself');
            }
        } else {
            redirect('member/reservation/vip', 'refresh');
        }
    }

    function set_data_final_booking_vip_click_myself($allow = 0) {
        is_member();
        $check = $this->Mix->read_row_by_two('uid_member', $this->session->userdata('member'), 'hidden', '1', 'tx_rwagen_vipbooking');
        if (empty($check['uid_sch']) || $allow == 1) {
            $uidnum = $_GET['uidnum'];
            $up['uid_sch'] = $_GET['uid'];
            $up['qty'] = $_GET['qty'];
            $this->Mix->update_record('uid', $uidnum, $up, 'tx_rwagen_vipbooking');

            $sql = "select a.uid as uid_booking, 
                                b.uid as uid_sch, 
                                c.retail_rate as harga 
                                from 
                                tx_rwagen_vipbooking a, 
                                tx_rwagen_vipschedule b, 
                                tx_rwagen_vippackage c 
                                where 
                                a.hidden = '1' and
                                a.uid_sch = b.uid and
                                b.package  = c.uid and
                                a.uid_member = '" . $this->session->userdata('member') . "'";
            $get_data_sch = $this->Mix->read_rows_by_sql($sql);
            $get_data_member = $this->Mix->read_row_by_one('uid', $this->session->userdata('member'), 'tx_rwmembermlm_member');
            $data['nama'] = $get_data_member['firstname'] . " " . $get_data_member['lastname'];
            $data['email'] = $get_data_member['email'];
            $data['insurance'] = '1';
            $data['hidden'] = '0';
            $data['pid'] = $get_data_sch['uid_booking'];
            $data['rate'] = $get_data_sch['harga'];
            # menambahkan data pada tabel vip booking detail
            $this->Mix->add_with_array($data, 'tx_rwagen_vipbookingdetails');
        }
    }

    function set_for_other($qty = '1', $myself = 0, $me = '') {
        is_member();
        if (empty($qty)) {
            echo "<b>sorry you can't reserverd, please try again. <b>";
            redirect('member/reservation/vip', 'refresh');
        }
        $data = array();
        $check = $this->Mix->read_row_by_two('uid_member', $this->session->userdata('member'), 'hidden', '1', 'tx_rwagen_vipbooking');
        if (!empty($check)) {
            $sql = "select 
					a.uid,
					a.time_sch, 
					a.qty, 
					a.booking, 
					b.nama as package, 
					c.name as travel, 
					d.destination, 
					b.retail_rate
					from 
					tx_rwagen_vipschedule a, 
					tx_rwagen_vippackage b, 
					tx_rwagen_agen c, 
					tx_rwmembermlm_destination d 
					where 
					a.package = b.uid and
					b.agen = c.uid and
					b.destination = d.uid  
					and a.uid='" . $_GET['uid'] . "'";
            /* data halaman */
            if ($check['reservation'] != 'Compliment') {
                $data['compliment_only'] = '0';
                $qty = $_GET['qty'] - $myself;
            } else {
                $data['compliment_only'] = '1';
                $data['hidden'] = '<input type="hidden" name="compliment" value="1">';
            }

            $data['me'] = $me;
            $data['qty'] = $qty;
            $data['sch'] = $this->Mix->read_rows_by_sql($sql);
            $data['received'] = $this->Mix->read_row_ret_field_by_value('tx_rwmembermlm_member', 'firstname', $this->session->userdata('member'), 'uid');
            $data['page'] = "vip/set_for_other";
            $data['title'] = "Member | Home Page | Reservation";
            $data['nav'] = "reservation";
            $this->load->vars($data);
            $this->load->view('member/template');
        } else {
            redirect('member/reservation/vip', 'refresh');
        }
    }

    function set_reservation() {
        is_member();

        $data = array();
        $check = $this->Mix->read_row_by_two('uid_member', $this->session->userdata('member'), 'hidden', '1', 'tx_rwagen_vipbooking');
        if (!empty($check)) {
            $this->check_qty();
            // dilakukan lagi pengecekan untuk updata data dari qty
            $check = $this->Mix->read_row_by_two('uid_member', $this->session->userdata('member'), 'hidden', '1', 'tx_rwagen_vipbooking');
            $sql = "select a.uid as uid_booking, b.uid as uid_sch, c.harga as harga from 
                                    tx_rwagen_vipbooking a, tx_rwagen_vipschedule b, tx_rwagen_vippackage c 
                                    where a.hidden = '1' and
                                    a.uid_sch = b.uid and
                                    b.package  = c.uid 
                                    and a.uid_member = '" . $this->session->userdata('member') . "'";
            $get_data_sch = $this->Mix->read_rows_by_sql($sql);
            $get_data_member = $this->Mix->read_row_by_one('uid', $this->session->userdata('member'), 'tx_rwmembermlm_member');
            $data['hidden'] = '0';
            $data['pid'] = $get_data_sch['uid_booking'];
            $data['rate'] = $get_data_sch['harga'];

            $data['email'] = $this->input->post('email');
            $data['insurance'] = '1';

            for ($i = 1; $i <= $this->input->post('qty'); $i++) {
                $data['nama'] = $this->input->post('name' . $i);
                $data['rate'] = $this->input->post('rate') + (100 * $this->input->post('mega' . $i));
                $this->Mix->add_with_array($data, 'tx_rwagen_vipbookingdetails');
            }

            $up['hidden'] = '0';
            $this->Mix->update_record('uid', $get_data_sch['uid_booking'], $up, 'tx_rwagen_vipbooking');
            $this->get_pdf($check['uid'], $check['qty']);
        } else {
            redirect('member/reservation/vip', 'refresh');
        }
    }

    function get_pdf($uid = 0, $limit = 0) {
        is_member();
        $sql = "select 
                a.uid, 
                a.uid_sch, 
                a.payment, 
                b.nama, 
                b.rate as price, 
                a.qty, 
                c.time_sch, 
                d.nama as package, 
                d.deskripsi, 
                e.name as agen, 
                a.reservation
                from 
                tx_rwagen_vipbooking a,
                tx_rwagen_vipbookingdetails b,
                tx_rwagen_vipschedule c,
                tx_rwagen_vippackage d,
                tx_rwagen_agen e
                where 
                a.uid='$uid' and 
                b.pid = a.uid and 
                a.uid_sch = c.uid and 
                c.package = d.uid and 
                d.agen = e.uid
                limit 0,$limit";
        $data = $this->Mix->read_more_rows_by_sql($sql);
        foreach ($data as $row) {
            $pdf['payment'] = $row['payment'];
            $pdf['qty'] = $row['qty'];
            $pdf['package'] = $row['package'];
            $pdf['deskripsi'] = $row['deskripsi'];
            $pdf['depart'] = $row['time_sch'];
            $pdf['status'] = $row['reservation'];
            $pdf['id_booking'] = $row['uid'];
            $pdf['agen'] = $row['agen'];
        }
        if ($pdf['status'] == 'Redeem'):
            $this->kurangi_point($pdf['id_booking']);
        endif;
        //debug_data($pdf);

        $this->fpdf->FPDF('P', 'cm', 'A4');
        $this->fpdf->SetTopMargin(2);
        $this->fpdf->SetLeftMargin(2);
        $this->fpdf->Ln();
        $this->fpdf->AddPage();
        $this->fpdf->Image(base_url() . 'upload/pics/logo.jpg', 1.6, 1.4, 3.5);
        $this->fpdf->ln(0);
        $this->fpdf->SetFont('Arial', 'i', 12);
        $this->fpdf->text(8.6, 3, 'Invoice');

        $this->fpdf->text(1.6, 4, 'ID Booking ');
        $this->fpdf->text(6.6, 4, ': ' . $pdf['id_booking']);
        
        $this->fpdf->text(1.6, 4.5, 'Invoice No ');
        $this->fpdf->text(6.6, 4.5, ': 1000' . $pdf['id_booking']);

        $y = 5;
        $this->fpdf->text(1.6, 5, 'Name Reservation ');

        $price = 0;
        foreach ($data as $row) {
            $this->fpdf->text(6.6, $y, ': ' . $row['nama']);
            $y = $y + 0.5;
            $price = $row['price'] + $price;
        }

        $price = number_format($price);

        $this->fpdf->text(1.6, $y + 1, 'Status ');
        $this->fpdf->text(6.6, $y + 1, ': ' . $pdf['status']);

        $this->fpdf->text(1.6, $y + 1.5, 'Time Schedule ');
        $this->fpdf->text(6.6, $y + 1.5, ': ' . $pdf['depart']);

        $this->fpdf->text(1.6, $y + 2, "Package ");
        $this->fpdf->text(6.6, $y + 2, ": " . $pdf['package']);

        $this->fpdf->text(1.6, $y + 2.5, 'Qty ');
        $this->fpdf->text(6.6, $y + 2.5, ': ' . $pdf['qty']);

        $this->fpdf->text(1.6, $y + 3, 'Price ');
        $this->fpdf->text(6.6, $y + 3, ': USD ' . $price);

        $this->fpdf->text(1.6, $y + 3.5, 'Payment ');
        $this->fpdf->text(6.6, $y + 3.5, ': ' . $pdf['payment']);

        $this->fpdf->Output();
    }

    function check_qty() {
        is_member();
        $qty = $_GET['qty'];
        $uid = $_GET['uid'];
        $uidnum = $_GET['uidnum'];
        $up['uid_sch'] = $uid;
        $up['qty'] = $qty;
        if (empty($qty) || empty($uid)) {
            echo "<b>sorry you can't reserverd, please try again. <b>";
            redirect('member/reservation/vip', 'refresh');
        } else {
            $d = $this->Mix->read_row_ret_field_by_value('tx_rwagen_vipschedule', 'booking', $up['uid_sch'], 'uid');
            $q = $this->Mix->read_row_ret_field_by_value('tx_rwagen_vipschedule', 'qty', $up['uid_sch'], 'uid');

            $qty = $qty + $d['booking'];
            if ($qty > $q['qty']) {
                echo "<b>sorry is not enough quota <b>";
                redirect('member/reservation/vip', 'refresh');
            } else {
                $quote['booking'] = $qty;
                // kesalahan dalam mengupdate jumlah dari qty
                $this->Mix->update_record('uid', $up['uid_sch'], $quote, 'tx_rwagen_vipschedule');
                $this->Mix->update_record('uid', $uidnum, $up, 'tx_rwagen_vipbooking');
            }
        }
    }

    function kurangi_point($id_booking) {
        $sql = "update 
                tx_rwmembermlm_member 
                set 
                pointrewards = (
                        select
                        e.point * b.qty as point
                        from 
                        tx_rwagen_vipbooking b,
                        tx_rwagen_vipschedule c,
                        tx_rwagen_vippackage d,
                        tx_rwmembermlm_destination e
                        where
                        b.uid_sch = c.uid and
                        c.package = d.uid and
                        d.destination = e.uid and
                        b.uid = $id_booking
                ) + pointrewards
                where 
                uid = '" . $this->session->userdata('member') . "'";
        $this->db->query($sql);
    }

}