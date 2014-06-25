<?php
class timesheet_entry extends CI_Controller
{

	function __construct()
	{
			
		parent::__construct();
		$this->load->model('TimeSheet/timesheet_entry_model');

		$this->load->helper('url');

		$this->load->library('session');
		if(!$this->session->userdata('admin_logged_in'))
		{
			redirect("logincheck");
		}

	}

	function index()
	{
	}

	function entry()
	{
			
		$data["menu"]='timesheet';
		$data["submenu"]='entry';
		$data["activity"]=$this->timesheet_entry_model->get_activity_code();
		$data["job"]=$this->timesheet_entry_model->get_jobs();
		$data["np"]=$this->timesheet_entry_model->get_np_jobs();
		$this->template->write('titleText', "Time Sheet  Entry");
		$this->template->write_view('sideLinks', 'General/menu',$data);
		$this->template->write_view('bodyContent', 'Timesheet/Timesheet_Entry/timesheet_entry',$data);
		$this->template->render();
	}
	function insert_timesheet_data(){

		$result= $this->input->post();
		$this->timesheet_entry_model->insert_timesheet_data($result["date"],$result["in"],$result["out"],$result["late"],$result["lunch"],$result["duty"],$result["ot"],$result["tot"],$result["jd1"],$result["Hr1"],$result["jd2"],$result["Hr2"],$result["jd3"],$result["Hr3"],$result["jd4"],$result["Hr4"],$result["jd5"],$result["Hr5"],$result["jd6"],$result["Hr6"],$result["jd7"],$result["Hr7"],$result["np1"],$result["atv1"],$result["desc1"],$result["np2"],$result["atv2"],$result["desc2"],$result["np3"],$result["atv3"],$result["desc3"],$result["np4"],$result["atv4"],$result["desc4"],$result["np5"],$result["atv5"],$result["desc5"],$result["np6"],$result["atv6"],$result["desc6"],$result["np7"],$result["atv7"],$result["desc7"]);
		//echo $result["date"];
	}
	function checkDate(){
		$result= $this->input->post();
		echo $this->timesheet_entry_model->checkDate($result["d1"]);
		//echo $result["d1"];
	}
	function checkLeave(){
		$result= $this->input->post();
		echo $this->timesheet_entry_model->checkLeave($result["d1"]);
	}
	function checkLocked(){
		$result= $this->input->post();
		echo $this->timesheet_entry_model->checkLocked($result["d1"]);
	}
	
	function get_INOUT(){
		$result= $this->input->post();
		$col=$this->timesheet_entry_model->get_INOUT($result["d1"]);
		echo $col;
	}

	function intro_admin()
	{
		$data["menu"]='timesheet';
		$data["submenu"]='tms_intro';
		$data["activity"]=$this->timesheet_entry_model->get_activity_code();
		$data["job"]=$this->timesheet_entry_model->get_jobs();
		$data["np"]=$this->timesheet_entry_model->get_np_jobs();
			
		$this->template->write('titleText', "Time Sheet  Entry");
		$this->template->write_view('sideLinks', 'general/menu',$data);
		$this->template->write_view('bodyContent', 'timesheet/Timesheet_Entry/tms_intro',$data);
		$this->template->render();
	}
	
	
	
	
	
	
	
	
	function intro()
	{
		$data["menu"]='timesheet';
		$data["submenu"]='tms_intro';
		$data["activity"]=$this->timesheet_model->get_activity_code();
		$data["job"]=$this->timesheet_model->get_jobs();
		$data["np"]=$this->timesheet_model->get_np_jobs();
			
		$this->template->write('titleText', "Time Sheet  Entry");
		$this->template->write_view('sideLinks', 'general/menu',$data);
		$this->template->write_view('bodyContent', 'timesheet/tms_intro',$data);
		$this->template->render();
	}


	function teamsheet()
	{
		$data["menu"]='e_reports';
		$data["submenu"]='teamsheet';
		$data["deptlist"]=$this->timesheet_model->get_dept();
		$data["members"]=$this->timesheet_model->get_all_members();

		$this->template->write('titleText', "Employees Time Sheet Reports");
		$this->template->write_view('sideLinks', 'general/menu',$data);
		$this->template->write_view('bodyContent', 'timesheet/teamsheet',$data);
		$this->template->render();
	}
		
