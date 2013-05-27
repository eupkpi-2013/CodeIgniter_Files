<?php

	Class home_ extends CI_Controller (){

		public function __construct() {
			parent::__construct();

			$this->data['styles'] = array(
				1 => 'style.css',
			);
		}

		public function deleteaccount($id) {
			//$this->load->helper('url');
			$this->load->model('subsuperuser_db');
			$this->subsuperuser_db->deleteaccount($id);
		}
	}
?>