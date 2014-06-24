
<div style="height: 70px; background: #59955C;">
	<table>
		<tr>
			<td width="50" align='left'><img style="width: 100px; height: 50px"
				src="<?php echo base_url(); ?>/images/leave1.png"></td>
			<td align='left'
				style="margin-bottom: 20px; font-size: 21pt; position: inline; color: white; font-weight: bolder">Pending
				Leave Applications</td>
			<td style="color: white; font-size: 15pt" align="right">Hi, <b><?php echo $this->session->userdata('fullname');?>
			</b> ..!</td>
			<td align="left" style="color: white; font-size: 15pt; width: 50px">
				<a href="<?php echo site_url("logincheck/logout"); ?>"><img
					style="width: 50px; height: 50px"
					src="<?php echo base_url(); ?>/images/logout2.png"> </a>
			</td>
		</tr>
	</table>
</div>


<?php
print("<div style='background-color:#DBEADC;height:350px;overflow-y:scroll;'>");

print("<table  border='1' align='left' cellpadding='1' cellspacing='1'  class='alt_row' style='border-collapse:collapse;'>");
print("<tr bgcolor='#518C9C' id='hdr_row' style='background-color:#518C9C;color:white;border-right:1px solid white; '>");
print("<td width='10%' align='center'>LeaveID</td>");
print("<td width='8%' align='center'>Applied By</td>");
print("<td width='8%' align='center'>Department</td>");
print("<td width='8%' align='center'>Leave Type</td>");
print("<td width='10%' align='center'>From Date</td>");
print("<td width='5%' align='center'>No of Days</td>");
print("<td width='10%' align='center'>Status</td>");
print("<td width='17%' align='center'>Reason</td>");
print("<td width='17%' align='center'>Applied on</td>");
print("</tr>");
$counter=0;
foreach($result as $openrow) {
	$counter++;
	$rowid="row".$counter;
	$type=$openrow["LeaveType"];
	$day=$openrow["TotalDays"];
	$d1=$openrow["FromDate"];
	$d2=$openrow["ToDate"];
	$user=$openrow["User"];

	print("<tr id='$rowid'  class='small'>");
	print("<td width='10%' align='center'><input type='button'  style='width:100px' onclick='select_row(\"$counter\",\"$type\",\"$day\",\"$d1\",\"$d2\",\"$user\",this.value)' value='".$openrow["LeaveID"]."'> </td>");
	print("<td width='8%' align='center'>".$openrow["User"]."</td>");
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
if(empty($result))
{
	print("<div style='margin:100px 0px 0px 120px'>");
	print("<font style='font-size:2em;color:#254117; font-family:'BebasNeueRegular', Arial, Helvetica, sans-serif; >Nothing to Display...!</font>");
	print("</div>");
}
	
print("</div>");
?>
<?php
if($counter!=0){
	?>
<div style="margin: 0px 0px 0px 0px" align="center">
	<table align="center" style="width: 300px;">
		<tr>
			<td align="center"><input type="button"
				style="width: 100px; height: 30px; font-size: 15pt; color: white; background-color: green; font-family: ' Tahoma"
				onclick="approve()" value="Approve" /></td>
			<td align="center"><input type="button"
				style="width: 100px; height: 30px; font-size: 15pt; color: white; background-color: red; font-family: ' Tahoma"
				onclick="reject()" value="Reject" /></td>
		</tr>
	</table>
</div>

	<?php }?>
<input type='hidden' value=''
	id='type'>
<input type='hidden' value=''
	id='uname'>
<input type='hidden' value=''
	id='days'>

<script
	type="text/javascript" src="<?php echo base_url(); ?>js/custom/lms.js"></script>
