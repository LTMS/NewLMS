
<div style="height: 70px; background: #59955C;">
	<table>
		<tr>
			<td width="50" align='left'><img style="width: 120px; height: 65px"
				src="<?php echo base_url(); ?>/images/feedback.png"></td>
			<td align='left'
				style="margin-bottom: 20px; font-size: 21pt; position: inline; color: white; font-weight: bolder">Feedback
				/ Report</td>
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



<div align="center"
	style="float: left; height: auto; background: #DBEADC; margin: 10px 0px 0px 0px; width: 100%; border: 2px solid black; border-radius: 10px;">

	<table align="center">
		<tr height='70'
			style='font-size: 18pt; color: #006699; font-weight: bolder; font-family: Lucida Handwriting'
			align='center'>
			<td colspan='2'><u>Feel free to send Feedback and to report Errors..!</u>
				<img style="width: 50px; height: 50px"
				src="<?php echo base_url(); ?>/images/penblue.png"></td>
		</tr>
		<tr height='70'>
			<td id='FEED' width='50%'
				style='font-size: 14pt; font-weight: bolder; color: #FF800D; font-family: Lucida Handwriting'
				align='right'><input type='radio' id='radio1' checked name='radio2'
				style='width: 25px; height: 25px;' onclick='showDiv("1")' />
				&nbsp;&nbsp;Send Feedback Mail</td>

			<td id='ERROR'
				style='font-size: 14pt; font-weight: bolder; font-family: Lucida Handwriting'
				align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type='radio' id='radio2' name='radio2'
				style='width: 25px; height: 25px;' onclick='showDiv("2")' />
				&nbsp;&nbsp;Send Error Mail</td>
		</tr>
	</table>
	<table>
		<tr id='Send_Feedback'>
			<td id='head' valign='top'
				style='font-weight: bolder; font-size: 12pt; color: #1F88A7; font-family: Lucida Handwriting'>Feedback:</td>
			<td align='left'><textarea id="body" name="body"
					placeholder='Do not use quotes' rows="6" cols="80"
					style='font-weight: bold; font-size: 12pt; color: #23819C; font-family: Segoe Print; background: #CFE7E2'></textarea>
			</td>
		</tr>
		<tr>
			<td
				style='font-weight: bolder; font-size: 10pt; color: #1F88A7; font-family: Lucida Handwriting; width: 128px'>Upload
				File:</td>
			<td align='left'><input
				style='width: 300px; height: 20px; font-weight: bolder; font-size: 9pt; color: #1F88A7; font-family: Tahoma'
				type="text" name="fake_section1" class="fake_section1"> <input
				type="button" class="fake_section" value="Choose Photo" /> <input
				type="file" style="display: none;" name="file" id="file"
				value="Choose Photo" accept="image/png,image/jpeg,image/jpg" />
			</td>
		</tr>
		<tr>
			<td></td>
			<td id='buttonrow'
				style='font-size: 15px; color: red; font-weight: bold'><input
				style='font-size: 12pt; font-weight: bold; color: green; width: 100px; font-family: Lucida Handwriting'
				type="button" name="submit" value="Submit" onclick="sendError()" />
			</td>
		</tr>

	</table>
	<input type='hidden' value='1' id='feed_error' />
</div>


<script
	type="text/javascript"
	src="<?php echo base_url(); ?>js/custom/general.js"></script>
<script
	type="text/javascript"
	src="<?php echo base_url(); ?>js/custom/ajaxfileupload.js"></script>
