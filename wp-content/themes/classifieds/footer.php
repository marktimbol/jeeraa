<?php
$show_clients = classifieds_get_option( 'show_clients' );
$ads_search_layout = classifieds_get_option( 'ads_search_layout' );
$page_template = get_page_template_slug();
?>

<?php if( $page_template !== 'page-tpl_search_page.php' || ( $page_template !== 'page-tpl_search_page.php'&& $ads_search_layout !== 'style-left' ) ): ?>

	<?php
	if( $show_clients == 'yes' && $page_template !== 'page-tpl_my_profile.php' ):
	?>
	<section class="clients-bar">
		<div class="container">
			<?php
			$clients = new WP_Query(array(
				'post_type' => 'client',
				'posts_per_page' => '-1',
				'post_status' => 'publish'
			));
			if( $clients->have_posts() ):
			?>
			<div class="clients-owl">
				<?php
				while( $clients->have_posts() ){
					$clients->the_post();
					$client_link = get_post_meta( get_the_ID(), 'client_link', true );
					?>
					<div class="client">
						<a href="<?php echo esc_url( $client_link ) ?>" title="<?php esc_attr__( get_the_title() ) ?>">
							<?php the_post_thumbnail( 'full' ); ?>
						</a>
					</div>
					<?php
				}
				?>
			</div>
			<?php
			endif;
			wp_reset_postdata();
			?>
		</div>
	</section>
	<?php endif; ?>


	<?php
	$show_subscribe = classifieds_get_option( 'show_subscribe' );
	if( $show_subscribe == 'yes' && $page_template !== 'page-tpl_my_profile.php' ):
	?>
	<section class="subscribe-bar">
		<div class="container">
			<?php $footer_subscribe_text = classifieds_get_option( 'footer_subscribe_text' ); ?>
			<?php if( !empty( $footer_subscribe_text ) ): ?>
				<h2><?php echo esc_html( $footer_subscribe_text ); ?></h2>
			<?php endif; ?>

			<?php $footer_subscribe_subtext = classifieds_get_option( 'footer_subscribe_subtext' ); ?>
			<?php if( !empty( $footer_subscribe_subtext ) ): ?>
				<p><?php echo esc_html( $footer_subscribe_subtext ); ?></p>
			<?php endif; ?>

			<form class="subscribe-box">
				<div class="subscribe-input-wrap">
					<i class="fa fa-envelope"></i>
					<input type="text" class="form-control" placeholder="<?php esc_attr_e( 'Type your email here...', 'classifieds' ) ?>" name="email">
				</div>
				<a href="javascript:;" class="footer-subscribe btn submit-form-ajax"><?php esc_html_e( 'Subscribe', 'classifieds' ) ?></a>
				<input type="hidden" name="action" value="subscribe">
				<div class="ajax-response"></div>
			</form>
		</div>
	</section>
	<?php endif; ?>

	<?php get_sidebar('footer'); ?>

	<?php
	$footer_copyrights = classifieds_get_option( 'footer_copyrights' );

	if( !empty( $footer_copyrights ) ):
	?>
		<section class="footer">
			<div class="container">
				<?php echo wp_kses_post( $footer_copyrights ) ?>
			</div>
		</section>
	<?php
	endif;
	?>

<?php endif ?>

