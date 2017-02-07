<?php
/*
	Template Name: Contact Page
*/
get_header();
the_post();
get_template_part( 'includes/title' );
?>
<section class="contact-page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="white-block top-border">
                        <?php
                        $contact_map = classifieds_get_option( 'contact_map' );
                        if( !empty( $contact_map[0] ) ){
                            echo '<div class="contact_map">';
                                foreach( $contact_map as $long_lat ){
                                    echo '<input type="hidden" value="'.esc_attr__( $long_lat ).'" class="contact_map_marker">';
                                }
                                $contact_map_scroll_zoom = classifieds_get_option( 'contact_map_scroll_zoom' );
                                if( $contact_map_scroll_zoom == 'yes' ){
                                    echo '<input type="hidden" value="1" class="contact_map_scroll_zoom">';
                                }
                                ?>
                                <div class="embed-responsive embed-responsive-16by9">
                                    <div id="map" class="embed-responsive-item"></div>
                                </div>                        
                                <?php
                            echo '</div>';
                        }
                        ?>
                    
                    <div class="white-block-content">
                        <div class="row">
                            <div class="col-md-6">
                                <h4><?php esc_html_e( 'Send Message', 'classifieds' ) ?></h4>
                                <form>
                                    <div class="input-group">
                                        <label for="name"><?php esc_html_e( 'Name', 'classifieds' ) ?></label>
                                        <input type="text" class="form-control" name="name" id="name">
                                    </div>
                                    <div class="input-group">
                                        <label for="name"><?php esc_html_e( 'Email', 'classifieds' ) ?></label>
                                        <input type="text" class="form-control" name="email" id="text">
                                    </div>
                                    <div class="input-group">
                                        <label for="name"><?php esc_html_e( 'Message', 'classifieds' ) ?></label>
                                        <textarea class="form-control" name="message" id="message"></textarea>
                                    </div>
                                    <input type="hidden" name="action" value="contact">
                                    <a class="btn submit-form-ajax" href="javascript:;"><?php esc_html_e( 'SEND MESSAGE', 'classifieds' ); ?></a>
                                    <div class="ajax-response"></div>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <div class="page-content clearfix">
                                    <?php the_content(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php get_footer(); ?>