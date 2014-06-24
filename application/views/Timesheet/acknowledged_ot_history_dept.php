
<div
	style="width: 100%; border: 0px solid black; border-radius: 0px; float: center;">


	<table cellpadding="0" cellspacing="0" style="" border="1">

		<tr
			style='height: 60; font-size: 14px; color: #003333; font-weight: bold'>
			<td align='center' width='2%'>S.No</td>
			<td align='center' width='15%'>Employee Name</td>
			<td align='center'>Department</td>
			<td align='center'>From</td>
			<td align='center'>To</td>
			<td align='center'>OT Hours</td>
			<td align='center'>Amount / Remarks</td>
			<td align='center'>Acknowledged By</td>
			<td align='center'>Acknowledged On</td>

		</tr>
		<?php
		if(!empty($history)){
			$counter=0;
			foreach($history as $row) {
				$counter++;
				$id=$row["Ack_id"];
				$name=$row["EmployeeName"];
				$dept=$row["Dept"];
				$date1=$row["FromMonth"];
				$date2=$row["ToMonth"];
				$ot_hrs=$row["Ack_Hours"];
				$amount=$row["Ack_Amount"];
				$ack_on1=$row["Ack_on"];
				$ack_by=$row["Ack_By"];
				$ack_on=date("d M Y",strtotime($ack_on1));
				//			     	$d1=date("m",strtotime($date1));
				//			     	$d2=date("m",strtotime($date2));

				print("<tr  style='color:black;font-size:13px;height:25'>");
				print("<td align='center' width='2%'>".$counter."</td>");
				print("<td align='left' width='15%'>".$name."</td>");
				print("<td align='center' >".$dept."</td>");
				print("<td align='center' >".$date1."</td>");
				print("<td align='center'>".$date2."</td>");
				print("<td align='center'>".$ot_hrs." Hrs</td>");
				print("<td align='center'>".$amount."</td>");
				print("<td align='center'>".$ack_by."</td>");
				print("<td align='center'>$ack_on1</td>");
				print("</tr>");
			}
		}

		else{

			print("<tr  style='color:red;font-size:18px'>");
			print("<td colspan='10' align='center'>Nothing to display..!</td></tr>");

		}
		?>

	</table>
</div>
