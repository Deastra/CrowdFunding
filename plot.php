
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
 
</head>

</html>

<?php 
	 function change_key( $array ) {
	 	for ($i=0;$i<count($array);$i++){
		    $keys = array_keys( $array[$i] );
		    $keys[ array_search( 0, $keys ) ] = "label";
		    $keys[ array_search( 1, $keys ) ] = "y";

		    $array[$i]=array_combine( $keys, $array[$i] );
		    $array[$i]["y"]=(float)$array[$i]["y"];
		}
	
	return $array;
	
	}
 ?>

<?php 
		function barplot($dataPoints1,$dataPoints2){
				echo "<script>
						window.onload = function () {
						 
						var chart = new CanvasJS.Chart('chartContainer', {
							title: {
								text: 'Investments of Projects'
							},
							theme: 'light2',
							animationEnabled: true,
							toolTip:{
								shared: true,
								reversed: true
							},
							axisY: {
								title: 'INVESTMENTS',
								suffix: '\$'
							},
							legend: {
								cursor: 'pointer',
								itemclick: toggleDataSeries
							},
							data: [
{
									
									name: 'Requested',
									showInLegend: true,
									yValueFormatString: '#,##0 \$',
									dataPoints:".json_encode($dataPoints1, JSON_NUMERIC_CHECK)."

								},									{
									type: 'stackedColumn',
									name: 'Invested',
									showInLegend: true,
									yValueFormatString: '#,##0 \$',
									dataPoints:".json_encode($dataPoints2, JSON_NUMERIC_CHECK)."
								}
							]
						});
						 
						chart.render();
						 
						function toggleDataSeries(e) {
							if (typeof (e.dataSeries.visible) === 'undefined' || e.dataSeries.visible) {
								e.dataSeries.visible = false;
							} else {
								e.dataSeries.visible = true;
							}
							e.chart.render();
						}
						 
						}";
		echo "</script>";
		echo "<div id='chartContainer' style='height: 370px; width: 100%;'></div>";
		echo "<script src='https://canvasjs.com/assets/script/canvasjs.min.js'></script>";

	}
 ?>


