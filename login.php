<?php 
session_start();
if(isset($_SESSION['user_id']) && $_SESSION['user_id'] >0 )
{
	header("Location:index.php");
}
 ?>
<!doctype html>
<html lang="en">
  <head>
  	<title>Please Login Here</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="icon" type="image/x-icon" href="assets/images/youth_favicon.png">
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="assets/login_signup/css/style.css">

	</head>
	<body>
	<section class="ftco-section">
		<div class="container"> 
			<div class="row justify-content-center">
				<div class="col-md-12 col-lg-10">
					<div class="wrap d-md-flex">
						<div class="img" style="background-image: url(assets/login_signup/images/bg-1.jpg);">
			      </div>
						<div class="login-wrap p-4 p-md-5">
			      	<div class="d-flex">
			      		<div class="w-100">
						  <img src="assets/images/youth_favicon.png" alt="" style="width: 64px; margin-bottom: 25px;text-align: center;margin-left: 75%;">
			      			<h3 class="mb-4">Sign In</h3>
			      		</div>
								<div class="w-100">
									<p class="social-media d-flex justify-content-end">
										<!-- <a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-facebook"></span></a>
										<a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-twitter"></span></a> -->
									</p>
								</div>
			      	</div>
							<form action="#" class="signin-form" id="signup_form">
			      		<div class="form-group mb-3">
			      			<label class="label" for="name">Email</label>
			      			<input type="email" name="email" class="form-control" placeholder="Email" required>
			      		</div>
		            <div class="form-group mb-3">
		            	<label class="label" for="password">Password</label>
		              <input type="password" name="password" class="form-control" placeholder="Password" required>
		            </div>
		            <input type="hidden" name="login" value="1">
		            <div class="form-group">
		            	<button type="submit" class="form-control btn btn-primary rounded submit px-3">Sign In</button>
		            </div>
		            <div class="form-group d-md-flex">
		            	<div class="w-50 text-left">
			            	<!-- <label class="checkbox-wrap checkbox-primary mb-0">Remember Me
									  <input type="checkbox" checked>
									  <span class="checkmark"></span>
										</label>
									</div>
									<div class="w-50 text-md-right">
										<a href="#">Forgot Password</a>
									</div> -->
		            </div>
		          </form>
		          <p class="text-center">Not a member? <a href="signup.php">Sign Up</a></p>
		        </div>
		        <div class="row w-100">	
                     	<div class="alert alert-success" role="alert" id="success_alert"></div>
                  	<div class="alert alert-danger" role="alert" id="error_alert"></div>
                     </div>
		      </div>
				</div>
			</div>
		</div>
	</section>

		<script src="assets/login_signup/js/jquery.min.js"></script>
	  <script src="assets/login_signup/js/popper.js"></script>
	  <script src="assets/login_signup/js/bootstrap.min.js"></script>
	  <script src="assets/login_signup/js/main.js"></script>
<script type="text/javascript">
      	$(document).ready(function(){
      		$('#success_alert').hide();
      		$('#error_alert').hide();
      		$('#signup_form').submit(function(event){
      			event.preventDefault();
      			var datastring = $("#signup_form").serialize();
				$.ajax({
				    type: "POST",
				    url: "ajax.php",
				    data: datastring,
				    dataType: "json",
				    success: function(response) {
				    	if(response.response==1){
				    		$('#error_alert').hide();
				    		$('#success_alert').show();
				    		$('#success_alert').html(response.message);
				    		$("#reset").click();
				    		window.location.replace("index.php");
				    	}
				    	if(response.response==0){
				    		$('#success_alert').hide();
				    		$('#error_alert').show();
				    		$('#error_alert').html(response.message);
				    	}
				        
				    },
				    error: function() {
				        // alert('error handling here');
				        $('#success_alert').hide();
			    		$('#error_alert').show();
			    		$('#error_alert').html("Error Occured Try Again!!!");
				    }
				});
      		})
      	})
      </script>
	</body>
</html>

