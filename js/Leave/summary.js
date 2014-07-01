															/* * * 			My Leave Summary 				* * */
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
	

	
																	/* * * 				Admin Leave Summary 			* * */										
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

	
	function admin_leave_summary_general(part){	
		//alert(part);

					if(part=='Dept'){
						var dept1=document.getElementById('dept').value;	
						document.getElementById('emp').value="All";
									get_DepartmentEmployees(dept1); 
							
					}
		
						var emp1=document.getElementById('emp').value; 
						var year1=document.getElementById('year').value;
						var month1=document.getElementById('month').value;
						var dept1=document.getElementById('dept').value;
						//alert("YEAR:"+year1+",  MONTH:"+month1+", DEPT:"+dept1+", EMP:"+emp1);
						
						if(year1!="" && dept1!="" && emp1!=""){
							$.post(site_url+"/Leave/summary/get_admin_leave_summary_general",{year:year1,month:month1,dept:dept1,emp:emp1},function(data){
										alert(data);
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
			
			
	