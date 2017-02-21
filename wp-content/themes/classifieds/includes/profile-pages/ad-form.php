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
$ad_gmap_longitude = $is_edit ? get_post_meta( $ad_id, 'ad_gmap_longitude', true ) : '54.3773';
$ad_gmap_latitude = $is_edit ? get_post_meta( $ad_id, 'ad_gmap_latitude', true ) : '24.4539';
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
$ad_gmap_latitude = $is_edit ? get_post_meta( $ad_id, 'ad_gmap_latitude', true ) : '24.4539';
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
        <h4><i class="fa fa-send"></i> &nbsp; 
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
                        <div class="col-md-6">
                            <div class="radio">
                                <label class="Flex--center Flex--column">
                                    <i class="fa fa-gift verified" 
                                        title="<?=esc_attr__( 'Give Away', 'classifieds' )?>">
                                    </i>
                                    <?php esc_html_e( 'Give this item', 'classifieds' ); ?>
                                    <input type="radio" 
                                        name="ad_price" 
                                        id="give_item"
                                        value="GIVEAWAY"
                                        checked="checked" 
                                    >                    
                                </label>
                            </div>         
                        </div>
                        <div class="col-md-6">
                            <div class="radio">
                                <label class="Flex--center Flex--column">
                                    <i class="fa fa-heart featured" 
                                        title="<?=esc_attr__( 'Give Away', 'classifieds' )?>">
                                    </i>                                    
                                    <?php esc_html_e( 'Request for this item', 'classifieds' ); ?>
                                    <input type="radio" 
                                        name="ad_price" 
                                        id="request_item"
                                        value="REQUEST"
                                        <?= $ad_price == 'REQUEST' ? 'checked="checked"' : '' ?>
                                    >                                    
                                </label>
                            </div>  
                        </div>
                    </div>

                    <div class="separator"></div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="ad_title">
                                <?php esc_html_e( 'Give a title to your item', 'classifieds' ); ?>
                                <span class="required">*</span>
                            </label>
                            <input type="text" 
                                name="ad_title" 
                                id="ad_title" 
                                value="<?php echo esc_attr__( $ad_title ); ?>" 
                                pattern=".{10,}"
                                class="form-control require" required />
                            <p class="description">
                                <?php esc_html_e( 'Minimum 10 characters', 'classifieds' ) ?>
                            </p>                                
                        </div>

                        <div class="col-md-6">
                            <label><?php esc_html_e( 'Featured Image', 'classifieds' ); ?></label>
                            <div class="image-wrap">
                                <?php if( !empty( $featured_image ) ){
                                    echo wp_get_attachment_image( $featured_image, 'thumbnail' );
                                    echo '<a href="javascript:;" class="remove-image">X</a>';
                                }?>
                            </div>
                            <a href="javascript:;" class="btn set-image">
                                <?php esc_html_e( 'FEATURED IMAGE', 'classifieds' ) ?>
                            </a>
                            <input type="hidden" 
                                name="featured_image" 
                                id="featured_image" 
                                value="<?php echo esc_attr__( $featured_image ) ?>"
                                class="form-control" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="ad_category">
                                <?php esc_html_e( 'Ad Category', 'classifieds' ); ?><span class="required">*</span>
                            </label>
                            <select name="ad_category" class="form-control require" id="ad_category">
                                <option value="">
                                    <?php esc_html_e( '- Select -', 'classifieds' ) ?>
                                </option>
                                <?php echo classifieds_get_taxonomy_select_search( 'ad-category', $ad_category, 'term_id' ) ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="ad_phone">
                                <?php esc_html_e( 'Alternative Phone Number', 'classifieds' ); ?>
                            </label>
                            <input type="text" 
                                name="ad_phone" 
                                id="ad_phone" 
                                value="<?php echo esc_attr__( $ad_phone ); ?>"
                                class="form-control" />
                            <p class="description">
                                <input type="hidden" name="hide_phone" value="no" />
                                <input type="checkbox" 
                                    value="yes" 
                                    name="hide_phone"
                                    <?=get_post_meta( $ad_id, 'hide_phone', true ) == 'yes' ? 'checked=checked' : '' ?>
                                     /> Hide my phone number
                            </p>
                        </div>
                    </div>

                    <div>
                        <label for="ad_description">
                            <?php esc_html_e( 'Describe your item', 'classifieds' ); ?> <span class="required">*</span>
                        </label>
                        <?php wp_editor( $ad_description, 'ad_description', array( 
                            'editor_height' => '200px', 
                            'media_buttons' => false 
                        ) ); ?>
                    </div>

                    <p>&nbsp;</p>

                    <div class="gmap">
                        <label for="gmap_input">
                            <?php esc_html_e( 'Please type your city, then drag the marker to your location', 'classifieds' ); ?> <span class="required">*</span>
                        </label>
                        
                        <input type="text" name="gmap_input" id="gmap_input" value="Abu Dhabi, United Arab Emirates" class="form-control gmap_input">
                        
                        <div id="map"></div>

                        <input type="hidden" 
                            name="ad_gmap_longitude" 
                            value="<?php echo esc_attr__( $ad_gmap_longitude ) ?>"
                            class="longitude require" />
                        <input type="hidden" 
                            name="ad_gmap_latitude" 
                            value="<?php echo esc_attr__( $ad_gmap_latitude ) ?>" 
                            class="latitude require" />
                    </div>

                    <p>&nbsp;</p>

                    <?php if( !empty( $ad_terms ) && !$is_edit ): ?>
                    <div class="checkbox">
                        <input type="checkbox" name="ad_terms" id="ad_terms" class="require">
                        <label for="ad_terms">
                            I have read and accept the <a href="<?=bloginfo('url')?>/terms-conditions/">Terms &amp; Conditions</a>
                        </label>
                    </div>
                    <?php else: ?>
                        <input type="hidden" name="ad_terms" id="ad_terms" value="1">
                    <?php endif; ?>

                    <?php if( !$is_edit ): ?>
                        <?php if( !$is_expired ): ?>
                            <p>&nbsp;</p>
                            <a href="javascript:;" class="btn submit-form-ajax">
                                <?php esc_html_e( 'Submit Item', 'classifieds' ); ?>
                            </a>
                        <?php else: ?>
                            <input type="hidden" name="is_expired" value="1">
                            <a href="javascript:;" class="btn submit-form-ajax">
                                <?php esc_html_e( 'RENEW AD', 'classifieds' ); ?>
                            </a>
                        <?php endif; ?>
                    <?php else: ?>
                        <?php
                        if( $ad_featured == 'yes' ){
                            echo '<input type="hidden" name="ad_featured" value="1">';
                        }
                        ?>
                    <?php endif; ?>

                    <input type="hidden" name="post_id" value="<?php echo esc_attr__( $ad_id ); ?>">
                    <input type="hidden" name="ad_views" value="<?php echo esc_attr( $ad_views ) ?>">
                    <input type="hidden" value="update_ad" name="action">

                    <?php if( $is_edit ): ?>
                        <p>&nbsp;</p>
                        <a href="javascript:;" class="btn submit-form-ajax">
                            <?php esc_html_e( 'SAVE CHANGES', 'classifieds' ); ?>
                        </a>
                    <?php endif; ?>                                                                                             
                </div>
            </div>
        </div>
    </div>
</form>