<?php
class Logincheck extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('SimpleLoginSecure');
		$this->session->set_userdata("adminpage",0);
		$this->load->model('User/users_model');
		$this->load->library('My_PHPMailer');
	}

	function index()
	{
		/*$data["menu"]='sales';
		 $data["submenu"]='sales';
		 $this->template->write('sideTitle', 'Main Menu');
		 $this->template->write('titleText', "Login Form");
		 //$this->template->write_view('sideLinks', 'general/menu',$data);
		 $this->template->write_view('bodyContent', 'general/myContent');
		 $this->template->render();*/
		$this->load->view('general/myContent');
	}


	function login()
	{
		if($this->session->userdata('admin_logged_in')) {
			redirect("/Leave/apply/index");
		} else {
			$emp_num = $this->input->post('emp_num');
			$pwd = $this->input->post('password');

			if($this->simpleloginsecure->login($emp_num, $pwd)) {
				redirect("/Leave/apply/index");

			}
			else {
				$err = "Wrong Credentials";
				$data["err"] = $err;
				/*$data["menu"]='error';
				 $data["submenu"]='error';
				 $this->template->write_view('bodyContent', 'general/myContent',$data);
				 $this->template->write_view('sideLinks', 'general/menu');
				 $this->template->render();*/
				$this->load->view('general/myContent',$data);
			}
		}
	}



	function logout()
	{
		$this->simpleloginsecure->logout();
		redirect("general");
	}


	function adduser(){

		$this->template->write_view('sideLinks', 'general/menu');
		$this->template->write_view('bodyContent', 'general/adduser');
		$this->template->render();
	}

	function updateuser(){
		$form_data = $this->input->post();
		$uname=$form_data["u_name"];
		$username=$form_data["username"];
		$passwd=$form_data["passwd"];
		$userrole=$form_data["userrole"];
		$to_id=$form_data["to_id"];

		$this->simpleloginsecure->update($uname,$username,$passwd,$userrole,$to_id);
		echo "User Information updated successfully";
	}


	function update_details(){
		$result= $this->input->post();
		//	echo $result["name"];
		$this->simpleloginsecure->update_details($result["name"],$result["pwd"],$result["id"]);
		$this->AccountModifiedMail($result["uname"],$result["pwd"],$result["mail"]);
			
	}

	function AccountModifiedMail($UserName,$Password,$mailid){

		$form_data = $this->input->post();
			
		$mail = new PHPMailer;

		$mail->isSMTP();
		$mail->Host = 'mail.preipolar.com';
		$mail->SMTPAuth = True;
		$mail->Username = 'irshath@preipolar.com';
		$mail->Password = 'prei@123';


		$mail->From = 'info@preipolar.com';
		$mail->FromName = 'Administrator';
		$mail->addAddress($mailid);
			
		$mail->isHTML(true);

		$mail->Subject ='Leave Management System Web-Application Account';

		$body1 ="<font size='3pt' color='green'>Your Account Password has been changed  in Leave Management System Successfully..! <br><br> <b>UserName: ".$UserName."<br> New Password: ".$Password."</b><br></font>";
		$mail->Body=$body1;
		if(!$mail->send()) {
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
			exit;
		}

		echo 'Message has been sent';

	}


		

}