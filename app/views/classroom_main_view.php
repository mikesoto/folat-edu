<div class="container">
	<div class="row animated fadeIn">
		<div class="col-md-12">
			<h3><?php echo $this->lang->line('classroom_main_classroom').': '.$course_arr['course_title'];?></h3>
		</div>

		<div class="col-md-6">
			<h3><?php echo $this->lang->line('classroom_main_course_modules');?></h3>
			<?php
				//var_dump($review_scores);
				$count = 1;
				$show_link_next = 'false';
				foreach($modules_arr as $module)
				{
					$final_score = -1;
					//determine if there is a score for this module
					if(!empty($review_scores))
					{
						foreach($review_scores as $score)
						{
							if($score['module_id'] == $module['id'])
							{
								$final_score = $score['final_score'];
							}
						}
					}
					//determin if the module should be active and linked
					if($final_score > 0 || $count == 1 || $show_link_next == 'true')
					{
						echo '<a href="'.base_url('classroom/module/'.$module['id']).'">';
							echo '<div id="module_'.$count.'" class="row class-room-module-item main-active-module">
									<div class="col-md-9">
										'.$module['chapter'].'.'.$module['section'].' &nbsp; '.$module['title'].'
									</div>
								    <div class="col-md-3">';
								    	//determin if the score is passing
										if($final_score > 69)
										{
											echo '<span class="glyphicon glyphicon-ok main-correct-mark"></span>';
											echo '&nbsp;'.$final_score; 
											$show_link_next = 'true';//they passed this module so next module should be linked
										}
										else
										{
											//in case this is count 1 and there is no score than don't show any icon
											if($final_score != -1)
											{
												echo '<span class="glyphicon glyphicon-remove main-incorrect-mark"></span>';
												echo '&nbsp;'.$final_score; 
											}
											$show_link_next = 'false';//they did not pass this module or there was no score so next module should not be linked
										}
							echo   '</div>
						  		  </div> 
						  	  </a>';
					}
					else //there is no score, count is NOT 1, and show_link_next is not true				
					{
							echo '<div id="module_'.$count.'" class="row class-room-module-item">
									<div class="col-md-9">
										'.$module['chapter'].'.'.$module['section'].' &nbsp; '.$module['title'].'
									</div>
								    <div class="col-md-3">
								    	<i class="fa fa-lock"></i>
								    </div>
						  		  </div> ';
						  	$show_link_next = 'false';
					}
					$count++;
				}	
			?>
		</div>

		<div class="col-md-6">
			<h2>Course Tracker</h2>
			Course Length: <?php echo $course_time['hh'].':'.$course_time['mm'];?><br>
			Reviews for this course:
			<?php 
			foreach($review_scores as $rev):
			?>
			<div class="col-md-12">
				Date: <?php echo $rev['datetime'];?><br/>
				Module ID: <?php echo $rev['module_id'];?><br/>
				Total Questions: <?php echo $rev['total_questions'];?><br/>
				Correct Answers: <?php echo $rev['correct_answers'];?><br/>
				Incorrect Answers: <?php echo $rev['incorrect_answers'];?><br/>
				Final Score: <?php echo $rev['final_score'];?><br/>
				<hr/>
			</div>
			<?php endforeach;?>
		</div>


	</div>
</div>