<?php

	require('Pivot.php');
	require('conexion.php');
	$val = $_POST['seleccion'];
	$limit = $_POST['top'];
	$date1 = $_POST['begin_date'];
	$date2 = $_POST['end_date'];
	//$limit = 5;
	//$date1 = '2014-11-27';
	//$date2 = $date1;
	//$val = 0;
	
	$sql  ="SELECT TRUNK, SUM(CALLS) CALLS FROM TG_POR_PAISES2 A WHERE CONCAT(YEARS,'-',MONTHS,'-',DAYS) BETWEEN '$date1' AND '$date2'
	GROUP BY TRUNK ORDER BY CALLS DESC LIMIT $limit";

	$r = $mysqli->query($sql) or die($mysqli->error.__LINE__);
	
	$pivot=array();
	$trunks = array();
	$countries = array();
	$tabla= array();
	$obs1 = '';
	$obs2 = '';
    while($result = $r->fetch_assoc()) {
		$trunks[] = $result['TRUNK'];
	}
	
	#print_r(sizeof($countries));
	for($i = 0; $i < sizeof($trunks); $i++){
		$sql = "SELECT COUNTRY,TRUNK,SUM(CALLS) CALLS,ROUND((SUM(CALLS)-SUM(ERRORS_ASR))/SUM(CALLS)*100) ASR,ROUND((SUM(CALLS)-SUM(ERRORS_NER))/SUM(CALLS)*100) NER,
		TRUNCATE(SUM(MINUTES),2) MIN, SUM(ERRORS_NER) ERRORS_NER, SUM(ERRORS_ASR) ERRORS_ASR
		FROM TG_POR_PAISES2 WHERE TRUNK='$trunks[$i]' AND CONCAT(YEARS,'-',MONTHS,'-',DAYS) BETWEEN '$date1' AND '$date2' GROUP BY COUNTRY,TRUNK";
		
		$r = $mysqli->query($sql) or die($mysqli->error.__LINE__);
		
		while($result = $r->fetch_assoc()) {
			$pivot[] = $result;
		}
		
	}
	
	$data2 = array();
	
	$ca = '';
	if($val == 0){
		$ca="ASR";
	}else if($val == 1){
		$ca="NER";
	}
	else {
		$ca="CALLS";
	}
	
	$data = Pivot::factory($pivot)
    ->pivotOn(array('TRUNK'))
    ->addColumn(array('COUNTRY'), array("$ca",))
    ->fetch();
	
	$data_ner = Pivot::factory($pivot)
    ->pivotOn(array('TRUNK'))
    ->addColumn(array('COUNTRY'), array("ERRORS_NER",))
	->linetotal()
	->fulltotal()
    ->fetch();

	$data_asr = Pivot::factory($pivot)
    ->pivotOn(array('TRUNK'))
    ->addColumn(array('COUNTRY'), array("ERRORS_ASR",))
	->linetotal()
	->fulltotal()
    ->fetch();
	
	$data_calls = Pivot::factory($pivot)
    ->pivotOn(array('TRUNK'))
    ->addColumn(array('COUNTRY'), array("CALLS",))
    ->linetotal()
	->fulltotal()
	->fetch();
	
	$rows = array();
	$table= array();
	$lines = array();
	$columns = array();
	$titulos2 = array();
	$titulos3 = array();
	$titulos4 = array();
	
	$titulos=(array_keys($data[0]));
	$titulos2 =(array_keys($data_asr[0]));
	$titulos3 =(array_keys($data_ner[0]));
	$titulos4 =(array_keys($data_calls[0]));
	
	for($i = 0; $i < (sizeof($data_calls)-1); $i++){
		
		$c = $data_calls[$i]['TOT_CALLS'];
		
		if($val == 0){
			$a = $data_asr[$i]['TOT_ERRORS_ASR'];
			$lines[] = round(($c-$a)*100/$c);
			
		}
		else if($val == 1){
			$n = $data_ner[$i]['TOT_ERRORS_NER'];
			$lines[] = round(($c-$n)*100/$c);
			
		}
		else{
			$lines[] = $c;
			
		}
	}
	$s2 = sizeof($data_calls)-1;
	$s3 = sizeof($data_asr)-1;
	$s4 = sizeof($data_ner)-1;
	
	for($i = 0; $i < sizeof($data_calls[0]); $i++){
		$c = $data_calls[$s2][$titulos4[$i]];
		$a = $data_asr[$s2][$titulos2[$i]];
		$n = $data_ner[$s2][$titulos3[$i]];
		if($i > 1){
			
			if ($val == 0){
				
				$columns[] = round(($c-$a)*100/$c);
				//echo $a;
			}else if ($val == 1){
				
				$columns[] = round(($c-$n)*100/$c);
			} else{
				
				$columns[] = $c;
			}
		}
		else{
			if ($val == 0){
				
				$columns[] = $a;
				
			}else if ($val == 1){
				
				$columns[] = $n;
				
			} else{
				
				$columns[] = $c;
			}
		}
	}
	
	$s=sizeof($data[0]);
	
	//echo sizeof($data).' lines: '.sizeof($lines).' line[5]: '.$lines[5];
	for($i = 0; $i < sizeof($data); $i++){
		for($j = 1; $j < ($s+1); $j++){
			
			if($j == $s){
				$data2[$i][$j] = $lines[$i];
			}else{
				$data2[$i][$j] = $data[$i][$titulos[$j]];
			}
		}
	}
	for($i = 0; $i < sizeof($data2[0]); $i++){
		$data2[($s2+1)][] = $columns[$i+1];
	}
	
	//$data2[][sizeof($data[0])+1] = $lines;
	
	for($i = 0; $i < sizeof($titulos); $i++){
		if($val==0 || $val==1){
			$a = substr($titulos[$i],0,-5);
			$titulos[$i]=$a;
		}
		else{
			$a = substr($titulos[$i],0,-7);
			$titulos[$i]=$a;	
		}
	}

	$table['cols'] = array(
		// Labels for your chart, these represent the column titles
		// Note that one column is in "string" format and another one is in "number" format as pie chart only required "numbers" for calculating percentage and string will be used for column title
		
		array('label' => 'Carrier', 'type' => 'string'),
		
	);
	
	for($i = 2; $i < sizeof($titulos); $i++){
		array_push($table['cols'],array('label' => $titulos[$i], 'type' => 'number'));
	}
	
	array_push($table['cols'],array('label' => 'TOT', 'type' => 'number'));
	
	foreach($data2 as $tr) {
    $temp = array();

     foreach($tr as $key=>$value){

    // the following line will be used to slice the Pie chart

    // Values of each slice
    $temp[] = array('v' => $value);     
    }
  $rows[] = array('c' => $temp); 
}

	$table['rows'] = $rows;
	//$jsonTable = json_encode($data_calls);
	$jsonTable = json_encode($table);
	#$t=simpleHtmlTable($rows);
	echo $jsonTable;
	#echo $titulos[2];
?>