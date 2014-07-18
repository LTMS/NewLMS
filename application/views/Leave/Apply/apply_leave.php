<div style="height: 70px; background: #59955C;">
	<table>
		<tr>
			<td width="50" align='left'><img style="width: 100px; height: 50px"
				src="<?php echo base_url(); ?>/images/apply.png">
			</td>
			<td align='left'
				style="margin-bottom: 20px; font-size: 21pt; position: inline; color: white; font-weight: bolder">Apply
				Leave</td>
			<td style="color: white; font-size: 15pt" align="right">Hi, <b><?php echo $this->session->userdata('Emp_Name');?>
			</b> ..!</td>
			<td align="left" style="color: white; font-size: 15pt; width: 50px">
				<a href="<?php echo site_url("logincheck/logout"); ?>"><img
					style="width: 50px; height: 50px"
					src="<?php echo base_url(); ?>/images/logout2.png">
			</a></td>
		</tr>
	</table>
</div>
<body onload="remove_NotUploadedDocuments()" ></body>
<?php 
	if(!empty($Criteria)){
				foreach($Criteria as $row){
					$type=$row["Leave_Type"];
					if($type=="CL"){
						$month_limit_CL=$row["Monthly_Limit"];
						$year_limit_CL=$row["Yearly_Limit"];
						$experience_CL=$row["Experience_Month"];
						$min_limit_CL=$row["Minimum_Limit"];
						$max_limit_CL=$row["Maximum_Limit"];
						$prior_days_CL=$row["Prior_Days"];
						$doc_days_CL=$row["Doc_Limit_Days"];
						$carry_CL=$row["Carry_Forward"];
					}

					if($type=="SL"){
						$month_limit_SL=$row["Monthly_Limit"];
						$year_limit_SL=$row["Yearly_Limit"];
						$experience_SL=$row["Experience_Month"];
						$min_limit_SL=$row["Minimum_Limit"];
						$max_limit_SL=$row["Maximum_Limit"];
						$prior_days_SL=$row["Prior_Days"];
						$doc_days_SL=$row["Doc_Limit_Days"];
						$carry_SL=$row["Carry_Forward"];
					}
				
					if($type=="EL"){
						$month_limit_EL=$row["Monthly_Limit"];
						$year_limit_EL=$row["Yearly_Limit"];
						$experience_EL=$row["Experience_Month"];
						$min_limit_EL=$row["Minimum_Limit"];
						$max_limit_EL=$row["Maximum_Limit"];
						$prior_days_EL=$row["Prior_Days"];
						$doc_days_EL=$row["Doc_Limit_Days"];
						$carry_EL=$row["Carry_Forward"];
					}
				
					if($type=="CO"){
						$month_limit_CO=$row["Monthly_Limit"];
						$year_limit_CO=$row["Yearly_Limit"];
						$experience_CO=$row["Experience_Month"];
						$min_limit_CO=$row["Minimum_Limit"];
						$max_limit_CO=$row["Maximum_Limit"];
						$prior_days_CO=$row["Prior_Days"];
						$doc_days_CO=$row["Doc_Limit_Days"];
						$carry_CO=$row["Carry_Forward"];
					}
					
					if($type=="ML"){
						$month_limit_ML=$row["Monthly_Limit"];
						$year_limit_ML=$row["Yearly_Limit"];
						$experience_ML=$row["Experience_Month"];
						$min_limit_ML=$row["Minimum_Limit"];
						$max_limit_ML=$row["Maximum_Limit"];
						$prior_days_ML=$row["Prior_Days"];
						$doc_days_ML=$row["Doc_Limit_Days"];
						$carry_ML=$row["Carry_Forward"];
						$chances_ML=$row["Chances"];
					}
					
				}
		
	}
	
	if(!empty($Experience)){
			foreach($Experience as $row2){
					$experience=$row2["Experience_Month"];
			}
	}
	
?>


<input type='hidden'  id='experience' value='<?php echo $experience;?>'/>


<input type='hidden'  id='month_limit_CL' value='<?php echo $month_limit_CL;?>'/>
<input type='hidden'  id='year_limit_CL'  value='<?php echo $year_limit_CL;?>'/>
<input type='hidden'  id='experience_CL'  value='<?php echo $experience_CL;?>'/>
<input type='hidden'  id='min_limit_CL'  value='<?php echo $min_limit_CL;?>'/>
<input type='hidden'  id='max_limit_CL'  value='<?php echo $max_limit_CL;?>'/>
<input type='hidden'  id='prior_days_CL'  value='<?php echo $prior_days_CL;?>'/>
<input type='hidden'  id='doc_days_CL'  value='<?php echo $doc_days_CL;?>'/>
<input type='hidden'  id='carry_CL'  value='<?php echo $carry_CL;?>'/>


