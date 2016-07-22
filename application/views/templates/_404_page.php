<?php
    $this->load->view('templates/_header');
?>
<link href="<?php echo base_url();?>assets/css/pages/error.css" rel="stylesheet" type="text/css"/>
<div class="page-container">
    <?php 
        $this->load->view('templates/_navigation_menu');
    ?>
    <div class="page-content-wrapper">
        <div class="page-content">
            
            <!-- BEGIN PAGE HEADER-->
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->
					<h3 class="page-title">
					404 <small>Page</small>
					</h3>
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<i class="fa fa-home"></i>
							<a href="<?php echo base_url();?>home">
								Home
							</a>
							<i class="fa fa-angle-right"></i>
						</li>
						<li>
							<a href="#">
								404 Page
							</a>
						</li>
					</ul>
					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12 page-404">
					<div class="number">
						 404
					</div>
					<div class="details">
						<h3>Oops! You're lost.</h3>
						<p>
							 We can not find the page you're looking for or you don't have access to this page.<br/>
							<a href="<?php echo base_url();?>home">
								 Return home
							</a>
							 
						</p>
					</div>
				</div>
			</div>
			<!-- END PAGE CONTENT-->
        </div>
    </div>
</div>
<?php
    $this->load->view('templates/_footer');
?>