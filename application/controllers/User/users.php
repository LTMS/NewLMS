<?php
class Users extends CI_Controller
{   function __construct(){
	parent::__construct();
	$this->load->model('User/users_model');
	$this->load->library('SimpleLoginSecure');
	$this->load->library('My_PHPMailer');
	$this->load->library('session');
	if(!$this->session->userdata('admin_logged_in')) {
		redirect("logincheck");
	}
}

function list_users(){
	$data["menu"]='users';
	$data["submenu"]='list_users';
	$data['users']=$this->users_model->get_users_list();
	$this->template->write('titleText', "Users List");
	$this->template->write_view('sideLinks', 'general/menu',$data);
	$this->template->write_view('bodyContent', 'User/listusers',$data);
	$this->template->render();
}

function add_new_user(){
	$data["menu"]='users';
	$data["submenu"]='add_new_user';
	$data["deptlist"]=$this->users_model->get_dept();
	$data["rolelist"]=$this->users_model->get_roles();
	//$data["reporter"]=$this->users_model->get_reporter();
	//$data["approvers"]=$this->users_model->get_approvers();
	$this->template->write('titleText', "Add New User");
	$this->template->write_view('sideLinks', 'general/menu',$data);
	$this->template->write_view('bodyContent', 'User/adduser',$data);
	$this->template->render();
}

function employee_details(){
	$data["menu"]='my_account';
	$data["submenu"]='employee_details';
	$data["details"]=$this->users_model->getDetails($this->session->userdata('fullname'));
	$data["details1"]=$this->users_model->getDetails1($this->session->userdata('fullname'));
	$this->template->write('titleText', "Employee Details");
	$this->template->write_view('sideLinks', 'general/menu',$data);
	$this->template->write_view('bodyContent', 'User/employee_details',$data);
	$this->template->render();
}


function fetch_user_info($user_id)
{
	$data['user_info'] = $this->users_model->get_user_info($user_id);
	$this->load->view("users/user_info_form",$data);

}
function remove_user_info($user_id)
{
	$form_data = $this->input->post();
	$this->users_model->remove_user_info($form_data["user_id"],$form_data["name"]);

}

function check_username($emp_num)
{
	$emp_num=str_replace('%20',' ', $emp_num);
	echo $this->users_model->check_username($emp_num);
}


function get_team_leader(){
	$form_data = $this->input->post();
	echo $this->users_model->get_team_leader($form_data['dept']);
		
}

function get_reporters(){
	$form_data = $this->input->post();
	$reporters="";
	$result=$this->users_model->get_reporters($form_data['dept']);
	$list="";
	foreach($result as $row){
		$reporters=$row["Reporter"];
		$list=$list.'::'.$reporters;
	}
	echo $list;
}

function get_approvers(){
	$form_data = $this->input->post();
	$result=$this->users_model->get_approvers($form_data['dept']);
	$list="";
	foreach($result as $row){
		$approvers=$row["Approver"];
		$list=$list.'::'.$approvers;
	}
	echo $list;

}

function check_EmpNumber(){
	$form_data=$this->input->post();
	$result=$this->users_model->check_EmpNumber($form_data['emp_num']);
	foreach($result as $row){
		$count=$row["Count"];
	}
	echo $count;
}


function updateEmployees_Details1(){
	$form_data = $this->input->post();
	$this->users_model->updateEmployees_Details1($form_data['name'],$form_data['f_name'],$form_data['gender'],$form_data['blood'],$form_data['sub_blood'],$form_data['dob'],$form_data['marital'],$form_data['mail'],$form_data['doj']);
	//	$this->users_model->update_admin_users($form_data['name'],$form_data['mail'],$form_data['doj']);
}

function updateEmployees_Details2(){
	$form_data = $this->input->post();
	$this->users_model->updateEmployees_Details2($form_data['name'],$form_data['mobile'],$form_data['phone'],$form_data['desig'],$form_data['pf'],$form_data['bank'],$form_data['branch'],$form_data['accno'],$form_data['insur']);
}

function updateEmployees_Details3(){
	$form_data = $this->input->post();
	$this->users_model->updateEmployees_Details3($form_data['name'],$form_data['adr1'],$form_data['adr2'],$form_data['adr3'],$form_data['city'],$form_data['state'],$form_data['country'],$form_data['post']);
}

function updateEmployees_Details4(){
	$form_data = $this->input->post();
	$this->users_model->updateEmployees_Details4($form_data['name'],$form_data['Eadr1'],$form_data['Eadr2'],$form_data['Eadr3'],$form_data['Ecity'],$form_data['Estate'],$form_data['Ecountry'],$form_data['Epost']);
	$this->users_model->updateEmployees_Details5($form_data['name'],$form_data['adr1'],$form_data['adr2'],$form_data['adr3'],$form_data['city'],$form_data['state'],$form_data['country'],$form_data['post']);
}
function Users_Info()
{
	$data["menu"]='misc';
	$data["submenu"]='users_info';
	$data["result"]=$this->users_model->Users_Info();
	$this->template->write('titleText', "Employees Profile");
	$this->template->write_view('sideLinks', 'general/menu',$data);
	$this->template->write_view('bodyContent', 'User/users_info',$data);
	$this->template->render();
}



function create_user()
{
	$form_data = $this->input->post();
	$emp_name=$form_data["emp_name"];
	$emp_number=$form_data["emp_num"];
	$passwd=$form_data["passwd"];
	$userrole=$form_data["userrole"];
	$dept=$form_data["dept"];
	$reporter=$form_data["reporter"];
	$approver=$form_data["approver"];
	$doj=$form_data["doj"];
	$mail=$form_data["mail"];
		
	$createdby=$this->session->userdata('admin_user_email');
	$data["result"]=$this->users_model->add_employees_table($emp_number,$emp_name,$dept,$doj,$reporter,$approver,$mail);
	$this->simpleloginsecure->create($emp_number,$emp_name,$passwd,$userrole,$createdby);
	$this->AccountMail($emp_number,$passwd,$mail);
	redirect("User/users/add_new_user");
}

function AccountMail($UserName,$Password,$mailID){

	$form_data = $this->input->post();
		
	$mail = new PHPMailer;

	$mail->isSMTP();
	$mail->Host = 'mail.preipolar.com';
	$mail->SMTPAuth = True;
	$mail->Username = 'irshath@preipolar.com';
	$mail->Password = 'prei@123';


	$mail->From = 'info@preipolar.com';
	$mail->FromName = 'Administrator';
	$mail->addAddress($mailID);
		
	$mail->isHTML(true);

	$mail->Subject ='Leave Management System Web-Application Account';

	$body1 ="<font size='3pt' color='green'>Your Account was created in Leave Management System Successfully..! <br><br> <b>User ID: ".$UserName."<br> Password: ".$Password."</b><br></font>";
	$body2 ="<br> <b><font size='3pt' color='red'> * Please submit your details in the Menu:</font><font color='brown' size='3pt'> <i>My Account Details -> My Profile </i></font><br><br><font size='3pt' color='blue'> Login Now using this link:...............    </font>";
	$mail->Body=$body1.$body2;
	if(!$mail->send()) {
		echo 'Message could not be sent.';
		echo 'Mailer Error: ' . $mail->ErrorInfo;
		exit;
	}

	echo 'Message has been sent';

}



}
?>