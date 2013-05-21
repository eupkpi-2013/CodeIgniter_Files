<?php
class file_controller extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('filetest_model');
	}

		public function index()
{
		// $data['text'] = $this->filetest_model->get_all();
		$data['text'] = $this->filetest_model->get_kpis();
		$this->load->view('files/files', $data);
}

		public function writepdf($text)
{
		$this->load->library('fpdf17/fpdf');
	
		// class pdf extends FPDF{
		// function Header()
		// {
			// // Arial bold 15
			// $this->SetFont('Arial','B',15);
			// // Title
			// $this->Cell(30,10,'eUP KPI - After 6 Months');
			// // Line break
			// $this->Ln(10);
		// }
		// function Footer()
		// {
			// // Position at 1.5 cm from bottom
			// $this->SetY(-15);
			// // Arial italic 8
			// $this->SetFont('Arial','I',8);
			// // Page number
			// $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
		// }
		// }
		
		$pdf = new FPDF();
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetFont('Arial','',11);
		$pdf->Write(10,$text);
		// $data['text'] = $this->filetest_model->get_kpis();
		// foreach($data['text'] as $textentry){
			// $pdf->Write(10, $textentry['kpi_name']);
			// $pdf->Ln();
		// }
		// $pdf->Output("./application/views/files/testpdf.pdf", 'F');
		$pdf->Output();
		// $this->load->view('files/pdf_writer');
}
		public function loadpdf(){	
			$filename = "testpdf.pdf";
			$this->load->helper('download');
	
			$data = file_get_contents('./application/views/files/'.$filename); 
			force_download($filename, $data);
		}
		
		public function writeexcel()
		{
		$data['kpis'] = $this->filetest_model->get_kpis();
		
		//load our new PHPExcel library
		$this->load->library('excel');
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('test worksheet');
		//set cell A1 content with some text
		//$this->excel->getActiveSheet()->setCellValue('A1', 'This is just some text value');
		
		$counter = 2;
		foreach($data['kpis'] as $kpi){
			$this->excel->getActiveSheet()->setCellValue('A'.$counter, $kpi['kpi_name']);
			$counter = $counter + 1;
			// echo $kpi['kpi_name'];
		}
		
		//change the font size
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
		//make the font become bold
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		//merge cell A1 until D1
		$this->excel->getActiveSheet()->mergeCells('A1:D1');
		//set aligment to center for that merged cell (A1 to D1)
		$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		 
		$filename='Book1.xls'; //save our workbook as this file name
		//header('Content-Type: application/vnd.ms-excel'); //mime type
		//header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		//header('Cache-Control: max-age=0'); //no cache
					 
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save($filename);		
		$this->load->view('files/excel_writer');
		}

		public function readexcel(){
			$this->load->library('excel');
			/** Include path **/
			set_include_path('C:\xampp\htdocs\CodeIgniter\application\third_party\\');

			/** PHPExcel_IOFactory */
			include 'PHPExcel/IOFactory.php';

			$inputFileName = './application/views/files/Book1.xlsx';
			$inputFileType = 'Excel2007';
			echo 'Loading file ',pathinfo($inputFileName,PATHINFO_BASENAME),' using IOFactory to identify the format<br />';
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			$objReader->setReadDataOnly(true);
			$objPHPExcel = $objReader->load($inputFileName);


			echo '<hr />';

			$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			// echo $sheetData;
			var_dump($sheetData);			
		
		}
		
		public function loadexcel(){
			$this->load->view('files/excel_writer');
		
		}
}