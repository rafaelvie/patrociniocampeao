<?php
/**
 * Enqueues scripts and styles for front end.
 *
 * @since classify 4.0
 *
 * @return void
 */
function classify_scripts_styles(){
	//Load Script
	wp_enqueue_script('jquery', get_template_directory_uri() . '/js/jquery.js', 'jquery', '', true);
	wp_enqueue_script('jquery-ui', get_template_directory_uri() . '/js/jquery-ui.min.js', 'jquery', '', true);
	wp_enqueue_script('bootstrap', get_template_directory_uri() . '/js/bootstrap.js', 'jquery', '', true);	
	wp_enqueue_script('owl.carousel.min', get_template_directory_uri() . '/js/owl.carousel.min.js', 'jquery', '', true);
	wp_enqueue_script('bootstrap-dropdownhover.min', get_template_directory_uri() . '/js/bootstrap-dropdownhover.min.js', 'jquery', '', true);
	wp_enqueue_script('select2.min', get_template_directory_uri() . '/js/select2.min.js', 'jquery', '', true);
	wp_enqueue_script('validator.min', get_template_directory_uri() . '/js/validator.min.js', 'jquery', '', true);
	wp_enqueue_script('classify', get_template_directory_uri() . '/js/classify.js', 'jquery', '', true);
	wp_enqueue_script('jquery.matchHeight', get_template_directory_uri() . '/js/jquery.matchHeight.js', 'jquery', '', true);
	
	if(is_rtl()){
		wp_enqueue_script('bootstrap-rtl', get_template_directory_uri() . '/js/bootstrap-rtl.js', 'jquery', '', true);
	}	
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ){
		wp_enqueue_script( 'comment-reply' );
	}
	// Add Open Sans and Bitter fonts, used in the main stylesheet.
	wp_enqueue_style( 'classify-fonts', classify_fonts_url(), array(), null );
	
	// Load google maps js
    global $redux_demo;
	$googleApiKey = $redux_demo['clasify_google_api'];	
	wp_enqueue_script( 'classify-google-maps', 'https://maps.googleapis.com/maps/api/js?key='.$googleApiKey.'&v=3.exp', array( 'jquery' ), '2014-07-18', true );
	wp_enqueue_script('modernizr.touch', get_template_directory_uri() . '/js/modernizr.touch.js', 'jquery', '', true);
	wp_enqueue_script('classify-map', get_template_directory_uri() . '/js/classify-map.js', 'jquery', '', true);
	
    if( is_page_template('template-submit-ads.php') || is_page_template('template-edit-post.php')){      
		wp_enqueue_script('getlocation-map-script', get_template_directory_uri() . '/js/getlocation-map-script.js', 'jquery', '', true);		
    }
    // Load Classify CSS
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array(), '1' );
	wp_enqueue_style('jquery-ui', 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css', array(), '1' );	
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.css', array(), '1' );
	wp_enqueue_style( 'owl.carousel', get_template_directory_uri() . '/css/owl.carousel.css', array(), '1' );
	wp_enqueue_style( 'owl.theme.default', get_template_directory_uri() . '/css/owl.theme.default.css', array(), '1' );
	wp_enqueue_style( 'bootstrap-dropdownhover', get_template_directory_uri() . '/css/bootstrap-dropdownhover.css', array(), '1' );	
    wp_enqueue_style( 'animate.min', get_template_directory_uri() . '/css/animate.min.css', array(), '1' );
    wp_enqueue_style( 'select2.min', get_template_directory_uri() . '/css/select2.min.css', array(), '1' );
	wp_enqueue_style( 'select2-bootstrap.min', get_template_directory_uri() . '/css/select2-bootstrap.min.css', array(), '1' );
	wp_enqueue_style( 'classify-map', get_template_directory_uri() . '/css/classify-map.css', array(), '1' ); 
    wp_enqueue_style( 'classify', get_template_directory_uri() . '/css/classify.css', array(), '1' );    
    wp_enqueue_style( 'responsive', get_template_directory_uri() . '/css/responsive.css', array(), '1' );
	
	if(is_rtl()){
		wp_enqueue_style( 'bootstrap-rtl', get_template_directory_uri() . '/css/bootstrap-rtl.css', array(), '1' );
	}

	if(is_admin_bar_showing()) echo "<style type=\"text/css\">.navbar-fixed-top { margin-top: 28px; } </style>";

}