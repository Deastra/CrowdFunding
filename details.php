<?php 
	include('auth.php');
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
	if($flag==1){
		header("Location: investors.php?id=$project");
	}else if($check_res==0){
		header("Location: main.php");
	}
		
?>
 <!DOCTYPE html>
 <html>
 <head>
 	<meta charset="utf-8">
 	<title>Project Investment Details</title>
 </head>
 <body>
	<input type="button" class="btn btn-outline-secondary mx-3 my-2" onclick="location.href='main.php';" value="Back" />
	<?php 
		$query="SELECT firstname,lastname,projectName,requestedFund,investmentFund,projectDescription, projectStartDate,projectEndDate,investmentDate from projects_investors join projects using (idProject) join users on users.idUser=projects_investors.idUser where idProject=$project and projects_investors.idUser=$logUser";
		$detail=mysqli_fetch_array((mysqli_query($link,$query)));
		
	  ?>
	  <table border="black 5px" class="table table-info table-stripped table-hover">
	  	<tr class="table-active">
	  		<th>Project ID</th>
	  		<th>Project Name</th>
	  		<th>Project Description</th>
	  		<th>Start Date</th>
	  		<th>End Date</th>
	  		<th>Requested Fund</th>
	  		<th>Investor</th>
	  		<th>Invested Fund</th>
	  		<th>Investment Date</th>
	  	</tr>
	  		<tr>
	  			<?php 
		  		echo "<td>$project</td>";
		  		echo "<td>".$detail["projectName"]."</td>";
		  		echo "<td>".$detail["projectDescription"]."</td>";
		  		echo "<td>".$detail["projectStartDate"]."</td>";
		  		echo "<td>".$detail["projectEndDate"]."</td>";
		  		echo "<td>".$detail["requestedFund"]."</td>";
		  		echo "<td>".$detail["firstname"]." ".$detail["lastname"]."</td>";
		  		echo "<td>".$detail["investmentFund"]."</td>";
	  			echo "<td>".$detail["investmentDate"]."</td>";
	  			 ?>
	  		</tr>


	  </table>
	 
		<?php 
			require_once("plot.php");
			pie2($link,$project,$logUser);
		 ?>
	

	<footer class="bg-light text-center text-lg-start">
	  <!-- Copyright -->
	  <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
	   © Gismat Salimov && Mirali Rahimov:
	    <a class="text-dark" href="main.php">Crowd Funding</a>
	  </div>
	  <!-- Copyright -->
	</footer>

 </body>
 </html>