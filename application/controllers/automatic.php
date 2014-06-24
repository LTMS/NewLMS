<?php
class Automatic extends CI_Controller
{


	function __construct()
	{
		parent::__construct();
		$this->load->model('ts_model');
		$this->load->helper('url');
		$this->load->library('My_PHPMailer');
			
		parent::__construct();

	}
	function index()
	{
		echo "koko";
	}
	function message()
	{
			
		echo "OKOKO";
		$UnFollowers_List="";
		$Followers_List="";
		$users=$this->ts_model->fetch_all_users();
		foreach($users as $row)
		{

			$individual_user=$row['Name'];
			$data=$this->ts_model->fetch_unfollowers_timesheet($individual_user);
			$UnFollowers=explode('*', $data);
			$Followers=explode('^', $data);
			$UnFollowers=$UnFollowers[0];
			$UnFollowers_List=$UnFollowers_List."".$UnFollowers;
			$Followers=$Followers[0];
			$Followers_List=$Followers_List."".$Followers;
		}
		//print('<div><table border="1" align="center" cellpading="0" cellspacing="0" width="100%">');
		$info_mail=$this->ts_model->fetch_info_mail_id();
		$Follower=explode('*', $Followers_List);
		/*for($i=0;$i<sizeof($Follower);$i++)
		 {
		 $followers_mail=$this->ts_model->fetch_followers_mail_id($Follower[$i]);
		 if($Follower[$i] != "")
		 {
		 $mail = new PHPMailer;
		 $mail->isSMTP();
		 $mail->Host = 'mail.preipolar.com';
		 $mail->SMTPAuth = True;
		 $mail->Username = 'irshath@preipolar.com';
		 $mail->Password = 'prei@123';
		 $mail->From = $info_mail;
		 $mail->FromName = 'LMS';
		 $mail->addAddress($followers_mail);
		 $mail->isHTML(true);

		 $mail->Subject = "Regarding Your TimeSheet Updation";
		 $mail->Body    = "Dear"."  ".$Follower[$i].",

		 "."You have successfully updated the timesheet for lastweek in Leave Management System.";
		 //	$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		 if(!$mail->send()) {
		 echo 'Message could not be sent.';
		 echo 'Mailer Error: ' . $mail->ErrorInfo;
		 exit;
		 }
		 //echo $Follower[$i]."message has been sent";
		 }
		 	
		 print('<tr style="bgcolor:grey">');
		 print('<td align="center" style="font-size:14px;font-weight:bold;color:blue">'.$Follower[$i].'</td>');
		 print('<td align="center" style="font-size:14px;font-weight:bold;color:blue">'.$followers_mail.'</td>');
		 print('</tr>');

		 }

		 print('</table>');*/

		//print('<div><table border="1" align="center" cellpading="0" cellspacing="0" width="100%">');
		$UnFollower=explode('^', $UnFollowers_List);
		for($i=0;$i<sizeof($UnFollower);$i++)
		{
			$Unfollowers_mail=$this->ts_model->fetch_Unfollowers_mail_id($UnFollower[$i]);
			if($UnFollower[$i] != "")
			{
				$mail = new PHPMailer;
				$mail->isSMTP();
				$mail->Host = 'mail.preipolar.com';
				$mail->SMTPAuth = True;
				$mail->Username = 'irshath@preipolar.com';
				$mail->Password = 'prei@123';
				$mail->From = $info_mail;
				$mail->FromName = 'LMS';

				$mail->addAddress($Unfollowers_mail);
				$mail->isHTML(true);
				$mail->Subject = "Time Sheet Alert";
				$mail->Body    = "Dear"."  ".$UnFollower[$i].",

												 "."You have not updated the timesheet for lastweek.So kindly update Your Timesheet. Last week days will be locked @ 2.00 PM.";
				//	$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

				if(!$mail->send()) {
					echo 'Message could not be sent.';
					echo 'Mailer Error: ' . $mail->ErrorInfo;
					exit;
				}
				//echo $UnFollower[$i]."message has been sent";
			}

			print('<tr style="bgcolor:grey">');
			print('<td align="center" style="font-size:14px;font-weight:bold;color:red">'.$UnFollower[$i].'</td>');
			print('<td align="center" style="font-size:14px;font-weight:bold;color:red">'.$Unfollowers_mail.'</td>');
			print('</tr>');
		}
		//print('</table>');
		//echo "Color blue for followers;Red for Unfollowers";
		$data="";
		$MD_mail=$this->ts_model->fetch_MD_mail_id();

		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->Host = 'mail.preipolar.com';
		$mail->SMTPAuth = True;
		$mail->Username = 'irshath@preipolar.com';
		$mail->Password = 'prei@123';
		$mail->From = $info_mail;
		$mail->FromName = 'LMS';

		$mail->addAddress($MD_mail);
		$mail->addAddress($info_mail);
		$mail->addAddress('gnana.jeyam@deastech.com');
		$mail->isHTML(true);
		$mail->Subject = "Employees TimeSheet Alert";
		$a="Dear Sir,";
		$b="The Following Employees have not updated the Timesheet for lastweek.";
		$UnFollower=explode('^', $UnFollowers_List);
		$length=sizeof($UnFollower);
		for($i=1;$i<$length;$i++)
		{
			$data=$data."<tr style='bgcolor:grey'><td align='center' style='font-weight:bold;'>$i</td><td  align='center' style='font-size:14px;font-weight:bold;'>$UnFollower[$i]</td></tr>";
		}

		$c=	"
								<html>
								
								<body>
								<table border='0' align='center' cellpading='0' cellspacing='0' width='100%'>
								<tr><td></td></tr>
								<tr><td style='font-size:14px;color:black'>$a</td></tr> </br>
								<tr><td  style='font-size:14px;color:black'>$b</td></tr>
								</table>
								</br>
								</br>
							 	<div><table border='1' align='center' cellpading='0' cellspacing='0' width='70%' style='margin: 40px 0px 0px 50px;'>
								<tr style='bgcolor:grey'><td align='center' width='25' style='font-weight:bold;'>SNo</td><td  align='center' width='45' style='font-size:14px;font-weight:bold;'>Employee Name</td></tr>	
							 	";
		$d="
		$data
								 </table>
								 </body>
								</html>";
		$mail->Body =$c.$d;
			
			
		//	$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		if(!$mail->send()) {
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
			exit;
		}
		//echo $MD_mail."message has been sent";
			
