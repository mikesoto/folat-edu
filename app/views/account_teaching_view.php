<div class="row">
  <?php if(!empty($account_alerts)):?>
	<div class="col-md-9 my-account-courses-listing">
  <?php else:?>
    <div class="col-md-12 my-account-courses-listing">
  <?php endif;?>
		<?php 
			//loads the submenu template for all account sections
			$data['selected'] = 'teaching'; 
			$this->load->view('templates/account_submenu',$data);
		?>

		<div class="animated fadeIn">
			<div class="row">
				<div class="col-lg-12">
					<p>&nbsp;</p>
			  		<h3><?php echo $this->lang->line('coursesTeaching_title_coursesImTeaching');?></h3>
				</div>
				<?php $this->load->view('templates/flash_messages');?>
			</div>
				  	
			<?php 
			foreach($courses_teaching as $course)
			{	$course['course_time'] = convertToTime($course['course_length']);
				echo '	
				<div class="course_cat_listing">
					<div class="row">
						<div class="col-lg-6 col-md-9 col-sm-9 col-xs-12 course-info-listing">
							<a href="'.base_url('courses/manage/'.$course['course_slug']).'">
								<h3>'.$course['course_title'].'</h3>
							</a>
						</div>

						<div class="col-lg-6 col-md-3 col-sm-3 col-xs-12"> 
			               <ul class="nav nav-tabs course-action-menu">
							  <li role="presentation" class="dropdown">
							    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
							       <span class="glyphicon glyphicon-pencil"></span> 
							        '.$this->lang->line('coursesTeaching_btn_teacherActions').'
							       <span class="caret"></span>
							    </a>
							    <ul class="dropdown-menu" role="menu">
							       <li>
							         <a href="'.base_url('courses/manage/'.$course['course_slug']).'">
							         	'.$this->lang->line('coursesTeaching_btn_manageCourse').'
							         </a>
							       </li>
							       <li>
							       	 <a href="#" onclick="confirmDeleteSet(\''.$course['course_title'].'\', \''.base_url('courses/delete/'.$course['id']).'\');show_modal(\'delete_confirm\');">
							       	 	'.$this->lang->line('coursesTeaching_btn_deleteCourse').'
							       	 </a>
							       </li>
							    </ul>
							  </li>
							</ul>
						</div>

					</div>
					<div class="row">
						<div class="col-lg-2 course-info-listing">
							<strong>'.$this->lang->line('courseField_teacher').': </strong><br/>
							<a href="#" class="btn btn-default btn-xs">
								'.$course['course_teacher_info']['user_username'].'
							</a>
						</div>					
						
						<div class="col-lg-3 course-info-listing">
							<strong>'.$this->lang->line('courseField_category').': </strong><br/>
							<a href="'.base_url().'courses/category/'.$course['course_category_info']['cat_slug'].'" class="btn btn-primary	 btn-xs">
								'.$this->lang->line('cat_'.$course['course_category_info']['cat_slug']).'
							</a>
						</div>

						<div class="col-lg-3 course-info-listing">
							<strong>'.$this->lang->line('courseField_subcategory').': </strong><br/>
							<a href="'.base_url().'courses/category/'.$course['course_category_info']['cat_slug'].'/'.$course['course_subcat_info']['subcat_slug'].'" class="btn btn-default btn-subcat btn-xs">
								'.$this->lang->line('subcat_'.$course['course_subcat_info']['subcat_slug']).'
							</a>
						</div>

						<div class="col-lg-2 course-info-listing">
							<strong>'.$this->lang->line('courseField_length').':</strong><br/>
							<span class="btn btn-default btn-xs" disabled="disabled">
								'.$course['course_time']['hh'].':'.$course['course_time']['mm'].' 
							</span>
						</div>
						
						<div class="col-lg-2 course-info-listing">
							<strong>'.$this->lang->line('courseField_enrollment').':</strong><br/>';
							switch($course['enrollment_status'])
							{
								case 0:
									echo '
										<a href="'.base_url('courses/details/'.$course['course_slug']).'" class="btn btn-warning btn-xs">
											'.$this->lang->line('courseField_inactive').'
										</a>
									';
									break;
								case 1:
									echo '
										<a href="'.base_url('courses/details/'.$course['course_slug']).'" class="btn btn-success btn-xs">
											'.$this->lang->line('courseField_active').'
										</a>
									';
									break;
								case 2:
									echo '
										<a href="'.base_url('courses/details/'.$course['course_slug']).'" class="btn btn-default btn-xs">
											'.$this->lang->line('courseField_paused').'
										</a>
									';
									break;
							}

				echo '	
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<div class="row">
								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">';
									$course_image = base_url('images/course_default.png');
									if(isset($course['course_image']) && $course['course_image'] != '')
									{
										$course_image = base_url('uploads/course_imgs/'.$course['course_image']);
									}
									echo '
									<a href="'.base_url('courses/details/'.$course['course_slug']).'" class="course-image-link">
										<img src="'.$course_image.'" width="350px" height="300px" align="left" class="img-responsive course_listing_img">
									</a>
								</div>
								<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
									<p><strong>'.$this->lang->line('courseField_summary').':</strong> '.substr($course['course_description'],0,600).'...
										<a href="'.base_url('courses/details/'.$course['course_slug']).'">
										  '.$this->lang->line('courseField_read_more').'
										</a>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>';
			}

			//show message if not teaching any courses
			if(count($courses_teaching) < 1)
			{
				echo ' <div class="col-lg-12 text-center">
						  <h1>&nbsp;</h1>
						  <span class="btn btn-default btn-lg" disabled="disabled">
							'.$this->lang->line('coursesTeaching_msg_arentTeaching').'
						  </span>
						  <p><br/>
						  	<a href="'.base_url('courses/create').'">'.$this->lang->line('coursesTeaching_btn_createFirstCourse').'</a>
						  </p>
					   </div>';
			}

			?>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="delete_confirm" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="delete_confirm"><?php echo $this->lang->line('coursesTeaching_title_confirmDelete');?></h4>
	      </div>
	      <div id="delete_confirm_modal_body" class="modal-body">
	        <!--set by JS-->
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('form_cancel');?></button>
	        <button id="delete_course_btn" type="button" class="btn btn-danger"><?php echo $this->lang->line('form_deleteCourse');?></button>
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

<script>
	function confirmDeleteSet(course_title,url)
	{
		$("#delete_confirm_modal_body").html('<?php echo $this->lang->line("coursesTeaching_msg_confirmDelete1");?><br/><strong>'+course_title+'</strong>?<br/><em><?php echo addslashes($this->lang->line("coursesTeaching_msg_confirmDelete2"));?></em>');
		$("#delete_course_btn").click(function(){
			document.location = url;
		});
	}
</script>