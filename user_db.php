<?php

	Class User_db extends CI_Model {
	
		public function __construct()
		{
			parent::__construct();
			$config['hostname'] = "localhost";
			$config['username'] = "root";
			$config['password'] = "";
			$config['database'] = "testkpi";
			$config['dbdriver'] = "mysql";
			$config['dbprefix'] = "";
			$config['pconnect'] = FALSE;
			$config['db_debug'] = TRUE;
			
			$this->load->database($config);
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
		
		public function sidebar_verify($iscu_id)
		{
				$this->db->query("drop view IF EXISTS all_users");
				$this->db->query("create view all_users as SELECT users.user_id,tag,account_id iscu_id from field_values,users WHERE
			                      field_values.tag='submitted' AND field_values.user_id=users.user_id AND users.iscu_id=$iscu_id AND 
							      users.account_id=5");
				$query = $this->db->query("SELECT DISTINCT user_id FROM all_users");
				$this->db->query("drop view all_users");
				return $query->result_array();
		}
		
		public function verify_value($user_id)
		{
			$query = $this->db->get_where('field_values', array('user_id'=> $user_id));
			return $query->result_array();
		}
		
		public function allmetric($iscu_id, $identifier)
		{
			
			$this->db->query("drop view IF EXISTS all_results");
			$this->db->query("create view all_results as SELECT kpi_id,tag,fields.field_id,value,iscu_id,field_values.user_id,field_name from field_values,users,fields WHERE
			                  field_values.field_id=fields.field_id AND field_values.user_id=users.user_id AND users.iscu_id=$iscu_id AND field_values.tag='$identifier'");	
			$query = $this->db->get('all_results');
			$this->db->query("drop view all_results");
			return $query->result_array();
			
		}
		
		public function updates($iscu_id)
		{
			$this->db->query("drop view IF EXISTS all_updates");
			$this->db->query("create view all_updates as SELECT * from iscu_updates,updates WHERE
			                  iscu_updates.updates_id=updates.update_id");			
			$query = $this->db->get_where('all_updates', array('iscu_id'=> $iscu_id));
			$this->db->query("drop view all_updates");
			return $query->result_array();
		}
	
		public function period_value()
		{
			$query = $this->db->get('results');
			return $query->result_array();
		}
		
		
	}
?>