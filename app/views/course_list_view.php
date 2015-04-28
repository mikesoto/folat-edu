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
	<!--Validation Errors if any-->
	<?php if(validation_errors() != ''):?>
		<div class="col-lg-12 alert alert-danger" role="alert">
			<?php echo validation_errors(); ?>
		</div>
	<?php endif;?>
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
							'.$this->lang->line('cat_'.$cat['cat_slug']);
							if($incat[$cat['id']] > 0)
							{
								echo '<span class="badge cat_badge">'.$incat[$cat['id']].'</span>';
							}
					echo '</a>';
						
					if($cat['cat_name'] == $category)
					{
						foreach($subcat_list as $subcat)
						{
							if($subcat['subcat_parent_id'] == $cat['id'])
							{
							  echo '<a href="'.base_url('courses/category/'.$cat['cat_slug'].'/'.$subcat['subcat_slug']).'" class="list-group-item subcat-link '.is_active_subcat($subcat['subcat_name'],$subcategory).'" title="'.$subcat['subcat_description'].'">
										<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
										'.$this->lang->line('subcat_'.$subcat['subcat_slug']);
										if($insubcat[$subcat['id']] > 0)
										{
											echo '<span class="badge subcat_badge">'.$insubcat[$subcat['id']].'</span>';
										}
							  echo '</a>';
							}
						}
					}
				}	
			?>
			<a href="#" class="list-group-item request-new-cat" data-toggle="modal" data-target="#request_cat_modal"><?php echo $this->lang->line('courseList_btn_requestNewCategory');?></a>
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
						'cl_page' => 'course_list',
					);
					$this->load->view('templates/course_list.php',$data);
			    }
			?>
	</div>

	<?php //==================================== MODAL FOR REQUEST CATEGORY ==================================?>
 	<div id="request_cat_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="request_cat_modal" aria-hidden="true">
 		<div class="modal-dialog">
		    <div class="modal-content">
		      	<div class="modal-header">
		      		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    				<h4 class="modal-title" id="request_cat_modal_title">Request a new Category</h4>
  				</div>
  				<!--form-->
				<?php echo form_open_multipart('verify_req_category',array('role' => 'form', 'id' => 'request_cat_form')); ?>
      				<div class="modal-body">
      					<?php if($this->session->userdata('logged_in')):
      						$session_data = $this->session->userdata('logged_in');
      					?>
		      				<input type="hidden" name="user_id" value="<?php echo $session_data['user_id'];?>"/>
		      				<input type="hidden" name="user_username" value="<?php echo $session_data['user_username'];?>"/>
		      				<input type="hidden" name="user_email" value="<?php echo $session_data['user_email'];?>"/>
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
									 	<label for="cat">*Category:</label> 
									 	<input type="text" class="form-control" id="cat" name="cat" maxlength="50" value="<?php echo set_value('cat'); ?>" style="max-width:400px;"/>
									</div>
								</div>	
							</div>

							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
									 	<label for="subcat">*Subcategory:</label> 
									 	<input type="text" class="form-control" id="subcat" name="subcat" maxlength="50" value="<?php echo set_value('cat'); ?>" style="max-width:400px;"/>
									</div>
								</div>	
							</div>

							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
									 	<label for="description">*Description:</label><br/>
									 	<textarea id="description" name="description" maxlength="200" rows="4" cols="40"><?php echo set_value('description'); ?></textarea>
									</div>
								</div>
							</div>
						<?php else:?>
							<div class="row">
								<div class="col-lg-12">
									<p>You must be logged in to request a new category.</p>
									<p>Please <a href="<?php echo base_url('account/login');?>">Login</a> or <a href="<?php echo base_url('account/register');?>">Register</a></p>
								</div>
							</div>	
						<?php endif;?>
					</div>
      				<div class="modal-footer">
				    	<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				    	<input type="submit" class="btn btn-primary" value="Send Request"/>
				    </div>
			 	</form><!--/form-->
			</div>
			</div>
 	</div>
</div>