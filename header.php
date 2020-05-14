<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "container" div.
 *
 * @package WordPress
 * @subpackage classify
 * @since classify 4.0
 */

?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<?php 
	if (isset($_SERVER['HTTP_USER_AGENT']) &&
    (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))
        header('X-UA-Compatible: IE=9');
	global $redux_demo; 
	$classifyFavicon = $redux_demo['favicon']['url'];
	$classifyLogo = $redux_demo['logo']['url'];
	$classifyLayout = $redux_demo['layout-version'];
?>
	<head>	
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1">	
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<?php 
		if(is_front_page()){
			?>
		<meta property="og:image" content="<?php echo $classifyLogo; ?>"/>
			<?php
		}elseif(is_single()){
			$ID = $wp_query->post->ID;
			$classifyOGIMG = wp_get_attachment_url( get_post_thumbnail_id($ID) );
			?>
		<meta property="og:image" content="<?php echo $classifyOGIMG; ?>"/>
			<?php
		}
		?>
		<?php
		if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) {			
			if (!empty($classifyFavicon)){
			?>
			<link rel="shortcut icon" href="<?php echo $classifyFavicon; ?>" type="image/x-icon" />
			<?php }else{ ?>
			<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.ico" type="image/x-icon">
			<?php
			}
		}
		?>
		<!--[if lt IE 9]>
		<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
		<![endif]-->
		<?php wp_head(); ?>
	</head>
	<body <?php if($classifyLayout == 'boxed'){ ?>id="boxed" <?php } ?> <?php body_class(); ?>>
		<!--Start Header section-->
		<section id="header">
			<header>
				<?php get_template_part( 'templates/classify-offcnavas' ); ?>
				<?php get_template_part( 'templates/classify-top-bar' ); ?>
				<?php get_template_part( 'templates/classify-menu-bar' ); ?>
			</header>
		</section>
		<!--End Header section-->