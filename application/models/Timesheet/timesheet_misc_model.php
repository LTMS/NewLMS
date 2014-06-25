<?php
Class timesheet_misc_model extends CI_Model{
	function _construct()
	{
		parent::_construct();
	}

	
	function get_all_jobs()
	{
		$uname=$this->session->userdata('fullname');
		return $this->db->query("SELECT job_id, job_no, job_desc, CASE WHEN  enabled='1' THEN 'Enabled' WHEN  enabled='0' THEN 'Disabled' END as  status, enabled as enb FROM jobs WHERE job_no!='Nil' AND name='$uname' ORDER BY addedtime desc ")->result_array();
	}
	function get_all_npjobs()
	{
		$uname=$this->session->userdata('fullname');
		return $this->db->query("SELECT id_npjobs, job_no, job_desc, CASE WHEN  enabled='1' THEN 'Enabled' WHEN  enabled='0' THEN 'Disabled' END as status, enabled as enb FROM np_jobs WHERE job_no!='Nil' AND name='$uname' ORDER BY addedtime desc ")->result_array();
	}
function check_job($job){
			$user=$this->session->userdata('fullname');
			$data= $this->db->query("SELECT job_desc FROM jobs WHERE job_no='$job'  AND name='$user' limit 1")->result_array();
			if(empty($data)){return $row1="";}
			foreach($data as $row){
				$row1=$row["job_desc"];
			}
			return $row1;
		}
function add_jobs($num,$desc,$type)
	{
		$uname=$this->session->userdata('fullname');
		if($type==1){
			$this->db->query("INSERT INTO jobs (job_no,job_desc,name) VALUES ('$num',\"$desc\",'$uname')");
		}
		else {
			$this->db->query("INSERT INTO np_jobs (job_no,job_desc,name) VALUES ('$num',\"$desc\",'$uname')");
		}

	}
	function update_jobs($num,$desc,$type,$id)
	{
		$uname=$this->session->userdata('fullname');
		if($type==1){
			$this->db->query("UPDATE jobs SET job_no='$num',job_desc=\"$desc\"  WHERE job_id='$id'");
		}
		else {
			$this->db->query("UPDATE np_jobs SET job_no='$num',job_desc=\"$desc\" WHERE id_npjobs='$id'");
		}

	}
function fetch_job($job){
			$user=$this->session->userdata('fullname');
			$data= $this->db->query("SELECT job_desc FROM jobs WHERE job_no='$job'   AND job_no NOT IN (SELECT job_no FROM jobs WHERE name='$user')  limit 1")->result_array();
			if(empty($data)){return $row1="";}
			foreach($data as $row){
				$row1=$row["job_desc"];
			}
			return $row1;
		}	
		
		function check_npjob($job){
			$user=$this->session->userdata('fullname');
			$data=$this->db->query("SELECT job_desc FROM np_jobs WHERE job_no='$job'  AND  name='$user'  limit 1")->result_array();
			if(empty($data)){return $row1="";}
			foreach($data as $row){
				$row1=$row["job_desc"];
			}
			return $row1;
		}
			
		function fetch_npjob($job){
			$user=$this->session->userdata('fullname');
			$data=$this->db->query("SELECT job_desc FROM np_jobs WHERE job_no='$job'  AND job_no NOT IN (SELECT job_no FROM jobs WHERE name='$user')  limit 1")->result_array();
			if(empty($data)){return $row1="";}
			foreach($data as $row){
				$row1=$row["job_desc"];
			}
			return $row1;
		}
	
	function process_npjobs($value,$num)
	{
		if($value==0){
			return $this->db->query("UPDATE np_jobs SET enabled='1' WHERE id_npjobs='$num' ");
		}
		else {
			return $this->db->query("UPDATE np_jobs SET enabled='0'  WHERE id_npjobs='$num' ");
		}
	}
		
	function process_jobs($value,$num)
	{
		if($value==0){
			$this->db->query("UPDATE jobs SET enabled=1 WHERE job_id='$num' ");
		}
		else {
			$this->db->query("UPDATE jobs SET enabled=0 WHERE job_id='$num' ");
		}

	}	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

	function get_parameters()
	{
			
		return $this->db->query("SELECT *, (TIME_TO_SEC(min_OT)/60) AS OT FROM parameters ")->result_array();

	}

		
		
	function get_lockedyears()
	{
		return $this->db->query("SELECT  DISTINCT YEAR(lock_date) AS 'year' FROM ts_locked_users WHERE lock_status='0' ORDER BY year ")->result_array();
	}
		
		
		
		

	function get_dept()
	{
		return $this->db->query("SELECT * FROM departments ")->result_array();
	}



	function get_team()
	{
		return $this->db->query("SELECT a.EmployeeName AS EmployeeName FROM team a  WHERE a.Designation='TeamLeader' ORDER BY a.EmployeeName")->result_array();
	}

	function get_activity_code()
	{
		return $this->db->query("SELECT  * FROM activity_code")->result_array();
	}

	function get_jobs()
	{
		$uname=$this->session->userdata('fullname');

		return $this->db->query("SELECT  job_no, job_desc,CONCAT(job_desc,' - ',job_no) AS JOB FROM jobs WHERE enabled='1' AND name='$uname' ")->result_array();
	}

	function get_np_jobs()
	{
		$uname=$this->session->userdata('fullname');
		return $this->db->query("SELECT  job_no, job_desc,CONCAT(job_desc,' - ',job_no) AS JOB FROM np_jobs WHERE enabled='1' AND name='$uname'")->result_array();
	}

	function insert_timesheet_data($date,$in,$out,$late,$lunch,$duty,$ot,$tot,$j1,$t1,$j2,$t2,$j3,$t3,$j4,$t4,$j5,$t5,$j6,$t6,$j7,$t7,$np1,$atv1,$desc1,$np2,$atv2,$desc2,$np3,$atv3,$desc3,$np4,$atv4,$desc4,$np5,$atv5,$desc5,$np6,$atv6,$desc6,$np7,$atv7,$desc7)
	{
		$uname=$this->session->userdata('fullname');
			
		$this->db->query("INSERT INTO time_sheet(ts_date,ts_name,ts_intime,ts_outtime,ts_late,ts_lunch,ts_duty,ts_ot,ts_tot_hrs)
						 										 VALUES(STR_TO_DATE(STR_TO_DATE('$date','%d-%m-%Y'),'%Y-%m-%d'),'$uname','$in','$out','$late','$lunch','$duty','$ot','$tot')");

		for($jobs=1;$jobs<8;$jobs++){
			$job1=${'j'.$jobs};
			$time1=${'t'.$jobs};
			$atv1=${'atv'.$jobs};
			$np1=${'np'.$jobs};
			$desc1=${'desc'.$jobs};
			if($job1!='Nil' && $time1!="00:00:00"){
				$this->db->query("INSERT INTO time_sheet_jobs(ts_date,ts_name,job_no,job_time,activity,job_np,task_desc)
															 									 VALUES(STR_TO_DATE(STR_TO_DATE('$date','%d-%m-%Y'),'%Y-%m-%d'),'$uname','$job1','$time1','$atv1','$np1',\"$desc1\")");
			}
		}
	}
		

	function get_job_num()
	{
		$uname=$this->session->userdata('fullname');
		return $this->db->query("SELECT  job_no as num FROM jobs WHERE AND name='$uname'")->result_array();
	}


	function get_team_members()
	{
		$uname=$this->session->userdata('fullname');

		return $this->db->query("SELECT EmployeeName AS 'Name' FROM team WHERE LeaveApprover_L1='$uname' ORDER BY EmployeeName ")->result_array();
	}

	function get_all_members(){
		return $this->db->query("SELECT DISTINCT Emp_Name AS 'Name' FROM  admin_users WHERE Emp_role NOT IN ('MD') ORDER BY name")->result_array();
	}


	function displayname($name)
	{

		return  $this->db->query("SELECT  ts_name AS name FROM time_sheet WHERE ts_name LIKE '$name' ")->result_array();
	}

	
	
		
	
		
		
	

	function get_timesheet_overall_hrs($d1,$d2){


		if($d1!="" && $d2!=""){
			return  $this->db->query("SELECT (SELECT COUNT(ts_date) FROM time_sheet WHERE STR_TO_DATE(DATE_FORMAT(ts_date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y') ) AS days,
									                               		  SUM(HOUR(job_time))+HOUR(SEC_TO_TIME(SUM(MINUTE(job_time)*60))) AS total ,
															     		  SEC_TO_TIME(AVG(TIME_TO_SEC(job_time))) AS'avg' 
									                                      FROM time_sheet_jobs  
																		  WHERE STR_TO_DATE(DATE_FORMAT(ts_date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y') ")->result_array();		
		}
		else {
			return  $this->db->query("SELECT (SELECT COUNT(ts_date) FROM time_sheet) AS days,
							                                           		 SUM(HOUR(job_time))+HOUR(SEC_TO_TIME(SUM(MINUTE(job_time)*60))) AS total ,
															   			     SEC_TO_TIME(AVG(TIME_TO_SEC(job_time))) AS 'avg' 
							                                                 FROM time_sheet_jobs  ")->result_array();		
		}
	}

	function get_timesheet_overall($d1,$d2){

		if($d1!="" && $d2!=""){
			return  $this->db->query("SELECT a.job_no AS num, b.job_desc AS 'desc', COUNT(a.ts_date) AS days, SEC_TO_TIME(SUM(TIME_TO_SEC(a.job_time))) AS total,SEC_TO_TIME(AVG(TIME_TO_SEC(a.job_time))) AS 'AVG', COUNT(ts_date) AS Days FROM time_sheet_jobs a INNER JOIN jobs b ON (a.job_no=b.job_no AND b.name=a.ts_name)
																		 WHERE  STR_TO_DATE(DATE_FORMAT(a.ts_date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y') GROUP BY a.job_no ORDER BY b.addedtime desc")->result_array();			
		}
		else {
			return  $this->db->query("SELECT a.job_no AS num, b.job_desc AS 'desc', COUNT(a.ts_date) AS days, SEC_TO_TIME(SUM(TIME_TO_SEC(a.job_time))) AS total,SEC_TO_TIME(AVG(TIME_TO_SEC(a.job_time))) AS 'AVG', COUNT(ts_date) AS Days FROM time_sheet_jobs a INNER JOIN jobs b ON (a.job_no=b.job_no AND b.name=a.ts_name)
																		     GROUP BY a.job_no ORDER BY b.addedtime desc")->result_array();			
		}
			
			
	}


	function get_timesheet_jobwise($d1,$d2,$num){

		if($d1!="" && $d2!=""){
			return  $this->db->query("SELECT a.job_no AS num, b.job_desc AS 'desc', a.ts_name AS name, COUNT(a.ts_date) AS days,
																	 SEC_TO_TIME(SUM(TIME_TO_SEC(a.job_time))) AS total,
																	 SEC_TO_TIME(AVG(TIME_TO_SEC(a.job_time))) AS 'avg' 
																	 FROM time_sheet_jobs a INNER JOIN jobs b ON (a.job_no=b.job_no AND b.name=a.ts_name)  
																	 WHERE STR_TO_DATE(DATE_FORMAT(a.ts_date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y') AND a.job_no='$num' GROUP BY a.ts_name ORDER BY total")->result_array();			
				
		}
		else {
			return  $this->db->query("SELECT a.job_no AS num, b.job_desc AS 'desc', a.ts_name AS name, COUNT(a.ts_date) AS days,
										                                 SEC_TO_TIME(SUM(TIME_TO_SEC(a.job_time))) AS total, SEC_TO_TIME(AVG(TIME_TO_SEC(a.job_time))) AS 'avg' 
										                              FROM time_sheet_jobs a INNER JOIN jobs b ON (a.job_no=b.job_no AND b.name=a.ts_name) 
																	 WHERE  a.job_no='$num' 
																	 GROUP BY a.ts_name ORDER BY total")->result_array();			
		}

	}


	function get_timesheet_jobwise_hrs($d1,$d2,$num){

		if($d1!="" && $d2!=""){
			return  $this->db->query("SELECT (SELECT COUNT(ts_date) FROM time_sheet WHERE STR_TO_DATE(DATE_FORMAT(ts_date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y') ) AS days,
									                              		  SUM(HOUR(job_time))+HOUR(SEC_TO_TIME(SUM(MINUTE(job_time)*60))) AS total ,
															     	     SEC_TO_TIME(AVG(TIME_TO_SEC(job_time))) AS 'avg' 
															     	     FROM time_sheet_jobs 
																	 WHERE STR_TO_DATE(DATE_FORMAT(ts_date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y') AND job_no='$num' ")->result_array();			
				
		}
		else {
			return  $this->db->query("SELECT (SELECT COUNT(ts_date) FROM time_sheet  ) AS days,
									                             		  SUM(HOUR(job_time))+HOUR(SEC_TO_TIME(SUM(MINUTE(job_time)*60))) AS total ,
									                             		  SEC_TO_TIME(AVG(TIME_TO_SEC(job_time))) AS 'avg' 
															     		  FROM time_sheet_jobs 
																		 WHERE  job_no='$num' ")->result_array();			
		}
	}

		
	function get_timesheet_userwise($d1,$d2,$user){

		if($d1!='' && $d2!='' ){
			return  $this->db->query("SELECT a.job_no AS num, b.job_desc AS 'desc', a.ts_name AS name, COUNT(a.ts_date) AS days, SEC_TO_TIME(SUM(TIME_TO_SEC(a.job_time))) AS total,SEC_TO_TIME(AVG(TIME_TO_SEC(a.job_time))) AS avg FROM time_sheet_jobs a INNER JOIN jobs b ON (a.job_no=b.job_no AND b.name=a.ts_name)
																	 WHERE STR_TO_DATE(DATE_FORMAT(a.ts_date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y') AND a.ts_name='$user' GROUP BY a.job_no ORDER BY total")->result_array();			
				
		}
		else{
			return  $this->db->query("SELECT a.job_no AS num, b.job_desc AS 'desc', a.ts_name AS name, COUNT(a.ts_date) AS days, SEC_TO_TIME(SUM(TIME_TO_SEC(a.job_time))) AS total,SEC_TO_TIME(AVG(TIME_TO_SEC(a.job_time))) AS avg FROM time_sheet_jobs a INNER JOIN jobs b ON (a.job_no=b.job_no AND b.name=a.ts_name)
																	 WHERE  a.ts_name='$user' GROUP BY a.job_no ORDER BY total")->result_array();			
		}
	}

	function get_timesheet_userwise_hrs($d1,$d2,$user){
		if($d1!='' && $d2!=''){
			return  $this->db->query("SELECT  COUNT(a.ts_date) AS days,
																		  SUM(HOUR(a.job_time))+HOUR(SEC_TO_TIME(SUM(MINUTE(a.job_time)*60))) AS total ,
															     		 SEC_TO_TIME(AVG(TIME_TO_SEC(a.job_time))) AS 'avg' 
															     		 FROM time_sheet_jobs a 
																	 WHERE STR_TO_DATE(DATE_FORMAT(a.ts_date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y') AND a.ts_name='$user' ")->result_array();			
		}
		else {
			return  $this->db->query("SELECT  COUNT(a.ts_date) AS days,
																		  SUM(HOUR(a.job_time))+HOUR(SEC_TO_TIME(SUM(MINUTE(a.job_time)*60))) AS total ,
															     			SEC_TO_TIME(AVG(TIME_TO_SEC(a.job_time))) AS 'avg' 
																		FROM time_sheet_jobs a 
																	 WHERE  a.ts_name='$user' ")->result_array();			
		}
	}

	function get_timesheet_ot_hrs($d1,$d2){
		if($d1 != '' && $d2 != ''){
			return  $this->db->query("SELECT  COUNT(ts_date)  AS days,
																	 SUM(HOUR(ts_late))+HOUR(SEC_TO_TIME(SUM(MINUTE(ts_late)*60))) AS late ,
																	SUM(HOUR(ts_duty))+HOUR(SEC_TO_TIME(SUM(MINUTE(ts_duty)*60))) AS duty ,
																	 ROUND(AVG(HOUR(ts_duty))+HOUR(SEC_TO_TIME(AVG(MINUTE(ts_duty)*60)))) AS avgduty ,
																	 SUM(HOUR(ts_ot))+HOUR(SEC_TO_TIME(SUM(MINUTE(ts_ot)*60))) AS ot , 
																	  ROUND(AVG(HOUR(ts_ot))+HOUR(SEC_TO_TIME(AVG(MINUTE(ts_ot)*60)))) AS avgot ,
																	 SUM(HOUR(ts_lunch))+HOUR(SEC_TO_TIME(SUM(MINUTE(ts_lunch)*60))) AS lunch ,
																	 SUM(HOUR(ts_tot_hrs))+HOUR(SEC_TO_TIME(SUM(MINUTE(ts_tot_hrs)*60))) AS total 
																	FROM time_sheet 
																	 WHERE STR_TO_DATE(DATE_FORMAT(ts_date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y') ")->result_array();			
		}
		else{
			return  $this->db->query("SELECT  COUNT(ts_date) AS days,
																 SUM(HOUR(ts_late))+HOUR(SEC_TO_TIME(SUM(MINUTE(ts_late)*60))) AS late ,
																	SUM(HOUR(ts_duty))+HOUR(SEC_TO_TIME(SUM(MINUTE(ts_duty)*60))) AS duty ,
																	 ROUND(AVG(HOUR(ts_duty))+HOUR(SEC_TO_TIME(AVG(MINUTE(ts_duty)*60)))) AS avgduty ,
																	 SUM(HOUR(ts_ot))+HOUR(SEC_TO_TIME(SUM(MINUTE(ts_ot)*60))) AS ot , 
																	  ROUND(AVG(HOUR(ts_ot))+HOUR(SEC_TO_TIME(AVG(MINUTE(ts_ot)*60)))) AS avgot ,
																	 SUM(HOUR(ts_lunch))+HOUR(SEC_TO_TIME(SUM(MINUTE(ts_lunch)*60))) AS lunch ,
																	 SUM(HOUR(ts_tot_hrs))+HOUR(SEC_TO_TIME(SUM(MINUTE(ts_tot_hrs)*60))) AS total 
																FROM time_sheet")->result_array();			
		}
	}

	function get_timesheet_ot($d1,$d2){
		if($d1!='' && $d2!=''){
			return  $this->db->query("SELECT  ts_name AS name,COUNT(ts_date) AS days,
																	 SEC_TO_TIME(SUM(TIME_TO_SEC(ts_late))) AS late ,
																	 SEC_TO_TIME(SUM(TIME_TO_SEC(ts_duty))) AS duty ,
																	 SEC_TO_TIME(AVG(TIME_TO_SEC(ts_duty))) AS avgduty ,
																	 SEC_TO_TIME(SUM(TIME_TO_SEC(ts_ot))) AS ot , 
																	 SEC_TO_TIME(AVG(TIME_TO_SEC(ts_ot))) AS avgot ,
																	 SEC_TO_TIME(SUM(TIME_TO_SEC(ts_lunch))) AS lunch ,
																	 SEC_TO_TIME(SUM(TIME_TO_SEC(ts_tot_hrs))) AS total 
																	FROM time_sheet 
																	 WHERE STR_TO_DATE(DATE_FORMAT(ts_date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y') GROUP BY ts_name")->result_array();			
		}
		else {
			return  $this->db->query("SELECT  ts_name AS name,COUNT(ts_date) AS days,
																	 SEC_TO_TIME(SUM(TIME_TO_SEC(ts_late))) AS late ,
																	 SEC_TO_TIME(SUM(TIME_TO_SEC(ts_duty))) AS duty ,
																	 SEC_TO_TIME(AVG(TIME_TO_SEC(ts_duty))) AS avgduty ,
																	 SEC_TO_TIME(SUM(TIME_TO_SEC(ts_ot))) AS ot , 
																	 SEC_TO_TIME(AVG(TIME_TO_SEC(ts_ot))) AS avgot ,
																	 SEC_TO_TIME(SUM(TIME_TO_SEC(ts_lunch))) AS lunch ,
																	 SEC_TO_TIME(SUM(TIME_TO_SEC(ts_tot_hrs))) AS total 
																	FROM time_sheet 
																	GROUP BY ts_name")->result_array();			

		}	}


		function timesheet_activity_emp($d1,$d2,$user){
			if($d1!='' && $d2!=''){
				return  $this->db->query("SELECT *, DATE_FORMAT(ts_date,'%d-%m-%Y') as date1
					     				FROM time_sheet 
					     				WHERE STR_TO_DATE(DATE_FORMAT(ts_date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y') AND ts_name='$user'  ORDER BY ts_date DESC")->result_array();			
					
			}
			else{
				return  $this->db->query("SELECT *, DATE_FORMAT(ts_date,'%d-%m-%Y') as date1
					     				FROM time_sheet 
					     				WHERE  ts_name='$user'  ORDER BY ts_date DESC")->result_array();			
					
			}
		}

		function timesheet_activity_emp_hrs($d1,$d2,$user){
			if($d1!='' && $d2 != ''){
				return  $this->db->query("SELECT  COUNT(ts_date) AS days,
					     													SUM(HOUR(ts_lunch))+HOUR(SEC_TO_TIME(SUM(MINUTE(ts_lunch)*60))) AS lunch ,
																			SUM(HOUR(ts_duty))+HOUR(SEC_TO_TIME(SUM(MINUTE(ts_duty)*60))) AS duty ,
																			SUM(HOUR(ts_ot))+HOUR(SEC_TO_TIME(SUM(MINUTE(ts_ot)*60))) AS ot ,
																			SUM(HOUR(ts_tot_hrs))+HOUR(SEC_TO_TIME(SUM(MINUTE(ts_tot_hrs)*60))) AS total
																			FROM time_sheet 
					     													WHERE STR_TO_DATE(DATE_FORMAT(ts_date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y')  AND ts_name='$user' ")->result_array();			
					
			}
			else {
				return  $this->db->query("SELECT  COUNT(ts_date) AS days,
					     													SUM(HOUR(ts_lunch))+HOUR(SEC_TO_TIME(SUM(MINUTE(ts_lunch)*60))) AS lunch ,
																			SUM(HOUR(ts_duty))+HOUR(SEC_TO_TIME(SUM(MINUTE(ts_duty)*60))) AS duty ,
																			SUM(HOUR(ts_ot))+HOUR(SEC_TO_TIME(SUM(MINUTE(ts_ot)*60))) AS ot ,
																			SUM(HOUR(ts_tot_hrs))+HOUR(SEC_TO_TIME(SUM(MINUTE(ts_tot_hrs)*60))) AS total
					     													FROM time_sheet 
					     													WHERE ts_name='$user' ")->result_array();			
			}
		}

		function user_timesheet_overall_hrs($d1,$d2){
			$uname=$this->session->userdata('fullname');

			if($d1 !="" && $d2 != ""){
				return  $this->db->query("SELECT  (SELECT COUNT(ts_date) FROM time_sheet WHERE STR_TO_DATE(DATE_FORMAT(ts_date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y')  AND ts_name='$uname') AS days,
					     													SUM(HOUR(job_time))+HOUR(SEC_TO_TIME(SUM(MINUTE(job_time)*60))) AS total ,
																			ROUND(AVG(HOUR(job_time))+HOUR(SEC_TO_TIME(AVG(MINUTE(job_time)*60)))) AS avg 
															           FROM time_sheet_jobs  
																	   WHERE STR_TO_DATE(DATE_FORMAT(ts_date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y')   AND ts_name='$uname' ")->result_array();			
					
			}
			else {
				return  $this->db->query("SELECT (SELECT COUNT(ts_date) FROM time_sheet WHERE  ts_name='$uname') AS days,
									               					SUM(HOUR(job_time))+HOUR(SEC_TO_TIME(SUM(MINUTE(job_time)*60))) AS total ,
																	ROUND(AVG(HOUR(job_time))+HOUR(SEC_TO_TIME(AVG(MINUTE(job_time)*60)))) AS avg 
														          FROM time_sheet_jobs  
																 WHERE  ts_name='$uname' ")->result_array();			
					
			}
		}


		function user_timesheet_overall($d1,$d2){
			$uname=$this->session->userdata('fullname');

			if($d1!="" && $d2!=""){

				return  $this->db->query("SELECT a.job_no AS num, b.job_desc AS 'desc', COUNT(a.ts_date) AS Days,
																				SEC_TO_TIME(SUM(TIME_TO_SEC(a.job_time))) AS total,
																				SEC_TO_TIME(AVG(TIME_TO_SEC(a.job_time))) AS 'AVG'
																			FROM time_sheet_jobs a INNER JOIN jobs b ON (a.job_no=b.job_no AND b.name=a.ts_name) 
																		 WHERE STR_TO_DATE(DATE_FORMAT(a.ts_date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y')  AND a.ts_name='$uname' GROUP BY a.job_no ORDER BY b.addedtime desc")->result_array();			
			}
			else {

				return  $this->db->query("SELECT a.job_no AS num, b.job_desc AS 'desc', COUNT(a.ts_date) AS Days,
																	SEC_TO_TIME(SUM(TIME_TO_SEC(a.job_time))) AS total,
																	SEC_TO_TIME(AVG(TIME_TO_SEC(a.job_time))) AS 'AVG'
																						FROM time_sheet_jobs a INNER JOIN jobs b ON (a.job_no=b.job_no AND b.name=a.ts_name) 
																		 WHERE  a.ts_name='$uname' GROUP BY a.job_no ORDER BY b.addedtime desc")->result_array();			
			}

		}




		function user_timesheet_jobwise($d1,$d2,$num){
			$uname=$this->session->userdata('fullname');
				
			if($d1!="" && $d2!=""){
				return  $this->db->query("SELECT  a.ts_date,a.job_no AS num, b.job_desc AS 'desc',  a.job_time AS total
											                                                FROM time_sheet_jobs a INNER JOIN jobs b ON (a.job_no=b.job_no AND b.name=a.ts_name) 
																	                       WHERE STR_TO_DATE(DATE_FORMAT(a.ts_date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y')  AND a.job_no='$num' AND  a.ts_name='$uname' ORDER BY total")->result_array();			
					
			}
			else {
				return  $this->db->query("SELECT  a.ts_date,a.job_no AS num, b.job_desc AS 'desc',    a.job_time AS total
										                              FROM time_sheet_jobs a INNER JOIN jobs b ON (a.job_no=b.job_no AND b.name=a.ts_name) 
																	 WHERE  a.job_no='$num' AND  a.ts_name='$uname'
																	 ORDER BY total")->result_array();			
			}

		}


		function user_timesheet_jobwise_hrs($d1,$d2,$num){
			$uname=$this->session->userdata('fullname');
				
			if($d1!="" && $d2!=""){
				return  $this->db->query("SELECT COUNT(ts_date) AS days,
																											SUM(HOUR(job_time))+HOUR(SEC_TO_TIME(SUM(MINUTE(job_time)*60))) AS total ,
																											ROUND(AVG(HOUR(job_time))+HOUR(SEC_TO_TIME(AVG(MINUTE(job_time)*60)))) AS avg 
																								 FROM time_sheet_jobs 
																	 							WHERE STR_TO_DATE(DATE_FORMAT(ts_date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y')  AND job_no='$num' AND  ts_name='$uname'")->result_array();			
					
			}
			else {
				return  $this->db->query("SELECT COUNT(ts_date) AS days,
																									SUM(HOUR(job_time))+HOUR(SEC_TO_TIME(SUM(MINUTE(job_time)*60))) AS total ,
																									ROUND(AVG(HOUR(job_time))+HOUR(SEC_TO_TIME(AVG(MINUTE(job_time)*60)))) AS avg 
																						 FROM time_sheet_jobs 
																						 WHERE  job_no='$num' AND  ts_name='$uname' ")->result_array();			
			}
		}

		function timesheet_activity_user($d1,$d2){
			$user=$this->session->userdata('fullname');
			if($d1!='' && $d2 != ''){
				return  $this->db->query("SELECT *,DATE_FORMAT(ts_date,'%d-%m-%Y') as date1	FROM time_sheet
					     				WHERE STR_TO_DATE(DATE_FORMAT(ts_date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y')  AND ts_name='$user'  ORDER BY ts_date DESC")->result_array();			
					
			}
			else {
					
				return  $this->db->query("SELECT *,DATE_FORMAT(FromDate,'%d-%m-%Y') as date1	FROM time_sheet
					     				WHERE ts_name='$user'  ORDER BY ts_date DESC")->result_array();			
					
					
					
			}
		}

		function timesheet_activity_user_hrs($d1,$d2){
			$user=$this->session->userdata('fullname');
			if($d1!='' && $d2 != ''){
				return  $this->db->query("SELECT  COUNT(ts_date) AS days,
					     													SUM(HOUR(ts_lunch))+HOUR(SEC_TO_TIME(SUM(MINUTE(ts_lunch)*60))) AS lunch ,
																			SUM(HOUR(ts_duty))+HOUR(SEC_TO_TIME(SUM(MINUTE(ts_duty)*60))) AS duty ,
																			SUM(HOUR(ts_ot))+HOUR(SEC_TO_TIME(SUM(MINUTE(ts_ot)*60))) AS ot ,
																			SUM(HOUR(ts_tot_hrs))+HOUR(SEC_TO_TIME(SUM(MINUTE(ts_tot_hrs)*60))) AS total
					     													FROM time_sheet 
					     													WHERE STR_TO_DATE(DATE_FORMAT(ts_date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y')  AND ts_name='$user' ")->result_array();			
					
			}
			else {
				return  $this->db->query("SELECT  COUNT(ts_date) AS days,
					     													SUM(HOUR(ts_lunch))+HOUR(SEC_TO_TIME(SUM(MINUTE(ts_lunch)*60))) AS lunch ,
																			SUM(HOUR(ts_duty))+HOUR(SEC_TO_TIME(SUM(MINUTE(ts_duty)*60))) AS duty ,
																			SUM(HOUR(ts_ot))+HOUR(SEC_TO_TIME(SUM(MINUTE(ts_ot)*60))) AS ot ,
																			SUM(HOUR(ts_tot_hrs))+HOUR(SEC_TO_TIME(SUM(MINUTE(ts_tot_hrs)*60))) AS total
					     													FROM time_sheet 
					     													WHERE ts_name='$user' ")->result_array();			
			}
		}
			
			
			
			
			
		function team_timesheet_overall_hrs($d1,$d2){
			$user=$this->session->userdata('fullname');

			if($d1!="" && $d2!=""){
				return  $this->db->query("SELECT (SELECT COUNT(ts_date) FROM time_sheet WHERE STR_TO_DATE(DATE_FORMAT(ts_date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y')  ) AS days,
									                         			SUM(HOUR(job_time))+HOUR(SEC_TO_TIME(SUM(MINUTE(job_time)*60))) AS total ,
																		ROUND(AVG(HOUR(job_time))+HOUR(SEC_TO_TIME(AVG(MINUTE(job_time)*60)))) AS avg 
																   	   FROM time_sheet_jobs  JOIN team b ON b.EmployeeName=ts_name
																	 WHERE STR_TO_DATE(DATE_FORMAT(ts_date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y')  AND b.LeaveApprover_L1='$user' ")->result_array();		
			}
			else {
				return  $this->db->query("SELECT (SELECT COUNT(ts_date) FROM time_sheet) AS days,
							                                            				SUM(HOUR(job_time))+HOUR(SEC_TO_TIME(SUM(MINUTE(job_time)*60))) AS total ,
																						ROUND(AVG(HOUR(job_time))+HOUR(SEC_TO_TIME(AVG(MINUTE(job_time)*60)))) AS avg 
																      		FROM time_sheet_jobs   JOIN team b ON b.EmployeeName=ts_name
							                                                WHERE b.LeaveApprover_L1='$user'")->result_array();		
			}
		}

		function team_timesheet_overall($d1,$d2){
			$user=$this->session->userdata('fullname');
			if($d1!="" && $d2!=""){
				return  $this->db->query("SELECT a.job_no AS num, b.job_desc AS 'desc', COUNT(a.ts_date) AS days,
																		SEC_TO_TIME(SUM(TIME_TO_SEC(a.job_time))) AS total,
																		SEC_TO_TIME(AVG(TIME_TO_SEC(a.job_time))) AS 'AVG'
																		 FROM time_sheet_jobs a INNER JOIN jobs b ON (a.job_no=b.job_no AND b.name=a.ts_name)  JOIN team c ON c.EmployeeName=a.ts_name
																		 WHERE STR_TO_DATE(DATE_FORMAT(a.ts_date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y')  AND c.LeaveApprover_L1='$user'     GROUP BY a.job_no ORDER BY b.addedtime desc")->result_array();			
			}
			else {
				return  $this->db->query("SELECT a.job_no AS num, b.job_desc AS 'desc', COUNT(a.ts_date) AS days,
																		SEC_TO_TIME(SUM(TIME_TO_SEC(a.job_time))) AS total,
																		SEC_TO_TIME(AVG(TIME_TO_SEC(a.job_time))) AS 'AVG'
																		 FROM time_sheet_jobs a INNER JOIN jobs b  ON (a.job_no=b.job_no AND b.name=a.ts_name)  JOIN team c ON c.EmployeeName=a.ts_name
																		WHERE c.LeaveApprover_L1='$user'     
																		GROUP BY a.job_no ORDER BY b.addedtime desc")->result_array();			
			}
				
				
		}


		function team_timesheet_jobwise($d1,$d2,$num){

			$user=$this->session->userdata('fullname');

			if($d1!="" && $d2!=""){
				return  $this->db->query("SELECT a.job_no AS num, b.job_desc AS 'desc', a.ts_name AS name,
																								 COUNT(a.ts_date) AS days,
																								  SEC_TO_TIME(SUM(TIME_TO_SEC(a.job_time))) AS total,
																								  SEC_TO_TIME(AVG(TIME_TO_SEC(a.job_time))) AS 'avg' 
																								FROM time_sheet_jobs a INNER JOIN jobs b ON (a.job_no=b.job_no AND b.name=a.ts_name)   JOIN team c ON c.EmployeeName=a.ts_name
																	 							WHERE STR_TO_DATE(DATE_FORMAT(a.ts_date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y')  AND a.job_no='$num' AND c.LeaveApprover_L1='$user' GROUP BY a.ts_name ORDER BY total")->result_array();			
					
			}
			else {
				return  $this->db->query("SELECT a.job_no AS num, b.job_desc AS 'desc', a.ts_name AS name,
																		 COUNT(a.ts_date) AS days,
										                                 SEC_TO_TIME(SUM(TIME_TO_SEC(a.job_time))) AS total, 
										                                 SEC_TO_TIME(AVG(TIME_TO_SEC(a.job_time))) AS 'avg' 
										                              FROM time_sheet_jobs a INNER JOIN jobs b ON (a.job_no=b.job_no AND b.name=a.ts_name)  JOIN team c ON c.EmployeeName=a.ts_name
																	 WHERE  a.job_no='$num' AND c.LeaveApprover_L1='$user'
																	 GROUP BY a.ts_name ORDER BY total")->result_array();			
			}

		}


		function team_timesheet_jobwise_hrs($d1,$d2,$num){
			$user=$this->session->userdata('fullname');

			if($d1!="" && $d2!=""){
				return  $this->db->query("SELECT (SELECT COUNT(ts_date) FROM time_sheet WHERE STR_TO_DATE(DATE_FORMAT(ts_date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y')  ) AS days,
							                                            				SUM(HOUR(job_time))+HOUR(SEC_TO_TIME(SUM(MINUTE(job_time)*60))) AS total ,
																						ROUND(AVG(HOUR(job_time))+HOUR(SEC_TO_TIME(AVG(MINUTE(job_time)*60)))) AS avg 
																				FROM time_sheet_jobs JOIN team b ON b.EmployeeName=ts_name
																	  WHERE STR_TO_DATE(DATE_FORMAT(ts_date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y')  AND job_no='$num' AND b.LeaveApprover_L1='$user'")->result_array();			
					
			}
			else {
				return  $this->db->query("SELECT (SELECT COUNT(ts_date) FROM time_sheet  ) AS days,
							                                            				SUM(HOUR(job_time))+HOUR(SEC_TO_TIME(SUM(MINUTE(job_time)*60))) AS total ,
																						ROUND(AVG(HOUR(job_time))+HOUR(SEC_TO_TIME(AVG(MINUTE(job_time)*60)))) AS avg 
																	         FROM time_sheet_jobs JOIN team b ON b.EmployeeName=ts_name
																	 WHERE  job_no='$num' AND b.LeaveApprover_L1='$user'")->result_array();			
			}
		}

			
		function team_timesheet_ot_hrs($d1,$d2){
			$user=$this->session->userdata('fullname');
			if($d1 != '' && $d2 != ''){
				return  $this->db->query("SELECT  COUNT(ts_date) AS days,
																		 SUM(HOUR(ts_late))+HOUR(SEC_TO_TIME(SUM(MINUTE(ts_late)*60))) AS late ,
																	SUM(HOUR(ts_duty))+HOUR(SEC_TO_TIME(SUM(MINUTE(ts_duty)*60))) AS duty ,
																	 ROUND(AVG(HOUR(ts_duty))+HOUR(SEC_TO_TIME(AVG(MINUTE(ts_duty)*60)))) AS avgduty ,
																	 SUM(HOUR(ts_ot))+HOUR(SEC_TO_TIME(SUM(MINUTE(ts_ot)*60))) AS ot , 
																	  ROUND(AVG(HOUR(ts_ot))+HOUR(SEC_TO_TIME(AVG(MINUTE(ts_ot)*60)))) AS avgot ,
																	 SUM(HOUR(ts_lunch))+HOUR(SEC_TO_TIME(SUM(MINUTE(ts_lunch)*60))) AS lunch ,
																	 SUM(HOUR(ts_tot_hrs))+HOUR(SEC_TO_TIME(SUM(MINUTE(ts_tot_hrs)*60))) AS total 
																	FROM time_sheet JOIN team b ON b.EmployeeName=ts_name
																	 WHERE STR_TO_DATE(DATE_FORMAT(ts_date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y')  AND b.LeaveApprover_L1='$user' ")->result_array();			
			}
			else{
				return  $this->db->query("SELECT  COUNT(ts_date) AS days,
																	 SUM(HOUR(ts_late))+HOUR(SEC_TO_TIME(SUM(MINUTE(ts_late)*60))) AS late ,
																	SUM(HOUR(ts_duty))+HOUR(SEC_TO_TIME(SUM(MINUTE(ts_duty)*60))) AS duty ,
																	 ROUND(AVG(HOUR(ts_duty))+HOUR(SEC_TO_TIME(AVG(MINUTE(ts_duty)*60)))) AS avgduty ,
																	 SUM(HOUR(ts_ot))+HOUR(SEC_TO_TIME(SUM(MINUTE(ts_ot)*60))) AS ot , 
																	  ROUND(AVG(HOUR(ts_ot))+HOUR(SEC_TO_TIME(AVG(MINUTE(ts_ot)*60)))) AS avgot ,
																	 SUM(HOUR(ts_lunch))+HOUR(SEC_TO_TIME(SUM(MINUTE(ts_lunch)*60))) AS lunch ,
																	 SUM(HOUR(ts_tot_hrs))+HOUR(SEC_TO_TIME(SUM(MINUTE(ts_tot_hrs)*60))) AS total 
																	FROM time_sheet JOIN team b ON b.EmployeeName=ts_name
																	 WHERE b.LeaveApprover_L1='$user' ")->result_array();			
			}
		}

		function team_timesheet_ot($d1,$d2){
			$user=$this->session->userdata('fullname');
			if($d1!='' && $d2!=''){
				return  $this->db->query("SELECT  ts_name AS name,COUNT(ts_date) AS days,
																	 SEC_TO_TIME(SUM(TIME_TO_SEC(ts_late))) AS late ,
																	 SEC_TO_TIME(SUM(TIME_TO_SEC(ts_duty))) AS duty ,
																	 SEC_TO_TIME(AVG(TIME_TO_SEC(ts_duty))) AS avgduty ,
																	 SEC_TO_TIME(SUM(TIME_TO_SEC(ts_ot))) AS ot , 
																	 SEC_TO_TIME(AVG(TIME_TO_SEC(ts_ot))) AS avgot ,
																	 SEC_TO_TIME(SUM(TIME_TO_SEC(ts_lunch))) AS lunch ,
																	 SEC_TO_TIME(SUM(TIME_TO_SEC(ts_tot_hrs))) AS total 
																	FROM time_sheet JOIN team b ON b.EmployeeName=ts_name
																	 WHERE STR_TO_DATE(DATE_FORMAT(ts_date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y')  AND b.LeaveApprover_L1='$user' GROUP BY ts_name")->result_array();			
			}
			else {
				return  $this->db->query("SELECT  ts_name AS name,COUNT(ts_date) AS days,
																	 SEC_TO_TIME(SUM(TIME_TO_SEC(ts_late))) AS late ,
																	 SEC_TO_TIME(SUM(TIME_TO_SEC(ts_duty))) AS duty ,
																	 SEC_TO_TIME(AVG(TIME_TO_SEC(ts_duty))) AS avgduty ,
																	 SEC_TO_TIME(SUM(TIME_TO_SEC(ts_ot))) AS ot , 
																	 SEC_TO_TIME(AVG(TIME_TO_SEC(ts_ot))) AS avgot ,
																	 SEC_TO_TIME(SUM(TIME_TO_SEC(ts_lunch))) AS lunch ,
																	 SEC_TO_TIME(SUM(TIME_TO_SEC(ts_tot_hrs))) AS total 
																	FROM time_sheet JOIN team b ON b.EmployeeName=ts_name
																	 WHERE  b.LeaveApprover_L1='$user' GROUP BY ts_name")->result_array();			

			}
		}
			


		function get_timedate($date)
		{
			return $this->db->query("SELECT  *  FROM time_sheet WHERE ts_date='$date' ORDER BY ts_name ")->result();
		}


		function update_changes($id,$in,$out,$late,$ot,$duty,$total,$lunch){
			$this->db->query("UPDATE time_sheet
														SET ts_intime='$in',
																ts_outtime='$out',
																ts_late='$late',
																ts_duty='$duty',
																ts_ot='$ot',
																ts_tot_hrs='$total',
																ts_lunch='$lunch'
													 WHERE id_timesheet='$id' ");	
				
		}


		function checkDate($d1){
			$user=$this->session->userdata('fullname');
			$data= $this->db->query("SELECT COUNT(ts_date) as date FROM time_sheet WHERE ts_date=STR_TO_DATE(STR_TO_DATE('$d1','%d-%m-%Y'),'%Y-%m-%d') AND ts_name='$user'")->result_array();
			foreach($data as $row){
				$row1=$row["date"];
			}
			return $row1;
		}


		function checkLeave($d1){
			$user=$this->session->userdata('fullname');
			$data= $this->db->query("SELECT COUNT(FromDate) AS 'Count'
																				FROM leavehistory
																				WHERE STR_TO_DATE(STR_TO_DATE('$d1','%d-%m-%Y'),'%Y-%m-%d') BETWEEN FromDate AND ToDate 
																				AND LeaveStatus IN ('2','4') AND User='$user'")->result_array();				
			foreach($data as $row){
				$row1=$row["Count"];
			}
			return $row1;
		}

		function checkLocked($d1){
			$user=$this->session->userdata('fullname');
			$data= $this->db->query("SELECT COUNT(lock_date) AS 'Count'
																				FROM ts_locked_users
																				WHERE lock_date=STR_TO_DATE(STR_TO_DATE('$d1','%d-%m-%Y'),'%Y-%m-%d')  AND lock_name='$user' AND lock_status='0' ")->result_array();				
			foreach($data as $row){
				$row1=$row["Count"];
			}
			return $row1;
		}


		function get_INOUT($d1){
			$number=$this->session->userdata('Emp_Number');
			$data= $this->db->query("SELECT intime,outtime,indate,outdate,totalhrs,dutyhrs,lunch,if(ot>min_OT,ot,'00:00:00') as ot,late
																				FROM
																				(select intime,outtime,DATE(indate) as indate,DATE(outdate) as outdate,totalhrs,dutyhrs,lunch,
																						if(DATE(indate)=DATE(outdate), SUBTIME(totalhrs,duty),
																							if(outtime>param_in,SUBTIME(dutyhrs,ADDTIME(duty,SUBTIME(outtime,param_in))),SUBTIME(dutyhrs,duty))
																						) as ot,min_OT,		
																					if(intime>param_in,SUBTIME(intime,param_in),'00:00:00') late
																												FROM
																													(SELECT CODE, DATE(ENTRY_DATE) AS recdate, sec_to_time(IN_TIME*60) as intime, sec_to_time(OUT_TIME*60) as outtime,
																													ADDTIME(IN_DATE,IN_HOUR) as indate,	ADDTIME(OUT_DATE,OUT_HOUR) as outdate,
																													ADDTIME(IN_DATE,(SELECT in_time FROM parameters)) as paramdate,
																													(SELECT lunch FROM parameters) as lunch,	(SELECT in_time FROM parameters) as param_in,
																													(SELECT duty_hrs FROM parameters) as duty,	(SELECT min_OT FROM parameters) as min_OT,
																													TIMEDIFF(ADDTIME(OUT_DATE,OUT_HOUR),ADDTIME(IN_DATE,IN_HOUR)) as totalhrs,
																													SUBTIME(TIMEDIFF(ADDTIME(OUT_DATE,OUT_HOUR),ADDTIME(IN_DATE,IN_HOUR)),(SELECT lunch FROM parameters)) as dutyhrs
																													FROM time_entry
																													WHERE DATE(ENTRY_DATE)=STR_TO_DATE(STR_TO_DATE('$d1','%d-%m-%Y'),'%Y-%m-%d') AND CODE=(SELECT timeoffice_id FROM admin_users WHERE Emp_Number='$number')) a) b")->result_array();				
			foreach($data as $row){
				$in=$row["intime"];
				$out=$row["outtime"];
				$ind=$row["indate"];
				$outd=$row["outdate"];
				$late=$row["late"];
				$lunch=$row["lunch"];
				$total=$row["totalhrs"];
				$duty=$row["dutyhrs"];
				$ot=$row["ot"];
				$result=$in.','.$out.','.$ind.','.$outd.','.$late.','.$lunch.','.$total.','.$duty.','.$ot;
			}
			if(empty($data)){
				$result='0';
			}
			return $result;
		}


			
		function get_timesheet_Dept($d1,$d2,$dept){
			if($d1!="" && $d2!=""){
				return  $this->db->query("SELECT a.job_no AS num, b.job_desc AS 'desc',
																		COUNT(a.ts_date) AS Days,
																		 SEC_TO_TIME(SUM(TIME_TO_SEC(a.job_time))) AS total,
																		SEC_TO_TIME(AVG(TIME_TO_SEC(a.job_time))) AS 'AVG'
																		FROM time_sheet_jobs a INNER JOIN jobs b ON (a.job_no=b.job_no AND b.name=a.ts_name) INNER JOIN team c ON c.EmployeeName=a.ts_name
																		 WHERE STR_TO_DATE(DATE_FORMAT(a.ts_date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y') AND c.Department='$dept' GROUP BY a.job_no ORDER BY b.addedtime desc")->result_array();			
			}
			else {
				return  $this->db->query("SELECT a.job_no AS num, b.job_desc AS 'desc',
																			COUNT(a.ts_date) AS Days, 
																			SEC_TO_TIME(SUM(TIME_TO_SEC(a.job_time))) AS total,
																			SEC_TO_TIME(AVG(TIME_TO_SEC(a.job_time))) AS 'AVG'
																		FROM time_sheet_jobs a INNER JOIN jobs b ON (a.job_no=b.job_no AND b.name=a.ts_name) INNER JOIN team c ON c.EmployeeName=a.ts_name
																		 WHERE  c.Department='$dept' GROUP BY a.job_no ORDER BY b.addedtime desc")->result_array();			
			}
		}
			
		function get_timesheet_Dept_hrs($d1,$d2,$dept){
			if($d1!="" && $d2!=""){
				return  $this->db->query("SELECT (SELECT COUNT(ts_date) FROM time_sheet WHERE STR_TO_DATE(DATE_FORMAT(ts_date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y') ) AS days,
							                                            				SUM(HOUR(job_time))+HOUR(SEC_TO_TIME(SUM(MINUTE(job_time)*60))) AS total ,
																						ROUND(AVG(HOUR(job_time))+HOUR(SEC_TO_TIME(AVG(MINUTE(job_time)*60)))) AS avg 
																				  FROM time_sheet_jobs  INNER JOIN team c ON c.EmployeeName=ts_name
																		 WHERE STR_TO_DATE(DATE_FORMAT(ts_date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y') AND   c.Department='$dept'")->result_array();		
			}
			else {
				return  $this->db->query("SELECT (SELECT COUNT(ts_date) FROM time_sheet) AS days,
							                                            				SUM(HOUR(job_time))+HOUR(SEC_TO_TIME(SUM(MINUTE(job_time)*60))) AS total ,
																						ROUND(AVG(HOUR(job_time))+HOUR(SEC_TO_TIME(AVG(MINUTE(job_time)*60)))) AS avg 
													                       FROM time_sheet_jobs INNER JOIN team c ON c.EmployeeName=ts_name
							                                                  WHERE  c.Department='$dept' ")->result_array();		
			}
		}

		function get_timesheet_Team($d1,$d2,$team){
			if($d1!="" && $d2!=""){
				return  $this->db->query("SELECT a.job_no AS num, b.job_desc AS 'desc', COUNT(a.ts_date) AS days, SEC_TO_TIME(SUM(TIME_TO_SEC(a.job_time))) AS total,SEC_TO_TIME(AVG(TIME_TO_SEC(a.job_time))) AS 'AVG', COUNT(ts_date) AS Days
																		FROM time_sheet_jobs a INNER JOIN jobs b ON (a.job_no=b.job_no AND b.name=a.ts_name) INNER JOIN team c ON c.EmployeeName=a.ts_name
																		 WHERE STR_TO_DATE(DATE_FORMAT(a.ts_date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y') AND (c.LeaveApprover_L1='$team' OR c.EmployeeName='$team') GROUP BY a.job_no ORDER BY b.addedtime desc")->result_array();			
			}
			else {
				return  $this->db->query("SELECT a.job_no AS num, b.job_desc AS 'desc', COUNT(a.ts_date) AS days, SEC_TO_TIME(SUM(TIME_TO_SEC(a.job_time))) AS total,SEC_TO_TIME(AVG(TIME_TO_SEC(a.job_time))) AS 'AVG', COUNT(ts_date) AS Days
																		FROM time_sheet_jobs a INNER JOIN jobs b ON (a.job_no=b.job_no AND b.name=a.ts_name) INNER JOIN team c ON c.EmployeeName=a.ts_name
																		 WHERE  (c.LeaveApprover_L1='$team' OR c.EmployeeName='$team') GROUP BY a.job_no   ORDER BY b.addedtime desc")->result_array();			
			}
		}
			
		function get_timesheet_Team_hrs($d1,$d2,$team){
			if($d1!="" && $d2!=""){
				return  $this->db->query("SELECT (SELECT COUNT(ts_date) FROM time_sheet WHERE STR_TO_DATE(DATE_FORMAT(ts_date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y') ) AS days,
							                                            				SUM(HOUR(job_time))+HOUR(SEC_TO_TIME(SUM(MINUTE(job_time)*60))) AS total ,
																						ROUND(AVG(HOUR(job_time))+HOUR(SEC_TO_TIME(AVG(MINUTE(job_time)*60)))) AS avg 
													                               FROM time_sheet_jobs  INNER JOIN team c ON c.EmployeeName=ts_name
																			 WHERE STR_TO_DATE(DATE_FORMAT(ts_date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y') AND   (c.LeaveApprover_L1='$team' OR c.EmployeeName='$team') ")->result_array();		
			}
			else {
				return  $this->db->query("SELECT (SELECT COUNT(ts_date) FROM time_sheet) AS days,
							                                            				SUM(HOUR(job_time))+HOUR(SEC_TO_TIME(SUM(MINUTE(job_time)*60))) AS total ,
																						ROUND(AVG(HOUR(job_time))+HOUR(SEC_TO_TIME(AVG(MINUTE(job_time)*60)))) AS avg 
											                                    FROM time_sheet_jobs INNER JOIN team c ON c.EmployeeName=ts_name
							                                           	       WHERE  (c.LeaveApprover_L1='$team'  OR c.EmployeeName='$team' )")->result_array();		
			}
		}


		function timesheet_team_job($d1,$d2,$num,$team){
				
			if($d1!="" && $d2!=""){
				return  $this->db->query("SELECT a.job_no AS num, b.job_desc AS 'desc', a.ts_name AS name, COUNT(a.ts_date) AS days, SEC_TO_TIME(SUM(TIME_TO_SEC(a.job_time))) AS total,SEC_TO_TIME(AVG(TIME_TO_SEC(a.job_time))) AS 'avg'
																								FROM time_sheet_jobs a INNER JOIN jobs b ON (a.job_no=b.job_no AND b.name=a.ts_name) JOIN team c ON c.EmployeeName=a.ts_name
																	 							WHERE STR_TO_DATE(DATE_FORMAT(a.ts_date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y') AND a.job_no='$num' AND (c.LeaveApprover_L1='$team' OR c.EmployeeName='$team') GROUP BY a.ts_name ORDER BY c.Designation")->result_array();			
					
			}
			else {
				return  $this->db->query("SELECT a.job_no AS num, b.job_desc AS 'desc', a.ts_name AS name, COUNT(a.ts_date) AS days,
										                                 SEC_TO_TIME(SUM(TIME_TO_SEC(a.job_time))) AS total, SEC_TO_TIME(AVG(TIME_TO_SEC(a.job_time))) AS 'avg' 
										                              FROM time_sheet_jobs a INNER JOIN jobs b ON (a.job_no=b.job_no AND b.name=a.ts_name)  JOIN team c ON c.EmployeeName=a.ts_name
																	 WHERE  a.job_no='$num' AND (c.LeaveApprover_L1='$team' OR c.EmployeeName='$team')
																	 GROUP BY a.ts_name ORDER BY c.Designation")->result_array();			
			}

		}


		function timesheet_team_job_hrs($d1,$d2,$num,$team){

			if($d1!="" && $d2!=""){
				return  $this->db->query("SELECT (SELECT COUNT(ts_date) FROM time_sheet WHERE STR_TO_DATE(DATE_FORMAT(ts_date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y') ) AS days,
							                                            				SUM(HOUR(job_time))+HOUR(SEC_TO_TIME(SUM(MINUTE(job_time)*60))) AS total ,
																						ROUND(AVG(HOUR(job_time))+HOUR(SEC_TO_TIME(AVG(MINUTE(job_time)*60)))) AS avg 
															           FROM time_sheet_jobs JOIN team b ON b.EmployeeName=ts_name
																	  WHERE STR_TO_DATE(DATE_FORMAT(ts_date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y') AND job_no='$num' AND (b.LeaveApprover_L1='$team' OR b.EmployeeName='$team')")->result_array();			
					
			}
			else {
				return  $this->db->query("SELECT (SELECT COUNT(ts_date) FROM time_sheet  ) AS days,
							                                            				SUM(HOUR(job_time))+HOUR(SEC_TO_TIME(SUM(MINUTE(job_time)*60))) AS total ,
																						ROUND(AVG(HOUR(job_time))+HOUR(SEC_TO_TIME(AVG(MINUTE(job_time)*60)))) AS avg 
												                                  FROM time_sheet_jobs JOIN team b ON b.EmployeeName=ts_name
																				 WHERE  job_no='$num' AND (b.LeaveApprover_L1='$team' OR b.EmployeeName='$team')")->result_array();			
			}
		}

			

		function update_timeoffice($id,$date1,$date2,$in,$out){

			return  $this->db->query("INSERT INTO time_entry(COMPCODE,CODE,ENTRY_DATE,IN_TIME,OUT_TIME,IN_HOUR,OUT_HOUR,IN_DATE,OUT_DATE)
 																VALUES('C0001','$id',CONCAT(STR_TO_DATE(STR_TO_DATE('$date1','%d-%m-%Y'),'%Y-%m-%d'),' 00:00:00'),ROUND(time_to_sec('$in')/60,0),ROUND(time_to_sec('$out')/60,0),
																	'$in','$out',CONCAT(STR_TO_DATE(STR_TO_DATE('$date1','%d-%m-%Y'),'%Y-%m-%d'),' 00:00:00'),CONCAT('$date2',' 00:00:00'))");
		}
			

			
		function get_timeofficeID($date){

			return $this->db->query("SELECT Emp_Name,timeoffice_id,'$date' as outdate FROM admin_users WHERE user_role NOT IN ('MD','Admin') AND timeoffice_id NOT IN (SELECT CODE FROM time_entry WHERE STR_TO_DATE(DATE_FORMAT(ENTRY_DATE,'%d-%m-%Y'),'%d-%m-%Y')=STR_TO_DATE('$date','%d-%m-%Y'))")->result();
				
		}

			
		function timesheet_job_activity_emp($d1,$d2,$user){
			if($d1!='' && $d2!=''){
				return  $this->db->query("SELECT *,a.job_desc,b.desc,DATE_FORMAT(c.ts_date,'%d-%m-%Y') as date1
					     				FROM time_sheet_jobs c INNER JOIN jobs a ON (a.job_no=c.job_no AND a.name=ts_name) INNER JOIN activity_code b ON b.code=activity
					     				WHERE STR_TO_DATE(DATE_FORMAT(c.ts_date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y')  AND ts_name='$user'  ORDER BY ts_date DESC")->result_array();			
					
			}
			else{
				return  $this->db->query("SELECT *,a.job_desc,b.desc,DATE_FORMAT(c.ts_date,'%d-%m-%Y') as date1
					     				FROM time_sheet_jobs c INNER JOIN jobs a ON (a.job_no=c.job_no AND a.name=ts_name) INNER JOIN activity_code b ON b.code=activity
					     				WHERE  ts_name='$user'  ORDER BY ts_date DESC")->result_array();			
					
			}
		}

		function timesheet_job_activity_emp_hrs($d1,$d2,$user){
			if($d1!='' && $d2 != ''){
				return  $this->db->query("SELECT COUNT(days1) as days,
																			(SELECT 	SUM(HOUR(job_time))+HOUR(SEC_TO_TIME(SUM(MINUTE(job_time)*60))) as  total
																			FROM time_sheet_jobs WHERE   STR_TO_DATE(DATE_FORMAT(ts_date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y')   AND ts_name='$user' ) as total
																	
																	FROM (SELECT  COUNT(ts_date) AS days1
																								FROM time_sheet_jobs
										     													WHERE STR_TO_DATE(DATE_FORMAT(ts_date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y')  AND ts_name='$user' GROUP BY ts_date ) a  ")->result_array();	
			}
			else {
				return  $this->db->query("SELECT COUNT(days1) as days,
																			(SELECT 	SUM(HOUR(job_time))+HOUR(SEC_TO_TIME(SUM(MINUTE(job_time)*60))) as  total
																			FROM time_sheet_jobs WHERE ts_name='$user' ) as total
																	
																	FROM (SELECT  COUNT(ts_date) AS days1
																								FROM time_sheet_jobs
										     													WHERE  ts_name='$user' GROUP BY ts_date ) a  ")->result_array();			
			}
		}
			

		function timesheet_job_activity_user($d1,$d2){
			$user=$this->session->userdata('fullname');
			if($d1!='' && $d2 != ''){
				return  $this->db->query("SELECT *,a.job_desc,b.desc,DATE_FORMAT(c.ts_date,'%d-%m-%Y') as date1
					     				FROM time_sheet_jobs c INNER JOIN jobs a  ON (a.job_no=c.job_no AND a.name=ts_name) INNER JOIN activity_code b ON b.code=activity
					     				WHERE STR_TO_DATE(DATE_FORMAT(c.ts_date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y')  AND ts_name='$user'  ORDER BY ts_date DESC")->result_array();			
					
			}
			else {
					
				return  $this->db->query("SELECT *,a.job_desc,b.desc,DATE_FORMAT(c.ts_date,'%d-%m-%Y') as date1
					     				FROM time_sheet_jobs c INNER JOIN jobs a ON (a.job_no=c.job_no AND a.name=ts_name)  INNER JOIN activity_code b ON b.code=activity
					     				WHERE  ts_name='$user'  ORDER BY ts_date DESC")->result_array();			
					
			}
		}

		function timesheet_job_activity_user_hrs($d1,$d2){
			$user=$this->session->userdata('fullname');
			if($d1!='' && $d2 != ''){
				return  $this->db->query("SELECT COUNT(days1) as days,
																			(SELECT 	SUM(HOUR(job_time))+HOUR(SEC_TO_TIME(SUM(MINUTE(job_time)*60))) as  total
																			FROM time_sheet_jobs WHERE  STR_TO_DATE(DATE_FORMAT(ts_date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y') AND  ts_name='$user' ) as total
																	
																	FROM (SELECT  COUNT(ts_date) AS days1
																								FROM time_sheet_jobs
										     													WHERE STR_TO_DATE(DATE_FORMAT(ts_date,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y') AND ts_name='$user' GROUP BY ts_date ) a  ")->result_array();	
			}
			else {
				return  $this->db->query("SELECT COUNT(days1) as days,
																			(SELECT 	SUM(HOUR(job_time))+HOUR(SEC_TO_TIME(SUM(MINUTE(job_time)*60))) as  total
																			FROM time_sheet_jobs WHERE ts_name='$user' ) as total
																	
																	FROM (SELECT  COUNT(ts_date) AS days1
																								FROM time_sheet_jobs
										     													WHERE  ts_name='$user' GROUP BY ts_date ) a  ")->result_array();			
			}
		}
			
			
		
			
		
	


		function showLeaves_emp($d1,$d2,$user){
			if($d1!="" && $d2!=""){
				return $this->db->query("SELECT date1,days,dayname1
																	FROM 
																	(SELECT DATE_FORMAT(FromDate,'%d-%m-%Y') as date1 ,TotalDays as days, DAYNAME(SUBSTRING(FromDate,1,10)) as dayname1 FROM leavehistory WHERE User='$user' AND STR_TO_DATE(DATE_FORMAT(FromDate,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y') ) a ")->result_array();
			}
			else{
				return $this->db->query("SELECT date1,days,dayname1
																	FROM 
																	(SELECT DATE_FORMAT(FromDate,'%d-%m-%Y') as date1 ,TotalDays as days, DAYNAME(SUBSTRING(FromDate,1,10)) as dayname1 FROM leavehistory WHERE User='$user'  ) a ")->result_array();

			}
		}
			

		function showLeaves_user($d1,$d2){
			$user=$this->session->userdata('fullname');
			if($d1!="" && $d2!=""){
				return $this->db->query("SELECT date1,days,dayname1
																	FROM 
																	(SELECT DATE_FORMAT(FromDate,'%d-%m-%Y') as date1 ,TotalDays as days, DAYNAME(FromDate) as dayname1 FROM leavehistory WHERE User='$user' AND STR_TO_DATE(DATE_FORMAT(FromDate,'%d-%m-%Y'),'%d-%m-%Y') BETWEEN STR_TO_DATE('$d1','%d-%m-%Y') AND STR_TO_DATE('$d2','%d-%m-%Y') ) a ")->result_array();
			}
			else{
				return $this->db->query("SELECT date1,days,dayname1
																	FROM 
																	(SELECT DATE_FORMAT(FromDate,'%d-%m-%Y') as date1 ,TotalDays as days, DAYNAME(FromDate) as dayname1 FROM leavehistory WHERE User='$user'  ) a ")->result_array();

			}
		}
		function fetch_all_users(){
			return $this->db->query("SELECT DISTINCT name AS 'Name' FROM  admin_users where user_role !='MD' ")->result_array();
		}
		function fetch_MD_mail_id(){
			$data=$this->db->query("SELECT  email  FROM  admin_users where user_role ='MD' and user_email != 'default' ")->result_array();
			foreach($data as $row)
			{
				return $row['email'];
			}
		}
		function fetch_unfollowers_timesheet($uname)
		{
			$timesheet='';
			$timeentry='';
			$timesheet_details=$this->db->query("SELECT TS.TS_NAME,COUNT(TS_DATE)  AS TIMESHEET_DAYS
												FROM TIME_SHEET TS join ADMIN_USERS AU
												ON(TS.TS_NAME=AU.EMP_NAME)
												WHERE TS_DATE BETWEEN (
												SELECT DATE_SUB(CURRENT_DATE, INTERVAL( DAYOFWEEK(CURRENT_DATE)+6 ) DAY) AS  'LASTWEEK_START')AND (
												SELECT DATE_SUB( CURRENT_DATE, INTERVAL DAYOFWEEK( CURRENT_DATE ) DAY ) AS  'LASTWEEK_END') AND AU.EMP_NAME ='$uname'
												GROUP BY TS.TS_NAME")->result_array();	
			$timeentry_details=$this->db->query("SELECT AU.EMP_NAME AS NAME,COUNT( IN_DATE ) AS 'INDATE'
												FROM TIME_ENTRY TE JOIN ADMIN_USERS AU ON ( TE.CODE = AU.TIMEOFFICE_ID ) 
												WHERE IN_DATE BETWEEN (
												SELECT DATE_SUB( CURRENT_DATE, INTERVAL( DAYOFWEEK( CURRENT_DATE ) +6 ) DAY ) AS  'LASTWEEK_START')
												AND (SELECT DATE_SUB( CURRENT_DATE, INTERVAL DAYOFWEEK( CURRENT_DATE ) DAY ) AS  'LASTWEEK_END') AND AU.EMP_NAME ='$uname'
												GROUP BY AU.EMP_NAME")->result_array();	
				
			foreach($timesheet_details as $tsd)
			{
				$timesheet=$tsd['TIMESHEET_DAYS'];
			}
			foreach($timeentry_details as $ted)
			{
				$timeentry=$ted['INDATE'];
			}
			if ($timesheet >= $timeentry && $timesheet !=0 && $timeentry !=0)
			{
				return "*".$uname;
			}else
			{
				return "^".$uname;
			}
		}
		function fetch_unfollowers_mail_id($name)
		{
			$data=$this->db->query("SELECT email FROM `admin_users` where EMP_NAME='$name'")->result_array();
			foreach($data as $row)
			{
				return $row['email'];
			}
		}
		function fetch_followers_mail_id($name)
		{
			$data=$this->db->query("SELECT email FROM `admin_users` where EMP_NAME='$name'")->result_array();
			foreach($data as $row)
			{
				return $row['email'];
			}
		}
		function fetch_info_mail_id()
		{
			$data=$this->db->query("SELECT email FROM `admin_users` where user_role='admin'")->result_array();
			foreach($data as $row)
			{
				return $row['email'];
			}
		}
			

			
			
			
		function get_locked_users($year,$month){
			return  $this->db->query("SELECT * FROM ts_locked_users WHERE YEAR(lock_date)='$year' AND MONTHNAME(lock_date)='$month' AND lock_status='0'")->result();
		}
			
		function get_locked_user($year,$month,$user){
			return $this->db->query("SELECT * FROM ts_locked_users WHERE YEAR(lock_date)='$year' AND MONTHNAME(lock_date)='$month' AND lock_name='$user' AND lock_status='0' ")->result();
		}


		function unlock_timesheet($id){
			$this->db->query("UPDATE ts_locked_users SET  lock_status='1' WHERE lock_id='$id' ");
		}
		//Modified by Sakthivel.k On 27.03.2014

		function fetch_unfollowers_details($uname)
		{
			$timesheet='';
			$timeentry='';


			$timesheet_details=$this->db->query("SELECT TS.TS_NAME,COUNT(TS_DATE)  AS TIMESHEET_DAYS
												FROM TIME_SHEET TS join ADMIN_USERS AU
												ON(TS.TS_NAME=AU.EMP_NAME)
												WHERE TS_DATE BETWEEN (
												SELECT DATE_SUB(CURRENT_DATE, INTERVAL( DAYOFWEEK(CURRENT_DATE)+6 ) DAY) AS  'LASTWEEK_START')AND (
												SELECT DATE_SUB( CURRENT_DATE, INTERVAL DAYOFWEEK( CURRENT_DATE ) DAY ) AS  'LASTWEEK_END') AND AU.EMP_NAME ='$uname'
												GROUP BY TS.TS_NAME")->result_array();	
			$timeentry_details=$this->db->query("SELECT AU.EMP_NAME AS NAME,COUNT( IN_DATE ) AS 'INDATE'
												FROM TIME_ENTRY TE JOIN ADMIN_USERS AU ON ( TE.CODE = AU.TIMEOFFICE_ID ) 
												WHERE IN_DATE BETWEEN (
												SELECT DATE_SUB( CURRENT_DATE, INTERVAL( DAYOFWEEK( CURRENT_DATE ) +6 ) DAY ) AS  'LASTWEEK_START')
												AND (SELECT DATE_SUB( CURRENT_DATE, INTERVAL DAYOFWEEK( CURRENT_DATE ) DAY ) AS  'LASTWEEK_END') AND AU.EMP_NAME ='$uname'
												GROUP BY AU.EMP_NAME")->result_array();	
				
			foreach($timesheet_details as $tsd)
			{
				$timesheet=$tsd['TIMESHEET_DAYS'];
			}
			foreach($timeentry_details as $ted)
			{
				$timeentry=$ted['INDATE'];
			}
			if ($timesheet >= $timeentry && $timesheet !=0 && $timeentry !=0)
			{
				//return "*".$uname;//followers
			}else
			{
				$timesheet_date_details="";
				$timesheet_unfollowers=$this->db->query("SELECT AU.EMP_NAME AS NAME, date(IN_DATE) AS 'INDATE'
														FROM TIME_ENTRY TE JOIN ADMIN_USERS AU ON ( TE.CODE = AU.TIMEOFFICE_ID )
														WHERE IN_DATE BETWEEN (
														SELECT DATE_SUB( CURRENT_DATE, INTERVAL( DAYOFWEEK( CURRENT_DATE ) +6 ) DAY ) AS 'LASTWEEK_START')
														AND (SELECT DATE_SUB( CURRENT_DATE, INTERVAL DAYOFWEEK( CURRENT_DATE ) DAY ) AS  'LASTWEEK_END')   AND AU.EMP_NAME ='$uname' AND IN_DATE NOT IN (SELECT  TS_DATE
														FROM TIME_SHEET TS join ADMIN_USERS AU
														ON(TS.TS_NAME=AU.EMP_NAME)
														WHERE TS_DATE BETWEEN (SELECT DATE_SUB(CURRENT_DATE, INTERVAL( DAYOFWEEK(CURRENT_DATE)+6 ) DAY) AS  'LASTWEEK_START')AND (
														SELECT DATE_SUB( CURRENT_DATE, INTERVAL DAYOFWEEK( CURRENT_DATE ) DAY ) AS  'LASTWEEK_END') AND AU.EMP_NAME ='$uname')
														Order by INDATE DESC");
					
				//$timeentry_date_details=$timeentry_date_details.$timeentry_unfollowers_date."^".$timeentry_unfollowers_name;
				if($timesheet_unfollowers->num_rows() != 0)
				{
					foreach($timesheet_unfollowers->result_array() as $tsuf)
					{
						$timesheet_date=$tsuf['INDATE'];
						$timesheet_name=$tsuf['NAME'];
						$today=date('Y-m-d H:i:s');
						$timesheet_date_details=$timesheet_date_details.$timesheet_date."?".$timesheet_name;
						$this->db->query("INSERT INTO ts_locked_users(lock_date,lock_name,locked_on,lock_status)
						 							 VALUES('$timesheet_date','$timesheet_name','$today','0')");
					}
						
						
				}
				return $timesheet_date_details;
					
			}
		}
			
		function Fetch_Lastweek_Details()
		{
			$Lastweek_Details=$this->db->query("SELECT substring(DATE_SUB(CURRENT_DATE, INTERVAL( DAYOFWEEK(CURRENT_DATE)+6 ) DAY),9,2) AS  'LASTWEEK_START',
											substring(DATE_SUB( CURRENT_DATE, INTERVAL DAYOFWEEK( CURRENT_DATE ) DAY ) ,9,2)AS  'LASTWEEK_END',
											left(MONTHNAME(STR_TO_DATE(Month(CURRENT_DATE), '%m')),3) as MONTH ")->result_array();	
			foreach($Lastweek_Details as $row)
			{
				$start=$row['LASTWEEK_START'];
				$end=$row['LASTWEEK_END'];
				$month=$row['MONTH'];
			}
			return $month." "."(".$start."-".$end.")";
		}
		function Fetch_Lastweek_Leavesummary()
		{
			$LeaveSummary=$this->db->query("SELECT USER,LEAVETYPE,FROMDATE,TOTALDAYS
											FROM LEAVEHISTORY
											WHERE  SUBSTRING(FromDate,1,10)  BETWEEN (SELECT DATE_SUB(CURRENT_DATE, INTERVAL( DAYOFWEEK(CURRENT_DATE)+6 ) DAY) AS  'LASTWEEK_START')AND (
														SELECT DATE_SUB( CURRENT_DATE, INTERVAL DAYOFWEEK( CURRENT_DATE ) DAY ) AS  'LASTWEEK_END')
                               							AND SUBSTRING(ToDate,1,10) BETWEEN (SELECT DATE_SUB(CURRENT_DATE, INTERVAL( DAYOFWEEK(CURRENT_DATE)+6 ) DAY) AS  'LASTWEEK_START')AND (
														SELECT DATE_SUB( CURRENT_DATE, INTERVAL DAYOFWEEK( CURRENT_DATE ) DAY ) AS  'LASTWEEK_END')
      													AND LEAVESTATUS IN ('2','4')
      										ORDER BY FROMDATE ")->result_array();	
			return 	$LeaveSummary;
		}
			
}
?>