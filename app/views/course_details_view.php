
<div class="container animated fadeIn">
	<div class="row">
		<div class="col-lg-12">
			<h2 class="course-title"><?php echo $course_arr['course_title'];?></h2>
		</div>
		<div class="row">
			<div class="col-lg-11">
				<?php $this->load->view('templates/flash_messages');?>
			</div>
		</div>

		<div class="col-lg-2 course-info-listing">
			<strong><?php echo $this->lang->line('courseField_teacher');?>:</strong><br/>
			<a href="#" class="btn btn-default btn-xs">
				<?php echo $course_arr['course_teacher_info']['user_username'];?>
			</a>
		</div>		

		<div class="col-lg-3 course-info-listing">
			<strong><?php echo $this->lang->line('courseField_category');?>: </strong><br/>
			<?php echo '
				<a href="'.base_url().'courses/category/'.$course_arr['course_category_info']['cat_slug'].'" class="btn btn-primary	 btn-xs">
					'.$this->lang->line('cat_'.$course_arr['course_category_info']['cat_slug']).'
				</a>';
			?>
		</div>

		<div class="col-lg-3 course-info-listing">
			<strong><?php echo $this->lang->line('courseField_subcategory');?>: </strong><br/>
			<?php echo '
				<a href="'.base_url().'courses/category/'.$course_arr['course_category_info']['cat_slug'].'/'.$course_arr['course_subcat_info']['subcat_slug'].'" class="btn btn-default btn-subcat btn-xs">
					'.$this->lang->line('subcat_'.$course_arr['course_subcat_info']['subcat_slug']).'
				</a>';
			?>
		</div>

		<div class="col-lg-2 course-info-listing">
			<strong><?php echo $this->lang->line('courseField_length');?>:</strong><br/>
			<span class="btn btn-default btn-xs">
				<?php echo $course_time['hh'].':'.$course_time['mm'];?>
			</span>
		</div>
		
		<div class="col-lg-2 course-info-listing">
			<strong><?php echo $this->lang->line('courseField_enrollment');?>:</strong><br/>
			<?php 
				switch($course_arr['enrollment_status'])
				{
					case 0:
						echo '
							<a href="'.base_url('courses/details/'.$course_arr['course_slug']).'" class="btn btn-warning btn-xs">
								'.$this->lang->line('courseField_inactive').'
							</a>
						';
						break;
					case 1:
						echo '
							<a href="'.base_url('courses/details/'.$course_arr['course_slug']).'" class="btn btn-success btn-xs">
								'.$this->lang->line('courseField_active').'
							</a>
						';
						break;
					case 2:
						echo '
							<a href="'.base_url('courses/details/'.$course_arr['course_slug']).'" class="btn btn-default btn-xs">
								'.$this->lang->line('courseField_paused').'
							</a>
						';
						break;
				}
			?>
		</div>

	</div>


	<div class="row">
		<div class="col-lg-4 col-md-5 col-sm-6 col-xs-12 text-left course-info-img">
			<?php
				$course_image = base_url('images/course_default.png');
				if(isset($course_arr['course_image']) && $course_arr['course_image'] != '')
				{
					$course_image = base_url('uploads/course_imgs/'.$course_arr['course_image']	);
				}
			?>
			<img src="<?php echo $course_image;?>" class="img-responsive course-details-img">
		</div>
		<div class="col-lg-7 col-md-7 col-sm-6 col-xs-12 text-left course-info-desc text-justify">
			<p><strong><?php echo $this->lang->line('courseField_summary');?>: </strong></p>
			<p><?php echo $course_arr['course_description'];?></p>
		</div>
	</div>
	
	<div class="col-lg-12 text-center enroll-section">
		<?php 
		if($is_enrolled)
		{
			echo '<h3>'.$this->lang->line('courseDetails_msg_enrolledInClass').'</h3>
				  <a class="btn btn-lg btn-primary" href="'.base_url('classroom/main/'.$course_arr['course_slug']).'">
				  	'.$this->lang->line('courseDetails_btn_goToClass').'
				  </a>

			';
		}
		else
		{
			//display enrollment message only if not enrolled
			switch($course_arr['enrollment_status'])
			{
				case 0:
					echo '<h3>
							'.$this->lang->line('courseDetails_msg_notReadyEnroll').'
						  </h3>
						  <p>&nbsp;</p>
						  <p>
						  	'.$this->lang->line('courseDetails_msg_enrollNotification1').'
						  </p>
						  <p>
						  	<a href="#" class="btn btn-primary btn-lg">'.$this->lang->line('courseDetails_msg_enrollNotification2').'</a>
						  </p>
						  	'.$this->lang->line('courseDetails_msg_enrollNotification3').'
						  </p>';
					break;
				case 1:
					echo '
						<h2>'.$this->lang->line('courseDetails_title_enrollInCourse').'</h2>
						<a href="'.base_url('account/enroll/'.$course_arr['course_slug']).'" class="btn btn-success btn-lg">
							'.$this->lang->line('courseDetails_btn_signMeUp').'
						</a>
					';
					break;
				case 2:
					echo '<h3>
							'.$this->lang->line('courseDetails_msg_pausedEnroll').'
						  </h3>
						  <p>&nbsp;</p>
						  <p>
						  	'.$this->lang->line('courseDetails_msg_enrollNotification1').'
						  </p>
						  <p>
						  	<a href="#" class="btn btn-primary btn-lg">'.$this->lang->line('courseDetails_msg_enrollNotification2').'</a>
						  </p>
						  	'.$this->lang->line('courseDetails_msg_enrollNotification3').'
						  </p>';
					break;
			}
		}
		?>
	</div>


	<!--course modules section-->
	<div class="row">
		<div class="col-lg-12 text-center">
			<?php if(!empty($modules_arr)):?>
				<h2>&nbsp;</h2>
				<h2><?php echo $this->lang->line('courseDetails_title_courseModules');?></h2>
				<div class="col-lg-12 list-group">
					<?php foreach($modules_arr as $module):?>
						<div class="list-group-item module-list-row">
							<div class="row">
								<div class="col-md-1 module-list-info">
									<?php 
										echo '<strong>'.$module['chapter'].'.'.$module['section'].'</strong>';
									?>
								</div>
								<div class="col-md-10 module-list-title">
									<h4 class="list-module-title"><?php echo $module['title'];?></h4>
								</div>
								<div class="col-md-1 list-module-info-btn">
									<a id="<?php echo $module['id'];?>" href="#" onclick="toggleListInfo(this.id);return false;">
										<span class="glyphicon glyphicon-info-sign"></span>
									</a>
								</div>
							</div>
							
							<div id="list-info-<?php echo $module['id'];?>" class="row module_info_extra">
								<div class="col-md-3 module-list-info">
									<?php echo '<strong>'.$this->lang->line('moduleField_type').':</strong>';?>
									<span class="btn btn-default btn-xs">
										<?php echo $this->lang->line('moduleField_type_'.$module['module_type_name']);?>
									</span>
								</div>
								
								<div class="col-md-3 module-list-info">
									<?php echo '<strong>'.$this->lang->line('moduleField_length').':</strong>';?>
									<span class="btn btn-default btn-xs">
										<?php echo $module['module_time']['hh'].':'.$module['module_time']['mm'];?>
									</span>
								</div>
								
								<div class="col-md-3 module-list-info">
									<span class="btn btn-default btn-xs">
										<?php echo $module['slides_count'].' '.$this->lang->line('moduleField_slides');?>
									</span>
								</div>

								<div class="col-md-3 module-list-info">
									<span class="btn btn-default btn-xs">
										<?php echo $module['questions_count'].' '.$this->lang->line('moduleField_questions');?>
									</span>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12 module-list-summary">
									<?php echo $module['summary'];?>
								</div>
							</div>
							
							<div class="clearfix"></div>
						</div>
					<?php endforeach;?>
				</div>
			<?php endif;?>
		</div>
	</div>

</div>

















