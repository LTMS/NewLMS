
<table width='100%' cellpadding="0" cellspacing="0" style="color: red"
	border="0">

	<tr height='20px'>
		<td></td>
	</tr>

	<?php
	$wday=$hday=$tday=$row=$actual=0;
	foreach($ot as $openrow) {
		$row++;
		$actual = $openrow["total"];
		$hday = $openrow["holidays"];
		//$sday = $openrow["sundays"];
		//$hday1 = $openrow["holidays1"];
		$duty = $openrow["dutyhrs"];
		$tday = $openrow["totaldays"];
		$lday = $openrow["leaves"];
		$exp = $openrow["exp"];
		$wday = $openrow["wdays"];
		$tsday = $openrow["tsdate"];
	}


	$profit=$actual-$exp;

	foreach($timeoffice as $openrow1) {
		$recday = $openrow1["days"];
	}
	?>

	<tr>
		<td align="right"
			style="font-size: 18px; font-weight: bold; color: #003333;">Total
			Days</td>
		<td align="center"
			style="font-size: 16px; font-weight: bolder; color: black; width: 30px">:</td>
		<td align="left"
			style="font-size: 18px; font-weight: bolder; color: #003333;"><?php echo $tday ?>
		</td>
		<!--			<?php 
				if($profit>0){
								print('<td  align="center"  rowspan="7"  style="font-size:40pt;font-weight:bolder;color:green">'.$profit.' </td>');
								print('<td  valign="bottom" rowspan="4" style="font-size:20px;font-weight:bolder;color:green;width:100px">Hrs</td>');
		
				}
				else if($profit<0){
								print('<td  align="center"  rowspan="7"  style="font-size:40pt;font-weight:bolder;color:red">'.$profit.' </td>');
							print('<td  valign="bottom" rowspan="4" style="font-size:20px;font-weight:bolder;color:red;width:100px">Hrs</td>');
		
				}
				else{
								print('<td  align="center"  rowspan="7"  style="font-size:40pt;font-weight:bolder;color:blue">'.$profit.' </td>');
							}	?>
			 -->
	</tr>
	<tr height='50px'>
		<td align="right"
			style="font-size: 18px; font-weight: bold; color: #003333">Holidays +
			Leave</td>
		<td align="center"
			style="font-size: 16px; font-weight: bolder; color: black;">:</td>
		<td align="left"
			style="font-size: 18px; font-weight: bolder; color: #003333"><?php echo $hday.' + '.$lday ?>
		</td>
	</tr>
	<tr height='50px'>
		<td align="right"
			style="font-size: 18px; font-weight: bold; color: #003333">Working
			Days</td>
		<td align="center"
			style="font-size: 16px; font-weight: bolder; color: black;">:</td>
		<td align="left"
			style="font-size: 18px; font-weight: bolder; color: #003333"><?php echo $wday ?>
		</td>
	</tr>
	<tr height='50px'>
		<td align="right" colspan='2'
			style="font-size: 18px; font-weight: bold; color: #003333"></td>
		<td align="right"
			style="font-size: 20px; font-weight: bold; color: #003333">Expcd
			Working Hours</td>
		<td align="center"
			style="font-size: 16px; font-weight: bolder; color: black; width: 22px">:</td>
		<td align="left"
			style="font-size: 20px; font-weight: bolder; color: #003333"><?php echo $exp ?>
			Hrs</td>
	</tr>
	<tr height='50px'>
		<td align="right"
			style="font-size: 18px; font-weight: bold; color: #003333">IN-OUT
			Captured</td>
		<td align="center"
			style="font-size: 16px; font-weight: bolder; color: black;">:</td>
		<td align="left"
			style="font-size: 18px; font-weight: bolder; color: #003333"><?php echo $recday ?>
			Days</td>
	</tr>
	<tr height='50px'>
		<td align="right"
			style="font-size: 18px; font-weight: bold; color: #003333">Time Sheet
			updated</td>
		<td align="center"
			style="font-size: 16px; font-weight: bolder; color: black;">:</td>
		<td align="left"
			style="font-size: 18px; font-weight: bolder; color: #003333"><?php echo $tsday ?>
			Days</td>
	</tr>
	<tr>
		<td align="right" colspan='2'
			style="font-size: 18px; font-weight: bold; color: #003333"></td>
		<td align="right"
			style="font-size: 20px; font-weight: bold; color: #003333">Actual
			Working Hours</td>
		<td align="center"
			style="font-size: 16px; font-weight: bolder; color: black; width: 22px">:</td>
		<td align="left"
			style="font-size: 20px; font-weight: bolder; color: #003333"><?php echo $actual ?>
			Hrs</td>
	</tr>
	<tr height='50px'>
		<td align="right" width='100%' colspan='5'
			style="font-size: 18px; font-weight: bold; color: #003333">-- -- --
			-- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- --
			-- -- --</td>
	</tr>
	<tr>
		<td align="right" colspan='2'
			style="font-size: 18px; font-weight: bold; color: #003333"></td>
		<td align="right"
			style="font-size: 20px; font-weight: bold; color: #003333">Net Over
			Time Hours</td>
		<td align="center"
			style="font-size: 16px; font-weight: bolder; color: black; width: 22px">:</td>
		<td align="left"
			style="font-size: 20px; font-weight: bolder; color: #003333"><?php echo $profit ?>
			Hrs</td>
	</tr>

</table>
