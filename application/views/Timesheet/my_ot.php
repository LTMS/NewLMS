
<div style="height: 70px; background: #59955C;">
	<table>
		<tr>
			<td width="50" align='left'><img style="width: 120px; height: 70px"
				src="<?php echo base_url(); ?>/images/OT2.png"></td>
			<td align='left'
				style="margin-bottom: 20px; font-size: 21pt; position: inline; color: white; font-weight: bolder">My
				Over Time Details</td>
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

	<div align="center" style="margin-top: 20px; margin-bottom: 10px;">
		<select id="year"
			style="height: 20px; width: 100px; color: Brown; font-weight: bold; font-size: 12px;"
			onchange="javascript:get_my_ot();">
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
		</select>&nbsp;&nbsp;&nbsp;&nbsp; <select id="month"
			style="height: 20px; width: 100px; color: blue; font-weight: bold; font-size: 12px;"
			onchange="javascript:get_my_ot();">
			<option value="">Select Month</option>
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
		</select>&nbsp;&nbsp;&nbsp;&nbsp; <img align="bottom"
			src="<?php echo base_url(); ?>/images/print2.png"
			onclick="javascript:printOT();"
			style="width: 50px; height: 30px; color: green" />

		<!-- 				<select  id='emp'  style="height:20px;width:150px;color:green;font-weight:bolder;font-size:12px;" onchange="javascript:get_approved_leaves();"> 
								<option selected value="All Employees">All  Employees</option>
								 <?php
											foreach($members as $memb ){
												$emp=$memb["Name"];						
												echo '<option style="font-size:12px" value="'.$emp.'">'.$emp.'</option>'; 
											}
								?>
						</select> &nbsp;&nbsp;
						 -->
	</div>

	<hr width="100%">

	<div id="contentData" style="height: 640px; overflow: scroll;"></div>

</div>
<input
	type='hidden' id='report_option'
	value='Over Time Hours Details of <?php echo $this->session->userdata('fullname');?>' />

<script
	type="text/javascript"
	src="<?php echo base_url(); ?>js/Timesheet/timesheet.js"></script>
<script
	type="text/javascript"
	src="<?php echo base_url(); ?>js/custom/print.js"></script>
