<?php
	class Results extends CI_Controller {
		public function index(){
			$this->load->helper('url');
		
			$this->load->view("vHead");
			$this->load->view("vHeader");
			$this->load->view("vResults");
			$this->load->view("vFooter");
		}
		
		public function reports(){
			$this->load->helper('url');
			
			$q = $_GET['q'];
			
			$this->load->view("vHead");
			$this->load->view("vHeader");
			$this->load->view("vResults");
			$this->load->view("vFooter");
		}
	}
?>