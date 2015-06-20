<!--Validation Errors if any-->
<?php if(validation_errors() != ''):?>
	<div class="col-lg-12 alert alert-danger" role="alert">
		<?php echo validation_errors(); ?>
	</div>
<?php endif;?>
<?php $this->load->view('templates/flash_messages');?>

<?php if($module_arr['type_id'] == 1)://TODO # this will be passed to a template later?>
<div class="row">
	<div class="col-lg-12">	
		<div class="col-lg-12 text-right">
			<a id="back-to-course-btn" class="btn btn-success btn-sm" href="<?php echo base_url('courses/manage/'.$course_arr['course_slug']);?>">
				<span class="glyphicon glyphicon-share-alt"></span>
				<?php echo $this->lang->line('moduleEdit_btn_backToCourse');?>
			</a>
		</div>
		
		<div class="list-group">
			<li class="col-lg-12 list-group-item">

				<div class="row">
						<div class="col-lg-9">
							<h3><?php echo $this->lang->line('moduleEdit_title_module');?> <?php echo $module_arr['chapter'].'.'.$module_arr['section'];?> <?php echo $module_arr['title'];?></h3>
						</div>
						<div class="col-lg-3 text-right">
							<a href="#" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#edit_module_modal"><?php echo $this->lang->line('moduleEdit_btn_editModuleInfo');?></a>
						</div>
						
				</div>
				<div class="row">
					<div class="col-sm-12">
						<h4><?php echo $this->lang->line('moduleField_length');?>: <?php echo $module_time['hh'].':'.$module_time['mm'];?></h4>
						
					</div>
				</div>
				<div class="row">
						<div class="col-sm-6 col-xs-12">
							<h4><?php echo $this->lang->line('moduleField_description');?>:</h4>
							<?php echo lineBreaksToBr($module_arr['summary']);?>
						</div>
						<div class="col-sm-6 col-xs-12">
							<h4><?php echo $this->lang->line('moduleField_type');?>: <?php echo $this->lang->line('moduleField_type_'.$module_arr['module_type_name']);?></h4>
							<?php echo $this->lang->line('moduleField_typeDesc_'.$module_arr['module_type_name']);?>
						</div>
				</div>
			</li>
		</div>

		<hr/>
<?php //==================================== SLIDES FOR THIS MODULE ==================================?>
		<div class="row">
			<div class="col-lg-12">
				<h2><?php echo $this->lang->line('moduleEdit_title_slideForModule');?></h2>
			</div>

			<div class="col-lg-12 text-center">
				<button type="button" class="btn btn-primary btn-lg add-new-slide-button" data-toggle="modal" data-target="#add_slide_modal">
				  <?php echo $this->lang->line('moduleEdit_btn_addNewSlide');?>
				</button>
			</div>

			<div class="col-lg-12">
				<div class="list-group">
					<?php if(!$module_content):?>
						<div class="col-lg-12 text-center">
							<div class="help-text-add-content" style="text-align:center">
								<?php echo $this->lang->line('moduleEdit_msg_noSlides');?>
							</div>
						</div>
					<?php else:?>
						<?php foreach($module_content as $content):?>
							<li class="col-lg-12 list-group-item text-module-slide-listing">
								<div class="col-lg-12">
									
									<div class="slide-edit-controls col-lg-3 text-right pull-right">
										<a href="#" title="<?php echo $this->lang->line('slideField_editSlide');?>" data-toggle="modal" data-target="#edit_slide_modal" onclick="setEditSlideContent(<?php echo $content['id'];?>);return false;">
											<i class="fa fa-pencil-square-o"></i>
										</a>
							
										<a href="#" title="<?php echo $this->lang->line('slideField_addQuestion');?>" data-toggle="modal" data-target="#add_questions_modal" onclick="setAddQuestionContent('<?php echo addslashes($content['title'])."','".$content['id'];?>');return false;">
											<i class="fa fa-question"></i>
										</a>
										
										<a class="trash-link" href="#"  title="<?php echo $this->lang->line('slideField_deleteSlide');?>" data-toggle="modal" data-target="#delete_slide_modal" onclick="setDeleteSlideContent(<?php echo $module_arr['id'].','.$content['id'].',\''.$content['title'].'\'';?>);return false;">
									       	<i class="fa fa-trash-o"></i>
									    </a>
									</div>

									<div class="col-lg-1">	
										<h3><?php echo $content['order_num'];?></h3>
									</div>
									
									<div class="col-lg-8">
										<h3><?php echo $content['title'];?></h3>
									</div>
									
									<div class="col-lg-7 edit-content-slide-body">
										<strong><?php echo $this->lang->line('slideField_body');?></strong>:<br/>
										<?php echo $content['body'];?>
									</div>
									<div class="col-lg-5">
										<div class="col-lg-12">
											<strong><?php echo $this->lang->line('slideField_references');?></strong>:
										</div>
										<div class="col-lg-12">
											<?php echo $content['refs'];?>
										</div>
										<div class="col-lg-12">
											<br/>
											<strong><?php echo $this->lang->line('slideField_length');?></strong>:<br/>
											<?php echo $content['slide_time']['hh'].':'.$content['slide_time']['mm'];?></h4>
										</div>
									</div>
								</div>
		
									
