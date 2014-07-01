<?php
class Summary extends CI_Controller
	{
		   function __construct()
		   {
			parent::__construct();
		
			$this->load->library('SimpleLoginSecure');
			//$this->load->library('Export_emp_leave_summary');
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
		$data['years']=$this->summary_model->get_leave_years();
		$data["summary"]=$this->summary_model->get_my_summary(date('Y'));
		$data["total"]=$this->summary_model->get_my_summary_total(date('Y'));
		
		
		$this->template->write('titleText', "My Leave Summary");
		$this->template->write_view('sideLinks', 'general/menu',$data);
        $this->template->write_view('bodyContent', 'Leave/Summary/my_leave_summary',$data);
        $this->template->render();					
	}
	
	function admin_leave_summary()
	{	
		$data["menu"]='LMS';
		$data["submenu"]='summary_admin';
		$data['Years']=$this->summary_model->get_leave_years();
		$data["department"]=$this->summary_model->get_Departments();
		$data["members"]=$this->summary_model->get_leave_members();
				
		$this->template->write('titleText', "Employees Leave Summary");
		$this->template->write_view('sideLinks', 'general/menu',$data);
        $this->template->write_view('bodyContent', 'Leave/Summary/admin_leave_summary',$data);
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

		
														/* * * 			Admin Leave Summary 		* * */
		
		
		function get_admin_leave_summary_general(){
				$form_data = $this->input->post();
				$month=$form_data["month"];
				$dept=$form_data["dept"];
				$emp=$form_data["emp"];
		
									if($dept=='All'){				/* Dept=All   */
											
												if($emp=='All'){ 		
																	
																	if($month=='All'){			/* Dept=All, Emp=All, Month=All   */
																				$data["result"]=$this->summary_model->admin_leave_summary_Y($form_data["year"]);
																				$data["total"]=$this->summary_model->admin_leave_summary_total_Y($form_data["year"]);
																				$this->load->view('Leave/Summary/admin_leave_summary_general',$data);
																	}
																	else{								/* Dept=All, Emp=All, Month!=All   */
																				$data["result"]=$this->summary_model->admin_leave_summary_YM($form_data["year"],$form_data["month"]);
																				$data["total"]=$this->summary_model->admin_leave_summary_total_YM($form_data["year"],$form_data["month"]);
																				$this->load->view('Leave/Summary/admin_leave_summary_general',$data);
																	}
												}
												else{					
																	if($month=='All'){			/* Dept=All, Emp!=All, Month=All   */
																				$data["result"]=$this->summary_model->admin_leave_summary_YE($form_data["year"],$form_data["emp"]);
																				$data["total"]=$this->summary_model->admin_leave_summary_total_YE($form_data["year"],$form_data["emp"]);
																				$this->load->view('Leave/Summary/admin_leave_summary_general',$data);
																	}
																	else{								/* Dept=All, Emp!=All, Month!=All   */
																				$data["result"]=$this->summary_model->admin_leave_summary_YME($form_data["year"],$form_data["month"],$form_data["emp"]);
																				$data["total"]=$this->summary_model->admin_leave_summary_total_YME($form_data["year"],$form_data["month"],$form_data["emp"]);
																				$this->load->view('Leave/Summary/admin_leave_summary_general',$data);
																	}
													
												}
							}
							else{		/* Dept!=All   */
																if($emp=='All'){ 		
																	
																	if($month=='All'){			/* Dept!=All, Emp=All, Month=All   */
																				$data["result"]=$this->summary_model->admin_leave_summary_YD($form_data["year"],$form_data["dept"]);
																				$data["total"]=$this->summary_model->admin_leave_summary_total_YD($form_data["year"],$form_data["dept"]);
																				$this->load->view('Leave/Summary/admin_leave_summary_general',$data);
																	}
																	else{								/* Dept!=All, Emp=All, Month!=All   */
																				$data["result"]=$this->summary_model->admin_leave_summary_YMD($form_data["year"],$form_data["month"],$form_data["dept"]);
																				$data["total"]=$this->summary_model->admin_leave_summary_total_YMD($form_data["year"],$form_data["month"],$form_data["dept"]);
																				$this->load->view('Leave/Summary/admin_leave_summary_general',$data);
																	}
												}
												else{					
																	if($month=='All'){			/* Dept!=All, Emp!=All, Month=All   */
																				$data["result"]=$this->summary_model->admin_leave_summary_YDE($form_data["year"],$form_data["dept"],$form_data["emp"]);
																				$data["total"]=$this->summary_model->admin_leave_summary_total_YDE($form_data["year"],$form_data["dept"],$form_data["emp"]);
																				$this->load->view('Leave/Summary/admin_leave_summary_general',$data);
																	}
																	else{								/* Dept!=All, Emp!=All, Month!=All   */
																				$data["result"]=$this->summary_model->admin_leave_summary_YMDE($form_data["year"],$form_data["month"],$form_data["dept"],$form_data["emp"]);
																				$data["total"]=$this->summary_model->admin_leave_summary_total_YMDE($form_data["year"],$form_data["month"],$form_data["dept"],$form_data["emp"]);
																				$this->load->view('Leave/Summary/admin_leave_summary_general',$data);
																	}
													
												}
								
							}
	}
		
		
	
		}
	?>