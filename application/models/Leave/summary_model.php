<?php
Class Summary_model extends CI_Model{
	function _construct()
	{
		parent::_construct();
	}


	function get_leave_years(){
					return $this->db->query("SELECT  DISTINCT YEAR(From_Date) AS 'year' FROM leave_history ORDER BY year DESC")->result_array();
	}

	function get_leaveList(){
					return $this->db->query("SELECT  DISTINCT LeaveDesc , LeaveType FROM leave_list ORDER BY LeaveDesc ")->result_array();
	}

	function get_leave_members(){
					return $this->db->query("SELECT DISTINCT Emp_Number AS 'Number',Emp_Name AS 'Name' FROM  admin_users WHERE Emp_Role NOT IN ('MD') ORDER BY Name DESC")->result_array();
	}
		
	function get_Departments()
	{
		return $this->db->query("SELECT DISTINCT * FROM departments ")->result_array();
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
		
																					/* * * 			My Leave Summary 			* * */
	
	
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


																			/* * * 			Admin Leave Summary Model 		* * */																			
	

//1
	function admin_leave_summary_Y($year){
								return $this->db->query("SELECT Emp_Number,Emp_Name,Department,CONCAT(YEAR(Date),' - ',MONTHNAME(Date)) as Month, SUM(CL) AS 'CL',SUM(PL) AS 'PL', SUM(SL) AS 'SL',
																								SUM(CO) AS 'CO', (SUM(CL)+SUM(PL)+SUM(SL)+SUM(CO)) as Total
																					FROM(
																												SELECT Emp_Number,Emp_Name,b.Department, From_Date as Date,
																														IF(Leave_Type='CL',Total_Days, 0) as 'CL',
																														IF(Leave_Type='PL',Total_Days, 0) as 'PL',
																														IF(Leave_Type='SL',Total_Days, 0) as 'SL',
																														IF(Leave_Type='CO',Total_Days, 0) as 'CO' 
																												FROM leave_history INNER JOIN employees b ON b.Employee_Number=Emp_Number
																												WHERE Leave_Status IN (4) AND 	 YEAR(From_Date)='$year' ) A
																					GROUP BY Department,Emp_Number,MONTH(Date)
																					ORDER BY Department,Emp_Number,MONTH(Date)  ")->result_array();
		}

		function admin_leave_summary_total_Y($year){
								return $this->db->query("SELECT  SUM(CL) AS 'CL',SUM(PL) AS 'PL', SUM(SL) AS 'SL',
																								SUM(CO) AS 'CO', (SUM(CL)+SUM(PL)+SUM(SL)+SUM(CO)) as Total
																					FROM(
																												SELECT Emp_Number,Emp_Name,b.Department, From_Date as Date,
																														IF(Leave_Type='CL',Total_Days, 0) as 'CL',
																														IF(Leave_Type='PL',Total_Days, 0) as 'PL',
																														IF(Leave_Type='SL',Total_Days, 0) as 'SL',
																														IF(Leave_Type='CO',Total_Days, 0) as 'CO' 
																												FROM leave_history INNER JOIN employees b ON b.Employee_Number=Emp_Number
																												WHERE Leave_Status IN (4) AND 	 YEAR(From_Date)='$year') A ")->result_array();
		}

//2
	function admin_leave_summary_YM($year,$month){
								return $this->db->query("SELECT Emp_Number,Emp_Name,Department,CONCAT(YEAR(Date),' - ',MONTHNAME(Date)) as Month, SUM(CL) AS 'CL',SUM(PL) AS 'PL', SUM(SL) AS 'SL',
																								SUM(CO) AS 'CO', (SUM(CL)+SUM(PL)+SUM(SL)+SUM(CO)) as Total
																					FROM(
																												SELECT Emp_Number,Emp_Name,b.Department, From_Date as Date,
																														IF(Leave_Type='CL',Total_Days, 0) as 'CL',
																														IF(Leave_Type='PL',Total_Days, 0) as 'PL',
																														IF(Leave_Type='SL',Total_Days, 0) as 'SL',
																														IF(Leave_Type='CO',Total_Days, 0) as 'CO' 
																												FROM leave_history INNER JOIN employees b ON b.Employee_Number=Emp_Number
																												WHERE Leave_Status IN (4) AND 	 YEAR(From_Date)='$year' AND MONTHNAME(From_Date)='$month') A
																					GROUP BY Department,Emp_Number 
																					ORDER BY Department,Emp_Number  ")->result_array();
		}

		function admin_leave_summary_total_YM($year,$month){
								return $this->db->query("SELECT SUM(CL) AS 'CL',SUM(PL) AS 'PL', SUM(SL) AS 'SL',
																								SUM(CO) AS 'CO', (SUM(CL)+SUM(PL)+SUM(SL)+SUM(CO)) as Total
																					FROM(
																												SELECT Emp_Number,Emp_Name,b.Department, From_Date as Date,
																														IF(Leave_Type='CL',Total_Days, 0) as 'CL',
																														IF(Leave_Type='PL',Total_Days, 0) as 'PL',
																														IF(Leave_Type='SL',Total_Days, 0) as 'SL',
																														IF(Leave_Type='CO',Total_Days, 0) as 'CO' 
																												FROM leave_history INNER JOIN employees b ON b.Employee_Number=Emp_Number
																												WHERE Leave_Status IN (4) AND 	 YEAR(From_Date)='$year' AND MONTHNAME(From_Date)='$month') A ")->result_array();
			}

		//3
	function admin_leave_summary_YD($year,$dept){
								return $this->db->query("SELECT Emp_Number,Emp_Name,Department,CONCAT(YEAR(Date),' - ',MONTHNAME(Date)) as Month, SUM(CL) AS 'CL',SUM(PL) AS 'PL', SUM(SL) AS 'SL',
																								SUM(CO) AS 'CO', (SUM(CL)+SUM(PL)+SUM(SL)+SUM(CO)) as Total
																					FROM(
																												SELECT Emp_Number,Emp_Name,b.Department, From_Date as Date,
																														IF(Leave_Type='CL',Total_Days, 0) as 'CL',
																														IF(Leave_Type='PL',Total_Days, 0) as 'PL',
																														IF(Leave_Type='SL',Total_Days, 0) as 'SL',
																														IF(Leave_Type='CO',Total_Days, 0) as 'CO' 
																												FROM leave_history INNER JOIN employees b ON b.Employee_Number=Emp_Number
																												WHERE Leave_Status IN (4) AND 	 YEAR(From_Date)='$year' 	 AND b.Department='$dept' ) A
																					GROUP BY Emp_Number,MONTH(Date)
																					ORDER BY Emp_Number,MONTH(Date)  ")->result_array();
		}

		function admin_leave_summary_total_YD($year,$dept){
								return $this->db->query("SELECT SUM(CL) AS 'CL',SUM(PL) AS 'PL', SUM(SL) AS 'SL',
																								SUM(CO) AS 'CO', (SUM(CL)+SUM(PL)+SUM(SL)+SUM(CO)) as Total
																					FROM(
																												SELECT Emp_Number,Emp_Name,b.Department, From_Date as Date,
																														IF(Leave_Type='CL',Total_Days, 0) as 'CL',
																														IF(Leave_Type='PL',Total_Days, 0) as 'PL',
																														IF(Leave_Type='SL',Total_Days, 0) as 'SL',
																														IF(Leave_Type='CO',Total_Days, 0) as 'CO' 
																												FROM leave_history INNER JOIN employees b ON b.Employee_Number=Emp_Number
																												WHERE Leave_Status IN (4) AND 	 YEAR(From_Date)='$year' 	 AND b.Department='$dept' ) A ")->result_array();
			}

		//4
	function admin_leave_summary_YE($year,$emp){
								return $this->db->query("SELECT Emp_Number,Emp_Name,Department,CONCAT(YEAR(Date),' - ',MONTHNAME(Date)) as Month, SUM(CL) AS 'CL',SUM(PL) AS 'PL', SUM(SL) AS 'SL',
																								SUM(CO) AS 'CO', (SUM(CL)+SUM(PL)+SUM(SL)+SUM(CO)) as Total
																					FROM(
																												SELECT Emp_Number,Emp_Name,b.Department, From_Date as Date,
																														IF(Leave_Type='CL',Total_Days, 0) as 'CL',
																														IF(Leave_Type='PL',Total_Days, 0) as 'PL',
																														IF(Leave_Type='SL',Total_Days, 0) as 'SL',
																														IF(Leave_Type='CO',Total_Days, 0) as 'CO' 
																												FROM leave_history INNER JOIN employees b ON b.Employee_Number=Emp_Number
																												WHERE Leave_Status IN (4) AND 	 YEAR(From_Date)='$year'   AND Emp_Number='$emp') A
																					GROUP BY Department,MONTH(Date)
																					ORDER BY Department,MONTH(Date) ")->result_array();
		}

		function admin_leave_summary_total_YE($year,$emp){
								return $this->db->query("SELECT  SUM(CL) AS 'CL',SUM(PL) AS 'PL', SUM(SL) AS 'SL',
																								SUM(CO) AS 'CO', (SUM(CL)+SUM(PL)+SUM(SL)+SUM(CO)) as Total
																					FROM(
																												SELECT Emp_Number,Emp_Name,b.Department, From_Date as Date,
																														IF(Leave_Type='CL',Total_Days, 0) as 'CL',
																														IF(Leave_Type='PL',Total_Days, 0) as 'PL',
																														IF(Leave_Type='SL',Total_Days, 0) as 'SL',
																														IF(Leave_Type='CO',Total_Days, 0) as 'CO' 
																												FROM leave_history INNER JOIN employees b ON b.Employee_Number=Emp_Number
																												WHERE Leave_Status IN (4) AND 	 YEAR(From_Date)='$year'   AND Emp_Number='$emp') A")->result_array();
		}

		//5
	function admin_leave_summary_YMD($year,$month,$dept){
								return $this->db->query(" SELECT Emp_Number,Emp_Name,Department,CONCAT(YEAR(Date),' - ',MONTHNAME(Date)) as Month, SUM(CL) AS 'CL',SUM(PL) AS 'PL', SUM(SL) AS 'SL',
																								SUM(CO) AS 'CO', (SUM(CL)+SUM(PL)+SUM(SL)+SUM(CO)) as Total
																					FROM(
																												SELECT Emp_Number,Emp_Name,b.Department, From_Date as Date,
																														IF(Leave_Type='CL',Total_Days, 0) as 'CL',
																														IF(Leave_Type='PL',Total_Days, 0) as 'PL',
																														IF(Leave_Type='SL',Total_Days, 0) as 'SL',
																														IF(Leave_Type='CO',Total_Days, 0) as 'CO' 
																												FROM leave_history INNER JOIN employees b ON b.Employee_Number=Emp_Number
																												WHERE Leave_Status IN (4) AND 	 YEAR(From_Date)='$year'
																												 AND MONTHNAME(From_Date)='$month'  AND b.Department='$dept'  ) A
																					GROUP BY Emp_Number
																					ORDER BY Emp_Number   ")->result_array();
		}

		function admin_leave_summary_total_YMD($year,$month,$dept){
								return $this->db->query("SELECT  SUM(CL) AS 'CL',SUM(PL) AS 'PL', SUM(SL) AS 'SL',
																								SUM(CO) AS 'CO', (SUM(CL)+SUM(PL)+SUM(SL)+SUM(CO)) as Total
																					FROM(
																												SELECT Emp_Number,Emp_Name,b.Department, From_Date as Date,
																														IF(Leave_Type='CL',Total_Days, 0) as 'CL',
																														IF(Leave_Type='PL',Total_Days, 0) as 'PL',
																														IF(Leave_Type='SL',Total_Days, 0) as 'SL',
																														IF(Leave_Type='CO',Total_Days, 0) as 'CO' 
																												FROM leave_history INNER JOIN employees b ON b.Employee_Number=Emp_Number
																												WHERE Leave_Status IN (4) AND 	 YEAR(From_Date)='$year'
																												 AND MONTHNAME(From_Date)='$month'  AND b.Department='$dept'  ) A")->result_array();
		}

		//6
	function admin_leave_summary_YME($year,$month,$emp){
								return $this->db->query("SELECT Emp_Number,Emp_Name,Department,CONCAT(YEAR(Date),' - ',MONTHNAME(Date)) as Month, SUM(CL) AS 'CL',SUM(PL) AS 'PL', SUM(SL) AS 'SL',
																								SUM(CO) AS 'CO', (SUM(CL)+SUM(PL)+SUM(SL)+SUM(CO)) as Total
																					FROM(
																												SELECT Emp_Number,Emp_Name,b.Department, From_Date as Date,
																														IF(Leave_Type='CL',Total_Days, 0) as 'CL',
																														IF(Leave_Type='PL',Total_Days, 0) as 'PL',
																														IF(Leave_Type='SL',Total_Days, 0) as 'SL',
																														IF(Leave_Type='CO',Total_Days, 0) as 'CO' 
																												FROM leave_history INNER JOIN employees b ON b.Employee_Number=Emp_Number
																												WHERE Leave_Status IN (4) AND 	 YEAR(From_Date)='$year' 
																												AND MONTHNAME(From_Date)='$month' AND Emp_Number='$emp') A
																					GROUP BY MONTH(Date)
																					ORDER BY Department,Emp_Number,MONTH(Date)   ")->result_array();
		}

		function admin_leave_summary_total_YME($year,$month,$emp){
								return $this->db->query("SELECT  SUM(CL) AS 'CL',SUM(PL) AS 'PL', SUM(SL) AS 'SL',
																								SUM(CO) AS 'CO', (SUM(CL)+SUM(PL)+SUM(SL)+SUM(CO)) as Total
																					FROM(
																												SELECT Emp_Number,Emp_Name,b.Department, From_Date as Date,
																														IF(Leave_Type='CL',Total_Days, 0) as 'CL',
																														IF(Leave_Type='PL',Total_Days, 0) as 'PL',
																														IF(Leave_Type='SL',Total_Days, 0) as 'SL',
																														IF(Leave_Type='CO',Total_Days, 0) as 'CO' 
																												FROM leave_history INNER JOIN employees b ON b.Employee_Number=Emp_Number
																												WHERE Leave_Status IN (4) AND 	 YEAR(From_Date)='$year' 
																												AND MONTHNAME(From_Date)='$month' AND Emp_Number='$emp') A ")->result_array();
			}

		//7
	function admin_leave_summary_YDE($year,$dept,$emp){
								return $this->db->query("SELECT Emp_Number,Emp_Name,Department,CONCAT(YEAR(Date),' - ',MONTHNAME(Date)) as Month, SUM(CL) AS 'CL',SUM(PL) AS 'PL', SUM(SL) AS 'SL',
																								SUM(CO) AS 'CO', (SUM(CL)+SUM(PL)+SUM(SL)+SUM(CO)) as Total
																					FROM(
																												SELECT Emp_Number,Emp_Name,b.Department, From_Date as Date,
																														IF(Leave_Type='CL',Total_Days, 0) as 'CL',
																														IF(Leave_Type='PL',Total_Days, 0) as 'PL',
																														IF(Leave_Type='SL',Total_Days, 0) as 'SL',
																														IF(Leave_Type='CO',Total_Days, 0) as 'CO' 
																												FROM leave_history INNER JOIN employees b ON b.Employee_Number=Emp_Number
																												WHERE Leave_Status IN (4) AND 	 YEAR(From_Date)='$year' 
																																 AND b.Department='$dept'  AND Emp_Number='$emp' ) A
																					GROUP BY MONTH(Date) 
																					ORDER BY MONTH(Date)  ")->result_array();
		}

		function admin_leave_summary_total_YDE($year,$dept,$emp){
								return $this->db->query("SELECT   SUM(CL) AS 'CL',SUM(PL) AS 'PL', SUM(SL) AS 'SL',
																								SUM(CO) AS 'CO', (SUM(CL)+SUM(PL)+SUM(SL)+SUM(CO)) as Total
																					FROM(
																												SELECT Emp_Number,Emp_Name,b.Department, From_Date as Date,
																														IF(Leave_Type='CL',Total_Days, 0) as 'CL',
																														IF(Leave_Type='PL',Total_Days, 0) as 'PL',
																														IF(Leave_Type='SL',Total_Days, 0) as 'SL',
																														IF(Leave_Type='CO',Total_Days, 0) as 'CO' 
																												FROM leave_history INNER JOIN employees b ON b.Employee_Number=Emp_Number
																												WHERE Leave_Status IN (4) AND 	 YEAR(From_Date)='$year' 
																																 AND b.Department='$dept'  AND Emp_Number='$emp' ) A ")->result_array();
			}

		//8
	function admin_leave_summary_YMDE($year,$month,$dept,$emp){
								return $this->db->query("SELECT Emp_Number,Emp_Name,Department,CONCAT(YEAR(Date),' - ',MONTHNAME(Date)) as Month, SUM(CL) AS 'CL',SUM(PL) AS 'PL', SUM(SL) AS 'SL',
																								SUM(CO) AS 'CO', (SUM(CL)+SUM(PL)+SUM(SL)+SUM(CO)) as Total
																					FROM(
																												SELECT Emp_Number,Emp_Name,b.Department, From_Date as Date,
																														IF(Leave_Type='CL',Total_Days, 0) as 'CL',
																														IF(Leave_Type='PL',Total_Days, 0) as 'PL',
																														IF(Leave_Type='SL',Total_Days, 0) as 'SL',
																														IF(Leave_Type='CO',Total_Days, 0) as 'CO' 
																												FROM leave_history INNER JOIN employees b ON b.Employee_Number=Emp_Number
																												WHERE Leave_Status IN (4) AND 	 YEAR(From_Date)='$year' AND MONTHNAME(From_Date)='$month'
																																 AND b.Department='$dept'  AND Emp_Number='$emp') A ")->result_array();
		}

		function admin_leave_summary_total_YMDE($year,$month,$dept,$emp){
								return $this->db->query("SELECT  SUM(CL) AS 'CL',SUM(PL) AS 'PL', SUM(SL) AS 'SL',
																								SUM(CO) AS 'CO', (SUM(CL)+SUM(PL)+SUM(SL)+SUM(CO)) as Total
																					FROM(
																												SELECT Emp_Number,Emp_Name,b.Department, From_Date as Date,
																														IF(Leave_Type='CL',Total_Days, 0) as 'CL',
																														IF(Leave_Type='PL',Total_Days, 0) as 'PL',
																														IF(Leave_Type='SL',Total_Days, 0) as 'SL',
																														IF(Leave_Type='CO',Total_Days, 0) as 'CO' 
																												FROM leave_history INNER JOIN employees b ON b.Employee_Number=Emp_Number
																												WHERE Leave_Status IN (4) AND 	 YEAR(From_Date)='$year' AND MONTHNAME(From_Date)='$month'
																																 AND b.Department='$dept'  AND Emp_Number='$emp') A ")->result_array();
		}

		
	
		




}
	

?>