<?php //==================================== REVIEW QUESTIONS FOR EACH SLIDE ==================================?>
								<div class="col-lg-12">
									<div class="col-lg-12">
										<h4><?php echo $this->lang->line('slideField_reviewQuestions');?>:</h4>
									</div>
									<div class="col-lg-12">
										<?php if(empty($content['content_questions'])):?>
											<div class="alert alert-warning">
												<?php echo $this->lang->line('moduleEdit_msg_noReviewQuestions');?>
											</div>
										<?php else:?>
											<?php foreach($content['content_questions'] as $question):?>
												<div class="slide-list-question">
													<div class="col-lg-10">
														<strong><?php echo $this->lang->line('questionField_question');?>:</strong> &nbsp;
														<?php echo ($question['question']);?>
													</div>
													<div class="col-lg-2 text-right">
														<ul class="nav nav-tabs course-action-menu">
														  <li role="presentation" class="dropdown">
														    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false"> 
														       <?php echo $this->lang->line('questionField_btn_manage');?> <span class="caret"></span>
														    </a>
														    <ul class="dropdown-menu" role="menu">
														       <li>
														         <a href="#" data-toggle="modal" data-target="#edit_questions_modal" onclick="setEditQuestionContent(<?php echo $question['id'];?>);return false;"><?php echo $this->lang->line('questionField_btn_editQuestion');?></a>
														       </li>
														       <li>
														         <a href="#" data-toggle="modal" data-target="#move_question_modal" onclick="setMoveQuestionId(<?php echo $question['id'];?>);"><?php echo $this->lang->line('questionField_btn_moveQuestion');?></a>
														       </li>
														       <li>
														         <a href="#" data-toggle="modal" data-target="#delete_question_modal" onclick="setDeleteQuestionContent(<?php echo $module_arr['id'].','.$content['id'].','.$question['id'].",'".lineBreaksToBr(addslashes(encodeQuot($question['question'])))."'";?>);return false;"><?php echo $this->lang->line('questionField_btn_deleteQuestion');?></a>
														       </li>
														    </ul>
														  </li>
														</ul>				
													</div>

													<div class="col-lg-6">
														<strong><?php echo $this->lang->line('questionField_correctAnswer');?>:</strong><br/>
														<?php echo ($question['answer']);?>
													</div>
													<div class="col-lg-6">
														&nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo $this->lang->line('questionField_incorrectAnswers');?>:</strong><br/>
														<ol>
															<li><?php echo ($question['wrong_1']);?></li>
															<li><?php echo ($question['wrong_2']);?></li>
															<li><?php echo ($question['wrong_3']);?></li>
														</ol>
													</div>
													
													<div class="clearfix"></div>
												</div>
											<?php endforeach;?>
										<?php endif;?>
									</div>
								</div>

							</li>
						<?php endforeach;?>
					<?php endif;?>
				</div>
			</div>

			<div class="col-lg-12 text-center">
				<button type="button" class="btn btn-primary btn-lg add-new-slide-button" data-toggle="modal" data-target="#add_slide_modal">
				  <?php echo $this->lang->line('moduleEdit_btn_addNewSlide');?>
				</button>
			</div>
		</div>
	</div>
</div>







