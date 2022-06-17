<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function sendEmail() {
		$date = $this->input->post('date');
		$img = $this->input->post('img');
		$tbl_data = $this->input->post('tbl_data');

		$this->load->library('html2pdf');

		//Set folder to save PDF to
		$this->html2pdf->folder('./assets/pdfs/');
		
		//Set the filename to save/download as
		$this->html2pdf->filename('timesheet_' . str_replace('/', '_', $date) . '.pdf');
		
		//Set the paper defaults
		$this->html2pdf->paper('a4', 'landscape');
		
		//Load html view
		$this->html2pdf->html('
		<!DOCTYPE html>
			<html>
				<head>
					<title>Time Sheet | Kirk</title>
					<meta charset="utf-8">
					<meta name="viewport" content="width=device-width, initial-scale=1">
					<link type="text/css" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
				</head>
				<body>
					<div class="container-fluid">
						<h1>Time Sheet</h1>
						<form action="#" class="form-horizontal">
							<div class="form-group">
								<label class="control-label col-md-2 text-left">BUSINESS NAME</label>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2 text-left">PAYROLL HOURS SUMMARY</label>
							</div>
							<div class="form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-2 text-left">PAYROLL PERIOD ENDING:</label>
								<div class="col-md-2 col-sm-2 col-xs-2">' . $date . '</div>
							</div>
						</form>
						<table class="table table-bordered table-striped" id="time_table" style="width: 100%">
							<thead>
								<tr>
									<th>Employee Name</th>
									<th>Dept #</th>
									<th>Emp ID #</th>
									<th>Reg Hrs</th>
									<th>Vac Hrs</th>
									<th>Sick Hrs</th>
									<th>Hol Hrs</th>
									<th>Other Hrs</th>
									<th>Bday Hrs</th>
									<th>Funeral Hrs</th>
									<th>Family Sick Hrs</th>
									<th>Special Leave</th>
									<th>Total Hrs</th>
									<th>Overtime</th>
								</tr>
							</thead>
							<tbody>' . $tbl_data . '</tbody>
						</table>
						<div class="row">
							<div class="col-md-1">Approved By</div>
							<div class="col-md-4 sign"><img src="' . $img . '" style="width: 50%;"></div>
						</div>
					</div>
				</body>
			</html>'
		);

		//Create the PDF
		if ($path = $this->html2pdf->create('save')) {
			
			$config['protocol']='smtp';
			$config['smtp_host']='ssl://smtp.gmail.com';
			$config['smtp_port']='465';
			$config['smtp_timeout']='30';
			$config['smtp_user']='emstimesheet85@gmail.com';
			$config['smtp_pass']='EMST1m3sh33t!';
			$config['charset']='utf-8';

			$this->load->library('email', $config);
			// $this->email->initialize($config);

			$this->email->from('Kirk Officer', 'Officer');
			$this->email->to('seniorweb0417@outlook.com'); // need replace AccountingClerk@emtns.loc
		
			$this->email->subject('Time Sheet');
			$this->email->message('This is time sheet for ' . $date);	
		
			$this->email->attach($path);
		
			echo 'PDF saved to: ' . $path;
			echo $this->email->send();
		} else {
			echo 'Create PDF failed' . $path;
		}
		

        // $msg = $this->load->view('welcome_message', '', true);

		// $this->load->library('email');
		// $config['mailtype'] = 'html';
		// // $config['protocol']='smtp';
		// // $config['smtp_host']='';
		// // $config['smtp_port']='';
		// // $config['smtp_timeout']='';
		// // $config['smtp_user']='';
		// // $config['smtp_pass']='';
		// // $config['charset']='utf-8';
		// // $config['wordwrap'] = TRUE;
		// $this->email->initialize($config);
		// $this->email->from('kirk@freelancer.com', 'Kirk');
		// // $this->email->to('AccountingClerk@emtns.loc');
		// $this->email->to('seniorweb0417@outlook.com');
		// $this->email->message($msg);
		// if (!$this->email->send()) {
		// 	echo 'email send failed';
		// } else {
		// 	echo 'email send successfully.';
		// }
	}
}