<input type='hidden'  id='month_limit_SL' value='<?php echo $month_limit_SL;?>'/>
<input type='hidden'  id='year_limit_SL'  value='<?php echo $year_limit_SL;?>'/>
<input type='hidden'  id='experience_SL'  value='<?php echo $experience_SL;?>'/>
<input type='hidden'  id='min_limit_SL'  value='<?php echo $min_limit_SL;?>'/>
<input type='hidden'  id='max_limit_SL'  value='<?php echo $max_limit_SL;?>'/>
<input type='hidden'  id='prior_days_SL'  value='<?php echo $prior_days_SL;?>'/>
<input type='hidden'  id='doc_days_SL'  value='<?php echo $doc_days_SL;?>'/>
<input type='hidden'  id='carry_SL'  value='<?php echo $carry_SL;?>'/>


<input type='hidden'  id='month_limit_EL' value='<?php echo $month_limit_EL;?>'/>
<input type='hidden'  id='year_limit_EL'  value='<?php echo $year_limit_EL;?>'/>
<input type='hidden'  id='experience_EL'  value='<?php echo $experience_EL;?>'/>
<input type='hidden'  id='min_limit_EL'  value='<?php echo $min_limit_EL;?>'/>
<input type='hidden'  id='max_limit_EL'  value='<?php echo $max_limit_EL;?>'/>
<input type='hidden'  id='prior_days_EL'  value='<?php echo $prior_days_EL;?>'/>
<input type='hidden'  id='doc_days_EL'  value='<?php echo $doc_days_EL;?>'/>
<input type='hidden'  id='carry_EL'  value='<?php echo $carry_EL;?>'/>


<input type='hidden'  id='month_limit_CO' value='<?php echo $month_limit_CO;?>'/>
<input type='hidden'  id='year_limit_CO'  value='<?php echo $year_limit_CO;?>'/>
<input type='hidden'  id='experience_CO'  value='<?php echo $experience_CO;?>'/>
<input type='hidden'  id='min_limit_CO'  value='<?php echo $min_limit_CO;?>'/>
<input type='hidden'  id='max_limit_CO'  value='<?php echo $max_limit_CO;?>'/>
<input type='hidden'  id='prior_days_CO'  value='<?php echo $prior_days_CO;?>'/>
<input type='hidden'  id='doc_days_CO'  value='<?php echo $doc_days_CO;?>'/>
<input type='hidden'  id='carry_CO'  value='<?php echo $carry_CO;?>'/>


<input type='hidden'  id='month_limit_ML' value='<?php echo $month_limit_ML;?>'/>
<input type='hidden'  id='year_limit_ML'  value='<?php echo $year_limit_ML;?>'/>
<input type='hidden'  id='experience_ML'  value='<?php echo $experience_ML;?>'/>
<input type='hidden'  id='min_limit_ML'  value='<?php echo $min_limit_ML;?>'/>
<input type='hidden'  id='max_limit_ML'  value='<?php echo $max_limit_ML;?>'/>
<input type='hidden'  id='prior_days_ML'  value='<?php echo $prior_days_ML;?>'/>
<input type='hidden'  id='doc_days_ML'  value='<?php echo $doc_days_ML;?>'/>
<input type='hidden'  id='carry_ML'  value='<?php echo $carry_ML;?>'/>
<input type='hidden'  id='chances_ML'  value='<?php echo $chances_ML;?>'/>

<input type='hidden'  id='Row_Id_SL' value='0'/>			
<input type='hidden'  id='Row_Id_ML' value='0'/>			
<input type='hidden'  id='Docs_Total_Count_SL' value='1'/>			
<input type='hidden'  id='Docs_Total_Count_ML' value='1'/>			

<?php 

// Assinging Leave Balance Variables

	$rep_month=$rep_year=$apvr_month=$apvr_year=$apprd_month=$apprd_year=0;
	
		if(!empty($Leave_Details_Year)){
					foreach($Leave_Details_Year as $row3){
						$rep_year=$row3["At_Reporter"];
						$apvr_year=$row3["At_Approver"];
						$apprd_year=$row3["Approved"];
					}
		}
		
		if(!empty($Leave_Details_Month)){
					foreach($Leave_Details_Month as $row4){
						$rep_month=$row4["At_Reporter"];
						$apvr_month=$row4["At_Approver"];
						$apprd_month=$row4["Approved"];
					}
		}

	$balance=$year_limit_CL-$apprd_year;
?>

