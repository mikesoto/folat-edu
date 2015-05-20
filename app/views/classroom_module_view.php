<div class="container">
	<div class="row animated fadeIn">
		<div class="col-md-5">
			    <h4><?php echo $this->lang->line('classroom_module_course');?>:</h4>
			    <h4><a href="<?php echo base_url('classroom/main/'.$course_arr['course_slug']);?>"><?php echo $course_arr['course_title'];?></a></h4>
		</div>
		<div class="col-md-5">
			    <h4><?php echo $this->lang->line('classroom_module_module');?>:</h4>
			    <h4><a href="#"><?php echo $module_arr['chapter'].'.'.$module_arr['section'].' &nbsp; '.$module_arr['title'];?></a></h4>
		</div>
		<div class="col-md-1 text-center">
			   	<h4>Reset</h4>
			   	<h4>
			   		<a href="#" onclick="repeatModule('<?php echo $module_arr["id"];?>');return false;" title="Reset Module">
			   			<i class="fa fa-refresh"></i>
					</a>
				</h4>
		</div>

		<div class="col-md-12 text-center">
			<?php if(!empty($slides_arr)):?>
				<div id="slide_controls" class="module_slide_controls">
					<a id="prev-slide-btn" href="#" onclick="showPrevSlide();return false;">
						<span class="glyphicon glyphicon-arrow-left previous_arrow"></span>
					</a>
					<a id="next-slide-btn" href="#" onclick="showNextSlide();return false;">
						<span class="glyphicon glyphicon-arrow-right next_arrow"></span>
					</a>
					<a id="start_review_btn" href="#" class="btn btn-primary" onclick="start_review();return false;"><?php echo $this->lang->line('classroom_module_startReview');?></a>
				</div>
			<?php endif;?>
		</div>

		<div id="slide_row_window" class="col-md-12 slide_row_container">
			<?php 
				$questions_arr = array(); //array to store all slide questons
				$slide_count = 1;
				if(!empty($slides_arr))
				{
					foreach($slides_arr as $slide){
					   echo '<div id="slide_'.$slide_count.'" class="module_text_slide animated fadeInRight">
								<h3>'.$slide['title'].'</h3>
								'.addLineBreaks($slide['body']).'
								<div class="clearfix"><h3>&nbsp;</h3></div>
								<div class="module_slide_references">
									'.$slide['refs'].'
								</div>
							</div>';
						//extract the slides questions
						foreach($slide['content_questions'] as $question)
						{
							array_push($questions_arr,$question);
						}
						$slide_count++;
					}
				}
				else
				{
					echo '<div class="col-md-12 text-center"><h3>'.$this->lang->line('classroom_module_noslides').'</h3></div>';
				}
				
			?>
		</div>


		<!---------------------- Module Review ------------------------------>
		<div id="module_review" class="row animated fadeIn">
			<div class="col-md-12 text-center">
				<h3><?php echo $this->lang->line('classroom_module_moduleReview');?></h3>
				<?php 
					$q_count = 1;
					$q_count_total = count($questions_arr);
					foreach($questions_arr as $question)
					{
					   $rand_answers = randAnswers($question);
					   echo '<div id="question_'.$q_count.'" class="classroom_review_question">
					   			('.$q_count.') <span class="question">'.$question['question'].'</span><br/><br/>';
					   			$a_count_total = count($rand_answers);
					   			$a_count = 1;
					   			foreach($rand_answers as $answer)
					   			{
					   				echo '<a id="answer_'.$q_count.'_'.$a_count.'" href="#" class="classroom_answer_option" onclick="check_answer('.$question['id'].','.$q_count.','.$q_count_total.','.$a_count.','.$a_count_total.', '.$question['slide_id'].', \''.addslashes(encodeQuot($answer)).'\',  \''.addslashes(encodeQuot($question['question'])).'\');return false;">
					   						 	'.$answer.'
					   					  </a>';
					   				$a_count++;
					   			}
					   echo '	
					   			<br class="clearfix">
					   			<div id="answer_check_'.$q_count.'" class="check_answer_results"></div>
					   		</div>
					   ';
					   $q_count++;
					}	
				?>


				<!---------------------- Modue Review Results ------------------------>
				<div id="review_results" class="row animated fadeInRight" style="display:none;">
					<!--content set dinamicaly-->
				</div>


				<div class="clearfix">&nbsp;</div>
			</div>
		</div>

		
	</div>
