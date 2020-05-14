<?php
get_header(); 
?>
<?php 
global $redux_demo;
global $wp_query;
?>
<section id="detail">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>				
					<?php get_template_part( 'templates/blog-loop' ); ?>
				<?php endwhile; ?>
				<?php else : ?>
				<p><?php esc_html_e( 'Sorry nothing found' ); ?></p>
				<?php endif; ?>
			</div><!--col-md-8-->
			<div class="col-md-4">
				<div class="sidebar">
					<?php get_sidebar('main'); ?>
				</div><!--sidebar-->
			</div><!--col-md-4-->
		</div><!--row-->
	</div><!--container-->
</section>
<?php get_footer(); ?>
