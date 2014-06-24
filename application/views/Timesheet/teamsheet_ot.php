<?php
print("<div style='background-color:white'>");

print("<table  width='100%' border='1' align='left' cellpadding='1' cellspacing='1'  style='border-collapse:collapse;'>");
// print("<tr style='color:red;font-size:12px;font-weight:bolder; '><td colspan='10' align='center'>The Result shows 'Total Working Hours' spent by an Employee for All Jobs between the selected Date</td></tr>");
print("<tr bgcolor='#518C9C' id='hdr_row' style='font-size:15px;font-weight:bold;background-color:#518C9C;color:white;border-right:1px solid  black; '>");
print("<td width='5%' align='center'>S.No</td>");
print("<td width='22%' align='center'>Employee Name</td>");
print("<td width='9%' align='center'>Late Hrs</td>");
print("<td width='9%' align='center'>Lunch Hrs</td>");
print("<td width='9%' align='center'>Duty Hrs</td>");
print("<td width='9%' align='center'>OT Hrs</td>");
print("<td width='9%' align='center'>Avg Duty Hrs</td>");
print("<td width='9%' align='center'>Avg OT Hrs</td>");
print("<td width='9%' align='center'>Total Hrs</td>");
print("<td width='5%' align='center'>Days</td>");
print("</tr>");

$counter=0;
foreach($history as $openrow) {
	$counter++;
	$rowid="row".$counter;

	print("<tr id='$rowid'  class='small'>");
	print("<td width='5%' align='center' > ".$counter."</td>");
	print("<td width='22%' align='center'>".$openrow["name"]."</td>");
	print("<td width='9%' align='center'>".$openrow["late"]."</td>");
	print("<td width='9%' align='center'>".$openrow["lunch"]." </td>");
	print("<td width='9%' align='center'>".$openrow["duty"]."</td>");
	print("<td width='9%' align='center'>".$openrow["ot"]." </td>");
	print("<td width='9%' align='center'>".$openrow["avgduty"]." </td>");
	print("<td width='9%' align='center'>".$openrow["avgot"]." </td>");
	print("<td width='9%' align='center'>".$openrow["total"]." </td>");
	print("<td width='10%' align='center'>".$openrow["days"]." Days</td>");
	print("</tr>");
}

foreach($tothrs as $row) {
	$days = $row["days"];
	$late = $row["late"];
	$lunch = $row["lunch"];
	$duty = $row["duty"];
	$avgduty = $row["avgduty"];
	$ot = $row["ot"];
	$avgot = $row["avgot"];
	$tot = $row["total"];
}
print("<tr style='color:white;font-size:16px;font-weight:bolder;border-color:white;background:grey '>");
print("<td colspan='2'  align='right'> TOTAL </td>");
print("<td  align='center'>".$late." Hrs</td>");
print("<td align='center'>".$lunch." Hrs</td>");
print("<td  align='center'>".$duty." Hrs</td>");
print("<td  align='center'>".$ot."  Hrs</td>");
print("<td align='center'>".$avgduty." Hrs</td>");
print("<td align='center'>".$avgot." Hrs</td>");
print("<td  align='center'>".$tot."  Hrs</td>");
print("<td  align='center'>".$days." Days</td>");
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
<script
	type="text/javascript" src="<?php echo base_url(); ?>js/custom/lms.js"></script>
