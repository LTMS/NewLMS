
<?php

print("<table style='background-color:#DBEADC;'><tr valign='top'><td width='60%' >");
print("<div id='history_table'  style='background-color:#DBEADC;margin:5px 0px 0px 0px;height:550px;overflow-y:scroll;width:100%;border:0px solid black ;border-radius:10px;'>");

print("<table   valign='top' border='1' align='left' cellpadding='1' cellspacing='1'  class='alt_row' style='border-collapse:collapse;overflow-y:scroll;'>");
print("<tr bgcolor='#518C9C' id='hdr_row' style='font-size:14px;font-weight:bold;background-color:#518C9C;color:white;border-right:1px solid white; '>");
print("<td width='4%' align='center'>S.No</td>");
//   print("<td width='8%' align='center'>Applied By</td>");
//  print("<td width='8%' align='center'>Department</td>");
print("<td width='8%' align='center'>Leave Type</td>");
print("<td width='10%' align='center'>From Date</td>");
print("<td width='5%' align='center'>No of Days</td>");
print("<td width='10%' align='center'>Status</td>");
//  print("<td width='17%' align='center'>Reason</td>");
// print("<td width='17%' align='center'>Applied on</td>");
print("</tr>");
$counter=0;$day=0;$type='';$d1=0;$d2=0; $user='';
foreach($result as $openrow) {
	$counter++;
	$rowid="row".$counter;
	$type=$openrow["LeaveType"];
	$day=$openrow["TotalDays"];
	$d1=date("d-m-Y", strtotime($openrow["FromDate"]));
	$d2=$openrow["ToDate"];
	$user=$openrow["User"];
	$status=$openrow["Description"];
	$reason=$openrow["Reason"];
	$apptime=date("d-m-Y H:m:s", strtotime($openrow["AppliedTime"]));
	$appby=$openrow["ApprovedBy"];
	 
	print("<tr id='$rowid'  style='font-size:12px'>");
	print("<td width='4%' align='center'><input type='button'  style='width:100px' onclick='select_row(\"$counter\",\"$type\",\"$day\",\"$d1\",\"$d2\",\"$user\",this.value,\"$status\",\"$reason\",\"$apptime\",\"$appby\")' value='".$counter."'> </td>");
	//   print("<td width='8%' align='center'>".$user."</td>");
	//  print("<td width='8%' align='center'>".$openrow["Department"]."</td>");
	print("<td id='$type' width='8%' align='center'>".$type."</td>");
	print("<td width='10%' align='center'>".$d1."</td>");
	print("<td id='$day' width='5%' align='center'>".$day."</td>");

	if($status=='Leave Applied'){
		print("<td width='10%' align='center' style='color:blue'>".$status."</td>");
	}
	else  if($status=='L1 - Rejected' || $status=='L2 - Rejected'){
		print("<td width='10%' align='center' style='color:red'>".$status."</td>");
	}
	else{
		print("<td width='10%' align='center' style='color:green'>".$status."</td>");
	}
	//   print("<td width='17%' align='left'>".$openrow["Reason"]."</td>");
	//   print("<td width='17%' align='center'>".$openrow["AppliedTime"]."</td>");
	print("</tr>");
}
print("</table>");
 
print("<input type='hidden' id='TotalRows' value='$counter'>");
print("<input type='hidden' id='selected_leave_id' value=''>");
if(empty($result))
{
	print("<div style='margin:100px 0px 10px 150px'>");
	print("<font style='font-size:2em;color:#254117; font-family:'BebasNeueRegular', Arial, Helvetica, sans-serif; >Nothing to Display...!</font>");
	print("</div>");
}

print("<div style='display:none;' id='sick_document'>");
print("<img width='500' height='500' id='IMG1' />");
print("</div>");

print("</div>");
 
print("</td >");	//style="margin:0px 0px 0px 100px"
print("<td width='40%' style='background:grey' valign='center' align='center'>");

print("<div id='Details' style='display:none;margin:5px 0px 0px 0px;'>");
	
print("<table border='0' align='center' valign='center' cellpadding='0' cellspacing='0'  style='border-collapse:collapse;'>");
print("<tr height='20%' style='background:grey;font-size:19px;font-weight:bold;color:#33FFFF;border-color:black'>");
print("<td  id='applicant' align='left' colspan='3'>Employee Name</td>");
	
