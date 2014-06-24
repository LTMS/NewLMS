
	function get_leave_status(id)
	{		
		document.getElementById('error').innerHTML="";
		document.getElementById('errorrow').style.display="none";
		
		var date1=document.getElementById('date_from').value;
		var date2=document.getElementById('date_to').value;
		if(id=='1' && date1!='' && date2!=''){
			var l_type=document.getElementById('leave_type').value;			
			$.post(site_url+"/Leave/history/get_leave_status",{d1:date1,d2:date2,type:l_type},function(data){$("#contentData").html("");
			$("#contentData").append(data);});

		}
		if(id=='2'){
			document.getElementById('date_from').value='';
			document.getElementById('date_to').value='';

			var l_type='1';		
			$.post(site_url+"/Leave/history/get_leave_status",{d1:date1,d2:date2,type:l_type},function(data){$("#contentData").html("");
			$("#contentData").append(data);});
		}
		
	}

	
	
	
	function select_row(counter,type,day,d1,d2,user,id,status,reason,apptime,appby)
	{ 
		//alert(status);
		document.getElementById('buttoncol').innerHTML="Please Wait..! System Sending Mail to "+user+"...!";
		
		document.getElementById('type').value=type;
		document.getElementById('uname').value=user;
		document.getElementById('days').value=day;
			var rows=document.getElementById('TotalRows').value; 
			document.getElementById('date1').innerHTML="";
			document.getElementById('type').innerHTML="";
			document.getElementById('days').innerHTML="";
			document.getElementById('reason').innerHTML="";
			document.getElementById('applicant').innerHTML="";
			document.getElementById('apptime').innerHTML="";
			document.getElementById('appby').innerHTML="---";

		for( i=1; i<=rows;i++){
			if(i==counter){
				document.getElementById("row"+i).style.background="#AFEEEE";
				document.getElementById('selected_leave_id').value=id; 
			}
			else if(i%2==0){
				document.getElementById("row"+i).style.background="WHITE";
			}
			else{document.getElementById("row"+i).style.background="#EEEEEE";}
		}
		
		displayDiv(type,day,d1,d2,user,id,status,reason,apptime,appby);
		
		if(type=='Sick Leave' && day>1){ 	
			$.post(site_url+"/Leave/history/show_document",{lid:id},function(data){
						

				updatepop=window.open("","","menubar=no, location=no, status=no, titlebar=yes, width=700px, height=500px,toolbar=no,addressbar=no");
				var generatedContent="<html><head><title>Sick Leave Proof Document</title><script type='text/javascript' src='../../js/jquery-1.js'></script><script type='text/javascript' src='../../js/jquery-ui-1.8.18.custom.min.js'></script><style type='text/css'>div.ui-datepicker{font-size:10px;width:150px;height:150px;}</style><link rel='stylesheet' media='screen,projection' type='text/css' href='../../css/mystyle.css' /><link rel='stylesheet' media='' type='text/css' href='../../css/jquery-ui-1.8.18.custom.css' /></head>"+
				 "<body background='../../images/bg-radial-gradient.gif' bgcolor='' ><div style='height:auto; background:#CEF6F5;margin:20px 0px 0px 20px;width:700px;border:1px solid black ;border-radius:20px;'><p style='height:10px;padding:0px 0px 0px 20px;' align='center'><span style='font-weight:bolder;font-size:13pt;'>" +id+" - "+user+" Sick Leave Proof Document for "+d1+" - "+d2+" "+ "</span></p>"+
				 "<hr width='700px'>"+
				 "<div id='sick_document' style='margin:20px 20px 20px 40px;'><img align='enter' width='600' height='450' id='IMG1' /></div><div align='enter' style='margin-left:100px;margin-bottom:30px;align:center;width:500px'><input align='enter' type=\"button\" id='close' value='Close' class='button' onclick='javascript:self.close()'/></div></p></body></html>";
				 updatepop.document.write(generatedContent);   
				updatepop.document.getElementById('sick_document').style.display="";
				 updatepop.document.getElementById("IMG1").src="/LMS/files/"+data;
					});
			
		}
		
	
		
	}

	function displayDiv(type,day,d1,d2,user,id,status,reason,apptime,appby){
		document.getElementById('approved1').style.display="none";
		document.getElementById('applied1').style.display="none";
		document.getElementById('rejected1').style.display="none";

			
		document.getElementById('date1').innerHTML=d1;
		document.getElementById('type').innerHTML=type;
		document.getElementById('days').innerHTML=day;
		document.getElementById('reason').innerHTML=reason;
		document.getElementById('applicant').innerHTML=user;
		document.getElementById('apptime').innerHTML=apptime;
		document.getElementById('appby').innerHTML=appby;
		document.getElementById('Details').style.display="";
		//alert(status);


				$.post(site_url+"/Leave/history/leaves_on_sameday/",{date1:d1,date2:d2,id1:id},function(data){
				$("#leavesDiv").html("");
				$("#leavesDiv").append(data);
		     	document.getElementById('leavesDiv').style.display="";
		
				});
				//alert(user);
				$.post(site_url+"/Leave/history/getRecentLeave/",{user1:user,id1:id},function(data){
						document.getElementById('recent').innerHTML=data;
				});
		
	}
	
	
	
	function approve()
	{ 
		document.getElementById('buttonrow').style.display='none';
		document.getElementById('buttonrow1').style.display='';
			var l_id=document.getElementById('selected_leave_id').value; 
		if(l_id!=""){
		var l_reason="Leave Approved..!";
		if(l_reason != null && l_reason != ""){
			$.post(site_url+"/Leave/history/approve/",{lid:l_id,reason:l_reason},function(data){
                                               //alert(data);
				window.location.reload();
				});
			
			}
			else if(l_reason==""){alert("You Must Enter the Reason to Process.!");}
		}
		else {alert("Select a Leave ID to Process.!");}
	}
	
	
	
	
	
	function reject()
	{ 
		document.getElementById('buttonrow').style.display='none';
		document.getElementById('buttonrow1').style.display='';
		var l_id=document.getElementById('selected_leave_id').value; 
		var l_type=document.getElementById('type').value; 
		var uname=document.getElementById('uname').value; 
		var days=document.getElementById('days').value; 
		var hrs1=parseInt(days)*8;
		var hrs2=hrs1+':00:00';
		//alert(hrs2);
			if(l_id!=""){
		var l_reason="Leave Rejected..!";
			if(l_reason != null && l_reason != ""){
				$.post(site_url+"/Leave/history/reject/",{lid:l_id,reason:l_reason,type:l_type,user:uname,hrs:hrs2},function(data){
						window.location.reload();
						});
					}
					else if(l_reason==""){alert("You Must Enter the Reason to Process.!");}
				}
		else {
				alert("Select a Leave ID to Process.!");
			}
	}
		
	
	function admin_leavehistory_general()		{	
						document.getElementById('year1').value="";
						document.getElementById('emp_appr').value="All";
						var leave1=document.getElementById('leave').value; 
						if(leave1!="All"){
							document.getElementById('month').value="All";
						}
						var year1=document.getElementById('year').value;
						var month1=document.getElementById('month').value;
						var emp1=document.getElementById('emp').value;

								
								if(year1!="" && emp1!="" && leave1=="All"){
											$.post(site_url+"/Leave/history/admin_leavehistory_general_all",{year:year1,month:month1,emp:emp1},function(data){
														//alert(data);
														$("#contentData").html("");
														$("#contentData").append(data);
												});
									}
								if(year1!="" && emp1!="" && leave1!="All"){
											$.post(site_url+"/Leave/history/admin_leavehistory_general_filter",{year:year1,month:month1,emp:emp1,leave:leave1},function(data){
														//alert(data);
														$("#contentData").html("");
														$("#contentData").append(data);
											});
									}
	}										
				
							
		function admin_leavehistory_approved()	{	
						document.getElementById('AllEmp_leave_history_dwnld').style.display="";
						document.getElementById('year').value="";
						document.getElementById('emp').value="";
						document.getElementById('leave').value="All";
						document.getElementById('month').value="All";
						var year1=document.getElementById('year1').value;
						if(year1=="")
							{
							document.getElementById('AllEmp_leave_history_dwnld').style.display="none";
							}
						var emp_appr=document.getElementById('emp_appr').value; 
						//alert(year1);		
							if(year1!=""){
										$.post(site_url+"/Leave/history/admin_leavehistory_approved",{year:year1,emp:emp_appr},function(data){
												//alert(data);
														$("#contentData").html("");
														$("#contentData").append(data);
											});
								}
								
			}
		

																		/*  My Leave History  */ 
		
		function my_leavehistory_general()		{	
							document.getElementById('year1').value="";
							var leave1=document.getElementById('leave').value; 
							if(leave1!="All"){
								document.getElementById('month').value="All";
							}
							var year1=document.getElementById('year').value;
							var month1=document.getElementById('month').value;
							var emp_name=document.getElementById('month').value;
							if(month1=="All"){
								var date_txt=year1;
							}
							else{
								var date_txt=month1+" - "+year1;
							}
									
									if(year1!=""  && leave1=="All"){
												$.post(site_url+"/Leave/history/my_leavehistory_general_all",{year:year1,month:month1},function(data){
															//alert(data);
															document.getElementById('report_option').value=emp_name+" Leave History for "+date_txt;
															$("#contentData").html("");
															$("#contentData").append(data);
															
													});
										}
									if(year1!=""  && leave1!="All"){
												document.getElementById('report_option').value=emp_name+" Leave History of  " +leave1+" for "+year1;
												$.post(site_url+"/Leave/history/my_leavehistory_general_filter",{year:year1,month:month1,leave:leave1},function(data){
															//alert(month1);
															$("#contentData").html("");
															$("#contentData").append(data);
												});
										}
		}										
					
								
			function my_leavehistory_approved()	{	
							document.getElementById('year').value="";
							document.getElementById('leave').value="All";
							document.getElementById('month').value="All";
							var year1=document.getElementById('year1').value;
							//alert(year1);
							if(year1!=""){
											$.post(site_url+"/Leave/history/my_leavehistory_approved",{year:year1},function(data){
													//alert(data);
															document.getElementById('report_option').value=emp_name+" Leave History [ Approved ] for "+year1;
															$("#contentData").html("");
															$("#contentData").append(data);
												});
									}
									
				}
			
	
		
			function get_history_teamleader(str,op)	{
			
				var tl=document.getElementById('get_team').value+" Team"; 
			
				if(op=='1'){
					document.getElementById('filter').value="null";
					document.getElementById('search').value="null"; 
					document.getElementById('report_option').value="Employees Leave History of "+tl;
							}
				if(op=='2'){
					document.getElementById('filter').value="null";
					document.getElementById('report_option').value="Leave History of "+str+" - "+tl;
				}
				if(op=='3'){
					document.getElementById('search').value="null";
					document.getElementById('report_option').value=str+" History of "+tl;
				}

			var date1=document.getElementById('date_from').value;
			var date2=document.getElementById('date_to').value;
			document.getElementById('error').innerHTML="";
					
					$.post(site_url+"/Leave/history/get_history_teamleader",{d1:date1,d2:date2,string:str},function(data){
							$("#contentData").html("");
							$("#contentData").append(data);
					});
			}

			
		function get_approved_leaves(){
				var yr=document.getElementById('year').value;
				var mon=document.getElementById('month').value;
				var emp1=document.getElementById('emp').value;
					
				if(year!='' && mon!='' && emp!=''){
					$.post(site_url+"/Leave/history/get_approved_leaves",{year:yr,month:mon,emp:emp1},function(data){
						//alert(data);
							$("#contentData").html("");
							$("#contentData").append(data);
					});
			}
				
			}
			
			function remove_leave(l_id){
				//alert(l_id);
				$.post(site_url+"/Leave/history/remove_leave/",{id:l_id},function(data){
					get_leave_status('2');
				});

			}
			
			
			
			function SendReminder(type,date,days,reason,colid,button,id){
				//alert(button);
				document.getElementById(colid).style.color='red';
				document.getElementById(colid).innerHTML='Sending Reminder...';
				//alert(type+' ,'+date+' ,'+days+' ,'+reason);
				$.post(site_url+"/Leave/history/getOfficer_L1",{leaveID:id},function(data){
						var to1=data;
									$.post(site_url+"/Leave/history/SendRemainder",{date_from:date,reasoning:reason,day:days,l_type:type,to:to1},function(data){
								
										document.getElementById(colid).style.color='green';
										document.getElementById(colid).innerHTML=data;
											});
					});

			}
			
			/* refreshing a division
			var refreshId = setInterval(function () {
			    $('#lms_intro_div').fadeOut("slow").load('site_url+"/Leave/history/index.php').fadeIn("slow");
			}, 60000);
			*/
			
			
			function check_clicked(){
				var check=document.getElementById('intro_check').checked;
				
				if(check==true){
					//alert('1');
					document.getElementById('carry_color').style.color='green';
				}
				else{
					//alert('0');
					document.getElementById('carry_color').style.color='red';
				}
				
			}
			
			
			
			function export_leave_history(id)
			{
				var sdate=document.getElementById('date_from').value;
				var edate=document.getElementById('date_to').value;
				var filter=document.getElementById("leave_type").value;
				if(id=='1' && sdate!='' && edate!=''){
					var params=sdate+"::"+edate+"::"+filter;
					var downloadurl=site_url+"/Leave/history/export_leave_history/"+params;
					window.location=downloadurl;

				}	else
					{
					alert("Please Check Dates");
					}
				
				
			}
			
			
			
			
			function process_permission(id,date1,user1){
				document.getElementById(id).style.background='grey';
				document.getElementById(id).style.color='white';
				document.getElementById('p_id').value=id;
				document.getElementById('p_user').value=user1;
				document.getElementById('p_date').value=date1;
				document.getElementById('buttons').style.display="";
				document.getElementById('col_1').innerHTML="Wait..! System is Sending Mail to "+user1;
				
				
			}

			function grantPermission(remark1){
				document.getElementById('button1').style.display="";
				document.getElementById('buttons').style.display="none";
					
				var id1 =document.getElementById('p_id').value;
				var user1=document.getElementById('p_user').value;
				var date1=document.getElementById('p_date').value;

				$.post(site_url+"/Leave/history/grantPermission/",{user:user1,date:date1,remark:remark1,id:id1},function(data){
					window.location.reload();
				});

			}

			
													/* * *    Reminder	* * */
			
			function SendReminder(type,date,days,reason,colid,button,id){
							//alert(button);
							document.getElementById(colid).style.color='red';
							document.getElementById(colid).innerHTML='Sending Reminder...';
							
							$.post(site_url+"/lms/getOfficer_L1",{leaveID:id},function(data){
										var to1=data;
												$.post(site_url+"/lms/SendRemainder",{date_from:date,reasoning:reason,day:days,l_type:type,to:to1},function(data){
														document.getElementById(colid).style.color='green';
														document.getElementById(colid).innerHTML=data;
												});
							});
			}
			
			//Reminder End			



