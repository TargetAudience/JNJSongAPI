<!doctype html>
<html lang="en">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/libs/css/style.css">
    <link rel="stylesheet" href="assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <style>
    html,
    body {
        height: 100%;
    }

    body {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
        background-image: url('assets/images/bg.jpg');  
        background-size: cover;
    } 
    </style>
</head>

<body>
    <!-- ============================================================== -->
    <!-- login page  -->
    <!-- ============================================================== -->
    <div class="splash-container">
        <div class="card ">
            <div class="card-header text-center"><a href="dashboard.php"><img class="logo-img" src="assets/images/logo.png" alt="logo"></a><span class="splash-description">Please enter your user information.</span></div>
            <div class="card-body">
            <div class="card-footer bg-white   ">
            <div class="">	
                     	<div class="alert alert-success" role="alert" id="success_alert"></div>
                  	<div class="alert alert-danger" role="alert" id="error_alert"></div>
                     </div>
            </div>
            <form action="#" class="signin-form" id="signup_form">
                    <div class="form-group">
                        <input class="form-control form-control-lg" name="username" type="text" placeholder="Username" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <input class="form-control form-control-lg" name="password" type="password" placeholder="Password">
                    </div>
                    <!-- <div class="form-group">
                        <label class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox"><span class="custom-control-label">Remember Me</span>
                        </label>
                    </div> -->
                    <input type="hidden" name="login" value="1">
                    <input type="submit"     class="btn btn-primary btn-lg btn-block" value="Sign in">
                </form>
            </div>
            <div class="card-footer bg-white   ">
            
                <!-- <div class="card-footer-item card-footer-item-bordered">
                    <a href="signup.php" class="footer-link">Create An Account</a></div>
                <div class="card-footer-item card-footer-item-bordered">
                    <a href="forget_password.php" class="footer-link">Forgot Password</a>
                </div> -->
            </div>
        </div>
    </div>
  
    <!-- ============================================================== -->
    <!-- end login page  -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <script src="assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <script type="text/javascript">
      	$(document).ready(function(){
      		$('#success_alert').hide();
      		$('#error_alert').hide();
      		$('#signup_form').submit(function(event){
      			event.preventDefault();
      			var datastring = $("#signup_form").serialize();
                // console.log(datastring);
                // return;
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
				    		window.location.replace("dashboard.php");
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