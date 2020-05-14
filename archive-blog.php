<?php
/**
 * The template for displaying archives of blog categories
 *
 * @package WordPress
 * @subpackage classify
 * @since classify 4.0
 */
 ?>
<?php get_header();?>
<?php 	
	$wp_query->get_queried_object();
?>
<section class="page_title">
	<h2 class="text-uppercase text-center"><?php the_archive_title(); ?></h2>
</section>
<main>
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-lg-8">
				<?php			
				
				if ( have_posts() ):
					while ( have_posts() ) : the_post(); 
						get_template_part( 'templates/classify-blog-loop' );
					endwhile;
				?>
				<div class="pagination-nav">
					<?php //pagination
					$big = 999999999; // need an unlikely integer		
					echo paginate_links( array(
							'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
							'format' => '?paged=%#%',
							'current' => max( 1, get_query_var('paged') ),
							'total' => $wp_query->max_num_pages
						) );
					?>
				</div><!--pagination-nav-->
				<?php 
				else :
					$classifyNotFound =  esc_html__( 'Sorry Nothing Found', 'classify' );
					echo $classifyNotFound;
				endif;
				wp_reset_postdata(); 
				?>
			</div><!--col-md-8-->
			<div class="col-md-4 col-sm-6 col-res-centered">
				<div class="sidebar">
					<?php dynamic_sidebar('blog'); ?>
				</div>
			</div><!--col-md-4-->
		</div><!--row-->
	</div><!--container-->
</main>
<?php get_footer(); ?>