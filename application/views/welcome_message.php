<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Time Sheet | Kirk</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/style.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/print.css" media="print">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
		<script src="<?php echo base_url() ?>assets/js/script.js"></script>
	</head>
	<body>
		<div class="container-fluid">
			<h1>Time Sheet</h1>
			<form action="#" class="form-horizontal">
				<input type="hidden" id="base_url" value='<?php echo base_url(); ?>' />
				<input type="hidden" id="credential" value='<?php echo json_encode(KIRK_CREDENTIAL) ?>' />
				<div class="form-group">
					<label class="control-label col-md-2 text-left">BUSINESS NAME</label>
				</div>
				<div class="form-group">
					<label class="control-label col-md-2 text-left">PAYROLL HOURS SUMMARY</label>
				</div>
				<div class="form-group">
					<label class="control-label float-left text-left">PAYROLL PERIOD ENDING:</label>
					<div class="col-md-2 col-sm-2 col-xs-2">
						<input type="text" class="form-control datepicker">
					</div>
				</div>
			</form>
			<div class="text-right">
				<button class="btn btn-success" onClick="add_row();">Add Employee</button>
				<button class="btn btn-primary" onClick="save_rows();">Save</button>
			</div>
			<table class="table table-bordered table-striped" id="time_table">
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
						<th> ** </th>
					</tr>
				</thead>
				<tbody>
				<?php
					for ($i = 0; $i < 5; $i ++) {
						echo '
						<tr>
							<td contenteditable></td>
							<td contenteditable></td>
							<td contenteditable></td>
							<td class="edit-item" contenteditable></td>
							<td class="edit-item" contenteditable></td>
							<td class="edit-item" contenteditable></td>
							<td class="edit-item" contenteditable></td>
							<td class="edit-item" contenteditable></td>
							<td class="edit-item" contenteditable></td>
							<td class="edit-item" contenteditable></td>
							<td class="edit-item" contenteditable></td>
							<td class="edit-item" contenteditable></td>
							<td class="total_hrs"></td>
							<td contenteditable></td>
							<td class="need_hide"><a href="javascript:void(0);" class="remove_tr"><i class="glyphicon glyphicon-trash"></i></a></td>
						</tr>';
					}
				?>				
				</tbody>
			</table>
			<div class="row">
				<div class="col-md-1">Approved By</div>
				<div class="col-md-4 sign"></div>
				<div class="col-md-2 text-center">
					<button class="btn btn-lg btn-success" id="approve_modal_btn">Approve</button>
				</div>
			</div>
			<div class="row" id="action_wrapper">
				<div class="col-md-1"><button class="btn btn-lg btn-danger" id="reset_btn">RESET</button></div>
				<div class="col-md-offset-10 col-md-1"><button class="btn btn-lg btn-primary" id="report_btn">Submit</button></div>
			</div>
		</div>
		<div id="password_modal" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Authentication</h4>
					</div>
					<div class="modal-body">
						<form class="modal-form">
							<div class="form-group">
								<label for="email">Enter your password:</label>
								<input type="password" class="form-control" id="password">
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button class="btn btn-success" id="approve_btn">Approve</button>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>