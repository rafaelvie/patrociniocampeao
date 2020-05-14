<?php 
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
 function classify_register_required_plugins(){ 
    /**
     * Array of plugin arrays. Required keys are name, slug and required.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(
	
		// Redux Framework
        array(            
			'name' => esc_html__( 'Redux Framework', 'classify' ),
            'slug' => 'redux-framework',
            'required' => true,
            'force_activation' => false,
            'force_deactivation' => false
        ),		
        //WooCommerce
        array(
            'name' => 'WooCommerce',
            'slug' => 'woocommerce',
            'required' => false,
            'force_activation' => false,
            'force_deactivation' => false
        ),
		//One Click Demo Import
		array(
            'name' => 'One Click Demo Import',
            'slug' => 'one-click-demo-import',
            'required' => false,
            'force_activation' => false,
            'force_deactivation' => false
        ),
		//AccessPress Social Login Lite
        array(
            'name' => 'Social Login WordPress Plugin – AccessPress Social Login Lite',
            'slug' => 'accesspress-social-login-lite',
            'required' => false,
            'force_activation' => false,
            'force_deactivation' => false
        ),
		array(
            'name' => 'Social Share WordPress Plugin – AccessPress Social Share',
            'slug' => 'accesspress-social-share',
            'required' => false,
            'force_activation' => false,
            'force_deactivation' => false
        ),
		// Ratings
        array(            
			'name' => esc_html__( 'WP-PostRatings', 'classify' ),
            'slug' => 'wp-postratings',            
            'required' => false,            
            'force_activation' => false,
            'force_deactivation' => false
        ),
 
    );
 
    // Change this to your theme text domain, used for internationalising strings
    $theme_text_domain = 'wpcrown';
 
    /**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
        'domain'            => 'wpcrown',           // Text domain - likely want to be the same as your theme.
        'default_path'      => '',                           // Default absolute path to pre-packaged plugins
        'parent_menu_slug'  => 'themes.php',         // Default parent menu slug
        'parent_url_slug'   => 'themes.php',         // Default parent URL slug
        'menu'              => 'install-required-plugins',   // Menu slug
        'has_notices'       => true,                         // Show admin notices or not
        'is_automatic'      => false,            // Automatically activate plugins after installation or not
        'message'           => '',               // Message to output right before the plugins table
        'strings'           => array(
            'page_title'                      => __( 'Install Required Plugins', 'classify' ),
				'menu_title'                      => __( 'Install Plugins', 'classify' ),
				'installing'                      => __( 'Installing Plugin: %s', 'classify' ),
				'oops'                            => __( 'Something went wrong with the plugin API.', 'classify' ),
				'notice_can_install_required'     => _n_noop(
					'This theme requires the following plugin: %1$s.',
					'This theme requires the following plugins: %1$s.',
					'classify'
				),
				'notice_can_install_recommended'  => _n_noop(
					'This theme recommends the following plugin: %1$s.',
					'This theme recommends the following plugins: %1$s.',
					'classify'
				),
				'notice_cannot_install'           => _n_noop(
					'Sorry, but you do not have the correct permissions to install the %1$s plugin.',
					'Sorry, but you do not have the correct permissions to install the %1$s plugins.',
					'classify'
				),
				'notice_ask_to_update'            => _n_noop(
					'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
					'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
					'classify'
				),
				'notice_ask_to_update_maybe'      => _n_noop(
					'There is an update available for: %1$s.',
					'There are updates available for the following plugins: %1$s.',
					'classify'
				),
				'notice_cannot_update'            => _n_noop(
					'Sorry, but you do not have the correct permissions to update the %1$s plugin.',
					'Sorry, but you do not have the correct permissions to update the %1$s plugins.',
					'classify'
				),
				'notice_can_activate_required'    => _n_noop(
					'The following required plugin is currently inactive: %1$s.',
					'The following required plugins are currently inactive: %1$s.',
					'classify'
				),
				'notice_can_activate_recommended' => _n_noop(
					'The following recommended plugin is currently inactive: %1$s.',
					'The following recommended plugins are currently inactive: %1$s.',
					'classify'
				),
				'notice_cannot_activate'          => _n_noop(
					'Sorry, but you do not have the correct permissions to activate the %1$s plugin.',
					'Sorry, but you do not have the correct permissions to activate the %1$s plugins.',
					'classify'
				),
				'install_link'                    => _n_noop(
					'Begin installing plugin',
					'Begin installing plugins',
					'classify'
				),
				'update_link'                     => _n_noop(
					'Begin updating plugin',
					'Begin updating plugins',
					'classify'
				),
				'activate_link'                   => _n_noop(
					'Begin activating plugin',
					'Begin activating plugins',
					'classify'
				),
				'return'                          => __( 'Return to Required Plugins Installer', 'classify' ),
				'dashboard'                       => __( 'Return to the dashboard', 'classify' ),
				'plugin_activated'                => __( 'Plugin activated successfully.', 'classify' ),
				'activated_successfully'          => __( 'The following plugin was activated successfully:', 'classify' ),
				'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'classify' ),
				'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'classify' ),
				'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'classify' ),
				'dismiss'                         => __( 'Dismiss this notice', 'classify' ),
				'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'classify' ),
        )
    );
 
    tgmpa( $plugins, $config );
 
}