<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

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