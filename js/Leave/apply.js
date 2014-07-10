														/* * * 			Date Picker Functions			* * */

		$("#Calendar_From_CL").datepicker({ 				
								dateFormat: 'dd-mm-yy',
								beforeShowDay: function(dt)    {
													    return [dt.getDay() == 0  ? false : true];
													 },
								onClose:function(selectedDate){
									document.getElementById("CL_from_date").value=selectedDate;
									validate_Date(selectedDate,'CL');
								},	
								defaultDate: new Date()	
		}) ; 
		
		$("#Calendar_From_SL").datepicker({ 				
						dateFormat: 'dd-mm-yy',
						beforeShowDay: function(dt)    {
											    return [dt.getDay() == 0  ? false : true];
											 },
						onClose:function(selectedDate){
							document.getElementById("SL_from_date").value=selectedDate;
							$("#Calendar_To_SL").datepicker("option","minDate",selectedDate);
							//validate_Date(selectedDate,'SL');
						},	
						defaultDate: new Date()	
		}) ; 
		
		$("#Calendar_From_EL").datepicker({ 				
							dateFormat: 'dd-mm-yy',
							beforeShowDay: function(dt)    {
												    return [dt.getDay() == 0  ? false : true];
												 },
							onClose:function(selectedDate){
									document.getElementById("EL_from_date").value=selectedDate;
									$("#Calendar_To_EL").datepicker("option","minDate",selectedDate);
									validate_Date(selectedDate,"EL");
								},	
								defaultDate: new Date()	
		}) ; 
		
		$("#Calendar_From_CO").datepicker({ 				
								dateFormat: 'dd-mm-yy',
								beforeShowDay: function(dt)    {
													    return [dt.getDay() == 0  ? false : true];
													 },
									onClose:function(selectedDate){
									document.getElementById("CO_from_date").value=selectedDate;
											$("#Calendar_To_CO").datepicker("option","minDate",selectedDate);
											validate_Date(selectedDate,"CO");
									},	
									defaultDate: new Date()	
		}) ; 

		$("#Calendar_From_ML").datepicker({ 				
			dateFormat: 'dd-mm-yy',
			beforeShowDay: function(dt)    {
								    return [dt.getDay() == 0  ? false : true];
								 },
				onClose:function(selectedDate){
				document.getElementById("ML_from_date").value=selectedDate;
						$("#Calendar_To_ML").datepicker("option","minDate",selectedDate);
						validate_Date(selectedDate,"ML");
				},	
				defaultDate: new Date()	
		}) ; 

		$("#Calendar_To_SL").datepicker({
									dateFormat: 'dd-mm-yy',
									beforeShowDay: function(dt)    {
														    return [dt.getDay() == 0  ? false : true];
														 },
									onClose:function(selectedDate){
											document.getElementById("SL_to_date").value=selectedDate;
											validate_Date(selectedDate,"SL");
									},	
									defaultDate: new Date()	
		}) ; 

		
		$("#Calendar_To_EL").datepicker({ 				
									dateFormat: 'dd-mm-yy',
									beforeShowDay: function(dt)    {
														    return [dt.getDay() == 0  ? false : true];
														 },
									onClose:function(selectedDate){
											document.getElementById("EL_to_date").value=selectedDate;
											validate_Date(selectedDate,"EL");
										},	
										defaultDate: new Date()	
		}) ; 
		
		$("#Calendar_To_CO").datepicker({ 				
									dateFormat: 'dd-mm-yy',
									beforeShowDay: function(dt)    {
														    return [dt.getDay() == 0  ? false : true];
														 },
										onClose:function(selectedDate){
										document.getElementById("CO_to_date").value=selectedDate;
										validate_Date(selectedDate,"CO");
										},	
										defaultDate: new Date()	
		}) ; 

		$("#Calendar_To_ML").datepicker({ 				
			dateFormat: 'dd-mm-yy',
			beforeShowDay: function(dt)    {
								    return [dt.getDay() == 0  ? false : true];
								 },
				onClose:function(selectedDate){
				document.getElementById("ML_to_date").value=selectedDate;
				validate_Date(selectedDate,"ML");
				},	
				defaultDate: new Date()	
		}) ; 

		
		$("#p_date").datepicker({ 
						dateFormat: 'dd-mm-yy',
						beforeShowDay: function(dt)
						    {
						    return [dt.getDay() == 0  ? false : true];
						 },
						defaultDate: new Date(),minDate: 0 
		}) ; 


		
		
		
																	/* * * 						General 					* * */

	function remove_Specials(id,string){
			var string=document.getElementById(id).value;
			var new_string=string.replace(/([~!@#$%^&*()_+=`{}\[\]\|\\:;'<>,\/? ])+/g, ' ').replace(/^(-)+|(-)+$/g,'');
			document.getElementById(id).value=new_string;
	}
	
	
	
	
		function show_LeaveDiv(new_Div){
			var cur_Div=document.getElementById("Current_Table").value;
			//alert(cur_Div+', '+new_Div);
			document.getElementById("Current_Table").value=new_Div;
				if(cur_Div!=new_Div){
						cur_Div='#'+cur_Div;
						new_Div='#'+new_Div;
						
						$(cur_Div).slideUp(1000);
							$(new_Div).slideDown(1000);
						//alert(cur_Div+', '+new_Div);
				}
		}

		

																			/* * * 		File Upload Function 		* * */
		
		  function upload_ProofDoc(filepath,elementid,leavetype){
				var arrays=filepath.split('\\');
				var array_lentgh=filepath.split('\\').length-1;
				var file_name=arrays[array_lentgh];
				//alert(elementid);
				doc_count_id="Docs_Total_Count_"+leavetype;
				var doc_count=parseInt(document.getElementById(doc_count_id).value);
				table_id="Doc_Table_"+leavetype;
				var row_count=parseInt(document.getElementById("Row_Id").value);
				row_id=leavetype+row_count;
				
				//alert("Count: "+tot_count+"countID: "+count_id+", TableID: "+table_id);
				if(doc_count<=3 && doc_count>=0){
	
	  				    $.ajaxFileUpload({
		    	            	url             		 	: site_url+'/Leave/apply/upload_ProofDoc/'+leavetype,  
		    	            	secureuri      	: false,
		    	            	fileElementId	: elementid,
		    	            	dataType       	:  'json',
		    	            	success				: function (data, status) {
			    	                										if(data.status != 'error') {
			    	                												//alert("Status is "+data.status);
			    	                														var file_id=data.status;
			    	                											
			    	                														var table = document.getElementById(table_id);
					    	                												var row = table.insertRow(0);					    	                												
					    	                												row.id=row_id;
					    	                												var cell1 = row.insertCell(0);   
					    	                												//alert(row_id);
					    	                												cell1.innerHTML = "<input alt='Remove' type='image' id='' width='15' height='15' src='../../../images/General/remove.png' onclick='delete_ProofDoc(this,\""+file_id+"\",\""+table_id+"\",\""+doc_count_id+"\")'> &nbsp;&nbsp;" +file_name;
					    	                												document.getElementById(doc_count_id).value=doc_count+1;
					    	                												document.getElementById("Row_Id").value=row_count+1;
			    	                										}
			    	                										else{
			    	                											alert("Error");
			    	                										}
			    	                						}	
		    	        });
		  }
			else{
					alert("You can upload Three Files Only..!");
			}
		    	        

	}
		  
		  
		  	function delete_ProofDoc(row,file_id1,table_id,doc_count_id){
		  			//alert("File ID: "+file_id1+", Table ID: "+table_id+", File Count:"+doc_count_id);
		  		
		  		    var warning = confirm("Are you sure you want to delete this Image?");
		  		    if(warning == true){
				  		    	$.post(	site_url+"/Leave/apply/delete_ProofDoc",
				  		    					{file_id:file_id1},
				  		    					function(data){
				  		    								if(data){
				  		    									var doc_count=parseInt(document.getElementById(doc_count_id).value);
				  		    							  		var i=row.parentNode.parentNode.rowIndex;
				  		    							  	    document.getElementById(table_id).deleteRow(i);
               												 document.getElementById(doc_count_id).value=doc_count-1;
                												 
                											}
				  		    						}
				  		    	);
		  		    }	
		  	}

		  
		  
		
																/* * * 			 Validating Date			* * */
		
		function validate_Date(date1,type1){
				if(date1){
					var button_id="apply_img_"+type1;
					check_in_holidays(date1,type1,button_id);
				}
			}	
		
		function check_in_holidays(date1,type1,button_id){
						$.post(site_url+"/Leave/apply/check_in_holidays",{date:date1},function(holiday){
								//	alert("Is it Holiday? : "+holiday.trim());
							
										if(holiday.trim()=='No'){
													check_leavetaken(date1,type1,button_id);
										}
										else{	// If it is a Holiday
											document.getElementById('Error_Col').innerHTML='<i>'+date1+" - "+holiday.trim()+'</u>';
											$('Error').slideUp(2000);
											document.getElementById('Error').style.display='';
											document.getElementById(button_id).style.display='none';		
									}
						});
		}

		function check_leavetaken(date1,type1,button_id){
					$.post(site_url+"/Leave/apply/check_leavetaken",{date:date1},function(leave){
									//alert("Leave Taken? : "+leave.trim());
									if(leave.trim()=='No'){
												check_prior_days(date1,type1,button_id);
									}
									else{
										var days_id=type1+"_days";
										document.getElementById(days_id).value="";
										document.getElementById('Error_Col').innerHTML=leave.trim();
										document.getElementById('Error').style.display='';
										document.getElementById(button_id).style.display='none';		
								}
		
					});
		}


		function check_prior_days(date1,type1,button_id){
					$.post(site_url+"/Leave/apply/check_prior_days",{date:date1,type:type1},function(prior){
								//alert("Prior in Limit : "+prior.trim());
								if(prior.trim()=='Yes'){
											//alert("Going t o calculate no of days.");
													calculate_no_of_days(type1,button_id);
									}
									else{
										document.getElementById('Error_Col').innerHTML=prior.trim();
										document.getElementById('Error').style.display='';
										document.getElementById(button_id).style.display='none';		
									}
	
						});
		}


		
		function calculate_no_of_days(type,button_id){
			//alert("Welcome to Calaculate no of days..!");
			var from_id=type+"_from_date";
			var to_id=type+"_to_date";
			if(type=="CL"){
				to_id=from_id;
			}
			var days_id=type+"_days";

			var from_date1=document.getElementById(from_id).value;
			var to_date1=document.getElementById(to_id).value;	
			
			//alert(from_date1+" , "+to_date1);
				if(from_date1!="" && to_date1!=""){
							$.post(site_url+"/Leave/apply/calculate_no_of_days",{from_date:from_date1,to_date:to_date1},function(data){
								var no_of_days=data.trim();
								//alert("No of Days: "+no_of_days);
									document.getElementById(days_id).value=no_of_days;
									if(no_of_days){
												check_minimumLimit(parseInt(no_of_days),type,button_id);
									}
							});
				}
				else{
					document.getElementById('Error_Col').innerHTML="";
					document.getElementById('Error').style.display='none';		
					document.getElementById(button_id).style.display='';		
				}
			
			}

		
		function check_minimumLimit(no_of_days,type,button_id){
					var min_limit_id="min_limit_"+type;
					var min_limit=document.getElementById(min_limit_id).value; //alert(min_limit);
					//alert(no_of_days);
					if(min_limit!=0){
							if( no_of_days >= min_limit){
								check_maximumLimit(no_of_days,type,button_id);
							}
							else{
								document.getElementById('Error_Col').innerHTML="Minimum Limit for "+type+" is "+min_limit+" Days..!";
								document.getElementById('Error').style.display='';
								document.getElementById(button_id).style.display='none';		
							}
					}
					else{
						check_maximumLimit(no_of_days,type,button_id);
					}
		}

		
		function check_maximumLimit(no_of_days,type,button_id){
					var max_limit_id="max_limit_"+type;
					var max_limit=document.getElementById(max_limit_id).value;
					
					if(max_limit!=0){
							if( no_of_days<=max_limit){
								//alert("Goes to check Monthly Limit..!");
								check_MonthlyLimit(no_of_days,type,button_id);
							}
							else{
								document.getElementById('Error_Col').innerHTML="Maximum Limit for "+type+" is "+max_limit+" Days..!";
								$('Error').slideUp(2000);
								document.getElementById('Error').style.display='';
								document.getElementById(button_id).style.display='none';		
							}
					}
					else{
						check_MonthlyLimit(no_of_days,type,button_id);
					}
		}

		
		function check_MonthlyLimit(no_of_days,type1,button_id){
					var month_limit_id="month_limit_"+type1;
					var month_limit=document.getElementById(month_limit_id).value;
					var date_id=type1+"_from_date";
					var from_date1=document.getElementById(date_id).value;
			
					$.post(site_url+"/Leave/apply/check_MonthlyLimit",{from_date:from_date1,type:type1},function(data){
						//alert("Leaves in Month: "+data.trim()+" and Month Limit: "+month_limit);
							month_leaves=parseInt(data.trim());
							total_days=month_leaves+no_of_days;
								if(month_limit!=0){
											if(total_days<=month_limit){
												//alert("Goes to check Yearly Limit..!");
												check_YearlyLimit(no_of_days,type1,button_id);
											}
											else{
												document.getElementById('Error_Col').innerHTML="Monthly Limit for "+type1+" is "+month_limit+" Days..! You have already taken / applied "+month_leaves+" "+type1+" in this month.";
												$('Error').slideUp(2000);
												document.getElementById('Error').style.display='';
												document.getElementById(button_id).style.display='none';		
											}
								}
								else{
									check_YearlyLimit(no_of_days,type1,button_id);
								}
					});	
		}
	
		
		function check_YearlyLimit(no_of_days,type1,button_id){
			
			var year_limit_id="year_limit_"+type1;
			var year_limit=document.getElementById(year_limit_id).value;
			var date_id=type1+"_from_date";
			var from_date1=document.getElementById(date_id).value;
	
				$.post(site_url+"/Leave/apply/check_YearlyLimit",{from_date:from_date1,type:type1},function(data){
					//alert("Leaves in Year: "+data.trim()+" and Year Limit: "+year_limit);
						year_leaves=parseInt(data.trim());
						total_days=year_leaves+no_of_days;
							if(year_limit!=0){
										if(total_days<=year_limit){
											//alert("Completed all validations.!");
											document.getElementById('Error_Col').innerHTML="";
											document.getElementById('Error').style.display='none';		
											document.getElementById(button_id).style.display='';		
										}
										else{
											document.getElementById('Error_Col').innerHTML="Yearly Limit for "+type1+" is "+year_limit+" Days..!  You have already taken / applied "+year_leaves+" "+type1+" in this year.";
											$('Error').slideUp(2000);
											document.getElementById('Error').style.display='';
											document.getElementById(button_id).style.display='none';		
										}
							}
							else{
								//alert("Completed all validations.!");
								document.getElementById('Error_Col').innerHTML="";
								document.getElementById('Error').style.display='none';		
								document.getElementById(button_id).style.display='';		
							}
				});	
		}


		
		
																/* * * 				Inserting Leave Application			* * */
		
// Casual Leave
		function insert_CasualLeave(){
			var from_date1 = document.getElementById('CL_from_date').value; 
			var to_date1 = from_date1; 
			var days1 = document.getElementById('CL_days').value; 
			var reason1 = document.getElementById('CL_reason').value; 
				$.post(site_url+"/Leave/apply/insert_LeaveApplication",{type:"CL",from_date:from_date1,to_date:to_date1,days:days1,reason:reason1},function(data){
						alert(data);
				});
		}
		
		
//Sick Leave		
				
		function insert_SickLeave(){
			var from_date1 = document.getElementById('SL_from_date').value; 
			var to_date1 = document.getElementById('SL_to_date').value; 
			var days1 = document.getElementById('SL_days').value; 
			var reason1 = document.getElementById('SL_reason').value; 
				$.post(site_url+"/Leave/apply/insert_LeaveApplication",{type:"SL",from_date:from_date1,to_date:to_date1,days:days1,reason:reason1},function(data){
						alert(data);
				});
		}
		
		function insert_EarnedLeave(){
			var from_date1 = document.getElementById('EL_from_date').value; 
			var to_date1 = document.getElementById('EL_to_date').value; 
			var days1 = document.getElementById('EL_days').value; 
			var reason1 = document.getElementById('EL_reason').value; 
				$.post(site_url+"/Leave/apply/insert_LeaveApplication",{type:"EL",from_date:from_date1,to_date:to_date1,days:days1,reason:reason1},function(data){
						alert(data);
				});
		}
		
		function insert_CompOff(){
			var from_date1 = document.getElementById('CO_from_date').value; 
			var to_date1 = document.getElementById('CO_to_date').value; 
			var days1 = document.getElementById('CO_days').value; 
			var reason1 = document.getElementById('CO_reason').value; 
				$.post(site_url+"/Leave/apply/insert_LeaveApplication",{type:"CO",from_date:from_date1,to_date:to_date1,days:days1,reason:reason1},function(data){
						alert(data);
				});
		}
		
	
	

	
	
	
	function insert_permission_data(){
		document.getElementById("error").innerHTML="";
		document.getElementById('butt2').style.display="none";
		document.getElementById("error2").innerHTML="";
		
		var user1=	document.getElementById('username').value;
		var d1=	document.getElementById('p_date').value;
		var tot=	document.getElementById('p_total').value;
		var hr1=	document.getElementById('p_timeH').value+":"+document.getElementById('p_timeM').value;
		var reason1=	document.getElementById('p_reason').value;
		if(reason1!="" && d1!=""){
					document.getElementById("error2").innerHTML="Please wait. System is sending Mail..!";
					$.post(site_url+"/Leave/apply/insert_permission_data/",{date:d1,hour:hr1,total:tot,reason:reason1},function(data){
						//alert(data);
						
								$.post(site_url+"/Leave/apply/SendPermission/",{date:d1,hour:hr1,total:tot,reason:reason1,user:user1},function(data1){
									document.getElementById('butt2').style.display="none";
									document.getElementById('p_date').value="";
									document.getElementById('p_total').value="";
									document.getElementById('p_reason').value="";
									document.getElementById("error2").innerHTML="Your Permission was sent Successfully.!";
								});
								
	
					});

					
				}
		else{
			document.getElementById("error").innerHTML="Check All Input Fields.!";
			document.getElementById('butt2').style.display="";
		}

				
	}
	

			$("#doj_date").datepicker({
				dateFormat: 'yy-mm-dd',onClose:function(selectedDate){},		
				defaultDate: new Date()		
			});
		

			
			
			/* * *   onMOUSE  Functions * * */

		function change_OnMouseOver(id,img){
			//alert(img);
			if(id!="" && img!="" && img!=null){
						document.getElementById(id).src='../../../images/Leave/'+img;
				}
		
		}
		
