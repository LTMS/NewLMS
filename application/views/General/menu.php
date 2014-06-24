
<!-- Leave Management -->

<li><a href="javascript:void(0);" class="nav-top-item <?php if(($this->session->userdata('admin_logged_in'))&&($menu=='LMS')) echo "current"; ?>">Leave Management</a>
			<ul style="display: block;">
					<?php if($this->session->userdata('Emp_Role')=='Engineer' || $this->session->userdata('Emp_Role')=='teamleader' || $this->session->userdata('Emp_Role')=='admin'){ ?>	
	 	  				<li><a href="<?php echo site_url("Leave/apply/apply_leave"); ?>" <?php if ($submenu=='apply'){?>class="current"<?php }?> >Apply For Leave</a></li>
	    				<li><a href="<?php echo site_url("Leave/history/my_leave_history"); ?>" <?php if ($submenu=='history'){?>class="current"<?php }?> >My Leave History</a></li>
	     	 			<li><a href="<?php echo site_url("Leave/summary/my_leave_summary"); ?>" <?php if ($submenu=='my_summary'){?>class="current"<?php }?> >My Leave Summary</a></li>
      	 			<?php }?>	
      	 			
					<?php if( $this->session->userdata('Emp_Role')=='teamleader'){ ?>				
						<li><a href="<?php echo site_url("Leave/history/pending_applications"); ?>" <?php if ($submenu=='pending_applications'){?>class="current"<?php }?> >Pending Leave Applications</a></li>
  					<?php }?>
  					
					<?php if( $this->session->userdata('Emp_Role')=='MD'){ ?>	
						<li><a href="<?php echo site_url("Leave/history/pending_applications"); ?>" <?php if ($submenu=='pending_applications'){?>class="current"<?php }?> >Level - 2  Applications</a></li>
	    				<li><a href="<?php echo site_url("Leave/history/pending_applications_lev1"); ?>" <?php if ($submenu=='pending_applications_lev1'){?>class="current"<?php }?> >Level - 1 Applications</a></li>
						<li><a href="<?php echo site_url("Leave/history/permissions"); ?>" <?php if ($submenu=='permissions'){?>class="current"<?php }?> >Pending Permissions</a></li>
						<li><a href="<?php echo site_url("Leave/history/history_md"); ?>" <?php if ($submenu=='history_admin'){?>class="current"<?php }?> >Employees Leave History</a></li>
	    				<li><a href="<?php echo site_url("Leave/summary/leave_summary_md"); ?>" <?php if ($submenu=='summary'){?>class="current"<?php }?> >Employees Leave Summary</a></li>
	    				<li><a href="<?php echo site_url("Leave/leave_misc/leave_reprocess"); ?>" <?php if ($submenu=='reprocess'){?>class="current"<?php }?> >Reprocess Approved Leaves</a></li>
					
							<?php if( $this->session->userdata('Emp_Role')=='MD'){ ?>				
			    				<li><a href="<?php echo site_url("Leave/leave_misc/lms_intro_md"); ?>" <?php if ($submenu=='lms_intro_md'){?>class="current"<?php }?> >Leave Management Criteria</a></li>
			  				<?php }?>
		  					<?php if( $this->session->userdata('Emp_Role')=='teamleader' || $this->session->userdata('Emp_Role')=='user'){ ?>
		    					<li><a href="<?php echo site_url("Leave/leave_misc/lms_intro_emp"); ?>" <?php if ($submenu=='lms_intro_emp'){?>class="current"<?php }?> >Leave Management Criteria</a></li>
		  					<?php }?>

					<?php }?>
		 </ul>
</li>

<!-- Timesheet Management -->

