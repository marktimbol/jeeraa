<?php

$email = $current_user->user_email;

?>

<div class="white-block">
    <div class="white-block-content">
        <h4><i class="fa fa-user"></i> &nbsp; <?php esc_html_e( 'My Profile', 'classifieds' ) ?></h4>
    </div>
</div>


<?php
if( !empty( $message ) ){
    echo '<div class="ad-manage">';
        echo  $message;
    echo '</div>';
}
?>

<!-- Nav tabs -->
<ul class="nav nav-tabs profile-tabs" role="tablist">
    <li role="presentation" class="active">
        <a href="#basic" aria-controls="basic" role="tab" data-toggle="tab">
            <?php esc_html_e( 'Basic', 'classifieds' ) ?>
        </a>
    </li>
    <li role="presentation">
        <a href="#contact" aria-controls="contact" role="tab" data-toggle="tab">
            <?php esc_html_e( 'Contact', 'classifieds' ) ?>
        </a>
    </li>
    <li role="presentation">
        <a href="#about" aria-controls="about" role="tab" data-toggle="tab">
            <?php esc_html_e( 'About', 'classifieds' ) ?>
        </a>
    </li>
    <li role="presentation">
        <a href="#social" aria-controls="social" role="tab" data-toggle="tab">
            <?php esc_html_e( 'Social', 'classifieds' ) ?>
        </a>
    </li>
    <li role="presentation">
        <a href="#password" aria-controls="password" role="tab" data-toggle="tab">
            <?php esc_html_e( 'Password', 'classifieds' ) ?>
        </a>
    </li>    
</ul>

<!-- Tab panes -->
<form method="post" class="profile-form" action="#basic">
    <div class="white-block">
        <div class="white-block-content">
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="basic">

                    <div class="row">
                        <div class="col-md-6">
                            <label for="first_name"><?php esc_html_e( 'First Name', 'classifieds' ); ?></label>
                            <input type="text" name="first_name" id="first_name" value="<?php echo esc_attr__( $first_name ); ?>" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="last_name"><?php esc_html_e( 'Last Name', 'classifieds' ); ?></label>
                            <input type="text" name="last_name" id="last_name" value="<?php echo esc_attr__( $last_name ); ?>" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="city"><?php esc_html_e( 'Your City', 'classifieds' ); ?></label>
                            <input type="text" name="city" id="city" value="<?php echo esc_attr__( $city ); ?>" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="email"><?php esc_html_e( 'Your Email', 'classifieds' ); ?></label>
                            <input type="text" name="email" id="email" value="<?php echo esc_attr__( $email ); ?>" class="form-control">
                        </div>
                    </div>

                    <a href="javascript:;" class="submit-form">
                        <?php esc_html_e( 'SAVE CHANGES', 'classifieds' ); ?>
                    </a>

                </div>
                <div role="tabpanel" class="tab-pane" id="contact">

                    <div class="row">
                        <div class="col-md-6">
                            <label for="phone_number"><?php esc_html_e( 'Phone Number', 'classifieds' ); ?></label>
                            <input type="text" name="phone_number" id="phone_number" class="form-control" value="<?php echo esc_attr__( $phone_number ) ?>" />
                        </div>
                    </div>

                    <a href="javascript:;" class="submit-form">
                        <?php esc_html_e( 'SAVE CHANGES', 'classifieds' ); ?>
                    </a>        
                    
                </div>
                <div role="tabpanel" class="tab-pane" id="about">

<!--                     <div class="row">
                        <div class="col-md-6">
                            <label><?php esc_html_e( 'Cover Image', 'classifieds' ); ?></label>
                            <div class="image-wrap">
                                <?php if( !empty( $cover_image ) ){
                                    echo wp_get_attachment_image( $cover_image, 'thumbnail' );
                                    echo '<a href="javascript:;" class="remove-image">X</a>';
                                }?>
                            </div>
                            <a href="javascript:;" class="btn set-image"><?php esc_html_e( 'CHANGE COVER', 'classifieds' ) ?></a>
                            <input type="hidden" name="cover_image" id="cover_image" value="<?php echo esc_attr__( $cover_image ) ?>" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label><?php esc_html_e( 'Avatar', 'classifieds' ); ?></label>
                            <div class="image-wrap">
                                <?php if( !empty( $avatar ) ){
                                    echo wp_get_attachment_image( $avatar, 'thumbnail' );
                                    echo '<a href="javascript:;" class="remove-image">X</a>';
                                }?>
                            </div>
                            <a href="javascript:;" class="btn set-image"><?php esc_html_e( 'CHANGE AVATAR', 'classifieds' ) ?></a>
                            <input type="hidden" name="avatar" id="avatar" value="<?php echo esc_attr__( $avatar ) ?>" class="form-control">
                        </div>                
                    </div> -->

                    <label for="description"><?php esc_html_e( 'Description', 'classifieds' ); ?></label>
                    <textarea name="description" id="description" class="form-control"><?php echo  $description ?></textarea>

                    <a href="javascript:;" class="submit-form">
                        <?php esc_html_e( 'SAVE CHANGES', 'classifieds' ); ?>
                    </a>
                    
                </div>
                <div role="tabpanel" class="tab-pane" id="social">

                    <div class="row">
                        <div class="col-md-6">
                            <label for="twitter"><?php esc_html_e( 'Twitter', 'classifieds' ); ?></label>
                            <input type="text" name="twitter" id="twitter" value="<?php echo esc_url( $twitter ); ?>" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="linkedin"><?php esc_html_e( 'Linkedin', 'classifieds' ); ?></label>
                            <input type="text" name="linkedin" id="linkedin" value="<?php echo esc_url( $linkedin ); ?>" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="instagram"><?php esc_html_e( 'Instagram', 'classifieds' ); ?></label>
                            <input type="text" name="instagram" id="instagram" value="<?php echo esc_url( $instagram ); ?>" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="facebook"><?php esc_html_e( 'Facebook', 'classifieds' ); ?></label>
                            <input type="text" name="facebook" id="facebook" value="<?php echo esc_url( $facebook ); ?>" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="google"><?php esc_html_e( 'Google+', 'classifieds' ); ?></label>
                            <input type="text" name="google" id="google" value="<?php echo esc_url( $google ); ?>" class="form-control">
                        </div>
                    </div>            

                    <a href="javascript:;" class="submit-form">
                        <?php esc_html_e( 'SAVE CHANGES', 'classifieds' ); ?>
                    </a>
                    
                </div>
                <div role="tabpanel" class="tab-pane" id="password">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <label for="new_password"><?php esc_html_e( 'New Password', 'classifieds' ); ?></label>
                            <input type="password" name="new_password" id="new_password" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="new_password_repeat"><?php esc_html_e( 'New Password Repeat', 'classifieds' ); ?></label>
                            <input type="password" name="new_password_repeat" id="new_password_repeat" class="form-control">
                        </div>                
                    </div>

                    <a href="javascript:;" class="submit-form">
                        <?php esc_html_e( 'SAVE CHANGES', 'classifieds' ); ?>
                    </a>   

                </div>        
            </div>

            <input type="hidden" name="update_profile" value="1">
        </div>
    </div>
</form>