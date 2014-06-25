
<div style="height: 70px; background: #59955C;">
	<table>
		<tr>
			<td width="50" align='left'><img style="width: 150px; height: 60px"
				src="<?php echo base_url(); ?>/images/timesheet.png"></td>
			<td align='left'
				style="margin-bottom: 20px; font-size: 21pt; position: inline; color: white; font-weight: bolder">Time
				Sheet Entry</td>
			<td style="color: white; font-size: 15pt" align="right">Hi <b><?php echo $this->session->userdata('Emp_Name');?>
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
	style="float: center; height: auto; background: #DBEADC; margin: 5px 0px 0px 0px; width: 100%; border: 1px solid black; border-radius: 10px;">

	<table style="width: 100%" border="0" align="center">
		<tr>
			<td colspan="7" id="error" align="center"
				style="color: red; width: 250px; font-size: 15px; font-weight: bolder;">
			</td>
		</tr>
		<tr>
			<td colspan="7" id="error1" align="center"
				style="color: red; width: 250px; font-size: 15px; font-weight: bolder;">
			</td>
		</tr>
		<tr style="font-weight: bold">
			<td align="center">Date</td>
			<td align="center">IN Time</td>
			<td align="center">OUT Time</td>
			<td align="center">Late</td>
			<td align="center">Lunch Hrs</td>
			<td align="center">Duty Hrs</td>
			<td align="center">OT Hrs</td>
			<td align="center">Total Hrs</td>
		</tr>

		<tr style="font-weight: bold">
			<td align="center"><input name="date" class="input" id="date"
				type="text" style="width: 90px; height: 18px;" value=""
				onchange="javascript:checkDate(this.value)" /></td>
			<td align="center"><input name="intime" class="input" id="intime"
				type="text" readonly="readonly" style="width: 50px; height: 18px;"
				value="00:00" /></td>
			<td align="center"><input name="outtime" class="input" id="outtime"
				type="text" readonly="readonly" style="width: 50px; height: 18px;"
				value="00:00" /> <input name="outdate" class="input" id="outdate"
				class='plain_txt' type="text" readonly="readonly"
				style="width: 80px; height: 18px; display: none" value="" />
			</td>
			<td align="center"><input name="late" class="input" id="late"
				type="text" readonly="readonly" style="width: 50px; height: 18px;"
				value="00:00" /></td>
			<td align="center"><input name="lunch" class="input" id="lunch"
				type="text" readonly="readonly" style="width: 50px; height: 18px;"
				value="00:00" /></td>
			<td align="center"><input name="duty" class="input" id="duty"
				type="text" readonly="readonly" style="width: 50px; height: 18px;"
				value="00:00" /></td>
			<td align="center"><input name="ot" class="input" id="ot" type="text"
				readonly="readonly" style="width: 50px; height: 18px;" value="00:00" />
			</td>
			<td align="center"><input name="total" class="input" id="total"
				type="text" readonly="readonly" style="width: 50px; height: 18px;"
				value="00:00" /></td>
		</tr>
	</table>
	<hr>

	<table width="100%">
		<tr height="30" style="font-size: 12pt; color: #006600">
			<td align="center">Job Number</td>
			<td align="center">Hr : Min</td>
			<td align="center">NP Job Number</td>
			<td align="center">Activity</td>
			<td align="center">Remark</td>
		</tr>
		<tr>
			<td align="center" class="font_align"><select name="job_1" id="job_1"
				style="font-weight: bolder; height: 25px; width: 100px;">
					<option value="Nil">SELECT</option>
					<?php
					foreach($job as $work1 ){
						$job_no1=$work1["job_no"];
						echo '<option  value="'.$job_no1.'">'.$job_no1.'</option>';
					}
					?>
			</select>
			</td>
			<td align="center"><input name="job_1H" class="font_align"
				id="job_1H" type="text" style="width: 50px; height: 22px;"
				value="00" /> <input name="job_1M" class="font_align" id="job_1M"
				type="text" style="width: 50px; height: 22px;" value="00" />
			</td>
			<td align="center" class="font_align"><select name="np_1" id="np_1"
				style="font-weight: bolder; height: 26px;">
					<option selected value="Nil">SELECT</option>
					<?php
					foreach($np as $key1 ){
						$np1=$key1["job_no"];
						echo '<option value="'.$np1.'">'.$np1.'</option>';
					}?>

			</select>
			</td>
			<td align="center" class="font_align"><select name="atv_1" id="atv_1"
				style="font-weight: bolder; height: 30px;">
					<option selected value="Nil">SELECT</option>
					<?php
					foreach($activity as $engg ){
						$code=$engg["code"];
						$desc=$engg["desc"];
						echo '<option value="'.$code.'">'.$desc.'</option>';
					}
					?>
			</select>
			</td>
			<td><input placeholder='Do not use quotes' style="width: 260px"
				type="text" class="font_align" id="desc1" name="desc1"></td>
		</tr>
		<tr>
			<td align="center" class="font_align"><select name="job_2" id="job_2"
				style="font-weight: bolder; height: 25px; width: 100px;">
					<option value="Nil">SELECT</option>
					<?php
					foreach($job as $work2 ){
						$job_no2=$work2["job_no"];
						echo '<option value="'.$job_no2.'">'.$job_no2.'</option>';
					}
					?>
			</select>
			</td>
			<td align="center"><input name="job_2H" class="font_align"
				id="job_2H" type="text" style="width: 50px; height: 22px;"
				value="00" /> <input name="job_2M" class="font_align" id="job_2M"
				type="text" style="width: 50px; height: 22px;" value="00" />
			</td>
			<td align="center" class="font_align"><select name="np_2" id="np_2"
				style="font-weight: bolder; height: 26px;">
					<option selected value="Nil">SELECT</option>
					<?php
					foreach($np as $key2 ){
						$np2=$key2["job_no"];
						echo '<option value="'.$np2.'">'.$np2.'</option>';
					}?>

			</select>
			</td>
			<td align="center" class="font_align"><select name="atv_2" id="atv_2"
				style="font-weight: bolder; height: 30px;">
					<option selected value="Nil">SELECT</option>
					<?php
					foreach($activity as $engg2 ){
						$code2=$engg2["code"];
						$desc2=$engg2["desc"];
						echo '<option value="'.$code2.'">'.$desc2.'</option>';
					}
					?>
			</select>
			</td>
			<td><input placeholder='Do not use quotes' style="width: 260px"
				type="text" class="font_align" id="desc2" name="desc2"></td>
		</tr>
		<tr>
			<td align="center" class="font_align"><select name="job_3" id="job_3"
				style="font-weight: bolder; height: 25px; width: 100px;">
					<option selected value="Nil">SELECT</option>
					<?php
					foreach($job as $work3 ){
						$job_no3=$work3["job_no"];
						echo '<option value="'.$job_no3.'">'.$job_no3.'</option>';
					}
					?>
			</select>
			</td>
			<td align="center"><input name="job_3H" class="font_align"
				id="job_3H" type="text" style="width: 50px; height: 22px;"
				value="00" /> <input name="job_3M" class="font_align" id="job_3M"
				type="text" style="width: 50px; height: 22px;" value="00" />
			</td>
			<td align="center" class="font_align"><select name="np_3" id="np_3"
				style="font-weight: bolder; height: 26px;">
					<option selected value="Nil">SELECT</option>
					<?php
					foreach($np as $key3 ){
						$np3=$key3["job_no"];
						echo '<option value="'.$np3.'">'.$np3.'</option>';
					}?>

			</select>
			</td>
			<td align="center" class="font_align"><select name="atv_3" id="atv_3"
				style="font-weight: bolder; height: 30px;">
					<option selected value="Nil">SELECT</option>
					<?php
					foreach($activity as $engg3 ){
						$code3=$engg3["code"];
						$desc3=$engg3["desc"];
						echo '<option value="'.$code3.'">'.$desc3.'</option>';
					}
					?>
			</select>
			</td>
			<td><input placeholder='Do not use quotes' style="width: 260px"
				type="text" class="font_align" id="desc3" name="desc3"></td>
		</tr>
		<tr>
			<td align="center" class="font_align"><select name="job_4" id="job_4"
				style="font-weight: bolder; height: 25px; width: 100px;">
					<option selected value="Nil">SELECT</option>
					<?php
					foreach($job as $work4 ){
						$job_no4=$work4["job_no"];
						echo '<option value="'.$job_no4.'">'.$job_no4.'</option>';
					}
					?>
			</select>
			</td>
			<td align="center"><input name="job_4H" class="font_align"
				id="job_4H" type="text" style="width: 50px; height: 22px;"
				value="00" /> <input name="job_4M" class="font_align" id="job_4M"
				type="text" style="width: 50px; height: 22px;" value="00" />
			</td>
			<td align="center" class="font_align"><select name="np_4" id="np_4"
				style="font-weight: bolder; height: 26px;">
					<option selected value="Nil">SELECT</option>
					<?php
					foreach($np as $key4 ){
						$np4=$key4["job_no"];
						echo '<option value="'.$np4.'">'.$np4.'</option>';
					}
					?>

			</select>
			</td>
			<td align="center" class="font_align"><select name="atv_4" id="atv_4"
				style="font-weight: bolder; height: 30px;">
					<option selected value="Nil">SELECT</option>
					<?php
					foreach($activity as $engg4 ){
						$code4=$engg4["code"];
						$desc4=$engg4["desc"];
						echo '<option value="'.$code4.'">'.$desc4.'</option>';
					}
					?>
			</select>
			</td>
			<td><input placeholder='Do not use quotes' style="width: 260px"
				type="text" class="font_align" id="desc4" name="desc4"></td>
		</tr>
		<tr>
			<td align="center" class="font_align"><select name="job_5" id="job_5"
				style="font-weight: bolder; height: 25px; width: 100px;">
					<option selected value="Nil">SELECT</option>
					<?php
					foreach($job as $work5 ){
						$job_no5=$work5["job_no"];
						echo '<option value="'.$job_no5.'">'.$job_no5.'</option>';
					}
					?>
			</select>
			</td>
			<td align="center"><input name="job_5H" class="font_align"
				id="job_5H" type="text" style="width: 50px; height: 22px;"
				value="00" /> <input name="job_5M" class="font_align" id="job_5M"
				type="text" style="width: 50px; height: 22px;" value="00" />
			</td>
			<td align="center" class="font_align"><select name="np_5" id="np_5"
				style="font-weight: bolder; height: 26px;">
					<option selected value="Nil">SELECT</option>
					<?php
					foreach($np as $key5 ){
						$np5=$key5["job_no"];
						echo '<option value="'.$np5.'">'.$np5.'</option>';
					}?>

			</select>
			</td>
			<td align="center" class="font_align"><select name="atv_5" id="atv_5"
				style="font-weight: bolder; height: 30px;">
					<option selected value="Nil">SELECT</option>
					<?php
					foreach($activity as $engg5 ){
						$code5=$engg5["code"];
						$desc5=$engg5["desc"];
						echo '<option value="'.$code5.'">'.$desc5.'</option>';
					}
					?>
			</select>
			</td>
			<td><input placeholder='Do not use quotes' style="width: 260px"
				type="text" class="font_align" id="desc5" name="desc5"></td>
		</tr>
		<tr>
			<td align="center" class="font_align"><select name="job_6" id="job_6"
				style="font-weight: bolder; height: 25px; width: 100px;">
					<option selected value="Nil">SELECT</option>
					<?php
					foreach($job as $work6 ){
						$job_no6=$work6["job_no"];
						echo '<option value="'.$job_no6.'">'.$job_no6.'</option>';
					}
					?>
			</select>
			</td>
			<td align="center"><input name="job_6H" class="font_align"
				id="job_6H" type="text" style="width: 50px; height: 22px;"
				value="00" /> <input name="job_6M" class="font_align" id="job_6M"
				type="text" style="width: 50px; height: 22px;" value="00" />
			</td>
			<td align="center" class="font_align"><select name="np_6" id="np_6"
				style="font-weight: bolder; height: 26px;">
					<option selected value="Nil">SELECT</option>
					<?php
					foreach($np as $key6 ){
						$np6=$key6["job_no"];
						echo '<option value="'.$np6.'">'.$np6.'</option>';
					}?>

			</select>
			</td>
			<td align="center" class="font_align"><select name="atv_6" id="atv_6"
				style="font-weight: bolder; height: 30px;">
					<option selected value="Nil">SELECT</option>
					<?php
					foreach($activity as $engg6 ){
						$code6=$engg6["code"];
						$desc6=$engg6["desc"];
						echo '<option value="'.$code6.'">'.$desc6.'</option>';
					}
					?>
			</select>
			</td>
			<td><input placeholder='Do not use quotes' style="width: 260px"
				type="text" class="font_align" id="desc6" name="desc6"></td>
		</tr>
		<tr>
			<td align="center" class="font_align"><select name="job_7" id="job_7"
				style="font-weight: bolder; height: 25px; width: 100px;">
					<option selected value="Nil">SELECT</option>
					<?php
					foreach($job as $work7 ){
						$job_no7=$work7["job_no"];
						echo '<option value="'.$job_no7.'">'.$job_no7.'</option>';
					}
					?>
			</select>
			</td>
			<td align="center"><input name="job_7H" class="font_align"
				id="job_7H" type="text" style="width: 50px; height: 22px;"
				value="00" /> <input name="job_7M" class="font_align" id="job_7M"
				type="text" style="width: 50px; height: 22px;" value="00" />
			</td>
			<td align="center" class="font_align"><select name="np_7" id="np_7"
				style="font-weight: bolder; height: 26px;">
					<option selected value="Nil">SELECT</option>
					<?php
					foreach($np as $key7 ){
						$np7=$key7["job_no"];
						echo '<option value="'.$np7.'">'.$np7.'</option>';
					}?>

			</select>
			</td>
			<td align="center" class="font_align"><select name="atv_7" id="atv_7"
				style="font-weight: bolder; height: 30px;">
					<option selected value="Nil">SELECT</option>
					<?php
					foreach($activity as $engg7 ){
						$code7=$engg7["code"];
						$desc7=$engg7["desc"];
						echo '<option value="'.$code7.'">'.$desc7.'</option>';
					}
					?>
			</select>
			</td>
			<td><input placeholder='Do not use quotes' style="width: 260px"
				type="text" class="font_align" id="desc7" name="desc7"></td>
		</tr>

		<tr>
			<td id="success" align="center" colspan="7"
				style="color: green; width: 250px; font-size: 15px; font-weight: bolder;"></td>
		</tr>
		<tr id="buttonrow">
			<td colspan="7" align="center"><input style="height: 30px"
				type='image'
				src="<?php echo base_url(); ?>/images/updatetimesheet.png"
				id="button" onclick="javascript:timesheet_data();"></td>
		</tr>

	</table>
</div>



<input id="in_date"
	type="hidden" value="" />
<input id="out_date"
	type="hidden" value="" />

<script type="text/javascript"
	src="<?php echo base_url(); ?>js/Timesheet/timesheet_entry.js"> </script>
