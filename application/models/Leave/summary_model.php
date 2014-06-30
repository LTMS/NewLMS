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
							$emp_num=$this->session->userdata('Emp_Number');				
							return $this->db->query("SELECT Employee_Number AS 'Name'  FROM team  WHERE LeaveApprover_L1='$emp_num' ORDER BY EmployeeName ")->result_array();				
					}
			
			
			
			
			
					function get_summary($year,$emp){
			
								if($emp!='All Employees'){
											return $this->db->query("SELECT SUM(CL) AS 'CL',SUM(PL) AS 'PL', SUM(SL) AS 'SL',
																								SUM(CO) AS 'CO', (SUM(CL)+SUM(PL)+SUM(SL)+SUM(CO)) as Total
																								FROM(
																												SELECT Emp_Number,	MONTHNAME(From_Date) AS 'MonthName', 
																														IF(Leave_Type='CL',Total_Days, 0) as 'CL',
																														IF(Leave_Type='PL',Total_Days, 0) as 'PL',
																														IF(Leave_Type='SL',Total_Days, 0) as 'SL',
																														IF(Leave_Type='CO',Total_Days, 0) as 'CO' 
																												FROM leave_history
																												WHERE Leave_Status IN (4) AND YEAR(From_Date)='$year' AND Emp_Number='$emp'
																				) A
																				Group By Emp_Number,Month")->result_array();
					
										}
										if($emp=='All Employees'){
													return $this->db->query("SELECT SUM(CL) AS 'CL',SUM(PL) AS 'PL', SUM(SL) AS 'SL',
																								SUM(CO) AS 'CO', (SUM(CL)+SUM(PL)+SUM(SL)+SUM(CO)) as Total
																								FROM(
																												SELECT Emp_Number,	MONTHNAME(From_Date) AS 'MonthName', 
																														IF(Leave_Type='CL',Total_Days, 0) as 'CL',
																														IF(Leave_Type='PL',Total_Days, 0) as 'PL',
																														IF(Leave_Type='SL',Total_Days, 0) as 'SL',
																														IF(Leave_Type='CO',Total_Days, 0) as 'CO' 
																												FROM leave_history
																												WHERE Leave_Status IN (4) AND YEAR(From_Date)='$year'
																				) A
																				Group By Emp_Number,Month")->result_array();
										}
				
						}
			
						function get_summary_total($year,$emp){
			
									if($emp!='All Employees'){
													return $this->db->query("SELECT SUM(CL) AS 'CL',SUM(PL) AS 'PL', SUM(SL) AS 'SL',
																								SUM(CO) AS 'CO', (SUM(CL)+SUM(PL)+SUM(SL)+SUM(CO)) as Total
																								FROM(
																												SELECT Emp_Number,	MONTHNAME(From_Date) AS 'MonthName', 
																														IF(Leave_Type='CL',Total_Days, 0) as 'CL',
																														IF(Leave_Type='PL',Total_Days, 0) as 'PL',
																														IF(Leave_Type='SL',Total_Days, 0) as 'SL',
																														IF(Leave_Type='CO',Total_Days, 0) as 'CO' 
																												FROM leave_history
																												WHERE Leave_Status IN (4) AND YEAR(From_Date)='$year'AND Emp_Number='$emp' 
																				) A ")->result_array();
					
										}
										if($emp=='All Employees'){
													return $this->db->query("SELECT SUM(CL) AS 'CL',SUM(PL) AS 'PL', SUM(SL) AS 'SL',
																								SUM(CO) AS 'CO', (SUM(CL)+SUM(PL)+SUM(SL)+SUM(CO)) as Total
																								FROM(
																												SELECT Emp_Number,	MONTHNAME(From_Date) AS 'MonthName', 
																														IF(Leave_Type='CL',Total_Days, 0) as 'CL',
																														IF(Leave_Type='PL',Total_Days, 0) as 'PL',
																														IF(Leave_Type='SL',Total_Days, 0) as 'SL',
																														IF(Leave_Type='CO',Total_Days, 0) as 'CO' 
																												FROM leave_history
																												WHERE Leave_Status IN (4) AND YEAR(From_Date)='$year'
																				) A ")->result_array();
										}
				
							}
			
			
							function get_my_summary($year){
											$emp_num=$this->session->userdata('Emp_Number');
											return $this->db->query("SELECT  MonthName, SUM(CL) AS 'CL',SUM(PL) AS 'PL', SUM(SL) AS 'SL',
																								SUM(CO) AS 'CO', (SUM(CL)+SUM(PL)+SUM(SL)+SUM(CO)) as Total
																								FROM(
																												SELECT Emp_Number,	MONTHNAME(From_Date) AS 'MonthName', 
																														IF(Leave_Type='CL',Total_Days, 0) as 'CL',
																														IF(Leave_Type='PL',Total_Days, 0) as 'PL',
																														IF(Leave_Type='SL',Total_Days, 0) as 'SL',
																														IF(Leave_Type='CO',Total_Days, 0) as 'CO' 
																												FROM leave_history
																												WHERE Leave_Status IN (4) AND YEAR(From_Date)='$year' AND Emp_Number='$emp_num' 
																								) A
																								Group By MonthName")->result_array();
					
							}

							function get_my_summary_total($year){
											$emp_num=$this->session->userdata('Emp_Number');
											return $this->db->query("SELECT SUM(CL) AS 'CL',SUM(PL) AS 'PL', SUM(SL) AS 'SL',
																								SUM(CO) AS 'CO', (SUM(CL)+SUM(PL)+SUM(SL)+SUM(CO)) as Total
																								FROM(
																												SELECT Emp_Number,	MONTHNAME(From_Date) AS 'MonthName', 
																														IF(Leave_Type='CL',Total_Days, 0) as 'CL',
																														IF(Leave_Type='PL',Total_Days, 0) as 'PL',
																														IF(Leave_Type='SL',Total_Days, 0) as 'SL',
																														IF(Leave_Type='CO',Total_Days, 0) as 'CO' 
																												FROM leave_history
																												WHERE Leave_Status IN (4) AND YEAR(From_Date)='$year' AND Emp_Number='$emp_num' 
																								) A	")->result_array();
					
							}
				
				
				
								
				function get_my_permission($y){
					$Emp_Number=$this->session->userdata('Emp_Number');	
					return	$this->db->query("SELECT MONTHNAME(p_date) as month, Total_Hrs, DAY(p_date) as day,reason,Time_From FROM permissions WHERE  Emp_Number='$Emp_Number' AND YEAR(p_date)='$y'  AND status='Approved' ")->result_array();
				}
				
				function get_my_permission_total($y){
					$Emp_Number=$this->session->userdata('Emp_Number');	
					return	$this->db->query("SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(Total_Hrs))) as Total_Hrs FROM permissions WHERE  Emp_Number='$Emp_Number' AND YEAR(p_date)='$y'  AND status='Approved' ")->result_array();
			}
			
				function get_admin_permission($y,$Emp_Number){
					return	$this->db->query("SELECT MONTHNAME(p_date) as month, Total_Hrs,DAY(p_date) as day,reason,Time_From FROM permissions WHERE  Emp_Number='$Emp_Number' AND YEAR(p_date)='$y'  AND status='Approved' ")->result_array();
				}
				
				function get_admin_permission_total($y,$Emp_Number){
					return	$this->db->query("SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(Total_Hrs))) as Total_Hrs FROM permissions WHERE  Emp_Number='$Emp_Number' AND YEAR(p_date)='$y' AND status='Approved' ")->result_array();
			}
				
				
				
				
				
				
}		
			
		
?>