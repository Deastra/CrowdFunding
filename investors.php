<?php 
	include('auth.php');

 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<title>INVESTORS</title>

</head>
<body>
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
		$email=$_SESSION["email"];
		
		$idProject=$_GET['id'];
		
		
	?>
	<input type="button" class="btn btn-outline-secondary mx-3 my-2" onclick="location.href='my_projects.php';" value="Back" />
	<input type="button" class="btn btn-outline-dark mx-3 my-2" onclick="location.href='main.php';" value="Home" />


	<?php 
		$query="SELECT idUser,firstname,lastname,email,investmentFund,investmentDate from projects_investors join users using (idUser) where idProject='$idProject'";
		
		$invests=mysqli_query($link,$query);
		$row=mysqli_num_rows($invests);

		echo "<table class='table table-error table-striped table-hover table-bordered'>";
		echo "<thead class=\"table-warning\">"; 
	        echo "<tr>";  
	        echo "<th>#</th>";
	        echo "<th>UserID</th>"; 
	        echo "<th>First Name</th>"; //firstName
	        echo "<th>Last Name</th>"; //lastName
	        echo "<th>Email</th>"; //email
	        echo "<th>Investment</th>"; //requestedFund
	        echo "<th>Investment Date</th>";
	        echo "</tr></thead>";

	        $row_n=1;
			while ($row=mysqli_fetch_array($invests)){
				echo "<tr>";
	    		echo "<td>",$row_n,"</td>";
	    		echo "<td>",$row["idUser"],"</td>";
				echo "<td>",$row["firstname"],"</td>";
				echo "<td>",$row["lastname"],"</td>";
				echo "<td>",$row["email"],"</td>";
				echo "<td>",$row["investmentFund"],"</td>";
				echo "<td>",$row["investmentDate"],"</td>";
				echo "</tr>";
				$row_n++;
			}
		echo "</table>";

		require_once('plot.php');
		pie_project($idProject,$link);		

	 ?>
	<footer class="bg-light text-center text-lg-start">
	  <!-- Copyright -->
	  <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
	   © Gismat Salimov:
	    <a class="text-dark" href="main.php">Crowd Funding</a>
	  </div>
	  <!-- Copyright -->
	</footer>

</body>
</html>