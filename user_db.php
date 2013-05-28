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
		
		public function sidebar($active=false)
		{
			$where = ($active ? array('leaf_node'=>0) : array('leaf_node'=>0, 'active'=>true));
			$query = $this->db->get_where('kpi', $where);
			return $query->result_array();
		}
		
		public function subsidebar($active=false)
		{
			$where = ($active ? array('leaf_node'=>1) : array('leaf_node'=>1, 'active'=>true));
			$query = $this->db->get_where('kpi', $where);
			return $query->result_array();
		}
		
		public function query_metric($current_subkpi, $active='false')
		{
			$query = $this->db->get_where('kpi', array('kpi_name'=> $current_subkpi));
			$query_item = $query->row_array();
			$where = ($active ? array('kpi_id'=> $query_item['kpi_id']) : array('kpi_id'=> $query_item['kpi_id'], 'active' => true));
			$query = $this->db->get_where('fields', $where);
			return $query->result_array();
		}
		
		public function query_submetric($current_metric)
		{
			$query = $this->db->get_where('breakdown', array('field_id'=>$current_metric));
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
			$this->db->query("create view all_users as SELECT users.user_id,account_id,iscu_id from field_values,users WHERE
							  field_values.value_status_id='2' AND field_values.user_id=users.user_id AND users.iscu_id=$iscu_id AND 
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
		
 		public function allmetric1()
		{
			$this->db->select('field_id, kpi_id, field_name, has_breakdown');
			$query = $this->db->order_by('field_id', 'asc')->get_where('fields', array('active'=>1));
			return $query->result_array();
		}
		
		public function allmetric($iscu_id, $identifier) // ren
		{
			$this->db->query("drop view IF EXISTS all_results");
			$this->db->query("create view all_results as SELECT kpi_id,results_id,fields.field_id,value,iscu_id,field_values.user_id,field_name from field_values,users,fields WHERE
			                  field_values.field_id=fields.field_id AND field_values.user_id=users.user_id AND users.iscu_id=$iscu_id AND field_values.value_status_id=(select value_status_id from value_status where value_status_name='$identifier')");	
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
		
		/* public function adduserrate() {
			foreach(array_combine($_POST['metric_item'],$_POST['id']) as $value => $id) {
				$this->db->query("INSERT INTO field_values(field_id, value, user_id, tag, results_id) VALUES ('$id','$value', 1, 'unverified', 1)");
			}
		} */
		
		public function submitRates($user_id, $results_id) {
			// $sql = "UPDATE field_values SET tag ='submitted' WHERE user_id = 1 AND tag = 'unverified'";
			$sql = "UPDATE field_values SET value_status_id =2 WHERE user_id = $user_id AND results_id=$results_id";
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
			$metric = $this->input->post("metric_name");
			
			$this->db->query("insert into fields (kpi_id, field_name, type, active) values ('$id', '$metric', 'int', '0')");

			$query = $this->db->query("SELECT parent_kpi FROM KPI WHERE kpi_id='$id'");
			$query = $query->result_array();
			return $query[0];
		}
		
		public function addBreakdown() {
			$id = $this->input->post('id');
			
			foreach ( $this->input->post('breakdown_name') as $breakdown_item ):
				echo $breakdown_item;
				$this->db->query("insert into breakdown (breakdown_name, field_id, active) values ('$breakdown_item', '$id' ,'0')");
				$this->db->update("update fields set has_breakdown=1 where field_id=$id");
			endforeach;
			return $this->db->query("select * from fields where field_id=$id")->result_array()[0];
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
			$query = $this->db->query("SELECT * FROM fields WHERE field_name='$metric_name'");
			$query = $query->result_array();
			return $query[0]; 
		}
		
		public function find_id($find)
		{
			$query = $this->db->get_where('kpi', array('kpi_name'=> $find));
			return $query->row_array();
		}
		
		public function change_value() {
			
			$kpi_value = $this->input->post('kpi');
			$kpi_id = $this->input->post('kpi_id');
			$this->db->query("UPDATE kpi SET kpi_name='$kpi_value' WHERE kpi_id=$kpi_id");
			
			$subkpi_value = $this->input->post('subkpi');
			$subkpi_id = $this->input->post('subkpi_id');
			$this->db->query("UPDATE kpi SET kpi_name='$subkpi_value' WHERE kpi_id=$subkpi_id");
			
			if ($this->input->post('metric') && $this->input->post('metric_id')) $holder = array_combine($this->input->post('metric_id'), $this->input->post('metric'));
			else $holder = array();
			
			foreach ($holder as $field_id => $field_name):
				$this->db->query("UPDATE fields SET field_name='$field_name' WHERE field_id=$field_id");
			endforeach; 
			
			$new_metric = $this->input->post('metric_name');
			$type = 'int'; // IMPORTANT, FIX data type implementation!!!
			if ( !empty($new_metric) ) {
				foreach ($new_metric as $new_metric_item):
					if ( !empty($new_metric_item) )
						echo ($this->db->query("insert into fields (field_name, kpi_id, type, active) values ('$new_metric_item', $subkpi_id, '$type', false)") ? 'yay' : 'nay');
				endforeach;
			}
			
			if ( $this->input->post('breakdown') && $this->input->post('breakdown_id') ) $holder = array_combine($this->input->post('breakdown_id'), $this->input->post('breakdown'));
			else $holder = array();
			
			foreach ($holder as $breakdown_id => $breakdown_name):
				$this->db->query("update breakdown set breakdown_name='$breakdown_name' where breakdown_id=$breakdown_id");
			endforeach;
			
			foreach ($this->input->post('metric_id') as $metric_id):
				if ($this->input->post('breakdown'.$metric_id.'_name')) {
					foreach ($this->input->post('breakdown'.$metric_id.'_name') as $breakdown_item):
						$this->db->query("insert into breakdown (breakdown_name, field_id, active) values ('$breakdown_item', '$metric_id', '0')");
					endforeach;
					$this->db->query("update fields set has_breakdown = 1 where field_id='$metric_id'");
				}
			endforeach;
			
			
			$kpi_value = str_replace(" ", "_", $kpi_value);
			$subkpi_value = str_replace(" ", "_", $subkpi_value);
			
			return "editvalue?q=".$kpi_value."/".$subkpi_value;
		}
		
		public function deactivate_1($id)
		{
			$current_active = $this->get_active_result();
			if (empty($current_active)) {
				$this->db->query("UPDATE kpi SET active=0 WHERE kpi_id=$id");

				$query = $this->db->get_where('kpi', array('parent_kpi'=> $id));
				foreach ($query->result_array() as $query_item):
					$temp_id = $query_item['kpi_id'];
					$this->deactivate_2($temp_id);
				endforeach;
			}
		}

		public function deactivate_2($id)
		{
			echo '<br> deactivating subkpi <br> $id = '.$id.'<br><br>';
			$current_active = $this->get_active_result();
			if (empty($current_active)) {
				$this->db->query("UPDATE kpi SET active=0 WHERE kpi_id=$id");

				$query = $this->db->get_where('fields', array('kpi_id'=> $id));
				foreach ($query->result_array() as $query_item):
					$temp_id = $query_item['field_id'];
					$this->deactivate_3($temp_id);
				endforeach;
				$query = $this->db->get_where('kpi', array('kpi_id'=>$id));
				$value = $query->row_array()['parent_kpi'];
				$query = $this->db->get_where('kpi', array('parent_kpi'=>$value, 'active'=>true));
				if (empty($query->num_rows)) deactivate_parent($value, 'kpi');
			}
		}

		public function deactivate_3($id)
		{
			echo '<br> deactivating metric <br> $id = '.$id.'<br><br>';
			$current_active = $this->get_active_result();
			if (empty($current_active)) {
				$this->db->query("UPDATE fields SET active=0 WHERE field_id=$id");
				$query = $this->db->get_where('fields', array('field_id'=>$id));
				
				// wag muna
				// foreach ($query->result_array() as $query_item):
					// if ($query_item['has_breakdown']):
						// $submetric = $this->db->get_where('breakdown', array('field_id'=>$query_item['field_id']));
						// foreach ($submetric->result_array() as $submetric_item):
							// $this->deactivate_4($submetric_item['breakdown_id']);
						// endforeach;
					// endif;
				// endforeach;
				
				$value = $query->result_array()[0]['kpi_id'];
				$query = $this->db->query("select * from fields where kpi_id=$value and active=1");
				if (empty($query->num_rows)) $this->deactivate_parent($value, 'kpi');
			}
		}
		
		public function deactivate_4($id) {
			$current_active = $this->get_active_result();
			if (empty($current_active)) $this->db->query("UPDATE breakdown SET active=0 WHERE breakdown_id=$id");
		}
		
		public function deactivate_parent($value, $table) {
			echo '<br> deactivating parent <br> $value = '.$value.'<br> $table = '.$table.'<br><br>';
			if ($table=='kpi') {
				$this->db->query("update kpi set active=0 where kpi_id=$value");
				$query = $this->db->get_where('kpi', array('kpi_id'=>$value));
				$value = $query->row_array()['parent_kpi'];
				if ($value != 0) {
					$query = $this->db->get_where('kpi', array('parent_kpi'=>$value, 'active'=>1));
					if (empty($query->num_rows)) $this->deactivate_parent($value, 'kpi');
				}
			}
			// wag muna (for breakdown)
			//else $query = $this->db->get_where('fields', array('field_id'=>$value));
		}
		
		public function activate($id, $table) {
			$sql = "update $table set active=1 where ".($table=='fields' ? "field" : "kpi" )."_id=$id";
			echo '<br>'.$sql;
			//$this->db->query($sql);
		}
		
		public function get_inactive() {
			$this->db->query("drop view if exists active_fields");
			if ($this->db->query("create view active_fields as select iscu_field.field_id, fields.field_name, fields.kpi_id, fields.has_breakdown from fields, iscu_field, kpi where fields.field_id = iscu_field.field_id AND fields.kpi_id = kpi.kpi_id AND fields.active = 0")) {
				$return = $this->db->query("select * from active_fields group by field_id");
				$return1 = $this->db->query("select kpi_id, kpi_name from kpi where kpi_id in (select distinct(parent_kpi) from kpi where kpi_id in (select distinct(kpi_id) from active_fields)) order by kpi_id");
				$return2 = $this->db->query("select kpi_id, kpi_name, parent_kpi from kpi where kpi_id in (select distinct(kpi_id) from active_fields) order by kpi_id");
			}
			$this->db->query("drop view if exists active_fields");
			return array($return->result(), $return1->result(), $return2->result());
		}
		
		public function get_inactive_submetric() {
			$query = $this->db->query("select field_id, field_name, kpi_id, has_breakdown from fields where field_id in (select distinct(field_id) from breakdown where active=0)");
			
			$submetric = $this->db->query("select * from breakdown where field_id in (select iscu_field.field_id from iscu_field, fields where iscu_field.field_id = fields.field_id AND fields.has_breakdown = 1)");
			
			return array($query->result(), $submetric->result());
		}
		
		public function iscu_sidebar() {
			$query = $this->db->get_where('iscu', array('project_id'=>1));
			return $query->result_array();
		}
		
		public function assignISCU() {
			$current_active = $this->get_active_result();
			if (empty($current_active)) {
				$kpi = $this->input->post("kpi");
				$subkpi = $this->input->post("subkpi");			
				$metric = $this->input->post("metric");
				
				$iscu = $this->input->post("iscu");
				$query = $this->db->query("SELECT iscu_id FROM iscu WHERE iscu='$iscu'");
				$query = $query->result_array();
				$iscu_id = $query[0]['iscu_id'];
				
				foreach ($metric as $metric_id):
					$this->db->query("INSERT INTO iscu_field (iscu_id, field_id) VALUES ('$iscu_id', '$metric_id')"); 
				endforeach;
			}
		}
		
		public function get_active_result() {
			$result = $this->db->query("select results_id, results_name from results where active='1'");
			return $result->result_array();
		}
		
		public function activate_result() {
			$current_active = $this->get_active_result();
			if (empty($current_active)) {
				$name = $this->input->post('results_name');
				$this->db->query("insert into results (results_name, active, project_id) values ('$name', '1', '1')");
			}
		}
	}
?>