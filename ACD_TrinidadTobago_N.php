<?php
include('lock.php');
?>

<?php
	
	include('conexion.php');

	$sql5 = "SELECT Fecha,ASR,NER,ACD FROM ASR_NER where Pais = 'TrinidadTobago' and Fecha between date(date_sub(now(), interval 30 day)) and date(now())";
	$sql6 = "SELECT Fecha,ASR,NER,ACD FROM ASR_NER where Pais = 'TrinidadTobago' and Fecha between date(date_sub(now(), interval 45 day)) and date(now())";
	$sql7 = "SELECT Fecha,ASR,NER,ACD FROM ASR_NER where Pais = 'TrinidadTobago' and Fecha between date(date_sub(now(), interval 60 day)) and date(now())";
	$sql8 = "SELECT Fecha,ASR,NER,ACD FROM ASR_NER where Pais = 'TrinidadTobago' and Fecha between date(date_sub(now(), interval 10 day)) and date(now())";
	$sql9 = "SELECT Fecha,ASR,NER,ACD FROM ASR_NER where Pais = 'TrinidadTobago' and Fecha between date(date_sub(now(), interval 20 day)) and date(now())";

	$r5 = $mysqli->query($sql5) or die($mysqli->error.__LINE__);
	$r6 = $mysqli->query($sql6) or die($mysqli->error.__LINE__);
	$r7 = $mysqli->query($sql7) or die($mysqli->error.__LINE__);
	$r8 = $mysqli->query($sql8) or die($mysqli->error.__LINE__);
	$r9 = $mysqli->query($sql9) or die($mysqli->error.__LINE__);

	$res5 = array();
	$res6 = array();
	$res7 = array();
	$res8 = array();
	$res9 = array();

	while($result = $r5->fetch_assoc()) {
		$res5[] = $result;	
	}
	while($result = $r6->fetch_assoc()) {
		$res6[] = $result;	
	}
	while($result = $r7->fetch_assoc()) {
		$res7[] = $result;	
	}
	while($result = $r8->fetch_assoc()) {
		$res8[] = $result;	
	}
	while($result = $r9->fetch_assoc()) {
		$res9[] = $result;	
	}
	
	//print_r($mean_asr);

	  $rows3 = array();
      $rows4 = array();
	  $rows5 = array();
	  $rows6 = array();
	  $rows7 = array();
	  //flag is not needed

	  $table3 = array();
	  $table4 = array();
	  $table5 = array();
	  $table6 = array();
	  $table7 = array();
	  
	 $table3['cols'] = array(
    // Labels for your chart, these represent the column titles
    // Note that one column is in "string" format and another one is in "number" format as pie chart only required "numbers" for calculating percentage and string will be used for column title
    array('label' => 'Fecha', 'type' => 'string'),
    array('label' => 'ASR', 'type' => 'number'),
    array('label' => 'NER', 'type' => 'number'),
    array('label' => 'ACD', 'type' => 'number'),
    );
	
	$table4['cols'] = array(
    // Labels for your chart, these represent the column titles
    // Note that one column is in "string" format and another one is in "number" format as pie chart only required "numbers" for calculating percentage and string will be used for column title
    array('label' => 'Fecha', 'type' => 'string'),
    array('label' => 'ASR', 'type' => 'number'),
    array('label' => 'NER', 'type' => 'number'),
    array('label' => 'ACD', 'type' => 'number'),
    );

	 $table5['cols'] = array(
    // Labels for your chart, these represent the column titles
    // Note that one column is in "string" format and another one is in "number" format as pie chart only required "numbers" for calculating percentage and string will be used for column title
    array('label' => 'Fecha', 'type' => 'string'),
    array('label' => 'ASR', 'type' => 'number'),
    array('label' => 'NER', 'type' => 'number'),
    array('label' => 'ACD', 'type' => 'number'),
    );
	
	 $table6['cols'] = array(
    // Labels for your chart, these represent the column titles
    // Note that one column is in "string" format and another one is in "number" format as pie chart only required "numbers" for calculating percentage and string will be used for column title
    array('label' => 'Fecha', 'type' => 'string'),
    array('label' => 'ASR', 'type' => 'number'),
    array('label' => 'NER', 'type' => 'number'),
    array('label' => 'ACD', 'type' => 'number'),
    );
	
	 $table7['cols'] = array(
    // Labels for your chart, these represent the column titles
    // Note that one column is in "string" format and another one is in "number" format as pie chart only required "numbers" for calculating percentage and string will be used for column title
    array('label' => 'Fecha', 'type' => 'string'),
    array('label' => 'ASR', 'type' => 'number'),
    array('label' => 'NER', 'type' => 'number'),
    array('label' => 'ACD', 'type' => 'number'),
    );
	
	foreach($res5 as $tr) {
    $temp = array();

     foreach($tr as $key=>$value){

    // the following line will be used to slice the Pie chart

    // Values of each slice
    $temp[] = array('v' => $value);     
    }
  $rows3[] = array('c' => $temp); 
}
  foreach($res6 as $tr) {
    $temp = array();

     foreach($tr as $key=>$value){

    // the following line will be used to slice the Pie chart

    // Values of each slice
    $temp[] = array('v' => $value);     
    }
  $rows4[] = array('c' => $temp); 
}
	foreach($res7 as $tr) {
    $temp = array();

     foreach($tr as $key=>$value){

    // the following line will be used to slice the Pie chart

    // Values of each slice
    $temp[] = array('v' => $value);     
    }
  $rows5[] = array('c' => $temp); 
}

	foreach($res8 as $tr) {
    $temp = array();

     foreach($tr as $key=>$value){

    // the following line will be used to slice the Pie chart

    // Values of each slice
    $temp[] = array('v' => $value);     
    }
  $rows6[] = array('c' => $temp); 
}

	foreach($res9 as $tr) {
    $temp = array();

     foreach($tr as $key=>$value){

    // the following line will be used to slice the Pie chart

    // Values of each slice
    $temp[] = array('v' => $value);     
    }
  $rows7[] = array('c' => $temp); 
}
	$table3['rows'] = $rows3;
	$table4['rows'] = $rows4;
	$table5['rows'] = $rows5;
	$table6['rows'] = $rows6;
	$table7['rows'] = $rows7;

	$jsonTable3 = json_encode($table3);
	$jsonTable4 = json_encode($table4);
	$jsonTable5 = json_encode($table5);
	$jsonTable6 = json_encode($table6);
	$jsonTable7 = json_encode($table7);
