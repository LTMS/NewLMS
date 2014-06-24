<?php
print("<table  border='1' align='left' cellpadding='1' cellspacing='1'  class='alt_row' style='border-collapse:collapse;'>");
print("<tr bgcolor='#518C9C' id='hdr_row' style='background-color:#518C9C;color:white;border-right:1px solid white; '>");
print("<td width='3%' align='center'>S.No</td>");
print("<td width='12%' align='center'>Applied By</td>");
print("<td width='8%' align='center'>Department</td>");
print("<td width='8%' align='center'>Leave Type</td>");
print("<td width='10%' align='center'>From Date</td>");
print("<td width='5%' align='center'>No of Days</td>");
print("<td width='10%' align='center'>Status</td>");
print("<td width='17%' align='center'>Reason</td>");
print("<td width='17%' align='center'>Applied on</td>");
print("</tr>");
$counter=0;
foreach($summary as $openrow) {
	$counter++;
	$rowid="row".$counter;
	$type=$openrow["LeaveType"];
	$day=$openrow["TotalDays"];
	$d1=$openrow["FromDate"];
	$d2=$openrow["ToDate"];
	$user=$openrow["User"];

	print("<tr id='$rowid'  class='small'>");
	print("<td width='3%' align='center' ><input type='button' style='width:50px' onclick='reprocess_leave(this.value,\"$rowid\",\"$type\",\"$user\",\"$day\",\"$d1\")' value=".$openrow["LeaveID"]." /></td>");
	print("<td width='12%' align='center'>".$openrow["User"]."</td>");
	print("<td width='8%' align='center'>".$openrow["Department"]."</td>");
	print("<td width='8%' align='center'>".$openrow["LeaveType"]."</td>");
	print("<td width='10%' align='center'>".$openrow["FromDate"]."</td>");
	print("<td width='5%' align='center'>".$openrow["TotalDays"]."</td>");
	print("<td width='10%' align='center'>".$openrow["Description"]."</td>");
	print("<td width='17%' align='left'>".$openrow["Reason"]."</td>");
	print("<td width='17%' align='center'>".$openrow["AppliedTime"]."</td>");
	print("</tr>");
}
print("</table>");

print("<input type='hidden' id='TotalRows' value='$counter'>");
print("<input type='hidden' id='selected_leave_id' value=''>");
if(empty($summary))
{
	print("<div style='margin:0px 0px 0px 420px'>");
	print("<font style='font-size:2em;color:#254117; font-family:'BebasNeueRegular', Arial, Helvetica, sans-serif; >Nothing to Display...!</font>");
	print("</div>");
}
?>