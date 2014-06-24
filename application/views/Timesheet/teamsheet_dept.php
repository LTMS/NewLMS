
<div style="height: 70px; background: #59955C;">
	<table>
		<tr>
			<td width="50" align='left'><img style="width: 110px; height: 70px"
				src="<?php echo base_url(); ?>/images/exreports.png"></td>
			<td align='left'
				style="margin-bottom: 20px; font-size: 21pt; position: inline; color: white; font-weight: bolder">Extensive
				Time Sheet Report</td>
			<td style="color: white; font-size: 15pt" align="right">Hi, <b><?php echo $this->session->userdata('fullname');?>
			</b> ..!</td>
			<td align="left" style="color: white; font-size: 15pt; width: 50px">
				<a href="<?php echo site_url("logincheck/logout"); ?>"><img
					style="width: 50px; height: 50px"
					src="<?php echo base_url(); ?>/images/logout2.png"> </a>
			</td>
		</tr>
	</table>
</div>


<div
	style="height: auto; overflow: hidden; background: #DBEADC; margin: 5px 0px 0px 0px; width: 100%; border: 1px solid black; border-radius: 10px;">
	<table width="100%" border="0" align="left" cellpadding="2"
		style="height: 40px;">
		<tr class="tab_header_bg">
			<td align="center">Date From : <input type="text" id="date_from"
				class="datefld_txt" style="width: 80px;"
				onchange="javascript:chooseFunction()" />&nbsp;&nbsp; To : <input
				type="text" id="date_to" class="datefld_txt" style="width: 80px;"
				onchange="javascript:chooseFunction()" /> &nbsp;&nbsp; <select
				id='getUser'
				style="height: 20px; width: 150px; color: green; font-weight: bolder; font-size: 12px;"
				onchange="team_activity_emp();">
					<option selected value="">Select Employee</option>
					<?php
					foreach($members as $memb ){
						$emp=$memb["Name"];
						echo '<option style="font-size:12px" value="'.$emp.'">'.$emp.'</option>';
					}
					?>

			</select> &nbsp; <select id='getDept'
				style="height: 22px; width: 180px; color: RED; font-weight: bolder; font-size: 12px;"
				onchange="javascript:get_timesheet_Dept(this.value);">
					<option value="">Select Department</option>
					<?php
					foreach($deptlist as $dept ){
						$desc=$dept["department"];
						echo '<option value="'.$desc.'">'.$desc.'</option>';
					}
					?>
			</select> <select id='getTeam'
				style="height: 22px; width: 180px; color: blue; font-weight: bolder; font-size: 12px;"
				onchange="javascript:get_timesheet_Team(this.value);">
					<option value="">Select a Team</option>
					<?php
					foreach($teamlist as $team ){
						$desc1=$team["EmployeeName"];
						echo '<option value="'.$desc1.'">'.$desc1.'</option>';
					}
					?>
			</select> <input type='text' value='' id='getjob'
				placeholder="Job Number"
				style="height: 20px; width: 70px; color: RED; font-weight: bolder; font-size: 12px; display: none" />
				&nbsp; <input type='button' value='Job Report'
				onclick="javascript:timesheet_team_job();"
				style="width: 80px; color: #006600; font-weight: bold" />
				&nbsp;&nbsp; <img align="bottom"
				src="<?php echo base_url(); ?>/images/print2.png"
				onclick="javascript:printReport();"
				style="width: 50px; height: 30px; color: green" />
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
<input type='hidden'
	id='report_option' value='' />
<input type='hidden'
	id='getTeam1' value="" />

<script
	type="text/javascript"
	src="<?php echo base_url(); ?>js/Timesheet/timesheet.js"></script>
<script
	type="text/javascript"
	src="<?php echo base_url(); ?>js/custom/print.js"></script>
