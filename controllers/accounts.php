<?php

	Class Accounts extends CI_Controller {

		public function __construct(){
			parent::__construct();
			$this->load->database();
		}

		public function index() {
			$this->load->model('subsuperuser_db');
	
			$data['query'] = $this->subsuperuser_db->getaccountdetails();

			$this->load->helper('url');
			$this->load->view('header');
			$this->load->view('header2');
			$this->load->view('usernav');
			$this->load->view('accounts_view', $data);
			$this->load->view('footer');
		}
	}
?>