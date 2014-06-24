
<div id='lms_intro_div'
	style="height: auto; overflow: hidden; background: #DBEADC; margin: 10px 0px 0px 0px; width: 100%; border: 1px solid #003366; border-radius: 10px;">
	<?php
	foreach($Param as $openrow) {
		$sick_tot=$openrow["sick_total"];
		$paid_tot=$openrow["paid_total"];
		$casual_tot=$openrow["casual_total"];
		$paid_exp=$openrow["paid_exp"];
		$sick_limit=$openrow["sick_limit"];
		$comp_off=$openrow["comp_off_reduct"];
		$permis=$openrow["permission_hrs"];
		$paid_min=$openrow["paid_min"];
		$paid_prior=$openrow["paid_prior"];
		$casual_month=$openrow["casual_month"];
		$comp_hrs=$openrow["hour"];
		$comp_min=$openrow["min"];
		$carry=$openrow["carry_forward"];
		if(strlen($comp_hrs)<9){
			$comp_hrs='0'.$comp_hrs;
		}
		if(strlen($comp_min)<9){
			$comp_min=''.$comp_min;
		}
		$comp=$comp_hrs.':'.$comp_min;
	}
	?>

	<table
		style='margin: 5px 0px 0px 10px; font-size: 11pt; font-weight: bolder; color: #23819C; width: 100%'>
		<tr>
			<td>
				<table align='right'>
					<tr style='font-size: 15pt; color: #9D9D00;'>
						<td>
					
					
					<tr style='font-size: 15pt; color: #9D9D00;'>
						<td><u>Casual Leave </u></td>
					</tr>
					<tr>
						<td>* You can take <font size='5px'><?php echo $casual_month;?> </font>
							Casual Leave per Month</td>
					</tr>
					<tr>
						<td>* Totally <font size='5px'><?php echo $casual_tot;?> </font>
							Casual Leaves per Year</td>
					</tr>
					<tr>
						<td height='20'></td>
					</tr>
				</table>
			</td>
			<td>
				<table align='right'>
					<tr style='font-size: 15pt; color: #9D9D00;'>
						<td><u>Sick Leave </u></td>
					</tr>
					<tr>
						<td>* You can take totally <font size='5px'><?php echo $sick_tot;?>
						</font> Sick Leaves per Year</td>
					</tr>
					<tr>
						<td>* You have to attach a Proof / Medical Document for <font
							size='5px'><?php echo $sick_limit;?> </font> Days and more</td>
					</tr>
				</table>
			</td>
		</tr>

		<tr>
			<td>
				<table align='right'>
					<tr style='font-size: 15pt; color: #9D9D00;'>
						<td>
					
					
					<tr style='font-size: 15pt; color: #9D9D00;'>
						<td><u>Paid Leave </u></td>
					</tr>
					<tr>
						<td>* You can take totally<font size='5px'> <?php echo $paid_tot;?>
						</font> Paid Leaves per Year</td>
					</tr>
					<tr>
						<td>* You are allowed to take Paid Leave minimum <font size='5px'><?php echo $paid_min;?>
						</font> Days at a time</td>
					</tr>
					<tr>
						<td>* You have to have more than <font size='5px'><?php echo $paid_exp;?>
						</font> Months Exprience</td>
					</tr>
					<tr>
						<td>* You have to apply <font size='5px'><?php echo $paid_prior;?>
						</font> days before</td>
					</tr>
				</table>
			</td>
			<td>
				<table align='right'>
					<tr style='font-size: 15pt; color: #9D9D00;'>
						<td>
					
					
					<tr style='font-size: 15pt; color: #9D9D00;'>
						<td><u>Complimentary Offer</u></td>
					</tr>
					<tr>
						<td>* You have to have minimum <font size='5px'> <?php echo $comp;?>
						</font> O-T Hours for <font size='5px'>1 </font>day Comp-Off</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td width='50%'></td>
		</tr>
		<tr>
			<td height='10'></td>
		</tr>
		<tr>
			<td>
				<table align='right'>
					<tr style='font-size: 15pt; color: #9D9D00;'>
						<td>
					
					
					<tr style='font-size: 15pt; color: #9D9D00;'>
						<td><u>Permission</u></td>
					</tr>
					<tr>
						<td>* Employees can take only <font size='5px'> <?php echo $permis;?>
						</font> Hour Permission per Month</td>
					</tr>
				</table>
			</td>
			<td align='left' width='50%' style='color: green'><input
				onclick="return false" id='intro_check' type='checkbox'
				style='width: 20px; height: 20px'
	<?php  if($carry=='YES'){	print 'checked';	} ?> /><i> <font
					id='carry_color' color="<?php if($carry!='YES'){	print 'red';	} ?>">Carry
						forward on Leaves</font> </i></td>
		</tr>


	</table>



</div>


<script type="text/javascript"
	src="<?php echo base_url(); ?>js/custom/lms.js"> </script>
