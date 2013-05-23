<?php
class kpi_generate_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
		// $this->load->database($another_db_settings);

		$this->load->database();
		
		$this->load->library('session');
		$this->session->set_userdata('user', 1);
		$this->session->set_userdata('iscu', 1);
		$this->session->set_userdata('account', 1);
		$this->session->set_userdata('project', 1);
		// echo var_dump($this->session->all_userdata());
		
	}
	
	public function get_parent_kpis(){
		$project_id = $this->session->userdata('project');
		
		$sql = "SELECT * 
				FROM kpi
				WHERE parent_kpi=0
				AND project_id=".$project_id;
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function get_sub_kpis(){
		$project_id = $this->session->userdata('project');
		
		$sql = "SELECT * 
				FROM kpi
				WHERE parent_kpi>0
				AND project_id=".$project_id;
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function get_all_metrics(){
		$user_id = $this->session->userdata('user');
		$iscu_id = $this->session->userdata('iscu');
		$account_id = $this->session->userdata('account');
		$project_id = $this->session->userdata('project');
		
		$sql = "SELECT fields.* 
				FROM fields";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function get_all_results(){
		$query = $this->db->get('results');
		return $query->result_array();
	}
	
	public function get_all_iscus(){
		$query = $this->db->get('iscu');
		return $query->result_array();
	}
	
	public function get_all_accounts(){
		$query = $this->db->get('accounts');
		return $query->result_array();
	}
	
	public function get_field_values($results_id, $field){
		// $query = $this->db->get_where('field_values', array('results_id' => $results_id, "field_id" => 1,2,3));
		$sql = "SELECT * FROM `field_values` 
				WHERE results_id=".$results_id." 
				AND (";
		$counter = 0;
		foreach($field as $field){
			if($counter>0)
				$sql = $sql." OR ";
			$sql = $sql."field_id = ".$field;
			$counter++;
		}
		$sql = $sql.")";
		// echo $sql;
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function get_field_value($results_id, $field_id){
		$sql = "SELECT * FROM `field_values` 
				WHERE results_id=".$results_id." 
				AND field_id=".$field_id;
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	
	public function get_field($field_id)
	{
		$sql = "SELECT * FROM fields WHERE field_id=".$field_id;
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	
	public function get_breadcrumbs($field_id){
		$sql = "SELECT kpi.kpi_id,kpi_name,parent_kpi 
				FROM kpi,fields
				WHERE fields.kpi_id=kpi.kpi_id
				AND fields.field_id=".$field_id;
		$query = $this->db->query($sql);
		$result = $query->row_array();
		$current =  $result['parent_kpi'];
		$breadcrumbs = [];
		while($current){
			array_push($breadcrumbs,$result);
			$sql = "SELECT kpi.kpi_id,kpi_name,parent_kpi 
				FROM kpi
				WHERE kpi_id=".$current;
			$query = $this->db->query($sql);
			$result = $query->row_array();
			$current =  $result['parent_kpi'];
		}
		array_push($breadcrumbs,$result);
		$breadcrumbs = array_reverse($breadcrumbs, true);
		return $breadcrumbs;
	}
	
	public function get_output_types(){
		$query = $this->db->get('output_types');
		return $query->result_array();
	}
	
	public function new_output($name, $desc, $type, $public, $user_id, $project_id){
		$sql = "INSERT INTO `output`(`output_name`, `output_description`, `output_type`, `is_public`, `user_id`, `done`, `project_id`) 
				VALUES ('".$name."','".$desc."',".$type.",".$public.",".$user_id.",0,".$project_id.")";
		$query = $this->db->query($sql);
		return $this->db->insert_id();		
	}
	
	public function new_output_result($results_id, $output_id){
		$sql = "INSERT INTO `output_results`(`output_id`, `results_id`) 
				VALUES (".$output_id.",".$results_id.")";
		$query = $this->db->query($sql);
	}
	
	public function new_file($filename, $output_id){
		$sql = "INSERT INTO `files`(`filename`, `output_id`) 
				VALUES ('".$filename."', ".$output_id.")";
		// echo $sql;
		$query = $this->db->query($sql);
	}
	
	public function new_output_field($field_id, $output_id){
		$sql = "INSERT INTO `output_fields`(`output_id`, `fields_id`) 
				VALUES (".$output_id.",".$field_id.")";
		// echo $sql;
		$query = $this->db->query($sql);
	}
	
	public function new_output_iscu($iscu_id, $output_id){
		$sql = "INSERT INTO `output_iscus`(`output_id`, `iscu_id`) 
				VALUES (".$output_id.",".$iscu_id.")";
		// echo $sql;
		$query = $this->db->query($sql);
	}
	
	public function new_output_account($accounts_id, $output_id){
		$sql = "INSERT INTO `output_accounts`(`output_id`, `accounts_id`) 
				VALUES (".$output_id.",".$accounts_id.")";
		// echo $sql;
		$query = $this->db->query($sql);
	}
	
	public function update_output($output_id, $output_name, $output_desc, $type, $is_public){
		$sql = "UPDATE  output 
				SET  output_name = '".$output_name."', output_description = '".$output_desc."', output_type = ".$type.", is_public = ".$is_public."
				WHERE  output_id = ".$output_id.";";
		$query = $this->db->query($sql);
	}
	
	public function update_output_is_public($output_id, $is_public){
		$sql = "UPDATE output
				SET is_public = ".$is_public."
				WHERE output_id = ".$output_id.";";
		$query = $this->db->query($sql);
	}
	
	public function delete_all_output_iscus($output_id){
		$sql = "DELETE FROM output_iscus WHERE output_id = ".$output_id;
		$query = $this->db->query($sql);	
	}
	
	public function delete_all_output_accounts($output_id){
		$sql = "DELETE FROM output_accounts WHERE output_id = ".$output_id;
		$query = $this->db->query($sql);	
	}
	
	public function delete_all_output_rels($output_id){
		$sql = "DELETE FROM output_fields WHERE output_id = ".$output_id;
		$query = $this->db->query($sql);
		$sql = "DELETE FROM output_accounts WHERE output_id = ".$output_id;
		$query = $this->db->query($sql);
		$sql = "DELETE FROM output_results WHERE output_id = ".$output_id;
		$query = $this->db->query($sql);
		$sql = "DELETE FROM output_iscus WHERE output_id = ".$output_id;
		$query = $this->db->query($sql);	
	}
	
	public function delete_output($output_id){
		$sql = "DELETE FROM output WHERE output_id = ".$output_id;
		$query = $this->db->query($sql);
	}
	
	public function publish($output_id){
		$sql = "UPDATE `output` SET `done`=1,`timestamp`=CURRENT_TIMESTAMP WHERE output_id=".$output_id;
		$query = $this->db->query($sql);
	}
	
	public function get_output($output_id){
		$sql = "SELECT * 
				FROM output 
				WHERE output_id=".$output_id;
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	
	public function get_all_output(){
		$sql = "SELECT * FROM output";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function get_all_done_output($user_id, $account_id, $iscu_id){
		$sql = "SELECT DISTINCT output.*
				FROM output
				LEFT JOIN output_iscus
				ON output.output_id = output_iscus.output_id
				LEFT JOIN output_accounts
				ON output_iscus.output_id = output_accounts.output_id
				WHERE done = 1
				AND (user_id = ".$user_id."
				OR is_public = 1
				OR (output_accounts.accounts_id=".$account_id." 
				AND output_iscus.iscu_id=".$iscu_id."))";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function get_all_not_done_output($user_id){
		$sql = "SELECT * 
				FROM output 
				WHERE done=0 and user_id=".$user_id;
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function get_all_public_output(){
		$sql = "SELECT * 
				FROM output 
				WHERE is_public=1 AND done=1";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function get_output_results($output_id){
		$sql = "SELECT results.results_id, results_name 
				FROM output_results,results 
				WHERE output_id=".$output_id." and output_results.results_id=results.results_id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function get_output_fields($output_id){
		$sql = "SELECT *
				FROM output_fields, fields
				WHERE fields.field_id=output_fields.fields_id
				AND output_fields.output_id=".$output_id;
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function get_output_field_values($output_id, $field_id){
		$sql = "SELECT value
				FROM field_values, output_results
				WHERE field_values.results_id=output_results.results_id
				AND field_id=".$field_id."
				AND output_id=".$output_id;
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function get_output_accounts($output_id){
		$sql = "SELECT *
				FROM output_accounts, accounts
				WHERE output_id=".$output_id." AND accounts.account_id=output_accounts.accounts_id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function get_output_iscus($output_id){
		$sql = "SELECT *
				FROM output_iscus, iscu
				WHERE output_id=".$output_id." AND iscu.iscu_id=output_iscus.iscu_id";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function get_output_user($output_id){
		$sql = "SELECT users.*
				FROM users
				JOIN output
				ON users.user_id = output.user_id
				WHERE output_id=".$output_id;
		$query = $this->db->query($sql);
		return $query->row_array();
	}
	
	public function is_done($output_id){
		$sql = "SELECT done
				FROM output";
		$query = $this->db->query($sql);
		$done = $query->row_array();
		if($done)
			return true;
		else
			return false;
	}
	
	public function check_output_exists($name){
		$sql = "SELECT *
				FROM output
				WHERE done=1 AND output_name='".$name."'";
		$query = $this->db->query($sql);
		$done = $query->result_array();
		if(count($done)>0)
			return true;
		else
			return false;
	}
	
	
}