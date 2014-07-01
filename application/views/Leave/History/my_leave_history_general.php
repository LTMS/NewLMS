				
				<?php
				
				print("<table   valign='top' border='1' align='left' cellpadding='1' cellspacing='1'  class='alt_row' style='border-collapse:collapse;overflow-y:scroll;'>");
				print("<tr id='hdr_row' style='font-size:14px;font-weight:bold;background-color:#EAF1FB;color:black;border-right:1px solid black; '>");
				print("<td width='1%' align='center'>S.No</td>");
				print("<td width='8%' align='center'>Leave Type</td>");
				print("<td width='10%' align='center'>From Date</td>");
				print("<td width='8%' align='center'>No of Days</td>");
				print("<td width='10%' align='center'>Status</td>");
				print("<td width='10%' align='center'>Applied on</td>");
				print("<td width='27%' align='left'>Reason</td>");
				print("</tr>");
				$counter=0;$day=0;$type='';$d1=0;$d2=0; $user='';
				foreach($result as $openrow) {
					$counter++;
					$rowid="row".$counter;
					$emp_num=$openrow["Emp_Number"];
					$type=$openrow["Leave_Type"];
					$day=$openrow["Total_Days"];
					$d1=date("d-m-Y", strtotime($openrow["From_Date"]));
					$d2=$openrow["To_Date"];
					$status=$openrow["Description"];
					$reason=$openrow["Reason"];
					$apptime=date("d-m-Y ", strtotime($openrow["Applied_On"]));
					$appby=$openrow["Approved_By"];
					 
					print("<tr id='$rowid'  class='small'>");
					print("<td align='center' ><input type='button'  style='width:40px' onclick='select_row(\"$counter\",\"$type\",\"$day\",\"$d1\",\"$d2\",\"$user\",this.value,\"$status\",\"$reason\",\"$apptime\",\"$appby\")' value='".$counter."'> </td>");
					print("<td align='center'>".$type."</td>");
					print("<td align='center'>".$d1."</td>");
					print("<td align='center'>".$day."</td>");
					print("<td align='center'>".$status."</td>");
					print("<td align='center'>".$apptime."</td>");
					print("<td align='left'>".$reason."</td>");
					print("</tr>");
				}
				print("</table>");
				
				if(!empty($total)){	
				$cl1=$pl1=$sl1=$co1='0';
				foreach($total as $row1){

					if($row1["CL"]!=""){
						$cl1=$row1["CL"];
						$pl1=$row1["PL"];
						$sl1=$row1["SL"];
						$co1=$row1["CO"];
						$tot1=$row1["Total"];
					}
					print("<br><br><hr><br>");
					print("<table width='50%' align='center' >");
					print("<tr><td align='left' width='250' style='font-size:16px;font-weight:bold;color:#003366;font-family:Lucida Handwriting'><u>Leave Summary</u></td></tr>");
					print("<tr><td align='left' style='font-size:16px;font-weight:bold;color:#003366'>Casual Leave</td>");
					print("<td align='left' style='font-size:16px;font-weight:bold;color:#003366'>$cl1</td></tr>");
					print("<tr><td align='left' style='font-size:16px;font-weight:bold;color:#003366'>Sick Leave</td>");
					print("<td align='left' style='font-size:16px;font-weight:bold;color:#003366'>$sl1</td></tr>");
					print("<tr><td align='left' style='font-size:16px;font-weight:bold;color:#003366'>Paid Leave</td>");
					print("<td align='left' style='font-size:16px;font-weight:bold;color:#003366'>$pl1</td></tr>");
					print("<tr><td align='left' style='font-size:16px;font-weight:bold;color:#003366'>Comp-Off Leave</td>");
					print("<td align='left' style='font-size:16px;font-weight:bold;color:#003366'>$co1</td></tr>");
					print("<tr><td align='left' style='font-size:18px;font-weight:bold;color:#003366'>Total Leaves</td>");
					print("<td align='left' style='font-size:22px;font-weight:bold;color:#003366'>$tot1</td></tr>");
					print("</table>");
				}
				}	
				
					if(empty($result))
					{
						print("<div style='margin:100px 0px 10px 150px'>");
						print("<font style='font-size:2em;color:#254117; font-family:'BebasNeueRegular', Arial, Helvetica, sans-serif; >Nothing to Display...!</font>");
						print("</div>");
					}
				
				print("</table></tr></td ></div>");
				
				
				?>
				
				<input type='hidden' value=''		id='type'>
				<input type='hidden' value=''	id='uname'>
				<input type='hidden' value=''	id='days'>
	