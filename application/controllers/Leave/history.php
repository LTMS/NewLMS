<?php
class History extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->library('SimpleLoginSecure');
		$this->load->library('Export_emp_leave_history');
		$this->load->library('My_PHPMailer');
		$this->load->model('Leave/history_model');
		$this->load->model('Leave/summary_model');
		$this->load->helper('url');
			
		$this->load->library('session');
		if(!$this->session->userdata('admin_logged_in'))
		{
			redirect("logincheck");
		}

	}


	function get_applied_applications()
	{
		$data["menu"]='LMS';
		$data["submenu"]='applied_applications';
		$data["result"]=$this->history_model->get_applied_applications();

		$this->template->write('titleText', "Pending Leave Applications");
		$this->template->write_view('sideLinks', 'general/menu',$data);
		$this->template->write_view('bodyContent', 'Leave/History/applications_applied',$data);
		$this->template->render();
	}

	function get_reported_applications()
	{
		$data["menu"]='LMS';
		$data["submenu"]='reported_applications';
		$data["result"]=$this->history_model->get_reported_applications();
			
		$this->template->write('titleText', "Pending Leave Applications");
		$this->template->write_view('sideLinks', 'general/menu',$data);
		$this->template->write_view('bodyContent', 'Leave/History/applications_reported',$data);
		$this->template->render();
	}



	function leave_reprocess()
	{
		$data["menu"]='LMS';
		$data["submenu"]='reprocess';
		$data["members"]=$this->history_model->get_leave_members();
		$data['years']=$this->history_model->get_years();

		$this->template->write('titleText', "Reprocess Approved Leaves");
		$this->template->write_view('sideLinks', 'general/menu',$data);
		$this->template->write_view('bodyContent', 'Leave/History/reprocess_leave',$data);
		$this->template->render();
	}

	

	function my_leave_history()
	{
		$data["menu"]='LMS';
		$data["submenu"]='history';
		$data["Years"]=$this->history_model->get_years();
		$data["LeaveList"]=$this->history_model->get_leaveList();
		
		$this->template->write('titleText', "My Leave History");
		$this->template->write_view('sideLinks', 'general/menu',$data);
		$this->template->write_view('bodyContent', 'Leave/History/my_leave_history',$data);
		$this->template->render();
	}



	function history_admin()
	{
		$data["menu"]='LMS';
		$data["submenu"]='history_admin';
		$data["Years"]=$this->history_model->get_years();
		$data["LeaveList"]=$this->history_model->get_leaveList();
		$data["department"]=$this->history_model->get_Departments();

		$this->template->write('titleText', "Employees Leave History");
		$this->template->write_view('sideLinks', 'general/menu',$data);
		$this->template->write_view('bodyContent', 'Leave/History/history_admin',$data);
		$this->template->render();
	}

	function history_md()
	{
		$data["menu"]='LMS';
		$data["submenu"]='history_admin';
		$data["deptlist"]=$this->history_model->get_dept();
		$data["teamlist"]=$this->history_model->get_team();
		$data["members"]=$this->history_model->get_leave_members();

		$this->template->write('titleText', "Employees Leave History");
		$this->template->write_view('sideLinks', 'general/menu',$data);
		$this->template->write_view('bodyContent', 'Leave/History/history_admin',$data);
		$this->template->render();
	}

	function history_teamleader()
	{
		$data["menu"]='LMS';
		$data["submenu"]='history_teamleader';
		$data["members"]=$this->history_model->get_team_members();

		$this->template->write('titleText', "Department Leave History");
		$this->template->write_view('sideLinks', 'general/menu',$data);
		$this->template->write_view('bodyContent', 'Leave/History/history_teamleader',$data);
		$this->template->render();
	}


	
	
	
		function update_LeaveStatusReporter(){
						$form_data = $this->input->post();
						$this->history_model->update_LeaveStatusReporter($form_data["leave_id"],$form_data["remark"],$form_data["status"]);
		}
	
		
		function update_LeaveStatusApprover(){
						$form_data = $this->input->post();
						$this->history_model->update_LeaveStatusApprover($form_data["leave_id"],$form_data["remark"],$form_data["status"]);
		}
		
		
	
	function Send_LeaveMail()
	{
		$form_data = $this->input->post();
		$emp_name=$form_data["emp_name"];
		$emp_num=$form_data["emp_num"];
		$type=$form_data["type"];
		$date=$form_data["date"];
		$tot_days=$form_data["tot_days"];
		$reason=$form_data["reason"];
		$apptime=$form_data["apptime"];
		$remark=$form_data["remark"];
		$mail_subject=$form_data["mail_subject"];
		
		$data["MailID"]=$this->history_model->get_MailID($emp_num);
		foreach($MailID as $row){
			$emp_mail=$row["Emp_Mail"];
			$reporter_mail=$row["Reporter_Mail"];
		}
		
		
		$my_mail=$this->session->userdata('My_Mail');
		$actionby=$this->session->userdata('Emp_Name');
		
		
		
		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->Host = 'mail.preipolar.com';
		$mail->SMTPAuth = True;
		$mail->Username = 'irshath@preipolar.com';
		$mail->Password = 'prei@123';


		$mail->From = $my_mail;
		$mail->FromName = 'Leave Mailer';
		$mail->addAddress($emp_mail);
		$mail->addCC($reporter_mail);

		$mail->isHTML(true);

		$mail->Subject = $mail_subject;

		$c=	"
							<html>
										<body>
										<h style='font-weight:bold' ><font color='#003366' size='5pt' face='Lucida Handwriting' >Hi, <b>Gnanajeyam G..!</b></font></h>
										<br>
										<br>
										<p style='font-weight:bold;font-size:13px;color:#003366' >&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; 
											$mail_subject
										</p>
										<br>
										<h3 style='font-weight:bold;font-size:13px;color:#003366' ><u>Leave Details</u></h3>
										<br>
										<table style='font-size:13px;color:#006699;'>
											<tr>
												<td width='100px'>Type of Leave</td><td width='10px'>:</td>
												<td>$type</td>
											</tr>
											<tr>
												<td width='100px'>Leave On</td><td width='10px'>:</td>
												<td>$date</td>
											</tr>
											<tr>
												<td width='100px'>No of Days</td><td width='10px'>:</td>
												<td>$tot_days</td>
											</tr>
											<tr>
												<td width='100px'>Reason</td><td width='10px'>:</td>
												<td>$reason</td>
											</tr>
											<tr>
												<td width='100px'>Applied On</td><td width='10px'>:</td>
												<td>$apptime</td>
											</tr>
											<tr>
												<td width='100px'>Processed By</td><td width='10px'>:</td>
												<td>$actionby</td>
											</tr>
											<tr>
												<td width='100px'>Remarks</td><td width='10px'>:</td>
												<td>$remark</td>
											</tr>
										</table>
										</body>					 	  
							 </html>";

		
		$mail->Body =$c;


		if(!$mail->send()) {
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
			exit;
		}

		echo 'Message has been sent';
	}
		
	
		function get_leave_status(){
		$form_data = $this->input->post();
		$type = $form_data["type"];
		$data["reminder"]=$this->history_model->get_reminder_limit();
		$data["result"]=$this->history_model->get_leave_status($form_data["d1"],$form_data["d2"],$form_data["type"]);
		if($type=='1'){
			$this->load->view('Leave/History/leave_status_noaction',$data);
		}
		else{
			$this->load->view('Leave/History/history_left',$data);
			$this->load->view('Leave/History/leave_status',$data);
		}
	}
	
	
	
																		/*  * * Admin Leave History * * */

	function admin_leavehistory_general_all(){
		$form_data = $this->input->post();
		$month=$form_data["month"];

		if($month=='All'){
			$data["result"]=$this->history_model->admin_leavehistory_general_all($form_data["year"],$form_data["month"],$form_data["emp"]);
			$this->load->view('Leave/History/admin_leavehistory_page_emp',$data);
			$this->load->view('Leave/History/admin_leavehistory_general_print',$data);
		}
		if($month!='All'){
			$data["result"]=$this->history_model->admin_leavehistory_general_month($form_data["year"],$form_data["month"],$form_data["emp"]);
			$this->load->view('Leave/History/admin_leavehistory_page_emp',$data);
			$this->load->view('Leave/History/admin_leavehistory_general_print',$data);
		}

	}

	function admin_leavehistory_general_filter(){
		$form_data = $this->input->post();
		$data["result"]=$this->history_model->admin_leavehistory_general_filter($form_data["year"],$form_data["emp"],$form_data["leave"]);
		$this->load->view('Leave/History/admin_leavehistory_page_emp',$data);
		$this->load->view('Leave/History/admin_leavehistory_general_print',$data);
	}
		
		
	function admin_leavehistory_approved(){
		$form_data = $this->input->post();
		$emp=$form_data["emp"];
		if($emp=='All'){
			$data["result"]=$this->history_model->admin_leavehistory_approved_all($form_data["year"]);
			$this->load->view('Leave/History/admin_leavehistory_page_all',$data);
			$this->load->view('Leave/History/admin_leavehistory_approved_all_print',$data);
		}
		else{
			$data["result"]=$this->history_model->admin_leavehistory_approved_ind($form_data["year"],$form_data["emp"]);
			$this->load->view('Leave/History/admin_leavehistory_page_all',$data);
			$this->load->view('Leave/History/admin_leavehistory_approved_ind_print',$data);
		}

	}

	
	function get_DepartmentEmployees(){
				$form_data = $this->input->post();
				$deptartments=$this->history_model->get_DepartmentEmployees($form_data["dept"]);
				$deptlist="";
				if(!empty($deptartments)){
						foreach($deptartments as $row){
						$depts=$row["Dept"];
						$deptlist=$deptlist.'::'.$depts;
						}
				}
				else{
					$deptlist="No Employees";
				}
				echo $deptlist;
				
	}
	
	
																		/*  * * My Leave History * * */

	function my_leavehistory_general_all(){
		$form_data = $this->input->post();
		$month=$form_data["month"];
		
		if($month=='All'){
			$data["result"]=$this->history_model->my_leavehistory_general_all($form_data["year"],$form_data["month"]);
			$this->load->view('Leave/History/my_leavehistory_general',$data);
			$this->load->view('Leave/History/my_leavehistory_general_print',$data);
		}
		if($month!='All'){
			$form_data["emp"]=$this->session->userdata('Emp_Number');
			$data["result"]=$this->history_model->my_leavehistory_general_month($form_data["year"],$form_data["month"],$form_data["emp"]);
			$this->load->view('Leave/History/my_leavehistory_general',$data);
			$this->load->view('Leave/History/my_leavehistory_general_print',$data);
		}

	}

	function my_leavehistory_general_filter(){
		$form_data = $this->input->post();
		$data["result"]=$this->history_model->my_leavehistory_general_filter($form_data["year"],$form_data["leave"]);
		$this->load->view('Leave/History/my_leavehistory_general',$data);
		$this->load->view('Leave/History/my_leavehistory_general_print',$data);
	}
		
		
	function my_leavehistory_approved(){
			$form_data = $this->input->post();
			$data["result"]=$this->history_model->my_leavehistory_approved($form_data["year"]);
			$data["total"]=$this->summary_model->get_my_summary_total($form_data["year"]);
			$this->load->view('Leave/History/my_leavehistory_general',$data);
			$this->load->view('Leave/History/my_leavehistory_general_print',$data);

	}
																		/*  * * Team and Department Leave History * * */
	
	function get_history_teamleader()
	{
		$form_data = $this->input->post();
		$data["status"]=$this->history_model->get_history_teamleader($form_data["d1"],$form_data["d2"],$form_data["string"]);
		$this->load->view('Leave/History/history_teamleader_page',$data);
	}


	
	function show_document()
	{
		//echo "hello";
		$form_data = $this->input->post();
		echo $this->history_model->show_document($form_data["lid"]);
		//echo $form_data["lid"];
	}


	function get_approved_leaves(){
		$form_data = $this->input->post();
		$data["summary"]=$this->history_model->get_approved_leaves($form_data["year"],$form_data["month"],$form_data["emp"]);
			
		$this->load->view('Leave/History/reprocess_leave_page',$data);
			
	}
	function leaves_on_sameday(){
		$form_data = $this->input->post();
		$data["result2"]=$this->history_model->leaves_on_sameday($form_data["date1"],$form_data["date2"],$form_data["id1"]);
			
		$this->load->view('Leave/History/LeaveList4date',$data);
			
		 
	}
	
	
																								/*  * * Action on  Leaves * * */
	
	function remove_leave(){
		$form_data = $this->input->post();
		$this->history_model->remove_leave($form_data["id"]);
			
	}
		
	function getRecentLeave(){
		$form_data = $this->input->post();
		$result=$this->history_model->getRecentLeave($form_data["user1"],$form_data["id1"]);
			
		foreach($result as $row){
			echo	$date=$row["date"];
		}
			
		if(empty($result)){echo $date='---';}
	}
		

	function export_leave_history($params){
		//$sdate=document.getElementById("start_date").value;
		$form_data=explode("::", $params);
		$sdate=$form_data[0];
		$edate=$form_data[1];
		$filter=$form_data[2];
		$uname=$this->session->userdata('fullname');
		$data=$this->history_model->get_leave_status($sdate,$edate,$filter);
		$exporter= new Export_emp_leave_history();
		$exporter->Export($data,$uname);
	}


																					/* * *        Permissions         * * */

	function permissions()
	{
		$data["menu"]='LMS';
		$data["submenu"]='permissions';
		$data["result"]=$this->history_model->get_pending_permissions();

		$this->template->write('titleText', "Pending Permissions");
		$this->template->write_view('sideLinks', 'general/menu',$data);
		$this->template->write_view('bodyContent', 'Leave/History/permissions',$data);
		$this->template->render();
	}

	function grantPermission(){

		$result = $this->input->post();
		$date=$result["date"];
		$remark=$result["remark"];
		$name=$result["user"];

		$this->apply_model->process_permission($result["id"],$result["remark"]);

		$mail_id = 	$this->apply_model->get_mailID($result["user"]);
			

		foreach($mail_id as $row){
			$from=$row["md"];
			$to1=$row["user"];

		}
		$mail = new PHPMailer;

		$mail->isSMTP();
		$mail->Host = 'mail.preipolar.com';
		$mail->SMTPAuth = True;
		$mail->Username = 'irshath@preipolar.com';
		$mail->Password = 'prei@123';


		$mail->From = $from;
		$mail->FromName = 'Permission Mailer';

		$mail->addAddress($to1);

		$mail->isHTML(true);

		$mail->Subject = $name." .! Your Permission on ".$date." was ".$remark;
		$mail->Body    = $name." .! Your Permission on ".$date." was ".$remark." by Managing Director.";
			
		if(!$mail->send()) {
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
			exit;
		}

		echo 'Message has been sent';

	}

	

}
?>