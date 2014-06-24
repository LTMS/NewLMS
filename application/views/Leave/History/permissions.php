
<div style="height: 70px; background: #59955C;">
	<table>
		<tr>
			<td width="50" align='left'><img style="width: 100px; height: 60px"
				src="<?php echo base_url(); ?>/images/permission1.png"></td>
			<td align='left'
				style="margin-bottom: 20px; font-size: 21pt; position: inline; color: white; font-weight: bolder">Pending
				Permissions</td>
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
print(' 	<div style="height:auto;overflow:hidden; background:#DBEADC;margin:5px 0px 0px 0px;width:100%;border:1px solid black ;border-radius:10px;">');

print("<table  border='1' align='left' cellpadding='1' cellspacing='1'  class='alt_row' style='border-collapse:collapse;'>");
print("<tr bgcolor='#518C9C' id='hdr_row' style='background-color:#518C9C;color:white;border-right:1px solid white; '>");
print("<td width='10%' align='center'> ID</td>");
print("<td width='8%' align='center'>Applied By</td>");
print("<td width='10%' align='center'> Date</td>");
print("<td width='5%' align='center'>Time From</td>");
print("<td width='10%' align='center'>Req Hours</td>");
print("<td width='17%' align='center'>Reason</td>");
print("<td width='17%' align='center'>Applied on</td>");
print("</tr>");
$counter=0;$day=0;$type='';$d1=0;$d2=0; $user='';
foreach($result as $openrow) {
	$counter++;
	$id=$openrow["permission_id"];
	$hrs=$openrow["Total_Hrs"];
	$date=date("d-m-Y", strtotime($openrow["P_Date"]));
	$time=$openrow["Time_From"];
	$user=$openrow["Emp_Number"];
	$reason=$openrow["Reason"];

	print("<tr name='$id' id='$id' style='color:black'>");
	print("<td width='10%' align='center'><input type='button'  style='width:100px' onclick='process_permission(this.value,\"$date\",\"$user\")' value='".$openrow["permission_id"]."'> </td>");
	print("<td width='8%' align='center'>".$user."</td>");
	print("<td width='8%' align='center'>".$date."</td>");
	print("<td id='$type' width='8%' align='center'>".$time."</td>");
	print("<td width='10%' align='center'>".$hrs." Hrs</td>");
	print("<td id='$day' width='5%' align='center'>".$reason."</td>");
	print("<td width='10%' align='center'>".date("d-m-Y H:m:s", strtotime($openrow["Applied_Time"]))."</td>");
	print("</tr>");
}
print("</table>");

print("<input type='hidden' id='TotalRows' value='$counter'>");
print("<input type='hidden' id='selected_leave_id' value=''>");
if(empty($result))
{
	print("<div style='margin:0px 0px 0px 420px'>");
	print("<font style='font-size:2em;color:#254117; font-family:'BebasNeueRegular', Arial, Helvetica, sans-serif; >Nothing to Display...!</font>");
	print("</div>");
}
	
print("<div style='display:none;' id='sick_document'>");
print("<img width='500' height='500' id='IMG1' />");
print("</div>");

print("</div>");
?>
<?php
if($counter!=0){
	?>
<div style="margin: 0px 0px 0px 0px" align="center">
	<table align="center" style="width: 400px;">
		<tr id="buttons" style="display: none">
			<td align="center"><input type="button"
				style="width: 100px; height: 30px; font-size: 15pt; color: white; background-color: green; font-family: Tahoma"
				onclick="grantPermission('Approved')" value="Approve" /></td>
			<td align="center"><input type="button"
				style="width: 100px; height: 30px; font-size: 15pt; color: white; background-color: red; font-family: Tahoma"
				onclick="grantPermission('Rejected')" value="Reject" /></td>
		</tr>
		<tr id="button1" style="display: none">
			<td id='col_1'
				style="font-size: 15px; color: red; font-weight: bolder;"
				align="center" colspan='2'></td>
		</tr>
	</table>
</div>

	<?php }?>

<input type='hidden' value=''
	id='p_id'>
<input type='hidden' value=''
	id='p_user'>
<input type='hidden' value=''
	id='p_date'>
<script
	type="text/javascript" src="<?php echo base_url(); ?>js/custom/lms.js"></script>
