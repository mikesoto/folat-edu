<div class="container">
	<div class="row animated fadeIn">
		<div class="col-md-12">
			<h3><?php echo $this->lang->line('classroom_main_classroom').': <a href="'.base_url().'courses/details/'.$course_arr['course_slug'].'">'.$course_arr['course_title'];?></a></h3>
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
					//determine if the module should be active and linked
					if($final_score > 0 || $count == 1 || $show_link_next == 'true')
					{
						echo '<a href="'.base_url('classroom/module/'.$module['id']).'">';
							echo '<div id="module_'.$count.'" class="row class-room-module-item main-active-module">
									<div class="col-sm-9">
										'.$module['chapter'].'.'.$module['section'].' &nbsp; '.$module['title'].'
									</div>
								    <div class="col-sm-3">';
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

		<div class="col-md-3 hidden-sm hidden-xs">
			<h3>Questions</h3>
			<!-- Course Length: <?php echo $course_time['hh'].':'.$course_time['mm'];?><br> -->
			<?php 
			if($review_scores){
				foreach($review_scores as $rev)
				{
					echo '
						  <div class="rev_qbox_container">
							  <div class="col-md-12">';
								//show correct qboxes
								for($i = 0; $i < $rev['correct_answers']; $i++)
								{
									echo '<div class="rev_qbox_correct"></div>';
								}
								//show incorrect qboxes
								for($i = 0; $i < $rev['incorrect_answers']; $i++)
								{
									echo '<div class="rev_qbox_incorrect"></div>';
								}

					echo '	  </div>
						  </div>';
				}
			}
			else
			{
				echo '
						  <div class="rev_qbox_container">
							  <div class="col-md-12">
							  	None completed.
							  </div>
						  </div>
					 ';
			}
			?>
		</div>

		<div class="col-md-3">
			<?php 
				$avg = 0;
				if($review_scores){
					//calculate course average
					$scores = count($review_scores);
					$total = 0;
					
					if($scores > 0){
						foreach($review_scores as $rev){
							$total += $rev['final_score'];
						}
						$avg = ($total/$scores);
					}
				}
			
				echo '<div class="text-center">
						<h3>Course Average</h3>
						<h2>'.round($avg).'</h2>
					  </div>';
			?>
	</div>
</div>