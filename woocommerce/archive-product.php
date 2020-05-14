<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>
<section id="page-head" class="margin-control">
	<div class="container">
		<div class="row col-md-12">
			<div class="page-heading">
				<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
				<h1><?php woocommerce_page_title(); ?></h1>	
				<?php endif; ?>
				<h4><?php do_action( 'woocommerce_archive_description' );?></h4>
			</div>
		</div>
	</div>
</section>
<section id="detail">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="woocommerce">
				<?php
					/**
					 * woocommerce_before_main_content hook.
					 *
					 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
					 * @hooked woocommerce_breadcrumb - 20
					 * @hooked WC_Structured_Data::generate_website_data() - 30
					 */
					//do_action( 'woocommerce_before_main_content' );
				?>

				<?php if ( have_posts() ) : ?>

				<?php
					/**
					 * woocommerce_before_shop_loop hook.
					 *
					 * @hooked wc_print_notices - 10
					 * @hooked woocommerce_result_count - 20
					 * @hooked woocommerce_catalog_ordering - 30
					 */
					do_action( 'woocommerce_before_shop_loop' );
				?>

				<?php woocommerce_product_loop_start(); ?>

				<?php woocommerce_product_subcategories(); ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						/**
						 * woocommerce_shop_loop hook.
						 *
						 * @hooked WC_Structured_Data::generate_product_data() - 10
						 */
						do_action( 'woocommerce_shop_loop' );
					?>

					<?php wc_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>

				<?php woocommerce_product_loop_end(); ?>

				<?php
					/**
					 * woocommerce_after_shop_loop hook.
					 *
					 * @hooked woocommerce_pagination - 10
					 */
					do_action( 'woocommerce_after_shop_loop' );
				?>

				<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

				<?php
					/**
					 * woocommerce_no_products_found hook.
					 *
					 * @hooked wc_no_products_found - 10
					 */
					do_action( 'woocommerce_no_products_found' );
				?>

				<?php endif; ?>

				<?php
					/**
					 * woocommerce_after_main_content hook.
					 *
					 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
					 */
					//do_action( 'woocommerce_after_main_content' );
				?>

				</div>
			</div><!--col-md-12-->
		</div>
	</div>
</section>
<?php get_footer( 'shop' ); ?>
