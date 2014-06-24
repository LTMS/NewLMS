<?php
class Leave_misc extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->library('SimpleLoginSecure');
		$this->load->model('Leave/misc_model');
		$this->load->helper('url');
			
		$this->load->library('session');
		if(!$this->session->userdata('admin_logged_in'))
		{
			redirect("logincheck");
		}

	}
	
	
	
	function lms_intro_md(){
			$data["menu"]='LMS';
			$data["submenu"]='lms_intro_md';
			$this->template->write('titleText', "Leave Criteria");
			$data["Param"]=$this->misc_model->get_parameters();

			$this->template->write_view('sideLinks', 'general/menu',$data);
			$this->template->write_view('bodyContent', 'Leave/Misc/lms_intro_admin',$data);
			$this->template->render();
		
	}
	
	function lms_intro_emp(){
			$data["menu"]='LMS';
			$data["submenu"]='lms_intro_emp';
			$this->template->write('titleText', "Leave Criteria");
			$data["Param"]=$this->misc_model->get_parameters();

			$this->template->write_view('sideLinks', 'general/menu',$data);
			$this->template->write_view('bodyContent', 'Leave/Misc/lms_intro_emp',$data);
			$this->template->render();
		
	}
	
	function leave_reprocess()	{
			$data["menu"]='LMS';
			$data["submenu"]='reprocess';
			$data["members"]=$this->misc_model->get_leave_members();
			$data['years']=$this->misc_model->get_years();
	
			$this->template->write('titleText', "Reprocess Approved Leaves");
			$this->template->write_view('sideLinks', 'general/menu',$data);
			$this->template->write_view('bodyContent', 'Leave/Misc/reprocess_leave',$data);
			$this->template->render();
	}


	function get_approved_leaves(){
			$form_data = $this->input->post();
			$data["summary"]=$this->misc_model->get_approved_leaves($form_data["year"],$form_data["month"],$form_data["emp"]);
				
			$this->load->view('lms/reprocess_leave_page',$data);
			
	}

	function process_leave(){
			$form_data = $this->input->post();
			$this->misc_model->process_leave($form_data["id"]);
				
	}
	


}
?>