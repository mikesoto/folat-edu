<div class="row">
  <?php if(!empty($account_alerts)):?>
	<div class="col-md-9 my-account-courses-listing">
  <?php else:?>
    <div class="col-md-12 my-account-courses-listing">
  <?php endif;?>
		<?php 
			//loads the submenu template for all account sections
			$data['selected'] = 'profile'; 
			$this->load->view('templates/account_submenu',$data);
		?>

		<div class="animated fadeIn">
			<div class="row">
			  	<div class="col-lg-10 col-md-9 col-sm-9 col-xs-12">
			  		<p>&nbsp;</p>
				  	<h3><?php echo $this->lang->line('profile_title_myFolatProfile');?></h3>
				</div>
				<div class="col-lg-2 col-md-3 col-sm-3 col-xs-12">
					<a href="<?php echo base_url('account/edit');?>" class="edit_profile_link"><span class="glyphicon glyphicon-pencil"></span> &nbsp; <?php echo $this->lang->line('profile_btn_editProfile');?></a>
				</div>
			</div>
			<?php $this->load->view('templates/flash_messages');?>
			<div class="row">
				<div class="col-lg-3">
					<?php 
						$profile_image = base_url('images/profile_default.png');
						if(isset($user_image) && $user_image != '')
						{
							$profile_image = base_url('uploads/profile_imgs/'.$user_image);
						}
					?>
					<img src="<?php echo $profile_image;?>" id="profile_image" class="img-responsive">
				</div>
				<div class="col-lg-9">
					<div class="row">
						<div class="col-lg-6">
							<p><strong><?php echo $this->lang->line('form_first_name');?>:</strong><br/>
							<?php echo $user_name; ?></p>
						</div>
						<div class="col-lg-6">
							<p><strong><?php echo $this->lang->line('form_last_name');?>:</strong><br/>
							<?php echo $user_lastname; ?></p>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<p><strong><?php echo $this->lang->line('form_email');?>:</strong><br/>
							<?php echo $user_email; ?></p>
						</div>
						<div class="col-lg-6">
							<p><strong><?php echo $this->lang->line('form_username');?>:</strong><br/>
							<?php echo $user_username; ?></p>
						</div>
				    </div>
				    <div class="row">
						<div class="col-lg-12">
							<p><strong><?php echo $this->lang->line('form_about_me');?>:</strong></p>
						 	<div class="well account-about-me"><?php echo $user_about;?></div>
						</div>
				    </div>
				</div>
			</div>
		</div>
	</div>

	<!-- ACCOUNT ALERTS SIDEBAR-->
	<?php 
		//loads the account alerts sidebar if there are any alerts
		$data['account_alerts'] = $account_alerts; 
		$this->load->view('templates/account_alerts_sidebar',$data);
	?>
</div>