<div id='Criteria_CL' style='position:absolute;width:28%;height:65%;margin:9.5% 0 0 54%;background:#FFFFFF;box-shadow: 5px 5px 5px #BBDAFF;border:1px groove #62A9FF;border-radius:10px;'>

			<p class="Font_Small" style='font-size:13pt;color:#AD0000' align='center'><u>Criteria</u></p>
			<table id='Criteria_Table' style='color:#218429' class='Font_Small'>
				<tr>
					<td > * Experience Needed </td>
					<td width='5'>:</td>
					<td id='exp' ><?php if($experience_CL==0){ $experience_CL="---";}else{ echo $experience_CL." Months";} ?>  </td>
				</tr>	
				<tr>
					<td > * Prior Approval</td>
					<td width='5'>:</td>
					<td id='prior' ><?php if($prior_days_CL==0){ echo "---";} else{echo $prior_days_CL." Days"; } ?> </td>
				</tr>	
				<tr>
					<td> * Document Uploading Limit</td>
					<td width='5'>:</td>
					<td id='doc_limit' ><?php if($doc_days_CL==0){ echo "---";} else{echo $doc_days_CL." Days"; } ?> </td>
				</tr>	
				<tr>
					<td > * Leaves allowed per Month</td>
					<td width='5'>:</td>
					<td id='month_limit'><?php  if($month_limit_CL==0){ echo "---";} else{echo $month_limit_CL." Days"; } ?></td>
				</tr>	
				<tr>
					<td > * Leaves allowed per Year</td>
					<td width='5'>:</td>
					<td id='year_limit'><?php  if($year_limit_CL==0){ echo "---";} else{echo $year_limit_CL." Days"; }?></td>
				</tr>	
				<tr>
					<td > * Minimum at a Time</td>
					<td width='5'>:</td>
					<td id='min_limit'><?php if($min_limit_CL==0){ echo "---";} else{echo $min_limit_CL." Days"; } ?> </td>
				</tr>	
				<tr>
					<td > * Maximum at a Time</td>
					<td width='5'>:</td>
					<td id='max_limit'><?php if($max_limit_CL==0){ echo "---";} else{echo $max_limit_CL." Days"; }  ?> </td>
				</tr>	
				<tr>
					<td> * Carry Forward</td>
					<td width='5'>:</td>
					<td id='carry' ><?php echo $carry_CL; ?></td>
				</tr>	
			</table>
			<br>
			<p class="Font_Small" style='font-size:13pt;color:#AD0000' align='center'><u>Leave Balance</u></p>
			
			<table  id='Balance_Table' width='100%'align='center' style="color:#218429" class='Font_Small' >
				<tr align='center'>
						<td  ></td>
						<td ><u>This Month</u></td>
						<td  ><u>This Year</u></td>
				</tr>
				<tr align='center'>
						<td  align='left'>Pending @ Reporter</td>
						<td id='rep_month'><?php echo $rep_month;?></td>
						<td id='rep_year' ><?php echo $rep_year;?></td>
				</tr>
				<tr align='center'>
						<td  align='left'>Pending @ Approver</td>
						<td id='apvr_month'><?php echo $apvr_month;?></td>
						<td  id='apvr_year'><?php echo $apvr_year;?></td>
				</tr>
				<tr align='center' >
						<td  align='left'>Approved Leaves</td>
						<td id='apprd_month'><?php echo $apprd_month;?></td>
						<td  id='apprd_year' style="font-size:12pt;color:#2F619C; ahoma;"><?php echo $apprd_year;?></td>
				</tr>
				<tr align='center' >
						<td  align='center' colspan='4' ><hr></td>
				</tr>
				<tr align='center'  style="font-size:12pt;color:#2F619C;font-family:Tahoma;">
						<td  colspan='2' align='right'>Balance <font color='red'  size='2px'>&nbsp; (Excld Pending Leaves) </font></td>
						<td id="balance"><?php echo $balance;?></td>
				</tr>
			</table>
</div>



