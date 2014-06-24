
<div
	style="background: white; width: 49%; border: 0px solid black; border-radius: 0px; float: left;">
	<table cellpadding="0" cellspacing="0" style="color: red" border="1"
		align="center">

		<tr>
			<td colspan="4" align="center" width="49%"
				style="font-size: 18px; font-weight: bolder; color: black">Normal
				Over Time Hours</td>
		</tr>
		<tr>
			<td align="center"
				style="font-size: 13px; font-weight: bolder; color: black">S.No</td>
			<td align="center"
				style="font-size: 13px; font-weight: bolder; color: black">Date</td>
			<td align="center"
				style="font-size: 13px; font-weight: bolder; color: black">OT Hours</td>
		</tr>


		<?php				$row=0;
		foreach($ot as $openrow) {
			$row++;
			$d = $openrow["ts_date"];
			$d1=$d.',  '.date('D', strtotime($d));
			$ot1 = $openrow["ts_ot"];

			?>
		<tr>
			<td
				style='font-size: 9pt; width: 50px; color: green; font-weight: bold'
				align='center'' ><?php echo $row ?>
			</td>
			<td
				style='font-size: 9pt; width: 50px; color: green; font-weight: bold'
				align='center'' ><?php echo $d1 ?>
			</td>
			<td align='center'
				style='font-size: 9pt; color: green; font-weight: bold''><?php echo $ot1 ?>
			</td>
		</tr>
		<tr>
		<?php 		}

		foreach($ot_tot as $openrow2) {
			$ot2 = $openrow2["total"];
			if($ot2==''){
				$ot2='00:00:00';
			}
			?>
			<td colspan="2"
				style='font-size: 12pt; width: 50px; color: green; font-weight: bold; font-weight: bold'
				' align='center'>Total</td>
			<td align='center'
				style='font-size: 12pt; color: green; font-weight: bold''><?php echo $ot2 ?>
			</td>
		</tr>
		<?php 		}				?>

	</table>
</div>

<div
	style="background: white; width: 49%; border: 0px solid black; border-radius: 0px; float: right;">
	<table cellpadding="0" cellspacing="0" border="1">
		<tr>
			<td colspan="4" align="center" width="50%"
				style="font-size: 18px; font-weight: bolder; color: black">Holidays
				Over Time Hours</td>
		</tr>
		<tr>
			<td align="center"
				style="font-size: 13px; font-weight: bolder; color: black">S.No</td>
			<td align="center"
				style="font-size: 13px; font-weight: bolder; color: black">Date</td>
			<td align="center"
				style="font-size: 13px; font-weight: bolder; color: black">OT Hours</td>
		</tr>

		<?php				$row3=0;
		foreach($holi as $openrow3) {
			$row3++;
			$d2 = $openrow3["ts_date"];
			$d3=$d2.',  '.date('D', strtotime($d2));
			$ot3 = $openrow3["ts_duty"];

			?>
		<tr>
			<td
				style='font-size: 9pt; width: 50px; color: green; font-weight: bold'
				' align='center'><?php echo $row3 ?>
			</td>
			<td
				style='font-size: 9pt; width: 50px; color: green; font-weight: bold'
				' align='center'><?php echo $d3 ?>
			</td>
			<td align='center'
				style='font-size: 9pt; color: green; font-weight: bold''><?php echo $ot3 ?>
			</td>
		</tr>
		<tr>
		<?php 		}

		foreach($holi_tot as $openrow4) {
			$ot4 = $openrow4["total"];
			if($ot4==''){
				$ot4='00:00:00';
			}

			?>
			<td colspan="2"
				style='font-size: 12pt; width: 50px; color: green; font-weight: bold'
				' align='center'>Total</td>
			<td align='center'
				style='font-size: 12pt; color: green; font-weight: bold''><?php echo $ot4 ?>
			</td>
		</tr>
		<?php 		}				?>

	</table>
</div>