</div>

<!--==================================== MODAL FOR RATE COURSE ==================================-->
<div id="rate_course_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="rate_course_modal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
			    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        		<h4 class="modal-title"><?php echo $this->lang->line('classroom_module_howDoYouRate');?></h4>
      		</div>
      		<div class="modal-body">
				<div class="row">
					<div class="col-lg-12 text-center">
						<form id="rate_course_form" action="<?php echo base_url('verify_rate_course');?>" method="post">
							<table id="rate-course-table">
								<tbody>
									<tr>
										<th><label for="rate_1"><span id="lrate_1" class="glyphicon glyphicon-star"></span></label></th>
										<th><label for="rate_2"><span id="lrate_2" class="glyphicon glyphicon-star"></span></label></th>
										<th><label for="rate_3"><span id="lrate_3" class="glyphicon glyphicon-star"></span></label></th>
										<th><label for="rate_4"><span id="lrate_4" class="glyphicon glyphicon-star"></span></label></th>
										<th><label for="rate_5"><span id="lrate_5" class="glyphicon glyphicon-star"></span></label></th>
									</tr>
									<tr>
										<td><input id="rate_1" type="radio" name="rating" value="1" onchange="rateClick(this.id,1);"/></td>
										<td><input id="rate_2" type="radio" name="rating" value="2" onchange="rateClick(this.id,2);"/></td>
										<td><input id="rate_3" type="radio" name="rating" value="3" onchange="rateClick(this.id,3);"/></td>
										<td><input id="rate_4" type="radio" name="rating" value="4" onchange="rateClick(this.id,4);"/></td>
										<td><input id="rate_5" type="radio" name="rating" value="5" onchange="rateClick(this.id,5);"/></td>
									</tr>
								</tbody>
							</table>
							<div class="form-group">
								<label for="comment"><?php echo $this->lang->line('classroom_module_commentsRec');?></label><br/>
								<textarea id="comment" name="comment" cols="50" rows="4"></textarea>
							</div>
							<input type="hidden" name="course_id" value="<?php echo $course_arr['id'];?>"/>
							<input type="hidden" name="module_id" value="<?php echo $module_arr['id'];?>"/>
						</form>
					</div>	
				</div>
			</div>
      		<div class="modal-footer">
		    	<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('classroom_module_cancel');?></button>
		    	<button id="rate_course_btn" type="button" class="btn btn-primary" onclick="checkRateSubmit();return false;"><?php echo $this->lang->line('classroom_module_rateAndViewCert');?></button>
			</div>
		</div>
	</div>
</div>




