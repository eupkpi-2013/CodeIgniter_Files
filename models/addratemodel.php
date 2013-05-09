<?php
	Class AddRateModel extends CI_Model {
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
		}
		
		public function adduserrate() {
				$m111 = $this->input->post("m111");
				$m112 = $this->input->post("m112");
				$m113 = $this->input->post("m113");
				$m114 = $this->input->post("m114");
				$this->db->query("INSERT INTO field_values(field_id, value, user_id) VALUES (1 ,'$m111', 1)");
				$this->db->query("INSERT INTO field_values(field_id, value, user_id) VALUES (2 ,'$m112', 1)");
				$this->db->query("INSERT INTO field_values(field_id, value, user_id) VALUES (3 ,'$m113', 1)");
				$this->db->query("INSERT INTO field_values(field_id, value, user_id) VALUES (4 ,'$m114', 1)");
		}
		}