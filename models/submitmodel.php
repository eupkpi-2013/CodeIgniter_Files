<?php
	Class SubmitModel extends CI_Model {
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
		}
		
		
		public function searchMetric() {
			

			$sql = ("SELECT * FROM field_values WHERE user_id = 1 AND tag = 'unverified'");
			$query = $this->db->query($sql);
			$rowArray = array_values($query->row_array());
			return $rowArray;
		}
		
		public function submitRates() {
			$sql = "UPDATE field_values SET tag ='submitted' WHERE user_id = 1 AND tag = 'unverified'");
			$this->db->query($sql);
		}

	}
?>