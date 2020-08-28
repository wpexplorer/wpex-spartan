<?php
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments
 * template simply create your own wpex_comment(), and that function
 * will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @package WordPress
 * @subpackage Spartan WPExplorer Theme
 * @since Spartan 1.0
 */

if ( ! function_exists( 'wpex_comment' ) ) {
	function wpex_comment( $comment, $args, $depth ) {
		global $post;
		$author_id = $post->post_author;
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' :
			// Display trackbacks differently than normal comments. ?>
		<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
			<div class="pingback-entry"><span class="pingback-heading"><?php _e( 'Pingback:', 'spartan' ); ?></span> <?php comment_author_link(); ?></div>
		<?php
			break;
			default :
			// Proceed with normal comments. ?>
		<li id="li-comment-<?php comment_ID(); ?>">
			<div id="comment-<?php comment_ID(); ?>" <?php comment_class('clr'); ?>>
				<?php if ( get_option( 'show_avatars' ) ){ ?>
					<div class="comment-author vcard">
						<?php echo get_avatar( $comment, 60 ); ?>
					</div><!-- .comment-author -->
				<?php } ?>
				<div class="comment-details clr <?php if ( ! get_option( 'show_avatars' ) ) echo 'avatars-disabled'; ?>">
					<header class="comment-meta">
						<cite class="fn">
							<?php if ( get_theme_mod( 'wpex_comment_author_link' ) ) { ?>
								<?php comment_author(); ?>
							<?php } else { ?>
								<?php comment_author_link(); ?>
							<?php } ?>
							<?php
							// Author badge
							$comment_user_id = $comment->user_id;
							if ( $comment_user_id ) {
								$wpex_user = new WP_User( $comment_user_id );
								if ( isset( $wpex_user->roles[0] ) ) { ?>
									<?php if ( $author_id == $comment_user_id ) { ?>
											<span class="author-badge"><?php _e( 'Author', 'spartan' ); ?></span>
									<?php } ?>
								<?php }
							} ?>
						</cite>
						<span class="comment-date">
						<?php printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
							esc_url( get_comment_link( $comment->comment_ID ) ),
							get_comment_time( 'c' ),
							sprintf( _x( '%1$s', '1: date', 'spartan' ), get_comment_date() )
						); ?> <?php _e( 'at', 'spartan' ); ?> <?php comment_time(); ?>
						</span><!-- .comment-date -->
					</header><!-- .comment-meta -->
					<?php if ( '0' == $comment->comment_approved ) : ?>
						<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'spartan' ); ?></p>
					<?php endif; ?>
					<div class="comment-content entry clr">
						<?php comment_text(); ?>
					</div><!-- .comment-content -->
					<div class="reply comment-reply-link">
						<?php comment_reply_link( array_merge( $args, array(
							'reply_text'	=> __( 'Reply to this message', 'spartan' ),
							'depth'			=> $depth,
							'max_depth'		=> $args['max_depth'] )
						) ); ?>
					</div><!-- .reply -->
				</div><!-- .comment-details -->
			</div><!-- #comment-## -->
		<?php
			break;
		endswitch; // End comment_type check.
	}
}