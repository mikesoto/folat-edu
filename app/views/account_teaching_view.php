<div class="row">
  <?php if(!empty($account_alerts)):?>
	<div class="col-md-9 my-account-courses-listing">
  <?php else:?>
    <div class="col-md-12 my-account-courses-listing">
  <?php endif;?>
		<?php 
			//loads the submenu template for all account sections
			$data['selected'] = 'teaching'; 
			$this->load->view('templates/account_submenu',$data);
		?>

		<div class="animated fadeIn">
			<div class="row">
				<div class="col-lg-12">
					<p>&nbsp;</p>
			  		<h3><?php echo $this->lang->line('coursesTeaching_title_coursesImTeaching');?></h3>
				</div>
				<?php $this->load->view('templates/flash_messages');?>
			</div>
			<?php 
				if(empty($courses_teaching)){
					//show message if not taking any courses
					echo ' <div class="col-lg-12 text-center">
							  <h1>&nbsp;</h1>
							  <span class="btn btn-default btn-lg" disabled="disabled">
								'.$this->lang->line('coursesTeaching_msg_arentTeaching').'
							  </span>
							  <p><br/>
							  	<a href="'.base_url('courses/create').'">'.$this->lang->line('coursesTeaching_btn_createFirstCourse').'</a>
							  </p>
						   </div>';
				}
				else
				{
					$data = array(
					'courses_arr' => $courses_teaching,
					'cl_page' => 'account_teaching',
					);
					$this->load->view('templates/course_list.php',$data);
				}
			?>

		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="delete_confirm" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="delete_confirm"><?php echo $this->lang->line('coursesTeaching_title_confirmDelete');?></h4>
	      </div>
	      <div id="delete_confirm_modal_body" class="modal-body">
	        <!--set by JS-->
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('form_cancel');?></button>
	        <button id="delete_course_btn" type="button" class="btn btn-danger"><?php echo $this->lang->line('form_deleteCourse');?></button>
	      </div>
	    </div>
	  </div>
	</div>


	<!-- ACCOUNT ALERTS SIDEBAR-->
	<?php 
		//loads the account alerts sidebar if there are any alerts
		$data['account_alerts'] = $account_alerts; 
		$this->load->view('templates/account_alerts_sidebar',$data);
	?>
</div>

<script>
	function confirmDeleteSet(course_title,url)
	{
		$("#delete_confirm_modal_body").html('<?php echo $this->lang->line("coursesTeaching_msg_confirmDelete1");?><br/><strong>'+course_title+'</strong>?<br/><em><?php echo addslashes($this->lang->line("coursesTeaching_msg_confirmDelete2"));?></em>');
		$("#delete_course_btn").click(function(){
			document.location = url;
		});
	}
</script>