<?php
	include('conexionmantenimiento.php');
	include('lock.php');
	$var="";
	$var1="";
	$var2="";
	$var3="";
	$var4="";
	if(isset($_POST['button'])) {
		$btn=$_POST['button'];
		$username=$_POST['txtusername'];
		$password=$_POST['txtpassword'];
		$activeinactive=$_POST['rdActivo'];
		$userrol=$_POST['roluser'];
		$find=$_POST['txtBuscar'];
		$codigo=$_POST['txtCodigo'];
		
	
		
			if ($btn=="Insert") {
				if (isset($username) && !empty($username) && isset ($password) && !empty($password)){
					$sql="insert into members(username, password, activeinactive, userrol, userphp, tabla) values ('$username', md5('$password'), '$activeinactive', '$userrol', '$login_session','members')";	
					$res=mysql_query($sql,$conn);
					if ($res){
						echo"<script>alert('Succesfully Inserted');</script>";
					}else{
							echo"<script>alert('Error - Not Inserted');</script>";
					}
					}else{
					echo"<script>alert('Must Complete all Fields');</script>";
				}
				echo"<script>window.location='mantenimiento.php';</script>";
			}
			
			
		
			
			if($btn=="Find"){
				if (isset($find) && !empty($find)){
					$sql="select * from members where id='$find'";
					$res=mysql_query($sql, $conn);
					while ($resultado=mysql_fetch_array($res)) {
						$var=$resultado[0];
						$var1=$resultado[1];
						$var2=$resultado[2];
						$var3=$resultado[3];
						$var4=$resultado[4];			
					}
					if ($var3=="0"){
					$var3="checked";
					}	
				}else {
							echo "<script>alert('Must complete the ID');</script>";
						}

					if ($var4 =="admin"){
						$sA = "selected";
						}
						
						if ($var4 =="manag"){
						$sM = "selected";
						}
						
						if ($var4 =="monitor"){
						$sO = "selected";
						}
						
			}
			if ($btn=="Delete"){
				if (isset($codigo) && !empty($codigo)){
				$sql="delete from members where id='$codigo'";
				$res=mysql_query($sql,$conn);
				if ($res) {
					echo "<script>alert('Succesfully Deleted');</script>";
				}else{
				echo "<script>alert('Error - Not Deleted');</script>";
				}
				} else {
					echo "<script>alert('Must Find before Delete');</script>";
			}
			echo "<script>window.location='mantenimiento.php';</script>";
			}
			
			if ($btn=="Update") {
				if (isset($codigo) && !empty($codigo) && isset($username) && !empty($username) && isset($password) && !empty($password)) {
					$sql="update members set username='$username', password=md5('$password'), activeinactive='$activeinactive', userrol='$userrol', userphp= '$login_session' where id='$codigo'";
					$res=mysql_query($sql,$conn);
					if ($res) {
						echo "<script>alert('Succesfully Updated');</script>";
						}else{
						echo "<script>alert('Error - Not Updated');</script>";
					}
					
				}else
				{
					"<script>alert('Must Find before Update');</script>";
				}
				
			}
			
			}
			
			
?>

<html>
  <head>
    <meta content="text/html; charset=windows-1252" http-equiv="content-type">
    <title>Data Maintenance</title>
	<link href='stylecssmant.css' rel='stylesheet' type "text/css"/>
  </head>
  <body>
  
  <br><br><br>
  <center><h1> Data Maintenance (USERS) </h1></center>
    <div class="formulario"><center><h3>
      <form action="" method="post"> 
	  <br><br><table>
	    <tr>
		<td>ID: <input type="text" name="txtBuscar">
		<input type="submit" class="css_button" name="button" value="Find">
		<input type="hidden" name="txtCodigo" value="<?php echo $var;?>">  
	  </tr>
	  </table>
	  
	  <br><br><table>
	   <tr>
		<td> Username: <input type="text" style="width:150px" name="txtusername" value="<?php echo $var1;?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br>
	  	</td>
		
		<td>Password: <input type="password" style="width:150px" name="txtpassword" value="<?php echo $var2;?>"><br><br>
	  	</td>
		</tr>
		<tr>
		<td>User Rol:&nbsp;&nbsp;&nbsp;&nbsp;<select style="width:150px"; name="roluser">
		  <option value="admin"<?php echo $sA; ?>>ADMIN</option>
		  <option value="manag"<?php echo $sM; ?>>MANAGER</option>
		  <option value="monitor"<?php echo $sO; ?>>MONITOR</option>
		</select>
	  	</td>
		<td>User Status:<input type="radio" name="rdActivo" value="1" checked>Active
		<input type="radio" name="rdActivo" value="0" <?php echo $var3;?>>Inactive
	  	</td>
	  </tr>
		</table>
		
		<br><br><table>
	   <tr>
		<td><input type="submit" class="css_button" name="button" value="View" >
	  	</td>
		<td><input type="submit" class="css_button" name="button" value="Insert" >
	  	</td>
		<td><input type="submit" class="css_button" name="button" value="Delete" >
	  	</td>
		<td><input type="submit" class="css_button" name="button" value="Update" >
	  	</td>
	  </tr>
	  
	  </table>
		
     
      </form>
    </h3></div></center>
	
	<?php
		if(isset($_POST['button'])) {
			$btn=$_POST['button'];
				if ($btn=="View"){
				$sql="Select id, username, activeinactive, userrol from members";
				$res=mysql_query($sql,$conn);
				
				echo" 
					<h1>List of Users</h1><br>
					<center><table border='1px' cellspacing=0 cellpading=0>
						<tr>
							<td width='35'><h2>ID</td>
							<td width='100'><h2>Username</td>
							<td width='150'><h2>Active / Inactive</td>
							<td width='100'><h2>User Rol</td>
							
						</tr>
						";
						
						while ($resultado=mysql_fetch_array($res)) {
						echo "
							<tr>
								<td><center>$resultado[id]</center></td>
								<td><center>$resultado[username]</center></td>
								<td><center>$resultado[activeinactive]</center></td>
								<td><center>$resultado[userrol]</center></td>
							</tr>
							";
							}
							echo "</table></center>";
						}
					}
		?>
				
  </body>
</html>