<?php //==================================== MODAL FOR EDIT MODULE ==================================?>
	 	<div id="edit_module_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="edit_module_modal" aria-hidden="true">
	 		<div class="modal-dialog">
			    <div class="modal-content">
			      	<div class="modal-header">
			      		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        				<h4 class="modal-title" id="edit_module_form_title"><?php echo $this->lang->line('moduleEdit_title_editModule');?></h4>
      				</div>
      				<!--form-->
					<?php echo form_open_multipart('verify_module_update',array('role' => 'form', 'id' => 'edit_module_form')); ?>
	      				<div class="modal-body">
								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
										 	<label for="title"><?php echo $this->lang->line('moduleField_title');?>: </label> 
										 	<a tabindex="0" class="btn btn-lg btn-info form-tooltip-button" role="button" data-trigger="focus" data-toggle="popover" title="Module Title" data-content="Module titles have a maximum length of 50 Characters. ">?</a>
										 	<input  type="text" class="form-control" id="title" name="title" value="<?php echo $module_arr['title']; ?>" maxlength="50" style="max-width:400px;"/>
										</div>
									</div>	
								</div>

								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
										 	<label for="title"><?php echo $this->lang->line('moduleField_chapter');?>:</label> 
										 	<a tabindex="0" class="btn btn-lg btn-info form-tooltip-button" role="button" data-trigger="focus" data-toggle="popover" title="Chapter" data-content="Courses are divided into Chapters and Sections. The content in this module will be sorted by these numbers. Both values must be numbers only (No Alphabetical Characters).">?</a>
										 	<input type="text" class="form-control" id="chapter" name="chapter" value="<?php echo $module_arr['chapter']; ?>" style="max-width:100px;"/>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
										 	<label for="title"><?php echo $this->lang->line('moduleField_section');?>:</label> 
										 	<a tabindex="0" class="btn btn-lg btn-info form-tooltip-button" role="button" data-trigger="focus" data-toggle="popover" title="Section" data-content="Courses are divided into Chapters and Sections. The content in this module will be sorted by these numbers. Both values must be numbers only (No Alphabetical Characters).">?</a>
										 	<input type="text" class="form-control" id="section" name="section" value="<?php echo $module_arr['section']; ?>" style="max-width:100px;"/>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
										 	<label for="title"><?php echo $this->lang->line('moduleField_description');?>:</label> 
										 	<a tabindex="0" class="btn btn-lg btn-info form-tooltip-button" role="button" data-trigger="focus" data-toggle="popover" title="Slide Text" data-content="The module summary is a short description of what the student can expect to learn in this section. Keep it short and to the point. You can list any pre-requisite knowledge for this module or if they can skip it entirely.">?</a>
										 	<textarea class="form-control" id="summary" name="summary" rows="5"><?php echo $module_arr['summary']; ?></textarea>
										</div>
									</div>	
								</div>

								<input type="hidden" name="module_id" value="<?php echo $module_arr['id'];?>"/>
								<input type="hidden" name="course_id" value="<?php echo $module_arr['course_id'];?>"/>
						</div>
	      				<div class="modal-footer">
					    	<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('moduleField_updateCancel');?></button>
					    	<input type="submit" class="btn btn-primary" value="<?php echo $this->lang->line('moduleField_updateModule');?>"/>
					    </div>
				 	</form><!--/form-->
    			</div>
  			</div>
	 	</div>








<?php //==================================== MODAL FOR ADD SLIDE ==================================?>
	 	<div id="add_slide_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="add_slide_modal" aria-hidden="true">
	 		<div class="modal-dialog">
			    <div class="modal-content">
			      	<div class="modal-header">
			      		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        				<h4 class="modal-title" id="add_slide_form_title"><?php echo $this->lang->line('slideField_addNewSlide');?></h4>
      				</div>
      				<!--form-->
					<?php echo form_open_multipart('verify_text_slide_create',array('role' => 'form', 'id' => 'add_module_content_form')); ?>
	      				<div class="modal-body">
								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
										 	<label for="title"><?php echo $this->lang->line('slideField_title');?>: </label> <a tabindex="0" class="btn btn-lg btn-info form-tooltip-button" role="button" data-trigger="focus" data-toggle="popover" title="Slide Title" data-content="Keep it related to the slide text. Maximum of 50 characters">?</a>
										 	<input type="text" class="form-control" id="title" maxlength="50" name="title" value="<?php echo set_value('title'); ?>" style="max-width:400px;"/>
										</div>
									</div>	
								</div>

								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
										 	<label for="order_num"><?php echo $this->lang->line('slideField_orderNum');?>:</label> <a tabindex="0" class="btn btn-lg btn-info form-tooltip-button" role="button" data-trigger="focus" data-toggle="popover" title="Order Number" data-content="Slides are sorted and listed by this number. You can always edit this later to move the slide up or down in the list.">?</a>
										 	<input type="text" class="form-control" id="order_num" name="order_num" value="<?php echo set_value('order_num'); ?>" style="max-width:100px;"/>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
										 	<label for="length"><?php echo $this->lang->line('slideField_length');?>:</label> <a tabindex="0" class="btn btn-lg btn-info form-tooltip-button" role="button" data-trigger="focus" data-toggle="popover" title="Slide Length" data-content="The amount of time (in minutes) that the student is expected to spend reading this slide and answering all of it's questions. Recommended time is between 3 and 5 minutes per slide. These times are added up to calculate the total time for the module and course.">?</a>
										 	<input type="text" class="form-control" id="length" name="length" value="<?php echo set_value('length','5'); ?>" style="max-width:100px;"/> minutes (numbers only)
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
										 	<label for="body"><?php echo $this->lang->line('slideField_body');?>:</label> <a tabindex="0" class="btn btn-lg btn-info form-tooltip-button" role="button" data-trigger="focus" data-toggle="popover" title="Slide Text" data-content="This is the body of the text slide which should contain up to 2 or 3 paragraphs (max 1000 characters) of knowledge for the student to learn and retain. The Questions in the next step will be related to this content and will test the student's comprehension at the end of the module.">?</a>
										 	<textarea class="form-control mceEditor" id="body" name="body" maxlength="2000" rows="10"><?php echo set_value('body'); ?></textarea>
										</div>
									</div>	
								</div>

								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
										 	<label for="refs"><?php echo $this->lang->line('slideField_references');?>:</label> <a tabindex="0" class="btn btn-lg btn-info form-tooltip-button" role="button" data-trigger="focus" data-toggle="popover" title="Text References" data-content="It's recommended to cite your references in order to support the validity of your course. This is optional, but can be useful to your student's as they can read-up on some of your sources to learn more. It's also important to give credit to authors of original works and respect copyright laws. Be sure to include the Author, Title of Book, Article, or Web Page, Date, and URL's if any.">?</a>
										 	<textarea class="form-control" id="refs" name="refs" rows="4"><?php echo set_value('refs'); ?></textarea>
										</div>
									</div>	
								</div>
								<input type="hidden" name="module_id" value="<?php echo $module_arr['id'];?>">
						</div>
	      				<div class="modal-footer">
					    	<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('slideField_cancel');?></button>
					    	<input type="submit" class="btn btn-primary" value="<?php echo $this->lang->line('slideField_createSlide');?>"/>
					    </div>
				 	</form><!--/form-->
    			</div>
  			</div>
	 	</div>




