
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
			$comp_min='0'.$comp_min;
		}
		//	$comp=$comp_hrs.':'.$comp_min;
	}
	?>

	<table
		style='margin: 0px 0px 0px 10px; font-size: 11pt; font-weight: bolder; color: #23819C; width: 100%'>
		<tr>
			<td>
				<table align='right'>
					<tr style='font-size: 15pt; color: #9D9D00;'>
						<td>
					
					
					<tr style='font-size: 15pt; color: #9D9D00;'>
						<td><u>Casual Leave </u></td>
					</tr>
					<tr>
						<td>* Employees can take <input id='casual_month'
							style='width: 20px; height: 22px; font-size: 15pt; color: #74138C; border: none; background: #B4D1B6; font-weight: bolder'
							type='text' value='<?php echo $casual_month ;?>' />&nbsp; Casual
							Leave per Month</td>
					</tr>
					<tr>
						<td>* Totally <input id='casual_tot'
							style='width: 30px; height: 22px; font-size: 15pt; color: #74138C; border: none; background: #B4D1B6; font-weight: bolder'
							type='text' value='<?php echo $casual_tot ;?>' />&nbsp; Casual
							Leaves per Year</td>
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
						<td>* Employees can take totally <input id='sick_tot'
							style='width: 30px; height: 22px; font-size: 15pt; color: #74138C; border: none; background: #B4D1B6; font-weight: bolder'
							type='text' value='<?php echo $sick_tot ;?>' />&nbsp; Sick Leaves
							per Year</td>
					</tr>
					<tr>
						<td>* Employees have to attach a Proof / Medical Document for <input
							id='sick_proof'
							style='width: 20px; height: 22px; font-size: 15pt; color: #74138C; border: none; background: #B4D1B6; font-weight: bolder'
							type='text' value='<?php echo $sick_limit ;?>' />&nbsp; Days and
							more than that</td>
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
						<td>* Employees can take totally <input id='paid_tot'
							style='width: 30px; height: 22px; font-size: 15pt; color: #74138C; border: none; background: #B4D1B6; font-weight: bolder'
							type='text' value='<?php echo $paid_tot ;?>' />&nbsp; Paid Leaves
							per Year</td>
					</tr>
					<tr>
						<td>* Employees are allowed to take Paid Leave minimum <input
							id='paid_min'
							style='width: 30px; height: 22px; font-size: 15pt; color: #74138C; border: none; background: #B4D1B6; font-weight: bolder'
							type='text' value='<?php echo $paid_min ;?>' />&nbsp; Days at a
							time</td>
					</tr>
					<tr>
						<td>* Employees have to have more than <input id='paid_exp'
							style='width: 30px; height: 22px; height: 20px; font-size: 15pt; color: #74138C; border: none; background: #B4D1B6; font-weight: bolder'
							type='text' value='<?php echo $paid_exp ;?>' />&nbsp; Months
							Exprience</td>
					</tr>
					<tr>
						<td>* Employees have to apply <input id='paid_prior'
							style='width: 30px; height: 22px; height: 20px; font-size: 15pt; color: #74138C; border: none; background: #B4D1B6; font-weight: bolder'
							type='text' value='<?php echo $paid_prior ;?>' />&nbsp; days
							before</td>
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
						<td>* Employees have to have minimum <input id='comp_hrs'
							style='width: 30px; height: 22px; font-size: 15pt; color: #74138C; border: none; background: #B4D1B6; font-weight: bolder'
							type='text' value='<?php echo $comp_hrs ;?>' /><font size='5px'>:
						</font> <input id='comp_mins'
							style='width: 30px; height: 22px; font-size: 15pt; color: #74138C; border: none; background: #B4D1B6; font-weight: bolder'
							type='text' value='<?php echo $comp_min ;?>' /> O-T Hours for <font
							size='5px'>1 </font>day Complimentary Offer</td>
					</tr>
					<tr>
						<td height='40'></td>
					</tr>
					<tr>
						<td></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td height='10'></td>
		</tr>
		<tr>
		
		
		<tr>
			<td>
				<table align='right'>
					<tr style='font-size: 15pt; color: #9D9D00;'>
						<td>
					
					
					<tr style='font-size: 15pt; color: #9D9D00;'>
						<td><u>Permission</u></td>
					</tr>
					<tr>
						<td>* Employees can take only <input id='permis_hrs'
							style='width: 20px; height: 22px; font-size: 15pt; color: #74138C; border: none; background: #B4D1B6; font-weight: bolder'
							type='text' value='<?php echo $permis ;?>' />&nbsp; Hour
							Permission per Month</td>
					</tr>
				</table>
			</td>
			<td align='left' width='50%' style='color: green'><input
				id='intro_check' type='checkbox' style='width: 20px; height: 20px'
				onclick='check_clicked()'
	<?php  if($carry=='YES'){	print 'checked';	} ?> /><i> <font
					id='carry_color' color="<?php if($carry!='YES'){	print 'red';	} ?>">Carry
						forward on Leaves</font> </i></td>
		</tr>
		<tr>
		</tr>
		<tr>
			<td width='50%'></td>
		</tr>
		<tr>
			<td id='button_row' colspan='2' align='center'><input type='image'
				src="<?php echo base_url(); ?>/images/update.png"
				style='width: 100px; height: 25px' onclick='update_leave_param()' />
			</td>
		</tr>


	</table>



</div>


<script type="text/javascript"
	src="<?php echo base_url(); ?>js/custom/lms.js"> </script>
