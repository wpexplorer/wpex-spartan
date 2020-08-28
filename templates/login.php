<?php
/**
 * Template Name: Login
 *
 * @package WordPress
 * @subpackage Spartan WPExplorer Theme
 * @since Spartan 1.0
 */

get_header();

if ( isset( $_POST['adduser'] ) && isset( $_POST['add-nonce'] ) && wp_verify_nonce( $_POST['add-nonce'], 'add-user' ) ) {

	// Die if the nonce fails
	if ( ! wp_verify_nonce( $_POST['add-nonce'],'add-user' ) ) {
		wp_die( 'Sorry! That was secure, guess you\'re cheatin huh!', 'spartan' );
	}

	// Setup new user
	else {
		$userdata = array(
			'user_login'		=> esc_attr( $_POST['user_name'] ),
			'user_email'		=> esc_attr( $_POST['email'] ),
			'user_pass'			=> esc_attr( $_POST['register_user_pass'] ),
			'user_pass_repeat'	=> esc_attr( $_POST['register_user_pass_repeat'] ),
			'role'				=> get_option( 'default_role' ),
		);
		
		// Username check
		if ( ! $userdata['user_login'] ) {
			$error = __( 'A <strong>username</strong> is required for registration.', 'spartan' );
		} elseif ( username_exists( $userdata['user_login'] ) ) {
			$error = __( 'Sorry, that username already exists!', 'spartan' );
		}

		// Email check
		elseif ( ! $userdata['user_email'] ) {
			$error = __( 'An <strong>email</strong> is required for registration.', 'spartan' );
		} elseif ( !is_email( $userdata['user_email'] ) ) {
			$error = __( 'You must enter a valid email address.', 'spartan' );
		} elseif ( email_exists($userdata['user_email'] ) ) {
			$error = __( 'Sorry, that email address is already used!', 'spartan' );
		}

		// Pass 1 or Password 2
		elseif ( ! $userdata['user_pass'] ){
			$error = __( 'A <strong>password</strong> is required for registration.', 'spartan' );
		}

		// Password match
		elseif( $userdata['user_pass'] != $userdata['user_pass_repeat'] ){
			$error = __( 'Password do not match.', 'spartan' );
		}

		// setup new users and send notification
		else{
			$new_user = wp_insert_user( $userdata );
			wp_new_user_notification( $new_user, $userdata['user_pass'] );
		}
	}
} ?>
	<div id="primary" class="content-area clr">
		<div id="content" class="site-content left-content" role="main">
			<?php
			// Start loop
			while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" class="clr">
					<div class="entry clr">
						<div class="login-template-content clr">
							<?php the_content(); ?>
						</div><!-- .login-template-content -->
						<div class="login-template-forms clr">
							<?php
							// If user is already logged in
							if( is_user_logged_in() ) { ?>
								<div class="already-loggedin-msg clr">
									<p><?php
									// Get current user and display already logged in message
									$current_user = wp_get_current_user();
									echo __( 'You are already logged in as:', 'spartan' ) .' <span>'. $current_user->display_name; ?><span></p>
									<a href="<?php echo wp_logout_url( get_permalink() ); ?>" class="theme-button light"><?php _e( 'Logout', 'spartan' ); ?></a>
								</div><!-- .already-loggedin-msg -->
							<?php }
							// Display login form & register form
							else { ?>
								<div class="login-form clr">
									<h2><?php _e( 'Login to an account', 'spartan' ); ?></h2>
									<?php
									/**
									 * Display login form
									 *
									 * @link http://codex.wordpress.org/Function_Reference/wp_login_form
									 */
									wp_login_form( array(
										'label_username'	=> '',
										'label_password'	=> '',
										'remember'			=> false,
									) ); ?>
									<a href="<?php echo wp_lostpassword_url(); ?>" title="<?php _e( 'Lost Password? Recover it here.', 'spartan' ); ?>"><?php _e( 'Lost Password?', 'spartan' ); ?></a>
								</div><!-- .login-form -->
								<hr class="thick-hr" />
								<div class="register-form clr">
									<?php
									// User was created display message
									if ( isset( $new_user ) ) { ?>
										<div class="notice green registration-notice">
											<?php _e( 'Registration successful. You can now log in above.', 'spartan' ); ?>
										</div><!-- .notice -->
									<?php }
									// User not created, display error
									elseif ( !isset( $new_user ) && isset( $error ) && !empty( $error ) ) { ?>
										<div class="notice yellow registration-notice">
											<?php echo wp_kses_post( $error ); ?>
										</div><!-- .notice -->
									<?php } ?>
									<h2><?php _e( 'Register for an account', 'spartan' ); ?></h2>
									<form method="POST" id="adduser" class="user-forms" action="" autocomplete="off">
										<input class="text-input" name="user_name" type="text" id="user_name" value="<?php echo isset( $_POST['user_name'] ) ? $_POST['user_name'] : ''; ?>" placeholder="<?php echo 'Username *'; ?>" />
										<input class="text-input" name="email" type="text" id="email" value="<?php echo isset( $_POST['email'] ) ? $_POST['email'] : ''; ?>" placeholder="<?php echo 'E-mail *'; ?>" />
										<input class="text-input" name="register_user_pass" type="password" id="register_user_pass" value="" placeholder="<?php echo 'Password *'; ?>" />
										<input class="text-input" name="register_user_pass_repeat" type="password" id="register_user_pass_repeat" value="" placeholder="<?php echo 'Confirm Password *'; ?>" />
										<div class="strength"><span><?php _e( 'Strength indicator', 'spartan' ); ?></span></div>
										<p class="form-submit">
											<input name="adduser" type="submit" id="addusersub" class="submit button" value="Register" />
											<?php wp_nonce_field( 'add-user', 'add-nonce' ) ?>
											<input name="action" type="hidden" id="action" value="adduser" />
										</p>
									</form>
									<?php
									// Enqueue password strength js
									wp_enqueue_script( 'password-strength-meter' ); ?>
									<script>
									// <![CDATA[
										jQuery(function(){
											// Password check
											function password_strength() {
												var pass = jQuery('#register_user_pass').val();
												var pass2 = jQuery('#register_user_pass_repeat').val();
												var user = jQuery('#user_name').val();
												jQuery('.strength').removeClass('short bad good strong empty mismatch');
												if ( !pass ) {
													jQuery('#pass-strength-result').html( pwsL10n.empty );
													return;
												}
												var strength = passwordStrength(pass, user, pass2);
												if ( 2 == strength )
													jQuery('.strength').addClass('bad').html( pwsL10n.bad );
												else if ( 3 == strength )
													jQuery('.strength').addClass('good').html( pwsL10n.good );
												else if ( 4 == strength )
													jQuery('.strength').addClass('strong').html( pwsL10n.strong );
												else if ( 5 == strength )
													jQuery('.strength').addClass('mismatch').html( pwsL10n.mismatch );
												else
													jQuery('.strength').addClass('short').html( pwsL10n.short );
											}
											jQuery('#register_user_pass, #register_user_pass_repeat').val('').keyup( password_strength );
										});
										pwsL10n = {
											empty: "<?php _e( 'Strength indicator', 'spartan' ) ?>",
											short: "<?php _e( 'Very weak', 'spartan' ) ?>",
											bad: "<?php _e( 'Weak', 'spartan' ) ?>",
											good: "<?php _e( 'Medium', 'spartan' ) ?>",
											strong: "<?php _e( 'Strong', 'spartan' ) ?>",
											mismatch: "<?php _e( 'Mismatch', 'spartan' ) ?>"
										}
									try{convertEntities(pwsL10n);}catch(e){};
									// ]]>
									</script>
								</div><!-- .register-form -->
							<?php } ?>
						</div><!-- .login-template-forms -->
					</div><!-- .entry -->
				</article><!-- #post-<?php the_ID(); ?> -->
			<?php
			// End loop
			endwhile; ?>
		</div><!-- #content -->
		<?php
		// Get sidebar if post layout meta isn't set to fullwidth
		if( 'fullwidth' != get_post_meta( get_the_ID(), 'wpex_post_layout', true ) ) {
			get_sidebar();
		} ?>
	</div><!-- #primary -->
<?php get_footer(); ?>