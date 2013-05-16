<?php 

class User extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_db');
	}
	
	public function view($page)
	{
	
		//if( !file_exists('application/views/kpi/'.$page.'.php'))
		//{
			//$this->load->helper('url');
			//echo site_url();
			//show_404();
		//}
		
		//$data['title'] = ucfirst($page);
		
		$iscu_id = 1001;
		
		$data['kpi'] = $this->user_db->sidebar();
		$data['subkpi'] = $this->user_db->subsidebar();
		$data['update'] = $this->user_db->updates($iscu_id);
		$data['checker'] = "empty";
		
		$user = strtok($page, "_");
	
			$this->load->view('kpi/header');
			$this->load->view('kpi/banner');
			$this->load->view('kpi/navbar_'.$user);
			$this->load->view('kpi/'.$page,$data);
			$this->load->view('kpi/footer');

	}
	
	public function viewmetric()
	{
		$q = $_GET['q'];
		$iscu_id = 1001;
		$identifier = "verified";
		
		$data['kpi'] = $this->user_db->sidebar();
		$data['subkpi'] = $this->user_db->subsidebar();
		$data['period'] = $this->user_db->period_value();
		$data['metric_values'] = $this->user_db->allmetric($iscu_id, $identifier);
		$data['metric'] = $this->user_db->query_metric($q);
		$data['checker'] = "notempty";
		
			$this->load->view('kpi/header');
			$this->load->view('kpi/banner');
			$this->load->view('kpi/navbar_user');
			$this->load->view('kpi/user_rate',$data);
			$this->load->view('kpi/footer');

	}
	
	public function viewuser()
	{
			$page='auditor_verify';
			$user = strtok($page, "_");
			
			$iscu_id = 1001;
			
			$data['userid'] = $this->user_db->sidebar_verify($iscu_id);
			$data['checker'] = "empty";
			
			$this->load->view('kpi/header');
			$this->load->view('kpi/banner');
			$this->load->view('kpi/navbar_'.$user);
			$this->load->view('kpi/'.$page,$data);
			$this->load->view('kpi/footer');
	}
	
	public function viewaccountid()
	{
		$q = $_GET['q'];
		$iscu_id = 1001;
		$identifier = "submitted";
		
		$trash = strtok($q, "_");
		$trash = strtok("_");
		$user_id = strtok("_");
		
		$page='auditor_verify';
		$user = strtok($page, "_");
		
		$data['kpi'] = $this->user_db->sidebar();
		$data['subkpi'] = $this->user_db->subsidebar();
		$data['userid'] = $this->user_db->sidebar_verify($iscu_id);
		$data['metric'] = $this->user_db->allmetric($iscu_id, $identifier);
		$data['verifyvalue'] = $this->user_db->verify_value($user_id);
		$data['user_id'] = $user_id;
		$data['checker'] = "notempty";
		
		$this->load->view('kpi/header');
		$this->load->view('kpi/banner');
		$this->load->view('kpi/navbar_'.$user);
		$this->load->view('kpi/'.$page,$data);
		$this->load->view('kpi/footer');
	}
	
}

?>