<?php
get_header(); ?>
<?php
global $user_ID;
global $errorMessage;
global $current_user;
global $redux_demo;
$hasError = false;
$author = get_user_by( 'slug', get_query_var( 'author_name' ) ); 
$user_ID = $author->ID;
$user_info = get_userdata($user_ID);
$currentUser_ID = '';
$current_user = wp_get_current_user(); 
$currentUser_ID == $current_user->ID;
$contact_email = get_the_author_meta( 'user_email', $currentUser_ID );
$UserRegistered = $current_user->user_registered;
$dateFormat = get_option( 'date_format' );
$classifyRegDate = date_i18n($dateFormat,  strtotime($UserRegistered));
$caticoncolor="";
$category_icon_code ="";
$category_icon="";
$category_icon_color="";

//If the form is submitted
if(isset($_POST['submitted'])) {
	
		//Check to make sure that the name field is not empty
		if(trim($_POST['contactName']) === '') {
			$errorMessage = esc_html__('Please type your name...!');
			$hasError = true;
		}else{
			$name = trim($_POST['contactName']);
		}

		//Check to make sure that the subject field is not empty
		if(trim($_POST['subject']) === '') {
			$errorMessage = esc_html__('Please give subject..!');
			$hasError = true;
		}else{
			$subject = trim($_POST['subject']);
		}
		
		//Check to make sure sure that a valid email address is submitted
		if(trim($_POST['email']) === '')  {
			$errorMessage = esc_html__('Email is required..!', 'classify');
			$hasError = true;
		} else if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($_POST['email']))) {
			$errorMessage = esc_html__('Email is required..!');
			$hasError = true;
		} else {
			$email = trim($_POST['email']);
		}
			
		//Check to make sure comments were entered	
		if(trim($_POST['comments']) === '') {
			$errorMessage = esc_html__('Please type some word in message area..!');
			$hasError = true;
		} else {
			if(function_exists('stripslashes')) {
				$comments = stripslashes(trim($_POST['comments']));
			} else {
				$comments = trim($_POST['comments']);
			}
		}

		//Check to make sure that the human test field is not empty
		if(trim($_POST['humanTest']) != '8') {
			$errorMessage = esc_html__('Not Human');	
			$hasError = true;
		}			
		//If there is no error, send the email
		if($hasError == false){

			$emailTo = $contact_email;
			$subject = $subject;	
			$body = "Name: $name \n\nEmail: $email \n\nMessage: $comments";
			$headers = 'From <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;
			
			wp_mail($emailTo, $subject, $body, $headers);

			$emailSent = true;

		}
}
$classifyAuthorEmail = $user_info->user_email;
$classifyDisplayName = $user_info->display_name;
if(empty($classifyDisplayName)){
	$classifyDisplayName = $user_info->user_nicename;
}
if(empty($classifyDisplayName)){
	$classifyDisplayName = $user_info->user_login;
}
$classifyAuthorIMG = get_user_meta($user_ID, "classify_author_avatar_url", true);
if(empty($classifyAuthorIMG)){
	$classifyAuthorIMG = classify_get_avatar_url ($classieraAuthorEmail, $size = '150' );
}
?>
 <section id="page-head">
	<div class="container">
		<div class="row col-md-12">
			<div class="page-heading">
				<h1><?php echo $classifyDisplayName; ?></h1>
				<h4><?php echo $user_info->roles[0];?></h4>
			</div>
		</div>
	</div>
