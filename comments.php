<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains comments and the comment form.
 *
 * @package WordPress
 * @subpackage classify
 * @since classify 1.0
 */

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() )
	return;
?>

<section id="form" class="comments">	
	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
				printf( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'classify' ),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
		</h2>

		<ol class="comment-list">
			<?php
				
				wp_list_comments( array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 74,
				) );
			?>
		</ol><!-- .comment-list -->

		<?php
			// Are there comments to navigate through?
			if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
		?>
		<nav class="navigation comment-navigation" role="navigation">
			<h1 class="screen-reader-text section-heading"><?php _e( 'Comment navigation', 'classify' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'classify' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'classify' ) ); ?></div>
		</nav><!-- .comment-navigation -->
		<?php endif; // Check for comment navigation ?>

		<?php if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="no-comments"><?php _e( 'Comments are closed.' , 'classify' ); ?></p>
		<?php endif; ?>

	<?php endif; // have_comments() ?>
	<?php 
	$args = array(
	  'id_form'           => 'commentform',
	  'class_form'      => 'comment-form',
	  'id_submit'         => 'submit',
	  'class_submit'      => 'submit',
	  'name_submit'       => 'submit',
	  'title_reply'       => __( 'Leave a Reply', 'classify'),
	  'title_reply_to'    => __( 'Leave a Reply to %s', 'classify'),
	  'cancel_reply_link' => __( 'Cancel Reply', 'classify'),
	  'label_submit'      => __( 'Post Comment', 'classify'),
	  'format'            => 'xhtml',

	  'comment_field' =>  '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun', 'classify') .
		'</label><textarea class="form-control" id="comment" name="comment" cols="45" rows="8" aria-required="true">' .
		'</textarea></p>',

	  'must_log_in' => '<p class="must-log-in">' .
		sprintf(
		  __( 'You must be <a href="%s">logged in</a> to post a comment.', 'classify'),
		  wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
		) . '</p>',

	  'logged_in_as' => '<p class="logged-in-as">' .
		sprintf(
		__( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'classify'),
		  admin_url( 'profile.php' ),
		  $user_identity,
		  wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )
		) . '</p>',

	  'comment_notes_before' => '<p class="comment-notes">' .
		__( 'Your email address will not be published.', 'classify') . ( $req ? $required_text : '' ) .
		'</p>',

	  'comment_notes_after' => '<p class="form-allowed-tags">' .
		sprintf(
		  __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s', 'classify'),
		  ' <code>' . allowed_tags() . '</code>'
		) . '</p>',

	  'fields' => apply_filters( 'comment_form_default_fields', $fields ),
	);
?>
	<?php comment_form(); ?>

</section><!-- #comments -->