<?php
session_start();
$db = mysqli_connect("localhost:3308", "root", "", "project");
	
   if($_SERVER["REQUEST_METHOD"] == "POST") {
	   
      // username and password sent from form 
      
      $myusername = mysqli_escape_string($db, trim($_POST["email"]));
      $mypassword = mysqli_escape_string($db, trim($_POST["pass"])); 
      
      $sql = "SELECT emp_ID FROM user_inform WHERE LOGIN = '$myusername' and PASSWORD = '$mypassword'";
	  $result = mysqli_query($db, $sql);
      //$result = mysqli_query($db,$sql);
      
      $count = mysqli_num_rows($result);

      if($count == 1) {
        //session_register("myusername");
        $_SESSION['login_user'] = $myusername;
		
		$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$id = $row['emp_ID'];
		$sql = "SELECT e.user_id, e.role_id, r.role_desc FROM employees e inner join roles_ref r on e.role_id=r.role_id where e.user_id = $id";
		$result = mysqli_query($db, $sql);
		$rolerow = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$role = $rolerow['role_desc'];
		$_SESSION['user_id'] = $id;
		if($role == 'Administrator') {
			$_SESSION['perm'] = '1';
			header("location: tables/admin_login.php");
		}else if($role == 'Common employee'){
			$_SESSION['perm'] = '2';
			header("location: tables/emp_current_tasks.php");
		} else if($role == 'Manager'){
			$_SESSION['perm'] = '3';
			header("location: tables/manager_tasks_current.php");
		}
        //header("location: admin.php");
      }else {
         $error = "Your Login Name or Password is invalid";
      }
   }
?>
<!------ Include the above in your HEAD tag ---------->
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form" method="POST">
					<span class="login100-form-title p-b-26">
						Welcome
					</span>
					<span class="login100-form-title p-b-48">
						<i class="zmdi zmdi-font"></i>
					</span>
						<div class="wrap-input100">
							<input class="input100" type="text" name="email">
							<span class="focus-input100" data-placeholder="Login"></span>
						</div>

						<div class="wrap-input100 validate-input" data-validate="Enter password">
							<span class="btn-show-pass">
								<i class="zmdi zmdi-eye"></i>
							</span>
							<input class="input100" type="password" name="pass">
							<span class="focus-input100" data-placeholder="Password"></span>
						</div>
						<div class="container-login100-form-btn">
							<div class="wrap-login100-form-btn">
								<div class="login100-form-bgbtn"></div>
								<button class="login100-form-btn">
									Login
								</button>
							</div>
							<div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
						</div>
						

				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>
