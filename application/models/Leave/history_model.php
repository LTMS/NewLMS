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
		return $this->db->query("SELECT  DISTINCT YEAR(From_Date) AS 'year' FROM leave_history ORDER BY year ")->result_array();
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
		$uname=$this->session->userdata('fullname');

		return $this->db->query("SELECT EmployeeName AS 'Name'  FROM team  WHERE LeaveApprover_L1='$uname' ORDER BY EmployeeName ")->result_array();
	}

	function checkLeaveAvailability($leave_type)
	{
		$uname=$this->session->userdata('fullname');
		$availability =$this->db->query("SELECT SUM(Total_Days) FROM leave_history WHERE Emp_Number='$uname' AND Leave_Type='$leave_type' ");
		return $availability->result();
	}


	function insert_application_data($leave_type,$d1,$d2,$days,$officer,$reason,$hrs)
	{

		$add_date=date('Y-m-d H:i:s');

		$uname=$this->session->userdata('fullname');
		$availability =$this->db->query("INSERT INTO leave_history(Emp_Number,Leave_Type,From_Date,To_Date,Total_Days,Leave_Status,Reason,AppliedTime) VALUES('$uname','$leave_type',STR_TO_DATE(STR_TO_DATE('$d1','%d-%m-%Y'),'%Y-%m-%d'),STR_TO_DATE(STR_TO_DATE('$d2','%d-%m-%Y'),'%Y-%m-%d'),'$days',1,\"$reason\",'$add_date');");
		if($leave_type=='Sick Leave'){
			return $this->db->insert_id();
		}
		if($leave_type=='Comp-Off'){
			$this->db->query("UPDATE team SET Comp_off=ADDTIME(Comp_off,'$hrs') WHERE EmployeeName='$uname'");
		}
	}



	function insert_other_application($uname,$leave_type,$d1,$d2,$days,$officer,$reason,$hrs)
	{
		$add_date=date('Y-m-d H:i:s');

		$availability =$this->db->query("INSERT INTO leave_history(Emp_Number,Leave_Type,From_Date,To_Date,Total_Days,Leave_Status,Reason,AppliedTime) VALUES('$uname','$leave_type','$d1','$d2','$days',1,\"$reason\",'$add_date');");
		if($leave_type=='Sick Leave'){
			return $this->db->insert_id();
		}
		if($leave_type=='Comp-Off'){
			$this->db->query("UPDATE team SET Comp_off=ADDTIME(Comp_off,'$hrs') WHERE EmployeeName='$uname'");
		}
			
	}




		function get_applied_applications()	{
					$availability =$this->db->query("SELECT a.*, b.* FROM leave_history a JOIN leave_status b ON  a.Leave_Status = b.Status WHERE b.Status IN (1)  ORDER BY a.From_Date");
					return $availability->result_array();
		}
		
		function get_reported_applications()	{
					$availability =$this->db->query("SELECT a.*, b.* FROM leave_history a JOIN leave_status b ON  a.Leave_Status = b.Status WHERE b.Status IN (2)   ORDER BY a.From_Date");
					return $availability->result_array();
		}
	


	function get_technicians()
	{
		return $this->db->query("SELECT * FROM technicians ")->result_array();
	}

	function get_technicians_details()
	{
		return $this->db->query("SELECT a.tech_id, a.tech_name as name, a.tech_dept as dept, a.tech_email as mail, a.tech_phone as phone,b.EmployeeID AS team_id, b.Designation as desig, b.JoiningDate as doj FROM technicians a JOIN team b ON b.EmployeeName = a.tech_name")->result();
	}

	function get_dept()
	{
		return $this->db->query("SELECT * FROM departments ")->result_array();
	}

	function add_dept($id)
	{
		$this->db->query("INSERT INTO departments(department) VALUES('$id')");
	}

	function remove_dept($id)
	{
		$this->db->query("DELETE FROM departments WHERE id='$id'");
	}




	function approve($lid,$reason)
	{
		$uname=$this->session->userdata('fullname');
		$uroll=$this->session->userdata('userrole');
		$add_date=date('Y-m-d H:i:s');
		if($uroll=='MD'){
			return $this->db->query("UPDATE leave_history SET Leave_Status=4, ApprovedBy=IFNULL (CONCAT(ApprovedBy,', ','$uname'),'$uname' ),
		 ActionTime=IFNULL (CONCAT(ActionTime,'; ','$add_date'),'$add_date'), Remarks=IFNULL (CONCAT(Remarks,'; ','$reason'),'$reason')  WHERE Leave_ID='$lid'");
		}

		if($uroll=='teamleader'){
			return $this->db->query("UPDATE leave_history SET Leave_Status=2, ApprovedBy=IFNULL (CONCAT(ApprovedBy,', ','$uname'),'$uname' ),
		ActionTime=IFNULL (CONCAT(ActionTime,'; ','$add_date'),'$add_date'), Remarks=IFNULL (CONCAT(Remarks,'; ','$reason'),'$reason')  WHERE Leave_ID='$lid'");
		}
	}


	function reject($lid,$reason,$type,$Emp_Number,$hrs)
	{
		$uname=$this->session->userdata('fullname');
		$urole=$this->session->userdata('userrole');
		$add_date=date('Y-m-d H:i:s');
		if($urole=='MD'){
			$this->db->query("UPDATE leave_history SET Leave_Status=5, ApprovedBy=IFNULL (CONCAT(ApprovedBy,', ','$uname'),'$uname' ),
		ActionTime=IFNULL (CONCAT(ActionTime,'; ','$add_date'),'$add_date'), Remarks=IFNULL (CONCAT(Remarks,'; ','$reason'),'$reason')  WHERE Leave_ID='$lid'");
		}
		if($urole=='teamleader'){
		 $this->db->query("UPDATE leave_history SET Leave_Status=3, ApprovedBy=IFNULL (CONCAT(ApprovedBy,', ','$uname'),'$uname' ),
		ActionTime=IFNULL (CONCAT(ActionTime,'; ','$add_date'),'$add_date'), Remarks=IFNULL (CONCAT(Remarks,'; ','$reason'),'$reason')  WHERE Leave_ID='$lid'");
		}
		if($type =='Comp-Off'){
		 $this->db->query("UPDATE team SET Comp_off=SUBTIME(Comp_off,'$hrs') WHERE  EmployeeName='$Emp_Number'");
		}

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
		$uname=$this->session->userdata('fullname');
		if($d1!=''&&$d2!=''){
			if( $string=='null'){
				return $this->db->query("SELECT a . *, b . *, c . * FROM leave_history a JOIN leave_status b ON a.Leave_Status = b.Status JOIN team c ON c.Employee_Number = a.Employee_Number
																							WHERE 	STR_TO_DATE(DATE_FORMAT(a.From_Date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y')
																							 AND  a.Employee_Number NOT IN  ('$uname')  AND a.Leave_Status IN ('2','4')  AND c.Department=(SELECT Department from team where EmployeeName='$uname')
																						ORDER BY a.AppliedTime Desc")->result_array();
			}
			else{
				return $this->db->query("	SELECT a . *, b . *, c . * FROM leave_history a JOIN leave_status b ON a.Leave_Status = b.Status JOIN team c ON c.Employee_Number = a.Employee_Number
															WHERE 	STR_TO_DATE(DATE_FORMAT(a.From_Date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y') AND a.Employee_Number NOT IN  ('$uname') AND  (a.Employee_Number='$string' OR a.Leave_Status IN ('$string') OR a.Leave_Type='$string')
															AND c.Department=(SELECT Department from team where EmployeeName='$uname')
					                                		ORDER BY a.AppliedTime Desc ")->result_array();
			}
		}
		else{
			if( $string=='null'){
				return $this->db->query("SELECT a . *, b . *, c . * FROM leave_history a JOIN leave_status b ON a.Leave_Status = b.Status JOIN team c ON c.Employee_Number = a.Employee_Number
																			WHERE a.Employee_Number NOT IN  ('$uname')  AND a.Leave_Status IN ('2','4')  AND c.Department=(SELECT Department from team where EmployeeName='$uname')
																			ORDER BY a.AppliedTime Desc")->result_array();
			}
			else{
				return $this->db->query("	SELECT a . *, b . *, c . * FROM leave_history a JOIN leave_status b ON a.Leave_Status = b.Status JOIN team c ON c.Employee_Number = a.Employee_Number
												WHERE a.Employee_Number NOT IN  ('$uname')  AND  (a.Employee_Number='$string' OR a.Leave_Status IN ('$string') OR a.Leave_Type='$string')
												AND c.Department=(SELECT Department from team where EmployeeName='$uname') AND Leave_Status IN (2,4)
		                                		ORDER BY a.AppliedTime Desc ")->result_array();
			}
		}
	}


	function check_leave($d,$type)
	{
		$uname=$this->session->userdata('fullname');
		return $this->db->query("SELECT IFNULL(SUM(Total_Days),0) AS Leaves FROM leave_history  WHERE Emp_Number='$uname' AND DATE_FORMAT(From_Date,'%d-%m-%Y')='$d' AND Leave_Type='$type'
							AND Leave_Status IN (1,2,4)")->result_array();
	}

	function check_leavetaken($d)
	{
		$uname=$this->session->userdata('fullname');
		return $this->db->query("SELECT COUNT(Emp_Number) AS avail FROM leave_history  WHERE Emp_Number='$uname' AND  '$d' BETWEEN DATE_FORMAT(From_Date,'%d-%m-%Y') AND DATE_FORMAT(To_Date,'%d-%m-%Y')  AND Leave_Status IN (1,2,4)")->result_array();
	}

	function check_holidays($d)
	{
		return $this->db->query("SELECT COUNT(holi_date) AS avail, holi_desc FROM holidays  WHERE DATE_FORMAT(holi_date,'%d-%m-%Y')='$d' ")->result_array();
	}

	function check_sunday($d)
	{
		return $this->db->query("SELECT if(DAYNAME(STR_TO_DATE(STR_TO_DATE('$d','%d-%m-%Y'),'%Y-%m-%d'))='Sunday',1,0) AS day FROM parameters limit 1")->result_array();
	}


	function validate_casual($d)
	{
		$Emp_Number=$this->session->userdata('fullname');
		return $this->db->query("SELECT SUM(Total_Days) AS day FROM leave_history
																		WHERE MONTH(STR_TO_DATE(STR_TO_DATE('$d','%d-%m-%Y'),'%Y-%m-%d'))=MONTH(From_Date) AND YEAR(STR_TO_DATE(STR_TO_DATE('$d','%d-%m-%Y'),'%Y-%m-%d'))=YEAR(From_Date)
																		AND Emp_Number='$Emp_Number' AND Leave_Type='Casual Leave'")->result_array();
	}

	function validate_permission($d)
	{
		$Emp_Number=$this->session->userdata('fullname');
		return $this->db->query("SELECT COUNT(P_Date) AS Status FROM permissions
																		WHERE MONTH(STR_TO_DATE(STR_TO_DATE('$d','%d-%m-%Y'),'%Y-%m-%d'))=MONTH(P_Date) AND YEAR(STR_TO_DATE(STR_TO_DATE('$d','%d-%m-%Y'),'%Y-%m-%d'))=YEAR(P_Date)
																		AND Emp_Number='$Emp_Number' AND ( Status='Approved' OR Status='Applied' ) ")->result_array();
	}

	function get_approval_officer()
	{
		$uname=$this->session->userdata('fullname');
		return $this->db->query("SELECT IFNULL(LeaveApprover_L1,'MD') as LeaveApprover_L1 FROM team  WHERE EmployeeName='$uname'  ")->result_array();
	}



	function get_leave_summary()
	{
		$y=date('Y');
		$m=date('m');
		$uname=$this->session->userdata('fullname');
		return $this->db->query("SELECT SUM(Total_Days) AS Total_Days, Leave_Type FROM leave_history  WHERE Leave_Status IN (2,4) AND Emp_Number='$uname' AND YEAR(From_Date)='$y'  AND MONTH(From_Date)='$m'
							GROUP BY Leave_Type ")->result_array();
	}

	function get_leave_summary_year()
	{
		$d1=date('Y');
		$uname=$this->session->userdata('fullname');
		return $this->db->query("SELECT SUM(Total_Days) AS Total_Days, Leave_Type FROM leave_history  WHERE Leave_Status IN (2,4) AND Emp_Number='$uname' AND YEAR(From_Date)='$d1'
							 GROUP BY Leave_Type ")->result_array();
	}

	function get_leave_summary_pend()
	{
		//	$d1=date('Y');
		$uname=$this->session->userdata('fullname');
		return $this->db->query("SELECT SUM(Total_Days) AS Total_Days, Leave_Type FROM leave_history  WHERE Leave_Status IN (1) AND Emp_Number='$uname'   GROUP BY Leave_Type ")->result_array();
	}

	function carry_forward_on(){
		$uname=$this->session->userdata('fullname');
		return $this->db->query("SELECT IF(count>0,12-MONTH(CURDATE()),11-MONTH(CURDATE())) as casual_remain
																				FROM
																				(SELECT COUNT(From_Date) as count FROM leave_history WHERE Leave_Type='Casual Leave' AND Leave_Status IN (1,2,4) AND Emp_Number='Gnanajeyam G' AND MONTH(CURDATE())=MONTH(From_Date) AND YEAR(CURDATE())=YEAR(From_Date)) a")->result_array();
	}

	function get_doj()
	{
		$uname=$this->session->userdata('fullname');
		return $this->db->query("SELECT DATE_FORMAT(JoiningDate,'%d-%m-%Y') as JoiningDate, TIMESTAMPDIFF(MONTH,JoiningDate,CURRENT_TIMESTAMP) as Experience FROM team  WHERE EmployeeName='$uname' ")->result_array();
	}


	function add_team_table($username,$dept,$desig,$doj,$l1,$l2)
	{

		$this->db->query("INSERT INTO team(EmployeeName,Department,Designation,LeaveApprover_L1,LeaveApprover_L2,JoiningDate)
						 VALUES('$username','$dept','$desig','$l1','$l2',STR_TO_DATE(STR_TO_DATE('$doj','%d-%m-%Y'),'%Y-%m-%d'));");

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
		$Emp_Number=$this->session->userdata('fullname');
			
		return $this->db->query("SELECT DISTINCT (SELECT email FROM admin_users WHERE name='$Emp_Number') AS FromMail ,
					(SELECT email FROM admin_users WHERE name=(SELECT LeaveApprover_L1 FROM team WHERE Emp_Number='$Emp_Number' ) ) AS ToMail1,
					 (SELECT email 	FROM admin_users WHERE user_email='MD' limit 1 ) AS ToMail2,'$Emp_Number' as Name,
					filename,file_count
					 FROM  (
					 SELECT IF(filename!='',filename,'NO') as filename, COUNT(filename) as file_count FROM files	WHERE leave_id = (SELECT Leave_ID FROM leave_history WHERE Emp_Number='$Emp_Number' AND Leave_Type='Sick Leave' AND DATE_FORMAT(From_Date,'%d-%m-%Y')='$date_from') limit 1) a")->result_array();
			

	}
		
	function approve_mail($lid){
		$app=$this->session->userdata('fullname');
		return $this->db->query("SELECT Emp_Number,Leave_Type AS Type,From_Date As Date,Total_Days As Days,AppliedTime AS Time,leave_status.Description As Status,
																	admin_users.email AS Email,(SELECT email FROM admin_users WHERE name='$app' ) AS FromMail
																	FROM leave_history 
																	INNER JOIN leave_status ON leave_status.Status=leave_history.Leave_Status 
																	INNER JOIN admin_users ON admin_users.name=leave_history.Emp_Number
																	WHERE leaveID='$lid'")->result_array();	

	}
		

		
		
	function remove_tech_info($team,$tech)
	{

		$this->db->query("DELETE FROM technicians WHERE tech_id='$tech' ");
		$this->db->query("DELETE FROM team WHERE EmployeeID='$team'");

	}
		
	function update_tech_info($tech,$team,$name,$dept,$desig,$phone,$mail,$doj,$option)
	{

		if($option=='ADD'){
			$this->db->query("INSERT INTO team (EmployeeName,Department,Designation,LeaveApprover_L1,LeaveApprover_L2,JoiningDate)
								 VALUES('$name','$dept','$desig','MD','MD',STR_TO_DATE(STR_TO_DATE('$doj','%d-%m-%Y'),'%Y-%m-%d'));");
				
			$this->db->query("INSERT INTO technicians(tech_name,tech_dept,tech_phone,tech_email)
								 VALUES('$name','$dept','$phone','$mail');");
		}
			
		if($option=='EDIT'){

			$this->db->query("UPDATE technicians SET tech_name='$name',tech_dept='$dept', tech_phone='$phone', tech_email='$mail' WHERE tech_id='$tech'");

			$this->db->query("UPDATE team SET EmployeeName='$name',Department='$dept',Designation='$desig',JoiningDate=STR_TO_DATE(STR_TO_DATE('$doj','%d-%m-%Y'),'%Y-%m-%d') WHERE EmployeeID='$team'");

		}
	}
		
		
		

	function get_OT_hrs(){
		$uname=$this->session->userdata('fullname');
			
		return $this->db->query("SELECT HOUR(used) as used,HOUR(ot) as ot,HOUR(IFNULL(sun,'00:00:00')) as sun, HOUR(ADDTIME(ot,IFNULL(sun,'00:00:00'))) as tot, HOUR(SUBTIME(ADDTIME(ot,IFNULL(sun,'00:00:00')),used)) as remain
					FROM ( SELECT
					(SELECT Sec_to_time(SUM(TIME_TO_SEC(ts_duty))) FROM time_sheet WHERE ts_name='$uname' AND (DAYNAME(ts_date)='Sunday' OR ts_date IN (SELECT holi_date FROM holidays)))  as sun, 
					(SELECT Sec_to_time(SUM(TIME_TO_SEC(ts_ot))) FROM time_sheet WHERE ts_name='$uname' AND (ts_date NOT IN (SELECT holi_date FROM holidays)) AND DAYNAME(ts_date)!='Sunday') as ot, 
					(SELECT Comp_off FROM team WHERE Emp_Number='$uname') AS used
					FROM time_sheet WHERE ts_name='$uname') a ")->result_array();
			
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

	function insert_permission_data($d,$time,$total,$reason){
		$Emp_Number=$this->session->userdata('fullname');
		$this->db->query("INSERT INTO permissions(P_Date,Emp_Number,timefrom,Total_Hrs,reason)  VALUES(STR_TO_DATE(STR_TO_DATE('$d','%d-%m-%Y'),'%Y-%m-%d'),'$Emp_Number','$time','$total',\"$reason\") ");

	}


	function get_permission($d){
		$Emp_Number=$this->session->userdata('fullname');
		$this->db->query("SELECT COUNT(P_Date) as permission FROM permissions WHERE  Emp_Number='$Emp_Number' AND month(STR_TO_DATE(DATE_FORMAT(P_Date,'%d-%m-%Y'),'%d-%m-%Y'))=month('$d') ")->result_array();

	}
	function get_allpermissions($y,$d){
		$Emp_Number=$this->session->userdata('fullname');
		return $this->db->query("SELECT DISTINCT (SELECT COUNT(P_Date) as permission FROM permissions WHERE Emp_Number='$Emp_Number' AND MONTH(P_Date) ='05' AND YEAR(P_Date) ='2014' AND Status='Approved') as month,
																							(SELECT COUNT(P_Date) as permission FROM permissions WHERE Emp_Number='$Emp_Number' AND YEAR(P_Date) ='2014' AND Status='Approved') as year,
																							(SELECT COUNT(P_Date) as permission FROM permissions WHERE Emp_Number='$Emp_Number' AND YEAR(P_Date) ='2014' AND Status='Applied') as pending
																							FROM permissions ")->result_array();

	}


	function check_permission_data($d){
		$Emp_Number=$this->session->userdata('fullname');
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


	function get_mailID($Emp_Number){
		return $this->db->query("SELECT (SELECT email FROM admin_users WHERE user_email='MD') as md,
																							(SELECT email FROM admin_users WHERE name='$Emp_Number') as Emp_Number
																			FROM admin_users limit 1")->result_array();
			
			
			
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
		$Emp_Number=$this->session->userdata('fullname');
		$this->db->query("UPDATE leave_history SET ReminderCount=ReminderCount+1 WHERE Leave_ID='$id'");
		return $this->db->query("SELECT email FROM admin_users WHERE name=(SELECT LeaveApprover_L1 FROM team  WHERE EmployeeName='$Emp_Number' ) ")->result_array();
	}


	function add_employee_details($name){
		$this->db->query("INSERT INTO employee_details(EmployeeName) VALUES('$name')  ");

	}

	function update_leave_param($cm,$ct,$st,$sp,$pt,$pm,$pe,$comp,$permis,$carry,$pp){
		$uname=$this->session->userdata('fullname');
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
		$Emp_Number=$this->session->userdata('fullname');
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