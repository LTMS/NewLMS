														/* * * 			Date Functions			* * */
		$("#date_from1").datepicker({ 
								dateFormat: 'dd-mm-yy',
								beforeShowDay: function(dt)    {
													    return [dt.getDay() == 0  ? false : true];
													 },
								onClose:function(selectedDate){$("#date_to1").datepicker("option","minDate",selectedDate);},	
								defaultDate: new Date()	
			}) ; 

		$("#date_to1").datepicker({
			dateFormat: 'dd-mm-yy',
			beforeShowDay: function(dt)
			    {
			    return [dt.getDay() == 0  ? false : true];
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


// Showing Divsion for Leave
		
		
		function show_LeaveDiv(leave){
			
			
		}

	function check_leave_status(datevalue){
		document.getElementById('Table2').style.display="";
		document.getElementById('Table3').style.display="none";
		document.getElementById("error").innerHTML="";
		document.getElementById("error1").innerHTML="";		
		document.getElementById("error2").innerHTML="";		
		document.getElementById('butt2').style.display="";
		document.getElementById('butt1').style.display="";
			
		var type = document.getElementById('leave_type').value; 
		
		
		if(datevalue == ""){
			document.getElementById("error1").innerHTML="Please Select Date..!";		
			document.getElementById('butt1').style.display="none";
	//		document.getElementById('no_of_days').value="0";
		}
		else if(type=='Permission'){
			document.getElementById('Table3').style.display="";
			document.getElementById('Table2').style.display="none";
			
			check_permission();
		}	
		else {			
			document.getElementById("error1").innerHTML="";		
			document.getElementById('butt1').style.display="";
			check_holiday(datevalue);
		}
	}
	
	function check_holiday(datevalue){
		document.getElementById('butt1').style.display="";
		document.getElementById("error").innerHTML="";
		document.getElementById("error1").innerHTML="";		
		document.getElementById("error2").innerHTML="";		

		$.post(site_url+"/Leave/apply/check_holidays",{date_from:datevalue},function(data){
			//alert(data);
			str=data.split('::');
			
			if(str[0].trim()=='0'){
				document.getElementById('butt1').style.display="";
				check_sunday(datevalue);
				
			}
			else{
				document.getElementById("error1").innerHTML=datevalue+" ( "+str[1]+" ) -  is a Holiday..!";	
				document.getElementById('butt1').style.display="none";
			}
			
		});
	}
	
	function check_sunday(datevalue){
		$.post(site_url+"/Leave/apply/check_sunday",{date_from:datevalue},function(data){
			if(data.trim()=='0'){
				document.getElementById('butt1').style.display="";
				check_leavetaken(datevalue);
			}
			else{
				document.getElementById("error1").innerHTML=datevalue+" - is a Sunday Holiday..!";		
				document.getElementById('butt1').style.display="none";
			}
			
		});

	}
	
	function check_leavetaken(datevalue){
		$.post(site_url+"/Leave/apply/check_leavetaken",{date_from:datevalue},function(data){
			if(data.trim()=='0'){
				
				calculate_days();
			}
			else{
				document.getElementById("error1").innerHTML="Already you have taken / applied leave on - "+datevalue+" .!";	
				document.getElementById('butt1').style.display="none";
			}
			
		});

	}
	
	
	function calculate_days(){
		var date1=document.getElementById('date_from1').value;
		var date2=document.getElementById('date_to1').value;
		
		if(date1!="" && date2!=""){
			$.post(site_url+"/Leave/apply/calculate_workingdays",{date_from:date1,date_to:date2},function(data){
				//alert(data);
				var str=data.split('::');
				var no_of_days=parseInt(str[0]);
				var leave=str[1];
				var holiday=str[2];
				var totaldays=str[3];
				var sundays=str[4];
					if(parseInt(leave)>0 || parseInt(holiday)>0 || parseInt(sundays)>0 ){
					alert("Total Days : " +totaldays + "\nSundays : "+sundays+ "\nHolidays : "+holiday+"\nLeaves : "+leave+"\nInterval : "+totaldays+"-["+sundays+"+"+holiday+"+"+leave+"]="+no_of_days+" Days");
					//alert(" Total Days -" +totaldays + " ** Sundays -"+sundays+ " ** Holidays - "+holiday+" ** Leaves - "+leave+" ** Interval : "+totaldays+"-["+sundays+"+"+holiday+"+"+leave+"]="+no_of_days+" Days");
					document.getElementById('holidays_list').value=" Total Days -" +totaldays + "<br>Sundays -"+sundays+ "<br>Holidays - "+holiday+"<br>Leaves - "+leave+"<br>Interval : "+totaldays+"-["+sundays+"+"+holiday+"+"+leave+"]="+no_of_days+" Days";
				}
				else{
			}
					//alert(tot);
				document.getElementById('no_of_days').value=no_of_days;	
				
				validate_leave();
			});
		}
		
		}
		
	



	function validate_leave(){
		var type=document.getElementById('leave_type').value;
		var casual_limit=document.getElementById('casual_limit').value;
		var sick_limit=document.getElementById('sick_limit').value;
		var paid_min=document.getElementById('paid_min').value;
		var no_of_days = document.getElementById('no_of_days').value; 
		var date1=document.getElementById('date_from1').value;
		
		if(type=='Casual Leave'){
			document.getElementById('doc_row1').style.display="none";
					 if(no_of_days>casual_limit ){
							//alert(casual_limit+" - "+data);
							document.getElementById('error').innerHTML='Number of days exceeds Casual Leave Limit for the month..!';
							document.getElementById('butt1').style.display="none";
					}
					 else {
						 $.post(site_url+"/Leave/apply/validate_casual",{date_from:date1},function(data){
								//alert(data);
								if(data.trim()>0){
									document.getElementById('error').innerHTML='You have taken / applied Casual Leave for this month..!';
									document.getElementById('butt1').style.display="none";
								}
								
								else{
									document.getElementById('butt1').style.display="";
									document.getElementById('error').innerHTML='';
								}
							});
					 }
		}
		
		else if(type=='Sick Leave'){
			var sick_bal=parseInt(document.getElementById('slr').innerHTML);
				//alert('Sick Leave limit -'+sick_limit);
				if(sick_bal==0){
					document.getElementById('error').innerHTML='You have utilized all Sick Leaves..!';
					document.getElementById('butt1').style.display="none";					
				}
				else if(sick_bal<no_of_days){
					document.getElementById('error').innerHTML='No of days exceeds Sick Leave Limit..!';
					document.getElementById('butt1').style.display="none";
				}				
				else{
					 if(sick_limit<=no_of_days ){
							document.getElementById('doc_row1').style.display="";
						}
						else{
							document.getElementById('doc_row1').style.display="none";
							document.getElementById('butt1').style.display="";					
						}
				}
				
		}
		
		else if(type=='Paid Leave'){
			var paid_bal=parseInt(document.getElementById('plr').innerHTML);
			//alert(sick_bal);
			if(paid_min>no_of_days){
				document.getElementById('butt1').style.display="none";
				document.getElementById('error').innerHTML='Minimum Limit for Paid Leave is 3 Days..!';
				document.getElementById('doc_row1').style.display="none";
			}
			else if(paid_bal<no_of_days){
					document.getElementById('error').innerHTML='You have utilized all Paid Leaves..!';
					document.getElementById('butt1').style.display="none";
			}
				else{
					document.getElementById('doc_row1').style.display="none";
					document.getElementById('butt1').style.display="";
					calculate_prior();
				}	

		}
		
		else if(type =="Comp-Off"){ 
			var remain = document.getElementById("remain").value;
			var comp_minutes=document.getElementById('comp_minutes').value;
			var days=document.getElementById('no_of_days').value;
			var req_OT_hrs=parseInt(days)*comp_minutes; // in minutes
			//alert(remain+" : "+req_OT_hrs);
			// Remain should be in minutes
			if(remain==''){	
				remain='0';
			}
				    if(parseInt(remain)*60 < req_OT_hrs){
						document.getElementById('error').innerHTML=" Your Over Time hour is very less.!";
						document.getElementById('error1').style.display="None";
						return false;
			    	}
		}

		
		else{
			document.getElementById('butt1').style.display="";
			document.getElementById('error').innerHTML='';
		}
		
	}
	

	
	function calculate_prior()
	{
		document.getElementById('butt1').style.display="";
		var date1=document.getElementById('date_from1').value;
		var paid_prior=document.getElementById('paid_prior').value;
		if(date1 != ""){
			$.post(site_url+"/Leave/apply/calculate_prior",{date_from:date1},function(data){
				//alert(data+", "+paid_prior);
				document.getElementById('prior').value=data;
					if(paid_prior>data.trim()){
						document.getElementById('error').innerHTML='Minimum Prior Approval for Paid Leave - 10 days..!';
						document.getElementById('butt1').style.display="none";
					}
					else{
						document.getElementById('error').innerHTML='';
						document.getElementById('butt1').style.display="";
						//calculate_days();
					}
				
			});
			
		}
		
	}
	

	 function check_permission(){
			
			var per_balance=parseInt(document.getElementById('per_r').innerHTML);
			
			if(per_balance==0){
				document.getElementById('error').innerHTML='You have utilized all Permissions..!';
				document.getElementById('butt2').style.display="none";
			}
			else{
				document.getElementById('butt2').style.display="";
				document.getElementById('error').innerHTML='';					
			}	
}
	 
	 function validate_permission(){
			
			var date1=document.getElementById('p_date').value;
			//alert(date1);
			 $.post(site_url+"/Leave/apply/validate_permission",{date_from:date1},function(data){
					//alert(data);
					if(data.trim()>0){
						document.getElementById('error').innerHTML='You have taken / applied Permission for this month..!';
						document.getElementById('butt2').style.display="none";
					}
					
					else{
						document.getElementById('butt2').style.display="";
						document.getElementById('error').innerHTML='';
					}
				});
			 
	 }

	 	function validate_fields(){
	 		var type=document.getElementById('leave_type').value;
	 		var no_of_days=document.getElementById('no_of_days').value;
	 		var reason=document.getElementById('reason').value;
	 		var file=document.getElementById('fileupload').value;
			var date1=document.getElementById('date_from1').value;
			var date2=document.getElementById('date_to1').value;
			var sick_limit=document.getElementById('sick_limit').value;
	 		if(reason=="" || reason==" "){
	 			document.getElementById('error').innerHTML='Please fill the Reason..!';
	 		}
	 		else if(type=='Sick Leave' && (file=="" || file==null) && no_of_days>=sick_limit ){
	 			document.getElementById('error').innerHTML='Please upload a Medical / Proof Document..!';
	 		}
	 		else if(date1=="" || date2==""){
	 			document.getElementById('error').innerHTML='Please check date fields..!';
	 		}
	 		else{
	 			insert_application_data();
	 		}
	 		
	 	}
	
		function insert_application_data()
		{
			document.getElementById('butt1').style.display="none";
			document.getElementById('success').innerHTML="" ;
			
			var type=document.getElementById('leave_type').value;
			var date1=document.getElementById('date_from1').value;
			var date2=document.getElementById('date_to1').value;
			var days=document.getElementById('no_of_days').value;
			var reporter=document.getElementById('reporter').value;
			var approver=document.getElementById('approver').value;
			var reason=document.getElementById('reason').value;
			var sick_limit1=document.getElementById('sick_limit').value;
			var comp_minutes=document.getElementById('comp_minutes').value;
			var holidays_list1=document.getElementById('holidays_list').value ;
		var ask=confirm("Do You want to send this Application to Your Approval Officer(s)?");
		if(ask==true){

		
		//	alert("1");
			var leavid;
			var data={};
			data['leave_type']=type;
			data['date1']=date1;
			data['date2']=date2;
			data['days']=days;
			data['reporter']=reporter;
			data['approver']=approver;
			data['reason']=reason;
			data['hrs']=parseInt(days)*8+':00:00';
		//alert(data['hrs']);
			$.post(site_url+"/Leave/apply/insert_application_data",data,function(result){
			//	alert(result);
				document.getElementById('success').innerHTML="Please wait.System is sending Mail..!";
			
				
				if(type=='Sick Leave'){
				document.getElementById('leavID').value=result;					
				 leavid = document.getElementById('leavID').value;				
				$.ajaxFileUpload({				
			         url :site_url+'/lms/upload_file/'+leavid,   secureuri  :false, fileElementId  :'fileupload', 
			         		dataType    : 'json', data : {  'lid': leavid },success  : function (data, status)
			         		{
			         			if(data.status != 'error')
			         			{
			         				$.post(site_url+"/Leave/apply/SendMail",{date_from:date1,date_to:date2,reasoning:reason,day:days,l_type:type,Offr:officer,sick_limit:sick_limit1,holidays_list:holidays_list1},function(data){
			         					//alert(data);
			         					document.getElementById('error').innerHTML="";
			         					document.getElementById('error1').innerHTML="";
			         					document.getElementById('date_to1').value="";
			         					document.getElementById('date_from1').value="";
			         					document.getElementById('reason').value="";
			         					document.getElementById('no_of_days').value="";
			         					//document.getElementById('success').innerHTML="Your Leave Application was sent..!";
			         					document.getElementById('butt1').style.display="none";
			         					alert("Your Leave Application was sent successfully..!");
			         					window.location.reload();
			         				});
			         			}
			         		}
					});
				}
				else{
     				$.post(site_url+"/Leave/apply/SendMail",{date_from:date1,date_to:date2,reasoning:reason,day:days,l_type:type,Offr:reporter,sick_limit:sick_limit1,holidays_list:holidays_list1},function(data){
     					//alert(data);
     					document.getElementById('error').innerHTML="";
     					document.getElementById('error1').innerHTML="";
     					document.getElementById('date_to1').value="";
     					document.getElementById('date_from1').value="";
     					document.getElementById('reason').value="";
     					document.getElementById('no_of_days').value="";
     					//document.getElementById('success').innerHTML="Your Leave Application was sent..!";
     					document.getElementById('butt1').style.display="none";
     					alert("Your Leave Application was sent successfully..!");
     					window.location.reload();
     				});

				}
			});
			
	// Call the file upload function
			juploadstop();
			
	}
		
}
	

	function juploadstop(result)
	{
	    if(result==0)
	    {
	        $(".imageholder").html("");

	    }
	    // the result will be the path to the image
	    else if(result!=0)
	    {
	        $(".imageholder").html("");
	        // imageplace is the class of the div where you want to add the image  
	        $(".imageplace").append("<img src='"+result+"'>");
	    }   
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
	

	
			function insert_other_application()
			{	
								document.getElementById('success').innerHTML="" ;
								var user=document.getElementById('tech_name').value;
								var type=document.getElementById('leave_type').value;
								var date1=document.getElementById('date_from').value;
								var date2=document.getElementById('date_to').value;
								var am1=document.getElementById('am_pm1').value;
								var am2=document.getElementById('am_pm2').value;
								var days=document.getElementById('no_of_days').value;
								var officer=document.getElementById('approval_officer').value;
								var reason=document.getElementById('reason').value;
								
								var ask=confirm("Do You want to send this Application to Your Approval Officers?");
								if(ask==true){

									var leavid;
									var data={};
									data['uname']=user;
									data['leave_type']=type;
									data['date1']=date1+' '+am1;
									data['date2']=date2+' '+am2;
									data['days']=days;
									data['officer']=officer;
									data['reason']=reason;
									
									$.post(site_url+"/Leave/apply/insert_other_application",data,function(result){
										//alert(result);
										
													if(type=='Sick Leave'){
													document.getElementById('leavID').value=result;					
													 leavid = document.getElementById('leavID').value;				
													$.ajaxFileUpload({				
												         url :site_url+'/lms/upload_file/'+leavid,   secureuri  :false, fileElementId  :'fileupload', 
												         		dataType    : 'json', data : {  'lid': leavid },success  : function (data, status)
												         		{
												         			if(data.status != 'error')
												         			{
												         					$('#files').html('<p>Reloading files...</p>');
												         					refresh_files();
												         					$('#title').val('');
												         			}
												         		}
														});
													}
									});
									
									
										
							// Call the file upload function
									juploadstop();
												
								$.post(site_url+"/Leave/apply/SendMail",{date_from:date1,reasoning:reason,day:days,l_type:type,Offr:officer},function(data){
								//alert(data);
							});
							
							document.getElementById('error').innerHTML="";
							document.getElementById('error1').innerHTML="";
							document.getElementById('date_to').value="";
							document.getElementById('date_from').value="";
							document.getElementById('reason').value="";
							document.getElementById('no_of_days').value="";
							document.getElementById('success').innerHTML="Your Leave Application has sent to Your Approval Officer.!";

					}
									
			}
			

			$("#doj_date").datepicker({
				dateFormat: 'yy-mm-dd',onClose:function(selectedDate){},		
				defaultDate: new Date()		
			});
		

			
			
			/* * *   onMOUSE  Functions * * */

		function change_OnMouseOver(id,img){
			//alert(id);
			if(id!="" && img!="" && img!=null){
						document.getElementById(id).src='../../../images/Leave/'+img;
				}
		
		}
		
