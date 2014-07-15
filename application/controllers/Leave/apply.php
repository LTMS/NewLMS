<?php
class Apply extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->library('SimpleLoginSecure');
		$this->load->library('My_PHPMailer');
		$this->load->model('Leave/apply_model');
		$this->load->model('Leave/summary_model');
		$this->load->model('Timesheet/overtime_model');
		$this->load->helper('url');
			
		$this->load->library('session');
		if(!$this->session->userdata('admin_logged_in'))
		{
			redirect("logincheck");
		}

	}


	function index()
	{


		$urole=$this->session->userdata('Emp_Role');
		if($urole == 'MD')
		{
			$data["menu"]='LMS';
			$data["submenu"]='lms_intro';
			$this->template->write('titleText', "Leave Criteria");
			$data['img']="/images/leave1.png";
			$data['Titlebar']="Leave Management System";
			$data["Criteria"]=$this->apply_model->get_LeaveCriteria();
			$data["Experience"]=$this->apply_model->get_Experience();
			$this->template->write_view('sideLinks', 'General/menu',$data);
			$this->template->write_view('bodyContent', 'Leave/Apply/apply_leave',$data);
			$this->template->render();
		}
		else{
			$data["menu"]='LMS';
			$data["submenu"]='lms_intro';
			$data['img']="/images/leave1.png";
			$data['Titlebar']="Leave Management System";
			$data["Criteria"]=$this->apply_model->get_LeaveCriteria();
			$data["Experience"]=$this->apply_model->get_Experience();
			$this->template->write('titleText', "Leave Criteria");
			$this->template->write_view('sideLinks', 'general/menu',$data);
			$this->template->write_view('bodyContent', 'Leave/Apply/apply_leave',$data);
			$this->template->render();
		}
	}


	function apply_leave()
	{
		$data["menu"]='LMS';
		$data["submenu"]='apply';
		$data['img']="/images/leave1.png";
		$data['Titlebar']="Apply for Leave & Permission";
		$data["Criteria"]=$this->apply_model->get_LeaveCriteria();
		$data["Experience"]=$this->apply_model->get_Experience();
		$data["Leave_Details_Year"]=$this->apply_model->get_Leave_At_Reporter_Year('CL');
		$data["Leave_Details_Month"]=$this->apply_model->get_Leave_At_Reporter_Month('CL');
		$this->template->write('titleText', "Apply For Leave");
		$this->template->write_view('sideLinks', 'general/menu',$data);
		$this->template->write_view('bodyContent', 'Leave/Apply/apply_leave',$data);
		$this->template->render();
	}
		

	function leave_others()
	{
		$data["menu"]='LMS';
		$data["submenu"]='apply_others';
		$data["technicians"]=$this->apply_model->get_technicians();

		$this->template->write('titleText', "Leave Status");
		$this->template->write_view('sideLinks', 'general/menu',$data);
		$this->template->write_view('bodyContent', 'Leave/Apply/apply_others',$data);
		$this->template->render();
	}


	function permissions()
	{
		$data["menu"]='LMS';
		$data["submenu"]='permissions';
		$data["result"]=$this->apply_model->get_pending_permissions();

		$this->template->write('titleText', "Pending Permissions");
		$this->template->write_view('sideLinks', 'general/menu',$data);
		$this->template->write_view('bodyContent', 'Leave/Apply/permissions',$data);
		$this->template->render();
	}


	
																					/* * *		 Date Validation 			* * */


	function check_in_holidays()	{
		$form_data = $this->input->post();
		$date1 = $form_data["date"];
		
		$your_date = date("Y-m-d", strtotime($date1));
		$result=$this->apply_model->check_in_holidays($your_date);
		
			foreach($result as $row){
					$status= $row["status"];
					$desc= $row["holi_desc"];
			}
				if($status!=0){
					 $txt=$desc."- It is a Holiday ..!";
				}
				else{
					$txt='No';
				}
				echo $txt;
	}

		
	function check_leavetaken(){
		$form_data = $this->input->post();
	 	$date1 = $form_data["date"];
		
		$your_date = date("Y-m-d", strtotime($date1));
		$result=$this->apply_model->check_leavetaken($your_date);
		
			foreach($result as $row1){
				$count= $row1["Count"];
				$type= $row1["LeaveDesc"];
				$app_time= $row1["Applied_On"];
			}
				if($count==0){
					 $txt="No";
				}
				else{
					$txt="You have taken or  applied ".$type." on this day..!";
				}
				echo $txt;
			
	}
	
		function check_prior_days(){
				$form_data = $this->input->post();
			 	$date1 = $form_data["date"];
			 	$type = $form_data["type"];
			 	
				$your_date = date("Y-m-d", strtotime($date1));
				$result=$this->apply_model->check_prior_days($your_date,$type);
				
					foreach($result as $row1){
						$diff= $row1["Diff"];
						$prior= $row1["Prior_Days"];
					}
					
						if($diff>=$prior){
									 $txt="Yes";
						}
						else{
									if($type=='SL'){
										 	$txt="You have to apply ".$type." with in  ".$prior." days after leave taken.";
									}
									else{
										$txt="You have to apply ".$type." before ".$prior." days.";									
									}
						}
						echo $txt;
			
	}

	
	function calculate_no_of_days(){
				$form_data = $this->input->post();
			 	$from_date = $form_data["from_date"];
			 	$to_date = $form_data["to_date"];
			 	
				$date_from = date("Y-m-d", strtotime($from_date));
				$date_to = date("Y-m-d", strtotime($to_date));
				$result=$this->apply_model->calculate_no_of_days($date_from,$date_to);
				
					foreach($result as $row1){
						$diff= $row1["Diff"];
					}
						echo $diff;
	}

	
	
	function check_MonthlyLimit(){
				$form_data=$this->input->post();
			 	$from_date = $form_data["from_date"];
			 				 	
				$date_from = date("Y-m-d", strtotime($from_date));
				$result=$this->apply_model->check_MonthlyLimit($date_from,$form_data["type"]);
				$days=0;
				if(!empty($result)){
						foreach($result as $row1){
							$days= $row1["TotalDays"];
						}
				}
				echo $days;
	}
	
	function check_YearlyLimit(){
				$form_data=$this->input->post();
			 	$from_date = $form_data["from_date"];
			 				 	
				$date_from = date("Y-m-d", strtotime($from_date));
				$result=$this->apply_model->check_YearlyLimit($date_from,$form_data["type"]);
				$days=0;
				if(!empty($result)){
						foreach($result as $row1){
							$days= $row1["TotalDays"];
						}
				}
				echo $days;
	}
	
	
