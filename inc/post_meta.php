<?php
	/*Make it Featured*/
	
	add_action( 'add_meta_boxes', 'featured_post' );
	function featured_post() {
	    add_meta_box( 
	        'featured_post',
	        __( 'Make it Fatured post', 'classify' ),
	        'classieraFeaturedPost',
	        'post',
	        'side',
	        'high'
	    );
	}
	// Show The Post On Slider Option
	function classieraFeaturedPost() {
		global $post;
		
		// Noncename needed to verify where the data originated
		echo '<input type="hidden" name="eventmeta_noncename" id="eventmeta_noncename" value="' . 
		wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
		
		// Get the location data if its already been entered
		$featured_post = get_post_meta($post->ID, 'featured_post', true);
		
		// Echo out the field
		echo '<span class="text overall" style="margin-right: 20px;">Is this Featured Post:</span>';
		
		$checked = get_post_meta($post->ID, 'featured_post', true) == '1' ? "checked" : "";
		
		echo '<input type="checkbox" name="featured_post" id="featured_post" value="1" '. $checked .'/>';

	}
	
	add_action( 'save_post', 'wpcrown_save_post_meta' );
	// Save the Metabox Data
	function wpcrown_save_post_meta($post_id) {
		global $post;
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
	/*Make it Featured*/

	// Post price box
	add_action( 'add_meta_boxes', 'post_price' );
	function post_price() {
	    add_meta_box( 
	        'post_price',
	        __( 'Price', 'classify' ),
	        'post_price_content',
	        'post',
	        'side',
	        'high'
	    );
	}
	function post_price_content( $post ) {
		$post_price = get_post_meta( $post->ID, 'post_price', true );
		echo '<label for="post_price"></label>';
		echo '<input type="text" id="post_price" name="post_price" placeholder="Enter price here" value="';
		echo $post_price; 
		echo '">';		
	}
	add_action( 'save_post', 'post_price_save' );
	function post_price_save( $post_id ) {
		global $post_price;
		if(isset($_POST["post_price"])){	
			$post_price = $_POST['post_price'];
			update_post_meta( $post_id, 'post_price', $post_price );
		}
	}
	// Post location box
	add_action( 'add_meta_boxes', 'post_location' );
	function post_location() {
	    add_meta_box( 
	        'post_location',
	        __( 'Location', 'classify' ),
	        'post_location_content',
	        'post',
	        'side',
	        'high'
	    );
	}
	function post_location_content( $post ) {
		$post_location = get_post_meta( $post->ID, 'post_location', true );
		echo '<label for="post_location"></label>';
		echo '<input type="text" id="post_location" name="post_location" placeholder="Enter location here" value="';
		echo $post_location; 
		echo '">';
		
	}
	add_action( 'save_post', 'post_location_save' );
	function post_location_save( $post_id ) {
		global $post_location;
		if(isset($_POST["post_location"]))
		{	
			$post_location = $_POST['post_location'];
			update_post_meta( $post_id, 'post_location', $post_location );
		}
	}
	// Post latitude
	add_action( 'add_meta_boxes', 'post_latitude' );
	function post_latitude() {
	    add_meta_box( 
	        'post_latitude',
	        __( 'Latitude', 'classify' ),
	        'post_latitude_content',
	        'post',
	        'side',
	        'high'
	    );
	}
	function post_latitude_content( $post ) {
		$post_latitude = get_post_meta( $post->ID, 'post_latitude', true );
		echo '<label for="post_latitude"></label>';
		echo '<input type="text" id="post_latitude" name="post_latitude" placeholder="Enter location here" value="';
		echo $post_latitude; 
		echo '">';		
	}
	add_action( 'save_post', 'post_latitude_save' );
	function post_latitude_save( $post_id ) {
		global $post_latitude;
		if(isset($_POST["post_latitude"]))
		{	
			$post_latitude = $_POST['post_latitude'];
			update_post_meta( $post_id, 'post_latitude', $post_latitude );
		}
	}
	// Post longitude
	add_action( 'add_meta_boxes', 'post_longitude' );
	function post_longitude() {
	    add_meta_box( 
	        'post_longitude',
	        __( 'Longitude', 'classify' ),
	        'post_longitude_content',
	        'post',
	        'side',
	        'high'
	    );
	}
	function post_longitude_content( $post ) {
		$post_longitude = get_post_meta( $post->ID, 'post_longitude', true );
		echo '<label for="post_longitude"></label>';
		echo '<input type="text" id="post_longitude" name="post_longitude" placeholder="Enter location here" value="';
		echo $post_longitude; 
		echo '">';		
	}
	add_action( 'save_post', 'post_longitude_save' );
	function post_longitude_save( $post_id ) {
		global $post_longitude;
		if(isset($_POST["post_longitude"]))
		{	
			$post_longitude = $_POST['post_longitude'];
			update_post_meta( $post_id, 'post_longitude', $post_longitude );
		}
	}

?>