<div style='width:60%;margin:1% 0 0 1%'>
	<table id='Leave_List' align='center'>
		<?php if($this->session->userdata["Gender"]=="Female"){?>
		<tr align='center'>
			<td align='center'><input type='image' id='CL_Div' width='130' height='90' src='../../../images/Leave/CL.png'  alt='Casual Leave' onclick='show_LeaveDiv("CL_Table","CL","#218429")' onmouseover='show_Shadow("CL_Div","#E3FBE9")' /></td>
			<td align='center'><input type='image' id='SL_Div' width='130' height='90' src='../../../images/Leave/SL.png' alt='Sick Leave' onclick='show_LeaveDiv("SL_Table","SL","#872187")'  onmouseover='show_Shadow("SL_Div","#FFEEFD")'/></td>
			<td align='center'><input type='image' id='EL_Div' width='130' height='90' src='../../../images/Leave/EL.png' alt='Earned Leave' onclick='show_LeaveDiv("EL_Table","EL","#616161")'  onmouseover='show_Shadow("EL_Div","#E0E0E0")'/></td>
			<td align='center'><input type='image' id='CO_Div' width='130' height='90' src='../../../images/Leave/CO.png' alt='Comp Off' onclick='show_LeaveDiv("CO_Table","CO","#DB9900")' onmouseover='show_Shadow("CO_Div","#FFFFD7")'/></td>
			<td align='center'><input type='image' id='ML_Div' width='130' height='90' src='../../../images/Leave/ML.png' alt='Maternity Leave' onclick='show_LeaveDiv("ML_Table","ML","#087B7B")'  onmouseover='show_Shadow("ML_Div","#E6FCFF")'/></td>
		</tr>
		<?php } 
		else{ ?>
			<tr align='center'>
			<td></td>
			<td align='center'><input type='image' id='CL_Div' width='160' height='90' src='../../../images/Leave/CL.png'  alt='Casual Leave' onclick='show_LeaveDiv("CL_Table","CL","#218429")' onmouseover='show_Shadow("CL_Div","#E3FBE9")' /></td>
			<td align='center'><input type='image' id='SL_Div' width='160' height='90' src='../../../images/Leave/SL.png' alt='Sick Leave' onclick='show_LeaveDiv("SL_Table","SL","#872187")'  onmouseover='show_Shadow("SL_Div","#FFEEFD")'/></td>
			<td align='center'><input type='image' id='EL_Div' width='160' height='90' src='../../../images/Leave/EL.png' alt='Earned Leave' onclick='show_LeaveDiv("EL_Table","EL","#616161")'  onmouseover='show_Shadow("EL_Div","#E0E0E0")'/></td>
			<td align='center'><input type='image' id='CO_Div' width='160' height='90' src='../../../images/Leave/CO.png' alt='Comp Off' onclick='show_LeaveDiv("CO_Table","CO","#DB9900")' onmouseover='show_Shadow("CO_Div","#FFFFD7")'/></td>
		</tr>
		
		<?php 
				}?>
		
	</table>
	
	<table align='center' id='Error' style='display:none;background-color:#FFEAEA;height:30px;box-shadow: 5px 5px 5px #FFC8C8;border:1px inset red;' >
				<tr height='30' style='font-size:11pt;font-weight:bold;color:red;'>
						<td align='left' width='35px'>
								<img width='20px' style='display:inline;'height='20x' src='../../../images/General/alert.png' /> 
						</td>
						<td  align='center' id='Error_Col'  align='center'></td>
				</tr>
	</table>
	
</div>

<div id='CL_Table' style='background-color:#DEF3BD;width:60%;margin:1% 0 0 2%;border:5px groove #BDF4CB;border-radius:5px;' >
		<center><p style='font-size:16pt;font-weight:bolder;color:#218429;'><u>CASUAL LEAVE</u></p></center>
		<?php if(!empty($experience) && $experience>=$experience_CL)
		{?>			
			<table   height='200'   border="0" align="center">
				<tr height='60'>				
					<td   width='10%' class='Font_Style1'></td>
					<td  align='left' width='180'  class='Font_Style1'>Leave From</td>
					<td width='10' class='Font_Style1'>:</td>
					<td>
							<input id='CL_from_date'  readonly='readonly' class='input_date'"/>
							<input type='image' id='Calendar_From_CL' width='50' height='30' src='../../../images/Leave/calendar1.png'/>
					</td>
				</tr>
				<tr height='60'>				
					<td   width='10%' class='Font_Style1'></td>
					<td  align='left' width='180'  class='Font_Style1'>To Date</td>
					<td width='10' class='Font_Style1'>:</td>
					<td>
							<input id='CL_to_date'  readonly='readonly' class='input_date'"/>
							<input type='image' id='Calendar_to_CL' width='50' height='30' src='../../../images/Leave/calendar1.png'/>
					</td>
				</tr>
				<tr height='40' class='Font_Style1'>
					<td   width='10%' ></td>
					<td align='left' >No of Days</td>
					<td   width='10' >:</td>
					<td><input id='CL_days' readonly='readonly' class='input_date' style='width:30px;height:25px;' value=''></td>
				</tr>
				<tr height='30'>
					<td   width='10%' class='Font_Style1'></td>
					<td  align='left' class='Font_Style1'>Reason for Leave</td>
					<td width='10' class='Font_Style1'>:</td>
					<td ><textarea  id='CL_reason' cols='30' rows='4' onblur='remove_Specials("CL_reason",this.value)'></textarea>
						<br><font color='#333300'>* Maximum 200 Characters allowed.</font>
					</td>
				</tr>
				<tr  height='80'>
					<td id='CL_Button'  style='font-size:13pt;color:#339900;font-family:lucida Handwriting' colspan='5' align='center'>
							<input id='apply_img_CL' type='image' src='../../../images/Leave/apply.png'   style='width:100px;height:32px;'  onclick='insert_CasualLeave()' onmouseover='change_OnMouseOver("apply_img_CL","apply_over.png")' onmouseout='change_OnMouseOver("apply_img_CL","apply.png")'/>
					</td>
				</tr>
				<tr height='40'>
					<td></td>
				</tr>
			</table>
			
			<?php }
			else{?>
			<table   height='200'   border="0" >
				<tr height='60'>				
					<td   style='font-size:20pt;font-weight:bolder;color:red;font-family:Lucida Handwriting;'> Sorry..!</td>
				</tr>
				<tr height='60'>
					<td  style='font-size:16pt;font-weight:bolder;color:#003366;font-family:Lucida Calligraphy;'> &nbsp;&nbsp;&nbsp;&nbsp;
										You are not eligible for taking Casual Leave..!
					</td>
				</tr>
				<tr style='font-size:14pt;font-weight:bolder;color:#003366;font-family:Lucida Calligraphy;'>
					<td ><u>Reason may be...</u></td>
				</tr>
				<tr style='font-size:12pt;font-weight:bolder;color:#003366;font-family:Tahoma;'>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;
						Not having <?php echo $experience_CL;?> months of Experience.
					</td>
				</tr>
					<tr style='font-size:12pt;font-weight:bolder;color:#003366;font-family:Tahoma;'>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;
					Have utilized all <?php echo $year_limit_CL ;?> Casual Leaves.</td>
				</tr>
				<tr height='40'>
					<td></td>
				</tr>
			</table>
			<?php }?>
			
