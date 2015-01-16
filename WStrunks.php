<?php
	require('conexion.php');
	
	$trunks = array();
	$values = array();
	$resultado = array();
	
	$sql  ="SELECT DISTINCT NAME,TG FROM CUSTOMER_SUPPLIER ORDER BY TG";

	$r = $mysqli->query($sql) or die($mysqli->error.__LINE__);
	
	while($result = $r->fetch_assoc()) {
		$trunks[] = $result['NAME'];
		$values[] = $result['TG'];
	}
	
	$resultado[] = array('NAME'=>$trunks);
	$resultado[] = array('TG'=>$values);
	
	$data = json_encode($resultado);
	
	echo $data;
	
	//for ($i = 0; $i <sizeof($trunks); $i++){
	//	echo $trunks[$i]['TG'];
	//}
?>