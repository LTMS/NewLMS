<?php
Class Apply_model extends CI_Model{
	
			function _construct(){
				parent::_construct();
			}
	
		function get_Leave_At_Reporter_Year($type){
			$year=date("Y");
			$emp_num=$this->session->userdata["Emp_Number"];		
			return $this->db->query("	SELECT SUM(At_Reporter) AS 'At_Reporter',
																				SUM(At_Approver) AS 'At_Approver', 
																				SUM(Approved) AS 'Approved',
																				SUM(Total) as Total
																FROM(
																						SELECT Emp_Number,
																										IF(Leave_Status='1',Total_Days, 0) as 'At_Reporter',
																										IF(Leave_Status='2',Total_Days, 0) as 'At_Approver',
																										IF(Leave_Status='4',Total_Days, 0) as 'Approved',
																										IFNULL(Total_Days,0) as Total	
																						FROM leave_history
																						WHERE Leave_Type='$type' AND YEAR(From_Date)='$year'
																										 AND Emp_Number='$emp_num') A	")->result_array();
			
		}
		
		function get_Leave_At_Reporter_Month($type){
			$month=date("m");
			$year=date("Y");
			$emp_num=$this->session->userdata["Emp_Number"];		
			return $this->db->query("	SELECT SUM(At_Reporter) AS 'At_Reporter',
																				SUM(At_Approver) AS 'At_Approver', 
																				SUM(Approved) AS 'Approved',
																				IFNULL(Total,0) as Total	
																FROM(
																						SELECT Emp_Number,
																										IF(Leave_Status='1',Total_Days, 0) as 'At_Reporter',
																										IF(Leave_Status='2',Total_Days, 0) as 'At_Approver',
																										IF(Leave_Status='4',Total_Days, 0) as 'Approved',
																										IFNULL(Total_Days,0) as Total	
																						FROM leave_history
																						WHERE YEAR(From_Date)='$year' AND MONTH(From_Date)='$month'
																										  AND Emp_Number='$emp_num' AND Leave_Type='$type' ) A	")->result_array();
			
		}
		
					
		function get_Leave_Approved($type){
			$month=date("m");
			$year=date("Y");
			$emp_num=$this->session->userdata["Emp_Number"];		
			return $this->db->query("SELECT SUM(Total_Days) as Total,Leave_Type,Leave_Status
																FROM leave_history
																WHERE YEAR(From_Date)='$year' AND Leave_Type='$type' 
																				AND Emp_Number='$emp_num' AND Leave_Status IN (2,4) ")->result_array();
			
		}
					
		function get_MailID($emp_num){
				return	$this->db->query("SELECT Email as Emp_Mail,
																	(SELECT DISTINCT Employee_Name FROM employees WHERE Employee_Number=a.Reporter) as Reporter_Name,
																	(SELECT DISTINCT Email FROM employees WHERE Employee_Number=a.Reporter) as Reporter_Mail, 
																	(SELECT DISTINCT Employee_Name FROM employees WHERE Employee_Number=a.Approver) as Approver_Name,
																	(SELECT DISTINCT Email FROM employees WHERE Employee_Number=a.Approver) as Approver_Mail
																	FROM 
																	(SELECT Email, Reporter, Approver FROM employees WHERE Employee_Number='$emp_num') a")->result_array();
		}
	
	function get_Experience(){
			$Emp_Num=$this->session->userdata("Emp_Number");
			return $this->db->query("SELECT 12 * (YEAR(CURDATE()) - YEAR(DOJ)) 
       																						+ (MONTH(CURDATE()) - MONTH(DOJ)) AS Experience_Month 
																FROM employees
																WHERE Employee_Number='$Emp_Num' limit 1")->result_array();
		
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
		
	function upload_ProofDoc($encr_name,$type){
				$emp_num=$this->session->userdata("Emp_Number");
				return	$this->db->query("INSERT INTO proof_documents(Emp_Number,Encr_Name,Leave_Type,Status) 
																	VALUES('$emp_num','$encr_name','$type','Selected')");
	}
	
	
		function update_DocumentStatus($type,$leaveid){
					$emp_num=$this->session->userdata("Emp_Number");
					return $this->db->query("UPDATE proof_documents
																		SET Leave_ID='$leaveid',
																				Status='Uploaded'
																		WHERE Leave_Type='$type' AND  Emp_Number='$emp_num' AND Status='Selected'  ");
	}
		
	
	function delete_ProofDoc($file_id){
			$this->db->query("DELETE FROM proof_documents
												WHERE Encr_Name='$file_id' AND Status='Selected' ");
	}

		function get_NotUploadedDocuments(){
				$emp_num=$this->session->userdata("Emp_Number");
				return 	$this->db->query("SELECT Encr_Name
																	FROM proof_documents
																	WHERE Emp_Number='$emp_num' AND Status='Selected'  ")->result_array();
				
				
	}
	
	
		function delete_NotUploadedDocuments(){
			$emp_num=$this->session->userdata("Emp_Number");
			$this->db->query("DELETE FROM proof_documents
												WHERE Emp_Number='$emp_num' AND Status='Selected' ");
	}
	
																			/* * * 		Inserting Leave Application 		* * */	
	
	
	function insert_LeaveApplication($leave_type,$from_date,$to_date,$days,$reason,$proof_status){

		$add_date=date('Y-m-d H:i:s');
		$emp_num=$this->session->userdata('Emp_Number');
		$emp_name=$this->session->userdata('Emp_Name');
		
		$this->db->query("INSERT INTO 
																	leave_history(Emp_Number, Emp_Name, Leave_Type, From_Date,To_Date,Total_Days,Leave_Status,Reason,Applied_On,Proof_Uploaded)
																	VALUES('$emp_num','$emp_name','$leave_type','$from_date','$to_date','$days','1','$reason',CURRENT_TIMESTAMP,'$proof_status' )  ");
				return $this->db->query("SELECT Leave_ID
																	FROM leave_history
																	WHERE Emp_Number='$emp_num' AND From_Date='$from_date'
																					AND Leave_Status='1' AND Leave_Type='$leave_type' ")->result_array();	
				

	}


	function getFilePath($leaveID){
		return $this->db->query("SELECT filename 	FROM files
																			WHERE leave_id = '$leaveID' Limit 1")->result_array();
			
	}

	
	function get_Attachments($leave_Id){
				return $this->db->query("SELECT Encr_Name
																	FROM proof_documents
																	WHERE Leave_ID='$leave_Id' ")->result_array();
		
	}	
	
	
	
	
												/* * * 		OT Calculation 		* * */
	// to be done after Timesheet have completed.
		function get_OT_Summary(){
				$year=date('Y');
				$month=date('m');
				$emp_num=$this->session->userdata("Emp_Number");
					
				return $this->db->query("SELECT IFNULL(HOUR(ADDTIME(normal,sun))+IF(MINUTE(ADDTIME(normal,sun))>29,1,0),0) as total, normal,sun
																			FROM (
																						SELECT (SELECT SEC_TO_TIME(SUM(time_to_sec(ts_ot))) FROM time_sheet  
																											WHERE YEAR(ts_date)='$year' AND MONTH(ts_date)='$month' AND ts_name='$emp_num'
																											AND (DAYNAME(ts_date)!='Sunday' OR ts_date NOT IN (SELECT holi_date FROM holidays))) as normal,
																										(SELECT IFNULL(SEC_TO_TIME(SUM(time_to_sec(ts_duty))),'0')  FROM time_sheet  
																											WHERE YEAR(ts_date)='$year' AND MONTH(ts_date)='$month' AND ts_name='$emp_num'
																											AND (DAYNAME(ts_date)='Sunday' OR ts_date IN (SELECT holi_date FROM holidays)) ) as sun) a")->result_array();
			
	}
	
	
	
	
	
	
	
	
	

		
}


?>