</div>




<div id='SL_Table'  style='display:none;background:#DEBDDE;width:60%;margin:1% 0 0 2%;border:5px groove #F4D2F4;border-radius:5px;' >
		<center><p style='font-size:16pt;font-weight:bolder;color:#730063;'><u>SICK LEAVE</u></p></center>
		<?php if(!empty($experience) && $experience>=$experience_CL)
		{?>			
			<table  height='200'  border="0" align="center">
				<tr height='60'>
					<td   width='10%' class='Font_Style1'></td>
					<td  align='left' width='180'  class='Font_Style1'>Leave From</td>
					<td width='10' class='Font_Style1'>:</td>
					<td>
						<input id='SL_from_date'  readonly='readonly' class='input_date'/>
						<input type='image' id='Calendar_From_SL' width='50' height='30' src='../../../images/Leave/calendar1.png'/>
					</td>
				</tr>
				<tr height='60'>
					<td   width='10%' class='Font_Style1'></td>
					<td  align='left' width='180'  class='Font_Style1'>To Date</td>
					<td width='10' class='Font_Style1'>:</td>
					<td>
						<input id='SL_to_date'  readonly='readonly' class='input_date'/>
						<input type='image' id='Calendar_To_SL' width='50' height='30' src='../../../images/Leave/calendar1.png'/>
					</td>
				</tr>
				<tr height='40' class='Font_Style1'>
					<td   width='10%' ></td>
					<td align='left' >No of Days</td>
					<td   width='10' >:</td>
					<td><input id='SL_days' readonly='readonly' class='input_date' style='width:30px;height:25px;' value=''></td>
				</tr>
				<tr id='Doc_Upload_SL' style='display:none' height='40'>
					<td   width='10%' class='Font_Style1'></td>
					<td  align='left' class='Font_Style1'>Proof Documents</td>
					<td width='10' class='Font_Style1'>:</td>
					<td >
						<input type='file' name="fileupload_SL" id="fileupload_SL" onchange="upload_ProofDoc(this.value,'fileupload_SL','SL')" style='color:green;font-size:12pt;font-weight:bold;'/>
						<br><br><font color='#333300'>* File Format: jpg / png / doc / pdf &nbsp;&nbsp; * Max Fize Size: 2 MB</font>
						</td>
				</tr>
			<tr height='30'>
					<td   colspan='3'></td>
					<td style='font-size:13px;color:blue;'>
							<table id='Doc_Table_SL' >
							</table>
					</td>
				</tr>
				<tr height='30'>
					<td   width='10%' class='Font_Style1'></td>
					<td  align='left' class='Font_Style1'>Reason for Leave</td>
					<td width='10' class='Font_Style1'>:</td>
					<td >
						<textarea  id='SL_reason'  cols='30' rows='4' onblur='remove_Specials("SL_reason",this.value)'></textarea>
						<br><font color='#333300'>* Maximum 200 Characters allowed.</font>
					</td>
				</tr>
				<tr height='80'>
					<td  id='SL_Button'   style='font-size:13pt;color:#339900;font-family:lucida Handwriting' colspan='5' align='center'>
							<input id='apply_img_SL' type='image' src='../../../images/Leave/apply_SL.png'   style='width:100px;height:32px;'  onclick='insert_SickLeave()' onmouseover='change_OnMouseOver("apply_img_SL","apply_SL_over.png")' onmouseout='change_OnMouseOver("apply_img_SL","apply_SL.png")'/>
					</td>
				</tr>
				<tr height='50'>
					<td></td>
				</tr>
			</table>
						
	<?php }
	else{?>
			<table   height='200'   border="0" >
				<tr height='60'>				
					<td   style='font-size:20pt;font-weight:bolder;color:red;font-family:Lucida Handwriting;'> Sorry..!</td>
				</tr>
				<tr height='60'>
					<td  style='font-size:16pt;font-weight:bolder;color:#003366;font-family:Lucida Calligraphy;'> &nbsp;&nbsp;&nbsp;&nbsp;
										You are not eligible for taking Sick Leave..!
					</td>
				</tr>
				<tr style='font-size:14pt;font-weight:bolder;color:#003366;font-family:Lucida Calligraphy;'>
					<td ><u>Reason may be...</u></td>
				</tr>
				<tr style='font-size:12pt;font-weight:bolder;color:#003366;font-family:Tahoma;'>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;
						Not having <?php echo $experience_SL;?> months of Experience.
					</td>
				</tr>
					<tr style='font-size:12pt;font-weight:bolder;color:#003366;font-family:Tahoma;'>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;
					Have utilized all <?php echo $year_limit_SL ;?> Sick Leaves.</td>
				</tr>
				<tr height='40'>
					<td></td>
				</tr>
			</table>
	<?php }?>
