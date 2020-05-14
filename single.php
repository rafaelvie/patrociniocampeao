<?php
get_header(); ?>
	
	<?php while ( have_posts() ) : the_post(); ?>


<?php 

global $redux_demo; 
global $current_user; wp_get_current_user(); $user_ID == $current_user->ID;

$profileLink = get_the_author_meta( 'user_url', $user_ID );
$contact_email = get_the_author_meta('user_email');
$classifyGoogleMAP = $redux_demo['classify-google-map-adpost'];
$classifyToAuthor = $redux_demo['author-msg-box-off'];
$locShownBy = $redux_demo['classify_location_shown_by'];
$classifyMAPStyle = $redux_demo['map-style'];
$classify_comments_area = $redux_demo['classify_comments_area'];
$category_icon_code = "";
$category_icon_color = "";
$your_image_url = "";
$hasError = false;
$emailSent = false;
$errorMessage = "";

//If the form is submitted
if(isset($_POST['submit'])) {		
	//Check to make sure that the name field is not empty
	if(trim($_POST['contactName']) === ''){
		$errorMessage = esc_html__('Please type your name...!', 'classify');
		$hasError = true;
	}else{
		$name = trim($_POST['contactName']);
	}

	//Check to make sure that the subject field is not empty
	if(trim($_POST['subject']) === ''){
		$errorMessage = esc_html__('Please give subject..!', 'classify');
		$hasError = true;
	}else{
		$subject = trim($_POST['subject']);
	}
	
	//Check to make sure sure that a valid email address is submitted
	if(trim($_POST['email']) === ''){
		$errorMessage = esc_html__('Email is required..!', 'classify');
		$hasError = true;		
	}else{
		$email = trim($_POST['email']);
	}			
	//Check to make sure comments were entered	
	if(trim($_POST['comments']) === '') {
		$errorMessage = esc_html__('Please type some word in message area..!', 'classify');
		$hasError = true;
	}else{
		if(function_exists('stripslashes')){
			$comments = stripslashes(trim($_POST['comments']));
		}else{
			$comments = trim($_POST['comments']);
		}
	}

	//Check to make sure that the human test field is not empty
	$classieraCheckAnswer = $_POST['humanAnswer'];
	if(trim($_POST['humanTest']) != $classieraCheckAnswer) {
		$errorMessage = esc_html__('Not Human', 'classify');			
		$hasError = true;
	}
	$classifyPostTitle = $_POST['classify_post_title'];	
	$classifyPostURL = $_POST['classify_post_url'];
	
	//If there is no error, send the email		
	if($hasError == false){
		$emailTo = $contact_email;
		$subject = $subject;
		$headers = 'From <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;		
		contactToAuthor($emailTo, $subject, $name, $email, $comments, $headers, $classifyPostTitle, $classifyPostURL);
		$emailSent = true;	

	}
	
}
if(isset($_POST['favorite'])){
	$author_id = $_POST['author_id'];
	$post_id = $_POST['post_id'];
	echo classify_favorite_insert($author_id, $post_id);
}
if(isset($_POST['follower'])){	
	$author_id = $_POST['author_id'];
	$follower_id = $_POST['follower_id'];
	echo classify_authors_insert($author_id, $follower_id);
}
if(isset($_POST['unfollow'])){
	$author_id = $_POST['author_id'];
	$follower_id = $_POST['follower_id'];
	echo classify_authors_unfollow($author_id, $follower_id);
}

