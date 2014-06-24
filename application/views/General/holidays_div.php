
<table>
	<tr bgcolor="#518C9C" style="border-right: 1px solid white;">
		<td align="center" width="4%" style="border-right: 1px solid white;"><font
			color="white">S.No</font></td>
		<td align="center" style="border-right: 1px solid white;"><font
			color="white">Date</font></td>
		<td align="center" style="border-right: 1px solid white;"><font
			color="white">Description</font></td>
		<td align="center" style="border-right: 1px solid white;"><font
			color="white">Added By</font></td>
		<td align="center" style="border-right: 1px solid white;"><font
			color="white">Remove</font></td>
	</tr>
	<tr>

	<?php
	$counter=0;
	foreach($holidays as $row) {
		$counter++;
		$rowid="row".$counter;
		$d1=$row->holi_date;
		$d2=date("d M Y",strtotime($d1));
		print("<tr id='$rowid' class='td_rows' style='border-right:1px solid white;'>");
		print("<td align='center'><input type='text' style='' class='plain_txt' readonly='readonly' id='$counter' value='".$counter."' /></td>");
		$date_id="date".$counter;
		print("<td align='center' ><input type='text' height='' style='margin-left:0px;' class='plain_txt' id='$date_id'  value='$d2' /></td>");
		$desc_id="desc".$counter;
		print("<td align='center'><input type='text' style='' class='plain_txt' readonly='readonly' id='$desc_id' value=\"".$row->holi_desc."\" /></td>");
		$by="by".$counter;
		print("<td align='center'><input type='text' style='' class='plain_txt' readonly='readonly' id='$by' value='".$row->addedby."' /></td>");

		print("<td align='center'><input type='button' style='color:red'   value='Remove' onclick='remove_holiday(\"".$row->holiday_id."\")'/></td>");
			
		print("</tr>");

	}

	echo "<input type='hidden' id='hrowcount' value='$counter' />";
	?>

</table>
