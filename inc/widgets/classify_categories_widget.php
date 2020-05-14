<?php
class classifycategoryWidget extends WP_Widget {
    public function __construct() {		
			$widget_ops = array('classname' => 'classifycategoryWidget', 'description' => esc_html__( 'Classify Categories', 'classify' ));
			parent::__construct( 'classifycategoryWidget', esc_html__( 'Classify Categories', 'classify' ), $widget_ops );
    }
    function widget($args, $instance) {
        global $post;
		extract($instance);
		$counter = $instance['counter'];
		if(empty($counter)){
			$counter = '';
		}
		$title = apply_filters('widget_title', $instance['title']);
		echo $args['before_widget'] ;
		echo $args['before_title'].$title.$args['after_title'];
		?>
		<div class="widget__content">
			<div class="widget__content_subcat">			
				<ul class="list-unstyled">
				<?php
				global $redux_demo;
				$classifyCatStyle = $redux_demo['classify_cat_icon_img'];
				$classifyCatsAdsCount = $redux_demo['classify_cats_ads_count'];
				$arags = array(
					'parent' => 0,
					'orderby' => 'name',
					'order' => 'ASC',
					'number' => $counter,
					'hide_empty' => false,
				);
				$categories = get_terms('category', $arags);						
				$current = -1;						
				$category_icon_code = "";
				$category_icon_color = "";
				$your_image_url = "";
				foreach ($categories as $category) {							
					$tag = $category->term_id;							
					$tag_extra_fields = get_option(MY_CATEGORY_FIELDS);
					if (isset($tag_extra_fields[$tag])) {
						$category_icon_code = $tag_extra_fields[$tag]['category_icon_code'];
						$category_icon_color = $tag_extra_fields[$tag]['category_icon_color'];
						$classifyCatIcoIMG = $tag_extra_fields[$tag]['your_image_url'];
					}
					?>
					<li>
						<a href="<?php echo get_category_link( $category->term_id )?>" title="<?php esc_html_e('View posts in', 'classify');?> <?php echo $category->name?>">
							<?php if($classifyCatStyle == 'img'){?>
								<img class="classify__widgetimg" src="<?php echo $classifyCatIcoIMG; ?>" alt="<?php echo $category->name; ?>">
							<?php }else{?>
								<i class="<?php echo $category_icon_code; ?>" style="background-color:<?php echo $category_icon_color; ?>;"></i>
							<?php } ?>
							<?php echo $category->name ?>
							<span>
							<?php 
								if($classifyCatsAdsCount == 1){
									$q = new WP_Query( array(
										'nopaging' => true,
										'tax_query' => array(
											array(
												'taxonomy' => 'category',
												'field' => 'id',
												'terms' => $tag,
												'include_children' => true,
											),
										),
										'fields' => 'ids',
									));
									$allPosts = $q->post_count;
									echo $allPosts; 
								}else{
									echo '&nbsp;';
								}
							?>
							</span>
						</a>
					</li>
					<?php } ?>
				</ul>
			</div><!--widget__content_subcat-->
		</div><!--widget__content-->
	<?php		
	echo $args['after_widget'] ; 
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        /* Strip tags (if needed) and update the widget settings. */
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['counter'] = strip_tags($new_instance['counter']);
       
        return $instance;
    }

    function form($instance) {
	extract($instance);
       ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e('Title:', 'classify');?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>"  />
        </p>
		<p>
            <label for="<?php echo $this->get_field_id('counter'); ?>"><?php esc_html_e('Counter:', 'classify');?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('counter'); ?>" name="<?php echo $this->get_field_name('counter'); ?>" value="<?php echo $instance['counter']; ?>"  />
        </p>
        <?php
    }
}
add_action('widgets_init', create_function('', 'return register_widget("classifycategoryWidget");'));
 ?>