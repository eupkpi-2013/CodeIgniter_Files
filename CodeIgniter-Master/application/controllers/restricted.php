<?php
class Restricted extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        if (! $this->session->userdata('first_name'))
        {
            redirect('restricted/index');//redirect('index'); // the user is not logged in, redirect them!
        }
    }
	
	public function index() {
		$this->load->view('kpi/index');
	}
}
?>