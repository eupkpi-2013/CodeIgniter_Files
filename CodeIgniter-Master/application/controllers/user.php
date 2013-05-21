<?php 

class User extends CI_Controller {

	
	public function view($page)
	{
	
		//if( !file_exists('application/views/kpi/'.$page.'.php'))
		//{
			//$this->load->helper('url');
			//echo site_url();
			//show_404();
		//}
		
		//$data['title'] = ucfirst($page);
		
		$user = strtok($page, "_");
	
			$this->load->view('kpi/header');
			$this->load->view('kpi/banner');
			$this->load->view('kpi/navbar_'.$user);
			$this->load->view('kpi/'.$page);
			$this->load->view('kpi/footer');
	
	}
	
	public function viewmetric($page='user_rate')
	{
			$user = strtok($page, "_");
	
			$this->load->view('kpi/header');
			$this->load->view('kpi/banner');
			$this->load->view('kpi/navbar_'.$user);
			$this->load->view('kpi/viewmetric');
			$this->load->view('kpi/footer');
	}
	
		public function verifyuser($page='auditor_verify')
	{
			$user = strtok($page, "_");
	
			$this->load->view('kpi/header');
			$this->load->view('kpi/banner');
			$this->load->view('kpi/navbar_'.$user);
			$this->load->view('kpi/verifyuser');
			$this->load->view('kpi/footer');
	}
	
	
}

?>