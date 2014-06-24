$("#date").datepicker({
	dateFormat: 'dd-mm-yy',onClose:function(selectedDate){},		
	defaultDate: new Date()		
});
		
$("#date_from").datepicker({
	dateFormat: 'dd-mm-yy',onClose:function(selectedDate){},		
	defaultDate: new Date()		
});

$("#date_to").datepicker({
	dateFormat: 'dd-mm-yy',onClose:function(selectedDate){},	
	defaultDate: new Date()		
});


			function timesheet_data(){
				document.getElementById('error').innerHTML="";
				document.getElementById('button').style.display="none";
				
				var data={};
				data["date"] =document.getElementById('date').value;
							
				if(data["date"] == "" || data["date"] ==null  ){	
					document.getElementById('error').innerHTML="Please Check the Date Field..!";
					document.getElementById('buttonrow').style.display="";
					
				}
						
				else{
					
					var min=0;
					var hr=0;
					var i,j;
					for(i=1;i<=7;i++){
							var id='job_'+i+'M';
							
							var	val=document.getElementById(id).value;
							if(val!="" && val!=null){
								min=parseInt(min)+parseInt(val);					
							}
						}
					var hours = min / 60; 
					var minutes = min % 60;
					if(minutes<10)
					{
						minutes="0"+minutes;
					}
	
					for(j=1;j<=7;j++){
						var id1='job_'+j+'H';
						var val1=document.getElementById(id1).value;
						if(val1!="" && val1!=null){
							hr=parseInt(hr)+parseInt(val1);					
						}
					}
					var total_hrs=parseInt(hours)+hr;
					if(total_hrs<10)
					{
					total_hrs="0"+total_hrs;
					}
			
					var time1=total_hrs+':'+minutes+':00';
							
					var time2=document.getElementById('duty').value;
					//alert(time1+'=='+time2);
					
					if(time1==time2){
						var ask=confirm("Do You want to update these data to Your Time Sheet?");
						if(ask==true){
							
									data["in"]=document.getElementById('intime').value;
									data["out"]=document.getElementById('outtime').value;
									data["ot"]=document.getElementById('ot').value;
									data["lunch"]=document.getElementById('lunch').value;
									data["late"]=document.getElementById('late').value;
									data["tot"]=document.getElementById('total').value;
									data["duty"]=document.getElementById('duty').value;
										
									data["jd1"]=document.getElementById('job_1').value;
									data["jd2"]=document.getElementById('job_2').value;
									data["jd3"]=document.getElementById('job_3').value;
									data["jd4"]=document.getElementById('job_4').value;
									data["jd5"]=document.getElementById('job_5').value;
									data["jd6"]=document.getElementById('job_6').value;
									data["jd7"]=document.getElementById('job_7').value;
									 data["Hr1"]=document.getElementById('job_1H').value+':'+document.getElementById('job_1M').value+':00';
									 data["Hr2"]=document.getElementById('job_2H').value+':'+document.getElementById('job_2M').value+':00';
									 data["Hr3"]=document.getElementById('job_3H').value+':'+document.getElementById('job_3M').value+':00';
								     data["Hr4"]=document.getElementById('job_4H').value+':'+document.getElementById('job_4M').value+':00';
									 data["Hr5"]=document.getElementById('job_5H').value+':'+document.getElementById('job_5M').value+':00';
									 data["Hr6"]=document.getElementById('job_6H').value+':'+document.getElementById('job_6M').value+':00';
									 data["Hr7"]=document.getElementById('job_7H').value+':'+document.getElementById('job_7M').value+':00';
										
							
									 data["atv1"]=document.getElementById('atv_1').value;
									 data["atv2"]=document.getElementById('atv_2').value;
									 data["atv3"]=document.getElementById('atv_3').value;
									 data["atv4"]=document.getElementById('atv_4').value;
									 data["atv5"]=document.getElementById('atv_5').value;
									 data["atv6"]=document.getElementById('atv_6').value;
									 data["atv7"]=document.getElementById('atv_7').value;
												
									 data["np1"]=document.getElementById('np_1').value;					
									 data["np2"]=document.getElementById('np_2').value;					
									 data["np3"]=document.getElementById('np_3').value;					
									 data["np4"]=document.getElementById('np_4').value;					
									 data["np5"]=document.getElementById('np_5').value;					
									 data["np6"]=document.getElementById('np_6').value;					
									 data["np7"]=document.getElementById('np_7').value;					
										
									 //alert(document.getElementById('desc1').value);
									 data["desc1"]=document.getElementById('desc1').value;					
									 data["desc2"]=document.getElementById('desc2').value;					
									 data["desc3"]=document.getElementById('desc3').value;					
									 data["desc4"]=document.getElementById('desc4').value;					
									 data["desc5"]=document.getElementById('desc5').value;					
									 data["desc6"]=document.getElementById('desc6').value;					
									 data["desc7"]=document.getElementById('desc7').value;					
													
									
							//	alert(	data["jd1"]+''+	data["jd2"]);	
									
								$.post(site_url+"/Timesheet/timesheet/insert_timesheet_data/",data,function(result){
											//alert();	
								});
								alert("Time Sheet Updated Successfully..!");
								window.location.reload();
									
								}
				}
					else{
						document.getElementById('error').innerHTML="Duty Hours Mismatch..!";
					}
			}		
		}
			
			
			
			
			
			function edit_jobs(no,desc,id){
				//document.getElementById('tit1').innerHTML="Edit Job";
				document.getElementById('job_no').value=no;
				document.getElementById('job_desc').value=desc;
				document.getElementById('edit_id1').value=id;
				document.getElementById('row_job1').style.display="none";
				document.getElementById('row_job2').style.display="";
				document.getElementById("job_no").setAttribute("readonly",1);
										
			}
			
			function edit_npjobs(no,desc,id){
				//document.getElementById('tit2').innerHTML="Edit Job";
				document.getElementById('npjob_no').value=no;
				document.getElementById('npjob_desc').value=desc;
				document.getElementById('edit_id2').value=id;
				document.getElementById('row_npjob1').style.display="none";
				document.getElementById('row_npjob2').style.display="";
				document.getElementById("npjob_no").setAttribute("readonly",1);
				
			}
			
			
			function process_npjobs(val,no){
				//alert(val+' : '+no);				
				
				$.post(site_url+"/Timesheet/timesheet/process_npjobs/",{value:val,num:no},function(result){
					window.location.reload();
				});
		
			}
			
			function process_jobs(val,no){
				//alert(val+' : '+no);						
					
							$.post(site_url+"/Timesheet/timesheet/process_jobs/",{value:val,num:no},function(result){
								window.location.reload();
									});
			
				}		
				
				
			function add_job(type1){
				
				if(type1=='1'){
					var job_no = document.getElementById("job_no").value;
					var desc1 = document.getElementById("job_desc").value;
					
					}
				
				if(type1=='2'){
					var job_no = document.getElementById("npjob_no").value;
					var desc1 = document.getElementById("npjob_desc").value;
					}
				
				
				if(job_no !="" && desc1 !=""){
					$.post(site_url+"/Timesheet/timesheet/add_jobs/",{num:job_no,desc:desc1,type:type1},function(result){
						window.location.reload();
						//alert(result);
				});
				
				}
					
			}
			
			
			function update_job(type1){
				
				if(type1=='1'){
					var job_no = document.getElementById("job_no").value;
					var desc1 = document.getElementById("job_desc").value;
					var id1 = document.getElementById("edit_id1").value;
						
					}
				
				if(type1=='2'){
					var job_no = document.getElementById("npjob_no").value;
					var desc1 = document.getElementById("npjob_desc").value;
					var id1 = document.getElementById("edit_id2").value;
						}
				
				
				if(job_no !="" && desc1 !=""){
					$.post(site_url+"/Timesheet/timesheet/update_jobs/",{num:job_no,desc:desc1,type:type1,id:id1},function(result){
						window.location.reload();
				});
				
				}
					
			}
			
			
		
			
			function get_timesheet_overall(){
				var date1 = document.getElementById('date_from').value;
				var date2 = document.getElementById('date_to').value;
				document.getElementById('getjob').style.display="none";
				document.getElementById('getjob').value="";
				document.getElementById('getuser').style.display="none";
				document.getElementById('getuser').value="";
				document.getElementById('getuser1').style.display="none";
				document.getElementById('getuser1').value="";
				document.getElementById('getuser2').style.display="none";
				document.getElementById('getuser2').value="";
				document.getElementById('report_option').value="Over all Jobwise Report";
				
						
							$.post(site_url+"/Timesheet/timesheet/get_timesheet_overall",{d1:date1,d2:date2},function(data){							
										$("#contentData").html("");
										$("#contentData").append(data);
								});	
	
		}
			
			function get_timesheet_jobwise(){
				var date1 = document.getElementById('date_from').value;
				var date2 = document.getElementById('date_to').value;
				document.getElementById('getjob').style.display="";
				var num1 = document.getElementById('getjob').value;
				document.getElementById('getuser').style.display="none";
				document.getElementById('getuser').value="";
				document.getElementById('getuser1').style.display="none";
				document.getElementById('getuser1').value="";
				document.getElementById('getuser2').style.display="none";
				document.getElementById('getuser2').value="";
				document.getElementById('report_option').value="Time Sheet Report for JOB No: "+num1;
				
					if( num1 != "" ){	
						
							$.post(site_url+"/Timesheet/timesheet/get_timesheet_jobwise",{d1:date1,d2:date2,num:num1},function(data){							
										$("#contentData").html("");
										$("#contentData").append(data);
								});	
		
					}	
		}
			
			
			function get_timesheet_userwise(){
				var date1 = document.getElementById('date_from').value;
				var date2 = document.getElementById('date_to').value;
				document.getElementById('getuser').style.display="";
				var user1 = document.getElementById('getuser').value;
				document.getElementById('getjob').style.display="none";
				document.getElementById('getjob').value="";
				document.getElementById('getuser1').style.display="none";
				document.getElementById('getuser1').value="";
				document.getElementById('getuser2').style.display="none";
				document.getElementById('getuser2').value="";
				document.getElementById('report_option').value="Time Sheet Report of "+user1;
				
				
					if(user1 != "" ){	
						
							$.post(site_url+"/Timesheet/timesheet/get_timesheet_userwise",{d1:date1,d2:date2,user:user1},function(data){							
										$("#contentData").html("");
										$("#contentData").append(data);
								});	
				}
								
		}
			
			function get_timesheet_ot(){
				var date1 = document.getElementById('date_from').value;
				var date2 = document.getElementById('date_to').value;
				document.getElementById('getjob').style.display="none";
				document.getElementById('getjob').value="";
				document.getElementById('getuser').style.display="none";
				document.getElementById('getuser').value="";
				document.getElementById('getuser1').style.display="none";
				document.getElementById('getuser1').value="";
				document.getElementById('getuser2').style.display="none";
				document.getElementById('getuser2').value="";
				document.getElementById('report_option').value="Employees Over all Working Hours Details";
				
				
					if(date1!="" && date2 !="" ){	
						
							$.post(site_url+"/Timesheet/timesheet/get_timesheet_ot",{d1:date1,d2:date2},function(data){							
										$("#contentData").html("");
										$("#contentData").append(data);
								});	
				}
								
		}
			function get_timesheet_Dept(){
				var date1 = document.getElementById('date_from').value;
				var date2 = document.getElementById('date_to').value;
				document.getElementById('getjob').style.display="none";
				document.getElementById('getjob').value="";
				document.getElementById('getuser').style.display="none";
				document.getElementById('getuser').value="";
				document.getElementById('getuser1').style.display="none";
				document.getElementById('getuser1').value="";
				document.getElementById('getuser2').style.display="none";
				document.getElementById('getuser2').value="";
				document.getElementById('report_option').value="Employees Over all Working Hours Details";
				
				
					if(date1!="" && date2 !="" ){	
						
							$.post(site_url+"/Timesheet/timesheet/get_timesheet_ot",{d1:date1,d2:date2},function(data){							
										$("#contentData").html("");
										$("#contentData").append(data);
								});	
				}
								
		}
			
			
			function timesheet_activity_emp(){
					var date1 = document.getElementById('date_from').value;
					var date2 = document.getElementById('date_to').value;
					document.getElementById('getuser1').style.display="";
					var user1 = document.getElementById('getuser1').value;
					document.getElementById('getjob').style.display="none";
					document.getElementById('getjob').value="";
					document.getElementById('getuser').style.display="none";
					document.getElementById('getuser').value="";
					document.getElementById('getuser2').style.display="none";
					document.getElementById('getuser2').value="";
					document.getElementById('report_option').value="Time Activities Report of "+user1;
					
					
						if(user1 != "" ){	
							
								$.post(site_url+"/Timesheet/timesheet/timesheet_activity_emp",{d1:date1,d2:date2,user:user1},function(data){							
											$("#contentData").html("");
											$("#contentData").append(data);
									});	
					}
								
		}
			
			
			
			function user_timesheet_overall(){
				var date1 = document.getElementById('date_from').value;
				var date2 = document.getElementById('date_to').value;
				var uname=document.getElementById('emp_name').value;
				document.getElementById('report_option').value="Over all Jobwise Report of "+uname;
				document.getElementById('getjob').style.display="none";
					document.getElementById('getjob').value="";
						
							$.post(site_url+"/Timesheet/timesheet/user_timesheet_overall",{d1:date1,d2:date2},function(data){							
										$("#contentData").html("");
										$("#contentData").append(data);
								});	
		
								
		}
		
			
			function user_timesheet_jobwise(){
				var date1 = document.getElementById('date_from').value;
				var date2 = document.getElementById('date_to').value;
				var uname=document.getElementById('emp_name').value;
				document.getElementById('report_option').value="Time Sheet Report of "+uname;
				document.getElementById('getjob').style.display="";
				var num1 = document.getElementById('getjob').value;
			
					if( num1 != "" ){	
						
							$.post(site_url+"/Timesheet/timesheet/user_timesheet_jobwise",{d1:date1,d2:date2,num:num1},function(data){							
										$("#contentData").html("");
										$("#contentData").append(data);
								});	
		
					}	
		}

			
			
			function timesheet_activity_user(){
				var date1 = document.getElementById('date_from').value;
				var date2 = document.getElementById('date_to').value;
				var uname=document.getElementById('emp_name').value;
				document.getElementById('report_option').value="Time Activities Report of "+uname;
				document.getElementById('getjob').style.display="";
				document.getElementById('getjob').style.display="none";
				document.getElementById('getjob').value="";
			
							$.post(site_url+"/Timesheet/timesheet/timesheet_activity_user",{d1:date1,d2:date2},function(data){							
										$("#contentData").html("");
										$("#contentData").append(data);
								});	
									
			}

				
			function team_timesheet_overall(){
				var date1 = document.getElementById('date_from').value;
				var date2 = document.getElementById('date_to').value;
				document.getElementById('getjob').style.display="none";
				document.getElementById('getjob').value="";
				document.getElementById('getuser').style.display="none";
				document.getElementById('getuser').value="";
				document.getElementById('getuser1').style.display="none";
				document.getElementById('getuser1').value="";
				var uname=document.getElementById('emp_name').value;
				document.getElementById('report_option').value="Over all Jobwise Report of "+uname;
				
						
							$.post(site_url+"/Timesheet/timesheet/team_timesheet_overall",{d1:date1,d2:date2},function(data){							
										$("#contentData").html("");
										$("#contentData").append(data);
								});	
	
		}
			
			function team_timesheet_jobwise(){
				var date1 = document.getElementById('date_from').value;
				var date2 = document.getElementById('date_to').value;
				document.getElementById('getjob').style.display="";
				var num1 = document.getElementById('getjob').value;
				document.getElementById('getuser').style.display="none";
				document.getElementById('getuser').value="";
				document.getElementById('getuser1').style.display="none";
				document.getElementById('getuser1').value="";
				var uname=document.getElementById('emp_name').value;
				document.getElementById('report_option').value="Time Sheet Report for JOB No: "+num1+" of "+uname;
		
					if( num1 != "" ){	
						
							$.post(site_url+"/Timesheet/timesheet/team_timesheet_jobwise",{d1:date1,d2:date2,num:num1},function(data){							
										$("#contentData").html("");
										$("#contentData").append(data);
								});	
		
					}	
		}
			
			function team_timesheet_emp(){
				var date1 = document.getElementById('date_from').value;
				var date2 = document.getElementById('date_to').value;
				document.getElementById('getjob').style.display="none";
				 document.getElementById('getjob').value="";
				document.getElementById('getuser').style.display="none";
				document.getElementById('getuser').value="";
				document.getElementById('getuser1').style.display="";
				var user1 = document.getElementById('getuser1').value;
				var uname=document.getElementById('emp_name').value;
				document.getElementById('report_option').value="Time Sheet Report of "+user1 +" - "+uname;
		
				if(user1 != "" ){	
					
					$.post(site_url+"/Timesheet/timesheet/timesheet_activity_emp",{d1:date1,d2:date2,user:user1},function(data){							
								$("#contentData").html("");
								$("#contentData").append(data);
						});	
		}
			}	
			
		
	
		
		
		function team_timesheet_ot(){
			var date1 = document.getElementById('date_from').value;
			var date2 = document.getElementById('date_to').value;
			document.getElementById('getjob').style.display="none";
			document.getElementById('getjob').value="";
			document.getElementById('getuser').style.display="none";
			document.getElementById('getuser').value="";
			document.getElementById('getuser1').style.display="none";
			document.getElementById('getuser1').value="";
			var uname=document.getElementById('emp_name').value;
			document.getElementById('report_option').value="Total Working Hours Details of "+uname;

		//	if( date1 != "" && date2!="" ){	
						$.post(site_url+"/Timesheet/timesheet/team_timesheet_ot",{d1:date1,d2:date2},function(data){							
									$("#contentData").html("");
									$("#contentData").append(data);
							});	
			//}
	}
			
			
			function get_timedate(date1){
				//document.getElementById('dummyDate').value=date1;
				$.post(site_url+"/Timesheet/timesheet/get_timedate",{date:date1},function(data){							
					$("#contentData").html("");
					$("#contentData").append(data);
			});	
				
			}
			
			
			function fill_timingValues(id,name,in1,out,late,duty,ot,total){
				
				document.getElementById('name').innerHTML=name;
				document.getElementById('rowID').value=id;
				
				in1=in1.split(':');
				out=out.split(':');
				document.getElementById('intimeH').value=in1[0];
				document.getElementById('intimeM').value=in1[1];
				document.getElementById('outtimeH').value=out[0];
				document.getElementById('outtimeM').value=out[1];
				
				document.getElementById('lunch').value="00:30";
				document.getElementById('late').value=late;
				document.getElementById('ot').value=ot;
				document.getElementById('duty').value=duty;
				document.getElementById('total').value=total;
				
					//	alert(document.getElementById('rowID').value);			
				
			}
			
			
			
			function update_changes(){
				
				var date=document.getElementById('date').value;
			
				if(document.getElementById('intime').value!='' && document.getElementById('outtime').value!=''){
				
				var ask=confirm("Do You want to update these data to Your Time Sheet?");
				if(ask==true){
					var data={};
					//alert(document.getElementById('rowID').value);
					data["id"]= document.getElementById('rowID').value;
					data["in"]=document.getElementById('intime').value;
					data["out"]=document.getElementById('outtime').value;
					data["ot"]=document.getElementById('ot').value;
					data["lunch"]=document.getElementById('lunch').value;
					data["late"]=document.getElementById('late').value;
					data["tot"]=document.getElementById('total').value;
					data["duty"]=document.getElementById('duty').value;

							$.post(site_url+"/Timesheet/timesheet/update_changes",data,function(datas){		
								alert(datas);
								get_timedate(date);
							});	
							
							document.getElementById('name').innerHTML="";
							document.getElementById('rowID').value="";
							
							document.getElementById('intime').value="";
							document.getElementById('outtime').value="";						
							document.getElementById('late').value="";
							document.getElementById('ot').value="";
							document.getElementById('duty').value="";
							document.getElementById('total').value="";
							document.getElementById('lunch').value="";
								//document.getElementById('date').value="2012-01-01";
							//document.getElementById('date').value=date;
									
						}
				}
				else{
					document.getElementById('error').innerHTML="Please check Data Fields..!";
				}
			}
			
			
	
			
			function chooseFunction(){
				var dept1 = document.getElementById('getDept').value;
				var team1 = document.getElementById('getTeam').value;
				var job1 = document.getElementById('getjob').value;
				if(team1 != "" && job1=="" ){
					get_timesheet_Team();
				}
						if(dept1 != ""  && job1==""){
							get_timesheet_Dept();
						}
						if( job1!=""){
							timesheet_team_job();
						}
						
			}
			
			function get_timesheet_Dept(){
				var date1 = document.getElementById('date_from').value;
				var date2 = document.getElementById('date_to').value;
				var dept1 = document.getElementById('getDept').value;
				document.getElementById('getjob').style.display="none";
				document.getElementById('getjob').value="";
				document.getElementById('getUser').value="";
				document.getElementById('getTeam').value="";
				document.getElementById('report_option').value="Time Sheet Activities Report of "+dept1+" Department";
				
				
					if(dept1 != "" ){	
						
							$.post(site_url+"/Timesheet/timesheet/get_timesheet_Dept",{d1:date1,d2:date2,dept:dept1},function(data){							
										$("#contentData").html("");
										$("#contentData").append(data);
								});	
				}
	
			}
			
			function get_timesheet_Team(){
				var date1 = document.getElementById('date_from').value;
				var date2 = document.getElementById('date_to').value;
				var team1 = document.getElementById('getTeam').value;
				document.getElementById('getUser').value="";
						
				var job1 = document.getElementById('getjob').value;
				if(job1==""){
				document.getElementById('getjob').style.display="none";
				document.getElementById('getjob').value="";
				
				document.getElementById('getDept').value="";
				document.getElementById('report_option').value="Time Sheet Activities Report of "+team1+" Team";
				
							if(team1 != "" ){	
								
									$.post(site_url+"/Timesheet/timesheet/get_timesheet_Team/",{d1:date1,d2:date2,team:team1},function(data){							
												$("#contentData").html("");
												$("#contentData").append(data);
										});	
						}
				}
				else{
					timesheet_team_job();
				}
			}
			
			function timesheet_team_job(){
				var date1 = document.getElementById('date_from').value;
				var date2 = document.getElementById('date_to').value;
				document.getElementById('getjob').style.display="";
				var job1=document.getElementById('getjob').value;
				var team1 = document.getElementById('getTeam').value;
				document.getElementById('getUser').value="";
				document.getElementById('getDept').value="";
				document.getElementById('report_option').value="Time Sheet Activities Report of "+team1+" Team for JOB No: "+job1;
				
				
					if(job1 != "" ){	
						
							$.post(site_url+"/Timesheet/timesheet/timesheet_team_job",{d1:date1,d2:date2,job:job1,team:team1},function(data){							
										$("#contentData").html("");
										$("#contentData").append(data);
								});	
				}
	
			}
			
			function team_activity_emp(){
				var date1 = document.getElementById('date_from').value;
				var date2 = document.getElementById('date_to').value;
				document.getElementById('getjob').style.display="none";
				var job1=document.getElementById('getjob').value;
	
				var user1 = document.getElementById('getUser').value;
					document.getElementById('getDept').value="";
				document.getElementById('report_option').value="Time Sheet Activities Report of "+user1;
				
				
					if(user1 != "" ){	
						
						$.post(site_url+"/Timesheet/timesheet/get_timesheet_userwise",{d1:date1,d2:date2,user:user1},function(data){							
							$("#contentData").html("");
							$("#contentData").append(data);
					});	
				}
	
			}

			
		
			
			function checkDate(date){
				
				document.getElementById('button').style.display="";
				document.getElementById('outdate').style.display="none";
				document.getElementById('intime').value="";
				document.getElementById('outtime').value="";				
				document.getElementById('late').value="";
				document.getElementById('ot').value="";
				document.getElementById('lunch').value="";
				document.getElementById('duty').value="";
						document.getElementById('total').value="";

								$.post(site_url+"/Timesheet/timesheet/timesheet/checkDate",{d1:date},function(data){	
								
					if(data != 0)
						{
							document.getElementById('error').innerHTML="Already You have updated Time sheet this day..!";
							document.getElementById('button').style.display="none";
						}
					else
							{
							checkLeave(date);
							}
					});	
		
			}
			
					function checkLeave(date){
						$.post(site_url+"/Timesheet/timesheet/checkLeave",{d1:date},function(data){		
							//alert(data);
							if(data != 0)
								{
								document.getElementById('error').innerHTML="You have taken  Leave in this day..!";
									document.getElementById('button').style.display="none";
								}else
									{
									checkLocked(date);
									}
							});	
				}
					
					function checkLocked(date){
						$.post(site_url+"/Timesheet/timesheet/checkLocked",{d1:date},function(data){							
						if(data != 0)
							{
							document.getElementById('error').innerHTML="This date was locked..! Please contact Your HR to unlock.!";
								document.getElementById('button').style.display="none";
							}else
								{
								get_INOUT(date);
								}
						});	
		
				}
			
			
			function get_INOUT(date){
				
							$.post(site_url+"/Timesheet/timesheet/get_INOUT",{d1:date},function(data){	
								//alert(data);
									var time=data.split(',');
									var in1=time[0];
								//alert(in1);
									if(in1!='0'){
										var out1=time[1];
										var indate=time[2];
										var outdate=time[3];
										var late=time[4];
										var lunch=time[5];
										var total=time[6];
										var duty=time[7];
										var ot=time[8];
											
										document.getElementById('in_date').value=indate;
										document.getElementById('out_date').value=outdate;
										
										if(indate!=outdate){
											document.getElementById('outdate').value=outdate;
											document.getElementById('outdate').style.display="";
													
										}
		
												document.getElementById('intime').value=in1;
												document.getElementById('outtime').value=out1;
												document.getElementById('late').value=late;
												document.getElementById('lunch').value=lunch;
												document.getElementById('duty').value=duty;
												document.getElementById('ot').value=ot;
												document.getElementById('total').value=total;
														document.getElementById('error').innerHTML="";

												
												document.getElementById('button').style.display="";

														
									}
									else{
										document.getElementById('error').innerHTML="Your IN-OUT Time were not received from Time Office..!";
										document.getElementById('button').style.display="none";

									}
									
					
				});	
			
			}


		
	
			
		
			
			function get_UpdatedUsers(date1){
				
				if(date1!=""){
					$.post(site_url+"/Timesheet/timesheet/get_timeofficeID/",{date:date1},function(data){		
						//alert(data);
						$("#contentData").html("");
						$("#contentData").append(data);
		
					});
				}
			}
			
			
			function update_timeoffice(){
				var rows=document.getElementById('hrowcount').value;
				//alert(rows);
				var date=document.getElementById('date').value;
				var key = confirm("Do you want to update IN-OUT time of Employees for the Date - "+date);
				if(key==true){
				for(i=1;i<=rows;i++){
					
					var to_id="id"+i;
					
					var inH="inH"+i;
					var inM="inM"+i;
					var outH="outH"+i;
					var outM="outM"+i;
					var outdate="outdate"+i;
					var id=document.getElementById(to_id).value;
					var date1=document.getElementById(outdate).value;
					var intime=document.getElementById(inH).value+':'+document.getElementById(inM).value;
					var outtime=document.getElementById(outH).value+':'+document.getElementById(outM).value;
						//alert(id+':'+intime+':'+outtime);	
						if(intime!="00:00" && outtime!='00:00' && date!=""&& date1!=""){
								$.post(site_url+"/Timesheet/timesheet/update_timeoffice/",{id1:id,d1:date,d2:date1,in1:intime,out1:outtime},function(data){		
									//alert();
								});
					
						}
						
				}
				}
			// 		window.location.reload();
				var key1 = confirm("InTime and OutTime updated Successfully");
				if(key1==true){
					window.location.reload();
				}
				else{
				window.location.reload();
				}
				
			}
		
			
			
			
			
			function timesheet_job_activity_user(){
				var date1 = document.getElementById('date_from').value;
				var date2 = document.getElementById('date_to').value;
				var uname=document.getElementById('emp_name').value;
				document.getElementById('report_option').value="Job Activities Report of "+uname;
				document.getElementById('getjob').style.display="";
				document.getElementById('getjob').style.display="none";
				document.getElementById('getjob').value="";
			
							$.post(site_url+"/Timesheet/timesheet/timesheet_job_activity_user",{d1:date1,d2:date2},function(data){							
										$("#contentData").html("");
										$("#contentData").append(data);
								});	
									
			}
			
			function timesheet_job_activity_emp(){
				var date1 = document.getElementById('date_from').value;
				var date2 = document.getElementById('date_to').value;
				document.getElementById('getuser2').style.display="";
				var user2 = document.getElementById('getuser2').value;
	
				document.getElementById('getuser1').style.display="none";
				document.getElementById('getjob').style.display="none";
				document.getElementById('getjob').value="";
				document.getElementById('getuser').style.display="none";
				document.getElementById('getuser').value="";
				document.getElementById('report_option').value="Time Activities Report of "+user2;
				
				//alert(user2);
					if(user2 != "" ){	
						
							$.post(site_url+"/Timesheet/timesheet/timesheet_job_activity_emp",{d1:date1,d2:date2,user:user2},function(data){							
							//	alert(data);	
								$("#contentData").html("");
										$("#contentData").append(data);
								});	
				}
							
	}
			
			
			
			function check_job(job1){ 
				document.getElementById('error1').style.display="none";
				document.getElementById('row_job1').style.display="";
				document.getElementById("job_no").removeAttribute("readonly",1);
				document.getElementById("job_desc").removeAttribute("readonly",1);
				document.getElementById("job_desc").value="";

					if(job1!=""){
				$.post(site_url+"/Timesheet/timesheet/check_job",{job:job1},function(data1){			
					//alert(data1);
							if(data1!=""){
								document.getElementById('error1').style.display="";
								document.getElementById('row_job1').style.display="none";
								document.getElementById('job_desc').value=data1;				
								document.getElementById("job_desc").setAttribute("readonly",1);
									}	
							else{
								$.post(site_url+"/Timesheet/timesheet/fetch_job",{job:job1},function(data){										
									document.getElementById('job_no').value=job1;
									document.getElementById('job_desc').value=data;
									document.getElementById("job_no").removeAttribute("readonly",1);
									document.getElementById("job_desc").removeAttribute("readonly",1);
							
								});						
					}
					});	
				}
				
			}
			
			
			function check_npjob(job1){
				document.getElementById('error2').style.display="none";
				document.getElementById('row_npjob1').style.display="";
				document.getElementById("npjob_no").removeAttribute("readonly",0);
				document.getElementById("npjob_desc").removeAttribute("readonly",0);
				document.getElementById("npjob_desc").value="";

				if(job1!=""){
					$.post(site_url+"/Timesheet/timesheet/check_npjob",{job:job1},function(data1){			
						//alert(data);
								if(data1!=""){
									document.getElementById('error2').style.display="";
									document.getElementById('row_npjob1').style.display="none";
									document.getElementById('npjob_desc').value=data1;									
									document.getElementById("npjob_desc").setAttribute("readonly",1);
									}	
								else{
									$.post(site_url+"/Timesheet/timesheet/fetch_npjob",{job:job1},function(data){										
										document.getElementById('npjob_no').value=job1;
										document.getElementById('npjob_desc').value=data;
										document.getElementById("npjob_no").removeAttribute("readonly",1);
										document.getElementById("npjob_desc").removeAttribute("readonly",1);
							
									});						
						}
						});	
					}
					
				}
			
			function clear_job(op){
				if(op=='1'){
					document.getElementById('job_no').value="";
					document.getElementById('job_desc').value="";
					document.getElementById("job_no").removeAttribute("readonly",1);
					document.getElementById("job_desc").removeAttribute("readonly",1);
					document.getElementById('error1').style.display="none";
					document.getElementById('row_job1').style.display="";

				}
				if(op=='2'){
					document.getElementById('npjob_no').value="";
					document.getElementById('npjob_desc').value="";
					document.getElementById("npjob_no").removeAttribute("readonly",1);
					document.getElementById("npjob_desc").removeAttribute("readonly",1);
					document.getElementById('error2').style.display="none";
					document.getElementById('row_npjob1').style.display="";

				}
				
			}

			
			
			function get_locked_users(op){
				if(op=='1'){
					//alert("1");
					document.getElementById('emp').value="";
					document.getElementById('option').value="1";
						var yr=document.getElementById('year').value;
					var mon=document.getElementById('month').value;
						if(yr!="" && emp1!=""){
						$.post(site_url+"/Timesheet/timesheet/get_locked_users",{year:yr,month:mon},function(data){										
							$("#contentData").html("");
							$("#contentData").append(data);
						});	
					}
				}
				
				if(op=='2'){
					//alert("2");
					document.getElementById('option').value="2";
					var emp1=document.getElementById('emp').value;
					var yr=document.getElementById('year').value;
					var mon=document.getElementById('month').value;
					if(yr!="" && emp1!=""){
						$.post(site_url+"/Timesheet/timesheet/get_locked_user",{year:yr,month:mon,emp:emp1},function(data){										
					
							$("#contentData").html("");
							$("#contentData").append(data);
						});
					}
				}
			}	
					function unlock_timesheet(id1){
						
						$.post(site_url+"/Timesheet/timesheet/unlock_timesheet",{id:id1},function(data){		
							var op=document.getElementById('option').value;
							
							get_locked_users(op);
							//window.location.reload();
						});
				
						
					}
	
