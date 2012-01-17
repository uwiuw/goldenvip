<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of account
 *
 * @author aceng nursamsudin
 */
class Account extends CI_Controller {

    //put your code here
    public function index() {
        is_admin();
        $this->account_settings();
    }

    function account_settings() {
        is_admin();
        $this->load->view('panel/page/account/account_settings');
    }

    function saving_account() {
        is_admin();
        $pw = $this->input->post('pwd');
        $pw2 = $this->input->post('pwd2');
        if($pw != $pw2):
            echo "password not same";
        else:
            $val = '1';
            $data['password'] = md5($pw);
            $tb = 'be_users';
            $this->Mix->update_record('uid', $val, $data, $tb);
            echo "password has been updated";
        endif;
    }

}

?>
