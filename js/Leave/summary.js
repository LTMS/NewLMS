			
			function get_summary(txt1,op)
			{	
				var year1=document.getElementById('year').value;
			//	var month1=document.getElementById('month').value;
	
				if(op=='1'){
					var emp1=document.getElementById('emp').value; 

					document.getElementById('dept').value="";
					document.getElementById('team').value=""; 
					document.getElementById('report_option').value="Leave Summary of "+emp1+" for "+year1;
							}
				if(op=='2'){
					var dept1=document.getElementById('dept').value;

					document.getElementById('emp').value="";
					document.getElementById('team').value=""; 
					document.getElementById('report_option').value="Leave Summary of "+dept1+" Department for "+year1;
				}
				if(op=='3'){
					var team1=document.getElementById('team').value; 

					document.getElementById('emp').value="";
					document.getElementById('dept').value="";
					document.getElementById('report_option').value="Leave Summary of "+team1+" Team for "+year1;
				}
				if(op=='4' ){
					document.getElementById('dept').value="";
					document.getElementById('team').value=""; 
					document.getElementById('emp').value=""; 
					document.getElementById('report_option').value="Employees Leave Summary for the Year - "+year1;
					
				}

				
			if(year1!=''){	
				$.post(site_url+"/Leave/Summary/get_summary",{year:year1,emp:emp1,team:team1,dept:dept1,type:op},function(data){
							//alert(data);
								$("#contentData").html("");
								$("#contentData").append(data);
				});
			}
				
			}
			
			
			function get_my_summary(){
				var year1=document.getElementById('year').value;
				var op1=document.getElementById('report_option1').value;
				document.getElementById('report_option').value=op1+" for  "+year1;
				
				if(year1!=''){	
					$.post(site_url+"/Leave/Summary/get_my_summary",{year:year1},function(data){
								//alert(data);
									$("#contentData").html("");
									$("#contentData").append(data);
					});
				}

				
			}
			
			
			
			function reprocess_leave(l_id,row,l_type,uname,days){
				document.getElementById(row).style.background="#FF6699";
				var hrs1=parseInt(days)*8;
				var hrs2=hrs1+':00:00';
				//alert(days);
					if(l_id!=""){
						var l_reason=prompt("Remarks for Rejecting the Leave ID: "+l_id);
						if(l_reason != null && l_reason != ""){
							$.post(site_url+"/Leave/Summary/reject/",{lid:l_id,reason:l_reason,type:l_type,user:uname,hrs:hrs2},function(data){
								get_approved_leaves();
									});
								}
							else if(l_reason==""){alert("You Must Enter the Reason to Process.!");}
						}
					else {
						alert("Select a Leave ID to Process.!");
					}
			}
			
			
			function remove_leave(l_id){
				//alert(l_id);
				$.post(site_url+"/Leave/Summary/remove_leave/",{id:l_id},function(data){
					get_leave_status('2');
				});

			}
			
			
			
			function SendReminder(type,date,days,reason,colid,button,id){
				//alert(button);
				document.getElementById(colid).style.color='red';
				document.getElementById(colid).innerHTML='Sending Reminder...';
				//alert(type+' ,'+date+' ,'+days+' ,'+reason);
				$.post(site_url+"/Leave/Summary/getOfficer_L1",{leaveID:id},function(data){
						var to1=data;
									$.post(site_url+"/Leave/Summary/SendRemainder",{date_from:date,reasoning:reason,day:days,l_type:type,to:to1},function(data){
								
										document.getElementById(colid).style.color='green';
										document.getElementById(colid).innerHTML=data;
											});
					});

			}
			
			/* refreshing a division
			var refreshId = setInterval(function () {
			    $('#lms_intro_div').fadeOut("slow").load('site_url+"/Leave/Summary/index.php').fadeIn("slow");
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
			
			
			
			
			function update_leave_param(){
				
				var cas_mon1=document.getElementById('casual_month').value;
				var cas_tot1=document.getElementById('casual_tot').value;
				var sick_tot1=document.getElementById('sick_tot').value;
				var sick_proof1=document.getElementById('sick_proof').value;
				var paid_tot1=document.getElementById('paid_tot').value;
				var paid_min1=document.getElementById('paid_min').value;
				var paid_exp1=document.getElementById('paid_exp').value;
				var paid_prior1=document.getElementById('paid_prior').value;
				var comp_hr=document.getElementById('comp_hrs').value;
				var comp_min=document.getElementById('comp_mins').value;
				var comp1=comp_hr+':'+comp_min+':00';
				var perm1=document.getElementById('permis_hrs').value;
				var carry2=document.getElementById('intro_check').checked;
				var check=document.getElementById('intro_check').checked;
							if(check==true){	carry1='YES';	}
							else{	carry1='NO'; }
				
							$.post(site_url+"/Leave/Summary/update_leave_param",{cm:cas_mon1,ct:cas_tot1,st:sick_tot1,sp:sick_proof1,pt:paid_tot1,pm:paid_min1,pe:paid_exp1,comp:comp1,permis:perm1,carry:carry1,paid_prior:paid_prior1},function(data){
								window.location.reload();
							});

				
			}
			
			function export_leave_history(id)
			{
				var sdate=document.getElementById('date_from').value;
				var edate=document.getElementById('date_to').value;
				var filter=document.getElementById("leave_type").value;
				if(id=='1' && sdate!='' && edate!=''){
					var params=sdate+"::"+edate+"::"+filter;
					var downloadurl=site_url+"/Leave/Summary/export_leave_history/"+params;
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

				$.post(site_url+"/Leave/Summary/grantPermission/",{user:user1,date:date1,remark:remark1,id:id1},function(data){
					window.location.reload();
				});

			}


