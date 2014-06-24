<link rel="stylesheet" type="text/css" href="../../../css/mystyle.css">
<table style="width: 100%; border-radius: 10px;" border="0"
	background='#DBEADC'>
	<?php foreach($user_info as $row){ ?>
	<tr>
		<td><font class="font_align">Username &nbsp;&nbsp;</font><span
			style="font-size: 11px;"></span></td>
		<td><?php print("<input name='username' id='username' class='input' readonly='readonly' type='text' style='width:75px;' value='".$row->user_email."'>")
		?>
		</td>
	</tr>

	<tr>
		<td width=""><font class="font_align">Name</font></td>

		<td><?php print("<input name='u_name' id='u_name' class='input' readonly='readonly'  type='text' style='width:150px;' value='".$row->name."'>")
		?>
		</td>
	</tr>
	<tr>
		<td><font class="font_align">Change Password &nbsp;&nbsp;</font><span
			style="font-size: 11px;"></span></td>
		<td><?php print("<input name='passwd' id='passwd' class='input'  type='password' style='width:150px;' value=''>")
		?>
		</td>
	</tr>
	<tr>
		<td><font class="font_align">Confirm Password &nbsp;&nbsp;</font><span
			style="font-size: 11px;"></span></td>
		<td><?php print("<input name='cpasswd' id='cpasswd' class='input'  type='password' style='width:150px;' value=''>")
		?>
		</td>
	</tr>

	<tr>
		<td><font class="font_align">Time Office ID &nbsp;&nbsp;</font><span
			style="font-size: 11px;"></span></td>
		<td><?php print("<input name='timeoffice_id' id='timeoffice_id' class='input'  type='text' style='width:50px;' value='".$row->timeoffice_id."'>")
		?>
		</td>
	</tr>
	<tr>
		<td><font class="font_align">User Role &nbsp;&nbsp;</font><span
			style="font-size: 11px;"></span></td>
		<td><select name="userrole" id="userrole" style="width: 150px">
				<option value="user"
				<?php if($row->user_role=='user'){echo "selected";}?>>User</option>
				<option value="teamleader"
				<?php if($row->user_role=='teamleader'){echo "selected";}?>>Team
					Leader</option>
				<option value="admin"
				<?php if($row->user_role=='admin'){echo "selected";}?>>Admin</option>
				<option value="MD"
				<?php if($row->user_role=='MD'){echo "selected";}?>>MD</option>
		</select>
		</td>
	</tr>



	<?php } ?>
</table>
