<?php
class Kpi_Model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	public function sidebar()
		{
			$query = $this->db->get_where('kpi', array('leaf_node'=> 0));
			return $query->result_array();
		}

	public function subsidebar()
	{
		$query = $this->db->get_where('kpi', array('leaf_node'=> 1));
		return $query->result_array();
	}

	public function query_metric($q)
	{
		$kpi = strtok($q, "/");
		$subkpi = strtok("/");

		$kpi = str_replace("_", " ", $kpi);
		$subkpi = str_replace("_", " ", $subkpi);

		$query = $this->db->get_where('kpi', array('kpi_name'=> $subkpi));
		$query_item = $query->row_array();

		$query = $this->db->get_where('fields', array('kpi_id'=> $query_item['kpi_id']));
		return $query->result_array();
	}

	public function sidebar_verify()
	{
			$query = $this->db->get_where('field_values', array('tag'=> 'unverified', 'active'=> 1));
			return $query->result_array();
	}

	public function verify_value($q)
	{
		$trash = strtok($q ,"_");
		$trash = strtok("_");
		$userid = strtok("_");

		$query = $this->db->get_where('field_values', array('user_id'=> $userid));
		return $query->result_array();
	}
}