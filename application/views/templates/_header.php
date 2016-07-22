<!DOCTYPE html>
<!--[if IE 8]> <html lang='en' class='ie8 no-js'> <![endif]-->
<!--[if IE 9]> <html lang='en' class='ie9 no-js'> <![endif]-->
<!--[if !IE]><!-->
<html lang='en' class='no-js'>
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset='utf-8'/>
<title>Ezytravel | Dashboard</title>
<meta http-equiv='X-UA-Compatible' content='IE=edge'>
<meta content='width=device-width, initial-scale=1' name='viewport'/>
<meta content='' name='description'/>
<meta content='' name='author'/>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all' rel='stylesheet' type='text/css'/>
<link href='<?php echo base_url()?>assets/plugins/font-awesome/css/font-awesome.min.css' rel='stylesheet' type='text/css'/>
<link href='<?php echo base_url()?>assets/plugins/bootstrap/css/bootstrap.min.css' rel='stylesheet' type='text/css'/>
<link href='<?php echo base_url()?>assets/plugins/uniform/css/uniform.default.css' rel='stylesheet' type='text/css'/>
<link href='<?php echo base_url()?>assets/plugins/gritter/css/jquery.gritter.css' rel='stylesheet' type='text/css'/>
<link href="<?php echo base_url()?>assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css" rel="stylesheet" type="text/css">

<!--CSS-->
<link href='<?php echo base_url()?>assets/css/style-metronic.css' rel='stylesheet' type='text/css'/>
<link href='<?php echo base_url()?>assets/css/style.css' rel='stylesheet' type='text/css'/>
<link href='<?php echo base_url()?>assets/css/style-responsive.css' rel='stylesheet' type='text/css'/>
<link href='<?php echo base_url()?>assets/css/plugins.css' rel='stylesheet' type='text/css'/>
<link href='<?php echo base_url()?>assets/css/pages/tasks.css' rel='stylesheet' type='text/css'/>
<link href='<?php echo base_url()?>assets/css/themes/default.css' rel='stylesheet' type='text/css' id='style_color'/>
<link href='<?php echo base_url()?>assets/css/print.css' rel='stylesheet' type='text/css' media='print'/>
<link href='<?php echo base_url()?>assets/css/custom.css' rel='stylesheet' type='text/css'/>
<link href='<?php echo base_url()?>assets/plugins/bootstrap-datepicker/css/datepicker3.css' rel='stylesheet' type='text/css'/>
<link href='<?php echo base_url()?>assets/plugins/bootstrap-datetimepicker/css/datetimepicker.css' rel='stylesheet' type='text/css'/>
<link href='<?php echo base_url()?>assets/plugins/bootstrap-daterangepicker/daterangepicker.css' rel='stylesheet' type='text/css'/>
<link href='<?php echo base_url()?>assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css' rel='stylesheet' type='text/css'/>
<link href='<?php echo base_url()?>assets/plugins/fullcalendar/fullcalendar/fullcalendar.css' rel='stylesheet' type='text/css'/>

<script src='<?php echo base_url()?>assets/scripts/core/jquery.min.js' type='text/javascript'></script>

<!--END CSS-->
<link rel='shortcut icon' href='favicon.ico'/>

</head>
<body class='page-header-fixed'>
    
<div class='header navbar navbar-fixed-top'>
    <div class='header-inner'>
        <a class='navbar-brand' href='<?php echo base_url();?>home'>
            
        </a>
        <a href='javascript:;' class='navbar-toggle' data-toggle='collapse' data-target='.navbar-collapse'>
            <img src='<?php echo base_url()?>assets/img/menu-toggler.png' alt=''/>
        </a>
        <ul class='nav navbar-nav pull-right'>
            <li class='dropdown user'>
                <a href='#' class='dropdown-toggle' data-toggle='dropdown' data-hover='dropdown' data-close-others='true'>
                </a>
            </li>
            <li class='dropdown user'>
                <a href='#' class='dropdown-toggle' data-toggle='dropdown' data-hover='dropdown' data-close-others='true'>
                    <i class='fa fa-user'></i>
                    <span class='username'>
                        <?php
                        $user = $this->session->userdata('login');
                        echo $user['customer_username'];
                        ?>
                    </span>
                    <i class='fa fa-angle-down'></i>
                </a>
                <ul class='dropdown-menu'>
					<li>
						<a href='<?php echo base_url()?>profile'>
						<i class='fa fa-user'></i>
							My Profile
						</a>
					</li>
                    <li>
                        <a href='<?php echo base_url()?>login/logout'>
                            <i class='fa fa-key'></i> Log Out
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
    
<div class='clearfix'> </div>