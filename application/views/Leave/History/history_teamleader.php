
<div style="height: 70px; background: #59955C;">
	<table>
		<tr>
			<td width="50" align='left'><img style="width: 100px; height: 50px"
				src="<?php echo base_url(); ?>/images/history1.png"></td>
			<td align='left'
				style="margin-bottom: 20px; font-size: 21pt; position: inline; color: white; font-weight: bolder">Department
				Leave History</td>
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
			<td align="center">Leave Date From : <input type="text"
				id="date_from" class="datefld_txt" style="width: 100px;" /></td>
			<td align="center">To : <input type="text" id="date_to"
				class="datefld_txt" style="width: 100px;" />&nbsp;&nbsp;</td>
			<td><button onclick="get_history_teamleader('null','3')">Get Report</button>
			</td>
			<td align="center"><select id='search'
				style="height: 20px; width: 150px; color: green; font-weight: bolder; font-size: 12px;"
				onchange="get_history_teamleader(this.value,'2')">
					<option selected value="null">Select Employee</option>
					<?php
					foreach($members as $memb ){
						$emp=$memb["Name"];
						echo '<option style="font-size:12px" value="'.$emp.'">'.$emp.'</option>';
					}
					?>

			</select> &nbsp;&nbsp;</td>
			<td align="center">Filter By: <select name='filter' id='filter'
				style="color: blue; font-weight: bold"
				onchange="get_history_teamleader(this.value,'3')">
					<option value='null'>Leave Type</option>
					<option value='Casual Leave'>Casual Leave</option>
					<option value='Paid Leave'>Paid Leave</option>
					<option value='Sick Leave'>Sick Leave</option>
					<option value='Comp-Off'>Comp-Off</option>
					<option value='2,4'>Approved</option>
					<option value='3,5'>Rejected</option>
					<option value='1'>No Result</option>
			</select>
			</td>
			<td><img align="bottom"
				src="<?php echo base_url(); ?>/images/print2.png"
				onclick="javascript:printLeaveHistory();"
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
<input type="hidden"
	id="report_option" value="" />
<input
	type="hidden" id="get_team"
	value="<?php echo $this->session->userdata('fullname');?>" />

<script
	type="text/javascript" src="<?php echo base_url(); ?>js/custom/lms.js"></script>
<script
	type="text/javascript"
	src="<?php echo base_url(); ?>js/custom/print.js"></script>
