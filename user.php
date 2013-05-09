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
		
		$data['kpi'] = $this->user_db->sidebar();
		$data['subkpi'] = $this->user_db->subsidebar();
		$data['metric'] = array("<h2>eUP KPI: After 2 months</h2>","<p>Choose a KPI on the left.</p><br>","<button>View your previous ratings</button>");
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
		$data['kpi'] = $this->user_db->sidebar();
		$data['subkpi'] = $this->user_db->subsidebar();
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
			
			$data['userid'] = $this->user_db->sidebar_verify();
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
		
		$page='auditor_verify';
		$user = strtok($page, "_");
		
		$data['userid'] = $this->user_db->sidebar_verify();
		$data['verifyvalue'] = $this->user_db->verify_value($q);
		$data['checker'] = "notempty";
		
		$this->load->view('kpi/header');
		$this->load->view('kpi/banner');
		$this->load->view('kpi/navbar_'.$user);
		$this->load->view('kpi/'.$page,$data);
		$this->load->view('kpi/footer');
	}
	
}

?>