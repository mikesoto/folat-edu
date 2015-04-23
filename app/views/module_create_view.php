<h2><?php echo $this->lang->line('moduleCreate_title_createModule').': '.$course_arr['course_title'];?></h2>
<div class="row">
	<div class="col-lg-12">
		<!--Validation Errors if any-->
		<?php if(validation_errors() != ''):?>
		<div class="col-lg-12 alert alert-danger" role="alert">
			<?php echo validation_errors(); ?>

		</div>
		<h4>&nbsp;<!--for spacing--></h4>
		<?php endif;?>
		<?php $this->load->view('templates/flash_messages');?>
		<div id="create_module_form_container" style="max-width:600px;">
			<!--open form-->
			<?php echo form_open_multipart('verify_module_create',array('role' => 'form', 'id' => 'create_module_form')); ?>
				<div class="col-lg-12">	
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
							 	<label for="type_id"><?php echo $this->lang->line('moduleField_type');?>:</label>
							 	<a tabindex="0" id="type-tooltip" class="btn btn-lg btn-info form-tooltip-button" role="button" data-trigger="focus" data-toggle="popover" title="<?php echo $this->lang->line('moduleField_type');?>" data-content="<?php echo $this->lang->line('moduleCreate_selectModuleType');?>">?</a>
							 	<select class="form-control" id="type_id" name="type_id" onchange="load_type_desc(this.value);">
							 		<option value=""></option>
							 		<?php 
							 			foreach($mod_types as $type)
							 			{
							 				echo '<option value="'.$type['id'].'">'.$this->lang->line('moduleField_type_'.$type['name']).'</option>';
							 			}
							 		?>
							 	</select>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
							 	<label for="title"><?php echo $this->lang->line('moduleField_title');?>:</label>
							 	<a tabindex="0" class="btn btn-lg btn-info form-tooltip-button" role="button" data-trigger="focus" data-toggle="popover" title="<?php echo $this->lang->line('moduleField_title');?>" data-content="<?php echo $this->lang->line('moduleCreate_tooltipTitle');?>">?</a>
							 	<input type="text" class="form-control" id="title" maxlength="50" name="title" value="<?php echo set_value('title'); ?>"/>
							</div>
						</div>	
					</div>

					<div class="row">
						<div class="col-lg-12">
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
									 	<label for="title"><?php echo $this->lang->line('moduleField_chapter');?>:</label>
									 	<a tabindex="0" class="btn btn-lg btn-info form-tooltip-button" role="button" data-trigger="focus" data-toggle="popover" title="<?php echo $this->lang->line('moduleCreate_tooltipTitleChapSec');?>" data-content="<?php echo $this->lang->line('moduleCreate_tooltipChapSec');?>">?</a>
									 	<input type="text" class="form-control" id="chapter" name="chapter" style="max-width:100px;" value="<?php echo set_value('chapter'); ?>"/>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
									 	<label for="title"><?php echo $this->lang->line('moduleField_section');?>:</label>
									 	<a tabindex="0" class="btn btn-lg btn-info form-tooltip-button" role="button" data-trigger="focus" data-toggle="popover" title="<?php echo $this->lang->line('moduleCreate_tooltipTitleChapSec');?>" data-content="<?php echo $this->lang->line('moduleCreate_tooltipChapSec');?>">?</a>
									 	<input type="text" class="form-control" id="section" name="section" style="max-width:100px;" value="<?php echo set_value('section'); ?>"/>
									</div>
								</div>
							</div>
						</div>	
					</div>

					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
							 	<label for="title"><?php echo $this->lang->line('moduleField_description');?>:</label>
							 	<a tabindex="0" class="btn btn-lg btn-info form-tooltip-button" role="button" data-trigger="focus" data-toggle="popover" title="<?php echo $this->lang->line('moduleField_description');?>" data-content="<?php echo $this->lang->line('moduleCreate_tooltipDescription');?>">?</a>
							 	<textarea class="form-control" id="summary" name="summary" rows="5"><?php echo set_value('summary'); ?></textarea>
							</div>
						</div>	
					</div>

					<div class="row">
						<div class="col-lg-12">
							<div class="form-group text-center">
								<input type="hidden" name="course_id" value="<?php echo $course_arr['id'];?>">
								<input type="submit" class="btn btn-primary create-module-submit-btn" value="<?php echo $this->lang->line('moduleCreate_btn_saveAndContinue');?>"/>
							</div>
						</div>
					</div>

				</div>
			</form>
			<br class="clearfix"/>
		</div><!--/create_module_form_container-->
	</div>
</div>


<script>
	var type_descs = [];
	<?php 
		foreach($mod_types  as $type)
 		{	
 			echo 'type_descs.push("'.$type['id'].'_'.$type['name'].'_'.$this->lang->line('moduleField_typeDesc_'.$type['name']).'");';
 		}
 	?>
	
	function load_type_desc(type_id)
	{ 
		for(i=0; i< type_descs.length; i++)
		{
			info_arr = type_descs[i].split("_")
			tp_id = info_arr[0];
			tp_name = info_arr[1];
			tp_desc = info_arr[2];
			if(type_id == tp_id)
			{
				$('#type-tooltip').attr('data-content',tp_desc);
				$('#type-tooltip').popover();
			}
		}
	}

	$(document).ready(function(){
		//initialize all popovers for tooltip hints
		$('[data-toggle="popover"]').popover();
	});
</script>
