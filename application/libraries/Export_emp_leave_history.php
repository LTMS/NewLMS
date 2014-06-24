<?php

class Export_emp_leave_history{

	public function Export($data,$uname){
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=".date('dmY').$uname."_Leave History.xls");
		print("<table  width='100%' border='1' align='left' cellpadding='1' cellspacing='1'  class='alt_row' style='border-collapse:collapse;'>");
		print("<tr bgcolor='#518C9C' id='hdr_row' style='font-weight:bold;background-color:#518C9C;color:white;border-right:1px solid black; '>");
		print("<td  align='center'  width='3%'>S.No</td>");
		print("<td  align='center' width='80px'>Date</td>");
		print("<td  align='center' width='10%'>Leave Type</td>");
		print("<td  align='center' width='5%'> No.of Days</td>");
		//  print("<td  align='center'>Leave Status</td>");
		//	print("<td  align='center'>Applied on</td>");
		print("<td  align='center' width='22%'>Processed By</td>");
		//	print("<td  align='center'>Processed on</td>");
		print("<td  align='center'>Reason</td>");
		print("</tr>");
		$row=0;
		foreach($data as $openrow) {
			$row++;
			print("<tr style='font-size:12px'>");
			print("<td  align='center'>".$row."</td>");
			print("<td  align='center'>".date("d-m-Y", strtotime($openrow["FromDate"]))."</td>");
			$type=$openrow["LeaveType"];
			if($type=='Casual Leave'){
				$type='CL';
			}
			else if($type=='Sick Leave'){
				$type='SL';
			}
			else if($type=='Paid Leave'){
				$type='PL';
			}
			else{
				$type='CO';
			}
			print("<td  align='center'>".$type."</td>");
			print("<td  align='center'>".$openrow["TotalDays"]."</td>");
			//  print("<td  align='center'>".$openrow["Description"]."</td>");
			//   print("<td  align='center'>".date("d-m-Y", strtotime($openrow["AppliedTime"]))."</td>");
			print("<td  align='left'>".$openrow["ApprovedBy"]."</td>");
			//        print("<td  align='center'>".$openrow["ActionTime"]."</td>");
			print("<td  align='left'>".$openrow["Reason"]."</td>");
			print("</tr>");
		}
		print("</table>");
		if(empty($data))
		{
			print("<div style='margin:0px 0px 0px 370px'>");
			print("<font style='font-size:2em;color:#254117; font-family:'BebasNeueRegular', Arial, Helvetica, sans-serif; >Nothing to Display...!</font>");
			print("</div");
		}
	}
}

?>