?>
<?php
$edit_post_page_id = $redux_demo['edit_post'];
$postID = $post->ID;
global $wp_rewrite;
global $redux_demo;
if ($wp_rewrite->permalink_structure == ''){
	$edit_post = $edit_post_page_id."&post=".$postID;
}else{
	$edit_post = $edit_post_page_id."?post=".$postID;
}
$post_price = get_post_meta($post->ID, 'post_price', true);
$post_video = get_post_meta($post->ID, 'post_video', true);
$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
if(!empty($post_currency_tag)){
	$classifyCurrencyTag = classify_Display_currency_sign($post_currency_tag);
}else{
	$classifyCurrencyTag = $redux_demo['classify_post_currency'];
}
$classifyCatStyle = $redux_demo['classify_cat_icon_img']; 
?>
<section id="page-head">
	<div class="container">
		<div class="row col-md-12">
			<div class="page-heading">
				<h1><?php the_title(); ?></h1>
				<h4>
				<?php 
				if(is_numeric($post_price)){
					echo $classifyCurrencyTag.$post_price;
				}else{
					echo $post_price;
				}
				?>
				</h4>
				<?php if ( get_post_status ( $post->ID ) == 'private' ) {?>
					<div class="alert alert-info" role="alert">
					  <p>
					  <strong><?php esc_html_e('Congratulation!', 'classify') ?></strong> <?php esc_html_e('Your Ad has submitted and pending for review. After review your Ad will be live for all users. You may not preview it more than once.!', 'classify') ?>
					  </p>
					</div>
				<?php } ?>
				<?php if($post->post_author == $current_user->ID && get_post_status ( $post->ID ) == 'publish'){?>
					<a href="<?php echo $edit_post; ?>" class="edit-post btn btn-sm btn-default">
						<i class="fa fa-pencil-square-o"></i>
						<?php esc_html_e( 'Edit Post', 'classify' ); ?>
					</a>
				<?php }elseif( current_user_can('administrator')){?>
					<a href="<?php echo $edit_post; ?>" class="edit-post btn btn-sm btn-default">
						<i class="fa fa-pencil-square-o"></i>
						<?php esc_html_e( 'Edit Post', 'classify' ); ?>
					</a>
				<?php } ?>
			</div>
		</div>
	</div>