<li><a href="javascript:void(0);" class="nav-top-item <?php if(($this->session->userdata('admin_logged_in'))&&($menu=='timesheet')) echo "current"; ?>">TimeSheet Management</a>
			<ul style="display: block;">
					<?php if($this->session->userdata('Emp_Role')=='Engineer' || $this->session->userdata('Emp_Role')=='teamleader' || $this->session->userdata('Emp_Role')=='admin'){ ?>	
    	  			<li><a href="<?php echo site_url("Timesheet/timesheet_entry/entry"); ?>" <?php if ($submenu=='entry'){?>class="current"<?php }?> >Time Sheet Entry</a></li>
    				<li><a href="<?php echo site_url("Timesheet/timesheet_reports/mysheet"); ?>" <?php if ($submenu=='mysheet'){?>class="current"<?php }?> >My Time Sheet Report</a></li>
    				<li><a href="<?php echo site_url("Timesheet/overtime/my_ot"); ?>" <?php if ($submenu=='my_ot'){?>class="current"<?php }?> >My Over Time Details</a></li>
    				<li><a href="<?php echo site_url("Timesheet/overtime/my_otsummary"); ?>" <?php if ($submenu=='my_otsummary'){?>class="current"<?php }?> >My Over Time Summary</a></li>
    				
 		   			<li><a href="<?php echo site_url("Timesheet/timesheet_entry/intro_admin"); ?>" <?php if ($submenu=='tms_intro'){?>class="current"<?php }?> >Time Sheet Criteria</a></li>
				
    				<?php }?>
					<?php if( $this->session->userdata('Emp_Role')=='teamleader'){ ?>	
					<li><a href="<?php echo site_url("Timesheet/timesheet/teamsheet_leader"); ?>" <?php if ($submenu=='teamsheet_leader'){?>class="current"<?php }?> >My Team Time Sheet</a></li> 
					<?php }?>	
					<?php if( $this->session->userdata('Emp_Role')=='MD'){ ?>
				
					<li><a href="<?php echo site_url("Timesheet/timesheet/teamsheet"); ?>" <?php if ($submenu=='teamsheet'){?>class="current"<?php }?> >Employees Time Sheet</a></li>
    		 		<li><a href="<?php echo site_url("Timesheet/timesheet/teamsheet_dept"); ?>" <?php if ($submenu=='teamsheet_dept'){?>class="current"<?php }?> >Extensive Time Sheet Report</a></li>
    		 		<li><a href="<?php echo site_url("Timesheet/overtime/admin_ot"); ?>" <?php if ($submenu=='admin_ot'){?>class="current"<?php }?> >Employees O-T Details</a></li>
    		 		<li><a href="<?php echo site_url("Timesheet/overtime/admin_otsummary"); ?>" <?php if ($submenu=='admin_otsummary'){?>class="current"<?php }?> >Employees O-T Summary</a></li>
 		   		 	<li><a href="<?php echo site_url("Timesheet/overtime/ack_ot_history"); ?>" <?php if ($submenu=='ack_ot_history'){?>class="current"<?php }?> >Acknowledged OT History</a></li>
 		   		 	<li><a href="<?php echo site_url("Timesheet/timesheet/intro"); ?>" <?php if ($submenu=='tms_intro'){?>class="current"<?php }?> >Time Sheet Criteria</a></li>
					<?php }?>
     	</ul>
</li>

<!-- Employee Reports -->

<?php if( $this->session->userdata('Emp_Role')=='admin'){ ?>
<li><a href="javascript:void(0);" class="nav-top-item <?php if(($this->session->userdata('admin_logged_in'))&&($menu=='e_reports')) echo "current"; ?>">Employees Reports</a>
			<ul style="display: block;">
	   				<li><a href="<?php echo site_url("Leave/lms/history_admin"); ?>" <?php if ($submenu=='history_admin'){?>class="current"<?php }?> >Employees Leave History</a></li>
	     			<li><a href="<?php echo site_url("Leave/lms/leave_summary"); ?>" <?php if ($submenu=='summary'){?>class="current"<?php }?> >Employees Leave Summary</a></li>
		   			<li><a href="<?php echo site_url("Timesheet/timesheet/teamsheet"); ?>" <?php if ($submenu=='teamsheet'){?>class="current"<?php }?> >Employees Time Sheet</a></li>
	    			<li><a href="<?php echo site_url("Timesheet/timesheet/teamsheet_dept"); ?>" <?php if ($submenu=='teamsheet_dept'){?>class="current"<?php }?> >Extensive Time Sheet Report</a></li>  
	     		 	<li><a href="<?php echo site_url("Timesheet/overtime/admin_ot"); ?>" <?php if ($submenu=='admin_ot'){?>class="current"<?php }?> >Employees O-T Details</a></li>
	     		 	<li><a href="<?php echo site_url("Timesheet/overtime/admin_otsummary"); ?>" <?php if ($submenu=='admin_otsummary'){?>class="current"<?php }?> >Employees O-T Summary</a></li>
	    		 	<li><a href="<?php echo site_url("Timesheet/overtime/ack_ot_history"); ?>" <?php if ($submenu=='ack_ot_history'){?>class="current"<?php }?> >Acknowledged OT History</a></li>
  		</ul>
</li>
<?php }?>


