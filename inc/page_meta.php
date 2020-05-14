<?php

add_action( 'add_meta_boxes', 'classify_meta_box_add' );
function classify_meta_box_add(){
	add_meta_box( 'page_metabox', __( 'Page Meta', 'classify' ), 'classify_page_metabox', 'page', 'normal', 'high' );
}

function classify_page_metabox( $post ){
	$values = get_post_custom( $post->ID );
	$layerslider_shortcode = isset( $values['layerslider_shortcode'] ) ? esc_attr( $values['layerslider_shortcode'][0] ) : '';
	$page_custom_title = isset( $values['page_custom_title'] ) ? esc_attr( $values['page_custom_title'][0] ) : '';
	$selected = isset( $values['page_slider'] ) ? esc_attr( $values['page_slider'][0] ) : '';
	wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
	?>
	
	<div style="padding:20px 0;">		
		<?php 
		//Begin shortcode array
			$shortcodes = array(
				'progress_bar' => array(
					'attr' => array(
						'title' => 'text',
						'percent' => 'text',
						'color' => 'text',
					),
					'desc' => array(
						'title' => 'Progress Bar Title',
						'percent' => 'Progress Bar Percent (ex: 50)',
						'color' => 'Progress Bar background Color (ex: #FC5136)',
					),
					'content' => FALSE,
				),	
				'normal_button' => array(
					'attr' => array(
						'type' => 'select',
						'url' => 'text',
					),
					'desc' => array(
						'type' => 'List type',
						'url' => 'Enter button link here',
					),
					'options' => array(
						'default' => 'Default',
						'primary' => 'Primary',
						'success' => 'Success',
						'info' => 'Info',
						'warning' => 'Warning',
						'danger' => 'Danger',
						'link' => 'Link',						
					),
					'content' => TRUE,
					'content_text' => 'Enter button text',
				),
				'large_button' => array(
					'attr' => array(
						'type' => 'select',
						'url' => 'text',
					),
					'desc' => array(
						'type' => 'List type',
						'url' => 'Enter button link here',
					),
					'options' => array(
						'default' => 'Default',
						'primary' => 'Primary',
						'success' => 'Success',
						'info' => 'Info',
						'warning' => 'Warning',
						'danger' => 'Danger',
						'link' => 'Link',
					),
					'content' => TRUE,
					'content_text' => 'Enter button text',
				),
				'large_button_block' => array(
					'attr' => array(
						'type' => 'select',
						'url' => 'text',
					),
					'desc' => array(
						'type' => 'List type',
						'url' => 'Enter button link here',
					),
					'options' => array(
						'default' => 'Default',
						'primary' => 'Primary',
						'success' => 'Success',
						'info' => 'Info',
						'warning' => 'Warning',
						'danger' => 'Danger',
						'link' => 'Link',
					),
					'content' => TRUE,
					'content_text' => 'Enter button text',
				),
				'dropcap' => array(
					'attr' => array(),
					'desc' => array(),
					'content' => TRUE,
				),				
				'quote' => array(
					'attr' => array(),
					'desc' => array(),
					'content' => TRUE,
				),				
				'toggle' => array(
					'attr' => array(
						'title' => 'text',
					),
					'desc' => array(
						'title' => 'Enter toggle title',
					),
					'content' => TRUE,
					'content_text' => 'Toggle content',
				),
				'faq_toggle' => array(
					'attr' => array(
						'title' => 'text',
					),
					'desc' => array(
						'title' => 'Enter faq question',
					),
					'content' => TRUE,
					'content_text' => 'FAQ answer',
				),
				'notification_success' => array(
					'content' => TRUE,
				),	
				'notification_info' => array(
					'content' => TRUE,
				),
				'notification_warning' => array(
					'content' => TRUE,
				),
				'notification_danger' => array(
					'content' => TRUE,
				),
			);

		?>
		<script>
		jQuery(document).ready(function(){ 
			jQuery('#shortcode_select').change(function() {
				var target = jQuery(this).val();
				jQuery('.rm_section').css('display', 'none');
				jQuery('#div_'+target).css('display', '');
			});	
			
			jQuery('.code_area').click(function() { 
				document.getElementById(jQuery(this).attr('id')).focus();
				document.getElementById(jQuery(this).attr('id')).select();
			});
			
			jQuery('.button').click(function() { 
				var target = jQuery(this).attr('id');
				var gen_shortcode = '';
				gen_shortcode+= '['+target;
				
				if(jQuery('#'+target+'_attr_wrapper .attr').length > 0)
				{
					jQuery('#'+target+'_attr_wrapper .attr').each(function() {
						gen_shortcode+= ' '+jQuery(this).attr('name')+'="'+jQuery(this).val()+'"';
					});
				}
				
				gen_shortcode+= ']';
				
				if(jQuery('#'+target+'_content').length > 0)
				{
					gen_shortcode+= jQuery('#'+target+'_content').val()+'[/'+target+']';
					
					var repeat = jQuery('#'+target+'_content_repeat').val();
					for (count=1;count<=repeat;count=count+1)
					{
						if(count<repeat)
						{
							gen_shortcode+= '['+target+']';
							gen_shortcode+= jQuery('#'+target+'_content').val()+'[/'+target+']';
						}
						else
						{
							gen_shortcode+= '['+target+'_last]';
							gen_shortcode+= jQuery('#'+target+'_content').val()+'[/'+target+'_last]';
						}
					}
				}
				
				jQuery('#'+target+'_code').val(gen_shortcode);
			});
		});
		</script>
		<div class="custom-page-title">
			<label style="float: left; width: 160px;" for="page_custom_title"><strong><?php esc_html_e("Put Second Page Title ", 'classify') ?></strong></label>
			<input style="width: 260px;" type="text" name="page_custom_title" id="page_custom_title" value="<?php echo $page_custom_title; ?>" />
		</div>
		<div style="margin-top: 20px; margin-bottom: 20px; float: left; width: 100%; border-top: solid 1px #d7d7d7;"></div>
		<span style="font-size: 16px; font-family: 'Armata','Helvetica Neue',Arial,Helvetica,Geneva,sans-serif; font-weight: lighter;"><?php esc_html_e("Shortcode Generator ", 'classify') ?></span><br/>		
		<div style="margin-top: 20px; margin-bottom: 20px; float: left; width: 100%; border-top: solid 1px #d7d7d7;"></div>
		
		<div style="float: left; margin-bottom: 40px; width: 100%;">		
		<?php if(!empty($shortcodes)){ ?>
				
				<label style="float: left; width: 160px;" for="page_slider"><strong><?php esc_html_e("Select Shortcode ", 'classify') ?></strong></label>
				
				<div style="margin-left: 30px; float: left;">
				
					<select id="shortcode_select" style="width: 260px;">
						<option value=""><?php esc_html_e("---Select--- ", 'classify') ?></option>
				
		<?php
				foreach($shortcodes as $shortcode_name => $shortcode)
				{
		?>
		
				<option value="<?php echo $shortcode_name; ?>"><?php echo $shortcode_name; ?></option>
		
		<?php
				}
		?>
					</select>
					<span style="font-style: italic; float: left; margin-top: 5px;"><?php esc_html_e("Select shortcode. ", 'classify') ?></span>
				
				</div>
				
				<div style="margin-top: 20px; margin-bottom: 20px; float: left; width: 100%; border-top: solid 1px #d7d7d7;"></div>
		<?php
			}
		?>
		
		<br/><br/>
		
		<?php
			if(!empty($shortcodes))
			{
				foreach($shortcodes as $shortcode_name => $shortcode)
				{
		?>
		
				<div id="div_<?php echo $shortcode_name; ?>" class="rm_section" style="display:none">
					<div class="rm_title">
						<h3><?php echo ucfirst($shortcode_name); ?></h3>
						<div class="clearfix"></div>
					</div>
					
					<div class="rm_text" style="padding: 10px 0 20px 0">
					
					<!-- img src="<?php echo $plugin_url.'/'.$shortcode_name.'.png'; ?>" alt=""/><br/><br/><br/ -->
					
					<?php
						if(isset($shortcode['content']) && $shortcode['content'])
						{
							if(isset($shortcode['content_text']))
							{
								$content_text = $shortcode['content_text'];
							}
							else
							{
								$content_text = 'Your Content';
							}
					?>
					
					<strong><?php echo $content_text; ?>:</strong><br/>
					<input type="hidden" id="<?php echo $shortcode_name; ?>_content_repeat" value="<?php echo $shortcode['repeat']; ?>"/>
					<textarea id="<?php echo $shortcode_name; ?>_content" style="width:100%;height:70px" rows="3" wrap="off"></textarea><br/><br/>
					
					<?php
						}
					?>
				
					<?php
						if(isset($shortcode['attr']) && !empty($shortcode['attr']))
						{
					?>
							
							<div id="<?php echo $shortcode_name; ?>_attr_wrapper">
							
					<?php
							foreach($shortcode['attr'] as $attr => $type)
							{
					?>
					
								<?php echo '<strong>'.ucfirst($attr).'</strong>: '.$shortcode['desc'][$attr]; ?><br/><br/>
								
								<?php
									switch($type)
									{
										case 'text':
								?>
								
										<input type="text" id="<?php echo $shortcode_name; ?>_text" style="width:100%" class="attr" name="<?php echo $attr; ?>"/>
								
								<?php
										break;
										
										case 'select':
								?>
								
										<select id="<?php echo $shortcode_name; ?>_select" style="width:25%" class="attr" name="<?php echo $attr; ?>">
										
											<?php
												if(isset($shortcode['options']) && !empty($shortcode['options']))
												{
													foreach($shortcode['options'] as $select_key => $option)
													{
											?>
											
														<option value="<?php echo $select_key; ?>"><?php echo $option; ?></option>
											
											<?php	
													}
												}
											?>							
										
										</select>
								
								<?php
										break;
									}
								?>
								
								<br/><br/>
					
					<?php
							} //end attr foreach
					?>
					
							</div>
					
					<?php
						}
					?>
					<br/>
					
					<input type="button" id="<?php echo $shortcode_name; ?>" value="Generate Shortcode" class="button"/>
					
					<br/><br/><br/>
					
					<strong><?php esc_html_e("Shortcode: ", 'classify') ?></strong><br/>
					<textarea id="<?php echo $shortcode_name; ?>_code" style="width:90%;height:70px" rows="3" readonly="readonly" class="code_area" wrap="off"></textarea>
					
					</div>
					
				</div>
		
		<?php
				} //end shortcode foreach
			}
		?>
		
		</div>


		
		<div id="pageSliderOption" style="display: none;">

			<span style="font-size: 16px; font-family: 'Armata','Helvetica Neue',Arial,Helvetica,Geneva,sans-serif; font-weight: lighter;"><?php esc_html_e("Page Sliders ", 'classify') ?></span><br/>
			
			<div style="margin-top: 20px; margin-bottom: 20px; float: left; width: 100%; border-top: solid 1px #d7d7d7;"></div>



			
			<div style="float: left; margin-bottom: 40px; width: 100%;">
			
				<label style="float: left; width: 160px;" for="page_slider"><strong><?php esc_html_e("Page slider ", 'classify') ?></strong></label>
				
				<div style="margin-left: 30px; float: left;">
					<select name="page_slider" id="page_slider" style="width: 260px;">
						<option value="none" <?php selected( $selected, 'none' ); ?>><?php esc_html_e("none ", 'classify') ?></option>
						<option value="googlemap" <?php selected( $selected, 'googlemap' ); ?>><?php esc_html_e("Big Map ", 'classify') ?></option>
						<option value="layerslider" <?php selected( $selected, 'layerslider' ); ?>><?php esc_html_e("LayerSlider ", 'classify') ?></option>
					</select>
					<span style="font-style: italic; float: left; margin-top: 5px;"><?php esc_html_e("Select page slider. ", 'classify') ?></span>
				</div>				
			</div>			
			<div id="layerslidershortcode" style="display: none; float: left; margin-bottom: 40px; width: 100%;">
			
				<label style="float: left; width: 160px;" for="layerslider_shortcode"><strong><?php esc_html_e("LayeSlider Shortcode ", 'classify') ?></strong></label>
				
				<div style="margin-left: 30px; float: left;">
					<input style="width: 260px;" type="text" name="layerslider_shortcode" id="layerslider_shortcode" value="<?php echo $layerslider_shortcode; ?>" />
					<span style="font-style: italic; float: left; margin-top: 5px;"><?php esc_html_e("Enter layerslider shortcode ", 'classify') ?></span>
				</div>
				
			</div>

		</div>			
		<script>
		jQuery(document).ready(function(){ 

			var val = jQuery("#page_template").val();
			if( val === "default" || val === "template-home-v1.php" || val === "template-page-fullwidth.php" || val === "template-left-sidebar.php") {
			    jQuery("#pageSliderOption").css({"display":"block"});
			} else {
			    jQuery("#pageSliderOption").css({"display":"none"});
			}

			jQuery("#page_template").on('change', function() {
			    var val = jQuery(this).val();
			    if( val === "default" || val === "template-home-v1.php" || val === "template-page-fullwidth.php" || val === "template-left-sidebar.php") {
			        jQuery("#pageSliderOption").css({"display":"block"});
			    } else {
			        jQuery("#pageSliderOption").css({"display":"none"});
			    }
			});


			var val2 = jQuery("#page_slider").val();
			if( val2 === "layerslider" ) {
			    jQuery("#layerslidershortcode").css({"display":"block"});
			} else {
			    jQuery("#layerslidershortcode").css({"display":"none"});
			}
			
			jQuery("#page_slider").on('change', function() {
			    var val2 = jQuery(this).val();
			    if( val2 === "layerslider" ) {
			        jQuery("#layerslidershortcode").css({"display":"block"});
			    } else {
			        jQuery("#layerslidershortcode").css({"display":"none"});
			    }
			});

		});
		</script>
		
		<span style="visibility: hidden;"><p>Page meta end</p></span>
	</div>
	
	<?php	
}


add_action( 'save_post', 'cd_meta_box_save' );
function cd_meta_box_save( $post_id )
{
	// Bail if we're doing an auto save
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	
	// if our nonce isn't there, or we can't verify it, bail
	if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;
	
	// if our current user can't edit this post, bail
	if( !current_user_can( 'edit_post' ) ) return;
	
	// now we can actually save the data
	$allowed = array( 
		'a' => array( // on allow a tags
			'href' => array() // and those anchords can only have href attribute
		)
	);
	
	// Probably a good idea to make sure your data is set
	if( isset( $_POST['layerslider_shortcode'] ) ){
		update_post_meta( $post_id, 'layerslider_shortcode', wp_kses( $_POST['layerslider_shortcode'], $allowed ) );
	}	
	if( isset( $_POST['page_slider'] ) ){
		update_post_meta( $post_id, 'page_slider', esc_attr( $_POST['page_slider'] ) );
	}
	if( isset( $_POST['page_custom_title'] ) ){
		update_post_meta( $post_id, 'page_custom_title', esc_attr( $_POST['page_custom_title'] ) );
	}	
		
}
?>
