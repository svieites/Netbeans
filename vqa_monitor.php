<?php
	
include('conexion.php');
include('Pivot.php');	
	$pais = $_POST['pais'];
	//$pais='Barbados';
	
	$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

	$sql  ="SELECT if(week(Fecha)=0,52,if(week(Fecha)=53,1,week(Fecha))) WEEKS,DAYNAME(Fecha) DAY, TRUNCATE(ASR,2) ASR,TRUNCATE(NER,2) NER,FECHA DATE FROM ASR_NER 
	WHERE if(week(Fecha)=0,52,if(week(Fecha)=53,1,week(Fecha))) 
	IN(if(week(sysdate())=0,52,if(week(sysdate())=53,1,week(sysdate()))),
	if(week(date_sub(sysdate(), interval 1 week))=0,52,if(week(date_sub(sysdate(), interval 1 week))=53,1,week(date_sub(sysdate(), interval 1 week)))),
	if(week(date_sub(sysdate(), interval 2 week))=0,52,if(week(date_sub(sysdate(), interval 2 week))=53,1,week(date_sub(sysdate(), interval 2 week)))),
	if(week(date_sub(sysdate(), interval 3 week))=0,52,if(week(date_sub(sysdate(), interval 3 week))=53,1,week(date_sub(sysdate(), interval 3 week)))))
	AND Pais = '$pais' AND Fecha BETWEEN  DATE(date_sub(sysdate(), interval 28 DAY)) AND DATE(SYSDATE()) ORDER BY DAYOFWEEK(FECHA),FECHA DESC";
    $sql2 ="select round((sum(Calls)-sum(Errors_ASR))*100/(sum(Calls))) Mean_ASR, round((sum(Calls)-sum(Errors_NER))*100/(sum(Calls))) Mean_NER from ASR_NER_Errors where dayname(Fecha) = dayname(now()) and Fecha between date(date_sub(sysdate(), interval 100 day)) and date(date_sub(sysdate(), interval 1 day)) and Pais = '$pais'";
    $sql3 = "select ASR,NER,Last_Update from ASR_NER_Min_Temp where Pais = '$pais'";
	
	$r = $mysqli->query($sql) or die($mysqli->error.__LINE__);
	$r2 = $mysqli->query($sql2) or die($mysqli->error.__LINE__);
	$r3 = $mysqli->query($sql3) or die($mysqli->error.__LINE__);
	
    $res = array();
	$res2 = array();
	$res3 = array();
	
    while($result = $r->fetch_assoc()) {
		$res[] = $result;	
	}
    while($result = $r2->fetch_assoc()) {
		$res2[] = $result;	
	}
	while($result = $r3->fetch_assoc()) {
		$res3[] = $result;	
	}
	
	$pivot = Pivot::factory($res)
    ->pivotOn(array('DAY'))
    ->addColumn(array('WEEKS'), array("ASR",))
    ->fetch();
	
	$pivot2 = Pivot::factory($res)
    ->pivotOn(array('DAY'))
    ->addColumn(array('WEEKS'), array("NER",))
    ->fetch();
	
	$titulos = array_keys($pivot[0]);
	$titulos2 = array_keys($pivot2[0]);
	
	$data = array();
	$data2 = array();
	
	$s=sizeof($pivot[0]);
	$s2=sizeof($pivot2[0]);
	
	for($i = 0; $i < sizeof($pivot); $i++){
		for($j = 1; $j < ($s+1); $j++){
			
			$data[$i][$j] = $pivot[$i][$titulos[$j]];
			
		}
	}
	
	for($i = 0; $i < sizeof($pivot2); $i++){
		for($j = 1; $j < ($s+1); $j++){
			
			$data2[$i][$j] = $pivot2[$i][$titulos2[$j]];
			
		}
	}
	
	$arr=$res2[0];
	$mean_a=$arr['Mean_ASR'];
	$mean_n=$arr['Mean_NER'];

	$arr2=$res3[0];
	$a=$arr2['ASR'];
	$n=$arr2['NER'];
	$up=$arr2['Last_Update'];
	
	//print_r($mean_asr);
	
	  $rows = array();
	  $rows2 = array();

	  //flag is not needed
      //$flag = true;
      $table = array();
	  $table2 = array();
	  
      $table['cols'] = array(
    // Labels for your chart, these represent the column titles
    // Note that one column is in "string" format and another one is in "number" format as pie chart only required "numbers" for calculating percentage and string will be used for column title
    array('label' => 'Dia', 'type' => 'string'),
    array('label' => 'Current Week', 'type' => 'number'),
	array('label' => 'Last Week', 'type' => 'number'),
	array('label' => '2 Weeks Ago', 'type' => 'number'),
	array('label' => '3 Weeks Ago', 'type' => 'number'),
    );
	
	$table2['cols'] = array(
    // Labels for your chart, these represent the column titles
    // Note that one column is in "string" format and another one is in "number" format as pie chart only required "numbers" for calculating percentage and string will be used for column title
    array('label' => 'Dia', 'type' => 'string'),
    array('label' => 'Current Week', 'type' => 'number'),
	array('label' => 'Last Week', 'type' => 'number'),
	array('label' => '2 Weeks Ago', 'type' => 'number'),
	array('label' => '3 Weeks Ago', 'type' => 'number'),
    );
	
  foreach($data as $tr) {
    $temp = array();

     foreach($tr as $key=>$value){

    // the following line will be used to slice the Pie chart

    // Values of each slice
    $temp[] = array('v' => $value);     
    }
  $rows[] = array('c' => $temp); 
}
  foreach($data2 as $tr) {
    $temp = array();

     foreach($tr as $key=>$value){

    // the following line will be used to slice the Pie chart

    // Values of each slice
    $temp[] = array('v' => $value);     
    }
  $rows2[] = array('c' => $temp); 
}

    $table['rows'] = $rows;
	$table2['rows'] = $rows2;
	
	$asr = array('asr'=>$a);
	$ner = array('ner'=>$n);
	$mean_asr = array('mean_asr'=>$mean_a);
	$mean_ner = array('mean_ner'=>$mean_n);
	$update = array('update'=>$up);
	$lines_asr = array('lines_asr'=>$table);
	$lines_ner = array('lines_ner'=>$table2);
	$final = $asr + $ner + $mean_asr + $mean_ner + $update + $lines_asr + $lines_ner;
    //$jsonTable = json_encode($table);
	//$jsonTable2 = json_encode($table2);
	$jsonTable = json_encode($final);
	echo $jsonTable;

?>