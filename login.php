<?php
	include("config.php");
	session_start();

		if($_SERVER["REQUEST_METHOD"] == "POST")
		{
			$myusername=mysqli_real_escape_string($db,$_POST['username']); 
			$mypassword=mysqli_real_escape_string($db,$_POST['password']);
			$sql="SELECT id FROM members WHERE username='$myusername' and password='".md5($_POST['password'])."'";
			$result=mysqli_query($db,$sql);
			$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
			$active=$row['active'];
			$count=mysqli_num_rows($result);

			if($count==1)
			{
				session_register("myusername");
				$_SESSION['login_user']=$myusername;
				
				switch($_POST){
				case ($_POST['username']=="admin");
				header ("location: vqa_monitoring_manager.php");
				break;
				case ($_POST['username']=="vqa");
				header ("location: vqa_monitoring.php");
				break;
				case ($_POST['username']=="manag");
				header ("location: vqa_monitoring.php");
				break;
				
			}
			}
				else 
					{
						echo"<script type='text/javascript'>alert('Invalid username or password')</script>";
					}					
		}
?>

<html>
<TITLE>AUTHENTICATION</TITLE>
	<head>
		<script type="text/javascript">
		</script>
		<link href='stylecss.css' rel='stylesheet' type "text/css"/>
		<meta content="text/html; charset=UTF-8" http-equiv="content-type">
	</head>
		<body>
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			
				<center>
					<h1>VQA MONITORING AUTHENTICATION</h1>
				</center>
					<div style="text-align: center;">
						<form action="" method="post">
							<br><br>
								<div id="center">
									<table style="width: 591px; height: 102px; text-align: left; margin-left: auto; margin-right: auto;" border="0">
									
										<tbody>
										
											<tr style="height: 50px;">
											
												<td style="colspan=1" rowspan="3">&nbsp;&nbsp;
													<img alt="users" src="imagenes/sign_in.png" height="90px" width="90px">
												</td>
												
												<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													<span style="color: #00BFFF; font-family: Broadway;">Username:</span><br>
												</td>
												<td>
													<input name="username" type="text"><br>
												</td>
											</tr>
											<tr>
											
												<td style="width: 3000px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													<span style="color: #00BFFF;"><span style="font-family: Broadway;">Password:</span><br>
													</span>
												</td>
												<td style="width: 3000px;">
													<input name="password" type="password"><br>
												</td>
											</tr>
											<tr>
												<td>
													<br>
													<br>
													
												</td>
												
												<td style="text-align: center;">
													<br>
													<br>
													<input class="css_button" value="LOGIN" type="submit"><br>
													
												</td>
											</tr>
										</tbody>
									</table></div>
									
						</form>
		
					</div>
		</body>
</html>
