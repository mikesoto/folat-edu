<div class="row">
	<div class="col-lg-12 my-account-edit-profile">
		<div class="row">
			<div class="col-lg-10 col-md-9 col-sm-9 col-xs-12">
			  	<h3  class="hidden-xs"><?php echo $this->lang->line('accountEdit_title_editProfile');?></h3>
			</div>
			<div class="col-lg-2 col-md-3 col-sm-3 col-xs-12"> 
				<a href="<?php echo base_url('account');?>" class="edit_profile_link"><span class="glyphicon glyphicon-user"></span> &nbsp; <?php echo $this->lang->line('accountEdit_btn_myAccount');?></a>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<p>&nbsp;</p>
				<?php if(validation_errors() != ''):?>
				   <div class="alert alert-danger" role="alert"><?php echo validation_errors(); ?></div>
				<?php endif;?>
				<?php $this->load->view('templates/flash_messages');?>
			</div>
		</div>
		<div class="row">
			<?php echo form_open_multipart('verify_account_update',array('role' => 'form', 'id' => 'edit_profile_form')); ?>
				<div class="col-lg-3">
					<?php 
						$profile_image = base_url('images/profile_default.png');
						if(isset($user_image) && $user_image != '')
						{
							$profile_image = base_url('uploads/profile_imgs/'.$user_image);
						}
					?>
					<img src="<?php echo $profile_image;?>" id="profile_image" class="img-responsive">
					<label for="file_user_image"><?php echo $this->lang->line('accountEdit_label_changeImage');?>:</label>
					<input type="file" name="file_user_image"/>
					<input type="hidden" name="user_image" value="<?php echo $user_image;?>"/>
					<p>&nbsp;</p>
				</div>
				<div class="col-lg-8">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label><?php echo $this->lang->line('form_first_name');?>:</label> 
								<input type="text" class="form-control" name="user_name" id="user_name" value="<?php echo $user_name; ?>"/>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label><?php echo $this->lang->line('form_last_name');?>:</label> 
								<input type="text" class="form-control" name="user_lastname" id="user_lastname" value="<?php echo $user_lastname; ?>"/>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label><?php echo $this->lang->line('form_email');?>:</label> 
								<input type="text" class="form-control" name="user_email" id="user_email" value="<?php echo $user_email; ?>"/>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label for"user_username"><?php echo $this->lang->line('form_username');?>:</label> 
								<input type="text" class="form-control" name="user_username" id="user_username" value="<?php echo $user_username; ?>"/>
							</div>
						</div>
				    </div>
				    <div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<label><?php echo $this->lang->line('form_about_me');?>:</label>
							 	<textarea rows="5" class=" mceNoEditor form-control" name="user_about"><?php echo $user_about; ?></textarea>
							</div>
						</div>
				    </div>
				    <div class="row">
						<div class="col-lg-3">
						</div>
						<div class="col-lg-9 text-right">
							<input type="submit" class="btn btn-primary" value="<?php echo $this->lang->line('accountEdit_btn_saveChanges');?>"/>
						</div>
				    </div>
				</div>
			</form>
		</div>
	</div><!--.my-account-edit-profile-->

</div><!--.row-->