<?php
Class Misc_model extends CI_Model{
	
	function _construct()
	{
		parent::_construct();
	}

		function get_parameters(){
					return $this->db->query("SELECT *, HOUR(comp_off_reduct) as hour, MINUTE(comp_off_reduct) as min,ROUND(TIME_TO_SEC(comp_off_reduct)/60) as comp_minutes FROM parameters ")->result_array();
		}
	
		function process_leave($id){			
					$this->db->query("UPDATE leavehistory SET LeaveStatus='5' WHERE LeaveID='$id'");
		}
	
		function get_leave_members(){
					return $this->db->query("SELECT DISTINCT Emp_Name AS 'Name' FROM  admin_users  WHERE Emp_Role NOT IN ('MD') ORDER BY name")->result_array();				
		}
		
		function get_years(){
					return $this->db->query("SELECT  DISTINCT YEAR(From_Date) AS 'year' FROM leave_history ORDER BY year ")->result_array();
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




		
}


?>