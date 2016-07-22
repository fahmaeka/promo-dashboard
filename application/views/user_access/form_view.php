<?php $this->load->view('templates/_header'); ?>
<div class="page-container">
    <?php $this->load->view('templates/_navigation_menu'); ?>
    <div class="page-content-wrapper">
        <div class="page-content">
			<h3 class="page-title">User Access</h3>
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
                                <div class="form-group">
                                    <label class="control-label col-sm-3">Menus</label>
                                    <div class="col-sm-9">
                                        <?php
                                        if (count($menus) > 0)
                                        {
                                            if (isset($access) && $access !== FALSE)
                                            {
                                                $menu_access = array_column($access, 'menu_id');
                                            }
                                            foreach ($menus as $menu_id => $menu)
                                            {
                                                if (isset($menu_access))
                                                {
                                                    $menu_selected = (in_array($menu_id, $menu_access)) ? 'checked' : '';
                                                }
                                                else
                                                {
                                                    $menu_selected = '';
                                                }
                                                echo '<label><input type="checkbox" name="menu_id[]" value="'.$menu_id.'" '.$menu_selected.'> '.$menu['data']->menu_name.'</label><br>';
                                                if (count($menu['sub_menus']) > 0)
                                                {
                                                    foreach ($menu['sub_menus'] as $sub_menu)
                                                    {
                                                        if (isset($menu_access))
                                                        {
                                                            $sub_menu_selected = (in_array($sub_menu->menu_id, $menu_access)) ? 'checked' : '';
                                                        }
                                                        else
                                                        {
                                                            $sub_menu_selected = '';
                                                        }
                                                        echo '<label><input type="checkbox" name="menu_id[]" value="'.$sub_menu->menu_id.'" '.$sub_menu_selected.'> |-- '.$sub_menu->menu_name.'</label><br>';
                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
								<div class="form-actions">
									<div class="row">
										<div class="col-sm-offset-3 col-sm-9">
											<a href="<?php echo site_url('user_access'); ?>" class="btn blue">
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
<?php $this->load->view('templates/_footer'); ?>