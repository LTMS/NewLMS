
<div style="height: 70px; background: #59955C;">
	<table>
		<tr>
			<td width="50" align='left'><img style="width: 100px; height: 60px"
				src="<?php echo base_url(); ?>/images/usermanage2.png"></td>
			<td align='left'
				style="margin-bottom: 20px; font-size: 21pt; position: inline; color: white; font-weight: bolder">Employees
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

<?php

print("<table style='background-color:#DBEADC;'><tr valign='top'><td width='50%' >");
print("<div style='background-color:#DBEADC;margin:5px 0px 0px 0px;height:700px;overflow-y:scroll;width:100%;border:1px solid black ;border-radius:10px;'>");

print("<table  valign='top' border='1' align='left' cellpadding='1' cellspacing='1'  class='alt_row' style='border-collapse:collapse;overflow-y:scroll;'>");
print("<tr bgcolor='#518C9C' id='hdr_row' style='background-color:#518C9C;color:white;border-right:1px solid white;font-weight:bold; '>");
 
print("<td width='12%' align='center'>Employee</td>");
print("<td width='8%' align='center'>Department</td>");
print("<td width='6%' align='center'>Email</td>");
print("<td width='10%' align='center'>Phone</td>");
print("<td width='14%' align='center'>DOJ</td>");

print("</tr>");
$counter=0;$father='';$gender='';$dob='';$bgs='';$martial='';$design='';$pf='';$star='';$tempaddr='';$peraddr='';$bankname='';
$bankbranch='';$bankaccount='';$homephone='';$break="";
foreach($result as $openrow) {
	$counter++;
	$rowid="row".$counter;
	$father=$openrow["FatherName"];
	$gender=$openrow["Gender"];
	$dob=$openrow["DOB"];
	$bg=$openrow["BloodGroup"];
	$sbg=$openrow["SubType"];
	if($sbg!=""){
		$bgs=$bg." [ ".$sbg." ]";
	}
	else{
		$bgs=$bg;
	}
	 
	$martial=$openrow["MaritalStatus"];
	$design=$openrow["Designation"];
	$pf=$openrow["PFNumber"];
	$star=$openrow["StarHealthID"];
	$homephone=$openrow["HomePhone"];
	$bankname=$openrow["BankName"];
	$bankbranch=$openrow["BankBranch"];
	$bankaccount=$openrow["BankAccNum"];
	$homephone=$openrow["HomePhone"];
	 
	$tempaddr=$openrow["Address1"].",<br>".$openrow["Address2"].",<br>".$openrow["Address3"].",<br>".$openrow["City"]." - ".$openrow["PostCode"].",<br>".$openrow["State"].", ".$openrow["Country"].".<br>";
	$peraddr=$openrow["E_Address1"].",<br>".$openrow["E_Address2"].",<br>".$openrow["E_Address3"].",<br>".$openrow["E_City"]." - ".$openrow["E_PostCode"].",<br>".$openrow["E_State"].", ".$openrow["E_Country"].".<br>";
	print("<tr id='$rowid'  class='small'>");
	print("<td width='12%' align='center' ><input type='button'  style='width:120px;' onclick='individual_details(\"$counter\",\"$father\",\"$gender\",\"$dob\",\"$bgs\",\"$martial\",this.value,\"$design\",\"$pf\",\"$star\",\"$homephone\",\"$tempaddr\",\"$peraddr\",\"$bankname\",\"$bankbranch\",\"$bankaccount\")' value='".$openrow["EmployeeName"]."'> </td>");

	Print("<td width='8%' align='center' >".$openrow["Department"]."</td>");
	print("<td id='' width='6%' align='center'  >".$openrow["email"]."</td>");
	print("<td width='10%' align='center'  >".$openrow["MobileNumber"]."</td>");
	print("<td id='' width='14%' align='center'  >".$openrow["JoiningDate"]."</td>");


	 
	print("</tr>");
}
print("</table>");
 
