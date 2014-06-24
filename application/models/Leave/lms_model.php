<?php
Class lms_model extends CI_Model{
	function _construct()
	{
		parent::_construct();
	}
	function get_parameters()
	{
		return $this->db->query("SELECT *, HOUR(comp_off_reduct) as hour, MINUTE(comp_off_reduct) as min,ROUND(TIME_TO_SEC(comp_off_reduct)/60) as comp_minutes FROM parameters ")->result_array();

	}

	function get_years(){
		return $this->db->query("SELECT  DISTINCT YEAR(FromDate) AS 'year' FROM leavehistory ORDER BY year ")->result_array();
	}

	
	function get_team()
	{
		return $this->db->query("SELECT a.EmployeeName AS EmployeeName FROM team a  WHERE a.Designation IN ('TeamLeader') ORDER BY a.EmployeeName")->result_array();
	}

	function get_leave_members(){
		return $this->db->query("SELECT DISTINCT name AS 'Name' FROM  admin_users WHERE user_role NOT IN ('MD') ORDER BY name")->result_array();
	}

	function get_team_members()
	{
		$uname=$this->session->userdata('fullname');

		return $this->db->query("SELECT EmployeeName AS 'Name'  FROM team  WHERE LeaveApprover_L1='$uname' ORDER BY EmployeeName ")->result_array();
	}

	function checkLeaveAvailability($leave_type)
	{
		$uname=$this->session->userdata('fullname');
		$availability =$this->db->query("SELECT SUM(TotalDays) FROM leavehistory WHERE User='$uname' AND LeaveType='$leave_type' ");
		return $availability->result();
	}


	function insert_application_data($leave_type,$d1,$d2,$days,$officer,$reason,$hrs)
	{

		$add_date=date('Y-m-d H:i:s');

		$uname=$this->session->userdata('fullname');
		$availability =$this->db->query("INSERT INTO leavehistory(User,LeaveType,FromDate,ToDate,TotalDays,LeaveStatus,Reason,AppliedTime) VALUES('$uname','$leave_type',STR_TO_DATE(STR_TO_DATE('$d1','%d-%m-%Y'),'%Y-%m-%d'),STR_TO_DATE(STR_TO_DATE('$d2','%d-%m-%Y'),'%Y-%m-%d'),'$days',1,\"$reason\",'$add_date');");
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

		$availability =$this->db->query("INSERT INTO leavehistory(User,LeaveType,FromDate,ToDate,TotalDays,LeaveStatus,Reason,AppliedTime) VALUES('$uname','$leave_type','$d1','$d2','$days',1,\"$reason\",'$add_date');");
		if($leave_type=='Sick Leave'){
			return $this->db->insert_id();
		}
		if($leave_type=='Comp-Off'){
			$this->db->query("UPDATE team SET Comp_off=ADDTIME(Comp_off,'$hrs') WHERE EmployeeName='$uname'");
		}
			
	}


	function get_leave_status($d1,$d2,$type)
	{
		$uname=$this->session->userdata('fullname');
			
		if($d1!='' && $d2!=''){
			if($type != 'AllTypes' && $type!='1' && $type!='3'){
				return $this->db->query("SELECT a.*, b.Description FROM leavehistory a JOIN leave_status b ON  a.LeaveStatus = b.Status
																			WHERE User='$uname' AND STR_TO_DATE(DATE_FORMAT(a.FromDate,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y')
								 											AND (LeaveType='$type' OR a.LeaveStatus IN ('$type') ) ")->result_array();
			}
				
			else if ($type=='1'){
				return $this->db->query("SELECT a.*, b.Description FROM leavehistory a JOIN leave_status b ON  a.LeaveStatus = b.Status WHERE User='$uname'  AND
							 STR_TO_DATE(DATE_FORMAT(a.FromDate,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y') AND a.LeaveStatus IN ('1') ")->result_array();
			}
			else if ($type=='3'){
				return $this->db->query("SELECT a.*, b.Description FROM leavehistory a JOIN leave_status b ON  a.LeaveStatus = b.Status WHERE User='$uname'  AND
							 STR_TO_DATE(DATE_FORMAT(a.FromDate,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y') AND a.LeaveStatus IN ('3','5') ")->result_array();
			}
			else{
				return $this->db->query("SELECT a.*, b.Description FROM leavehistory a JOIN leave_status b ON  a.LeaveStatus = b.Status WHERE User='$uname'  AND
							 STR_TO_DATE(DATE_FORMAT(a.FromDate,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y') AND LeaveStatus IN (2,4) ")->result_array();
			}

		}
		else{
			if($type != 'AllTypes' && $type!='1'){
				return $this->db->query("SELECT a.*, b.Description FROM leavehistory a JOIN leave_status b ON  a.LeaveStatus = b.Status
								WHERE User='$uname'   AND (a.LeaveType='$type' OR a.LeaveStatus IN ('$type') ) ORDER BY  a.LeaveStatus Desc ")->result_array();
			}
			else if ($type=='1') {
				return $this->db->query("SELECT a.*, b.Description FROM leavehistory a JOIN leave_status b ON  a.LeaveStatus = b.Status WHERE User='$uname' AND LeaveStatus IN ('1') ")->result_array();
			}
			else {
				return $this->db->query("SELECT a.*, b.Description FROM leavehistory a JOIN leave_status b ON  a.LeaveStatus = b.Status WHERE User='$uname' AND LeaveStatus IN (2,4) ")->result_array();
			}
		}
			
	}


	function get_pending_applicatoins()
	{
		$uname=$this->session->userdata('fullname');
		$urole=$this->session->userdata('userrole');
		if($urole=='MD'){
			$availability =$this->db->query("SELECT a.*, b.*, c.* FROM leavehistory a JOIN leave_status b ON  a.LeaveStatus = b.Status JOIN team c ON c.EmployeeName = a.User WHERE b.Status IN (1) AND c.Designation NOT IN ('Trainee')  ORDER BY a.LeaveID");
			return $availability->result_array();
		}
		else{
			$availability =$this->db->query("SELECT a.*, b.*, c.* FROM leavehistory a JOIN leave_status b ON  a.LeaveStatus = b.Status JOIN team c ON c.EmployeeName = a.User WHERE b.Status=1 AND User!='$uname'
			 AND c.Department=(SELECT Department FROM team WHERE EmployeeName='$uname') AND c.Designation NOT IN ('TeamLeader','MD') ORDER BY a.LeaveID");
			return $availability->result_array();
		}
	}

	function get_pending_applicatoins_lev1()
	{

		$availability =$this->db->query("SELECT a.*, b.*, c.* FROM leavehistory a JOIN leave_status b ON  a.LeaveStatus = b.Status JOIN team c ON c.EmployeeName = a.User WHERE b.Status IN (1,2,3) AND c.Designation  IN ('Trainee')   ORDER BY a.LeaveID");
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
			return $this->db->query("UPDATE leavehistory SET LeaveStatus=4, ApprovedBy=IFNULL (CONCAT(ApprovedBy,', ','$uname'),'$uname' ),
		 ActionTime=IFNULL (CONCAT(ActionTime,'; ','$add_date'),'$add_date'), Remarks=IFNULL (CONCAT(Remarks,'; ','$reason'),'$reason')  WHERE LeaveID='$lid'");
		}

		if($uroll=='teamleader'){
			return $this->db->query("UPDATE leavehistory SET LeaveStatus=2, ApprovedBy=IFNULL (CONCAT(ApprovedBy,', ','$uname'),'$uname' ),
		ActionTime=IFNULL (CONCAT(ActionTime,'; ','$add_date'),'$add_date'), Remarks=IFNULL (CONCAT(Remarks,'; ','$reason'),'$reason')  WHERE LeaveID='$lid'");
		}
	}


	function reject($lid,$reason,$type,$user,$hrs)
	{
		$uname=$this->session->userdata('fullname');
		$urole=$this->session->userdata('userrole');
		$add_date=date('Y-m-d H:i:s');
		if($urole=='MD'){
			$this->db->query("UPDATE leavehistory SET LeaveStatus=5, ApprovedBy=IFNULL (CONCAT(ApprovedBy,', ','$uname'),'$uname' ),
		ActionTime=IFNULL (CONCAT(ActionTime,'; ','$add_date'),'$add_date'), Remarks=IFNULL (CONCAT(Remarks,'; ','$reason'),'$reason')  WHERE LeaveID='$lid'");
		}
		if($urole=='teamleader'){
		 $this->db->query("UPDATE leavehistory SET LeaveStatus=3, ApprovedBy=IFNULL (CONCAT(ApprovedBy,', ','$uname'),'$uname' ),
		ActionTime=IFNULL (CONCAT(ActionTime,'; ','$add_date'),'$add_date'), Remarks=IFNULL (CONCAT(Remarks,'; ','$reason'),'$reason')  WHERE LeaveID='$lid'");
		}
		if($type =='Comp-Off'){
		 $this->db->query("UPDATE team SET Comp_off=SUBTIME(Comp_off,'$hrs') WHERE  EmployeeName='$user'");
		}

	}

	function get_history_admin($d1,$d2,$filter,$string,$team,$type)
	{
		$uname=$this->session->userdata('fullname');

		if($d1!="" && $d2!=""){
			if($type!=4){
				return $this->db->query("SELECT a.*, b.*, c.* FROM leavehistory a JOIN leave_status b ON  a.LeaveStatus = b.Status JOIN team c ON c.EmployeeName = a.User
															WHERE 	STR_TO_DATE(DATE_FORMAT(a.FromDate,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y')
															AND a.LeaveStatus IN ('2','4') 
															AND (  c.Department='$filter' OR  c.EmployeeName='$string' OR c.LeaveApprover_L1='$team' OR c.EmployeeName='$team')
															 ORDER BY a.AppliedTime Desc  ")->result_array();
			}
			else{
				return $this->db->query("SELECT a.*, b.*, c.* FROM leavehistory a JOIN leave_status b ON  a.LeaveStatus = b.Status JOIN team c ON c.EmployeeName = a.User
															WHERE 	STR_TO_DATE(DATE_FORMAT(a.FromDate,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y') AND a.LeaveStatus IN ('2','4') 
															 ORDER BY a.AppliedTime Desc  ")->result_array();
			}
		}
		else {
			if($type!=4){
				return $this->db->query("SELECT a.*, b.*, c.* FROM leavehistory a JOIN leave_status b ON  a.LeaveStatus = b.Status JOIN team c ON c.EmployeeName = a.User
																	WHERE 	 a.LeaveStatus IN ('2','4')  	AND (  c.Department='$filter' OR  c.EmployeeName='$string' OR c.LeaveApprover_L1='$team' OR c.EmployeeName='$team')
																   ORDER BY a.AppliedTime Desc  ")->result_array();
			}
			else{

				return $this->db->query("SELECT a.*, b.*, c.* FROM leavehistory a JOIN leave_status b ON  a.LeaveStatus = b.Status JOIN team c ON c.EmployeeName = a.User
															WHERE 	 a.LeaveStatus IN ('2','4')   ORDER BY a.AppliedTime Desc  ")->result_array();
			}
		}
			
	}

	function get_history_teamleader($d1,$d2,$string)
	{
		$uname=$this->session->userdata('fullname');
		if($d1!=''&&$d2!=''){
			if( $string=='null'){
				return $this->db->query("SELECT a . *, b . *, c . * FROM leavehistory a JOIN leave_status b ON a.LeaveStatus = b.Status JOIN team c ON c.EmployeeName = a.User
																							WHERE 	STR_TO_DATE(DATE_FORMAT(a.FromDate,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y')
																							 AND  a.User NOT IN  ('$uname')  AND a.LeaveStatus IN ('2','4')  AND c.Department=(SELECT Department from team where EmployeeName='$uname')
																						ORDER BY a.AppliedTime Desc")->result_array();
			}
			else{
				return $this->db->query("	SELECT a . *, b . *, c . * FROM leavehistory a JOIN leave_status b ON a.LeaveStatus = b.Status JOIN team c ON c.EmployeeName = a.User
															WHERE 	STR_TO_DATE(DATE_FORMAT(a.FromDate,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y') AND a.User NOT IN  ('$uname') AND  (a.User='$string' OR a.LeaveStatus IN ('$string') OR a.LeaveType='$string')
															AND c.Department=(SELECT Department from team where EmployeeName='$uname')
					                                		ORDER BY a.AppliedTime Desc ")->result_array();
			}
		}
		else{
			if( $string=='null'){
				return $this->db->query("SELECT a . *, b . *, c . * FROM leavehistory a JOIN leave_status b ON a.LeaveStatus = b.Status JOIN team c ON c.EmployeeName = a.User
																			WHERE a.User NOT IN  ('$uname')  AND a.LeaveStatus IN ('2','4')  AND c.Department=(SELECT Department from team where EmployeeName='$uname')
																			ORDER BY a.AppliedTime Desc")->result_array();
			}
			else{
				return $this->db->query("	SELECT a . *, b . *, c . * FROM leavehistory a JOIN leave_status b ON a.LeaveStatus = b.Status JOIN team c ON c.EmployeeName = a.User
												WHERE a.User NOT IN  ('$uname')  AND  (a.User='$string' OR a.LeaveStatus IN ('$string') OR a.LeaveType='$string')
												AND c.Department=(SELECT Department from team where EmployeeName='$uname') AND LeaveStatus IN (2,4)
		                                		ORDER BY a.AppliedTime Desc ")->result_array();
			}
		}
	}


	function check_leave($d,$type)
	{
		$uname=$this->session->userdata('fullname');
		return $this->db->query("SELECT IFNULL(SUM(TotalDays),0) AS Leaves FROM leavehistory  WHERE User='$uname' AND DATE_FORMAT(FromDate,'%d-%m-%Y')='$d' AND LeaveType='$type'
							AND LeaveStatus IN (1,2,4)")->result_array();
	}

	function check_leavetaken($d)
	{
		$uname=$this->session->userdata('fullname');
		return $this->db->query("SELECT COUNT(User) AS avail FROM leavehistory  WHERE User='$uname' AND  '$d' BETWEEN DATE_FORMAT(FromDate,'%d-%m-%Y') AND DATE_FORMAT(ToDate,'%d-%m-%Y')  AND LeaveStatus IN (1,2,4)")->result_array();
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
		$user=$this->session->userdata('fullname');
		return $this->db->query("SELECT SUM(TotalDays) AS day FROM leavehistory
																		WHERE MONTH(STR_TO_DATE(STR_TO_DATE('$d','%d-%m-%Y'),'%Y-%m-%d'))=MONTH(FromDate) AND YEAR(STR_TO_DATE(STR_TO_DATE('$d','%d-%m-%Y'),'%Y-%m-%d'))=YEAR(FromDate)
																		AND User='$user' AND LeaveType='Casual Leave'")->result_array();
	}

	function validate_permission($d)
	{
		$user=$this->session->userdata('fullname');
		return $this->db->query("SELECT COUNT(p_date) AS status FROM permissions
																		WHERE MONTH(STR_TO_DATE(STR_TO_DATE('$d','%d-%m-%Y'),'%Y-%m-%d'))=MONTH(p_date) AND YEAR(STR_TO_DATE(STR_TO_DATE('$d','%d-%m-%Y'),'%Y-%m-%d'))=YEAR(p_date)
																		AND User='$user' AND ( status='Approved' OR status='Applied' ) ")->result_array();
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
		return $this->db->query("SELECT SUM(TotalDays) AS TotalDays, LeaveType FROM leavehistory  WHERE LeaveStatus IN (2,4) AND User='$uname' AND YEAR(FromDate)='$y'  AND MONTH(FromDate)='$m'
							GROUP BY LeaveType ")->result_array();
	}

	function get_leave_summary_year()
	{
		$d1=date('Y');
		$uname=$this->session->userdata('fullname');
		return $this->db->query("SELECT SUM(TotalDays) AS TotalDays, LeaveType FROM leavehistory  WHERE LeaveStatus IN (2,4) AND User='$uname' AND YEAR(FromDate)='$d1'
							 GROUP BY LeaveType ")->result_array();
	}

	function get_leave_summary_pend()
	{
		//	$d1=date('Y');
		$uname=$this->session->userdata('fullname');
		return $this->db->query("SELECT SUM(TotalDays) AS TotalDays, LeaveType FROM leavehistory  WHERE LeaveStatus IN (1) AND User='$uname'   GROUP BY LeaveType ")->result_array();
	}

	function carry_forward_on(){
		$uname=$this->session->userdata('fullname');
		return $this->db->query("SELECT IF(count>0,12-MONTH(CURDATE()),11-MONTH(CURDATE())) as casual_remain
																				FROM
																				(SELECT COUNT(FromDate) as count FROM leavehistory WHERE LeaveType='Casual Leave' AND LeaveStatus IN (1,2,4) AND User='Gnanajeyam G' AND MONTH(CURDATE())=MONTH(FromDate) AND YEAR(CURDATE())=YEAR(FromDate)) a")->result_array();
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
		$user=$this->session->userdata('fullname');
			
		return $this->db->query("SELECT DISTINCT (SELECT email FROM admin_users WHERE name='$user') AS FromMail ,
					(SELECT email FROM admin_users WHERE name=(SELECT LeaveApprover_L1 FROM team WHERE EmployeeName='$user' ) ) AS ToMail1,
					 (SELECT email 	FROM admin_users WHERE user_email='MD' limit 1 ) AS ToMail2,'$user' as Name,
					filename,file_count
					 FROM  (
					 SELECT IF(filename!='',filename,'NO') as filename, COUNT(filename) as file_count FROM files	WHERE leave_id = (SELECT LeaveID FROM leavehistory WHERE User='$user' AND LeaveType='Sick Leave' AND DATE_FORMAT(FromDate,'%d-%m-%Y')='$date_from') limit 1) a")->result_array();
			

	}
		
	function approve_mail($lid){
		$app=$this->session->userdata('fullname');
		return $this->db->query("SELECT User,LeaveType AS Type,FromDate As Date,TotalDays As Days,AppliedTime AS Time,leave_status.Description As Status,
																	admin_users.email AS Email,(SELECT email FROM admin_users WHERE name='$app' ) AS FromMail
																	FROM leavehistory 
																	INNER JOIN leave_status ON leave_status.status=leavehistory.LeaveStatus 
																	INNER JOIN admin_users ON admin_users.name=leavehistory.User
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
					(SELECT Comp_off FROM team WHERE EmployeeName='$uname') AS used
					FROM time_sheet WHERE ts_name='$uname') a ")->result_array();
			
	}


	function get_approved_leaves($year,$month,$emp){
		if($emp!='All Employees'){
			return $this->db->query("SELECT a.*, b.*, c.* FROM leavehistory a JOIN leave_status b ON  a.LeaveStatus = b.Status JOIN team c ON c.EmployeeName = a.User
															WHERE 	YEAR(a.FromDate)='$year' AND  MONTH(a.FromDate)='$month'  AND a.LeaveStatus IN ('2','4') AND a.User='$emp' 
															 ORDER BY a.AppliedTime Desc ")->result_array();
		}
		if($emp=='All Employees'){
			return $this->db->query("SELECT a.*, b.*, c.* FROM leavehistory a JOIN leave_status b ON  a.LeaveStatus = b.Status JOIN team c ON c.EmployeeName = a.User
															WHERE 	YEAR(a.FromDate)='$year' AND  MONTH(a.FromDate)='$month'  AND a.LeaveStatus IN ('2','4') 
															 ORDER BY a.AppliedTime Desc ")->result_array();
		}
	}

		function process_leave($id){			
					$this->db->query("UPDATE leavehistory SET LeaveStatus='5' WHERE LeaveID='$id'");
		}
	

	function remove_leave($id){
		$this->db->query("DELETE FROM  leavehistory WHERE LeaveID='$id' ");

	}

	function insert_permission_data($d,$time,$total,$reason){
		$user=$this->session->userdata('fullname');
		$this->db->query("INSERT INTO permissions(p_date,user,timefrom,totalhrs,reason)  VALUES(STR_TO_DATE(STR_TO_DATE('$d','%d-%m-%Y'),'%Y-%m-%d'),'$user','$time','$total',\"$reason\") ");

	}


	function get_permission($d){
		$user=$this->session->userdata('fullname');
		$this->db->query("SELECT COUNT(p_date) as permission FROM permissions WHERE  user='$user' AND month(STR_TO_DATE(DATE_FORMAT(p_date,'%d-%m-%Y'),'%d-%m-%Y'))=month('$d') ")->result_array();

	}
	function get_allpermissions($y,$d){
		$user=$this->session->userdata('fullname');
		return $this->db->query("SELECT DISTINCT (SELECT COUNT(p_date) as permission FROM permissions WHERE user='$user' AND MONTH(p_date) ='05' AND YEAR(p_date) ='2014' AND status='Approved') as month,
																							(SELECT COUNT(p_date) as permission FROM permissions WHERE user='$user' AND YEAR(p_date) ='2014' AND status='Approved') as year,
																							(SELECT COUNT(p_date) as permission FROM permissions WHERE user='$user' AND YEAR(p_date) ='2014' AND status='Applied') as pending
																							FROM permissions ")->result_array();

	}


	function check_permission_data($d){
		$user=$this->session->userdata('fullname');
		$data=$this->db->query("SELECT COUNT(p_date) as 'count' FROM permissions WHERE  user='$user' AND MONTH(p_date)=SUBSTRING('$d',4,2)  AND YEAR(p_date)=SUBSTRING('$d',7,10)  AND status!='Applied' ")->result_array();
		foreach($data as $name){
			$count1=$name["count"];
		}
		return $count1;

	}

	function get_pending_permissions(){
		$availability =$this->db->query("SELECT *  FROM permissions  WHERE status='Applied' ORDER BY permission_id");
		return $availability->result_array();

			
	}


	function get_mailID($user){
		return $this->db->query("SELECT (SELECT email FROM admin_users WHERE user_email='MD') as md,
																							(SELECT email FROM admin_users WHERE name='$user') as user
																			FROM admin_users limit 1")->result_array();
			
			
			
	}


	function process_permission($id,$str){
		$this->db->query("UPDATE permissions SET status='$str' WHERE permission_id='$id' ");

	}

	function getLeave4Date($d1,$d2,$id){
		return $this->db->query("SELECT User,TotalDays, Reason,LeaveStatus FROM leavehistory  WHERE  DATE_FORMAT(FromDate,'%d-%m-%Y')='$d1' AND LeaveID NOT IN ('$id') AND LeaveStatus IN ('2','4')")->result();
	}

	function getRecentLeave($user,$id){
		return $this->db->query("SELECT CONCAT(CONCAT(DATE_FORMAT(FromDate,'%d-%m-%Y'),' : ',TotalDays),' ', 'Day(s)') as date FROM leavehistory  WHERE User='$user' AND LeaveStatus IN ('2','4') AND LeaveID NOT IN ('$id') ORDER BY LeaveID DESC Limit 1  ")->result_array();
	}

	function SendReminder($id){
		$user=$this->session->userdata('fullname');
		$this->db->query("UPDATE leavehistory SET ReminderCount=ReminderCount+1 WHERE LeaveID='$id'");
		return $this->db->query("SELECT email FROM admin_users WHERE name=(SELECT LeaveApprover_L1 FROM team  WHERE EmployeeName='$user' ) ")->result_array();
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
		$user=$this->session->userdata('fullname');
		return $this->db->query("SELECT (leaves+holidays+sundays) as total, leaves,holidays,sundays
																					FROM (SELECT COUNT(FromDate) as leaves,
																							(SELECT COUNT(holi_date)  FROM holidays WHERE STR_TO_DATE(DATE_FORMAT(holi_date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$date1','%d-%m-%Y') AND STR_TO_DATE('$date2','%d-%m-%Y')) as holidays, 
																							(select COUNT(DATE_ADD(STR_TO_DATE('$date1','%d-%m-%Y'), INTERVAL ROW DAY))
																		  			 FROM
																						(SELECT @row := @row + 1 as row FROM 	(select 0 union all select 1 union all select 3 	union all select 4 union all select 5 union all select 6) t1,
																								(select 0 union all select 1 union all select 3 union all select 4 union all select 5 union all select 6) t2,
																								(SELECT @row:=-1) t3 limit 31
																							) b
																						WHERE		DATE_ADD(STR_TO_DATE('$date1','%d-%m-%Y'), INTERVAL ROW DAY)
																						BETWEEN STR_TO_DATE('$date1','%d-%m-%Y') and STR_TO_DATE('$date2','%d-%m-%Y') AND DAYOFWEEK(DATE_ADD(STR_TO_DATE('$date1','%d-%m-%Y'), INTERVAL ROW DAY))=1) as sundays
																							FROM leavehistory
																							WHERE ((STR_TO_DATE(DATE_FORMAT(FromDate,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$date1','%d-%m-%Y') AND STR_TO_DATE('$date2','%d-%m-%Y')) OR (STR_TO_DATE(DATE_FORMAT(ToDate,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$date1','%d-%m-%Y') AND STR_TO_DATE('$date2','%d-%m-%Y')))
																							AND User='$user') a  ")->result_array();
			
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