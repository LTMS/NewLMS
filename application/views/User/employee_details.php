
<div style="height: 70px; background: #59955C;">
	<table>
		<tr>
			<td width="50" align='left'><img style="width: 120px; height: 70px"
				src="<?php echo base_url(); ?>/images/myprofile.png"></td>
			<td align='left'
				style="margin-bottom: 20px; font-size: 21pt; position: inline; color: white; font-weight: bolder">My
				Profile</td>
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
	style="height: auto; background: #DBEADC; margin: 10px 0px 0px 0px; width: 100%; border: 1px solid black; border-radius: 10px;">

	<?php
	if(!empty($details)){
		foreach($details as $openrow) {
			$name=$openrow["EmployeeName"];
			$f_name=$openrow["FatherName"];
			$gender=$openrow["Gender"];
			$dob=$openrow["DOB1"];
			$blood=$openrow["BloodGroup"];
			$subtype=$openrow["SubType"];
			$marital=$openrow["MaritalStatus"];
			$desig=$openrow["Designation"];
			$pf=$openrow["PFNumber"];
			$insur=$openrow["StarHealthID"];
				
			$ad1=$openrow["Address1"];
			$ad2=$openrow["Address2"];
			$ad3=$openrow["Address3"];
			$city=$openrow["City"];
			$state=$openrow["State"];
			$country=$openrow["Country"];
			$post=$openrow["PostCode"];
				
			$Ead1=$openrow["E_Address1"];
			$Ead2=$openrow["E_Address2"];
			$Ead3=$openrow["E_Address3"];
			$Ecity=$openrow["E_City"];
			$Estate=$openrow["E_State"];
			$Ecountry=$openrow["E_Country"];
			$Epost=$openrow["E_PostCode"];
				
			$mob=$openrow["MobileNumber"];
			$phone=$openrow["HomePhone"];
			$bank=$openrow["BankName"];
			$branch=$openrow["BankBranch"];
			$acc=$openrow["BankAccNum"];
			$status=$openrow["Status"];
			$modi=$openrow["ModifiedOn"];
				
		}

	}

	if(!empty($details1)){
		foreach($details1 as $openrow2) {
			$doj=$openrow2["doj"];
			$mail=$openrow2["email"];
		}
	}
	?>

	<?php
	if(!empty($details)){
		?>
	<table align='center'>
	<?php
	if($status=='0'){
		print("<tr height='30'><td align='center'  colspan='2' style='font-weight:bolder;color:red;font-size:12pt'>You have not updated your details.!</td></tr>");
	}
	if($status=='1'){
		print("<tr height='30'><td align='center' colspan='2' style='font-weight:bolder;color:green;font-size:12pt'><u>Details were modified on  ".$modi."</u></td></tr>");
	}
	?>

		<tr>
			<td align='center' width="50%">

				<table style="font-size: 12px;" border="0">
					<tr>
						<td><font class="font_align">Name</font></td>
						<td><input name="name" id="name" class="input" readonly="readonly"
							type="text" style="width: 160px; height: 18px; font-weight: bold"
							value="<?php echo $this->session->userdata('fullname');?>"></td>
					</tr>
					<tr>
						<td><font class="font_align">Father Name</font><font color='red'>
								*</font></td>
						<td><input name="f_name" id="f_name" class="input"
							readonly="readonly" type="text"
							style="width: 160px; height: 18px; font-weight: bold"
							value="<?php echo $f_name;?>"></td>
					</tr>
					<tr>
						<td><font class="font_align">Gender</font><font color='red'> *</font>
						</td>
						<td><select name="gender" id="gender" disabled='disabled'
							style="width: 110px; height: 24px; font-weight: bold">

							<?php if($gender='Male'){ ?>
								<option value="Male" selected>Male</option>
								<option value="Female">Female</option>
								<option value="Transgender">Transgender</option>

								<?php 			}	 if($gender=='Female'){  	?>
								<option value="Male">Male</option>
								<option value="Female" selected>Female</option>
								<option value="Transgender">Transgender</option>

								<?php } 	  if($gender=='Transgender'){  	?>

								<option value="Male">Male</option>
								<option value="Female">Female</option>
								<option value="Transgender" selected>Transgender</option>

								<?php }?>
						</select>
						</td>
					</tr>
					<tr>
						<td><font class="font_align">Blood Group</font><font color='red'>
								*</font></td>
						<td><select name="blood" id="blood" disabled='disabled'
							style="width: 60px; height: 24px; font-weight: bold">
							<?php
							print('<option selected value="'.$blood.'">'.$blood.'</option>');
							?>

								<option value="A+">A +</option>
								<option value="A-">A -</option>
								<option value="B+">B +</option>
								<option value="B-">B -</option>
								<option value="AB+">AB +</option>
								<option value="AB-">AB -</option>
								<option value="O+">O +</option>
								<option value="O-">O -</option>

						</select> &nbsp;&nbsp; <font class="font_align">Sub-Type</font>
							&nbsp; <select name="sub_blood" disabled='disabled'
							id="sub_blood"
							style="width: 65px; height: 24px; font-weight: bold">
							<?php
							print('<option selected value="'.$subtype.'">'.$subtype.'</option>');
							?>
								<option value="">Nil</option>
								<option value="A1+">A1 +</option>
								<option value="A1-">A1 -</option>
								<option value="A1B+">A1B +</option>
								<option value="A1B-">A1B -</option>
								<option value="A2+">A2 +</option>
								<option value="A2-">A2 -</option>
								<option value="A2B+">A2B +</option>
								<option value="A2B-">A2B -</option>
								<option value="B1+">B1 +</option>
						</select>
						</td>
					</tr>
					<tr>
						<td><font class="font_align">Date of Birth</font><font color='red'>
								*</font></td>
						<td><input name="dob" id="dob" class="input" disabled='disabled'
							style="width: 100px; height: 18px; font-weight: bold"
							Value="<?php echo $dob;?>"></td>
					</tr>

					<tr>
						<td><font class="font_align">Marital Status</font><font
							color='red'> *</font></td>
						<td><select name="marital" id="marital" disabled='disabled'
							style="width: 100px; height: 24px; font-weight: bold">

							<?php 	 if($marital=='Married'){  	?>
								<option value="Married" selected>Married</option>
								<option value="Unmarried">Unmarried</option>

								<?php } 	  if($marital=='Unmarried'){  	?>
								<option value="Married">Married</option>
								<option value="Unmarried" selected>Unmarried</option>

								<?php } 	  if($marital==''){  	?>
								<option value="Married">Married</option>
								<option value="Unmarried">Unmarried</option>

								<?php }?>
						</select>
						</td>
					</tr>

					<tr>
						<td><font class="font_align">Mobile Number</font><font color='red'>
								*</font></td>
						<td><input name="mobile" id="mobile" readonly="readonly"
							class="input"
							style="width: 120px; height: 18px; font-weight: bold"
							Value="<?php echo $mob;?>"></td>
					</tr>
					<tr>
						<td><font class="font_align">Home Phone / Mobile</font> <font
							color='red'> *</font></td>
						<td><input name="phone" id="phone" readonly="readonly"
							class="input"
							style="width: 120px; height: 18px; font-weight: bold"
							Value="<?php echo $phone;?>"></td>
					</tr>
					<tr>
						<td><font class="font_align">E-Mail ID</font><font color='red'> *</font>
						</td>
						<td><input name="mail" id="mail" readonly="readonly" class="input"
							style="width: 200px; height: 18px;" Value="<?php echo $mail;?>">
						</td>
					</tr>

					<tr>
						<td height='30'><font class="font_align" style='font-weight: bold'>Designation</font><font
							color='red'> *</font></td>
						<td><input name="desig" id="desig" readonly="readonly"
							class="input"
							style="width: 200px; height: 18px; font-weight: bold"
							Value="<?php echo $desig;?>"></td>
					</tr>

					<tr>
						<td height='30'><font class="font_align" style='font-weight: bold'>Date
								of Joining</font><font color='red'> *</font></td>
						<td><input name="doj" id="doj" disabled='disabled' class="input"
							style="width: 100px; height: 18px; font-weight: bold"
							Value="<?php echo $doj;?>"></td>
					</tr>
					<tr>
						<td height='30'><font class="font_align" style='font-weight: bold'>PF
								Number</font><font color='red'> *</font></td>
						<td><input name="pf" id="pf" readonly="readonly" class="input"
							style="width: 150px; height: 18px; font-weight: bold"
							Value="<?php echo $pf;?>"></td>
					</tr>
					<tr>
						<td colspan='2' height='30' readonly="readonly"
							style='font-weight: bold'><font class="font_align"><u>Bank
									Details</u> </font></td>
					</tr>

					<tr>
						<td><font class="font_align">Bank Name</font><font color='red'> *</font>
						</td>
						<td><input name="bank" id="bank" readonly="readonly" class="input"
							type="text" style="width: 200px; height: 18px; font-weight: bold"
							value="<?php echo $bank;?>"></td>
					</tr>
					<tr>
						<td><font class="font_align">Branch Name</font><font color='red'>
								*</font></td>
						<td><input name="branch" readonly="readonly" id="branch"
							class="input" type="text"
							style="width: 200px; height: 18px; font-weight: bold"
							value="<?php echo $branch;?>"></td>
					</tr>
					<tr>
						<td><font class="font_align">Account Number</font><font
							color='red'> *</font></td>
						<td><input name="accno" readonly="readonly" id="accno"
							class="input" type="text"
							style="width: 150px; height: 18px; font-weight: bold"
							value="<?php echo $acc;?>"></td>
					</tr>

				</table>
			</td>
			<td align='left' style="width: 50%">

				<table style="font-size: 12px;" border="0">
					<tr>
						<td height='40'><font class="font_align" style='font-weight: bold'>Star
								Health Insurance ID</font><font color='red'> *</font></td>
						<td><input name="insur" id="insur" readonly="readonly"
							class="input"
							style="width: 200px; height: 18px; font-weight: bold"
							Value="<?php echo $insur;?>"></td>
					</tr>

					<tr>
						<td><font class="font_align" style='font-weight: bold'>Current
								Address</font><font color='red'> *</font></td>
						<td><input name="ad1" id="ad1" class="input" readonly="readonly"
							placeholder="Address Line 1"
							style="width: 250px; height: 18px; font-weight: bold"
							Value="<?php echo $ad1;?>"></td>
					</tr>

					<tr>
						<td><font class="font_align"></font></td>
						<td><input name="ad2" id="ad2" class="input" readonly="readonly"
							placeholder="Address Line 2"
							style="width: 250px; height: 18px; font-weight: bold"
							Value="<?php echo $ad2;?>"></td>
					</tr>
					<tr>
						<td></td>
						<td><input name="ad3" id="ad3" class="input" readonly="readonly"
							placeholder="Address Line 3"
							style="width: 250px; height: 18px; font-weight: bold"
							Value="<?php echo $ad3;?>"></td>
					</tr>
					<tr>
						<td></td>
						<td><input name="city" id="city" class="input" readonly="readonly"
							placeholder="City"
							style="width: 150px; height: 18px; font-weight: bold"
							Value="<?php echo $city;?>"></td>
					</tr>
					<tr>
						<td></td>
						<td><input name="state" id="state" class="input"
							readonly="readonly" placeholder="State"
							style="width: 150px; height: 18px; font-weight: bold"
							Value="<?php echo $state;?>"></td>
					</tr>
					<tr>
						<td></td>
						<td><input name="country" id="country" class="input"
							readonly="readonly" placeholder="Country"
							style="width: 150px; height: 18px; font-weight: bold"
							Value="<?php echo $country;?>"></td>
					</tr>
					<tr>
						<td></td>
						<td><input name="post" id="post" class="input" readonly="readonly"
							placeholder="Post Code"
							style="width: 100px; height: 18px; font-weight: bold"
							Value="<?php echo $post;?>"></td>
					</tr>

					<tr height='60'>
						<td colspan='2' style='font-size: 14px; color: blue' align='left'><input
							onclick="fix_address(this.value)" name="check" id="check"
							disabled='disabled' type='checkbox'
							style="width: 30px; height: 20px; color: red">Tick if Current
							Address is same as to Permanent Address</td>
					</tr>

					<tr>
						<td><font class="font_align" style='font-weight: bold'>Permanent
								Address</font><font color='red'> *</font></td>
						<td><input name="E-ad1" id="E-ad1" class="input"
							readonly="readonly" placeholder="Address Line 1"
							style="width: 250px; height: 18px; font-weight: bold"
							Value="<?php echo $Ead1;?>"></td>
					</tr>

					<tr>
						<td><font class="font_align"></font></td>
						<td><input name="E-ad2" id="E-ad2" class="input"
							readonly="readonly" placeholder="Address Line 2"
							style="width: 250px; height: 18px; font-weight: bold"
							Value="<?php echo $Ead2;?>"></td>
					</tr>
					<tr>
						<td><font class="font_align"></font></td>
						<td><input name="E-ad3" id="E-ad3" class="input"
							readonly="readonly" placeholder="Address Line 3"
							style="width: 250px; height: 18px; font-weight: bold"
							Value="<?php echo $Ead3;?>"></td>
					</tr>
					<tr>
						<td></td>
						<td><input name="E-city" id="E-city" class="input"
							readonly="readonly" placeholder="City"
							style="width: 150px; height: 18px; font-weight: bold"
							Value="<?php echo $Ecity;?>"></td>
					</tr>
					<tr>
						<td></td>
						<td><input name="E-state" id="E-state" class="input"
							readonly="readonly" placeholder="State"
							style="width: 150px; height: 18px; font-weight: bold"
							Value="<?php echo $Estate;?>"></td>
					</tr>
					<tr>
						<td></td>
						<td><input name="E-country" id="E-country" class="input"
							readonly="readonly" placeholder="Country"
							style="width: 150px; height: 18px; font-weight: bold"
							Value="<?php echo $Ecountry;?>"></td>
					</tr>
					<tr>
						<td></td>
						<td><input name="E-post" id="E-post" class="input"
							readonly="readonly" placeholder="Post Code"
							style="width: 100px; height: 18px; font-weight: bold"
							Value="<?php echo $Epost;?>"></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr height='30'>
			<td align='center' id='error' colspan='2'
				style='font-weight: bolder; color: red; font-size: 12pt'></td>
		</tr>

		<tr>
			<td colspan='2' align='center' id='BUTTONROW1'><input type='image'
				style='width: 120px; height: 35px' src='../../images/edit.png'
				onclick='enableEditing()'></td>
		</tr>
		<tr>
			<td colspan='2' align='center' style='display: none' id='BUTTONROW2'><input
				type='image' style='width: 140px; height: 40px'
				src='../../images/submit.png' onclick='updateEmployees_Details()'></td>
		</tr>


	</table>
	<?php
	}
	else{
		?>
	<table width='100%' align='center'>
		<tr>
			<td align='right'><input type='image' src='../../images/warning.png'
				style='width: 100px; height: 100px' /></td>
			<td align='left' style='font-size: 20pt; color: red'>Please check
				Your Account was created Successfully..!</td>
		</tr>
	</table>
	<?php } ?>
</div>


<script
	type="text/javascript"
	src="<?php echo base_url(); ?>js/custom/users.js"></script>
