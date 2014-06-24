<div id='normal_report'>
<?php
print("<table  width='100%'border='1' align='left' cellpadding='1' cellspacing='1'  class='alt_row' style='border-collapse:collapse;'>");
print("<tr bgcolor='#518C9C' id='hdr_row' style='font-weight:bold;background-color:#518C9C;color:white;border-right:1px solid black; '>");
print("<td  align='center'>ID</td>");
print("<td  align='center'>From Date</td>");
print("<td  align='center'>Type</td>");
print("<td  align='center'> Days</td>");
print("<td  align='center'>Status</td>");
print("<td  align='center'>Reason</td>");
print("<td  align='center'>Applied on</td>");
print("<td  align='center'>Remind</td>");
print("<td  align='center'>Remove</td>");
print("</tr>");
 
 
if(!empty($result))
{
	foreach($reminder as $row){
		$reminder_limit=$row["reminder_limit"];
	}
	$row=0;
	foreach($result as $openrow) {
		$row++;
		$but='B'+$row;
		$id=$openrow["LeaveID"];
		$date=date("d-m-Y", strtotime($openrow["FromDate"]));
		$days=$openrow["TotalDays"];
		$reason=$openrow["Reason"];
		$reminder_count=$openrow["ReminderCount"];
		print("<tr class='small'>");
		print("<td  align='center'>$id</td>");
		print("<td  align='center'>".$date."</td>");
		$type=$openrow["LeaveType"];
		if($type=='Casual Leave'){
			$type='CL';
		}
		else if($type=='Sick Leave'){
			$type='SL';
		}
		else if($type=='Paid Leave'){
			$type='PL';
		}
		else{
			$type='CO';
		}
		print("<td  align='center'>".$type."</td>");
		print("<td  align='center'>".$days."</td>");
		print("<td  align='center'>".$openrow["Description"]."</td>");
		print("<td  align='left'>".$reason."</td>");
		print("<td  align='center'>".date("d-m-Y", strtotime($openrow["AppliedTime"]))."</td>");

		if($reminder_limit>$reminder_count){
			print("<td id='$row' align='center'><button id='$but' onclick='SendReminder(\"$type\",\"$date\",\"$days\",\"$reason\",\"$row\",\"$but\",\"$id\")'>Send Reminder</button></td>");
		}
		else{
			print("<td  align='center'>No Reminder</td>");
		}
		print("<td  align='center'><input style='width:30px;height:30px' type='image' src='../../images/remove.png'  onclick='remove_leave(this.value)' value='$id'/></td>");

		print("</tr>");
	}
}
print("</table>");
if(empty($result))
{
	print("<div style='margin:0px 0px 0px 370px'>");
	print("<font style='font-size:2em;color:#254117; font-family:'BebasNeueRegular', Arial, Helvetica, sans-serif; >Nothing to Display...!</font>");
	print("</div");
}
?>
</div>
