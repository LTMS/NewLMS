
		function get_admin_otsummary(){
				document.getElementById('dept').value='';
				var year=document.getElementById('year').value;
				var month1=document.getElementById('month1').value;
				var month2=document.getElementById('month2').value;
				var user=document.getElementById('emp').value;
				if(user!=""){
					document.getElementById('ack_button').style.display='';	
				}
				
				var date1=year+'-'+month1;
				var date2=year+'-'+month2;
						//alert(date2);
				
				
				if(year!="" && month1!="" && user!="" && month2!=""){
					$.post(site_url+"/timesheet/get_admin_otsummary/",{d1:date1,d2:date2,emp:user},function(data){		
						//alert(data);
						$("#contentData").html("");
						$("#contentData").append(data);
		
					});
				}
				else {
					//alert("Please Check Input Fields.!");
				}
				
			}
		

		function get_my_otsummary(){
			var year=document.getElementById('year').value;
		var month1=document.getElementById('month1').value;
		var month2=document.getElementById('month2').value;
		var user=document.getElementById('emp').value;
		
		var date1=year+'-'+month1;
		var date2=year+'-'+month2;
				//alert(date2);
		
		
		if(year!="" && month1!="" && user!="" && month2!=""){
			$.post(site_url+"/timesheet/get_admin_otsummary/",{d1:date1,d2:date2,emp:user},function(data){		
				//alert(data);
				$("#contentData").html("");
				$("#contentData").append(data);

			});
		}
		else {
			//alert("Please Check Input Fields.!");
		}
	}
		
	
		function acknowledge_OT(){
			var emp=document.getElementById('emp').value;
			var year=document.getElementById('year').value;
			var month1=document.getElementById('month1').value;
			var month2=document.getElementById('month2').value;
			var user=document.getElementById('emp').value;
			var ot_sum=document.getElementById('ot_sum').value;
			
			var date1=year+'-'+month1;
			var date2=year+'-'+month2;

			if(year!="" && month1!="" && user!="" && month2!=""){
				
					if(ot_sum>0){
						$.post(site_url+"/timesheet/check_acknowledged/",{user:emp,d1:date1,d2:date2},function(data){		
							//alert(data);
							var str=data.split('::');
							var count=str[0];
							var from=str[1];
							var to=str[2];
								
									if(count==0){	
										var amount1=prompt("Enter Amount or Remark..!","");
												if(amount1!="" || amount1.length>0){
															$.post(site_url+"/timesheet/acknowledge_OT/",{user:emp,d1:date1,d2:date2,ot_hrs:ot_sum,amount:amount1},function(data1){		
																
																alert("Over Time Hours of "+emp+" was acknowledged..!");
																//window.location.reload();
															});
													}
												else{
													alert("You should enter Amount or Remark..!");
												}
										
									}
									else{
										if(from==to){
											alert("Over Time Hours of "+emp+" was already acknowledged for "+from);
										}
										else{
											alert("Over Time Hours of "+emp+" was already acknowledged for "+from+" - "+to);
										}
									
									}
									
							
						});
						
							
					}
					else{
						alert("Over Time Hours should not be Zero and Lesser than that..!");
					}
				
				
			}
	
	
 }
		
		function ack_history_dept(){
			document.getElementById('emp').value='';
			var year=document.getElementById('year').value;
			var month1=document.getElementById('month1').value;
			var month2=document.getElementById('month2').value;
			var dept1=document.getElementById('dept').value;
			document.getElementById('emp').value='';
					
			var date1=year+'-'+month1;
			var date2=year+'-'+month2;
					//alert(date2);
			
			
			if(year!="" && month1!="" && dept1!="" && month2!=""){
				$.post(site_url+"/timesheet/ack_history_dept/",{d1:date1,d2:date2,dept:dept1},function(data){		
					//alert(data);
					$("#contentData").html("");
					$("#contentData").append(data);
		
				});
			}
			else {
				//alert("Please Check Input Fields.!");
			}
				
		}
		


		
		function ack_history_emp(){
				var year1=document.getElementById('year').value;
				document.getElementById('month1').value="";
				document.getElementById('month2').value="";
				//var date1=year+'-'+month1;
				//var date2=year+'-'+month2;

				var emp=document.getElementById('emp').value;
				document.getElementById('dept').value='';
				
				if(year!="" && month1!="" && emp!="" && month2!=""){
					$.post(site_url+"/timesheet/ack_history_emp/",{year:year1,user:emp},function(data){		
						//alert(data);
						$("#contentData").html("");
						$("#contentData").append(data);
		
					});
				}
				else {
					//alert("Please Check Input Fields.!");
				}
	}


	
	
	function printOT(){

				var disp_setting="toolbar=yes,location=no,directories=yes,menubar=yes,";
				disp_setting+="scrollbars=yes,width=700, height=500, left=10, top=25";
				var text = document.getElementById('report_option').value;
				var month = document.getElementById('month').value;
				var year = document.getElementById('year').value;
						//alert(text);
				var content_value = document.getElementById("contentData").innerHTML;
				var docprint=window.open("","",disp_setting);
				docprint.document.open();
				docprint.document.write('<html><head>');
				docprint.document.write('</head><body onLoad="self.print()"><center>');
				
				docprint.document.write("<table align='center' width='100%'><tr style='font-size:20px;color:black;font-weight:bolder'><td align='center'>PREIPOLAR ENGINEERING PRIVATE LIMITED</td></td></tr></table>");
				docprint.document.write("<table align='center' width='100%'><tr style='font-size:16px;color:black;font-weight:bolder;background:white'><td align='center'>M-17, SIPCOT, Hi-Tech, SEZ, Sriperumbudur, Sunguvarchathiram, Kanchipuram 602105 - India</td></tr></table>");
				docprint.document.write("<p align='center' style='font-size:16px;color: black;font-weight:bold;'> "+text+" for "+month+" - "+year+"</p>");
				docprint.document.write("");
				docprint.document.write(content_value);
				
				docprint.document.write('</center></body></html>');
				docprint.document.close();
				docprint.focus();
				
		}


	function printOT_Summary(){

				var disp_setting="toolbar=yes,location=no,directories=yes,menubar=yes,";
				disp_setting+="scrollbars=yes,width=700, height=500, left=10, top=25";
				var mon1 = document.getElementById('month1').value;
				var mon2 = document.getElementById('month2').value;
				var month1='';
				var month2='';
				if(mon1=='01-01'){		month1='January';			}
				if(mon1=='02-01'){		month1='February';		}
				if(mon1=='03-01'){		month1='March';			}
				if(mon1=='04-01'){		month1='April';				}
				if(mon1=='05-01'){		month1='May';				}
				if(mon1=='06-01'){		month1='June';				}
				if(mon1=='07-01'){		month1='July';				}
				if(mon1=='08-01'){		month1='August';			}
				if(mon1=='09-01'){		month1='September';	}
				if(mon1=='10-01'){		month1='October';		}
				if(mon1=='11-01'){		month1='November';	}
				if(mon1=='12-01'){	 	month1='December';	}
				
				
				if(mon2=='01-31'){		month2='January';			}
				if(mon2=='02-28'){		month2='February';		}
				if(mon2=='03-31'){		month2='March';			}
				if(mon2=='04-30'){		month2='April';				}
				if(mon2=='05-31'){		month2='May';				}
				if(mon2=='06-30'){		month2='June';				}
				if(mon2=='07-31'){		month2='July';				}
				if(mon2=='08-31'){		month2='August';			}
				if(mon2=='09-30'){		month2='September';	}
				if(mon2=='10-31'){		month2='October';		}
				if(mon2=='11-30'){		month2='November';	}
				if(mon2=='12-31'){	 	month2='December';	}
				
				if(month1!=month2){
					var month=month1+' to '+month2;
				}
				else{
					var month=month1;
				}
				var year = document.getElementById('year').value;
				
				var emp = document.getElementById('emp').value;
				var dept = document.getElementById('dept').value;
				
								//alert(text);
				var content_value = document.getElementById("contentData").innerHTML;
				var docprint=window.open("","",disp_setting);
				docprint.document.open();
				docprint.document.write('<html><head>');
				docprint.document.write('</head><body onLoad="self.print()"><center>');
				
				docprint.document.write("<table align='center' width='100%'><tr style='font-size:20px;color:black;font-weight:bolder'><td align='center'>PREIPOLAR ENGINEERING PRIVATE LIMITED</td></td></tr></table>");
				docprint.document.write("<table align='center' width='100%'><tr style='font-size:16px;color:black;font-weight:bolder;background:white'><td align='center'>M-17, SIPCOT, Hi-Tech, SEZ, Sriperumbudur, Sunguvarchathiram, Kanchipuram 602105 - India</td></tr></table>");
				if(emp!=""){
					docprint.document.write("<p align='center' style='font-size:18px;color: black;font-weight:bolder;'><u> Over Time Summary of "+emp+"</u></p>");
					docprint.document.write("<p align='center' style='font-size:18px;color: black;font-weight:bolder;'><u> "+month+"-"+year+"</u></p>");

				}
				if(dept!=""){
					docprint.document.write("<p align='center' style='font-size:18px;color: black;font-weight:bolder;'><u> Over Time Summary of "+dept+" Department</u></p>");
					docprint.document.write("<p align='center' style='font-size:18px;color: black;font-weight:bolder;'><u> "+month+"-"+year+"</u></p>");
				}
				docprint.document.write("");
				docprint.document.write(content_value);
				
				docprint.document.write('</center></body></html>');
				docprint.document.close();
				docprint.focus();
				
		}
	
	
			function admin_ot_dept(){
				document.getElementById('emp').value='';
				var year=document.getElementById('year').value;
				var month1=document.getElementById('month1').value;
				var month2=document.getElementById('month2').value;
				var dept1=document.getElementById('dept').value;
				document.getElementById('ack_button').style.display='none';
				
				var date1=year+'-'+month1;
				var date2=year+'-'+month2;
						//alert(date2);
				
				
				if(year!="" && month1!="" && dept1!="" && month2!=""){
					$.post(site_url+"/timesheet/admin_ot_dept/",{d1:date1,d2:date2,dept:dept1},function(data){		
						//alert(data);
						$("#contentData").html("");
						$("#contentData").append(data);
		
					});
				}
				else {
					//alert("Please Check Input Fields.!");
				}
					
			}
			
		function cancel_Acknowledged(id1){
			var user=document.getElementById('emp').value;
			var reason=confirm("Do You want to cancel this OT - Acknowlegement?");
				if(reason==true){
					$.post(site_url+"/timesheet/cancel_Acknowledged/",{id:id1},function(data){		
			
						alert("Acknowledgement was  Cancelled for "+user+"..!");
						var dept=document.getElementById('dept').value;
						var emp=document.getElementById('emp').value;
						if(dept==""){
							ack_history_emp();
						}
						if(emp==""){
							ack_history_dept();
						}

					});
				}
		
			}


			function print_myOT_Summary(){

				var disp_setting="toolbar=yes,location=no,directories=yes,menubar=yes,";
				disp_setting+="scrollbars=yes,width=700, height=500, left=10, top=25";
				var mon1 = document.getElementById('month1').value;
				var mon2 = document.getElementById('month2').value;
				var month1='';
				var month2='';
				if(mon1=='01-01'){		month1='January';			}
				if(mon1=='02-01'){		month1='February';		}
				if(mon1=='03-01'){		month1='March';			}
				if(mon1=='04-01'){		month1='April';				}
				if(mon1=='05-01'){		month1='May';				}
				if(mon1=='06-01'){		month1='June';				}
				if(mon1=='07-01'){		month1='July';				}
				if(mon1=='08-01'){		month1='August';			}
				if(mon1=='09-01'){		month1='September';	}
				if(mon1=='10-01'){		month1='October';		}
				if(mon1=='11-01'){		month1='November';	}
				if(mon1=='12-01'){	 	month1='December';	}
				
				
				if(mon2=='01-31'){		month2='January';			}
				if(mon2=='02-28'){		month2='February';		}
				if(mon2=='03-31'){		month2='March';			}
				if(mon2=='04-30'){		month2='April';				}
				if(mon2=='05-31'){		month2='May';				}
				if(mon2=='06-30'){		month2='June';				}
				if(mon2=='07-31'){		month2='July';				}
				if(mon2=='08-31'){		month2='August';			}
				if(mon2=='09-30'){		month2='September';	}
				if(mon2=='10-31'){		month2='October';		}
				if(mon2=='11-30'){		month2='November';	}
				if(mon2=='12-31'){	 	month2='December';	}
				
				if(month1!=month2){
					var month=month1+' to '+month2;
				}
				else{
					var month=month1;
				}
				var year = document.getElementById('year').value;
				
				var emp = document.getElementById('emp').value;
				var txt = "Over Time Summary of "+emp+" for "+month+" - "+year;
					
								//alert(text);
				var content_value = document.getElementById("contentData").innerHTML;
				var docprint=window.open("","",disp_setting);
				docprint.document.open();
				docprint.document.write('<html><head>');
				docprint.document.write('</head><body onLoad="self.print()"><center>');
				
				docprint.document.write("<table align='center' width='100%'><tr style='font-size:20px;color:black;font-weight:bolder'><td align='center'>PREIPOLAR ENGINEERING PRIVATE LIMITED</td></td></tr></table>");
				docprint.document.write("<table align='center' width='100%'><tr style='font-size:16px;color:black;font-weight:bolder;background:white'><td align='center'>M-17, SIPCOT, Hi-Tech, SEZ, Sriperumbudur, Sunguvarchathiram, Kanchipuram 602105 - India</td></tr></table>");
				docprint.document.write("<p align='center' style='font-size:18px;color: black;font-weight:bolder;'><u> "+txt+" </u></p>");
				docprint.document.write("");
				docprint.document.write(content_value);
				
				docprint.document.write('</center></body></html>');
				docprint.document.close();
				docprint.focus();
				
		}



			function printOT_Ack_History(){

				var disp_setting="toolbar=yes,location=no,directories=yes,menubar=yes,";
				disp_setting+="scrollbars=yes,width=700, height=500, left=10, top=25";
				var mon1 = document.getElementById('month1').value;
				var mon2 = document.getElementById('month2').value;
				var month1='';
				var month2='';
				if(mon1=='01-01'){		month1='January';			}
				if(mon1=='02-01'){		month1='February';		}
				if(mon1=='03-01'){		month1='March';			}
				if(mon1=='04-01'){		month1='April';				}
				if(mon1=='05-01'){		month1='May';				}
				if(mon1=='06-01'){		month1='June';				}
				if(mon1=='07-01'){		month1='July';				}
				if(mon1=='08-01'){		month1='August';			}
				if(mon1=='09-01'){		month1='September';	}
				if(mon1=='10-01'){		month1='October';		}
				if(mon1=='11-01'){		month1='November';	}
				if(mon1=='12-01'){	 	month1='December';	}
				
				
				if(mon2=='01-31'){		month2='January';			}
				if(mon2=='02-28'){		month2='February';		}
				if(mon2=='03-31'){		month2='March';			}
				if(mon2=='04-30'){		month2='April';				}
				if(mon2=='05-31'){		month2='May';				}
				if(mon2=='06-30'){		month2='June';				}
				if(mon2=='07-31'){		month2='July';				}
				if(mon2=='08-31'){		month2='August';			}
				if(mon2=='09-30'){		month2='September';	}
				if(mon2=='10-31'){		month2='October';		}
				if(mon2=='11-30'){		month2='November';	}
				if(mon2=='12-31'){	 	month2='December';	}
				
				if(month1!=month2){
					var month=month1+' to '+month2;
				}
				else{
					var month=month1;
				}
				var year = document.getElementById('year').value;
				
				var emp = document.getElementById('emp').value;
				var dept = document.getElementById('dept').value;
					
								//alert(text);
				var content_value = document.getElementById("contentData").innerHTML;
				var docprint=window.open("","",disp_setting);
				docprint.document.open();
				docprint.document.write('<html><head>');
				docprint.document.write('</head><body onLoad="self.print()"><center>');
				
				docprint.document.write("<table align='center' width='100%'><tr style='font-size:20px;color:black;font-weight:bolder'><td align='center'>PREIPOLAR ENGINEERING PRIVATE LIMITED</td></td></tr></table>");
				docprint.document.write("<table align='center' width='100%'><tr style='font-size:16px;color:black;font-weight:bolder;background:white'><td align='center'>M-17, SIPCOT, Hi-Tech, SEZ, Sriperumbudur, Sunguvarchathiram, Kanchipuram 602105 - India</td></tr></table>");
				if(emp!=""){
					var txt = "Over Time Acknowledgement of "+emp+" for "+month+" - "+year;
					docprint.document.write("<p align='center' style='font-size:18px;color: black;font-weight:bolder;'><u> Over Time Acknowledgement of "+emp+"</u></p>");
					docprint.document.write("<p align='center' style='font-size:18px;color: black;font-weight:bolder;'><u> "+month+"-"+year+"</u></p>");

				}
				if(dept!=""){
					docprint.document.write("<p align='center' style='font-size:18px;color: black;font-weight:bolder;'><u> Over Time Acknowledgement of "+dept+" Department</u></p>");
					docprint.document.write("<p align='center' style='font-size:18px;color: black;font-weight:bolder;'><u> "+month+"-"+year+"</u></p>");
				}
				docprint.document.write("");
				docprint.document.write(content_value);
				
				docprint.document.write('</center></body></html>');
				docprint.document.close();
				docprint.focus();
				
		}
			
			
			
		
