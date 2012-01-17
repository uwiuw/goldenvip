<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Mail_settings extends CI_Controller {

    public function index() {
        is_admin();
        $this->load_settings_mail();
    }

    function load_settings_mail() {
        is_admin();
        $data['email'] = $this->Mix->read_rows('admin_request_mail');
        $this->load->view('panel/page/mail_settings/load_settings_mail',$data);
    }

    function simpan_alamat_email() {
        is_admin();
        if ($this->input->post('mega')):
            $this->load->helper('email');
            if (valid_email($this->input->post('mega'))):
                $data['email'] = $this->input->post('mega');
                echo "data has been updated for mega travel insurance";
                $val = $this->input->post('idmega');
                $tb = "admin_request_mail";
                $this->Mix->update_record('uid', $val, $data, $tb);
            else:
                echo "not valid email address for mega travel insurance";
            endif;
        else:
            echo "email is blank for mega travel insurance ";
        endif;
        
        if ($this->input->post('golden')):
            $this->load->helper('email');
            if (valid_email($this->input->post('golden'))):
                $data['email'] = $this->input->post('golden');
                echo " & data has been updated for Golden VIP";
                $val = $this->input->post('id');
                $tb = "admin_request_mail";
                $this->Mix->update_record('uid', $val, $data, $tb);
            else:
                echo " & not valid email address for GOlden VIP";
            endif;
        else:
            echo " & email is blank for Golden VIP ";
        endif;
    }

}

?>
