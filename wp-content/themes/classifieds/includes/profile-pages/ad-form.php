<?php

foreach( $my_profile as $item_name ){
    if( $item_name !== 'email' ){
        $$item_name = get_user_meta( $userID, $item_name, true );
    }
}

global $classifieds_slugs;

$ad_terms = classifieds_get_option('ad_terms');

$email = $current_user->user_email;

$is_edit = false;
if( $subpage == 'edit_ad' ){;
	$is_edit = true;
}

$ad_id = $is_edit && !empty( $_GET['ad_id'] ) ? $_GET['ad_id'] : 0;

if( $is_edit ){
    $ad = get_post( $ad_id );
}

$featured_image = '';
if( $is_edit && has_post_thumbnail( $ad_id ) ){
    $featured_image = get_post_thumbnail_id( $ad_id );
}

$ad_title = $is_edit ? $ad->post_title : '';
$ad_description = $is_edit ? $ad->post_content : '';
$ad_price = $is_edit ? get_post_meta( $ad_id, 'ad_price', true ) : '';
$ad_call_for_price = $is_edit ? get_post_meta( $ad_id, 'ad_call_for_price', true ) : '';
$ad_phone = $is_edit ? get_post_meta( $ad_id, 'ad_phone', true ) : '';
$ad_discounted_price = $is_edit ? get_post_meta( $ad_id, 'ad_discounted_price', true ) : '';
$ad_gmap_longitude = $is_edit ? get_post_meta( $ad_id, 'ad_gmap_longitude', true ) : '';
$ad_gmap_latitude = $is_edit ? get_post_meta( $ad_id, 'ad_gmap_latitude', true ) : '';
$ad_visibility = $is_edit ? get_post_meta( $ad_id, 'ad_visibility', true ) : '';
$ad_category = '';
$custom_fields = '';
if( $is_edit ){
    $cats = wp_get_object_terms( $ad_id, 'ad-category' );
    if( !empty( $cats ) ){
        $terms_organized = array();
        classifieds_sort_terms_hierarchicaly( $cats, $terms_organized );
        $cat = classifieds_get_last_category( $terms_organized );
        $ad_category = $cat->term_id;

        $custom_fields = classifieds_generate_custom_fields_html( $ad_id, $cats );
    }
}
$ad_tags = '';
if( $is_edit ){
    $tags = wp_get_post_terms( $ad_id, 'ad-tag', array( 'fields' => 'names' ) );
    $ad_tags = join( ',', $tags );
}
$ad_gmap_latitude = $is_edit ? get_post_meta( $ad_id, 'ad_gmap_latitude', true ) : '';
$ad_images = $is_edit ? classifieds_smeta_images( 'ad_images', $ad_id, array() ): array();
$ad_videos = $is_edit ? get_post_meta( $ad_id, 'ad_videos', true ) : array();
$ad_featured = $is_edit ? get_post_meta( $ad_id, 'ad_featured', true ) : array();
$ad_views = $is_edit ? get_post_meta( $ad_id, 'ad_views', true ) : 0;

$is_expired = false;
$ad_expire = get_post_meta( $ad_id, 'ad_expire', true );
if( !empty( $ad_expire ) && current_time( 'timestamp' ) > $ad_expire ){
    $is_edit = false;
    $is_expired = true;
}

$ad_paid = get_post_meta( $ad_id, 'ad_paid', true );
if( !empty( $ad_paid ) && $ad_paid == 'no' ){
    $is_edit = false;
    $is_expired = true;
}
?>

<div class="white-block">
    <div class="white-block-content">
        <h4><i class="fa fa-pencil"></i> 
        <?php 
        if( $is_edit ){
            esc_html_e( 'Edit Ad', 'classifieds' );
        }
        else if( $is_expired ){
            esc_html_e( 'Renew Ad', 'classifieds' );
        }
        else{
            esc_html_e( 'Submit Ad', 'classifieds' );
        }
        ?></h4>
    </div>
</div>

<div class="ajax-response ad-manage"></div>

