<?php
class History extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->library('SimpleLoginSecure');
		$this->load->library('Export_emp_leave_history');
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



	function status()
	{

		$data["menu"]='LMS';
		$data["submenu"]='status';

		$this->template->write('titleText', "Leave Status");
		$this->template->write_view('sideLinks', 'general/menu',$data);
		$this->template->write_view('bodyContent', 'Leave/History/status',$data);
		$this->template->render();
	}

	function add_dept(){
		$data["menu"]='misc';
		$data["submenu"]='add_dept';
		$data["deptlist"]=$this->history_model->get_dept();

		$this->template->write('titleText', "Manage Departments");
		$this->template->write_view('sideLinks', 'general/menu',$data);
		$this->template->write_view('bodyContent', 'Leave/History/add_dept',$data);
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


	function history_admin()
	{
		$data["menu"]='e_reports';
		$data["submenu"]='history_admin';
		$data["deptlist"]=$this->history_model->get_dept();
		$data["teamlist"]=$this->history_model->get_team();
		$data["members"]=$this->history_model->get_leave_members();

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
		$remark=$form_data["remark"];
		$mail_title=$form_data["mail_title"];
		$data["result"]=$this->history_model->get_LeaveDetails($form_data["leave_id"]);

		foreach($leave as $row){
			$to=$row["Email"];
			$from=$row["FromMail"];
			$days=$row["Days"];
			$date=$row["Date"];
			$time=$row["Time"];
			$status1=$row["Status"];
			$name=$row["User"];
			$type=$row["Type"];
		}
		if($status1=='L1 -  Approved'){
			$status='Team Leader';
		}
		if($status1=='L2 -  Approved'){
			$status='Managing Director';
		}
			
		$mail = new PHPMailer;

		$mail->isSMTP();
		$mail->Host = 'mail.preipolar.com';
		$mail->SMTPAuth = True;
		$mail->Username = 'irshath@preipolar.com';
		$mail->Password = 'prei@123';


		$mail->From = $from;
		$mail->FromName = 'Leave Mailer';
		$mail->addAddress($to);
		$mail->addAddress('saravanan@preipolar.com');

		$mail->isHTML(true);

		$mail->Subject = $name." Your ".$type." was Approved ";

		$c=	"
								<html><body>
									<table border='1' align='center' cellpading='0' cellspacing='0' width='70%' style='color:blue;font-weight:bold;margin: 40px 0px 0px 50px;'>
												<tr >
														<td colspan='2' align='center' style='color:green'>Approved Leave Details</td>
														
												</tr>
												<tr>
														<td align='right'>Leave Type</td>
														<td>$type</td>
												</tr>
												<tr>
														<td align='right'>From Date</td>
														<td>$date</td>
												</tr>
												<tr>
														<td align='right'>No of Days</td>
														<td>$days</td>
												</tr>
											<tr>
														<td align='right'>Applied On</td>
														<td>$time</td>
											</tr>
												<tr>
														<td align='right'>Approved By</td>
														<td>$status</td>
											</tr>
									</table>
							 	  </body></html>";

		$mail->Body =$c;

		//	$mail->Body    = $name." Your ".$type." from ".$date." for ".$days." day(s) applied on ".$time." status is ".$status;
		//	$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		if(!$mail->send()) {
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
			exit;
		}

		echo 'Message has been sent';


		$this->load->view('Leave/History/pending_applications',$data);
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


																							/*  * * Approving Leave * * */


	
																								/*  * * Rejecting Leave * * */
	
	function reject(){
		$form_data = $this->input->post();
		$data["result"]=$this->history_model->reject($form_data["lid"],$form_data["reason"],$form_data["type"],$form_data["user"],$form_data["hrs"]);
		$leave=$this->history_model->approve_mail($form_data["lid"]);

		foreach($leave as $row){

			$to=$row["Email"];
			$from=$row["FromMail"];
			$days=$row["Days"];
			$date=$row["Date"];
			$time=$row["Time"];
			$status1=$row["Status"];
			$name=$row["User"];
			$type=$row["Type"];
		}
		if($status1=='L1 - Rejected'){
			$status='Team Leader';
		}
		if($status1=='L2 - Rejected'){
			$status='Managing Director';
		}

		$mail = new PHPMailer;

		$mail->isSMTP();
		$mail->Host = 'mail.preipolar.com';
		$mail->SMTPAuth = True;
		$mail->Username = 'irshath@preipolar.com';
		$mail->Password = 'prei@123';


		$mail->From =$from;
		$mail->FromName = 'Leave Mailer';
		$mail->addAddress($to);
		$mail->addAddress('saravanan@preipolar.com');

		$mail->isHTML(true);

		$mail->Subject = $name." Your ".$type." was Rejected ";


		$c=	"
								<html><body>
									<table border='1' align='center' cellpading='0' cellspacing='0' width='70%' style='color:blue;font-weight:bold;margin: 40px 0px 0px 50px;'>
												<tr >
														<td colspan='2' align='center' style='color:red'>Rejected Leave Details</td>
														
												</tr>
												<tr>
														<td align='right'>Leave Type</td>
														<td>$type</td>
												</tr>
												<tr>
														<td align='right'>From Date</td>
														<td>$date</td>
												</tr>
												<tr>
														<td align='right'>No of Days</td>
														<td>$days</td>
												</tr>
												<tr>
														<td align='right'>Applied On</td>
														<td>$time</td>
											</tr>
												<tr>
														<td align='right'>Rejected By</td>
														<td>$status</td>
											</tr>
									</table>
							 	  </body></html>";

		$mail->Body =$c;

		//	$mail->Body    = $name." Your ".$type." from ".$date." for ".$days." day(s) applied on ".$time." status is ".$status;
		//	$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		if(!$mail->send()) {
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
			exit;
		}

		echo 'Message has been sent';


		$this->load->view('Leave/History/pending_applications',$data);
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