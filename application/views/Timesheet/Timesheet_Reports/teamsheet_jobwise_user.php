<?php
print("<div style='background-color:white'>");

print("<table width='100%' border='1' align='left' cellpadding='1' cellspacing='1'   style='border-collapse:collapse;'>");
//   print("<tr style='color:red;font-size:12px;font-weight:bolder; '><td colspan='8' align='center'>The Result shows 'Total Working Hours' spent by Employees for a given Job between the selected Date</td></tr>");
print("<tr bgcolor='#518C9C' id='hdr_row' style='font-size:15px;font-weight:bold;background-color:#518C9C;color:white;border-right:1px solid  black; '>");
print("<td width='5%' align='center'>S.No</td>");
print("<td width='20%' align='center'>Date</td>");
print("<td width='40%' align='center'>Job Description</td>");
print("<td width='10%' align='center'>Total Hours</td>");
print("</tr>");

$counter=0;
foreach($history as $openrow) {
	$counter++;
	$rowid="row".$counter;

	print("<tr id='$rowid'  class='small'>");
	print("<td width='5%' align='center'> ".$counter."</td>");
	print("<td width='10%' align='center'>".$openrow["ts_date"]."</td>");
	print("<td width='40%' align='center'>".$openrow["num"]." - ".$openrow["desc"]."</td>");
	print("<td width='10%' align='center'>".$openrow["total"]."</td>");
	print("</tr>");
}


foreach($tothrs as $row) {
	$days = $row["days"];
	$tot = $row["total"];
	$avg = $row["avg"];
}
print("<tr style='color:white;font-size:16px;font-weight:bolder;border-color:white;background:grey '>");
print("<td colspan='5'  align='center'> Total Hours / No of Days: &nbsp;&nbsp;&nbsp;   ".$tot." Hrs&nbsp; / &nbsp;".$days." Days</td>");
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
