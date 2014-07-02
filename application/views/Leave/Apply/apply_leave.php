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
			<td align='center'><img width='150' height='100' src='../../../images/Leave/CL.png'  alt='Casual Leave' onclick='show_LeaveDiv("CL")'/></td>
			<td align='center'><img width='150' height='100' src='../../../images/Leave/SL.png' alt='Sick Leave' onclick='show_LeaveDiv("SL")'/></td>
			<td align='center'><img width='150' height='100' src='../../../images/Leave/EL.png' alt='Earned Leave' onclick='show_LeaveDiv("EL")'/></td>
			<td align='center'><img width='150' height='100' src='../../../images/Leave/CO.png' alt='Comp Off' onclick='show_LeaveDiv("CO")'/></td>
		</tr>
	</table>


			<table style="width: 70%" border="0" align="center">
			<tr>
				<td id="error" align="center" colspan="2"
					style="color: red; width: 250px; font-size: 15px; font-weight: bolder;">
				</td>
			</tr>
			<tr>
				<td id="error1" align="center" colspan="2"
					style="color: red; width: 250px; font-size: 15px; font-weight: bolder;">
				</td>
			</tr>
			<tr>
				<td align="right"><font class="font_align">Name</font></td>
				<td><input name="tech_name" id="tech_name" type="text"
					style="width: 150px; height: 18px; font-size: 15px; font-weight: bolder"
					placeholder="Name of Technician " value="" /></td>
			</tr>

			<tr>
				<td width='40%' align="right"><font class="font_align">Leave Type</font>
				</td>
				<td><select name="leave_type" id="leave_type"
					style="height: 25px; width: 120px;" onchange="hide_doc()">
						<option value="Casual Leave">Casual Leave</option>
						<option value="Paid Leave">Paid Leave</option>
						<option value="Sick Leave">Sick Leave</option>
						<option value="Comp-Off">Comp-Off</option>
				</select>
				</td>
			</tr>
			<tr>
				<td align="right"><font class="font_align">From</font></td>
				<td><input name="date_from" class="input" id="date_from" type="text"
					style="width: 80px; height: 18px;" " onchange="calculate_days()" />
					<select name="am_pm1" id="am_pm1"
					style="height: 25px; width: 60px;">
						<option value="AM">AM</option>
						<option value="PM">PM</option>
				</select>
				</td>
			</tr>
			<tr>
				<td align="right"><font class="font_align">To</font></td>
				<td><input name="date_to" class="input" id="date_to" type="text"
					style="width: 80px; height: 18px;" " onchange="calculate_days()" />
					<select name="am_pm2" id="am_pm2"
					style="height: 25px; width: 60px;">
						<option value="PM">PM</option>
						<option value="AM">AM</option>
				</select>
				</td>
			</tr>
			<tr>
				<td align="right"><font class="font_align">No of Days</font></td>
				<td><input name="no_of_days" class="input" id="no_of_days"
					type="text" readonly="readonly" style="width: 50px; height: 18px;" " />
				</td>
			</tr>

			<tr id="Lev1Off">
				<td align="right"><font class="font_align">Level-1 Approver</font></td>
				<td align="left"><select name="approval_officer" class="input"
					id="approval_officer" style="height: 25px; width: 120px;">
						<option value="MD">MD</option>
						<option value="Admin">Admin</option>
				</select>
				</td>
			</tr>
			<tr>
				<td align="right"><font class="font_align">Level-2 Approver</font></td>
				<td align="left"><select name="approval_officer2" class="input"
					id="approval_officer2" style="width: 120px; height: 25px;">
						<option value="MD">MD</option>
						<option value="Admin">Admin</option>
				</select>
				</td>
			</tr>
			<tr>
				<td align="right"><font class="font_align">Reason</font></td>
				<td align="left" width=""><textarea name="reason" id="reason"
						rows="3" cols="100" class="txtarea"></textarea></td>
			</tr>
			<tr style="display: none" id="doc_row1">
				<td align="right"><font class="font_align">Upload Document</font></td>
				<td align="left" width=""><input type="file" name="fileupload"
					id='fileupload' />
				</td>
			</tr>
			<tr>
				<td id="success" align="center" colspan="2"
					style="color: green; width: 250px; font-size: 15px; font-weight: bolder;"></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><img id='apply_image' width='150' height='35' src="../../../images/Leave/apply.png"	onmouseover='change_OnMouseOver("apply_image","apply_over.png")'        onmouseout='change_OnMouseOver("apply_image","apply.png")'  	onclick="javascript:insert_other_application();"></td>
			</tr>

		</table>
	
</div>


<script	type="text/javascript" src="<?php echo base_url(); ?>js/Leave/apply.js"></script>
<script	type="text/javascript"	src="<?php echo base_url(); ?>js/Leave/ajaxfileupload.js"></script>
