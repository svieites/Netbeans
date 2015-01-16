<?php

	include('conexion2.php');

	$pais = $_POST['pais'];
	
	//$pais= 'PuertoRico';
	
    $sql  ="select round(sum(Minutes)) Min,sum(Errors_ASR) Errores,sum(Calls) Calls,round((sum(Calls)-sum(Errors_ASR))*100/sum(Calls)) ASR, 
	truncate(sum(ACD)/count(*),2) ACD,round((sum(Calls)-sum(Errors_NER))*100/sum(Calls)) NER
	from Indicadores_Temp where Pais='$pais' and Hora between '0' and hour(now())+1";
	
	$sql2 = "select Min,Errores,Calls,ASR,ACD,NER from Indicadores_Actuales where Pais= '$pais'";
	
	$sql3 ="select Region_Code Region,truncate(sum(B.Duration)/ 60,2) Min, count(*) Calls , sum(Errors_ASR) Errores,round((count(*)-sum(Errors_ASR))*100/count(*)) ASR,
	round((count(*)-sum(Errors_NER))*100/count(*)) NER, sum(B.Duration)/((count(*)-sum(Errors_ASR))*60) ACD
	from VQAS3.$pais B where date(Start_Time)=date(now()) and hour(Start_Time) between '0' and hour(now())+1 group by Region_Code order by Min desc limit 0,5";
	
	$sql4 = "select Region,truncate(sum(Minutes),2) Min,sum(Calls) Calls, sum(Errors_ASR) Errores, round((sum(Calls)-sum(Errors_ASR))*100/sum(Calls)) ASR,
	round((sum(Calls)-sum(Errors_NER))*100/sum(Calls)) NER, truncate((sum(Minutes)/(sum(calls)-sum(Errors_ASR))),2) ACD
	from Indicadores_Temp_Region where Pais ='$pais' and Hora between '0' and hour(now())+1
	group by Region order by Min desc limit 0,10";
	
	$sql5 = "select Last_Update LastUp,Min totMin from VQAS3.ASR_NER_Min_Temp where Pais='$pais'";
	
	$r = $mysqli->query($sql) or die($mysqli->error.__LINE__);
	$r2 = $mysqli->query($sql2) or die($mysqli->error.__LINE__);
	$r3 = $mysqli->query($sql3) or die($mysqli->error.__LINE__);
	$r4 = $mysqli->query($sql4) or die($mysqli->error.__LINE__);
	$r5 = $mysqli->query($sql5) or die($mysqli->error.__LINE__);
	
    $res = array();
	$res2 = array();
	$res3 = array();
	$res4 = array();
	$res5 = array();
	
    while($result = $r->fetch_assoc()) {
		$res[] = $result;	
	}
	while($result = $r2->fetch_assoc()) {
		$res2[] = $result;	
	}
	while($result = $r3->fetch_assoc()) {
		$res3[] = $result;	
	}
	while($result = $r4->fetch_assoc()) {
		$res4[] = $result;	
	}
	while($result = $r5->fetch_assoc()) {
		$res5[] = $result;	
	}
	
	$arr=$res[0];
	$mean_min=$arr['Min'];
	$mean_calls=$arr['Calls'];
	$mean_errors=$arr['Errores'];
	$mean_asr=$arr['ASR'];
	$mean_ner=$arr['NER'];
	$mean_acd=$arr['ACD'];
	//print_r($mean_ner);

	$arr2=$res2[0];
	$min=$arr2['Min'];
	$calls=$arr2['Calls'];
	$errors=$arr2['Errores'];
	$asr=$arr2['ASR'];
	$ner=$arr2['NER'];
	$acd=$arr2['ACD'];
	//print_r($ner);
	
	$arr3=$res5[0];
	$last_update=$arr3['LastUp'];
	$totMin=$arr3['totMin'];
	$callsOthers = $totMin;
	
	$inf_reg = array();
	$inf_comp = array();
	
	$reg_name = array();
	$reg_min = array();
	
	//print_r($res3[0]['Region']);
	for ($i = 0; $i < sizeof($res3); $i++) {
		$inf_reg[$i]=$res3[$i];
		$reg_name[$i]=$res3[$i]['Region'];
		$reg_min[$i]=$res3[$i]['Min'];
		$callsOthers=$callsOthers-$reg_min[$i];
	}
	//print_r($callsOthers);
	
	for ($i = 0; $i < sizeof($res4); $i++) {
		$inf_comp[$i]=$res4[$i];
	}
	
	$obs=array();
	$obs[]="<h9>Last Update (GMT-4): ".$last_update.'</h9>';
	for ($i = 0; $i < 5; $i++) {
		$region_exists=false;
		for ($j = 0; $j < 10; $j++){
			
			if($inf_reg[$i]['Region']==$inf_comp[$j]['Region']){
				
				$region_exists=true;
				
				$calls2=(int)$inf_reg[$i]['Calls'];
				$calls2_m=(int)$inf_comp[$j]['Calls'];
				$asr2=(int)$inf_reg[$i]['ASR'];
				$asr2_m=(int)$inf_comp[$j]['ASR'];
				$ner2=(int)$inf_reg[$i]['NER'];
				$ner2_m=(int)$inf_comp[$j]['NER'];
				$minutos=(int)$inf_reg[$i]['Min'];
				$minutos_m=(int)$inf_comp[$j]['Min'];
				$acd2=(int)$inf_reg[$i]['ACD'];
				$acd2_m=(int)$inf_comp[$j]['ACD'];
				$errores=(int)$inf_reg[$i]['Errores'];
				$errores_m=(int)$inf_comp[$j]['Errores'];
				if($errores_m==0){
					$errores_m=1;
				}
				
				if($calls2 < $calls2_m*0.70 && $calls2>0){
					$dis=($calls2_m-$calls2)*100/$calls2;
					$obs[]= "-Baja de llamadas hacia ".$inf_reg[$i]['Region'].' de: <h10>'.round($dis)."%</h10>.<br>";
					//$obs.='Baja de llamadas hacia '.$inf_reg[$i]['Region'].".<br />\n";
				}
				if(($calls2 > $calls2_m*1.30) && $calls2>200){
					$dis=($calls2-$calls2_m)*100/$calls2_m;
					$obs[]= '-Aumento de llamadas hacia '.$inf_reg[$i]['Region'].' de: <h10>'.round($dis)."%</h10>.<br>";
					//$obs.='Aumento de llamadas hacia '.$inf_reg[$i]['Region'].".<br />\n";
				}
				if(($asr2_m - $asr2)>9){
					$dis=$asr2_m-$asr2;
					$obs[]='-Baja de ASR hacia '.$inf_reg[$i]['Region'].' de: <h10>'.round($dis)."%</h10>.<br>";
					//$obs.='Baja de ASR hacia '.$inf_reg[$i]['Region'].".<br />\n";
				}
				if(($ner2_m - $ner2)>9){
					$dis=$ner2_m-$ner2;
					$obs[]='-Baja de NER hacia '.$inf_reg[$i]['Region'].' de: <h10>'.round($dis)."%</h10>.<br>";
					//$obs.='Baja de NER hacia '.$inf_reg[$i]['Region'].".<br />\n";
				}
				if($minutos < ($minutos_m*0.70) && $minutos>0){
					$dis=($minutos_m-$minutos)*100/$minutos;
					$obs[]='-Baja de minutos hacia '.$inf_reg[$i]['Region'].' de: <h10>'.round($dis)."%</h10>.<br>";
					//$obs.='Baja de Minutos hacia '.$inf_reg[$i]['Region'].".<br />\n";
				}
				if(($minutos > $minutos_m*1.30) && $minutos>200){
					$dis=($minutos-$minutos_m)*100/$minutos_m;
					$obs[]='-Aumento de minutos hacia '.$inf_reg[$i]['Region'].' de: <h10>'.round($dis)."%</h10>.<br>";
					//$obs.='Aumento de Minutos hacia '.$inf_reg[$i]['Region'].".<br />\n";
				}
				if($acd2 < $acd2_m*0.70 && $acd2>0){
					$dis=($acd2_m-$acd2)*100/$acd2;
					$obs[]='-Baja de ACD hacia '.$inf_reg[$i]['Region'].' de: <h10>'.round($dis)."%</h10>.<br>";
					//$obs.='Baja de ACD hacia: '.$inf_reg[$i]['Region'].".<br />\n";
				}
				if($acd2 > $acd2_m*1.30 && $acd2_m>0){
					$dis=($acd2-$acd2_m)*100/$acd2_m;
					$obs[]='-Aumento de ACD hacia '.$inf_reg[$i]['Region'].' de: <h10>'.round($dis)."%</h10>.<br>";
					//$obs.='Aumento de ACD hacia: '.$inf_reg[$i]['Region'].".<br />\n";
				}
				if(($errores > $errores_m*1.30) && $errores>50){
					$dis=($errores-$errores_m)*100/$errores_m;
					$obs[]='-Aumento de Errores hacia '.$inf_reg[$i]['Region'].' de: <h10>'.round($dis)."%</h10>.<br>";
					//$obs.='Aumento de Errores hacia: '.$inf_reg[$i]['Region'].".<br />\n";
				}
			}
		}
		//$obs.=".<br />\n";
		if($region_exists==false){
			$obs[]='-Destino nuevo en top 10: <h10>'.$inf_reg[$i]['Region'].'.</h10><br>';
		}
	}
	
	//print_r($obs);
	
	$rows = array();

	$table = array();

	$table['cols'] = array(
		// Labels for your chart, these represent the column titles
		// Note that one column is in "string" format and another one is in "number" format as pie chart only required "numbers" for calculating percentage and string will be used for column title
		array('label' => 'Region', 'type' => 'string'),
		array('label' => 'Minutes', 'type' => 'number'),
		array('label' => 'Calls', 'type' => 'number'),
		array('label' => 'Errores', 'type' => 'number'),
		array('label' => 'ASR', 'type' => 'number'),
		array('label' => 'NER', 'type' => 'number'),
		array('label' => 'ACD', 'type' => 'number'),
	);
	foreach($res3 as $tr) {
    $temp = array();

     foreach($tr as $key=>$value){

    // the following line will be used to slice the Pie chart

    // Values of each slice
    $temp[] = array('v' => $value);     
    }
  $rows[] = array('c' => $temp); 
}

