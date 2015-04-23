	<?php if(!empty($account_alerts)):?>
	<?php $this->lang->load('folat_AccountAlerts', $this->config->item('language'));?>
		<div class="col-md-3 account-alerts">
			<h3><?php echo $this->lang->line('alerts_title_accountAlerts');?></h3>
			<?php 
				foreach($account_alerts as $alert)
				{
					echo '<a href="'.$alert['link'].'" class="btn btn-info center-block account-alert">
					  	 	'.$this->lang->line($alert['langKey']).'
					     </a>';
				}
			?>
		</div>
	<?php endif;?>