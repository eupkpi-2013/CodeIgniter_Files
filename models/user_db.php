<?php

	Class User_db extends CI_Model {
	
		public function __construct()
		{
			parent::__construct();
			$config['hostname'] = "localhost";
			$config['username'] = "root";
			$config['password'] = "root";
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
		
		public function query_metric($current_subkpi)
		{
			$query = $this->db->get_where('kpi', array('kpi_name'=> $current_subkpi));
			$query_item = $query->row_array();
		
			$query = $this->db->get_where('fields', array('kpi_id'=> $query_item['kpi_id']));
			return $query->result_array();
		}
		
		/* public function sidebar_verify() jasper's file
		{
				$query = $this->db->get_where('field_values', array('tag'=> 'unverified'));
				return $query->result_array();
		} */
		
		public function sidebar_verify($iscu_id) //ren's file
		{
			$this->db->query("drop view IF EXISTS all_users");
			$this->db->query("create view all_users as SELECT users.user_id,tag,account_id iscu_id from field_values,users WHERE
							  field_values.tag='submitted' AND field_values.user_id=users.user_id AND users.iscu_id=$iscu_id AND 
							  users.account_id=5");
			$query = $this->db->query("SELECT DISTINCT user_id FROM all_users");
			$this->db->query("drop view all_users");
			return $query->result_array();
		}

		/* public function verify_value($q) jasper's file
		{
			$trash = strtok($q ,"_");
			$trash = strtok("_");
			$userid = strtok("_");
			
			
			$query = $this->db->get_where('field_values', array('user_id'=> $userid));
			return $query->result_array();
		} */
		
		public function verify_value($user_id) //ren's file
		{
			$query = $this->db->get_where('field_values', array('user_id'=> $user_id));
			return $query->result_array();
		}
		
/* 		public function allmetric() jasper's file
		{
			$query = $this->db->order_by('field_id', 'asc')->get('fields');
			return $query->result_array();
		} */
		
		public function allmetric($iscu_id, $identifier) // ren
		{
			$this->db->query("drop view IF EXISTS all_results");
			$this->db->query("create view all_results as SELECT kpi_id,tag,fields.field_id,value,iscu_id,field_values.user_id,field_name from field_values,users,fields WHERE
			                  field_values.field_id=fields.field_id AND field_values.user_id=users.user_id AND users.iscu_id=$iscu_id AND field_values.tag='$identifier'");	
			$query = $this->db->get('all_results');
			$this->db->query("drop view all_results");
			return $query->result_array();
		}
		
		/* public function updates($iscu_id) jasper
		{
			$query = $this->db->get_where('iscu_updates', array('iscu_id'=> $iscu_id));
			return $query->result_array();
		} */
		
		public function updates($iscu_id) //ren
		{
			$this->db->query("drop view IF EXISTS all_updates");
			$this->db->query("create view all_updates as SELECT * from iscu_updates,updates WHERE
			                  iscu_updates.updates_id=updates.update_id");			
			$query = $this->db->get_where('all_updates', array('iscu_id'=> $iscu_id));
			$this->db->query("drop view all_updates");
			return $query->result_array();
		}
		
		public function add_user()
		{
			$value = $this->input->post('iscu');
			//if add user from superuser module, add account
			if ($value!='') {
				$data=array(
						$this->input->post('gmail'),
						$this->input->post('fname'),
						$this->input->post('lname'),
						$this->db->query('select iscu_id from iscu where iscu="'.$this->input->post('iscu').'"')->result()[0]->iscu_id,
						$this->db->query('select account_id from accounts where account_name="'.$this->input->post('account_name').'"')->result()[0]->account_id,
						$this->db->query('select status_id from user_status where status_name="Active"')->result()[0]->status_id
						);
				$sql = "insert into users (email, fname, lname, iscu_id, account_id, status_id) values (?, ?, ?, ?, ?, ?) on duplicate key update email=?, fname=?, lname=?, iscu_id=?, account_id=?, status_id=?";
				$this->db->query($sql, array_merge($data, $data));
			}
			//else add user from signup
			else {
				$data=array(
						$this->input->post('gmail'),
						$this->input->post('fname'),
						$this->input->post('lname'),
						$this->db->query('select status_id from user_status where status_name="To confirm"')->result()[0]->status_id
						);
				$sql = "insert into users (email, fname, lname, status_id) values (?, ?, ?, ?)";
				$this->db->query($sql, $data);
			}
		}
		
		public function get_accounts($where=NULL) {
			$this->db->select('user_id, fname, lname, email, iscu_id, account_id, status_id');
			if (!isset($where)) $this->db->where_not_in('status_id', array(2));
			else $this->db->where('user_id', $where);
			$result = $this->db->get('users');
			foreach ($result->result() as $result_item) {
				//$this->db->select('iscu');
				$id = $this->db->get_where('iscu', array('iscu_id'=>$result_item->iscu_id))->result();
				$result_item->iscu_id = (isset($id[0])== true ? $id[0]->iscu : '');
				
				//$this->db->select('account_name');
				$id = $this->db->get_where('accounts', array('account_id'=>$result_item->account_id))->result();
				$result_item->account_id = (isset($id[0]) ? $id[0]->account_name: '');
				
				//$this->db->select('status_name');
				$id = $this->db->get_where('user_status', array('status_id'=>$result_item->status_id))->result();
				$result_item->status_id = (isset($id[0]) ? $id[0]->status_name: '');
			}
			return $result;
		}
		
		public function gen_query($select='', $from='', $where='') {
			if ($select != '') $select = 'select '.$select;
			if ($from != '') $from = ' from '.$from;
			if ($where != '') $where = ' where '.$where;
			return $this->db->query($select.$from.$where);
		}
		
		public function submitRates() {
			$sql = "UPDATE field_values SET tag ='submitted' WHERE user_id = 1 AND tag = 'unverified'";
			$this->db->query($sql);
		}
		
		public function delete($user_id) {
			try {
				$this->db->update('users', array('status_id'=>2), array('user_id'=>$user_id));
			} catch (Exception $e) {
				echo var_dump($e);
			}
		}
		
		public function period_value()
		{
			$query = $this->db->get('results');
			return $query->result_array();
		}
	}
?>