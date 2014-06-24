<div style="height: 70px; background: #8AC5D3;">
	<p style="margin-left: 80%; padding-top: 5px; line-height: 0.5em;">
		User: <b><?php echo $this->session->userdata('fullname');?>
		</b>&nbsp;&nbsp;<img src="../../images/rightarrow1.png" width="10px"
			height="10px;" />&nbsp;&nbsp;&nbsp;<strong> <a
			href="<?php echo site_url("logincheck/logout"); ?>"
			style="color: black;" onmouseover="this.style.color='blue'"
			onmouseout="this.style.color='black'">Logout</a>
		</strong>
	</p>
	<center style="margin-bottom: 20px; font-size: 20pt; position: inline;">Apply
		For Leave</center>
</div>

<form action="upload_file.php" method="post"
	enctype="multipart/form-data">
	<label for="file">Filename:</label> <input type="file" name="file"
		id="file"><br> <input type="submit" name="submit" value="Submit">
</form>


<script
	type="text/javascript" src="<?php echo base_url(); ?>js/custom/lms.js"></script>
