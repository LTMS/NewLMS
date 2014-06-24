<?php
print("<div style='background-color:white'>");

print("<table width='100%' border='1' align='center' cellpadding='1' cellspacing='1'   style='border-collapse:collapse;'>");
//  print("<tr style='color:red;font-size:12px;font-weight:bolder; '><td colspan='13' align='center'>The Result shows 'Total Working Hours' spent by Employees for a given Job between the selected Date</td></tr>");
print("<tr bgcolor='#518C9C' id='hdr_row' style='font-size:15px;font-weight:bold;background-color:#518C9C;color:white;border-right:1px solid  black; '>");
print("<td  width='3%' align='center'>S.No</td>");
print("<td width='10%' align='center'>Date</td>");
print("<td  align='center'>Job Description</td>");
print("<td  align='center'>Time Spent</td>");
print("<td  align='center'>NP-Job</td>");
print("<td  align='center'>Activity</td>");
print("<td  align='center'>Description</td>");
print("</tr>");

$counter=0;
foreach($history as $openrow) {
	$counter++;
	$rowid="row".$counter;
	$date=$openrow["date1"];
	$d2=$date.',  '.date('D', strtotime($date));

	print("<tr id='$rowid'  class='small'>");
	print("<td  width='3%' align='center'> ".$counter."</td>");
	print("<td  width='10%' align='center'>$date</td>");
	print("<td  align='left'>".$openrow["job_no"]."-".$openrow["job_desc"]." </td>");
	print("<td  align='center'>".$openrow["job_time"]."</td>");
	print("<td  align='center'>".$openrow["job_np"]."</td>");
	print("<td  align='center'>".$openrow["activity"]."</td>");
	print("<td  align='left'>".$openrow["task_desc"]."</td>");
	print("</tr>");
}
foreach($tothrs as $row) {
	$days = $row["days"];
	$total = $row["total"];
}
print("<tr style='color:white;font-size:16px;font-weight:bolder;border-color:white;background:grey '>");
print("<td colspan='12'  align='center'> Days:".$days."&nbsp;&nbsp;|&nbsp;&nbsp; Total Hrs: ".$total." Hrs&nbsp;&nbsp;</td>");
print("</tr>");
 
print("</table>");



print("<hr>");
print("<br>");

if(!empty($history) && !empty($leaves))
{
	print("<table style='color:black;font-size:16px;font-weight:bolder;width:50%;'  border='1' align='left' cellpadding='0' cellspacing='0'><tr style='background:#518C9C'><td colspan='8' align='center'>Leave Days</td></tr>");

	print("<tr style='color:black;font-size:13px;'>");
	print("<td   align='center' >S.No</td>");
	print("<td   align='center'>Date</td>");
	print("<td   align='center'>Day</td>");
	print("<td   align='center'>No of days</td>");
	print("</tr>");
	 
	$counter1=0;
	foreach($leaves as $row1) {
		$counter1++;
		$days1 = $row1["days"];
		$date1 = $row1["date1"];
		$day1 = $row1["dayname1"];

		print("<tr style='color:black;font-size:12px;'>");
		print("<td   align='center'>$counter1</td>");
		print("<td   align='center'>$date1</td>");
		print("<td   align='center'>$day1</td>");
		print("<td   align='center'>$days1</td>");
		print("</tr>");
	}
	print("</table>");
}

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
