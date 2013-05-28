<?php

	Class Subsuperuser extends CI_Controller {

		public function __construct() {
			parent::__construct();

			$this->data['styles'] = array(
				1 => 'style.css',
			);
		}

		public function home() {
			$this->load->helper('url');
			$this->load->view('header');
			$this->load->view('header2');
			$this->load->view('usernav');
			$this->load->view('home_view');
			$this->load->view('footer');
		}

		public function accounts() {
			$this->load->model('subsuperuser_db');
	
			$data['query'] = $this->subsuperuser_db->getaccountdetails();

			$this->load->helper('url');
			$this->load->view('header');
			$this->load->view('header2');
			$this->load->view('usernav');
			$this->load->view('accounts_view', $data);
			$this->load->view('footer');
		}

		public function addaccount() {
			$this->load->helper('url');
			$this->load->view('header');
			$this->load->view('header2');
			$this->load->view('usernav');
			$this->load->view('add_account_view');
			$this->load->view('footer');
		}

		public function home2 () {
			$this->load->helper('url');
			$this->load->view('header');
			$this->load->view('header2');
			$this->load->view('usernav');
			$this->load->view('success');
			$this->load->model('subsuperuser_db');
			$this->subsuperuser_db->addaccount();
			$this->load->view('home_view');
			$this->load->view('footer');
		}

		public function home_($id) {
			$this->load->helper('url');
			$this->load->model('subsuperuser_db');
			$this->subsuperuser_db->deleteaccount($id);

			$this->load->helper('url');
			$this->load->view('header');
			$this->load->view('header2');
			$this->load->view('usernav');
			$this->load->view('success2');
			$this->load->view('home_view');
			$this->load->view('footer');			
		}

		public function deactivateaccount($id) {
			$this->load->helper('url');
			$this->load->model('subsuperuser_db');
			$this->subsuperuser_db->deactivateaccount($id);
			
			

			$this->load->helper('url');
			$this->load->view('header');
			$this->load->view('header2');
			$this->load->view('usernav');
			$this->load->view('success3');
			
			$this->load->view('home_view');
			$this->load->view('footer');

			
		}
	}
?>