<?php
get_header();?>
<?php
	//Classify theme options//
	global $redux_demo;
	$max_range = $redux_demo['max_range'];
	if(!empty($max_range)) {
		$maximRange = $max_range;
	} else {
		$maximRange = 1000;
	}
	$classifyHideFeaturedSlider = $redux_demo['hide-fslider'];
	$classifyHideMap = $redux_demo['hide-map'];
	$classifyAdvSearch = $redux_demo['classify_adv_search_cat'];
	$classifyCatsAdsCount = $redux_demo['classify_cats_ads_count'];
?>
<?php 
	$cat_id = get_queried_object_id();
	$this_category = get_category($cat_id);
	$cat_parent_ID = isset( $cat_id->category_parent ) ? $cat_id->category_parent : '';
	if ($cat_parent_ID == 0) {
		$tag = $cat_id;
	}else{
		$tag = $cat_parent_ID;
	}
	$category = get_category($tag);
	$count = $category->category_count;
	$catName = get_cat_name( $tag );
	//Find Total Posts//
	$q = new WP_Query( array(
		'nopaging' => true,
		'tax_query' => array(
			array(
				'taxonomy' => 'category',
				'field' => 'id',
				'terms' => $tag,
				'include_children' => true,
			),
		),
		'fields' => 'ids',
	) );
	$allPosts = $q->post_count;
	//Find Sub categories//
	$args = array(
		'type' => 'post',
		'child_of' => $tag,
		'parent' => get_query_var(''),
		'orderby' => 'name',
		'order' => 'ASC',
		'hide_empty' => 0,
		'hierarchical' => 1,
		'exclude' => '',
		'include' => '',
		'number' => '',
		'taxonomy' => 'category',
		'pad_counts' => true,
	);
	$categories = get_categories($args);
	$subCateCount = 0;
	foreach($categories as $category) {
		$subCateCount++;
	}
?>
<section id="page-head" class="margin-control">
	<div class="container">
		<div class="row col-md-12">
			<div class="page-heading">
				<h1><?php echo $catName; ?></h1>
				<h4>
				<?php echo $allPosts; ?>&nbsp;
				<?php esc_html_e( 'Ads In', 'classify' ); ?>&nbsp;
				<?php echo $subCateCount; ?>&nbsp;
				<?php esc_html_e( 'subcategories', 'classify' ); ?>
				</h4>
			</div>
		</div>
	</div>
</section><!--end main page heading-->
	<?php
	if($classifyHideMap == 1){
		get_template_part('templates/classify_category_map');
	}else{
	?>
		<script type="text/javascript">	
			jQuery(document).ready(function(){
				jQuery(function() {
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
						}
					}).find(".ui-slider-handle").append(tooltip).hover(function() {
						tooltip.show()
					}, function() {
						tooltip.hide()
					});
					tooltip.text(jQuery( "#slider-range-min" ).slider( "value" ) + distance);
					jQuery( "#amount" ).val(jQuery( "#slider-range-min" ).slider( "value" ) );
				});
			});
		</script>
	<?php
	}
	get_template_part('templates/classify-searchbar');	
	?>
