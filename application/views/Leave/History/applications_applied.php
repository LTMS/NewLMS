
<div style="height: 70px; background: #59955C;">
	<table>
		<tr>
			<td width="50" align='left'><img style="width: 100px; height: 50px"
				src="<?php echo base_url(); ?>/images/leave1.png"></td>
			<td align='left'
				style="margin-bottom: 20px; font-size: 21pt; position: inline; color: white; font-weight: bolder">Pending	Leave Applications</td>
			<td style="color: white; font-size: 15pt" align="right">Hi, <b><?php echo $this->session->userdata('Emp_Name');?>
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

		print("<table style='background-color:#DBEADC;'><tr valign='top'><td width='60%' >");
		print("<div style='background-color:#DBEADC;margin:5px 0px 0px 0px;height:550px;overflow-y:scroll;width:100%;border:1px solid black ;border-radius:10px;'>");
		
		print("<table  valign='top' border='1' align='left' cellpadding='1' cellspacing='1'  class='alt_row' style='border-collapse:collapse;overflow-y:scroll;'>");
		print("<tr bgcolor='#518C9C' id='hdr_row' style='font-size:14px;font-weight:bold;background-color:#518C9C;color:white;border-right:1px solid white; '>");
		print("<td width='8%' align='center'>Applied By</td>");
		//  print("<td width='8%' align='center'>Department</td>");
		print("<td width='8%' align='center'>Leave Type</td>");
		print("<td width='10%' align='center'>From Date</td>");
		print("<td width='5%' align='center'>No of Days</td>");
		//print("<td width='10%' align='center'>Status</td>");
		print("<td width='8%' align='center'>Applied on</td>");
		print("<td align='left'>Reason</td>");
		print("<td width='15%'  align='center'>Approve / Reject</td>");
		print("</tr>");
		$counter=0;$day=0;$type='';$d1=0;$d2=0; $user='';
		foreach($result as $openrow) {
			$counter++;
			$rowid="row".$counter;			
			$app_img="app".$counter;			
			$rej_img="rej".$counter;			
			$button_row="button".$counter;			
			$leave_id=$openrow["Leave_ID"];
			$type=$openrow["Leave_Type"];
			$day=$openrow["Total_Days"];
			$d1=date("d-m-Y", strtotime($openrow["From_Date"]));
			$d2=$openrow["To_Date"];
			$user=$openrow["Emp_Name"];
			$status=$openrow["Leave_Desc"];
			$reason=$openrow["Reason"];
			$apptime=date("d-m-Y", strtotime($openrow["Applied_On"]));
			$appby=$openrow["Approved_By"];
			 
			print("<tr id='$rowid'  class='small' style='border:1 solid black;'>");
			print("<td width='4%' align='left'><input type='button'  style='width:150px;color:green' onclick='select_row(\"$counter\",\"$type\",\"$day\",\"$d1\",\"$d2\",\"$user\",this.value,\"$status\",\"$reason\",\"$apptime\",\"$appby\")' value='".$user."'> </td>");
			//print("<td width='8%' align='center'>".$openrow["Department"]."</td>");
			print("<td id='$type' width='8%' align='center'>".$status."</td>");
			print("<td width='10%' align='center'>".$d1."</td>");
			print("<td id='$day' width='5%' align='center'>".$day."</td>");
			//print("<td width='10%' align='center' style='color:red'>".$status."</td>");
			print("<td width='8%' align='center'>".$apptime."</td>");
			print("<td  align='left'>".$reason."</td>");
			print("<td  id='$button_row' align='center'><img  valign='bottom' id='$app_img' style='width:50px;height:21px;' src='../../../images/Leave/approve.png' onmouseover='change_OnMouseOver(\"$app_img\",\"approve_over.png\")' onmouseout='change_OnMouseOver(\"$app_img\",\"approve.png\")'  onclick='update_LeaveStatusApprover(\"$leave_id\",2,\"$button_row\")'/> &nbsp;&nbsp;");
			print("<img valign='bottom' id='$rej_img' style='width:50px;height:21px;'src='../../../images/Leave/reject.png' onmouseover='change_OnMouseOver(\"$rej_img\",\"reject_over.png\")' onmouseout='change_OnMouseOver(\"$rej_img\",\"reject.png\")' onclick='update_LeaveStatusApprover(\"$leave_id\",3,\"$button_row\")'/></td>");
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

?>

<input type='hidden' value=''	id='type'>
<input type='hidden' value=''	id='uname'>
<input type='hidden' value=''	id='days'>

<script	type="text/javascript" src="<?php echo base_url(); ?>js/Leave/history.js"></script>
