<?php
class Kpi extends CI_Controller {

	// public function __construct()
	// {
		// parent::__construct();
	// }
	
	public function view($page)
	{		
		$this->load->view('kpi/header');
		$this->load->view('kpi/'.$page);
		$this->load->view('kpi/footer');
	}
	
	// public function index()
// {
	// $this->load->view('kpi/header', $data);
	// $this->load->view('kpi/index', $data);
	// $this->load->view('kpi/footer');
// }
}