
<div style="height: 70px; background: #59955C;">
	<table>
		<tr>
			<td width="50" align='left'><img style="width: 100px; height: 60px"
				src="<?php echo base_url(); ?>/images/user_add.png"></td>
			<td align='left'
				style="margin-bottom: 20px; font-size: 21pt; position: inline; color: white; font-weight: bolder">Add
				New User</td>
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
	style="height: auto; background: #DBEADC; margin: 10px 0px 0px 200px; width: 60%; border: 1px solid black; border-radius: 10px;">


	<p style="height: 40px; padding: 20px 0px 0px 20px;" align="center">
		<span style="font-weight: bolder; font-size: 18pt; color: #003333">New
			User Entry </span>
	</p>

	<hr width="100%">
	<div align="center" style="margin: 0px 0px 0px 0px;">
		<table style="width: 90%" border="0">

			<tr>
				<td><font
					style='font-size: 12pt; color: #003333; font-weight: bolder'>Employee
						Name</font><font color='red'> *</font></td>
				<td colspan='2'><select id='honorific'
					style='color: green; font-family: Lucida; font-size: 12pt; font-weight: bolder; height: 26px;'>
						<option value='Mr.'>Mr.</option>
						<option value='Dr.'>Dr.</option>
						<option value='Mrs.'>Mrs.</option>
						<option value='Miss.'>Miss.</option>
						<option value='Ms.'>Ms.</option>
				</select> <input name="emp_name" id="emp_name" type="text"
					style="width: 180px; height: 23px; font-size: 12pt; font-weight: bolder; color: green; font-family: Lucida;"
					value=""></td>
			</tr>

			<tr style="height: 50px;">
				<td width="40%"><font
					style='font-size: 12pt; color: #003333; font-weight: bolder'>Employee
						Number</font><font color='red'> *</font></td>
				<td><input name="emp_num" id="emp_num" type="text"
					style="width: 180px; height: 23px; font-size: 12pt; font-weight: bolder; color: green; font-family: Lucida;"
					value="" onkeyup="javascript:check_EmpNumber(this.value)"
					onblur="javascript:check_EmpNumber(this.value)"></td>
				<td align='left'><img id='notavail' height='30px' width='40px'
					style='align: center; display: none'
					src='<?php echo  base_url();?>images/notavail.png' /> <img
					id='avail' height='30px' width='40px'
					style='align: center; display: none'
					src='<?php echo  base_url();?>images/avail.png' />
				</td>

			</tr>

			<tr style="height: 40px;">
				<td><font
					style='font-size: 12pt; color: #003333; font-weight: bolder'>Password</font><font
					color='red'> *</font></td>
				<td><input name="passwd" id="passwd" type="password"
					placeholder='Length: 6 to 12'
					style="width: 176px; height: 23px; font-size: 12pt; font-weight: bolder; color: green; font-family: Lucida;"
					value="" onblur="check_password_length()">
				</td>
			</tr>

			<tr>
				<td><font
					style='font-size: 12pt; color: #003333; font-weight: bolder'>Confirm
						Password</font><font color='red'> *</font></td>
				<td width='140px'><input name="cpasswd" id="cpasswd" type="password"
					style="width: 176px; height: 23px; font-size: 12pt; font-weight: bolder; color: green; font-family: Lucida;"
					value="" onkeyup="check_password()"></td>
				<td align='left'><img id='mismatch' height='30px' width='40px'
					style='display: none'
					src='<?php echo  base_url();?>images/notavail.png' /> <img
					id='match' height='30px' width='40px' style='display: none'
					src='<?php echo  base_url();?>images/avail.png' />
				</td>
			</tr>

			<tr style="height: 40px;">
				<td><font
					style='font-size: 12pt; color: #003333; font-weight: bolder'>User
						Role</font><font color='red'> *</font></td>
				<td colspan='2'><select name="userrole" id="userrole"
					style="width: 180px; height: 24px; color: green; font-size: 12pt; font-family: Lucida; font-weight: bolder;">
						<option value="">Select</option>
						<?php
						foreach($rolelist as $row ){
							$role=$row["Role"];
							echo '<option value="'.$role.'">'.$role.'</option>';
						}
						?>

				</select>
				</td>
			</tr>

			<tr style="height: 40px;">
				<td><font
					style='font-size: 12pt; color: #003333; font-weight: bolder'>Department</font><font
					color='red'> *</font></td>
				<td colspan='2'><select name="dept" id="dept"
					style="width: 180px; height: 24px; color: green; font-size: 12pt; font-family: Lucida; font-weight: bolder"
					onchange="get_reporters(this.value)">
						<option value="">Select</option>
						<?php
						foreach($deptlist as $dept ){
							$desc=$dept["department"];
							echo '<option value="'.$desc.'">'.$desc.'</option>';
						}
						?>
				</select>
				</td>
			</tr>


			<tr id="row_l1" style="height: 40px;">
				<td><font
					style='font-size: 12pt; color: #003333; font-weight: bolder'>Reporting
						Authority</font><font color='red'> *</font></td>
				<td colspan='2'><select name="reporters" id="reporters"
					style="width: 180px; height: 24px; color: green; font-size: 12pt; font-family: Lucida; font-weight: bolder">
						<option selected value="Managing Director">Managing Director</option>
				</select>
				</td>
			</tr>

			<tr style="height: 40px;">
				<td><font
					style='font-size: 12pt; color: #003333; font-weight: bolder'>Approving
						Authority</font><font color='red'> *</font></td>
				<td colspan='2'><select name="approvers" id="approvers"
					style="width: 180px; height: 24px; color: green; font-size: 12pt; font-family: Lucida; font-weight: bolder">
						<option selected value="Managing Director">Managing Director</option>
				</select>
				</td>
			</tr>

			<tr height='40'>
				<td><font
					style='font-size: 12pt; color: #003333; font-weight: bolder'>Joining
						Date</font><font color='red'> *</font></td>
				<td colspan='2'><input name="doj" id="doj" type="text"
					style="width: 100px; height: 23px; font-size: 12pt; font-weight: bolder; color: green"
					value=""></td>
			</tr>

			<tr>
				<td><font
					style='font-size: 12pt; color: #003333; font-weight: bolder'>E-Mail
						ID</font><font color='red'> *</font></td>
				<td colspan='2'><input name="email" id="email" type="text"
					style="width: 220px; height: 23px; font-size: 10pt; font-weight: bolder; color: green"
					value=""></td>
			</tr>

			<tr height="10">
				<td></td>
			</tr>

			<tr style='font-size: 15px; color: red; font-weight: bold'>
				<td id='buttonrow' colspan="2" align="center"><img
					style="width: 100px; height: 35px; color: green; font-weight: bold; font-size: 12pt; border: 1px solid; border-radius: 5px;"
					src="<?php echo base_url(); ?>/images/adduser.png" id="button"
					type="image" onclick="javascript:submit_userData()">
				</td>
			</tr>

		</table>
	</div>
</div>


<script
	type="text/javascript" src="<?php echo base_url(); ?>js/User/users.js"></script>
<script
	type="text/css" src="<?php echo base_url(); ?>css/style.css"></script>



