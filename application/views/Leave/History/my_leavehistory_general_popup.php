				
				<?php
				
				 
	print("<div id='Details' style='display:none;margin:5px 0px 0px 0px;'>");
					
			print("<table border='0' align='center' valign='center' cellpadding='0' cellspacing='0'  style='border-collapse:collapse;'>");
				print("<tr height='20%' style='background:grey;font-size:19px;font-weight:bold;color:#33FFFF;border-color:black'>");
				print("<td  id='applicant' align='left' colspan='3'>Employee Name</td>");
					
				print("<td  id='approved1' align='right' style='display:none' ><img style='top:210px;left:350px' width='75' height='75' src='../../../images/tickmark1.png' /></td>");
				print("<td  id='applied1' align='right' style='display:none'><img style='top:210px;left:350px' width='75' height='75' src='../../../images/applied2.png' /></td>");
				print("<td  id='rejected1' align='right' style='display:none'><img style='top:210px;left:350px' width='75' height='75' src='../../../images/crossmark.png' /></td></tr>");
				
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
								print("<div id='leavesDiv'></div>");
								print("</td>");
				print("</tr>");
						
			print("</table>");
							
	print("</div>");
				
				?>
				
				<input type='hidden' value=''	id='type'>
				<input type='hidden' value=''	id='uname'>
				<input type='hidden' value=''	id='days'>
	