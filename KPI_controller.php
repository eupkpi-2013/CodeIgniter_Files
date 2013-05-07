<?php
class KPI_Controller extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('KPI_model');
	}
}
