<?php

class Model_users extends CI_Model
{

	public function can_log_in(){

		$this->db->where('email',$this->input->post('email'));
		$this->db->where('password',md5($this->input->post('password')));
		$query = $this->db->get('user');
		//$fields = $this->db->field_data(‘role’);
		if($query->num_rows()==1){ //if it founds a user meaning if it find a valid credential

			//return true;
			return $query;
			//return $fields;

		}
		else
		{
			return false;
		// /return $query;
		}
	}

}// end of can_log_in

 ?>