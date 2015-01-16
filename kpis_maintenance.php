<?php
	include('conexion.php');
	
	
		$id=$_POST['id'];
		$v1=$_POST['input1'];
		$v2=$_POST['input2'];
		$v3=$_POST['input3'];
		$v4=$_POST['input4'];
		$v5=$_POST['input5'];
		$v6=$_POST['input6'];
		$v7=$_POST['input7'];
		$v8=$_POST['input8'];
		$v9=$_POST['input9'];
		$v10=$_POST['input10'];
		$v11=$_POST['input11'];
		$v12=$_POST['input12'];
		$vcountry = $_POST['country'];
		$countryname="";
		$date= $_POST['date'];
		
		if ($vcountry == 0) { $countryname= 'TrinidadTobago';} 
		else if ($vcountry == 1 ) { $countryname= 'Grenada';}
		else if ($vcountry == 2 ) { $countryname= 'Jamaica';}
		else if ($vcountry == 3 ) { $countryname= 'Curacao';}
		else if ($vcountry == 4 ) { $countryname= 'Panama';}
		else if ($vcountry == 5 ) { $countryname= 'Honduras';}
		else if ($vcountry == 6 ) { $countryname= 'Barbados';}
		else { $countryname= 'PuertoRico';}
		
		
		if($id==0){
			if($vcountry==0)
			{
				$sql="INSERT INTO MASTER_WEEKLY_REPORT(SAFARI_MTA_SUB_COUNT, SAFARI_SIP_EP_SUB_COUNT, TOTAL, REL_CAUSES_NORMAL, REL_CAUSES_OTHER, ACD_ALL_CALLS, ASR_ALL_CALLS, SUBS_WEEKLY_MINS, CORPORATE_SIP_TRUNKS_WEEKLY_MINS, MAX_MTA_OOS_LINES, SIP_LINES_WITHOUT_PASSWORD, COUNTRY, DATE) values ('$v1', '$v2', '$v3', '$v4','$v5', '$v6','$v7', '$v8', '$v9', '$v10', '$v11', '$countryname', '$date')";	
			}
			else if ($vcountry==1 || $vcountry==2 || $vcountry==3){
			
				$sql="INSERT INTO MASTER_WEEKLY_REPORT(SAFARI_MTA_SUB_COUNT, SAFARI_SIP_EP_SUB_COUNT, TOTAL, REL_CAUSES_NORMAL, REL_CAUSES_OTHER, ACD_ALL_CALLS, ASR_ALL_CALLS, SUBS_WEEKLY_MINS, CARRIERS_OUT_WEEKLY_MINS, CORPORATE_SIP_TRUNKS_WEEKLY_MINS, MAX_MTA_OOS_LINES, SIP_LINES_WITHOUT_PASSWORD, COUNTRY, DATE) values ('$v1', '$v2', '$v3', '$v4','$v5', '$v6','$v7', '$v8', '$v9', '$v10', '$v11', '$v12', '$countryname', '$date')";	
			} 
			else if ($vcountry==4)
			{
				$sql="INSERT INTO MASTER_WEEKLY_REPORT(META_SUBS_COUNT, SIP_BINDING_ACTIVE_LICENSES,  REL_CAUSES_NORMAL, BUSINESS_GROUPS, REL_CAUSES_OTHER, TOTAL_WEEKLY_MINS, COUNTRY, DATE) values ('$v1', '$v2', '$v3', '$v4','$v5', '$v6', '$countryname', '$date')";	
			}
			else if ($vcountry==5)
			{
				$sql="INSERT INTO MASTER_WEEKLY_REPORT(SIP_TRUNKS_QTY, MAX_ACTIVE_CALLS, REL_CAUSES_OTHER, ASR_ALL_CALLS, BUSINESS_GROUPS, META_SUBS_COUNT, ACD_ALL_CALLS, TOTAL_WEEKLY_MINS ,TOTAL_WEEKLY_MINS_HONDUTEL, COUNTRY, DATE) values ('$v1', '$v2', '$v3', '$v4','$v5', '$v6', '$v7','$v8', '$v9', '$countryname', '$date')";	
			}
			else if ($vcountry==6)
			{
				$sql="INSERT INTO MASTER_WEEKLY_REPORT(SUBSCRIBERS_WITH_VOICEMAIL, SIP_TRUNKS_QTY, ASR_ALL_CALLS, BUSINESS_GROUPS, TOTAL_WEEKLY_MINS, TOTAL_CALIX_SUBS, TOTAL_CALIX_SUBS_MIN, COUNTRY, DATE) values ('$v1', '$v2', '$v3', '$v4','$v5', '$v6', '$v7', '$countryname', '$date')";	
			}
			else
			{
				$sql="INSERT INTO MASTER_WEEKLY_REPORT(SIP_TRUNKS_QTY, MAX_ACTIVE_CALLS, ASR_ALL_CALLS, BUSINESS_GROUPS, ACD_ALL_CALLS, TOTAL_WEEKLY_MINS, COUNTRY, DATE) values ('$v1', '$v2', '$v3', '$v4','$v5', '$v6', '$countryname', '$date')";
			}
		}else{
			if($vcountry==0)
			{
				$sql="UPDATE MASTER_WEEKLY_REPORT SET SAFARI_MTA_SUB_COUNT = '$v1', SAFARI_SIP_EP_SUB_COUNT = '$v2', TOTAL = '$v3', REL_CAUSES_NORMAL = '$v4', REL_CAUSES_OTHER = '$v5', ACD_ALL_CALLS = '$v6', ASR_ALL_CALLS = '$v7', SUBS_WEEKLY_MINS = '$v8', CORPORATE_SIP_TRUNKS_WEEKLY_MINS = '$v9', MAX_MTA_OOS_LINES = '$v10', SIP_LINES_WITHOUT_PASSWORD = '$v11' WHERE ID = '$id'";	
			}
			else if ($vcountry==1 || $vcountry==2 || $vcountry==3)
			{
				$sql="UPDATE MASTER_WEEKLY_REPORT SET SAFARI_MTA_SUB_COUNT = '$v1', SAFARI_SIP_EP_SUB_COUNT = '$v2', TOTAL = '$v3', REL_CAUSES_NORMAL = '$v4', REL_CAUSES_OTHER = '$v5', ACD_ALL_CALLS = '$v6', ASR_ALL_CALLS = '$v7', SUBS_WEEKLY_MINS = '$v8', CARRIERS_OUT_WEEKLY_MINS = '$v9',CORPORATE_SIP_TRUNKS_WEEKLY_MINS = '$v10', MAX_MTA_OOS_LINES = '$v11', SIP_LINES_WITHOUT_PASSWORD = '$v12' WHERE ID = '$id'";	
			} 
			else if ($vcountry==4)
			{
				$sql="UPDATE MASTER_WEEKLY_REPORT SET META_SUBS_COUNT = '$v1', SIP_BINDING_ACTIVE_LICENSES = '$v2', REL_CAUSES_NORMAL = '$v3', BUSINESS_GROUPS = '$v4', REL_CAUSES_OTHER = '$v5', TOTAL_WEEKLY_MINS = '$v6' WHERE ID = '$id'";	
				//$sql="INSERT INTO MASTER_WEEKLY_REPORT(META_SUBS_COUNT, SIP_BINDING_ACTIVE_LICENSES, TOTAL, REL_CAUSES_NORMAL, BUSINESS_GROUPS, REL_CAUSES_OTHER, TOTAL_WEEKLY_MINS, PAIS, DATE) values ('$v1', '$v2', '$v3', '$v4','$v5', '$v6', '$countryname', '$date')";	
			}
			else if ($vcountry==5)
			{
				$sql="UPDATE MASTER_WEEKLY_REPORT SET SIP_TRUNKS_QTY = '$v1', MAX_ACTIVE_CALLS = '$v2', REL_CAUSES_OTHER = '$v3', ASR_ALL_CALLS = '$v4', BUSINESS_GROUPS = '$v5', META_SUBS_COUNT = '$v6', ACD_ALL_CALLS = '$v7', TOTAL_WEEKLY_MINS = '$v8', TOTAL_WEEKLY_MINS_HONDUTEL = '$v9' WHERE ID = '$id'";	
				//$sql="INSERT INTO MASTER_WEEKLY_REPORT(SIP_TRUNKS_QTY, MAX_ACTIVE_CALLS, REL_CAUSES_OTHER, ASR_ALL_CALLS, BUSINESS_GROUPS, META_SUBS_COUNT, ACD_ALL_CALLS, TOTAL_WEEKLY_MINS ,TOTAL_WEEKLY_MINS_HONDUTEL, PAIS, DATE) values ('$v1', '$v2', '$v3', '$v4','$v5', '$v6', '$v7','$v8', '$v9', '$countryname', '$date')";	
			}
			else if ($vcountry==6)
			{
				$sql="UPDATE MASTER_WEEKLY_REPORT SET SUBSCRIBERS_WITH_VOICEMAIL = '$v1', SIP_TRUNKS_QTY = '$v2', ASR_ALL_CALLS = '$v3', BUSINESS_GROUPS = '$v4', TOTAL_WEEKLY_MINS = '$v5', TOTAL_CALIX_SUBS = '$v6', TOTAL_CALIX_SUBS_MIN = '$v7' WHERE ID = '$id'";	
				//$sql="INSERT INTO MASTER_WEEKLY_REPORT(SUBSCRIBERS_WITH_VOICEMAIL, SIP_TRUNKS_QTY, ASR_ALL_CALLS, BUSINESS_GROUPS, TOTAL_WEEKLY_MINS, TOTAL_CALIX_SUBS, TOTAL_CALIX_SUBS_MIN, PAIS, DATE) values ('$v1', '$v2', '$v3', '$v4','$v5', '$v6', '$v7', '$countryname', '$date')";	
			}
			else
			{	
				$sql="UPDATE MASTER_WEEKLY_REPORT SET SIP_TRUNKS_QTY = '$v1', MAX_ACTIVE_CALLS = '$v2', ASR_ALL_CALLS = '$v3', BUSINESS_GROUPS = '$v4', ACD_ALL_CALLS = '$v5', TOTAL_WEEKLY_MINS = '$v6' WHERE ID = '$id'";	
				//$sql="INSERT INTO MASTER_WEEKLY_REPORT(SIP_TRUNKS_QTY, MAX_ACTIVE_CALLS, ASR_ALL_CALLS, BUSINESS_GROUPS, ACD_ALL_CALLS, TOTAL_WEEKLY_MINS, PAIS, DATE) values ('$v1', '$v2', '$v3', '$v4','$v5', '$v6', '$countryname', '$date')";
			}
		}
		
		if ($mysqli->query($sql) === TRUE) {
			echo "Data added successfully";
		} else {
			echo "Error: " . $sql . "<br>" . $mysqli->error;
		}

?>