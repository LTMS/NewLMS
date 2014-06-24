<?php
class overtime extends CI_Controller
{

	function __construct()
	{
			
		parent::__construct();
			
		$this->load->model('TimeSheet/overtime_model');
		$this->load->helper('url');

		$this->load->library('session');
		if(!$this->session->userdata('admin_logged_in'))
		{
			redirect("logincheck");
		}

	}
		
	function my_ot()
	{
		$data["menu"]='timesheet';
		$data["submenu"]='my_ot';
		$data['years']=$this->overtime_model->get_years();

		$this->template->write('titleText', "My  OT Details");
		$this->template->write_view('sideLinks', 'general/menu',$data);
		$this->template->write_view('bodyContent', 'timesheet/my_ot',$data);
		$this->template->render();
	}
	function get_my_ot(){
		$result= $this->input->post();
		$data["ot"]=$this->overtime_model->get_my_normal_ot($result["year"],$result["month"]);
		$data["holi"]=$this->overtime_model->get_my_holiday_ot($result["year"],$result["month"]);
		$data["ot_tot"]=$this->overtime_model->get_my_normal_ot_hrs($result["year"],$result["month"]);
		$data["holi_tot"]=$this->overtime_model->get_my_holiday_ot_hrs($result["year"],$result["month"]);
		$this->load->view('timesheet/my_ot_page',$data);

	}
		

	function get_admin_otsummary(){
		$result= $this->input->post();
		$data["ot"]=$this->overtime_model->get_admin_normal_ot($result["d1"],$result["d2"],$result["emp"]);
		$data["timeoffice"]=$this->overtime_model->get_days($result["d1"],$result["d2"],$result["emp"]);
		$data["Comp_Hours"]=$this->overtime_model->get_CompOff_Hours($result["d1"],$result["d2"],$result["emp"]);
		// $data["leave"]=$this->overtime_model->get_admin_normal_ot_hrs($result["d1"],$result["d2"],$result["emp"]);
		// $data["holi_tot"]=$this->overtime_model->get_admin_holiday_ot_hrs($result["d1"],$result["d2"],$result["emp"]);
		$this->load->view('timesheet/admin_otsummary_page',$data);

	}
	function admin_ot()
	{
		$data["menu"]='e_reports';
		$data["submenu"]='admin_ot';
		$data["members"]=$this->overtime_model->get_leave_members();

		$data['years']=$this->overtime_model->get_years();
		$this->template->write('titleText', "Employees  OT Details");
		$this->template->write_view('sideLinks', 'general/menu',$data);
		$this->template->write_view('bodyContent', 'timesheet/admin_ot',$data);
		$this->template->render();
	}
		
	function admin_otsummary()
	{
		$data["menu"]='e_reports';
		$data["submenu"]='admin_otsummary';
		$data["members"]=$this->overtime_model->get_leave_members();
		$data["dept"]=$this->overtime_model->get_deptartments();

		$data['years']=$this->overtime_model->get_years();
		$this->template->write('titleText', "Employees  OT Summary");
		$this->template->write_view('sideLinks', 'general/menu',$data);
		$this->template->write_view('bodyContent', 'timesheet/admin_otsummary',$data);
		$this->template->render();
	}
		
	function ack_ot_history()
	{
		$data["menu"]='e_reports';
		$data["submenu"]='ack_ot_history';
		$data["members"]=$this->overtime_model->get_ack_members();
		$data["dept"]=$this->overtime_model->get_deptartments();
		$data['years']=$this->overtime_model->get_years();

		$this->template->write('titleText', "Acknowledged OTs");
		$this->template->write_view('sideLinks', 'general/menu',$data);
		$this->template->write_view('bodyContent', 'timesheet/acknowledged_ot_history',$data);
		$this->template->render();
	}
	function get_admin_ot(){
		$result= $this->input->post();
		$data["ot"]=$this->overtime_model->get_admin_normal_ot($result["year"],$result["month"],$result["emp"]);
		$data["holi"]=$this->overtime_model->get_admin_holiday_ot($result["year"],$result["month"],$result["emp"]);
		$data["ot_tot"]=$this->overtime_model->get_admin_normal_ot_hrs($result["year"],$result["month"],$result["emp"]);
		$data["holi_tot"]=$this->overtime_model->get_admin_holiday_ot_hrs($result["year"],$result["month"],$result["emp"]);
		$this->load->view('timesheet/admin_ot_page',$data);

	}
		
		
		
	function admin_ot_dept(){
		$result= $this->input->post();
		//		$a="2014-03-01";
		//		$b="2014-03-31";
		//		$c="ENGINEERING";
		$data["dept_work_details"]=$this->overtime_model->dept_work_details($result["d1"],$result["d2"],$result["dept"]);
		$data["from"]=$result["d1"];
		$data["to"]=$result["d2"];
		$this->load->view('timesheet/admin_ot_dept_page',$data);
			
	}
		
		
	function acknowledge_OT(){
		$result= $this->input->post();
		$this->overtime_model->acknowledge_OT($result["user"],$result["d1"],$result["d2"],$result["ot_hrs"],$result["amount"]);
	}
		
	function check_acknowledged(){
		$result= $this->input->post();
		$solution=$this->overtime_model->check_acknowledged($result["user"],$result["d1"],$result["d2"]);

		foreach($solution as $row){
			$count=$row["count"];
			$from=$row["FromMonth"];
			$to=$row["ToMonth"];
			$output=$count.'::'.$from.'::'.$to;
		}
		echo $output;
	}
		
		
	function ack_history_emp(){
		$result= $this->input->post();
		$data["history"]=$this->overtime_model->ack_history_emp($result["user"],$result["year"]);
		$this->load->view('timesheet/acknowledged_ot_history_page',$data);
	}

		
	function ack_history_dept(){
		$result= $this->input->post();
		$data["history"]=$this->overtime_model->ack_history_dept($result["dept"],$result["d1"],$result["d2"]);
		$this->load->view('timesheet/acknowledged_ot_history_dept',$data);
	}
		
		
	function cancel_Acknowledged(){
		$result= $this->input->post();
		$data["history"]=$this->overtime_model->cancel_Acknowledged($result["id"]);
	}
	function my_otsummary()
	{
		$data["menu"]='timesheet';
		$data["submenu"]='my_otsummary';
		$data["members"]=$this->overtime_model->get_leave_members();
		$data["dept"]=$this->overtime_model->get_deptartments();

		$data['years']=$this->overtime_model->get_years();
		$this->template->write('titleText', "My OT Summary");
		$this->template->write_view('sideLinks', 'general/menu',$data);
		$this->template->write_view('bodyContent', 'timesheet/my_otsummary',$data);
		$this->template->render();
	}

}
?>