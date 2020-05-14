<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage classify
 * @since classify 1.0
 */
?>
<?php 
global $redux_demo; 
$classifyCopyright = $redux_demo['footer_copyright'];
$classifyBTTop = $redux_demo['classify_backtotop'];
$classifywidgets = $redux_demo['classify_footer_widgets'];
?>
	<section id="footer">
		<footer <?php if($classifywidgets != 1){?>style="padding:20px 0;"<?php }?>>
			<div class="container">
				<?php if($classifywidgets == 1){?>
                <div class="row">
					<?php dynamic_sidebar( 'footer' ); ?>
				</div>
				<?php } ?>
				<div class="row">
                    <div class="col-md-12">
                        <div class="copyright text-center" <?php if($classifywidgets != 1){?>style="margin:0;"<?php }?>>
                            <p><?php if($classifyCopyright){echo $classifyCopyright;}?></p>
                        </div>
                    </div>
                </div>
			</div>
			<?php if($classifyBTTop == 1){?>
				<a href="#" class="back-to-top"><i class="fa fa-angle-up"></i></a>
			<?php } ?>
		</footer>
	</section>
	<?php wp_footer(); ?>
	</body>
</html>