<?php //==================================== MODAL FOR EDIT SLIDE ==================================?>
	 	<div id="edit_slide_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="edit_slide_modal" aria-hidden="true">
	 		<div class="modal-dialog">
			    <div class="modal-content">
			      	<div class="modal-header">
			      		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        				<h4 class="modal-title" id="edit_slide_form_title"><?php echo $this->lang->line('slideField_editSlide');?></h4>
      				</div>
      				<!--form-->
					<?php echo form_open_multipart('verify_text_slide_update',array('role' => 'form', 'id' => 'edit_module_content_form')); ?>
	      				<div class="modal-body">
								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
										 	<label for="title"><?php echo $this->lang->line('slideField_title');?>: </label> <a tabindex="0" class="btn btn-lg btn-info form-tooltip-button" role="button" data-trigger="focus" data-toggle="popover" title="Slide Title" data-content="Keep it related to the slide text. Maximum of 50 characters">?</a>
										 	<input type="text" class="form-control" id="edit_slide_title" maxlength="50" name="title" value="<?php echo set_value('title'); ?>" style="max-width:400px;"/>
										</div>
									</div>	
								</div>

								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
										 	<label for="title"><?php echo $this->lang->line('slideField_orderNum');?>:</label> <a tabindex="0" class="btn btn-lg btn-info form-tooltip-button" role="button" data-trigger="focus" data-toggle="popover" title="Order Number" data-content="Slides are sorted and listed by this number. You can always edit this later to move the slide up or down in the list.">?</a>
										 	<input type="text" class="form-control" id="edit_slide_order_num" name="order_num" value="<?php echo set_value('order_num'); ?>" style="max-width:100px;"/>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
										 	<label for="title"><?php echo $this->lang->line('slideField_length');?>:</label> <a tabindex="0" class="btn btn-lg btn-info form-tooltip-button" role="button" data-trigger="focus" data-toggle="popover" title="Slide Length" data-content="The amount of time (in minutes) that the student is expected to spend reading this slide and answering all of it's questions. Recommended time is between 3 and 5 minutes per slide. These times are added up to calculate the total time for the module and course.">?</a>
										 	<input type="text" class="form-control" id="edit_slide_length" name="length" value="<?php echo set_value('length'); ?>" style="max-width:100px;"/> minutes (numbers only)
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
										 	<label for="title"><?php echo $this->lang->line('slideField_body');?>:</label> <a tabindex="0" class="btn btn-lg btn-info form-tooltip-button" role="button" data-trigger="focus" data-toggle="popover" title="Slide Text" data-content="This is the body of the text slide which should contain up to 2 or 3 paragraphs (max 1000 characters) of knowledge for the student to learn and retain. The Questions in the next step will be related to this content and will test the student's comprehension at the end of the module.">?</a>
										 	<textarea class="form-control mceEditor" id="edit_slide_body" name="body" maxlength="2000" rows="10"><?php echo set_value('body'); ?></textarea>
										</div>
									</div>	
								</div>

								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
										 	<label for="title"><?php echo $this->lang->line('slideField_references');?>:</label> <a tabindex="0" class="btn btn-lg btn-info form-tooltip-button" role="button" data-trigger="focus" data-toggle="popover" title="Text References" data-content="It's recommended to cite your references in order to support the validity of your course. This is optional, but can be useful to your student's as they can read-up on some of your sources to learn more. It's also important to give credit to authors of original works and respect copyright laws. Be sure to include the Author, Title of Book, Article, or Web Page, Date, and URL's if any.">?</a>
										 	<textarea class="form-control" id="edit_slide_refs" name="refs" rows="4"><?php echo set_value('refs'); ?></textarea>
										</div>
									</div>	
								</div>
								<input type="hidden" name="module_id" value="<?php echo $module_arr['id'];?>">
								<input type="hidden" id="edit_slide_id" name="slide_id" value="">
						</div>
	      				<div class="modal-footer">
					    	<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('slideField_cancel');?></button>
					    	<input type="submit" class="btn btn-primary" value="<?php echo $this->lang->line('slideField_updateSlide');?>"/>
					    </div>
				 	</form><!--/form-->
    			</div>
  			</div>
	 	</div>




