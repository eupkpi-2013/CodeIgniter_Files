<?php

	Class updates_model extends CI_Model {
	
		public function __construct()
		{
			parent::__construct();
			// $config['hostname'] = "localhost";
			// $config['username'] = "root";
			// $config['password'] = "lrmds";
			// $config['database'] = "testkpi2";
			// $config['dbdriver'] = "mysql";
			// $config['dbprefix'] = "";
			// $config['pconnect'] = FALSE;
			// $config['db_debug'] = TRUE;
			
			$this->load->database();
		}
		
		public function get_updates($user_id, $iscu_id, $account_id){
			$sql = "SELECT updates.*
					FROM updates
					JOIN iscu_updates
					ON iscu_updates.updates_id = updates.update_id
					WHERE iscu_updates.iscu_id=".$iscu_id."
					AND iscu_updates.account_id=".$account_id."
					ORDER BY timestamp DESC";
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function find_update($value){
			$sql = "SELECT *
					FROM updates
					WHERE update_value LIKE '".$value."'
					ORDER BY update_id DESC;";
			echo $sql;
			$query = $this->db->query($sql);
			return $query->result_array();
		}
		
		public function add_update($value, $user_id){
			$sql = "INSERT INTO updates (update_value, user_id)
					VALUES (".$value.", ".$user_id.")";
			echo $sql;
			$this->db->query($sql);
			return $this->db->insert_id();
		}
		
		public function update_update($update_id, $value, $user_id=""){
			if($user_id==""){
				$sql = "UPDATE updates
						SET update_value='".$value."', timestamp=CURRENT_TIMESTAMP
						WHERE update_id=".$update_id;
			}
			else{
				$sql = "UPDATE updates
						SET update_value='".$value."', timestamp=CURRENT_TIMESTAMP, user_id=".$user_id."
						WHERE update_id=".$update_id;
			}
			echo $sql;
			$this->db->query($sql);
			return $this->db->insert_id();
		}
		
		public function add_update_iscu_account($update_id, $iscu_id, $account_id){
			if($update_id != null){
				$sql = "INSERT INTO iscu_updates (updates_id, iscu_id, account_id)
						VALUES (".$update_id.", ".$iscu_id.", ".$account_id.")";
				$this->db->query($sql);
			}
		}
		
		public function get_active_result(){
			$sql = "SELECT *
					FROM results
					WHERE active=1";
			$query = $this->db->query($sql);
			return $query->row_array();
		}
		
		public function update_to_all($update_id){
			$query = $this->db->get('iscu');
			$iscus = $query->result_array();
			$query = $this->db->get('accounts');
			$accounts = $query->result_array();
			foreach($iscus as $iscu){
				foreach($accounts as $account){
					$this->add_update_iscu_account($update_id, $iscu['iscu_id'], $account['account_id']);
				}		
			}
		}
	}
?>