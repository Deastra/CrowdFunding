<?php
// Start the session
	session_start();
	session_destroy();
	session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login Crowd Funding</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	<?php  
		ini_set('display_errors', 1);
		$servername = "mysql-gismat.alwaysdata.net";
		$username = "gismat";
		$password = "deastra333";
		$dbname = "gismat_crowd";

		$link=mysqli_connect($servername,$username,$password,$dbname);	

		if(!$link){
			die("Connection Failed:: ".mysqli_connect_error());
		}
		mysqli_set_charset($link,"utf8");
	?>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt style="will-change: transform; transform: perspective(300px) rotateX(0deg) rotateY(0deg);">
					<img src="images/img-01.png" alt="IMG">
				</div>

				<form class="login100-form validate-form" method="post">
					<span class="login100-form-title">
						Member Login
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" type="text" name="email" placeholder="Email">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="password" name="psw" placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<input type="submit" name="submit" class="login100-form-btn" value="Login">

					</div>

					<div class="text-center p-t-136">
					</div>
				</form>



    
   <?php 
	  		if(isset($_POST["submit"])){
	  				
				$email = $_POST["email"];
	        	$psw = $_POST["psw"];
	        	
	        	$query="SELECT * from users where email='$email' and password= '$psw'";
	        	$user=mysqli_query($link,$query);

	        	$row=mysqli_num_rows($user);
				
	        	if ($row==1){
	        		$row=mysqli_fetch_array($user);
	        		$_SESSION["user"] = $row["idUser"];
		        	$_SESSION["email"] = $_POST["email"];
					$_SESSION["psw"] = $_POST["psw"];	
					header("Location: main.php");		
	        	}else{
	        		echo "<a class='txt2' >
							<p style='color:blue;font-size:18px;' >!!!Email or Password is incorrect!!!</p>
						</a>";
	        	}

	  		}

	 ?>
	 			</div>
		</div>
	</div>
	
	<footer class="bg-light text-center text-lg-start">
	  <!-- Copyright -->
	  <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
	   © Gismat Salimov && Mirali Rahimov:
	    <a class="text-dark" href="main.php">Crowd Funding</a>
	  </div>
	  <!-- Copyright -->
	</footer>
	
<!--===============================================================================================-->	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>




</body>
</html>