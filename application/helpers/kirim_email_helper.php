<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if (!function_exists('kirim_kirim_email')) {

    function kirim_kirim_email($list = array('one@example.com'), $sbj = 'Reservation infromation', $msg = 'Thank you for making reservation') {
        $CI = & get_instance();
        $CI->load->library('email');
        $config['protocol'] = 'mail';
        $config['mailtype'] = 'text';
        $config['charset'] = 'utf-8';
        $config['wordwrap'] = TRUE;
        $CI->email->initialize($config);
        $CI->email->from('info@mygoldenvip.com', 'Info Admin GVIP');
        $CI->email->to($list);
        //$CI->email->cc('another@another-example.com');
        //$CI->email->bcc('them@their-example.com');

        $CI->email->subject($sbj);
        $CI->email->message($msg);
        $CI->email->send();
//        echo $CI->email->print_debugger();
    }

}
?>
