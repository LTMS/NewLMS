
<div style="height: 70px; background: #59955C;">
	<table>
		<tr>
			<td width="50" align='left'><img style="width: 100px; height: 60px"
				src="<?php echo base_url(); ?>/images/myaccount1.png"></td>
			<td align='left'
				style="margin-bottom: 20px; font-size: 21pt; position: inline; color: white; font-weight: bolder">My
				App Account</td>
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
	foreach($details as $openrow2) {
		$id = $openrow2["user_id"];
		$uname = $openrow2["user_email"];
		$mail = $openrow2["email"];
		$role = $openrow2["user_role"];
		$phone = $openrow2["phone_number"];
		$to_id = $openrow2["timeoffice_id"];
		$modify = $openrow2["modifiedon"];
		$name = $openrow2["EmployeeName"];
		$dept = $openrow2["Department"];
		$desig = $openrow2["Designation"];
		$tl = $openrow2["LeaveApprover_L1"];
		$doj = $openrow2["JoiningDate"];
	}
	?>

	<table align="center" width="80%">
		<tr height="40">
			<td align="center" colspan="2"
				style="font-size: 10pt; font-weight: bolder; color: Blue;">Your
				details recently modified on <?php echo $modify?>
			</td>
		</tr>
		<tr id="error" style="display: none" height="40">
			<td align="center" colspan="2"
				style="font-size: 12pt; font-weight: bolder; color: Red;">* Password
				Does not Match..!</td>
		</tr>
		<tr>
			<td align="right"
				style="font-size: 12pt; font-weight: bolder; color: black;">My Name</td>
			<td align="left"><input id="name" readonly="readonly" type="text"
				style="font-size: 10pt; font-weight: bolder; color: brown;"
				value="<?php echo $name;?>" /></td>
		</tr>
		<tr>
			<td align="right"
				style="font-size: 12pt; font-weight: bolder; color: black;">User
				Name</td>
			<td align="left"><input id="uname" readonly="readonly" type="text"
				style="font-size: 10pt; font-weight: bolder; color: brown;"
				value="<?php echo $uname;?>" /></td>
		</tr>
		<tr style="display: none">
			<td align="right"
				style="font-size: 12pt; font-weight: bolder; color: black;">Current
				Password</td>
			<td align="left"><input id="cur_pwd" readonly="readonly"
				type="password"
				style="font-size: 10pt; font-weight: bolder; color: brown;"
				value="<?php echo $name;?>" /></td>
		</tr>
		<tr id="row1" style="display: none">
			<td align="right"
				style="font-size: 12pt; font-weight: bolder; color: black;">Enter
				Password</td>
			<td align="left"><input id="pwd_1" type="password"
				style="font-size: 10pt; font-weight: bolder; color: brown;" value="" />
			</td>
		</tr>
		<tr id="row2" style="display: none">
			<td align="right"
				style="font-size: 12pt; font-weight: bolder; color: black;">Re-Enter
				Password</td>
			<td align="left"><input id="pwd_2" type="password"
				style="font-size: 10pt; font-weight: bolder; color: brown;" value="" />
			</td>
		</tr>
		<tr>
			<td align="right"
				style="font-size: 12pt; font-weight: bolder; color: black;">Time
				Office ID</td>
			<td align="left"><input id="to_id" readonly="readonly" type="text"
				style="width: 50px; font-size: 10pt; font-weight: bolder; color: brown;"
				value="<?php echo $to_id;?>" /></td>
		</tr>
		<tr>
			<td align="right"
				style="font-size: 12pt; font-weight: bolder; color: black;">Department</td>
			<td align="left"><input id="dept" readonly="readonly" type="text"
				style="font-size: 10pt; font-weight: bolder; color: brown;"
				value="<?php echo $dept;?>" /></td>
		</tr>
		<tr>
			<td align="right"
				style="font-size: 12pt; font-weight: bolder; color: black;">App
				Designation</td>
			<td align="left"><input id="desig" readonly="readonly" type="text"
				style="font-size: 10pt; font-weight: bolder; color: brown;"
				value="<?php echo $desig;?>" /></td>
		</tr>
		<tr>
			<td align="right"
				style="font-size: 12pt; font-weight: bolder; color: black;">Team
				Leader</td>
			<td align="left"><input id="tl" readonly="readonly" type="text"
				style="font-size: 10pt; font-weight: bolder; color: brown;"
				value="<?php echo $tl;?>" /></td>
		</tr>

		<tr height="40">
			<td colspan="7" align="center" id='buttonrow'
				style='font-size: 14px; font-weight: bolder; color: red'><input
				id="modify" type="image" style="width: 150px; height: 30px;"
				src="<?php echo base_url(); ?>/images/changepassword.png"
				onclick="enableCol_details()"/ > <input id="update" type="image"
				style="width: 80px; height: 30px; display: none"
				src="<?php echo base_url(); ?>/images/update.png"
				onclick="update_details()"/ >
			</td>
		</tr>
	</table>
</div>

<input
	type="hidden" id="mail" value="<?php echo $mail; ?>" />
<input type="hidden"
	id="pwd_old" value="" />
<input
	type="hidden" id="u_id" value="<?php echo $id; ?>" />

<script
	type="text/javascript"
	src="<?php echo base_url(); ?>js/custom/general.js"></script>
