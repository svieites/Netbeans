<?php
include('lock.php');
?>
 <?php
	
	include('Pivot.php');
	include('conexion.php');

	$sql  ="SELECT if(week(Fecha)=0,52,if(week(Fecha)=53,1,week(Fecha))) WEEKS,DAYNAME(Fecha) DAY, TRUNCATE(ASR,2) ASR,TRUNCATE(NER,2) NER,FECHA DATE FROM ASR_NER 
	WHERE if(week(Fecha)=0,52,if(week(Fecha)=53,1,week(Fecha))) 
	IN(if(week(sysdate())=0,52,if(week(sysdate())=53,1,week(sysdate()))),
	if(week(date_sub(sysdate(), interval 1 week))=0,52,if(week(date_sub(sysdate(), interval 1 week))=53,1,week(date_sub(sysdate(), interval 1 week)))),
	if(week(date_sub(sysdate(), interval 2 week))=0,52,if(week(date_sub(sysdate(), interval 2 week))=53,1,week(date_sub(sysdate(), interval 2 week)))),
	if(week(date_sub(sysdate(), interval 3 week))=0,52,if(week(date_sub(sysdate(), interval 3 week))=53,1,week(date_sub(sysdate(), interval 3 week)))))
	AND Pais = 'TrinidadTobago' AND Fecha BETWEEN  DATE(date_sub(sysdate(), interval 28 DAY)) AND DATE(SYSDATE()) ORDER BY DAYOFWEEK(FECHA),FECHA DESC";
    $sql2 ="select round((sum(Calls)-sum(Errors_ASR))*100/(sum(Calls))) Mean_ASR, round((sum(Calls)-sum(Errors_NER))*100/(sum(Calls))) Mean_NER from ASR_NER_Errors where dayname(Fecha) = dayname(now()) and Fecha between date(date_sub(sysdate(), interval 100 day)) and date(date_sub(sysdate(), interval 1 day)) and Pais = 'TrinidadTobago'";
    $sql3 = "select ASR,NER,Last_Update from ASR_NER_Min_Temp where Pais = 'TrinidadTobago'";
	
	$r = $mysqli->query($sql) or die($mysqli->error.__LINE__);
	$r2 = $mysqli->query($sql2) or die($mysqli->error.__LINE__);
	$r3 = $mysqli->query($sql3) or die($mysqli->error.__LINE__);
	
    $res = array();
	$res2 = array();
	$res3 = array();
	$res4 = array();
	
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
	$mean_asr=$arr['Mean_ASR'];
	$mean_ner=$arr['Mean_NER'];

	$arr2=$res3[0];
	$asr=$arr2['ASR'];
	$ner=$arr2['NER'];
	$update=$arr2['Last_Update'];
	
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
	
    $jsonTable = json_encode($table);
	$jsonTable2 = json_encode($table2);

?>
<html>
<TITLE>TrinidadTobago</TITLE>
  <head>
  
  <!-- compatibilidad de explorer  -->
  <meta http-equiv="X-UA-Compatible" content="IE=10" />
    <link href='stylecss.css' rel='stylesheet' type "text/css"/>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load('visualization', '1', {'packages':['corechart','gauge']});
      google.setOnLoadCallback(init);
      
	  function init(){
	  
		var data = new google.visualization.DataTable(<?=$jsonTable?>);
		
		var data4 = new google.visualization.DataTable(<?=$jsonTable2?>);
         
        var data2 = new google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['ASR', <?=$asr?>],
          
        ]);
		
		var data3 = new google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['NER', <?=$ner?>],
          
        ]);
		
		 var options = {
		 legend:{textStyle:{color: '#000000',fontSize: '10'}},
		 title:'ASR Weekly Trinidad & Tobago',
		 backgroundColor: 'transparent',
		 //title: 'ASR Panama',
		  hAxis: {textStyle:{color: '#000000',fontSize:'10'},direction:1, slantedText:true, slantedTextAngle:45 },
		  vAxis: {textStyle:{color: '#000000',fontSize: '12', paddingRight: '100',marginRight: '100'}},
		  //hAxis: {title: 'Día', titleTextStyle: {color: 'red'}},
          is3D: 'true',
          width: 650,
          height: 250,
		  pointSize: 8,
		  colors: ['#F96302', '#CC0C00', '#00BFFF', '#7FBA00'],
          series: {
                0: { pointShape: 'circle' },
                1: { pointShape: 'triangle' },
                2: { pointShape: 'square' },
                3: { pointShape: 'diamond' },
              //  4: { pointShape: 'star' },
                //5: { pointShape: 'polygon' }
            }
		  
        };

        var options2 = {
          width: 280, height: 140,
          greenFrom: <?=($mean_asr-2)?>, greenTo: 100,
          yellowFrom:<?=($mean_asr-12)?>, yellowTo: <?=($mean_asr-2)?>,
          minorTicks: 5
        };

		var options3 = {
          width: 300, height: 150,
          greenFrom: <?=($mean_ner-2)?>, greenTo: 100,
          yellowFrom:<?=($mean_ner-12)?>, yellowTo: <?=($mean_ner-2)?>,
          minorTicks: 5
        };
		
		var options4 = {
		legend: {textStyle:{color: '#000000', fontSize: '10'}},
		title:'NER Weekly Trinidad & Tobago',
		 backgroundColor: 'transparent',		
		// title: 'ASR Panama',
		  hAxis: {textStyle:{color: '#000000', fontSize: '10'},direction:1, slantedText:true, slantedTextAngle:45},
		  vAxis: {textStyle:{color: '#000000', fontSize: '12'}},
		  //hAxis: {title: 'Día', titleTextStyle: {color: 'red'}},
          is3D: 'true',
          width: 650,
          height: 250,
		  pointSize: 8,
		  colors: ['#F96302', '#CC0C00', '#00BFFF', '#7FBA00'],
          series: {
                0: { pointShape: 'circle' },
                1: { pointShape: 'triangle' },
               2: { pointShape: 'square' },
                3: { pointShape: 'diamond' },
              //  4: { pointShape: 'star' },
                //5: { pointShape: 'polygon' }
            }
        };
			
		function drawChart() {
		
		var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    
        var chart2 = new google.visualization.Gauge(document.getElementById('chart_div2'));
		chart2.draw(data2, options2);
		
		var chart3 = new google.visualization.Gauge(document.getElementById('chart_div3'));
		chart3.draw(data3,options3);
		
		var chart4 = new google.visualization.LineChart(document.getElementById('chart_div4'));
		chart4.draw(data4,options4);

      }
	  drawChart(); 
	  }
	  
    </script>
  </head>
  <body>
 <table>
	<tr>
		<td>
		<br><br>
			
			<div id="chart_div"> </div>		
		</td>
<td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</td>		
		<td>	
			<br><br><br><br><div id="chart_div2"> </div>
			<center> <h2> Last Update:  </h2>
			 <p><h2><?php echo $update?></h2></p></center>
		</td>	
	</tr>
	
		<tr>
			<td>
				&nbsp;
				<div id="chart_div4"></div>
			</td>

<td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</td>				
			<td>
			<br><br><br><div id="chart_div3">
			
			<CENTER><h2>Last Update: <?php echo $update?></div></h2></center>
			<CENTER><h2>Last Update: <P><?php echo $update?></P></h2></center>
			</td>
		</tr>
		
	</table>
	

	</body>
</html>