print("<td  id='approved1' align='right' style='display:none' ><img style='top:210px;left:350px' width='75' height='75' src='../../images/tickmark1.png' /></td>");
print("<td  id='applied1' align='right' style='display:none'><img style='top:210px;left:350px' width='75' height='75' src='../../images/applied2.png' /></td>");
print("<td  id='rejected1' align='right' style='display:none'><img style='top:210px;left:350px' width='75' height='75' src='../../images/crossmark.png' /></td></tr>");

print("<tr height='10px' style='background:grey;border-color:black'><td colspan='4'></td></tr>");
print("<tr style='background:grey;font-size:14px;font-weight:bold;color:white;border-color:black'>");
print("<td width='20' align='left'></td>");
print("<td width='110' align='left'>Leave Type</td>");
print("<td width='10' align='left'>:</td>");
print("<td  id='type' align='left'>Casual Leave</td></tr>");

print("<tr style='background:grey;font-size:14px;font-weight:bold;color:white;border-color:black'>");
print("<td width='20' align='left'></td>");
print("<td width='100' align='left'>No of Days</td>");
print("<td width='10' align='left'>:</td>");
print("<td  id='days' align='left'>1 </td></tr>");

print("<tr style='background:grey;font-size:14px;font-weight:bold;color:white;border-color:black'>");
print("<td width='20' align='left'></td>");
print("<td width='110' align='left'>Date From</td>");
print("<td width='10' align='left'>:</td>");
print("<td  id='date1' align='left'>2014-01-01</td></tr>");
	
print("<tr style='background:grey;font-size:14px;font-weight:bold;color:white;border-color:black'>");
print("<td width='20' align='left'></td>");
print("<td width='110' align='left'>Processed By</td>");
print("<td width='10' align='left'>:</td>");
print("<td  id='appby' align='left'>Team Leader</td></tr>");
	
print("<tr style='background:grey;font-size:14px;font-weight:bold;color:white;border-color:black'>");
print("<td width='20' align='left'></td>");
print("<td width='110' align='left'>Applied Time</td>");
print("<td width='10' align='left'>:</td>");
print("<td  id='apptime' align='left'></td></tr>");
	
	
print("<tr style='background:grey;font-size:14px;font-weight:bold;color:white;border-color:black'>");
print("<td width='20' align='left'></td>");
print("<td width='110' align='left'>Reason</td>");
print("<td width='10' align='left'>:</td>");
print("<td  id='reason' align='left' >Suffering from fever. </td></tr>");
	
	
print("<tr style='background:grey;font-size:14px;font-weight:bold;color:white;border-color:black'>");
print("<td width='20' align='left'></td>");
print("<td width='110' align='left'>Recently Leave Taken</td>");
print("<td width='10' align='left'>:</td>");
print("<td  id='recent' align='left' >2013-12-31 </td></tr>");

print("<tr height='20px' align='Left' style='background:grey;border-color:black'><td></td><td colspan='3'>----------------------------------------------------------</td></tr>");
print('<tr id="buttonrow" style="display:none"><td  align="right" colspan="2"><input type="button" style="width:100px;height:30px;font-size:15pt;color:white;background-color:green; font-family:Tahoma"onclick="approve()" value="Approve"/></td> &nbsp;&nbsp;&nbsp;');
print('<td align="left" colspan="2"><input type="button" style="width:100px;height:30px;font-size:15pt;color:white; background-color:red;font-family:Tahoma"onclick="reject()"value="Reject"/></td></tr>');

print('<tr style="display:none" id="buttonrow1"><td id="buttoncol"align="center" colspan="4" style="color:yellow;font-weight:bolder"></td></tr>');
	
print("<tr style='background:grey;font-size:14px;font-weight:bold;color:white;border-color:black'>");
print("<td width='110' align='left' colspan='4'>");

print("<div id='leavesDiv' style=''>");
print("</div>");

print("</table></tr></td ></div>");

print("</tr></table>");

?>

<input type='hidden' value=''
	id='type'>
<input type='hidden' value=''
	id='uname'>
<input type='hidden' value=''
	id='days'>
<script
	type="text/javascript" src="<?php echo base_url(); ?>js/custom/lms.js"></script>
