<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Sayvers | Admin</title>
    <link rel="shortcut icon" href="<?php echo  base_url('images/sayver_logo.png'); ?>">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	<style>
		@import url('https://fonts.googleapis.com/css2?family=PT+Sans&display=swap');
        body{
            font-family: 'PT Sans', sans-serif;
            font-size: 15px;
        }
		.p_20{
			margin-top: 20vh;
		}
		.login_message{
			font-size: 12px;
			width: 200px;
		}
		.form-control:focus {
			color: #495057;
			background-color: #fff;
			border-color: #2F55D4;
			outline: 0;
			box-shadow: none;
		}
		input[type=checkbox], input[type=radio] {
			border: 1px solid #ced4da;
		}
		.field_error{
            font-size: 10px;
        }
		.checkbox-label{
			font-size: 13px;
		}
		.form-check-input {
			font-size: 10 ;
		}
		.btn-block{
			background-color: #2F55D4;
		}
		.foter-text{
			font-size: small;
		}
	</style>
    <title>Sayvers | Admin</title>
  </head>
  <body class="text-center">
	<div class="container">
	<div class="row">
		<div class="col-md-4 col-sm-8  mx-auto p_20">
			<div class="card card-block p-5">
				<form class="form-signin" action="<?php echo base_url(); ?>admin/process_login" method="POST">
					<h5 class="mb-3 font-weight-normal">Admin Login</h5>
					<?php if(isset($this->session->message)){
							echo '<div class="alert-danger mx-auto login_message  text-center mb-3">'.$this->session->message.'</div>';
							unset($_SESSION['message']);
						}
                    ?>
					<div class="form-group">
						<label for="username" class="sr-only">Email address</label>
						<input type="text" id="username" name="username" class="form-control" placeholder="Username"  value="<?php echo set_value('username'); ?>">
						<div class="text-danger text-left ml-1 field_error"><?php echo form_error('username'); ?></div>
					</div>
					<div class="form-group">
						<label for="password" class="sr-only">Password</label>
						<input type="password" id="password" name="password" class="form-control" placeholder="Password" >
						<div class="text-danger text-left ml-1 field_error"><?php echo form_error('password'); ?></div>

					</div>

					<div class="mb-3">
					<div class="form-check text-left">
						<input type="checkbox" class="form-check-input " id="remember_me">
						<label class="form-check-label checkbox-label" for="remember_me">Remember Me</label>
					</div>
					</div>
					<button class="btn btn-md btn-primary btn-block" type="submit">Login</button>
				</form>
			</div>
			
		</div>
	</div>
	<div class="row">
		<!-- Footer -->
		<footer class="mx-auto text-center">
		<!-- Copyright -->
		<div class="text-secondary pt-5 foter-text">
			© 2020 Copyright:
			<span>Sayvers</span>
		</div>
		<!-- Copyright -->
		</footer>
		<!-- Footer -->

	</div>
		
	</div>
	
  

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  </body>
</html>

