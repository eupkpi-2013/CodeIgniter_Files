<?php
	Class AddRateModel extends CI_Model {
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
		}
		
		public function adduserrate() {
				foreach(array_combine($_POST['metric_item'],$_POST['id']) as $value => $id){
				$this->db->query("INSERT INTO field_values(field_id, value, user_id) VALUES ('$id','$value', 1)");
				}
			}
		}
	
		?>