print("<input type='hidden' id='TotalRows' value='$counter'>");
print("<input type='hidden' id='selected_leave_id' value=''>");
if(empty($result))
{
	print("<div style='margin:100px 0px 10px 150px'>");
	print("<font style='font-size:2em;color:white; font-family:'BebasNeueRegular', Arial, Helvetica, sans-serif; >Nothing to Display...!</font>");
	print("</div>");
}

print("</div>");
 
print("</td >");	//style="margin:0px 0px 0px 100px"
print("<td width='40%' style='background:grey' valign='center' align='center'>");

print("<div id='Details' style='display:none;margin:5px 0px 0px 0px;'>");
print("<img style='height:120px;width:150px;margin:200px 0px 0px 0px;' src='../../images/warning.png' id='warning' />");
print("<div id='updation' style='display:none;margin:10px 0px 0px 0px;font-weight:bold;color:#00ffff;font-size:24px;font-family:calibri,Georgia,Serif;'></div>");

print("<table border='0' width ='50%' align='center' valign='center' cellpadding='0' cellspacing='0'  style='border-collapse:collapse;'>");
print("<tr height='20%' style='background:grey;'>");
print("<td id='Employee' align='left' colspan='3' style='font-size:25px;font-family:calibri,Georgia,Serif;font-weight:bold;color:#00ffff;border-color:black'>Employee Name</td>");
	
print("<td  id='female' align='right' style='display:none;' ><img style='height:80px;width:150px;' src='../../images/woman.png' /></td>");
print("<td  id='male' align='right' style='display:none;' ><img style='height:80px;width:150px;' src='../../images/men.png' /></td>");
print("<tr height='10px' style='background:grey;border-color:black'><td colspan='4'></td></tr>");
print("<tr style='background:grey;font-size:18px;font-family:calibri,Georgia,Serif;font-weight:bold;color:white;border-color:black' id='father_row'>");
print("<td width='5%' align='left'></td>");
print("<td width='40%' align='left'>Father Name</td>");
print("<td width='5%' align='left'>:</td>");
print("<td  id='father' width='50%' align='left'>Casual Leave</td></tr>");

print("<tr style='background:grey;font-size:18px;font-family:calibri,Georgia,Serif;font-weight:bold;color:white;border-color:black' id='gender_row'>");
print("<td width='20' align='left'></td>");
print("<td width='100' align='left'>Gender</td>");
print("<td width='10' align='left'>:</td>");
print("<td  id='gender' align='left'>1 </td></tr>");

print("<tr style='background:grey;font-size:18px;font-family:calibri,Georgia,Serif;font-weight:bold;color:white;border-color:black' id='dob_row'>");
print("<td width='20' align='left'></td>");
print("<td width='110' align='left'>DOB</td>");
print("<td width='10' align='left'>:</td>");
print("<td  id='dob' align='left'>2014-01-01</td></tr>");
	
print("<tr style='background:grey;font-size:18px;font-family:calibri,Georgia,Serif;font-weight:bold;color:white;border-color:black' id='BGS_row'>");
print("<td width='20' align='left'></td>");
print("<td width='110' align='left'>Blood Group</td>");
print("<td width='10' align='left'>:</td>");
print("<td  id='BGS' align='left'>Team Leader</td></tr>");
	
print("<tr style='background:grey;font-size:18px;font-family:calibri,Georgia,Serif;font-weight:bold;color:white;border-color:black' id='martial_row'>");
print("<td width='20' align='left'></td>");
print("<td width='110' align='left'>Martial Status</td>");
print("<td width='10' align='left'>:</td>");
print("<td  id='martial' align='left'></td></tr>");
	
	
print("<tr style='background:grey;font-size:18px;font-family:calibri,Georgia,Serif;font-weight:bold;color:white;border-color:black' id='design_row'>");
print("<td width='20' align='left'></td>");
print("<td width='110' align='left'>Designation</td>");
print("<td width='10' align='left'>:</td>");
print("<td  id='design' align='left' >Suffering from fever. </td></tr>");
	
	
print("<tr style='background:grey;font-size:18px;font-family:calibri,Georgia,Serif;font-weight:bold;color:white;border-color:black' id='PF_row'>");
print("<td width='20' align='left'></td>");
print("<td width='110' align='left'>PF Number</td>");
print("<td width='10' align='left'>:</td>");
print("<td  id='PF' align='left' >2013-12-31 </td></tr>");

