/* * *  Reprocessing Leave		* * */	
			
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
			
			
			
																								/* * *     LMS Criteria     * * */
			
			
			
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
	
// LMS Criteria End			
			
			
			
			
			
			function export_leave_summmary(id)
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
			
			