<!-- modal -->
<div class="modal fade in" id="login" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
				<h4><?php esc_html_e( 'Login', 'classifieds' ) ?></h4>		
					
				<form class="form-login">
					<label for="login-username"><?php esc_html_e( 'Username', 'classifieds' ) ?></label>
					<input type="text" name="login-username" id="login-username" class="form-control" />

					<label for="login-password"><?php esc_html_e( 'Password', 'classifieds' ) ?></label>
					<input type="password" name="login-password" id="login-password" class="form-control" />	

					<div class="row">
						<div class="col-xs-6">
							<div class="checkbox checkbox-inline">
								<input type="checkbox" name="login-remember" id="login-remember" />
								<label for="login-remember"><?php esc_html_e( 'Remember me', 'classifieds' ) ?></label>
							</div>
						</div>
						<div class="col-xs-6 text-right">
							<a href="javascript:;" class="forgot-password" data-dismiss="modal"><?php esc_html_e( 'Forgot Password?', 'classifieds' ) ?></a>
						</div>
					</div>

					<a href="javascript:;" class="btn submit-form-ajax"><?php esc_html_e( 'LOGIN', 'classifieds' ) ?></a>
					<?php esc_html_e( ' or ', 'classifieds' ); ?>
					<a href="javascript:;" class="register-close-login" data-dismiss="modal"><?php esc_html_e( 'register here', 'classifieds' ) ?></a>
					<input type="hidden" name="action" value="login">
					<div class="ajax-response"></div>

                    <?php
                    if( function_exists( 'sc_render_login_form_social_connect' ) ){
                    	?>
                    	<h4><?php esc_html_e( 'Social login', 'classifieds' ) ?></h4>
                    	<p><?php esc_html_e( 'Simply use your social network profiles to login', 'classifieds' ) ?></p>
                    	<?php
                        sc_render_login_form_social_connect();
                    }
                    ?>					
				</form>
			</div>
		</div>
	</div>
</div>

<!-- .modal -->
<!-- modal -->
<div class="modal fade in" id="register" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
				<h4><?php esc_html_e( 'Register', 'classifieds' ) ?></h4>
				<form class="form-register">

					<div class="row">
						<div class="col-md-6">
							<label for="register-username"><?php esc_html_e( 'Username', 'classifieds' ) ?></label>
							<input type="text" name="register-username" id="register-username" class="form-control" />						
						</div>
						<div class="col-md-6">
							<label for="register-email"><?php esc_html_e( 'Email', 'classifieds' ) ?></label>
							<input type="text" name="register-email" id="register-email" class="form-control" />						
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<label for="register-password"><?php esc_html_e( 'Password', 'classifieds' ) ?></label>
							<input type="password" name="register-password" id="register-password" class="form-control" />							
						</div>					
						<div class="col-md-6">
							<label for="register-password-repeat"><?php esc_html_e( 'Repeat Password', 'classifieds' ) ?></label>
							<input type="password" name="register-password-repeat" id="register-password-repeat" class="form-control" />							
						</div>
					</div>

					<a href="javascript:;" class="btn submit-form-ajax"><?php esc_html_e( 'REGISTER', 'classifieds' ) ?></a>
					<?php esc_html_e( ' or ', 'classifieds' ); ?>
					<a href="javascript:;" class="register-close-login" data-dismiss="modal"><?php esc_html_e( 'login here', 'classifieds' ) ?></a>					
					<input type="hidden" name="action" value="register">
					<div class="ajax-response"></div>

                    <?php
                    if( function_exists( 'sc_render_login_form_social_connect' ) ){
                    	?>
                    	<div class="row">
                    		<div class="col-md-6">
                    			<h4><?php esc_html_e( 'Social register', 'classifieds' ) ?></h4>
                    			<p><?php esc_html_e( 'Use your social network profiles to login', 'classifieds' ) ?></p>
                    		</div>
                    		<div class="col-md-6 text-right">
                    			<?php
                        		sc_render_login_form_social_connect();
                        		?>
                        	</div>
                        </div>
                        <?php
                    }
                    ?>					
				</form>
			</div>
		</div>
	</div>
</div>
<!-- .modal -->

<div class="modal fade in" id="recover" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
				<h4><?php esc_html_e( 'Recover Password & Username', 'classifieds' ) ?></h4>
				<form class="form-login">
					<label for="recover-email"><?php esc_html_e( 'Email', 'classifieds' ) ?></label>
					<input type="text" name="recover-email" id="recover-email" class="form-control" />


					<a href="javascript:;" class="btn submit-form-ajax"><?php esc_html_e( 'RECOVER', 'classifieds' ) ?></a>
					<input type="hidden" name="action" value="recover">
					<div class="ajax-response"></div>
					
				</form>
			</div>
		</div>
	</div>
</div>

