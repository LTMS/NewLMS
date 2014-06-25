<?php
print("<div style='background-color:white'>");

print("<table  border='1' align='center' cellpadding='1' cellspacing='1'   style='border-collapse:collapse;'>");
//  print("<tr style='color:red;font-size:12px;font-weight:bolder; '><td colspan='13' align='center'>The Result shows 'Total Working Hours' spent by Employees for a given Job between the selected Date</td></tr>");
print("<tr bgcolor='#518C9C' id='hdr_row' style='font-size:15px;font-weight:bold;background-color:#518C9C;color:white;border-right:1px solid  black; '>");
print("<td width='3%' align='center'>S.No</td>");
print("<td width='8%' align='center'>Date</td>");
print("<td width='5%' align='center'>IN Time</td>");
print("<td width='5%' align='center'>Late Hours</td>");
//    print("<td width='5%' align='center'>Lunch Hours</td>");
print("<td width='5%' align='center'>OUT Time</td>");
print("<td width='5%' align='center'>Duty Hours</td>");
print("<td width='5%' align='center'>OT Hours</td>");
//     print("<td width='5%' align='center'>Total Hours</td>");
print("</tr>");

$counter=0;
foreach($history as $openrow) {
	$counter++;
	$rowid="row".$counter;
	$date=$openrow["date1"];
	$d2=$date.',  '.date('D', strtotime($date));

	print("<tr id='$rowid'  class='small'>");
	print("<td width='3%' align='center'> ".$counter."</td>");
	print("<td width='8%' align='center'>$d2</td>");
	print("<td width='5%' align='center'>".$openrow["ts_intime"]." </td>");
	print("<td width='5%' align='center'>".$openrow["ts_late"]."</td>");
	//	 print("<td width='5%' align='center'>".$openrow["ts_lunch"]."</td>");
	print("<td width='5%' align='center'>".$openrow["ts_outtime"]."</td>");
	print("<td width='5%' align='center'>".$openrow["ts_duty"]."</td>");
	print("<td width='5%' align='center'>".$openrow["ts_ot"]."</td>");
	//     print("<td width='5%' align='center'>".$openrow["ts_tot_hrs"]."</td>");
	print("</tr>");
}
foreach($tothrs as $row) {
	$days = $row["days"];
	$total = $row["total"];
	$duty = $row["duty"];
	$lunch = $row["lunch"];
	$ot = $row["ot"];
}
print("<tr style='color:white;font-size:16px;font-weight:bolder;border-color:white;background:grey '>");
print("<td colspan='12'  align='center'> Days:".$days."&nbsp;&nbsp;|&nbsp;&nbsp;   Duty Hrs: ".$duty."&nbsp;&nbsp;|&nbsp;&nbsp; </td>");
print("</tr>");
 
print("</table>");

print("<input type='hidden' id='TotalRows' value='$counter'>");
print("<input type='hidden' id='selected_leave_id' value=''>");

if(empty($history))
{
	print("<div style='margin:0px 0px 0px 420px'>");
	print("<font style='font-size:2em;color:#254117; font-family:'BebasNeueRegular', Arial, Helvetica, sans-serif; >Nothing to Display...!</font>");
	print("</div>");
}
	
print("</div>");
?>
<?php
if($counter!=0){
	?>


	<?php }?>
