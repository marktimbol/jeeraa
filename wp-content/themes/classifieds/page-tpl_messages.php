<?php
/*
    Template Name: My Messages
*/

if( !is_user_logged_in() ){
    wp_redirect( home_url() );
}

get_header();
the_post();
get_template_part( 'includes/title' );
global $current_user;
$current_user = wp_get_current_user();

$userID = $current_user->ID;
global $classifieds_slugs;

$subpage = isset( $_GET[$classifieds_slugs['subpage']] ) ? $_GET[$classifieds_slugs['subpage']] : '';

$permalink = classifieds_get_permalink_by_tpl( 'page-tpl_my_profile' );


/* MY PROFILE VARS */
$my_profile = array(
    'first_name',
    'last_name',
    'city',
    'email',
    'phone_number',
    'cover_image',
    'avatar',
    'description',
    'twitter',
    'linkedin',
    'instagram',
    'facebook',
    'google',
);

$message = '';
$pasword_changes = false;
$can_update = true;

if( isset( $_POST['update_profile'] ) ){
    foreach( $my_profile as $item_name ){
        if( $item_name !== 'email' ){
            update_user_meta( $userID, $item_name, $_POST[$item_name] );
        }
    }

    $email = $_POST['email'];

    if( !filter_var( $email, FILTER_VALIDATE_EMAIL ) ){
        $message .= '<div class="alert alert-danger">'.esc_html__( 'Invalid email address.', 'classifieds' ).'</div>';
        $can_update = false;
    }

    if( !empty( $_POST['new_password'] ) ){
        if( empty( $_POST['new_password_repeat'] ) || ( $_POST['new_password'] !== $_POST['new_password_repeat'] ) ){
            $message .= '<div class="alert alert-danger">'.esc_html__( 'Passwords do not match.', 'classifieds' ).'</div>';
            $can_update = false;
        }
        else{
            $pasword_changes = true;
        }
    }

    if( $can_update ){
        $update_fields = array(
            'ID'            => $userID,
            'user_email'    => $email
        );

        if( !empty( $first_name ) || !empty( $$last_name ) ){
            $update_fields['display_name'] = $first_name.' '.$last_name;
        }
 
        if( $pasword_changes ){
            $update_fields['user_pass'] = $_POST['new_password'];
        }
        wp_update_user( $update_fields );   
        $current_user = wp_get_current_user();

        $message .= '<div class="alert alert-success">'.esc_html__( 'Profile updated.', 'classifieds' ).'</div>';

        $_POST['wp-user-avatar'] = $_POST['avatar'];
        global $wp_user_avatar;
        $wp_user_avatar->wpua_action_process_option_update( $userID );        
    }
}

foreach( $my_profile as $item_name ){
    if( $item_name !== 'email' ){
        $$item_name = get_user_meta( $userID, $item_name, true );
    }
}

?>

<section class="page-template-page-tpl_my_profile">
    <div class="container">
        <div class="row">

            <div class="col-md-4">

                <div class="widget white-block">
                    <h4><i class="fa fa-pencil"></i> <?php esc_html_e( 'Dashboard', 'classifieds' ); ?></h4>
                

                    <?php $my_profile_sidebar = true; include( classifieds_load_path( 'includes/author-info.php' ) ); ?>

                    <?php if( !empty( $twitter ) || !empty( $linkedin ) || !empty( $linkedin ) || !empty( $facebook ) || !empty( $google ) ): ?>

                        <ul class="list-unstyled list-inline my-networks">
                            <li><?php esc_html_e( 'My network: ', 'classifieds' ); ?></li>
                            <?php if( !empty( $twitter ) ): ?>
                                <li><a href="<?php echo esc_url( $twitter ) ?>" class="twitter" target="_blank"><i class="fa fa-twitter"></i></a></li>
                            <?php endif; ?>
                            <?php if( !empty( $linkedin ) ): ?>
                                <li><a href="<?php echo esc_url( $linkedin ) ?>" class="linkedin" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                            <?php endif; ?>
                            <?php if( !empty( $facebook ) ): ?>
                                <li><a href="<?php echo esc_url( $facebook ) ?>" class="facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>
                            <?php endif; ?>
                            <?php if( !empty( $google ) ): ?>
                                <li><a href="<?php echo esc_url( $google ) ?>" class="google-plus" target="_blank"><i class="fa fa-google-plus"></i></a></li>
                            <?php endif; ?>
                        </ul>

                    <?php endif; ?>

                    <ul class="list-unstyled">
                        <li class="<?php echo empty( $subpage ) ? 'active' : '' ?>">
                            <a href="<?php echo esc_url( $permalink ); ?>">
                                <h4><?php esc_html_e( 'My Ads', 'classifieds' ) ?></h4>
                            </a>
                        </li>
                        <li class="<?php echo $subpage == 'edit_profile' ? esc_attr__( 'active' ) : '' ?>">
                            <a href="<?php echo esc_url( add_query_arg( array( $classifieds_slugs['subpage'] => 'edit_profile' ), $permalink ) ); ?>">
                                <h4><?php esc_html_e( 'My Profile', 'classifieds' ) ?></h4>
                            </a>
                        </li>
                        <li class="<?php echo $subpage == 'submit_ad' ? esc_attr__( 'active' ) : '' ?>">
                            <a href="<?php echo esc_url( add_query_arg( array( $classifieds_slugs['subpage'] => 'submit_ad' ), $permalink ) ); ?>">
                                <h4><?php esc_html_e( 'Submit Ad', 'classifieds' ) ?></h4>
                            </a>
                        </li>
                        <li class="<?php echo $subpage == 'view_messages' ? esc_attr__( 'active' ) : '' ?>">
                            <a href="<?php echo esc_url( add_query_arg( array( $classifieds_slugs['subpage'] => 'view_messages' ), $permalink ) ); ?>">
                                <h4><?php esc_html_e( 'Messages', 'classifieds' ) ?></h4>
                            </a>
                        </li>                        
                    </ul>
                    <a href="<?php echo esc_url( wp_logout_url( home_url( '/' ) ) ); ?>" class="logout">
                        <?php esc_html_e( 'Log Out', 'classifieds' ) ?>
                    </a>
                </div>

            </div>

            <div class="col-md-8"> 
                <?php                              
                include( classifieds_load_path( 'includes/profile-pages/private-messaging.php' ) );
                ?>
            </div>

        </div>
    </div>
</section>

<?php get_footer(); ?>