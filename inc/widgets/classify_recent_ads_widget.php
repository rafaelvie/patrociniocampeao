<?php
class classify_recent_ads_widget extends WP_Widget{
    public function __construct() {		
        $widget_ops = array('classname' => 'classify_recent_ads_widget', 'description' => esc_html__( 'Classify Regular and Featured ads', 'classify' ));       
		parent::__construct( 'classify_recent_ads_widget', esc_html__( 'Classify Ads widget', 'classify' ), $widget_ops );
    }
    function widget($args, $instance) {
        global $post;
        extract(array(
            'title' => '',
            'theme' => 'post_nothumbnailed',
            'post_order' => 'latest',
            'post_type' => 'post',
			'post_status' => 'publish',
        ));
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);		
        $post_count = 5;
        if (isset($instance['number_posts']))
            $post_count = $instance['number_posts'];
        $q['posts_per_page'] = $post_count;
        $cats = (array) $instance['post_category'];
        $q['paged'] = 1;
        $q['post_type'] = $instance['post_type'];
        $q['post_status'] = 'publish';
        if (count($cats) > 0) {
            $typ = 'category';
	    if ($instance['post_type'] != 'post')
		$typ = 'catalog';
            $catq = '';
            $sp = '';
            foreach ($cats as $mycat) {
                $catq = $catq . $sp . $mycat;
                $sp = ',';
            }
            $catq = explode(',', $catq);
            $q['tax_query'] = Array(
				Array(
                    'taxonomy' => $typ,
                    'terms' => $catq,
                    'field' => 'id'
                )
            );			
			if ($instance['post_order'] == 'commented'){
				$q['tax_query'] = Array(
				Array(
						'taxonomy' => $typ,
						'terms' => $catq,
						'field' => 'id',
						'posts_per_page' => -1,
						'meta_query' => array(
						array(
							'key' => 'featured_post',
							'value' => '1',
							'compare' => '=='
							)
						),
					)
				);
			}
			$featuredArags = array(
				'post_type' => 'post',
				'posts_per_page' => $post_count,
				'meta_query' => array(
					array(
						'key' => 'featured_post',
						'value' => '1',
						'compare' => '=='
					)
				),
				'tax_query' => array(
					array(
						'taxonomy' => $typ,
						'field' => 'id',
						'terms' => $catq,
					)
				)
			);
        } 
		$featuredArags = array(
			'post_type' => 'post',
			'orderby' => 'rand',
			'posts_per_page' => $post_count,
			'meta_query' => array(
				array(
					'key' => 'featured_post',
					'value' => '1',
					'compare' => '=='
				)
			),
			'cat' => $cats,
		);			
		if ($instance['post_order'] == 'commented'){
			query_posts($featuredArags);
		}else{
			query_posts($q);
		}
		$current = -1;
		$featuredCurrent = 0;
        echo $args['before_widget'] ;      
		echo $args['before_title'] . $title . $args['after_title'];
		if($instance['post_order'] == 'commented'){
			echo '<ul class="list-unstyled widget__premium">';
		}else{
			echo '<ul class="list-unstyled widget__latest_ad media-list">';
		}
        while ( have_posts() ) : the_post();
		
