<?php
	require('conexion.php');
	require('Pivot.php');
	
	$trunk = $_POST['trunk'];
	$el = $_POST['element'];
	
	//$trunk=530;
	//$el=0;
	
	$regions = array();
	$titulos = array();
	$res = array();
	$data2 = array();
	$resultado = array();
	if($el==0){
		$element = 'ASR';
		$query = "SELECT CONCAT(YEARS,'-',MONTHS,'-',DAYS) FECHA,REGION, ROUND(((SUM(CALLS)-SUM(ERRORS_ASR))/SUM(CALLS))*100) ASR FROM RESUMEN A
		WHERE DEST_TG=$trunk AND CALL_ZONE_DATA=6 AND DAYNAME(CONCAT(YEARS,MONTHS,DAYS))=DAYNAME(DATE(NOW())) AND HOURS<=HOUR(NOW())
		AND CONCAT(YEARS,'-',MONTHS,'-',DAYS) BETWEEN DATE(DATE_SUB(NOW(),INTERVAL 28 DAY)) AND DATE(NOW())
		GROUP BY CONCAT(YEARS,'-',MONTHS,'-',DAYS),REGION ORDER BY CONCAT(YEARS,'-',MONTHS,'-',DAYS) ASC";
	}else if($el==1){
		$element = 'NER';
		$query = "SELECT CONCAT(YEARS,'-',MONTHS,'-',DAYS) FECHA,REGION, ROUND(((SUM(CALLS)-SUM(ERRORS_NER))/SUM(CALLS))*100) NER FROM RESUMEN A
		WHERE DEST_TG=$trunk AND CALL_ZONE_DATA=6 AND DAYNAME(CONCAT(YEARS,MONTHS,DAYS))=DAYNAME(DATE(NOW())) AND HOURS<=HOUR(NOW())
		AND CONCAT(YEARS,'-',MONTHS,'-',DAYS) BETWEEN DATE(DATE_SUB(NOW(),INTERVAL 28 DAY)) AND DATE(NOW())
		GROUP BY CONCAT(YEARS,'-',MONTHS,'-',DAYS),REGION ORDER BY CONCAT(YEARS,'-',MONTHS,'-',DAYS) ASC";
	}else if($el==2){
		$element = 'CALLS';
		$query = "SELECT CONCAT(YEARS,'-',MONTHS,'-',DAYS) FECHA,REGION,SUM(CALLS) CALLS FROM RESUMEN A
		WHERE DEST_TG=$trunk AND CALL_ZONE_DATA=6 AND DAYNAME(CONCAT(YEARS,MONTHS,DAYS))=DAYNAME(DATE(NOW())) AND HOURS<=HOUR(NOW())
		AND CONCAT(YEARS,'-',MONTHS,'-',DAYS) BETWEEN DATE(DATE_SUB(NOW(),INTERVAL 28 DAY)) AND DATE(NOW())
		GROUP BY CONCAT(YEARS,'-',MONTHS,'-',DAYS),REGION ORDER BY CONCAT(YEARS,'-',MONTHS,'-',DAYS) ASC";
	}else{
		$element = 'MIN';
		$query = "SELECT CONCAT(YEARS,'-',MONTHS,'-',DAYS) FECHA,REGION, ROUND(SUM(DURATION_SEC)/60) MIN FROM RESUMEN A
		WHERE DEST_TG=$trunk AND CALL_ZONE_DATA=6 AND DAYNAME(CONCAT(YEARS,MONTHS,DAYS))=DAYNAME(DATE(NOW())) AND HOURS<=HOUR(NOW())
		AND CONCAT(YEARS,'-',MONTHS,'-',DAYS) BETWEEN DATE(DATE_SUB(NOW(),INTERVAL 28 DAY)) AND DATE(NOW())
		GROUP BY CONCAT(YEARS,'-',MONTHS,'-',DAYS),REGION ORDER BY CONCAT(YEARS,'-',MONTHS,'-',DAYS) ASC";
	}
	
	$r = $mysqli->query($query) or die($mysqli->error.__LINE__);
	
	while($result = $r->fetch_assoc()) {
		$res[] = $result;
	}
	
	$data = Pivot::factory($res)
    ->pivotOn(array('REGION'))
    ->addColumn(array('FECHA'), array("$element",))
    ->fetch();
	
	if($data[0]!=''){
		$titu=(array_keys($data[0]));
	}	
		
	for($i = 2; $i < sizeof($titu); $i++){
		$titulos[] = $titu[$i];
	}
	//echo sizeof($data).'<br>';

	
	for($i = 0; $i < sizeof($data); $i++){
		$regions[] = $data[$i]['REGION'];
	}
	
	for($i = 0; $i < sizeof($data); $i++){
		
		for($j = 0; $j < sizeof($titulos); $j++){
			$data2[$i][] = $data[$i][$titulos[$j]];
		}
	}
	if($el==2){
		for($i = 0; $i < sizeof($titulos); $i++){
				$a = substr($titulos[$i],0,-7);
				$titulos[$i]=$a;
		}
	}else{
		for($i = 0; $i < sizeof($titulos); $i++){
				$a = substr($titulos[$i],0,-5);
				$titulos[$i]=$a;
		}
	}
	
	//$resultado[0]['categories'] = $titulos;
	
	for($i = 0; $i < (sizeof($regions)); $i++){
		$resultado[$i]['name'] = $regions[$i];
		$resultado[$i]['data'] = $data2[$i];
	}
	
	$result=array();
	
	for($i = 0; $i < sizeof($resultado); $i++){
		array_push($result,$resultado[$i]);
	}
	$datos=array('data'=>$result);
	$title=array('categories'=>$titulos);
	
	$final=$title+$datos;
	
	$jsonTable2 = json_encode($final);
	//echo json_encode($table,JSON_NUMERIC_CHECK);
	echo $jsonTable2;
?>