</section><!--end main page heading-->
<section id="detail">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<div class="advs-detail">
					<!--Ads Video-->
					<?php 
					$post_video = get_post_meta($post->ID, 'post_video', true);
					if(!empty($post_video)){
						if(preg_match("/youtu.be\/[a-z1-9.-_]+/", $post_video)) {
							preg_match("/youtu.be\/([a-z1-9.-_]+)/", $post_video, $matches);
							if(isset($matches[1])) {
								$url = 'https://www.youtube.com/embed/'.$matches[1];
								$video = '<iframe class="embed-responsive-item" src="'.$url.'" frameborder="0" allowfullscreen></iframe>';
							}
						}elseif(preg_match("/youtube.com(.+)v=([^&]+)/", $post_video)) {
							preg_match("/v=([^&]+)/", $post_video, $matches);
							if(isset($matches[1])) {
								$url = 'https://www.youtube.com/embed/'.$matches[1];
								$video = '<iframe class="embed-responsive-item" src="'.$url.'" frameborder="0" allowfullscreen></iframe>';
							}
						}elseif(preg_match("#https?://(?:www\.)?vimeo\.com/(\w*/)*(([a-z]{0,2}-)?\d+)#", $post_video)) {
							preg_match("/vimeo.com\/([1-9.-_]+)/", $post_video, $matches);
							//print_r($matches); exit();
							if(isset($matches[1])) {
								$url = 'https://player.vimeo.com/video/'.$matches[1];
								$video = '<iframe class="embed-responsive-item" src="'.$url.'" frameborder="0" allowfullscreen webkitallowfullscreen mozallowfullscreen></iframe>';
							}
						}else{
							$video = $post_video;
						}
					?>
					<div class="row">
						<div class="col-md-12 col-xs-12 col-sm-12 classify_adv_video">	
							<div class="alert alert-info" role="alert">
								<i class="fa fa-youtube-play fa_mright"></i>
								<strong><?php _e( 'Video', 'classify' ); ?></strong>
							</div>
							<div class="embed-responsive embed-responsive-16by9">
								<?php echo $video; ?>
							</div>
						</div>
					</div>
					<?php } ?>
					<!--Ads Video-->
					<div class="row">
						<div class="col-md-12 col-xs-12 col-sm-12">
							<div class="adv-slider">
								<div id="myCarousel" class="carousel slide" data-interval="3000" data-ride="carousel">
									<?php 
									$attachments = get_children(array('post_parent' => $post->ID,
										'post_status' => 'inherit',
										'post_type' => 'attachment',
										'post_mime_type' => 'image',
										'order' => 'ASC',
										'orderby' => 'menu_order ID'
										)
									);
									if ( has_post_thumbnail() || !empty($attachments)){
									?>
										<ol class="carousel-indicators">
											<?php $count = 0;?>
											<?php foreach($attachments as $att_id => $attachment){?>
											<li data-target="#myCarousel" data-slide-to="<?php echo $count; ?>" class="active">
											</li>
											<?php $count++;?>
											<?php }?>
										</ol>
										<div class="carousel-inner">
											<?php $count = 1;?>
											<?php foreach($attachments as $att_id => $attachment){?>
											<?php $full_img_url = wp_get_attachment_url($attachment->ID);?>
											<div class="item <?php if($count == 1){echo "active";} ?>">
												<img class="img-responsive" src="<?php echo $full_img_url; ?>" alt="<?php the_title(); ?>">
											</div>
											<?php $count++;?>
											<?php }?>
										</div><!--carousel-inner-->
										<!-- Carousel nav -->
										<?php if(is_rtl()){ ?>
											<a class="carousel-control left" href="#myCarousel" data-slide="prev">
												<i class="fa fa-angle-right"></i>
											</a>
											<a class="carousel-control right" href="#myCarousel" data-slide="next">
												<i class="fa fa-angle-left"></i>
											</a>
										<?php }else{?>
											<a class="carousel-control left" href="#myCarousel" data-slide="prev">
												<i class="fa fa-angle-left"></i>
											</a>
											<a class="carousel-control right" href="#myCarousel" data-slide="next">
												<i class="fa fa-angle-right"></i>
											</a>
											<?php } ?>
									<?php }?>
								</div><!--myCarousel-->
							</div><!--adv-slider-->
						</div><!--col-md-12-->
					</div><!--row-->
					<!--author details-->
					<div class="author-detail">
						<?php 
						$user_ID = $post->post_author;
						$authorName = get_the_author_meta('display_name', $user_ID );
						if(empty($authorName)){
							$authorName = get_the_author_meta('user_nicename', $user_ID );
						}
						if(empty($authorName)){
							$authorName = get_the_author_meta('user_login', $user_ID );
						}
						$author_avatar_url = get_user_meta($user_ID, "classify_author_avatar_url", true);
						$authorEmail = get_the_author_meta('user_email', $user_ID);
						$authorURL = get_the_author_meta('user_url', $user_ID);
						$authorAddress = get_the_author_meta('address', $user_ID);
						$authorPhone = get_the_author_meta('phone', $user_ID);
						if(empty($author_avatar_url)){										
							$author_avatar_url = classify_get_avatar_url ($authorEmail, $size = '150' );
						} 
						?>
						<div class="row">
							<div class="col-sm-3">
								<div class="author-avatar">
									<img src="<?php echo $author_avatar_url;?>" alt="<?php echo $authorName;?>">
								</div><!--author-avatar-->
								<div class="author-name">
									<p><?php echo $authorName;?></p>
								</div><!--author-name-->
							</div><!--col-sm-3-->
							<div class="col-sm-9">
								<div class="author-detail-right">
									<?php if(!empty($authorAddress)){?>
									<div class="author-info">
										<i class="fa fa-map-marker"></i>
										<p><?php echo $authorAddress; ?></p>
									</div>
									<?php } ?>
									<!--Author Phone-->
									<?php if(!empty($authorPhone)){?>
									<div class="author-info">
										<i class="fa fa-phone"></i>
										<p><?php echo $authorPhone; ?></p>
									</div>
									<?php } ?>
									
									<!--Author Website-->
									<?php if(!empty($authorURL)){?>
									<div class="author-info">
										<i class="fa fa-globe"></i>
										<p><?php esc_html_e( 'Website :', 'classify' ); ?>
											<a class="col" href="<?php echo $authorURL; ?>">
												<?php echo $authorURL; ?>
											</a>
										</p>
									</div>
									<?php } ?>
									<!--follow-btn-->
									<div class="follow-btn">
										<?php 
										$current_user = wp_get_current_user();
										$currentUserID = $current_user->ID;
										if ( is_user_logged_in() ) {
											if($user_ID != $currentUserID){							
											echo classify_authors_follower_check($user_ID, $currentUserID);
										}} ?>
										<?php echo classify_authors_favorite_check($currentUserID,$post->ID); ?>
									</div>
									<!--follow-btn-->
								</div>
							</div><!--col-sm-9-->
						</div><!--row-->
					</div>
					<!--author details-->
					<!--Adv details-->
					<div class="adv-detail">
						<?php 
						$post_location = get_post_meta($post->ID, 'post_location', true);
						$post_state = get_post_meta($post->ID, 'post_state', true);
						$post_city = get_post_meta($post->ID, 'post_city', true);
						$post_address = get_post_meta($post->ID, 'post_address', true);
						
						$classify_ads_type = get_post_meta($post->ID, 'classify_ads_type', true);
						$classify_ads_type = classify_ads_type_display($classify_ads_type);
						$classify_ad_condition = get_post_meta($post->ID, 'classify_ad_condition', true);
						$classify_post_phone = get_post_meta($post->ID, 'classify_post_phone', true);
						
						$classifyCustomFields = get_post_meta($post->ID, 'custom_field', true);
						$category = get_the_category();
						if ($category[0]->category_parent == 0) {
							$tag = $category[0]->cat_ID;
							$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
							if (isset($tag_extra_fields[$tag])) {
								$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
								$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
								$classifyCatIcoIMG = $tag_extra_fields[$tag]['your_image_url'];
							}
						}elseif(isset($category[1]->category_parent) && $category[1]->category_parent == 0){
							$tag = $category[0]->category_parent;
							$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
							if (isset($tag_extra_fields[$tag])) {
								$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
								$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
								$classifyCatIcoIMG = $tag_extra_fields[$tag]['your_image_url'];
							}
						}else{
							$tag = $category[0]->category_parent;
							$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
							if (isset($tag_extra_fields[$tag])) {
								$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
								$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
								$classifyCatIcoIMG = $tag_extra_fields[$tag]['your_image_url'];
							}
						}
						$category_icon = stripslashes($category_icon_code);
						?>
						<div class="adv-detail-head">
							<?php if($classifyCatStyle == 'img'){?>
								<img class="classify__imgsingleIcon" src="<?php echo $classifyCatIcoIMG; ?>" alt="<?php echo  $category[0]->name; ?>">
							<?php }else{?>
								<i class="<?php echo $category_icon; ?> fa-2x" style="background-color:<?php echo $category_icon_color;?>;"></i>
							<?php } ?>
							<h4 class="adv-cat">
							<?php echo  $category[0]->name; ?>
							</h4>
						</div>
						<div class="adv-detail-info clearfix">
							<p class="pull-left"><?php esc_html_e( 'Added', 'classify' ); ?></p>
							<p class="pull-right light"><?php the_time('M j, Y') ?></p>
						</div><!--adv-detail-info-->
						<?php if($classify_ads_type){?>
						<div class="adv-detail-info clearfix">
							<p class="pull-left"><?php esc_html_e( 'Type', 'classify' ); ?></p>
							<p class="pull-right light"><?php echo $classify_ads_type;?></p>
						</div><!--classify_ads_type-->
						<?php } ?>
						<?php if($classify_ad_condition){?>
						<div class="adv-detail-info clearfix">
							<p class="pull-left"><?php esc_html_e( 'Condition', 'classify' ); ?></p>
							<p class="pull-right light"><?php echo $classify_ad_condition; ?></p>
						</div><!--classify_ad_condition-->
						<?php } ?>
						<div class="adv-detail-info clearfix">
							<p class="pull-left"><?php esc_html_e( 'Views', 'classify' ); ?></p>
							<p class="pull-right light"><?php echo classify_get_post_views(get_the_ID()); ?></p>
						</div><!--adv-detail-info-->
						<?php if($post_location){?>
						<div class="adv-detail-info clearfix">
							<p class="pull-left"><?php esc_html_e( 'Country', 'classify' ); ?></p>
							<p class="pull-right light"><?php echo $post_location; ?></p>
						</div><!--Country-->
						<?php } ?>
						<?php if($post_state){?>
						<div class="adv-detail-info clearfix">
							<p class="pull-left"><?php esc_html_e( 'States', 'classify' ); ?></p>
							<p class="pull-right light"><?php echo $post_state; ?></p>
						</div><!--States-->
						<?php } ?>
						<?php if($post_city){?>
						<div class="adv-detail-info clearfix">
							<p class="pull-left"><?php esc_html_e( 'City', 'classify' ); ?></p>
							<p class="pull-right light"><?php echo $post_city; ?></p>
						</div><!--City-->
						<?php } ?>
						
						<?php if($classify_post_phone){?>
						<div class="adv-detail-info clearfix">
							<p class="pull-left"><?php esc_html_e( 'Contact No', 'classify' ); ?></p>
							<p class="pull-right light"><?php echo $classify_post_phone; ?></p>
						</div><!--Contact No-->
						<?php } ?>
						<!--Custom Fields-->
						<?php 
						if(!empty($classifyCustomFields)) {
							for ($i = 0; $i < count($classifyCustomFields); $i++){
								if($classifyCustomFields[$i][2] != 'dropdown' && $classifyCustomFields[$i][2] != 'checkbox'){
									if(!empty($classifyCustomFields[$i][1]) && !empty($classifyCustomFields[$i][0]) ) {
									?>
									<div class="adv-detail-info clearfix">
										<p class="pull-left"><?php echo $classifyCustomFields[$i][0]; ?>:</p>
										<p class="pull-right light"><?php echo $classifyCustomFields[$i][1]; ?></p>
									</div>
									<?php
									}
								}
							}
							for ($i = 0; $i < count($classifyCustomFields); $i++){
								if($classifyCustomFields[$i][2] == 'dropdown'){
									if(!empty($classifyCustomFields[$i][1]) && !empty($classifyCustomFields[$i][0]) ){
									?>
									<div class="adv-detail-info clearfix">
										<p class="pull-left"><?php echo $classifyCustomFields[$i][0]; ?>:</p>
										<p class="pull-right light"><?php echo $classifyCustomFields[$i][1]; ?></p>
									</div>
									<?php
									}
								}
							}
							for ($i = 0; $i < count($classifyCustomFields); $i++){
								if($classifyCustomFields[$i][2] == 'checkbox'){
									if(!empty($classifyCustomFields[$i][1]) && !empty($classifyCustomFields[$i][0]) ){
									?>
									<div class="adv-detail-info clearfix">
										<p class="pull-left"><?php echo $classifyCustomFields[$i][0]; ?>:</p>
										<p class="pull-right light"><i class="fa fa-check-square" aria-hidden="true"></i></p>
									</div>
									<?php	
									}
								}
							}
						}
						?>
						<!--Custom Fields-->
						<?php if(function_exists('the_ratings')) { ?>
						<div class="adv-detail-info clearfix">
							<p class="pull-left"><?php esc_html_e( 'Ratings', 'classify' ); ?>:</p>
							<p class="pull-right light">
							<?php the_ratings(); ?>
							</p>
						</div><!--Rating-->
						<?php } ?>
						<div class="adv-detail-info clearfix">
							<p><?php esc_html_e( 'Description', 'classify' ); ?>:</p>
							<p class="light line"><?php echo the_content(); ?></p>
						</div><!--Description-->
						<div class="tags">
							<i class="fa fa-tags"></i>
							<span><?php esc_html_e( 'Tags', 'classify' ); ?>:</span>
							<?php the_tags('','',''); ?>
						</div><!--tags-->
					</div>
					<!--Adv details-->
				</div><!--advs-detail-->
				<!--post_address-->
				<?php if(!empty($post_address)){?>
				<div class="alert alert-info" role="alert">
					<i class="fa fa-map-marker fa_mright"></i>
					<?php echo $post_address; ?>
				</div>
				<?php } ?>
				<!--post_address-->
				<!--Classify MAP-->
				<?php 				
				$post_latitude = get_post_meta($post->ID, 'post_latitude', true);
				//echo $post_latitude."shabir";
				$post_longitude = get_post_meta($post->ID, 'post_longitude', true);
				$post_address = get_post_meta($post->ID, 'post_address', true);
				if(!empty($post_latitude)) {
					if(has_post_thumbnail()){
						$classifyIMG = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
						$classifyIMGURL = $classifyIMG[0];
					}else{
						$classifyIMGURL = get_template_directory_uri() . '/images/nothumb.png';
					}
					if(!empty($classifyCatIcoIMG)) {
						$iconPath = $classifyCatIcoIMG;
					} else {
						$iconPath = get_template_directory_uri() .'/images/icon-services.png';
					}
				if($classifyGoogleMAP == 1){	
				?>
				<div class="classify_single_map">
					<div class="details_adv_map" id="details_adv_map">					
						<script type="text/javascript">
						jQuery(document).ready(function(){
							var addressPoints = [							
								<?php 
								$content = '<div class="classify_adv_box classify_map_box_home"><div class="classify_adv_box_img"><img src="'.$classifyIMGURL.'" alt="'.get_the_title().'"><a href="'.get_the_permalink().'" class="classify_adv_hover"><span>'.$post_price.'</span><i class="'.$category_icon.' fa-2x" style="background-color:'.$category_icon_color.';"></i></a><p class="classify_adv_box_title"><a href="'.get_the_permalink().'">'.get_the_title().'</a></p><span class="classify-buy-sel">'.$classify_ads_type.'</span><div class="close_map_box"><i class="fa fa-times"></i></div></div></div>';
								?>
								[<?php echo $post_latitude; ?>, <?php echo $post_longitude; ?>, '<?php echo $content; ?>', "<?php echo $iconPath; ?>"],							
							];
							var mapopts;
							if(window.matchMedia("(max-width: 1024px)").matches){
								var mapopts =  {
									dragging:false,
									tap:false,
								};
							};
							var map = L.map('details_adv_map', mapopts).setView([<?php echo $post_latitude; ?>,<?php echo $post_longitude; ?>],10);
							map.scrollWheelZoom.disable();
							var roadMutant = L.gridLayer.googleMutant({
							<?php if($classifyMAPStyle){?>styles: <?php echo $classifyMAPStyle; ?>,<?php }?>
								maxZoom: 16,
								type:'roadmap'
							}).addTo(map);
							var markers = L.markerClusterGroup({
								spiderfyOnMaxZoom: true,
								showCoverageOnHover: true,
								zoomToBoundsOnClick: true,
								maxClusterRadius: 60
							});
							var markerArray = [];
							for (var i = 0; i < addressPoints.length; i++){
								var a = addressPoints[i];
								var newicon = new L.Icon({iconUrl: a[3],
									iconSize: [50, 50], // size of the icon
									iconAnchor: [20, 10], // point of the icon which will correspond to marker's location
									popupAnchor: [0, 0] // point from which the popup should open relative to the iconAnchor                                 
								});
								var title = a[2];
								var marker = L.marker(new L.LatLng(a[0], a[1]));
								marker.setIcon(newicon);
								marker.bindPopup(title);
								marker.title = title;
								marker.on('click', function(e) {
									map.setView(e.latlng, 13);
									
								});				
								markers.addLayer(marker);
								markerArray.push(marker);
								if(i==addressPoints.length-1){//this is the case when all the markers would be added to array
									var group = L.featureGroup(markerArray); //add markers array to featureGroup
									map.fitBounds(group.getBounds());   
								}
							}
							map.addLayer(markers);
						});
						</script>
					</div>
				</div>
				<?php } ?>
				<?php } ?>
				<!--Classify MAP-->
				<!--advertisement-->
				<?php 
					$postAdImg= $redux_demo['post_ad']['url']; 
					$postAdImglink= $redux_demo['post_ad_link'];
					$postAdCode = $redux_demo['post_ad_code_client']; 
					
					if(!empty($postAdCode) || !empty($postAdImg)){
						if(!empty($postAdCode)){
							$classifySingleAdv = $postAdCode;
						}else{
							$classifySingleAdv = '<a href="'.$postAdImglink.'" target="_blank"><img class="img-responsive" alt="image" src="'.$postAdImg.'" /></a>';
						}
					}					
				?>
				<?php if(!empty($classifySingleAdv)){?>
				<div class="advert">
					<?php echo $classifySingleAdv; ?>
				</div>
				<?php } ?>
				<!--advertisement-->
				<!--Related Ads-->
				<?php 
				function related_Post_ID(){
					global $post;
					$post_Id = $post->ID;
					return $post_Id;
				}
				?>
				<?php get_template_part( 'templates/classify-related-ads' );?>
				<!--Related Ads-->
				<!--Contact to author-->
				<?php if($classifyToAuthor == 1){?>
				<div id="form">	
					<?php 
					if(isset($_POST)){
						if($hasError == true){
							?>
							<div class="alert alert-warning">
								<strong><?php esc_html_e('Warning!', 'classify'); ?></strong>
								<?php echo $errorMessage; ?>
							</div>
							<?php
						}
						if($emailSent == true){
							?>
							<div class="alert alert-success">
							  <strong><?php esc_html_e('Congratulation!', 'classify'); ?></strong>
							  <?php esc_html_e( 'Your message sent to Ad author.', 'classify' ); ?>
							</div>
							<?php
						}
					}
					?>
					<h4 class="inner-heading"><?php esc_html_e( 'TO AUTHOR', 'classify' ); ?></h4>
					<form method="post" data-toggle="validator" class="row">
						<!--Name-->
						<div class="col-sm-6 form-group">
							<span class="fa fa-user form-control-feedback"></span>
							<input class="form-control" type="text" name="contactName" placeholder="<?php esc_html_e( 'Your name', 'classify' ); ?>" data-error="<?php esc_html_e( 'Please type your name', 'classify' ); ?>" required>
							<div class="help-block with-errors"></div>
						</div>
						<!--Name-->
						<!--Email-->
						<div class="col-sm-6 form-group">
							<span class="fa fa-envelope form-control-feedback"></span>
							<input class="form-control" type="email" name="email" placeholder="<?php esc_html_e( 'Your email', 'classify' ); ?>" data-error="<?php esc_html_e( 'Please type your email', 'classify' ); ?>" required>
							<div class="help-block with-errors"></div>
						</div>
						<!--Email-->
						<!--Subject-->
						<div class="col-sm-12 form-group">
							<span class="fa fa-book form-control-feedback"></span>
							<input class="form-control" type="text" name="subject" placeholder="<?php esc_html_e( 'Subject', 'classify' ); ?>" data-error="<?php esc_html_e( 'please give your subject', 'classify' ); ?>" required>
							<div class="help-block with-errors"></div>
						</div>
						<!--Subject-->
						<!--Description-->
						<div class="col-sm-12 form-group">
							<textarea class="form-control" name="comments" placeholder="<?php esc_html_e('Type message here...!', 'classify') ?>" required data-error="<?php esc_html_e( 'please give some description', 'classify' ); ?>"></textarea>
							<div class="help-block with-errors"></div>
						</div>
						<!--Description-->
						<!--humanAnswer-->
						<?php 
							$classifyFirstNumber = rand(1,9);
							$classifyLastNumber = rand(1,9);
							$classifyNumberAnswer = $classifyFirstNumber + $classifyLastNumber;
						?>
						<div class="col-sm-6 padding-control form-group">
							<p>
							<?php esc_html_e("Please input the result of ", "classify"); ?>
							<?php echo $classifyFirstNumber; ?> + <?php echo $classifyLastNumber;?> = 
							</p>
						</div>
						<div class="col-sm-6 form-group">
							<span class="fa fa-text-height form-control-feedback"></span>
							<input class="form-control" type="text" name="humanTest" placeholder="<?php esc_html_e( 'Your answer', 'classify' ); ?>" data-error="<?php esc_html_e( 'please type your answer', 'classify' ); ?>" required>
							<div class="help-block with-errors"></div>
						</div>
						<input type="hidden" name="humanAnswer" id="humanAnswer" value="<?php echo $classifyNumberAnswer; ?>" />
						<input type="hidden" name="classify_post_title" value="<?php the_title(); ?>" />
						<input type="hidden" name="classify_post_url" value="<?php the_permalink(); ?>"  />
						<input type="hidden" name="submit" value="send_message" />
						<div class="col-sm-12 form-group">
							<input class="form-control padding-control" type="submit" value="<?php esc_html_e( 'Send', 'classify' ); ?>" name="submit">
						</div>
						<!--humanAnswer-->
					</form>
				</div>
				<?php } ?>
				<?php 
				if($classify_comments_area == true){
					comments_template();
				}
				?> 
				<!--Contact to author-->
			</div><!--col-md-8-->
			<div class="col-md-4 col-sm-6 col-res-centered">
				<div class="sidebar">				
					<?php dynamic_sidebar('single'); ?> 
				</div>
			</div>
		</div><!--row-->
	</div><!--container-->
</section><!--detail-->	
<?php endwhile; ?>
<?php get_footer(); ?>
