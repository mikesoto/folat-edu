<?php 
	$this->lang->load('folat_AccountSubmenu', $this->config->item('language'));
?>

<ul class="nav nav-tabs">
  <li role="presentation" <?php echo is_active('profile',$selected);?> >
  	<a href="<?php echo base_url('account/profile');?>">
  		<?php echo $this->lang->line('submenu_btn_myProfile');?>
  	</a>
  </li>
  <li role="presentation" <?php echo is_active('taking',$selected);?> >
  	<a href="<?php echo base_url('account/taking');?>">
  		<?php echo $this->lang->line('submenu_btn_coursesTaking');?>
  	</a>
  </li>
  <li role="presentation" <?php echo is_active('teaching',$selected);?> >
  	<a href="<?php echo base_url('account/teaching');?>">
  		<?php echo $this->lang->line('submenu_btn_coursesTeaching');?>
  	</a>
  </li>
  <li role="presentation" <?php echo is_active('create',$selected);?>>
  	<a href="<?php echo base_url('courses/create');?>">
  		<?php echo $this->lang->line('submenu_btn_createNewCourse');?>
  	</a>
  </li>
</ul>