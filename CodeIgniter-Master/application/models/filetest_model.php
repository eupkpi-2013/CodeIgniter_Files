<?php
class filetest_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$another_db_settings['hostname'] = 'localhost';
		$another_db_settings['username'] = 'root';
		$another_db_settings['password'] = 'lrmds';
		$another_db_settings['database'] = 'kpitest';
		$another_db_settings['dbdriver'] = "mysql";
		$another_db_settings['dbprefix'] = "";
		$another_db_settings['pconnect'] = TRUE;
		$another_db_settings['db_debug'] = TRUE;
		$another_db_settings['cache_on'] = FALSE;
		$another_db_settings['cachedir'] = "";
		$another_db_settings['char_set'] = "utf8";
		$another_db_settings['dbcollat'] = "utf8_general_ci";
		$this->load->database($another_db_settings);

		// $this->load->model('Model_name', '', $config);
		// $this->load->database();
	}
	
	public function get_all(){
		$query = $this->db->get('data');
		return $query->result_array();
	}
	
	public function get_kpis(){
		$query = $this->db->get('kpi');
		return $query->result_array();
	}
	
	
}