</div>


<div id='EL_Table'  style='display:none;background:#E0E0E0;width:60%;margin:1% 0 0 2%;border:5px groove #BFBFBF;border-radius:5px;' >
		<center><p style='font-size:16pt;font-weight:bolder;color:#616161;'><u>EARNED LEAVE</u></p></center>
		<?php if(!empty($experience) && $experience>=$experience_EL)
		{?>			
			<table   height='200'  border="0" align="center">
				<tr height='60'>
					<td   width='10%' class='Font_Style1'></td>
					<td  align='left' width='180'  class='Font_Style1'>Leave From</td>
					<td width='10' class='Font_Style1'>:</td>
					<td>
						<input id='EL_from_date'  readonly='readonly' class='input_date'/>
						<input type='image' id='Calendar_From_EL' width='50' height='30' src='../../../images/Leave/calendar1.png'/>
					</td>
				</tr>
				<tr height='60'>
					<td   width='10%' class='Font_Style1'></td>
					<td  align='left' width='180'  class='Font_Style1'>Leave To</td>
					<td width='10' class='Font_Style1'>:</td>
					<td>
						<input id='EL_to_date'  readonly='readonly' class='input_date'/>
						<input type='image' id='Calendar_To_EL'  width='50' height='30' src='../../../images/Leave/calendar1.png'/>
					</td>
				</tr>
				<tr height='30' class='Font_Style1'>
					<td   width='10%' ></td>
					<td align='left' >No of Days</td>
					<td   width='10' >:</td>
					<td><input id='EL_days' readonly='readonly' class='input_date' style='width:30px;height:25px;' value=''></td>
				</tr>
				<tr height='30'>
					<td   width='10%' class='Font_Style1'></td>
					<td  align='left' class='Font_Style1'>Reason for Leave</td>
					<td width='10' class='Font_Style1'>:</td>
					<td ><textarea  id='EL_reason' cols='30' rows='4' onblur='remove_Specials("EL_reason",this.value)'></textarea>
						<br><font color='#333300'>* Maximum 200 Characters allowed.</font>
					</td>
				</tr>
				<tr  height='80'>
					<td id='EL_Button'  style='font-size:13pt;color:#339900;font-family:lucida Handwriting' colspan='5' align='center'>
							<input id='apply_img_EL' type='image' src='../../../images/Leave/apply_EL.png'   style='width:100px;height:32px;'  onclick='insert_EarnedLeave()' onmouseover='change_OnMouseOver("apply_img_EL","apply_EL_over.png")' onmouseout='change_OnMouseOver("apply_img_EL","apply_EL.png")'/>
					</td>
				</tr>
				<tr height='50'>
					<td></td>
				</tr>
			</table>
			
			<?php }
			else{?>
			<table   height='200'   border="0" >
				<tr height='60'>				
					<td   style='font-size:20pt;font-weight:bolder;color:red;font-family:Lucida Handwriting;'> Sorry..!</td>
				</tr>
				<tr height='60'>
					<td  style='font-size:16pt;font-weight:bolder;color:#003366;font-family:Lucida Calligraphy;'> &nbsp;&nbsp;&nbsp;&nbsp;
										You are not eligible for taking Earned Leave..!
					</td>
				</tr>
				<tr style='font-size:14pt;font-weight:bolder;color:#003366;font-family:Lucida Calligraphy;'>
					<td ><u>Reason may be...</u></td>
				</tr>
				<tr style='font-size:12pt;font-weight:bolder;color:#003366;font-family:Tahoma;'>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;
						Not having <?php echo $experience_EL;?> months of Experience.
					</td>
				</tr>
				<tr height='40'>
					<td></td>
				</tr>
			</table>
			<?php }?>
