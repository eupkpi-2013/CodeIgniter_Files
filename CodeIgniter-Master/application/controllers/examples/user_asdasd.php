<?php 

class User extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('user_db');
	}
	
	public function index() {
		if(($this->session->userdata('user_name')!='')) $this->view('user');
		else {
			//$this->load->view('');  header, blah blah blah
		}
	}
	
	public function signup() {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[5]|max_length[16]');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('con_email', 'Email Confirmation', 'trim|required|matches[email]');
		
		if($this->form_validation->run() == FALSE) $this->index();
		else {
			$this->user_model->add_user();
			$this->checkmail();
		}
	}*/
	
	public function view($page)
	{
		
		//end of testing
		
		if( !file_exists('application/views/kpi/'.$page.'.php'))
		{
			$this->load->helper('url');
			show_404();
		}
		//$data['title'] = ucfirst($page);
		
		$user = strtok($page, "_");
		if ($page != 'index') {
			$this->load->view('kpi/header');
			$this->load->view('kpi/banner');
			$this->load->view('kpi/navbar_'.$user);
			$this->load->view('kpi/'.$page);
			$this->load->view('kpi/footer');
		}
		else $this->load->view('kpi/index');
	}
	
	public function auth() {
		require_once 'kpi_sources/openid.php';
		$openid = new LightOpenID("localhost");
		 
		$openid->identity = 'https://www.google.com/accounts/o8/id';
		$openid->required = array(
		  'namePerson/first',
		  'namePerson/last',
		  'contact/email',
		);
		//header('Location: ' . $openid->authUrl());
		$openid->returnUrl = 'http://localhost/ci/index.php/login';
		header('Location: '.$openid->authUrl());
	}
	
	public function login() {
		require_once 'kpi_sources/openid.php';
		$openid = new LightOpenID("localhost");
		 
		if ($openid->mode) {
			if ($openid->mode == 'cancel') {
				echo "User has canceled authentication !";
			} elseif($openid->validate()) {
				$data = $openid->getAttributes();
				$email = $data['contact/email'];
				$first = $data['namePerson/first'];
				echo "Identity : $openid->identity <br>";
				echo "Email : $email <br>";
				echo "First name : $first";
				$this->output->set_header('refresh:5; url=user');
			} else {
				echo "The user has not logged in";
				$this->output->set_header('refresh:5; url=index');
			}
		} else {
			echo "Go to index page to log in.";
			$this->output->set_header('refresh:5; url=index');
		}
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