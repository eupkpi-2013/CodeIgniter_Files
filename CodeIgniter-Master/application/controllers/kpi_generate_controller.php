<?php
class kpi_generate_controller extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('kpi_generate_model');
		$this->load->model('updates_model');
		
		// $newdata = array(
					// 'iscu_id' => 1,
					// 'user_id' => 1,
					// 'account_id' => 1);
		// $this->session->set_userdata($newdata);
	}

	public function index()
	{	
	}
	
	public function generate($output_id){
		$user_id = $this->session->userdata['user_id'];
		$account_id = $this->session->userdata['account_id'];
		$iscu_id = $this->session->userdata['iscu_id'];
		
		$forbidden = false;
		if($account_id == 1 || $account_id == 2){
			$data['kpis'] = $this->kpi_generate_model->get_parent_kpis();
			$data['subkpis'] = $this->kpi_generate_model->get_sub_kpis();
			$data['metrics'] = $this->kpi_generate_model->get_all_metrics();			
			$data['results'] = $this->kpi_generate_model->get_all_inactive_results();
			$data['iscus'] = $this->kpi_generate_model->get_all_iscus();
			$data['accounts'] = $this->kpi_generate_model->get_all_accounts();
			$data['output_types'] = $this->kpi_generate_model->get_output_types();
			if($output_id == "null" || $output_id == "exists"){
				if($output_id == "exists"){
					$data['message'] = "Report Name already exists.";
				}
				$undone_output = $this->kpi_generate_model->get_all_not_done_output($user_id);
				foreach($undone_output as $output){
					$this->kpi_generate_model->delete_all_output_rels($output['output_id']);
					$this->kpi_generate_model->delete_output($output['output_id']);
				}
			}
			else if($output_id != "null"){
				$data['output'] = $this->kpi_generate_model->get_output($output_id);
				if($data['output']['user_id']!=$user_id){
					$forbidden = true;
				}
				else{
					$data['output_fields'] = $this->kpi_generate_model->get_output_fields($output_id);
					$data['output_results'] = $this->kpi_generate_model->get_output_results($output_id);
					$data['output_accounts'] = $this->kpi_generate_model->get_output_accounts($output_id);
					$data['output_iscus'] = $this->kpi_generate_model->get_output_iscus($output_id);
				}
			}
		}
		else{
			$forbidden = true;
		}
		if($forbidden)
			echo "403 Forbidden";
		else{
			$this->load->view('generate/head');
			// $this->load->view('generate/header');
			$this->load->view('kpi/header');
			$this->load->view('kpi/banner');
			$this->load->view('kpi/navbar_superuser');
			$this->load->view('generate/content-generate',$data);
			$this->load->view('generate/footer');
		}
	}
	
	public function generated()
	{	
		$user_id = $this->session->userdata['user_id'];
		$account_id = $this->session->userdata['account_id'];
		$iscu_id = $this->session->userdata['iscu_id'];
		
		if(!isset($_POST['name'])){
			echo "403 Forbidden";
		}
		else{
			$project_id = 1;
			$this->load->library('form_validation');
			$this->form_validation->set_rules('name', 'name', 'required|is_unique[output.output_name]');
			$exists = $this->kpi_generate_model->check_output_exists($_POST['name']);
			if($exists>0){
				$this->generate('exists');
			}
			else
			{
				$metrics = $this->kpi_generate_model->get_all_metrics();
				$results = $this->kpi_generate_model->get_all_results();
				$iscus = $this->kpi_generate_model->get_all_iscus();
				$accounts = $this->kpi_generate_model->get_all_accounts();
				$fields_included = [];
				$subkpis_included = [];
				$results_included = [];
				$iscus_included = [];
				$accounts_included = [];
				foreach($metrics as $metric){
					$postname = 'checkfield'.$metric['field_id'];
					if (isset($_POST[$postname]))
					{
						array_push($fields_included, $metric);
						$breadcrumbs = $this->kpi_generate_model->get_breadcrumbs($metric['field_id']);
						$subkpi = end($breadcrumbs);
						if(!in_array($subkpi, $subkpis_included)){
							array_push($subkpis_included, $subkpi);
						}
					}
				}
				foreach($results as $result){
					$postname = 'checkresult'.$result['results_id'];
					if (isset($_POST[$postname]))
					{
						array_push($results_included, $result);
					}
				}
				foreach($iscus as $iscu){
					$postname = 'checkiscu'.$iscu['iscu_id'];
					if (isset($_POST[$postname]))
					{
						array_push($iscus_included, $iscu);
					}
				}
				foreach($accounts as $account){
					$postname = 'checkaccount'.$account['account_id'];
					if (isset($_POST[$postname]))
					{
						array_push($accounts_included, $account);
					}
				}
				if (isset($_POST['checkpublic'])){
					$is_public = 1;
				}
				else
					$is_public = 0;
				
				// update db
				if (isset($_POST['outputid']))
				{
					$output_id = $_POST['outputid'];
					$this->kpi_generate_model->update_output($output_id, $_POST['name'], $_POST['description'],$_POST['charttype'],$is_public);
					$this->kpi_generate_model->delete_all_output_rels($output_id);
				}
				
				// insert to db
				else{
					$output_id = $this->kpi_generate_model->new_output($_POST['name'],$_POST['description'],$_POST['charttype'],$is_public, $user_id, $project_id);
				}	
				
				foreach($fields_included as $field){
					$this->kpi_generate_model->new_output_field($field['field_id'],$output_id);
				}	
				foreach($results_included as $result){
					$this->kpi_generate_model->new_output_result($result['results_id'], $output_id);
				}
				foreach($iscus_included as $iscu){
					$this->kpi_generate_model->new_output_iscu($iscu['iscu_id'], $output_id);
				}
				foreach($accounts_included as $account){
					$this->kpi_generate_model->new_output_account($account['account_id'], $output_id);
				}
				
				// always add boss
				$this->kpi_generate_model->new_output_account(4, $output_id);
				
				// always add superuser
				$this->kpi_generate_model->new_output_account(1, $output_id);
				
				// write text file
				$this->info_file($output_id);
				
				// get javascript and breadcrumbs
				if($_POST['charttype']!=1){
					$hc = $this->load_highchart($output_id);
					$data['highchart'] = $hc[0];
				}
				
				$data['subkpis'] = $subkpis_included;
				$data['output'] = $this->kpi_generate_model->get_output($output_id);	
					
				// $this->load->view('generate/head');
				// $this->load->view('generate/header');
				$this->load->view('kpi/header');
				$this->load->view('kpi/banner');
				$this->load->view('kpi/navbar_superuser');
				$this->load->view('generate/content-generate-preview', $data);
				$this->load->view('generate/footer');
			}
		}
	}
	
	public function get_breadcrumbs($output_id, $fields_included){
		$crumbs_included = [];
		foreach($fields_included as $field){
			$breadcrumbs = $this->kpi_generate_model->get_breadcrumbs($field['field_id']);
			if(!in_array($breadcrumbs, $crumbs_included)){
				array_push($crumbs_included, $breadcrumbs);
			}
		}
		// $crumbs_included[0] = subkpi, $crumbs_included[0] = kpi
		return $crumbs_included;
	}
	
	public function load_highchart($output_id){
		$output = $this->kpi_generate_model->get_output($output_id);
		if($output['output_type']==2)
			$hc = $this->load_highchart_line($output_id);	
		else if($output['output_type']==3)
			$hc = $this->load_highchart_bar($output_id);
		return $hc;
	}
	
	public function load_highchart_bar($output_id){
		$fields_included = $this->kpi_generate_model->get_output_fields($output_id);
		$crumbs_included = $this->get_breadcrumbs($output_id, $fields_included);
		$results_included = $this->kpi_generate_model->get_output_results($output_id);
		$output = $this->kpi_generate_model->get_output($output_id);
		
		$counter = 1;
		$js = '<script>';
		$js = $js.'$(function () {';
		
		foreach($crumbs_included as $subkpi){
			$element = '#container'.$subkpi[0]['kpi_id'];
			$title = $subkpi[1]['kpi_name'].">".$subkpi[0]['kpi_name'];
			$categories = array();
			foreach($fields_included as $field){
				if($subkpi[0]['kpi_id']==$field['kpi_id']){
					$iscus = $this->kpi_generate_model->get_iscu($field['field_id']);
					foreach($iscus as $iscu){
						array_push($categories, '"'.$field['field_name'].' ('.$iscu['iscu'].') "');
					}
				}					
			}
			$series = array();
			foreach($results_included as $result){
				$name = $result['results_name'];
				$data = array();
				foreach($fields_included as $field){
					if($subkpi[0]['kpi_id']==$field['kpi_id']){
						$iscus = $this->kpi_generate_model->get_iscu($field['field_id']);
						foreach($iscus as $iscu){
							$value = $this->kpi_generate_model->get_field_value($result['results_id'],$field['field_id'],$iscu['iscu_id']);
							if(isset($value['value']))
								$value = $value['value'];
							else
								$value = 0;
							array_push($data, $value);
						}
					}
				}
				array_push($series, array("name"=>$name, "data"=>$data));
			}
			$hc = '$("'.$element.'").highcharts({
					chart: {
					type: "column"
					},
					title: {
						text: "'.$title.'"
					},
					subtitle: {
						text: ""
					},
					xAxis: {
						categories: ['.implode(",", $categories).']
					},
					yAxis: {
						min: 0,
						title: {
						}
					},
					tooltip: {
						headerFormat: "<span style=\'font-size:10px\'>{point.key}</span><table>",
						pointFormat: "<tr><td style=\'color:{series.color};padding:0\'>{series.name}: </td>" +
							"<td style=\'padding:0\'><b>{point.y:.1f}</b></td></tr>",
						footerFormat: "</table>",
						shared: true,
						useHTML: true
					},
					plotOptions: {
						column: {
							pointPadding: 0.2,
							borderWidth: 0
						}
					},
					series: [';
					foreach($series as $serie){
						$hc = $hc.'{name: "'.$serie['name'].'", data: ['.implode(",", $serie['data']).']},';
					}
			$hc = $hc.'],
					 exporting: {
						enabled: true,
						sourceWidth: 1200,
						filename:"'.$output_id."-".str_replace(" ", "_", $output['output_name'])."-".$counter."-".str_replace(" ", "_", $subkpi[0]['kpi_name']).'"
					}
					});';
			$js = $js.$hc;
			$counter++;
		}
		
		$js = $js.'});';
		$js = $js.'</script>';
		return [$js,$crumbs_included];
	}
	
	public function load_highchart_line($output_id){
		$fields_included = $this->kpi_generate_model->get_output_fields($output_id);
		$crumbs_included = $this->get_breadcrumbs($output_id, $fields_included);
		$results_included = $this->kpi_generate_model->get_output_results($output_id);
		$output = $this->kpi_generate_model->get_output($output_id);
		
		$counter = 1;
		$js = '<script>';
		$js = $js.'$(function () {';
		
		foreach($crumbs_included as $subkpi){
			$element = '#container'.$subkpi[0]['kpi_id'];
			$title = $subkpi[1]['kpi_name'].">".$subkpi[0]['kpi_name'];
			$categories = array();
			foreach($results_included as $result){
				array_push($categories, '"'.$result['results_name'].'"');
			}
			$series = array();
			foreach($fields_included as $field){
				if($subkpi[0]['kpi_id']==$field['kpi_id']){
					$iscus = $this->kpi_generate_model->get_iscu($field['field_id']);
					foreach($iscus as $iscu){
						$name = $field['field_name']."(".$iscu['iscu'].")";
						$data = array();
						foreach($results_included as $result){
								$value = $this->kpi_generate_model->get_field_value($result['results_id'],$field['field_id'], $iscu['iscu_id']);
								if(isset($value['value']))
									$value = $value['value'];
								else
									$value = 0;
								array_push($data, $value);
							
						}
						array_push($series, array("name"=>$name, "data"=>$data));
					}
				}				
			}
			$hc = '$("'.$element.'").highcharts({
					chart: {
					type: "line"
					},
					title: {
						text: "'.$title.'"
					},
					subtitle: {
						text: ""
					},
					xAxis: {
						categories: ['.implode(",", $categories).']
					},
					yAxis: {
						min: 0,
						title: {
						}
					},
					tooltip: {
						headerFormat: "<span style=\'font-size:10px\'>{point.key}</span><table>",
						pointFormat: "<tr><td style=\'color:{series.color};padding:0\'>{series.name}: </td>" +
							"<td style=\'padding:0\'><b>{point.y:.1f}</b></td></tr>",
						footerFormat: "</table>",
						shared: true,
						useHTML: true
					},
					plotOptions: {
						column: {
							pointPadding: 0.2,
							borderWidth: 0
						}
					},
					series: [';
					foreach($series as $serie){
						$hc = $hc.'{name: "'.$serie['name'].'", data: ['.implode(",", $serie['data']).']},';
					}
			$hc = $hc.'],
					 exporting: {
						enabled: true,
						sourceWidth: 1200,
						filename:"'.$output_id."-".str_replace(" ", "_", $output['output_name'])."-".$counter."-".str_replace(" ", "_", $subkpi[0]['kpi_name']).'"
					}
					});';
			$js = $js.$hc;
			$counter++;
		}
		
		$js = $js.'});';
		$js = $js.'</script>';
		return [$js,$crumbs_included];
	}
	
	public function info_file($output_id){	
		$output = $this->kpi_generate_model->get_output($output_id);
		$user = $this->kpi_generate_model->get_output_user($output_id);
		$del = "\t";
		$info_file = $output_id.$del."eUP KPI: ".$output['output_name'].$del."by".$del.$user['fname']." ".$user['lname'].$del.$del.$output['timestamp']."\n";
		$results_included = $this->kpi_generate_model->get_output_results($output_id);
		$field_included = $this->kpi_generate_model->get_output_fields($output_id);
		
		$info_file=$info_file."\n";
		$info_file=$info_file.$del."KPI".$del.$del."SubKPI".$del.$del."Metric".$del."IS/CU".$del;
		
		$counter = 0;
		foreach($results_included as $result){
			//echo $result;
			if($counter>0)
				$info_file = $info_file.$del;
			$info_file=$info_file."(".$result['results_id'].")".$result['results_name'];
			$counter++;
		}
		$info_file=$info_file."\n";
		foreach($field_included as $field){
			$iscus = $this->kpi_generate_model->get_iscu($field['field_id']);
			// echo "Field: ".$field['field_id']." # of iscus: ".count($iscus)."\n";
			foreach($iscus as $iscu){
				$values=$this->kpi_generate_model->get_output_field_values($output_id, $field['field_id'],$iscu['iscu_id']);
				$breadcrumbs = $this->kpi_generate_model->get_breadcrumbs($field['field_id']);
				$counter = 0;
				foreach($breadcrumbs as $bc){
					if($counter>0)
						$info_file = $info_file.$del;
					$info_file=$info_file.$bc['kpi_id'].$del.$bc['kpi_name'];
					$counter++;
				}
				$info_file=$info_file.$del;
				$info_file=$info_file.$field['field_id'].$del.$field['field_name'];
				$info_file=$info_file.$del;
				$info_file=$info_file."(".$iscu['iscu_id'].") ".$iscu['iscu'].":";
				$info_file=$info_file.$del;
				$counter = 0;
				foreach($values as $value){
					if($counter>0)
						$info_file = $info_file.$del;
					$info_file=$info_file.$value['value'];
					$counter++;
				}
				$info_file=$info_file."\n";
			}
		}
		$info_file=$info_file."--";
		
		$this->load->helper('file');
		$path = 'files/';
		$filename = "info-".$output_id;
		write_file($path.$filename, $info_file);
	}
		public function previewpdf($output_id)
	{
		$this->load->helper('file');
		$path = 'files/';
		$text = read_file($path.'info-'.$output_id);
		$this->load->library('fpdf17/fpdf');		
		$pdf = new FPDF();
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetFont('Arial','',8);
		// $pdf->Write(5,$text);
		$text = str_replace("\t", " - ", $text);
		$pdf->MultiCell(0, 5, $text, []);
		$pdf->Output();
	}
	
	public function previewexcel($output_id)
	{
		$this->load->helper('file');
		$path = 'files/';
		$text = read_file($path.'info-'.$output_id);
		
		// $this->load->library('excel');
		// $this->excel->setActiveSheetIndex(0);
		// $this->excel->getActiveSheet()->setTitle('test worksheet');
		// $this->excel->getActiveSheet()->setCellValue('A1', $text);
		// $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		// //make the font become bold
		// $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		// //merge cell A1 until D1
		// $this->excel->getActiveSheet()->mergeCells('A1:D1');
		// //set aligment to center for that merged cell (A1 to D1)
		// $this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		// if($this->kpi_generate_model->is_done($output_id))
			// $filename='info-'.$output_id;
		// else
			// $filename='info-'.$output_id.'-preview.xls';
		// header('Content-Type: application/vnd.ms-excel'); //mime type
		// header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		// $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		// $objWriter->save('php://output');
		$this->load->helper('download');
		$name = $output_id.'excel.xls';

		force_download($name, $text);
	}
	
	public function previewtxt($output_id)
	{
		$this->load->helper('file');
		$path = 'files/';
		$text = read_file($path.'info-'.$output_id);
		header("Content-Type: text/plain");
		echo $text;
	}
	
	public function printablepage($output_id){
		$hc = $this->load_highchart($output_id);
		$data['subkpis'] = $hc[1];
		$data['highchart'] = $hc[0];
		$data['output'] = $this->kpi_generate_model->get_output($output_id);
		
		$this->load->view('generate/head');
		$this->load->view('generate/printable_page',$data);
		$this->load->view('generate/footer');
	}
	
	public function publish($output_id){
		$this->load->helper('file');
		$path = 'files/';
		$text = read_file($path.'info-'.$output_id);
		
		$this->load->library('excel');
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('test worksheet');
		$this->excel->getActiveSheet()->setCellValue('A1', $text);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		//make the font become bold
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		//merge cell A1 until D1
		$this->excel->getActiveSheet()->mergeCells('A1:D1');
		//set aligment to center for that merged cell (A1 to D1)
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$f = $this->kpi_generate_model->get_output($output_id);
		
		$path = 'files/';
		$filename = $f['output_id'].'-'.$f['output_name'];
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		$objWriter->save($path.$filename.'.xls');
		$this->kpi_generate_model->new_file($filename.'.xls', $output_id);
		
		$this->load->helper('file');
		$text = read_file('./application/views/files/info-'.$output_id);
		$this->load->library('fpdf17/fpdf');		
		$pdf = new FPDF();
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetFont('Arial','',11);
		$pdf->Write(10,$text);
		$pdf->Output($path.$filename.'.pdf', 'F');
		$this->kpi_generate_model->new_file($filename.'.pdf', $output_id);
		
		write_file($path.$filename.'.txt', $text);
		$this->kpi_generate_model->new_file($filename.'.txt', $output_id);
		
		$this->kpi_generate_model->publish($output_id);
		
		$this->new_report_update($output_id);
		
		$this->load->helper('url');
		redirect('reports', 'refresh');
	}
	
	public function new_report_update($output_id){
		$output = $this->kpi_generate_model->get_output($output_id);
		$val = "New Report Generated: ".$output['output_name'];
		$update_id = $this->updates_model->add_update("'".$val."'", $this->session->userdata['user_id']);
		$output_iscus = $this->kpi_generate_model->get_output_iscus($output_id);
		$output_accounts = $this->kpi_generate_model->get_output_accounts($output_id);
		foreach($output_iscus as $iscu){
			foreach($output_accounts as $account){
				$this->updates_model->add_update_iscu_account($update_id, $iscu['iscu_id'], $account['accounts_id']);
			}
		}
		
		$this->updates_model->add_update_iscu_account($update_id, 1, 1); // 1,1 for superuser
		$this->updates_model->add_update_iscu_account($update_id, 1, 4); // 1,4 for boss
		// $this->updates_model->update_to_all($update_id);
	}
	
	public function reports(){
		$user_id = $this->session->userdata['user_id'];
		$account_id = $this->session->userdata['account_id'];
		$iscu_id = $this->session->userdata['iscu_id'];
		
		if($user_id==''){
			echo "403 Forbidden";
		}
		else{
			$data['reports'] = $this->kpi_generate_model->get_all_done_output($user_id, $account_id, $iscu_id);
			$data['reports'] = array_reverse($data['reports']);
			$data['account'] = $account_id;
			
			if($account_id==5)
				$navname = "user";
			else if($account_id==1)
				$navname = "superuser";
			else if($account_id==3)
				$navname = "auditor";
			
			$this->load->view('generate/head');
			// $this->load->view('generate/header');
			$this->load->view('kpi/header');
			$this->load->view('kpi/banner');
			$this->load->view('kpi/navbar_'.$navname);
			$this->load->view('generate/reports',$data);
			$this->load->view('generate/footer');
		}
	}
	
	public function report($output_id){
		$user_id = $this->session->userdata['user_id'];
		$account_id = $this->session->userdata['account_id'];
		$iscu_id = $this->session->userdata['iscu_id'];
		
		$output_accounts = $this->kpi_generate_model->get_output_accounts($output_id);
		$output_iscus = $this->kpi_generate_model->get_output_iscus($output_id);
		$output_user = $this->kpi_generate_model->get_output_user($output_id);
		$output = $this->kpi_generate_model->get_output($output_id);
		$forbidden = true;
		if($output_user['user_id']==$user_id || $account_id==4 || $account_id==1 || $output['is_public']==1)
			$forbidden = false;
		else{
			foreach($output_iscus as $iscu){
				if($iscu['iscu_id']==$iscu_id){
					foreach($output_accounts as $account){
						if($account['account_id']==$account_id){
							$forbidden = false;
							break;
						}
					}
				}
				if(!$forbidden){
					break;
				}
			}
		}
		if($forbidden){
			echo "403 Forbidden";
		}
		else{
			if($output['output_type']!=1){
				$hc = $this->load_highchart($output_id);
				$subkpis = [];
				foreach($hc[1] as $crumb){
					array_push($subkpis, $crumb[0]);
				}
				$data['highchart'] = $hc[0];
				$data['subkpis'] = $subkpis;
			}
			
			$data['output'] = $output;		
			
			$data['output_accounts'] = $this->kpi_generate_model->get_output_accounts($output_id);
			$data['output_iscus'] = $this->kpi_generate_model->get_output_iscus($output_id);
			$data['iscus'] = $this->kpi_generate_model->get_all_iscus();
			$data['accounts'] = $this->kpi_generate_model->get_all_accounts();
			$data['user'] = $this->kpi_generate_model->get_output_user($output_id);		
			
			$this->load->view('generate/head');
			// $this->load->view('generate/header');
			$this->load->view('kpi/header');
			if($user_id!=''){
				$this->load->view('kpi/banner');
				$this->load->view('kpi/navbar_superuser');
			}
			$this->load->view('generate/report',$data);
			$this->load->view('generate/footer');
		}
	}
	
	public function changevisibleto($output_id){
		$iscus = $this->kpi_generate_model->get_all_iscus();
		$accounts = $this->kpi_generate_model->get_all_accounts();
		$iscus_included = [];
		$accounts_included = [];
		$this->kpi_generate_model->delete_all_output_iscus($output_id);
		$this->kpi_generate_model->delete_all_output_accounts($output_id);
		if (isset($_POST['checkpublic']))
			$this->kpi_generate_model->update_output_is_public($output_id, 1);
		else
			$this->kpi_generate_model->update_output_is_public($output_id, 0);
		foreach($iscus as $iscu){
			$postname = 'checkiscu'.$iscu['iscu_id'];
			if (isset($_POST[$postname]))
			{
				$this->kpi_generate_model->new_output_iscu($iscu['iscu_id'], $output_id);
			}
		}
		foreach($accounts as $account){
			echo $account['account_name'];
			$postname = 'checkaccount'.$account['account_id'];
			if (isset($_POST[$postname]))
			{
				$this->kpi_generate_model->new_output_account($account['account_id'], $output_id);
			}
		}
		
		//boss
		$this->kpi_generate_model->new_output_account(4, $output_id);
		
		//superuser
		$this->kpi_generate_model->new_output_account(1, $output_id);
		redirect(site_url().'/report/'.$output_id);
	}
	
	public function publicreports(){
		$data['reports'] = $this->kpi_generate_model->get_all_public_output();
		$data['reports'] = array_reverse($data['reports']);
		
		$this->load->view('generate/head');
		// $this->load->view('generate/header');
		$this->load->view('generate/reports',$data);
		$this->load->view('generate/footer');
	}
}