	function teamsheet_dept()
	{
		$data["menu"]='e_reports';
		$data["submenu"]='teamsheet_dept';
		$data["deptlist"]=$this->timesheet_model->get_dept();
		$data["teamlist"]=$this->timesheet_model->get_team();
		$data["members"]=$this->timesheet_model->get_all_members();

		$this->template->write('titleText', "Extensive Time Sheet Reports");
		$this->template->write_view('sideLinks', 'general/menu',$data);
		$this->template->write_view('bodyContent', 'timesheet/teamsheet_dept',$data);
		$this->template->render();
	}
		
	function teamsheet_leader()
	{
		$data["menu"]='timesheet';
		$data["submenu"]='teamsheet_leader';

		$data["members"]=$this->timesheet_model->get_team_members();
		$this->template->write('titleText', "My Team Time Sheet");
		$this->template->write_view('sideLinks', 'general/menu',$data);
		$this->template->write_view('bodyContent', 'timesheet/teamsheet_leader',$data);
		$this->template->render();
	}
		
		
	 
		
		
	 
	function mysheet()
	{
		$data["menu"]='timesheet';
		$data["submenu"]='mysheet';

		$this->template->write('titleText', "My  Time Sheet");
		$this->template->write_view('sideLinks', 'general/menu',$data);
		$this->template->write_view('bodyContent', 'timesheet/mysheet',$data);
		$this->template->render();
	}
		
	function edit_timesheet()
	{
		$data["menu"]='timesheet';
		$data["submenu"]='edit_timesheet';
		$data["param"]=$this->timesheet_model->get_parameters();

		$this->template->write('titleText', "Edit  Time Sheet");
		$this->template->write_view('sideLinks', 'general/menu',$data);
		$this->template->write_view('bodyContent', 'timesheet/edit_timesheet',$data);
		$this->template->render();
	}
		
		
	function set_inout_time()
	{
		$data["menu"]='misc';
		$data["submenu"]='set_inout_time';

		$this->template->write('titleText', "Set In-Out Time");
		$this->template->write_view('sideLinks', 'general/menu',$data);
		$this->template->write_view('bodyContent', 'timesheet/set_inout_time',$data);
		$this->template->render();
	}
		
		
		
		
	function addjobs()
	{
		$data["menu"]='misc';
		$data["submenu"]='addjobs';
		$data["jobs"]=$this->timesheet_model->get_all_jobs();
		$data["npjobs"]=$this->timesheet_model->get_all_npjobs();

		$this->template->write('titleText', "	Manage Jobs");
		$this->template->write_view('sideLinks', 'general/menu',$data);
		$this->template->write_view('bodyContent', 'timesheet/addjobs',$data);
		$this->template->render();
	}

		
	
		
	function process_jobs(){
		$result= $this->input->post();
		$this->timesheet_model->process_jobs($result["value"],$result["num"]);
			
	}
		
	function process_npjobs(){
		$result= $this->input->post();
		$this->timesheet_model->process_npjobs($result["value"],$result["num"]);
			
	}

	function add_jobs(){
		$result= $this->input->post();
		$this->timesheet_model->add_jobs($result["num"],$result["desc"],$result["type"]);
			
	}
		
	function update_jobs(){
		$result= $this->input->post();
		$this->timesheet_model->update_jobs($result["num"],$result["desc"],$result["type"],$result["id"]);
			
	}
		
		

		
	function get_timesheet_overall(){
		$result= $this->input->post();
		$data["history"]=$this->timesheet_model->get_timesheet_overall($result["d1"],$result["d2"]);
		$data["tothrs"]=$this->timesheet_model->get_timesheet_overall_hrs($result["d1"],$result["d2"]);
		$this->load->view('timesheet/teamsheet_overall',$data);
	}
		
	function get_timesheet_jobwise(){
		$result= $this->input->post();
		$data["history"]=$this->timesheet_model->get_timesheet_jobwise($result["d1"],$result["d2"],$result["num"]);
		$data["tothrs"]=$this->timesheet_model->get_timesheet_jobwise_hrs($result["d1"],$result["d2"],$result["num"]);
		$this->load->view('timesheet/teamsheet_jobwise',$data);
	}

