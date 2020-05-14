<?php
get_header(); ?>
<?php 
	global $redux_demo;
	$map_style = $redux_demo['map-style'];
	$classifyMAPOnSearch = $redux_demo['classify_map_on_search_page'];	
	$searchQueryCountry = '';
	$searchQueryState = '';
	$searchQueryCity = '';
	$searchCondition = '';
	$catSearchID = '';
	$searchQueryCustomFields = '';
	$classifySearchKeyword = $_GET['s'];
	if(isset($_GET['classify_min_price'])){
		$minPrice = $_GET['classify_min_price'];
	}
	if(isset($_GET['classify_max_price'])){
		$maxPrice = $_GET['classify_max_price'];
	}
	if(!empty($minPrice) && !empty($maxPrice)){
		$searchQueryPrice = classify_Price_search_Query($minPrice, $maxPrice);
	}
	if(isset($_GET['custom_fields'])){
		$custom_fields = $_GET['custom_fields'];
		$searchQueryCustomFields = classify_CF_search_Query($custom_fields);
	}
	if(isset($_GET['post_location'])){
		$country = $_GET['post_location'];		
		$searchQueryCountry = classify_Country_search_Query($country);		
	}
	if(isset($_GET['post_state'])){
		$state = $_GET['post_state'];
		$searchQueryState = classify_State_search_Query($state);		
	}
	if(isset($_GET['post_city'])){
		$city = $_GET['post_city'];
		$searchQueryCity = classify_City_search_Query($city);
	}
	if(isset($_GET['classify_ad_condition'])){
		$search_condition = $_GET['classify_ad_condition'];		
		$searchCondition = classify_Condition_search_Query($search_condition);
	}
	if(isset($_GET['classify_ads_type'])){
		$search_adstype = $_GET['classify_ads_type'];		
		$searchAdsType = classify_adstype_search_Query($search_adstype);
	}
	if(isset($_GET['category_name'])){
		$catSearchID = $_GET['category_name'];
	}
	if($catSearchID == 'All' || $catSearchID == '-1'){
		$catSearchID = '';
	}
?>
<section id="page-head">
	<div class="container">
		<div class="row col-md-12">
			<div class="page-heading">
				<h1><?php printf( __( 'Search Results for: ', 'classify' )); ?>&nbsp;<?php echo $classifySearchKeyword; ?></h1>
			</div>
		</div>
	</div>
