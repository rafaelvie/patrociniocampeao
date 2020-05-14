<?php
get_header();
?>
<?php 
global $post;
$user_ID = $post->post_author;
$authorName = get_the_author_meta('display_name', $user_ID );
if(empty($authorName)){
	$authorName = get_the_author_meta('user_nicename', $user_ID );
}
if(empty($authorName)){
	$authorName = get_the_author_meta('user_login', $user_ID );
}
$dateFormat = get_option( 'date_format' );
$postDate = get_the_date($dateFormat, $post->ID);
?>
<section class="page_title">
	<h2 class="text-uppercase text-center"><?php the_title(); ?></h2>
</section>
<main>
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-lg-8">
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<article class="blog_post">
					<?php if ( has_post_thumbnail() ){
					$imageurl = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
					$thumb_id = get_post_thumbnail_id($post->id);
					?>
					<div class="blog_post__image">
						<img class="img-responsive" src="<?php echo $imageurl[0]; ?>" alt="<?php the_title(); ?>">
					</div><!--blog_post__image-->
					<?php } ?>
					<div class="blog_post__content">
						<?php the_content(); ?>
					</div><!--blog_post__content-->
					<div class="blog_post_meta">
						<div class="blog_post_meta__author">
							<p>
								<strong><?php esc_html_e('Posted By', 'classify'); ?> :</strong>
								<span>
								<?php echo $authorName; ?> <?php esc_html_e('On', 'classify'); ?> <?php echo $postDate; ?>
								</span>
							</p>
							<?php 
							$blog_category = get_the_terms( $post->ID, 'blog_category' );
							if(!empty($blog_category)){
							?>
							<p><strong class=""><?php esc_html_e( 'Categories', 'classify' ); ?> :</strong> 
								<?php 
								foreach($blog_category as $category){
									?>
									<a class="btn btn-default btn-xs" href="<?php echo get_category_link( $category->term_id )?>">
										<?php echo $category->name; ?>
									</a>
									<?php
								}
								?>
							</p>
							<?php } ?>
							<p><strong><?php esc_html_e('Tags', 'classify'); ?>:</strong><?php the_tags('','',''); ?></p>
						</div><!--blog_post_meta__author-->
					</div><!--blog_post_meta-->
				</article>
				<?php endwhile; endif; ?>
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
