<?php
	class Rate extends CI_Controller {
		public function __construct()
	{
		parent::__construct();			
		
		$this->data['styles'] = array(
		1 => 'style.css',
		
		);
		}
		public function index(){
			$this->load->helper('url');
		
			$this->load->view("vHead");
			$this->load->view("vHeader");
			$this->load->view("vRate");
			$this->load->view("vFooter");
		}
		
		public function kpi(){
			$this->load->helper('url');
			
			$q = $_GET['q'];
			
			if($q == "1"){
			$this->load->view("vHead");
			$this->load->view("vHeader");
			$this->load->view("vRate_kpi".$q);
			$this->load->view("vFooter");
			}
			else{
			$this->load->view("vHead");
			$this->load->view("vHeader");
			$this->load->model('addratemodel');
			$this->addratemodel->adduserrate();
			$this->load->view("vRate_kpi".$q);
			$this->load->view("vFooter");
			
		}
		
		}
	}
?>