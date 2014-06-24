<?php
class General extends CI_Controller
{


	function __construct()
	{
		parent::__construct();

			
		parent::__construct();
		$this->load->model('general_model');
		$this->load->helper('url');
		$this->load->library('My_PHPMailer');

		if(!$this->session->userdata('admin_logged_in'))
		{
			redirect("logincheck");
		}

	}

	function index()
	{
		$data["menu"]='LMS';
		$data["submenu"]='apply';
		$this->template->write_view('sideLinks', 'general/menu',$data);
		$this->template->write_view('bodyContent', 'general/myContent');
		$this->template->render();
			
	}



	function parameters()
	{
		$data["menu"]='misc';
		$data["submenu"]='parameters';
		$data['param']=$this->general_model->get_parameters();
		$this->template->write('titleText', "Manage Office Time");
		$this->template->write_view('sideLinks', 'general/menu',$data);
		$this->template->write_view('bodyContent', 'general/parameters',$data);
		$this->template->render();
	}


	function mydetails()
	{
		$data["menu"]='my_account';
		$data["submenu"]='mydetails';
		$data['details']=$this->general_model->get_mydetails();
		$this->template->write('titleText', "My Details");
		$this->template->write_view('sideLinks', 'general/menu',$data);
		$this->template->write_view('bodyContent', 'general/mydetails',$data);
		$this->template->render();
	}

	function holidays()
	{
		$data["menu"]='misc';
		$data["submenu"]='holidays';
		$data['years']=$this->general_model->get_years();
		$data["holidays"]=$this->general_model->show_holidays(date('Y'));
		$this->template->write('titleText', "Manage Holidays");
		$this->template->write_view('sideLinks', 'general/menu',$data);
		$this->template->write_view('bodyContent', 'general/holidays',$data);
		$this->template->render();
	}

	function holidays_emp()
	{
		$data["menu"]='misc';
		$data["submenu"]='holidays_emp';
		$data['years']=$this->general_model->get_years();
		$data["holidays"]=$this->general_model->show_holidays(date('Y'));
		$this->template->write('titleText', "Holidays Details");
		$this->template->write_view('sideLinks', 'general/menu',$data);
		$this->template->write_view('bodyContent', 'general/holidays_emp',$data);
		$this->template->render();
	}

	function update_param(){
		$result= $this->input->post();
		$this->general_model->update_param($result["intime"],$result["outtime"],$result["tot"],$result["ot"],$result["lunch"],$result["sick_limit"],$result["permiss"],$result["comp"]);
			
	}


	function show_holidays(){
		$result= $this->input->post();
		$data["holidays"]=$this->general_model->show_holidays($result["year"]);
		$this->load->view('general/holidays_div',$data);
	}
		
	function show_holidays_emp(){
		$result= $this->input->post();
		$data["holidays"]=$this->general_model->show_holidays($result["year"]);
		$this->load->view('general/holidays_emp_div',$data);
	}
		
	function add_holiday(){
		$result= $this->input->post();
		echo $this->general_model->add_holiday($result["desc"],$result["date"]);

	}
		
	function remove_holiday(){
		$result= $this->input->post();
		echo $this->general_model->remove_holiday($result["id"]);
	}
		

	function ErrorReport()
	{
		$data["menu"]='error';
		$data["submenu"]='error';
		$this->template->write('titleText', "Error Report");
		$this->template->write_view('sideLinks', 'general/menu',$data);
		$this->template->write_view('bodyContent', 'general/ErrorReport',$data);
		$this->template->render();
	}



	function upload_file($msg){
			
		$details = explode(":", $msg);
		$sub=$details[0];
		$body=$details[1];
			
		$rbody=str_replace('_', '  ', $body);
		if($sub =='1'){
			$subject='Feedback from Preipolar Customer.!';
		}
		if($sub =='2'){
			$subject='Error Report from Preipolar Customer.!';
		}
			
		$status = "";
		$msg = "";
		$file_element_name = 'file';
			

		if ($status != "error")
		{
			$config['upload_path'] = './Errors/';
			$config['allowed_types'] = 'gif|jpg|png|doc|txt';
			$config['max_size']  = 1024 * 8;
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
				$file=$data['file_name'];
				// Send Mail
				$this->sendErrorMail($file,$rbody,$subject);
			}
			@unlink($_FILES[$file_element_name]);
		}

			
	}

	function sendErrorMail($file,$rbody,$subject){
			
		$result=$this->general_model->getUserMail();

			
		foreach($result as $row){
			$from=$row["email"];
		}

		$mail = new PHPMailer;

		$mail->isSMTP();
		$mail->Host = 'mail.preipolar.com';
		$mail->SMTPAuth = True;
		$mail->Username = 'irshath@preipolar.com';
		$mail->Password = 'prei@123';


		$mail->From = $from;
		$mail->FromName = 'LMS Feedback / Error Report';

		$to1='gnana.jeyam@deastech.com';
		$to2='sakthi.kanesh@deastech.com';
		$to3='sureshsivam@deastech.com';
		//$filepath='Errors\\'.$file;

		$mail->addAddress($to1);
		$mail->addAddress($to2);
		$mail->addAddress($to3);
		if($file!="" || $file!=null){
			$mail->AddAttachment("Errors/".$file);
		}


		$mail->Subject =$subject;


		$mail->Body ="<font size='3pt' color='#006699'>".$rbody."</font>";

		$mail->isHTML(true);


		if(!$mail->send()) {
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
			exit;
		}

		echo 'Message has been sent';

	}




}
?>