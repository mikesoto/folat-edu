<div class="row">
	<?php $this->load->view('templates/flash_messages');?>
	<div class="col-lg-6">
		<div class="jumbotron login">
			<div class="folat_logo_text login-title"><?php echo $this->lang->line('login_loginToFolat');?></div>
			<p>&nbsp;</p>
			<?php if(validation_errors() != ''):?>
			   <div class="alert alert-danger" role="alert"><?php echo validation_errors(); ?></div>
			<?php endif;?>
			<?php echo form_open('verify_login?ref='.str_replace("account/login", "",$ref_uri),array('role' => 'form', 'id' => 'login_form')); ?>
				<div class="form-group">
			 		<label for="user_username">
			 			<?php echo $this->lang->line('login_username');?>
			 		</label>
				 	<input type="text" class="form-control" id="user_username" name="user_username" value="<?php echo set_value('user_username'); ?>"/>
				</div>
				<div class="form-group">
				 	<label for="teachcer_password">
				 		<?php echo $this->lang->line('login_password');?>
				 	</label>
				 	<input type="password" class="form-control" id="user_password" name="user_password" value="<?php echo set_value('user_password'); ?>"/>
				</div>
				<div class="checkbox">
					<br>
				    <label>
				      <input type="checkbox" id="terms" name="terms" checked="checked">
				       <?php echo $this->lang->line('login_iHaveRead');?> <a href="pages/folat-terms-of-service"><?php echo $this->lang->line('login_termsOfService');?></a>
				    </label>
				</div>
				<br>
				<input type="submit" class="btn btn-default" value="<?php echo $this->lang->line('login_loginToMyAccount');?>"/>
			</form>
		</div>
	</div>
	<div class="col-lg-6">
		<div class="well text-center login-register-link">
			<h4><?php echo $this->lang->line('login_dontHaveAccount');?></h4>
			<p>&nbsp;</p>
			<?php echo anchor(base_url('account/register'), $this->lang->line('login_registerNowBtn'), array('class' => 'btn btn-primary btn-lg'));?>
			<p>&nbsp;</p>
			<?php echo $this->lang->line('login_benefitsList');?>
		</div>
	</div>
</div>
