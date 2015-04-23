<?php 
	function is_active_cat($thiscat, $category){ 
		if($thiscat == $category)
		{
			return 'active';
		} 
	}
	function is_active_subcat($thissubcat, $subcategory){ 
		if($thissubcat == $subcategory)
		{
			return 'active';
		} 
	}
	if($category == '')
	{
		$category = $this->lang->line('courseList_allCategories');
		if($this->config->item('language') == 'spanish')
		{
			$title_cat = 'Todas las Categorías';
		}
	}
	else
	{
		$title_cat = $this->lang->line('courseList_catTitle_'.$category);
	}
	$insub = '';
	if($subcategory != '')
	{
		$insub = ' | '.$this->lang->line('subcat_'.strtolower(str_replace(' ','-',$subcategory)));
	}
?>
<div class="row">
	<?php $this->load->view('templates/flash_messages');?>
	<div class="col-md-3">
		<h3><?php echo $this->lang->line('courseList_title_courseCategories');?></h3>
		<div class="list-group">
			<?php
				echo '<a href="'.base_url('courses/category/').'" class="list-group-item '.is_active_cat($this->lang->line('courseList_allCategories'),$category).'">
							'.$this->lang->line('courseList_allCategories').'
					  </a>
				     ';
				foreach($cat_list as $cat)
				{
					echo '<a href="'.base_url('courses/category/'.$cat['cat_slug']).'" class="list-group-item '.is_active_cat($cat['cat_name'],$category).'" title="'.$cat['cat_description'].'">
							'.$this->lang->line('cat_'.$cat['cat_slug']).'
						  </a>
						';
					if($cat['cat_name'] == $category)
					{
						foreach($subcat_list as $subcat)
						{
							if($subcat['subcat_parent_id'] == $cat['id'])
							{
							  echo '<a href="'.base_url('courses/category/'.$cat['cat_slug'].'/'.$subcat['subcat_slug']).'" class="list-group-item subcat-link '.is_active_subcat($subcat['subcat_name'],$subcategory).'" title="'.$subcat['subcat_description'].'">
										<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
										'.$this->lang->line('subcat_'.$subcat['subcat_slug']).'
								    </a>';
							}
						}
					}
					
				}	
			?>
			<a href="#" class="list-group-item request-new-cat"><?php echo $this->lang->line('courseList_btn_requestNewCategory');?></a>
		</div>
	</div>

	<div class="col-md-9 animated fadeIn">
		<?php 
			if($this->config->item('language') != 'spanish')
			{
				$title_cat = $this->lang->line('courseList_catTitle_'.$category);
			}
		?>
		<h3><?php echo $this->lang->line('courseList_availableCoursesIn').$title_cat.$insub;?></h3>
			<?php 
			    if(count($courses_arr) < 1)
			    {
			    	echo '<div class="text-center no-courses-in-category">';
			    	echo '<h4>'.$this->lang->line('courseList_msg_noCoursesInCategory').':</h4>
			    		  <h3>'.$this->lang->line('courseList_catTitle_'.$category).$insub.'</h3>
			    		  <h4>&nbsp;</h4>';
			    	echo '<a href="'.base_url('courses/create').'" class="btn btn-primary btn-lg">'.$this->lang->line('courseList_btn_beTheFirst').'</a>';
			    	echo '</div>';
			    }
			    else
			    {
					$data = array(
						'courses_arr' => $courses_arr,
						'cl_page' => 'home_featured',
					);
					$this->load->view('templates/course_list.php',$data);
			    }
		/*		foreach($courses_arr as $course)
				{	
					echo '	
					<div class="course_cat_listing">
						<div class="row">
							<div class="col-lg-11 course-info-listing">
								<a href="'.base_url('courses/details/'.$course['course_slug']).'">
									<h3 class="list-course-title">'.$course['course_title'].'</h3>
								</a>
							</div>
							<div class="col-lg-1 list-course-info-btn">
								<a id="'.$course['id'].'" href="#" onclick="toggleListInfo(this.id);return false;">
									<span class="glyphicon glyphicon-info-sign"></span>
								</a>
							</div>
						</div>



						<div id="list-info-'.$course['id'].'" class="row course_info_extra">
							<div class="col-lg-2 course-info-listing">
								<strong>'.$this->lang->line('courseField_teacher').':</strong><br/>
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
				}*/
			?>
	</div>
</div>