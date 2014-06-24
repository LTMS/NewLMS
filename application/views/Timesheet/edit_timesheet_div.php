
<div
	style="height: auto; overflow: hidden; background: #C0F7FE; margin: 3px 0px 0px 0px; width: 100%; border: 0px solid black; border-radius: 0px;">
	<hr width="100%">
	<div
		style="margin-left: 30px; margin-bottom: 10px; margin-right: 20px; margin-top: 10px;">
		<table border="0" width="100%" style="border-right: 1px solid white;">
			<tr bgcolor="#518C9C" style="border-right: 1px solid white;">
				<td align="center" width="5%" style="border-right: 1px solid white;"><font
					color="white">S.No</font></td>
				<td align="center" style="border-right: 1px solid white;"><font
					color="white">Name</font></td>
				<td align="center" style="border-right: 1px solid white;"><font
					color="white">IN Time</font></td>
				<td align="center" style="border-right: 1px solid white;"><font
					color="white">OUT Time</font></td>
				<td align="center" style="border-right: 1px solid white;"><font
					color="white">Late</font></td>
				<td align="center" style="border-right: 1px solid white;"><font
					color="white">Lunch Hrs</font></td>
				<td align="center" style="border-right: 1px solid white;"><font
					color="white">Duty Hrs</font></td>
				<td align="center" style="border-right: 1px solid white;"><font
					color="white">OT Hrs</font></td>
				<td align="center" style="border-right: 1px solid white;"><font
					color="white">Total hrs</font></td>
				<td align="center" style="border-right: 1px solid white;"><font
					color="white">Modify</font></td>
			</tr>
			<tr>

			<?php
			$counter=0;
			foreach($timing as $row) {
				$counter++;
				$rowid="row".$counter;
				print("<tr id='$rowid' class='td_rows' style='border-right:1px solid white;'>");
				print("<td align='center'><input type='text' style='' class='plain_txt' readonly='readonly' id='$counter' value='".$counter."' /></td>");
				$name_id="name".$counter;
				print("<td align='center' ><input type='text' height='' style='margin-left:0px;' class='plain_txt' id='$name_id'  value='".$row->ts_name."' /></td>");
				$in_id="in".$counter;
				print("<td align='center'><input type='text' style='' class='plain_txt' readonly='readonly' id='$in_id' value='".$row->ts_intime."' /></td>");
				$out_id="out".$counter;
				print("<td align='center'><input type='text' style='' class='plain_txt' readonly='readonly' id='$out_id' value='".$row->ts_outtime."' /></td>");
				$late_id="late".$counter;
				print("<td align='center'><input type='text' style='' class='plain_txt' readonly='readonly' id='$late_id' value='".$row->ts_late."' /></td>");
				print("<td align='center'><input type='text' style='' class='plain_txt' readonly='readonly'  value='".$row->ts_lunch."' /></td>");
				$duty_id="duty".$counter;
				print("<td align='center'><input type='text' style='' class='plain_txt' readonly='readonly' id='$duty_id' value='".$row->ts_duty."'/></td>");
				$ot_id="ot".$counter;
				print("<td align='center'><input type='text'  style='' class='plain_txt' readonly='readonly' id='$ot_id' value='".$row->ts_ot."' /></td>");
				$total_id="total".$counter;
				print("<td align='center'><input type='text'  style='' class='plain_txt' readonly='readonly' id='$total_id' value='".$row->ts_tot_hrs."' /></td>");
				$edit_id="edit".$counter;
				print("<td align='center'><a style='' href='javascript:fill_timingValues(\"".$row->id_timesheet."\",\"".$row->ts_name."\",\"".$row->ts_intime."\",\"".$row->ts_outtime."\",\"".$row->ts_late."\",\"".$row->ts_duty."\",\"".$row->ts_ot."\",\"".$row->ts_tot_hrs."\");' id='edit_id'><font color=''>Edit </font></a></td>");
				print("</tr>");

			}


			echo "<input type='hidden' id='hrowcount' value='$counter' />";

			?>
		
		</table>
	</div>
	<?php
	if(empty($timing))
	{
		print("<div style='margin:50px 0px 0px 420px'>");
		print("<font style='font-size:2em;color:#254117; font-family:'BebasNeueRegular', Arial, Helvetica, sans-serif; >Nothing to Display...!</font>");
		print("</div>");
	}?>
</div>
<script
	type="text/javascript"
	src="<?php echo base_url(); ?>js/custom/timesheet.js"></script>
