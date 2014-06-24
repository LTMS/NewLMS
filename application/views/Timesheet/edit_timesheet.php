
<div style="height: 70px; background: #59955C;">
	<table>
		<tr>
			<td width="50" align='left'><img style="width: 100px; height: 50px"
				src="<?php echo base_url(); ?>/images/edit.png"></td>
			<td align='left'
				style="margin-bottom: 20px; font-size: 21pt; position: inline; color: white; font-weight: bolder">Edit
				Time Sheet Reports</td>
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
	style="float: left; height: auto; background: #DBEADC; margin: 10px 0px 0px 30px; width: 100%; border: 1px solid black; border-radius: 10px;">
	<hr width="100%">

	<table style="width: 100%" border="0" align="center">
		<tr>
			<td colspan="10" id="error" align="center"
				style="color: red; width: 250px; font-size: 15px; font-weight: bolder;">
			</td>
		</tr>
		<tr>
			<td colspan="10" class="input" id="name" align="center"
				style="color: red; width: 250px; font-size: 20px; font-weight: bolder;">
			</td>
		</tr>
		<tr style="font-weight: bold">
			<td align="center">IN Time</td>
			<td align="center">OUT Time</td>
			<td align="center">Late</td>
			<td align="center">Lunch Hrs</td>
			<td align="center">Duty Hrs</td>
			<td align="center">OT Hrs</td>
			<td align="center">Total Hrs</td>
			<td align="center"></td>
		</tr>
		<tr>
			<td align="center"><input name="intimeH" class="input" id="intimeH"
				type="text" style="width: 30px; height: 18px;" value=""
				onchange="findLateHrs()" />: <input name="intimeM" class="input"
				id="intimeM" type="text" style="width: 30px; height: 18px;"
				onchange="findLateHrs()" />
			</td>
			<td align="center" width="150px"><input name="outtimeH" class="input"
				id="outtimeH" type="text" style="width: 30px; height: 18px;"
				value="" onchange="findTotalHrs()" />: <input name="outtimeM"
				class="input" id="outtimeM" type="text"
				style="width: 30px; height: 18px;" value=""
				onchange="findTotalHrs()" />
			</td>
			<td align="center"><input name="late" class="input" id="late"
				type="text" readonly="readonly" style="width: 50px; height: 18px;"
				value="" /></td>
			<td align="center"><input name="lunch" class="input" id="lunch"
				type="text" readonly="readonly" style="width: 50px; height: 18px;"
				value="" /></td>
			<td align="center"><input name="duty" class="input" id="duty"
				type="text" readonly="readonly" style="width: 50px; height: 18px;"
				value="" /></td>
			<td align="center"><input name="ot" class="input" id="ot" type="text"
				readonly="readonly" style="width: 50px; height: 18px;" value="" /></td>
			<td align="center"><input name="total" class="input" id="total"
				type="text" readonly="readonly" style="width: 50px; height: 18px;"
				value="" /></td>
			<td align="left"><input type="button"
				style="width: 100px; height: 18px;" value="Update Changes"
				onclick="update_changes()" />
			</td>
		</tr>
		<tr height="30px">
			<td></td>
		</tr>
		<tr style="font-weight: bold">
			<td align="center" colspan="8"
				style="font-size: 13pt; font-weight: bolder">Select Date</td>

		</tr>
		<tr style="font-weight: bold">
			<td align="center" colspan="8"><input name="date" class="input"
				id="date" type="text"
				style="width: 100px; height: 20px; font-size: 18px; font-weight: bolder; color: red"
				value="" onchange="get_timedate(this.value)" /></td>

		</tr>

		<tr>
			<td id="success" align="center" colspan="7"
				style="color: green; width: 250px; font-size: 15px; font-weight: bolder;"></td>
		</tr>

	</table>
</div>
<input type="hidden" value=""
	id="rowID" />
<input type="hidden"
	value="" id="dummyDate" />
<div id="contentData"></div>
<?php
foreach($param as $openrow2) {
	$in = $openrow2["in_time"];
	$out = $openrow2["out_time"];
	$tot = $openrow2["duty_hrs"];
	$ot = $openrow2["OT"];
	$lun = $openrow2["lunch"];
}
?>

<input
	id="param_in" type="hidden" value="<?php echo $in;?>" />
<input
	id="param_out" type="hidden" value="<?php echo $out;?>" />
<input
	id="param_tot" type="hidden" value="<?php echo $tot;?>" />
<input
	id="param_ot" type="hidden" value="<?php echo $ot;?>" />
<input
	id="param_lunch" type="hidden" value="<?php echo $lun;?>" />

<input id="in_date"
	type="hidden" value="" />
<input id="out_date"
	type="hidden" value="" />

<script
	type="text/javascript"
	src="<?php echo base_url(); ?>js/custom/timesheet.js"></script>
