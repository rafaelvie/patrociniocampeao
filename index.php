<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme and one of the
 * two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage classify
 * @since classify 1.0
 */
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
					<?php get_template_part( 'templates/classify-blog-loop' ); ?>
				<?php endwhile; ?>
				<?php else : ?>
				<p><?php esc_html_e( 'Sorry nothing found', 'classify' ); ?></p>
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