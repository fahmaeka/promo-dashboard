<?php $this->load->view('templates/_header'); ?>
<div class="page-container">
    <?php $this->load->view('templates/_navigation_menu'); ?>
    <div class="page-content-wrapper">
        <div class="page-content">
			<h3 class="page-title">Promo Rule</h3>
			<div class="row">
				<div class="col-md-12">
					<div class="portlet box orange">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject"><?php echo $form_title; ?></span>
							</div>
						</div>
						<div class="portlet-body form">
							<form id="form" class="form-horizontal form-bordered" action="<?php echo $form_action; ?>" method="post">
								<div id="info-message">
									<?php if (!empty($success_message)) { echo $success_message; } ?>
									<?php if (!empty($error_message)) { echo $error_message; } ?>
								</div>
								<?php echo $form; ?>
                                <div id="promo_rule_detail">
                                        <div class ="clone hidden">
                                        <div class="form-group">
                                        <label class="col-sm-3 control-label">Detail</label>
                                        <div class="col-sm-9">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <?php echo form_dropdown('range_id[]', $this->range_model->dropdown(), NULL, 'class="form-control required"'); ?>
                                                </div>
                                                <div class="col-sm-2">
                                                    <input type="number" name="promo_rule_detail_fixed_value[]" placeholder="Fixed Value" class="form-control required">
                                                </div>
                                                <div class="col-sm-2">
                                                    <input type="number" name="promo_rule_detail_max_value[]" placeholder="Max Value" class="form-control required">
                                                </div>
                                                <div class="col-sm-2">
                                                    <input type="number" name="promo_rule_detail_percent[]" placeholder="Percent" class="form-control required">
                                                </div>
                                                <div class="col-sm-2">
                                                    <button type="button" class="btn red btn-remove-detail"><i class="fa fa-remove"></i></button>
                                                    <button type="button" class="btn green btn-add-detail"><i class="fa fa-plus"></i></button>
                                                </div>
                                        </div>
                                        </div>
                                        </div>
                                        </div>
                                            <?php
                                            if (isset($details) && $details !== FALSE)
                                            {
                                                foreach ($details->result() as $detail)
                                                {
                                            ?>
                                            <div>
                                            <div class="form-group">
                                            <label class="col-sm-3 control-label">Detail</label>
                                            <div class="col-sm-9">
                                            <div class="row margin-top-10">
                                                <div class="col-sm-4">
                                                    <input type="hidden" name="promo_rule_id" value="<?php echo $detail->promo_rule_id; ?>" >
                                                    <?php echo form_dropdown('range_id[]', $this->range_model->dropdown(), $detail->range_id, 'class="form-control required"'); ?>
                                                </div>
                                                <div class="col-sm-2">
                                                    <input type="number" name="promo_rule_detail_fixed_value[]" value="<?php echo $detail->promo_rule_detail_fixed_value; ?>" placeholder="Fixed Value" class="form-control required">
                                                </div>
                                                <div class="col-sm-2">
                                                    <input type="number" name="promo_rule_detail_max_value[]" value="<?php echo $detail->promo_rule_detail_max_value; ?>" placeholder="Max Value" class="form-control required">
                                                </div>
                                                <div class="col-sm-2">
                                                    <input type="number" name="promo_rule_detail_percent[]" value="<?php echo $detail->promo_rule_detail_percent; ?>" placeholder="Percent" class="form-control required">
                                                </div>
                                                <div class="col-sm-2">
                                                    <button type="button" class="btn red btn-remove-detail"><i class="fa fa-remove"></i></button>
                                                    <button type="button" class="btn green btn-add-detail"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                            </div>
                                            </div>
                                            </div>
                                            <?php }}
                                            else
                                            {
                                            ?>
                                            <div>
                                            <div class="form-group">
                                            <label class="col-sm-3 control-label">Detail</label>
                                            <div class="col-sm-9">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <?php echo form_dropdown('range_id[]', $this->range_model->dropdown(), NULL, 'class="form-control required"'); ?>
                                                </div>
                                                <div class="col-sm-2">
                                                    <input type="number" name="promo_rule_detail_fixed_value[]" placeholder="Fixed Value" class="form-control required">
                                                </div>
                                                <div class="col-sm-2">
                                                    <input type="number" name="promo_rule_detail_max_value[]" placeholder="Max Value" class="form-control required">
                                                </div>
                                                <div class="col-sm-2">
                                                    <input type="number" name="promo_rule_detail_percent[]" placeholder="Percent" class="form-control required">
                                                </div>
                                                <div class="col-sm-2">
                                                    <button type="button" class="btn red btn-remove-detail"><i class="fa fa-remove"></i></button>
                                                    <button type="button" class="btn green btn-add-detail"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                            </div>
                                            </div>
                                            </div>
                                            <?php } ?>
                                     </div>   
                                </div>
                                
								<div class="form-actions">
									<div class="row">
										<div class="col-sm-offset-3 col-sm-9">
											<a href="<?php echo site_url('promo_rule'); ?>" class="btn blue">
												<i class="fa fa-undo"></i> Back to list
											</a>
											<button id="btn-submit" class="btn blue">
												<i class="fa fa-save"></i> Save
											</button>
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
<?php $this->load->view('templates/_footer', $output); ?>