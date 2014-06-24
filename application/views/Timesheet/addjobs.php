
<div style="height: 70px; background: #59955C;">
	<table>
		<tr>
			<td width="50" align='left'><img style="width: 80px; height: 50px"
				src="<?php echo base_url(); ?>/images/jobicon.png"></td>
			<td align='left'
				style="margin-bottom: 20px; font-size: 21pt; position: inline; color: white; font-weight: bolder">Manage
				Jobs</td>
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
	style="float: left; height: auto; background: #DBEADC; margin: 10px 0px 0px 30px; width: 95%; border: 0px solid black; border-radius: 0px;">

	<table style="color: red" border="2" align="center" cellpadding=""
		cellspacing="">
		<tr height="50">
			<td id="tit1" align="center" width="50%"
				style="font-size: 15px; font-weight: bolder; color: brown">Add Job
				<hr>

				<table>
					<tr id="error1" height="40" style="display: none">
						<td colspan="3" align="center">Already You have this Job.</td>
					</tr>
					<tr height="50">
						<td style="font-size: 12px; font-weight: bolder; color: black">Job
							No :<input name="job_no" id="job_no" class="input" type="text"
							style="width: 80px; height: 18px;" value=""
							onblur="check_job(this.value)">
						</td>
						<td style="font-size: 12px; font-weight: bolder; color: black">Description
							: <input placeholder='Do not use quotes' name="job_desc"
							id="job_desc" class="input" type="text"
							style="width: 220px; height: 18px;" value="">
						</td>
						<td width='20'><button onclick="clear_job(1)"
								style="font-size: 12px; color: red; font-weight: bold">Clear</button>
						</td>
					</tr>
					<tr id="row_job1" height="40">
						<td colspan="3" align="center"><button
								style="font-size: 13px; color: #006600; font-weight: bold"
								onclick="javascript:add_job('1')">Add Job</button>
						</td>
					</tr>
					<tr id="row_job2" height="40" style="display: none">
						<td colspan="3" align="center"><button
								style="font-size: 13px; font-weight: bold; color: #006600;"
								onclick="javascript:update_job('1')">Update</button>
						</td>
					</tr>
				</table>
			</td>
			<td id="tit2" align="center" width="50%"
				style="font-size: 15px; font-weight: bolder; color: brown">Add NP
				Job
				<hr>

				<table>
					<tr id="error2" height="40" style="display: none">
						<td colspan="3" align="center">Already You have this NP-Job.</td>
					</tr>
					<tr height="50">
						<td style="font-size: 12px; font-weight: bolder; color: black">Job
							No :<input name="npjob_no" id="npjob_no" class="input"
							type="text" style="width: 80px; height: 18px;" value=""
							onblur="check_npjob(this.value)">
						</td>
						<td style="font-size: 12px; font-weight: bolder; color: black">Description
							: <input placeholder='Do not use quotes' name="npjob_desc"
							id="npjob_desc" class="input" type="text"
							style="width: 220px; height: 18px;" value="">
						</td>
						<td width='20'><button onclick="clear_job(2)"
								style="font-size: 12px; color: red; font-weight: bold">Clear</button>
						</td>
					</tr>
					<tr id="row_npjob1" height="40">
						<td colspan="3" align="center"><button
								style="font-size: 13px; color: #006600; font-weight: bold"
								onclick="javascript:add_job('2')">Add NP Job</button>
						</td>
					</tr>
					<tr id="row_npjob2" height="40" style="display: none">
						<td colspan="3" align="center"><button
								style="font-size: 13px; color: #006600; font-weight: bold"
								onclick="javascript:update_job('2')">Update</button>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</div>
<table>
	<tr height="20">
		<td></td>
	</tr>
