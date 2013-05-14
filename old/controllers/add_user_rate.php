<?php
	class Add_user_rate extends CI_Controller {
		public function __construct()
	{
		parent::__construct();			
		
		$this->data['styles'] = array(
		1 => 'style.css',
		
		);
		}
		public function index(){
			$this->load->view('kpi/header');
			$this->load->view('kpi/banner');
			$this->load->view('kpi/navbar_user');
			$this->load->model('addratemodel');
			$this->addratemodel->adduserrate();
			//$this->load->view('kpi/user_rate');
			//$this->load->view('kpi/'.$page,$data);
			//redirect('index.php/user_rate.html');
			$this->load->view('kpi/footer');
			


	}
		

		}
		
		
?>