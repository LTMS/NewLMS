<div style="height: 70px; background: #8AC5D3;">
	<p style="margin-left: 80%; padding-top: 5px; line-height: 0.5em;">
		User: <b><?php echo $this->session->userdata('fullname');?>
		</b>&nbsp;&nbsp;<img src="../../images/rightarrow1.png" width="10px"
			height="10px;" />&nbsp;&nbsp;&nbsp;<strong> <a
			href="<?php echo site_url("logincheck/logout"); ?>"
			style="color: black;" onmouseover="this.style.color='blue'"
			onmouseout="this.style.color='black'">Logout</a>
		</strong>
	</p>
	<center style="margin-bottom: 20px; font-size: 20pt; position: inline;">Apply
		Leave For Me</center>
</div>

<form name="application_form" id="application_form" method="post">
	<div
		style="float: left; height: auto; background: #C0F7FE; margin: 20px 0px 0px 50px; width: 60%; border: 0px solid black; border-radius: 0px;">
		<p style="height: 40px; padding: 20px 0px 0px 20px;" align="center">
			<span style="font-weight: bolder; font-size: 18pt;">Leave Application
				Form </span>
		</p>
		<hr width="100%">

		<input type="hidden" name="count" id="count" value="0" />
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
				<td width='40%' align="right"><font class="font_align">Leave Type</font>
				</td>
				<td><select name="leave_type" id="leave_type"
					style="height: 25px; width: 120px;" onchange="hide_doc()">
						<option value="Casual Leave">Casual Leave</option>
						<option value="Paid Leave">Paid Leave</option>
						<option value="Sick Leave">Sick Leave</option>
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
			<?php
			foreach($approv as $openrow) {
				$App_Off=$openrow["LeaveApprover_L1"];

			}?>

			<tr id="Lev1Off">
				<td align="right"><font class="font_align">Level-1 Approver</font></td>
				<td align="left"><input name="approval_officer" align="left"
					class="input" id="approval_officer" readonly="readonly" type="text"
					style="width: 200px; height: 18px;"
					value="	<?php	echo $App_Off;		?>" /></td>
			</tr>
			<tr>
				<td align="right"><font class="font_align">Level-2 Approver</font></td>
				<td align="left"><input name="approval_officer2" align="left"
					class="input" id="approval_officer2" readonly="readonly"
					type="text" style="width: 130px; height: 18px;" value="	MD" /></td>
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
				<td colspan="2" align="center"><input style="width: 90px"
					class="button" value="APPLY" id="button" type="button"
					onclick="javascript:insert_application_data();"></td>
			</tr>

		</table>
	</div>
	<div
		style="float: right; width: 20%; background: #CEF6F5; margin: 20px 120px 0px 20px; border: 0px solid black">
		<?php
		$casual=$paid=$sick=$casual_y=$paid_y=$sick_y=$casual_p=$paid_p=$sick_p=0;
		foreach($summary as $openrow) {
			if($openrow["LeaveType"]=='Casual Leave'){
				$casual=$openrow["TotalDays"];
			}
			if($openrow["LeaveType"]=='Paid Leave'){
				$paid=$openrow["TotalDays"];
			}
			if($openrow["LeaveType"]=='Sick Leave'){
				$sick=$openrow["TotalDays"];
			}
		}
			
		foreach($summary_year as $openrow) {
			if($openrow["LeaveType"]=='Casual Leave'){
				$casual_y=$openrow["TotalDays"];
			}
			if($openrow["LeaveType"]=='Paid Leave'){
				$paid_y=$openrow["TotalDays"];
			}
			if($openrow["LeaveType"]=='Sick Leave'){
				$sick_y=$openrow["TotalDays"];
			}
		}
			
		foreach($summary_pend as $openrow) {
			if($openrow["LeaveType"]=='Casual Leave'){
				$casual_p=$openrow["TotalDays"];
			}
			if($openrow["LeaveType"]=='Paid Leave'){
				$paid_p=$openrow["TotalDays"];
			}
			if($openrow["LeaveType"]=='Sick Leave'){
				$sick_p=$openrow["TotalDays"];
			}
		}
		?>

		<table border="1" align="left" bgcolor="99CC66"
			style="font-size: 8pt; font-weight: bolder">
			<tr>
				<td bgcolor="white" colspan="4" align="center"
					style="font-size: 10pt; font-weight: bolder">Leave Summary in Days</td>
			</tr>
			<tr>
				<td style="font-size: 9pt; font-weight: bolder; color: white"
					align="center">Leave Type</td>
				<td style="font-size: 9pt; font-weight: bolder; color: white"
					align="center">Pending</td>
				<td style="font-size: 9pt; font-weight: bolder; color: white"
					align="center">This Month</td>
				<td style="font-size: 9pt; font-weight: bolder; color: white"
					align="center">This Year</td>
			</tr>
			<tr>
				<td align="center">Casual Leave</td>
				<td align="center" id="clp"><?php 	echo  $casual_p;	?>
				</td>
				<td align="center" id="cl"><?php 	echo  $casual;	?>
				</td>
				<td align="center" id="cly"><?php 	echo  $casual_y;	?>
				</td>
			</tr>
			<tr>
				<td align="center">Paid Leave</td>
				<td align="center" id="plp"><?php 	echo  $paid_p;		?>
				</td>
				<td align="center" id="pl"><?php 	echo  $paid;		?>
				</td>
				<td align="center" id="ply"><?php 	echo  $paid_y;	?>
				</td>
			</tr>
			<tr>
				<td align="center">Sick Leave</td>
				<td align="center" id="slp"><?php	echo $sick_p;		?>
				</td>
				<td align="center" id="sl"><?php	echo $sick;		?>
				</td>
				<td align="center" id="sly"><?php 	echo  $sick_y;	?>
				</td>
			</tr>
		</table>
	</div>
</form>
		<?php
		foreach($doj as $openrow) {
			$DOJ=$openrow["JoiningDate"];
		}?>

<input
	type="hidden" value="<?php	echo $DOJ		?>" id="DOJ" />
<input type="hidden" value=""
	id="Diff" />
<input type="hidden"
	value="" id="leavecheck" />
<input type="hidden" value=""
	id="prior" />
<input type="hidden"
	value="" id="leavID" />


<script
	type="text/javascript" src="<?php echo base_url(); ?>js/custom/lms.js"></script>
<script
	type="text/javascript"
	src="<?php echo base_url(); ?>js/custom/ajaxfileupload.js"></script>
