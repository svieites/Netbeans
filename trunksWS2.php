<?php
	require('conexion.php');
	
	$sel = $_POST['opt'];
	$sel=$sel+1;

	//$type = 'DEST_TG';
	$trunks = array();
	
	$carrier = array();
	$vals = array();
	$c = array();
	$values = array();
	$carriers = array();
	$a = array();
	$b = array();
	
	$sql  ="SELECT NAME,TG FROM CUSTOMER_SUPPLIER WHERE TYPE = $sel";
	
	$r = $mysqli->query($sql) or die($mysqli->error.__LINE__);
	
	while($result = $r->fetch_assoc()) {
		$trunks[] = $result;
		echo '<option value="'.$result['TG'].'">'.$result['NAME'].'</option>';
	}

	#for ( $i = 0; $i < sizeof($carriers); $i++){
	#	echo $carriers[$i].' '.$values[$i].'<br>';
	#}
	//echo sizeof($vals);
?>