<?php //==================================== MODAL FOR DELETE SLIDE ==================================?>
	 	<div id="delete_slide_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="delete_slide_modal" aria-hidden="true">
	 		<div class="modal-dialog">
			    <div class="modal-content">
			      	<div class="modal-header">
			      		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        				<h4 class="modal-title" id="delete_question_modal_title"><?php echo $this->lang->line('slideField_deleteSlide');?></h4>
      				</div>
      				<div class="modal-body">
							<div class="row">
								<div id="delete_slide_modal_body" class="col-lg-12 text-center">
									<!--this content is set dynamically-->
								</div>	
							</div>
					</div>
      				<div class="modal-footer">
				    	<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('slideField_cancel');?></button>
				    	<button id="delete_slide_btn" type="button" class="btn btn-danger" onclick=""><?php echo $this->lang->line('slideField_deleteSlide');?></button>
				    </div>
      			</div>
  			</div>
	 	</div>






<?php //==================================== MODAL FOR ADD QUESTION ==================================?>
	 	<div id="add_questions_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="add_questions_modal" aria-hidden="true">
	 		<div class="modal-dialog">
			    <div class="modal-content">
			      	<div class="modal-header">
			      		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        				<h4 class="modal-title" id="add_questions_form_title"><?php echo $this->lang->line('questionField_addReviewQuestion');?></h4>
      				</div>
      				<!--form-->
					<?php echo form_open_multipart('verify_question_create',array('role' => 'form', 'id' => 'add_review_question_form')); ?>
	      				<div class="modal-body">
								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
										 	<label for="question"><?php echo $this->lang->line('questionField_question');?>: </label> 
										 	<a tabindex="0" class="btn btn-lg btn-info form-tooltip-button" role="button" data-trigger="focus" data-toggle="popover" title="<?php echo $this->lang->line('questionField_question');?>" data-content="<?php echo $this->lang->line('questionField_tooltipQuestion');?>">?</a>
										 	<textarea maxlength="245" class="form-control" id="question" name="question" rows="3"><?php echo set_value('question'); ?></textarea>
										</div>
									</div>	
								</div>

								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
										 	<label for="answer"><?php echo $this->lang->line('questionField_correctAnswer');?>:</label> 
										 	<a tabindex="0" class="btn btn-lg btn-info form-tooltip-button" role="button" data-trigger="focus" data-toggle="popover" title="<?php echo $this->lang->line('questionField_correctAnswer');?>" data-content="<?php echo $this->lang->line('questionField_tooltipAnswer');?>">?</a>
										 	<textarea maxlength="245" class="form-control" id="answer" name="answer" rows="2"><?php echo set_value('answer'); ?></textarea>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
										 	<label for="wrong_1"><?php echo $this->lang->line('questionField_incorrectAnswer1');?>:</label> 
										 	<a tabindex="0" class="btn btn-lg btn-info form-tooltip-button" role="button" data-trigger="focus" data-toggle="popover" title="<?php echo $this->lang->line('questionField_incorrectAnswer1');?>" data-content="<?php echo $this->lang->line('questionField_tooltipWrong1');?>">?</a>
										 	<textarea maxlength="245" class="form-control" id="wrong_1" name="wrong_1" rows="2"><?php echo set_value('wrong_1'); ?></textarea>
										</div>
									</div>	
								</div>

								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
										 	<label for="wrong_2"><?php echo $this->lang->line('questionField_incorrectAnswer2');?>:</label> 
										 	<a tabindex="0" class="btn btn-lg btn-info form-tooltip-button" role="button" data-trigger="focus" data-toggle="popover" title="<?php echo $this->lang->line('questionField_incorrectAnswer2');?>" data-content="<?php echo $this->lang->line('questionField_tooltipWrong2');?>">?</a>
										 	<textarea maxlength="245" class="form-control" id="wrong_2" name="wrong_2" rows="2"><?php echo set_value('wrong_2'); ?></textarea>
										</div>
									</div>	
								</div>

								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
										 	<label for="wrong_3"><?php echo $this->lang->line('questionField_incorrectAnswer3');?>:</label> 
										 	<a tabindex="0" class="btn btn-lg btn-info form-tooltip-button" role="button" data-trigger="focus" data-toggle="popover" title="<?php echo $this->lang->line('questionField_incorrectAnswer3');?>" data-content="<?php echo $this->lang->line('questionField_tooltipWrong3');?>">?</a>
										 	<textarea maxlength="245" class="form-control" id="wrong_3" name="wrong_3" rows="2"><?php echo set_value('wrong_3'); ?></textarea>
										</div>
									</div>	
								</div>

								<input type="hidden" name="module_id" value="<?php echo $module_arr['id'];?>">
								<input type="hidden" id="slide_id_add_question" name="slide_id" value="<?php echo set_value('slide_id'); ?>">

						</div>
	      				<div class="modal-footer">
					    	<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('questionField_btn_cancel');?></button>
					    	<input type="submit" class="btn btn-primary" value="<?php echo $this->lang->line('questionField_saveQuestion');?>"/>
					    </div>
				 	</form><!--/form-->
      			</div>
  			</div>
	 	</div>








