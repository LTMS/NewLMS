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
<div style='width:60%;margin:1% 0 0 20%'>
	<table id='Leave_List' >
		<tr>
			<td align='center'><input type='image' id='CL_Div' width='150' height='100' src='../../../images/Leave/CL.png'  alt='Casual Leave' onclick='show_LeaveDiv("CL_Table")'/></td>
			<td align='center'><input type='image' id='CL_Div' width='150' height='100' src='../../../images/Leave/SL.png' alt='Sick Leave' onclick='show_LeaveDiv("SL_Table")'/></td>
			<td align='center'><input type='image' id='CL_Div' width='150' height='100' src='../../../images/Leave/EL.png' alt='Earned Leave' onclick='show_LeaveDiv("EL_Table")'/></td>
			<td align='center'><input type='image' id='CL_Div' width='150' height='100' src='../../../images/Leave/CO.png' alt='Comp Off' onclick='show_LeaveDiv("CO_Table")'/></td>
		</tr>
	</table>
	<table id='Error' style='display:none;background-color:#FFEAEA;width:100%;height:30px;box-shadow: 5px 5px 5px #FFC8C8;border:1px inset red;' >
				<tr  height='30' style='font-size:11pt;font-weight:bold;color:red;'>
						<td align='left' width='35px'><img width='20px' style='display:inline;'height='20x' src='../../../images/General/alert.png' /> </td>
						<td  align='center' id='Error_Col'  align='center'> Hi..!</td>
				</tr>
	</table>
	
</div>

<div id='CL_Table' style='background-color:#E3FBE9;width:60%;margin:1% 0 0 20%;border:5px groove #BDF4CB;border-radius:5px;' >
		<center><p style='font-size:14pt;font-weight:bolder;color:#218429;'><u>CASUAL LEAVE</u></p></center>
			
			<table   height='200'   border="0" align="center">
				<tr height='60'>				
					<td   width='10%' class='Font_Style1'></td>
					<td  align='left' width='180'  class='Font_Style1'>Leave On</td>
					<td width='10' class='Font_Style1'>:</td>
					<td>
							<input id='CL_from_date'  readonly='readonly' class='input_date' onchange="alert(this.value)"/>
							<input type='image' id='Calendar_From_CL' width='50' height='30' src='../../../images/Leave/calendar1.png'/>
					</td>
				</tr>
				<tr height='30' class='Font_Style1'>
					<td   width='10%' ></td>
					<td align='left' >No of Days</td>
					<td   width='10' >:</td>
					<td><input id='CL_days' readonly='readonly' class='input_date' style='width:20px;height:25px;' value='1'></td>
				</tr>
				<tr height='30'>
					<td   width='10%' class='Font_Style1'></td>
					<td  align='left' class='Font_Style1'>Reason for Leave</td>
					<td width='10' class='Font_Style1'>:</td>
					<td ><textarea  id='CL_reason' cols='30' rows='4' onblur='remove_Specials("CL_reason",this.value)'></textarea></td>
				</tr>
				<tr id='CL_Button' height='80'>
					<td colspan='5' align='center'>
							<input id='apply_img1' type='image' src='../../../images/Leave/apply.png'   style='width:100px;height:32px;'  onclick='insert_CasualLeave()' onmouseover='change_OnMouseOver("apply_img1","apply_over.png")' onmouseout='change_OnMouseOver("apply_img1","apply.png")'/>
					</td>
				</tr>
				<tr height='50'>
					<td></td>
				</tr>
			</table>