		//echo "Sakthi";
		echo "Do not close this window.It will be closed automatically";
	}
	//Modified by Sakthivel.k On 27.03.2014
	function  block_dates()
	{

		$users=$this->ts_model->fetch_all_users();
		foreach($users as $row)
		{

			$individual_user=$row['Name'];
			$data=$this->ts_model->fetch_unfollowers_details($individual_user);
			echo $data;
		}
	}
	//Modified by Sakthivel.k On 17.04.2014
	function Lastweek_Leavesummary()
	{
		$details=$this->ts_model->Fetch_Lastweek_Leavesummary();
		$weekdetails=$this->ts_model->Fetch_Lastweek_Details();
		print("<table border='1' align='center' style='border-collapse:collapse;margin-top:350px;' width='50%' >");
		print("<tr width='50%' bgcolor='#347c17'>");
		print("<td colspan='4' align='center' style='color:#e5e4e2;font-weight:bold;'>Last Week Employees Leave Summary</td>");
		print("</tr>");
		print("<tr bgcolor='#d1d0ce'>");
		print("<td width='15%' align='center' style='color:#483c32;font-weight:bold;'>User Name</td>");
		print("<td width='13%' align='center' style='color:#483c32;font-weight:bold;'>Leave Type</td>");
		print("<td width='12%' align='center' style='color:#483c32;font-weight:bold;'>From Date</td>");
		print("<td width='10%' align='center' style='color:#483c32;font-weight:bold;'>No of Days</td>");
		print("</tr>");
		foreach($details as $row)
		{
			$counter++;
			print("<tr bgcolor='#d1d0ce'>");
			print("<td width='15%' align='center' style='color:#483c32;'>".$row['USER']."</td>");
			print("<td width='13%' align='center' style='color:#483c32;'>".$row['LEAVETYPE']."</td>");
			print("<td width='12%'align='center'  style='color:#483c32;'>".$row['FROMDATE']."</td>");
			print("<td width='10%' align='center' style='color:#483c32;'>".$row['TOTALDAYS']."</td>");
			print("</tr>");
		 print("<input type='hidden' id='TotalRows' value='$counter'>");
		}
		print("</table>");
		if ($counter != 0)
		{
			$MD_mail=$this->ts_model->fetch_MD_mail_id();
			$info_mail=$this->ts_model->fetch_info_mail_id();
			//echo $MD_mail;
			//echo $info_mail;
			$mail = new PHPMailer;
			$mail->isSMTP();
			$mail->Host = 'mail.preipolar.com';
			$mail->SMTPAuth = True;
			$mail->Username = 'irshath@preipolar.com';
			$mail->Password = 'prei@123';
			$mail->From = $info_mail;
			$mail->FromName = 'LMS';

			$mail->addAddress($MD_mail);
			$mail->addAddress($info_mail);
			$mail->isHTML(true);
			$mail->Subject = "Employess Leave Summary for ".$weekdetails;
			$a="Dear Sir,";
			$b="The Following Employees have taken the leave in last week.";
			$data="";
			foreach($details as $row)
			{
				$data=$data."<tr bgcolor='#d1d0ce'><td width='15%' align='center' style='color:#483c32;'>".$row['USER']."</td>
																	   <td width='13%' align='center' style='color:#483c32;'>".$row['LEAVETYPE']."</td>
																	   <td width='12%'align='center'  style='color:#483c32;'>".$row['FROMDATE']."</td>
																	    <td width='10%' align='center' style='color:#483c32;'>".$row['TOTALDAYS']."</td>
												</tr>";	
			}

			$c=	"
								<html>
								
								<body>
								<table border='0' align='center' cellpading='0' cellspacing='0' width='100%'>
								<tr><td></td></tr>
								<tr><td style='font-size:14px;color:black'>$a</td></tr> </br>
								<tr><td style='font-size:14px;color:black;'>$b</td></tr>
								</table>
								</br>
								</br>
							 	<table border='1' align='center' style='border-collapse:collapse;margin-top:10px;' width='50%'>
								<tr width='50%' bgcolor='#347c17'>	
							 	<td colspan='4' align='center' style='color:#e5e4e2;font-weight:bold;'>Last Week Employees Leave Summary</td>
								</tr>
							 	<tr bgcolor='#d1d0ce'>
								<td width='13%' align='center' style='color:#483c32;font-weight:bold;'>User Name</td>
							 	<td width='12%' align='center' style='color:#483c32;font-weight:bold;'>Leave Type</td>
								<td width='12%' align='center' style='color:#483c32;font-weight:bold;'>From Date</td>
							 	<td width='13%' align='center' style='color:#483c32;font-weight:bold;'>No of Days</td>
							 	</tr>
								";
			$d="
			$data
								 </table>
								 </body>
								</html>";
			$mail->Body =$c.$d;
				
				
			//	$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

			if(!$mail->send()) {
				echo 'Message could not be sent.';
				echo 'Mailer Error: ' . $mail->ErrorInfo;
				exit;
			}
		}

	}
}
?>