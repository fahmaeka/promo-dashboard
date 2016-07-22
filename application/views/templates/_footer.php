
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<div class='footer'>
	<div class='footer-inner'>
		 Copyright (c) PT Dwidaya Indo Exchange - all rights reserved
	</div>
	<div class='footer-tools'>
		<span class='go-top'>
			<i class='fa fa-angle-up'></i>
		</span>
	</div>
</div>
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src='assets/plugins/respond.min.js'></script>
<script src='assets/plugins/excanvas.min.js'></script>
<![endif]-->
<script src='<?php echo base_url()?>assets/scripts/core/jquery.form.min.js' type='text/javascript'></script>
<script src='<?php echo base_url()?>assets/plugins/jquery-migrate-1.2.1.min.js' type='text/javascript'></script>
<script src='<?php echo base_url()?>assets/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js' type='text/javascript'></script>
<script src='<?php echo base_url()?>assets/plugins/bootstrap/js/bootstrap.min.js' type='text/javascript'></script>
<script src='<?php echo base_url()?>assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js' type='text/javascript'></script>
<script src='<?php echo base_url()?>assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js' type='text/javascript'></script>
<script src='<?php echo base_url()?>assets/plugins/jquery.blockui.min.js' type='text/javascript'></script>
<script src='<?php echo base_url()?>assets/plugins/jquery.cokie.min.js' type='text/javascript'></script>
<script src='<?php echo base_url()?>assets/plugins/jquery-validation/jquery.validate.min.js' type='text/javascript'></script>
<script src='<?php echo base_url()?>assets/plugins/datatables/media/js/jquery.dataTables.min.js' type='text/javascript'></script>
<script src='<?php echo base_url()?>assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js' type='text/javascript'></script>
<script src='<?php echo base_url()?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js' type='text/javascript'></script>
<script src='<?php echo base_url()?>assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js' type='text/javascript'></script>
<script src='<?php echo base_url()?>assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js' type='text/javascript'></script>
<script src='<?php echo base_url()?>assets/plugins/ckeditor/ckeditor.js' type='text/javascript'></script>

<!-- <script src='<?php echo base_url()?>assets/plugins/uniform/jquery.uniform.min.js' type='text/javascript'></script> -->

<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src='<?php echo base_url()?>assets/plugins/flot/jquery.flot.min.js' type='text/javascript'></script>
<script src='<?php echo base_url()?>assets/plugins/flot/jquery.flot.resize.min.js' type='text/javascript'></script>
<script src='<?php echo base_url()?>assets/plugins/flot/jquery.flot.categories.min.js' type='text/javascript'></script>
<script src='<?php echo base_url()?>assets/plugins/jquery.pulsate.min.js' type='text/javascript'></script>
<script src='<?php echo base_url()?>assets/plugins/bootstrap-daterangepicker/moment.min.js' type='text/javascript'></script>
<script src='<?php echo base_url()?>assets/plugins/bootstrap-daterangepicker/daterangepicker.js' type='text/javascript'></script>
<script src='<?php echo base_url()?>assets/plugins/gritter/js/jquery.gritter.js' type='text/javascript'></script>
<script src='<?php echo base_url()?>assets/plugins/jquery.sparkline.min.js' type='text/javascript'></script>
<script src='<?php echo base_url()?>assets/plugins/fullcalendar/fullcalendar/fullcalendar.min.js' type='text/javascript'></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src='<?php echo base_url()?>assets/scripts/core/app.js' type='text/javascript'></script>
<script src='<?php echo base_url()?>assets/scripts/custom/global_script.js' type='text/javascript'></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script type="text/javascript">
var base_url = '<?php echo base_url(); ?>';
var current_url = '<?php echo current_url(); ?>';
var current_time = '<?php echo date('Y-m-d H:i:s'); ?>';
$(document).ready(function() {
   App.init('<?php echo base_url();?>'); // initlayout and core plugins
});
</script>
<script src='<?php echo base_url()?>assets/scripts/form.js' type='text/javascript'></script>
<script src='<?php echo base_url()?>assets/scripts/grid.js' type='text/javascript'></script>
<?php
if (isset($js_files))
{
	foreach ($js_files as $js)
	{
		echo '<script src="'.base_url().$js.'" type="text/javascript"></script>';
	}
}
?>
<?php
if (isset($custom_js))
{
	echo '<script type="text/javascript">';
	echo $custom_js;
	echo '</script>';
}
?>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>