</div>
<div id='SL_Table'  style='display:none;background:#FFEEFD;width:60%;margin:1% 0 0 20%;border:5px groove #F4D2F4;border-radius:5px;' >
		<center><p style='font-size:14pt;font-weight:bolder;color:#730063;'><u>SICK LEAVE</u></p></center>
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
					<td><input id='SL_days' readonly='readonly' class='input_date' style='width:20px;height:25px;' value=''></td>
				</tr>
				<tr height='40'>
					<td   width='10%' class='Font_Style1'></td>
					<td  align='left' class='Font_Style1'>Proof Documents</td>
					<td width='10' class='Font_Style1'>:</td>
					<td >
						<input type='file' name="fileupload" id="fileupload" onchange="upload_ProofDoc(this.value,'CL')" style='color:green;font-size:12pt;font-weight:bold;'/>
						</td>
				</tr>
			<tr height='30'>
					<td   colspan='3'></td>
					<td style='font-size:11px;color:blue;'>
							<table>
								<tr id='selected1' style='display:none'>
										<td width='20'><input alt='Remove' type='image' width='15' height='15' src="../../../images/General/remove.png" onclick="delete_file1()"></td>
										<td id="selected_file1"> kfgdfg.png</td>
								</tr>
								<tr id='selected2' style='display:none'>
										<td width='20'><input alt='Remove' type='image' width='15' height='15' src="../../../images/General/remove.png" onclick="delete_file1()"></td>
										<td id="selected_file2"> kfgdfg.png</td>
								</tr>
								<tr id='selected3' style='display:none'>
										<td width='20'><input alt='Remove' type='image' width='15' height='15' src="../../../images/General/remove.png" onclick="delete_file1()"></td>
										<td id="selected_file3"> kfgdfg.png</td>
								</tr>
							</table>
					</td>
				</tr>
				<tr height='30'>
					<td   width='10%' class='Font_Style1'></td>
					<td  align='left' class='Font_Style1'>Reason for Leave</td>
					<td width='10' class='Font_Style1'>:</td>
					<td ><textarea  id='SL_reason' cols='30' rows='4' onblur='remove_Specials("SL_reason",this.value)'></textarea></td>
				</tr>
				<tr id='SL_Button' height='80'>
					<td colspan='5' align='center'>
							<input id='apply_img2' type='image' src='../../../images/Leave/apply_SL.png'   style='width:100px;height:32px;'  onclick='insert_SickLeave()' onmouseover='change_OnMouseOver("apply_img2","apply_SL_over.png")' onmouseout='change_OnMouseOver("apply_img2","apply_SL.png")'/>
					</td>
				</tr>
				<tr height='50'>
					<td></td>
				</tr>
			</table>
</div>


<div id='EL_Table'  style='display:none;background:#E0E0E0;width:60%;margin:1% 0 0 20%;border:5px groove #BFBFBF;border-radius:5px;' >
		<center><p style='font-size:14pt;font-weight:bolder;color:#616161;'><u>EARNED LEAVE</u></p></center>
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
					<td><input id='EL_days' readonly='readonly' class='input_date' style='width:20px;height:25px;' value=''></td>
				</tr>
				<tr height='30'>
					<td   width='10%' class='Font_Style1'></td>
					<td  align='left' class='Font_Style1'>Reason for Leave</td>
					<td width='10' class='Font_Style1'>:</td>
					<td ><textarea  id='EL_reason' cols='30' rows='4' onblur='remove_Specials("EL_reason",this.value)'></textarea></td>
				</tr>
				<tr id='EL_Button' height='80'>
					<td colspan='5' align='center'>
							<input id='apply_img3' type='image' src='../../../images/Leave/apply_EL.png'   style='width:100px;height:32px;'  onclick='insert_EarnedLeave()' onmouseover='change_OnMouseOver("apply_img3","apply_EL_over.png")' onmouseout='change_OnMouseOver("apply_img3","apply_EL.png")'/>
					</td>
				</tr>
				<tr height='50'>
					<td></td>
				</tr>
			</table>
</div>


<div id='CO_Table'  style='display:none;background:#FFFFD7;width:60%;margin:1% 0 0 20%;border:5px groove #FFF9CE;border-radius:5px;' >
		<center><p style='font-size:14pt;font-weight:bolder;color:#AD9410;'><u>COMPENSATORY LEAVE</u></p></center>
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
					<td><input id='CO_days' readonly='readonly' class='input_date' style='width:20px;height:25px;' value=''></td>
				</tr>
				<tr height='30'>
					<td   width='10%' class='Font_Style1'></td>
					<td  align='left' class='Font_Style1'>Reason for Leave</td>
					<td width='10' class='Font_Style1'>:</td>
					<td ><textarea  id='CO_reason' cols='30' rows='4' onblur='remove_Specials("CO_reason",this.value)'></textarea></td>
				</tr>
				<tr id='CO_Button' height='80'>
					<td colspan='5' align='center'>
							<input id='apply_img4' type='image' src='../../../images/Leave/apply_CO.png'   style='width:100px;height:32px;'  onclick='insert_CompOff()' onmouseover='change_OnMouseOver("apply_img4","apply_CO_over.png")' onmouseout='change_OnMouseOver("apply_img4","apply_CO.png")'/>
					</td>
				</tr>
				<tr height='50'>
					<td></td>
				</tr>
			</table>
</div>

<input type='hidden'  id='Current_Table' value='CL_Table' >

<script	type="text/javascript" src="<?php echo base_url(); ?>js/Leave/apply.js"></script>
<script	type="text/javascript"	src="<?php echo base_url(); ?>js/Leave/ajaxfileupload.js"></script>
