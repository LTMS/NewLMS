																/* * * 	   Action on Leave Status    * * */

function update_LeaveStatusReporter(leave_id1,status1,button_row,emp_name1,emp_num1,type1,date1,tot_days1,reason1,apptime1){
					if(status1==2){
						innertxt="Leave was Reported..!";
						mail_subject1="Hi, "+emp_name1+"..!   Your Leave was passed to Approving Authority..!";
					}
					else{
						innertxt="Reporter Cancelled..!";
						mail_subject1="Hi, "+emp_name1+"..!   Your Leave was Cancelled by Reporting Authority..!";
					}
					var remark1=prompt("Enter Your Remarks..!","");
					//var length = remark1.length;
					if( remark1 != null){
										if(remark1.replace(/[^A-Z]/gi, "").length>0){
												document.getElementById(button_row).innerHTML="Sending Mail...!";
												$.post(site_url+"/Leave/history/update_LeaveStatusReporter/",{leave_id:leave_id1,remark:remark1,status:status1},function(data){
												
															$.post(site_url+"/Leave/history/Send_LeaveMail/",{leave_id:leave_id1,remark:remark1,mail_subject:mail_subject1,emp_name:emp_name1,emp_num:emp_num1,type:type1,date:date1,tot_days:tot_days1,reason:reason1,apptime:apptime1},function(data){
																		document.getElementById(button_row).innerHTML=innertxt;
																	});
													
												});
										}
										else{
											alert("You should enter the Remarks..!");
										}
							}
						else{
							alert("You should enter the Remarks..!");
						}
		}
		
		
		function update_LeaveStatusApprover(leave_id1,status1,button_row,emp_name1,emp_num1,type1,date1,tot_days1,reason1,apptime1){
					if(status1==4){
						innertxt="Leave was Approved..!";
						color="green";
						mail_subject1="Hi, "+emp_name1+"..!   Your Leave was Approved..!";
					}
					else{
						innertxt="Leave was  Rejected..!";
						color="red";
						mail_subject1="Hi, "+emp_name1+"..!   Your Leave was Rejected by Approving Authority..!";
					}
					var remark1=prompt("Enter Your Remarks..!","");
						//	var length = remark1.length;
							if(remark1 != null){
								if(remark1.replace(/[^A-Z]/gi, "").length>0){
									document.getElementById(button_row).style.color="#CA00CA";
									document.getElementById(button_row).innerHTML="Sending Mail...!";
									$.post(site_url+"/Leave/history/update_LeaveStatusApprover/",{leave_id:leave_id1,remark:remark1,status:status1},function(data){
													
											
															$.post(site_url+"/Leave/history/Send_LeaveMail/",{leave_id:leave_id1,remark:remark1,mail_subject:mail_subject1,emp_name:emp_name1,emp_num:emp_num1,type:type1,date:date1,tot_days:tot_days1,reason:reason1,apptime:apptime1},function(data){
																document.getElementById(button_row).style.color=color;
																document.getElementById(button_row).innerHTML=innertxt;
																});
															
										});
								}
								else{
									alert("You should enter the Remarks..!");
								}
					}
				else{
					alert("You should enter the Remarks..!");
				}
}


																						/* * *		 Admin Leave History  		* * */ 
	
		function get_DepartmentEmployees(dept1){
			
		var select=document.getElementById('emp').options.  length = 2;

			$.post(site_url+"/Leave/history/get_DepartmentEmployees",{dept:dept1},function(data){
								var list=data.split('::');
								for(i=1;i<list.length;i++)
								{
										if(i%2!=0){
											//alert(list[i]+" : "+list[i+1]);
												if(list[i]!="" && list[i].replace(/[^A-Z]/gi, "").length>0){
														var opt = document.createElement("option");
																if(document.getElementById("emp")){
																			document.getElementById("emp").options.add(opt);
																			opt.text =list[i];
																		    opt.value = list[i+1];
																}
													}
										}
									
							}
			}); 
					
}

	
	function admin_leavehistory_general(part,value){	
		//alert(value);

					if(part=='Dept'){
						var dept1=document.getElementById('dept').value;	
					
						document.getElementById('emp').value="All";
						
								get_DepartmentEmployees(dept1); 
							
					}
		
					var emp1=document.getElementById('emp').value; 
					
	/*					if(emp1!="All" ){
							document.getElementById('month').value="All";
						}
	*/
						var year1=document.getElementById('year').value;
						var month1=document.getElementById('month').value;
						var leave1=document.getElementById('leave').value; 
						var dept1=document.getElementById('dept').value;
					//	alert("YEAR:"+year1+",  MONTH:"+month1+", DEPT:"+dept1+", EMP:"+emp1+", LEAVE:"+leave1);
						if(dept1!="" && emp1!=""){
							$.post(site_url+"/Leave/history/admin_leavehistory_general",{year:year1,month:month1,dept:dept1,emp:emp1,leave:leave1},function(data){
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
			
																						/* * *		 Permissions         * * */
			
			function update_Permission(perm_id1,status1,button_row,emp_name1,emp_num1,date1,time1,hours1,reason1,app_on1){
				
						if(status1=="Allowed"){
							innertxt="Permission was Approved..!";
							color="green";
							mail_subject1="Your are Allowed to take "+hours1+" Permission from "+time1+" on "+ date1+".";
						}
						else{
							innertxt="Permission was Rejected..!";
							color="red";
							mail_subject1="Your are Not Allowed to take Permission  on "+ date1+".";
						}
						var remark1=prompt("Enter Your Remarks..!","");
						//var length = remark1.length;
						if(remark1 != null){
									if(remark1.replace(/[^A-Z]/gi, "").length>0){
										document.getElementById(button_row).style.color="#CA00CA";
										document.getElementById(button_row).innerHTML="Sending Mail...!";

												$.post(site_url+"/Leave/history/update_Permission/",{perm_id:perm_id1,status:status1,remark:remark1},function(data){
																	//alert(data);
																	$.post(site_url+"/Leave/history/Send_PermissionMail/",{remark:remark1,mail_subject:mail_subject1,emp_name:emp_name1,emp_num:emp_num1,date:date1,time:time1,hours:hours1,reason:reason1,app_on:app_on1},function(data){
																		alert(data);
																		document.getElementById(button_row).style.color=color;
																		document.getElementById(button_row).innerHTML=innertxt;
																	});
												});
									}
									else{
										alert("You should enter the Reason..!");
									}
						}
						else{
							alert("You should enter the Reason..!");
						}
			}
		

			
// Perimission History
			
			function get_permission_history(){
				var year1=document.getElementById('year').value;
				var status1=document.getElementById('status').value;
				var emp_num1=document.getElementById('emp_num').value;
				//alert(year1+status1+emp_num1);
				if(year!=""){
						$.post(site_url+"/Leave/history/get_permission_history/",{year:year1,status:status1,emp_num:emp_num1},function(data){
								$("#contentData").html("");
								$("#contentData").append(data);
						});
				}
				
				
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



			
											/* * *   onMOUSE  Functions * * */
			
			function change_OnMouseOver(id,over){
				
				document.getElementById(id).src='../../../images/Leave/'+over;
			}
			
			
			function change_OnMouseOut(id,normal){
				
				document.getElementById(id).src='../../../images/Leave/'+over;
			}
			
			
			
			/*  Replacing script
			
			remark1 = remark1.replace(/[^A-Z]/gi, "");

			*/
			
			/* Refreshing a division
			 
						var refreshId = setInterval(function () {
						    $('#lms_intro_div').fadeOut("slow").load('site_url+"/Leave/history/index.php').fadeIn("slow");
						}, 60000);
			
			*/
			

			
			