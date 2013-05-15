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
		
		public function query_metric($current_subkpi)
		{
			$query = $this->db->get_where('kpi', array('kpi_name'=> $current_subkpi));
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
			
			
			$query = $this->db->get_where('field_values', array('user_id'=> $userid, 'active'=> 1));
			return $query->result_array();
		}
		
		public function allmetric()
		{
			$query = $this->db->order_by('field_id', 'asc')->get('fields');
			return $query->result_array();
		}
		
		public function updates($iscu_id)
		{
			$query = $this->db->get_where('iscu_updates', array('iscu_id'=> $iscu_id));
			return $query->result_array();
		}
		
		public function add_user()
		{
			$data=array(
			'email'=>$this->input->post('gmail'),
			'fname'=>$this->input->post('fname'),
			'lname'=>$this->input->post('lname'),
			'status_id'=>$this->db->query('select status_id from user_status where status_name="To confirm"')->result()[0]->status_id
			);
			$this->db->insert('users',$data);
		}
		
		public function get_accounts() {
			$this->db->select('fname, lname, email, iscu_id, account_id, status_id');
			
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
	}
?>