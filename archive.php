<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example, Twenty Thirteen
 * already has tag.php for Tag archives, category.php for Category archives,
 * and author.php for Author archives.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage classify
 * @since classify 1.0
 */

get_header();
?>
<section id="page-head">
	<div class="container">
		<div class="row col-md-12">
			<div class="page-heading">
				<h1>
					<?php
					global $paged, $wp_query, $wp;
					$args = wp_parse_args($wp->matched_query);
					if ( !empty ( $args['paged'] ) && 0 == $paged ) {
						$wp_query->set('paged', $args['paged']);
						$paged = $args['paged'];
					}
						if ( is_day() ) :

									printf( __( 'Daily Archives: %s', 'classify' ), get_the_date() );
									$archive_year  = get_the_date('Y'); 
									$archive_month = get_the_date('m'); 
									$archive_day   = get_the_date('d');
									global $args; $args = array('paged' => $paged, 'posts_per_page' => 9, 'year' => $archive_year, 'monthnum' => $archive_month, 'day' => $archive_day, 'order' => 'DESC', 'post_type' => 'post');
									global $args_popular; $args_popular = array('paged' => $paged, 'posts_per_page' => 9, 'year' => $archive_year, 'monthnum' => $archive_month, 'day' => $archive_day, 'post_type' => 'post', 'meta_key' => 'wpb_post_views_count', 'orderby' => 'meta_value_num', 'order' => 'DESC');
									global $args_random; $args_random = array('paged' => $paged, 'posts_per_page' => 9, 'year' => $archive_year, 'monthnum' => $archive_month, 'day' => $archive_day, 'order' => 'DESC', 'post_type' => 'post', 'orderby' => 'title');

						elseif ( is_month() ) :

									printf( __( 'Monthly Archives: %s', 'classify' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'classify' ) ) );
									$archive_year  = get_the_date('Y'); 
									$archive_month = get_the_date('m');
									global $args; $args = array('paged' => $paged, 'posts_per_page' => 9, 'year' => $archive_year, 'monthnum' => $archive_month, 'order' => 'DESC', 'post_type' => 'post');
									global $args_popular; $args_popular = array('paged' => $paged, 'posts_per_page' => 9, 'year' => $archive_year, 'monthnum' => $archive_month, 'post_type' => 'post', 'meta_key' => 'wpb_post_views_count', 'orderby' => 'meta_value_num', 'order' => 'DESC');
									global $args_random; $args_random = array('paged' => $paged, 'posts_per_page' => 9, 'year' => $archive_year, 'monthnum' => $archive_month, 'order' => 'DESC', 'post_type' => 'post', 'orderby' => 'title');

						elseif ( is_year() ) :

									printf( __( 'Yearly Archives: %s', 'classify' ), get_the_date( _x( 'Y', 'yearly archives date format', 'classify' ) ) );
									$archive_year  = get_the_date('Y'); 
									global $args; $args = array('paged' => $paged, 'posts_per_page' => 9, 'year' => $archive_year, 'order' => 'DESC');
									global $args_popular; $args_popular = array('paged' => $paged, 'posts_per_page' => 9, 'year' => $archive_year, 'meta_key' => 'wpb_post_views_count', 'orderby' => 'meta_value_num', 'order' => 'DESC');
									global $args_random; $args_random = array('paged' => $paged, 'posts_per_page' => 9, 'year' => $archive_year, 'order' => 'DESC', 'orderby' => 'title');

						elseif ( is_tag() ) :
								
									single_tag_title( __( 'Tag', 'classify' ) );
									global $wp_query;
									$tag = $wp_query->get_queried_object();
									$current_tag = $tag->term_id;

									global $args; $args = array('paged' => $paged, 'posts_per_page' => 9, 'tag_id' => $current_tag, 'order' => 'DESC');
									global $args_popular; $args_popular = array('paged' => $paged, 'posts_per_page' => 9, 'tag_id' => $current_tag, 'meta_key' => 'wpb_post_views_count', 'orderby' => 'meta_value_num', 'order' => 'DESC');
									global $args_random; $args_random = array('paged' => $paged, 'posts_per_page' => 9, 'tag_id' => $current_tag, 'order' => 'DESC', 'orderby' => 'title');

						else :

									_e( 'Archives', 'classify' );

						endif;
					?>
				</h1>
			</div>
		</div>
	</div>
