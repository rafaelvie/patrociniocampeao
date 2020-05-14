<?php
    /**
     * ReduxFramework Sample Config File
     * For full documentation, please visit: http://docs.reduxframework.com/
     */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }


    // This is your option name where all the Redux data is stored.
    $opt_name = "redux_demo";

    // This line is only for altering the demo. Can be easily removed.
    $opt_name = apply_filters( 'redux_demo/opt_name', $opt_name );

    /*
     *
     * --> Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
     *
     */

    $sampleHTML = '';
    if ( file_exists( dirname( __FILE__ ) . '/info-html.html' ) ) {
        Redux_Functions::initWpFilesystem();

        global $wp_filesystem;

        $sampleHTML = $wp_filesystem->get_contents( dirname( __FILE__ ) . '/info-html.html' );
    }

    // Background Patterns Reader
    $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
    $sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
    $sample_patterns      = array();
    
    if ( is_dir( $sample_patterns_path ) ) {

        if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) {
            $sample_patterns = array();

            while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

                if ( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
                    $name              = explode( '.', $sample_patterns_file );
                    $name              = str_replace( '.' . end( $name ), '', $sample_patterns_file );
                    $sample_patterns[] = array(
                        'alt' => $name,
                        'img' => $sample_patterns_url . $sample_patterns_file
                    );
                }
            }
        }
    }

    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    $theme = wp_get_theme(); // For use with some settings. Not necessary.

    $args = array(
        // TYPICAL -> Change these values as you need/desire
        'opt_name'             => $opt_name,
        // This is where your data is stored in the database and also becomes your global variable name.
        'display_name'         => $theme->get( 'Name' ),
        // Name that appears at the top of your panel
        'display_version'      => $theme->get( 'Version' ),
        // Version that appears at the top of your panel
        'menu_type'            => 'menu',
        //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu'       => true,
        // Show the sections below the admin menu item or not
        'menu_title'           => __( 'Classify Options', 'classify' ),
        'page_title'           => __( 'Classify Options', 'classify' ),
        // You will need to generate a Google API key to use this feature.
        // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
        'google_api_key'       => '',
        // Set it you want google fonts to update weekly. A google_api_key value is required.
        'google_update_weekly' => false,
        // Must be defined to add google fonts to the typography module
        'async_typography'     => true,
        // Use a asynchronous font on the front end or font string
        //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
        'admin_bar'            => true,
        // Show the panel pages on the admin bar
        'admin_bar_icon'       => 'dashicons-portfolio',
        // Choose an icon for the admin bar menu
        'admin_bar_priority'   => 50,
        // Choose an priority for the admin bar menu
        'global_variable'      => '',
        // Set a different name for your global variable other than the opt_name
        'dev_mode'             => false,
        // Show the time the page took to load, etc
        'update_notice'        => false,
        // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
        'customizer'           => true,
        // Enable basic customizer support
        //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
        //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

        // OPTIONAL -> Give you extra features
        'page_priority'        => null,
        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        'page_parent'          => 'themes.php',
        // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        'page_permissions'     => 'manage_options',
        // Permissions needed to access the options panel.
        'menu_icon'            => '',
        // Specify a custom URL to an icon
        'last_tab'             => '',
        // Force your panel to always open to a specific tab (by id)
        'page_icon'            => 'icon-themes',
        // Icon displayed in the admin panel next to your menu_title
        'page_slug'            => '',
        // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
        'save_defaults'        => true,
        // On load save the defaults to DB before user clicks save or not
        'default_show'         => false,
        // If true, shows the default value next to each field that is not the default value.
        'default_mark'         => '',
        // What to print by the field's title if the value shown is default. Suggested: *
        'show_import_export'   => true,
        // Shows the Import/Export panel when not used as a field.

        // CAREFUL -> These options are for advanced use only
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
        'output_tag'           => true,
        // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
        // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

        // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
        'database'             => '',
        // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
        'use_cdn'              => true,
        // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

        // HINTS
        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'red',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'mouseover',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click mouseleave',
                ),
            ),
        )
    );

    // ADMIN BAR LINKS -> Setup custom links in the admin bar menu as external items.
    $args['admin_bar_links'][] = array(
        'id'    => 'redux-docs',
        'href'  => 'http://joinwebs.co.uk/docs/classify',
        'title' => __( 'Documentation', 'classify' ),
    );

    $args['admin_bar_links'][] = array(
        //'id'    => 'redux-support',
        'href'  => 'https://joinwebs.com/support/',
        'title' => __( 'Support', 'classify' ),
    );

    // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
    $args['share_icons'][] = array(
        'url'   => 'https://www.youtube.com/user/JoinWebs',
        'title' => 'Visit us on YouTube',
        'icon'  => 'el el-youtube'
        //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
    );
    $args['share_icons'][] = array(
        'url'   => 'https://www.facebook.com/pages/joinwebs',
        'title' => 'Like us on Facebook',
        'icon'  => 'el el-facebook'
    );
    $args['share_icons'][] = array(
        'url'   => 'http://twitter.com/joinwebs',
        'title' => 'Follow us on Twitter',
        'icon'  => 'el el-twitter'
    );
    $args['share_icons'][] = array(
        'url'   => 'http://www.linkedin.com/company/joinwebs',
        'title' => 'Find us on LinkedIn',
        'icon'  => 'el el-linkedin'
    );

    // Panel Intro text -> before the form
    if ( ! isset( $args['global_variable'] ) || $args['global_variable'] !== false ) {
        if ( ! empty( $args['global_variable'] ) ) {
            $v = $args['global_variable'];
        } else {
            $v = str_replace( '-', '_', $args['opt_name'] );
        }
        $args['intro_text'] = sprintf( __( '<p>Thanks for using Classify Classified Ads WordPress Theme, You are always welcome for support and help.</p>', 'classify' ), $v );
    } else {
        $args['intro_text'] = __( '<p>Thanks for using Classify Classified Ads WordPress Theme, You are always welcome for support and help.</p>', 'classify' );
    }

    // Add content after the form.
    $args['footer_text'] = __( '<p>We have Build Classify with ReduxFramework , If you have any problem with our option you can contact us any time on support.</p>', 'classify' );

    Redux::setArgs( $opt_name, $args );

    /*
     * ---> END ARGUMENTS
     */


    /*
     * ---> START HELP TABS
     */

    $tabs = array(
        array(
            'id'      => 'redux-help-tab-1',
            'title'   => __( 'Theme Information 1', 'classify' ),
            'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'classify' )
        ),
        array(
            'id'      => 'redux-help-tab-2',
            'title'   => __( 'Theme Information 2', 'classify' ),
            'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'classify' )
        )
    );
    Redux::setHelpTab( $opt_name, $tabs );

    // Set the help sidebar
    $content = __( '<p>This is the sidebar content, HTML is allowed.</p>', 'classify' );
    Redux::setHelpSidebar( $opt_name, $content );


    /*
     * <--- END HELP TABS
     */


    /*
     *
     * ---> START SECTIONS
     *
     */

    /*

        As of Redux 3.5+, there is an extensive API. This API can be used in a mix/match mode allowing for


     */

    // -> START General Settings
	
    Redux::setSection( $opt_name, array(
        'title'            => __( 'General Settings', 'classify' ),
        'id'               => 'general-settings',        
        'customizer_width' => '500px',
		'icon'             => 'el el-home',
        'desc'             => __( 'These are really basic fields', 'classify' ),
        'fields'           => array(            
            array(
				'id'=>'logo',
				'type' => 'media', 
				'url'=> true,
				'title' => __('Logo', 'classify'),
				'compiler' => 'true',
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Upload your logo.Recommended (Height:40px, Width:200px)', 'classify'),
				'subtitle' => __('Logo Image', 'classify'),
				'default'=>array('url'=>''),
			),
			array(
				'id'=>'favicon',
				'type' => 'media', 
				'url'=> true,
				'title' => __('Favicon', 'classify'),
				'compiler' => 'true',
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Upload your favicon.', 'classify'),
				'subtitle' => __('Favicon', 'classify'),
				'default'=>array('url'=>''),
			),
			array(
				'id'=>'measure-system',
				'type' => 'radio',
				'title' => __('Measurement system', 'classify'), 
				'subtitle' => __('Measurement', 'classify'),
				'desc' => __('Select Measurement', 'classify'),
				'options' => array('mi' => 'Miles', 'km' => 'Kilometers'),//Must provide key => value pairs for radio options
				'default' => 'mi'
			),
			array(
				'id'=>'max_range',
				'type' => 'text',
				'title' => __('Maxim Range', 'classify'),
				'subtitle' => __('Range', 'classify'),
				'desc' => __('You can add the max geolocation range (default: 1000', 'classify'),
				'default' => '1000'
			),
			array(
				'id'=>'tags_limit',
				'type' => 'text',
				'title' => __('Number of tags in tag Cloud widget', 'classify'),
				'subtitle' => __('Cloud widget', 'classify'),
				'desc' => __('Put here a number. Example "16"', 'classify'),
				'default' => '15'
			),
			array(
				'id'=>'google_id',
				'type' => 'text',
				'title' => __('Google Analytics Domain ID', 'classify'),
				'subtitle' => __('Google Analytics', 'classify'),
				'desc' => __('Get analytics on your site. Enter Google Analytics Domain ID (ex: UA-123456-1)', 'classify'),
				'default' => ''
			),
			array(
				'id'=>'clasify_google_api',
				'type' => 'text',
				'title' => __('Google API Key', 'classify'),
				'subtitle' => __('Google API Key', 'classify'),
				'desc' => __('Put Google API Key here to run Google MAP. If you dont know how to get API key Please Visit  <a href="http://www.tthemes.com/get-google-api-key/" target="_blank">Google API Key</a>', 'classify'),
				'default' => ''
			),
			array(
				'id'=>'footer_copyright',
				'type' => 'text',
				'title' => __('Footer Copyright Text', 'classify'),
				'subtitle' => __('Copyright', 'classify'),
				'desc' => __('You can add text and HTML in here.', 'classify'),
				'default' => ''
			),
			array(
				'id' => 'classify_backtotop',
				'type' => 'switch',
				'title' => __('Back to Top', 'classify'),
				'subtitle' => __('Turn On/OFF back to top button.', 'classify'),
				'default' => 1,
            ),
			array(
				'id' => 'classify_footer_widgets',
				'type' => 'switch',
				'title' => __('Footer Widgets', 'classify'),
				'subtitle' => __('Turn On/OFF footer widgets area.', 'classify'),
				'default' => 1,
            ),
			array(
				'id'=>'classify_footer_logo',
				'type' => 'media', 
				'url'=> true,
				'title' => __('Email Footer Logo', 'classify'),
				'compiler' => 'true',
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Upload your logo.Recommended (Height:40px, Width:200px)', 'classify'),
				'subtitle' => __('Footer Logo Image', 'classify'),
				'default'=>array('url'=>''),
			),
			array(
				'id'=>'map-style',
				'type' => 'textarea',
				'title' => __('Map Styles', 'classify'), 
				'subtitle' => __('Check <a href="http://snazzymaps.com/" target="_blank">snazzymaps.com</a> for a list of nice google map styles.', 'classify'),
				'desc' => __('Ad here your google map style.', 'classify'),
				'validate' => 'html_custom',
				'default' => '',
				'allowed_html' => array(
					'a' => array(
						'href' => array(),
						'title' => array()
					),
					'br' => array(),
					'em' => array(),
					'strong' => array()
					)
			),
            
            
        )
    ) );
	// -> START Layout Manager
	 Redux::setSection( $opt_name, array(
        'title'            => __( 'Layout Manager', 'classify' ),
        'id'               => 'layoutmanager',
        'desc'             => __( 'Home Page and Landing Page Manager', 'classify' ),
        'customizer_width' => '600px',
        'icon'             => 'el el-align-justify'
    ) );
	// -> START Layout Utilities
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Layout Utilities', 'classify' ),
        'id'               => 'classify_design_settings',
		'subsection' => true,
		'desc'  => __( 'From This section you can select Layout Design.', 'classify' ),
        'customizer_width' => '600px',
        'icon'             => 'el el-brush',
		'fields'     => array(	
			array(
				'id'=>'layout-version',
				'type' => 'radio',
				'title' => __('Layout', 'classify'), 
				'subtitle' => __('Select Layout', 'classify'),
				'desc' => __('You can use Boxed or Wide Layout', 'classify'),
				'options' => array('wide' => 'Wide', 'boxed' => 'Boxed'),//Must provide key => value pairs for radio options
				'default' => 'wide'
			),
			array(
				'id'=>'classify_cat_icon_img',
				'type' => 'radio',
				'title' => __('Categories Icons', 'classify'), 
				'subtitle' => __('Select Type for categories Icon', 'classify'),
				'desc' => __('You want to show categories icons from font awsome or you have your own images icon?', 'classify'),
				'options' => array('icon' => 'Font Awesome Icons', 'img' => 'Custom Images Icon'),//Must provide key => value pairs for radio options
				'default' => 'icon'
			),
			array(
				'id' => 'hide-map',
				'type' => 'switch',
				'title' => __('Map on single category', 'classify'),
				'subtitle' => __('Map On/OFF', 'classify'),
				'desc' => __('Turn OFF map from category page.', 'classify'),
				'default' => 1,
            ),
			array(
				'id' => 'classify_map_on_locations_page',
				'type' => 'switch',
				'title' => __('Map on Locations Page', 'classify'),
				'subtitle' => __('Map On/OFF', 'classify'),
				'desc' => __('Turn On/OFF Map from locations page', 'classify'),
				'default' => 1,
            ),
			array(
				'id' => 'classify_map_on_search_page',
				'type' => 'switch',
				'title' => __('Map on Search Result Page', 'classify'),
				'subtitle' => __('Map On/OFF', 'classify'),
				'desc' => __('Turn On/OFF Map from Search Result page', 'classify'),
				'default' => 1,
            ),
			array(
				'id' => 'classify_adv_search_cat',
				'type' => 'switch',
				'title' => __('Advanced Search on category page', 'classify'),
				'subtitle' => __('Advanced Search', 'classify'),
				'default' => 1,
            ),
			array(
				'id' => 'classify_cats_ads_count',
				'type' => 'switch',
				'title' => __('Ads Count display with categories', 'classify'),
				'subtitle' => __('On/OFF', 'classify'),
				'desc' => __('Turn On/OFF ads count with categories.', 'classify'),
				'default' => 1,
            ),
			array(
				'id'=>'home-cat-counter',
				'type' => 'select',
				'title' => __('How many Categories on homepage?', 'classify'),
				'subtitle' => __('Categories on homepage', 'classify'),
				'desc' => __('Select how many categories you want to display on homepage.', 'classify'),
				'options' => array('4' => '4', '8' => '8', '12' => '12' , '16' => '16', '20' => '20', '24' => '24', '28' => '28', '32' => '32', '36' => '36'),
				'default' => '8'
			),
			array(
				'id'=>'home-ads-counter',
				'type' => 'select',
				'title' => __('How many ads on homepage?', 'classify'),
				'subtitle' => __('Ads on homepage', 'classify'),
				'desc' => __('Ads on homepage', 'classify'),
				'options' => array('4' => '4','8' => '8','12' => '12', '16' => '16', '20' => '20', '24' => '24', '28' => '28', '32' => '32'),
				'default' => '12'
			),
			array(
				'id'=>'home-ads-view',
				'type' => 'select',
				'title' => __('Select Ads view type', 'classify'),
				'subtitle' => __('Ads view', 'classify'),
				'desc' => __('Select Ads view type', 'classify'),
				'options' => array('grid' => 'Grid view', 'list' => 'List view'),
				'default' => 'grid'
			), 
			array(
				'id'=>'classify_location_shown_by',
				'type' => 'select',
				'title' => __('Select Locations Shown by', 'classify'),
				'subtitle' => __('Location Shown by', 'classify'),
				'desc' => __('Location Section Shown by City or States or Country?', 'classify'),
				'options' => array('post_location' => 'Country', 'post_state' => 'States', 'post_city' =>'City'),
				'default' => 'post_city'
			),
		)
    ) );
	// -> START Home Layout Manager
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Home Search', 'classify' ),
        'id'               => 'classify_home_search',
		'subsection' => true,
		'desc'  => __( 'From here you can manage homepage search bar.', 'classify' ),
        'customizer_width' => '600px',
        'icon'             => 'el el-search',
		'fields'     => array(
			array(
				'id' => 'classify_search_location',
				'type' => 'switch',
				'title' => __('Location from search bar', 'classify'),
				'subtitle' => __('Locations', 'classify'),
				'desc' => __('Turn On/OFF locations from searchbar.', 'classify'),
				'default' => true,
            ),
			array(
				'id' => 'classify_search_cats',
				'type' => 'switch',
				'title' => __('Categories from search bar', 'classify'),
				'subtitle' => __('Categories', 'classify'),
				'desc' => __('Turn On/OFF Categories from searchbar.', 'classify'),
				'default' => true,
            ),
			array(
				'id' => 'classify_search_range_slider',
				'type' => 'switch',
				'title' => __('Range Slider from search bar', 'classify'),
				'subtitle' => __('Range Slider', 'classify'),
				'desc' => __('Turn On/OFF Range Slider from searchbar.', 'classify'),
				'default' => true,
            ),
		)
    ) );
	// -> START Home Layout Manager
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Home Layout Manager', 'classify' ),
        'id'               => 'homelayoutmanager',
		'subsection' => true,
		'desc'  => __( 'These Settings will work only on HomePage Version 1, If you want to disable any section just drag to Disable section.', 'classify' ),
        'customizer_width' => '600px',
        'icon'             => 'el el-home-alt',
		'fields'     => array(
			array(
                'id'       => 'classify_homepage_layout',
                'type'     => 'sorter',
                'title'    => 'Homepage Layout Manager',
                'desc'     => __( 'Organize how you want the layout to appear on the homepage', 'classify' ),
                'compiler' => 'true',
                'options'  => array(
                    'disabled' => array(
                        'customads'   => 'Banner ads',
                        'googlemap'   => 'Google MAP',
                        'contenthtml'   => 'Content WP Editor',
                        'listwithsidebar'   => 'Listing with sidebar',
						'premiumsadsgrid'   => 'Premium Ads Grid',  
                        'listfullwidth'   => 'Listing Fullwith',
                        'woocommerce'   => 'WooCommerce Shop',
						'calloutv2'   => 'Callout Parallax',
                    ),
                    'enabled'  => array(
                        'layerslider' => 'LayerSlider',
                        'searchbar' => 'Search Bar',
                        'premiumslider'   => 'Premium Ads Slider', 
                        'categories'   => 'Categories',
                        'callout'   => 'Callout',
                        'location'   => 'Location',
                        'advertisement'   => 'Advertisement',
                    ),
                ),
            ),
		)
    ) );
	Redux::setSection( $opt_name, array(
        'title'            => __( 'Ads Manager', 'classify' ),
        'id'               => 'classify_ads_manager',        
        'customizer_width' => '500px',
		'icon'             => 'el el-signal',
        'desc'             => __( 'You can manage Ads from here', 'classify' ),
        'fields'           => array( 
		)
    ) );
	// -> START Premium Ads
	Redux::setSection( $opt_name, array(
        'title'            => __( 'Premium Ads', 'classify' ),
        'id'               => 'classify_premium_ads_manager',        
        'customizer_width' => '500px',
		'subsection' 	   => true,
		'icon'             => 'el el-usd',
        'desc'             => __( 'You can manage Premium / Featured Ads from here', 'classify' ),
        'fields'           => array(
			array(
				'id' => 'featured-options-on',
				'type' => 'switch',
				'title' => __('Premium Ads', 'classify'),
				'subtitle' => __('Premium Ads On/OFF', 'classify'),
				'default' => 1,
            ),			
			array(
				'id' => 'hide-fslider',
				'type' => 'switch',
				'title' => __('Premium / Featured Ads Slider', 'classify'),
				'subtitle' => __('Featured Slider', 'classify'),
				'default' => 1,
            ),			
		   array(
				'id' => 'featured-options-cat',
				'type' => 'switch',
				'title' => __('Featured Ads on category related to category', 'classify'),
				'subtitle' => __('Featured Ads', 'classify'),
				'default' => 0,
            ),
			array(
				'id' => 'classify_featured_caton',
				'type' => 'switch',
				'title' => __('Featured Category On/OFF', 'classify'),
				'subtitle' => __('Ads Shown From Featured Category.', 'classify'),
				'desc' => __('If You dont want to use Featured Category then Turn OFF This Options', 'classify'),
				'default' => 0,
            ),
			array(
				'id'=>'featured_cat',
				'type' => 'select',
				'data' => 'categories',
				'multi'    => true,	
				'args' => array(
					'orderby' => 'name',
					'hide_empty' => 0,
					'parent' => 0,
				),
				'default' => 1,
				'title' => __('Featured Category', 'classify'),
				'subtitle' => __('Featured Category', 'classify'),
				'desc' => __('Put here any category name same as there in categories for featured ads(It will work if featured ads disable)', 'classify'),
			),
			array(
				'id'=>'classify_premium_ads_counter',
				'type' => 'text',
				'title' => __('How many Premium Ads on homepage?', 'classify'),
				'subtitle' => __('Premium Ads on homepage', 'classify'),
				'desc' => __('How many Premium Ads you want to show in Premium Slider', 'classify'),
				'default' => '9'
			),
		)
    ) );
	// -> START Regular Ads
	Redux::setSection( $opt_name, array(
        'title'            => __( 'Regular Ads', 'classify' ),
        'id'               => 'classify_regular_ads_manager',        
        'customizer_width' => '500px',
		'subsection' 	   => true,
		'icon'             => 'el el-usd',
        'desc'             => __( 'You can manage Regular Ads from here', 'classify' ),
        'fields'           => array(
			array(
				'id' => 'regular-free-ads',
				'type' => 'switch',
				'title' => __('Regular ad posting', 'classify'),
				'subtitle' => __('On/OFF Regular ad posting', 'classify'),
				'default' => 1,
            ),
			array(
				'id' => 'classify_regular_limit_on',
				'type' => 'switch',
				'title' => __('Regular Ads Limit', 'classify'),
				'subtitle' => __('On/OFF Regular ad posting limit', 'classify'),
				'desc' => __('If you will turn on this limit then you must need to put a number below', 'classify'),
				'default' => false,
            ),
			array(
				'id' => 'classify_regular_count',
				'type' => 'text',
				'title' => __('Regular Ads Count', 'classify'),
				'subtitle' => __('How many free ads user can post', 'classify'),
				'desc' => __('Put a number, how many free ads user can post.', 'classify'),
				'default' => '5',
            ),
			array(
				'id'=>'ad_expiry',
				'type' => 'select',
				'title' => __('Regular Ads Expiry', 'classify'), 
				'subtitle' => __('Ads Expiry', 'classify'),
				'desc' => __('Select Ads Expiry', 'classify'),
				'options' => array('7' => 'One week', '30' => 'One Month', '60' => 'Two Months', '90' => 'Three Months', '120' => 'Four Months', '150' => 'Five Months', '180' => 'Six Month', '365' => 'One Year', '36500' => 'Life Time'),//Must provide key => value pairs for radio options
				'default' => '36500'
			),
		)
    ) );
	// -> START Home settings
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Single Ad', 'classify' ),
        'id'               => 'post-ads',
		'icon'             => 'el el-pencil-alt',
        'customizer_width' => '500px',
        'desc'             => __('All settings related to single Ad Page.', 'classify' ),
        'fields'           => array(
			array(
				'id' => 'post-options-on',
				'type' => 'switch',
				'title' => __('Post moderation', 'classify'),
				'subtitle' => __('Moderation', 'classify'),
				'desc' => __('If you will turn OFF post moderation, then new ad wil be goes on public status.', 'classify'),
				'default' => 1,
            ),
			array(
				'id' => 'post-options-edit-on',
				'type' => 'switch',
				'title' => __('Post moderation On every edit post', 'classify'),
				'subtitle' => __('Moderation edit post', 'classify'),
				'desc' => __('If you will turn off Moderation edit post then every ad when it will be edit then goes to publish.', 'classify'),
				'default' => 1,
			),
			array(
				'id' => 'hide-rads',
				'type' => 'switch',
				'title' => __('Related Ads on Single Post', 'classify'),
				'subtitle' => __('Related Ads', 'classify'),
				'desc' => __('If you dont want to display related ads on single ad then you need to turn off this option.', 'classify'),
				'default' => 1,
			),
			array(
				'id' => 'author-msg-box-off',
				'type' => 'switch',
				'title' => __('Author Message Box On/OFF', 'classify'),
				'subtitle' => __('Author Message box on ad detail page', 'classify'),
				'desc' => __('If you dont want to display author Message box on ad detail page then turn off this option.', 'classify'),
				'default' => 1,
            ),
			array(
				'id' => 'classify_comments_area',
				'type' => 'switch',
				'title' => __('Comments area on single Ad On/OFF', 'classify'),
				'subtitle' => __('Comments area on single Ad page', 'classify'),
				'desc' => __('If you dont want to display Comments on ad detail page then turn off this option.', 'classify'),
				'default' => false,
            ),
			array(
				'id' => 'classify_price_section',
				'type' => 'switch',
				'title' => __('Price section', 'classify'),
				'subtitle' => __('Turn On/OFF Ads price', 'classify'),
				'desc' => __('If you dont want to use price input then just turn off this option.', 'classify'),
				'default' => 1,
            ),
			array(
				'id' => 'classify_ads_type',
				'type' => 'switch',
				'title' => __('Ads Type', 'classify'),
				'subtitle' => __('Turn On/OFF Ads Type', 'classify'),
				'desc' => __('If you dont want to use ads type then turn off this option.', 'classify'),
				'default' => 1,
            ),
			array(
				'id' => 'classify_ad_condition',
				'type' => 'switch',
				'title' => __('Item Condition', 'classify'),
				'subtitle' => __('Turn On/OFF Item Condition from Ads Post', 'classify'),
				'desc' => __('If You dont want to use Item Condition at Submit Page Then Turn OFF this Option.', 'classify'),
				'default' => 1,
            ),
			array(
				'id' => 'classify_post_phone',
				'type' => 'switch',
				'title' => __('Asking Phone Number on Post New Ads', 'classify'),
				'subtitle' => __('Phone number.', 'classify'),
				'desc' => __('If you dont want to ask phone number then just Turn OFF this.', 'classify'),
				'default' => 1,
            ),
			array(
				'id' => 'classify-google-lat-long',
				'type' => 'switch',
				'title' => __('Latitude and Longitude', 'classify'),
				'subtitle' => __('Turn On/OFF Latitude and Longitude from Ads Post', 'classify'),
				'desc' => __('If You dont want user put Latitude and Longitude while posting ads then just turn OFF this option.', 'classify'),
				'default' => 1,
            ),
			array(
				'id' => 'classify-google-map-adpost',
				'type' => 'switch',
				'title' => __('Google MAP on Post Ads', 'classify'),
				'subtitle' => __('Turn On/OFF Google MAP from Ads Post', 'classify'),
				'desc' => __('If You want to hide Google MAP from Submit Ads Page And Single Ads Page Then Turn OFF this Option.', 'classify'),
				'default' => 1,
            ),	
			array(
				'id' => 'classify_post_state',
				'type' => 'switch',
				'title' => __('Location States dropdown', 'classify'),
				'subtitle' => __('Turn On/OFF', 'classify'),
				'subtitle' => __('Turn OFF location states dropdown.', 'classify'),
				'default' => 1,
            ),
			array(
				'id' => 'classify_post_city',
				'type' => 'switch',
				'title' => __('Location Cities dropdown', 'classify'),
				'subtitle' => __('Turn On/OFF', 'classify'),
				'subtitle' => __('Turn OFF location Cities dropdown.', 'classify'),
				'default' => 1,
            ),
			array(
				'id' => 'classify_video_postads',
				'type' => 'switch',
				'title' => __('Video Box on Post Ads', 'classify'),
				'subtitle' => __('Turn On/OFF Video Box on Post Ads', 'classify'),
				'desc' => __('If you dont want to allow users to add video iframe or link in ads then just turn off this option', 'classify'),
				'default' => 1,
            ),			
			array(
				'id'=>'classify_multi_currency',
				'type' => 'button_set',
				'title' => __('Select Currecny', 'classify'),
				'subtitle' => __('Ads Posts', 'classify'),
				'options' => array('multi' => 'Multi Currecny', 'single' => 'Single Currecny'),
				'desc' => __('If you want to run your website only in one country then just select Single Currency. If you will select Multi Currecny then On Submit Ad Page there will be a dropdown from where user can select currecny tag.', 'classify'),
				'default' =>'multi',
			),
			array(
				'id'=>'classify_multi_currency_default',
				'type' => 'select',
				'title' => __('Currency Tag', 'classify'),
				'subtitle' => __('Currency Tag', 'classify'),
				'desc' => __('Select default selected currency in dropdown', 'classify'),
				'options' => array(
					'USD' => 'US Dollar', 
					'CAD' => 'Canadian Dollar',
					'EUR' => 'Euro',
					'AED' =>'United Arab Emirates Dirham',
					'AFN' => 'Afghan Afghani',
					'ALL' => 'Albanian Lek',
					'AMD' => 'Armenian Dram',
					'ARS' => 'Argentine Peso',
					'AUD' => 'Australian Dollar',
					'AZN' => 'Azerbaijani Manat',
					'BDT' => 'Bangladeshi Taka',
					'BGN' => 'Bulgarian Lev',
					'BHD' => 'Bahraini Dinar',
					'BND' => 'Brunei Dollar',
					'BOB' => 'Bolivian Boliviano',
					'BRL' => 'Brazilian Real',
					'BWP' => 'Botswanan Pula',
					'BYN' => 'Belarusian Ruble',
					'BZD' => 'Belize Dollar',
					'CHF' => 'Swiss Franc',
					'CLP' => 'Chilean Peso',
					'CNY' => 'Chinese Yuan',
					'COP' => 'Colombian Peso',
					'CRC' => 'Costa Rican Colón',
					'CVE' => 'Cape Verdean Escudo',
					'CZK' => 'Czech Republic Koruna',
					'DJF' => 'Djiboutian Franc',
					'DKK' => 'Danish Krone',
					'DOP' => 'Dominican Peso',
					'DZD' => 'Algerian Dinar',
					'EGP' => 'Egyptian Pound',
					'ERN' => 'Eritrean Nakfa',
					'ETB' => 'Ethiopian Birr',
					'GBP' => 'British Pound',
					'‎GEL' => 'Georgian Lari',
					'GHS' => 'Ghanaian Cedi',
					'GTQ' => 'Guatemalan Quetzal',
					'HKD' => 'Hong Kong Dollar',
					'HNL' => 'Honduran Lempira',
					'HRK' => 'Croatian Kuna',
					'HUF' => 'Hungarian Forint',
					'IDR' => 'Indonesian Rupiah',
					'ILS' => 'Israeli SheKel',
					'INR' => 'Indian Rupee',
					'IQD' => 'Iraqi Dinar',
					'IRR' => 'Iranian Rial',
					'ISK' => 'Icelandic Króna',
					'JMD' => 'Jamaican Dollar',
					'JOD' => 'Jordanian Dinar',
					'JPY' => 'Japanese Yen',
					'KES' => 'Kenyan Shilling',
					'KHR' => 'Cambodian Riel',
					'KMF' => 'Comorian Franc',
					'KRW' => 'South Korean Won',
					'KWD' => 'Kuwaiti Dinar',
					'KZT' => 'Kazakhstani Tenge',
					'LBP' => 'Lebanese Pound',
					'LKR' => 'Sri Lankan Rupee',
					'LTL' => 'Lithuanian Litas',
					'LVL' => 'Latvian Lats',
					'LYD' => 'Libyan Dinar',
					'MAD' => 'Moroccan Dirham',
					'MDL' => 'Moldovan Leu',
					'MGA' => 'Malagasy Ariary',
					'MKD' => 'Macedonian Denar',
					'MMK' => 'Myanma Kyat',
					'HKD' => 'Macanese Pataca',
					'MUR' => 'Mauritian Rupee',
					'MXN' => 'Mexican Peso',
					'MYR' => 'Malaysian Ringgit',
					'MZN' => 'Mozambican Metical',
					'NAD' => 'Namibian Dollar',
					'NGN' => 'Nigerian Naira',
					'NIO' => 'Nicaraguan Córdoba',
					'NOK' => 'Norwegian Krone',
					'NPR' => 'Nepalese Rupee',
					'NZD' => 'New Zealand Dollar',
					'OMR' => 'Omani Rial',
					'‎PAB' => 'Panamanian Balboa',
					'PEN' => 'Peruvian Nuevo Sol',
					'PHP' => 'Philippine Peso',
					'PKR' => 'Pakistani Rupee',
					'PLN' => 'Polish Zloty',
					'PYG' => 'Paraguayan Guarani',
					'QAR' => 'Qatari Rial',
					'RON' => 'Romanian Leu',
					'RSD' => 'Serbian Dinar',
					'RUB' => 'Russian Ruble',
					'RWF' => 'Rwandan Franc',
					'SAR' => 'Saudi Riyal',
					'SDG' => 'Sudanese Pound',
					'SEK' => 'Swedish Krona',
					'SGD' => 'Singapore Dollar',
					'SOS' => 'Somali Shilling',
					'SYP' => 'Syrian Pound',
					'THB' => 'Thai Baht',
					'TND' => 'Tunisian Dinar',
					'TOP' => 'Tongan Paʻanga',
					'TRY' => 'Turkish Lira',
					'TTD' => 'Trinidad and Tobago Dollar',
					'TWD' => 'New Taiwan Dollar',
					'UAH' => 'Ukrainian Hryvnia',
					'UGX' => 'Ugandan Shilling',
					'UYU' => 'Uruguayan Peso',
					'UZS' => 'Uzbekistan Som',
					'VEF' => 'Venezuelan Bolívar',
					'VND' => 'Vietnamese Dong',
					'YER' => 'Yemeni Rial',
					'ZAR' => 'South African Rand',
					'ZMK' => 'Zambian Kwacha'),
				'default' => 'USD',
				'required' => array( 'classify_multi_currency', '=', 'multi' )
			),
			array(
				'id'=>'classify_post_currency',
				'type' => 'text',
				'title' => __('Currency Tag', 'classify'),
				'subtitle' => __('Currency Tag', 'classify'),
				'desc' => __('Put Your Own Currecny Symbol or HTML code to display', 'classify'),
				'default' => '$',
				'required' => array( 'classify_multi_currency', '=', 'single' )
			),
		)
    ) );
	// -> START Callout Settings
    Redux::setSection( $opt_name, array(
        'title'      => __( 'CallOut', 'classify' ),
        'id'         => 'callout',
		'icon'             => 'el el-bullhorn',        
        'desc'             => __( 'Callout Message For Home page!', 'classify' ),
        'fields'     => array(
          
			array(
				'id'=>'callout_title',
				'type' => 'text',
				'title' => __(' Callout Title', 'classify'),
				'desc'=> __('Put here your Callout title', 'classify'),
				'subtitle' => __('Callout title', 'classify'),
				'default'=>'Are you ready for the posting your ads on Classify ?',
			),
			array(
				'id'=>'callout_desc',
				'type' => 'textArea',
				'title' => __(' Callout Description', 'classify'),
				'desc'=> __('Put here your Callout Description', 'classify'),
				'subtitle' => __('Callout Description', 'classify'),
				'default'=>'Vivamus in lectus purus. Quisque rhoncus erat tincidunt, dignissim nunc at, sodales turpis. Donec convallis rhoncus lorem ac ullamcorper. Morbi a mi facilisis, feugiat mi vel, facilisis ipsum.',
			),
			array(
				'id'=>'callout_btn_url',
				'type' => 'text',
				'title' => __(' Callout Button URL', 'classify'),
				'desc'=> __('Put here your Callout Button URL', 'classify'),
				'subtitle' => __('Callout Button URL', 'classify'),
				'validate' => 'url',
				'default'=>'',
			), 
			array(
				'id'       => 'classify_callout_bg',
				'type'     => 'background',
				'title'    => __('Callout Background', 'classify'),
				'subtitle' => __('Callout Background, color, etc.', 'classify'),
				'desc'     => __('If you want to use image then dont select color just upload background image, It will work on Callout parallax design only. Size: width:1600px and height 300px', 'classify'),
				'default'  => array(
					'background-color' => 'transparent',
					'background-image' => '',
					'background-repeat' => 'no-repeat',
					'background-position' => '',
					'background-size' => 'cover',
				),			 
			),
			array(
				'id'       => 'callout_heading_color',
				'type'     => 'color',
				'title'    => __('Callout Heading Color', 'classify'), 
				'subtitle' => __('Pick a Callout Heading Color (default: #ffffff).', 'classify'),
				'default'  => '#ffffff',
				'validate' => 'color',
				'transparent' => false,
			),
			array(
				'id'       => 'callout_desc_color',
				'type'     => 'color',
				'title'    => __('Callout Text Color', 'classify'), 
				'subtitle' => __('Pick a Callout Description text Color (default: #ffffff).', 'classify'),
				'default'  => '#ffffff',
				'validate' => 'color',
				'transparent' => false,
			),
        )
    ) );
	// -> START Custom Ads Settings
    Redux::setSection( $opt_name, array(
        'title'            => __( 'Advertainment', 'classify' ),        
        'id'               => 'classify-custom-ads',
        'icon'             => 'el el-usd',
        'customizer_width' => '500px',
        'fields'           => array(
            array(
				'id'=>'home_ad',
				'type' => 'media', 
				'url'=> true,
				'title' => __('Home Page Ad', 'classify'),
				'compiler' => 'true',
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Upload your Ad Image.', 'classify'),
				'subtitle' => __('Upload Banner', 'classify'),
				'default'=>array('url'=>''),
			),
			array(
				'id'=>'home_ad_link',
				'type' => 'text',
				'title' => __('Home Page Ad link URL', 'classify'),
				'subtitle' => __('Ad link URL', 'classify'),
				'desc' => __('You can add URL.', 'classify'),
				'default' => '',
				'validate' => 'url',
			),
			array(
				'id'=>'home_ad_code_client',
				'type' => 'textarea',
				'title' => __('Google ads or HTML Ads (HOME PAGE)', 'classify'),
				'subtitle' => __('HTML Ads', 'classify'),
				'desc' => __('Put your Google Ads code or HTML Ads code', 'classify'),
				'default' => ''
			),
			array(
				'id'=>'post_ad',
				'type' => 'media', 
				'url'=> true,
				'title' => __('Post Detail Page Ad', 'classify'),
				'compiler' => 'true',
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Upload your Ad Image.', 'classify'),
				'subtitle' => __('Upload Banner', 'classify'),
				'default'=>array('url'=>''),
			),
			array(
				'id'=>'post_ad_link',
				'type' => 'text',
				'title' => __('Post Page Ad link URL', 'classify'),
				'subtitle' => __('Ad link URL', 'classify'),
				'desc' => __('You can add URL.', 'classify'),
				'default' => '',
				'validate' => 'url',
			),
			array(
				'id'=>'post_ad_code_client',
				'type' => 'textarea',
				'title' => __('Google ads or HTML Ads (POST PAGE)', 'classify'),
				'subtitle' => __('HTML Ads', 'classify'),
				'desc' => __('Put your Google Ads code or HTML Ads code.', 'classify'),
				'default' => ''
			),
        )
    ) );
	// -> START Pages Settings
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Pages', 'classify' ),
        'id'         => 'classify-pages',
		'icon'             => 'el el-list-alt',        
        'fields'     => array(            
			array(
				'id'=>'login',
				'type' => 'text',
				'title' => __('Login Page URL', 'classify'),
				'subtitle' => __('This must be an URL.', 'classify'),
				'desc' => __('Login Page', 'classify'),
				'validate' => 'url',
				'default' => ''
			),
			array(
				'id'=>'profile',
				'type' => 'text',
				'title' => __('Profile Page URL', 'classify'),
				'subtitle' => __('This must be an URL.', 'classify'),
				'desc' => __('Profile Page', 'classify'),
				'validate' => 'url',
				'default' => ''
			),	
			array(
				'id'=>'edit',
				'type' => 'text',
				'title' => __('Edit Profile Page URL', 'classify'),
				'subtitle' => __('This must be an URL.', 'classify'),
				'desc' => __('Edit Profile', 'classify'),
				'validate' => 'url',
				'default' => ''
			),
			array(
				'id'=>'register',
				'type' => 'text',
				'title' => __('Register Page URL', 'classify'),
				'subtitle' => __('This must be an URL.', 'classify'),
				'desc' => __('Register Page', 'classify'),
				'validate' => 'url',
				'default' => ''
			),
			array(
				'id'=>'reset',
				'type' => 'text',
				'title' => __('Reset Password Page URL', 'classify'),
				'subtitle' => __('This must be an URL.', 'classify'),
				'desc' => __('Reset Password', 'classify'),
				'validate' => 'url',
				'default' => ''
			),
			array(
				'id'=>'new_post',
				'type' => 'text',
				'title' => __('Submit Ad Page URL', 'classify'),
				'subtitle' => __('This must be an URL.', 'classify'),
				'desc' => __('New Ad Page', 'classify'),
				'validate' => 'url',
				'default' => ''
			),
			array(
				'id'=>'edit_post',
				'type' => 'text',
				'title' => __('Edit Ad Page URL', 'classify'),
				'subtitle' => __('This must be an URL.', 'classify'),
				'desc' => __('Edit Ad Page', 'classify'),
				'validate' => 'url',
				'default' => ''
			),
			array(
				'id'=>'all-ads',
				'type' => 'text',
				'title' => __('Display All Ads Page URL', 'classify'),
				'subtitle' => __('This must be an URL.', 'classify'),
				'desc' => __('Display All Ads', 'classify'),
				'validate' => 'url',
				'default' => ''
			),
			array(
				'id'=>'classify_all_categories',
				'type' => 'text',
				'title' => __('Display All categories Page URL', 'classify'),
				'subtitle' => __('This must be an URL.', 'classify'),
				'desc' => __('Display All categories', 'classify'),
				'validate' => 'url',
				'default' => ''
			),
			array(
				'id'=>'classify_user_all_ads',
				'type' => 'text',
				'title' => __('Single user all ads Page URL', 'classify'),
				'subtitle' => __('This must be an URL.', 'classify'),
				'desc' => __('Single user All Ads page URL', 'classify'),
				'validate' => 'url',
				'default' => ''
			),
			array(
				'id'=>'featured_plans',
				'type' => 'text',
				'title' => __('Pricing Plans Page URL', 'classify'),
				'subtitle' => __('This must be an URL.', 'classify'),
				'desc' => __('Featured Plans', 'classify'),
				'validate' => 'url',
				'default' => ''
			),
			array(
				'id'=>'classify_terms_page',
				'type' => 'text',
				'title' => __('Terms Page URL', 'classify'),
				'subtitle' => __('This must be an URL.', 'classify'),
				'desc' => __('Terms', 'classify'),
				'validate' => 'url',
				'default' => ''
			),
        )
    ) );
	// -> START Fonts Settings
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Fonts', 'classify' ),
        'id'         => 'classify-fonts',
		'icon'             => 'el el-fontsize',
        'fields'     => array(            
			array(
				'id' => 'heading1-font',
				'type' => 'typography',
				'title' => __('H1 Font', 'classify'),
				'subtitle' => __('Specify the headings font properties.', 'classify'),
				'google' => true,
				'output' => array('h1, h1 a, h1 span'),
				'default' => array(
					'color' => '#3f3d59',
					'font-size' => '38.5px',
					'font-family' => 'Roboto Slab',
					'font-weight' => '700',
					'line-height' => '40px',
					),
         	),

			array(
				'id' => 'heading2-font',
				'type' => 'typography',
				'title' => __('H2 Font', 'classify'),
				'subtitle' => __('Specify the headings font properties.', 'classify'),
				'google' => true,
				'output' => array('h2, h2 a, h2 span'),
				'default' => array(
					'color' => '#3f3d59',
					'font-size' => '31.5px',
					'font-family' => 'Roboto Slab',
					'font-weight' => '700',
					'line-height' => '40px',
					),
         	),

			array(
				'id' => 'heading3-font',
				'type' => 'typography',
				'title' => __('H3 Font', 'classify'),
				'subtitle' => __('Specify the headings font properties.', 'classify'),
				'google' => true,
				'output' => array('h3, h3 a, h3 span'),
				'default' => array(
					'color' => '#3f3d59',
					'font-size' => '18px',
					'font-family' => 'Roboto Slab',
					'font-weight' => '700',
					'line-height' => '40px',
					),
         	),

			array(
				'id' => 'heading4-font',
				'type' => 'typography',
				'title' => __('H4 Font', 'classify'),
				'subtitle' => __('Specify the headings font properties.', 'classify'),
				'google' => true,
				'output' => array('h4, h4 a, h4 span'),
				'default' => array(
					'color' => '#3f3d59',
					'font-size' => '18px',
					'font-family' => 'Roboto Slab',
					'font-weight' => '700',
					'line-height' => '40px',
					),
         	),

			array(
				'id' => 'heading5-font',
				'type' => 'typography',
				'title' => __('H5 Font', 'classify'),
				'subtitle' => __('Specify the headings font properties.', 'classify'),
				'google' => true,
				'output' => array('h5, h5 a, h5 span'),
				'default' => array(
					'color' => '#484848',
					'font-size' => '14px',
					'font-family' => 'Roboto',
					'font-weight' => '300',
					'line-height' => '40px',
					),
         	),

			array(
				'id' => 'heading6-font',
				'type' => 'typography',
				'title' => __('H6 Font', 'classify'),
				'subtitle' => __('Specify the headings font properties.', 'classify'),
				'google' => true,
				'output' => array('h6, h6 a, h6 span'),
				'default' => array(
					'color' => '#484848',
					'font-size' => '11.9px',
					'font-family' => 'Roboto',
					'font-weight' => '300',
					'line-height' => '40px',
					),
         	),

			array(
				'id' => 'body-font',
				'type' => 'typography',
				'title' => __('Body Font', 'classify'),
				'subtitle' => __('Specify the body font properties.', 'classify'),
				'google' => true,
				'output' => array('html, body, div, applet, object, iframe p, blockquote, a, abbr, acronym, address, big, cite, del, dfn, em, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td, article, aside, canvas, details, embed, figure, figcaption, footer, header, hgroup, menu, nav, output, ruby, section, summary, time, mark, audio, video'),
				'default' => array(
					'color' => '#888888',
					'font-size' => '14px',
					'font-family' => 'Raleway',
					'font-weight' => 'Normal',
					'line-height' => '24px',
					),
         	),
        )
    ) );
	// -> START Colors Settings
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Colors', 'classify' ),
        'id'         => 'classify-colors',
		'icon'             => 'el el-brush',
        'fields'     => array(
            
			array(
				'id'       => 'color-primary',
				'type'     => 'color',
				'title'    => __('Primary Color', 'classify'), 
				'subtitle' => __('Pick a Primary Color (default: #a0ce4e).', 'classify'),
				'default'  => '#a0ce4e',
				'validate' => 'color',
				'transparent' => false,
			),
			array(
				'id'       => 'color-secondary',
				'type'     => 'color',
				'title'    => __('Secondary Color', 'classify'), 
				'subtitle' => __('Pick a Secondary Color (default: #3f3d59).', 'classify'),
				'default'  => '#3f3d59',
				'validate' => 'color',
				'transparent' => false,
			),
			array(
				'id'       => 'color-topbar-bg',
				'type'     => 'color',
				'title'    => __('Topbar Background', 'classify'), 
				'subtitle' => __('Topbar background color (default:#3f3d59)', 'classify'),
				'default'  => '#3f3d59',
				'validate' => 'color',
				'transparent' => false,
			),
			array(
				'id'       => 'color-topbar-color',
				'type'     => 'color',
				'title'    => __('Topbar Icon and text color', 'classify'), 
				'subtitle' => __('Social icon and text color in topbar. (default:#ffffff)', 'classify'),
				'default'  => '#ffffff',
				'validate' => 'color',
				'transparent' => false,
			),
			array(
				'id'       => 'color-topbar-hover-color',
				'type'     => 'color',
				'title'    => __('Topbar Icon and text hover color', 'classify'), 
				'subtitle' => __('Social icon and text hover color in topbar. (default:#a0ce4e)', 'classify'),
				'default'  => '#a0ce4e',
				'validate' => 'color',
				'transparent' => false,
			),			
			array(
				'id'       => 'fooer-color',
				'type'     => 'color',
				'title'    => __('Footer background color', 'classify'), 
				'subtitle' => __('Pick a color for Footer background (default: #3f3d59).', 'classify'),
				'default'  => '#3f3d59',
				'validate' => 'color',
				'transparent' => false,
			),
			array(
				'id'       => 'footer-heading-color',
				'type'     => 'color',
				'title'    => __('Footer Heading color', 'classify'), 
				'subtitle' => __('Pick a color for Footer heading text (default: #ffffff).', 'classify'),
				'default'  => '#ffffff',
				'validate' => 'color',
				'transparent' => false,
			),
			array(
				'id'       => 'footer-text-color',
				'type'     => 'color',
				'title'    => __('Footer text color', 'classify'), 
				'subtitle' => __('Pick a color for Footer text (default: #ffffff).', 'classify'),
				'default'  => '#ffffff',
				'validate' => 'color',
				'transparent' => false,
			),
			array(
				'id'       => 'footer-tagcloud-bg-color',
				'type'     => 'color',
				'title'    => __('Footer tagcloud bg color', 'classify'), 
				'subtitle' => __('Pick Footer tagcloud bg color (default: #f6f6f6).', 'classify'),
				'default'  => '#f6f6f6',
				'validate' => 'color',
				'transparent' => false,
			),
			array(
				'id'       => 'footer-tagcloud-hover-bg-color',
				'type'     => 'color',
				'title'    => __('Footer tagcloud hover bg color', 'classify'), 
				'subtitle' => __('Pick Footer tagcloud hover bg color (default: #a0ce4e).', 'classify'),
				'default'  => '#a0ce4e',
				'validate' => 'color',
				'transparent' => false,
			),
			array(
				'id'       => 'footer-tagcloud-text-color',
				'type'     => 'color',
				'title'    => __('Footer Tags Text color', 'classify'), 
				'subtitle' => __('Pick a color for Footer tags text (default: #888888).', 'classify'),
				'default'  => '#888888',
				'validate' => 'color',
				'transparent' => false,
			),
			array(
				'id'       => 'footer-tagcloud-text-hover-color',
				'type'     => 'color',
				'title'    => __('Footer Tags Text Hover color', 'classify'), 
				'subtitle' => __('Pick Footer tags hover text color (default: #ffffff).', 'classify'),
				'default'  => '#ffffff',
				'validate' => 'color',
				'transparent' => false,
			),
        )
    ) );
    // -> START Social Links
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Social Links', 'classify' ),
        'id'         => 'classify-social-links',
        'icon'  => 'el el-slideshare',
        'fields'     => array(            
			array(
				'id'=>'facebook-link',
				'type' => 'text',
				'title' => __('Facebook Page URL', 'classify'),
				'subtitle' => __('This must be an URL.', 'classify'),
				'desc' => __('Facebook', 'classify'),
				'validate' => 'url',
				'default' => ''
			),

			array(
				'id'=>'twitter-link',
				'type' => 'text',
				'title' => __('Twitter Page URL', 'classify'),
				'subtitle' => __('This must be an URL.', 'classify'),
				'desc' => __('Twitter', 'classify'),
				'validate' => 'url',
				'default' => ''
			),

			array(
				'id'=>'dribbble-link',
				'type' => 'text',
				'title' => __('Dribbble Page URL', 'classify'),
				'subtitle' => __('This must be an URL.', 'classify'),
				'desc' => __('Dribbble', 'classify'),
				'validate' => 'url',
				'default' => ''
			),

			array(
				'id'=>'flickr-link',
				'type' => 'text',
				'title' => __('Flickr Page URL', 'classify'),
				'subtitle' => __('This must be an URL.', 'classify'),
				'desc' => __('Flickr', 'classify'),
				'validate' => 'url',
				'default' => ''
			),

			array(
				'id'=>'github-link',
				'type' => 'text',
				'title' => __('Github Page URL', 'classify'),
				'subtitle' => __('This must be an URL.', 'classify'),
				'desc' => __('Github', 'classify'),
				'validate' => 'url',
				'default' => ''
			),

			array(
				'id'=>'pinterest-link',
				'type' => 'text',
				'title' => __('Pinterest Page URL', 'classify'),
				'subtitle' => __('This must be an URL.', 'classify'),
				'desc' => __('Pinterest', 'classify'),
				'validate' => 'url',
				'default' => ''
			),

			array(
				'id'=>'youtube-link',
				'type' => 'text',
				'title' => __('Youtube Page URL', 'classify'),
				'subtitle' => __('This must be an URL.', 'classify'),
				'desc' => __('Youtube', 'classify'),
				'validate' => 'url',
				'default' => ''
			),

			array(
				'id'=>'google-plus-link',
				'type' => 'text',
				'title' => __('Google+ Page URL', 'classify'),
				'subtitle' => __('This must be an URL.', 'classify'),
				'desc' => __('Google', 'classify'),
				'validate' => 'url',
				'default' => ''
			),

			array(
				'id'=>'linkedin-link',
				'type' => 'text',
				'title' => __('LinkedIn Page URL', 'classify'),
				'subtitle' => __('This must be an URL.', 'classify'),
				'desc' => __('LinkedIn', 'classify'),
				'validate' => 'url',
				'default' => ''
			),

			array(
				'id'=>'tumblr-link',
				'type' => 'text',
				'title' => __('Tumblr Page URL', 'classify'),
				'subtitle' => __('This must be an URL.', 'classify'),
				'desc' => __('Tumblr', 'classify'),
				'validate' => 'url',
				'default' => ''
			),

			array(
				'id'=>'vimeo-link',
				'type' => 'text',
				'title' => __('Vimeo Page URL', 'classify'),
				'subtitle' => __('This must be an URL.', 'classify'),
				'desc' => __('Vimeo', 'classify'),
				'validate' => 'url',
				'default' => ''
			),
			array(
				'id'=>'instagram-link',
				'type' => 'text',
				'title' => __('Instagram Page URL', 'classify'),
				'subtitle' => __('This must be an URL.', 'classify'),
				'desc' => __('Instagram', 'classify'),
				'validate' => 'url',
				'default' => ''
			),	
            
            
        ),        
    ) );    
	// -> START Contact Settings
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Contact Page', 'classify' ),
        'id'         => 'classify-contact-page', 
		'icon'  => 'el el-envelope',
        'fields'     => array(            
            array(
				'id'=>'contact-email',
				'type' => 'text',
				'title' => __('Your email address', 'classify'),
				'subtitle' => __('This must be an email address.', 'classify'),
				'desc' => __('Email address', 'classify'),
				'validate' => 'email',
				'default' => ''
			),
			array(
				'id'=>'contact-latitude',
				'type' => 'text',
				'title' => __('Latitude', 'classify'),
				'subtitle' => __('Latitude', 'classify'),
				'desc' => __('Latitude', 'classify'),
				'default' => ''
			),
			array(
				'id'=>'contact-longitude',
				'type' => 'text',
				'title' => __('Longitude', 'classify'),
				'subtitle' => __('Longitude', 'classify'),
				'desc' => __('Longitude', 'classify'),
				'default' => ''
			),
			array(
				'id'=>'contact-zoom',
				'type' => 'text',
				'title' => __('Zoom level', 'classify'),
				'subtitle' => __('Zoom level', 'classify'),
				'desc' => __('Zoom level', 'classify'),
				'default' => ''
			),
			array(
				'id'=>'contact-radius',
				'type' => 'text',
				'title' => __('Radius', 'classify'),
				'subtitle' => __('Radius value', 'classify'),
				'desc' => __('Put a radius value then it will show a circal', 'classify'),
				'default' => '500'
			),
        ),
    ) );
    if ( file_exists( dirname( __FILE__ ) . '/../README.md' ) ) {
        $section = array(
            'icon'   => 'el el-list-alt',
            'title'  => __( 'Documentation', 'classify' ),
            'fields' => array(
                array(
                    'id'       => '17',
                    'type'     => 'raw',
                    'markdown' => true,
                    'content_path' => dirname( __FILE__ ) . '/../README.md', // FULL PATH, not relative please
                    //'content' => 'Raw content here',
                ),
            ),
        );
        Redux::setSection( $opt_name, $section );
    }
    /*
     * <--- END SECTIONS
     */


    /*
     *
     * YOU MUST PREFIX THE FUNCTIONS BELOW AND ACTION FUNCTION CALLS OR ANY OTHER CONFIG MAY OVERRIDE YOUR CODE.
     *
     */

    /*
    *
    * --> Action hook examples
    *
    */

    // If Redux is running as a plugin, this will remove the demo notice and links
   add_action( 'redux/loaded', 'remove_demo' );

    // Function to test the compiler hook and demo CSS output.
    // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
    //add_filter('redux/options/' . $opt_name . '/compiler', 'compiler_action', 10, 3);

    // Change the arguments after they've been declared, but before the panel is created
    //add_filter('redux/options/' . $opt_name . '/args', 'change_arguments' );

    // Change the default value of a field after it's been set, but before it's been useds
    //add_filter('redux/options/' . $opt_name . '/defaults', 'change_defaults' );

    // Dynamically add a section. Can be also used to modify sections/fields
    //add_filter('redux/options/' . $opt_name . '/sections', 'dynamic_section');

    /**
     * This is a test function that will let you see when the compiler hook occurs.
     * It only runs if a field    set with compiler=>true is changed.
     * */
    if ( ! function_exists( 'compiler_action' ) ) {
        function compiler_action( $options, $css, $changed_values ) {
            echo '<h1>The compiler hook has run!</h1>';
            echo "<pre>";
            print_r( $changed_values ); // Values that have changed since the last save
            echo "</pre>";
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )
        }
    }

    /**
     * Custom function for the callback validation referenced above
     * */
    if ( ! function_exists( 'redux_validate_callback_function' ) ) {
        function redux_validate_callback_function( $field, $value, $existing_value ) {
            $error   = false;
            $warning = false;

            //do your validation
            if ( $value == 1 ) {
                $error = true;
                $value = $existing_value;
            } elseif ( $value == 2 ) {
                $warning = true;
                $value   = $existing_value;
            }

            $return['value'] = $value;

            if ( $error == true ) {
                $field['msg']    = 'your custom error message';
                $return['error'] = $field;
            }

            if ( $warning == true ) {
                $field['msg']      = 'your custom warning message';
                $return['warning'] = $field;
            }

            return $return;
        }
    }

    /**
     * Custom function for the callback referenced above
     */
    if ( ! function_exists( 'redux_my_custom_field' ) ) {
        function redux_my_custom_field( $field, $value ) {
            print_r( $field );
            echo '<br/>';
            print_r( $value );
        }
    }

    /**
     * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
     * Simply include this function in the child themes functions.php file.
     * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
     * so you must use get_template_directory_uri() if you want to use any of the built in icons
     * */
    if ( ! function_exists( 'dynamic_section' ) ) {
        function dynamic_section( $sections ) {
            //$sections = array();
            $sections[] = array(
                'title'  => __( 'Section via hook', 'classify' ),
                'desc'   => __( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'classify' ),
                'icon'   => 'el el-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }
    }

    /**
     * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
     * */
    if ( ! function_exists( 'change_arguments' ) ) {
        function change_arguments( $args ) {
            //$args['dev_mode'] = true;

            return $args;
        }
    }

    /**
     * Filter hook for filtering the default value of any given field. Very useful in development mode.
     * */
    if ( ! function_exists( 'change_defaults' ) ) {
        function change_defaults( $defaults ) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }
    }

    /**
     * Removes the demo link and the notice of integrated demo from the redux-framework plugin
     */
    if ( ! function_exists( 'remove_demo' ) ) {
        function remove_demo() {
            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                remove_filter( 'plugin_row_meta', array(
                    ReduxFrameworkPlugin::instance(),
                    'plugin_metalinks'
                ), null, 2 );

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
            }
        }
    }

