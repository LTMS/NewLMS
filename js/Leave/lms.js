
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

									/*
											var now = new Date();
											var thisYear = now.getFullYear();
											var nextYear = thisYear+1;
											
												$.post(site_url+"/lms/get_holidays_calendar",{year1:thisYear,year2:nextYear},function(data){
													natDays=[];
											});
											
									natDays = [
									  [01,01,'New Year'], [2, 6], [3, 17],
									  [4, 27], [5, 25,2014], [6, 6],
									  [7, 4, 'us'], [8, 17, 'id'], [9, 7, 'br'],
									  [10, 1, 'cn'], [11, 22, 'lb'], [12, 12, 'ke']
									];
									
									function nationalDays(date) {
									    for (i = 0; i < natDays.length; i++) {
									      if (date.getMonth() == natDays[i][0] - 1
									          && date.getDate() == natDays[i][1]) {
									        return [false, natDays[i][2] + '_day'];
									      }
									    }
									  return [true, ''];
									 } 
									 
									 $("#date_from1").datepicker({
										dateFormat: 'dd-mm-yy',onClose:function(selectedDate){$("#date_to1").datepicker("option","minDate",selectedDate);},	
											defaultDate: new Date()	
										});
										
										$("#date_to1").datepicker({
											dateFormat: 'dd-mm-yy',	
											defaultDate: new Date()		
										});
																			 $("#p_date").datepicker({
											dateFormat: 'dd-mm-yy',	
											defaultDate: new Date()		
										});
									  */






$("#date_from").datepicker({
	dateFormat: 'dd-mm-yy',
	defaultDate: new Date()	
});

