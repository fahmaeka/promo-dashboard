<?php $this->load->view('templates/_header'); ?>
<div class="page-container">
    <?php $this->load->view('templates/_navigation_menu'); ?>
    <div class="page-content-wrapper">
        <div class="page-content">
			<h3 class="page-title">Promo</h3>
			<div class="row">
				<div class="col-md-12">
					<div class="portlet box orange">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject">List of Promo</span>
							</div>
							<div class="actions">
								<a href="<?php echo site_url('promo/create'); ?>" class="btn btn-default btn-sm blue-stripe">
									<i class="fa fa-plus"></i>
									Add New Promo
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
                                        <th >Promo Name</th>
                                        <th >Created Date</th>
                                        <th >Created By</th>
                                        <th >Status</th>
                                        <th width="15">Actions</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th><input type="text" name="input[0]" value="" class="form-control input-sm"></th>
                                        <th><input type="text" name="input[1]" value="" class="form-control input-sm"></th>
                                        <th><input type="text" name="input[2]" value="" class="form-control input-sm"></th>
                                        <th>
                                            <select name="input[3]" class="form-control input-sm">
                                                <option value="">Select</option>
                                                <option value="1">Enabled</option>
                                                <option value="0">Disabled</option>
                                            </select>
                                        </th>
                                        <th><button id="search_datatable" class="btn btn-sm btn-default blue" type="button">Search&nbsp;</button></th>
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