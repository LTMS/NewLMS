
<div style="height: 70px; background: #59955C;">
	<table>
		<tr>
			<td width="50" align='left'><img style="width: 100px; height: 60px"
				src="<?php echo base_url(); ?>/images/User/user_add.png"></td>
			<td align='left'
				style="margin-bottom: 20px; font-size: 21pt; position: inline; color: white; font-weight: bolder">Add
				New User</td>
			<td style="color: white; font-size: 15pt" align="right">Hi, <b><?php echo $this->session->userdata('Emp_Name');?>
			</b> ..!</td>
			<td align="left" style="color: white; font-size: 15pt; width: 50px">
				<a href="<?php echo site_url("logincheck/logout"); ?>"><img
					style="width: 50px; height: 50px"
					src="<?php echo base_url(); ?>/images/User/logout2.png"> </a>
			</td>
		</tr>
	</table>
</div>

<div
	style="height: auto; background: #DBEADC; margin: 10px 0px 0px 180px; width: 70%; border: 1px solid black; border-radius: 10px;">


	<p style="height: 40px; padding: 20px 0px 0px 20px;" align="center">
		<span style="font-weight: bolder; font-size: 18pt; color: #003333">New	User Entry </span>
	</p>

	<hr width="100%">
	<center>	<p style='color:red;font-size:14px;font-weight:bold;' id='Error'></p></center>
	<div align="center" style="margin: 0px 0px 0px 0px;">
		<table style="width: 90%" border="0">

			<tr>
				<td><font	class='Font_Style1'>Employee Name</font><font color='red'> *</font></td>
				<td colspan='2'><select id='honorific'	class='Font_Style1'>
						<option value='Mr.'>Mr.</option>
				<!-- 	<option value='Dr.'>Dr.</option>  -->
						<option value='Mrs.'>Mrs.</option>
						<option value='Miss.'>Miss.</option>
						<option value='Ms.'>Ms.</option>
				</select> <input name="emp_name" id="emp_name" type="text"	class='Font_Style2' value=""></td>
			</tr>

			<tr style="height: 50px;">
				<td width="40%"><font	class='Font_Style1'>Employee Number</font><font color='red'> *</font></td>
				<td><input name="emp_num" id="emp_num" type="text"		class='Font_Style2'	value="" onkeyup="check_EmpNumber(this.value)"></td>
				<td align='left'>
						<img id='notavail' height='30px' width='40px'	style='align: center; display: none' src='<?php echo  base_url();?>images/User/notavail.png' />
						 <img	id='avail' height='30px' width='40px'	style='align: center; display: none'	src='<?php echo  base_url();?>images/User/avail.png' />
				</td>

			</tr>

			<tr style="height: 40px;">
				<td><font	class='Font_Style1'>Password</font>
						<font color='red'> * </font>	<font> (6-12 Characters)</font></td>
				<td><input name="passwd" id="passwd" type="password"	class='Font_Style2'  value="" onblur="check_password_length()">
				</td>
			</tr>

			<tr>
				<td><font	class='Font_Style1'>Confirm	Password</font><font color='red'> *</font></td>
				<td width='140px'>
				<input name="cpasswd" id="cpasswd" type="password"class='Font_Style2' value="" onkeyup="check_password()"></td>
				<td align='left'>
						<img id='mismatch' height='30px' width='40px'	style='display: none'	src='<?php echo  base_url();?>images/User/notavail.png' />
						 <img	id='match' height='30px' width='40px' style='display: none' src='<?php echo  base_url();?>images/User/avail.png' />
				</td>
			</tr>

			<tr style="height: 40px;">
				<td><font	class='Font_Style1'>User 	Role</font><font color='red'> *</font></td>
				<td colspan='2'>
						<select name="userrole" id="userrole" class='Font_Style2'>
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
				<td><font	class='Font_Style1'>Department</font><font	color='red'> *</font></td>
				<td colspan='2'>
							<select name="dept" id="dept"	class='Font_Style2' onchange="get_reporters(this.value)">
								<option value="">Select</option>
								<?php
								foreach($deptlist as $dept ){
									$desc=$dept["Department"];
									echo '<option value="'.$desc.'">'.$desc.'</option>';
								}
								?>
						</select>
				</td>
		</tr>


			<tr id="row_l1" style="height: 40px;">
				<td><font	class='Font_Style1'>Reporting	Authority</font><font color='red'> *</font></td>
				<td colspan='2'>
						<select name="reporters" id="reporters"	class='Font_Style2'>
							<option selected value="Managing Director">Managing Director</option>
						</select>
				</td>
			</tr>

			<tr style="height: 40px;">
				<td><font	class='Font_Style1'>Approving	Authority</font><font color='red'> *</font></td>
				<td colspan='2'>
						<select name="approvers" id="approvers"	class='Font_Style2'  >
								<option selected value="Managing Director">Managing Director</option>
						</select>
				</td>
			</tr>

			<tr height='40'>
				<td><font	class='Font_Style1'>Joining		Date</font><font color='red'> *</font></td>
				<td colspan='2'><input name="doj" id="doj" type="text"	 class='Font_Style2'	value=""></td>
			</tr>

			<tr>
				<td><font	class='Font_Style1'>E-Mail	ID</font><font color='red'> *</font></td>
				<td colspan='2'><input name="email" id="email"  type="text"class='Font_Style2' onblur="checkEmail()" 	value=""></td>
			</tr>

			<tr height="10">
				<td></td>
			</tr>
		</table>
	</div>
	
<center>	<p id='buttonrow'>
		<img	style="width: 100px; height: 35px; color: green; font-weight: bold; font-size: 12pt; border: 1px solid; border-radius: 5px;"
					src="<?php echo base_url(); ?>/images/User/adduser.png" id="button"	type="image" onclick="javascript:submit_userData()">
	</p>
	</center>
	
</div>


<script
	type="text/javascript" src="<?php echo base_url(); ?>js/User/users.js"></script>
<script
	type="text/css" src="<?php echo base_url(); ?>css/style.css"></script>



