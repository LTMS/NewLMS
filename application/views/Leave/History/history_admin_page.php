<div id='normal_report' style='display: none'>
<?php
				print("<table  width='100%' border='1' align='left' cellpadding='1' cellspacing='1'  class='alt_row' style='border-collapse:collapse;'>");
				print("<tr bgcolor='#518C9C'  style='font-weight:bold;background-color:#EAF1FB;color:black;border-right:1px solid black; '>");
				print("<td  align='center'  width='2%'>S.No</td>");
				print("<td  align='center' width='10%'>Date</td>");
				print("<td  align='center' width='8%'>Leave Type</td>");
				print("<td  align='center' width='5%'> No.of Days</td>");
				print("<td  align='center' width='22%'>Reported By</td>");
				print("<td  align='center' width='22%'>Approved By</td>");
				print("<td  align='center' width='22%'>Reason</td>");
				print("</tr>");
				$row=0;
				foreach($result as $openrow) {
					$row++;
					print("<tr style='font-size:12px'>");
					print("<td  align='left'>".$row."</td>");
					print("<td  align='center'>".date("d-m-Y", strtotime($openrow["From_Date"]))."</td>");
					print("<td  align='center'>".$openrow["Leave_Type"]."</td>");
					print("<td  align='center'>".$openrow["Total_Days"]."</td>");
					print("<td  align='left'>".$openrow["Reported_By"]."</td>");
					print("<td  align='left'>".$openrow["Approved_By"]."</td>");
					print("<td  align='left'>".$openrow["Reason"]."</td>");
					print("</tr>");
				}
				print("</table>");
				
				
				if(empty($result))	{
					print("<div style='margin:0px 0px 0px 370px'>");
					print("<font style='font-size:2em;color:#254117; font-family:'BebasNeueRegular', Arial, Helvetica, sans-serif; >Nothing to Display...!</font>");
					print("</div");
				}

?>

</div>
