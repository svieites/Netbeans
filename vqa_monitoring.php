<?php include('lock.php');
?>

<html lang="en">
	<head>
		<meta content="text/html; charset=utf-8" http-equiv="content-type">
		<link href="http://fonts.googleapis.com/css?family=Droid+Sans" rel="stylecss" type="text/css">
				
				
				
				<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no"/>
				
				<!-- BORRAR EL CONTENIDO DE LA CACHE -->
				<meta http-equiv="Expires" content="0" />
				<meta http-equiv="Pragma" content="no-cache" />
			
		
		<title>VQA MONITORING</title>
		<link href="stylecss.css" media="screen" rel="stylesheet" type="text/css">
		<link href="iconic.css" media="screen" rel="stylesheet" type="text/css">
		<link rel="shortcut icon" href="imagenes/logo_paginas.png">
		<script src="prefix-free.js"></script>
		
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		
		
	</head>
	
		<body>
			
			<div class="wrap1">
			<img style="width:189px; height:58px; title=" columbus_logo" alt="Columbus Logo" src="imagenes/columbus_logo.png">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<span style="color:#000000; font-family: Broadway;">USERNAME:</span><span style="color:#00BFFF; font-family: Broadway;"> <?php echo $login_session; ?><span style="color: white;"><a href="logout.php"><img style="width: 35px; height: 35px;" class="icon" src="imagenes/logout.png"></a></span></span></span>
					
			</div>
			
			<div class="wrap">
				
				<nav id= "responsive-menu">
				
				
				<ul class="menu">
					<li><a target="ventana_iframe" href="vqamonitoring.html"><img class="icon" src="imagenes/inicio.png"> Home</a>
					<ul>
						<li><a href="home.html" title="About The Tool" target="ventana_iframe"><img class="icon" src="imagenes/info.png"> About The Tool</a></li>
						<li><a href="call_search.html" title="Call Search" target="ventana_iframe"><img class="icon" src="imagenes/search.png"> Call Search</a></li>
					</ul>
					</li>
					<li><a href="#"><img class="icon" src="imagenes/chart.png"> VQA Report</a>
					<ul>
						<li><a href="#" title=" Comparative Reports" target="ventana_iframe"><img class="icon" src="imagenes/chart.png"> Comparative Report</a>
                                                    <ul>
                                                        <li><a href="Barbados_N.php" title=" ASR/NER Barbados" target="ventana_iframe"><img class="icon" src="imagenes/barbados.png"> Barbados</a></li>
                                                        <li><a href="Curacao_N.php" title=" ASR/NER Curacao" target="ventana_iframe"><img class="icon" src="imagenes/comparative.png"> Curacao</a></li>
                                                        <li><a href="Grenada_N.php" title=" ASR/NER Grenada" target="ventana_iframe"><img class="icon" src="imagenes/trafreport.png"> Grenada</a></li>
                                                        <li><a href="Jamaica_N.php" title=" ASR/NER Jamaica Report" target="ventana_iframe"><img class="icon" src="imagenes/jamaica.png"> Jamaica</a></li>
                                                        <li><a href="Panama_N.php" title=" ASR/NER Panam&aacute; Report" target="ventana_iframe"><img class="icon" src="imagenes/panama.png"> Panam&aacute;</a></li>
                                                        <li><a href="PuertoRico_N.php" title=" ASR/NER Puerto Rico Report" target="ventana_iframe"><img class="icon" src="imagenes/puerto_rico.png"> Puerto Rico</a></li>
                                                        <li><a href="TrinidadTobago_N.php" title=" ASR/NER Trinidad y Tobago Report" target="ventana_iframe"><img class="icon" src="imagenes/trinidad.png"> Trinidad & Tobago</a></li>
                                                        <li><a href="CloudVoice_N.php" title=" ASR/NER Cloud Voice Report" target="ventana_iframe"><img class="icon" src="imagenes/cloud.png"> Cloud Voice</a></li>
                                                    </ul></li>
						<li><a href="Curacao_N.php" title=" Traffic Reports" target="ventana_iframe"><img class="icon" src="imagenes/comparative.png"> Traffic Reports</a></li>
						<li><a href="Grenada_N.php" title=" ASR/NER Reports" target="ventana_iframe"><img class="icon" src="imagenes/trafreport.png"> ASR/NER Reports</a></li>
						
					</ul>
					</li>
					<li><a href="#"><img class="icon" src="imagenes/comparative.png"> Comparative Report</a>
					<ul>
						<li><a href="ACD_Barbados_N.php" title=" Comparative Report Barbados" target="ventana_iframe"><img class="icon" src="imagenes/barbados.png"> Barbados</a></li>
						<li><a target="ventana_iframe" title=" Comparative Report Curacao " href="ACD_Curacao_N.php"><img class="icon" src="imagenes/curacao.png"> Curacao</a></li>
						<li><a target="ventana_iframe" title=" Comparative Report Grenada " href="ACD_Grenada_N.php"><img class="icon" src="imagenes/grenada.png"> Grenada</a></li>
						<li><a target="ventana_iframe" title=" Comparative Report Jamaica " href="ACD_Jamaica_N.php"><img class="icon" src="imagenes/jamaica.png"> Jamaica</a></li>
						<li><a target="ventana_iframe" title=" Comparative Report Panam&aacute; " href="ACD_Panama_N.php"><img class="icon" src="imagenes/panama.png"> Panam&aacute;</a></li>
						<li><a target="ventana_iframe" title=" Comparative Report Puerto Rico " href="ACD_PuertoRico_N.php"><img class="icon" src="imagenes/puerto_rico.png"> Puerto Rico</a></li>
						<li><a target="ventana_iframe" title=" Comparative Report Trinidad & Tobago " href="ACD_TrinidadTobago_N.php"><img class="icon" src="imagenes/trinidad.png"> Trinidad & Tobago</a></li>
						<li><a target="ventana_iframe" title=" Comparative Report Cloud Voice " href="ACD_CloudVoice_N.php"><img class="icon" src="imagenes/cloud.png"> Cloud Voice</a></li>
					</ul>
					</li>
					<li><a href="#"><img class="icon" src="imagenes/trafreport.png"> Traffic Report</a>
					<ul>
						<li><a href="TRAFFIC_Barbados_N.php" title=" Traffic Report Barbados" target="ventana_iframe"><img class="icon" src="imagenes/barbados.png"> Barbados</a></li>
						<li><a target="ventana_iframe" title=" Traffic Report Curacao" href="TRAFFIC_Curacao_N.php"><img class="icon" src="imagenes/curacao.png"> Curacao</a></li>
						<li><a target="ventana_iframe" title=" Traffic Report Grenada" href="TRAFFIC_Grenada_N.php"><img class="icon" src="imagenes/grenada.png"> Grenada</a></li>
						<li><a target="ventana_iframe" title=" Traffic Report Jamaica" href="TRAFFIC_Jamaica_N.php"><img class="icon" src="imagenes/jamaica.png">Jamaica</a></li>
						<li><a target="ventana_iframe" title=" Traffic Report Panam&aacute;" href="TRAFFIC_Panama_N.php"><img class="icon" src="imagenes/panama.png"> Panam&aacute;</a></li>
						<li><a target="ventana_iframe" title=" Traffic Report Puerto Rico" href="TRAFFIC_PuertoRico_N.php"><img class="icon" src="imagenes/puerto_rico.png"> Puerto Rico</a></li>
						<li><a target="ventana_iframe" title=" Traffic Report Trinidad & Tobago" href="TRAFFIC_TrinidadTobago_N.php"><img class="icon" src="imagenes/trinidad.png"> Trinidad & Tobago</a></li>
						<li><a target="ventana_iframe" title=" Traffic Report Cloud Voice" href="TRAFFIC_CloudVoice_N.php"><img class="icon" src="imagenes/cloud.png"> Cloud Voice</a></li>
					</ul>
					</li>
					<li><a href="#"><img class="icon" src="imagenes/whole.png"> Wholesale</a>
					<ul>
						<li><a href="WS.html" title="Top Carriers and Countries Wholesale" target="ventana_iframe"><img class="icon" src="imagenes/countries.png"> Countries</a></li>
						<li><a href="WScarriers.html" title="Carriers Wholesale" target="ventana_iframe"><img class="icon" src="imagenes/carriers.png"> Carriers</a></li>
					</ul>
					</li>
					<li><a href="#"><img class="icon" src="imagenes/report.png"> Reports</a>
					<ul>
						<li><a target="_blank" href="kpis.html"><img class="icon" src="imagenes/weekly.png"> Weekly Report</a></li>
						
					</ul>
					</li>
				</ul>
				<div class="clearfix">
				</div>
				</nav>
				
			</div>
		
				<div style="margin-top: -70px;" align="center"> <div id="left"></div><div id="right"></div>
					<iframe src="vqamonitoring.html" name="ventana_iframe" onload="autofitframe" align="middle" frameborder="0" height="625px" width="950px"></iframe>
					
				</div>
			
		<h8><div id="footer">Copyright © Columbus Business Solutions</h8></div></p>
				
		</body>
</html>