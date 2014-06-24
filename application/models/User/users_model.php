<?php
Class Users_model extends CI_Model{

	function _construct()
	{
		parent::_construct();
	}



	function get_user_info($user_id){
		return $this->db->query("select * from admin_users where user_id='$user_id'")->result();
	}

	function remove_user_info($user_id,$name){
		$this->db->query("Delete From team where EmployeeName='$name'");
		$this->db->query("Delete From admin_users where user_email='$user_id'");
	}


	function get_dept()
	{
		return $this->db->query("SELECT * FROM departments ")->result_array();
	}

	function get_roles()
	{
		return $this->db->query("SELECT * FROM user_roles ")->result_array();
	}

	function get_reporters($dept)
	{
		return $this->db->query("SELECT Name FROM authorities WHERE Department='$dept' AND Task='Reporting' ")->result_array();
	}

	function get_approvers($dept)
	{
		return $this->db->query("SELECT Name FROM authorities WHERE Department='$dept' AND Task='Approving' ")->result_array();
	}

	function get_leaves()
	{
		return $this->db->query("SELECT * FROM leaves ")->result_array();
	}




	function check_EmpNumber($emp_num){
		return $this->db->query("SELECT COUNT(Emp_Number) as Count FROM admin_users WHERE  Emp_Number='$emp_num'")->result_array();
	}




	function add_employees_table($emp_num,$emp_name,$dept,$doj,$reporter,$approver,$mail)	{
		$this->db->query("INSERT INTO employees(Employee_Number,Employee_Name,Department,Reporter,Approver,DOJ,Email)
														 VALUES( '$emp_num','$emp_name','$dept','$reporter','$approver',STR_TO_DATE(STR_TO_DATE('$doj','%d-%m-%Y'),'%Y-%m-%d'),'$mail' );");

	}


	function get_team_leader($dept)
	{
		$leaders=$this->db->query("SELECT EmployeeName	FROM team  	where Designation IN ('TeamLeader') and Department ='$dept' ");
		$rowcount=$leaders->num_rows();
		if ($rowcount > 0)
		{
			$leaderno="";
			for($i=0;$i<$rowcount;$i++)
			{
				$row = $leaders->row_array($i);
				$leader[$i]=$row['EmployeeName'];
				$leaderno=$leaderno."!".$leader[$i];
			}
			echo $leaderno;
		}

	}


	function updateEmployees_Details1($name,$f_name,$gender,$blood,$subtype,$dob,$marital,$mail,$doj){
		$by=$this->session->userdata('fullname');

		$this->db->query("UPDATE employee_details
					 									SET	FatherName='$f_name',
					 										Gender='$gender',
					 										DOB=STR_TO_DATE(STR_TO_DATE('$dob','%d-%m-%Y'),'%Y-%m-%d'),
					 										BloodGroup='$blood',
					 										SubType='$subtype',
					 										MaritalStatus='$marital',
					 										ModifiedBy='$by' ,
					 										Status='1',
					 										ModifiedOn=CURRENT_TIMESTAMP
					 										WHERE EmployeeName='$name'");


			
		$this->db->query("UPDATE admin_users
					 									SET	email='$mail'
					 											WHERE name='$name' ");

		$this->db->query("UPDATE team
					 									SET	JoiningDate=STR_TO_DATE(STR_TO_DATE('$doj','%d-%m-%Y'),'%Y-%m-%d')
					 											WHERE EmployeeName='$name' ");

			

			

	}

	function updateEmployees_Details2($name,$mobile,$phone,$desig,$pf,$bank,$branch,$accno,$insur){

		$this->db->query("    UPDATE employee_details
													 SET MobileNumber='$mobile',
													HomePhone='$phone',
													Designation='$desig',
													PFNumber='$pf',
													BankName='$bank',
													BankBranch='$branch',
													BankAccNum='$accno',
													StarHealthID='$insur'											
												WHERE EmployeeName='$name'");

	}
	function updateEmployees_Details3($name,$ad1,$ad2,$ad3,$city,$state,$country,$post){

		$this->db->query("UPDATE employee_details
												SET Address1='$ad1',
												Address2='$ad2',
												Address3='$ad3',
												City='$city',
												State='$state',
												Country='$country',
												PostCode='$post',
												 E_Address1='$ad1',
												E_Address2='$ad2',
												E_Address3='$ad3',
												E_City='$city',
												E_State='$state',
												E_Country='$country',
												E_PostCode='$post'
		
												WHERE EmployeeName='$name'");

	}
	function updateEmployees_Details4($name,$ad1,$ad2,$ad3,$city,$state,$country,$post){

		$this->db->query("UPDATE employee_details
												SET E_Address1='$ad1',
												E_Address2='$ad2',
												E_Address3='$ad3',
												E_City='$city',
												E_State='$state',
												E_Country='$country',
												E_PostCode='$post'
												WHERE EmployeeName='$name'");

	}

	function updateEmployees_Details5($name,$Ead1,$Ead2,$Ead3,$Ecity,$Estate,$Ecountry,$Epost){

		$this->db->query("UPDATE employee_details
												SET Address1='$Ead1',
												Address2='$Ead2',
												Address3='$Ead3',
												City='$Ecity',
												State='$Estate',
												Country='$Ecountry',
												PostCode='$Epost'
												WHERE EmployeeName='$name'");

	}


	function getDetails($user){
		return $this->db->query("SELECT *,DATE_FORMAT(DOB,'%d-%m-%Y') as DOB1 FROM employee_details WHERE EmployeeName='$user' ")->result_array();
			
	}

	function getDetails1($user){
		return $this->db->query("SELECT email, (SELECT  DATE_FORMAT(JoiningDate,'%d-%m-%Y') FROM team WHERE EmployeeName='$user') as doj FROM admin_users WHERE name='$user' ")->result_array();
			
	}

	function Users_Info()
	{
		return $this->db->query("SELECT phone_number,e.EmployeeName,FatherName,Gender,DATE_FORMAT(DOB, '%d/%m/%Y') as DOB,BloodGroup,SubType,MaritalStatus,t.Designation,PFNumber,StarHealthID,Address1,Address2,Address3,City,State,Country,PostCode,
									E_Address1,E_Address2,E_Address3,E_City,E_State,E_Country,E_PostCode,HomePhone,MobileNumber,BankBranch,BankName,BankAccNum,Department,email,DATE_FORMAT(JoiningDate, '%d/%m/%Y') as JoiningDate
									FROM employee_details e Left outer JOIN team t ON(e.EmployeeName=t.EmployeeName)
									left outer JOIN  admin_users au ON(e.EmployeeName=au.name); ")->result_array();
	}



	function get_users_list(){
		$role=$this->session->userdata('userrole')=='MD';
		if($role=='MD'){
			return $this->db->query("select * from admin_users WHERE user_email NOT IN ('Default') ORDER BY timeoffice_id")->result();
		}
		else{
			return $this->db->query("select * from admin_users WHERE user_role NOT IN('MD')")->result();
		}
	}


}
?>