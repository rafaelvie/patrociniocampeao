<?php
/**
 * Register theme support for languages, menus, post-thumbnails, post-formats etc.
 *
 * @package WordPress
 * @subpackage classify
 * @since classify 2.0
 */

if ( ! function_exists( 'classify_theme_support' ) ) :
function classify_theme_support() {	
	add_theme_support( 'woocommerce' );
	add_theme_support( 'custom-header' );
	add_theme_support( 'custom-background' );
	add_theme_support( 'menus' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );	
		
	// Add Classify core files
	require get_template_directory() . '/assets/menu.php';
	require get_template_directory() . '/inc/page_meta.php';	
	require get_template_directory() . '/inc/post_meta.php';
	require get_template_directory() . '/inc/classify-search-functions.php';	
	require get_template_directory() . '/inc/classify-plans-functions.php';	
	require get_template_directory() . '/inc/wp_bootstrap_navwalker.php';	
	require get_template_directory() . '/inc/wp_bootstrap_pagination.php';	
	require get_template_directory() . '/inc/widgets/classify_categories_widget.php';	
	require get_template_directory() . '/inc/widgets/classify_recent_ads_widget.php';	
	
	// Add Colors
	require get_template_directory() . '/inc/colors.php';
	
	//Sets up the content width value based on the theme's design.
	if( ! isset( $content_width )){
		$content_width = 1200;
	}
	if ( version_compare( $GLOBALS['wp_version'], '4.3-alpha', '<' ) ){
		require get_template_directory() . '/inc/back-compat.php';
	}
	/*
	* This theme styles the visual editor to resemble the theme style,
	* specifically font, colors, icons, and column width.
	*/
	add_editor_style( array( 'css/editor-style.css', 'fonts/genericons.css', classify_fonts_url()));
	
	// This theme uses its own gallery styles.
	add_filter( 'use_default_gallery_style', '__return_false' );
	
	// Disable Disqus commehts on woocommerce product //
    add_filter( 'woocommerce_product_tabs', 'disqus_override_tabs', 98);
	
	// Custom admin scripts
    add_action('admin_enqueue_scripts', 'classify_admin_scripts' );
	
	// Author add new contact details
    add_filter('user_contactmethods','classify_author_new_contact',10,1);
	
	// Lost Password and Login Error
    add_action( 'wp_login_failed', 'classify_front_end_login_fail' );  // hook failed login
	
	// Load scripts and styles
    add_action( 'wp_enqueue_scripts', 'classify_scripts_styles' );
		
	// Save custom posts
    add_action('save_post', 'classify_save_post_meta', 1, 2); // save the custom fields
	
	// Category new fields (the form)
    add_filter('add_category_form', 'classify_my_category_fields');
    add_filter('edit_category_form', 'classify_my_category_fields');

    // Update category fields
    add_action( 'edited_category', 'classify_update_my_category_fields', 10, 2 );  
    add_action( 'create_category', 'classify_update_my_category_fields', 10, 2 );

    //Include the TGM_Plugin_Activation class.    
	require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';
    add_action( 'tgmpa_register', 'classify_register_required_plugins' );

    // Google analitycs code
    add_action( 'wp_enqueue_scripts', 'classify_google_analityc_code' );

    // Enqueue main font
    add_action( 'wp_enqueue_scripts', 'classify_main_font' );

    // Enqueue main font
    add_action( 'wp_enqueue_scripts', 'classify_second_font_armata' );

    // Track views
    add_action( 'wp_head', 'classify_track_post_views');

    // Theme page titles
    add_filter( 'wp_title', 'classify_wp_title', 10, 2 );


    // classify sidebars spot
    add_action( 'widgets_init', 'classify_widgets_init' );

    // classify body class
    add_filter( 'body_class', 'classify_body_class' );

    // classify content width
    add_action( 'template_redirect', 'classify_content_width' );

    // classify customize register
    add_action( 'customize_register', 'classify_customize_register' );

    // classify customize preview
    add_action( 'customize_preview_init', 'classify_customize_preview_js' );
	
	//OnClick Demo Importer
	add_filter( 'pt-ocdi/regenerate_thumbnails_in_content_import', '__return_false' );
	add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );

}

add_action( 'after_setup_theme', 'classify_theme_support' );
endif;
?>