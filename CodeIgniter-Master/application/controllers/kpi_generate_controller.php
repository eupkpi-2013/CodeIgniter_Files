<?php
class kpi_generate_controller extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('kpi_generate_model');
	}

	public function index()
	{	
	}
	
	public function generate($output_id){
		$data['kpis'] = $this->kpi_generate_model->get_parent_kpis();
		$data['subkpis'] = $this->kpi_generate_model->get_sub_kpis();
		$data['metrics'] = $this->kpi_generate_model->get_all_metrics();
		$data['results'] = $this->kpi_generate_model->get_all_results();
		$data['iscus'] = $this->kpi_generate_model->get_all_iscus();
		$data['accounts'] = $this->kpi_generate_model->get_all_accounts();
		$data['output_types'] = $this->kpi_generate_model->get_output_types();
		
		if($output_id == "null"){
			$undone_output = $this->kpi_generate_model->get_all_not_done_output(0);
			foreach($undone_output as $output){
				$this->kpi_generate_model->delete_all_output_rels($output['output_id']);
				$this->kpi_generate_model->delete_output($output['output_id']);
			}
		}
		
		else if($output_id != "null"){
			$data['output'] = $this->kpi_generate_model->get_output($output_id);
			$data['output_fields'] = $this->kpi_generate_model->get_output_fields($output_id);
			$data['output_results'] = $this->kpi_generate_model->get_output_results($output_id);
			$data['output_accounts'] = $this->kpi_generate_model->get_output_accounts($output_id);
			$data['output_iscus'] = $this->kpi_generate_model->get_output_iscus($output_id);
		}
		$this->load->view('generate/head');
		$this->load->view('generate/header');
		$this->load->view('generate/content-generate',$data);
		$this->load->view('generate/footer');
	}
	
	public function generated()
	{	$metrics = $this->kpi_generate_model->get_all_metrics();
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
			$output_id = $this->kpi_generate_model->new_output($_POST['name'],$_POST['description'],$_POST['charttype'],$is_public,1);
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
		$hc = $this->load_highchart($output_id);
		
		$data['subkpis'] = $subkpis_included;
		$data['highchart'] = $hc[0];
		$data['output'] = $this->kpi_generate_model->get_output($output_id);
		
		$this->load->view('generate/head');
		$this->load->view('generate/header');
		$this->load->view('generate/content-generate-preview', $data);
		$this->load->view('generate/footer');
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
		$js = '<script type="text/javascript">';
		$js = $js.'$(function () {';
		foreach($crumbs_included as $subkpi){
			$js = $js.'$("#container'.$subkpi[0]['kpi_id'].'").highcharts({';
			$js = $js.'chart: {
					type: "column"
					},
					title: {
					text: "'.$subkpi[1]['kpi_name'].">".$subkpi[0]['kpi_name'].'"
					},
					subtitle: {
						text: ""
					},
					xAxis: {
					categories: [';
				foreach($fields_included as $field){
					$f = $this->kpi_generate_model->get_field($field['field_id']);
					if($subkpi[0]['kpi_id']==$f['kpi_id']){
						$js = $js.'"'.$f['field_name'].'", ';
					}					
				}           
					$js = $js.']
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
			foreach($results_included as $result){
				$js = $js.'{ name: "'.$result['results_name'].'", data: [ ';
				foreach($fields_included as $field){
					$f = $this->kpi_generate_model->get_field($field['field_id']);
					if($subkpi[0]['kpi_id']==$f['kpi_id']){
						$value = $this->kpi_generate_model->get_field_values($result['results_id'],[$f['field_id']]);
						$js = $js.$value[0]['value'].', ';
					}
				}
				$js = $js.']},';
			}
				$js = $js.']
						});';
		}
		$js = $js.'});';
		$js = $js.'</script>';
		return [$js,$crumbs_included];
	}
	
	public function load_highchart_line($output_id){
		$fields_included = $this->kpi_generate_model->get_output_fields($output_id);
		$crumbs_included = $this->get_breadcrumbs($output_id, $fields_included);
		$results_included = $this->kpi_generate_model->get_output_results($output_id);
		$js = "<script>
				$(function () {";
		foreach ($crumbs_included as $subkpi){
			$js = $js."$('#container".$subkpi[0]['kpi_id']."').highcharts({
				chart: {
					type: 'line',
					marginRight: 130,
					marginBottom: 25
				},
				title: {
					text: \"".$subkpi[1]['kpi_name'].">".$subkpi[0]['kpi_name']."\",
					x: -20 //center
				},
				subtitle: {
					text: '',
					x: -20
				},
				xAxis: {
					categories: [";
					foreach($results_included as $result){
						$js = $js."\"".$result['results_name']."\", ";
					}
				$js = $js."]
				},
				yAxis: {
					title: {
						text: 'Temperature (°C)'
					},
					plotLines: [{
						value: 0,
						width: 1,
						color: '#808080'
					}]
				},
				tooltip: {
					valueSuffix: '°C'
				},
				legend: {
					layout: 'vertical',
					align: 'right',
					verticalAlign: 'top',
					x: -10,
					y: 100,
					borderWidth: 0
				},
				series: [";
					 foreach($fields_included as $field){
						if($subkpi[0]['kpi_id']==$field['kpi_id']){
							$js=$js."{
									name: \"".$field['field_name']."\", ";
							$js=$js."data: [";
							foreach($results_included as $result){							
								$value = $this->kpi_generate_model->get_field_values($result['results_id'],[$field['field_id']]);
								$js=$js.$value[0]['value'].", ";
							}
							$js=$js."]}, ";
						}
					 }
				$js=$js."]
						});";
			}			
		$js = $js."});
		</script>";
		return [$js,$crumbs_included];
	}
	
	public function info_file($output_id){	
		$output = $this->kpi_generate_model->get_output($output_id);
		$del = "\t";
		$info_file = "Output:"."(".$output_id.")".$output['output_name']."\n";
		$results_included = $this->kpi_generate_model->get_output_results($output_id);
		$field_included = $this->kpi_generate_model->get_output_fields($output_id);
		// $info_file = $info_file."result/s included:";
		$counter = 0;
		$info_file=$info_file."\n";
		$info_file=$info_file."KPI".$del."SubKPI".$del."Metric".$del;
		foreach($results_included as $result){
			//echo $result;
			if($counter>0)
				$info_file = $info_file.$del;
			$info_file=$info_file."(".$result['results_id'].")".$result['results_name'];
			$counter++;
		}
		$info_file=$info_file."\n";
		foreach($field_included as $field){
			$values=$this->kpi_generate_model->get_output_field_values($output_id,$field['field_id']);
			$breadcrumbs = $this->kpi_generate_model->get_breadcrumbs($field['field_id']);
			$counter = 0;
			foreach($breadcrumbs as $bc){
				if($counter>0)
					$info_file = $info_file.$del;
				$info_file=$info_file."(".$bc['kpi_id'].")".$bc['kpi_name'];
				$counter++;
			}
			$info_file=$info_file.$del;
			$info_file=$info_file."(".$field['field_id'].")".$field['field_name'].":";
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
		$info_file=$info_file."--endoffile--";
		
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
		$pdf->SetFont('Arial','',11);
		$pdf->Write(10,$text);
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
		
		$this->load->helper('url');
		redirect('reports', 'refresh');
	}
	
	public function reports(){
		$data['reports'] = $this->kpi_generate_model->get_all_done_output(0);
		$data['reports'] = array_reverse($data['reports']);
		
		$this->load->view('generate/head');
		$this->load->view('generate/header');
		$this->load->view('generate/reports',$data);
		$this->load->view('generate/footer');
	}
	public function report($output_id){
		$output = $this->kpi_generate_model->get_output($output_id);
		$hc = $this->load_highchart($output_id);
		$subkpis = [];
		foreach($hc[1] as $crumb){
			array_push($subkpis, $crumb[0]);
		}
		
		$data['output'] = $output;
		$data['highchart'] = $hc[0];
		$data['subkpis'] = $subkpis;
		$data['output_accounts'] = $this->kpi_generate_model->get_output_accounts($output_id);
		$data['output_iscus'] = $this->kpi_generate_model->get_output_iscus($output_id);
		$data['iscus'] = $this->kpi_generate_model->get_all_iscus();
		$data['accounts'] = $this->kpi_generate_model->get_all_accounts();
		$data['user'] = $this->kpi_generate_model->get_output_user($output_id);		
		
		$this->load->view('generate/head');
		$this->load->view('generate/header');
		$this->load->view('generate/report',$data);
		$this->load->view('generate/footer');
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
	}
}