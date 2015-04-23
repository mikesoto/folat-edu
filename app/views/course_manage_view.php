<h3 class="course-title">
	<?php echo $this->lang->line('courseManage_title_manage');?>: 
	<?php echo $course_arr['course_title'];?>
</h3>
<div class="row">
	<div class="col-lg-12">
		<?php if(validation_errors() != ''):?>
		<div class="col-lg-12 alert alert-danger" role="alert"><?php echo validation_errors(); ?></div>
		<?php endif;?>
		<?php $this->load->view('templates/flash_messages');?>
		<?php echo form_open_multipart('verify_course_update',array('role' => 'form', 'id' => 'update_course_form')); ?>
			<div class="col-lg-6">	
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
							 	<label for="title"><?php echo $this->lang->line('courseField_title');?>:</label>
							 	<input type="text" class="form-control" id="title" name="title" value="<?php echo $course_arr['course_title']; ?>"/>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
						 		<label for="category"><?php echo $this->lang->line('courseField_category');?>:</label>
							 	<select class="form-control" id="category" name="category" onchange="set_subcats(this.value);">
							 		<option value=""></option>
							 		<?php 
							 			foreach($cat_list as $cat)
								 		{	//is_selected is defined in the my_str_helper
								 			echo '<option value="'.$cat['id'].'" '.is_selected($cat['id'],$course_arr['course_category_id']).'>'.$this->lang->line('cat_'.$cat['cat_slug']).'</option>';
								 		}
								 	?>
								</select>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label for="subcategory"><?php echo $this->lang->line('courseField_subcategory');?></label>
								<select class="form-control" id="subcategory" name="subcategory">
									

								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<label for="description"><?php echo $this->lang->line('courseField_summary');?>: </label>
								<textarea class="form-control" id="description" name="description" cols="20" rows="12"><?php echo $course_arr['course_description'];?></textarea>
							</div>
						</div>
					</div>
			</div>
			<div class="col-lg-6">
				<div class="row">
					<div class="col-lg-4 col-md-3">
						<div class="form-group">
							<label for="course_length"><?php echo $this->lang->line('courseField_length');?>: </label><br/>
							<input type="hidden" name="course_length" value="<?php echo $course_time['hh'].':'.$course_time['mm'];?>"/>
							<span class="btn btn-default" disabled="disabled">
								<?php echo $course_time['hh'].':'.$course_time['mm'];?>
							</span>
						</div>
					</div>
					<div class="col-lg-8 col-md-9 course-update-note">
						<em><?php echo $this->lang->line('courseManage_msg_courseLength');?></em>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-4 col-md-3">
						<div class="form-group">
							<label for="course_length"><?php echo $this->lang->line('courseField_enrollment');?>: </label><br/>
							<select class="form-control" id="enrollment_status" name="enrollment_status">
								<option value=""></option>
								<?php 
									echo '<option value="0" '.is_selected(0,$course_arr['enrollment_status']).'>'.$this->lang->line('courseField_inactive').'</option>';
									echo '<option value="1" '.is_selected(1,$course_arr['enrollment_status']).'>'.$this->lang->line('courseField_active').'</option>';
									echo '<option value="2" '.is_selected(2,$course_arr['enrollment_status']).'>'.$this->lang->line('courseField_paused').'</option>';
								?>
							</select>
						</div>
					</div>
					<div class="col-lg-8 col-md-9 course-update-note">
						<em>
							<?php echo $this->lang->line('courseManage_msg_courseEnrollment');?>
						</em>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							<label for="course_length"><?php echo $this->lang->line('courseField_image');?>: </label><br/>
							<?php 
								if($course_arr['course_image'] !="")
								{
									echo '<img src="'.base_url('uploads/course_imgs/'.$course_arr['course_image']).'" class="img-responsive">';
								} else {
									echo '<img src="'.base_url('images/course_default.png').'" class="img-responsive">';
								}
							?>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<label for="file_course_image"><?php echo $this->lang->line('courseManage_label_changeCourseImage');?>:</label>
						<?php //TODO allow users to delete current image and reset to the default?>
						<input type="file" id="file_course_image" name="file_course_image"/>
						<input type="hidden" name="course_image" value="<?php echo $course_arr['course_image'];?>"/>
					</div>
				</div>
			</div>
			<div class="col-lg-12">
				<div class="col-lg-12 no-padding">
					<div class="form-group text-center">
						<input type="hidden" name="course_id" value="<?php echo $course_arr['id'];?>"/>
						<input type="hidden" name="course_teacher_id" value="<?php echo $course_arr['course_teacher_id'];?>"/>
						<input type="hidden" name="course_slug" value="<?php echo $course_arr['course_slug'];?>"/>
						<input type="submit" class="btn btn-primary update-course-submit-btn" value="<?php echo $this->lang->line('courseManage_btn_updateCourse');?>"/>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<hr/>

