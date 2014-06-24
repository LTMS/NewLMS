<?php
Class Apply_model extends CI_Model{
	function _construct(){
		parent::_construct();
	}
		
		
		
		
	function get_parameters(){
		return $this->db->query("SELECT *, HOUR(comp_off_reduct) as hour, MINUTE(comp_off_reduct) as min,ROUND(TIME_TO_SEC(comp_off_reduct)/60) as comp_minutes FROM parameters ")->result_array();
	}

	function carry_forward_on(){
		$emp_num=$this->session->userdata('Emp_Num');
		return $this->db->query("SELECT IF(count>0,12-MONTH(CURDATE()),11-MONTH(CURDATE())) as casual_remain
																				FROM	(SELECT COUNT(From_Date) as count FROM leave_history WHERE Leave_Type='Casual Leave' AND Leave_Status IN (1,2,4) AND Emp_Number='Gnanajeyam G' AND MONTH(CURDATE())=MONTH(From_Date) AND YEAR(CURDATE())=YEAR(From_Date)) a")->result_array();
	}
		

	function checkLeaveAvailability($leave_type){
		$emp_num=$this->session->userdata('Emp_Num');
		return $this->db->query("SELECT SUM(Total_Days) FROM leave_history WHERE Emp_Number='$emp_num' AND Leave_Type='$leave_type' ")->result();
	}
		
	function get_leave_summary(){
		$y=date('Y');
		$m=date('m');
		$emp_num=$this->session->userdata('Emp_Num');
		return $this->db->query("SELECT SUM(Total_Days) AS Total_Days, Leave_Type FROM leave_history  WHERE Leave_Status IN (2,4) AND Emp_Number='$emp_num' AND YEAR(From_Date)='$y'  AND MONTH(From_Date)='$m'
							GROUP BY Leave_Type ")->result_array();
	}

	function get_leave_summary_year(){
		$d1=date('Y');
		$emp_num=$this->session->userdata('Emp_Num');
		return $this->db->query("SELECT SUM(Total_Days) AS Total_Days, Leave_Type FROM leave_history  WHERE Leave_Status IN (2,4) AND Emp_Number='$emp_num' AND YEAR(From_Date)='$d1'
							 GROUP BY Leave_Type ")->result_array();
	}

	function get_leave_summary_pend(){
		//	$d1=date('Y');
		$emp_num=$this->session->userdata('Emp_Num');
		return $this->db->query("SELECT SUM(Total_Days) AS Total_Days, Leave_Type FROM leave_history  WHERE Leave_Status IN (1) AND Emp_Number='$emp_num'   GROUP BY Leave_Type ")->result_array();
	}
		

	function check_leave($d,$type){
		$emp_num=$this->session->userdata('Emp_Num');
		return $this->db->query("SELECT IFNULL(SUM(Total_Days),0) AS Leaves FROM leave_history  WHERE Emp_Number='$emp_num' AND DATE_FORMAT(From_Date,'%d-%m-%Y')='$d' AND Leave_Type='$type'
							AND Leave_Status IN (1,2,4)")->result_array();
	}

	function check_leavetaken($d)	{
		$emp_num=$this->session->userdata('Emp_Num');
		return $this->db->query("SELECT COUNT(Emp_Number) AS avail FROM leave_history  WHERE Emp_Number='$emp_num' AND  '$d' BETWEEN DATE_FORMAT(From_Date,'%d-%m-%Y') AND DATE_FORMAT(To_Date,'%d-%m-%Y')  AND Leave_Status IN (1,2,4)")->result_array();
	}

	function check_holidays($d){
		return $this->db->query("SELECT COUNT(holi_date) AS avail, holi_desc FROM holidays  WHERE DATE_FORMAT(holi_date,'%d-%m-%Y')='$d' ")->result_array();
	}

	function check_sunday($d){
		return $this->db->query("SELECT if(DAYNAME(STR_TO_DATE(STR_TO_DATE('$d','%d-%m-%Y'),'%Y-%m-%d'))='Sunday',1,0) AS day FROM parameters limit 1")->result_array();
	}


	function validate_casual($d){
		$emp_num=$this->session->userdata('Emp_Num');
		return $this->db->query("SELECT SUM(Total_Days) AS day FROM leave_history
																		WHERE MONTH(STR_TO_DATE(STR_TO_DATE('$d','%d-%m-%Y'),'%Y-%m-%d'))=MONTH(From_Date) AND YEAR(STR_TO_DATE(STR_TO_DATE('$d','%d-%m-%Y'),'%Y-%m-%d'))=YEAR(From_Date)
																		AND Emp_Number='$emp_num' AND Leave_Type='Casual Leave'")->result_array();
	}

	function validate_permission($d)	{
		$emp_num=$this->session->userdata('Emp_Num');
		return $this->db->query("SELECT COUNT(p_date) AS status FROM permissions
																		WHERE MONTH(STR_TO_DATE(STR_TO_DATE('$d','%d-%m-%Y'),'%Y-%m-%d'))=MONTH(p_date) AND YEAR(STR_TO_DATE(STR_TO_DATE('$d','%d-%m-%Y'),'%Y-%m-%d'))=YEAR(p_date)
																		AND Emp_Number='$emp_num' AND ( status='Approved' OR status='Applied' ) ")->result_array();
	}

	function get_approval_officer(){
		$emp_num=$this->session->userdata('Emp_Num');
		return $this->db->query("SELECT IFNULL(LeaveApprover_L1,'MD') as LeaveApprover_L1 FROM team  WHERE EmployeeName='$emp_num'  ")->result_array();
	}


	function insert_application_data($leave_type,$d1,$d2,$days,$reporter,$reason,$hrs){

		$add_date=date('Y-m-d H:i:s');

		$emp_num=$this->session->userdata('Emp_Num');
		$availability =$this->db->query("INSERT INTO leave_history(Emp_Number,Leave_Type,From_Date,To_Date,Total_Days,Leave_Status,Reason,Applied_On) VALUES('$emp_num','$leave_type',STR_TO_DATE(STR_TO_DATE('$d1','%d-%m-%Y'),'%Y-%m-%d'),STR_TO_DATE(STR_TO_DATE('$d2','%d-%m-%Y'),'%Y-%m-%d'),'$days',1,\"$reason\",'$add_date');");
		if($leave_type=='Sick Leave'){
			return $this->db->insert_id();
		}
		if($leave_type=='Comp-Off'){
			$this->db->query("UPDATE team SET Comp_off=ADDTIME(Comp_off,'$hrs') WHERE EmployeeName='$emp_num'");
		}
	}


	function insert_file($file_name,$id){
		$date=date('Y-m-d H:i:s');
		return $this->db->query("INSERT INTO files(filename,leave_id,date) values('$file_name','$id','$date')");
	}
		


	function getMailData($date_from,$reasoning,$day,$l_type,$Offr){
		$emp_num=$this->session->userdata('Emp_Num');
			
		return $this->db->query("SELECT DISTINCT (SELECT email FROM admin_users WHERE name='$emp_num') AS FromMail ,
					(SELECT email FROM admin_users WHERE name=(SELECT LeaveApprover_L1 FROM team WHERE EmployeeName='$emp_num' ) ) AS ToMail1,
					 (SELECT email 	FROM admin_users WHERE user_email='MD' limit 1 ) AS ToMail2,'$emp_num' as Name,
					filename,file_count
					 FROM  (
					 SELECT IF(filename!='',filename,'NO') as filename, COUNT(filename) as file_count FROM files	WHERE leave_id = (SELECT LeaveID FROM leave_history WHERE Emp_Number='$emp_num' AND Leave_Type='Sick Leave' AND DATE_FORMAT(From_Date,'%d-%m-%Y')='$date_from') limit 1) a")->result_array();
			

	}
		
	function approve_mail($lid){
		$app=$this->session->userdata('Emp_Num');
		return $this->db->query("SELECT Emp_Number,Leave_Type AS Type,From_Date As Date,Total_Days As Days,Applied_On AS Time,leave_status.Description As Status,
																	admin_users.email AS Email,(SELECT email FROM admin_users WHERE name='$app' ) AS FromMail
																	FROM leave_history 
																	INNER JOIN leave_status ON leave_status.status=leave_history.Leave_Status 
																	INNER JOIN admin_users ON admin_users.name=leave_history.Emp_Number
																	WHERE leaveID='$lid'")->result_array();	

	}
		


	function insert_permission_data($d,$time,$total,$reason){
		$emp_num=$this->session->userdata('Emp_Num');
		$this->db->query("INSERT INTO permissions(p_date,Emp_Number,timefrom,totalhrs,reason)  VALUES(STR_TO_DATE(STR_TO_DATE('$d','%d-%m-%Y'),'%Y-%m-%d'),'$emp_num','$time','$total',\"$reason\") ");

	}


	function get_permission($d){
		$emp_num=$this->session->userdata('Emp_Num');
		$this->db->query("SELECT COUNT(p_date) as permission FROM permissions WHERE  Emp_Number='$emp_num' AND month(STR_TO_DATE(DATE_FORMAT(p_date,'%d-%m-%Y'),'%d-%m-%Y'))=month('$d') ")->result_array();

	}
	function get_allpermissions($y,$d){
		$emp_num=$this->session->userdata('Emp_Num');
		return $this->db->query("SELECT DISTINCT (SELECT COUNT(p_date) as permission FROM permissions WHERE Emp_Number='$emp_num' AND MONTH(p_date) ='05' AND YEAR(p_date) ='2014' AND status='Approved') as month,
																							(SELECT COUNT(p_date) as permission FROM permissions WHERE Emp_Number='$emp_num' AND YEAR(p_date) ='2014' AND status='Approved') as year,
																							(SELECT COUNT(p_date) as permission FROM permissions WHERE Emp_Number='$emp_num' AND YEAR(p_date) ='2014' AND status='Applied') as pending
																							FROM permissions ")->result_array();

	}


	function check_permission_data($d){
		$emp_num=$this->session->userdata('Emp_Num');
		$data=$this->db->query("SELECT COUNT(p_date) as 'count' FROM permissions WHERE  Emp_Number='$emp_num' AND MONTH(p_date)=SUBSTRING('$d',4,2)  AND YEAR(p_date)=SUBSTRING('$d',7,10)  AND status!='Applied' ")->result_array();
		foreach($data as $name){
			$count1=$name["count"];
		}
		return $count1;

	}

	function get_pending_permissions(){
		$availability =$this->db->query("SELECT *  FROM permissions  WHERE status='Applied' ORDER BY permission_id");
		return $availability->result_array();

			
	}



	function process_permission($id,$str){
		$this->db->query("UPDATE permissions SET status='$str' WHERE permission_id='$id' ");

	}


	function calculate_workingdays($date1,$date2){
		$emp_num=$this->session->userdata('Emp_Num');
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
																							AND Emp_Number='$emp_num') a  ")->result_array();
			
	}



	function getFilePath($leaveID){
		return $this->db->query("SELECT filename 	FROM files
																			WHERE leave_id = '$leaveID' Limit 1")->result_array();
			
	}


		
}


?>