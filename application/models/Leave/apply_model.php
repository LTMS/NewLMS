<?php
Class Apply_model extends CI_Model{
	function _construct(){
		parent::_construct();
	}
		
	function get_Experience(){
			$Emp_Num=$this->session->userdata("Emp_Number");
			return $this->db->query("SELECT 12 * (YEAR(CURDATE()) - YEAR(DOJ)) 
       																						+ (MONTH(CURDATE()) - MONTH(DOJ)) AS Experience_Month 
																FROM employees
																WHERE Employee_Number='$Emp_Num' limit 1")->result_array();
		
	}	
	
	function upload_ProofDoc($encr_name,$type){
			return	$this->db->query("INSERT INTO proof_documents(Encr_Name,Leave_Type,Status) values('$encr_name','$type','Selected')");

		//	get_RecentlyUploadedFile($encr_name);
	}
	
		function get_RecentlyUploadedFile($encr_name){
			return $this->db->query("SELECT doc_id 
																FROM proof_documents
																WHERE Encr_Name='$encr_name'  Limit 1 ")->result_array();
	}
		
	
	function delete_ProofDoc($file_id){
			$this->db->query("DELETE FROM proof_documents
												WHERE Encr_Name='$file_id'");
	}
	
	function get_LeaveCriteria(){
			return $this->db->query("SELECT *
																FROM leave_criteria")->result_array();
	}
	
	function check_in_holidays($date){
				
				return $this->db->query("SELECT COUNT(holi_date) AS status, holi_desc 
																	FROM holidays  
																	WHERE holi_date='$date' Limit 1")->result_array();
	}

	function check_leavetaken($date)	{
		$emp_num=$this->session->userdata('Emp_Number');
		return $this->db->query("SELECT COUNT(Emp_Number) AS Count, LeaveDesc, DATE(Applied_On) as Applied_On 
															FROM leave_history  INNER JOIN leave_list b ON Leave_Type=b.LeaveType
															WHERE Emp_Number='$emp_num' AND  '$date' BETWEEN From_Date AND To_Date
																		  AND Leave_Status IN (1,2,4) Limit 1")->result_array();
	}
	
	function check_prior_days($date,$type){	
			return $this->db->query("SELECT DATEDIFF('$date', CURDATE()) as Diff, Prior_Days
																FROM leave_criteria
																WHERE Leave_Type='$type'")->result_array();
	}

	function calculate_no_of_days($date_from,$date_to){	
			return $this->db->query("SELECT DATEDIFF('$date_to','$date_from')+1 as Diff ")->result_array();
	}

	function check_MonthlyLimit($date,$type){
			$Emp_Num=$this->session->userdata("Emp_Number");
			return $this->db->query("SELECT IFNULL(SUM(Total_Days),0) as TotalDays
																FROM leave_history
																WHERE Emp_Number='$Emp_Num' AND MONTH(From_Date)=MONTH('$date')
																				AND Leave_Type='$type' AND Leave_Status IN (1,2,4)  ")->result_array();
	}

	function check_YearlyLimit($date,$type){
			$Emp_Num=$this->session->userdata("Emp_Number");
			return $this->db->query("SELECT IFNULL(SUM(Total_Days),0) as TotalDays
																FROM leave_history
																WHERE Emp_Number='$Emp_Num' AND YEAR(From_Date)=YEAR('$date')
																				AND Leave_Type='$type'  AND Leave_Status IN (1,2,4)")->result_array();
	}
	
	function validate_casual($d){
		$emp_num=$this->session->userdata('Emp_Number');
		return $this->db->query("SELECT SUM(Total_Days) AS day FROM leave_history
																		WHERE MONTH(STR_TO_DATE(STR_TO_DATE('$d','%d-%m-%Y'),'%Y-%m-%d'))=MONTH(From_Date) AND YEAR(STR_TO_DATE(STR_TO_DATE('$d','%d-%m-%Y'),'%Y-%m-%d'))=YEAR(From_Date)
																		AND Emp_Number='$emp_num' AND Leave_Type='Casual Leave'")->result_array();
	}
	

																		/* * * 			Update Leave Applcation			* * */
	function insert_LeaveApplication($leave_type,$from_date,$to_date,$days,$reason){

		$add_date=date('Y-m-d H:i:s');
		$emp_num=$this->session->userdata('Emp_Number');
		$emp_name=$this->session->userdata('Emp_Name');
		
		$availability =$this->db->query("INSERT INTO 
																	leave_history(Emp_Number, Emp_Name, Leave_Type, From_Date,To_Date,Total_Days,Leave_Status,Reason,Applied_On)
																	VALUES('$emp_num','$emp_name','$leave_type','$from_date','$to_date','$days','1','$reason',CURRENT_TIMESTAMP );");
	}




	function getMailData($date_from,$reasoning,$day,$l_type,$Offr){
		$emp_num=$this->session->userdata('Emp_Number');
			
		return $this->db->query("SELECT DISTINCT (SELECT email FROM admin_users WHERE name='$emp_num') AS FromMail ,
					(SELECT email FROM admin_users WHERE name=(SELECT LeaveApprover_L1 FROM team WHERE EmployeeName='$emp_num' ) ) AS ToMail1,
					 (SELECT email 	FROM admin_users WHERE user_email='MD' limit 1 ) AS ToMail2,'$emp_num' as Name,
					filename,file_count
					 FROM  (
					 SELECT IF(filename!='',filename,'NO') as filename, COUNT(filename) as file_count FROM files	WHERE leave_id = (SELECT LeaveID FROM leave_history WHERE Emp_Number='$emp_num' AND Leave_Type='Sick Leave' AND DATE_FORMAT(From_Date,'%d-%m-%Y')='$date_from') limit 1) a")->result_array();
			

	}
		
	function approve_mail($lid){
		$app=$this->session->userdata('Emp_Number');
		return $this->db->query("SELECT Emp_Number,Leave_Type AS Type,From_Date As Date,Total_Days As Days,Applied_On AS Time,leave_status.Description As Status,
																	admin_users.email AS Email,(SELECT email FROM admin_users WHERE name='$app' ) AS FromMail
																	FROM leave_history 
																	INNER JOIN leave_status ON leave_status.status=leave_history.Leave_Status 
																	INNER JOIN admin_users ON admin_users.name=leave_history.Emp_Number
																	WHERE leaveID='$lid'")->result_array();	

	}
		


	function insert_permission_data($d,$time,$total,$reason){
		$emp_num=$this->session->userdata('Emp_Number');
		$this->db->query("INSERT INTO permissions(p_date,Emp_Number,timefrom,totalhrs,reason)  VALUES(STR_TO_DATE(STR_TO_DATE('$d','%d-%m-%Y'),'%Y-%m-%d'),'$emp_num','$time','$total',\"$reason\") ");

	}


	function get_permission($d){
		$emp_num=$this->session->userdata('Emp_Number');
		$this->db->query("SELECT COUNT(p_date) as permission FROM permissions WHERE  Emp_Number='$emp_num' AND month(STR_TO_DATE(DATE_FORMAT(p_date,'%d-%m-%Y'),'%d-%m-%Y'))=month('$d') ")->result_array();

	}
	function get_allpermissions($y,$d){
		$emp_num=$this->session->userdata('Emp_Number');
		return $this->db->query("SELECT DISTINCT (SELECT COUNT(p_date) as permission FROM permissions WHERE Emp_Number='$emp_num' AND MONTH(p_date) ='05' AND YEAR(p_date) ='2014' AND status='Approved') as month,
																							(SELECT COUNT(p_date) as permission FROM permissions WHERE Emp_Number='$emp_num' AND YEAR(p_date) ='2014' AND status='Approved') as year,
																							(SELECT COUNT(p_date) as permission FROM permissions WHERE Emp_Number='$emp_num' AND YEAR(p_date) ='2014' AND status='Applied') as pending
																							FROM permissions ")->result_array();

	}


	function check_permission_data($d){
		$emp_num=$this->session->userdata('Emp_Number');
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
		$emp_num=$this->session->userdata('Emp_Number');
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