		if($instance['post_order'] == 'commented'){
			$featured_post = 0;
           $featuredMeta = get_post_meta($post->ID, 'featured_post', true);
		   $post_price_plan_activation_date = get_post_meta($post->ID, 'post_price_plan_activation_date', true);
			$post_price_plan_expiration_date = get_post_meta($post->ID, 'post_price_plan_expiration_date', true);
			$post_price_plan_expiration_date_noarmal = get_post_meta($post->ID, 'post_price_plan_expiration_date_normal', true);
		   $todayDate = strtotime(date('m/d/Y h:i:s'));
		   $expireDate = $post_price_plan_expiration_date;
		   if(!empty($post_price_plan_activation_date) && $featuredMeta == 1){
				if(($todayDate < $expireDate) or $post_price_plan_expiration_date == 0){
					$featured_post = 1;
				}
			}			
		   if($featured_post == 1){ 
				$current++; 
			if($current+1 <= $post_count){
				$classifyThumSrc = "";
				$classifyThumURL = "";				
				if ( has_post_thumbnail()){
					$classifyThumSrc = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
					$classifyThumURL = $classifyThumSrc[0];
				}else{
					$classifyThumURL = get_template_directory_uri() . '/images/nothumb.png';
				}
				$post_price = get_post_meta($post->ID, 'post_price', true);
				$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
				if(empty($post_currency_tag)){
					global $redux_demo;
					$post_currency_tag = $redux_demo['classify_post_currency'];
				}
				$post_currency_tag = classify_Display_currency_sign($post_currency_tag);
		   ?>
			<li>
				<a href="<?php echo esc_url(get_permalink($post->ID)); ?>">
					<img src="<?php echo $classifyThumURL; ?>" alt="<?php echo get_the_title();?>">
					<a href="<?php echo esc_url(get_permalink($post->ID)); ?>" class="item-hover">
						<span>
							<?php 
							if(is_numeric($post_price)){
								echo $post_currency_tag.$post_price; 
							}else{
								echo $post_price; 
							}
							?>
						</span>
					</a>
				</a>
			</li>	
			<?php }
		   }
		}else{
			$classifyThumSrc = "";
			$classifyThumURL = "";
			if($current+2 <= $post_count){
				if ( has_post_thumbnail()){
					$classifyThumSrc = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
					$classifyThumURL = $classifyThumSrc[0];
				}else{
					$classifyThumURL = get_template_directory_uri() . '/images/nothumb.png';
				}
				$post_price = get_post_meta($post->ID, 'post_price', true);
				$post_currency_tag = get_post_meta($post->ID, 'post_currency_tag', true);
				if(empty($post_currency_tag)){
					global $redux_demo;
					$post_currency_tag = $redux_demo['classify_post_currency'];
				}
				$post_currency_tag = classify_Display_currency_sign($post_currency_tag);
            ?>
			<li class="media">
				<div class="media-left">
					<a href="<?php echo esc_url(get_permalink($post->ID)); ?>">
						<img class="media-object" src="<?php echo $classifyThumURL; ?>" alt="<?php echo get_the_title();?>">
					</a>
				</div>
				<div class="media-body">
					<h5 class="media-heading">
						<a href="<?php echo esc_url(get_permalink($post->ID)); ?>"><?php echo get_the_title();?></a>
					</h5>
					<span class="price">
						<?php 
						if(is_numeric($post_price)){
							echo $post_currency_tag.$post_price; 
						}else{
							echo $post_price; 
						}
						?>
					</span>
					<p><?php echo get_the_excerpt();?></p>
				</div>
			</li>
			<?php
			}
			$current++;
		}
        endwhile;
		echo '</ul>';
		echo $args['after_widget'] ; 
        wp_reset_query();
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        /* Strip tags (if needed) and update the widget settings. */
        $instance['title'] = strip_tags($new_instance['title']);
        if ($new_instance['post_type'] == 'post') {
			$instance['post_category'] = $_REQUEST['post_category'];
		}else {
			$tax = get_object_taxonomies($new_instance['post_type']);
			$instance['post_category'] = $_REQUEST['tax_input'][$tax[0]];
		}
        $instance['number_posts'] = strip_tags($new_instance['number_posts']);
        $instance['post_type'] = strip_tags($new_instance['post_type']);
        $instance['post_order'] = strip_tags($new_instance['post_order']);        
        $instance['theme'] = strip_tags($new_instance['theme']);
        return $instance;
    }

    function form($instance) {
        //Output admin widget options form
        extract(shortcode_atts(array(
                    'title' => '',
                    'theme' => 'post_nothumbnailed',
                    'number_posts' => 5,
                    'post_order' => 'latest',                   
                    'post_type' => 'post'
                        ), $instance));
        $defaultThemes = Array(
            Array("name" => 'Thumbnailed posts', 'user_func' => 'post_thumbnailed'),
            Array("name" => 'Default posts', 'user_func' => 'post_nonthumbnailed')
        );
        $themes = apply_filters('jw_recent_posts_widget_theme_list', $defaultThemes);
        $defaultPostTypes = Array(Array("name" => 'Post', 'post_type' => 'post')); ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:', 'classify');?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>"  />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('post_order'); ?>"><?php esc_html_e('Post order', 'classify');?>:</label>
            <select class="widefat" id="<?php echo $this->get_field_id('post_order'); ?>" name="<?php echo $this->get_field_name('post_order'); ?>">
                <option value="latest" <?php if ($post_order == 'latest') print 'selected="selected"'; ?>><?php esc_html_e('Latest Ads', 'classify');?></option>
                <option value="commented" <?php if ($post_order == 'commented') print 'selected="selected"'; ?>><?php esc_html_e('Featured Ads', 'classify');?></option>
            </select>
        </p>		
       <?php 
        $customTypes = apply_filters('jw_recent_posts_widget_type_list', $defaultPostTypes);
        if (count($customTypes) > 0) { ?>
            <p style="display: none;">
                <label for="<?php echo $this->get_field_id('post_type'); ?>"><?php esc_html_e('Post from', 'classify');?>:</label>
                <select rel="<?php echo $this->get_field_id('post_cats'); ?>" onChange="jw_get_post_terms(this);" class="widefat" id="<?php echo $this->get_field_id('post_type'); ?>" name="<?php echo $this->get_field_name('post_type'); ?>"><?php
                    foreach ($customTypes as $postType) { ?>
                        <option value="<?php print $postType['post_type'] ?>" <?php echo selected($post_type, $postType['post_type']); ?>><?php print $postType['name'] ?></option><?php
                    } ?>
                </select>
            </p><?php
        } ?>
        <p><?php esc_html_e('If you were not selected for cats, it will show all categories.', 'classify');?></p>
        <div id="<?php echo $this->get_field_id('post_cats'); ?>" style="height:150px; overflow:auto; border:1px solid #dfdfdf;"><?php
            $post_type='post';
            $tax = get_object_taxonomies($post_type);

            $selctedcat = false;
            if (isset($instance['post_category']) && $instance['post_category'] != ''){
                $selctedcat = $instance['post_category'];
            }
            wp_terms_checklist(0, array('taxonomy' => $tax[0], 'checked_ontop' => false, 'selected_cats' => $selctedcat)); ?>
        </div>
        <p>
            <label for="<?php echo $this->get_field_id('number_posts'); ?>"><?php esc_html_e('Number of posts to show', 'classify');?>:</label>
            <input  id="<?php echo $this->get_field_id('number_posts'); ?>" name="<?php echo $this->get_field_name('number_posts'); ?>" value="<?php echo $number_posts; ?>" size="3"  />
        </p><?php
    }
}
add_action('widgets_init', create_function('', 'return register_widget("classify_recent_ads_widget");'));
add_action('wp_ajax_themewave_recent_post_terms', 'get_post_type_terms');
function get_post_type_terms() {
    $cat = 'post';
    if (isset($_REQUEST['post_format']) && $_REQUEST['post_format'] != '')
        $cat = $_REQUEST['post_format'];
    $tax = get_object_taxonomies($cat);
    wp_terms_checklist(0, array('taxonomy' => $tax[0], 'checked_ontop' => false, 'selected_cats' => false));
    die;
} ?>