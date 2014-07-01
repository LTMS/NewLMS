<?php
Class History_model extends CI_Model{
	function _construct()
	{
		parent::_construct();
	}
	
	function get_parameters()
	{
		return $this->db->query("SELECT *, HOUR(comp_off_reduct) as hour, MINUTE(comp_off_reduct) as min,ROUND(TIME_TO_SEC(comp_off_reduct)/60) as comp_minutes FROM parameters ")->result_array();
	}

	function get_years(){
		return $this->db->query("SELECT  DISTINCT YEAR(From_Date) AS 'year' FROM leave_history ORDER BY year DESC")->result_array();
	}
	
	function get_leaveList(){
		return $this->db->query("SELECT  DISTINCT LeaveDesc , LeaveType FROM leave_list ORDER BY LeaveDesc ")->result_array();
	}
	
	function get_team()
	{
		return $this->db->query("SELECT a.Employee_Number AS EmployeeName FROM team a  WHERE a.Designation IN ('TeamLeader') ORDER BY a.Employee_Number")->result_array();
	}

	function get_leave_members(){
		return $this->db->query("SELECT DISTINCT Emp_Number AS 'Number',Emp_Name AS 'Name' FROM  admin_users WHERE Emp_Role NOT IN ('MD') ORDER BY Name DESC")->result_array();
	}

	function get_team_members()
	{
		$Emp_Number=$this->session->userdata('Emp_Number');

		return $this->db->query("SELECT EmployeeName AS 'Name'  FROM team  WHERE LeaveApprover_L1='$Emp_Number' ORDER BY EmployeeName ")->result_array();
	}

	function checkLeaveAvailability($leave_type)
	{
		$Emp_Number=$this->session->userdata('Emp_Number');
		$availability =$this->db->query("SELECT SUM(Total_Days) FROM leave_history WHERE Emp_Number='$Emp_Number' AND Leave_Type='$leave_type' ");
		return $availability->result();
	}


	function insert_application_data($leave_type,$d1,$d2,$days,$officer,$reason,$hrs)
	{

		$add_date=date('Y-m-d H:i:s');

		$Emp_Number=$this->session->userdata('Emp_Number');
		$availability =$this->db->query("INSERT INTO leave_history(Emp_Number,Leave_Type,From_Date,To_Date,Total_Days,Leave_Status,Reason,AppliedTime) VALUES('$Emp_Number','$leave_type',STR_TO_DATE(STR_TO_DATE('$d1','%d-%m-%Y'),'%Y-%m-%d'),STR_TO_DATE(STR_TO_DATE('$d2','%d-%m-%Y'),'%Y-%m-%d'),'$days',1,\"$reason\",'$add_date');");
		if($leave_type=='Sick Leave'){
			return $this->db->insert_id();
		}
		if($leave_type=='Comp-Off'){
			$this->db->query("UPDATE team SET Comp_off=ADDTIME(Comp_off,'$hrs') WHERE EmployeeName='$Emp_Number'");
		}
	}



	function insert_other_application($Emp_Number,$leave_type,$d1,$d2,$days,$officer,$reason,$hrs)
	{
		$add_date=date('Y-m-d H:i:s');

		$availability =$this->db->query("INSERT INTO leave_history(Emp_Number,Leave_Type,From_Date,To_Date,Total_Days,Leave_Status,Reason,AppliedTime) VALUES('$Emp_Number','$leave_type','$d1','$d2','$days',1,\"$reason\",'$add_date');");
		if($leave_type=='Sick Leave'){
			return $this->db->insert_id();
		}
		if($leave_type=='Comp-Off'){
			$this->db->query("UPDATE team SET Comp_off=ADDTIME(Comp_off,'$hrs') WHERE EmployeeName='$Emp_Number'");
		}
			
	}


																/* * *   Action on Leave Ststus * * */

		function get_applied_applications()	{
					$logger_num=$this->session->userdata('Emp_Number');
					$availability =$this->db->query("SELECT a.*, b.* 
																					FROM leave_history a
																							 INNER JOIN leave_status b ON  a.Leave_Status = b.Status 
																							 INNER JOIN employees c 	 ON c.Employee_Number=a.Emp_Number
																					WHERE b.Status IN (1) AND c.Reporter='$logger_num'
																					ORDER BY a.From_Date");
					return $availability->result_array();
		}
		
		function get_reported_applications()	{
			$logger_num=$this->session->userdata('Emp_Number');
			$availability =$this->db->query("SELECT a.*, b.* 
																					FROM leave_history a 
																							INNER JOIN leave_status b ON  a.Leave_Status = b.Status 
																							INNER JOIN employees c 	ON  c.Employee_Number=a.Emp_Number
																					WHERE b.Status IN (2)   AND  c.Approver='$logger_num'
																					ORDER BY a.From_Date");
					return $availability->result_array();
		}
	
		function update_LeaveStatusReporter($leave_id,$remark,$status){
					$logger=$this->session->userdata('Emp_Name');
					$this->db->query("UPDATE leave_history 
														SET Leave_Status='$status',
														 Reporter_remarks='$remark',
														 Reported_On=CURRENT_TIMESTAMP,
														 Reported_By='$logger' 
														WHERE Leave_ID='$leave_id' ");
		}

		function update_LeaveStatusApprover($leave_id,$remark,$status){
					$logger=$this->session->userdata('Emp_Name');
					$this->db->query("UPDATE leave_history 
														SET Leave_Status='$status',
														 Approver_remarks='$remark',
														 Approved_On=CURRENT_TIMESTAMP,
														 Approved_By='$logger'  
														WHERE Leave_ID='$leave_id' ");
		}

		
		function get_MailID($emp_num){
				return	$this->db->query("SELECT Email as Emp_Mail,
																	(SELECT DISTINCT Email FROM employees WHERE Employee_Number=a.Reporter) as Reporter_Mail, 
																	(SELECT DISTINCT Email FROM employees WHERE Employee_Number=a.Approver) as Approver_Mail
																	FROM 
																	(SELECT Email, Reporter, Approver FROM employees WHERE Employee_Number='$emp_num') a")->result_array();
		}
		
	function get_Departments()
	{
		return $this->db->query("SELECT DISTINCT * FROM departments ")->result_array();
	}



	
															/* * *         Admin Leave History 		* * */	
	
	function get_DepartmentEmployees($dept){
				return $this->db->query("SELECT  CONCAT(Employee_Name,'::',Employee_Number) as Dept
																FROM employees
																WHERE Department='$dept' AND Employee_Name!=''
																ORDER BY Dept DESC")->result_array();
	}
//1	
	function admin_leavehistory_combination_Y($year){
					return $this->db->query("SELECT a.*, b.*,c.* 
															FROM leave_history a JOIN leave_status b ON  a.Leave_Status = b.Status 
																			INNER JOIN employees c ON c.Employee_Number=a.Emp_Number
															WHERE 	YEAR(a.From_Date)='$year' AND a.Leave_Status IN (4) 
															ORDER BY a.Emp_Number,a.From_Date   ")->result_array();
	}
	function admin_leavehistory_combination_summary_Y($year){
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
																				Group By Emp_Number ")->result_array();
	}
		//2		
	function admin_leavehistory_combination_YM($year,$month){
					return $this->db->query("SELECT a.*, b.*,c.* 
															FROM leave_history a JOIN leave_status b ON  a.Leave_Status = b.Status 
																			INNER JOIN employees c ON c.Employee_Number=a.Emp_Number
															WHERE 	YEAR(a.From_Date)='$year' AND a.Leave_Status IN (4) 
																			AND MONTHNAME(a.From_Date)='$month' 
															ORDER BY a.Emp_Number,a.From_Date   ")->result_array();
	}
	function admin_leavehistory_combination_summary_YM($year,$month){
					return $this->db->query("SELECT SUM(CL) AS 'CL',SUM(PL) AS 'PL', SUM(SL) AS 'SL',
																								SUM(CO) AS 'CO', (SUM(CL)+SUM(PL)+SUM(SL)+SUM(CO)) as Total
																								FROM(
																												SELECT Emp_Number,	MONTHNAME(From_Date) AS 'MonthName', 
																														IF(Leave_Type='CL',Total_Days, 0) as 'CL',
																														IF(Leave_Type='PL',Total_Days, 0) as 'PL',
																														IF(Leave_Type='SL',Total_Days, 0) as 'SL',
																														IF(Leave_Type='CO',Total_Days, 0) as 'CO' 
																												FROM leave_history 
																												WHERE Leave_Status IN (4) AND YEAR(From_Date)='$year' AND MONTHNAME(From_Date)='$month' 
																				) A
																				Group By Emp_Number ")->result_array();
	}
	//3
			function admin_leavehistory_combination_YD($year,$dept){
					return $this->db->query("SELECT a.*, b.*,c.* 
															FROM leave_history a JOIN leave_status b ON  a.Leave_Status = b.Status 
																			INNER JOIN employees c ON c.Employee_Number=a.Emp_Number
															WHERE 	YEAR(a.From_Date)='$year' AND a.Leave_Status IN (4)  AND c.Department='$dept'
															 ORDER BY a.Emp_Number,a.From_Date   ")->result_array();
	}
	function admin_leavehistory_combination_summary_YD($year,$dept){
					return $this->db->query("SELECT SUM(CL) AS 'CL',SUM(PL) AS 'PL', SUM(SL) AS 'SL',
																								SUM(CO) AS 'CO', (SUM(CL)+SUM(PL)+SUM(SL)+SUM(CO)) as Total
																								FROM(
																												SELECT Emp_Number,	MONTHNAME(From_Date) AS 'MonthName', 
																														IF(Leave_Type='CL',Total_Days, 0) as 'CL',
																														IF(Leave_Type='PL',Total_Days, 0) as 'PL',
																														IF(Leave_Type='SL',Total_Days, 0) as 'SL',
																														IF(Leave_Type='CO',Total_Days, 0) as 'CO' 
																												FROM leave_history INNER JOIN employees a ON a.Employee_Number=Emp_Number
																												WHERE Leave_Status IN (4) AND YEAR(From_Date)='$year' 	AND a.Department='$dept' 
																				) A
																				Group By Emp_Number ")->result_array();
	}
	//4	
	function admin_leavehistory_combination_YL($year,$leave){
					return $this->db->query("SELECT a.*, b.*,c.* 
															FROM leave_history a JOIN leave_status b ON  a.Leave_Status = b.Status 
																			INNER JOIN employees c ON c.Employee_Number=a.Emp_Number
															WHERE 	YEAR(a.From_Date)='$year' AND a.Leave_Status IN (4) AND a.Leave_Type='$leave' 
															 ORDER BY a.Emp_Number,a.From_Date   ")->result_array();
	}
	function admin_leavehistory_combination_summary_YL($year,$leave){
					return $this->db->query("SELECT SUM(CL) AS 'CL',SUM(PL) AS 'PL', SUM(SL) AS 'SL',
																								SUM(CO) AS 'CO', (SUM(CL)+SUM(PL)+SUM(SL)+SUM(CO)) as Total
																								FROM(
																												SELECT Emp_Number,	MONTHNAME(From_Date) AS 'MonthName', 
																														IF(Leave_Type='CL',Total_Days, 0) as 'CL',
																														IF(Leave_Type='PL',Total_Days, 0) as 'PL',
																														IF(Leave_Type='SL',Total_Days, 0) as 'SL',
																														IF(Leave_Type='CO',Total_Days, 0) as 'CO' 
																												FROM leave_history 
																												WHERE Leave_Status IN (4) AND YEAR(From_Date)='$year'  AND leave_Type='$leave' 
																				) A
																				Group By Emp_Number ")->result_array();
	}
	//5	
		function admin_leavehistory_combination_YE($year,$emp){
					return $this->db->query("SELECT a.*, b.*,c.* 
															FROM leave_history a JOIN leave_status b ON  a.Leave_Status = b.Status 
																			INNER JOIN employees c ON c.Employee_Number=a.Emp_Number
															WHERE 	YEAR(a.From_Date)='$year' AND a.Leave_Status IN (4) AND a.Emp_Number='$emp' 
															 ORDER BY a.Emp_Number,a.From_Date   ")->result_array();
	}
			function admin_leavehistory_combination_summary_YE($year,$emp){
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
																				Group By Emp_Number ")->result_array();
	}
	
//6
		function admin_leavehistory_combination_YMD($year,$month,$dept){
					return $this->db->query("SELECT a.*, b.*,c.* 
															FROM leave_history a JOIN leave_status b ON  a.Leave_Status = b.Status 
																			INNER JOIN employees c ON c.Employee_Number=a.Emp_Number
															WHERE 	YEAR(a.From_Date)='$year' AND a.Leave_Status IN (4) 
																			AND MONTHNAME(a.From_Date)='$month' AND c.Department='$dept'
															 ORDER BY a.Emp_Number,a.From_Date   ")->result_array();
	}
	function admin_leavehistory_combination_summary_YMD($year,$month,$dept){
					return $this->db->query("SELECT SUM(CL) AS 'CL',SUM(PL) AS 'PL', SUM(SL) AS 'SL',
																								SUM(CO) AS 'CO', (SUM(CL)+SUM(PL)+SUM(SL)+SUM(CO)) as Total
																								FROM(
																												SELECT Emp_Number,	MONTHNAME(From_Date) AS 'MonthName', 
																														IF(Leave_Type='CL',Total_Days, 0) as 'CL',
																														IF(Leave_Type='PL',Total_Days, 0) as 'PL',
																														IF(Leave_Type='SL',Total_Days, 0) as 'SL',
																														IF(Leave_Type='CO',Total_Days, 0) as 'CO' 
																												FROM leave_history INNER JOIN employees a ON a.Employee_Number=Emp_Number
																												WHERE Leave_Status IN (4) AND YEAR(From_Date)='$year' AND MONTHNAME(From_Date)='$month' 
																																AND a.Department='$dept' 
																				) A
																				Group By Emp_Number ")->result_array();
	}
	//7	
		function admin_leavehistory_combination_YME($year,$month,$emp){
					return $this->db->query("SELECT a.*, b.*,c.* 
															FROM leave_history a JOIN leave_status b ON  a.Leave_Status = b.Status 
																			INNER JOIN employees c ON c.Employee_Number=a.Emp_Number
															WHERE 	YEAR(a.From_Date)='$year' AND a.Leave_Status IN (4) AND MONTHNAME(a.From_Date)='$month' 
																			AND a.Emp_Number='$emp' AND a.Leave_Type='$leave' AND c.Department='$dept'
															 ORDER BY a.Emp_Number,a.From_Date   ")->result_array();
	}
		function admin_leavehistory_combination_summary_YME($year,$month,$emp){
					return $this->db->query("SELECT SUM(CL) AS 'CL',SUM(PL) AS 'PL', SUM(SL) AS 'SL',
																								SUM(CO) AS 'CO', (SUM(CL)+SUM(PL)+SUM(SL)+SUM(CO)) as Total
																								FROM(
																												SELECT Emp_Number,	MONTHNAME(From_Date) AS 'MonthName', 
																														IF(Leave_Type='CL',Total_Days, 0) as 'CL',
																														IF(Leave_Type='PL',Total_Days, 0) as 'PL',
																														IF(Leave_Type='SL',Total_Days, 0) as 'SL',
																														IF(Leave_Type='CO',Total_Days, 0) as 'CO' 
																												FROM leave_history
																												WHERE Leave_Status IN (4) AND YEAR(From_Date)='$year' AND MONTHNAME(From_Date)='$month' 
																																	AND Emp_Number='$emp'
																				) A
																				Group By Emp_Number ")->result_array();
	}
	//8
	function admin_leavehistory_combination_YML($year,$month,$leave){
					return $this->db->query("SELECT a.*, b.*,c.* 
															FROM leave_history a JOIN leave_status b ON  a.Leave_Status = b.Status 
																			INNER JOIN employees c ON c.Employee_Number=a.Emp_Number
															WHERE 	YEAR(a.From_Date)='$year' AND a.Leave_Status IN (4) AND MONTHNAME(a.From_Date)='$month' 
																			AND a.Leave_Type='$leave' 
															 ORDER BY a.Emp_Number,a.From_Date   ")->result_array();
	}
	function admin_leavehistory_combination_summary_YML($year,$month,$leave){
					return $this->db->query("SELECT SUM(CL) AS 'CL',SUM(PL) AS 'PL', SUM(SL) AS 'SL',
																								SUM(CO) AS 'CO', (SUM(CL)+SUM(PL)+SUM(SL)+SUM(CO)) as Total
																								FROM(
																												SELECT Emp_Number,	MONTHNAME(From_Date) AS 'MonthName', 
																														IF(Leave_Type='CL',Total_Days, 0) as 'CL',
																														IF(Leave_Type='PL',Total_Days, 0) as 'PL',
																														IF(Leave_Type='SL',Total_Days, 0) as 'SL',
																														IF(Leave_Type='CO',Total_Days, 0) as 'CO' 
																												FROM leave_history 
																												WHERE Leave_Status IN (4) AND YEAR(From_Date)='$year' AND MONTHNAME(From_Date)='$month' 
																																AND leave_Type='$leave' 
																				) A
																				Group By Emp_Number ")->result_array();
	}
	//9	
	function admin_leavehistory_combination_YDE($year,$dept,$emp){
						
				return $this->db->query("SELECT a.*, b.*,c.* 
															FROM leave_history a JOIN leave_status b ON  a.Leave_Status = b.Status 
																			INNER JOIN employees c ON c.Employee_Number=a.Emp_Number
															WHERE 	YEAR(a.From_Date)='$year' AND a.Leave_Status IN (4) AND c.Department='$dept'
																			AND a.Emp_Number='$emp' 
															 ORDER BY a.Emp_Number,a.From_Date
															     ")->result_array();
	}
	function admin_leavehistory_combination_summary_YDE($year,$dept,$emp){
					return $this->db->query("SELECT SUM(CL) AS 'CL',SUM(PL) AS 'PL', SUM(SL) AS 'SL',
																								SUM(CO) AS 'CO', (SUM(CL)+SUM(PL)+SUM(SL)+SUM(CO)) as Total
																								FROM(
																												SELECT Emp_Number,	MONTHNAME(From_Date) AS 'MonthName', 
																														IF(Leave_Type='CL',Total_Days, 0) as 'CL',
																														IF(Leave_Type='PL',Total_Days, 0) as 'PL',
																														IF(Leave_Type='SL',Total_Days, 0) as 'SL',
																														IF(Leave_Type='CO',Total_Days, 0) as 'CO' 
																												FROM leave_history INNER JOIN employees a ON a.Employee_Number=Emp_Number
																												WHERE Leave_Status IN (4) AND YEAR(From_Date)='$year' AND a.Department='$dept'
																																	AND Emp_Number='$emp' 
																				) A
																				Group By Emp_Number ")->result_array();
	}
	//10
	function admin_leavehistory_combination_YDL($year,$dept,$leave){
					return $this->db->query("SELECT a.*, b.*,c.* 
															FROM leave_history a JOIN leave_status b ON  a.Leave_Status = b.Status 
																			INNER JOIN employees c ON c.Employee_Number=a.Emp_Number
															WHERE 	YEAR(a.From_Date)='$year' AND a.Leave_Status IN (4) AND c.Department='$dept'
																			 AND a.Leave_Type='$leave' 
															 ORDER BY a.Emp_Number,a.From_Date   ")->result_array();
	}
	function admin_leavehistory_combination_summary_YDL($year,$dept,$leave){
					return $this->db->query("SELECT SUM(CL) AS 'CL',SUM(PL) AS 'PL', SUM(SL) AS 'SL',
																								SUM(CO) AS 'CO', (SUM(CL)+SUM(PL)+SUM(SL)+SUM(CO)) as Total
																								FROM(
																												SELECT Emp_Number,	MONTHNAME(From_Date) AS 'MonthName', 
																														IF(Leave_Type='CL',Total_Days, 0) as 'CL',
																														IF(Leave_Type='PL',Total_Days, 0) as 'PL',
																														IF(Leave_Type='SL',Total_Days, 0) as 'SL',
																														IF(Leave_Type='CO',Total_Days, 0) as 'CO' 
																												FROM leave_history INNER JOIN employees a ON a.Employee_Number=Emp_Number
																												WHERE Leave_Status IN (4) AND YEAR(From_Date)='$year' 
																																AND a.Department='$dept'  AND leave_Type='$leave' 
																				) A
																				Group By Emp_Number ")->result_array();
	}
	//11
		function admin_leavehistory_combination_YEL($year,$emp,$leave){
					return $this->db->query("SELECT a.*, b.*,c.* 
															FROM leave_history a JOIN leave_status b ON  a.Leave_Status = b.Status 
																			INNER JOIN employees c ON c.Employee_Number=a.Emp_Number
															WHERE 	YEAR(a.From_Date)='$year' AND a.Leave_Status IN (4) 
																			AND a.Emp_Number='$emp' AND a.Leave_Type='$leave' 
															 ORDER BY a.Emp_Number,a.From_Date   ")->result_array();
	}
	function admin_leavehistory_combination_summary_YEL($year,$emp,$leave){
					return $this->db->query("SELECT SUM(CL) AS 'CL',SUM(PL) AS 'PL', SUM(SL) AS 'SL',
																								SUM(CO) AS 'CO', (SUM(CL)+SUM(PL)+SUM(SL)+SUM(CO)) as Total
																								FROM(
																												SELECT Emp_Number,	MONTHNAME(From_Date) AS 'MonthName', 
																														IF(Leave_Type='CL',Total_Days, 0) as 'CL',
																														IF(Leave_Type='PL',Total_Days, 0) as 'PL',
																														IF(Leave_Type='SL',Total_Days, 0) as 'SL',
																														IF(Leave_Type='CO',Total_Days, 0) as 'CO' 
																												FROM leave_history 
																												WHERE Leave_Status IN (4) AND YEAR(From_Date)='$year' 	AND Emp_Number='$emp' 
																																AND Leave_Type='$leave'
																				) A
																				Group By Emp_Number ")->result_array();
	}
	//12
		function admin_leavehistory_combination_YMDE($year,$month,$dept,$emp){
					return $this->db->query("SELECT a.*, b.*,c.* 
															FROM leave_history a JOIN leave_status b ON  a.Leave_Status = b.Status 
																			INNER JOIN employees c ON c.Employee_Number=a.Emp_Number
															WHERE 	YEAR(a.From_Date)='$year' AND a.Leave_Status IN (4) AND MONTHNAME(a.From_Date)='$month' 
																			AND c.Department='$dept' AND a.Emp_Number='$emp' 
															 ORDER BY a.Emp_Number,a.From_Date   ")->result_array();
	}
	function admin_leavehistory_combination_summary_YMDE($year,$month,$dept,$emp){
					return $this->db->query("SELECT SUM(CL) AS 'CL',SUM(PL) AS 'PL', SUM(SL) AS 'SL',
																								SUM(CO) AS 'CO', (SUM(CL)+SUM(PL)+SUM(SL)+SUM(CO)) as Total
																								FROM(
																												SELECT Emp_Number,	MONTHNAME(From_Date) AS 'MonthName', 
																														IF(Leave_Type='CL',Total_Days, 0) as 'CL',
																														IF(Leave_Type='PL',Total_Days, 0) as 'PL',
																														IF(Leave_Type='SL',Total_Days, 0) as 'SL',
																														IF(Leave_Type='CO',Total_Days, 0) as 'CO' 
																												FROM leave_history INNER JOIN employees a ON a.Employee_Number=Emp_Number
																												WHERE Leave_Status IN (4) AND YEAR(From_Date)='$year' AND MONTHNAME(From_Date)='$month' 
																																AND a.Department='$dept' AND Emp_Number='$emp' 
																				) A
																				Group By Emp_Number ")->result_array();
	}
	//13
		function admin_leavehistory_combination_YMDL($year,$month,$dept,$leave){
					return $this->db->query("SELECT a.*, b.*,c.* 
															FROM leave_history a JOIN leave_status b ON  a.Leave_Status = b.Status 
																			INNER JOIN employees c ON c.Employee_Number=a.Emp_Number
															WHERE 	YEAR(a.From_Date)='$year' AND a.Leave_Status IN (4) AND MONTHNAME(a.From_Date)='$month' 
																			AND c.Department='$dept' AND a.Leave_Type='$leave' 
															 ORDER BY a.Emp_Number,a.From_Date   ")->result_array();
	}
	function admin_leavehistory_combination_summary_YMDL($year,$month,$dept,$leave){
					return $this->db->query("SELECT SUM(CL) AS 'CL',SUM(PL) AS 'PL', SUM(SL) AS 'SL',
																								SUM(CO) AS 'CO', (SUM(CL)+SUM(PL)+SUM(SL)+SUM(CO)) as Total
																								FROM(
																												SELECT Emp_Number,	MONTHNAME(From_Date) AS 'MonthName', 
																														IF(Leave_Type='CL',Total_Days, 0) as 'CL',
																														IF(Leave_Type='PL',Total_Days, 0) as 'PL',
																														IF(Leave_Type='SL',Total_Days, 0) as 'SL',
																														IF(Leave_Type='CO',Total_Days, 0) as 'CO' 
																												FROM leave_history INNER JOIN employees a ON a.Employee_Number=Emp_Number
																												WHERE Leave_Status IN (4) AND YEAR(From_Date)='$year' AND MONTHNAME(From_Date)='$month' 
																																AND a.Department='$dept' AND Emp_Number='$emp'  AND leave_Type='$leave' 
																				) A
																				Group By Emp_Number ")->result_array();
	}
	//14
		function admin_leavehistory_combination_YMEL($year,$month,$emp,$leave){
					return $this->db->query("SELECT a.*, b.*,c.* 
															FROM leave_history a JOIN leave_status b ON  a.Leave_Status = b.Status 
																			INNER JOIN employees c ON c.Employee_Number=a.Emp_Number
															WHERE 	YEAR(a.From_Date)='$year' AND a.Leave_Status IN (4) AND MONTHNAME(a.From_Date)='$month' 
																			AND a.Emp_Number='$emp' AND a.Leave_Type='$leave' 
															 ORDER BY a.Emp_Number,a.From_Date   ")->result_array();
	}
	function admin_leavehistory_combination_summary_YMEL($year,$month,$emp,$leave){
					return $this->db->query("SELECT SUM(CL) AS 'CL',SUM(PL) AS 'PL', SUM(SL) AS 'SL',
																								SUM(CO) AS 'CO', (SUM(CL)+SUM(PL)+SUM(SL)+SUM(CO)) as Total
																								FROM(
																												SELECT Emp_Number,	MONTHNAME(From_Date) AS 'MonthName', 
																														IF(Leave_Type='CL',Total_Days, 0) as 'CL',
																														IF(Leave_Type='PL',Total_Days, 0) as 'PL',
																														IF(Leave_Type='SL',Total_Days, 0) as 'SL',
																														IF(Leave_Type='CO',Total_Days, 0) as 'CO' 
																												FROM leave_history 
																												WHERE Leave_Status IN (4) AND YEAR(From_Date)='$year' AND MONTHNAME(From_Date)='$month' 
																																AND Emp_Number='$emp'	 AND leave_Type='$leave' 
																				) A
																				Group By Emp_Number ")->result_array();
	}
	//15	
	function admin_leavehistory_combination_YDEL($year,$dept,$emp,$leave){
					return $this->db->query("SELECT a.*, b.*,c.* 
															FROM leave_history a JOIN leave_status b ON  a.Leave_Status = b.Status 
																			INNER JOIN employees c ON c.Employee_Number=a.Emp_Number
															WHERE 	YEAR(a.From_Date)='$year' AND a.Leave_Status IN (4)  AND c.Department='$dept'
																			AND a.Emp_Number='$emp' AND a.Leave_Type='$leave' 
															 ORDER BY a.Emp_Number,a.From_Date   ")->result_array();
	}
	function admin_leavehistory_combination_summary_YDEL($year,$dept,$emp,$leave){
					return $this->db->query("SELECT SUM(CL) AS 'CL',SUM(PL) AS 'PL', SUM(SL) AS 'SL',
																								SUM(CO) AS 'CO', (SUM(CL)+SUM(PL)+SUM(SL)+SUM(CO)) as Total
																								FROM(
																												SELECT Emp_Number,	MONTHNAME(From_Date) AS 'MonthName', 
																														IF(Leave_Type='CL',Total_Days, 0) as 'CL',
																														IF(Leave_Type='PL',Total_Days, 0) as 'PL',
																														IF(Leave_Type='SL',Total_Days, 0) as 'SL',
																														IF(Leave_Type='CO',Total_Days, 0) as 'CO' 
																												FROM leave_history INNER JOIN employees a ON a.Employee_Number=Emp_Number
																												WHERE Leave_Status IN (4) AND YEAR(From_Date)='$year' 	AND a.Department='$dept' 
																																AND Emp_Number='$emp'  AND leave_Type='$leave' 
																				) A
																				Group By Emp_Number ")->result_array();
	}
	//	16
		function admin_leavehistory_combination_YMDEL($year,$month,$dept,$emp,$leave){
					return $this->db->query("SELECT a.*, b.*,c.* 
															FROM leave_history a JOIN leave_status b ON  a.Leave_Status = b.Status 
																			INNER JOIN employees c ON c.Employee_Number=a.Emp_Number
															WHERE 	YEAR(a.From_Date)='$year' AND a.Leave_Status IN (4) AND MONTHNAME(a.From_Date)='$month' 
																			AND a.Emp_Number='$emp' AND a.Leave_Type='$leave' AND c.Department='$dept'
															 ORDER BY a.Emp_Number,a.From_Date   ")->result_array();
	}
	function admin_leavehistory_combination_summary_YMDEL($year,$month,$dept,$emp,$leave){
					return $this->db->query("SELECT SUM(CL) AS 'CL',SUM(PL) AS 'PL', SUM(SL) AS 'SL',
																								SUM(CO) AS 'CO', (SUM(CL)+SUM(PL)+SUM(SL)+SUM(CO)) as Total
																								FROM(
																												SELECT Emp_Number,	MONTHNAME(From_Date) AS 'MonthName', 
																														IF(Leave_Type='CL',Total_Days, 0) as 'CL',
																														IF(Leave_Type='PL',Total_Days, 0) as 'PL',
																														IF(Leave_Type='SL',Total_Days, 0) as 'SL',
																														IF(Leave_Type='CO',Total_Days, 0) as 'CO' 
																												FROM leave_history INNER JOIN employees a ON a.Employee_Number=Emp_Number
																												WHERE Leave_Status IN (4) AND YEAR(From_Date)='$year' AND MONTHNAME(From_Date)='$month' 
																																AND a.Department='$dept' AND Emp_Number='$emp'  AND leave_Type='$leave' 
																				) A
																				Group By Emp_Number ")->result_array();
	}
	
	
	
	
	
																/* * *         My  Leave History 		* * */	
	
	
	function my_leavehistory_general_all($year){
				$emp=$this->session->userdata('Emp_Number');
				return $this->db->query("SELECT  a.*, b.* FROM leave_history a JOIN leave_status b ON  a.Leave_Status = b.Status 
															WHERE 	YEAR(From_Date)='$year' AND a.Emp_Number='$emp'
															 ORDER BY a.From_Date ")->result_array();
	}


	function my_leavehistory_general_month($year,$month){
				$emp=$this->session->userdata('Emp_Number');
				return $this->db->query("SELECT a.*, b.* FROM leave_history a JOIN leave_status b ON  a.Leave_Status = b.Status
															WHERE 	YEAR(From_Date)='$year'  AND ( MONTHNAME(From_Date)='$month' OR MONTHNAME(To_Date)='$month'  )
															 AND a.Emp_Number='$emp'
															 ORDER BY a.From_Date   ")->result_array();
	}


	function my_leavehistory_general_filter($year,$leave){
				$emp=$this->session->userdata('Emp_Number');	
				return $this->db->query("SELECT a.*, b.* FROM leave_history a JOIN leave_status b ON  a.Leave_Status = b.Status 
																	WHERE 	YEAR(From_Date)='$year' AND a.Emp_Number='$emp' AND a.Leave_Type='$leave'
															 ORDER BY a.From_Date   ")->result_array();
	}


	function my_leavehistory_approved($year){
						$emp=$this->session->userdata('Emp_Number');	
						return $this->db->query("SELECT a.*, b.* FROM leave_history a JOIN leave_status b ON  a.Leave_Status = b.Status 
															WHERE 	YEAR(From_Date)='$year' AND a.Emp_Number='$emp' AND a.Leave_Status IN (4)
															 ORDER BY a.Emp_Number,a.From_Date   ")->result_array();
	}



	function get_leave_summary()
	{
		$y=date('Y');
		$m=date('m');
		$Emp_Number=$this->session->userdata('Emp_Number');
		return $this->db->query("SELECT SUM(Total_Days) AS Total_Days, Leave_Type FROM leave_history  WHERE Leave_Status IN (2,4) AND Emp_Number='$Emp_Number' AND YEAR(From_Date)='$y'  AND MONTH(From_Date)='$m'
							GROUP BY Leave_Type ")->result_array();
	}

	function get_leave_summary_year()
	{
		$d1=date('Y');
		$Emp_Number=$this->session->userdata('Emp_Number');
		return $this->db->query("SELECT SUM(Total_Days) AS Total_Days, Leave_Type FROM leave_history  WHERE Leave_Status IN (2,4) AND Emp_Number='$Emp_Number' AND YEAR(From_Date)='$d1'
							 GROUP BY Leave_Type ")->result_array();
	}

	function get_leave_summary_pend()
	{
		//	$d1=date('Y');
		$Emp_Number=$this->session->userdata('Emp_Number');
		return $this->db->query("SELECT SUM(Total_Days) AS Total_Days, Leave_Type FROM leave_history  WHERE Leave_Status IN (1) AND Emp_Number='$Emp_Number'   GROUP BY Leave_Type ")->result_array();
	}
	
	function get_doj()
	{
		$Emp_Number=$this->session->userdata('Emp_Number');
		return $this->db->query("SELECT DATE_FORMAT(JoiningDate,'%d-%m-%Y') as JoiningDate, TIMESTAMPDIFF(MONTH,JoiningDate,CURRENT_TIMESTAMP) as Experience FROM team  WHERE EmployeeName='$Emp_Number' ")->result_array();
	}




	function insert_file($file_name,$id){
		$date=date('Y-m-d H:i:s');
		return $this->db->query("INSERT INTO files(filename,leave_id,date) values('$file_name','$id','$date')");
	}
		

	function show_document($lid)
	{
		$data=$this->db->query("SELECT filename FROM files WHERE leave_id='$lid'")->result_array();
		foreach($data as $name){
			$name1=$name["filename"];
		}
		return $name1;
	}





	function getMailData($date_from,$reasoning,$day,$l_type,$Offr){
		$Emp_Number=$this->session->userdata('Emp_Number');
			
		return $this->db->query("SELECT DISTINCT (SELECT email FROM admin_users WHERE name='$Emp_Number') AS FromMail ,
					(SELECT email FROM admin_users WHERE name=(SELECT LeaveApprover_L1 FROM team WHERE Emp_Number='$Emp_Number' ) ) AS ToMail1,
					 (SELECT email 	FROM admin_users WHERE user_email='MD' limit 1 ) AS ToMail2,'$Emp_Number' as Name,
					filename,file_count
					 FROM  (
					 SELECT IF(filename!='',filename,'NO') as filename, COUNT(filename) as file_count FROM files	WHERE leave_id = (SELECT Leave_ID FROM leave_history WHERE Emp_Number='$Emp_Number' AND Leave_Type='Sick Leave' AND DATE_FORMAT(From_Date,'%d-%m-%Y')='$date_from') limit 1) a")->result_array();
			

	}
		
	function approve_mail($lid){
		$app=$this->session->userdata('Emp_Number');
		return $this->db->query("SELECT Emp_Number,Leave_Type AS Type,From_Date As Date,Total_Days As Days,AppliedTime AS Time,leave_status.Description As Status,
																	admin_users.email AS Email,(SELECT email FROM admin_users WHERE name='$app' ) AS FromMail
																	FROM leave_history 
																	INNER JOIN leave_status ON leave_status.Status=leave_history.Leave_Status 
																	INNER JOIN admin_users ON admin_users.name=leave_history.Emp_Number
																	WHERE leaveID='$lid'")->result_array();	

	}
		

		
			
		
		

	function get_OT_hrs(){
		$Emp_Number=$this->session->userdata('Emp_Number');
			
		return $this->db->query("SELECT HOUR(used) as used,HOUR(ot) as ot,HOUR(IFNULL(sun,'00:00:00')) as sun, HOUR(ADDTIME(ot,IFNULL(sun,'00:00:00'))) as tot, HOUR(SUBTIME(ADDTIME(ot,IFNULL(sun,'00:00:00')),used)) as remain
					FROM ( SELECT
					(SELECT Sec_to_time(SUM(TIME_TO_SEC(ts_duty))) FROM time_sheet WHERE ts_name='$Emp_Number' AND (DAYNAME(ts_date)='Sunday' OR ts_date IN (SELECT holi_date FROM holidays)))  as sun, 
					(SELECT Sec_to_time(SUM(TIME_TO_SEC(ts_ot))) FROM time_sheet WHERE ts_name='$Emp_Number' AND (ts_date NOT IN (SELECT holi_date FROM holidays)) AND DAYNAME(ts_date)!='Sunday') as ot, 
					(SELECT Comp_off FROM team WHERE Emp_Number='$Emp_Number') AS used
					FROM time_sheet WHERE ts_name='$Emp_Number') a ")->result_array();
			
	}


	function get_approved_leaves($year,$month,$emp){
		if($emp!='All Employees'){
			return $this->db->query("SELECT a.*, b.*, c.* FROM leave_history a JOIN leave_status b ON  a.Leave_Status = b.Status JOIN team c ON c.Employee_Number = a.Employee_Number
															WHERE 	YEAR(a.From_Date)='$year'  AND  MONTHNAME(a.From_Date)='$month'  AND a.Leave_Status IN (4) AND a.Employee_Number='$emp' 
															 ORDER BY a.AppliedTime Desc ")->result_array();
		}
		if($emp=='All Employees'){
			return $this->db->query("SELECT a.*, b.*, c.* FROM leave_history a JOIN leave_status b ON  a.Leave_Status = b.Status JOIN team c ON c.Employee_Number = a.Employee_Number
															WHERE 	YEAR(a.From_Date)='$year'  AND  MONTHNAME(a.From_Date)='$month'  AND a.Leave_Status IN (4) 
															 ORDER BY a.AppliedTime Desc ")->result_array();
		}
	}

	function process_leave($id){
			
		$this->db->query("UPDATE leave_history SET Leave_Status='5' WHERE Leave_ID='$id'");
			
	}


	function remove_leave($id){
		$this->db->query("DELETE FROM  leave_history WHERE Leave_ID='$id' ");

	}

	
	
	
	
	
																		/* * * 			Permissions 			* * */
	function get_pending_permissions(){
					return $this->db->query("SELECT *
																	  FROM permissions 
																	  WHERE Status='Applied' ORDER BY P_Date")->result_array();
	}
	
	
	function update_Permission($perm_id,$status,$remark){
		$approver=$this->session->userdata('Emp_Name');
		$this->db->query("UPDATE permissions 
											SET Status='$status',
													Approved_By='$approver',
													Approved_On=CURRENT_TIMESTAMP,
													Approver_Remarks='$remark' 
											WHERE permission_id='$perm_id' ");

	}


	
	function get_permission_years($emp_num){
			if($emp_num=='All'){
						return $this->db->query("SELECT DISTINCT YEAR(P_Date) as Year
																	FROM permissions ORDER BY Year DESC")->result_array();
			}
			else{
						return $this->db->query("SELECT DISTINCT YEAR(P_Date) as Year
																	FROM permissions 
																	WHERE Emp_Number='$emp_num'  ORDER BY Year DESC")->result_array();
			}
			
	}

	
	
//		 Permission History	
	function get_permission_history($year,$status,$emp_num){
				if($status=='All'){
											return $this->db->query("SELECT *,
																								(SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(Total_Hrs))) FROM  permissions WHERE YEAR(P_Date)='$year' AND Emp_Number='$emp_num' ) as TotalHours
																							FROM permissions
																							WHERE YEAR(P_Date)='$year' AND Emp_Number='$emp_num' ")->result_array();
					
				}
				else if($status=='Applied'){
											return $this->db->query("SELECT *,
																								IFNULL((SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(Total_Hrs))) FROM  permissions WHERE YEAR(P_Date)='$year' AND Emp_Number='$emp_num' ),'00:00:00') as TotalHours
																							FROM permissions
																							WHERE YEAR(P_Date)='$year' AND Emp_Number='$emp_num'
																											AND Status='Applied' AND P_Date>=CURDATE() ")->result_array();
					
					
				}
				else if($status=='NO'){
											return $this->db->query("SELECT *,
																								(SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(Total_Hrs))) FROM  permissions WHERE YEAR(P_Date)='$year' AND Emp_Number='$emp_num' ) as TotalHours
																							FROM permissions
																							WHERE YEAR(P_Date)='$year' AND Emp_Number='$emp_num'
																											AND Status='Applied' AND P_Date<CURDATE() ")->result_array();
					
					
				}
				
				else{
											return $this->db->query("SELECT *,
																									(SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(Total_Hrs))) FROM  permissions WHERE YEAR(P_Date)='$year' AND Emp_Number='$emp_num' AND Status='$status' ) as TotalHours
																								FROM permissions
																								WHERE YEAR(P_Date)='$year' AND Emp_Number='$emp_num'
																										AND Status='$status' ")->result_array();
					
					
				}
			
				

	}
	
																			/* * * 		 Admin Permission History		* * */
	

//1
	function admin_permission_history_Y($year){
								return $this->db->query("SELECT a.*, b.Department
																					FROM permissions a INNER JOIN employees b ON b.Employee_Number=a.Emp_Number
																					WHERE a.Status='Allowed' AND YEAR(a.P_Date)='$year'
																					ORDER BY b.Department,a.Emp_Number,a.P_Date    ")->result_array();
		}

		function admin_permission_history_summary_Y($year){
								return $this->db->query("SELECT SUM(HOUR(Total_Hrs))+HOUR(SEC_TO_TIME(SUM(MINUTE(Total_Hrs)*60))) as TotalHours
																					FROM permissions a INNER JOIN employees b ON b.Employee_Number=a.Emp_Number
																					WHERE a.Status='Allowed' AND YEAR(a.P_Date)='$year'  ")->result_array();
		}

//2
	function admin_permission_history_YM($year,$month){
								return $this->db->query("SELECT a.*, b.Department
																					FROM permissions a INNER JOIN employees b ON b.Employee_Number=a.Emp_Number
																					WHERE a.Status='Allowed' AND YEAR(a.P_Date)='$year' AND MONTHNAME(a.P_Date)='$month'
																					ORDER BY b.Department,a.Emp_Number,a.P_Date    ")->result_array();
		}

		function admin_permission_history_summary_YM($year,$month){
								return $this->db->query("SELECT SUM(HOUR(Total_Hrs))+HOUR(SEC_TO_TIME(SUM(MINUTE(Total_Hrs)*60))) as TotalHours
																					FROM permissions a
																					WHERE a.Status='Allowed' AND YEAR(a.P_Date)='$year' AND MONTHNAME(a.P_Date)='$month' ")->result_array();
		}

		//3
	function admin_permission_history_YD($year,$dept){
								return $this->db->query("SELECT a.*, b.Department
																					FROM permissions a INNER JOIN employees b ON b.Employee_Number=a.Emp_Number
																					WHERE a.Status='Allowed' AND YEAR(a.P_Date)='$year' AND b.Department='$dept'
																					ORDER BY b.Department,a.Emp_Number,a.P_Date    ")->result_array();
		}

		function admin_permission_history_summary_YD($year,$dept){
								return $this->db->query("SELECT SUM(HOUR(Total_Hrs))+HOUR(SEC_TO_TIME(SUM(MINUTE(Total_Hrs)*60))) as TotalHours
																					FROM permissions a INNER JOIN employees b ON b.Employee_Number=a.Emp_Number 
																					WHERE a.Status='Allowed' AND YEAR(a.P_Date)='$year' 	AND b.Department='$dept' ")->result_array();
		}

		//4
	function admin_permission_history_YE($year,$emp){
								return $this->db->query("SELECT a.*, b.Department
																					FROM permissions a 
																					WHERE a.Status='Allowed' AND YEAR(a.P_Date)='$year'  AND a.Emp_Number='$emp'
																					ORDER BY a.Emp_Number,a.P_Date    ")->result_array();
		}

		function admin_permission_history_summary_YE($year,$emp){
								return $this->db->query("SELECT SUM(HOUR(Total_Hrs))+HOUR(SEC_TO_TIME(SUM(MINUTE(Total_Hrs)*60))) as TotalHours
																					FROM permissions a
																					WHERE a.Status='Allowed' AND YEAR(a.P_Date)='$year' AND a.Emp_Number='$emp' ")->result_array();
		}

		//5
	function admin_permission_history_YMD($year,$month,$dept){
								return $this->db->query("SELECT a.*, b.Department
																					FROM permissions a INNER JOIN employees b ON b.Employee_Number=a.Emp_Number
																					WHERE a.Status='Allowed' AND YEAR(a.P_Date)='$year' AND MONTHNAME(a.P_Date)='$month'
																									AND b.Department='$dept' 
																					ORDER BY b.Department,a.Emp_Number,a.P_Date    ")->result_array();
		}

		function admin_permission_history_summary_YMD($year,$month,$dept){
								return $this->db->query("SELECT SUM(HOUR(Total_Hrs))+HOUR(SEC_TO_TIME(SUM(MINUTE(Total_Hrs)*60))) as TotalHours
																					FROM permissions a INNER JOIN employees b ON b.Employee_Number=a.Emp_Number 
																					WHERE a.Status='Allowed' AND YEAR(a.P_Date)='$year' AND MONTHNAME(a.P_Date)='$month'
																									AND b.Department='$dept'  ")->result_array();
		}

		//6
	function admin_permission_history_YME($year,$month,$emp){
								return $this->db->query("SELECT a.*,b.Department
																					FROM permissions a
																					WHERE a.Status='Allowed' AND YEAR(a.P_Date)='$year' AND MONTHNAME(a.P_Date)='$month'
																									 AND a.Emp_Number='$emp'
																					ORDER BY a.Emp_Number,a.P_Date    ")->result_array();
		}

		function admin_permission_history_summary_YME($year,$month,$emp){
								return $this->db->query("SELECT SUM(HOUR(Total_Hrs))+HOUR(SEC_TO_TIME(SUM(MINUTE(Total_Hrs)*60))) as TotalHours
																					FROM permissions a
																					WHERE a.Status='Allowed' AND YEAR(a.P_Date)='$year' AND MONTHNAME(a.P_Date)='$month'
																									 AND a.Emp_Number='$emp' ")->result_array();
		}

		//7
	function admin_permission_history_YDE($year,$dept,$emp){
								return $this->db->query("SELECT a.*, b.Department
																					FROM permissions a INNER JOIN employees b ON b.Employee_Number=a.Emp_Number
																					WHERE a.Status='Allowed' AND YEAR(a.P_Date)='$year' 
																									AND b.Department='$dept' AND a.Emp_Number='$emp'
																					ORDER BY b.Department,a.Emp_Number,a.P_Date    ")->result_array();
		}

		function admin_permission_history_summary_YDE($year,$dept,$emp){
								return $this->db->query("SELECT SUM(HOUR(Total_Hrs))+HOUR(SEC_TO_TIME(SUM(MINUTE(Total_Hrs)*60))) as TotalHours
																					FROM permissions a INNER JOIN employees b ON b.Employee_Number=a.Emp_Number
																					WHERE a.Status='Allowed' AND YEAR(a.P_Date)='$year' 
																									AND b.Department='$dept' AND a.Emp_Number='$emp' ")->result_array();
		}

		//8
	function admin_permission_history_YMDE($year,$month,$dept,$emp){
								return $this->db->query("SELECT a.*, b.Department
																					FROM permissions a INNER JOIN employees b ON b.Employee_Number=a.Emp_Number
																					WHERE a.Status='Allowed' AND YEAR(a.P_Date)='$year' AND MONTHNAME(a.P_Date)='$month'
																									AND b.Department='$dept' AND a.Emp_Number='$emp'
																					ORDER BY b.Department,a.Emp_Number,a.P_Date    ")->result_array();
		}

		function admin_permission_history_summary_YMDE($year,$month,$dept,$emp){
								return $this->db->query("SELECT SUM(HOUR(Total_Hrs))+HOUR(SEC_TO_TIME(SUM(MINUTE(Total_Hrs)*60))) as TotalHours
																					FROM permissions a INNER JOIN employees b ON b.Employee_Number=a.Emp_Number
																					WHERE a.Status='Allowed' AND YEAR(a.P_Date)='$year' AND MONTHNAME(a.P_Date)='$month'
																									AND b.Department='$dept' AND a.Emp_Number='$emp' ")->result_array();
		}

		
		
	function SendReminder($id){
		$Emp_Number=$this->session->userdata('Emp_Number');
		$this->db->query("UPDATE leave_history SET ReminderCount=ReminderCount+1 WHERE Leave_ID='$id'");
		return $this->db->query("SELECT email FROM admin_users WHERE name=(SELECT LeaveApprover_L1 FROM team  WHERE EmployeeName='$Emp_Number' ) ")->result_array();
	}

	
	
	
	
	
	
	
	
	
	
	
	
}?>