</section><!--end main page heading-->
<?php if($classifyMAPOnSearch == 1){ ?>
<section id="big-map">
	<div id="log" style="display:none;"></div>
	<input id="latitude" type="hidden" value="">
	<input id="longitude" type="hidden" value="">
	<div id="classify_main_map" style="width:100%; height:600px;">
		<script type="text/javascript">			
			jQuery(document).ready(function(){
				var addressPoints = [
					<?php 
					$args = array(
						'post_type' => 'post',
						'post_status' => 'publish',
						's'   => $classifySearchKeyword,
						'posts_per_page' => -1,
						'category_name' => $catSearchID,
						'meta_query' => array(
							'relation' => 'AND',
							$searchQueryCountry,											
							$searchQueryState,											
							$searchQueryCity,
							$searchCondition,
							$searchQueryPrice,
							$searchAdsType,
							$searchQueryCustomFields,
						),
					);
					$wp_query= null;
					$wp_query = new WP_Query($args);
					while ($wp_query->have_posts()) : $wp_query->the_post();
						$post_latitude = get_post_meta($post->ID, 'post_latitude', true);
						$post_longitude = get_post_meta($post->ID, 'post_longitude', true);
						$classify_ads_type = get_post_meta($post->ID, 'classify_ads_type', true);
						$classify_ads_type = classify_ads_type_display($classify_ads_type);
						$theTitle = get_the_title();
						$post_price = get_post_meta($post->ID, 'post_price', true);
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
						if(!empty($category_icon_code)) {
							$catIcon = stripslashes($category_icon_code);
						}
						if(!empty($classifyCatIcoIMG)) {
							$iconPath = $classifyCatIcoIMG;
						} else {
							$iconPath = get_template_directory_uri() .'/images/icon-services.png';
						}
						if(has_post_thumbnail()){
							$classifyIMG = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
							$classifyIMGURL = $classifyIMG[0];
						}else{
							$classifyIMGURL = get_template_directory_uri() . '/images/nothumb.png';
						}
						$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
						if(empty($post_currency_tag)){
							$post_currency_tag = $redux_demo['classify_post_currency'];
						}
						$post_currency_tag = classify_Display_currency_sign($post_currency_tag);
						if(is_numeric($post_price)){
							$post_price = $post_currency_tag.$post_price; 
						}else{
							$post_price = $post_price; 
						}
						
					if(!empty($post_latitude)){	
					$content = '<div class="classify_adv_box classify_map_box_home"><div class="classify_adv_box_img"><img src="'.$classifyIMGURL.'" alt="'.get_the_title().'"><a href="'.get_the_permalink().'" class="classify_adv_hover"><span>'.$post_price.'</span><i class="'.$catIcon.' fa-2x" style="background-color:'.$category_icon_color.';"></i></a><p class="classify_adv_box_title"><a href="'.get_the_permalink().'">'.get_the_title().'</a></p><span class="classify-buy-sel">'.$classify_ads_type.'</span><div class="close_map_box"><i class="fa fa-times"></i></div></div></div>';
					?>
					
					[<?php echo $post_latitude; ?>, <?php echo $post_longitude; ?>, '<?php echo $content; ?>', "<?php echo $iconPath; ?>"],
					
					<?php 
					}
					endwhile;
					wp_reset_query();
					?>
				];
				var mapopts =  {				 
				  //zoomSnap: 0.1
				  dragging:false,
				  tap:false
				};
				var map = L.map('classify_main_map', mapopts).setView([0,0],1);
				map.dragging.disable;
				map.scrollWheelZoom.disable();
				var roadMutant = L.gridLayer.googleMutant({
				<?php if($classifyMAPStyle){?>styles: <?php echo $classifyMAPStyle; ?>,<?php }?>
					maxZoom: 20,
					type:'roadmap'
				}).addTo(map);
				var markers = L.markerClusterGroup({
					spiderfyOnMaxZoom: true,
					showCoverageOnHover: true,
					zoomToBoundsOnClick: true,
					maxClusterRadius: 60
				});
				markers.on('clusterclick', function(e) {				
					//document.getElementById("log").innerHTML = "cluster";
					map.setView(e.latlng, 5);				
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
				var circle;
				map.addLayer(markers);
				function getLocation(){
					if(navigator.geolocation){
						navigator.geolocation.getCurrentPosition(showPosition);
					}else{
						x.innerHTML = "Geolocation is not supported by this browser.";
					}
				}
				function showPosition(position){					
					jQuery('#latitude').val(position.coords.latitude);
					jQuery('#longitude').val(position.coords.longitude);
					var latitude = jQuery('#latitude').val();
					var longitude = jQuery('#longitude').val();
					map.setView([latitude,longitude],13);
					circle = new L.circle([latitude, longitude], {radius: 2500}).addTo(map);
				}
				jQuery('.classify_getloc').on('click', function(e){
					e.preventDefault();
					getLocation();
				});
				//Slider//
				jQuery(function(){
					var tooltip = jQuery('<div id="tooltip" />').css({
						position: 'absolute',
						bottom: -30,
						left: -30
					}).hide();

					var distance = jQuery( "#slider-range-min" ).data('mil');
					
					jQuery( "#slider-range-min" ).slider({					
						range: "min",
						value: 500,
						min: 1,
						max: 1000,
						slide: function(event, ui) {
							tooltip.text(ui.value + distance);
							jQuery( "#amount" ).val(ui.value);
							var classifykms = ui.value * 1000 / 100;
							var latitude = jQuery('#latitude').val();
							var longitude = jQuery('#longitude').val();	
							map.removeLayer(circle);
							circle = new L.circle([latitude, longitude], {radius: classifykms}).addTo(map);						
						}
					}).find(".ui-slider-handle").append(tooltip).hover(function() {
						tooltip.show()
					}, function() {
						tooltip.hide()
					});
					tooltip.text(jQuery( "#slider-range-min" ).slider( "value" ) + distance);
					jQuery( "#amount" ).val(jQuery( "#slider-range-min" ).slider( "value" ) );
				});
				//Slider//	
			});
		</script>
	</div>
</section>
<?php } ?>
<?php get_template_part( 'templates/classify-searchbar' );?>
<section id="detail">
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<div class="sidebar">
					<?php get_template_part('templates/classify_advance_search');?>
				</div>
			</div>
			<div class="col-md-8">
				<!--Classify Advertisement-->
				<section id="advertisement">
					<div class="container" data-width-offset="10">
						<!--heading-->
						<div class="row">
							<div class="col-sm-12">
								<div class="main-heading text-center">
									<h2><span class="font-container"><?php esc_html_e( 'Advertisement', 'classify' ); ?></span></h2>
								</div>
							</div>
						</div>
						<!--heading-->
						<!--HeadView-->
						<div class="row view-head">
							<div class="col-md-8 col-xs-8 col-sm-8">
								<div class="adv-tabs">
									<?php esc_html_e( 'Result founded related to your search', 'classify') ?>
								</div>
							</div>
							<div class="col-md-4">
								<div class="view-as text-right flip">
									<?php global $redux_demo;?>
									<?php $classifyAdsView = $redux_demo['home-ads-view'];?>
									<a id="grid" class="grid btn <?php if($classifyAdsView == 'grid'){echo 'active';}?>" href="#"><i class="fa fa-th"></i></a>
									<a id="list" class="list btn <?php if($classifyAdsView == 'list'){echo 'active';}?>" href="#"><i class="fa fa-bars"></i></a>
								</div>
							</div>
						</div>
						<!--HeadView-->
						<div class="row">
							<div class="col-md-12 content content1">
								<div class="clearfix">
									<?php 
									global $paged, $wp_query, $wp;								
									$args = wp_parse_args($wp->matched_query);
									$temp = $wp_query;								
									$args = array(
										'post_type' => 'post',
										'post_status' => 'publish',
										's'   => $classifySearchKeyword,
										'posts_per_page' => -1,
										'category_name' => $catSearchID,
										'meta_query' => array(
											'relation' => 'AND',
											$searchQueryCountry,											
											$searchQueryState,											
											$searchQueryCity,
											$searchQueryPrice,
											$searchCondition,
											$searchAdsType,
											$searchQueryCustomFields,
										),
									);
									//print_r($args);
									$wp_query= null;
									$wp_query = new WP_Query($args);
									//print_r($wp_query);
									while ($wp_query->have_posts()) : $wp_query->the_post();
										get_template_part('templates/single-loop-md4');
									endwhile;
									wp_reset_query();
									wp_reset_postdata();
									?>
								</div><!--clearfix-->
							</div><!--col-md-12-->
						</div><!--row-->
					</div><!--container-->
				</section><!--advertisement-->
				<!--Classify Advertisement-->
			</div><!--col-md-8-->
		</div><!--row-->
	</div><!--container-->
</section><!--detail-->
<?php get_footer(); ?>