<?php //==================================== MODAL FOR EDIT QUESTION ==================================?>
	 	<div id="edit_questions_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="edit_questions_modal" aria-hidden="true">
	 		<div class="modal-dialog">
			    <div class="modal-content">
			      	<div class="modal-header">
			      		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        				<h4 class="modal-title" id="edit_questions_form_title"><?php echo $this->lang->line('questionField_btn_editQuestion');?></h4>
      				</div>
      				<!--form-->
					<?php echo form_open_multipart('verify_question_update',array('role' => 'form', 'id' => 'edit_review_question_form')); ?>
	      				<div class="modal-body">
								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
										 	<label for="question"><?php echo $this->lang->line('questionField_question');?>: </label> 
										 	<a tabindex="0" class="btn btn-lg btn-info form-tooltip-button" role="button" data-trigger="focus" data-toggle="popover" title="<?php echo $this->lang->line('questionField_question');?>" data-content="<?php echo $this->lang->line('questionField_tooltipQuestion');?>">?</a>
										 	<textarea maxlength="245" class="form-control" id="edit_question" name="question" rows="3"><?php echo set_value('question'); ?></textarea>
										</div>
									</div>	
								</div>

								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
										 	<label for="answer"><?php echo $this->lang->line('questionField_correctAnswer');?>:</label> 
										 	<a tabindex="0" class="btn btn-lg btn-info form-tooltip-button" role="button" data-trigger="focus" data-toggle="popover" title="<?php echo $this->lang->line('questionField_correctAnswer');?>" data-content="<?php echo $this->lang->line('questionField_tooltipAnswer');?>">?</a>
										 	<textarea maxlength="245" class="form-control" id="edit_answer" name="answer" rows="2"><?php echo set_value('answer'); ?></textarea>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
										 	<label for="wrong_1"><?php echo $this->lang->line('questionField_incorrectAnswer1');?>:</label> 
										 	<a tabindex="0" class="btn btn-lg btn-info form-tooltip-button" role="button" data-trigger="focus" data-toggle="popover" title="<?php echo $this->lang->line('questionField_incorrectAnswer1');?>" data-content="<?php echo $this->lang->line('questionField_tooltipWrong1');?>">?</a>
										 	<textarea maxlength="245" class="form-control" id="edit_wrong_1" name="wrong_1" rows="2"><?php echo set_value('wrong_1'); ?></textarea>
										</div>
									</div>	
								</div>

								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
										 	<label for="wrong_2"><?php echo $this->lang->line('questionField_incorrectAnswer2');?>:</label> 
										 	<a tabindex="0" class="btn btn-lg btn-info form-tooltip-button" role="button" data-trigger="focus" data-toggle="popover" title="<?php echo $this->lang->line('questionField_incorrectAnswer2');?>" data-content="<?php echo $this->lang->line('questionField_tooltipWrong2');?>">?</a>
										 	<textarea maxlength="245" class="form-control" id="edit_wrong_2" name="wrong_2" rows="2"><?php echo set_value('wrong_2'); ?></textarea>
										</div>
									</div>	
								</div>

								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
										 	<label for="wrong_3"><?php echo $this->lang->line('questionField_incorrectAnswer3');?>:</label> 
										 	<a tabindex="0" class="btn btn-lg btn-info form-tooltip-button" role="button" data-trigger="focus" data-toggle="popover" title="<?php echo $this->lang->line('questionField_incorrectAnswer3');?>" data-content="<?php echo $this->lang->line('questionField_tooltipWrong3');?>">?</a>
										 	<textarea maxlength="245" class="form-control" id="edit_wrong_3" name="wrong_3" rows="2"><?php echo set_value('wrong_3'); ?></textarea>
										</div>
									</div>	
								</div>

								<input type="hidden" name="module_id" value="<?php echo $module_arr['id'];?>">
								<input type="hidden" id="edit_question_slide_id" name="slide_id" value="<?php echo set_value('slide_id'); ?>">
								<input type="hidden" id="edit_question_id" name="question_id" value="<?php echo set_value('question_id'); ?>">

						</div>
	      				<div class="modal-footer">
					    	<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('questionField_btn_cancel');?></button>
					    	<input type="submit" class="btn btn-primary" value="<?php echo $this->lang->line('questionField_saveQuestion');?>"/>
					    </div>
				 	</form><!--/form-->
      			</div>
  			</div>
	 	</div>




