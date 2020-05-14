<?php
/**
 * Registers two widget areas.
 *
 * @since classify 1.0
 *
 * @return void
 */
function classify_widgets_init() {	
	register_sidebar( array(
		'name'          => esc_html__( 'Pages Sidebar', 'classify' ),
		'id'            => 'pages',
		'description'   => esc_html__( 'Appears on posts and pages in the sidebar.', 'classify' ),
		'before_widget' => '<div class="widget clearfix">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="widget__heading"><h4 class="inner-heading">',
		'after_title'   => '</h4></div>',
	) ); 
	
   	
	register_sidebar( array(
		'name'          => esc_html__( 'Single Ad Sidebar', 'classify' ),
		'id'            => 'single',
		'description'   => esc_html__( 'Appears on Ad Details Sidebar.', 'classify' ),
		'before_widget' => '<div class="widget clearfix">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="widget__heading"><h4 class="inner-heading">',
		'after_title'   => '</h4></div>',
	) );
	register_sidebar( array(
		'name'          => __( 'Listing page Widget Area', 'classify' ),
		'id'            => 'listing',
		'description'   => __( 'Appears on posts and pages in the sidebar.', 'classify' ),
		'before_widget' => '<div class="col-lg-3 col-md-4 col-sm-6"><div class="widget clearfix">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<div class="widget__heading"><h4 class="inner-heading">',
		'after_title'   => '</h4></div>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Blog Sidebar', 'classify' ),
		'id'            => 'blog',
		'description'   => esc_html__( 'Appears on Blog sidebar.', 'classify' ),
		'before_widget' => '<div class="widget clearfix">',
		'after_widget'  => '</div>',
		'before_title'  => '<div class="widget__heading"><h4 class="inner-heading">',
		'after_title'   => '</h4></div>',
	) );
	register_sidebar( array(
        'name'          => esc_html__( 'Forum Widget Area', 'classify' ),
        'id'            => 'forum',
        'description'   => esc_html__( 'Appears on posts and pages in the sidebar.', 'classify' ),
        'before_widget' => '<div class="col-lg-3 col-md-4 col-sm-6"><div class="widget clearfix">',
        'after_widget'  => '</div></div>',
        'before_title'  => '<div class="widget__heading"><h4 class="inner-heading">',
        'after_title'   => '</h4></div>',
    ) );
	register_sidebar( array(
		'name'          => __( 'Footer Widget ', 'classify' ),
		'id'            => 'footer',
		'description'   => __( 'Appears in the footer section of the site.', 'classify' ),
		'before_widget' => '<div class="col-lg-3 col-md-4 col-sm-6 matchheight"><div class="widget clearfix">',
		'after_widget'  => '</div></div>',
		'before_title'  => '<div class="widget__heading"><h4 class="inner-heading">',
		'after_title'   => '</h4></div>',
	) );

    
}