
<div style="height: 70px; background: #59955C;">
	<table>
		<tr>
			<td width="50" align='left'><img style="width: 100px; height: 50px"
				src="<?php echo base_url(); ?>/images/holi1.png"></td>
			<td align='left'
				style="margin-bottom: 20px; font-size: 21pt; position: inline; color: white; font-weight: bolder">Holidays
				Details</td>
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
	style="float: left; height: auto; background: #DBEADC; margin: 10px 0px 0px 130px; width: 75%; border: 2px solid black; border-radius: 5px;">

	<table border="1" width="100%" style="border-right: 1px solid white;"
		height="100">

		<tr style="background: #DBEADC;">
			<td align="center" colspan="5">YEAR : <select id="year"
				onclick="show_holidays_emp(this.value)"
				style="width: 100px; color: blue">
				<?php
				foreach($years as $row){
					$y=$row["year"];
					?>
					<option selected value="<?php echo $y;?>">
					<?php echo $y;?>
					</option>
					<?php
				}
				?>
			</select>
			</td>
		</tr>
	</table>
	<hr>
	<div id="contentData" style="height: 640px; overflow: scroll;">
		<table>
			<tr bgcolor="#518C9C" style="border-right: 1px solid white;">
				<td align="center" width="4%" style="border-right: 1px solid white;"><font
					color="white">S.No</font></td>
				<td align="center" style="border-right: 1px solid white;"><font
					color="white">Date</font></td>
				<td align="center" style="border-right: 1px solid white;"><font
					color="white">Description</font></td>
				<td align="center" style="border-right: 1px solid white;"><font
					color="white">Added By</font></td>
			</tr>
			<tr>

			<?php
			$counter=0;
			foreach($holidays as $row) {
				$counter++;
				$rowid="row".$counter;
				$d1=$row->holi_date;
				$d2=date("d M Y",strtotime($d1));
				print("<tr id='$rowid' class='td_rows' style='border-right:1px solid white;'>");
				print("<td align='center'><input type='text' style='' class='plain_txt' readonly='readonly' id='$counter' value='".$counter."' /></td>");
				$date_id="date".$counter;
				print("<td align='center' ><input type='text' height='' style='margin-left:0px;' class='plain_txt' id='$date_id'  value='$d2' /></td>");
				$desc_id="desc".$counter;
				print("<td align='center'><input type='text' style='' class='plain_txt' readonly='readonly' id='$desc_id' value='".$row->holi_desc."' /></td>");
				$by="by".$counter;
				print("<td align='center'><input type='text' style='' class='plain_txt' readonly='readonly' id='$by' value='".$row->addedby."' /></td>");
				print("</tr>");

			}

			echo "<input type='hidden' id='hrowcount' value='$counter' />";
			?>
		
		</table>
	</div>
</div>





<script
	type="text/javascript"
	src="<?php echo base_url(); ?>js/custom/general.js"></script>