<section id="detail">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<?php 
				if($classifyHideFeaturedSlider == 1){
					get_template_part('templates/classify_category_premium_ads');
				}
				?>
				<!--Classify Advertisement-->
				<section id="advertisement">
					<div class="container" data-width-offset="10">
						<div class="row">
							<div class="col-sm-12">
								<div class="main-heading text-center">
									<h2>
										<span class="font-container">
										<?php esc_html_e('CLASSIFY ADVERTISEMENT', 'classify' ); ?>
										</span>
									</h2>
								</div><!--main-heading-->
							</div><!--col-sm-12-->
						</div><!--row-->
						<div class="row view-head">
							<div class="col-md-8 col-xs-8 col-sm-8">
								<div class="adv-tabs">
									<span class="tab active" id="content1">
										<?php esc_html_e('Latest Ads', 'classify' ); ?>
									</span>
									<span class="tab" id="content2">										
										<?php esc_html_e('Most Popular Ads', 'classify' ); ?>
									</span>
									<span class="tab" id="content3">										
										<?php esc_html_e('Random Ads', 'classify' ); ?>
									</span>
								</div>
							</div><!--col-md-8-->
							<div class="col-md-4">
								<div class="view-as text-right flip">
									<?php global $redux_demo;?>
									<?php $classifyAdsView = $redux_demo['home-ads-view'];?>
									<a id="grid" class="grid btn <?php if($classifyAdsView == 'grid'){echo 'active';}?>" href="#"><i class="fa fa-th"></i></a>
									<a id="list" class="list btn <?php if($classifyAdsView == 'list'){echo 'active';}?>" href="#"><i class="fa fa-bars"></i></a>
								</div>
							</div><!--col-md-4-->
						</div><!--row view-head-->
						<div class="row">
							<!--Latest Ads-->
							<div class="col-md-12 content content1">
								<div class="clearfix">
									<?php 
									global $paged, $wp_query, $wp;
									$args = wp_parse_args($wp->matched_query);
									if ( !empty ( $args['paged'] ) && 0 == $paged ) {
										$wp_query->set('paged', $args['paged']);
										$paged = $args['paged'];										
									}
									$temp = $wp_query;
									$arags = array(
										'post_type' => 'post',
										'posts_per_page' => 9,
										'paged' => $paged,
										'cat' => $cat_id,
									);
									$wp_query= null;
									$wp_query = new WP_Query($arags);
									?>
									<?php while ($wp_query->have_posts()) : $wp_query->the_post();?>
										<?php get_template_part('templates/single-loop-md4');?>
									<?php endwhile; ?>									
								</div><!--clearfix-->
								<?php 
								if(function_exists('classify_pagination')){
									classify_pagination();
								}
								wp_reset_query();
								?>
							</div>
							<!--Latest Ads-->
							<!--Popular Ads-->
							<div class="col-md-12 content content2">
								<div class="clearfix">
									<?php 
									global $paged, $wp_query, $wp;
									$args = wp_parse_args($wp->matched_query);
									if ( !empty ( $args['paged'] ) && 0 == $paged ) {
										$wp_query->set('paged', $args['paged']);
										$paged = $args['paged'];										
									}
									$temp = $wp_query;
									$arags = array(
										'post_type' => 'post',
										'posts_per_page' => 9,
										'paged' => $paged,
										'cat' => $cat_id,
										'meta_key' => 'wpb_post_views_count',
										'orderby' => 'meta_value_num',
										'order' => 'DESC',
									);
									$wp_query= null;
									$wp_query = new WP_Query($arags);
									?>
									<?php while ($wp_query->have_posts()) : $wp_query->the_post();?>
										<?php get_template_part('templates/single-loop-md4');?>
									<?php endwhile; ?>
									<?php get_template_part('pagination'); ?>
									<?php wp_reset_query(); ?>
								</div><!--clearfix-->
							</div>
							<!--Popular Ads-->
							<!--Random Ads-->
							<div class="col-md-12 content content3">
								<div class="clearfix">
									<?php 
									global $paged, $wp_query, $wp;
									$args = wp_parse_args($wp->matched_query);
									if ( !empty ( $args['paged'] ) && 0 == $paged ) {
										$wp_query->set('paged', $args['paged']);
										$paged = $args['paged'];										
									}
									$temp = $wp_query;
									$arags = array(
										'post_type' => 'post',
										'posts_per_page' => 9,
										'paged' => $paged,
										'cat' => $cat_id,										
										'orderby' => 'rand',
										'order' => 'DESC',
									);
									$wp_query= null;
									$wp_query = new WP_Query($arags);
									?>
									<?php while ($wp_query->have_posts()) : $wp_query->the_post();?>
										<?php get_template_part('templates/single-loop-md4');?>
									<?php endwhile; ?>
									<?php get_template_part('pagination'); ?>
									<?php wp_reset_query(); ?>
								</div><!--clearfix-->
							</div>
							<!--Random Ads-->							
						</div><!--row-->
					</div><!--container-->
				</section>
				<!--Classify Advertisement-->
			</div><!--col-md-8-->
			<div class="col-md-4 col-sm-6 col-res-centered">
				<div class="sidebar">
					<!--SUBCATEGORIES-->
					<?php 
					$cat_term_ID = $this_category->term_id;
					$cat_child = get_term_children( $cat_term_ID, 'category' );
					if(!empty($cat_child)):
					?>
					<div class="widget clearfix">
						<div class="widget__heading">
							<h4 class="inner-heading"><?php esc_html_e( 'SUBCATEGORIES', 'classify' ); ?></h4>
						</div><!--widget__heading-->	
						<div class="widget__content">
							<div class="widget__content_subcat">
								<ul class="list-unstyled">
									<?php 
									$args = array(
									'type' => 'post',
									'child_of' => $cat_id,
									'parent' => get_query_var(''),
									'orderby' => 'name',
									'order' => 'ASC',
									'hide_empty' => 0,
									'hierarchical' => 1,
									'exclude' => '',
									'include' => '',
									'number' => '',
									'taxonomy' => 'category',
									'pad_counts' => true );
									$categories = get_categories($args);
									if($categories[0]->category_parent == 0){
										$tag = $categories[0]->cat_ID;
										$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
										if (isset($tag_extra_fields[$tag])) {
											$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
											$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
										}
									}else{
										$tag = $categories[0]->category_parent;
										$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
										if (isset($tag_extra_fields[$tag])) {
											$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
											$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
										}
									}
									$category_icon = stripslashes($category_icon_code);
									foreach($categories as $category):
									?>
									<li>
										<a href="<?php echo get_category_link( $category->term_id )?>">
											<i class="<?php echo $category_icon; ?>"></i>
											<?php echo $category->name ?>
											<?php if($classifyCatsAdsCount == 1){ ?>
											<span><?php echo $category->count ?></span>
											<?php } ?>
										</a>
									</li>
									<?php endforeach; ?>
								</ul>
							</div><!--widget__content_subcat-->
						</div><!--widget__content-->
					</div><!--widget-->					
					<?php endif;?>
					<!--SUBCATEGORIES-->
					<?php 
					if($classifyAdvSearch == 1){
						get_template_part('templates/classify_advance_search');
					}
					?>
					<?php get_sidebar('pages'); ?>
				</div>
			</div><!--col-md-4-->
		</div><!--row-->
	</div><!--container-->
</section> <!--detail-->	
<?php get_footer(); ?>
