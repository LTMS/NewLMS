
<div style="height: 70px; background: #59955C;">
	<table>
		<tr>
			<td width="50" align='left'><img style="width: 100px; height: 50px"
				src="<?php echo base_url(); ?>/images/leavehistory.png">
			</td>
			<td align='left'
				style="margin-bottom: 20px; font-size: 21pt; position: inline; color: white; font-weight: bolder">Apply
				Leave</td>
			<td style="color: white; font-size: 15pt" align="right">Hi, <b><?php echo $this->session->userdata('Emp_Number');?>
			</b> ..!</td>
			<td align="left" style="color: white; font-size: 15pt; width: 50px">
				<a href="<?php echo site_url("logincheck/logout"); ?>"><img
					style="width: 50px; height: 50px"
					src="<?php echo base_url(); ?>/images/logout2.png">
			</a></td>
		</tr>
	</table>
</div>


<div
	style="height: auto; overflow: hidden; background: #DBEADC; margin: 5px 0px 0px 0px; width: 100%; border: 1px solid black; border-radius: 10px;">
	<table width="100%" border="0" align="left" cellpadding="2"
		style="height: 40px;">
		<tr class="tab_header_bg" height='60px' align='center'>
			<td align="center" colspan="10"><select id='year'
				style="height: 20px; width: 70px; color: green; font-weight: bolder; font-size: 12px;"
				onchange="admin_leavehistory_general();">
					<option selected value="">Year</option>
					<?php
					foreach($years as $row ){
						$yr=$row["year"];
						echo '<option style="font-size:12px" value="'.$yr.'">'.$yr.'</option>';
					}
					?>

			</select> &nbsp;&nbsp; <select id="month"
				style="height: 20px; width: 100px; color: blue; font-weight: bold; font-size: 12px;"
				onchange="admin_leavehistory_general();">
					<option value="All">All Months</option>
					<option value="January">January</option>
					<option value="February">February</option>
					<option value="March">March</option>
					<option value="April">April</option>
					<option value="May">May</option>
					<option value="June">June</option>
					<option value="July">July</option>
					<option value="August">August</option>
					<option value="September">September</option>
					<option value="October">October</option>
					<option value="November">November</option>
					<option value="December">December</option>
			</select>&nbsp;&nbsp;&nbsp;&nbsp; <select id='emp'
				style="height: 20px; width: 150px; color: brown; font-weight: bolder; font-size: 12px;"
				onchange="admin_leavehistory_general();">
					<option selected value="">Select Employee</option>
					<?php
					foreach($members as $memb ){
						$emp=$memb["Name"];
						echo '<option style="font-size:12px" value="'.$emp.'">'.$emp.'</option>';
					}
					?>

			</select> &nbsp;&nbsp; <select id='leave'
				style="height: 20px; width: 120px; color: #0099CC; font-weight: bolder; font-size: 12px;"
				onchange="admin_leavehistory_general();">
					<option selected value="All">All Leaves</option>
					<?php
					foreach($leavelist as $leave1 ){
						$leave=$leave1["LeaveType"];
						echo '<option style="font-size:12px" value="'.$leave.'">'.$leave.'</option>';
					}
					?>

			</select> &nbsp;&nbsp;<font size='5pt' color='gray'> || </font>
				&nbsp; <font color='green'> Approved History </font> &nbsp; <select
				id='year1'
				style="height: 20px; width: 70px; color: green; font-weight: bolder; font-size: 12px;"
				onchange="admin_leavehistory_approved()">
					<option selected value="">Year</option>
					<?php
					foreach($years as $row3 ){
						$yr1=$row3["year"];
						echo '<option style="font-size:12px" value="'.$yr1.'">'.$yr1.'</option>';
					}
					?>
			</select> &nbsp;&nbsp; <select id='emp_appr'
				style="height: 20px; width: 150px; color: red; font-weight: bolder; font-size: 12px;"
				onchange="admin_leavehistory_approved()">
					<option selected value="All">All Employees</option>
					<?php
					foreach($members as $memb1 ){
						$emp1=$memb1["Name"];
						echo '<option style="font-size:12px" value="'.$emp1.'">'.$emp1.'</option>';
					}
					?>

			</select> &nbsp;&nbsp; <!-- 
		<select  id='dept'  style="height:22px;width:130px;color:RED;font-weight:bolder;font-size:12px;" onchange="get_leavehistory_admin(2);"> 
			<option value="">All Department</option>
				 <?php
						foreach($deptlist as $dept ){
							$desc=$dept["department"];
							echo '<option value="'.$desc.'">'.$desc.'</option>'; 
						}
				?>	
		</select>&nbsp;&nbsp;
	
		<select  id='team'  style="height:22px;width:180px;color:blue;font-weight:bolder;font-size:12px;" onchange="get_leavehistory_admin(3);">  
			<option value="">Select a Team</option>
				 <?php
						foreach($teamlist as $team ){
							$desc1=$team["EmployeeName"];
							echo '<option value="'.$desc1.'">'.$desc1.'</option>'; 
						}
				?>	
		</select> &nbsp;&nbsp;
		 --> <img valign="bottom"
				src="<?php echo base_url(); ?>/images/print2.png"
				onclick="javascript:printLeaveHistory();"
				style="width: 70px; height: 40px; color: green" /> &nbsp;&nbsp; <img
				id='AllEmp_leave_history_dwnld' valign="bottom"
				src="<?php echo base_url(); ?>/images/excel2.png" onclick=""
				style="width: 70px; height: 40px; color: green; display: none;" />
			</td>
		</tr>
		<tr style="display: none" id="errorrow">
			<td id="error" align="center" colspan="10"
				style="color: red; width: 250px; font-size: 15px; font-weight: bolder;">
			</td>
		</tr>

	</table>
	<hr width="100%">
	<div id="contentData" style="height: 640px; overflow: scroll;"></div>
</div>
<input type="hidden"
	id="report_option" value="" />
<script
	type="text/javascript" src="<?php echo base_url(); ?>js/custom/lms.js"></script>
<script
	type="text/javascript"
	src="<?php echo base_url(); ?>js/custom/print.js"></script>
