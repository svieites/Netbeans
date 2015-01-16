<?php
	
	require('conexion.php');
	
	$nombre = $_POST['dato'];
	$el = $_POST['element'];
	$date1 = $_POST['begin_date'];
	$date2 = $_POST['end_date'];
	
	//$nombre='Flow Jamaica';
	//$el=1;
	//$date1='2014-11-27';
	//$date2=$date1;
	
	$rows = array();
	$tabla = array();
	$table = array();
	$res = array();
	
	$query = "SELECT A.REGION,ROUND(((SUM(A.CALLS)-SUM(A.ERRORS_ASR))/SUM(A.CALLS))*100) ASR,ROUND(((SUM(A.CALLS)-SUM(A.ERRORS_NER))/SUM(A.CALLS))*100) NER,
		SUM(A.CALLS) CALLS
		FROM RESUMEN A
		INNER JOIN CARRIER B ON A.DEST_TG=B.TRUNK_ID
		WHERE B.NAME = '$nombre' AND A.CALL_ZONE_DATA = 6 AND CONCAT(A.YEARS,'-',A.MONTHS,'-',A.DAYS) BETWEEN '$date1' AND '$date2'
		GROUP BY A.REGION";
	
	$query2 = "SELECT A.REGION,ROUND(SUM(DURATION_SEC)/60) MINUTES,SUM(ERRORS_ASR) ERRORES, 
		TRUNCATE((SUM(DURATION_SEC)/60)/(SUM(CALLS)-SUM(ERRORS_ASR)),2) ACD
		FROM RESUMEN A
		INNER JOIN CARRIER B ON A.DEST_TG=B.TRUNK_ID
		WHERE B.NAME = '$nombre' AND A.CALL_ZONE_DATA = 6 AND CONCAT(A.YEARS,'-',A.MONTHS,'-',A.DAYS) BETWEEN '$date1' AND '$date2'
		GROUP BY A.REGION";
		
	$query3 = "SELECT ROUND(((SUM(A.CALLS)-SUM(A.ERRORS_ASR))/SUM(A.CALLS))*100) ASR,ROUND(((SUM(A.CALLS)-SUM(A.ERRORS_NER))/SUM(A.CALLS))*100) NER,
		SUM(A.CALLS) CALLS
		FROM RESUMEN A
		INNER JOIN CARRIER B ON A.DEST_TG=B.TRUNK_ID
		WHERE B.NAME = '$nombre' AND A.CALL_ZONE_DATA = 6 AND CONCAT(A.YEARS,'-',A.MONTHS,'-',A.DAYS) BETWEEN '$date1' AND '$date2'";
	
	$query4 = "SELECT ROUND(SUM(DURATION_SEC)/60) MINUTES,SUM(ERRORS_ASR) ERRORES, 
		TRUNCATE((SUM(DURATION_SEC)/60)/(SUM(CALLS)-SUM(ERRORS_ASR)),2) ACD
		FROM RESUMEN A
		INNER JOIN CARRIER B ON A.DEST_TG=B.TRUNK_ID
		WHERE B.NAME = '$nombre' AND A.CALL_ZONE_DATA = 6 AND CONCAT(A.YEARS,'-',A.MONTHS,'-',A.DAYS) BETWEEN '$date1' AND '$date2'";
	
	if($el==0){
		$r2 = $mysqli->query($query3) or die($mysqli->error.__LINE__);
		$r = $mysqli->query($query) or die($mysqli->error.__LINE__);
		$table['cols'] = array(
		// Labels for your chart, these represent the column titles
		// Note that one column is in "string" format and another one is in "number" format as pie chart only required "numbers" for calculating percentage and string will be used for column title
		array('label' => 'Region', 'type' => 'string'),
		array('label' => 'ASR', 'type' => 'string'),
		array('label' => 'NER', 'type' => 'string'),
		array('label' => 'Calls', 'type' => 'string'),
		
	);
	}
	if($el==1){
		$r = $mysqli->query($query2) or die($mysqli->error.__LINE__);
		$r2 = $mysqli->query($query4) or die($mysqli->error.__LINE__);
		$table['cols'] = array(
		// Labels for your chart, these represent the column titles
		// Note that one column is in "string" format and another one is in "number" format as pie chart only required "numbers" for calculating percentage and string will be used for column title
		array('label' => 'Region', 'type' => 'string'),
		array('label' => 'MINUTES', 'type' => 'string'),
		array('label' => 'ERRORS', 'type' => 'string'),
		array('label' => 'ACD', 'type' => 'string'),
		
	);
	}
	
	while($result = $r->fetch_assoc()) {
		$res[] = $result;
	}
	
	foreach($res as $tr) {
		$temp = array();

		 foreach($tr as $key=>$value){

		// the following line will be used to slice the Pie chart

		// Values of each slice
		$temp[] = array('v' => $value);     
		}
	  $rows[] = array('c' => $temp); 
	}
	
	//$temp2[]=array();
	if($rows[0] != ''){
	while($result = $r2->fetch_assoc()) {
		$res2[] = $result;
	}
		$temp2[]=array('v' => 'TOT'); 
		foreach($res2 as $tr) {
			
			 foreach($tr as $key=>$value){

			// the following line will be used to slice the Pie chart

			// Values of each slice
			$temp2[] = array('v' => $value);     
			}
		  $rows[] = array('c' => $temp2); 
		}
	}else{}
	
	$table['rows'] = $rows;
	$jsonTable = json_encode($table);

	echo $jsonTable;
?>