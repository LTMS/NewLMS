	<?php
if(!empty($summary)){
		print('<div><table border="1" align="center" cellpading="0" cellspacing="0" width="100%">');
		print('<tr style="bgcolor:grey">');
		print('<td align="center" style="font-size:14px;font-weight:bold;color:Red">Month</td>');
		print('<td align="center" style="font-size:14px;font-weight:bold;color:red">Casual Leave</td>');
		print('<td align="center" style="font-size:14px;font-weight:bold;color:red">Paid Leave</td>');
		print('<td align="center" style="font-size:14px;font-weight:bold;color:red">Sick Leave</td>');
		print('<td align="center" style="font-size:14px;font-weight:bold;color:red">Comp-Off</td>');
		print('<td align="center" style="font-size:15px;font-weight:bold;color:red">Total</td>');
		print('</tr>');


		foreach($summary as $row){
			$month=$row["MonthName"];
			$cl=$row["CL"];
			$pl=$row["PL"];
			$sl=$row["SL"];
			$co=$row["CO"];
			$tot=$row["Total"];
			print('<tr>');
			print("<td align='left' style='font-size:13px;font-weight:bold;color:black'> &nbsp;&nbsp;$month</td>");
			print("<td align='center' style='font-size:13px;font-weight:bold;color:black'>$cl</td>");
			print("<td align='center' style='font-size:13px;font-weight:bold;color:black'>$pl</td>");
			print("<td align='center' style='font-size:13px;font-weight:bold;color:black'>$sl</td>");
			print("<td align='center' style='font-size:13px;font-weight:bold;color:black'>$co</td>");
			print("<td align='center' style='font-size:15px;font-weight:bold;color:black'>$tot</td>");
			print("</tr>");

		}
		$cl1=$pl1=$sl1=$co1='0';
		foreach($total as $row1){

			if($row1["CL"]!=""){
				$cl1=$row1["CL"];
				$pl1=$row1["PL"];
				$sl1=$row1["SL"];
				$co1=$row1["CO"];
				$tot1=$row1["Total"];
			}
			print('<tr style="background:white;border:1 solid black;">');
			print("<td align='center' style='font-size:16px;font-weight:bold;color:brown'>Total Days</td>");
			print("<td align='center' style='font-size:16px;font-weight:bold;color:brown'>$cl1</td>");
			print("<td align='center' style='font-size:16px;font-weight:bold;color:brown'>$pl1</td>");
			print("<td align='center' style='font-size:16px;font-weight:bold;color:brown'>$sl1</td>");
			print("<td align='center' style='font-size:16px;font-weight:bold;color:brown'>$co1</td>");
			print("<td align='center' style='font-size:24px;font-weight:bolder;color:blue'>$tot1</td>");
			print("</tr>");
		}

		print("</table>");

	}


	if(empty($summary) )
	{
		print("<div style='margin:0px 0px 0px 420px'>");
		print("<font style='font-size:2em;color:#254117; font-family:'BebasNeueRegular', Arial, Helvetica, sans-serif; >Nothing to Display...!</font>");
		print("</div>");
	}
		?>
