<?php

include('conexion.php');

//set query execution time to 600 seconds and memory limit to 12 MB
ini_set('max_execution_time', 600);
ini_set("memory_limit","128M");

//get begin date, end date, ani, called number and button information with post method
$date1 = $_POST['begin_date'];
$date2 = $_POST['end_date'];
$ani = $_POST['ani'];
$called = $_POST['called'];
$btn = $_POST['btn'];

$table = array();
$table2 = array();
$rows = array();
$rows2 = array();
	
    $sql  ="SELECT START_TIME, Call_Duration, CALL_SOURCE SOURCE_IP, CALLS_DEST DEST_IP, ANI, NEW_ANI, CALL_ERROR2, Called_Party_On_Dest, 
    Called_Party_On_Source, SOURCE_REGID, DEST_REGID, ISDN_Code, 
    Call_Dest_crname, Codec_On_Src_Leg,Codec_On_Dest_Leg FROM HISTORICO
    WHERE ANI LIKE '%$ani%' AND Called_Party_On_Source LIKE '%$called%' AND DATE(START_TIME) BETWEEN '$date1' AND '$date2'";
    
    $table['cols'] = array(
	// Labels for the chart, these represent the column titles
	
	array('label' => 'Start Time', 'type' => 'string','pattern'=>''),
	array('label' => 'Duration', 'type' => 'string','pattern'=>''),
	array('label' => 'Src IP', 'type' => 'string','pattern'=>''),
	array('label' => 'Dest IP', 'type' => 'string','pattern'=>''),
    array('label' => 'Ani', 'type' => 'string','pattern'=>''),
	array('label' => 'New Ani', 'type' => 'string','pattern'=>''),
	array('label' => 'Error', 'type' => 'string','pattern'=>''),
	array('label' => 'Called on Dest', 'type' => 'string','pattern'=>''),
    array('label' => 'Called on Src', 'type' => 'string','pattern'=>''),
    array('label' => 'Source RegID', 'type' => 'string','pattern'=>''),
	array('label' => 'Dest RegID', 'type' => 'string','pattern'=>''),
	array('label' => 'ISDN', 'type' => 'string','pattern'=>''),
    array('label' => 'Route', 'type' => 'string','pattern'=>''),
	array('label' => 'Src Codec', 'type' => 'string','pattern'=>''),
	array('label' => 'Dest Codec', 'type' => 'string','pattern'=>''),	
    );

	$table2['cols'] = array(
	// Labels for the chart, these represent the column titles
	
	array('label' => 'Start Time', 'type' => 'string','pattern'=>''),
	array('label' => 'Duration', 'type' => 'string','pattern'=>''),
	array('label' => 'Ani', 'type' => 'string','pattern'=>''),
	array('label' => 'Called on Src', 'type' => 'string','pattern'=>''),
    array('label' => 'Source RegID', 'type' => 'string','pattern'=>''),
	array('label' => 'Dest RegID', 'type' => 'string','pattern'=>''),
	array('label' => 'ISDN', 'type' => 'string','pattern'=>''),
    );

//execute the query 
$r = $mysqli->query($sql) or die($mysqli->error.__LINE__);

$res = array();
$res2 = array();
$x=0;
//get query in variable $res for CSV export, in variable $res2 to display in table
while($result = $r->fetch_assoc()) {
    $res[] = $result;
	$res2[$x]['START_TIME'] = $result['START_TIME'];
	$res2[$x]['Call_Duration'] = $result['Call_Duration'];
	$res2[$x]['ANI'] = $result['ANI'];
	$res2[$x]['Called_Party_On_Source'] = $result['Called_Party_On_Source'];
	$res2[$x]['SOURCE_REGID'] = $result['SOURCE_REGID'];
	$res2[$x]['DEST_REGID'] = $result['DEST_REGID'];
	$res2[$x]['ISDN_Code'] = $result['ISDN_Code'];
	$x++;
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

foreach($res2 as $tr) {
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

//depending on the button clicked we build the json data, button show: table, button csv: table2
if($btn==0){
	$jsonTable = json_encode($table2);
}else{
	$jsonTable = json_encode($table);
}
echo $jsonTable;

?>
