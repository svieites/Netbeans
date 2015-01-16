<?php
include('lock.php');
?>

<?php
	
	$DB_NAME = 'VQA_REPORT';
	$DB_HOST = '192.168.100.17';
	$DB_USER = 'admin';
	$DB_PASS = 'vqaadmin!';

	$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

    $sql  ="select round(sum(Minutes)) Min,sum(Errors_ASR) Errores,sum(Calls) Calls,round((sum(Calls)-sum(Errors_ASR))*100/sum(Calls)) ASR, 
	truncate(sum(ACD)/count(*),2) ACD,round((sum(Calls)-sum(Errors_NER))*100/sum(Calls)) NER
	from Indicadores_Temp where Pais='Panama' and Hora between '0' and hour(now())+1";
	
	$sql2 = "select Min,Errores,Calls,ASR,ACD,NER from Indicadores_Actuales where Pais= 'Panama'";
	
	$sql3 ="select Region_Code Region,truncate(sum(B.Duration)/ 60,2) Min, count(*) Calls , sum(Errors_ASR) Errores,round((count(*)-sum(Errors_ASR))*100/count(*)) ASR,
	round((count(*)-sum(Errors_NER))*100/count(*)) NER, sum(B.Duration)/((count(*)-sum(Errors_ASR))*60) ACD
	from VQAS3.Panama B where date(Start_Time)=date(now()) and hour(Start_Time) between '0' and hour(now())+1 group by Region_Code order by Min desc limit 0,5";
	
	$sql4 = "select Region,truncate(sum(Minutes),2) Min,sum(Calls) Calls, sum(Errors_ASR) Errores, round((sum(Calls)-sum(Errors_ASR))*100/sum(Calls)) ASR,
	round((sum(Calls)-sum(Errors_NER))*100/sum(Calls)) NER, truncate((sum(Minutes)/(sum(calls)-sum(Errors_ASR))),2) ACD
	from Indicadores_Temp_Region where Pais ='Panama' and Hora between '0' and hour(now())+1
	group by Region order by Min desc limit 0,10";
	
	$sql5 = "select Last_Update LastUp,Min totMin from VQAS3.ASR_NER_Min_Temp where Pais='Panama'";
	
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
	
	$obs="";
	$obs.="Last Update (GMT-4): ".$last_update."<br />\n";
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
				
				if($calls2 < $calls2_m*0.70){
					$dis=($calls2_m-$calls2)*100/$calls2;
					$obs.= "Baja de llamadas hacia ".$inf_reg[$i]['Region'].' de '.round($dis)."%.<br />\n";
					//$obs.='Baja de llamadas hacia '.$inf_reg[$i]['Region'].".<br />\n";
				}
				if(($calls2 > $calls2_m*1.30) && $calls2>200){
					$dis=($calls2-$calls2_m)*100/$calls2_m;
					$obs.= 'Aumento de llamadas hacia '.$inf_reg[$i]['Region'].' de '.round($dis)."%.<br />\n";
					//$obs.='Aumento de llamadas hacia '.$inf_reg[$i]['Region'].".<br />\n";
				}
				if(($asr2_m - $asr2)>9){
					$dis=$asr2_m-$asr2;
					$obs.='Baja de ASR hacia '.$inf_reg[$i]['Region'].' de '.round($dis)."%.<br />\n";
					//$obs.='Baja de ASR hacia '.$inf_reg[$i]['Region'].".<br />\n";
				}
				if(($ner2_m - $ner2)>9){
					$dis=$ner2_m-$ner2;
					$obs.='Baja de NER hacia '.$inf_reg[$i]['Region'].' de: '.round($dis)."%.<br />\n";
					//$obs.='Baja de NER hacia '.$inf_reg[$i]['Region'].".<br />\n";
				}
				if($minutos < ($minutos_m*0.70)){
					$dis=($minutos_m-$minutos)*100/$minutos;
					$obs.='Baja de minutos hacia '.$inf_reg[$i]['Region'].' de: '.round($dis)."%.<br />\n";
					//$obs.='Baja de Minutos hacia '.$inf_reg[$i]['Region'].".<br />\n";
				}
				if(($minutos > $minutos_m*1.30) && $minutos>200){
					$dis=($minutos-$minutos_m)*100/$minutos_m;
					$obs.='Aumento de minutos hacia '.$inf_reg[$i]['Region'].' de: '.round($dis)."%.<br />\n";
					//$obs.='Aumento de Minutos hacia '.$inf_reg[$i]['Region'].".<br />\n";
				}
				if($acd2 < $acd2_m*0.70){
					$dis=($acd2_m-$acd2)*100/$acd2;
					$obs.='Baja de ACD hacia '.$inf_reg[$i]['Region'].' de: '.round($dis)."%.<br />\n";
					//$obs.='Baja de ACD hacia: '.$inf_reg[$i]['Region'].".<br />\n";
				}
				if($acd2 > $acd2_m*1.30){
					$dis=($acd2-$acd2_m)*100/$acd2_m;
					$obs.='Aumento de ACD hacia '.$inf_reg[$i]['Region'].' de '.round($dis)."%.<br />\n";
					//$obs.='Aumento de ACD hacia: '.$inf_reg[$i]['Region'].".<br />\n";
				}
				if(($errores > $errores_m*1.30) && $errores>50){
					$dis=($errores-$errores_m)*100/$errores_m;
					$obs.='Aumento de Errores hacia '.$inf_reg[$i]['Region'].' de '.round($dis)."%.<br />\n";
					//$obs.='Aumento de Errores hacia: '.$inf_reg[$i]['Region'].".<br />\n";
				}
			}
		}
		//$obs.=".<br />\n";
		if($region_exists==false){
			$obs.='Destino nuevo en top 10: '.$inf_reg[$i]['Region'].".<br />\n";
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
$jsonTable = json_encode($table);
//print_r($table['rows'][1]['c']);
?>
	
<html>
  <head>

     <table style="width: 100%;" border="0" cellspacing="0">
      <tbody>
        <tr>
          <td>&nbsp;&nbsp;&nbsp; </td>
          <td><img src="imagenes/panama.png" height="40" width="40"><a href='VQA_Report.html'><img src="imagenes/undo.png" height="40" width="40"></a></td>
        </tr>
      </tbody>
    </table>
  
  
  
  
  <link href='stylesheet3.css' rel='stylesheet' type "text/css"/>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["gauge","table","corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {

        var data = new google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['ASR', <?=$asr?>],
          
        ]);
		
		var data2 = new google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['NER', <?=$ner?>],
          
        ]);
		
		var data3 = new google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['Calls', <?=$calls?>],
          
        ]);
		
		var data4 = new google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['ACD', <?=$acd?>],
          
        ]);
		
		var data5 = new google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['Errors', <?=$errors?>],
          
        ]);
		
		var data6 = new google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['Min', <?=$min?>],
          
        ]);
		
		var data7 = new google.visualization.DataTable(<?=$jsonTable?>);
		
		var data8 = new google.visualization.arrayToDataTable([
			['Region','<?=$reg_name[0]?>','<?=$reg_name[1]?>','<?=$reg_name[2]?>','<?=$reg_name[3]?>','<?=$reg_name[4]?>','Others',{ role: 'annotation' } ],
			['Min per Region',<?=$reg_min[0]?>,<?=$reg_min[1]?>,<?=$reg_min[2]?>,<?=$reg_min[3]?>,<?=$reg_min[4]?>,<?=$callsOthers?>,''],
		
		]);
		
		var table = new google.visualization.Table(document.getElementById('table_div'));
		
        var options = {
          width: 300, height: 160,
          greenFrom: <?=($mean_asr-2)?>, greenTo: 100,
          yellowFrom:<?=($mean_asr-12)?>, yellowTo: <?=($mean_asr-2)?>,
          minorTicks: 5
        };

		var options2 = {
          width: 300, height: 160,
          greenFrom: <?=($mean_ner-2)?>, greenTo: 100,
          yellowFrom:<?=($mean_ner-12)?>, yellowTo: <?=($mean_ner-2)?>,
          minorTicks: 5
        };
		
		var options3 = {
	
          width: 300, height: 160,
          yellowFrom:<?=($mean_calls*0.85)?>, yellowTo: <?=($mean_calls*0.9)?>,
		  greenFrom: <?=($mean_calls*0.9)?>, greenTo: <?=($mean_calls*1.1)?>,
		  redFrom:<?=($mean_calls*1.1)?>,redTo: <?=($mean_calls*1.15)?>,
		  redColor:'#FF9900',
          minorTicks: 5,
		  max: <?=($mean_calls*2)?>
        };
		
		var options4 = {
          width: 300, height: 160,
          yellowFrom:<?=($mean_acd*0.85)?>, yellowTo: <?=($mean_acd*0.9)?>,
		  greenFrom: <?=($mean_acd*0.9)?>, greenTo: <?=($mean_acd*1.1)?>,
		  redFrom:<?=($mean_acd*1.1)?>,redTo: <?=($mean_acd*1.15)?>,
		  redColor:'#FF9900',
          minorTicks: 5,
		  max: <?=($mean_acd*2)?>
        };
		
		var options5 = {
          width: 300, height: 160,
          yellowFrom:<?=($mean_errors*0.85)?>, yellowTo: <?=($mean_errors*0.9)?>,
		  greenFrom: <?=($mean_errors*0.9)?>, greenTo: <?=($mean_errors*1.1)?>,
		  redFrom:<?=($mean_errors*1.1)?>,redTo: <?=($mean_errors*1.15)?>,
		  redColor:'#FF9900',
          minorTicks: 5,
		  max: <?=($mean_errors*2)?>
        };
		
		var options6 = {
          width: 300, height: 160,
          yellowFrom:<?=($mean_min*0.85)?>, yellowTo: <?=($mean_min*0.9)?>,
		  greenFrom: <?=($mean_min*0.9)?>, greenTo: <?=($mean_min*1.1)?>,
		  redFrom:<?=($mean_min*1.1)?>,redTo: <?=($mean_min*1.15)?>,
		  redColor:'#FF9900',
          minorTicks: 5,
		  max: <?=($mean_min*2)?>
        };
		
	var options8 = {
		backgroundColor: 'transparent',
			width: 900,
			height: 100,
			 hAxis: {textStyle:{color: '#FFFFFF'}},
			vAxis: {textStyle:{color: '#FFFFFF'}},
			legend: {textStyle:{color: '#FFFFFF'}, position: 'top', maxLines: 0 },
			bar: { groupWidth: '75%' },
			isStacked: true
      };
	  
        var chart = new google.visualization.Gauge(document.getElementById('chart_div'));
		chart.draw(data, options);
		
		var chart2 = new google.visualization.Gauge(document.getElementById('chart_div2'));
		chart2.draw(data2,options2);
		
		var chart3 = new google.visualization.Gauge(document.getElementById('chart_div3'));
		chart3.draw(data3,options3);
		
		//var chart4 = new google.visualization.Gauge(document.getElementById('chart_div4'));
		//chart4.draw(data4,options4);
		
		//var chart5 = new google.visualization.Gauge(document.getElementById('chart_div5'));
		//chart5.draw(data5,options5);
		
		var chart6 = new google.visualization.Gauge(document.getElementById('chart_div6'));
		chart6.draw(data6,options6);
		
		//var formatter = new google.visualization.ColorFormat();
		//formatter.addRange(0,1000, 'red', '');
		//formatter.format(data7,1);
		table.draw(data7, {allowHtml: true,showRowNumber: true});
		
		var chart7 = new google.visualization.BarChart(document.getElementById('bar_div'));
		chart7.draw(data8,options8);
      }
    </script>
  </head>
  <body>
	<center><table>
	
	<tr>
		<td>
			<div id="chart_div"align="justify"></div>
		</td>	
		<td>	
			<div id="chart_div2"align="justify"></div>
		</td>	
		<td>	
			<div id="chart_div3"align="justify"></div>
		</td>	
			
		<td>	
			<div id="chart_div6"align="justify"></div>
		</td>
		</tr>
		
	
	</table></center>
	<center><tr>
		<br><td>
			<div id="table_div" style="width:900px"></div>
		</td>	
	</tr></center>	
	
	<center><br><tr>
		<td>
			
		<font color="white">	<b><?=$obs?></b>
		</td>	</font>
	</tr></center>

		<center><br><tr>
		<td>
			<div id="bar_div"></div>
			
		</td>	
	</tr></center>
	
  </body>
</html>