<?php 

	function main_bar($link){

		$query1="SELECT projectName,requestedFund from projects";
		$query2="SELECT projectName,sum(investmentFund) from projects_investors join projects using(idProject) group by idProject";
		
		$stats1=change_key(mysqli_fetch_all(mysqli_query($link,$query1)));
		$stats2=change_key(mysqli_fetch_all(mysqli_query($link,$query2)));

		barplot($stats1,$stats2);

	}

	?>

	<?php 

	function  my_projects_plot($link,$user){

		$query1="SELECT projectName,requestedFund from projects where idUser=$user";
		$query2="SELECT projectName,sum(investmentFund) from projects_investors join projects using(idProject) where projects.idUser=$user group by idProject";
		
		$stats1=change_key(mysqli_fetch_all(mysqli_query($link,$query1)));
		$stats2=change_key(mysqli_fetch_all(mysqli_query($link,$query2)));

		barplot($stats1,$stats2);

	};

	?>
 <?php 
	 function pie($link,$id){
		$query1="SELECT idProject,SUM(investmentFund) as total from projects_investors where idProject=$id group by idProject";
		$total_arr=mysqli_fetch_array(mysqli_query($link,$query1));
		// echo var_dump($total_arr);

		##################################

		$total=$total_arr["total"];
		$query2="SELECT projectName,requestedFund from projects where idProject=$id";
		$res=mysqli_fetch_array(mysqli_query($link,$query2));
		$requested=$res["requestedFund"];
		$name=$res["projectName"];
		$remain=($requested-$total)/$requested*100;
		$total=$total/$requested*100;
		$data=array(array("label"=>"Remained Fund","y"=>$remain),
			array("label"=>"Total Investment","y"=>$total));

	 	// echo var_dump($data);
	 	echo "<hr>";
		echo "<script>
		window.onload = function() {

		var chart1 = new CanvasJS.Chart('chartContainer1', {
			animationEnabled: true,
			title: {
				text: 'Fund Statistics'
			},
			subtitles: [{
				text: 'Project: \'$name\''
			}],
			data: [{
				type: 'pie',
				indexLabel: '{label} ({y})',
				yValueFormatString: '#,##0.00\"%\"',
				dataPoints:".json_encode($data, JSON_NUMERIC_CHECK)."
			}]
		});
		chart1.render();
		 
		}
		</script>";
		echo "<div id='chartContainer1' style='height: 370px; width: 100%;'></div>";
		echo "<script src='https://canvasjs.com/assets/script/canvasjs.min.js'></script>";
		echo "<br><hr><br>";

	 } ;

 ?>
 <?php 
	 function pie2($link,$id,$user){
		$query1="SELECT idProject,SUM(investmentFund) as total from projects_investors where idProject=$id group by idProject";
		$total_arr=mysqli_fetch_array(mysqli_query($link,$query1));
		// echo var_dump($total_arr);
		$user_query="SELECT * from projects_investors where idProject=$id and idUser=$user";
		$user_res=mysqli_fetch_array(mysqli_query($link,$user_query))["investmentFund"];
		##################################

		$total=$total_arr["total"];
		$query2="SELECT projectName,requestedFund from projects where idProject=$id";
		$res=mysqli_fetch_array(mysqli_query($link,$query2));
		$requested=$res["requestedFund"];
		$name=$res["projectName"];
		$remain=($requested-$total)/$requested*100;
		$total=($total-$user_res)/$requested*100;
		$user_fund=$user_res/$requested*100;

		$data=array(array("label"=>"Remained Fund","y"=>$remain),
					array("label"=>"Total Investment","y"=>$total),
					array("label"=>"Your Investment","y"=>$user_fund));

	 	// echo var_dump($data);
	 	echo "<hr>";
		echo "<script>
		window.onload = function() {

		var chart1 = new CanvasJS.Chart('chartContainer3', {
			animationEnabled: true,
			title: {
				text: 'Fund Statistics'
			},
			subtitles: [{
				text: 'Project: \'$name\''
			}],
			data: [{
				type: 'pie',
				indexLabel: '{label} ({y})',
				yValueFormatString: '#,##0.00\"%\"',
				dataPoints:".json_encode($data, JSON_NUMERIC_CHECK)."
			}]
		});
		chart1.render();
		 
		}
		</script>";
		echo "<div id='chartContainer3' style='height: 370px; width: 100%;'></div>";
		echo "<script src='https://canvasjs.com/assets/script/canvasjs.min.js'></script>";
		echo "<br><hr><br>";

	 } ;

 ?>
 <?php 
	 function pie1($dataPoints,$id){

	 	// echo var_dump($dataPoints);
	 	echo "<hr>";
		echo "<script>
		window.onload = function() {

		var chart = new CanvasJS.Chart('chartContainer2', {
			animationEnabled: true,
			title: {
				text: 'Investment Share of Customers'
			},
			subtitles: [{
				text: 'Project: $id'
			}],
			data: [{
				type: 'pie',
				indexLabel: '{label} ({y})',
				yValueFormatString: '#,##0.00\"%\"',
				dataPoints:".json_encode($dataPoints, JSON_NUMERIC_CHECK)."
			}]
		});
		chart.render();
		 
		}
		</script>";
		echo "<div id='chartContainer2' style='height: 370px; width: 100%;'></div>";
		echo "<script src='https://canvasjs.com/assets/script/canvasjs.min.js'></script>";
		echo "<br><hr><br>";

	 } 

 ?>


<?php 
	function pie_project($project,$link){
		$query1="SELECT idProject,SUM(investmentFund) as total from projects_investors group by idProject";
		$total_arr=mysqli_fetch_all(mysqli_query($link,$query1));
		// echo var_dump($total_arr);

		##################################

		$total=$total_arr[$project-1][1];
		$query2="SELECT concat(firstname,' ',lastname) as fullname,round(SUM(investmentFund)/$total*100,2) as invest from projects_investors join users using(idUser) where idProject=$project GROUP by idUser ";

		$stats=mysqli_fetch_all(mysqli_query($link,$query2));
		
		pie1(change_key($stats),$project);
	}
	

	
?>