<script>
	$(document).ready(function(){
		repeat_url = "";
		main_url = "";
		<?php
			if($has_review_score || $has_review_score == 0){
				echo 'has_review_score = '.$has_review_score[0]['final_score'].';';
				
				//if they failed this module before ask them if they want to clear and startover
				if($has_review_score[0]['final_score'] < 69)
				{
					echo "
					if(confirm('<?php echo $this->lang->line('classroom_module_failingGrade');?>'))
					{
						repeat_url = '".base_url("classroom/repeat_module/".$module_arr["id"])."';
						document.location = repeat_url;
					}
					else
					{
						main_url = '".base_url("classroom/main/".$course_arr["course_slug"])."';
						document.location = main_url;
					}";
				}
			}
			else
			{
				echo 'has_review_score = false;';
			}	
		?>
		if(repeat_url == "" && main_url == "")//if they have no score or a passing score than continue
		{
			<?php if(!empty($slides_arr)):?>
				//show the first slide
				$("#slide_1").css('display','block');
				current_slide = 1;
				total_slides = <?php echo count($slides_arr)?>;
				refreshArrows();
				sliding = false;
			<?php endif;?>
		}
		
	});

	function rateClick(radio,num){
		if($('input[id='+radio+']:checked').length > 0){
			//clear all colors
			for(i=1; i <= 5; i++)
			{
				$("#lrate_"+i).css('color','#ccc');
			}
			//set to gold up to this one
			for(i=1; i <= num; i++)
			{
				$("#lrate_"+i).css('color','#D6AF00');
			}
		}
	}

	function checkRateSubmit(){
		oneChecked = false;
		for(i=1; i <= 5; i++)
		{
			if( $('input[id=rate_'+i+']:checked').length > 0 )
			{
				oneChecked = true;
			}
		}
		if(oneChecked == false){
			alert("<?php echo $this->lang->line('classroom_module_pleaseGiveRating');?>");
		}
		else
		{
			$("#rate_course_form").submit();
		}
	}

	function refreshArrows(){
		//hide both arrows
		$("#prev-slide-btn").css('display','none');
		$("#next-slide-btn").css('display','none');
		if(total_slides > 1 && current_slide > 1)
		{
			//show prev arrow
			$("#prev-slide-btn").css('display','block');
		}
		if(total_slides > 1 && current_slide < total_slides)
		{
			//show next arrow
			$("#next-slide-btn").css('display','block');
		}
		//show review button if last slide
		if(total_slides == current_slide)
		{
			//show review button 
			$("#start_review_btn").css('display','block');
		}
		else
		{
			//hide review button 
			$("#start_review_btn").css('display','none');
		}
	}

	function showNextSlide(){
		//hide arrow durring slide change
		if(!sliding){
			sliding = true;
			//set return animation for the current slide
			$("#slide_"+current_slide).removeClass('fadeInRight');
			$("#slide_"+current_slide).addClass('fadeInLeft fadeOutLeft');
			//hide current slide
			setTimeout(function(){
				//remove fadeOutLeft class
				$("#slide_"+current_slide).removeClass('fadeOutLeft');
				//hide current slide
				$("#slide_"+current_slide).css('display','none');
				//show next slide
				$("#slide_"+(current_slide+1)).css('display','block');
				//increment current slide
				current_slide++;
				//show or hide arrows
				refreshArrows();
				sliding = false;
			},500);
		}
		
	}

	function showPrevSlide(){
		if(!sliding)
		{
			sliding = true;
			//set return animation for the current slide
			$("#slide_"+current_slide).removeClass('fadeInLeft');
			$("#slide_"+current_slide).addClass('fadeInRight fadeOutRight');
			//hide current slide
			setTimeout(function(){
				//remove fadeOutRight class
				$("#slide_"+current_slide).removeClass('fadeOutRight');
				//hide current slide
				$("#slide_"+current_slide).css('display','none');
				//show previous slide
				$("#slide_"+(current_slide-1)).css('display','block');
				//decriment current slide
				current_slide--;
				//show or hide arrows
				refreshArrows();
				sliding = false;
			},500);
		}
		
	}

	function start_review(){
		//hide last slide
		$("#slide_"+current_slide).addClass('fadeOutLeft');
		//hide slide controls
		$("#slide_controls").addClass('animated fadeOut');
		start_rev = false;
		if(has_review_score || has_review_score === 0)
		{
			if(confirm("<?php echo $this->lang->line('classroom_module_completedReview');?>"))
			{
				start_rev = true;
				<?php echo 'clear_url = "'.base_url("classroom/clear_module_review/").'"';?>
				
				//send ajax request to clear old review results dinamically
					$.ajax({
					    // The URL for the request
					    url: clear_url,
					    data: {
					    	module_id : <?php echo $module_arr['id'];?>
					    },
					    type: "POST",
					    // The type of data we expect back
					    dataType : "json",

					    // on complete action
					    complete: function( xhr, status ) {
					     	
					    },
					    // Code to run if the request succeeds; the response is passed to the function
					    success: function( json ) {
					  		if(json.review_cleared == "TRUE")
							{
								//alert('review results cleared!');
							}
					    },
					 
					    // Code to run if the request fails; the raw request and status codes are passed to the function
					    error: function( xhr, status, errorThrown ) {
					        alert( "Sorry, there was a problem!" );
					        console.log( "Error: " + errorThrown );
					        console.log( "Status: " + status );
					        console.dir( xhr );
					    }

					});
			}
			else
			{
				//send back to main classroom view
				<?php echo 'repeat_url = "'.base_url("classroom/main/".$course_arr["course_slug"]).'";';?>
				document.location = repeat_url;
			}
		}
		else
		{
			start_rev = true;
		}


		if(start_rev == true)
		{
			<?php
				echo 'rev_questions = '.count($questions_arr);
			?>

			setTimeout(function(){
				$("#slide_"+current_slide).css('display','none');
				$("#slide_controls").css('display','none');
				$("#slide_row_window").css('display','none');
				$("#module_review").css('display','block');
			},500);

			setTimeout(function(){
				if(rev_questions > 0)
				{
					$("#question_1").addClass('animated fadeInRight');
					$("#question_1").css('display', 'block');
				}
				else //there are no review questions to show
				{
					$("#module_review").append('<p><div class="col-md-12 text-center"><h4><?php echo $this->lang->line("classroom_module_noReviewQuestions");?></strong></h4></div></p>');	

					$("#module_review").append('<p><div class="col-md-12 text-center"><a class="btn btn-danger" href="#" onclick="repeatModule(\'<?php echo $module_arr["id"];?>\');return false;"><?php echo $this->lang->line("classroom_module_repeatModule");?></a></div></p>');

					//send ajax request
					$.ajax({
					    // The URL for the request
					    <?php $rev_url = base_url('classroom/generate_review_results/'.$module_arr['id'].'/'.$user_id);?>
					    url: "<?php echo $rev_url;?>",
					    data: {
					    	course_id : <?php echo $module_arr['course_id'];?>
					    },
					    type: "POST",
					    // The type of data we expect back
					    dataType : "json",

					    // on complete action
					    complete: function( xhr, status ) {
					     	
					    },
					    // Code to run if the request succeeds; the response is passed to the function
					    success: function( json ) {
					  		if(json.next_module.set == "TRUE")
							{
								$("#module_review").append('<p><div class="col-md-12 text-center"><a id="classrm-next-module-btn" class="btn btn-primary" href="<?php echo base_url("classroom/module");?>/'+json.next_module.module_id+'"><?php echo $this->lang->line('classroom_module_next');?>: '+json.next_module.chapter+'.'+json.next_module.section+' - '+json.next_module.module_title+'</a></div></p>');
							}
							else
							{
								$("#module_review").append('<h1>&nbsp;</h1><div class="row text-center"><h3><?php echo $this->lang->line("classroom_module_congratsEndOfCourse");?></h3></div>');
								$("#module_review").append('<h1>&nbsp;</h1><div class="row text-center"><a href="#" data-toggle="modal" data-target="#rate_course_modal" class="btn btn-primary"><?php echo $this->lang->line("classroom_module_rateToReceive");?></a></div>');
							}
					    },
					 
					    // Code to run if the request fails; the raw request and status codes are passed to the function
					    error: function( xhr, status, errorThrown ) {
					        alert( "Sorry, there was a problem!" );
					        console.log( "Error: " + errorThrown );
					        console.log( "Status: " + status );
					        console.dir( xhr );
					    }

					});
				}
			},800);
		}
		
	}

	function check_answer(q_id , q_count , q_count_total, a_count, a_count_total , slide_id, selected_answer, qstn){
		$("#answer_check_"+q_count).html('checking answer...');
		// Sending Ajax request
		$.ajax({
		    // The URL for the request
		    url: "<?php echo base_url('verify_check_answer');?>",
		    data: {
		    	course_id : <?php echo $module_arr['course_id'];?>,
		    	module_id : <?php echo $module_arr['id'];?>,
		    	slide_id : slide_id, 
		    	question_id : q_id,
		    	selected_answer : selected_answer,
		    	question : qstn
		    },
		    type: "POST",
		    // The type of data we expect back
		    dataType : "json",

		    // disable all options
		    complete: function( xhr, status ) {
		      for(i=1; i <= a_count_total; i++)
		        {
		        	$("#answer_"+q_count+"_"+i).attr('onclick','return false;');
		        	$("#answer_"+q_count+"_"+i).removeClass('classroom_answer_option');
		        	$("#answer_"+q_count+"_"+i).addClass('classroom_answer_disabled');
		        }
		    },
		    // Code to run if the request succeeds; the response is passed to the function
		    success: function( json ) {
		  	if(json.status == 'correct')
		    	{
		    		$("#answer_check_"+q_count).html('<?php echo $this->lang->line("classroom_module_thatIsCorrect");?><br/><a href="#" class="btn btn-primary pull-right" onclick="show_next_question('+q_count+','+q_count_total+');return false;">Next</a><br class="clearfix"/>');
		    		$("#answer_"+q_count+"_"+a_count).addClass('classroom_answer_correct');
		    	}
		    	else
		    	{
		    		$("#answer_check_"+q_count).html('<?php echo $this->lang->line("classroom_module_thatIsIncorrect");?> <strong>'+json.correct_answer+'</strong><br/><a href="#" class="btn btn-primary pull-right" onclick="show_next_question('+q_count+','+q_count_total+');return false;">Next</a><br class="clearfix"/>');
		    		$("#answer_"+q_count+"_"+a_count).addClass('classroom_answer_incorrect');
		    	}
		    },
		 
		    // Code to run if the request fails; the raw request and status codes are passed to the function
		    error: function( xhr, status, errorThrown ) {
		        alert( "Sorry, there was a problem!" );
		        console.log( "Error: " + errorThrown );
		        console.log( "Status: " + status );
		        console.dir( xhr );
		    }

		});
	}

	function show_next_question(q,q_total){
		$("#question_"+q).removeClass('fadeInRight');
		$("#question_"+q).addClass('fadeOutLeft');
		
		if(q < q_total)//there are more questions to show
		{
			setTimeout(function(){
				$("#question_"+q).css('display','none');
				$("#question_"+(q+1)).addClass('animated fadeInRight');
				$("#question_"+(q+1)).css('display','block');
			},500);
		}
		else //reached end of questions (show review)
		{
			//send ajax request
			$.ajax({
			    // The URL for the request
			    <?php $rev_url = base_url('classroom/generate_review_results/'.$module_arr['id'].'/'.$user_id);?>
			    url: "<?php echo $rev_url;?>",
			    data: {
			    	course_id : <?php echo $module_arr['course_id'];?>
			    },
			    type: "POST",
			    // The type of data we expect back
			    dataType : "json",

			    // on complete action
			    complete: function( xhr, status ) {
			     
			    },
			    // Code to run if the request succeeds; the response is passed to the function
			    success: function( json ) {
			  		//call function to show the review
			  		showReviewContent(json);
			    },
			 
			    // Code to run if the request fails; the raw request and status codes are passed to the function
			    error: function( xhr, status, errorThrown ) {
			        alert( "<?php echo $this->lang->line('classroom_module_problemGenRev');?>" );
			        console.log( "Error: " + errorThrown );
			        console.log( "Status: " + status );
			        console.dir( xhr );
			    }

			});

			//hide the last question
			setTimeout(function(){
				$("#question_"+q).css('display','none');
				//show the review results container
				$("#review_results").css('display','block');
			},500);
		}
	}

	function showReviewContent(json_res)
	{
		res_row_str = '';
		res_score = 0;
		res_score_str = '';
		row_val = (1/json_res.rows.length)*100;


	 	for(i=0; i < json_res.rows.length; i++){
			res_row_str +=  '<div class="row rev-res-row">';
			res_row_str += 	  	'<div class="col-md-1">';
			res_row_str +=		 	'<div class="rev-res-number">'+(i+1)+': </div> ';
			if(json_res.rows[i].is_correct == 1){
				res_row_str += 		'<span class="glyphicon glyphicon-ok rev-res-correct-mark"></span>';
				res_score += row_val;
			}
			else
			{
				res_row_str += 		'<span class="glyphicon glyphicon-remove rev-res-incorrect-mark"></span>';
			}
			res_row_str +=	  	'</div>';
			res_row_str += 	  	'<div class="col-md-4">';
			res_row_str +=	     	'<strong><?php echo $this->lang->line("classroom_module_question");?>:</strong> <br/>'+json_res.rows[i].question;
			res_row_str +=	  	'</div>';
			res_row_str += 	  	'<div class="col-md-3">';
			res_row_str +=	     	'<strong><?php echo $this->lang->line("classroom_module_selAnswer");?>:</strong> <br/>'+json_res.rows[i].selected_answer;
			res_row_str +=	  	'</div>';
			res_row_str +=	  	'<div class="col-md-4">';
			res_row_str +=	     	'<strong><?php echo $this->lang->line("classroom_module_correctAnswer");?>:</strong> <br/>'+json_res.rows[i].correct_answer;
			res_row_str +=	  	'</div>';
			res_row_str +=	'</div>';	
		}
			
		//add score result to top of review
		score_res_str = '<div class="row"><div class="rev-res-score col-md-6"><?php echo $this->lang->line("classroom_module_yourScore");?>: <strong>'+Math.round(res_score)+'</strong></div>';
		if(Math.round(res_score) > 69)
	 	{
	 		score_res_str += '<div class="col-md-6 rev-res-message"><?php echo $this->lang->line("classroom_module_provenComprehension");?></div>';
	 	}
	 	else
	 	{
	 		score_res_str += '<div class="col-md-6 rev-res-message"><?php echo $this->lang->line("classroom_module_notProvenComprehension");?></div>';
	 	}
	 	score_res_str +='</div>';//closes the rev-res-score row
		$("#review_results").html(score_res_str);

		$("#review_results").append(res_row_str);

		$("#review_results").append('<br/><br/><a class="btn btn-danger" href="#" onclick="repeatModule(\'<?php echo $module_arr["id"];?>\');return false;"><?php echo $this->lang->line("classroom_module_repeatModule");?></a>');

		if(Math.round(res_score) > 70)
		{
			if(json_res.next_module.set == "TRUE")
			{
				$("#review_results").append('<br/><br/><a id="classrm-next-module-btn" class="btn btn-primary" href="<?php echo base_url("classroom/module");?>/'+json_res.next_module.module_id+'"><?php echo $this->lang->line("classroom_module_next");?>: '+json_res.next_module.chapter+'.'+json_res.next_module.section+' - '+json_res.next_module.module_title+'</a>');
			}
			else
			{
				$("#review_results").append('<br/><br/><h3><?php echo $this->lang->line("classroom_module_congratsEndOfCourse");?></h3>');
				$("#review_results").append('<br/><a href="#" data-toggle="modal" data-target="#rate_course_modal" class="btn btn-primary"><?php echo $this->lang->line("classroom_module_rateToReceive");?></a>');
			}
		}
	}


	function repeatModule(module_id){
		if(confirm('<?php echo $this->lang->line("classroom_module_confirmClearResults");?>'))
		{
			<?php $repurl = base_url("classroom/repeat_module/".$module_arr['id']).'/'.$course_arr['id'];?>
			repeat_url = "<?php echo $repurl;?>";
			document.location = repeat_url;
		}
	}
	

</script>