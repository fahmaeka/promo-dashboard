<?php $this->load->view('templates/_header'); ?>
<div class="page-container">
    <?php $this->load->view('templates/_navigation_menu'); ?>
    <div class="page-content-wrapper">
        <div class="page-content">
			<h3 class="page-title">User</h3>
			<div class="row">
				<div class="col-md-12">
					<div class="portlet box orange">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject">List of User</span>
							</div>
							<div class="actions">
								<a href="<?php echo site_url('user/create'); ?>" class="btn btn-default btn-sm blue-stripe">
									<i class="fa fa-plus"></i>
									Add New User
								</a>
							</div>
						</div>
						<div class="portlet-body">
							<?php
							if (!empty($success_message)) { echo $success_message; }
							if (!empty($error_message)) { echo $error_message; }
							?>
							<table id="table_grid" class="table table-condensed table-striped table-hover">
								<thead>
									<tr>
										<th width="20">ID</th>
										<th>Username</th>
										<th>Email</th>
										<th>Type</th>
										<th>Status</th>
										<th width="110">Actions</th>
									</tr>
								</thead>
								<tfoot>
									<tr>
										<th><input type="text" name="input[0]" value="" class="form-control input-sm"></th>
										<th><input type="text" name="input[1]" value="" class="form-control input-sm"></th>
										<th><input type="text" name="input[2]" value="" class="form-control input-sm"></th>
										<th><?php echo form_dropdown('input[3]', $this->customer_type_model->dropdown('customer_type_name'), NULL, 'class="form-control input-sm"'); ?></th>
										<th>
											<select name="input[4]" class="form-control input-sm">
												<option value="">Select</option>
												<option value="1">Active</option>
												<option value="0">Inactive</option>
											</select>
										</th>
										<th><button id="search_datatable" class="btn btn-sm btn-default blue" type="button">Search&nbsp;<i class="fa fa-search"></i></button></th>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div> 
<?php $this->load->view('templates/_footer', $output); ?>