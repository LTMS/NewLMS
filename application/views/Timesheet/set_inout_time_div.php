
<table border="1" width="100%" style="border-right: 1px solid black;">
	<tr bgcolor="#518C9C"
		style="border-right: 1px solid black; font-weight: bolder; font-size: 14px">
		<td align="center" width="6%"><font color="white">S.No</font></td>
		<td align="center" width="10%"><font color="white">Time Office ID</font>
		</td>
		<td align="center" width="30%"><font color="white">Employee Name</font>
		</td>
		<td align="center"><font color="white">In Time</font></td>
		<td align="center"><font color="white">Out Time</font></td>
		<td align="center"><font color="white">Out-Date</font></td>
	</tr>
	<tr>

	<?php
	$counter=0;
	//  print("<table width='100%' height='100%' border='1' align='left' cellpadding='1' cellspacing='1' style='margin-bottom:20px'>");
	foreach($result1 as $row) {
		$counter++;
		$rowid="row".$counter;
		print("<tr id='$rowid' class='td_rows' style='border-right:1px solid black;'>");
		print("<td align='center'><input type='text' style='' class='plain_txt' readonly='readonly' id='$counter' value='".$counter."' /></td>");
		$id="id".$counter;
		print("<td align='center' ><input type='text' height='' style='margin-left:0px;' class='plain_txt' id='$id' readonly='readonly' value='".$row->timeoffice_id."' /></td>");
		$name="name".$counter;
		print("<td align='center'><input type='text'  class='plain_txt' readonly='readonly' id='$name' value='".$row->name."' /></td>");
		$inH="inH".$counter;
		$inM="inM".$counter;
		print("<td align='center' ><input type='text'  style='width:30px;font-weight:bolder;font-size:15px' id='$inH'  value='09' /> : <input type='text' 0 style='width:30px;font-weight:bolder;font-size:15px'  id='$inM' value='15' /></td>");
		$outH="outH".$counter;
		$outM="outM".$counter;
		print("<td align='center'><input type='text' style='width:30px;font-weight:bolder;font-size:15px'   id='$outH'  value='17' /> : <input type='text' 0 style='width:30px;font-weight:bolder;font-size:15px'   id='$outM' value='30' /></td>");
		$outdate="outdate".$counter;
		print("<td align='center'><input type='text' style='width:80px;font-weight:bolder;font-size:15px'  id='$outdate' value='".$row->outdate."' /></td>");
		print("</tr>");

	}

	echo "<input type='hidden' id='hrowcount' value='$counter' />";

	if($counter!=0){
		?>
	
	
	<tr>
		<td align='center' colspan="7"><input style="height: 35px"
			type='image' src="<?php echo base_url(); ?>/images/update.png"
			onclick="update_timeoffice()"></td>
	</tr>

	<?php }
	print("</table>");

	if(empty($result1))
	{
		print("<div style='margin:0px 0px 0px 420px'>");
		print("<font style='font-size:2em;color:#254117; font-family:'BebasNeueRegular', Arial, Helvetica, sans-serif; >Nothing to Display...!</font>");
		print("</div>");
	}
	?>