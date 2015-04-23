<div id="register_container">
	<div class="row  animated fadeIn">
		<div class="col-lg-12">
			<h2><?php echo $this->lang->line('register_title_FOLATAccountReg');?></h2>
			<h3>&nbsp;</h3>
			<?php if(validation_errors() != ''):?>
			   <div class="alert alert-danger" role="alert"><?php echo validation_errors(); ?></div>
			<?php endif;?>

			<?php $this->load->view('templates/flash_messages');?>

			<?php echo form_open('verify_account_create',array('role' => 'form', 'id' => 'register_form')); ?>
				<div class="row">	
					<div class="col-lg-8">
						<div class="form-group">
					 		<label for="user_name">
					 			<?php echo $this->lang->line('register_label_firstName');?>
					 		</label>
						 	<input type="text" class="form-control" id="user_name" name="user_name" value="<?php echo set_value('user_name'); ?>"/>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-8">
						<div class="form-group">
						 	<label for="user_lastname">
						 		<?php echo $this->lang->line('register_label_lastName');?>
						 	</label>
						 	<input type="text" class="form-control" id="user_lastname" name="user_lastname" value="<?php echo set_value('user_lastname'); ?>"/>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-8">
						<div class="form-group">
						 	<label for="user_email">
						 		<?php echo $this->lang->line('register_label_email');?>
						 	</label>
						 	<input type="text" class="form-control" id="user_email" name="user_email" value="<?php echo set_value('user_email'); ?>"/>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-8">
						<div class="form-group">
						 	<label for="user_lastname">
						 		<?php echo $this->lang->line('register_label_username');?>
						 	</label>
						 	<input type="text" class="form-control" id="user_username" name="user_username" value="<?php echo set_value('user_username'); ?>"/>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-8">
						<div class="form-group">
						 	<label for="user_password">
						 		<?php echo $this->lang->line('register_label_password');?>
						 	</label>
						 	<input type="password" class="form-control" id="user_password" name="user_password" value="<?php echo set_value('user_password'); ?>"/>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-8">
						<div class="form-group">
						 	<label for="user_password_conf">
						 		<?php echo $this->lang->line('register_label_confirmPassword');?>
						 	</label>
						 	<input type="password" class="form-control" id="user_password_conf" name="user_password_conf" value="<?php echo set_value('user_password_conf'); ?>"/>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-8">
						<div class="checkbox">
							<br>
						    <label>
						      <input type="checkbox" id="terms" name="terms"/> 
						      <?php echo $this->lang->line('register_label_iHaveRead');?><br/>
						      <a href="pages/folat-terms-of-service">
						      	<?php echo $this->lang->line('register_label_folatTermsOfService');?>
						      </a>
						    </label>
						</div>
					</div>
				</div>
				<br>
				<input type="submit" class="btn btn-default" value="<?php echo $this->lang->line('register_label_createMyAccount');?>"/>
			</form>
		</div>
	</div>
</div>