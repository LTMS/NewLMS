<?php
Class overtime_model extends CI_Model{
	function _construct()
	{
		parent::_construct();
	}


	function get_ack_members(){
		return $this->db->query("SELECT DISTINCT EmployeeName AS 'Name' FROM  ot_acknowledge ORDER BY EmployeeName")->result_array();
	}
	function get_deptartments()
	{
		return $this->db->query("SELECT DISTINCT Department FROM team ORDER BY Department ")->result_array();
	}
	function get_leave_members(){
		return $this->db->query("SELECT DISTINCT Emp_Name AS 'Name' FROM  admin_users WHERE Emp_role NOT IN ('MD') ORDER BY name")->result_array();
	}

	function get_years()
	{
		return $this->db->query("SELECT  DISTINCT YEAR(ts_date) AS 'year' FROM time_sheet ORDER BY year ")->result_array();
	}
	function get_admin_normal_ot($d1,$d2,$user){
			
		return $this->db->query("SELECT totaldays,total,(holidays+sundays) as holidays,dutyhrs,leaves,  (totaldays-(holidays+leaves+sundays)) as wdays, tsdate,
																		  IFNULL(SUM((HOUR(dutyhrs))* (totaldays-(holidays+leaves+sundays)))+HOUR(SEC_TO_TIME(SUM(MINUTE(dutyhrs)*60* (totaldays-(holidays+leaves+sundays))))),'0') as  exp
																		  																	
																		  FROM (SELECT  (DATEDIFF('$d2','$d1')+1) as totaldays,COUNT(ts_date) as tsdate,
																		 		 IFNULL(SUM(HOUR(ts_duty))+HOUR(SEC_TO_TIME(SUM(MINUTE(ts_duty)*60))),'0') as  total, 
																				 IFNULL((SELECT DISTINCT COUNT(holi_date) FROM holidays WHERE  holi_date BETWEEN '$d1' AND '$d2'),'0')  as holidays,
																			(select COUNT(DATE_ADD('$d1', INTERVAL ROW DAY))
																		  	 FROM
																			(SELECT @row := @row + 1 as row FROM 	(select 0 union all select 1 union all select 3 	union all select 4 union all select 5 union all select 6) t1,
																						(select 0 union all select 1 union all select 3 union all select 4 union all select 5 union all select 6) t2,
																				   (select 0 union all select 1 union all select 3 union all select 4 union all select 5 union all select 6) t4,
																				   (select 0 union all select 1 union all select 3 union all select 4 union all select 5 union all select 6) t5,
																					(SELECT @row:=-1) t3 limit 366
																				) b
																		WHERE		DATE_ADD('$d1', INTERVAL ROW DAY)
																		BETWEEN '$d1' and '$d2' AND DAYOFWEEK(DATE_ADD('$d1', INTERVAL ROW DAY))=1) as sundays	,
																				 (SELECT SUBTIME(duty_hrs,lunch) FROM parameters) as dutyhrs,
																				 IFNULL((SELECT SUM(TotalDays)  FROM leavehistory WHERE LeaveType!='Comp_Off' AND LeaveStatus IN ('2','4') AND User='$user' AND FromDate BETWEEN '$d1' AND '$d2'),'0') as leaves
																				 FROM time_sheet 
																				 WHERE ts_date BETWEEN '$d1' AND '$d2' AND ts_name='$user') a ")->result_array();
	}


		
	function get_days($d1,$d2,$user){
			
		return $this->db->query("SELECT DISTINCT COUNT(ENTRY_DATE) as days
																			 FROM time_entry 
																			 WHERE CODE=(SELECT timeoffice_id FROM admin_users WHERE Emp_Name='$user') 
																			 AND DATE(ENTRY_DATE) BETWEEN '$d1' AND '$d2'")->result_array();
	}

	function get_CompOff_Hours($d1,$d2,$user){
		return $this->db->query("SELECT HOUR(SEC_TO_TIME((COUNT(FromDate)*TIME_TO_SEC((SELECT comp_off_reduct FROM parameters))))) as Comp_Off_hours,COUNT(FromDate) as CO_Count
																						FROM leavehistory 
																						WHERE ((FromDate BETWEEN '$d1' AND '$d2' ) OR (ToDate BETWEEN '$d1' AND '$d2' )) 
																						AND User='$user' AND LeaveType='Comp_Off'")->result_array();
			
			
	}






	function dept_work_details($d1,$d2,$DEPT)
	{
			
		return $this->db->query("SELECT a.EmployeeName as Emp,IFNULL(tab.leaves,0) as Leaves,IFNULL(Ent.Entry,0) as Entry,IFNULL(Tmt.Timesheet,0) as Timesheet
											FROM team a left outer JOIN (SELECT t.EmployeeName as name,count(l.leaveid) AS LEAVES
											FROM departments D Left outer join team t
											On(D.department=t.department)
											Left outer join leavehistory l
											On(t.EmployeeName=l.user)
											WHERE l.LeaveType!='Comp_Off' AND l.leavestatus IN ('2','4') AND D.department = '$DEPT' AND l.FromDate BETWEEN '$d1' AND '$d2'
											GROUP BY t.EmployeeName)  tab
											ON (a.EmployeeName=tab.name)
											LEFT OUTER JOIN (SELECT t.EmployeeName as Employee,t.Department,au.timeoffice_id,cod.Entry
											FROM team t Left outer join admin_users au
											on(t.EmployeeName=au.Emp_Name)
											Left outer join(SELECT CODE,COUNT(ENTRY_DATE) AS ENTRY
											FROM time_entry t
											WHERE DATE(ENTRY_DATE) BETWEEN '$d1' AND '$d2'
											Group By CODE) cod
											ON(au.timeoffice_id=cod.code)
											where t.department='$DEPT') Ent
											ON(a.EmployeeName=Ent.Employee)
											LEFT OUTER JOIN (SELECT t.EmployeeName as EmployeeN,tst.timesheet as Timesheet
											from team t LEFT OUTER JOIN (SELECT ts.ts_name as name,count(ts.ts_date) as Timesheet
											FROM time_sheet ts
											WHERE DATE(ts.ts_date) BETWEEN '$d1' AND '$d2'
											group by ts.ts_name) tst
											on(t.EmployeeName=tst.name)
											where t.Department= '$DEPT') Tmt
											ON(a.EmployeeName=Tmt.EmployeeN)
											WHERE a.department = '$DEPT';")->result_array();
	}



	function user_work_details($name,$d1,$d2)
	{
		return $this->db->query("SELECT totaldays,total,(holidays+sundays) as holidays,dutyhrs,leaves, (totaldays-(holidays+leaves+sundays)) as wdays, tsdate,
										IFNULL(SUM((HOUR(dutyhrs))* (totaldays-(holidays+leaves+sundays)))+HOUR(SEC_TO_TIME(SUM(MINUTE(dutyhrs)*60* (totaldays-(holidays+leaves+sundays))))),'0') as exp
										
										FROM (SELECT (DATEDIFF('$d2','$d1')+1) as totaldays,COUNT(ts_date) as tsdate,
										IFNULL(SUM(HOUR(ts_duty))+HOUR(SEC_TO_TIME(SUM(MINUTE(ts_duty)*60))),'0') as total,
										IFNULL((SELECT DISTINCT COUNT(holi_date) FROM holidays WHERE holi_date BETWEEN '$d1' AND '$d2'),'0') as holidays,
										(select COUNT(DATE_ADD('$d1', INTERVAL ROW DAY))
										FROM
										(SELECT @row := @row + 1 as row FROM (select 0 union all select 1 union all select 3 union all select 4 union all select 5 union all select 6) t1,
										(select 0 union all select 1 union all select 3 union all select 4 union all select 5 union all select 6) t2,
									   (select 0 union all select 1 union all select 3 union all select 4 union all select 5 union all select 6) t4,
									   (select 0 union all select 1 union all select 3 union all select 4 union all select 5 union all select 6) t5,
										(SELECT @row:=-1) t3 limit 366
										) b
										WHERE	 DATE_ADD('$d1', INTERVAL ROW DAY)
										BETWEEN '$d1' and '$d2' AND DAYOFWEEK(DATE_ADD('$d1', INTERVAL ROW DAY))=1) as sundays	,
										(SELECT SUBTIME(duty_hrs,lunch) FROM parameters) as dutyhrs,
										IFNULL((SELECT SUM(TotalDays) FROM leavehistory WHERE LeaveType!='Comp_Off' AND LeaveStatus IN ('2','4') AND User='$name' AND FromDate BETWEEn '$d1' AND '$d2'),'0') as leaves
										FROM time_sheet
										WHERE ts_date BETWEEN '$d1' AND '$d2' AND ts_name='$name') a")->result_array();	
	}


	function get_employee_total_ot($user){
			
		return $this->db->query("SELECT totaldays,total,(holidays+sundays) as holidays,dutyhrs,leaves,  (totaldays-(holidays+leaves+sundays)) as wdays, tsdate,
																		  IFNULL(SUM((HOUR(dutyhrs))* (totaldays-(holidays+leaves+sundays)))+HOUR(SEC_TO_TIME(SUM(MINUTE(dutyhrs)*60* (totaldays-(holidays+leaves+sundays))))),'0') as  exp
																		  																	
																		  FROM (SELECT  (DATEDIFF('$d2','$d1')+1) as totaldays,COUNT(ts_date) as tsdate,
																		 		 IFNULL(SUM(HOUR(ts_duty))+HOUR(SEC_TO_TIME(SUM(MINUTE(ts_duty)*60))),'0') as  total, 
																				 IFNULL((SELECT DISTINCT COUNT(holi_date) FROM holidays WHERE  holi_date BETWEEN '$d1' AND '$d2'),'0')  as holidays,
																			(select COUNT(DATE_ADD('$d1', INTERVAL ROW DAY))
																		  	 FROM
																			(SELECT @row := @row + 1 as row FROM 	(select 0 union all select 1 union all select 3 	union all select 4 union all select 5 union all select 6) t1,
																					(select 0 union all select 1 union all select 3 union all select 4 union all select 5 union all select 6) t2,
																				   (select 0 union all select 1 union all select 3 union all select 4 union all select 5 union all select 6) t4,
																				   (select 0 union all select 1 union all select 3 union all select 4 union all select 5 union all select 6) t5,
																					(SELECT @row:=-1) t3 limit 366
																				) b
																		WHERE		DATE_ADD('$d1', INTERVAL ROW DAY)
																		BETWEEN '$d1' and '$d2' AND DAYOFWEEK(DATE_ADD('$d1', INTERVAL ROW DAY))=1) as sundays	,
																				 (SELECT SUBTIME(duty_hrs,lunch) FROM parameters) as dutyhrs,
																				 IFNULL((SELECT SUM(TotalDays)  FROM leavehistory WHERE LeaveType!='Comp_Off' AND LeaveStatus IN ('2','4') AND User='$user' AND FromDate BETWEEN '$d1' AND '$d2'),'0') as leaves
																				 FROM time_sheet 
																				 WHERE ts_date BETWEEN '$d1' AND '$d2' AND ts_name='$user') a ")->result_array();
	}
		


	function acknowledge_OT($user,$d1,$d2,$ot_hrs,$amount){
		$by=$this->session->userdata('fullname');
			
		$this->db->query(" INSERT INTO ot_acknowledge
																	SET EmployeeName='$user',
																			Ack_From='$d1',
																			Ack_To='$d2',
																			Ack_Hours='$ot_hrs' ,
																			Ack_Amount='$amount' ,
																			Ack_By='$by'");
			
			
			
	}


	function check_acknowledged($user,$d1,$d2){
			
		return $this->db->query("SELECT COUNT(Ack_id) as count, MONTHNAME(Ack_From) as FromMonth, MONTHNAME(Ack_To) as ToMonth
																				FROM ot_acknowledge
																				WHERE ((Ack_From BETWEEN '$d1' AND '$d2' ) OR (Ack_To BETWEEN '$d1' AND '$d2' )) 
																						AND EmployeeName='$user' ")->result_array();
	}

	function ack_history_emp($user,$year){
			
		return $this->db->query("SELECT Ack_id, EmployeeName, MONTHNAME( Ack_From) as FromMonth, MONTHNAME(Ack_To) as ToMonth, Ack_Hours, DATE(Ack_on) as Ack_on, Ack_By,Ack_Amount 	FROM ot_acknowledge
																				WHERE (YEAR(Ack_From)='$year' OR  YEAR(Ack_To)='$year') 
																						AND EmployeeName='$user' ORDER BY Ack_From,EmployeeName")->result_array();
	}

	function ack_history_dept($dept,$d1,$d2){
			
		return $this->db->query("SELECT DISTINCT a.Ack_id, a.EmployeeName, MONTHNAME( a.Ack_From) as FromMonth, MONTHNAME(a.Ack_To) as ToMonth, a.Ack_Hours, DATE(a.Ack_on) as Ack_on, a.Ack_By,a.Ack_Amount,b.Department as Dept
																			 	FROM ot_acknowledge a INNER JOIN team b on a.EmployeeName=b.EmployeeName
																				WHERE ((a.Ack_From BETWEEN '$d1' AND '$d2' ) OR (a.Ack_To BETWEEN '$d1' AND '$d2' )) 
																					AND b.Department='$dept' ORDER BY a.Ack_From,a.EmployeeName")->result_array();
	}

	function cancel_Acknowledged($id){
		$this->db->query("DELETE FROM ot_acknowledge WHERE Ack_id='$id' ");
	}

	function get_my_normal_ot($y,$m){
		$user=$this->session->userdata('fullname');
		return $this->db->query("SELECT ts_date,ts_ot FROM time_sheet WHERE YEAR(ts_date)='$y' AND MONTHName(ts_date)='$m' AND ts_name='$user' AND DAYNAME(ts_date)!='Sunday' AND ts_ot!='00:00:00' AND ts_date NOT IN (SELECT holi_date FROM holidays) AND ts_ot!='00:00:00' ORDER BY ts_date")->result_array();
	}
		
	function get_my_holiday_ot($y,$m){
		$user=$this->session->userdata('fullname');
		return $this->db->query("SELECT ts_date,ts_duty FROM time_sheet  WHERE YEAR(ts_date)='$y' AND MONTHName(ts_date)='$m' AND (DAYNAME(ts_date)='Sunday' OR ts_date IN (SELECT holi_date FROM holidays)) AND ts_name='$user' ORDER BY ts_date ")->result_array();
	}
		
	function get_my_normal_ot_hrs($y,$m){
		$user=$this->session->userdata('fullname');
		return $this->db->query("SELECT SEC_TO_TIME(SUM(time_to_sec(ts_ot))) AS total  FROM time_sheet WHERE YEAR(ts_date)='$y' AND MONTHName(ts_date)='$m' AND ts_name='$user' AND DAYNAME(ts_date)!='Sunday' AND ts_ot!='00:00:00' AND ts_date NOT IN (SELECT holi_date FROM holidays)")->result_array();
	}
		
	function get_my_holiday_ot_hrs($y,$m){
		$user=$this->session->userdata('fullname');
		return $this->db->query("SELECT SEC_TO_TIME(SUM(time_to_sec(ts_duty))) AS total FROM time_sheet WHERE YEAR(ts_date)='$y' AND MONTHName(ts_date)='$m' AND (DAYNAME(ts_date)='Sunday' OR ts_date IN (SELECT holi_date FROM holidays)) AND ts_name='$user' ")->result_array();
	}
		
		

	function get_admin_holiday_ot($y,$m,$user){

		return $this->db->query("SELECT ts_date,ts_duty FROM time_sheet WHERE YEAR(ts_date)='$y' AND MONTHName(ts_date)='$m' AND (DAYNAME(ts_date)='Sunday' OR ts_date IN (SELECT holi_date FROM holidays)) AND ts_name='$user'  ORDER BY ts_date")->result_array();
	}
		
	function get_admin_normal_ot_hrs($y,$m,$user){
			
		return $this->db->query("SELECT SEC_TO_TIME(SUM(time_to_sec(ts_ot))) AS total  FROM time_sheet WHERE YEAR(ts_date)='$y' AND MONTHName(ts_date)='$m' AND ts_name='$user' AND DAYNAME(ts_date)!='Sunday' AND ts_ot!='00:00:00' AND ts_date NOT IN (SELECT holi_date FROM holidays)")->result_array();
	}
		
	function get_admin_holiday_ot_hrs($y,$m,$user){
			
		return $this->db->query("SELECT SEC_TO_TIME(SUM(time_to_sec(ts_duty))) AS total FROM time_sheet  WHERE YEAR(ts_date)='$y' AND MONTHName(ts_date)='$m' AND (DAYNAME(ts_date)='Sunday' OR ts_date IN (SELECT holi_date FROM holidays)) AND ts_name='$user' ")->result_array();
	}
}
?>