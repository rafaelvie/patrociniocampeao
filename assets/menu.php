<?php
// Register menus
register_nav_menus(
	array(
		'primary' => esc_html__( 'Primary Menu', 'classify' ),   // Main nav in header
		'mobile' => esc_html__( 'Mobile Menu', 'classify' ),   // Main nav in header		
	)
);
// The Top Menu
function classifyPrimaryNav(){
	wp_nav_menu( array(
		'menu'              => 'primary',
		'theme_location'    => 'primary',
		'depth'             => 3,
		'container'         => 'ul',
		'menu_class'        => 'nav navbar-nav navbar-right',
		'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
		'walker'            => new wp_bootstrap_navwalker())
    );
}
// The Mobile Menu/
function classifyMobileNav(){
	wp_nav_menu( array(
		'menu'              => 'mobile',
		'theme_location'    => 'mobile',
		'depth'             => 3,
		'menu_class'        => 'nav navbar-nav navbar-right',
		'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
		'walker'            => new wp_bootstrap_navwalker())
    );
}
?>