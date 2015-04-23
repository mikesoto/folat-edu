<?php 
	//loads the submenu template for all account sections
	$data['selected'] = 'create'; 
	$this->load->view('templates/account_submenu',$data);
?>
<h1>&nbsp;</h1>
<div class="create-course-container animated fadeIn">
	<div class="row">
		<div class="col-lg-12">
			<h3><?php echo $this->lang->line('courseCreate_title_createNewCourse');?></h3>
		</div>

		

		<div class="col-lg-12">
			<?php if(validation_errors() != ''):?>
				<div class="alert alert-danger" role="alert"><?php echo validation_errors(); ?></div>
			<?php endif;?>
			<?php $this->load->view('templates/flash_messages');?>
			<?php echo form_open('verify_course_create',array('role' => 'form', 'id' => 'create_course_form')); ?>	
				
				<div class="row">
					<div class="col-lg-10 col-md-offset-1">
							<div class="form-group">
							 	<label for="title"><?php echo $this->lang->line('courseCreate_label_courseTitle');?>:</label>
							 	<input type="text" class="form-control" id="title" name="title" value="<?php echo set_value('title'); ?>"/>
							</div>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-5 col-md-offset-1">
						<div class="form-group">
					 		<label for="category"><?php echo $this->lang->line('courseCreate_label_category');?>:</label>
						 	<select class="form-control" id="category" name="category" onchange="set_subcats(this.value);">
						 		<option value=""></option>
						 		<?php 
						 			foreach($cat_list as $cat)
							 		{
							 			echo '<option value="'.$cat['id'].'" '.set_select("category",$cat['id']).'>'.$this->lang->line('cat_'.$cat['cat_slug']).'</option>';
							 		}
							 	?>
							</select>
						</div>
					</div>

					<div class="col-lg-5">
						<div class="form-group">
					 		<label for="category"><?php echo $this->lang->line('courseCreate_label_subcategory');?>:</label>
						 	<select class="form-control" id="subcategory" name="subcategory">
						 		<option value=""><?php echo $this->lang->line('courseCreate_msg_selectCategoryFirst');?></option>
							</select>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-5 col-md-offset-1">
						<div class="form-group">
							<label for="course_lang"><?php echo $this->lang->line('courseCreate_label_courseLang');?>: </label>
							<select class="form-control" id="course_lang" name="course_lang">
						 		<option value=""></option>
						 		<option value="english" <?php echo is_selected("english",$this->session->userdata('language'));?>>English</option>
								<option value="spanish" <?php echo is_selected("spanish",$this->session->userdata('language'));?>>Español</option>
							</select>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-10 col-md-offset-1">
						<div class="form-group">
							<label for="description"><?php echo $this->lang->line('courseCreate_label_courseDescription');?>: </label>
							<textarea class="form-control" id="description" name="description" cols="20" rows="5"><?php echo set_value('description'); ?></textarea>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-12">
						<div class="form-group text-center">
							<input type="submit" class="btn btn-primary create-course-submit-btn" value="<?php echo $this->lang->line('courseCreate_btn_createNewCourse');?>"/>
						</div>
					</div>
				</div>
			</form>
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
		cur_subcat_id = "";
		<?php
		 	if(set_value('subcategory') != '')
		 	{
		 		echo 'cur_subcat_id = '.set_value('subcategory').';';
		 	}
		?>
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

	$(document).ready(function(){
		if($("#category").val() != '')
		{
			set_subcats($("#category").val());
		}
	});

</script>