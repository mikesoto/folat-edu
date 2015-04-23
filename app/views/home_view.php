<div class="row">
	<?php $this->load->view('templates/flash_messages');?>
 	<div class="container">
		<!--start Carousel-->
		<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
		  	<!-- Indicators -->
			<ol class="carousel-indicators">
			    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
			    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
			    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
			</ol>

			<!-- Wrapper for slides -->
			<div class="carousel-inner" role="listbox">
			    <div class="item active">
			      <img src="<?php echo base_url('images/slides/FOLAT-Slider-male-student.png');?>" alt="">
			      <div class="carousel-caption caption-dark">
			        <h1><?php echo $this->lang->line('home_slide1_title');?></h1>
			        <h3><?php echo $this->lang->line('home_slide1_caption');?></h3>
			      </div>
			    </div>
			    <div class="item">
			      <img src="<?php echo base_url('images/slides/FOLAT-Slider-female-student.png');?>" alt="">
			      <div class="carousel-caption">
			        <h1><?php echo $this->lang->line('home_slide2_title');?></h1>
			        <h3><?php echo $this->lang->line('home_slide2_caption');?></h3>
			      </div>
			    </div>
			    <div class="item">
			      <img src="<?php echo base_url('images/slides/FOLAT-Slider-clouds.png');?>" alt="">
			      <div class="carousel-caption">
			        <h1><?php echo $this->lang->line('home_slide3_title');?></h1>
			        <h3><?php echo $this->lang->line('home_slide3_caption');?></h3>
			      </div>
			    </div>
			</div>

		  <!-- Controls -->
		  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
		    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
		    <span class="sr-only">Previous</span>
		  </a>
		  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
		    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
		    <span class="sr-only">Next</span>
		  </a>
		</div>
		<!--end Carousel-->

		<div id="what-is-container" class="col-md-12 text-justify animated fadeInUp">
			<h2><?php echo $this->lang->line('home_title_WhatIs');?></h2>
			<?php echo $this->lang->line('home_text_WhatIs');?>
			
			<p class="text-center">
				<?php echo anchor(base_url('account/register'),$this->lang->line('home_btn_registerNow'), array('class' => 'btn btn-default btn-lg btn-regnow'));?>
			</p>
		</div>

	</div><!--end main container-->

	<div class="col-md-12 animated fadeInUp">
		<h2><?php echo $this->lang->line('home_title_FeaturedCourses');?></h2>
		<?php 
			$data = array(
				'courses_arr' => $courses_arr,
				'cl_page' => 'home_featured',
			);
			$this->load->view('templates/course_list.php',$data);
		?>
	</div>
</div>