</table>
<div
	style="height: auto; margin: 10px 0px 0px 30px; width: 95%; border: 0px solid black; border-radius: 0px;">

	<div
		style="background: #DBEADC; width: 49%; border: 1px solid black; border-radius: 0px; float: left;">
		<table style="color: red" border="1" align="center">

			<tr>
				<td colspan="4" align="center" width="49%"
					style="font-size: 18px; font-weight: bolder; color: black">Jobs
					List</td>
			</tr>
			<tr>
				<td align="center"
					style="font-size: 13px; font-weight: bolder; color: black">Job No.</td>
				<td align="center"
					style="font-size: 13px; font-weight: bolder; color: black">Job
					Description</td>
				<td align="center"
					style="font-size: 13px; font-weight: bolder; color: black">Status</td>
					<?php if($this->session->userdata('userrole')=='teamleader') {?>
				<td align="center"
					style="font-size: 13px; font-weight: bolder; color: black">Edit</td>
					<?php };?>
			</tr>


			<?php
			foreach($jobs as $openrow2) {
				$id = $openrow2["job_id"];
				$job = $openrow2["job_no"];
				$desc = $openrow2["job_desc"];
				$status = $openrow2["status"];
				$value = $openrow2["enb"];
					
				?>
			<tr>
				<td style='font-size: 9pt; width: 50px; color: green' align='center'>
				<?php echo $job ?>
				</td>
				<td align='center' style='font-size: 9pt; color: green'><?php echo $desc ?>
				</td>
				<td align='center' style="font-size: 9pt; width: 70px; color: green">
					<button
						style='font-size: 9pt; font-weight: bolder; color: brown; width: 60px'
						onclick='process_jobs("<?php echo $value; ?>","<?php echo $id; ?>")'>
						<?php echo $status ?>
					</button>
				</td>
				<?php if($this->session->userdata('userrole')=='teamleader') {?>
				<td align='center' style="font-size: 9pt; width: 70px; color: red">
					<button
						style='font-size: 9pt; font-weight: bolder; color: brown; width: 40px'
						onclick='edit_jobs("<?php echo $job; ?>","<?php echo $desc; ?>","<?php echo $id; ?>")'>
						Edit</button>
				</td>
				<?php }?>
			</tr>
			<?php 		}				?>

		</table>
	</div>

	<div
		style="background: #DBEADC; width: 49%; border: 1px solid black; border-radius: 0px; float: right;">
		<table border="1">
			<tr>
				<td colspan="4" align="center" width="50%"
					style="font-size: 18px; font-weight: bolder; color: black">NP Jobs
					List</td>
			</tr>
			<tr>
				<td align="center"
					style="font-size: 13px; font-weight: bolder; color: black">Job No.</td>
				<td align="center"
					style="font-size: 13px; font-weight: bolder; color: black">Job
					Description</td>
				<td align="center"
					style="font-size: 13px; font-weight: bolder; color: black">Status</td>
					<?php if($this->session->userdata('userrole')=='teamleader') {?>
				<td align="center"
					style="font-size: 13px; font-weight: bolder; color: black">Edit</td>
					<?php 	}	?>
			</tr>

			<?php
			foreach($npjobs as $openrow3) {
				$id3 = $openrow3["id_npjobs"];
				$job3 = $openrow3["job_no"];
				$desc3 = $openrow3["job_desc"];
				$status3 = $openrow3["status"];
				$value3 = $openrow3["enb"];
					
					
				?>
			<tr>
				<td style='font-size: 9pt; width: 50px; color: green' align='center'>
				<?php echo $job3 ?>
				</td>
				<td align='center' style='font-size: 9pt; color: green'><?php echo $desc3 ?>
				</td>
				<td align='center' style="font-size: 9pt; width: 70px; color: green">
					<button
						style='font-size: 9pt; font-weight: bolder; color: brown; width: 60px'
						onclick='process_npjobs("<?php echo $value3; ?>","<?php echo $id3; ?>")'>
						<?php echo $status3 ?>
					</button>
				</td>
				<?php if($this->session->userdata('userrole')=='teamleader') {?>
				<td align='center' style="font-size: 9pt; width: 70px; color: red">
					<button
						style='font-size: 9pt; font-weight: bolder; color: brown; width: 60px'
						onclick='edit_npjobs("<?php echo $job3; ?>","<?php echo $desc3; ?>","<?php echo $id3; ?>")'>
						Edit</button>
				</td>
				<?php 	}	?>
			</tr>
			<?php 		}				?>

		</table>
	</div>
</div>
<input type="hidden"
	id="edit_id1" value="">
<input type="hidden"
	id="edit_id2" value="">

<script
	type="text/javascript"
	src="<?php echo base_url(); ?>js/Timesheet/timesheet.js"></script>
