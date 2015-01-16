<?php

	require('conexion.php');
	
	$tg = $_POST['trunk'];
	$el = $_POST['element'];
	$date1 = $_POST['begin_date'];
	$date2 = $_POST['end_date'];
	#$tg=502;
	$rows = array();
	$tabla = array();
	$table = array();
	$res = array();
	
	$query = "SELECT B.NAME,ROUND(((SUM(A.CALLS)-SUM(A.ERRORS_ASR))/SUM(A.CALLS))*100) ASR,ROUND(((SUM(A.CALLS)-SUM(A.ERRORS_NER))/SUM(A.CALLS))*100) NER,
		SUM(A.CALLS) CALLS
		FROM VQAS3.RESUMEN A
		INNER JOIN WHOLESALE.CARRIER B
		ON B.TRUNK_ID=A.DEST_TG
		WHERE A.CALLER_TG = '$tg' AND A.CALL_ZONE_DATA = 6 AND CONCAT(A.YEARS,'-',A.MONTHS,'-',A.DAYS) BETWEEN '$date1' AND '$date2'
		GROUP BY B.NAME";
		
	$query2 = "SELECT B.NAME,ROUND(SUM(DURATION_SEC)/60) MINUTES,
		SUM(ERRORS_ASR) ERRORES, 
		TRUNCATE((SUM(DURATION_SEC)/60)/(SUM(CALLS)-SUM(ERRORS_ASR)),2) ACD
		FROM VQAS3.RESUMEN A
		INNER JOIN WHOLESALE.CARRIER B
		ON B.TRUNK_ID=A.DEST_TG
		WHERE A.CALLER_TG = '$tg' AND A.CALL_ZONE_DATA = 6 AND CONCAT(A.YEARS,'-',A.MONTHS,'-',A.DAYS) BETWEEN '$date1' AND '$date2'
		GROUP BY B.NAME";
		
	$query3 = "SELECT ROUND(((SUM(A.CALLS)-SUM(A.ERRORS_ASR))/SUM(A.CALLS))*100) ASR,ROUND(((SUM(A.CALLS)-SUM(A.ERRORS_NER))/SUM(A.CALLS))*100) NER,
		SUM(A.CALLS) CALLS
		FROM VQAS3.RESUMEN A
		INNER JOIN WHOLESALE.CARRIER B
		ON B.TRUNK_ID=A.DEST_TG
		WHERE A.CALLER_TG = '$tg' AND A.CALL_ZONE_DATA = 6 AND CONCAT(A.YEARS,'-',A.MONTHS,'-',A.DAYS) BETWEEN '$date1' AND '$date2'";
		
	$query4 = "SELECT ROUND(SUM(DURATION_SEC)/60) MINUTES,
		SUM(ERRORS_ASR) ERRORES, 
		TRUNCATE((SUM(DURATION_SEC)/60)/(SUM(CALLS)-SUM(ERRORS_ASR)),2) ACD
		FROM VQAS3.RESUMEN A
		INNER JOIN WHOLESALE.CARRIER B
		ON B.TRUNK_ID=A.DEST_TG
		WHERE A.CALLER_TG = '$tg' AND A.CALL_ZONE_DATA = 6 AND CONCAT(A.YEARS,'-',A.MONTHS,'-',A.DAYS) BETWEEN '$date1' AND '$date2'";	
		
	if($el==0){
		$r = $mysqli->query($query) or die($mysqli->error.__LINE__);
		$r2 = $mysqli->query($query3) or die($mysqli->error.__LINE__);
		$table['cols'] = array(
		// Labels for your chart, these represent the column titles
		// Note that one column is in "string" format and another one is in "number" format as pie chart only required "numbers" for calculating percentage and string will be used for column title
		//array('label' => 'Caller_TG', 'type' => 'number'),
		array('label' => 'Term. Trunk', 'type' => 'string'),
		array('label' => 'ASR', 'type' => 'number'),
		array('label' => 'NER', 'type' => 'number'),
		array('label' => 'Calls', 'type' => 'number'),
	);
	}
	if($el==1){
		$r = $mysqli->query($query2) or die($mysqli->error.__LINE__);
		$r2 = $mysqli->query($query4) or die($mysqli->error.__LINE__);
		$table['cols'] = array(
		// Labels for your chart, these represent the column titles
		// Note that one column is in "string" format and another one is in "number" format as pie chart only required "numbers" for calculating percentage and string will be used for column title
		//array('label' => 'Caller_TG', 'type' => 'number'),
		array('label' => 'Term. Trunk', 'type' => 'string'),
		array('label' => 'Minutes', 'type' => 'number'),
		array('label' => 'Errors', 'type' => 'number'),
		array('label' => 'ACD', 'type' => 'number'),
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