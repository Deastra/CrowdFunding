<?php 
	include('auth.php');
 ?>
 <!DOCTYPE html>
 <html>
 <head>
 	<meta charset="utf-8">
 	<title>MY PROJECTS</title>
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
		$email=$_SESSION["email"];
		$logUser=$_SESSION["user"];

	?>
	<input type="button" class="btn btn-outline-dark mx-3 my-2" onclick="location.href='main.php';" value="Back" />
	<!-- <input type="button" onclick="location.href='https://google.com';" value="Go to Google" /> -->
	<!-- echo "<td><button type='button' name=EDIT onclick=''>EDIT</button></td>"; -->
	<?php

		$query_my_projects="SELECT projects.idProject,projectName,requestedFund,total,firstname,projectStartDate,projectEndDate,email
				from projects 
				join users using (idUser) 
				join (SELECT idProject,SUM(investmentFund) as total from projects_investors group by idProject) as invests on projects.idProject=invests.idProject where users.email='$email'";
		
		$my_projects=mysqli_query($link,$query_my_projects);
		$row=mysqli_num_rows($my_projects);
		if ($row==0){
			// echo "NO PROJECTS ARE OWNED!!!","<br>";
		}else{

	    	$row_n=1;
	    	
	    	echo "<table class='table table-light table-hover'>";
			echo "<thead class=\"table-primary\">";
		        echo "<tr>";  
		        echo "<th>#</th>";
		        echo "<th>ID</th>"; 
		        echo "<th>Owner</th>"; //firstName
		        echo "<th>Email</th>"; //email
		        echo "<th>Project Name</th>"; //projectName
		        echo "<th>Start Date</th>"; //projectStartDate
		        echo "<th>End Date</th>"; //projectEndDate
		        echo "<th>Requested Fund</th>"; //requestedFund
		        echo "<th>Total Investments</th>"; //requestedFund
		        echo "<th></th>";
		        echo "</tr></thead>";


		    	while ($row=mysqli_fetch_array($my_projects)) {

		    		echo "<tr>";
		    		#$r_email=$row["email"];
					#$user_del="DELETE FROM customers WHERE email='$r_email";
					
					//echo "<td><button type='button' name=Details onclick=''>EDIT</button></td>";
					//echo "<td><button type='button' onclick=''>DELETE</button></td>";
					echo "<td>",$row_n,"</td>";
					echo "<td>",$row["idProject"],"</td>";
					echo "<td>",$row["firstname"],"</td>";
					echo "<td>",$row["email"],"</td>";
					echo "<td>",$row["projectName"],"</td>";
					echo "<td>",$row["projectStartDate"],"</td>";
					
					echo "<td>",$row["projectEndDate"],"</td>";
					echo "<td>",$row["requestedFund"],"</td>";
					echo "<td>",$row["total"],"</td>";
					$id=$row["idProject"];
			        $link_i="investors.php?id=$id";
			        
	              	// echo "<td><form action='$link'><button type='submit'>Investors</button> </form></td>";
			        // echo "<td>",$link,"</td>";
		        	// echo "<td><button type='button' name=INVESTORS onclick='$link'>INVESTORS</button></td>";
		        	echo "<td><a class=\"btn btn-info\" href='$link_i'>INVESTORS</a></td>";
					echo "</tr>";
					$row_n=$row_n+1;
				}
				echo "</table>";
				echo "<hr>";
				require_once('plot.php');
				my_projects_plot($link,$logUser);
		}

		?>
		<br>
		<hr>
		<br>
		<br>
		<br>
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
