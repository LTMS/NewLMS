<?php
class Leave_misc extends CI_Controller{
	

		function __construct()
				{
				parent::__construct();
		
				$this->load->library("SimpleLoginSecure");
				$this->load->model("Leave/leave_misc_model");
				$this->load->helper("url");
				$this->load->library('session');
				
				if(!$this->session->userdata('admin_logged_in')){
					redirect("logincheck");
				}
	}
	
	function authorities(){
			$data["menu"]='LMS';
			$data["submenu"]='authorities';
			$data["Reporter"]=$this->leave_misc_model->get_LeaveReporters();
			$data["Approver"]=$this->leave_misc_model->get_LeaveApprovers();
			//$result["Employees"]=$this->leave_misc_model->get_ReporterEmployees();
			$this->template->write('titleText','Leave Authorities');
			$this->template->write_view('sideLinks', 'General/menu',$data);
			$this->template->write_view('bodyContent','Leave/Misc/authorities');
			$this->template->render();
	}
	
	
		
	function get_ReporterEmployees(){
		$form_data=$this->input->post();
		$emp_num=$form_data["emp_num"];
		$result["Employees"]=$this->leave_misc_model->get_ReporterEmployees($emp_num);
		
		$this->load->view('Leave/Misc/authorities_div',$result);
	}
	
	function get_ApproverEmployees(){
		$form_data=$this->input->post();
		$emp_num=$form_data["emp_num"];
		$result["Employees"]=$this->leave_misc_model->get_ApproverEmployees($emp_num);
	
		$this->load->view('Leave/Misc/authorities_div',$result);
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}
?>