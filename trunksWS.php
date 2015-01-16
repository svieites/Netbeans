<?php
	require('conexion.php');
	
	$trunks = array();
	$trunks2 = array();
	$carrier = array();
	$vals = array();
	$c = array();
	$values = array();
	$carriers = array();
	$a = array();
	$b = array();
	
	$sql  ="SELECT DISTINCT B.NAME,A.DEST_TG FROM RESUMEN A INNER JOIN CARRIER B ON B.TRUNK_ID = A.DEST_TG WHERE A.CALL_ZONE_DATA = 6";
	$sql2 ="SELECT DISTINCT B.NAME,A.CALLER_TG FROM RESUMEN A INNER JOIN CARRIER B ON B.TRUNK_ID = A.CALLER_TG WHERE A.CALL_ZONE_DATA = 6";
	
	$r = $mysqli->query($sql) or die($mysqli->error.__LINE__);
	$r2 = $mysqli->query($sql2) or die($mysqli->error.__LINE__);
	
	while($result = $r->fetch_assoc()) {
		$trunks[] = $result;	
	}
	while($result = $r2->fetch_assoc()) {
		$trunks2[] = $result;	
	}
	
	$c = array_merge($trunks,$trunks2);

	for ( $i = 0; $i < sizeof($c); $i++){
		$carrier[] = $c[$i]['NAME'];
		if($c[$i]['DEST_TG']!=null){
			$vals[] = $c[$i]['DEST_TG'];
		}
		else{
			$vals[] = $c[$i]['CALLER_TG'];
		}
	}
	$a = array_unique($carrier);
	$b = array_unique($vals);
	
	for ( $i = 0; $i < sizeof($c); $i++){
		if($a[$i]!=null){
			$carriers[] = $a[$i];
			$values[] = $b[$i];
		}
	}
	
	#for ( $i = 0; $i < sizeof($carriers); $i++){
	#	echo $carriers[$i].' '.$values[$i].'<br>';
	#}
	//echo sizeof($vals);
?>