$("#date_to").datepicker({
	dateFormat: 'dd-mm-yy',	
	defaultDate: new Date()		
});




	function check_leave_status(datevalue)
	{
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

		$.post(site_url+"/lms/check_holidays",{date_from:datevalue},function(data){
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
		$.post(site_url+"/lms/check_sunday",{date_from:datevalue},function(data){
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
		$.post(site_url+"/lms/check_leavetaken",{date_from:datevalue},function(data){
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
			$.post(site_url+"/lms/calculate_workingdays",{date_from:date1,date_to:date2},function(data){
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
						 $.post(site_url+"/lms/validate_casual",{date_from:date1},function(data){
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
			$.post(site_url+"/lms/calculate_prior",{date_from:date1},function(data){
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
			 $.post(site_url+"/lms/validate_permission",{date_from:date1},function(data){
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
			var officer=document.getElementById('approval_officer').value;
			var officer2=document.getElementById('approval_officer2').value;
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
			data['officer']=officer;
			data['officer2']=officer2;
			data['reason']=reason;
			data['hrs']=parseInt(days)*8+':00:00';
		//alert(data['hrs']);
			$.post(site_url+"/lms/insert_application_data",data,function(result){
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
			         				$.post(site_url+"/lms/SendMail",{date_from:date1,date_to:date2,reasoning:reason,day:days,l_type:type,Offr:officer,sick_limit:sick_limit1,holidays_list:holidays_list1},function(data){
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
     				$.post(site_url+"/lms/SendMail",{date_from:date1,date_to:date2,reasoning:reason,day:days,l_type:type,Offr:officer,sick_limit:sick_limit1,holidays_list:holidays_list1},function(data){
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
					$.post(site_url+"/lms/insert_permission_data/",{date:d1,hour:hr1,total:tot,reason:reason1},function(data){
						//alert(data);
						
								$.post(site_url+"/lms/SendPermission/",{date:d1,hour:hr1,total:tot,reason:reason1,user:user1},function(data1){
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
	

	function get_leave_status(id)
	{		
		document.getElementById('error').innerHTML="";
		document.getElementById('errorrow').style.display="none";
		
		var date1=document.getElementById('date_from').value;
		var date2=document.getElementById('date_to').value;
		if(id=='1' && date1!='' && date2!=''){
			var l_type=document.getElementById('leave_type').value;			
			$.post(site_url+"/lms/get_leave_status",{d1:date1,d2:date2,type:l_type},function(data){$("#contentData").html("");
			$("#contentData").append(data);});

		}
		if(id=='2'){
			document.getElementById('date_from').value='';
			document.getElementById('date_to').value='';

			var l_type='1';		
			$.post(site_url+"/lms/get_leave_status",{d1:date1,d2:date2,type:l_type},function(data){$("#contentData").html("");
			$("#contentData").append(data);});
		}
		
	}

	
	
	
	function select_row(counter,type,day,d1,d2,user,id,status,reason,apptime,appby)
	{ 
		alert(status);
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
			$.post(site_url+"/lms/show_document",{lid:id},function(data){
						
			//	document.getElementById("IMG1").src="/LMS/files/"+data;
			//	document.getElementById("IMG1").alt="/LMS/files/"+data;
			//	document.getElementById("IMG1").title="/LMS/files/"+data;
			//	document.getElementById("sick_document").style.display="";
				
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
		
		 if(status=='L1 - Rejected' || status=='L2 - Rejected'){
			document.getElementById('rejected1').style.display="";
		}
		else if(status=='Leave Applied'){
			document.getElementById('applied1').style.display="";
			document.getElementById('appby').innerHTML="---";
		}
		else {
			document.getElementById('approved1').style.display="";
		}


				$.post(site_url+"/lms/getLeave4Date/",{date1:d1,date2:d2,id1:id},function(data){
				$("#leavesDiv").html("");
				$("#leavesDiv").append(data);
		     	//document.getElementById('leavesDiv').style.display="";
		
				});
				//alert(user);
				$.post(site_url+"/lms/getRecentLeave/",{user1:user,id1:id},function(data){
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
			$.post(site_url+"/lms/approve/",{lid:l_id,reason:l_reason},function(data){
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
				$.post(site_url+"/lms/reject/",{lid:l_id,reason:l_reason,type:l_type,user:uname,hrs:hrs2},function(data){
						window.location.reload();
						});
					}
					else if(l_reason==""){alert("You Must Enter the Reason to Process.!");}
				}
		else {
				alert("Select a Leave ID to Process.!");
			}
	}
		
		
		function get_history_admin(txt,op)
		{	
		
			if(op=='1'){
				document.getElementById('filter').value="";
				document.getElementById('team').value=""; 
				document.getElementById('report_option').value="Leave History of "+txt;
						}
			if(op=='2'){
				document.getElementById('search').value="";
				document.getElementById('team').value=""; 
				document.getElementById('report_option').value="Leave History of "+txt;
			}
			if(op=='3'){
				document.getElementById('filter').value="";
				document.getElementById('search').value="";
				document.getElementById('report_option').value="Leave History of "+txt;
			}
			if(op=='4'){
				document.getElementById('filter').value="";
				document.getElementById('team').value=""; 				
				document.getElementById('search').value=""; 	
				document.getElementById('report_option').value="Employees Leave History";
			}
			
			document.getElementById('errorrow').style.display="none";
			var date1=document.getElementById('date_from').value;
			var date2=document.getElementById('date_to').value;
			var h_filter=document.getElementById('filter').value;
			var src=document.getElementById('search').value; 
			var team1=document.getElementById('team').value; 
			
			
					document.getElementById('error').innerHTML="";
					$.post(site_url+"/lms/get_history_admin",{d1:date1,d2:date2,filter:h_filter,string:src,team:team1,type:op},function(data){
						//alert(data);
								$("#contentData").html("");
								$("#contentData").append(data);
					});
			
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
					
					$.post(site_url+"/lms/get_history_teamleader",{d1:date1,d2:date2,string:str},function(data){
							$("#contentData").html("");
							$("#contentData").append(data);
					});
			}

			
		
			function dept_add(){		
				var dept1 = document.getElementById("add_dept").value;
				if(dept1!="" && dept1!=null){
					$.post(site_url+"/lms/add_depart",{dept:dept1},function(data){	window.location.reload();});	
				}
			}	
			
			function dept_remove(){		
				
				var id1 = document.getElementById("rem_dept").value; //alert(id1);	
					$.post(site_url+"/lms/remove_dept",{id:id1},function(data){window.location.reload();	});	
				
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
									
									$.post(site_url+"/lms/insert_other_application",data,function(result){
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
												
								$.post(site_url+"/lms/SendMail",{date_from:date1,reasoning:reason,day:days,l_type:type,Offr:officer},function(data){
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
		
			function delete_tech(tech1,team1,user){
			//	alert("TechID: "+tech1+",  TeamID: "+team1);
				var ask = confirm("Do you want to remove this Technician - "+user+" ?");
				if(ask==true){	
					$.post(site_url+"/lms/remove_tech_info/",{team:team1,tech:tech1},function(data){
						window.location.reload();
					});
					}
			}
			
			function edit_tech(name1,dept1,desig1,phone1,mail1,doj1,tech,team){
								document.getElementById('name1').value=name1;
								document.getElementById('dept1').value=dept1;
								document.getElementById('desig1').value=desig1;
								document.getElementById('phone1').value=phone1;
								document.getElementById('mail1').value=mail1;
								document.getElementById('doj_date').value=doj1;
								document.getElementById("Row_Head").innerHTML="Edit Details";
								document.getElementById("butt").value="Update";
								document.getElementById("butt").onclick=function() {update_tech("EDIT",tech,team);};
					}
			
			
			function update_tech(option1,tech1,team1){
		     	//alert(option1+':'+tech1+':'+team1);
				var name1 = document.getElementById('name1').value;
				var dept1 = document.getElementById('dept1').value;
				var desig1 = document.getElementById('desig1').value;
				var phone1 = document.getElementById('phone1').value;
				var mail1 = document.getElementById('mail1').value;
				var doj1 = document.getElementById('doj_date').value;
				if(name1 !="" && dept1 !="" && desig1 !="" && phone1 !=""){
					$.post(site_url+"/lms/update_tech_info/",{team:team1,tech:tech1,name:name1,dept:dept1,desig:desig1,phone:phone1,mail:mail1,doj:doj1,option:option1},function(data){
						window.location.reload();
					});
				}
					
			}
			
			
			
			
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
				$.post(site_url+"/lms/get_summary",{year:year1,emp:emp1,team:team1,dept:dept1,type:op},function(data){
							//alert(data);
								$("#contentData").html("");
								$("#contentData").append(data);
				});
			}
				
			}
			
			
			function get_my_summary(year1){
				var op1=document.getElementById('report_option1').value;
				document.getElementById('report_option').value=op1+" for  "+year1;
				
				if(year1!=''){	
					$.post(site_url+"/lms/get_my_summary",{year:year1},function(data){
								//alert(data);
									$("#contentData").html("");
									$("#contentData").append(data);
					});
				}

				
			}
			
			
			function get_approved_leaves(){
				var yr=document.getElementById('year').value;
				var mon=document.getElementById('month').value;
				var emp1=document.getElementById('emp').value;
					
				if(year!='' && mon!='' && emp!=''){
					$.post(site_url+"/lms/get_approved_leaves",{year:yr,month:mon,emp:emp1},function(data){
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
							$.post(site_url+"/lms/reject/",{lid:l_id,reason:l_reason,type:l_type,user:uname,hrs:hrs2},function(data){
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
				$.post(site_url+"/lms/remove_leave/",{id:l_id},function(data){
					get_leave_status('2');
				});

			}
			
			
			
			function SendReminder(type,date,days,reason,colid,button,id){
				//alert(button);
				document.getElementById(colid).style.color='red';
				document.getElementById(colid).innerHTML='Sending Reminder...';
				//alert(type+' ,'+date+' ,'+days+' ,'+reason);
				$.post(site_url+"/lms/getOfficer_L1",{leaveID:id},function(data){
						var to1=data;
									$.post(site_url+"/lms/SendRemainder",{date_from:date,reasoning:reason,day:days,l_type:type,to:to1},function(data){
								
										document.getElementById(colid).style.color='green';
										document.getElementById(colid).innerHTML=data;
											});
					});

			}
			
			/* refreshing a division
			var refreshId = setInterval(function () {
			    $('#lms_intro_div').fadeOut("slow").load('site_url+"/lms/index.php').fadeIn("slow");
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
				
							$.post(site_url+"/lms/update_leave_param",{cm:cas_mon1,ct:cas_tot1,st:sick_tot1,sp:sick_proof1,pt:paid_tot1,pm:paid_min1,pe:paid_exp1,comp:comp1,permis:perm1,carry:carry1,paid_prior:paid_prior1},function(data){
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
					var downloadurl=site_url+"/lms/export_leave_history/"+params;
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

				$.post(site_url+"/lms/grantPermission/",{user:user1,date:date1,remark:remark1,id:id1},function(data){
					window.location.reload();
				});

			}


