<?php 

class User extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_db');
		$this->load->library('session');
	}
	
	public function index() { // IMPORTANT TO FIX !!!
		if($this->session->userdata('user_name')!='') $this->view('user');
		else {
			$this->view('index');
		}
	}
	
	public function signup() { // done (?)
		$this->load->library('form_validation');
		$this->form_validation->set_rules('fname', 'First Name', 'trim|required|min_length[3]|max_length[12]');
		$this->form_validation->set_rules('lname', 'Last Name', 'trim|required|min_length[3]|max_length[12]');
		$this->form_validation->set_rules('gmail', 'Gmail', 'trim|required|valid_email|callback_check_entry');
		$this->form_validation->set_rules('con_gmail', 'Gmail Confirmation', 'trim|required|matches[gmail]');
		
		if ($this->form_validation->run() == FALSE) $this->index();
		else {
			$this->user_db->add_user();
			$this->checkmail();
			$data['url'] = 'index';
			$data['message'] = 'Signup successful!';
			$this->load->view('kpi/redirect', $data);
		}
	}
	
	public function checkmail() { // parameters for body, email, etc.
		require("../phpmailer/class.phpmailer.php");
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = "ssl";
		$mail->Host = "smtp.gmail.com";
		$mail->Port = 465;
		$mail->Username = "jasper.cacbay@gmail.com";
		$mail->Password = "sinecosinetangent";
		$webmaster_mail = "jtcacbay@up.edu.ph";
		$email=$this->input->post('gmail');
		$name=$this->input->post('fname')." ".$this->input->post('lname');
		$mail->From = "postmaster@localhost";
		$mail->FromName = "KPI Automation System";
		$mail->AddAddress($email, $name);
		$mail->AddReplyTo($webmaster_mail, "Postmaster");
		$mail->WordWrap = 50;
		$mail->IsHTML(true);
		$mail->Subject = "KPI Automation System Account Confirmation";
		$mail->Body = "klajf;klasdj";
		$mail->AltBody = "..";
		if (!$mail->Send()) echo "Error";
		else echo "Message has been sent";
	}
	
	public function check_selection($option) { // done
		if ($option == 'Please select') {
			$this->form_validation->set_message('check_selection', 'The selected %s is invalid. Please select a valid one.');
			return false;
		}
		else return true;
	}
	
	public function check_entry($gmail) { // small fix pa
		$update = $this->input->get('q');
		if (!empty($update)) return true;
		if ($this->user_db->gen_query('user_id, iscu_id, status_id','users','email="'.$gmail.'"')->num_rows > 0) {
			$this->form_validation->set_message('check_entry', 'An account with this %s already exists');
			return false;
		}
		else return true;
	}
	
	public function auth() {
		require_once 'kpi_sources/openid.php';
		$openid = new LightOpenID("localhost");
		try {
			$openid->identity = 'https://www.google.com/accounts/o8/id';
			$openid->required = array(
			  'namePerson/first',
			  'namePerson/last',
			  'contact/email',
			);
			//header('Location: ' . $openid->authUrl());
			$openid->returnUrl = 'http://localhost/ci/index.php/login';
			header('Location: '.$openid->authUrl());
		} catch (Exception $e) {
			// echo $e;
			// walang net haha
			// redirect sana, na walang net, or naputol ung net :o
		}
	}
	
	public function login() { // small fix
		require_once 'kpi_sources/openid.php';
		$openid = new LightOpenID("localhost");
		 
		if ($openid->mode) {
			if ($openid->validate()) {
				$email = $openid->getAttributes()['contact/email'];
				$user = $this->user_db->gen_query('user_id, iscu_id, status_id','users','email="'.$email.'"');
				if ($user->num_rows > 0) {
					if ($user->result()[0]->status_id == 1) $this->output->set_header('location: redirect');
					else if ($user->result()[0]->status_id == 2) $this->output->set_header('location: redirect_fail');
					else $this->output->set_header('location: redirect_fail');
				}
				else $this->output->set_header('location: redirect_email');	// echo "No email in the db.";
			} else $this->output->set_header('location: redirect_fail');	// echo "The user has not logged in";
		} else $this->output->set_header('location: redirect_fail');	// echo "You need to log in.";
	}
	
	public function view($page) // general view function
	{
		// not sure kung kelangan, pero magandang merong 404 page
		//if( !file_exists('application/views/kpi/'.$page.'.php'))
		//{
			//$this->load->helper('url');
			//echo site_url();
			//show_404();
		//}
		
		//$data['title'] = ucfirst($page);
		
		if ($page != 'index' && strncmp($page, 'redirect', strlen('redirect'))) {
			$iscu_id = 1001; // hard coded pa
				
			$data['kpi'] = $this->user_db->sidebar();
			$data['subkpi'] = $this->user_db->subsidebar();
			$data['update'] = $this->user_db->updates($iscu_id);
			$data['checker'] = "empty";
			
			$user = strtok($page, "_");
			
			if ( $page == 'superuser_activate' ) $this->activate();
			else if ($page != 'superuser_accounts' && $page != 'superuser_addaccount') {
				
				$this->load->view('kpi/header');
				$this->load->view('kpi/banner');
				$this->load->view('kpi/navbar_'.$user);
				$this->load->view('kpi/'.$page,$data);
				$this->load->view('kpi/footer');
			
			}
			else $this->view_accounts($page);
		}
		else {
			$this->load->view('kpi/'.$page);
		}
	}
	
	public function viewmetric() // IMPORTANT TO FIX !!! error check din
	{
		/* $post_values = $this->input->post(NULL, true);
		$this->load->library('form_validation');
		if (!empty($post_values) && !in_array("", $post_values)) {
			$save = true;
		}
		$save = false; */
		$q = $this->parse_q($_GET['q']);
		$iscu_id = 1001; // hard coded
		$identifier = "verified";
		
		$current_kpi = $q['current_kpi'];
		$current_subkpi = $q['current_subkpi'];
		
		$data['kpi'] = $this->user_db->sidebar();
		$data['subkpi'] = $this->user_db->subsidebar();
		$data['period'] = $this->user_db->period_value();
		$data['metric_values'] = $this->user_db->allmetric($iscu_id, $identifier);
		
		$data['current_kpi'] = $current_kpi;
		$data['current_subkpi'] = $current_subkpi;
		
		$data['metric'] = $this->user_db->query_metric($current_subkpi);
		$data['checker'] = "notempty";
		
		/* for ($i = 1; $i < count($data['metric'])+1; $i++) {
			$this->form_validation->set_rules('answer'.$i, $data['metric'][$i-1]['field_name'], 'trim|required|numeric');
		}
		
		if ($this->form_validation->run() == false && $save) {
			header('location: rate?q='.$_GET['q']);
		} */
		
		// load model
		$this->load->model('addratemodel');
		$user_id = 1; //hard coded
		$results_id = 1; // hard coded
		
		// check kung naglagay ng value, tapos update db
		$counter = 0;
		while($counter<count($_POST)){
			$key = substr(key($_POST),6);
			$val = current($_POST);
			$this->addratemodel->adduserrate($key, $val, $user_id, $results_id);
			next($_POST);
			$counter++;
		}
		
		// get value kung meron na
		$data['metric_value'] = array();
		foreach($data['metric'] as $metric){
			$value = $this->addratemodel->getrating($metric['field_id'], $user_id, $results_id);
			if(count($value)==0)
				$value = "";
			else
				$value = $value['value'];
			array_push($data['metric_value'], $value);
		}
		
		$next = false;
		
		for ($i = 0; $i < count($data['kpi']); $i++) {
			if ($current_kpi === $data['kpi'][$i]['kpi_name'] || $next) {
				$childkpi = $this->user_db->gen_query('kpi_name','kpi','parent_kpi='.$data['kpi'][$i]['kpi_id']);
				for ($j = 0; $j < $childkpi->num_rows; $j++) {
					if ($next) {
						$data['next'] = str_replace(" ", "_", $data['kpi'][$i]['kpi_name'])."/".str_replace(" ", "_", $childkpi->result_array()[$j]['kpi_name']);
						$next = false;
						break;
					}
					if ($current_subkpi === $childkpi->result_array()[$j]['kpi_name'])
						$next=true;
				}
			}
		}
		
		/* if (!empty($post_values)) $this->user_db->adduserrate(); */
		
		$this->load->view('kpi/header');
		$this->load->view('kpi/banner');
		$this->load->view('kpi/navbar_user');
		$this->load->view('kpi/user_rate',$data);
		$this->load->view('kpi/footer');

	}
	
	public function user_rated(){
		// load model
		$this->load->model('addratemodel');
		$user_id = 1; //hard coded
		$results_id = 1; // hard coded
		
		// check kung naglagay ng value, tapos update db
		$counter = 0;
		while($counter<count($_POST)){
			$key = substr(key($_POST),6);
			$val = current($_POST);
			$this->addratemodel->adduserrate($key, $val, $user_id, $results_id);
			next($_POST);
			$counter++;
		}
		$iscu_id = 1001; // hard coded pa
				
		$data['kpi'] = $this->user_db->sidebar();
		$data['subkpi'] = $this->user_db->subsidebar();
		$data['update'] = $this->user_db->updates($iscu_id);
		$data['checker'] = "empty";
		$user = "user";
		
		$data['fieldvalues'] = $this->addratemodel->getallratings($user_id, $results_id);
		
		$this->load->view('kpi/header');
		$this->load->view('kpi/banner');
		$this->load->view('kpi/navbar_'.$user);
		$this->load->view('kpi/user_rated',$data);
		$this->load->view('kpi/footer');
	}
	
	public function submit() { // IMPORTANT TO FIX !!!
		$this->load->helper('url');

		// update db
		$this->load->model('user_db');
		$this->user_db->submitRates();
		
		// redirect to rate page
		redirect('user_rate');
		
		$this->load->view('kpi/header');
		$this->load->view('kpi/banner');
		//$this->load->view('kpi/navbar_'.$user);
		//$this->load->view('kpi/user_rate');
		//$this->load->view('kpi/'.$page,$data);

		$this->load->view('kpi/footer');
	}
	
	public function viewuser() // auditor
	{
		$page='auditor_verify';
		$user = strtok($page, "_");
		
		$iscu_id = 1001; // hard coded pa
		
		$data['userid'] = $this->user_db->sidebar_verify($iscu_id);
		$data['checker'] = "empty"; // hard coded pa
		
		$this->load->view('kpi/header');
		$this->load->view('kpi/banner');
		$this->load->view('kpi/navbar_'.$user);
		$this->load->view('kpi/'.$page,$data);
		$this->load->view('kpi/footer');
	}
	
	public function viewaccountid() // audior list ng mga unverified rate
	{
		$q = $_GET['q'];
		$iscu_id = 1001; // hard coded pa
		$identifier = "submitted";
		
		$page='auditor_verify';
		$user = strtok($page, "_");
		
		$data['kpi'] = $this->user_db->sidebar();
		$data['subkpi'] = $this->user_db->subsidebar();
		$data['userid'] = $this->user_db->sidebar_verify($iscu_id);
		$data['metric'] = $this->user_db->allmetric($iscu_id, $identifier);
		$data['verifyvalue'] = $this->user_db->verify_value($user_id);
		$data['user_id'] = $user_id;
		$data['checker'] = "notempty"; // hard coded pa
		
		$this->load->view('kpi/header');
		$this->load->view('kpi/banner');
		$this->load->view('kpi/navbar_'.$user);
		$this->load->view('kpi/'.$page,$data);
		$this->load->view('kpi/footer');
	}
	
	public function view_accounts($page) { // view accounts for super user
		$data['accounts'] = $this->user_db->get_accounts();
		$data['iscu'] = $this->user_db->gen_query('iscu', 'iscu');
		$data['account_name'] = $this->user_db->gen_query('account_name','accounts','');
		
		$this->load->view('kpi/header');
		$this->load->view('kpi/banner');
		$this->load->view('kpi/navbar_superuser');
		$this->load->view('kpi/'.$page, $data);
		$this->load->view('kpi/footer');
	}
	
	public function delete_account() { // dapat ba magnotify sa na-delete?
		$q = $_GET['q'];
		
		$this->user_db->delete($q);
		//$this->output->set_header("location: redirect");
		$data['success'] = true;
		
		$this->output->set_header('location: superuser_accounts');
	}
	
	public function add_account() { // fix needed
		$this->load->library('form_validation');
		$this->form_validation->set_rules('fname', 'First Name', 'trim|required|min_length[3]|max_length[12]');
		$this->form_validation->set_rules('lname', 'Last Name', 'trim|required|min_length[3]|max_length[12]');
		$this->form_validation->set_rules('gmail', 'Gmail', 'trim|required|valid_email|callback_check_entry');
		$this->form_validation->set_rules('con_gmail', 'Gmail Confirmation', 'trim|required|matches[gmail]');
		$this->form_validation->set_rules('iscu','Unit', 'required|callback_check_selection');
		$this->form_validation->set_rules('account_name','Position', 'required|callback_check_selection');
		
		if ($this->form_validation->run() == FALSE) $this->view('superuser_addaccount');
		else {
			$this->user_db->add_user();
			//$this->checkmail(); // kelangan to, pero not now, i-edit ko pa
			$data['url'] = 'superuser_accounts';
			$data['message'] = (isset($_GET['q']) ? 'Edit' : 'Add').' account successful';
			$this->load->view('kpi/redirect', $data);
		}
	}
	
	public function addKPI() { // (done)
		$this->load->library('form_validation');
		$this->form_validation->set_message('is_unique', 'This %s already exists');
		$this->form_validation->set_rules('kpi_name', 'KPI Name', 'trim|required|min_length[3]|is_unique[kpi.kpi_name]');
		
		if ($this->form_validation->run() == false) {
			//$this->view('superuser_addkpi');
			$this->session->set_flashdata('errors', validation_errors('<div class="alert alert-red">', '</div>'));
			header('location: superuser_addkpi');
		}
		else {
			$this->user_db->addKPI();
			
			$result = $this->user_db->getKpiId($this->input->post("kpi_name"));
			$kpi_id = $result['kpi_id'];
			//print"<pre>";print_r($result);print"</pre>";
			
			$selected_radio = $this->input->post("radio");
			if ($selected_radio == 'subkpi_radio'){
				$location = 'location:'.site_url('superuser_addsubkpi').'?id='.$kpi_id;
			} else {
				$location = 'location:'.site_url('superuser_addmetric1').'?id='.$kpi_id;
			}
			header($location);
		}
	}
	
	public function addSubKPI() { // (done)
		$this->load->library('form_validation');
		$this->form_validation->set_message('is_unique', 'This %s already exists');
		$this->form_validation->set_rules('subkpi_name', 'SubKPI Name', 'trim|required|min_length[3]|is_unique[kpi.kpi_name]');
		
		if ($this->form_validation->run() == false) {
			//$redirect = $this->input->post('redirect');
			//$data['id']=$this->input->post('id');
			$data['errors'] = validation_errors('<div class="alert alert-red">', '</div>');
			$data['id'] = $this->input->post('id');
			$this->session->set_flashdata('errors', $data);
			//$this->load->view('kpi/superuser_addsubkpi', $data);
			//redirect($redirect);
			header('location: superuser_addsubkpi?id='.$data['id']);
		}
		else {
			$this->user_db->addSubKPI();

			$result = $this->user_db->getSubKpiId($this->input->post("subkpi_name"));
			$subkpi_id = $result['kpi_id'];
			//print"<pre>";print_r($result);print"</pre>";
			$location = 'location:'.site_url('superuser_addmetric').'?id='.$subkpi_id;
			header($location);
		}
	}
	
	function addMetric() { // (done)
		$this->load->library('form_validation');
		$this->form_validation->set_message('required', 'All metric fields are required.');
		$this->form_validation->set_message('min_length', 'All metric names should at least be 3 characters long.');
		$this->form_validation->set_message('is_unique', 'One of the metric names already exists.');
		
		for ($i = 0; $i < count($this->input->post(NULL, true))-1; $i++) {
			$this->form_validation->set_rules('metric_name'.$i, 'Metric', 'trim|required|min_length[3]|is_unique[fields.field_name]');
		}
		
		if ( $this->form_validation->run() == false ) {
			$data['errors'] = validation_errors('<div class="alert alert-red">', '</div>');
			$data['id'] = $this->input->post('id');
			$this->session->set_flashdata('errors', $data);
			header('location: superuser_addmetric?id='.$this->input->post('id'));
		}
		else {
			$result = $this->user_db->addMetric();
			
			$kpi_id = $result['parent_kpi'];
			//print"<pre>";print_r($result);print"</pre>";
			$location = 'location:'.site_url('superuser_addsubkpi').'?id='.$kpi_id;
			header($location);
		}
	}
	
	function addMetric1() { // (done)
		$this->load->library('form_validation');
		$this->form_validation->set_message('required', 'All metric fields are required.');
		$this->form_validation->set_message('min_length', 'All metric names should at least be 3 characters long.');
		$this->form_validation->set_message('is_unique', 'One of the metric names already exists.');
		
		for ($i = 0; $i < count($this->input->post(NULL, true))-1; $i++) {
			$this->form_validation->set_rules('metric_name'.$i, 'Metric', 'trim|required|min_length[3]|is_unique[fields.field_name]');
		}
		
		if ( $this->form_validation->run() == false ) {
			$data['errors'] = validation_errors('<div class="alert alert-red">', '</div>');
			$data['id'] = $this->input->post('id');
			$this->session->set_flashdata('errors', $data);
			header('location: superuser_addmetric1?id='.$this->input->post('id'));
		}
		else {
			$result = $this->user_db->addMetric();
			
			$kpi_id = $result['parent_kpi'];
			//print"<pre>";print_r($result);print"</pre>";
			$location = 'location:'.site_url('superuser_KPIs').'';
			header($location);
		}
	}
	
	public function deactivate_value()
	{
		$q = $_GET['q'];
		$level = strtok($q, "/");
		$id = strtok("/");

		if ($level==1)
		{
			$this->user_db->deactivate_1($id);
		}
		else if($level==2)
		{
			$this->user_db->deactivate_2($id);
		}
		else if($level==3)
		{
			$this->user_db->deactivate_3($id);
		}
	}
	
	// public function viewedit() 
	// {
		// $q = $this->parse_q($_GET['q']);
		
		// $data['kpi'] = $this->user_db->sidebar();
		// $data['subkpi'] = $this->user_db->subsidebar();
		// $data['metric'] = $this->user_db->query_metric($q['current_subkpi']);
		// $data['checker'] = "notempty"; // hard coded pa
		
		// $this->load->view('kpi/header');
		// $this->load->view('kpi/banner');
		// $this->load->view('kpi/navbar_superuser');
		// $this->load->view('kpi/superuser_edit',$data);
		// $this->load->view('kpi/footer');
	// }
	
	public function edit_values()
	{
		$q = $this->parse_q($_GET['q']);
		$iscu_id = 1001;
		
		$current_kpi = $q['current_kpi'];
		$current_subkpi = $q['current_subkpi'];

		$data['kpi'] = $this->user_db->sidebar();
		$data['subkpi'] = $this->user_db->subsidebar();
		$data['metric'] = $this->user_db->query_metric($current_subkpi);
		$data['checker'] = "notempty";

		$this->load->view('kpi/header');
		$this->load->view('kpi/banner');
		$this->load->view('kpi/navbar_superuser');
		$this->load->view('kpi/superuser_edit',$data);
		$this->load->view('kpi/footer');

	}
	
	public function check_fieldchange($str) {
		if (count(array_keys($this->input->post('metric'), $str)) > 1) {
			$this->form_validation->set_message('check_fieldchange', 'A metric name was entered twice. Metric names must be unique.');
			return false;
		}
		else {
			$this->form_validation->set_message('check_fieldchange', 'One of the metric names already exists. Please enter a unique metric name.');
			
			foreach ($this->input->post('metric') as $metric_item):
				
				$result = $this->user_db->gen_query('field_id, field_name', 'fields', 'field_name="'.$metric_item.'"');
				
				if ( $result->num_rows > 1 ) return false;
				else if ( $result->num_rows == 1 ) {
					
					$key = array_keys($this->input->post('metric_id'), $result->result()[0]->field_id);
					
					if ( empty($key) || $result->result()[0]->field_name != $this->input->post('metric')[$key[0]] ) {
						return false;
					}
				}
			endforeach;
		}
		return true;
	}
	
	public function check_subkpichange($str) {
		if ( $this->user_db->gen_query('kpi_name', 'kpi', 'kpi_id='.$this->input->post('subkpi_id'))->result()[0]->kpi_name == $str ) {
			return true;
		}
		else if ( $this->user_db->gen_query('kpi_id', 'kpi', 'kpi_name="'.$str.'"')->result()[0]->kpi_id == $this->input->post('subkpi_id') ) {
			return true;
		}
		$this->form_validation->set_message('check_subkpichange', 'A SubKPI with this name already exists. SubKPI Names must be unique.');
		return false;
	}
	
	public function check_kpichange($str) {
		if ( $this->user_db->gen_query('kpi_name', 'kpi', 'kpi_id='.$this->input->post('kpi_id'))->result()[0]->kpi_name == $str ) {
			return true;
		}
		else if ( $this->user_db->gen_query('kpi_id', 'kpi', 'kpi_name="'.$str.'"')->result()[0]->kpi_id == $this->input->post('kpi_id') ) {
			return true;
		}
		$this->form_validation->set_message('check_kpichange', 'A KPI with this name already exists. KPI Names must be unique.');
		return false;
	}
	
	public function changevalue() { // error checking for editing kpi
		$this->load->library('form_validation');
		$this->form_validation->set_rules('kpi', 'KPI Name', 'trim|required|min_length[3]|callback_check_kpichange');
		$this->form_validation->set_rules('subkpi', 'SubKPI Name', 'trim|required|min_length[3]|callback_check_subkpichange');
		$this->form_validation->set_rules('metric[]', 'Metric Name', 'trim|required|min_length[3]|callback_check_fieldchange');
		$asdf = $this->input->post(NULL, true);
		//echo var_dump($asdf);
		
		if ( $this->form_validation->run() == false ) {
			// $asdf = $this->input->post(NULL, true);
			// echo var_dump($asdf);
			echo validation_errors();
		}
		else {
			$location =  $this->user_db->change_value();
			header('Location:'.$location);
		}
	}
	
	public function edit_a_value()
	{
		$q = $this->parse_q($_GET['q']);
		$iscu_id = 1001;

		$current_kpi = $q['current_kpi'];
		$current_subkpi = $q['current_subkpi'];

		$data['kpi'] = $this->user_db->sidebar();
		$data['subkpi'] = $this->user_db->subsidebar();
		$data['metric'] = $this->user_db->query_metric($current_subkpi);
		$data['path'] = $_GET['q'];
		$data['current_kpi'] = $current_kpi;
		$data['current_subkpi'] = $current_subkpi;
		$data['kpi_value_id'] = $this->user_db->find_id($current_kpi);
		$data['subkpi_value_id'] = $this->user_db->find_id($current_subkpi);
		$data['checker'] = "editing";

		$this->load->view('kpi/header');
		$this->load->view('kpi/banner');
		$this->load->view('kpi/navbar_superuser');
		$this->load->view('kpi/superuser_edit',$data);
		$this->load->view('kpi/footer');
	}
	
	function parse_q($q) {
		$current_kpi = str_replace("_", " ", strtok($q, "/"));
		$current_subkpi = str_replace("_", " ", strtok("/"));
		return array('current_kpi'=>$current_kpi, 'current_subkpi'=>$current_subkpi);
	}
	
	function activate() { // activate KPI for superuser
		list($data['inactive'], $data['kpi'], $data['subkpi']) = $this->user_db->get_inactive();
		
		$this->load->view('kpi/header');
		$this->load->view('kpi/banner');
		$this->load->view('kpi/navbar_superuser');
		$this->load->view('kpi/superuser_activate', $data);
		$this->load->view('kpi/footer');
	}
	
	function shit() {
		echo "<pre>";
		print_r($this->input->post(NULL, true));
		echo "</pre>";
	}
}

?>