?>
<html>
  <head>
  <!-- compatibilidad de explorer  -->
  <meta http-equiv="X-UA-Compatible" content="IE=10" />
  <link href='stylesheet3.css' rel='stylesheet' type "text/css"/>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load('visualization', '1', {'packages':['corechart','gauge']});
      google.setOnLoadCallback(init);
      
	  function init(){
		
		var data5 = [];
		
		data5[0] = new google.visualization.DataTable(<?=$jsonTable6?>);
		data5[1] = new google.visualization.DataTable(<?=$jsonTable7?>);
		data5[2] = new google.visualization.DataTable(<?=$jsonTable3?>);
		data5[3] = new google.visualization.DataTable(<?=$jsonTable4?>);
		data5[4] = new google.visualization.DataTable(<?=$jsonTable5?>);
		
		var options5 = {
		legend: {textStyle:{color: '#000000'}},
		title: 'ASR - NER - ACD Weekly Comparative Trinidad & Tobago',
		backgroundColor: 'transparent',
		// title: 'ASR-NER Panama',
          width: 850,
          height: 450,
		  hAxis: {textStyle:{color: '#000000'}, direction:1, slantedText:true, slantedTextAngle:65},
		  vAxis: {textStyle:{color: '#000000'}},
		  seriesType: "bars",
		  series: {2: {type: "line"}},
		  colors: ['#00B5D6', '#AABA09', '#FF4000']
        };
		
		var opcion = document.getElementById("opt").value;
		
		function drawChart() {
		var chart5 = new google.visualization.ComboChart(document.getElementById('chart_div5'));
		chart5.draw(data5[opcion],options5);
		
		var columns = [];
		var series = {};
		for (var i = 0; i < data5[opcion].getNumberOfColumns(); i++) {
			columns.push(i);
			if (i > 0) {
				series[i - 1] = {};
			}
		}
		
		google.visualization.events.addListener(chart5, 'select', function () {
        var sel = chart5.getSelection();
        // if selection length is 0, we deselected an element
        if (sel.length > 0) {
            // if row is undefined, we clicked on the legend
            if (sel[0].row === null) {
                var col = sel[0].column;
                if (columns[col] == col) {
                    // hide the data series
                    columns[col] = {
                        label: data5[opcion].getColumnLabel(col),
                        type: data5[opcion].getColumnType(col),
                        calc: function () {
                            return null;
                        }
                    };
                    
                    // grey out the legend entry
                    series[col - 1].color = '#CCCCCC';
                }
                else {
                    // show the data series
                    columns[col] = col;
                    series[col - 1].color = null;
                }
                var view = new google.visualization.DataView(data5[opcion]);
                view.setColumns(columns);
                chart5.draw(view, options5);
            }
        }
    });
		
      }
	  drawChart();
	  
	  }
	  
    </script>
  </head>
  <body>	
	<table>
	<tr>	<br><br><P style="text-align: center;"> <select name="opt" id="opt" onchange="init();" >
					<option value="0">10 Days ago</option>
					<option value="1">20 Days ago</option>
					<option value="2">30 Days ago</option>
					<option value="3">45 Days ago</option>
					<option value="4">60 Days ago</option>
					</select></p>	
			<td> 
				<div id="chart_div5"></div>						
			</td>
			
			
					
		</tr>
		</table>
		
	</body>
</html>
