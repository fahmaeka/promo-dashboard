<?php $this->load->view('templates/_header'); ?>
<div class="page-container">
    <?php $this->load->view('templates/_navigation_menu'); ?>
    <div class="page-content-wrapper">
        <div class="page-content">
			<h3 class="page-title">Promo Code</h3>
			<div class="row">
				<div class="col-md-12">
					<div class="portlet box orange">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject">List of Promo Code</span>
							</div>
							<div class="actions">
								<a href="<?php echo site_url('promo_code/create'); ?>" class="btn btn-default btn-sm blue-stripe">
									<i class="fa fa-plus"></i>
									Add New Promo Code
								</a>
							</div>
						</div>
						<div class="portlet-body">
							<?php
							if (!empty($success_message)) { echo $success_message; }
							if (!empty($error_message)) { echo $error_message; }
							?>
                            <table id="table_grid" class="table table-condensed table-striped table-hover" style="width:1500px !important">
                                <thead>
                                    <tr>
                                        <th width="20">ID</th>
                                        <th width="200">Promo</th>
                                        <th width="150">Code</th>
                                        <th width="70">Count</th>
                                        <th width="70">Max Count</th>
                                        <th width="100">Created Date</th>
                                        <th width="100">Created By</th>
                                        <th width="100">Updated Date</th>
                                        <th width="100">Updated By</th>
                                        <th width="110">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th><input type="text" name="input[1]" value="" class="form-control input-sm"></th>
                                        <th><?php echo form_dropdown('input[0]', $this->promo_model->dropdown(),  'class="form-control input-sm"'); ?></th>
                                        <th><input type="text" name="input[0]" value="" class="form-control input-sm"></th>
                                        <th><input type="text" name="input[0]" value="" class="form-control input-sm"></th>
                                        <th><input type="text" name="input[0]" value="" class="form-control input-sm"></th>
                                        <th><input type="text" name="input[0]" value="" class="form-control input-sm"></th>
                                        <th><input type="text" name="input[0]" value="" class="form-control input-sm"></th>
                                        <th><input type="text" name="input[0]" value="" class="form-control input-sm"></th>
                                        <th><input type="text" name="input[0]" value="" class="form-control input-sm"></th>
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