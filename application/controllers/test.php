<?php
class Test extends CI_Controller
{
	public function index()
	{
		#$this->daterangepicker();
            $this->form_upload();
	}
	function timepicker()
	{
		$this->load->view('test/timepicker');
	}
	function daterangepicker()
	{
		$this->load->view('test/daterangepicker');
	}
        function form_upload()
        {
            $this->load->view('test/form_upload');
        }
        function do_upload_file()
	{
		$config['upload_path'] = './upload/itienary/';
		$config['allowed_types'] = 'gif|jpg|png|doc|docx';
		$config['max_size']	= '5000';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
                debug_data($config);
		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());
                        debug_data($error);
			//$this->load->view('upload_form', $error);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
                        debug_data($data);
			//$this->load->view('upload_success', $data);
		}
	}
}