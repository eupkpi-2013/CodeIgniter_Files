<?php
	class Home extends CI_Controller {
		public function index(){
			$this->load->helper('url');
		
			$this->load->view("vHead");
			$this->load->view("vHeader");
			$this->load->view("vHome");
			$this->load->view("vFooter");
		}
	}
?>