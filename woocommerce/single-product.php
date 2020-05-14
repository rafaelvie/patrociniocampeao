<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>
<section id="page-head" class="margin-control">
	<div class="container">
		<div class="row col-md-12">
			<div class="page-heading">
				<h1><?php the_title();?></h1>				
			</div>
		</div>
	</div>
</section>
<section id="detail">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<div class="woocommerce">
				<?php while ( have_posts() ) : the_post(); ?>
				<?php wc_get_template_part( 'content', 'single-product' ); ?>
				<?php endwhile; // end of the loop. ?>
				</div>
			</div>
			<div class="col-md-4">
				<div class="sidebar">
				<?php do_action( 'woocommerce_sidebar' ); ?>
				</div><!--sidebar-->
			</div><!--col-md-4-->
		</div>
	</div>
</section>
<?php get_footer( 'shop' );
