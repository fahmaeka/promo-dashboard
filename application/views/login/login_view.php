<?php $this->load->view('templates/_header_login'); ?>
<form id="login-form" class="login-form" action="<?php echo site_url('login'); ?>" method="post">
    <h3 class="form-title font-grey-gallery">Login</h3>
    <div id="message">
		<?php
		if (!empty($success_message)) { echo $success_message; }
		if (!empty($error_message)) { echo $error_message; }
		?>
	</div>
    <div class="alert alert-danger display-hide">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="icon-cross"></i></button>
        <span>Enter any username and password. </span>
    </div>
    <div class="form-group">
        <label class="control-label visible-ie8 visible-ie9">Username</label>
        <div class="input-icon">
            <i class="fa fa-user"></i>
            <input type="text" name="login_username" class="form-control" placeholder="Username">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label visible-ie8 visible-ie9">Password</label>
        <div class="input-icon">
            <i class="fa fa-key"></i>
            <input type="password" name="login_password" class="form-control" placeholder="Password">
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-default btn-medium btn-block orange">LOGIN</button>
    </div>
</form>
<?php $this->load->view('templates/_footer_login'); ?>