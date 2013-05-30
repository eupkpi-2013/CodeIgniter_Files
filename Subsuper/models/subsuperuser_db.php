<?php
	
	Class Subsuperuser_db extends CI_Model {

		public function __construct(){
			parent::__construct();
			$this->load->database();
		}

		public function addaccount() {
			$fname = $this->input->post("fname");
			$lname = $this->input->post("lname");
			$email = $this->input->post("email");
			$account_id = $this->input->post("position");

			$this->db->query("INSERT INTO users(account_id, email, fname, lname, status_id) VALUES ('$account_id', '$email', '$fname', '$lname', 1)");			
		}

		public function deleteaccount($id){
			$this->load->database();
			$this->db->query('DELETE FROM users WHERE user_id='.$id);
		}

		public function getaccountdetails(){
			$this->db->select('*');
			$this->db->from('users');
			$this->db->order_by('user_id', 'asc');
			$query = $this->db->get();
			return $query->result();
		}

		public function getthisaccount($id) {
			$query = $this->db->query('SELECT * FROM users WHERE user_id = '.$id);
			return $query->result();
		}

		public function deactivateaccount($id){
			$this->load->database();
			$this->db->query('UPDATE users SET status_id = 2 WHERE user_id = '.$id. ' AND status_id = 1');
		}

		public function editaccount($data, $id) {
		$this->load->database();
		$this->db->query('UPDATE users
						 SET
						 account_id = "'.$data['account_id'].'",
						 email = "'.$data['email'].'",
						 fname = "'.$data['fname'].'",
						 lname = "'.$data['lname'].'",
						 status_id = "'.$data['status_id'].'"
						 WHERE user_id='.$id);
		}
	}
?>