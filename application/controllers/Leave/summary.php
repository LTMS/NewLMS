<?php
class Summary extends CI_Controller
	{
		   function __construct()
		   {
			parent::__construct();
		
			$this->load->library('SimpleLoginSecure');
			$this->load->library('Export_emp_leave_history');
		  	$this->load->model('Leave/summary_model');
			$this->load->helper('url');
			
			$this->load->library('session');
			if(!$this->session->userdata('admin_logged_in'))
			 {
			redirect("logincheck");
			}
	
		}
		
	
	function my_leave_summary()
	{	
		$data["menu"]='LMS';
		$data["submenu"]='my_summary';
		$data['years']=$this->summary_model->get_years();
		$data['summary']=$this->summary_model->get_my_summary(date('Y'));
		$data['total']=$this->summary_model->get_my_summary_total(date('Y'));
		$data["perm"]=$this->summary_model->get_my_permission(date('Y'));
		$data["perm_tot"]=$this->summary_model->get_my_permission_total(date('Y'));
		
		
		$this->template->write('titleText', "My Leave Summary");
		$this->template->write_view('sideLinks', 'general/menu',$data);
        $this->template->write_view('bodyContent', 'Leave/Summary/my_leave_summary',$data);
        $this->template->render();					
	}
	
	function leave_summary()
	{	
		$data["menu"]='e_reports';
		$data["submenu"]='summary';
		$data["deptlist"]=$this->summary_model->get_dept();	
		$data["members"]=$this->summary_model->get_leave_members();	
		
		$data['years']=$this->summary_model->get_years();
		$this->template->write('titleText', "Employees Leave Summary");
		$this->template->write_view('sideLinks', 'general/menu',$data);
        $this->template->write_view('bodyContent', 'Leave/Summary/leave_summary',$data);
        $this->template->render();					
	}
	
	function leave_summary_md()
	{	
		$data["menu"]='LMS';
		$data["submenu"]='summary';
		$data["deptlist"]=$this->summary_model->get_dept();	
		$data["teamlist"]=$this->summary_model->get_team();	
		$data["members"]=$this->summary_model->get_leave_members();	
		
		$data['years']=$this->summary_model->get_years();
		$this->template->write('titleText', "Employees Leave Summary");
		$this->template->write_view('sideLinks', 'general/menu',$data);
        $this->template->write_view('bodyContent', 'Leave/Summary/leave_summary',$data);
        $this->template->render();					
	}
		
				
	
					
			function get_summary(){
				$form_data = $this->input->post();
				$type=$form_data["type"];
				$txt=$form_data["emp"];
				$data["summary"]=$this->summary_model->get_summary($form_data["year"],$form_data["emp"],$form_data["team"],$form_data["dept"]);
				$data["total"]=$this->summary_model->get_summary_total($form_data["year"],$form_data["emp"],$form_data["team"],$form_data["dept"]);
				$data["perm"]=$this->summary_model->get_admin_permission($form_data["year"],$form_data["emp"]);
				$data["perm_tot"]=$this->summary_model->get_admin_permission_total($form_data["year"],$form_data["emp"]);
	
				if($type=='1' && $txt!='All Employees'){
				
						$this->load->view('Leave/Summary/leave_summary_emp',$data);
				}
				if($type=='1' && $txt=='All Employees'){
					$this->load->view('Leave/Summary/leave_summary_dept',$data);
				}
				if($type=='2' || $type=='3'){
					$this->load->view('Leave/Summary/leave_summary_dept',$data);
				}
				
		}
		
			function get_my_summary(){
				$form_data = $this->input->post();
			 	$data["summary"]=$this->summary_model->get_my_summary($form_data["year"]);
			 	$data["total"]=$this->summary_model->get_my_summary_total($form_data["year"]);
			 	$data["perm"]=$this->summary_model->get_my_permission($form_data["year"]);
				$data["perm_tot"]=$this->summary_model->get_my_permission_total($form_data["year"]);
			
				$this->load->view('Leave/Summary/my_leave_summary_page',$data);
							
		}
			
	
	
		}
	?>