</section><!--end main page heading-->
<section id="detail">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<div class="profile-data">
					<div class="author-contact-detail">
						<div class="row">
							<div class="col-md-9 col-sm-9">
								<h4 class="inner-heading"><?php esc_html_e("ACCOUNT OVERVIEW", 'classify') ?></h4>
								<?php 
								$authorPhone = get_the_author_meta('phone', $user_ID);
								$authorMobile = get_the_author_meta('user_mobile', $user_ID);
								$authorAddress = get_the_author_meta('address', $user_ID);
								$authorCountry = get_the_author_meta('country', $user_ID);
								$authorState = get_the_author_meta('state', $user_ID);
								$authorCity = get_the_author_meta('city', $user_ID);
								$authorPostcode = get_the_author_meta('postcode', $user_ID);
								$authorWebsite = get_the_author_meta('user_url', $user_ID);
								$authorEmail = get_the_author_meta('user_email', $user_ID);
								?>
								<div class="author-profile-details">
									<ul>
										<!--User Phone-->
										<?php if($authorPhone):?>
										<li>
											<i class="fa fa-phone"></i>
											<?php esc_html_e("Phone") ?>: <?php echo $authorPhone; ?>
										</li>
										<?php endif;?>
										<!--User Phone-->
										<!--User Mobile-->
										<?php if($authorMobile):?>
										<li>
											<i class="fa fa-mobile"></i>
											<?php esc_html_e("Mobile") ?>: <?php echo $authorMobile; ?>
										</li>
										<?php endif;?>
										<!--User Mobile-->
										<!--User Country-->
										<?php if($authorCountry):?>
										<li>
											<i class="fa fa-map-marker"></i>
											<?php esc_html_e("Country") ?>: <?php echo $authorCountry; ?>
										</li>
										<?php endif;?>
										<!--User Country-->
										<!--User State-->
										<?php if($authorState):?>
										<li>
											<i class="fa fa-map-marker"></i>
											<?php esc_html_e("State") ?>: <?php echo $authorState; ?>
										</li>
										<?php endif;?>
										<!--User State-->
										<!--User City-->
										<?php if($authorCity):?>
										<li>
											<i class="fa fa-map-marker"></i>
											<?php esc_html_e("City") ?>: <?php echo $authorCity; ?>
										</li>
										<?php endif;?>
										<!--User City-->
										<!--User Post Code-->
										<?php if($authorPostcode):?>
										<li>
											<i class="fa fa-map-marker"></i>
											<?php esc_html_e("Post Code") ?>: <?php echo $authorPostcode; ?>
										</li>
										<?php endif;?>
										<!--User Post Code-->
										<!--User Address-->
										<?php if($authorAddress):?>
										<li>
											<i class="fa fa-map-marker"></i>
											<?php esc_html_e("Address") ?>: <?php echo $authorAddress; ?>
										</li>
										<?php endif;?>
										<!--User Address-->
										<?php if($authorWebsite):?>
										<!--User Website-->
										<li>
											<i class="fa fa-globe"></i>
											<?php esc_html_e("Website") ?>: <a href="<?php echo $authorWebsite; ?>" class="col">
												<?php echo $authorWebsite; ?>
											</a>
										</li>
										<?php endif;?>
										<!--User Website-->
										
										<!--User Email-->
										<?php if($authorEmail):?>
										<li>
											<i class="fa fa-envelope"></i>
											<?php esc_html_e("Email") ?>: 
											<a href="mailto:<?php echo $authorEmail; ?>" class="col">
												<?php echo $authorEmail; ?>
											</a>
										</li>
										<?php endif;?>
										<!--User Email-->
									</ul>
									<!--Social DETAILS-->
									<h4 class="inner-heading"><?php esc_html_e("SOCIAL DETAILS") ?></h4>
									<div class="classify_social_links">
										<?php 
										$authorFacebook = get_the_author_meta('facebook', $user_ID);
										$authorTwitter = get_the_author_meta('twitter', $user_ID);
										$authorGoogle = get_the_author_meta('googleplus', $user_ID);
										$authorLinkedin = get_the_author_meta('linkedin', $user_ID);
										$authorPinterest = get_the_author_meta('pinterest', $user_ID);
										$authorVimeno = get_the_author_meta('vimeo', $user_ID);
										$authorYoutube = get_the_author_meta('youtube', $user_ID);
										$instagram = get_the_author_meta('instagram', $user_ID);
										$behance = get_the_author_meta('behance', $user_ID);
										$dribbble = get_the_author_meta('dribbble', $user_ID);
										$vk = get_the_author_meta('vk', $user_ID);
										$skype = get_the_author_meta('skype', $user_ID);
										?>
										<!--User facebook-->
										<?php if($authorFacebook):?>
											<a class="classify_social" href="<?php echo $authorFacebook; ?>"><i class="fa fa-facebook"></i></a>
										<?php endif;?>
										<!--User facebook-->
										<!--User twitter-->
										<?php if($authorTwitter):?>
											<a class="classify_social" href="<?php echo $authorTwitter; ?>"><i class="fa fa-twitter"></i></a>
										<?php endif;?>
										<!--User twitter-->
										
										<!--User google-->
										<?php if($authorGoogle):?>
											<a class="classify_social" href="<?php echo $authorGoogle; ?>"><i class="fa fa-google"></i></a>
										<?php endif;?>
										<!--User google-->
										<!--User linkedin-->
										<?php if($authorLinkedin):?>
											<a class="classify_social" href="<?php echo $authorLinkedin; ?>"><i class="fa fa-linkedin"></i></a>
										<?php endif;?>
										<!--User linkedin-->
										
										<!--User pinterest-->
										<?php if($authorPinterest):?>
											<a class="classify_social" href="<?php echo $authorPinterest; ?>"><i class="fa fa-pinterest"></i></a>
										<?php endif;?>
										<!--User pinterest-->
										
										<!--User vimeo-->
										<?php if($authorVimeno):?>
											<a class="classify_social" href="<?php echo $authorVimeno; ?>"><i class="fa fa-vimeo"></i></a>
										<?php endif;?>
										<!--User vimeo-->
										
										<!--User pinterest-->
										<?php if($authorYoutube):?>
											<a class="classify_social" href="<?php echo $authorYoutube; ?>"><i class="fa fa-youtube"></i></a>
										<?php endif;?>
										<!--User pinterest-->
										<!--User instagram-->
										<?php if($instagram):?>
											<a class="classify_social" href="<?php echo $instagram; ?>"><i class="fa fa-instagram"></i></a>
										<?php endif;?>
										<!--User instagram-->
										<!--User behance-->
										<?php if($behance):?>
											<a class="classify_social" href="<?php echo $behance; ?>"><i class="fa fa-behance"></i></a>
										<?php endif;?>
										<!--User behance-->
										<!--User dribbble-->
										<?php if($dribbble):?>
											<a class="classify_social" href="<?php echo $dribbble; ?>"><i class="fa fa-dribbble"></i></a>
										<?php endif;?>
										<!--User dribbble-->
										<!--User skype-->
										<?php if($skype):?>
											<a class="classify_social" href="<?php echo $skype; ?>"><i class="fa fa-skype"></i></a>
										<?php endif;?>
										<!--User skype-->
										<!--User skype-->
										<?php if($vk):?>
											<a class="classify_social" href="<?php echo $vk; ?>"><i class="fa fa-vk"></i></a>
										<?php endif;?>
										<!--User skype-->
									</div>
									<!--Social DETAILS-->
								</div><!--author-profile-details-->
							</div><!--col-md-9-->
							<div class="col-md-3 col-sm-3">
								<div class="author-avatar-image">
									<img src="<?php echo $classifyAuthorIMG; ?>" alt="<?php echo $classifyDisplayName; ?>">
								</div>
								<div class="profile-author-name">
									<p><?php echo $classifyDisplayName; ?></p>
								</div>
							</div>
						</div><!--row-->
						<!--Description-->
						<h4 class="inner-heading"><?php esc_html_e("About") ?></h4>
						<?php $authorDesc = get_the_author_meta('description', $user_ID);?>
						<p><?php echo $authorDesc; ?></p>
						<!--Description-->
					</div><!--author-contact-detail-->
					<div class="author-related-ads">
						<section id="advertisement">
							<div class="container" data-width-offset="10">
								<h4 class="inner-heading"><?php esc_html_e("Ads") ?></h4>
								<div class="row">
									<div class="col-md-12 content content1">
										<div class="clearfix">
											<?php 
											global $paged, $wp_query, $wp;
											$args = wp_parse_args($wp->matched_query);
											if ( !empty ( $args['paged'] ) && 0 == $paged ){
												$wp_query->set('paged', $args['paged']);
												$paged = $args['paged'];
											}											
											$temp = $wp_query;
											$wp_query= null;
											$args = array(
												'post_type' => 'post',
												'posts_per_page' => 12,
												'paged' => $paged,
												'author' => $user_ID,
											);
											$wp_query = new WP_Query($args);							
											while($wp_query->have_posts()) : $wp_query->the_post();
												get_template_part('templates/single-loop-md4');
											endwhile;										
										?>
										</div>
									</div>
								</div><!--row-->
								<?php 
								if(function_exists('classify_pagination')){
									classify_pagination();
								}
								wp_reset_query();
								?>								
							</div>
						</section>
					</div><!--author-related-ads-->
					<!--Classify Google Ads-->
					<div class="advert">
						<a href="#"><img src="http://placehold.it/728x90" alt="ads"></a>
					</div>
					<!--Classify Google Ads-->
					<div class="author-contact">
						<h4 class="inner-heading"><?php esc_html_e("TO AUTHOR") ?></h4>
						<div class="row">
							<form method="post" data-toggle="validator">
								<!--Name-->
								<div class="col-sm-6 form-group">
									<input class="form-control" type="text" name="name" placeholder="<?php esc_html_e("Full name") ?>" required data-error="<?php esc_html_e("Please type your name.", 'classify') ?>">
									<div class="help-block with-errors"></div>
								</div>
								<!--Name-->
								<!--Email-->
								<div class="col-sm-6 form-group">
									<input class="form-control" type="email" name="email" placeholder="<?php esc_html_e("Email address") ?>" required data-error="<?php esc_html_e("Please type your email", 'classify') ?>">
									<div class="help-block with-errors"></div>
								</div>
								<!--Email-->
								<!--Subject-->
								<div class="col-sm-12 form-group">
									<input class="form-control" type="text" name="subject" placeholder="<?php esc_html_e("Subject") ?>" required data-error="<?php esc_html_e("please type subject", 'classify') ?>">
									<div class="help-block with-errors"></div>
								</div>
								<!--Subject-->
								<!--Message-->
								<div class="col-sm-12 form-group">
									<textarea required class="form-control"></textarea>
								</div>
								<!--Message-->
								<!--question-->
								<div class="col-sm-6">
									<?php 
										$classifyFirstNumber = rand(1,9);
										$classifyLastNumber = rand(1,9);
										$classifyNumberAnswer = $classifyFirstNumber + $classifyLastNumber;
									?>
									<p>
									<?php esc_html_e("Please input the result of ", "classify"); ?>
									<?php echo $classifyFirstNumber; ?> + <?php echo $classifyLastNumber;?> = 
									</p>
								</div>
								<!--question-->
								<!--question answer-->
								<div class="col-sm-6 form-group">
									<input class="form-control" type="text" name="answer" required>
								</div>
								<!--question answer-->
								<!--Submit Button-->
								<div class="col-sm-12">
									<input type="hidden" name="humanAnswer" id="humanAnswer" value="<?php echo $classifyNumberAnswer; ?>" />
									<input type="submit" name="send_message" value="<?php esc_html_e("Send Message") ?>">
								</div>
								<!--Submit Button-->
							</form>
						</div><!--row-->
					</div><!--author-contact-->
				</div><!--profile-data-->
			</div><!--col-md-8-->
			<div class="col-md-4 col-sm-6 col-res-centered">
				<div class="sidebar">
					<?php get_sidebar('pages'); ?>
				</div>
			</div><!--col-md-4-->
		</div><!--row-->
	</div><!--container-->
</section><!--detail-->
<?php get_footer(); ?>
