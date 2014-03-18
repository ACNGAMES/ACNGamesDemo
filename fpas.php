<?php  
?>
<!DOCTYPE html>
<!-- saved from url=(0040)http://getbootstrap.com/examples/signin/ -->

<html>
	<head>
		<title>Bootstrap 2.0 Modal Demo</title>
		<link href="css/bootstrap2.css" rel="stylesheet">
	<link href="css/modern-business.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="http://getbootstrap.com/examples/signin/signin.css" rel="stylesheet">
		<script src="js/head.min.js"></script>
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap-transition.js"></script>
		<script src="js/bootstrap-modal.js"></script>
		</head>
	<body>
		<div >
			<h1>Bootstrap 2.0 Modal Demo</h1>
				<div id="windowTitleDialog" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="windowTitleLabel" aria-hidden="true">
				<div class="modal-header">
					<a href="#" class="close" data-dismiss="modal">&times;</a>
					<h3>Por favor ingrese su enterprise id para blanquear su contraseña.</h3>
					</div>
				<div class="modal-body">
					<div class="divDialogElements">
						<input class="xlarge" id="xlInput" name="xlInput" type="text" />
						</div>
					</div>
				<div class="modal-footer">
					<a href="#" class="btn" onclick="closeDialog ();">Cancel</a>
					<a href="#" class="btn btn-primary" onclick="okClicked ();">OK</a>
					</div>
				</div>
			<div class="divButtons">
				<a data-toggle="modal" href="#windowTitleDialog" class="btn btn-primary btn-large">Set Window Title</a>
				</div>
		
			</div>
		</body>


  
