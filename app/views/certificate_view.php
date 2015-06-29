<div class="certificate-wrapper">
	<div class="animated fadeIn">
		<div class="row">
			<div class="col-md-12 text-center">
				<span class="folat_logo_text"><h1>CERTIFICATE OF COMPLETION</h1></span>
			</div>
			<div class="col-md-12 text-center">
				<h4>This certifies that</h4>
			</div>
			<div class="col-md-12 text-center">
				<h2><?php echo $student_data['user_name'].' '.$student_data['user_lastname'];?></h2>
				<br class="hidden-xs hidden-sm"/>
			</div>
			<div class="col-md-12 text-center">
				<h4>Has successfully completed the FOLAT Course Titled:</h4>
			</div>
			<div class="col-md-12 text-center">
				<span class="folat_logo_text"><h1><?php echo $course_arr['course_title'];?></h1></span>
			</div>
			<h3 class="hidden-xs hidden-sm">&nbsp;</h3>
			<div class="col-md-12 text-center">
				<h4>
					On the date of: 
					<?php echo $cert_data['day'].'/'.$cert_data['month'].'/'.$cert_data['year'];?>
				</h4>
			</div>
			<div class="col-md-12 text-center">
				<h4>
					Course ID: 
					<?php echo $course_arr['id'];?>
				</h4>
			</div>
			<div class="col-md-12 text-center">
				<h4>
					Certificate ID: 
					<?php echo $cert_data['cert_id'];?>
				</h4>
			</div>
			<div class="col-md-12 text-center">
				<h4>Certificate Link:</h4>
				<a href="<?php echo base_url('account/certificate/'.$cert_data['cert_id']);?>">
					<?php echo base_url('account/certificate/'.$cert_data['cert_id']);?>
				</a>
			</div>
		</div>		
	</div>
</div>