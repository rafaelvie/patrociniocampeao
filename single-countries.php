<?php
/**
 * The Template for displaying single country.
 *
 * @package WordPress
 * @subpackage classiera
 * @since classiera 2.0.13
 */
get_header(); ?>
<?php
	global $redux_demo; 
	$page = get_post($post->ID);
	$current_page_id = $page->ID;
	$locationName = get_the_title();
?>
<section id="page-head">
	<div class="container">
		<div class="row col-md-12">
			<div class="page-heading">
				<h1><?php echo $locationName;?></h1>
			</div>
		</div>
	</div>
</section><!--end main page heading-->
<section id="detail">
	<div class="container">
		<div class="row">
			<section id="advertisement">
				<div class="container" data-width-offset="10">
					<!--HeadView-->
					<div class="row view-head">
						<div class="col-md-8 col-xs-8 col-sm-8">
							<div class="adv-tabs">
								<p><?php esc_html_e( 'Ads founded in ', 'classify' ); ?> <?php echo $locationName;?></p>
							</div>
						</div>
						<div class="col-md-4">
							<div class="view-as text-right flip">
								<a id="grid" class="grid btn active" href="#"><i class="fa fa-th"></i></a>
								<a id="list" class="list btn" href="#"><i class="fa fa-bars"></i></a>
							</div>
						</div>
					</div>
					<!--HeadView-->
					<div class="row">
						<!--Latest Ads-->
						<div class="col-md-12 content content1">
							<div class="clearfix">
								<?php
								global $paged, $wp_query, $wp;
								$args = wp_parse_args($wp->matched_query);
								if( !empty ( $args['paged'] ) && 0 == $paged ){
									$wp_query->set('paged', $args['paged']);
									$paged = $args['paged'];
								}
								$temp = $wp_query;
								$wp_query= null;
								$args = array(
								'post_type'  => 'post',
								'posts_per_page' => 12,
								'paged' => $paged,
									'meta_query' => array(
										array(
											'key'     => 'post_location',
											'value'   => $locationName,
										),
									),
								);
								$wp_query = new WP_Query($args);
								while ($wp_query->have_posts()) : $wp_query->the_post();
									get_template_part( 'templates/single-loop-md3' );
								endwhile;
								?>
							</div>
							<?php get_template_part('pagination');?>
							<?php wp_reset_query(); ?>
						</div>
						<!--Latest Ads-->
					</div>
				</div><!--container-->
			</section><!--advertisement-->
		</div><!--row-->
	</div><!--container-->
</section><!--detail-->
<?php get_footer(); ?>