<!-- Nav tabs -->
<ul class="nav nav-tabs <?php echo !$is_edit ? esc_attr( 'tab-disable' ) : '' ?>" role="tablist">
    <li role="presentation" class="active">
        <a href="#basic" aria-controls="basic" role="tab" data-toggle="tab">
            <?php
            if( !$is_edit ){
            	esc_html_e( '1. ', 'classifieds' );
            }
            esc_html_e( 'Basic', 'classifieds' );
            ?>
        </a>
    </li>
    <li role="presentation">
        <a href="#location" aria-controls="location" role="tab" data-toggle="<?php echo $is_edit ? esc_attr( 'tab' ) : '' ?>">
            <?php
            if( !$is_edit ){
            	esc_html_e( '2. ', 'classifieds' );
            }
            esc_html_e( 'Location', 'classifieds' );
            ?>        
        </a>
    </li>
    <li role="presentation">
        <a href="#category" aria-controls="category" role="tab" data-toggle="<?php echo $is_edit ? esc_attr( 'tab' ) : '' ?>">
            <?php
            if( !$is_edit ){
            	esc_html_e( '3. ', 'classifieds' );
            }
            esc_html_e( 'Category', 'classifieds' );
            ?>        
        </a>
    </li>
    <li role="presentation">
        <a href="#media" aria-controls="media" role="tab" data-toggle="<?php echo $is_edit ? esc_attr( 'tab' ) : '' ?>">
            <?php
            if(!$is_edit ){
         	  esc_html_e( '4. ', 'classifieds' );
            }
            esc_html_e( 'Media', 'classifieds' );
            ?>        
        </a>
    </li>

    <?php if( !empty( $ad_terms ) && !$is_edit ): ?>
        <li role="presentation">
            <a href="#terms" aria-controls="terms" role="tab" data-toggle="<?php echo $is_edit ? esc_attr( 'tab' ) : '' ?>">
                <?php esc_html_e( '5. Terms', 'classifieds' ); ?>
            </a>
        </li>        
    <?php endif; ?>

    <?php if( $is_edit ): ?>
    	<li>
	        <a href="javascript:;" class="remove-ad" title="<?php esc_attr_e( 'Remove Ad', 'classifieds' ) ?>" data-delete_link="<?php echo esc_url( add_query_arg( array( $classifieds_slugs['subpage'] => 'delete_ad', 'ad_id' => $ad_id ), $permalink ) ) ?>" data-confirm="<?php esc_attr_e( 'Are you sure you wish to delete this ad?', 'classifieds' ) ?>">
            	<i class="fa fa-times"></i>
        	</a>
    	</li>
        <?php
        if( !$is_expired && $is_edit && $ad->post_status == 'publish' ):
        ?>
            <li>
                <a href="javascript:;" class="ad_visibility" title="<?php esc_attr_e( 'Toggle Ad On / Off', 'classifieds' ) ?>">
                    <i class="fa fa-eye<?php echo $ad_visibility == 'yes' ? esc_attr__('-slash') : '' ?>"></i>
                </a>
            </li>
        <?php endif; ?>
    <?php else: ?>
    	<li role="presentation">
	        <a href="#final" aria-controls="final" role="tab" data-toggle="<?php echo $is_edit ? esc_attr( 'tab' ) : '' ?>">
            	<?php 
                echo !empty( $ad_terms ) ? esc_html_e('6. ', 'classifieds') : esc_html_e( '5. ', 'classifieds' );
                esc_html_e( 'Final', 'classifieds' ) ?>
        	</a>
    	</li>    	
   	<?php endif; ?>
</ul>

