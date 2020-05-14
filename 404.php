<?php
get_header(); 
?>
<section id="page-head">
	<div class="container">
		<div class="row col-md-12">
			<div class="page-heading">
				<h1><?php _e( '404 ERROR' ); ?></h1>
			</div>
		</div>
	</div>
</section><!--end main page heading-->
<section id="detail">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="page-content">					
					<h1 class="text-center"><?php _e( 'This is somewhat embarrassing, isn&rsquo;t it?', 'classify' ); ?></h1>
					<p class="text-center"><?php _e( 'It looks like nothing was found at this location.', 'classify' ); ?></p>
				</div>
			</div><!--col-md-8-->
		</div><!--row-->
	</div><!--container-->
</section><!--section detail-->
<?php get_footer(); ?>