	function get_timesheet_userwise(){
		$result= $this->input->post();
		$data["history"]=$this->timesheet_model->get_timesheet_userwise($result["d1"],$result["d2"],$result["user"]);
		$data["tothrs"]=$this->timesheet_model->get_timesheet_userwise_hrs($result["d1"],$result["d2"],$result["user"]);
		$this->load->view('timesheet/teamsheet_userwise',$data);
	}

	function get_timesheet_ot(){
		$result= $this->input->post();
		$data["history"]=$this->timesheet_model->get_timesheet_ot($result["d1"],$result["d2"]);
		$data["tothrs"]=$this->timesheet_model->get_timesheet_ot_hrs($result["d1"],$result["d2"]);
		$this->load->view('timesheet/teamsheet_ot',$data);
	}

		
		
	function timesheet_activity_emp(){
		$result= $this->input->post();
		$data["history"]=$this->timesheet_model->timesheet_activity_emp($result["d1"],$result["d2"],$result["user"]);
		$data["tothrs"]=$this->timesheet_model->timesheet_activity_emp_hrs($result["d1"],$result["d2"],$result["user"]);
		$data["leaves"]=$this->timesheet_model->showLeaves_emp($result["d1"],$result["d2"],$result["user"]);
		$this->load->view('timesheet/timesheet_activity_emp',$data);
	}
		
		
		
	function user_timesheet_overall(){
		$result= $this->input->post();
		$data["history"]=$this->timesheet_model->user_timesheet_overall($result["d1"],$result["d2"]);
		$data["tothrs"]=$this->timesheet_model->user_timesheet_overall_hrs($result["d1"],$result["d2"]);
		$this->load->view('timesheet/teamsheet_user',$data);
	}

	function user_timesheet_jobwise(){
		$result= $this->input->post();
		$data["history"]=$this->timesheet_model->user_timesheet_jobwise($result["d1"],$result["d2"],$result["num"]);
		$data["tothrs"]=$this->timesheet_model->user_timesheet_jobwise_hrs($result["d1"],$result["d2"],$result["num"]);
		$this->load->view('timesheet/teamsheet_jobwise_user',$data);
	}
		
	function timesheet_activity_user(){
		$result= $this->input->post();
		$data["history"]=$this->timesheet_model->timesheet_activity_user($result["d1"],$result["d2"]);
		$data["tothrs"]=$this->timesheet_model->timesheet_activity_user_hrs($result["d1"],$result["d2"]);
		$data["leaves"]=$this->timesheet_model->showLeaves_user($result["d1"],$result["d2"]);
		$this->load->view('timesheet/timesheet_activity_user',$data);
	}

		
		
		
		
		
	function team_timesheet_overall(){
		$result= $this->input->post();
		$data["history"]=$this->timesheet_model->team_timesheet_overall($result["d1"],$result["d2"]);
		$data["tothrs"]=$this->timesheet_model->team_timesheet_overall_hrs($result["d1"],$result["d2"]);
		$this->load->view('timesheet/teamsheet_overall',$data);
	}
		
	function team_timesheet_jobwise(){
		$result= $this->input->post();
		$data["history"]=$this->timesheet_model->team_timesheet_jobwise($result["d1"],$result["d2"],$result["num"]);
		$data["tothrs"]=$this->timesheet_model->team_timesheet_jobwise_hrs($result["d1"],$result["d2"],$result["num"]);
		$this->load->view('timesheet/teamsheet_jobwise',$data);
	}

	function team_timesheet_ot(){
		$result= $this->input->post();
		$data["history"]=$this->timesheet_model->team_timesheet_ot($result["d1"],$result["d2"]);
		$data["tothrs"]=$this->timesheet_model->team_timesheet_ot_hrs($result["d1"],$result["d2"]);
		$this->load->view('timesheet/teamsheet_ot',$data);
	}

		
	function get_timedate(){
		$result= $this->input->post();
		$data["timing"]=$this->timesheet_model->get_timedate($result["date"]);
		$this->load->view('timesheet/edit_timesheet_div',$data);
	}
		
		
	function update_changes(){
		$result= $this->input->post();
		$this->timesheet_model->update_changes($result["id"],$result["in"],$result["out"],$result["late"],$result["ot"],$result["duty"],$result["tot"],$result["lunch"]);
	}
		
	
	
	
	
		

