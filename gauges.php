<?php
	require('conexion.php');
	
	$tg = $_POST['trunk'];
	$d = $_POST['direction'];
	$el = $_POST['element'];
	
	$dir='';
	if($d==0){
		$dir='CALLER_TG';
	}else{
		$dir='DEST_TG';
	}
	
	$res = array();
	$res2 = array();
	$final = array();
	
	$query = "SELECT ROUND(((SUM(CALLS)-SUM(ERRORS_ASR))/SUM(CALLS))*100) ASR,
		ROUND(((SUM(CALLS)-SUM(ERRORS_NER))/SUM(CALLS))*100) NER,
		SUM(CALLS) CALLS
		FROM VQAS3.RESUMEN 
		WHERE $dir = '$tg' AND CALL_ZONE_DATA = 6 AND CONCAT(YEARS,'-',MONTHS,'-',DAYS) =DATE(NOW())";
	
	$query2 = "SELECT TRUNCATE(SUM(DURATION_SEC)/60,2) MINUTES,
		SUM(ERRORS_ASR) ERRORES, 
		TRUNCATE((SUM(DURATION_SEC)/60)/(SUM(CALLS)-SUM(ERRORS_ASR)),2) ACD
		FROM VQAS3.RESUMEN 
		WHERE $dir = '$tg' AND CALL_ZONE_DATA = 6 AND CONCAT(YEARS,'-',MONTHS,'-',DAYS) =DATE(NOW())";
	
	$query3 = "SELECT ROUND(((SUM(CALLS)-SUM(ERRORS_ASR))/SUM(CALLS))*100) ASR_MEAN,
		ROUND(((SUM(CALLS)-SUM(ERRORS_NER))/SUM(CALLS))*100) NER_MEAN,
		ROUND(SUM(CALLS)/7) CALLS_MEAN
		FROM VQAS3.RESUMEN 
		WHERE $dir = '$tg' AND CALL_ZONE_DATA = 6 AND CONCAT(YEARS,'-',MONTHS,'-',DAYS) BETWEEN DATE(DATE_SUB(NOW(),INTERVAL 49 DAY)) AND DATE(DATE_SUB(NOW(),INTERVAL 7 DAY))
		AND DAYNAME(CONCAT(YEARS,'-',MONTHS,'-',DAYS))=DAYNAME(NOW()) AND HOURS <= HOUR(NOW())";
		
	$query4 = "SELECT TRUNCATE((SUM(DURATION_SEC)/60)/7,2) MINUTES_MEAN,
		ROUND(SUM(ERRORS_ASR)/7) ERRORES_MEAN, 
		TRUNCATE(((SUM(DURATION_SEC)/60)/(SUM(CALLS)-SUM(ERRORS_ASR))),2) ACD_MEAN
		FROM VQAS3.RESUMEN 
		WHERE $dir = '$tg' AND CALL_ZONE_DATA = 6 AND CONCAT(YEARS,'-',MONTHS,'-',DAYS) BETWEEN DATE(DATE_SUB(NOW(),INTERVAL 49 DAY)) AND DATE(DATE_SUB(NOW(),INTERVAL 7 DAY))
		AND DAYNAME(CONCAT(YEARS,'-',MONTHS,'-',DAYS))=DAYNAME(NOW()) AND HOURS <= HOUR(NOW())";
	
	if($el==0){
		$r = $mysqli->query($query) or die($mysqli->error.__LINE__);
		$r2 = $mysqli->query($query3) or die($mysqli->error.__LINE__);
	}
	if($el==1){
		$r = $mysqli->query($query2) or die($mysqli->error.__LINE__);
		$r2 = $mysqli->query($query4) or die($mysqli->error.__LINE__);
	}
	
	while($result = $r->fetch_assoc()) {
		$res[] = $result;
	}

	while($result = $r2->fetch_assoc()) {
		$res2[] = $result;
	}
	
	$final = array_merge($res,$res2);
	$array = json_encode($final);
	
	echo $array;
	//echo $res[0]['NER'];
	//echo sizeof($res[0]['MINUTES']);
	//echo sizeof($array);
?>