
<div style="height: 70px; background: #59955C;">
	<table>
		<tr>
			<td width="50" align='left'><img style="width: 100px; height: 50px"
				src="<?php echo base_url(); ?>/images/reprocess.png"></td>
			<td align='left'
				style="margin-bottom: 20px; font-size: 21pt; position: inline; color: white; font-weight: bolder">Reprocess
				Approved Leaves</td>
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

<div
	style="height: auto; overflow: hidden; background: #DBEADC; margin: 5px 0px 0px 0px; width: 100%; border: 1px solid black; border-radius: 10px;">
	<div align="center" style="margin-top: 20px; margin-bottom: 10px;">
		<select id="year"
			style="height: 20px; width: 100px; color: Brown; font-weight: bold; font-size: 12px;"
			onchange="javascript:get_approved_leaves();">
			<option value="">Select Year</option>
			<?php
			foreach($years as $row){
				$y=$row["year"];
				?>
			<option value="<?php echo $y;?>">
			<?php echo $y;?>
			</option>
			<?php
			}
			?>
		</select>&nbsp;&nbsp;&nbsp;&nbsp; <select id="month"
			style="height: 20px; width: 100px; color: blue; font-weight: bold; font-size: 12px;"
			onchange="javascript:get_approved_leaves();">
			<option value="">Select Months</option>
			<option value="01">January</option>
			<option value="02">February</option>
			<option value="03">March</option>
			<option value="04">April</option>
			<option value="05">May</option>
			<option value="06">June</option>
			<option value="07">July</option>
			<option value="08">August</option>
			<option value="09">September</option>
			<option value="10">October</option>
			<option value="11">November</option>
			<option value="12">December</option>
		</select>&nbsp;&nbsp;&nbsp;&nbsp; <select id='emp'
			style="height: 20px; width: 150px; color: green; font-weight: bolder; font-size: 12px;"
			onchange="javascript:get_approved_leaves();">
			<option selected value="All Employees">All Employees</option>
			<?php
			foreach($members as $memb ){
				$emp=$memb["Name"];
				echo '<option style="font-size:12px" value="'.$emp.'">'.$emp.'</option>';
			}
			?>
		</select> &nbsp;&nbsp;
	</div>

	<hr width="100%">

	<div id="contentData"></div>

</div>

<script
	type="text/javascript" src="<?php echo base_url(); ?>js/custom/lms.js"></script>
