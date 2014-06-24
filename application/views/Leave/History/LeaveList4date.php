<?php
 
print("<table id='leavesTab' border='1' style='font-size:12px;border-color:white;' >");
print("<tr style='background:grey;font-size:14px;font-weight:bold;color:#EDEF85;border-color:black'>");
print("<td width='110' align='left' colspan='5'>List of Employees taken Leave on this Day</td></tr>");
	
if(!empty($result2)){
	$counter1=0;
	foreach($result2 as $row ) {
		$counter1++;
		print("<tr >");
		print("<td align='center'>$counter1</td>");
		print("<td  align='left'>".$row->User."</td>");
		print("<td  align='left'>".$row->TotalDays." Day(s)</td>");
		// print("<td  align='left'>".$row->Reason."</td>");
		//   print("<td  align='left'>".$row->LeaveStatus."</td>");
		print("</tr>");
	}
}
else {
	print("<tr style='color:red;background:white'><td colspan='4'> No one applied for Leave.!");

}
print("</table>");

?>