<?php

class Main extends CI_Controller {
	
	function Main()
	{
		parent::__construct();	
	}
	
	function index()
	{
		// LOAD LIBRARIES
		$this->load->library(array('encrypt', 'form_validation', 'session'));
		
		// LOAD HELPERS
		$this->load->helper(array('form', 'url'));
		
		// VALID USER CREDENTIALS
		$user_credentials = array();
		$user_credentials['testuser1'] = array(
			'user_name' => 'testuser1',
			'user_pass' => 'Gag/R6LlMz8JKhjd+pkMrL+MUIHn86vjs/ZJ31uH+QRCh1eRxxA0Fve6FXfE7rmFqgqsiwe2ZFrFT8ylZs050A==' // password
		);
		$user_credentials['testuser2'] = array(
			'user_name' => 'testuser2',
			'user_pass' => 'Gag/R6LlMz8JKhjd+pkMrL+MUIHn86vjs/ZJ31uH+QRCh1eRxxA0Fve6FXfE7rmFqgqsiwe2ZFrFT8ylZs050A==' // password
		);
		$user_credentials['testuser3'] = array(
			'user_name' => 'testuser3',
			'user_pass' => 'Gag/R6LlMz8JKhjd+pkMrL+MUIHn86vjs/ZJ31uH+QRCh1eRxxA0Fve6FXfE7rmFqgqsiwe2ZFrFT8ylZs050A==' // password
		);
		
		// SET VALIDATION RULES
		$this->form_validation->set_rules('user_name', 'username', 'required');
		$this->form_validation->set_rules('user_pass', 'password', 'required');
		$this->form_validation->set_error_delimiters('<em>','</em>');
		
		// has the form been submitted and with valid form info (not empty values)
		if($this->input->post('login'))
		{
			if($this->form_validation->run())
			{
				$user_name = $this->input->post('user_name');
				$user_pass = $this->input->post('user_pass');
				
				if(array_key_exists($user_name, $user_credentials))
				{
					if($user_pass == $this->encrypt->decode($user_credentials[$user_name]['user_pass']))
					{
						// user has been logged in
						die("USER LOGGED IN!");
					}
					else
					{
						$this->session->set_flashdata('message', 'Incorrect password.');
						redirect('main/index/');
					}
				}
				else
				{
					$this->session->set_flashdata('message', 'A user does not exist for the username specified.');
					redirect('main/index/');
				}
			}
		}
		
		$this->load->view('templates/header_2');
		$this->load->view('templates/login_form');
		$this->load->view('templates/footer_2');
	}
	
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */