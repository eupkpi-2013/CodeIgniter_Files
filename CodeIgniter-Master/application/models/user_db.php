<?php

	Class User_db extends CI_Model {
	
		public function __construct()
		{
			parent::__construct();
			$config['hostname'] = "localhost";
			$config['username'] = "root";
			$config['password'] = "lrmds";
			$config['database'] = "testkpi2";
			$config['dbdriver'] = "mysql";
			$config['dbprefix'] = "";
			$config['pconnect'] = FALSE;
			$config['db_debug'] = TRUE;
			
			$this->load->database();
		}
		
		public function sidebar()
		{
			$query = $this->db->get_where('kpi', array('leaf_node'=> 0, 'active' => true));
			return $query->result_array();
		}
		
		public function subsidebar()
		{
			$query = $this->db->get_where('kpi', array('leaf_node'=> 1, 'active' => true));
			return $query->result_array();
		}
		
		public function query_metric($current_subkpi)
		{
			$query = $this->db->get_where('kpi', array('kpi_name'=> $current_subkpi));
			$query_item = $query->row_array();
			
			$query = $this->db->get_where('fields', array('kpi_id'=> $query_item['kpi_id'], 'active' => true));
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
			$this->db->query("create view all_results as SELECT kpi_id,results_id,tag,fields.field_id,value,iscu_id,field_values.user_id,field_name from field_values,users,fields WHERE
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
		
		public function adduserrate() {
			foreach(array_combine($_POST['metric_item'],$_POST['id']) as $value => $id) {
				$this->db->query("INSERT INTO field_values(field_id, value, user_id, tag, results_id) VALUES ('$id','$value', 1, 'unverified', 1)");
			}
		}
		
		
		public function submitRates() {
			// $sql = "UPDATE field_values SET tag ='submitted' WHERE user_id = 1 AND tag = 'unverified'";
			$sql = "UPDATE field_values SET value_status_id =2 WHERE user_id = 1 AND results_id=1";
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
		
		function addKPI() {
			$kpi = $this->input->post("kpi_name");
			$radio = $this->input->post("radio");
			
			$this->db->query("INSERT INTO KPI (kpi_name, project_id, leaf_node) VALUES ('$kpi', '1', '0')");
		}
		
		function addSubKPI() {
			$subkpi = $this->input->post("subkpi_name");
			$id = $this->input->post("id");
			
			$this->db->query("INSERT INTO KPI (kpi_name, parent_kpi, leaf_node, project_id) VALUES ('$subkpi', '$id', '1', '1')");
		}
		
		function addMetric() {
			$id = $this->input->post("id");

			$metricCount = 0;
			
			while(isset($_POST["metric_name".$metricCount])){
				$metric = $this->input->post("metric_name".$metricCount);
				/* if (!empty($metric)) */ $this->db->query("INSERT INTO fields (kpi_id, field_name, type, active) VALUES ('$id', '$metric', 'int', '0')");        
				$metricCount++;
			}

			$query = $this->db->query("SELECT parent_kpi FROM KPI WHERE kpi_id='$id'");
			$query = $query->result_array();
			return $query[0];
		}
		
		public function getKpiId($kpi_name){
			$this->load->database();
			
			$query = $this->db->query("SELECT * FROM KPI WHERE kpi_name='$kpi_name'");
			$query = $query->result_array();
			return $query[0];
		}
		
		public function getSubKpiId($subkpi_name){
			$this->load->database();
			
			$query = $this->db->query("SELECT * FROM KPI WHERE kpi_name='$subkpi_name'");
			$query = $query->result_array();
			return $query[0];
		}
		
		public function getMetricId($metric_name) {
			$query = $this->db->query("SELECT * FROM KPI WHERE kpi_name='$metric_name'");
			$query = $query->result_array();
			return $query[0]; 
		}
		
		public function find_id($find)
		{
			$query = $this->db->get_where('kpi', array('kpi_name'=> $find));
			return $query->row_array();
		}
		
		public function change_value() {
			/* echo '<pre>'; /* print_r($this->input->post(NULL, true));  
			$asdf = $this->input->post('metric_name');
			print_r($asdf);
			if (empty($asdf)) echo 'empty';
			else echo 'asdf';
			echo '</pre>';
			
			foreach ($asdf as $item):
				echo (empty($item) ? 'empty item' : 'not empty item');
				echo $item;
			endforeach; */
			
			$kpi_value = $this->input->post('kpi');
			$kpi_id = $this->input->post('kpi_id');
			$this->db->query("UPDATE kpi SET kpi_name='$kpi_value' WHERE kpi_id=$kpi_id");
			
			$subkpi_value = $this->input->post('subkpi');
			$subkpi_id = $this->input->post('subkpi_id');
			$this->db->query("UPDATE kpi SET kpi_name='$subkpi_value' WHERE kpi_id=$subkpi_id");
			
			foreach(array_combine($this->input->post('metric'),$this->input->post('metric_id')) as $field_name => $field_id):
				$this->db->query("UPDATE fields SET field_name='$field_name' WHERE field_id=$field_id");
			endforeach;
			
			$new_metric = $this->input->post('metric_name');
			$type = 'int'; // IMPORTANT, FIX !!!
			if ( !empty($new_metric) ) {
				foreach ($new_metric as $new_metric_item):
					if ( !empty($new_metric_item) )
						echo ($this->db->query("insert into fields (field_name, kpi_id, type, active) values ('$new_metric_item', $subkpi_id, '$type', false)") ? 'yay' : 'nay');
				endforeach;
			}
			
			$kpi_value = str_replace(" ", "_", $kpi_value);
			$subkpi_value = str_replace(" ", "_", $subkpi_value);
			
			return "editvalue?q=".$kpi_value."/".$subkpi_value;
		}
		
		public function deactivate_1($id)
		{
			$this->db->query("UPDATE kpi SET active=0 WHERE kpi_id=$id");

			$query = $this->db->get_where('kpi', array('parent_kpi'=> $id));
			foreach ($query->result_array() as $query_item):
				$temp_id = $query_item['kpi_id'];
				$this->deactivate_2($temp_id);
			endforeach;
		}

		public function deactivate_2($id)
		{
			$this->db->query("UPDATE kpi SET active=0 WHERE kpi_id=$id");

			$query = $this->db->get_where('fields', array('kpi_id'=> $id));
			foreach ($query->result_array() as $query_item):
				$temp_id = $query_item['field_id'];
				$this->deactivate_3($temp_id);
			endforeach;
		}

		public function deactivate_3($id)
		{
			$this->db->query("UPDATE fields SET active=0 WHERE field_id=$id");
		}
		
		public function get_inactive() {
			$this->db->query("drop view if exists active_fields");
			if ($this->db->query("create view active_fields as select iscu_field.field_id, fields.field_name, fields.kpi_id from fields, iscu_field, kpi where fields.field_id = iscu_field.field_id AND fields.kpi_id = kpi.kpi_id AND fields.active = 0")) {
				$return = $this->db->query("select * from active_fields group by field_id");
				$return1 = $this->db->query("select kpi_id, kpi_name from kpi where kpi_id in (select distinct(parent_kpi) from kpi where kpi_id in (select distinct(kpi_id) from active_fields)) order by kpi_id");
				$return2 = $this->db->query("select kpi_id, kpi_name, parent_kpi from kpi where kpi_id in (select distinct(kpi_id) from active_fields) order by kpi_id");
			}
			$this->db->query("drop view if exists active_fields");
			return array($return, $return1, $return2);
		}
	}
?>