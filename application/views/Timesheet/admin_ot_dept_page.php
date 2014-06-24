
<div
	style="width: 100%; border: 0px solid black; border-radius: 0px; float: center;">


	<table cellpadding="0" cellspacing="0" style="" border="1">

		<tr
			style='height: 60; font-size: 14px; color: #003333; font-weight: bold'>
			<td align='center' width='15%'>Employee Name</td>
			<td align='center'>Total Days</td>
			<td align='center' width='8%'>Holiday & Leave & Comp-OFF</td>
			<td align='center'>Working Days</td>

			<td align='center'>Expcd Working Hours</td>
			<td align='center'>In-Out captured</td>
			<td align='center'>Time Sheet Updated</td>
			<td align='center'>Actual Working Hours</td>
			<td align='center'>O-T Summary</td>

		</tr>
		<?php
		if(!empty($dept_work_details)){
			$wday=$hday=$tday=$row=$actual=0;
			foreach($dept_work_details as $openrow) {
				$row++;
				$name = $openrow["Emp"];
				$CI =& get_instance();
				$CI ->load->model('overtime_model');
				$result = $CI->otsummary_model->user_work_details($name,$from,$to);
				foreach ($result as $row){
					$hday = $row["holidays"];
					$duty = $row["dutyhrs"];
					$tday = $row["totaldays"];
					$exp = $row["exp"];
					$wday = $row["wdays"];
					$actual = $row["total"];

				}
					
				$lday = $openrow["Leaves"];
				$tsday = $openrow["Timesheet"];
				$recday = $openrow["Entry"];
				$Comp_Off = $openrow["Comp_Off"];
				$expcd=$exp-$Comp_Off;
				$profit=$actual-$expcd;
				$Comp_Count = $openrow["Comp_Count"];
				print("<tr  style='color:black;font-size:13px;height:25'>");
				print("<td align='left' width='15%'>".$name."</td>");
				print("<td align='center' >".$tday."</td>");
				print("<td align='center'>".$hday." + ". $lday."+".$Comp_Count."</td>");
				print("<td align='center'>".$wday."</td>");
				If($Comp_Off == 0){
					print("<td align='center' style='font-size:11pt;font-weight:bold'><i>".$exp."</i></td>");
				}
				else{
					print("<td align='center' style='font-size:11pt;font-weight:bold'><i>".$exp."-".$Comp_Off."=".$expcd."</i></td>");
				}
				print("<td align='center'>".$recday."</td>");
				print("<td align='center'>".$tsday."</td>");
				print("<td align='center' style='font-size:11pt;font-weight:bold'><i>".$actual."</i></td>");
				print("<td align='center' style='font-size:12pt;font-weight:bold'>".$profit."</td>");
				print("</tr>");
			}
		}

		else{

			print("<tr  style='color:red;font-size:18px'>");
			print("<td colspan='10' align='center'>Nothing to display..!</td></tr>");

		}
		?>

	</table>
</div>
