<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<link rel="shortcut icon" style='width:30'
	href="../../images/project-icon.ico" />
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<?php $this->load->view("template/includes/scripts"); ?>
<?php $this->load->view("template/includes/styles"); ?>
<title><?php echo $titleText?></title>
</head>
<body>

	<div id="sidebar" style="background: #59955C">
		<div id="sidebar-wrapper">
			<div id="profile-links">
				<img src="<?php echo base_url(); ?>/images/DEASLogo.jpg"
					width="170px" height="100px;" />

			</div>

			<?php if($this->session->userdata('admin_logged_in')){?>
			<ul id="main-nav">
			<?php echo $sideLinks?>
			</ul>
			<?php }?>
		</div>

	</div>

	<div id="main-content">
	<?php echo $bodyContent?>

	</div>

</body>
</html>
