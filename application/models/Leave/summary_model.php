<?php
Class Summary_model extends CI_Model{
		function _construct()
			{
				parent::_construct();
			}

					function get_dept()	{
								return $this->db->query("SELECT * FROM departments ")->result_array();
					}
					
					
					function get_team(){
								return $this->db->query("SELECT a.Employee_Number AS EmployeeName FROM team a  WHERE a.Designation IN ('TeamLeader') ORDER BY a.Employee_Number")->result_array();
					}
					
	
					function get_years(){
								return $this->db->query("SELECT  DISTINCT YEAR(From_Date) AS 'year' FROM leave_history ORDER BY year ")->result_array();
					}
		
					function get_leave_members(){
								return $this->db->query("SELECT DISTINCT Emp_Name AS 'Name' FROM  admin_users  WHERE Emp_Role NOT IN ('MD') ORDER BY name")->result_array();				
					}
		
					function get_team_members(){
							$uname=$this->session->userdata('Emp_Number');				
							return $this->db->query("SELECT Employee_Number AS 'Name'  FROM team  WHERE LeaveApprover_L1='$uname' ORDER BY EmployeeName ")->result_array();				
					}
			
			
			
			
			
					function get_summary($year,$emp,$team,$dept){
			
								if($emp!='All Employees'){
											return $this->db->query("SELECT  Emp_Number,monthname(str_to_date(month,'%c')) AS 'MonthName',SUM(CasualLeave) AS 'CL',SUM(PaidLeave) AS 'PL', SUM(SickLeave) AS 'SL',
																				SUM(Comp_Off) AS 'CO'
																				FROM(
																								SELECT Emp_Number,SUBSTRING(From_Date,6,2) AS 'Month',IF(Leave_Type='Casual Leave',Total_Days, 0) as 'CasualLeave',
																								IF(Leave_Type='Paid Leave',Total_Days, 0) as 'PaidLeave',
																								IF(Leave_Type='Sick Leave',Total_Days, 0) as 'SickLeave',
																								IF(Leave_Type='Comp-Off',Total_Days, 0) as 'Comp_Off' 
																								FROM leave_history INNER JOIN team b ON b.Employee_Number=Emp_Number
																								WHERE Leave_Status IN ('2','4') AND SUBSTRING(From_Date,1,4)='$year' AND (Emp_Number='$emp' OR b.Department='$dept' OR LeaveApprover_L1='$team')
																				) A
																				Group By Emp_Number,Month")->result_array();
					
										}
										if($emp=='All Employees'){
													return $this->db->query("SELECT  Emp_Number,monthname(str_to_date(month,'%c')) AS 'MonthName',SUM(CasualLeave) AS 'CL',SUM(PaidLeave) AS 'PL', SUM(SickLeave) AS 'SL',
																				SUM(Comp_Off) AS 'CO'
																				FROM(
																								SELECT Emp_Number,SUBSTRING(From_Date,6,2) AS 'Month',IF(Leave_Type='Casual Leave',Total_Days, 0) as 'CasualLeave',
																								IF(Leave_Type='Paid Leave',Total_Days, 0) as 'PaidLeave',
																								IF(Leave_Type='Sick Leave',Total_Days, 0) as 'SickLeave',
																								IF(Leave_Type='Comp-Off',Total_Days, 0) as 'Comp_Off' 
																								FROM leave_history INNER JOIN team b ON b.Employee_Number=Emp_Number
																								WHERE Leave_Status IN ('2','4') AND SUBSTRING(From_Date,1,4)='$year'
																				) A
																				Group By Emp_Number,Month")->result_array();
										}
				
						}
			
						function get_summary_total($year,$emp,$team,$dept){
			
									if($emp!='All Employees'){
													return $this->db->query("SELECT SUM(CasualLeave) AS 'CL',SUM(PaidLeave) AS 'PL', SUM(SickLeave) AS 'SL',
																				SUM(Comp_Off) AS 'CO'
																				FROM(
																								SELECT Emp_Number,SUBSTRING(From_Date,6,2) AS 'Month',IF(Leave_Type='Casual Leave',Total_Days, 0) as 'CasualLeave',
																								IF(Leave_Type='Paid Leave',Total_Days, 0) as 'PaidLeave',
																								IF(Leave_Type='Sick Leave',Total_Days, 0) as 'SickLeave',
																								IF(Leave_Type='Comp-Off',Total_Days, 0) as 'Comp_Off' 
																								FROM leave_history INNER JOIN team b ON b.Employee_Number=Emp_Number
																								WHERE Leave_Status IN ('2','4') AND SUBSTRING(From_Date,1,4)='$year' AND (Emp_Number='$emp' OR b.Department='$dept' OR LeaveApprover_L1='$team')
																				) A ")->result_array();
					
										}
										if($emp=='All Employees'){
													return $this->db->query("SELECT  SUM(CasualLeave) AS 'CL',SUM(PaidLeave) AS 'PL', SUM(SickLeave) AS 'SL',
																				SUM(Comp_Off) AS 'CO'
																				FROM(
																								SELECT Emp_Number,SUBSTRING(From_Date,6,2) AS 'Month',IF(Leave_Type='Casual Leave',Total_Days, 0) as 'CasualLeave',
																								IF(Leave_Type='Paid Leave',Total_Days, 0) as 'PaidLeave',
																								IF(Leave_Type='Sick Leave',Total_Days, 0) as 'SickLeave',
																								IF(Leave_Type='Comp-Off',Total_Days, 0) as 'Comp_Off' 
																								FROM leave_history INNER JOIN team b ON b.Employee_Number=Emp_Number
																								WHERE Leave_Status IN ('2','4') AND SUBSTRING(From_Date,1,4)='$year'
																				) A ")->result_array();
										}
				
							}
			
			
							function get_my_summary($year){
											$uname=$this->session->userdata('Emp_Number');
											return $this->db->query("SELECT  monthname(str_to_date(month,'%c')) AS 'MonthName',SUM(CasualLeave) AS 'CL',SUM(PaidLeave) AS 'PL', SUM(SickLeave) AS 'SL',
																								SUM(Comp_Off) AS 'CO'
																								FROM(
																												SELECT Emp_Number,SUBSTRING(From_Date,6,2) AS 'Month',IF(Leave_Type='Casual Leave',Total_Days, 0) as 'CasualLeave',
																												IF(Leave_Type='Paid Leave',Total_Days, 0) as 'PaidLeave',
																												IF(Leave_Type='Sick Leave',Total_Days, 0) as 'SickLeave',
																												IF(Leave_Type='Comp-Off',Total_Days, 0) as 'Comp_Off' 
																												FROM leave_history INNER JOIN team b ON b.Employee_Number=Emp_Number
																												WHERE Leave_Status IN ('2','4') AND SUBSTRING(From_Date,1,4)='$year' AND Emp_Number='$uname' 
																								) A
																								Group By Month")->result_array();
					
							}

							function get_my_summary_total($year){
											$uname=$this->session->userdata('Emp_Number');
											return $this->db->query("SELECT  SUM(CasualLeave) AS 'CL',SUM(PaidLeave) AS 'PL', SUM(SickLeave) AS 'SL',
																								SUM(Comp_Off) AS 'CO'
																								FROM(
																												SELECT Emp_Number,SUBSTRING(From_Date,6,2) AS 'Month',IF(Leave_Type='Casual Leave',Total_Days, 0) as 'CasualLeave',
																												IF(Leave_Type='Paid Leave',Total_Days, 0) as 'PaidLeave',
																												IF(Leave_Type='Sick Leave',Total_Days, 0) as 'SickLeave',
																												IF(Leave_Type='Comp-Off',Total_Days, 0) as 'Comp_Off' 
																												FROM leave_history INNER JOIN team b ON b.Employee_Number=Emp_Number
																												WHERE Leave_Status IN ('2','4') AND SUBSTRING(From_Date,1,4)='$year' AND Emp_Number='$uname' 
																								) A		")->result_array();
					
							}
				
				
				
								
				function get_my_permission($y){
					$Emp_Number=$this->session->userdata('Emp_Number');	
					return	$this->db->query("SELECT MONTHName(p_date) as month, Total_Hrs, DAY(p_date) as day,reason,Time_From FROM permissions WHERE  Emp_Number='$Emp_Number' AND YEAR(p_date)='$y'  AND status='Approved' ")->result_array();
				}
				
				function get_my_permission_total($y){
					$Emp_Number=$this->session->userdata('Emp_Number');	
					return	$this->db->query("SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(Total_Hrs))) as Total_Hrs FROM permissions WHERE  Emp_Number='$Emp_Number' AND YEAR(p_date)='$y'  AND status='Approved' ")->result_array();
			}
			
				function get_admin_permission($y,$Emp_Number){
					return	$this->db->query("SELECT MONTHName(p_date) as month, Total_Hrs,DAY(p_date) as day,reason,Time_From FROM permissions WHERE  Emp_Number='$Emp_Number' AND YEAR(p_date)='$y'  AND status='Approved' ")->result_array();
				}
				
				function get_admin_permission_total($y,$Emp_Number){
					return	$this->db->query("SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(Total_Hrs))) as Total_Hrs FROM permissions WHERE  Emp_Number='$Emp_Number' AND YEAR(p_date)='$y' AND status='Approved' ")->result_array();
			}
				
				
				
				
				
				
}		
			
		
?>