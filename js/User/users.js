			$("#doj").datepicker({
				dateFormat: 'dd-mm-yy',		
				defaultDate: new Date()		
			});
			
			$("#dob").datepicker({
				dateFormat: 'dd-mm-yy',		
				defaultDate: new Date()		
			});
	
			
// Allowing Numbers Only			
			$(document).ready(function() {
			    $("#SL_days").keydown(function (e) {
			        // Allow: backspace, delete, tab, escape, enter and .
			        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
			             // Allow: Ctrl+A
			            (e.keyCode == 65 && e.ctrlKey === true) || 
			             // Allow: home, end, left, right
			            (e.keyCode >= 35 && e.keyCode <= 39)) {
			                 // let it happen, don't do anything
			                 return;
			        }
			        // Ensure that it is a number and stop the keypress
			        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
			            e.preventDefault();
			        }
			    });
			});

			
			function get_reporters(dept1){
				
				if(dept1!=""){
					$.post(site_url + "/User/users/get_reporters/",{dept:dept1},function(data){	
						//alert(data);
						var list=data.split('::');
						for(i=1;i<list.length;i++)
						{
							if(i%2!=0){
								//alert(list[i]+" : "+list[i+1]);
									if(list[i]!="" && list[i].replace(/[^A-Z]/gi, "").length>0){
											var opt = document.createElement("option");
													if(document.getElementById("reporters")){
																document.getElementById("reporters").options.add(opt);
																opt.text =list[i];
															    opt.value = list[i+1];
													}
										}
							}
						
				}

						get_approvers(dept1);
						
						}); 
					}
			}
			
			function get_approvers(dept1){
				if(dept1!=""){
					$.post(site_url + "/User/users/get_approvers/",{dept:dept1},function(data){	
						//alert(data);
						var list=data.split('::');
						for(i=1;i<list.length;i++)
						{
							if(i%2!=0){
								//alert(list[i]+" : "+list[i+1]);
									if(list[i]!="" && list[i].replace(/[^A-Z]/gi, "").length>0){
											var opt = document.createElement("option");
													if(document.getElementById("approvers")){
																document.getElementById("approvers").options.add(opt);
																opt.text =list[i];
															    opt.value = list[i+1];
													}
											}
									}
						
							}

						}); 
					}
			}
			
						
			
			function check_EmpNumber(num){
				//alert(num);
				if(num!=""){
					$.post(site_url + "/User/users/check_EmpNumber/",{emp_num:num},function(data){
						//alert(data);
						if(data==0){
							document.getElementById('avail').style.display='';
							document.getElementById('notavail').style.display='none';
							document.getElementById('buttonrow').style.display='';	
						}
						else{
							document.getElementById('avail').style.display='none';
							document.getElementById('notavail').style.display='';
							document.getElementById('buttonrow').style.display='none';	
						}
						
						}); 
				}
				else{
					document.getElementById('avail').style.display='none';
					document.getElementById('notavail').style.display='none';
					document.getElementById('buttonrow').style.display='none';	
				}
	}
			
			function check_password_length(){
				var pwd=document.getElementById("passwd").value;
				if(pwd.length<6){
					
					alert("Password should have minimum 6 Characters and Maximum 12 Characters..!");
					document.getElementById("cpasswd").value="";
					
				}
				else if(pwd.length>12){
					alert("Password should have minimum 6 Characters and Maximum 12 Characters..!");
					document.getElementById("cpasswd").value="";	
					
				}
				else{
					document.getElementById("cpasswd").value="";
					
				}
			}
			
			
				function check_password(){
					var pwd=document.getElementById("passwd").value;
					var cpwd=document.getElementById("cpasswd").value;
				//alert(cpwd);
				if(pwd!="" && cpwd!=""){
						if(pwd==cpwd){
							document.getElementById('match').style.display='';
							document.getElementById('mismatch').style.display='none';	
						}
						else{
							document.getElementById('match').style.display='none';
							document.getElementById('mismatch').style.display='';		
						}
								
				}
				else{
					document.getElementById('match').style.display='none';
					document.getElementById('mismatch').style.display='none';	
			}
				
			}
				
				
		function checkEmail() {

				    var email = document.getElementById('email');
				    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

				    if (!filter.test(email.value)) {
						    alert('Please provide a valid email address');
						    email.focus;
						    return false;
				 }
		}
			
			function submit_userData(){
				
				var hon=document.getElementById("honorific").value;
				var emp_name1=hon+""+document.getElementById("emp_name").value;
				var emp_num1=document.getElementById("emp_num").value;
				var passwd1=document.getElementById("passwd").value;
				var cpasswd1=document.getElementById("cpasswd").value;
				var userrole1=document.getElementById("userrole").value;
				var mail1=document.getElementById("email").value;
				var dept1=document.getElementById("dept").value;
				var reporters1=document.getElementById("reporters").value;
				var approvers1=document.getElementById("approvers").value;
				var doj1=document.getElementById("doj").value;
				if(emp_name1=="")
				{
				alert("Please Enter Employee Name..!");
				}
				else if(emp_num1==""){
				alert("Please Enter Employee Number..!");
				}
				else if(mail1=="")
				   {
					   alert("Please Enter MailID");
					}
				else if(doj1=="")
				   {
					   alert("Please Enter Date of Joining..!");
					}
				else if(dept1=="")
				   {
					   alert("Please Enter Department..!");
					}
				else if(cpasswd1=="")
				{
				   alert("Please Enter Confirm Password");
				}
			
				else if(passwd1=="")
				   {
					   alert("Please Enter Password");
					}
			
				else if(passwd1!=cpasswd1)
				{
				   alert("Passwords do not match");
				}
			
					    else
					{
								    	//alert(emp_name1);
							    document.getElementById("button").style.display='none';
							    document.getElementById('buttonrow').innerHTML='Please wait..! System is sending mail..!';
									$.post(site_url + "/User/users/create_user/",{emp_name:emp_name1,emp_num:emp_num1,passwd:passwd1,userrole:userrole1,mail:mail1,dept:dept1,reporter:reporters1,approver:approvers1,doj:doj1},function(data){	
												//alert(data);
												alert(	'Mail has been sent to '+emp_name1+' ..!');
												window.location.reload();
									}); 
					}
				
			}
			
			
			function updateuser(user_id)
			{
				
				updatepop=window.open("","","menubar=no, location=no, status=no, titlebar=yes, width=600, height=520,toolbar=no,addressbar=yes");
						var generatedContent="<html><head><title>Update Customer Info</title><link rel='stylesheet' media='screen,projection' type='text/css' href='../../css/mystyle.css' /></head>"+
						 "<body background='../../images/bg-radial-gradient.gif' bgcolor=''><div style='height:auto; background:#DBEADC;margin:20px 0px 0px 40px;width:80%;border:1px solid black ;border-radius:10px;'><p style='height:10px;padding:0px 0px 0px 20px;' align='center'><span style='font-weight:bolder;font-size:13pt;'>User Information </span></p>"+
					"<hr width='100%'>"+
					"<div id='myuser' style='margin:20px 20px 20px 40px;'><p>Please wait while Loading....</p></div>  <div style='margin-left:100px;margin-bottom:30px;'><input style='margin-right:25px;' class='button' type=\"button\" id='update' value='Update' onclick='opener.updateuserFinish()'/><input class='button' type=\"button\" id='close' value='Close' onclick='javascript:self.close()'/></div></body</html>";
						 updatepop.document.write(generatedContent);   
						 
						 $.get(site_url + "/User/users/fetch_user_info/"+user_id,function(data){	
							 			updatepop.document.getElementById('myuser').innerHTML=data;
						 }); 
			}
			
			function deleteuser(user_id1,name1){
				//alert(user_id);
				var ask = confirm("Do you want to Remove this User - "+name+" ?");
				if(ask==true){	
					$.post(site_url + "/User/users/remove_user_info/",{user_id:user_id1,name:name1},function(data){	
					window.location.reload();
					}); 
				}
			}
			
			
			function updateuserFinish(){
				var u_name=updatepop.document.getElementById("u_name").value;		
				var username=updatepop.document.getElementById("username").value;
				var passwd=updatepop.document.getElementById("passwd").value;
				var cpasswd=updatepop.document.getElementById("cpasswd").value;
				var userrole=updatepop.document.getElementById("userrole").value;
				var to_id=updatepop.document.getElementById("timeoffice_id").value;
				if(passwd!=cpasswd){
					alert("Passwords do not match");
					return false;
				}
				
				var collect={};
				collect["u_name"]=u_name;
				collect["username"]=username;
				collect["passwd"]=passwd;
				collect["userrole"]=userrole;
				collect["to_id"]=to_id;
				
				   $.post(site_url+"/logincheck/updateuser",collect,function(data){
					 
					   updatepop.document.getElementById('myuser').innerHTML=data;
					   updatepop.document.getElementById('update').style.display="none";
					   updatepop.document.getElementById('close').style.marginLeft="80px";
					   window.location.reload();	
				    });
				}
			
			String.prototype.trim = function()
			{return ((this.replace(/^[\s\xA0]+/, "")).replace(/[\s\xA0]+$/, ""));};
			
			String.prototype.startsWith = function(str)
			{return (this.match(str)==str);};
			
			String.prototype.endsWith = function(str)
			{return (this.match(str+"$")==str);};
			
			function searchbyname()
			{
				var user=document.getElementById('user').value;
				filterTableByname(user);
			}
			function filterTableByname(str){
				
				str.trim();
				 var rowid, colid, rowc,vbid;
				  rcount=document.getElementById("hrowcount");
				  rowc=rcount.value;
				  
				  for(var i=1;i<=rowc;i++){
				    rowid="row"+i;
				    colid="name"+i;
				    var lstr=(str.toString()).toLowerCase();
				    displayRowStartsWith(rowid,colid,lstr);
				  }
				}
			function displayRowStartsWith(rowid,colid,str){
				var row = document.getElementById(rowid);
			      var searchcol= document.getElementById(colid);
			     var colstr=searchcol.value;
			     var lcolstr=(colstr.toString()).toLowerCase();
			      if (lcolstr.startsWith(str))
			    	  row.style.display = '';
			      else
			          row.style.display = 'none';
			}
			
			
							
							function get_team_leader(obj)
							{
								var select=document.getElementById('app_lev1');
								var select2=document.getElementById('app_lev2');
								if(select && select2){
									var length=select.length;
									var length2=select2.length;
									for (i=0;i<=length;i++) {
									select.remove(select.selectedIndex);
									}
									
									/*	for (i=0;i<=length;i++) {
									select2.remove(select2.selectedIndex);
									alert(select.selectedIndex);
									alert(select.length);
									select.remove(i);
									}*/
								}
								
								$.post(site_url+"/User/users/get_team_leader",{dept:obj},function(data){
							
									var leaderlist=data.split('!');
									for(i=1;i<leaderlist.length;i++)
									{
									var opt = document.createElement("option");
									if(document.getElementById("app_lev1")){
										document.getElementById("app_lev1").options.add(opt);
										opt.text = leaderlist[i];
									    opt.value = leaderlist[i];
										
										}
										}
								});
								
								Add_admin_option();
						}
			
							
							
								function Add_admin_option(){
									var opt = document.createElement("option");
									document.getElementById("app_lev1").options.add(opt);
									opt.text = "Managing Director";
								    opt.value = "Managing Director";
							
								}
								
								
								
							function fix_address(){
								
									var ad1= document.getElementById('ad1').value;
									var ad2= document.getElementById('ad2').value;
									var ad3= document.getElementById('ad3').value;
									var city= document.getElementById('city').value;
									var state= document.getElementById('state').value;
									var country= document.getElementById('country').value;
									var post= document.getElementById('post').value;
										
									if(document.getElementById('check').checked==true){	
										
										document.getElementById('E-ad1').value=ad1;
										document.getElementById('E-ad2').value=ad2;
										document.getElementById('E-ad3').value=ad3;
										document.getElementById('E-city').value=city;
										document.getElementById('E-state').value=state;
										document.getElementById('E-country').value=country;
										document.getElementById('E-post').value=post;
											}
									
									else{							
										document.getElementById('E-ad1').value="";
										document.getElementById('E-ad2').value="";
										document.getElementById('E-ad3').value="";
										document.getElementById('E-city').value="";
										document.getElementById('E-state').value="";
										document.getElementById('E-country').value="";
										document.getElementById('E-post').value="";
											}
									
							}
								
								
								function updateEmployees_Details(){
									
									var name1= document.getElementById('name').value;
									var f_name1= document.getElementById('f_name').value;
									var gender1= document.getElementById('gender').value;
									var blood1= document.getElementById('blood').value;
									var sub_blood1= document.getElementById('sub_blood').value;						
									var dob1= document.getElementById('dob').value;						
									var marital1= document.getElementById('marital').value;
									var mail1= document.getElementById('mail').value;
									var doj1= document.getElementById('doj').value;
									
									//alert(dob);
									var mobile1= document.getElementById('mobile').value;
									var phone1= document.getElementById('phone').value;
									var desig1= document.getElementById('desig').value;
									var pf1= document.getElementById('pf').value;
									var bank1= document.getElementById('bank').value;
									var branch1= document.getElementById('branch').value;
									var accno1= document.getElementById('accno').value;
									var insur1= document.getElementById('insur').value;
			
									var ad1=document.getElementById('ad1').value;
									var ad2= document.getElementById('ad2').value;
									var ad3= document.getElementById('ad3').value;
									var city1= document.getElementById('city').value;
									var state1= document.getElementById('state').value;
									var country1= document.getElementById('country').value;
									var post1= document.getElementById('post').value;
									
			
									var Ead1=document.getElementById('E-ad1').value;
									var Ead2= document.getElementById('E-ad2').value;
									var Ead3= document.getElementById('E-ad3').value;
									var Ecity1= document.getElementById('E-city').value;
									var Estate1= document.getElementById('E-state').value;
									var Ecountry1= document.getElementById('E-country').value;
									var Epost1= document.getElementById('E-post').value;
			
									if(name1!='' && f_name!='' && gender1!='' && mail1!='' && blood1!=''&& sub_blood1!='' && doj1!='' &&  dob1!='' && marital1!='' && mobile1!='' && phone1!='' && bank1!='' && branch1!='' && accno1!='' && desig1!='' && pf1!='' ){
										
										
										
														if(insur1!='' && ad1!='' && ad2!='' && state1!='' && city1!='' && country1!='' && post1!='' && Ead1!='' && Ead2!='' && Estate1!='' && Ecity1!='' && Ecountry1!='' &&  Epost1!=''){
															
																	$.post(site_url + "/User/users/updateEmployees_Details1/",{name:name1,f_name:f_name1,gender:gender1,blood:blood1,sub_blood:sub_blood1,dob:dob1,marital:marital1,doj:doj1,mail:mail1},function(data){	
									
																		
																		$.post(site_url + "/User/users/updateEmployees_Details2/",{name:name1,mobile:mobile1,phone:phone1,desig:desig1,pf:pf1,bank:bank1,branch:branch1,accno:accno1,insur:insur1},function(data){	
																					
									
																							//alert(Ead1);
																							if(document.getElementById('check').checked==true){	
																									$.post(site_url + "/User/users/updateEmployees_Details3/",{name:name1,adr1:ad1,adr2:ad2,adr3:ad3,city:city1,state:state1,country:country1,post:post1},function(data){	
																										window.location.reload();
																									}); 
																							}
																							else{
																								$.post(site_url + "/User/users/updateEmployees_Details4/",{name:name1,Eadr1:Ead1,Eadr2:Ead2,Eadr3:Ead3,Ecity:Ecity1,Estate:Estate1,Ecountry:Ecountry1,Epost:Epost1,adr1:ad1,adr2:ad2,adr3:ad3,city:city1,state:state1,country:country1,post:post1},function(data){	
																									window.location.reload();
																								}); 
																							}
																				}); 
																		
																	}); 
															
														}
														else{
															document.getElementById('error').innerHTML='Please Check Right-Side input Fields.!';
														}
										
									}
									else{
										document.getElementById('error').innerHTML='Please Check Left-Side input Fields.!';
									}
									
									
									
							}
								
								
								
								function enableEditing(){
									document.getElementById("f_name").removeAttribute("readonly",1);
									document.getElementById("gender").removeAttribute("disabled",1);
									document.getElementById("dob").removeAttribute("disabled",1);
									document.getElementById("blood").removeAttribute("disabled",1);
									document.getElementById("sub_blood").removeAttribute("disabled",1);
									document.getElementById("marital").removeAttribute("disabled",1);
									document.getElementById("mobile").removeAttribute("readonly",1);
									document.getElementById("phone").removeAttribute("readonly",1);
									document.getElementById("mail").removeAttribute("readonly",1);
									document.getElementById("desig").removeAttribute("readonly",1);
									document.getElementById("doj").removeAttribute("disabled",1);
									document.getElementById("pf").removeAttribute("readonly",1);
									document.getElementById("insur").removeAttribute("readonly",1);
											
									document.getElementById("bank").removeAttribute("readonly",1);
									document.getElementById("branch").removeAttribute("readonly",1);
									document.getElementById("accno").removeAttribute("readonly",1);
									document.getElementById("ad1").removeAttribute("readonly",1);
									document.getElementById("ad2").removeAttribute("readonly",1);
									document.getElementById("ad3").removeAttribute("readonly",1);
									document.getElementById("city").removeAttribute("readonly",1);
									document.getElementById("state").removeAttribute("readonly",1);
									document.getElementById("country").removeAttribute("readonly",1);
									document.getElementById("post").removeAttribute("readonly",1);
									
									document.getElementById("check").removeAttribute("disabled",1);
									
									document.getElementById("E-ad1").removeAttribute("readonly",1);
									document.getElementById("E-ad2").removeAttribute("readonly",1);
									document.getElementById("E-ad3").removeAttribute("readonly",1);
									document.getElementById("E-city").removeAttribute("readonly",1);
									document.getElementById("E-state").removeAttribute("readonly",1);
									document.getElementById("E-country").removeAttribute("readonly",1);
									document.getElementById("E-post").removeAttribute("readonly",1);
											
									document.getElementById('BUTTONROW1').style.display='none';
									document.getElementById('BUTTONROW2').style.display='';
										}
								
								function individual_details(counter,father,gender,dob,bgs,martial,name,design,pf,star,homephone,tempaddr,peraddr,bankname,bankbranch,bankaccount)
								{ 
									
									if(father !="" &&  dob !="" )
									{
									
									document.getElementById('Details').style.display="";
									document.getElementById('father_row').style.display="";
									document.getElementById('gender_row').style.display="";
									document.getElementById('dob_row').style.display="";
									document.getElementById('BGS_row').style.display="";
									document.getElementById('martial_row').style.display="";
									document.getElementById('Employee').style.display="";
									document.getElementById('PF_row').style.display="";
									document.getElementById('design_row').style.display="";
									document.getElementById('star_row').style.display="";
									document.getElementById('home_row').style.display="";
									document.getElementById('bankbranch_row').style.display="";
									document.getElementById('bankname_row').style.display="e";
									document.getElementById('bankaccount_row').style.display="";
									document.getElementById('tempaddr_row').style.display="";
									document.getElementById('peraddr_row').style.display="";
									document.getElementById('updation').style.display="none";
									document.getElementById('warning').style.display="none";
									document.getElementById('father').innerHTML=father;
									document.getElementById('gender').innerHTML=gender;
										if(gender == "Male")
											{document.getElementById('male').style.display="";
											document.getElementById('female').style.display="none";}else
												{document.getElementById('female').style.display="";
												document.getElementById('male').style.display="none";}
									document.getElementById('dob').innerHTML=dob;
									document.getElementById('BGS').innerHTML=bgs;
									document.getElementById('martial').innerHTML=martial;
									document.getElementById('Employee').innerHTML=name;
									document.getElementById('PF').innerHTML=pf;
									document.getElementById('design').innerHTML=design;
									document.getElementById('star').innerHTML=star;
									document.getElementById('home').innerHTML=homephone;
									document.getElementById('bankbranch').innerHTML=bankbranch;
									document.getElementById('bankname').innerHTML=bankname;
									document.getElementById('bankaccount').innerHTML=bankaccount;
									document.getElementById('tempaddr').innerHTML=tempaddr;
									document.getElementById('peraddr').innerHTML=peraddr;
									} else{
									document.getElementById('Details').style.display="";	
									document.getElementById('father_row').style.display="none";
									document.getElementById('gender_row').style.display="none";
									document.getElementById('dob_row').style.display="none";
									document.getElementById('BGS_row').style.display="none";
									document.getElementById('martial_row').style.display="none";
									document.getElementById('Employee').style.display="none";
									document.getElementById('updation').style.display="";
									document.getElementById('warning').style.display="";
									document.getElementById('updation').innerHTML="This user has not updated his profile..!";
									document.getElementById('female').style.display="none";
									document.getElementById('male').style.display="none";
									document.getElementById('PF_row').style.display="none";
									document.getElementById('design_row').style.display="none";
									document.getElementById('star_row').style.display="none";
									document.getElementById('home_row').style.display="none";
									document.getElementById('bankbranch_row').style.display="none";
									document.getElementById('bankname_row').style.display="none";
									document.getElementById('bankaccount_row').style.display="none";
									document.getElementById('tempaddr_row').style.display="none";
									document.getElementById('peraddr_row').style.display="none";
									}
									var rows=document.getElementById('TotalRows').value; 
									
			
									for( i=1; i<=rows;i++){
										if(i==counter){
											document.getElementById("row"+i).style.background="#AFEEEE";
											
										}
										else if(i%2==0){
											document.getElementById("row"+i).style.background="WHITE";
										}
										else{document.getElementById("row"+i).style.background="#EEEEEE";}
									}
								}
								
								
								