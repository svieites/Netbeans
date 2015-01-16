<?php include('lock.php');
?>
<html>
  <head>
    <meta content="text/html; charset=UTF-8" http-equiv="content-type">
    <meta http-equiv="X-UA-Compatible" content="chrome=1">
	
	
	<!-- BORRAR EL CONTENIDO DE LA CACHE -->
	<meta http-equiv="Expires" content="0" />
	<meta http-equiv="Pragma" content="no-cache" />
	
	
    <title>VQA Reports</title>
    <link rel="stylesheet" href="stylesheet.css">
    <link rel="shortcut icon" href="imagenes/logo_paginas.png">
  </head>
  <body>
    <table style="width: 1218px; height: 164px;" border="0">
      <tbody>
        <tr>
          <td style="text-align: left;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
          </td>
          <td style="margin-left: 105px;">&nbsp;&nbsp; &nbsp; &nbsp; &nbsp;
            &nbsp; &nbsp; </td>
          <td>&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; </td>
          <td>&nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; </td>
          <td style="width: 891.667px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <img title="Columbus_Logo"

              alt="Columbus Logo" src="imagenes/columbus_logo.png"> </td>
          <td style="width: 63px;"><span style="color: white; font-family: Broadway;">
              <?php echo $login_session; ?></span><br>
          </td>
          <td style="width: 56px; margin-left: 13px;"><span style="font-family: Broadway;"><span

                style="color: white;"><a href="logout.php"> <img class="icon" src="imagenes/logout.png"></a></span></span></td>
        </tr>
      </tbody>
    </table>
    <header style="margin-top: 0px;">
      <div style="width: 230px; margin-left: -120px;" class="contenedor" id="uno"><a

          target="ventana_iframe" title="Home" href="vqamonitoring1.html"> <img

            class="icon" src="imagenes/home.png"></a></div>
      <div style="width: 230px;" class="contenedor" id="dos"><a target="ventana_iframe"

          title="ASR NER Reports" href="ASR_NER_Pais.html"> <img class="icon" src="imagenes/world.png"></a></div>
      <div style="width: 230px;" class="contenedor" id="tres"> <a target="ventana_iframe"

          title="Traffic Reports" href="VQA_Report.html"><img class="icon" src="imagenes/report.png"></a></div>
      <div style="width: 230px;" class="contenedor" id="cuatro"><a target="ventana_iframe"

          title="Wholesale" href="WS.php"><img class="icon" src="imagenes/wholesale.png"></a></div>
      <div style="text-align: center; width: 960px; margin-left: -160px;"><!-- <div class="contenedor" id="cinco"><img class="icon" src="imagenes/icon5.png"></div> --><!-- <div class="contenedor" id="seis"><img class="icon" src="imagenes/icon6.png"></div> --><br>
      </div>
    </header>
    <div style="margin-top: 1cm; " align="center"><iframe src="vqamonitoring1.html"

        name="ventana_iframe" onload="autofitframe" align="middle" frameborder="0"

        height="600px" width="1250px"></iframe></div>
  </body>
</html>
