<?php 

class update extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('updates_model');	
		$this->load->model('user_db');	
	}
	
	public function new_active_result(){
		$result = $this->updates_model->get_active_result();
		$val = "New Result Opened: ".$result['results_name'].".";
		$update_id = $this->updates_model->add_update($val);
		$this->update_to_all($update_id);
		$val = $val."You may now start rating.";
	}
	
	public function answered_rating($user_id){
		$result = $this->updates_model->get_active_result();
		$answered = $this->user_db->get_answered_fields($user_id, $result['results_id']);
		$fields = $this->user_db->get_all_active_fields();
		if(count($answered) == count($fields)){
			$val = "hellloooo";
		}
		else{
			$val = "hiii";
		}
		$update_id = $this->updates_model->add_update($val);
		$this->update_to_all($update_id);
	}
	
	public function update_to_all($update_id){
		$iscus = $this->user_db->get_all_iscus();
		$accounts = $this->user_db->get_all_accounts();
		foreach($iscus as $iscu){
			foreach($accounts as $account){
				$this->updates_model->add_update_iscu_account($update_id, $iscu['iscu_id'], $account['account_id']);
			}		
		}
	}
}

?>