	function get_timesheet_Dept(){
		$result= $this->input->post();
		$data["history"]=$this->timesheet_model->get_timesheet_Dept($result["d1"],$result["d2"],$result["dept"]);
		$data["tothrs"]=$this->timesheet_model->get_timesheet_Dept_hrs($result["d1"],$result["d2"],$result["dept"]);
		$this->load->view('timesheet/teamsheet_overall',$data);
	}
		
	function get_timesheet_Team(){
		$result= $this->input->post();
		$data["history"]=$this->timesheet_model->get_timesheet_Team($result["d1"],$result["d2"],$result["team"]);
		$data["tothrs"]=$this->timesheet_model->get_timesheet_Team_hrs($result["d1"],$result["d2"],$result["team"]);
		$this->load->view('timesheet/teamsheet_overall',$data);
	}
		
	function timesheet_team_job(){
		$result= $this->input->post();
		$data["history"]=$this->timesheet_model->timesheet_team_job($result["d1"],$result["d2"],$result["job"],$result["team"]);
		$data["tothrs"]=$this->timesheet_model->timesheet_team_job_hrs($result["d1"],$result["d2"],$result["job"],$result["team"]);
		$this->load->view('timesheet/teamsheet_jobwise',$data);
	}
		
		
		
		
		
	function update_timeoffice(){
		$result= $this->input->post();
		echo		$this->timesheet_model->update_timeoffice($result["id1"],$result["d1"],$result["d2"],$result["in1"],$result["out1"]);
	}
		
	function get_timeofficeID(){
		$result=$this->input->post();
		$data["result1"]=$this->timesheet_model->get_timeofficeID($result["date"]);
		$this->load->view('timesheet/set_inout_time_div',$data);
	}





	function timesheet_job_activity_user(){
		$result= $this->input->post();
		$data["history"]=$this->timesheet_model->timesheet_job_activity_user($result["d1"],$result["d2"]);
		$data["tothrs"]=$this->timesheet_model->timesheet_job_activity_user_hrs($result["d1"],$result["d2"]);
		$data["leaves"]=$this->timesheet_model->showLeaves_user($result["d1"],$result["d2"]);
		$this->load->view('timesheet/timesheet_job_activity_user',$data);
	}

	function timesheet_job_activity_emp(){
		$result= $this->input->post();
		$data["history"]=$this->timesheet_model->timesheet_job_activity_emp($result["d1"],$result["d2"],$result["user"]);
		$data["tothrs"]=$this->timesheet_model->timesheet_job_activity_emp_hrs($result["d1"],$result["d2"],$result["user"]);
		$data["leaves"]=$this->timesheet_model->showLeaves_emp($result["d1"],$result["d2"],$result["user"]);
		$this->load->view('timesheet/timesheet_job_activity_emp',$data);
	}
		
	function check_job(){
		$result= $this->input->post();
		echo  $this->timesheet_model->check_job($result["job"]);
	}
	function fetch_job(){
		$result= $this->input->post();
		echo  $this->timesheet_model->fetch_job($result["job"]);
	}

	function check_npjob(){
		$result= $this->input->post();
		echo	$this->timesheet_model->check_npjob($result["job"]);

	}

	function locked_users()
	{
		$data["menu"]='misc';
		$data["submenu"]='locked_users';
		//	$data["members"]=$this->timesheet_model->get_team_members();
		$data["members"]=$this->timesheet_model->get_leave_members();
		$data['years']=$this->timesheet_model->get_lockedyears();

		$this->template->write('titleText', "Time Sheet Locked Users");
		$this->template->write_view('sideLinks', 'general/menu',$data);
		$this->template->write_view('bodyContent', 'timesheet/locked_users',$data);
		$this->template->render();
	}

	function get_locked_users(){
		$result= $this->input->post();
		$data["history"]=$this->timesheet_model->get_locked_users($result["year"],$result["month"]);
		$this->load->view('timesheet/locked_users_page',$data);

	}
	function get_locked_user(){
		$result= $this->input->post();
		$data["history"]=$this->timesheet_model->get_locked_user($result["year"],$result["month"],$result["emp"]);
		$this->load->view('timesheet/locked_users_page',$data);

	}
		
	function unlock_timesheet(){
		$result= $this->input->post();
		$this->timesheet_model->unlock_timesheet($result["id"]);
	}



		
		

}
?>