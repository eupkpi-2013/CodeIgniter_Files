<?php
	class Rate extends CI_Controller {
		public function __construct()
	{
		parent::__construct();			
		
		$this->data['styles'] = array(
		1 => 'style.css',
		
		);
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
			//$this->load->view('kpi/navbar_'.$user);
		//	$this->load->model('addratemodel');
		//	$this->addratemodel->adduserrate();
			//$this->load->view('kpi/user_rate');
			//$this->load->view('kpi/'.$page,$data);
			$this->load->view('kpi/footer');
			


	}
	
			public function kpi(){
			
			$this->load->helper('url');
			
			$q = $_GET['q'];
			
			
			$this->load->view('kpi/header');
			$this->load->view('kpi/banner');
			//$this->load->view('kpi/navbar_'.$user);
			$this->load->model('submitmodel');
			$this->submitmodel->submitRates();
			//$this->load->view('kpi/user_rate');
			//$this->load->view('kpi/'.$page,$data);
			$this->load->view($q);
			$this->load->view('kpi/footer');
			}
		

		}
		
		
?>