</div>


<div id='CO_Table'  style='display:none;background:#EFE8AD;width:60%;margin:1% 0 0 2%;border:5px groove #FFF9CE;border-radius:5px;' >
		<center><p style='font-size:16pt;font-weight:bolder;color:#AD9410;'><u>COMPENSATORY LEAVE</u></p></center>
		<?php if(!empty($experience) && $experience>=$experience_CO)
		{?>			
			<table   height='200'  border="0" align="center">
				<tr height='60'>
					<td   width='10%' class='Font_Style1'></td>
					<td  align='left' width='180'  class='Font_Style1'>Leave From</td>
					<td width='10' class='Font_Style1'>:</td>
					<td>
						<input id='CO_from_date'  readonly='readonly' class='input_date'/>
						<input type='image' id='Calendar_From_CO' width='50' height='30' src='../../../images/Leave/calendar1.png'/>
					</td>
				</tr>
				<tr height='60'>
					<td   width='10%' class='Font_Style1'></td>
					<td  align='left' width='180'  class='Font_Style1'>Leave To</td>
					<td width='10' class='Font_Style1'>:</td>
					<td>
						<input id='CO_to_date'  readonly='readonly' class='input_date'/>
						<input type='image' id='Calendar_To_CO' width='50' height='30' src='../../../images/Leave/calendar1.png'/>
					</td>
				</tr>
				<tr height='30' class='Font_Style1'>
					<td   width='10%' ></td>
					<td align='left' >No of Days</td>
					<td   width='10' >:</td>
					<td><input id='CO_days' readonly='readonly' class='input_date' style='width:30px;height:25px;' value=''></td>
				</tr>
				<tr height='30'>
					<td   width='10%' class='Font_Style1'></td>
					<td  align='left' class='Font_Style1'>Reason for Leave</td>
					<td width='10' class='Font_Style1'>:</td>
					<td ><textarea  id='CO_reason' cols='30' rows='4' onblur='remove_Specials("CO_reason",this.value)'></textarea>
						<br><font color='#333300'>* Maximum 200 Characters allowed.</font>
					</td>
				</tr>
				<tr  height='80'>
					<td id='CO_Button'  style='font-size:13pt;color:#339900;font-family:lucida Handwriting' colspan='5' align='center'>
							<input id='apply_img_CO' type='image' src='../../../images/Leave/apply_CO.png'   style='width:100px;height:32px;'  onclick='insert_CompOff()' onmouseover='change_OnMouseOver("apply_img_CO","apply_CO_over.png")' onmouseout='change_OnMouseOver("apply_img_CO","apply_CO.png")'/>
					</td>
				</tr>
				<tr height='50'>
					<td></td>
				</tr>
			</table>
			
	<?php }
	else{?>
			<table   height='200'   border="0" >
				<tr height='60'>				
					<td   style='font-size:20pt;font-weight:bolder;color:red;font-family:Lucida Handwriting;'> Sorry..!</td>
				</tr>
				<tr height='60'>
					<td  style='font-size:16pt;font-weight:bolder;color:#003366;font-family:Lucida Calligraphy;'> &nbsp;&nbsp;&nbsp;&nbsp;
										You are not eligible for taking Compensatory Leave..!
					</td>
				</tr>
				<tr style='font-size:14pt;font-weight:bolder;color:#003366;font-family:Lucida Calligraphy;'>
					<td ><u>Reason may be...</u></td>
				</tr>
				<tr style='font-size:12pt;font-weight:bolder;color:#003366;font-family:Tahoma;'>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;
						Not having <?php echo $experience_CO;?> months of Experience.
					</td>
				</tr>
					<tr style='font-size:12pt;font-weight:bolder;color:#003366;font-family:Tahoma;'>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;
					Have utilized all <?php echo $year_limit_CO ;?> Compensatory Leaves.</td>
				</tr>
				<tr height='40'>
					<td></td>
				</tr>
			</table>
	<?php }?>
</div>


