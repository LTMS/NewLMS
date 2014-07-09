
<!--  <div  style="height: 150px;background:#59955C">
<p style="text-align:center;padding-top:30px;font-size:22pt;font-weight:bolder;"> <img src="<?php echo base_url(); ?>images/PreipolarSwing3.gif" width="800px" height="80px;"/> </p>
</div>-->
<div align='center' id="login-form"
	style="height: 210px; width: 350px; border: 2px solid grey; border-radius: 20px; margin-top: 250px; margin-left: 550px;">
	<p
		style="color: green; text-align: center; font-size: 18pt; font-weight: bolder;">Login
		Form</p>
		<? echo form_open("logincheck/login"); ?>

	<table align='center' id="login_form"
		style="font-weight: bolder; font-size: 12pt; color: green">
		<tr>
			<td align='center'>Employee Number:</td>
			<td><input type="text" name="emp_num" id="emp_num"
				style="width: 150px; padding: 0 0 0 5px; color: #21610B; font-weight: bolder; font-size: 10pt;" />
			</td>
		</tr>
		<tr>
			<td align='center'>Enter Password:</td>
			<td><input type="password" name="password" id="password"
				style='width: 150px; color: #21610B' /></td>
		</tr>
		<tr height="100">
			<td colspan="2" align="center"><input type="image"
				style="width: 180px; height: 60px; margin-bottom: 20px"
				name="submit" id="submit"
				src="<?php echo base_url(); ?>/images/User/login2.png" />
			</td>
		</tr>
		<tr style="">
			<td colspan="2" align="center" style="color: red"><? if(isset($err)) { echo $err; } ?>
			</td>
		</tr>

	</table>
	<? echo "</form>" ?>
</div>

<table>
	<tr align='right' height='160' valign='bottom'>
		<td style='color: grey'></td>
	</tr>
</table>

