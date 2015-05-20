<div class="container">
	<div class="row animated fadeIn">
		<div class="col-md-12">
			<h3><?php echo $this->lang->line('classroom_teacher_title').': <a href="'.base_url().'courses/details/'.$course_arr['course_slug'].'">'.$course_arr['course_title'];?></a></h3>
		</div>

		<div class="col-md-11">
			<?php
				//var_dump($review_scores);
				$count = 1;
				$show_link_next = 'false';
			
				if(!empty($students)){
					foreach($students as $student)
					{	
						echo '	<div id="student_'.$student['user_id'].'" class="row class-room-student-item">
									<div class="col-sm-4">
										<a href="#">
											'.$student['user_name'].' '.$student['user_lastname'].' ('.$student['user_username'].')
										</a>
									</div>

									<div class="col-sm-4">';
										$count = 1;
										$total = 0;
										foreach($modules_arr as $module)
										{
											$status = 'normal';
											$module_score = 0;
											//determine if student has completed this module
											if(!empty($review_scores))
											{
												foreach($review_scores as $score)
												{
													if($score['student_id'] == $student['user_id'] && $module['id'] == $score['module_id'])
													{
														$total += $score['final_score'];
														$module_score = $score['final_score'];
														if($score['final_score'] > 69)
														{
															$status = 'completed';
														}
														else
														{
															$status = 'failed';
														}
													}
												}
												$course_avg = round($total/$count);
											}
											
											echo '<a href="#" id="">
											  			<div id="module_'.$module['id'].'" class="teacher-classroom-module-block-'.$status.'">
											  				'.$module_score.'
											  			</div>
												  </a>';
											$count++;
										}
							echo '	</div>	
									<div class="col-md-4">
										'.$this->lang->line('classroom_teacher_average').': '.$course_avg.'
									</div>
						  		</div>';					  	
					}//end foreach
				}
				else
				{
					echo '<h4>'.$this->lang->line('classroom_teacher_noStudents').'</h4>';
				}
								
			?>
		</div>
	</div>
</div>