print("<tr style='background:grey;font-size:18px;font-family:calibri,Georgia,Serif;font-weight:bold;color:white;border-color:black' id='star_row'>");
print("<td width='20' align='left'></td>");
print("<td width='110' align='left'>StarHealth ID</td>");
print("<td width='10' align='left'>:</td>");
print("<td  id='star' align='left' >2013-12-31 </td></tr>");
	
	
print("<tr style='background:grey;font-size:18px;font-family:calibri,Georgia,Serif;font-weight:bold;color:white;border-color:black' id='home_row'>");
print("<td width='20' align='left'></td>");
print("<td width='110' align='left'>Home Phone</td>");
print("<td width='10' align='left'>:</td>");
print("<td  id='home' align='left' >2013-12-31 </td></tr>");
print("<tr style='background:grey;font-size:18px;font-family:calibri,Georgia,Serif;font-weight:bold;color:white;border-color:black' id='bankname_row'>");
print("<td width='20' align='left'></td>");
print("<td width='110' align='left'>Bank Name</td>");
print("<td width='10' align='left'>:</td>");
print("<td  id='bankname' align='left' >2013-12-31 </td></tr>");
print("<tr style='background:grey;font-size:18px;font-family:calibri,Georgia,Serif;font-weight:bold;color:white;border-color:black'  id='bankbranch_row'>");
print("<td width='20' align='left'></td>");
print("<td width='110' align='left'>Bank Branch</td>");
print("<td width='10' align='left'>:</td>");
print("<td  id='bankbranch' align='left' >2013-12-31 </td></tr>");
print("<tr style='background:grey;font-size:18px;font-family:calibri,Georgia,Serif;font-weight:bold;color:white;border-color:black'  id='bankaccount_row'>");
print("<td width='20' align='left'></td>");
print("<td width='110' align='left'>Bank Account No</td>");
print("<td width='10' align='left'>:</td>");
print("<td  id='bankaccount' align='left' >2013-12-31 </td></tr>");
print("<tr style='background:grey;font-size:18px;font-family:calibri,Georgia,Serif;font-weight:bold;color:white;border-color:black'  id='tempaddr_row'>");
print("<td width='20' align='left'></td>");
print("<td width='110' valign='top' align='left' >Current Address</td>");
print("<td width='10' valign='top'  align='left'>:</td>");
print("<td  id='tempaddr'  align='left' >2013-12-31 </td></tr>");

print("<tr style='background:grey;font-size:18px;font-family:calibri,Georgia,Serif;font-weight:bold;color:white;border-color:black'  id='peraddr_row'>");
print("<td width='20' align='left'></td>");
print("<td width='110' valign='top' align='left'>Permanent Address</td>");
print("<td width='10'  valign='top' align='left'>:</td>");
print("<td  id='peraddr' align='left' >2013-12-31 </td></tr>");
	
	
print("<tr style='background:grey;font-size:18px;font-family:calibri,Georgia,Serif;font-weight:bold;color:white;border-color:black'>");
print("<td width='110' align='left' colspan='4'>");

print("<div id='leavesDiv' >");
print("</div>");

print("</table></tr></td ></div>");

print("</tr></table>");

?>

<input type='hidden' value=''
	id='type'>
<input type='hidden' value=''
	id='uname'>
<input type='hidden' value=''
	id='days'>
<script
	type="text/javascript"
	src="<?php echo base_url(); ?>js/custom/users.js"></script>
