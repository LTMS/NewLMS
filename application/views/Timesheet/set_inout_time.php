
<div style="height: 70px; background: #59955C;">
	<table>
		<tr>
			<td width="50" align='left'><img style="width: 100px; height: 60px"
				src="<?php echo base_url(); ?>/images/setinout.png"></td>
			<td align='left'
				style="margin-bottom: 20px; font-size: 21pt; position: inline; color: white; font-weight: bolder">Update
				IN - OUT Time</td>
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
	style="float: left; height: auto; background: #DBEADC; margin: 5px 0px 0px 00px; width: 100%; border: 1px solid black; border-radius: 10px;">
	<div align="center" style="margin-top: 20px; margin-bottom: 10px;">
		<font size="4pt">Select Date: </font>&nbsp;&nbsp;&nbsp;&nbsp; <input
			name="date" class="input" id="date" type="text"
			style="width: 90px; height: 18px;; font-weight: bolder; font-size: 15px; color: #006600"
			value="" onchange="get_UpdatedUsers(this.value)" />
	</div>

	<hr width="100%">
	<div
		style="margin-left: 0px; margin-bottom: 0px; margin-right: 0px; margin-top: 20px;"
		id="contentData"></div>
</div>
<script
	type="text/javascript"
	src="<?php echo base_url(); ?>js/Timesheet/timesheet.js"></script>
