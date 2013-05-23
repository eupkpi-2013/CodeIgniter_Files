<?php

class Model_role extends CI_Model {

	public function scalar($user,$role){

		$this->db->where('email',$this->input->post('email'));
		$this->db->select($role); #Because I need the value
		//$this->db->field_data($role);
		// $this->db->where($where); #Because I need the variable column entitled siteoverview
		$query = $this->db->get($user); #From the settings table
		$row = $query->row_array(); // get the row
		return $row['role']; // return the value
	} 
}

?>