<!--course modules section-->
<div class="row">
	<div class="col-lg-12 text-center">
		<h2><?php echo $this->lang->line('courseManage_title_courseModules');?></h2>
		<?php if(!$modules_arr):?>
		<h4><?php echo $this->lang->line('courseManage_msg_noModules');?></h4>
		<div class="help-text-modules">
			<?php echo $this->lang->line('courseManage_helptext_modules');?>
		</div>		
		<?php else:?>
			<div class="col-lg-12 list-group">
			<?php foreach($modules_arr as $module):?>
				<div class="list-group-item">
					
					<div class="row">
						<div class="col-md-1 module-list-info">
							<?php 
								echo '<strong>'.$module['chapter'].'.'.$module['section'].'</strong>';
							?>
						</div>

						<div class="col-md-8 module-list-title">
							<a href="<?php echo base_url('modules/edit_content/'.$module['id']);?>"><?php echo $module['title'];?></a>
						</div>

						<div class="col-md-3 module-list-options">
							<ul class="nav nav-tabs course-action-menu">
							  <li role="presentation" class="dropdown">
							    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
							       <span class="glyphicon glyphicon-pencil"></span> 
							        <?php echo $this->lang->line('moduleField_teacherActions');?>
							       <span class="caret"></span>
							    </a>
							    <ul class="dropdown-menu" role="menu">
							       <li>
							         <a href="<?php echo base_url('modules/edit_content/'.$module['id']);?>"><?php echo $this->lang->line('moduleField_editContent');?></a>
							       </li>
							       <li>
							       	 <a href="#" data-toggle="modal" data-target="#delete_module_modal" onclick="setDeleteModuleContent(<?php echo $module['id'];?>,'<?php echo $module['title'];?>','<?php echo $course_arr['course_slug'];?>');return false;"><?php echo $this->lang->line('moduleField_deleteModule');?></a>
							       </li>
							    </ul>
							  </li>
							</ul>

						</div>
					</div>
					
					<div class="row">
						<div class="col-md-2 module-list-info">
							<?php echo '<strong>'.$this->lang->line('moduleField_type').':</strong> '.$this->lang->line('moduleField_type_'.$module['module_type_name']);?>
						</div>

						<div class="col-md-2 module-list-info">
							<?php echo $module['slides_count'].' '.$this->lang->line('moduleField_slides');?>
						</div>

						<div class="col-md-2 module-list-info">
							<?php echo $module['questions_count'].' '.$this->lang->line('moduleField_questions');?>
						</div>

						<div class="col-md-2 module-list-info">
							<?php echo $this->lang->line('moduleField_length').' '.$module['module_time']['hh'].':'.$module['module_time']['mm'];?>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12 module-list-summary">
							<strong><?php echo $this->lang->line('moduleField_description');?>:</strong> <?php echo lineBreaksToBr($module['summary']);?>
						</div>
					</div>
					
					<div class="clearfix"></div>
				</div>
			<?php endforeach;?>
			</div>
		<?php endif;?>
		<div class="col-lg-12 text-center">
			<a href="<?php echo base_url('modules/create/'.$course_arr['id']);?>" class="btn btn-lg btn-primary creat-new-module-btn"><?php echo $this->lang->line('courseManage_btn_createNewModule');?></a>
		</div>
	</div>
</div>


<!--==================================== MODAL FOR DELETE MODULE ==================================-->
<div id="delete_module_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="delete_module_modal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
			    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        		<h4 class="modal-title" id="delete_module_modal_title"><?php echo $this->lang->line('moduleField_deleteModule');?></h4>
      		</div>
      		<div class="modal-body">
				<div class="row">
					<div id="delete_module_modal_body" class="col-lg-12 text-center">
						<!--this content is set dynamically-->
					</div>	
				</div>
			</div>
      		<div class="modal-footer">
		    	<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('moduleField_deleteCancel');?></button>
		    	<button id="delete_module_btn" type="button" class="btn btn-danger" onclick=""><?php echo $this->lang->line('moduleField_btn_deleteModule');?></button>
			</div>
		</div>
	</div>
</div>


<script>
	var subcats = [];
	<?php 
		foreach($subcat_list as $subcat)
 		{	
 			echo 'subcats.push("'.$subcat['subcat_parent_id'].'_'.$subcat['id'].'_'.$this->lang->line('subcat_'.$subcat['subcat_slug']).'");';
 		}
 	?>

	function set_subcats(category_id)
	{ 
		cur_subcat_id = <?php echo $course_arr['course_subcat_id'];?>;
		element = document.getElementById('subcategory');
		element.value = "";
		element.innerHTML = "";
		new_str = '<option value=""></option>';
		for(i=0; i < subcats.length; i++)
		{
			string = subcats[i];
			data = string.split('_');
			parent_id = data[0];
			subcat_id = data[1];
			subcat_name = data[2];
			if(parent_id == category_id)
			{
				var sel = "";
				if(subcat_id == cur_subcat_id)
				{
					sel = 'selected="selected"';
				}
				new_str += '<option value="'+subcat_id+'" '+sel+'>'+subcat_name+'</option>';
			}
		}
		element.innerHTML = new_str;
	}

	function setDeleteModuleContent(mid,module_title,course_slug){
		$("#delete_module_modal_body").html('<?php echo $this->lang->line("moduleField_msg_deleteModule1");?><br/>'+module_title+'<br/><?php echo $this->lang->line("moduleField_msg_deleteModule2");?>');
		$("#delete_module_btn").click(function(){
			document.location = '<?php echo base_url("modules/delete_module");?>/'+mid+'/'+course_slug;
		});
	}


	$(document).ready(function(){
		//run initial set_subcats (in case category is set after failing validation)
		set_subcats(document.getElementById('category').value);
	});	

</script>