<!-- Tab panes -->
<form method="post">
    <?php
    if( !$is_expired && $is_edit && $ad->post_status == 'publish' ):
    ?>
        <input type="hidden" value="<?php echo esc_attr__( $ad_visibility ) ?>" name="ad_visibility">
    <?php endif; ?>
    <div class="white-block">
        <div class="white-block-content">
            <div class="tab-content">

                <div role="tabpanel" class="tab-pane active" id="basic">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="radio">
                                <label>
                                    <input type="radio" 
                                        name="ad_price" 
                                        id="give_item"
                                        value="GIVE"
                                        <?= $ad_price == 'GIVE' ? 'checked="checked"' : '' ?> 
                                    >
                                    <?php esc_html_e( 'Give this item', 'classifieds' ); ?>
                                </label>
                            </div>         
                        </div>
                        <div class="col-md-4">
                            <div class="radio">
                                <label>
                                    <input type="radio" 
                                        name="ad_price" 
                                        id="request_item"
                                        value="REQUEST"
                                        <?= $ad_price == 'REQUEST' ? 'checked="checked"' : '' ?> 
                                    >
                                    <?php esc_html_e( 'Request for this item', 'classifieds' ); ?>
                                </label>
                            </div>  
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="ad_title"><?php esc_html_e( 'Ad Title', 'classifieds' ); ?> <span class="required">*</span></label>
                            <input type="text" name="ad_title" id="ad_title" value="<?php echo esc_attr__( $ad_title ); ?>" class="form-control require">
                            <p class="description"><?php esc_html_e( 'Input title of the ad which must be unique', 'classifieds' ) ?></p>
                        </div>
                        <div class="col-md-6">
                            <label><?php esc_html_e( 'Featured Image', 'classifieds' ); ?></label>
                            <div class="image-wrap">
                                <?php if( !empty( $featured_image ) ){
                                    echo wp_get_attachment_image( $featured_image, 'thumbnail' );
                                    echo '<a href="javascript:;" class="remove-image">X</a>';
                                }?>
                            </div>
                            <a href="javascript:;" class="btn set-image"><?php esc_html_e( 'FEATURED IMAGE', 'classifieds' ) ?></a>
                            <input type="hidden" name="featured_image" id="featured_image" value="<?php echo esc_attr__( $featured_image ) ?>" class="form-control">
                            <p class="description"><?php esc_html_e( 'Select featured image for the ad', 'classifieds' ) ?></p>
                        </div>
                    </div>

                    <label for="ad_description"><?php esc_html_e( 'Ad Description', 'classifieds' ); ?> <span class="required">*</span></label>
                    <?php wp_editor( $ad_description, 'ad_description', array( 'editor_height' => '200px' ) ); ?> 
                    <p class="description"><?php esc_html_e( 'Input desciption of the ad', 'classifieds' ) ?></p>

                    <?php /*
                    <label for="ad_tags"><?php esc_html_e( 'Tags', 'classifieds' ); ?></label>
                    <input type="text" name="ad_tags" id="ad_tags" value="<?php echo esc_attr__( $ad_tags ); ?>" class="form-control">                            
                    <p class="description"><?php esc_html_e( 'Input comma separated tags', 'classifieds' ) ?></p>
                    
                    <div class="row">
                		<div class="col-md-6">
                            <label for="ad_price"><?php esc_html_e( 'Price', 'classifieds' ); ?></label>
                            <input type="text" name="ad_price" id="ad_price" value="<?php echo esc_attr__( $ad_price ); ?>" class="form-control">
                            <p class="description"><?php esc_html_e( 'Input price of the product / service you are offering (number only). Put 0 for free', 'classifieds' ) ?></p>
                		</div>
                		<div class="col-md-6">
                            <label for="ad_discounted_price"><?php esc_html_e( 'Discounted Price', 'classifieds' ); ?></label>
                            <input type="text" name="ad_discounted_price" id="ad_discounted_price" value="<?php echo esc_attr__( $ad_discounted_price ); ?>" class="form-control">                			
                            <p class="description"><?php esc_html_e( 'Input discounted price of the product / service you are offering, if it exists (number only)', 'classifieds' ) ?></p>
                		</div>
                	</div>*/ ?>        	
                    <div class="row">
                        <?php /*
                        <div class="col-md-6">
                            <div class="checkbox">
                                <input type="checkbox" name="ad_call_for_price" id="ad_call_for_price" <?php echo !empty( $ad_call_for_price ) ? esc_attr__( 'checked="checked"' ) : ''; ?>>
                                <label for="ad_call_for_price"><?php esc_html_e( 'Call For Info', 'classifieds' ); ?> </label>
                                <p class="description"><?php esc_html_e( 'If this is checked then Call For Info text will be displayed instead of price', 'classifieds' ) ?></p>
                            </div>
                        </div>
                        */ ?>                
                        <div class="col-md-6">
                            <label for="ad_phone"><?php esc_html_e( 'Phone', 'classifieds' ); ?></label>
                            <input type="text" name="ad_phone" id="ad_phone" value="<?php echo esc_attr__( $ad_phone ); ?>" class="form-control">
                            <p class="description"><?php esc_html_e( 'Input phone number specific for this ad or leave empty to use the one from your profile', 'classifieds' ) ?></p>
                        </div>
                    </div> 

                    <?php include( classifieds_load_path( 'includes/profile-pages/next-prev.php' ) ); ?>

                </div>

                <div role="tabpanel" class="tab-pane" id="location">
                    <div class="gmap">
                        <label for="gmap_input"><?php esc_html_e( 'Location', 'classifieds' ); ?> <span class="required">*</span></label>
                        <input type="text" name="gmap_input" id="gmap_input" value="" class="form-control gmap_input">
                        <div id="map"></div>
                        <p class="description"><?php esc_html_e( 'Set location of the ad', 'classifieds' ) ?></p>
                        <input type="hidden" name="ad_gmap_longitude" value="<?php echo esc_attr__( $ad_gmap_longitude ) ?>" class="longitude require">
                        <input type="hidden" name="ad_gmap_latitude" value="<?php echo esc_attr__( $ad_gmap_latitude ) ?>" class="latitude require">
                    </div>

                    <?php include( classifieds_load_path( 'includes/profile-pages/next-prev.php' ) ); ?>

                </div>

                <div role="tabpanel" class="tab-pane" id="category">
                	<label for="ad_category"><?php esc_html_e( 'Ad Category', 'classifieds' ); ?><span class="required">*</span></label>
                	<select name="ad_category" class="form-control require" id="ad_category">
                		<option value=""><?php esc_html_e( '- Select -', 'classifieds' ) ?></option>
                		<?php echo classifieds_get_taxonomy_select_search( 'ad-category', $ad_category, 'term_id' ) ?>
                	</select>
                    <p class="description"><?php esc_html_e( 'Select category of the ad', 'classifieds' ) ?></p>
                	<div class="custom-fields-holder"><?php echo  $custom_fields; ?></div>

                    <?php include( classifieds_load_path( 'includes/profile-pages/next-prev.php' ) ); ?>

                </div>

                <div role="tabpanel" class="tab-pane" id="media">

                    <label for="ad_images">
                        <?php esc_html_e( 'Ad Images', 'classifieds' ); ?>
                        <?php
                        $ad_max_images = classifieds_get_option( 'ads_max_images' );
                        if( !empty( $ad_max_images ) ){
                            echo '( '.esc_html__( 'Max', 'classifieds' ).' '.$ad_max_images.' '.esc_html__( 'images', 'classifieds' ).' )';
                        }
                        ?>                         
                    </label>
                    <div class="ad-images-wrap">
                        <?php 
                        if( !empty( $ad_images )){
                            foreach( $ad_images as $image_id ){
                                echo '<div class="ad-image-wrap"">
                                        '.wp_get_attachment_image( $image_id, 'thumbnail', array( 'class' => 'img-responsive width-150' ) ).'
                                        <a href="javascript:;" class="remove-ad-image">
                                            <i class="fa fa-close"></i>
                                        </a>
                                        <input type="hidden" name="ad_images[]" value="'.esc_attr__( $image_id ).'">
                                      </div>';
                            }
                        }
                        ?>
                    </div>
                    <a href="javascript:;" class="btn image-upload ad-images"><?php esc_html_e( 'SELECT IMAGES', 'classifieds' ) ?></a>
                    <p class="description"><?php esc_html_e( 'Select additional images for the ad', 'classifieds' ) ?></p>

                    <label>
                        <?php esc_html_e( 'Ad Videos', 'classifieds' ); ?>
                        <?php
                        $ad_max_videos = classifieds_get_option( 'ads_max_videos' );
                        if( !empty( $ad_max_videos ) ){
                            echo '( '.esc_html__( 'Max', 'classifieds' ).' '.$ad_max_videos.' '.esc_html__( 'videos', 'classifieds' ).' )';
                        }
                        ?> 
                    </label>
                    <div class="ad-video-wrap hidden">
                        <div class="ad-video-field-wrap">
                            <input type="text" class="form-control" name="ad_videos[]" value="">
                            <a href="javascript:;" class="remove-video">X</a>
                        </div>
                        <p class="description"><?php esc_html_e( 'Youtube or vimeo links', 'classifieds' ) ?></p>
                    </div>                    
                    <div class="ad-media-wrap">
                        <?php
                        $videos = get_post_meta( $ad_id, 'ad_videos' );
                        if( !empty( $videos ) ){
                            foreach( $videos as $video ){
                                ?>
                                <div class="ad-video-wrap">
                                    <div class="ad-video-field-wrap">
                                        <input type="text" class="form-control" name="ad_videos[]" value="<?php echo esc_url( $video ) ?>">
                                        <a href="javascript:;" class="remove-video">X</a>
                                    </div>
                                    <p class="description"><?php esc_html_e( 'Direct youtube or vimeo link', 'classifieds' ) ?></p>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <a href="javascript:;" class="btn ad-videos"><?php esc_html_e( 'ADD VIDEOS', 'classifieds' ) ?></a>
                    <p class="description"><?php esc_html_e( 'Select additional videos for the ad', 'classifieds' ) ?></p>

                    <?php include( classifieds_load_path( 'includes/profile-pages/next-prev.php' ) ); ?>

                </div>

                <?php if( !empty( $ad_terms ) && !$is_edit ): ?>
                    <div role="tabpanel" class="tab-pane" id="terms">

                        <div class="terms-wrap">
                            <?php echo apply_filters( 'the_content', $ad_terms ); ?>
                        </div>
                        <div class="checkbox">
                            <input type="checkbox" name="ad_terms" id="ad_terms" class="require">
                            <label for="ad_terms"><?php esc_html_e( 'I have read and accept the terms', 'classifieds' ); ?> </label>
                        </div>

                        <?php include( classifieds_load_path( 'includes/profile-pages/next-prev.php' ) ); ?>

                    </div>
                <?php else: ?>
                    <input type="hidden" name="ad_terms" id="ad_terms" value="1">
                <?php endif; ?>


                <?php if( !$is_edit ): ?>
                    <div role="tabpanel" class="tab-pane" id="final">

                    	<div class="alert alert-info">
                    		<p><?php esc_html_e( 'Each ad will last for ', 'classifieds' ); echo classifieds_get_option( 'ad_lasts_for' ); esc_html_e( ' days.', 'classifieds' ) ?></p>
                            <hr />
                    		<?php
                    		$basic_ad_price = classifieds_get_option( 'basic_ad_price' );
                            if( empty( $basic_ad_price ) ){
                                $basic_ad_price = 0;
                            }
                    		$featured_ad_price = classifieds_get_option( 'featured_ad_price' );
                            if( empty( $featured_ad_price ) ){
                                $featured_ad_price = 0;
                            }

                    		$basic_price = classifieds_format_price_number( $basic_ad_price );
                    		$featured_price = classifieds_format_price_number( $featured_ad_price );
                            $faetured_total = classifieds_format_price_number( $basic_ad_price + $featured_ad_price );

                            echo '<p class="clearfix"><span class="pull-left">'.esc_html__( 'Basic ad:', 'classifieds' ).'</span><span class="pull-right">'.$basic_price.'</span></p>'; 

                    		if( !empty( $featured_ad_price ) ){
                                echo '<p class="clearfix featured-info hidden"><span class="pull-left">'.esc_html__( 'Featured ad:', 'classifieds' ).'</span><span class="pull-right">'.$featured_price.'</span></p>';                 			
                    		}

                            echo '<p class="clearfix"><span class="pull-left">'.esc_html__( 'Total:', 'classifieds' ).'</span><span class="pull-right total-amount" data-basic="'.esc_attr__( $basic_price ).'" data-featured="'.esc_attr__( $faetured_total ).'">'.$basic_price.'</span></p>'; 

                    		?>
                    	</div>

                    	<?php if( !empty( $featured_ad_price ) ): ?>
                            <div class="checkbox">
                                <input type="checkbox" name="ad_featured" id="ad_featured" value="1">
    	                        <label for="ad_featured"><?php esc_html_e( 'Make ad featured', 'classifieds' ); ?></label>
                            </div>
                    	<?php endif; ?>   

                        <?php if( !$is_expired ): ?>

                            <a href="javascript:;" class="btn submit-form-ajax">
                                <?php esc_html_e( 'SUBMIT AD', 'classifieds' ); ?>
                            </a>

                        <?php else: ?>

                            <input type="hidden" name="is_expired" value="1">
                            <a href="javascript:;" class="btn submit-form-ajax">
                                <?php esc_html_e( 'RENEW AD', 'classifieds' ); ?>
                            </a>

                        <?php endif; ?>

                        <?php include( classifieds_load_path( 'includes/profile-pages/next-prev.php' ) ); ?>                      

                    </div>
                <?php else: ?>
                    <?php
                    if( $ad_featured == 'yes' ){
                        echo '<input type="hidden" name="ad_featured" value="1">';
                    }
                    ?>
                <?php endif; ?>

            </div>

            <input type="hidden" name="post_id" value="<?php echo esc_attr__( $ad_id ); ?>">
            <input type="hidden" name="ad_views" value="<?php echo esc_attr( $ad_views ) ?>">
            <input type="hidden" value="update_ad" name="action">

            <?php if( $is_edit ): ?>
                <a href="javascript:;" class="btn submit-form-ajax">
                    <?php esc_html_e( 'SAVE CHANGES', 'classifieds' ); ?>
                </a>
            <?php endif; ?>              

        </div>
    </div>
</form>