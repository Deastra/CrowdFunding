<?php 
	include('../auth.php');

?>

<?php  

	ini_set('display_errors', 0);
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "crowd";
	$link=mysqli_connect($servername,$username,$password,$dbname);	

	if(!$link){
		die("Connection Failed:: ".mysqli_connect_error());
	}
	mysqli_set_charset($link,"utf8");
	$logEmail=$_SESSION["email"];
	$logUser=$_SESSION["user"];
	$project=$_GET["project"];

	## CHECK PROJECT
	$check_project_query="SELECT * from projects_investors where idProject=$project and idUser=$logUser ";
	$check_res=mysqli_num_rows(mysqli_query($link,$check_project_query));
	$check_own_project_query="SELECT idProject from projects where idUser=$logUser";
	$check_res1=mysqli_query($link,$check_own_project_query);
	$flag=0;
	
	while($row=mysqli_fetch_array($check_res1)){
		if($row["idProject"]=="$project"){
			$flag=1;
		}	
	}
	// echo $flag;
	if($check_res>0){
		header("Location: ../details.php?project=$project");
	}else if($flag==1){
		header("Location: ../main.php");
	}
	



?>
<!DOCTYPE html>
<html>
<head>

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
	 <link rel="stylesheet" href="../jquery/jquery-ui.min.css">
  	<script src="../jquery/external/jquery/jquery.js"></script>
  	<script src="../jquery/jquery-ui.min.js"></script>
	<meta charset="utf-8">
	<title>INVEST</title>
</head>
<body>

	<?php 
		$query="SELECT * from projects where idProject=$project";
		$projects=mysqli_query($link,$query);
		$row=mysqli_fetch_array($projects);
		$start=$row["projectStartDate"];
		$end=$row["projectEndDate"];
		$fund=$row["requestedFund"];	
		$project_name=$row["projectName"];	
	 ?>
	
	<?php 
		if(isset($_POST["submit"])){

			$invest = $_POST["invest"];
        	$date=$_POST["date"]	;

        	$query="INSERT INTO projects_investors(idUser,idProject,investmentFund,investmentDate) values('$logUser','$project','$invest','$date');";
			mysqli_query($link,$query);
			header("Location: ../details.php?project=$project");	
  		}
	 ?>
	<script>
		$(document).ready(function () {
		    $("#datepicker").datepicker({
		        showButtonPanel: true,
			    changeMonth: true,
			    changeYear: true,
			    firstDay: 1,		   
			    dateFormat: "yy-m-d",
			     <?php 
			     	echo "minDate: new Date('$start'),";
				    echo "maxDate: new Date('$end')";
			      ?>
		    });
		});
	</script>

	<?php 
		$total_query="SELECT idProject,SUM(investmentFund) as total from projects_investors where idProject=$project group by idProject";
		$total=mysqli_fetch_array(mysqli_query($link,$total_query))["total"];
		$max=$fund-$total;

	 ?>

	<div class="limiter">
		<div class="container-login100" style="background-image: url('images/bg-01.jpg');">
			<div class="wrap-login100">
				<form class="login100-form validate-form" method="post" >
					<span class="login100-form-logo">
						<i class="zmdi zmdi-money"></i>
					</span>

					<span class="login100-form-title p-b-34 p-t-27">
						INVEST TO <?php echo "<br>'$project_name'";?>
					</span>
					<div class="wrap-input100 validate-input" data-validate = "Enter username">
						<input class="input100" type="number" step="0.01" name="invest" id="invest" <?php echo "max=$max" ?> min=0.01 placeholder="Amount of Invest" required>
						
						<span class="focus-input100 fas fa-dollar-sign" data-placeholder="&#xf108;"></span>					
					</div>			
					<div class="wrap-input100 validate-input">
						<input class="input100" type="text" id="datepicker" name="date" placeholder="Date" required>
						<span class="focus-input100" data-placeholder="&#xf331;"></span>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn" type="submit" name="submit">
							Invest
						</button>
					</div>
					<br>
					<div class="container-login100-form-btn">
						<button type="button" class="login100-form-btn" onclick="location.href='../main.php';"> Back</button>
						
						
					</div>
				</form>
			</div>
		</div>
	</div>

	<?php 
		require_once("../plot.php");
		pie($link,$project);
	 ?>
 	<footer class="bg-light text-center text-lg-start">
	  <!-- Copyright -->
	  <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
	   © Gismat Salimov && Mirali Rahimov:
	    <a class="text-dark" href="../main.php">Crowd Funding</a>
	  </div>
	  <!-- Copyright -->
	</footer>
</body>
</html>  