<?php $ads_advanced_search = classifieds_get_option( 'ads_advanced_search' );
if( $ads_advanced_search == 'yes' ):
?>
<div class="modal fade in" id="filters" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
				<div class="filters-modal-holder">
					<?php classifieds_custom_filter(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>

<?php
if( is_singular( 'ad' ) ){
	?>
	<div class="modal fade in" id="share" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
					<h4><?php esc_html_e( 'Share Ad', 'classifieds' ) ?></h4>
					<?php get_template_part( 'includes/share' ) ?>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade in" id="question" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
					<h4><?php esc_html_e( 'Ask Question', 'classifieds' ) ?></h4>
					<form class="form-ask">
						<label for="ask-name"><?php esc_html_e( 'Name', 'classifieds' ) ?></label>
						<input type="text" name="name" id="ask-name" class="form-control" />

						<label for="ask-email"><?php esc_html_e( 'Email', 'classifieds' ) ?></label>
						<input type="text" name="email" id="ask-email" class="form-control" />	

						<label for="ask-message"><?php esc_html_e( 'Message', 'classifieds' ) ?></label>
						<p class="description"><?php esc_html_e( 'Ask question to seller regarding this product.', 'classifieds' ) ?></p>
						<textarea name="message" id="ask-message" class="form-control"></textarea>

						<a href="javascript:;" class="btn submit-form-ajax"><?php esc_html_e( 'ASK QUESTION', 'classifieds' ) ?></a>
						<input type="hidden" name="action" value="ask_question">
						<input type="hidden" name="ad_id" value="<?php the_ID(); ?>">
						<div class="ajax-response"></div>					
					</form>
				</div>
			</div>
		</div>
	</div>	

	<div class="modal fade in" id="report" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
					<h4><?php esc_html_e( 'Report Ad', 'classifieds' ) ?></h4>
					<form class="form-ask">
						<label for="report-name"><?php esc_html_e( 'Name', 'classifieds' ) ?></label>
						<input type="text" name="name" id="report-name" class="form-control" />

						<label for="report-email"><?php esc_html_e( 'Email', 'classifieds' ) ?></label>
						<input type="text" name="email" id="report-email" class="form-control" />	

						<label for="report-message"><?php esc_html_e( 'Reason', 'classifieds' ) ?></label>
						<p class="description"><?php esc_html_e( 'Please briefly explain why you are reporting this ad and why it should be removed.', 'classifieds' ) ?></p>
						<textarea name="message" id="report-message" class="form-control"></textarea>

						<a href="javascript:;" class="btn submit-form-ajax"><?php esc_html_e( 'REPORT AD', 'classifieds' ) ?></a>
						<input type="hidden" name="action" value="report">
						<input type="hidden" name="ad_id" value="<?php the_ID(); ?>">
						<div class="ajax-response"></div>					
					</form>
				</div>
			</div>
		</div>
	</div>	
	<?php
}
?>
<div class="modal fadein" id="payUAdditional" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content showCode-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
				<div class="payu-content-modal">
				</div>
			</div>
		</div>
	</div>
</div>
<?php
$confirmation_hash = isset( $_GET['confirmation_hash'] ) ? $_GET['confirmation_hash'] : '';
if( !empty( $confirmation_hash ) ){
    $username = $_GET['username'];
    $username = esc_sql( $username );
    $user = get_user_by( 'login', $username );
    if( !empty( $user ) ){
        $confirmation_hash = get_user_meta( $user->ID, 'confirmation_hash', true );
        if( !empty( $confirmation_hash ) && $confirmation_hash == $confirmation_hash ){
            update_user_meta( $user->ID, 'user_active_status', 'active' );
            $message = '<div class="alert alert-success">'.esc_html__( 'Thank you for confirming your email. Now you can proceed to login.', 'classifieds' ).'</div>';
        }
        else{
            $message = '<div class="alert alert-danger">'.esc_html__( 'Wrong confirmation hash.', 'classifieds' ).'</div>';
        }
    }
    else{
        $message = '<div class="alert alert-danger">'.esc_html__( 'There is no user with that username.', 'classifieds' ).'</div>';
    }
}
if( !empty( $message ) ){
	?>
	<div class="modal fadein" id="confirmation" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
					<div class="confirm-body">
						<?php echo  $message; ?>
					</div>
				</div>
			</div>
		</div>
	</div>	
	<?php
}
?>
<?php
wp_footer();
?>
</body>
</html>