<?php //==================================== MODAL FOR DELETE QUESION ==================================?>
	 	<div id="delete_question_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="delete_question_modal" aria-hidden="true">
	 		<div class="modal-dialog">
			    <div class="modal-content">
			      	<div class="modal-header">
			      		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        				<h4 class="modal-title" id="delete_question_modal_title"><?php echo $this->lang->line('questionField_title_deleteQuestion');?></h4>
      				</div>
      				<div class="modal-body">
							<div class="row">
								<div id="delete_question_modal_body" class="col-lg-12">
									<!--this content is set dynamically-->
								</div>	
							</div>
					</div>
      				<div class="modal-footer">
				    	<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('questionField_btn_cancel');?></button>
				    	<button id="delete_question_btn" type="button" class="btn btn-danger" onclick=""><?php echo $this->lang->line('questionField_btn_deleteQuestion');?></button>
				    </div>
      			</div>
  			</div>
	 	</div>




<?php //==================================== MODAL FOR MOVE QUESTION ==================================?>
	 	<div id="move_question_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="move_question_modal" aria-hidden="true">
	 		<div class="modal-dialog">
			    <div class="modal-content">
			      	<div class="modal-header">
			      		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        				<h4 class="modal-title" id="delete_question_modal_title"><?php echo $this->lang->line('questionField_title_moveQuestion');?></h4>
      				</div>
      				<!--form-->
					<?php echo form_open_multipart('verify_question_move',array('role' => 'form', 'id' => 'move_review_question_form')); ?>
	      				<div class="modal-body">
								<div class="row">
									<div id="move_question_modal_body" class="col-lg-12">
										<?php echo $this->lang->line('questionField_moveToWhere');?>
									</div>
									<div class="col-lg-8">
										<div class="form-group">
											<label for="wrong_2"><?php echo $this->lang->line('questionField_slidesInModule');?>:</label> 
											<a tabindex="0" class="btn btn-lg btn-info form-tooltip-button" role="button" data-trigger="focus" data-toggle="popover" title="<?php echo $this->lang->line('questionField_slidesInModule');?>" data-content="<?php echo $this->lang->line('questionField_tooltipMoveQuestion');?>">?</a>
											<select class="form-control" id="move_to_slide_id" name="move_to_slide_id">
												<?php
													foreach($module_content as $slide)
													{
														echo '<option value="'.$slide['id'].'">'.$slide['order_num'].' '.$slide['title'].'</option>';
													}
												?>
											</select>
										</div>
									</div>
								</div>
								<input type="hidden" name="module_id" value="<?php echo $module_arr['id'];?>"/>
								<input type="hidden" id="move_question_id" name="question_id" value=""/>
						</div>
	      				<div class="modal-footer">
					    	<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('questionField_btn_cancel');?></button>
					    	<input type="submit" class="btn btn-primary" value="<?php echo $this->lang->line('questionField_btn_moveQuestion');?>"/>
					    </div>
					</form>
					<!--/form-->
      			</div>
  			</div>
	 	</div>

	<?php endif;//END IF FOR TYPE ID = 1?>