</section><!--end main page heading-->
<section id="detail">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
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
							<div class="col-md-12 content content1">
								<div class="clearfix">
									<?php
									global $paged, $wp_query, $wp;
									$args = wp_parse_args($wp->matched_query);
									if ( !empty ( $args['paged'] ) && 0 == $paged ) {
										$wp_query->set('paged', $args['paged']);
										$paged = $args['paged'];
									}
									if ( is_day() ) :													
										$archive_year  = get_the_date('Y'); 
										$archive_month = get_the_date('m'); 
										$archive_day   = get_the_date('d');
										global $args; $args = array('paged' => $paged, 'posts_per_page' => 9, 'year' => $archive_year, 'monthnum' => $archive_month, 'day' => $archive_day, 'order' => 'DESC', 'post_type' => 'post');
										global $args_popular; $args_popular = array('paged' => $paged, 'posts_per_page' => 9, 'year' => $archive_year, 'monthnum' => $archive_month, 'day' => $archive_day, 'post_type' => 'post', 'meta_key' => 'wpb_post_views_count', 'orderby' => 'meta_value_num', 'order' => 'DESC');
										global $args_random; $args_random = array('paged' => $paged, 'posts_per_page' => 9, 'year' => $archive_year, 'monthnum' => $archive_month, 'day' => $archive_day, 'order' => 'DESC', 'post_type' => 'post', 'orderby' => 'title');

									elseif ( is_month() ) :													
										$archive_year  = get_the_date('Y'); 
										$archive_month = get_the_date('m');
										global $args; $args = array('paged' => $paged, 'posts_per_page' => 9, 'year' => $archive_year, 'monthnum' => $archive_month, 'order' => 'DESC', 'post_type' => 'post');
										global $args_popular; $args_popular = array('paged' => $paged, 'posts_per_page' => 9, 'year' => $archive_year, 'monthnum' => $archive_month, 'post_type' => 'post', 'meta_key' => 'wpb_post_views_count', 'orderby' => 'meta_value_num', 'order' => 'DESC');
										global $args_random; $args_random = array('paged' => $paged, 'posts_per_page' => 9, 'year' => $archive_year, 'monthnum' => $archive_month, 'order' => 'DESC', 'post_type' => 'post', 'orderby' => 'title');

									elseif ( is_year() ) :
													
										$archive_year  = get_the_date('Y'); 
										global $args; $args = array('paged' => $paged, 'posts_per_page' => 9, 'year' => $archive_year, 'order' => 'DESC');
										global $args_popular; $args_popular = array('paged' => $paged, 'posts_per_page' => 9, 'year' => $archive_year, 'meta_key' => 'wpb_post_views_count', 'orderby' => 'meta_value_num', 'order' => 'DESC');
										global $args_random; $args_random = array('paged' => $paged, 'posts_per_page' => 9, 'year' => $archive_year, 'order' => 'DESC', 'orderby' => 'title');

									elseif ( is_tag() ) :

										global $wp_query;
										$tag = $wp_query->get_queried_object();
										$current_tag = $tag->term_id;

										global $args; $args = array('paged' => $paged, 'posts_per_page' => 9, 'tag_id' => $current_tag, 'order' => 'DESC');
										global $args_popular; $args_popular = array('paged' => $paged, 'posts_per_page' => 9, 'tag_id' => $current_tag, 'meta_key' => 'wpb_post_views_count', 'orderby' => 'meta_value_num', 'order' => 'DESC');
										global $args_random; $args_random = array('paged' => $paged, 'posts_per_page' => 9, 'tag_id' => $current_tag, 'order' => 'DESC', 'orderby' => 'title');

									else :

									endif;
									?>
									<?php 
									$wp_query= null;
									$wp_query = new WP_Query();
									$wp_query->query($args);
									while ($wp_query->have_posts()) : $wp_query->the_post();
										get_template_part('templates/single-loop-md4');
									endwhile;
									get_template_part('pagination');
									wp_reset_query();
									?>
								</div><!--clearfix-->
							</div><!--content1-->
							<!--Popular Ads-->
							<div class="col-md-12 content content2">
								<div class="clearfix">
								<?php 
								$wp_query= null;
								$wp_query = new WP_Query();
								$wp_query->query($args_popular);
								while ($wp_query->have_posts()) : $wp_query->the_post();
									get_template_part('templates/single-loop-md4');
								endwhile;
								get_template_part('pagination');
								wp_reset_query();
								?>
								</div><!--clearfix-->
							</div><!--content2-->
							<!--Popular Ads-->
							<!--Random Ads-->
							<div class="col-md-12 content content3">
								<div class="clearfix">
									<?php 
									$wp_query= null;
									$wp_query = new WP_Query();
									$wp_query->query($args_random);
									while ($wp_query->have_posts()) : $wp_query->the_post();
										get_template_part('templates/single-loop-md4');
									endwhile;
									get_template_part('pagination');
									wp_reset_query();
									?>
								</div><!--clearfix-->
							</div><!--content3-->
							<!--Random Ads-->
						</div><!--row-->
					</div><!--container-->
				</section>
				<!--Classify Advertisement-->
			</div><!--col-md-8-->
			<div class="col-md-4 col-sm-6 col-res-centered">
				<div class="sidebar">
					<?php get_sidebar('pages'); ?>
				</div>
			</div>
		</div><!--row-->
	</div><!--container-->
</section><!--detail--> 
<?php get_footer(); ?>