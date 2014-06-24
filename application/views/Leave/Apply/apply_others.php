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
		Leave for Technicians</center>
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
				<td colspan="2" align="center"><input style="width: 90px"
					class="button" value="APPLY" id="button" type="button"
					onclick="javascript:insert_other_application();"></td>
			</tr>

		</table>
	</div>

	<div
		style="float: right; width: 15%; background: #CEF6F5; margin: 20px 190px 0px 20px; border: 0px solid black">

		<table border="3" align="left" bgcolor="99CC66" cellpadding="2"
			cellspacing="0">
			<tr>
				<td bgcolor="white" align="center"
					style="font-size: 12pt; font-weight: bolder; color: red">
					Technicians</td>
			</tr>

			<?php
			foreach($technicians as $openrow) {
				print("<tr><td align='center' ><input align='left' class='input'  type='button'' onclick='javascript:set_name(this.value)' style='width:130px;height:18px;' value='");
				echo	$openrow["tech_name"];
				print("' /></td></tr>");
					}
				?>

		</table>
		<input type="hidden" value="" id="leavID" />

	</div>
</form>



<script
	type="text/javascript" src="<?php echo base_url(); ?>js/custom/lms.js"></script>
<script
	type="text/javascript"
	src="<?php echo base_url(); ?>js/custom/ajaxfileupload.js"></script>

