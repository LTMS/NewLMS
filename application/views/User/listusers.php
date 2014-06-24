
<div style="height: 70px; background: #59955C;">
	<table>
		<tr>
			<td width="50" align='left'><img style="width: 100px; height: 60px"
				src="<?php echo base_url(); ?>/images/usermanage2.png"></td>
			<td align='left'
				style="margin-bottom: 20px; font-size: 21pt; position: inline; color: white; font-weight: bolder">User's
				List</td>
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
	<div style="margin-left: 40px; margin-top: 20px; border-radius: 10px;">
		<font size="2px">Search by Name</font>&nbsp;&nbsp;&nbsp;&nbsp; <input
			type="text" class="input" name="user" id="user"
			style="width: 125px; height: 24px;"
			onkeyup="javascript:searchbyname()">
	</div>
	<!--  
			<div style="margin-left: 930px"><a  href="<?php echo site_url("users/add_new_user");?>"><font color='green' size="4" >Add New User</font></a> </div>
			-->
	<hr width="100%">


	<div
		style="margin-left: 0px; margin-bottom: 10px; margin-right: 0px; margin-top: 10px;">
		<table border="0" width="100%" style="border-right: 1px solid white;">
			<tr bgcolor="#518C9C" style="border-right: 1px solid white;">
				<td align="center" width="4%" style="border-right: 1px solid white;"><font
					color="white">S.No</font></td>
				<td align="center" style="border-right: 1px solid white;"><font
					color="white">Name</font></td>
				<td align="center" style="border-right: 1px solid white;"><font
					color="white">Username</font></td>
				<!-- 
			<td align="center"  width="20%" style="border-right:1px solid white;"><font color="white">E - Mail ID</font></td>
		<td align="center"  width="8%" style="border-right:1px solid white;"><font color="white">Phone Number</font></td>
	 -->
				<td align="center" width="10%"
					style="border-right: 1px solid white;"><font color="white">User
						Role</font></td>
				<td align="center" width="10%"
					style="border-right: 1px solid white;"><font color="white">Time
						Office ID</font></td>

				<!--
			<td align="center"  style="border-right:1px solid white;"><font color="white">Added Date</font></td>
	   -->
				<td align="center" width="15%"
					style="border-right: 1px solid white;"><font color="white">Last
						Login time</font></td>
				<td align="center" style="border-right: 1px solid white;"><font
					color="white">Modify</font></td>
				<td align="center" style="border-right: 1px solid white;"><font
					color="white">Delete</font></td>
			</tr>
			<tr>

			<?php
			$counter=0;
			//  print("<table width='100%' height='100%' border='1' align='left' cellpadding='1' cellspacing='1' style='margin-bottom:20px'>");
			foreach($users as $row) {
				$counter++;
				$rowid="row".$counter;
				print("<tr id='$rowid' class='td_rows' style='border-right:1px solid white;'>");
				print("<td align='center'><input type='text' style='' class='plain_txt' readonly='readonly' id='$counter' value='".$counter."' /></td>");
				$name_id="name".$counter;
				print("<td align='center' ><input type='text' height='' style='margin-left:0px;' class='plain_txt' id='$name_id'  value='".$row->name."' /></td>");
				$uname_id="uname".$counter;
				print("<td align='center'><input type='text' style='' class='plain_txt' readonly='readonly' id='$uname_id' value='".$row->user_email."' /></td>");
				$mail_id="email".$counter;
				//   print("<td align='center'><input type='text' style='' class='plain_txt' readonly='readonly' id='$mail_id' value='".$row->email."' /></td>");
				$phone_id="phone".$counter;
				//    print("<td align='center'><input type='text' style='' class='plain_txt' readonly='readonly' id='$phone_id' value='".$row->phone_number."' /></td>");
				$role_id="role".$counter;
				print("<td align='center'><input type='text' style='' class='plain_txt' readonly='readonly' id='$role_id' value='".ucfirst($row->user_role)."'/></td>");
				$timeoffice_id="timeoffice".$counter;
				print("<td ><input type='text' style='' class='plain_txt' readonly='readonly' id='$timeoffice_id' value='".$row->timeoffice_id."' /></td>");
				$addeddate_id="added_date".$counter;
				//     print("<td align='center'><input type='text'  style='' class='plain_txt' readonly='readonly' id='$addeddate_id' value='".$row->user_date."' /></td>");
				$lastlogin_id="last_login".$counter;
				print("<td align='center'><input type='text'  style='' class='plain_txt' readonly='readonly' id='$lastlogin_id' value='".$row->user_last_login."' /></td>");
				$edit_id="edit".$counter;
				print("<td align='center'><a style='' href='javascript:updateuser(\"".$row->user_id."\");' id='edit_id'><font color=''>Edit </font></a></td>");
	   $delete_id="delete".$counter;
	   print("<td align='center' ><a style='' href='javascript:deleteuser(\"".$row->user_email."\",\"".$row->name."\");' id='delete_id'><font color='red'>X</font></a></td>");
	   print("</tr>");

			}
			//print("</table>");


			echo "<input type='hidden' id='hrowcount' value='$counter' />";
			?>
		
		</table>
	</div>
</div>
<script
	type="text/javascript"
	src="<?php echo base_url(); ?>js/custom/users.js"></script>
