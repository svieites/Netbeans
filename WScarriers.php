
<html>
	<head>
	<meta http-equiv="X-UA-Compatible" content="IE=10" />
    <link href='stylecss.css' rel='stylesheet' type "text/css"/>	
	<link href="libs/CalendarControl.css" rel="stylesheet" type="text/css">
	<script src="libs/CalendarControl.js" language="javascript"></script>
	<title>Wholesale Carriers</title>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<center><body onload="topDestinations(0)">
			<br><br><br><h3>Wholesale Carriers</h3><br><br>
			<table>
			<tr>
				<td>
					<b>Diaplay info as:<b>
				</td>
				
				<td>&nbsp;&nbsp;	
					<select name="type" id="type" selected="true" onchange="fillCarrier(this.value)" style="width: 170px">
					<option value="" >Select option</option>
					<option value="0" >Customer</option>
					<option value="1" >Supplier</option>
					</select>
				</td>
				
				<td>&nbsp;&nbsp;&nbsp;
					<b>Select carrier: </b>
				</td>
				<td>&nbsp;&nbsp;
					<select style="width: 170px" name="carrier" id="carrier" selected="true" onchange="">
					<option value="" >--Carrier--</option>
					
					</select>
				</td>
				
			</tr>
			<tr>
				<td><br>
				</td>
				
			</tr>
			<tr>
				<td>
					<b>Begin date:</b>
				</td>
				<td>&nbsp;&nbsp;
					<input style="width: 170px" id="begin_date" name="begin_date" onfocus="showCalendarControl(this);" type="text">
				</td>
			
				<td>&nbsp;&nbsp;&nbsp;
					<b>End date: </b>
				</td>	
				<td>&nbsp;&nbsp;
					<input style="width: 170px" id="end_date" name="end_date" onfocus="showCalendarControl(this);" type="text">
				</td>
				
			</tr>
			<tr>
				<td><br>
				</td>
				
			</tr>
			<tr>	
				<td>
					Items to show:
				</td>
				<td>&nbsp;&nbsp;
				<select name="opt" id="opt" selected="true" onchange="fillCarrier(this.value)" style="width: 170px">
					<option value="0" >ASR-NER-CALLS</option>
					<option value="1" >MIN-ERRORS-ACD</option>
					</select>
				</td>
				<td>&nbsp;&nbsp;&nbsp;
					<button style="width: 80px" value="0" id="btn1" onclick="validar()">Show</button>
				</td>
				<td>&nbsp;&nbsp;&nbsp;
					<button style="width: 80px" value="1" id="btn2" onclick="topDestinations(this.value)">CSV</button>
				</td>
				<td>
				
				</td>
			</tr>	
			</table>
			
			<br></br>
			
			<table>
				<tr>
					<td>
						<div id="gauge_div"align="justify"></div>
					</td>
					<td>
						<div id="gauge_div2"align="justify"></div>
					</td>
					<td>
						<div id="gauge_div3"align="justify"></div>
					</td>
				</tr>
			</table>
			<br>
			<b><label id="lbl1"></label></b>
			<br>
			<br>
			<div id="table_div2"align="center"style="width:750px;"></div>
			
			
			<script type="text/javascript">
			
			    google.load("visualization", "1", {packages:["gauge","table","corechart"]});
			    //google.setOnLoadCallback(top6(5,0));
				
				var today = new Date();
				var dd = today.getDate();
				var mm = today.getMonth()+1; //January is 0!
			
				var yyyy = today.getFullYear();
				if(dd<10){
					dd='0'+dd
				} 
				if(mm<10){
					mm='0'+mm
				}
				//today's date to initialize date inputs
				var today = mm+'-'+dd+'-'+yyyy;
				document.getElementById("begin_date").value = today;
				document.getElementById("end_date").value = today;
				
				function fillCarrier(opt){
				
					$.ajax({
					 type: "POST",
					 url: "trunksWS2.php",
					 data: {opt:opt},

					 success: function (data) {
						 $("#carrier").html(data);
					 },
					 error: function (data) {
						 alert("Error!");
					 }
				 });
				}
				
				//function that creates the table that shows traffic from carriers to countries
				function topDestinations(algo){
					var top = document.getElementById('top').value;
					var option = document.getElementById('opt').value;
					
					var begin_date = document.getElementById("begin_date").value;
					var year1 = begin_date.substring(6,10);
					var day1 = begin_date.substring(3,5);
					var month1 = begin_date.substring(0,2);
					begin_date = year1+'-'+month1+'-'+day1;
					
					var end_date = document.getElementById("end_date").value;
					var year2 = end_date.substring(6,10);
					var day2 = end_date.substring(3,5);
					var month2 = end_date.substring(0,2);
					end_date = year2+'-'+month2+'-'+day2;
					
					if(begin_date>end_date){
						alert('End date must be equal or greater than begin date');
					}
					else{
						if(begin_date == '--'){
							alert('Please select a begin date');
						}else if(end_date == '--'){
							alert('Please select an end date');
						}else{
							$.ajax({
							type: 'POST',
							url: 'WSpaises.php',
							datatype: 'json',
							data: {
								top:top,seleccion: option,begin_date:begin_date,end_date:end_date
							},
							success: (function(jsonData){
								if(algo==0){
									var data = new google.visualization.DataTable(jsonData);
									var table = new google.visualization.Table(document.getElementById('table_div'));
									
									table.draw(data, {allowHtml: true,showRowNumber: false});
									//$('.google-visualization-table-th:contains("Carrier")').css('width', '100px');
								}else{
									var data = new google.visualization.DataTable(jsonData);
									dataTableToCSV(data);
								}
							})
						});
						}
					}
				}
				
				function validar(){
				
				var cb = document.getElementById("carrier").value;
				var cb2 = $('#carrier option:selected').text();
				var opt = document.getElementById("opt").value;
				var type = document.getElementById("type").value;	
				//alert(cb);
				drawChart(cb,type,opt);
				
					if(opt==0){
						
						$('#lbl1').text('Delivering to the following carriers:');
						//var a=trunk_trunk(cb,document.getElementById("asr").value);
							
					}
						
					else {
						
						$('#lbl1').text('Delivering to the following regions:');	
						//var a=trunk_pais(cb2,document.getElementById("asr").value);
					}
					
				}
				
				function trunk_pais(option,element){
					var begin_date = document.getElementById("begin_date").value;
					var year1 = begin_date.substring(6,10);
					var day1 = begin_date.substring(3,5);
					var month1 = begin_date.substring(0,2);
					begin_date = year1+'-'+month1+'-'+day1;
					
					var end_date = document.getElementById("end_date").value;
					var year2 = end_date.substring(6,10);
					var day2 = end_date.substring(3,5);
					var month2 = end_date.substring(0,2);
					end_date = year2+'-'+month2+'-'+day2;
				
					$.ajax({
						type: 'POST',
						url: 'trunk_pais.php',
						datatype: 'json',
						data: {
							dato: option, element:element,begin_date:begin_date,end_date:end_date
						},
						success: (function(jsonData){
						var result = JSON.parse(jsonData);
						console.log(result);
						//alert(jsonData.length);
							if(result["rows"] == ''){
								
								$('#table_div2').text('This carrier is not a provider.');
							}
							else{
								var data = new google.visualization.DataTable(jsonData);
								var table = new google.visualization.Table(document.getElementById('table_div2'));
								table.draw(data, {allowHtml: true,showRowNumber: false});
							}
						
						})
					});
					
				}
				function trunk_trunk(option,element){
				
					var begin_date = document.getElementById("begin_date").value;
					var year1 = begin_date.substring(6,10);
					var day1 = begin_date.substring(3,5);
					var month1 = begin_date.substring(0,2);
					begin_date = year1+'-'+month1+'-'+day1;
					
					var end_date = document.getElementById("end_date").value;
					var year2 = end_date.substring(6,10);
					var day2 = end_date.substring(3,5);
					var month2 = end_date.substring(0,2);
					end_date = year2+'-'+month2+'-'+day2;
				
					$.ajax({
						type: 'POST',
						url: 'trunk_trunk.php',
						datatype: 'json',
						data: {
							dato: option, element:element,begin_date:begin_date,end_date:end_date
						},
						success: (function(jsonData){
						var result = JSON.parse(jsonData);
						console.log(result);
						//alert(result["rows"]);
						//alert(jsonData);
							if(result["rows"] == ''){
								$('#table_div2').text('This carrier is not a customer.');
							}
							else{
								var data = new google.visualization.DataTable(jsonData);
								var table = new google.visualization.Table(document.getElementById('table_div2'));
								table.draw(data, {allowHtml: true,showRowNumber: false});
							}
						
						})
					});
				}
				function drawChart(trunk,direction,element) {
			
					$.ajax({
						type: 'POST',
						url: 'gauges.php',
						datatype: 'json',
						data: {
							trunk: trunk, direction: direction, element: element
						},
						success: (function(jsonData){
							//alert(jsonData.length);
							var result = JSON.parse(jsonData);
							console.log(result);
							//alert(result[0]["ASR"]);
							var asr = parseInt(result[0]["ASR"]);
							var ner = parseInt(result[0]["NER"]);
							var calls = parseInt(result[0]["CALLS"]);
							var asr_m = parseInt(result[1]["ASR_MEAN"]);
							var ner_m = parseInt(result[1]["NER_MEAN"]);
							var calls_m = parseInt(result[1]["CALLS_MEAN"]);
							var min = parseInt(result[0]["MINUTES"]);
							var errors = parseInt(result[0]["ERRORES"]);
							var acd = parseFloat(result[0]["ACD"]);
							var min_m = parseInt(result[1]["MINUTES_MEAN"]);
							var errors_m = parseInt(result[1]["ERRORES_MEAN"]);
							var acd_m = parseFloat(result[1]["ACD_MEAN"]);
							if(element == 0 && result[0]["ASR"]!=null){
								//alert('ASR: '+asr + ' NER: '+ner+' Calls: '+calls+' ASR_M: '+asr_m+' NER_M: '+ner_m+' Calls_m: '+calls_m);
								draw('ASR','NER','CALLS',asr,ner,calls,asr_m,ner_m,calls_m);
							}
							else if(element == 1 && result[0]["MINUTES"]!=null){
								//alert('Min: '+min+' Errors: '+errors+ ' ACD: '+acd+ ' Min_M: '+min_m+' Errors_m: '+errors_m+' acd_m: '+acd_m);
								draw('MIN','ERRORS','ACD',min,errors,acd,min_m,errors_m,acd_m);
							}
							else{
								$( "#gauge_div" ).empty();
								$( "#gauge_div2" ).empty();
								$( "#gauge_div3" ).empty();
							}
						})
					});
				}
				
				function draw(n1,n2,n3,par1,par2,par3,c1,c2,c3){
					
					var data = google.visualization.arrayToDataTable([
					  ['Label', 'Value'],
					  [n1, par1],
					]);
					
					var data2 = google.visualization.arrayToDataTable([
					  ['Label', 'Value'],
					  [n2, par2],
					]);
					
					var data3 = google.visualization.arrayToDataTable([
					  ['Label', 'Value'],
					  [n3, par3],
					]);
					
					var options = {
					  width: 400, height: 130,
					  greenFrom: (c1-2), greenTo: 100,
					  yellowFrom: (c1-10), yellowTo: (c1-2),
					  minorTicks: 5
					};
					
					var options2 = {
					  width: 400, height: 130,
					  greenFrom: (c2-2), greenTo: 100,
					  yellowFrom: (c2-10), yellowTo: (c2-2),
					  minorTicks: 5
					};
					
					var options3 = {
					  width: 400, height: 130,
					  yellowFrom: (c3*0.85), yellowTo: (c3*0.9),
					  greenFrom: (c3*0.9), greenTo: (c3*1.1),
					  redFrom:(c3*1.1), redTo: (c3*1.15),
					  redColor:'#FF9900',
					  minorTicks: 5,
					  max:c3*2
					};
					
					var options4 = {
					  width: 400, height: 130,
					  yellowFrom: (c1*0.85), yellowTo: (c1*0.9),
					  greenFrom: (c1*0.9), greenTo: (c1*1.1),
					  redFrom:(c1*1.1), redTo: (c1*1.15),
					  redColor:'#FF9900',
					  minorTicks: 5,
					  max:c1*2
					};
					
					var options5 = {
					  width: 400, height: 130,
					  yellowFrom: (c2*0.85), yellowTo: (c2*0.9),
					  greenFrom: (c2*0.9), greenTo: (c2*1.1),
					  redFrom:(c2*1.1), redTo: (c2*1.15),
					  redColor:'#FF9900',
					  minorTicks: 5,
					  max:c2*2
					};
					
					var options6 = {
					  width: 400, height: 130,
					  yellowFrom: (c3*0.85), yellowTo: (c3*0.9),
					  greenFrom: (c3*0.9), greenTo: (c3*1.1),
					  redFrom:(c3*1.1), redTo: (c3*1.15),
					  redColor:'#FF9900',
					  minorTicks: 5,
					  max:c3*2
					};
		
					var chart = new google.visualization.Gauge(document.getElementById('gauge_div'));
					var chart2 = new google.visualization.Gauge(document.getElementById('gauge_div2'));
					var chart3 = new google.visualization.Gauge(document.getElementById('gauge_div3'));
					
					if(n1=='ASR'){
						chart.draw(data, options);
						chart2.draw(data2, options2);
						chart3.draw(data3, options3);
					}
					else if(n1=='MIN'){
						chart.draw(data, options4);
						chart2.draw(data2, options5);
						chart3.draw(data3, options6);
					}
					
				}
				function dataTableToCSV(dataTable_arg) {
					var dt_cols = dataTable_arg.getNumberOfColumns();
					var dt_rows = dataTable_arg.getNumberOfRows();
					var csv_cols = [];
					var csv_out;
					// Iterate columns
					for (var i=0; i<dt_cols; i++) {
					// Replace any commas in column labels
					csv_cols.push(dataTable_arg.getColumnLabel(i).replace(/,/g,""));
					}
					// Create column row of CSV
					csv_out = csv_cols.join(",")+"\r\n";
					// Iterate rows
					for (i=0; i<dt_rows; i++) {
					var raw_col = [];
					for (var j=0; j<dt_cols; j++) {
					// Replace any commas in row values
					raw_col.push(dataTable_arg.getFormattedValue(i, j, 'label').replace(/,/g,""));
					}
					// Add row to CSV text
					csv_out += raw_col.join(",")+"\r\n";
					}
					 
					downloadCSV(csv_out);
				}
				function downloadCSV (csv_out) {
					var blob = new Blob([csv_out], {type: 'text/csv;charset=utf-8'});
					var url  = window.URL || window.webkitURL;
					var link = document.createElementNS("http://www.w3.org/1999/xhtml", "a");
					link.href = url.createObjectURL(blob);
					link.download = "WSdata.csv"; 

					var event = document.createEvent("MouseEvents");
					event.initEvent("click", true, false);
					link.dispatchEvent(event); 
				}
				
			</script>
		</body>
	</head>
</html>