<script>
	var slides = [];
	<?php 
		if($module_content)
		{
			foreach($module_content as $s)
			{
				//add slide object to slides array in javascript (indexed by the slide id number)
				echo 'slides["'.$s['id'].'"] = {id:'.$s['id'].',module_id: '.$s['module_id'].' , order_num: "'.$s['order_num'].'", length: "'.$s['length'].'", title: "'.sanitizeString($s['title']).'", body: "'.sanitizeString($s['body']).'", refs: "'.sanitizeString($s['refs']).'"};
				';
			}
		}
	?>
	//create javacript array of all questions for edit questions modal to pull from
	var questions = [];
	<?php 
		if($module_content)
		{
			foreach($module_content as $slide)
			{
				foreach($slide['content_questions'] as $q)
				{
					//add question object to questions array in javascript (indexed by the question id number)
					echo 'questions["'.$q['id'].'"] = {id:'.$q['id'].',slide_id: '.$q['slide_id'].' , question: "'.sanitizeString($q['question']).'", answer: "'.sanitizeString($q['answer']).'", wrong_1: "'.sanitizeString($q['wrong_1']).'", wrong_2: "'.sanitizeString($q['wrong_2']).'", wrong_3: "'.sanitizeString($q['wrong_3']).'"};';
				}
			}
		}
	?>
			

	function showBreaksText(str){
		//converts html breaks to linebreaks when showing in a text area
		new_str = str.replace(/<br \/>/g, '<br/>');//replaces breaks with spaces first
		return new_str.replace(/<br\/>/g, '\n');//replaces breaks without spaces last
	}

	function setAddQuestionContent(slide_title, slide_id){
		$("#add_questions_form_title").html('<?php echo $this->lang->line("questionField_addReviewQuestion");?>:<br/><strong>'+slide_title+'</strong>');
		$("#slide_id_add_question").val(slide_id);
	}

	function setEditQuestionContent(q_id){
		$("#edit_question_id").val(questions[q_id].id);
		$("#edit_question_slide_id").val(questions[q_id].slide_id);
		$("#edit_question").val(showBreaksText(questions[q_id].question));
		$("#edit_answer").val(showBreaksText(questions[q_id].answer));
		$("#edit_wrong_1").val(showBreaksText(questions[q_id].wrong_1));
		$("#edit_wrong_2").val(showBreaksText(questions[q_id].wrong_2));
		$("#edit_wrong_3").val(showBreaksText(questions[q_id].wrong_3));
	}	

	function setDeleteQuestionContent(mid,sid,qid,question)
	{
		$("#delete_question_modal_body").html("<em><?php echo $this->lang->line('questionField_confirmDelete');?></em><br/><br/><strong>"+question+"</strong>")
		$("#delete_question_btn").click(function(){
			document.location = '<?php echo base_url("modules/delete_question");?>/'+mid+'/'+sid+'/'+qid;
		});
	}

	function setMoveQuestionId(q_id)
	{
		$("#move_question_id").val(q_id);
	}

	function setEditSlideContent(s_id){
		$("#edit_slide_id").val(slides[s_id].id);
		$("#edit_slide_title").val(slides[s_id].title);
		$("#edit_slide_order_num").val(slides[s_id].order_num);
		$("#edit_slide_length").val(slides[s_id].length);
		tinyMCE.activeEditor.setContent(slides[s_id].body);
		$("#edit_slide_refs").val(showBreaksText(slides[s_id].refs));
		//clean up empty paragraphs in editor
		$("p").each(function() {
		  var $this = $(this);
		  if ($this.html() === " " || $this.html() === "<br>") {
		      $this.remove();
		  }
		});
	}	

	function setDeleteSlideContent(mid,sid,slide_title){
		$("#delete_slide_modal_body").html('<?php echo $this->lang->line("slideField_confimDeleteSlide1");?>:<br/><h3>'+slide_title+'</h3><br/><br/><em><?php echo $this->lang->line("slideField_confimDeleteSlide2");?></em>');
		$("#delete_slide_btn").click(function(){
			document.location = '<?php echo base_url("modules/delete_slide");?>/'+mid+'/'+sid;
		});
	}
				

	$(document).ready(function(){
		//initialize all popovers for tooltip hints
		$('[data-toggle="popover"]').popover();
	});
</script>
