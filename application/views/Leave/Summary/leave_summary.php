
<div style="height: 70px; background: #59955C;">
	<table>
		<tr>
			<td width="50" align='left'><img style="width: 100px; height: 50px"
				src="<?php echo base_url(); ?>/images/leavesummary1.png"></td>
			<td align='left'
				style="margin-bottom: 20px; font-size: 21pt; position: inline; color: white; font-weight: bolder">Employees
				Leave Summary</td>
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
	<table width="100%" border="0" align="left" cellpadding="0"
		style="height: 40px;">
		<tr>
			<td align="center"><select id="year"
				style="height: 20px; width: 100px; color: Brown; font-weight: bold; font-size: 12px;"
				onchange="javascript:get_summary(this.value,'4');">
					<option value="">Select Year</option>
					<?php
					foreach($years as $row){
						$y=$row["year"];
						?>
					<option value="<?php echo $y;?>">
					<?php echo $y;?>
					</option>
					<?php
					}
					?>
			</select>&nbsp;&nbsp;&nbsp;&nbsp; <!-- 				<select  id="month" style="height:20px;width:100px;color:violet;font-weight:bold;font-size:12px;" > 
							<option value="">All Months</option>
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
								
					</select>&nbsp;&nbsp;&nbsp;&nbsp;
					<button onclick="javascript:get_summary(this.value,'4');">Get Report</button>&nbsp;&nbsp;&nbsp;&nbsp;
					 --> <select id='emp'
				style="height: 20px; width: 150px; color: green; font-weight: bolder; font-size: 12px;"
				onchange="javascript:get_summary(this.value,'1');">
					<option value="">Select Employee</option>
					<option selected value="All Employees">All Employees</option>
					<?php
					foreach($members as $memb ){
						$emp=$memb["Name"];
						echo '<option style="font-size:12px" value="'.$emp.'">'.$emp.'</option>';
					}
					?>

			</select> &nbsp;&nbsp; <select id='dept'
				style="height: 22px; width: 180px; color: RED; font-weight: bolder; font-size: 12px;"
				onchange="javascript:get_summary(this.value,'2');">
					<option value="">Select Department</option>
					<?php
					foreach($deptlist as $dept ){
						$desc=$dept["department"];
						echo '<option value="'.$desc.'">'.$desc.'</option>';
					}
					?>
			</select>&nbsp;&nbsp; <select id='team'
				style="height: 22px; width: 180px; color: blue; font-weight: bolder; font-size: 12px;"
				onchange="javascript:get_summary(this.value,'3');">
					<option value="">Select a Team</option>
					<?php
					foreach($teamlist as $team ){
						$desc1=$team["EmployeeName"];
						echo '<option value="'.$desc1.'">'.$desc1.'</option>';
					}
					?>
			</select> &nbsp;&nbsp; <img align="bottom"
				src="<?php echo base_url(); ?>/images/print2.png"
				onclick="javascript:printSummary();"
				style="width: 50px; height: 30px; color: green" />
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
