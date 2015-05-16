<div class="container">
	<div class="row animated fadeIn">
		<div class="col-md-12">
			<h3><?php echo $this->lang->line('classroom_teacher_classroom').': <a href="'.base_url().'courses/details/'.$course_arr['course_slug'].'">'.$course_arr['course_title'];?></a></h3>
		</div>

		<div class="col-md-6">
			<h3><?php echo $this->lang->line('classroom_teacher_course_students');?></h3>
			<?php
				//var_dump($review_scores);
				$count = 1;
				$show_link_next = 'false';
			
				foreach($students as $student)
				{
					echo '<a href="#">
							<div id="student_'.$student['user_id'].'" class="row class-room-module-item main-active-module">
								<div class="col-sm-9">
									'.$student['user_name'].' '.$student['user_lastname'].' ('.$student['user_username'].')
								</div>
					  		</div>
					  	  </a>';
				}	


				// foreach($modules_arr as $module)
				// {
				// 	echo '<a href="'.base_url('classroom/module/'.$module['id']).'">
				// 			<div id="module_'.$count.'" class="row class-room-module-item main-active-module">
				// 				<div class="col-sm-9">
				// 					'.$module['chapter'].'.'.$module['section'].' &nbsp; '.$module['title'].'
				// 				</div>
				// 	  		</div>
				// 	  	  </a>';
				// }	
			?>
		</div>
	</div>
</div>