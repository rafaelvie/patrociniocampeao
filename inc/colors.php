<?php 

function wpcrown_wpcss_loaded() {

	// Return the lowest priority number from all the functions that hook into wp_head
	global $wp_filter;
	//$lowest_priority = max(array_keys($wp_filter['wp_head']));
 
	add_action('wp_head', 'wpcrown_wpcss_head', 10 + 1);
 
	$arr = $wp_filter['wp_head'];

}
add_action('wp_head', "wpcrown_wpcss_loaded");

function hex2rgb($hex) {
        $hex = str_replace("#", "", $hex);

        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        $rgb = array($r, $g, $b);
        return implode(",", $rgb); // returns the rgb values separated by commas
        //return $rgb; // returns an array with the rgb values
    }
 
// wp_head callback functions
function wpcrown_wpcss_head() {

	global $redux_demo; 
	$classifyPrimary = $redux_demo['color-primary'];
	$classifySecondary = $redux_demo['color-secondary'];
	
	$classifyTopbarBG = $redux_demo['color-topbar-bg'];
	$classifyTopbarColor = $redux_demo['color-topbar-color'];
	$classifyTopbarHoverColor = $redux_demo['color-topbar-hover-color'];
	
	$classifyFooterBG = $redux_demo['fooer-color'];
	$classifyFooterHeadingColor = $redux_demo['footer-heading-color'];
	$classifyFooterTxtColor = $redux_demo['footer-text-color'];
	$classifyFooterTagsTxtColor = $redux_demo['footer-tagcloud-text-color'];
	$classifyFooterTagsTxtHoverColor = $redux_demo['footer-tagcloud-text-hover-color'];
	$classifyFooterTagsBG = $redux_demo['footer-tagcloud-bg-color'];
	$classifyFooterTagsHoverBG = $redux_demo['footer-tagcloud-hover-bg-color'];
	
	$wpcrown_main_color = $redux_demo['color-main'];
	$wpcrown_main_color_hover = $redux_demo['color-main-hover'];
	$wpcrown_button_color_main = $redux_demo['button-color-main'];
	$wpcrown_button_color_main_hover = $redux_demo['button-color-main-hover'];
	$body_color = $redux_demo['body-font']['color'];
	
	//CallOut Text Color//
	$classifyCalloutHeading = $redux_demo['callout_heading_color'];
	$classifyCalloutDescription = $redux_demo['callout_desc_color'];
	
	//Search bar settings
	$classifySearchLocation = $redux_demo['classify_search_location'];
	$classifySearchCats = $redux_demo['classify_search_cats'];
	$classifySearchRange = $redux_demo['classify_search_range_slider'];
	
	$measure_system = $redux_demo['measure-system'];

	echo "<style type=\"text/css\">";
	
	//Topbar Color Options//
	if(!empty($classifyTopbarBG)){
		
		echo "#header header .top-bar{ background-color: ";		
		echo $classifyTopbarBG;
		echo " !important; } ";
	}
	if(!empty($classifyTopbarColor)){
		echo "#header header .top-bar .social .social-icon a i, #header header .top-bar .links a{ color: ";		
		echo $classifyTopbarColor;
		echo " !important; } ";
		
		echo "#header header .top-bar .links a:nth-of-type(3){ border-color: ";		
		echo $classifyTopbarColor;
		echo " !important; } ";
	}
	if(!empty($classifyTopbarHoverColor)){
		
		echo "#header header .top-bar .links a:hover{ color: ";		
		echo $classifyTopbarHoverColor;
		echo " !important; } ";
		
		echo "#header header .top-bar .links a:nth-of-type(3){ border-color: ";		
		echo $classifyTopbarHoverColor;
		echo " !important; } ";
		
		echo "#header header .top-bar .links a:nth-of-type(3):hover{ color: ";	
		echo "#ffffff";
		echo " !important; } ";
		
		echo "#header header .top-bar .social .social-icon a i:hover, #header header .top-bar .links a:nth-of-type(3):hover{ background-color: ";		
		echo $classifyTopbarHoverColor;
		echo " !important; } ";
	}
	// Primary Color
	if(!empty($classifyPrimary)) {
		echo ".callout-box .callout-button a:hover, .classify_adv_box_footer .read-more-btn a:hover, .classify_adv_box_footer .read-more-btn a:focus, .classify_btn:hover span, #slider-range-min .ui-widget-header, .owl-nav .owl-prev:hover, .owl-nav .owl-next:hover, #searchBar form button[type='submit']:hover, .woocommerce ul.products li.product .price, .woocommerce span.onsale, .woocommerce-page span.onsale, .woocommerce a.button:hover, .advance_search button[type='submit']:hover, .author-name, #form form input[type='submit']:hover, .btn-primary, .pagination .active a, .pagination .active span, .pagination .active a:hover, .pagination .active span:hover, .pagination .active a:focus, .pagination .active span:focus, ul.pagination li a:hover, #header header .menu-bar .navbar-nav > li.dropdown .dropdown-menu li a:hover, #header header .menu-bar .navbar-nav > li.dropdown .dropdown-menu li a:focus, .author-setting, .author-profile-details .classify_social_links a.classify_social i:hover, .blog_post_meta__author_read a.btn:hover, .leaflet-container a.leaflet-popup-close-button:hover{ background-color: ";
		echo $classifyPrimary;
		echo " !important; } ";
		
		echo ".content .item-list .classify_adv_box .classify_adv_box_title p > a:hover, .classify_adv_box_footer .tags a:hover, .content .item-list .classify_adv_box .classify_adv_box_content .classify_adv_box_title p > span > a:hover, .classify_adv_box .classify_adv_box_img .classify_adv_box_title a:hover, .location .locations a:hover, .location .locations a:hover i, .widget__latest_ad .media-body .price, #footer footer .widget .media .media-heading a:hover, #premium .item .item-title a:hover, .back-to-top i, footer .widget .widget__content .widget__content_subcat ul li a, #footer footer .copyright a:hover, .col, .navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .active > a, #header header .menu-bar .navbar-nav > li > a:hover, #header header .menu-bar .navbar-nav > li > a:focus, .author__adv_info i:first-of-type, .author__adv .media .media-heading a:hover, .blog_post__title a:hover, #offCanvas .navbar-nav .open .dropdown-menu li.active a{ color: ";
		echo $classifyPrimary;
		echo " !important; } ";
		
		echo ".marker-cluster-small{ background:rgba( ";
		echo hex2rgb($classifyPrimary);
		echo ",1 )} ";
		
		echo "{ background:rgba( ";
		echo hex2rgb($classifyPrimary);
		echo ",.5 )} ";
		
		echo " { background-color: ";		
		echo $classifyPrimary;
		echo " !important; } ";
		
		echo ".owl-nav .owl-prev:hover, .owl-nav .owl-next:hover, #searchBar form button[type='submit']:hover, a.back-to-top, .advance_search button[type='submit']:hover, .post-type-box.active, .btn-primary, .pagination .active a, .pagination .active span, .pagination .active a:hover, .pagination .active span:hover, .pagination .active a:focus, .pagination .active span:focus, ul.pagination li a:hover{ border-color: ";
		echo $classifyPrimary;
		echo " !important; } ";
		
		echo ".page-content blockquote{ border-left-color: ";		
		echo $classifyPrimary;
		echo " !important; } ";
		
		echo ".classify_adv_box .classify_adv_hover i{ background-color: ";
		echo $classifyPrimary;
		echo "; } ";
	
	}
	// Primary Color end//
	// Secondary Color Start//
	if(!empty($classifySecondary)) {
		echo "#searchBar, #slider-range-min, .callout-box .callout-button a, .tab.active, .view-as a.active, .view-as a:hover, .classify_adv_box_footer .read-more-btn a, .classify_btn span, #footer footer .widget .widget__premium li a.item-hover, .woocommerce a.button, .table-responsive .classify__table_package thead th, .blog_post_meta__author_read a.btn, .leaflet-container a.leaflet-popup-close-button{ background-color: ";
		echo $classifySecondary;
		echo " !important; } ";
		
		echo "#searchBar form a i, .main-heading h2, .content .item-list .classify_adv_box .classify_adv_box_content .classify_adv_box_title p > a, .classify_adv_box_footer .tags span i, .classify_adv_box_footer .tags span, .content .item-list .classify_adv_box .classify_adv_box_content .classify_adv_box_title p > span > a, .callout-box .callout-content h4, #advertisement .main-heading h2 span.font-container, h2.woocommerce-loop-product__title, .inner-heading, #detail .adv-detail .adv-detail-head h4, .author__adv .media .media-heading a, .author__adv_info i, .blog_post__title a{ color: ";
		echo $classifySecondary;
		echo " !important; } ";
		
		echo ".view-as a.active, .view-as a:hover{ border-color: ";
		echo $classifySecondary;
		echo " !important; } ";
		
		echo ".marker-cluster-small div{ background:rgba( ";
		echo hex2rgb($classifySecondary);
		echo ",1 )} ";
		
		echo "#premium .item .item-title, .classify-buy-sel, .classify_adv_box .classify_adv_box_img .classify_adv_box_title{ background:rgba( ";
		echo hex2rgb($classifySecondary);
		echo ",.6 )} ";
		
		echo "#premium .item .item-hover, .classify_adv_box .classify_adv_hover{ background:rgba( ";
		echo hex2rgb($classifySecondary);
		echo ",.9 )} ";
		
		echo " { background-color: ";		
		echo $classifySecondary;
		echo " !important; } ";
	
	}
	// Secondary Color End//
	// Footer Colors Options//
	if(!empty($classifyFooterBG)) {
		echo "#footer footer{ background-color: ";
		echo $classifyFooterBG;
		echo "; } ";
	
	}
	if(!empty($classifyFooterHeadingColor)){
		echo "#footer footer .widget h4{ color: ";
		echo $classifyFooterHeadingColor;
		echo " !important; } ";
	}
	if(!empty($classifyFooterTxtColor)){
		echo "#footer footer .widget a, #footer footer .copyright, #footer footer .widget .textwidget, #footer footer .widget .widget__latest_ad p{ color: ";
		echo $classifyFooterTxtColor;
		echo "; } ";
	}
	
	if(!empty($classifyFooterTagsBG)){
		echo "#footer .widget .tagcloud a{ background-color: ";
		echo $classifyFooterTagsBG;
		echo "; } ";
	}
	if(!empty($classifyFooterTagsHoverBG)){
		echo "#footer .widget .tagcloud a:hover{ background-color: ";
		echo $classifyFooterTagsHoverBG;
		echo "; } ";
	}
	if(!empty($classifyFooterTagsTxtColor)){
		echo ".widget .tagcloud a{ color: ";
		echo $classifyFooterTagsTxtColor;
		echo " !important; } ";
	}
	if(!empty($classifyFooterTagsTxtHoverColor)){
		echo ".widget .tagcloud a:hover{ color: ";
		echo $classifyFooterTagsTxtHoverColor;
		echo " !important; } ";
	}
	// Footer Colors Options end//	
	//Classify callout v2
	if($classifyCalloutHeading){
		echo "section.classify_callout_parallax .parallax_content h4{ color: ";
		echo $classifyCalloutHeading;
		echo " !important; } ";
	}
	if($classifyCalloutDescription){
		echo "section.classify_callout_parallax .parallax_content p{ color: ";
		echo $classifyCalloutDescription;
		echo " !important; } ";
	}
	if($redux_demo['classify_callout_bg']){
		?>
		section.classify_callout_parallax{
		background-color:<?php echo $redux_demo['classify_callout_bg']['background-color']; ?> !important;
		background-image:url("<?php echo $redux_demo['classify_callout_bg']['background-image']; ?>");
		background-repeat:<?php echo $redux_demo['classify_callout_bg']['background-repeat']; ?>;
		background-position:<?php echo $redux_demo['classify_callout_bg']['background-position']; ?>;
		background-size:<?php echo $redux_demo['classify_callout_bg']['background-size']; ?>;		
		}
		<?php
	}
	//Classify callout v2	
	echo "</style>";

}