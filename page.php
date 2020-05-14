<?php
get_header();?>
<?php 
	$page = get_post($post->ID);
	$current_page_id = $page->ID;
	$page_slider = get_post_meta($current_page_id, 'page_slider', true);
	$classifyPageTitle = get_post_meta($current_page_id, 'page_custom_title', true);
?>
<section id="page-head">
	<div class="container">
		<div class="row col-md-12">
			<div class="page-heading">
				<h1><?php the_title(); ?></h1>
			</div>
		</div>
	</div>
</section><!--end main page heading-->
<section id="detail">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<div class="page-content">					
					<?php if($classifyPageTitle){?><h4 class="inner-heading"><?php echo $classifyPageTitle; ?></h4><?php } ?>
					<!--Content area-->
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
						<?php the_content(); ?>
					<?php endwhile; endif; ?>
					<?php
						$defaults = array(
							'before'           => '<p>' . __( 'Pages:', 'classify' ),
							'after'            => '</p>',
							'link_before'      => '',
							'link_after'       => '',
							'next_or_number'   => 'number',
							'separator'        => ' ',
							'nextpagelink'     => __( 'Next page', 'classify'),
							'previouspagelink' => __( 'Previous page', 'classify' ),
							'pagelink'         => '%',
						);
						wp_link_pages($defaults);
					?>
					<!--Content area-->
				</div>
			</div><!--col-md-8-->
			<div class="col-md-4 col-sm-6 col-res-centered">
				<div class="sidebar">
					<?php get_sidebar('pages'); ?>
				</div>
			</div><!--col-md-4-->
		</div><!--row-->
	</div><!--container-->
</section><!--section detail-->
<?php get_footer(); ?>
