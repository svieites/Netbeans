<?php
	include('lock.php');
	?>
	

<html>
<TITLE>Audit</TITLE>
	<head>
		<script type="text/javascript">
		</script>
		<link href='stylecssmant.css' rel='stylesheet' type "text/css"/>
		<meta content="text/html; charset=UTF-8" http-equiv="content-type">
	</head>
<br><br><br>
</html>	

	<?php
	include('conexionmantenimiento.php');
				$sql="select userphp, operacion, modificado, tabla, old_username, new_username, old_userrol, new_userrol, old_status, new_status from bitacora";
				$res=mysql_query($sql,$conn);
				
				echo" 
					<h1>Audit</h1><br>
					<center><table border='1px' cellspacing=0 cellpading=0>
						<tr>
							<td width='35'><h4>Username</h4></td>
							<td width='35'><h4>Action</h4></td>
							<td width='35'><h4>Modified</h4></td>
							<td width='35'><h4>Table</h4></td>
							<td width='35'><h4>Old User</h4></td>
							<td width='80'><h4>New User</h4></td>
							<td width='65'><h4>Old Rol</h4></td>
							<td width='65'><h4>New Rol</h4></td>
							<td width='80'><h4>Old Status</h4></td>
							<td width='95'><h4>New Status</h4></td>
						</tr>
						";
						
						while ($resultado=mysql_fetch_array($res)) {
						echo "
							<tr>
								<td><center>$resultado[userphp]</center></td>
								<td><center>$resultado[operacion]</center></td>
								<td><center>$resultado[modificado]</center></td>
								<td><center>$resultado[tabla]</center></td>
								<td><center>$resultado[old_username]</center></td>
								<td><center>$resultado[new_username]</center></td>
								
								<td><center>$resultado[old_userrol]</center></td>
								<td><center>$resultado[new_userrol]</center></td>
								<td><center>$resultado[old_status]</center></td>
								<td><center>$resultado[new_status]</center></td>
							</tr>
							";
							}
							echo "</table></center>";
						
					
		?>