<div id='ML_Table'  style='display:none;background:#C6E7DE;width:60%;margin:1% 0 0 2%;border:5px groove #ACF3FD;border-radius:5px;' >
		<center><p style='font-size:16pt;font-weight:bolder;color:#087B7B;'><u>MATERNITY LEAVE</u></p></center>
		<?php if(!empty($experience) && $experience>=$experience_ML)
		{?>			
			<table  height='200'  border="0" align="center">
				<tr height='60'>
					<td   width='10%' class='Font_Style1'></td>
					<td  align='left' width='180'  class='Font_Style1'>Leave From</td>
					<td width='10' class='Font_Style1'>:</td>
					<td>
						<input id='ML_from_date'  readonly='readonly' class='input_date'/>
						<input type='image' id='Calendar_From_ML' width='50' height='30' src='../../../images/Leave/calendar1.png'/>
					</td>
				</tr>
				<tr height='60'>
					<td   width='10%' class='Font_Style1'></td>
					<td  align='left' width='180'  class='Font_Style1'>To Date</td>
					<td width='10' class='Font_Style1'>:</td>
					<td>
						<input id='ML_to_date'  readonly='readonly' class='input_date'/>
						<input type='image' id='Calendar_To_ML' width='50' height='30' src='../../../images/Leave/calendar1.png'/>
					</td>
				</tr>
				<tr height='45' class='Font_Style1'>
					<td   width='10%' ></td>
					<td align='left' >No of Days</td>
					<td   width='10' >:</td>
					<td><input id='ML_days' readonly='readonly' class='input_date' style='width:30px;height:25px;' value=''></td>
				</tr>				
				<tr id='Doc_Upload_ML' style='display:none' height='45'>
					<td   width='10%' class='Font_Style1'></td>
					<td  align='left' class='Font_Style1'>Proof Documents</td>
					<td width='10' class='Font_Style1'>:</td>
					<td >
						<input type='file' name="fileupload_ML" id="fileupload_ML" onchange="upload_ProofDoc(this.value,'fileupload_ML','ML')" style='color:green;font-size:12pt;font-weight:bold;'/>
						<br><br><font color='#333300'>* File Format: jpg / png / doc / pdf &nbsp;&nbsp; * Max Fize Size: 2 MB</font>
						</td>
				</tr>
			<tr height='30'>
					<td   colspan='3'></td>
							<td style='font-size:13px;color:blue;'>
							<table id='Doc_Table_ML'>
							</table>
					</td>
				</tr>
				<tr height='30'>
					<td   width='10%' class='Font_Style1'></td>
					<td  align='left' class='Font_Style1'>Reason for Leave</td>
					<td width='10' class='Font_Style1'>:</td>
					<td ><textarea  id='ML_reason' cols='30' rows='4' onblur='remove_Specials("ML_reason",this.value)'></textarea>
						<br><font color='#333300'>* Maximum 200 Characters allowed.</font>
					</td>
				</tr>
				<tr  height='80'>
					<td id='ML_Button' colspan='5'  style='font-size:13pt;color:#339900;font-family:lucida Handwriting'  align='center'>
							<input  id='apply_img_ML' type='image' src='../../../images/Leave/apply_ML.png'   style='width:100px;height:32px;'  onclick='insert_MaternityLeave()' onmouseover='change_OnMouseOver("apply_img_ML","apply_ML_over.png")' onmouseout='change_OnMouseOver("apply_img_ML","apply_ML.png")'/>
					</td>
				</tr>
				<tr height='50'>
					<td></td>
				</tr>
			</table>
						
	<?php }
	else{?>
			<table   height='200'   border="0" >
				<tr height='60'>				
					<td   style='font-size:20pt;font-weight:bolder;color:red;font-family:Lucida Handwriting;'> Sorry..!</td>
				</tr>
				<tr height='60'>
					<td  style='font-size:16pt;font-weight:bolder;color:#003366;font-family:Lucida Calligraphy;'> &nbsp;&nbsp;&nbsp;&nbsp;
										You are not eligible for taking Maternity Leave..!
					</td>
				</tr>
				<tr style='font-size:14pt;font-weight:bolder;color:#003366;font-family:Lucida Calligraphy;'>
					<td ><u>Reason may be...</u></td>
				</tr>
				<tr style='font-size:12pt;font-weight:bolder;color:#003366;font-family:Tahoma;'>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;
						Not having <?php echo $experience_ML;?> months of Experience.
					</td>
				</tr>
					<tr style='font-size:12pt;font-weight:bolder;color:#003366;font-family:Tahoma;'>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;
					Have utilized all <?php echo $year_limit_ML ;?> Maternity Leaves.</td>
				</tr>
				<tr style='font-size:12pt;font-weight:bolder;color:#003366;font-family:Tahoma;'>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;
					Have utilized all <?php echo $chances_ML ;?> chances of Maternity Leaves.</td>
				</tr>
				<tr height='40'>
					<td></td>
				</tr>
			</table>
	<?php }?>
			
</div>

<input type='hidden'  id='Current_Table' value='CL_Table' >

<script	type="text/javascript" src="<?php echo base_url(); ?>js/Leave/apply.js"></script>
<script	type="text/javascript"	src="<?php echo base_url(); ?>js/Leave/ajaxfileupload.js"></script>
