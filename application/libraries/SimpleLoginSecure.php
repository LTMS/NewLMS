<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once('phpass-0.1/PasswordHash.php');

define('PHPASS_HASH_STRENGTH', 8);
define('PHPASS_HASH_PORTABLE', false);


class SimpleLoginSecure
{
	var $CI;
	var $user_table = 'admin_users';

	function create($emp_number='',$emp_name='',$passwd='',$userrole='',$createdby='',$auto_login = false)
	{
		$this->CI =& get_instance();



		//Make sure account info was sent
		if($emp_number == '' OR $passwd == '') {
			return false;
		}

		//Check against user table
		$this->CI->db->where('Emp_Number', $emp_number);
		$query = $this->CI->db->get_where($this->user_table);

		if ($query->num_rows() > 0) //user_email already exists
		return false;

		//Hash user_pass using phpass
		$hasher = new PasswordHash(PHPASS_HASH_STRENGTH, PHPASS_HASH_PORTABLE);
		$user_pass_hashed = $hasher->HashPassword($passwd);

		//Insert account into the database
		$data = array(
					'Emp_Number' => $emp_number,
					'Password' => $user_pass_hashed,
					'Created_On' => date('c'),
					'Modified_On' => date('c'),
					'Emp_Role'=> $userrole,
					'Emp_Name'=>$emp_name,
					'Created_By'=>$createdby
		);

		$this->CI->db->set($data);

		if(!$this->CI->db->insert($this->user_table)) //There was a problem!
		return false;

		if($auto_login)
		$this->login($emp_number, $passwd);

		return true;
	}



	function update($emp_num,$emp_name,$passwd,$userrole){
		$this->CI =& get_instance();
		if($passwd!=''){
			$hasher = new PasswordHash(PHPASS_HASH_STRENGTH, PHPASS_HASH_PORTABLE);
			$user_pass_hashed = $hasher->HashPassword($passwd);
		}
		if($passwd==''){
			$this->CI->db->simple_query("UPDATE " . $this->user_table  . " SET Emp_Role ='".$userrole."',Emp_Name='".$emp_name."'  WHERE Emp_Number = '" .$emp_num."'");
		}
		else if($passwd!='')
		{
			$this->CI->db->simple_query("UPDATE " . $this->user_table  . " SET user_pass='".$user_pass_hashed."',Emp_Role ='".$userrole."',Emp_Name='".$emp_name."'  WHERE Emp_Number = '" .$emp_num."'");
		}

		return true;
	}



	function login($emp_num = '', $user_pass = '')
	{
		$this->CI =& get_instance();

		if($emp_num == '' OR $user_pass == '')
		return false;


		//Check if already logged in
		if($this->CI->session->userdata('admin_logged_in') == true)
		return true;


		//Check against user table
		$this->CI->db->where('Emp_Number', $emp_num);
		$query = $this->CI->db->get_where($this->user_table);


		if ($query->num_rows() > 0)
		{
			$user_data = $query->row_array();

			$hasher = new PasswordHash(PHPASS_HASH_STRENGTH, PHPASS_HASH_PORTABLE);

			if(!$hasher->CheckPassword($user_pass, $user_data['Password']))
			return false;

			//Destroy old session
			$this->CI->session->sess_destroy();
				
			//Create a fresh, brand new session
			$this->CI->session->sess_create();
			$query = $this->CI->db->query("SELECT *,b.* FROM admin_users INNER JOIN employees b ON b.Employee_Number=Emp_Number WHERE Emp_Number= '$emp_num'");
			$row = $query->row_array();
			$emp_role=$row['Emp_Role'];
			$emp_name=$row['Emp_Name'];
			$dept=$row['Department'];
			$reporter=$row['Reporter'];
			$approver=$row['Approver'];
			$email=$row['Email'];
			$image=$row['Emp_Img'];
			$this->CI->db->query("UPDATE admin_users SET Last_Login=CURRENT_TIMESTAMP  WHERE Emp_Number= '$emp_num'");

			//Set session data
			unset($user_data['user_pass']);
			$user_data['Emp_Number'] = $user_data['Emp_Number']; // for compatibility with Simplelogin
			$user_data['admin_logged_in'] = true;
			$user_data['Emp_Role'] = $emp_role;
			$user_data['Emp_Name'] = $emp_name;
			$user_data['Department'] = $dept;
			$user_data['Reporter'] = $reporter;
			$user_data['Approver'] = $approver;
			$user_data['Emp_Img']=$image;
			$this->CI->session->set_userdata($user_data);
				
			return true;
		}
		else
		{
			return false;
		}

	}




	function logout() {
		$this->CI =& get_instance();
		$this->CI->session->sess_destroy();
	}




	function delete($user_id) {
		$this->CI =& get_instance();

		if(!is_numeric($user_id))
		return false;

		return $this->CI->db->delete($this->user_table, array('user_id' => $user_id));
	}


	function update_details($name,$pwd,$id ){
		$this->CI =& get_instance();
		if($pwd!=''){
			$hasher = new PasswordHash(PHPASS_HASH_STRENGTH, PHPASS_HASH_PORTABLE);
			$pwd_hashed = $hasher->HashPassword($pwd);
		}
			
		if($pwd != ""){
			$this->CI->db->query("UPDATE admin_users SET name='$name', user_pass='$pwd_hashed', modifiedon=CURRENT_TIMESTAMP  WHERE user_id='$id' ");
				
		}
		else{
			$this->CI->db->query("UPDATE admin_users SET name='$name',   modifiedon=CURRENT_TIMESTAMP  WHERE user_id='$id' ");
		}


	}



}
?>
