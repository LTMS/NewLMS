
<div style="height: 70px; background: #59955C;">
	<table>
		<tr>
			<td width="50" align='left'><img style="width: 100px; height: 50px"
				src="<?php echo base_url(); ?>/images/leavesummary1.png"></td>
			<td align='left'
				style="margin-bottom: 20px; font-size: 21pt; position: inline; color: white; font-weight: bolder">My
				Leave Summary</td>
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

<div
	style="height: auto; overflow: hidden; background: #DBEADC; margin: 5px 0px 0px 0px; width: 100%; border: 1px solid black; border-radius: 10px;">
	<table width="100%" border="0" align="left" cellpadding="0"
		style="height: 40px;">
		<tr>
			<td align="center"><select id="year"
				style="height: 20px; width: 100px; color: Brown; font-weight: bold; font-size: 13px;"
				onchange="get_my_summary();">
				<?php
				foreach($years as $row){
					$y=$row["year"];
					?>
					<option  value="<?php echo $y;?>"><?php echo $y;?>	</option>
					<?php
				}
				?>
			</select>&nbsp;&nbsp;&nbsp;&nbsp; <img align="right"
				src="<?php echo base_url(); ?>/images/print2.png"
				onclick="javascript:printSummary();"
				style="width: 50px; height: 30px; color: green" />
			</td>
		</tr>
	</table>
	<hr width="100%">
	<div id="contentData" style="height: 640px; overflow: scroll;">
	<?php
if(!empty($summary)){
		print('<div><table border="1" align="center" cellpading="0" cellspacing="0" width="100%">');
		print('<tr style="bgcolor:grey">');
		print('<td align="center" style="font-size:14px;font-weight:bold;color:Red">Month</td>');
		print('<td align="center" style="font-size:14px;font-weight:bold;color:red">Casual Leave</td>');
		print('<td align="center" style="font-size:14px;font-weight:bold;color:red">Paid Leave</td>');
		print('<td align="center" style="font-size:14px;font-weight:bold;color:red">Sick Leave</td>');
		print('<td align="center" style="font-size:14px;font-weight:bold;color:red">Comp-Off</td>');
		print('<td align="center" style="font-size:15px;font-weight:bold;color:red">Total</td>');
		print('</tr>');


		foreach($summary as $row){
			$month=$row["MonthName"];
			$cl=$row["CL"];
			$pl=$row["PL"];
			$sl=$row["SL"];
			$co=$row["CO"];
			$tot=$row["Total"];
			print('<tr>');
			print("<td align='left' style='font-size:13px;font-weight:bold;color:black'> &nbsp;&nbsp;$month</td>");
			print("<td align='center' style='font-size:13px;font-weight:bold;color:black'>$cl</td>");
			print("<td align='center' style='font-size:13px;font-weight:bold;color:black'>$pl</td>");
			print("<td align='center' style='font-size:13px;font-weight:bold;color:black'>$sl</td>");
			print("<td align='center' style='font-size:13px;font-weight:bold;color:black'>$co</td>");
			print("<td align='center' style='font-size:15px;font-weight:bold;color:black'>$tot</td>");
			print("</tr>");

		}
		$cl1=$pl1=$sl1=$co1='0';
		foreach($total as $row1){

			if($row1["CL"]!=""){
				$cl1=$row1["CL"];
				$pl1=$row1["PL"];
				$sl1=$row1["SL"];
				$co1=$row1["CO"];
				$tot1=$row1["Total"];
			}
			print('<tr style="background:white;border:1 solid black;">');
			print("<td align='center' style='font-size:16px;font-weight:bold;color:brown'>Total Days</td>");
			print("<td align='center' style='font-size:16px;font-weight:bold;color:brown'>$cl1</td>");
			print("<td align='center' style='font-size:16px;font-weight:bold;color:brown'>$pl1</td>");
			print("<td align='center' style='font-size:16px;font-weight:bold;color:brown'>$sl1</td>");
			print("<td align='center' style='font-size:16px;font-weight:bold;color:brown'>$co1</td>");
			print("<td align='center' style='font-size:24px;font-weight:bolder;color:blue'>$tot1</td>");
			print("</tr>");
		}

		print("</table>");

	}


	if(empty($summary))
	{
		print("<div style='margin:0px 0px 0px 420px'>");
		print("<font style='font-size:2em;color:#254117; font-family:'BebasNeueRegular', Arial, Helvetica, sans-serif; >Nothing to Display...!</font>");
		print("</div>");
	}
		?>
	</div>
</div>
<input	type="hidden" id="report_option"	value="Leave Summary of <?php echo $this->session->userdata('Emp_Name');?> for <?php echo date('Y');?>" />
<input	type="hidden" id="report_option1"	value="Leave Summary of <?php echo $this->session->userdata('Emp_Name');?>" />
<script	type="text/javascript" src="<?php echo base_url(); ?>js/Leave/summary.js"></script>
<script	type="text/javascript"	src="<?php echo base_url(); ?>js/Leave/lms_print.js"></script>
