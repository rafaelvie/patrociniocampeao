<?php
function classify_import_files() {
  return array(
    array(
		'import_file_name'             => 'Classify English',     
		'local_import_file'            => trailingslashit( get_template_directory() ) . 'import/content.xml',
		'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'import/widgets.json',      
		'local_import_redux'           => array(
			array(
				'file_path'   => trailingslashit( get_template_directory() ) . 'import/redux.json',
				'option_name' => 'redux_demo',
			),
		),
		'import_preview_image_url'     => '',
		'import_notice'                => __( 'After you import this demo, you will have to setup the LayerSlider separately. also you need to add categories icons by visiting All Posts --> Categories.', 'classify' ),
		'preview_url'                  => 'http://demo.joinwebs.com/classify/',
	),
    array(
		'import_file_name'             => 'Classify Arabic',    
		'local_import_file'            => trailingslashit( get_template_directory() ) . 'import/content-arabic.xml',
		'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'import/widgets-arabic.json',      
		'local_import_redux'           => array(
			array(
				'file_path'   => trailingslashit( get_template_directory() ) . 'import/redux-arabic.json',
				'option_name' => 'redux_demo',
			),        
		),
		'import_preview_image_url'     => '',
		'import_notice'                => __( 'After you import this demo, you will have to setup the LayerSlider separately. also you need to add categories icons by visiting All Posts --> Categories.', 'classify' ),
		'preview_url'                  => 'http://demo.joinwebs.com/classify/rtl',
    ),
  );
}
add_filter( 'pt-ocdi/import_files', 'classify_import_files' );
function classify_after_import_setup(){
	$main_menu = get_term_by( 'name', 'Primary', 'nav_menu' );
	set_theme_mod( 'nav_menu_locations', array(			
			'primary' => $main_menu->term_id,
			'mobile' => $main_menu->term_id,
		)
	);
	$front_page_id = get_page_by_title( 'Home' );
	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $front_page_id->ID );
}
add_action( 'pt-ocdi/after_import', 'classify_after_import_setup' );