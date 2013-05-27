<?php
	Class AddRateModel extends CI_Model {
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
		}
		
		// public function adduserrate() {
				// foreach(array_combine($_POST['metric_item'],$_POST['id']) as $value => $id){
				// $this->db->query("INSERT INTO field_values(field_id, value, user_id, tag, results_id) VALUES ('$id','$value', 1, 'unverified', 1)");
				// }
			// }
		
		public function adduserrate($field_id, $value, $user_id, $results_id){
			$added = true;
			if($value==""){
				$sql = "DELETE FROM `field_values`
						WHERE field_id=".$field_id." AND user_id=".$user_id." AND results_id=".$results_id;
				$query = $this->db->query($sql);
			}
			else{
				$sql = "SELECT *
						FROM field_values
						WHERE field_id=".$field_id." AND user_id=".$user_id." AND results_id=".$results_id;
				$query = $this->db->query($sql);
				$result = $query->row_array();
				if(!$result){
					$sql = "INSERT INTO field_values (field_id, value, user_id, value_status_id, results_id)
							VALUES (".$field_id.",".$value.",".$user_id.",1,".$results_id.")";
					$this->db->query($sql);
				}
				else if($result['value'] != $value){
					$sql = "UPDATE field_values
							SET value=".$value."
							WHERE value_id=".$result['value_id'];
					$query = $this->db->query($sql);
				}
				else{
					$added = false;
				}
			}
			return $added;
		}
		
		public function getrating($field_id, $user_id, $results_id){
			$sql = "SELECT *
					FROM field_values
					WHERE field_id=".$field_id." AND user_id=".$user_id." AND results_id=".$results_id;
			$query = $this->db->query($sql);
			return $query->row_array();
		}
		
		public function getallratings($user_id, $results_id){
			$sql = "SELECT fields.field_name, fields.kpi_id, field_values.value
					FROM field_values, fields
					WHERE user_id=".$user_id." AND results_id=".$results_id." AND field_values.field_id=fields.field_id";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
	
	}
		?>