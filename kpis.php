<?php

	include('conexion.php');
	
	$date1=$_POST['begin_date'];
	$date2=$_POST['end_date'];
	$v=$_POST['country'];
	$country='';
	
	$res = array();
	
	//$v=0;
	//$date1 = '2014-12-01';
	//$date2 = '2014-12-29';
	
	if($v==0){$country='TrinidadTobago';}
	else if($v==1){$country='Grenada';}
	else if($v==2){$country='Jamaica';}
	else if($v==3){$country='Curacao';}
	else if($v==4){$country='Panama';}
	else if($v==5){$country='Honduras';}
	else if($v==6){$country='Barbados';}
	else if($v==7){$country='PuertoRico';}
	
	if($v==8){
		$sql = "SELECT DATE Date, SUM(SAFARI_MTA_SUB_COUNT) Safari_MTA_Count, SUM(SAFARI_SIP_EP_SUB_COUNT) Safari_SIP_Count, SUM(TOTAL) AS Tot_Subs, 
		SUM(SUBS_WEEKLY_MINS) Subs_Weekly_Mins ,SUM(CORPORATE_SIP_TRUNKS_WEEKLY_MINS) Corporate_SIP_Mins FROM MASTER_WEEKLY_REPORT 
		WHERE DATE BETWEEN '$date1' AND '$date2' AND COUNTRY IN ('TrinidadTobago','Jamaica','Grenada','Curacao') GROUP BY DATE ORDER BY DATE ASC";
	}else if($v==9){
		$sql = "SELECT DATE Date, SUM(BUSINESS_GROUPS) Business_Groups_Qty, SUM(TOTAL_WEEKLY_MINS) Tot_Weekly_Mins FROM MASTER_WEEKLY_REPORT 
			WHERE DATE BETWEEN '$date1' AND '$date2' AND COUNTRY IN ('Panama','Honduras','PuertoRico','Barbados') GROUP BY DATE ORDER BY DATE ASC";
	}else{
		$sql = "SELECT DATE Date,SAFARI_MTA_SUB_COUNT Safari_MTA_Count,SAFARI_SIP_EP_SUB_COUNT Safari_SIP_Count,TOTAL Tot_Subs,SUBS_WEEKLY_MINS Subs_Weekly_Mins,CORPORATE_SIP_TRUNKS_WEEKLY_MINS Corporate_SIP_Mins,
		META_SUBS_COUNT Meta_Subs_Count,TRIM(TRAILING SUBSTRING(SIP_BINDING_ACTIVE_LICENSES,-4) FROM SIP_BINDING_ACTIVE_LICENSES) SIP_Binding_Active_Licenses,
		BUSINESS_GROUPS Business_Groups_Qty,TOTAL_WEEKLY_MINS Tot_Weekly_Mins,SIP_TRUNKS_QTY SIP_Trunks_Qty,MAX_ACTIVE_CALLS Max_Active_Calls,TOTAL_CALIX_SUBS Calix_Subs_Qty,TOTAL_CALIX_SUBS_MIN Tot_Calix_Subs_Mins
		FROM MASTER_WEEKLY_REPORT WHERE DATE BETWEEN '$date1' AND '$date2' AND COUNTRY = '$country' ORDER BY DATE ASC";
	}
	
	$r = $mysqli->query($sql) or die($mysqli->error.__LINE__);
	
	while($result = $r->fetch_assoc()){
		$res[] = $result;
	}
	//these titles are the legends for the charts
	$title1 = '';
	$title2 = '';
	$title3 = '';
	
	switch($v){
		case 0:
			
			$titulos_table = array('Date','Safari_MTA_Count','Safari_SIP_Count','Tot_Subs','Subs_Weekly_Mins','Corporate_SIP_Mins');
				
			$titulos_graph1 = array('Date','Subs_Weekly_Mins');
				
			$titulos_graph2 = array('Date','Safari_MTA_Count','Tot_Subs','Safari_SIP_Count');
				
			$titulos_graph3 = array('Date','Corporate_SIP_Mins');
			
			$title1 = 'Minutes';
			$title2 = 'Qty';
			$title3 = 'Minutes';
			break;
		case 1:
				
			$titulos_table = array('Date','Safari_MTA_Count','Safari_SIP_Count','Tot_Subs','Subs_Weekly_Mins','Corporate_SIP_Mins');
				
			$titulos_graph1 = array('Date','Subs_Weekly_Mins');
				
			$titulos_graph2 = array('Date','Safari_MTA_Count','Tot_Subs','Safari_SIP_Count');
				
			$titulos_graph3 = array('Date','Corporate_SIP_Mins');
			
			$title1 = 'Minutes';
			$title2 = 'Qty';
			$title3 = 'Minutes';
			break;
		case 2:
						
			$titulos_table = array('Date','Safari_MTA_Count','Safari_SIP_Count','Tot_Subs','Subs_Weekly_Mins');
				
			$titulos_graph1 = array('Date','Safari_MTA_Count','Tot_Subs');
				
			$titulos_graph2 = array('Date','Safari_SIP_Count');
			
			$title1 = 'Qty';
			$title2 = 'Qty';
			break;
		case 3:
			
			$titulos_table = array('Date','Safari_MTA_Count','Safari_SIP_Count','Tot_Subs','Subs_Weekly_Mins','Corporate_SIP_Mins');
				
			$titulos_graph1 = array('Date','Subs_Weekly_Mins','Corporate_SIP_Mins');
				
			$titulos_graph2 = array('Date','Safari_MTA_Count','Tot_Subs');
				
			$titulos_graph3 = array('Date','Safari_SIP_Count');
			
			$title1 = 'Minutes';
			$title2 = 'Qty';
			$title3 = 'Qty';
			break;
		case 4:
				
			$titulos_table = array('Date','Meta_Subs_Count','SIP_Binding_Active_Licenses','Business_Groups_Qty','Tot_Weekly_Mins');
				
			$titulos_graph1 = array('Date','SIP_Binding_Active_Licenses','Business_Groups_Qty');
				
			$titulos_graph2 = array('Date','Meta_Subs_Count');
				
			$titulos_graph3 = array('Date','Tot_Weekly_Mins');
			
			$title1 = 'Qty';
			$title2 = 'Qty';
			$title3 = 'Minutes';
			break;
		case 5:
				
			$titulos_table = array('Date','Meta_Subs_Count','SIP_Trunks_Qty','Business_Groups_Qty','Tot_Weekly_Mins','Max_Active_Calls');
				
			$titulos_graph1 = array('Date','SIP_Trunks_Qty','Business_Groups_Qty','Max_Active_Calls');
				
			$titulos_graph2 = array('Date','Tot_Weekly_Mins');
				
			$titulos_graph3 = array('Date','Meta_Subs_Count');
			
			$title1 = 'Qty';
			$title2 = 'Minutes';
			$title3 = 'Qty';
			break;
		case 6:
				
			$titulos_table = array('Date','SIP_Trunks_Qty','Business_Groups_Qty','Tot_Weekly_Mins','Calix_Subs_Qty','Tot_Calix_Subs_Mins');
				
			$titulos_graph1 = array('Date','SIP_Trunks_Qty','Business_Groups_Qty');
				
			$titulos_graph2 = array('Date','Tot_Weekly_Mins','Tot_Calix_Subs_Mins');
				
			$titulos_graph3 = array('Date','Calix_Subs_Qty');
			
			$title1 = 'Qty';
			$title2 = 'Minutes';
			$title3 = 'Qty';
			break;
		case 7:
			
			$titulos_table = array('Date','Tot_Weekly_Mins','Business_Groups_Qty','SIP_Trunks_Qty','Max_Active_Calls');
				
			$titulos_graph1 = array('Date','Tot_Weekly_Mins');
				
			$titulos_graph2 = array('Date','Business_Groups_Qty','SIP_Trunks_Qty','Max_Active_Calls');
			
			$title1 = 'Minutes';
			$title2 = 'Qty';
			
			break;
		case 8:
			
			$titulos_table = array('Date','Safari_MTA_Count','Safari_SIP_Count','Tot_Subs','Subs_Weekly_Mins','Corporate_SIP_Mins');
				
			$titulos_graph1 = array('Date','Safari_MTA_Count','Safari_SIP_Count','Tot_Subs');
				
			$titulos_graph2 = array('Date','Subs_Weekly_Mins');
				
			$titulos_graph3	= array('Date','Corporate_SIP_Mins');
			
			$title1 = 'Qty';
			$title2 = 'Minutes';
			$title3 = 'Minutes';
			break;
		case 9:
			
			$titulos_table = array('Date','Business_Groups_Qty','Tot_Weekly_Mins');
				
			$titulos_graph1 = array('Date','Business_Groups_Qty');
				
			$titulos_graph2 = array('Date','Tot_Weekly_Mins');
			
			$title1 = 'Qty';
			$title2 = 'Minutes';
			
			break;
	}
	
	//these are the names of values to display on the charts
	$titles_graph1 = array();
	$titles_graph2 = array();
	$titles_graph3 = array();
	
	for($i = 0; $i < sizeof($titulos_graph1); $i++){
		$titu = str_replace("_", " ", $titulos_graph1[$i]);
		$titles_graph1[] = $titu;
	}
	
	for($i = 0; $i < sizeof($titulos_graph2); $i++){
		$titu = str_replace("_", " ", $titulos_graph2[$i]);
		$titles_graph2[] = $titu;
	}
	
	for($i = 0; $i < sizeof($titulos_graph3); $i++){
		$titu = str_replace("_", " ", $titulos_graph3[$i]);
		$titles_graph3[] = $titu;
	}
	
	/*for($i = 1; $i < sizeof($titulos_table); $i++){
		$titulos_table = str_replace("_", " ", $titulos_table[$i]);
	}*/
	
	$resultado1 = array();
	$resultado2 = array();
	$resultado3 = array();
	$resultado4 = array();
	
	for($i = 0; $i < sizeof($res); $i++){
		for($j = 0; $j < sizeof($titulos_table); $j++){
			$resultado1[$i][] = $res[$i][$titulos_table[$j]];
		}
	}
	for($i = 1; $i < sizeof($titulos_graph1); $i++){
		$resultado2[$i-1]['name'] = $titles_graph1[$i];
		$arreglo = arrayColumn($res,$titulos_graph1[$i]);
		$arr = array();
		foreach($arreglo as $val){
			$arr[] = (int)$val;
		}
		$resultado2[$i-1]['data'] = $arr;
	}
	for($i = 1; $i < sizeof($titulos_graph2); $i++){
		$resultado3[$i-1]['name'] = $titles_graph2[$i];
		$arreglo = arrayColumn($res,$titulos_graph2[$i]);
		$arr = array();
		foreach($arreglo as $val){
			$arr[] = (int)$val;
		}
		$resultado3[$i-1]['data'] = $arr;
	}
	for($i = 1; $i < sizeof($titulos_graph3); $i++){
		$resultado4[$i-1]['name'] = $titles_graph3[$i];
		$arreglo = arrayColumn($res,$titulos_graph3[$i]);
		$arr = array();
		foreach($arreglo as $val){
			$arr[] = (int)$val;
		}
		$resultado4[$i-1]['data'] = $arr;
	}
	//Gets the column from the matrix
	function arrayColumn(array $array, $column_key, $index_key=null){
        if(function_exists('array_column ')){
            return array_column($array, $column_key, $index_key);
        }
        $result = array();
        foreach($array as $arr){
            if(!is_array($arr)) continue;

            if(is_null($column_key)){
                $value = $arr;
            }else{
                $value = $arr[$column_key];
            }

            if(!is_null($index_key)){
                $key = $arr[$index_key];
                $result[$key] = $value;
            }else{
                $result[] = $value;
            }

        }

        return $result;
    }
	//table for the google table 
	$table = array();
	$rows = array();
	
	$table['cols'] = array(
		
		array('label' => 'Date', 'type' => 'string'),
		
	);
	
	for($i = 1; $i < sizeof($titulos_table); $i++){
		$titulo = str_replace("_", " ", $titulos_table[$i]);
		array_push($table['cols'],array('label' => $titulo, 'type' => 'number'));
	}
	
	foreach($resultado1 as $tr) {
		$temp = array();

		 foreach($tr as $key=>$value){
		 
		// the following line will be used to slice the Pie chart

		// Values of each slice
		$temp[] = array('v' => $value);
		}
	  $rows[] = array('c' => $temp);
	}
	$table['rows']=$rows;
	
	$categories = arrayColumn($res,'Date');
	
	$result=array();
	$result2=array();
	$result3=array();
	$result4=array();
	
	/*for($i = 0; $i < sizeof($resultado1); $i++){
		array_push($result,$resultado1[$i]);
	}*/
	for($i = 0; $i < sizeof($resultado2); $i++){
		array_push($result2,$resultado2[$i]);
	}
	for($i = 0; $i < sizeof($resultado3); $i++){
		array_push($result3,$resultado3[$i]);
	}
	for($i = 0; $i < sizeof($resultado4); $i++){
		array_push($result4,$resultado4[$i]);
	}
	$categories = array('categories'=>$categories);
	$data1 = array('data1'=>$table);
	$data2 = array('data2'=>$result2);
	$data3 = array('data3'=>$result3);
	$data4 = array('data4'=>$result4);
	$title1 = array('title1'=>$title1);
	$title2 = array('title2'=>$title2);
	$title3 = array('title3'=>$title3);
	
	if($title3 != ''){
		$final = $categories + $data1 + $data2 + $data3 + $data4 + $title1 + $title2 + $title3;
	}else{
		$final = $categories + $data1 + $data2 + $data3 + $data4 + $title1 + $title2;
	}
	$jsonTable = json_encode($final);
	echo $jsonTable;
?>