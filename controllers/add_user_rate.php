<?php
	class Add_user_rate extends CI_Controller {
		
		public function __construct()
	{
		parent::__construct();
		$this->load->model('user_db');
	}
		
		public function index()
	{
	
		//if( !file_exists('application/views/kpi/'.$page.'.php'))
		//{
			//$this->load->helper('url');
			//echo site_url();
			//show_404();
		//}
		
		//$data['title'] = ucfirst($page);
		
		//$user = strtok($page, "_");
	
			$this->load->view('kpi/header');
			$this->load->view('kpi/banner');
			$this->load->view('kpi/view_user_rate');
			//$this->load->view('kpi/navbar_'.$user);
			$this->load->model('addratemodel');
			$this->addratemodel->adduserrate();
			//$this->load->view('kpi/user_rate');
			//$this->load->view('kpi/'.$page,$data);
			$this->load->view('kpi/footer');
			


	}
		

		}
		
		
?>