<!-- Miscellaneous -->

<li><a href="javascript:void(0);" class="nav-top-item <?php if(($this->session->userdata('admin_logged_in'))&&($menu=='misc')) echo "current"; ?>">Miscellaneous</a>
			<ul style="display: block;">
					<?php if($this->session->userdata('Emp_Role')=='Engineer' || $this->session->userdata('Emp_Role')=='teamleader' || $this->session->userdata('Emp_Role')=='admin' ) {?>
    				<li><a href="<?php echo site_url("Timesheet/timesheet/addjobs"); ?>" <?php if ($submenu=='addjobs'){?>class="current"<?php }?> >Manage Jobs</a></li> 
					<?php }?>
					<?php if($this->session->userdata('Emp_Role')=='Engineer' || $this->session->userdata('Emp_Role')=='teamleader'){?>
    				<li><a href="<?php echo site_url("general/holidays_emp");?>" <?php if ($submenu=='holidays_emp'){?>class="current"<?php }?> > Holidays  Details</a></li>
					<?php }?>
					<?php if($this->session->userdata('Emp_Role')=='MD' || $this->session->userdata('Emp_Role')=='admin'){?>
					<li><a href="<?php echo site_url("Leave/lms/add_dept"); ?>" <?php if ($submenu=='add_dept'){?>class="current"<?php }?> >Manage Departments</a></li>
    				<li><a href="<?php echo site_url("general/holidays");?>" <?php if ($submenu=='holidays'){?>class="current"<?php }?> > Manage Holidays</a></li>
 					<li><a href="<?php echo site_url("general/parameters");?>" <?php if ($submenu=='parameters'){?>class="current"<?php }?> > Manage Office Time</a></li>
     		 		<li><a href="<?php echo site_url("Timesheet/timesheet/locked_users"); ?>" <?php if ($submenu=='locked_users'){?>class="current"<?php }?> >Time Sheet Locked Users</a></li>
    				<li><a href="<?php echo site_url("User/users/Users_Info");?>" <?php if ($submenu=='users_info'){?>class="current"<?php }?> > Employees Details</a></li>
					<?php }?>
					<?php if($this->session->userdata('Emp_Role')=='admin'){ ?>
					<li><a href="<?php echo site_url("Timesheet/timesheet/set_inout_time"); ?>" <?php if ($submenu=='set_inout_time'){?>class="current"<?php }?> >Update Time Office IN-OUT</a></li>
					<?php } ?>
 			</ul>
</li>

<!-- Account Details -->

<li> <a href="javascript:void(0);" class="nav-top-item <?php if($menu=='my_account') echo "current"; ?> "> My Account Details</a>
	  	<ul style="display: block;">
  					<li><a href="<?php echo site_url("User/users/employee_details");?>" <?php if ($submenu=='employee_details'){?>class="current"<?php }?> >My Profile </a></li>
 	  	   			<li><a href="<?php echo site_url("general/mydetails"); ?>" <?php if ($submenu=='mydetails'){?>class="current"<?php }?> >My App Account </a></li>
    	  </ul>
</li>


<!-- User Management -->

<?php if($this->session->userdata('Emp_Role')=='MD' || $this->session->userdata('Emp_Role')=='admin'){?>
<li> <a href="javascript:void(0);" class="nav-top-item <?php if($menu=='users') echo "current"; ?> "> User Management</a>
	 	<ul style="display: block;">
  					<li><a href="<?php echo site_url("User/users/add_new_user");?>" <?php if ($submenu=='add_new_user'){?>class="current"<?php }?> > Add New User</a></li>
 					<li><a href="<?php echo site_url("User/users/list_users");?>" <?php if ($submenu=='list_users'){?>class="current"<?php }?> > List of Users</a></li>
	    </ul>
	</li>
	<?php }?>
	<li><a class="nav-top-item" href="<?php echo site_url("general/ErrorReport");?>" <?php if ($menu=='error' && $submenu='error' ){?>class="current"<?php }?> ><font color='#2F74D0' face='Lucida Handwriting'><i>Feedback</i></font></a></li>
		
		