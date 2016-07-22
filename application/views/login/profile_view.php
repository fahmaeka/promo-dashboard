<?php $this->load->view('templates/_header');
?>
<link href="<?php echo base_url()?>assets/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" type="text/css"/>
<div class="page-container">
    <?php $this->load->view('templates/_navigation_menu'); ?>
    <div class="page-content-wrapper">
        <div class="page-content">
			<h3 class="page-title">Profile</h3>
			<div class="row">
				<div class="col-md-12">
					<div class="portlet box orange">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject"><?php echo $form_title; ?></span>
							</div>
						</div>
						<ul class="nav nav-tabs">
						  <li class="active"><a data-toggle="tab" href="#profile">Profile</a></li>
						  <li><a data-toggle="tab" href="#change_password">Change Password</a></li>
						</ul>
						
						<div class="tab-content">
							<div id="profile" class="tab-pane fade in active portlet-body form">
								<form id="form" class="form-horizontal form-bordered" action="<?php echo $form_action; ?>" method="post" novalidate="novalidate">
								<div id="general_section">
									<div id="info-message">
										<?php if (!empty($success_message)) { echo $success_message; } ?>
										<?php if (!empty($error_message)) { echo $error_message; } ?>
									</div>
									<div id="transaction_section">
										<?php echo $form; ?>
									</div>
									<div class="form-actions">
									<div class="row">
										<div class="col-sm-offset-3 col-sm-9">
											
											<button id="show_transaction_detail" class="btn blue">
												<i class="fa fa-save"></i>&nbsp;&nbsp;Save Profile
											</button>
										</div>
									</div>
								</div>
									
								</div>
								
								</form>
							</div>
							
							<div id="change_password" class="tab-pane fade in portlet-body form">
								<form id="form_change_password" class="form-horizontal form-bordered" action="<?php echo $form_change_password_action; ?>" method="post" novalidate="novalidate">
								<div id="general_section">
									<div id="transaction_section">
										<div class="form-group">
											<label for="old_password" class="col-sm-2 control-label">Old Password</label>
											<div class="col-sm-9">
												<input type="password" name="old_password" id="old_password" class="form-control required">
											</div>
										</div>
										<div class="form-group">
											<label for="new_password" class="col-sm-2 control-label">New Password</label>
											<div class="col-sm-9">
												<input type="password" name="new_password" id="new_password" class="form-control required">
											</div>
										</div>
										<div class="form-group">
											<label for="confirm_password" class="col-sm-2 control-label">Confirm Password</label>
											<div class="col-sm-9">
												<input type="password" name="confirm_password" id="confirm_password" class="form-control required">
											</div>
										</div>
										
									</div>
									<div class="form-actions">
									<div class="row">
										<div class="col-sm-offset-3 col-sm-9">
											
											<button id="show_transaction_detail" class="btn blue">
												<i class="fa fa-save change_password"></i>&nbsp;&nbsp;Change Password
											</button>
										</div>
									</div>
								</div>
									
									
								</div>
								
								</form>
							</div>
							
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('templates/_footer', $output); ?>