$table['rows'] = $rows;
//print_r($table['rows'][1]['c'][2]['v']);
$asr = array('asr'=>$asr);
$ner = array('ner'=>$ner);
$calls = array('calls'=>$calls);
$min = array('min'=>$min);
$mean_asr = array('mean_asr'=>$mean_asr);
$mean_ner = array('mean_ner'=>$mean_ner);
$mean_calls = array('mean_calls'=>$mean_calls);
$mean_min = array('mean_min'=>$mean_min);
$reg_name0 = array('reg_name0'=>$reg_name[0]);
$reg_name1 = array('reg_name1'=>$reg_name[1]);
$reg_name2 = array('reg_name2'=>$reg_name[2]);
$reg_name3 = array('reg_name3'=>$reg_name[3]);
$reg_name4 = array('reg_name4'=>$reg_name[4]);
$reg_min0 = array('reg_min0'=>$reg_min[0]);
$reg_min1 = array('reg_min1'=>$reg_min[1]);
$reg_min2 = array('reg_min2'=>$reg_min[2]);
$reg_min3 = array('reg_min3'=>$reg_min[3]);
$reg_min4 = array('reg_min4'=>$reg_min[4]);
$callsOthers = array('callsOthers'=>$callsOthers);
$table = array('table'=>$table);
$obs = array('obs'=>$obs);

$final = $asr + $ner + $calls + $min + $mean_asr + $mean_ner + $mean_calls + $mean_min + $reg_name0 + $reg_name1 + $reg_name2 + $reg_name3 + $reg_name4 + $reg_min0 + $reg_min1 + $reg_min2 + $reg_min3 + $reg_min4 
+ $callsOthers + $table + $obs;

$jsonTable = json_encode($final);
echo $jsonTable;
//print_r($table['rows'][1]['c']);
?>
	
