
<table>
	<tr bgcolor="#518C9C" style="border-right: 1px solid white;">
		<td align="center" width="4%" style="border-right: 1px solid white;"><font
			color="white">S.No</font></td>
		<td align="center" style="border-right: 1px solid white;"><font
			color="white">Date</font></td>
		<td align="center" style="border-right: 1px solid white;"><font
			color="white">Employee Name</font></td>
		<td align="center" style="border-right: 1px solid white;"><font
			color="white">Locked On</font></td>
		<td align="center" style="border-right: 1px solid white;"><font
			color="white">Unlock</font></td>
	</tr>
	<tr>

	<?php
	if(!empty($history)){
		$counter=0;
		foreach($history as $row) {
			$counter++;
			$d1=$row->lock_date;
			$id=$row->lock_id;
			$d2=date("d M Y",strtotime($d1));
			print("<tr class='td_rows' style='border-right:1px solid white;'>");
			print("<td align='center'><input type='text' style='' class='plain_txt' readonly='readonly' value='".$counter."' /></td>");
			print("<td align='center' ><input type='text' height='' style='margin-left:0px;' class='plain_txt'  value='$d2' /></td>");
			print("<td align='center'><input type='text' style='' class='plain_txt' readonly='readonly'  value=\"".$row->lock_name."\" /></td>");
			print("<td align='center'><input type='text' style='' class='plain_txt' readonly='readonly'  value='".$row->locked_on."' /></td>");
			print("<td align='center'><input type='button' style='color:red'   value='Unlock' onclick='unlock_timesheet(\"$id\")'/></td>");

			print("</tr>");
		}
	}

	else{
		print("<tr><td colspan='6' align='center' style='font-size:10pt;font-weight:bolder;color:red'>Nothing to Display</td></tr>");
			
	}

	?>

</table>

<script
	type="text/javascript"
	src="<?php echo base_url(); ?>js/custom/timesheet.js"></script>
