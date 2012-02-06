<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sertificate
 *
 * @author aceng nursamsudin
 */
class Sertificate extends CI_Controller{
    //put your code here
    public function __construct() {
        parent::__construct();
        is_member();
    }
    public function index(){
        $uid = $this->session->userdata('member');
        $data = $this->Mix->read_row_by_one('uid', $uid, 'tx_rwmembermlm_member');
        
        $nama =  $data['firstname']." ".$data['lastname'];
        $gabung = date('d-M-Y',$data['crdate']);
        
        $this->get_pdf($nama,$gabung);
    }
    
    function get_pdf($nama = '', $ga) {
        $this->fpdf->FPDF('P', 'cm', 'A4');
        $this->fpdf->SetTopMargin(2);
        $this->fpdf->SetLeftMargin(2);
        $this->fpdf->Ln();
        $this->fpdf->AddPage();
        $this->fpdf->Image(base_url() . 'upload/background.jpg', 0, 0, 21);
        
        $this->fpdf->ln(0);
        $this->fpdf->SetFont('Arial','b', 22);
        $this->fpdf->text(6.5, 7.8, $nama);
        $this->fpdf->Output();
    }
}

?>
