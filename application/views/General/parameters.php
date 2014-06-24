
<div style="height: 70px; background: #59955C;">
	<table>
		<tr>
			<td width="50" align='left'><img style="width: 100px; height: 50px"
				src="<?php echo base_url(); ?>/images/officetime.png"></td>
			<td align='left'
				style="margin-bottom: 20px; font-size: 21pt; position: inline; color: white; font-weight: bolder">Office
				Parameters</td>
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


<div align="center"
	style="float: left; height: auto; background: #DBEADC; margin: 10px 0px 0px 180px; width: 65%; border: 2px solid black; border-radius: 10px;">
	<?php
	foreach($param as $openrow2) {
		$id = $openrow2["id_param"];
		$in = $openrow2["in_time"];
		$out = $openrow2["out_time"];
		$tot = $openrow2["duty_hrs"];
		$lunch = $openrow2["lunch"];
		$ot = $openrow2["min_OT"];
		$by = $openrow2["updatedby"];
		$on = $openrow2["updatedon"];
		$sick_limit=$openrow2["sick_limit"];
		$reduct=$openrow2["comp_off_reduct"];
		$permis=$openrow2["permission_hrs"];
	}
	?>

	<table width='100%'>

		<tr height="40">
			<td align="center" colspan="7"
				style="font-size: 10pt; font-weight: bolder; color: Blue;"><u>Recently
					modified by <?php echo $by;?> on <?php echo $on;?> </u>
			</td>
		</tr>
		<tr id='error' style='display: none; color: red' height="40">
			<td align="center" colspan="7"
				style="font-size: 10pt; font-weight: bolder;">Check Input Fields..!</td>
		</tr>
		<tr>
			<td>
				<table width='50%'>
					<tr>
						<td
							style="font-size: 12pt; font-weight: bolder; color: #004A4A; width: 130px">Current
							In Time</td>
						<td
							style="width: 50px; font-size: 12pt; font-weight: bolder; color: #004A4A;">
							<?php echo $in;?></td>
						<td id="col11"
							style="font-size: 12pt; font-weight: bolder; color: green; width: 130px; display: none;">New
							In Time</td>
						<td align="left" id="col1"
							style="font-size: 10pt; font-weight: bolder; color: black; display: none; width: 60px">Hour:<input
							name="intimeH" class="input" id="intimeH" type="text"
							style="font-size: 10pt; font-weight: bolder; width: 30px; height: 18px;"
							value="09" placeholder="Hr" onchange="findTotalHrs()" /></td>
						<td align="left" id="col2"
							style="font-size: 10pt; font-weight: bolder; color: black; display: none; width: 60px">Mins:<input
							name="intimeM" class="input" id="intimeM" type="text"
							style="font-size: 10pt; font-weight: bolder; width: 30px; height: 18px;"
							value="00" placeholder="min" onchange="findTotalHrs()" /></td>
						<td id="col14" width='250px'></td>
					</tr>
					<tr>
						<td
							style="font-size: 12pt; font-weight: bolder; color: #004A4A; width: 130px">Current
							Out Time</td>
						<td
							style="width: 50px; font-size: 12pt; font-weight: bolder; color: #004A4A;"><?php echo $out;?>
						</td>
						<td id="col12"
							style="font-size: 12pt; font-weight: bolder; color: green; width: 130px; display: none;">New
							Out Time</td>
						<td align="left" id="col3"
							style="font-size: 10pt; font-weight: bolder; color: black; display: none; width: 60px">Hour:<input
							name="outtimeH" class="input" id="outtimeH" type="text"
							style="font-size: 10pt; font-weight: bolder; width: 30px; height: 18px;"
							value="17" placeholder="Hr" onchange="findTotalHrs()" /></td>
						<td align="left" id="col4"
							style="font-size: 10pt; font-weight: bolder; color: black; display: none; width: 60px">Mins:<input
							name="outtimeM" class="input" id="outtimeM" type="text"
							style="font-size: 10pt; font-weight: bolder; width: 30px; height: 18px;"
							value="00" placeholder="min" onchange="findTotalHrs()" /></td>
					</tr>
					<tr>
						<td
							style="font-size: 12pt; font-weight: bolder; color: #004A4A; width: 130px">Current
							Lunch Hrs</td>
						<td
							style="width: 50px; font-size: 12pt; font-weight: bolder; color: #004A4A;"><?php echo $lunch;?>
						</td>
						<td id="col13"
							style="font-size: 12pt; font-weight: bolder; color: green; width: 130px; display: none;">New
							Lunch Hrs</td>
						<td align="left" id="col5"
							style="font-size: 10pt; font-weight: bolder; color: black; display: none; width: 60px">Hour:<input
							name="lunchH" class="input" id="lunchH" type="text"
							style="font-size: 10pt; font-weight: bolder; width: 30px; height: 18px;"
							value="00" placeholder="Hr" "/></td>
						<td align="left" id="col6"
							style="font-size: 10pt; font-weight: bolder; color: black; display: none; width: 60px">Mins:<input
							name="lunchM" class="input" id="lunchM" type="text"
							style="font-size: 10pt; font-weight: bolder; width: 30px; height: 18px;"
							value="45" placeholder="min" "/></td>
					</tr>
					<tr height='50'>
						<td
							style="font-size: 15pt; font-weight: bolder; color: #004A4A; width: 130px;"><i>Total
								Hours</i></td>
						<td
							style="width: 50px; font-size: 15pt; font-weight: bolder; color: #004A4A;">
							<i><?php echo $tot;?> </i></td>
						<td id="row2" colspan='3'
							style="font-size: 15pt; font-weight: bolder; color: green; width: 130px; display: none;"><i>New
								Total Hours &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="total"
								type="text"
								style="width: 100px; height: 25px; font-size: 15pt; font-weight: bold; color: green; background: #DBEADC;"
								readonly="readonly" value="08:00:00"/ > </i></td>
					</tr>
				</table>
				<hr>
			</td>
			<td>
		
		</tr>
		<tr>
			<td>
				<table width='50%'>
					<tr height='40'>
						<td colspan='2'
							style="font-size: 11pt; font-weight: bolder; color: #004A4A; width: 180px">Sick
							Leave Document Affiliation Limit &nbsp; <=</td>
						<td
							style="width: 100px; font-size: 12pt; font-weight: bolder; color: #004A4A;"><input
							readonly='readonly' name="sicklimit" class="input" id="sicklimit"
							type="text"
							style="font-size: 11pt; font-weight: bolder; width: 20px; height: 18px; color: green"
							value="<?php echo $sick_limit;?>" /> day(s)</td>
						<td
							style="font-size: 12pt; font-weight: bolder; color: green; width: 10px; display: none;">New
							Limit</td>
						<td id="col16" width='200px'></td>
					</tr>
					<tr height='40'>
						<td colspan='2'
							style="font-size: 11pt; font-weight: bolder; color: #004A4A; width: 140px">Permission
							- Maximum Allowed Hours</td>
						<td
							style="width: 100px; font-size: 12pt; font-weight: bolder; color: #004A4A;"><input
							readonly='readonly' name="permiss" class="input" id="permiss"
							type="text"
							style="font-size: 11pt; font-weight: bolder; width: 20px; height: 18px; color: green"
							value="<?php echo $permis;?>" /> hour(s)</td>
						<td align="left"
							style="font-size: 10pt; font-weight: bolder; color: black; display: none; width: 60px">Mins:<input
							name="coM" class="input" id="coM" type="text"
							style="font-size: 10pt; font-weight: bolder; width: 30px; height: 18px;"
							value="00" placeholder="min" "/></td>
					</tr>
					<tr height='40'>
						<td colspan='1'
							style="font-size: 11pt; font-weight: bolder; color: #004A4A; width: 140px">OT
							- Reduction Hours for Comp-Off</td>
						<td
							style="width: 20px; font-size: 12pt; font-weight: bolder; color: #004A4A;"><?php echo $reduct;?>
						</td>
						<td id="col19"
							style="font-size: 11pt; font-weight: bolder; color: green; width: 100px; display: none;">New
							Reduction</td>
						<td align="left" id="col17"
							style="font-size: 10pt; font-weight: bolder; color: black; display: none; width: 60px">Hour:<input
							name="coH" class="input" id="coH" type="text"
							style="font-size: 10pt; font-weight: bolder; width: 30px; height: 18px;"
							value="08" placeholder="Hr" "/></td>
						<td align="left" id="col18"
							style="font-size: 10pt; font-weight: bolder; color: black; display: none; width: 60px">Mins:<input
							name="coM" class="input" id="coM" type="text"
							style="font-size: 10pt; font-weight: bolder; width: 30px; height: 18px;"
							value="00" placeholder="min" "/></td>
					</tr>
					<tr height='40'>
						<td colspan='1'
							style="font-size: 11pt; font-weight: bolder; color: #004A4A; width: 200px">Minimum
							Limit for OT Updation</td>
						<td
							style="width: 50px; font-size: 12pt; font-weight: bolder; color: #004A4A;"><?php echo $ot;?>
						</td>
						<td id="col15"
							style="font-size: 11pt; font-weight: bolder; color: green; width: 100px; display: none;">New
							OT Limit</td>
						<td align="left" id="col7"
							style="font-size: 10pt; font-weight: bolder; color: black; display: none; width: 60px">Hour:<input
							name="otH" class="input" id="otH" type="text"
							style="font-size: 10pt; font-weight: bolder; width: 30px; height: 18px;"
							value="00" placeholder="Hr" "/></td>
						<td align="left" id="col8"
							style="font-size: 10pt; font-weight: bolder; color: black; display: none; width: 60px">Mins:<input
							name="otM" class="input" id="otM" type="text"
							style="font-size: 10pt; font-weight: bolder; width: 30px; height: 18px;"
							value="45" placeholder="min" "/></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>





	<table align="center">
		<tr height="40">
			<td colspan="7" align="center"><input id="reset" type="image"
				src="<?php echo base_url(); ?>/images/reset.png"
				style="width: 60px; height: 30px" value="RESET"
				onclick="enableCol()"/ > <input id="update" type="image"
				src="<?php echo base_url(); ?>/images/update.png"
				style="width: 80px; height: 30px; display: none"
				onclick="update_param()"/ >
			</td>
		</tr>
	</table>
</div>



<script
	type="text/javascript"
	src="<?php echo base_url(); ?>js/custom/general.js"></script>
