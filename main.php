<?php 
	include('auth.php');
 ?>



 <!DOCTYPE html>
 <html>
 <head>
 	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
 	<meta charset="utf-8">
 	<title>MAIN</title>
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
		$logEmail=$_SESSION["email"];
		$logUser=$_SESSION["user"];

	?>
	<?php 
		$query="SELECT * from users where email='$logEmail'";
		$my_user_q=mysqli_query($link,$query);
		$my_user=mysqli_fetch_array($my_user_q);
		$name=$my_user["firstname"]." ".$my_user["lastname"];
		$idUser=$my_user["idUser"];
	 ?>
	<div>
	 <h3 class="mx-3 my-2" style="display: inline-block;">MY PROFILE</h3>
	 <button type="button" class="btn btn-danger position-absolute top-0 end-0 mx-3 my-3" onclick="location.href='login.php'">Log out</button>
	</div>
	 <div >
		<div class="mx-4 my-2" style=" display:inline-block;">
			<?php  
				echo "<small class=\"text-muted\"><p><b>User ID:: </b>",$idUser," </p></small>";
				echo "<small class=\"text-muted\"><p><b>Full Name:: </b>",$name," </p></small>";
				echo "<small class=\"text-muted\"><p><b>Email:: </b> ",$logEmail," </p></small>";
				
			?>
		</div>
	</div>	
	<?php 

	$my_projects=mysqli_query($link,"SELECT * from projects where idUser=$idUser");
	$row=mysqli_num_rows($my_projects);
	
	if($row==0){
		
		echo "<input type=\"button\" class=\"btn btn-outline-primary mx-4\" onclick=\"location.href='my_projects.php';\" value=\"My Projects\" disabled/>";
	}else{
		
		echo "<input type=\"button\" class=\"btn btn-outline-primary mx-4\" onclick=\"location.href='my_projects.php';\" value=\"My Projects\" />";
	}

	 ?>
	<!-- <a href="my_projects.php" >MY PROJECTS</a> -->
	<hr>
	<?php 
			
		function cehckInvest($id,$user,$link) {
			$invests_query="SELECT idUser from projects_investors where idProject=$id";
			$invests=mysqli_query($link,$invests_query);	
			$row_i=mysqli_num_rows($invests);	

			if ($row_i==0){
				return 1;
			}else{
				while ($row_i=mysqli_fetch_array($invests)){
					if ($user==$row_i["idUser"]){
						return 0;
					}
				}
				return 1;	
			}
			  
		}

		$query="SELECT projects.idProject,projectName,requestedFund,total,firstname,projectStartDate,projectEndDate,idUser,projectDescription
				from projects 
				join users using (idUser) 
				join (SELECT idProject,SUM(investmentFund) as total from projects_investors group by idProject) as invests on projects.idProject=invests.idProject where email!='$logEmail'";
		

		echo "<h4 class='mx-3 my-2'>PROJECTS</h4>";
		$projects=mysqli_query($link,$query);
		$row=mysqli_num_rows($projects);

    	$row_n=1;

    	echo "<table class='table table-striped table-hover'>";
		echo "<thead class=\"table-info\">";
	        echo "<tr>";
	        echo "<th>#</th>";  
	        echo "<th>ID</th>";   
	        echo "<th>Owner</th>"; //firstName
	        echo "<th>Project Name</th>"; //projectName
	        echo "<th>Project Description</th>"; 
	        echo "<th>Start Date</th>"; 
	        echo "<th>End Date</th>"; //projectEndDate
	        echo "<th>Requested Fund</th>"; 
	        echo "<th>Total Investments</th>"; 
	        echo "<th> </th>";

	        echo "</tr></thead>";

	    	while ($row=mysqli_fetch_array($projects)) {

	    		echo "<tr>";

				echo "<td><b>",$row_n,"</b></td>";
				$idProject=$row["idProject"];
				// $idUser=$row["idUser"];

				echo "<td>",$idProject,"</td>";
				echo "<td>",$row["firstname"],"</td>";
				echo "<td>",$row["projectName"],"</td>";
				echo "<td>",$row["projectDescription"],"</td>";
				echo "<td>",$row["projectStartDate"],"</td>";
				
				echo "<td>",$row["projectEndDate"],"</td>";
				echo "<td>",$row["requestedFund"],"</td>";
				echo "<td>",$row["total"],"</td>";
				
				if (cehckInvest($idProject,$logUser,$link)==1){
					// echo "here";6
					$projectLink="invest/invest.php?project=$idProject";
					echo "<td><a class='btn btn-outline-success' href=$projectLink >INVEST</a></td>";					
				}else{
					$projectLink="details.php?project=$idProject";
					echo "<td><a class='btn btn-outline-warning' href=$projectLink >Details</a></td>";
				}
				
				echo "</tr>";
				$row_n=$row_n+1;
			}
		echo "</table>";

	?>
	<?php 
		echo "<br><hr><hr><hr>";
		require_once('plot.php');
		main_bar($link);
		echo "<hr><hr><hr>";

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