/*	
	function calculate_workingdays()
	{
		$form_data = $this->input->post();
		$date1 = $form_data["date_from"];
		$date2 = $form_data["date_to"];

		$start_ts = strtotime($date1);
		$end_ts = strtotime($date2);
		$diff = $end_ts - $start_ts;
		$days= round($diff / 86400)+1;
			
		$result=$this->apply_model->calculate_workingdays($form_data["date_from"],$form_data["date_to"]);
		foreach($result as $row){
			$tot= $row["total"];
			$holidays= $row["holidays"];
			$leave= $row["leaves"];
			$sundays= $row["sundays"];
		}
		echo $interval=$days-$tot.'::'.$holidays.'::'.$leave.'::'.$days.'::'.$sundays;

	}
	
*/	
																	/* * * 		Inserting  Leave 	Application 		* * */
	
	
		
	function upload_ProofDoc($leavetype){
			
			$status = "";
		    $msg = "";
			$file_element_name ="fileupload_".$leavetype;
		    
		   if ($status != "error")
		    { 
		        $config['upload_path'] = './Documents/';
		        $config['allowed_types'] = 'jpg|png|doc|pdf';
		        $config['max_size'] = 1024 * 2;
		        $config['encrypt_name'] = TRUE;
		 
		        $this->load->library('upload', $config);
		 
		        if (!$this->upload->do_upload($file_element_name))
		        {
		            $status = 'error';
		            $msg = $this->upload->display_errors('', '');
		        }
		        else
		        {
		            $data = $this->upload->data();
		            $file_id = $this->apply_model->upload_ProofDoc($data['file_name'],$leavetype);
		            if($file_id)
		            {
		                $status = $data['file_name'];
		                $msg = "File successfully uploaded";
		            }
		            else
		            {
		                unlink($data['full_path']);
		                $status = "error";
		                $msg = "Something went wrong when saving the file, please try again.";
		            }
		        }
		        @unlink($_FILES[$file_element_name]);
		    }
		    echo json_encode(array('status' => $status, 'msg' => $msg));
	  
	}					

	function delete_ProofDoc(){
				$form_data=$this->input->post();
				$file_id=$form_data["file_id"];
				$file_path='./Documents/'.$file_id;
				echo	$this->apply_model->delete_ProofDoc($form_data["file_id"]);
				
				@unlink($file_path);
	}
	
	
	function remove_NotUploadedDocuments(){
		$files=$this->apply_model->get_NotUploadedDocuments();
				if(!empty($files))
					foreach($files as $row){
									$file_id=$row["Encr_Name"];
									$file_path='./Documents/'.$file_id;
									@unlink($file_path);
									
						$this->apply_model->delete_ProofDoc($file_id);
					}
	}
	
																			/* * *		 Inserting Leave Application 			* * */
	
	
	function insert_LeaveApplication(){
		$form_data = $this->input->post();
		
	 	$date1 = $form_data["from_date"];
	 	$date2 = $form_data["to_date"];	 	
	 	$from_date = date("Y-m-d", strtotime($date1));
	 	$to_date = date("Y-m-d", strtotime($date2));
	 	$type = $form_data["type"];	 
	 	$proof_status=$form_data["proof_status"];
	 	
	 		$result=$this->apply_model->insert_LeaveApplication($form_data["type"],$from_date,$to_date,$form_data["days"],$form_data["reason"],$form_data["proof_status"]);

	 					foreach($result as $row){
								$leaveID=$row["Leave_ID"];
						}
	
				 		if($proof_status=="YES"){
								$this->update_DocumentStatus($type,$leaveID);
				 		}
		 				$this->Send_LeaveMail($type,$date1,$form_data["days"],$form_data["reason"],$proof_status,$leaveID);
		 				
	}
	
	function update_DocumentStatus($type,$leaveID){
				$form_data=$this->input->post();
				$this->apply_model->update_DocumentStatus($type,$leaveID);			
	}
	
	
	function 	Send_LeaveMail($type,$date,$days,$reason,$proof_status,$leaveID){
		
		$my_name=$this->session->userdata('Emp_Name');
		$my_num=$this->session->userdata('Emp_Number');
		$my_mail=$this->session->userdata('My_Mail');
		$R=$this->session->userdata('My_Mail');
		$app_time = date('l jS \of F Y h:i:s A');
		
		$MailID=$this->apply_model->get_MailID($my_num);
		foreach($MailID as $row){
			//	$emp_mail=$row["Emp_Mail"];
			$reporter_mail=$row["Reporter_Mail"];
			$reporter_name=$row["Reporter_Name"];
		}
		
		
		$mail_subject=$my_name." has applied ".$type;
		
		
		
		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->Host = 'mail.preipolar.com';
		$mail->SMTPAuth = True;
		$mail->Username = 'irshath@preipolar.com';
		$mail->Password = 'prei@123';


		$mail->From = $my_mail;
		$mail->FromName = 'Leave Mailer';
		$mail->addAddress($reporter_mail);
		$mail->addCC($my_mail);
		$files=$this->apply_model->get_Attachments($leaveID);
			if($proof_status=="YES" && !empty($files)){							
							foreach($files as $row){
								$filename=$row["Encr_Name"];
								$filepath="./Documents/".$filename;
								$mail->addAttachment($filepath);	
							}
			}
		

		$mail->isHTML(true);

		$mail->Subject = $mail_subject;

		$c=	"
							<html>
										<body>
										<h style='font-weight:bold' ><font color='#003366' size='5pt' face='Lucida Handwriting' >Hi, <b> $reporter_name  </b></font></h>
										<br>
										<br>
										<p style='font-weight:bold;font-size:15px;color:#003366' >&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; 
											$mail_subject.
										</p>
										<br>
										<h3 style='font-weight:bold;font-size:14px;color:#003366' ><u>Leave Details</u></h3>
										<br>
										<table style='font-weight:bold;font-size:14px;color:#003366;'>
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
												<td>$days</td>
											</tr>
											<tr>
												<td width='100px'>Reason</td><td width='10px'>:</td>
												<td>$reason</td>
											</tr>
											<tr>
												<td width='100px'>Applied On</td><td width='10px'>:</td>
												<td>$app_time</td>
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
		
	
	

																					/* * *        Permissions         * * */
	function insert_permission_data(){
		$form_data = $this->input->post();
		$this->apply_model->insert_permission_data($form_data["date"],$form_data["hour"],$form_data["total"],$form_data["reason"]);
			
	}

	function check_permission_data(){
		$form_data = $this->input->post();
		echo $this->apply_model->check_permission_data($form_data["date"]);
	}
	
	function SendPermission(){

		$result = $this->input->post();
		$mail_id = 	$this->apply_model->get_mailID($result["user"]);
		$reason=$result["reason"];
		$date=$result["date"];
		$time=$result["hour"];
		$hrs=$result["total"];
		$name=$result["user"];
			

		foreach($mail_id as $row){
			$to1=$row["md"];
			$from=$row["user"];

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

		$mail->Subject = $name."  has applied  for Permission.! ";

			
		$c=	"
								<html><body>
									<table border='1' align='center' cellpading='0' cellspacing='0' width='70%' style='color:blue;font-weight:bold;margin: 40px 0px 0px 50px;'>
												<tr >
														<td colspan='2' align='center' style='color:red'>Permission Details</td>
														
												</tr>
												<tr >
														<td align='right' >Employee Name</td>
														<td  >$name</td>
												</tr>
												<tr>
														<td align='right'>Need Hours</td>
														<td>$hrs</td>
												</tr>
												<tr>
														<td align='right'>Date</td>
														<td>$date</td>
												</tr>
													<tr>
														<td align='right'>Time</td>
														<td>$time</td>
												</tr>
											<tr>
														<td align='right'>Reason</td>
														<td>$reason</td>
													<tr>
														<td align='left' colspan='4'> Link:  http://192.168.2.54:8877/LMS/index.php/lms/permissions</td>
													
												</tr>
									</table>
							 	  </body></html>";

		$mail->Body =$c;

		
		if(!$mail->send()) {
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
			exit;
		}

		echo 'Message has been sent';

	}



}
?>