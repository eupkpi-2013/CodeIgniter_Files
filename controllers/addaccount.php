<?php

	Class Addaccount extends CI_Controller {

		public function __construct() {
			parent::__construct();

			$this->data['styles'] = array(
				1 => 'styles.css',
			);
		}

		public function index() {

			$this->load->helper('url');
			$this->load->view('header');
			$this->load->view('header2');
			$this->load->view('usernav');
			$this->load->view('add_account_view');
			$this->load->view('footer');
		}
	}