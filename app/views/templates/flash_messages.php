<!--Flash Messages-->
<?php if(isset($_SESSION['flash_success'])):?>
	<div class="col-lg-12">
		<div class="alert alert-success alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert"><span class="glyphicon glyphicon-remove-circle"></span></button>
 			<?php
 				//show the current flash_success message
 				echo $_SESSION['flash_success'];
 				//clear the flash_success message
 				unset($_SESSION['flash_success']);
 			?>
 		</div>
	</div>
<?php endif;?>
<?php if(isset($_SESSION['flash_error'])):?>
	<div class="col-lg-12">
		<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert"><span class="glyphicon glyphicon-remove-circle"></span></button>
 			<?php
 				//show the current flash_error message
 				echo $_SESSION['flash_error'];
 				//clear the flash_error message
 				unset($_SESSION['flash_error']);
 			?>
 		</div>
	</div>
<?php endif;?>
<!--End Flash Messages-->