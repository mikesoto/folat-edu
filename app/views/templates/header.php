<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>FOLAT.edu | <?php echo $page_title;?></title>
		<link rel="shortcut icon" href="<?php echo base_url('favicon.ico');?>" type="image/x-icon">
		<link rel="icon" href="<?php echo base_url('favicon.ico');?>" type="image/x-icon">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
		<link href='http://fonts.googleapis.com/css?family=Francois+One' rel='stylesheet' type='text/css'>
		<link href="<?php echo base_url('css/animate.css');?>" rel="stylesheet" >
		
		<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
		<script>
				tinymce.init({
					height : 300,
    				force_br_newlines : false,
					force_p_newlines : false,
					forced_root_block : '',
					formats : {
			        underline : {inline : 'u', exact : true}
			        },
					content_css : "<?php echo base_url();?>/css/main.css", 
					mode : "specific_textareas",
			        editor_selector : "mceEditor",
			        editor_deselector : "mceNoEditor",
					plugins: [
			        "media advlist autolink lists link image charmap print preview anchor",
			        "searchreplace visualblocks code fullscreen",
			        "insertdatetime media table contextmenu paste"
			    	],
			    	toolbar: "undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image code"
				});
		</script>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>/scripts/folat.js"></script>
		<script src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js"></script>
		<script type="text/javascript">
			//apply prettyprint class to pre tags
			$(document).ready(function(){
				//adds the prettyprint class for code blocks
				$("pre").addClass('prettyprint linenums');
				//converts html breaks to line breaks in pre elements (for all linenumbs to show)
				$("pre").each(function(){
					contents = $(this).html()
					newcontents = contents.replace(/(<br>|<br\/>)/g,'\r\n');
					$(this).html(newcontents);
				});
				//start carousel if it exists
				if($('.carousel').length){
					$('.carousel').carousel({
					  interval: 5000
					});
				}


				//fix problem with propagation in tiny mce image inputs
				$(document).on('focusin', function(e) {
				    if ($(e.target).closest(".mce-window").length) {
				        e.stopImmediatePropagation();
				    }
				});
			})
		</script>
		<link href="<?php echo base_url('css/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet">
		<link href="<?php echo base_url('css/main.css');?>" rel="stylesheet">
	</head>
	<!--[if gte IE 9]>
	  <style type="text/css">
	    .gradient {
	       filter: none;
	    }
	  </style>
	<![endif]-->
	<body>
		<div class="container main-container">
			<nav role="navigation" class="navbar navbar-default">
		        <!-- Brand and toggle get grouped for better mobile display -->
		        <div class="navbar-header">
		            <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
		                <span class="sr-only">Toggle navigation</span>
		                <span class="icon-bar"></span>
		                <span class="icon-bar"></span>
		                <span class="icon-bar"></span>
		            </button>
		            <a href="<?php echo base_url();?>" class="navbar-brand">
		            	<img src="<?php echo base_url();?>/images/folat-hedge-hog-small.png" class="folat_header_logo_img">
		            	<span class="folat_logo_text_header">FOLAT</span>
		            </a>
		        </div>
		        <!-- Collection of nav links and other content for toggling -->
		        <div id="navbarCollapse" class="collapse navbar-collapse">
		            <ul class="nav navbar-nav">
		            	<li>
		            		<a href="<?php echo base_url();?>">
		            			<span class="glyphicon glyphicon-home"></span>
		            		</a>
		            	</li>
		                <li>
		                	<a href="<?php echo base_url('courses');?>">
		                		<?php echo $this->lang->line('mainNav_courses');?>
		                	</a>
		                </li>


		                <?php //==================NOT Logged In Menu ========================
		                if(!$this->session->userdata('logged_in')):?>
		                	<li>
		                		<a href="<?php echo base_url('account/login');?>">
		                			<?php echo $this->lang->line('mainNav_login');?>
		                		</a>
		                	</li>
		                	<li>
		                		<a href="<?php echo base_url('account/register');?>">
		                			<?php echo $this->lang->line('mainNav_register');?>
		                		</a>
		                	</li>
		                <?php endif;?>


		                <?php //==================Logged In Menu ========================
		                if($this->session->userdata('logged_in')):?>
		                	<li role="presentation" class="dropdown">
							    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
							        <?php echo $this->lang->line('mainNav_myAccount');?>
							       <span class="caret"></span>
							    </a>
							    <ul class="dropdown-menu" role="menu">
							       <li>
							         <a href="<?php echo base_url('account/profile');?>">
							         	<?php echo $this->lang->line('mainNav_myProfile');?>
							         </a>
							       </li>
							       <li>
							         <a href="<?php echo base_url('account/taking');?>">
							         	<?php echo $this->lang->line('mainNav_coursesTaking');?>
							         </a>
							       </li>
							       <li>
							       	 <a href="<?php echo base_url('account/teaching');?>">
							       	 	<?php echo $this->lang->line('mainNav_coursesTeaching');?>
							       	 </a>
							       </li>
							       <li>
							       	 <a href="<?php echo base_url('courses/create');?>">
							       	 	<?php echo $this->lang->line('mainNav_createNewCourse');?>
							       	 </a>
							       </li>
							    </ul>
							</li>
							<li>
								<a href="<?php echo base_url('account/logout');?>">
									<?php echo $this->lang->line('mainNav_logout');?>
								</a>
							</li>
						<?php endif;?>

						<li role="presentation" class="dropdown">
						    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
						        <?php echo $this->lang->line('mainNav_languages');?>
						       <span class="caret"></span>
						    </a>
						    <ul class="dropdown-menu" role="menu">
						       <li>
						       	 <a href="<?php echo base_url('?lang=english&refurl='.uri_string());?>">
						       	 	English
						       	 </a>
						       </li>
						       <li>
						       	 <a href="<?php echo base_url('?lang=spanish&refurl='.uri_string());?>">
						       	 	<?php echo 'Español';?>
						       	 </a>
						       </li>
						    </ul>
						</li>

		            </ul>

		            <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
						<input type="hidden" name="cmd" value="_s-xclick">
						<input type="hidden" name="hosted_button_id" value="ZEUQQ4UEE3HJS">
						<input id="paypal_donate_btn" type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
						<img alt="" border="0" src="https://www.paypalobjects.com/es_XC/i/scr/pixel.gif" width="1" height="1">
					</form>

	              <!--   <form role="search" class="navbar-form navbar-right">
			            <div class="form-group">
			                <input type="text" placeholder="<?php echo $this->lang->line('mainNav_search');?>" class="form-control">
			            </div>
			        </form> -->
		        </div>
		    </nav>