
<div style="height: 70px; background: #59955C;">
	<table>
		<tr>
			<td width="50" align='left'><img style="width: 100px; height: 65px"
				src="<?php echo base_url(); ?>/images/department.png"></td>
			<td align='left'
				style="margin-bottom: 20px; font-size: 21pt; position: inline; color: white; font-weight: bolder">Manage
				Departments</td>
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
	style="float: left; height: auto; background: #DBEADC; margin: 10px 0px 0px 00px; width: 65%; border: 1px solid black; border-radius: 10px;">
	<p style="height: 40px; padding: 10px 0px 0px 10px;" align="center">
		<span style="font-weight: bolder; font-size: 18pt;">Add a New
			Department</span>
	</p>
	<hr width="100%">

	<table border="0" align="center"
		style="font-size: 8pt; font-weight: bolder" cellpadding=""
		cellspacing="">
		<tr>
			<td colspan="2" width="50%">
				<table border="1">
					<tr>
						<td style="font-size: 8pt; font-weight: bolder">Department:</td>
						<td><input name="add_dept" id="add_dept" class="input" type="text"
							style="width: 180px; height: 18px;"
							placeholder="Enter Department Name" value="">
						</td>
					</tr>
					<tr>
						<td colspan="2" align="center"><button
								style="font-size: 10pt; font-weight: bolder; color: green"
								onclick="javascript:dept_add()">Add Department</button></td>
					</tr>
				</table>
			</td>
			<td colspan="2" width="50%">
				<table border="">
					<tr>
						<td style="font-size: 8pt; font-weight: bolder">Department</td>
						<td><select id="rem_dept" name="rem_dept">
								<option selected value="">Select a Department</option>
								<?php
								foreach($deptlist as $openrow1) {
									$val=$openrow1["id"];
									$descr=$openrow1["department"];
									print("<option value='$val'>");echo $descr;
									print("</option>");
								}
								?>
						</select>
						</td>
					</tr>
					<tr>
						<td colspan="2" align="center"><button
								style="font-size: 10pt; font-weight: bolder; color: red"
								onclick="javascript:dept_remove()">Remove Department</button></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div>



<div
	style="float: right; width: 20%; background: #CEF6F5; margin: 10px 90px 0px 20px; border: 0px solid black">

	<table border="3" align="left" bgcolor="99CC66"
		style="font-size: 8pt; font-weight: bolder" cellpadding="2"
		cellspacing="0">
		<tr>
			<td bgcolor="white" align="center"
				style="font-size: 15pt; font-weight: bolder; color: red">Available
				Departments</td>
		</tr>

		<?php
		foreach($deptlist as $openrow) {
			print("<tr><td style='font-size: 13pt; font-weight:bolder;color:white' align='center'>");
			echo	$openrow["department"];
			print("</td></tr>");
		}
		?>

	</table>
</div>


<script
	type="text/javascript" src="<?php echo base_url(); ?>js/custom/lms.js"></script>
