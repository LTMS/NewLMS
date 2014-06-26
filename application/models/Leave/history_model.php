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
		return $this->db->query("SELECT DISTINCT Emp_Number AS 'Name' FROM  admin_users WHERE Emp_Role NOT IN ('MD') ORDER BY name")->result_array();
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

	function add_dept($id)
	{
		$this->db->query("INSERT INTO departments(department) VALUES('$id')");
	}

	function remove_dept($id)
	{
		$this->db->query("DELETE FROM departments WHERE id='$id'");
	}



	
															/* * *         Admin Leave History 		* * */	
	
	
	
	
	function admin_leavehistory_general_all($year,$month,$emp){
			
		return $this->db->query("SELECT a.*, b.* FROM leave_history a JOIN leave_status b ON  a.Leave_Status = b.Status JOIN team c ON c.Employee_Number = a.Emp_Number
															WHERE 	YEAR(From_Date)='$year' AND a.Emp_Number='$emp'
															 ORDER BY a.From_Date ")->result_array();
	}


	function admin_leavehistory_general_month($year,$month,$emp){
			
		return $this->db->query("SELECT a.*, b.* FROM leave_history a JOIN leave_status b ON  a.Leave_Status = b.Status JOIN team c ON c.Employee_Number = a.Emp_Number
															WHERE 	YEAR(From_Date)='$year'  AND ( MONTHNAME(From_Date)='$month' OR MONTHNAME(To_Date)='$month'  )
															 AND a.Emp_Number='$emp'
															 ORDER BY a.From_Date   ")->result_array();
	}


	function admin_leavehistory_general_filter($year,$emp,$leave){
			
		return $this->db->query("SELECT a.*, b.* FROM leave_history a JOIN leave_status b ON  a.Leave_Status = b.Status 
															WHERE 	YEAR(From_Date)='$year' AND a.Emp_Number='$emp' AND a.Leave_Type='$leave'
															 ORDER BY a.From_Date   ")->result_array();
	}


	function admin_leavehistory_approved_all($year){
			
				return $this->db->query("SELECT a.*, b.* FROM leave_history a JOIN leave_status b ON  a.Leave_Status = b.Status 
															WHERE 	YEAR(From_Date)='$year' AND a.Leave_Status IN (2,4) 
															 ORDER BY a.Emp_Number,a.From_Date   ")->result_array();
	}


	function admin_leavehistory_approved_ind($year,$emp){
			
				return $this->db->query("SELECT a.*, b.* FROM leave_history a JOIN leave_status b ON  a.Leave_Status = b.Status 
															WHERE 	YEAR(From_Date)='$year' AND a.Emp_Number='$emp' AND a.Leave_Status IN (4) 
															 ORDER BY a.Emp_Number,a.From_Date   ")->result_array();
	}


	function get_DepartmentEmployees($dept){
				return $this->db->query("SELECT  CONCAT(Employee_Name,'::',Employee_Number) as Dept
																FROM employees
																WHERE Department='$dept' AND Employee_Name!=''
																ORDER BY Dept DESC")->result_array();
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



	
	function get_history_teamleader($d1,$d2,$string){
		$Emp_Number=$this->session->userdata('Emp_Number');
		if($d1!=''&&$d2!=''){
			if( $string=='null'){
				return $this->db->query("SELECT a . *, b . *, c . * FROM leave_history a JOIN leave_status b ON a.Leave_Status = b.Status JOIN team c ON c.Employee_Number = a.Employee_Number
																							WHERE 	STR_TO_DATE(DATE_FORMAT(a.From_Date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y')
																							 AND  a.Employee_Number NOT IN  ('$Emp_Number')  AND a.Leave_Status IN ('2','4')  AND c.Department=(SELECT Department from team where EmployeeName='$Emp_Number')
																						ORDER BY a.AppliedTime Desc")->result_array();
			}
			else{
				return $this->db->query("	SELECT a . *, b . *, c . * FROM leave_history a JOIN leave_status b ON a.Leave_Status = b.Status JOIN team c ON c.Employee_Number = a.Employee_Number
															WHERE 	STR_TO_DATE(DATE_FORMAT(a.From_Date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y') AND a.Employee_Number NOT IN  ('$Emp_Number') AND  (a.Employee_Number='$string' OR a.Leave_Status IN ('$string') OR a.Leave_Type='$string')
															AND c.Department=(SELECT Department from team where EmployeeName='$Emp_Number')
					                                		ORDER BY a.AppliedTime Desc ")->result_array();
			}
		}
		else{
			if( $string=='null'){
				return $this->db->query("SELECT a . *, b . *, c . * FROM leave_history a JOIN leave_status b ON a.Leave_Status = b.Status JOIN team c ON c.Employee_Number = a.Employee_Number
																			WHERE a.Employee_Number NOT IN  ('$Emp_Number')  AND a.Leave_Status IN ('2','4')  AND c.Department=(SELECT Department from team where EmployeeName='$Emp_Number')
																			ORDER BY a.AppliedTime Desc")->result_array();
			}
			else{
				return $this->db->query("	SELECT a . *, b . *, c . * FROM leave_history a JOIN leave_status b ON a.Leave_Status = b.Status JOIN team c ON c.Employee_Number = a.Employee_Number
												WHERE a.Employee_Number NOT IN  ('$Emp_Number')  AND  (a.Employee_Number='$string' OR a.Leave_Status IN ('$string') OR a.Leave_Type='$string')
												AND c.Department=(SELECT Department from team where EmployeeName='$Emp_Number') AND Leave_Status IN (2,4)
		                                		ORDER BY a.AppliedTime Desc ")->result_array();
			}
		}
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
															WHERE 	YEAR(a.From_Date)='$year' AND  MONTH(a.From_Date)='$month'  AND a.Leave_Status IN ('2','4') AND a.Employee_Number='$emp' 
															 ORDER BY a.AppliedTime Desc ")->result_array();
		}
		if($emp=='All Employees'){
			return $this->db->query("SELECT a.*, b.*, c.* FROM leave_history a JOIN leave_status b ON  a.Leave_Status = b.Status JOIN team c ON c.Employee_Number = a.Employee_Number
															WHERE 	YEAR(a.From_Date)='$year' AND  MONTH(a.From_Date)='$month'  AND a.Leave_Status IN ('2','4') 
															 ORDER BY a.AppliedTime Desc ")->result_array();
		}
	}

	function process_leave($id){
			
		$this->db->query("UPDATE leave_history SET Leave_Status='5' WHERE Leave_ID='$id'");
			
	}


	function remove_leave($id){
		$this->db->query("DELETE FROM  leave_history WHERE Leave_ID='$id' ");

	}


	function get_permission($d){
		$Emp_Number=$this->session->userdata('Emp_Number');
		$this->db->query("SELECT COUNT(P_Date) as permission FROM permissions WHERE  Emp_Number='$Emp_Number' AND month(STR_TO_DATE(DATE_FORMAT(P_Date,'%d-%m-%Y'),'%d-%m-%Y'))=month('$d') ")->result_array();

	}
	function get_allpermissions($y,$d){
		$Emp_Number=$this->session->userdata('Emp_Number');
		return $this->db->query("SELECT DISTINCT (SELECT COUNT(P_Date) as permission FROM permissions WHERE Emp_Number='$Emp_Number' AND MONTH(P_Date) ='05' AND YEAR(P_Date) ='2014' AND Status='Approved') as month,
																							(SELECT COUNT(P_Date) as permission FROM permissions WHERE Emp_Number='$Emp_Number' AND YEAR(P_Date) ='2014' AND Status='Approved') as year,
																							(SELECT COUNT(P_Date) as permission FROM permissions WHERE Emp_Number='$Emp_Number' AND YEAR(P_Date) ='2014' AND Status='Applied') as pending
																							FROM permissions ")->result_array();

	}


	function check_permission_data($d){
		$Emp_Number=$this->session->userdata('Emp_Number');
		$data=$this->db->query("SELECT COUNT(P_Date) as 'count' FROM permissions WHERE  Emp_Number='$Emp_Number' AND MONTH(P_Date)=SUBSTRING('$d',4,2)  AND YEAR(P_Date)=SUBSTRING('$d',7,10)  AND Status!='Applied' ")->result_array();
		foreach($data as $name){
			$count1=$name["count"];
		}
		return $count1;

	}

	function get_pending_permissions(){
		$availability =$this->db->query("SELECT *  FROM permissions  WHERE Status='Applied' ORDER BY permission_id");
		return $availability->result_array();

			
	}


	function process_permission($id,$str){
		$this->db->query("UPDATE permissions SET Status='$str' WHERE permission_id='$id' ");

	}

	function leaves_on_sameday($d1,$d2,$id){
		return $this->db->query("SELECT Emp_Number,Total_Days, Reason,Leave_Status FROM leave_history  WHERE  DATE_FORMAT(From_Date,'%d-%m-%Y')='$d1' AND Leave_ID NOT IN ('$id') AND Leave_Status IN ('2','4')")->result();
	}

	function getRecentLeave($Emp_Number,$id){
		return $this->db->query("SELECT CONCAT(CONCAT(DATE_FORMAT(From_Date,'%d-%m-%Y'),' : ',Total_Days),' ', 'Day(s)') as date FROM leave_history  WHERE Emp_Number='$Emp_Number' AND Leave_Status IN ('2','4') AND Leave_ID NOT IN ('$id') ORDER BY Leave_ID DESC Limit 1  ")->result_array();
	}

	function SendReminder($id){
		$Emp_Number=$this->session->userdata('Emp_Number');
		$this->db->query("UPDATE leave_history SET ReminderCount=ReminderCount+1 WHERE Leave_ID='$id'");
		return $this->db->query("SELECT email FROM admin_users WHERE name=(SELECT LeaveApprover_L1 FROM team  WHERE EmployeeName='$Emp_Number' ) ")->result_array();
	}


	function add_employee_details($name){
		$this->db->query("INSERT INTO employee_details(EmployeeName) VALUES('$name')  ");

	}

	function update_leave_param($cm,$ct,$st,$sp,$pt,$pm,$pe,$comp,$permis,$carry,$pp){
		$Emp_Number=$this->session->userdata('Emp_Number');
		$this->db->query("UPDATE parameters
														SET casual_month ='$cm',
																casual_total = '$ct',
																sick_limit = '$sp',
																sick_total = '$st',
																paid_exp = '$pe',
																paid_total = '$pt',
																paid_min = '$pm',
																paid_prior = '$pp',
																comp_off_reduct = '$comp',
																permission_hrs = '$permis',
																carry_forward = '$carry'
																WHERE id_param ='1' ");
	}


	function get_holidays_calendar($year1,$year2){
		return $this->db->query("SELECT COUNT(holi_date) as count, holi_date,CONCAT('[',Month(holi_date),',',DAY(holi_date),']') as date FROM holidays WHERE YEAR(holi_date) IN ('$year1','$year2' ) ")->result_array();
			
	}

	function calculate_workingdays($date1,$date2){
		$Emp_Number=$this->session->userdata('Emp_Number');
		return $this->db->query("SELECT (leaves+holidays+sundays) as total, leaves,holidays,sundays
																					FROM (SELECT COUNT(From_Date) as leaves,
																							(SELECT COUNT(holi_date)  FROM holidays WHERE STR_TO_DATE(DATE_FORMAT(holi_date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$date1','%d-%m-%Y') AND STR_TO_DATE('$date2','%d-%m-%Y')) as holidays, 
																							(select COUNT(DATE_ADD(STR_TO_DATE('$date1','%d-%m-%Y'), INTERVAL ROW DAY))
																		  			 FROM
																						(SELECT @row := @row + 1 as row FROM 	(select 0 union all select 1 union all select 3 	union all select 4 union all select 5 union all select 6) t1,
																								(select 0 union all select 1 union all select 3 union all select 4 union all select 5 union all select 6) t2,
																								(SELECT @row:=-1) t3 limit 31
																							) b
																						WHERE		DATE_ADD(STR_TO_DATE('$date1','%d-%m-%Y'), INTERVAL ROW DAY)
																						BETWEEN STR_TO_DATE('$date1','%d-%m-%Y') and STR_TO_DATE('$date2','%d-%m-%Y') AND DAYOFWEEK(DATE_ADD(STR_TO_DATE('$date1','%d-%m-%Y'), INTERVAL ROW DAY))=1) as sundays
																							FROM leave_history
																							WHERE ((STR_TO_DATE(DATE_FORMAT(From_Date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$date1','%d-%m-%Y') AND STR_TO_DATE('$date2','%d-%m-%Y')) OR (STR_TO_DATE(DATE_FORMAT(To_Date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$date1','%d-%m-%Y') AND STR_TO_DATE('$date2','%d-%m-%Y')))
																							AND Emp_Number='$Emp_Number') a  ")->result_array();
			
	}



	function getFilePath($leaveID){
		return $this->db->query("SELECT filename 	FROM files
																			WHERE leave_id = '$leaveID' Limit 1")->result_array();
			
	}


	function get_reminder_limit(){
		return $this->db->query("SELECT reminder_limit FROM parameters limit 1")->result_array();
	}


		
}


?>