<?php

function classifieds_add_meta_box_ad() {
	add_meta_box(
		'classifieds_custom_meta_ad',
		esc_html__( 'Custom Fields Data', 'classifieds' ),
		'classifieds_populate_meta_box_ad',
		'ad'
	);
}
add_action( 'add_meta_boxes', 'classifieds_add_meta_box_ad' );

function classifieds_populate_meta_box_ad( $post ) {
	echo classifieds_generate_custom_fields_html( $post->ID );
}


function classifieds_generate_custom_fields_html( $post_id, $cats = '' ){
	global $wpdb;
	if( empty( $cats ) ){
		$cats = wp_get_object_terms( $post_id, 'ad-category' );
	}
	$list = '';

	if( !empty( $cats ) ){
		$terms_organized = array();
		classifieds_sort_terms_hierarchicaly( $cats, $terms_organized );
		$cat = classifieds_get_last_category( $terms_organized );
		if( empty( $cat ) ){
			$cat = array_pop( $cats );
		}

		$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->postmeta} WHERE meta_key = 'fields_for' AND meta_value LIKE %s", '%\"'.$cat->slug.'\"%' ) );
		if( !empty( $results ) ){
			$list = '<ul class="list-2-col">';

			$fields = classifieds_get_custom_fields( $results[0]->post_id );

			if( !empty( $fields ) ){
				foreach( $fields as $field ){
					$value = classifieds_get_post_meta( $post_id, $field->name );
					if( $field->type == 'select' ){
						$list .= classifieds_generate_select( $field, $value, false );
						$subfields = classifieds_get_custom_subfields( $results[0]->post_id, $field->field_id );
						if( !empty( $subfields ) ){
							foreach( $subfields as $subfield ){
								$value = classifieds_get_post_meta( $post_id, $subfield->name );
								$list .= classifieds_generate_select( $subfield, $value );
							}
						}
					}
					else{
						$list .= '<li>'.classifieds_generate_input( $field, $value ).'</li>';
					}
				}
			}

			$list .= '</ul>';
		}		
	}

	return $list;	
}

function classifieds_save_ad_meta( $post_id, $post ) {
	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'ad' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	/* OK, it's safe for us to save the data now. */
	
	//save values

	classifieds_empty_old_meta( $post_id );
	global $wpdb;
	foreach( $_POST as $key => $value ){
		$meta_key = substr( $key, 0, 3 );
		if( $meta_key == 'cf_' && $key !== 'cf_values' ){
			$meta_key = str_replace( 'cf_', '', $key );
			$wpdb->query( $wpdb->prepare( "DELETE FROM {$wpdb->prefix}custom_fields_meta WHERE post_id = %d AND name = %s", $post_id, $meta_key ) );
			classifieds_add_post_meta( $post_id, $meta_key, $value );
		}
	}

	
	if( $post->post_status == 'publish' && !empty( $_POST['post_type'] ) && 'ad' == $_POST['post_type'] ){
		$ad_expire = get_post_meta( $post_id, 'ad_expire', true );
		$inform_user = false;
		if( empty( $ad_expire ) ){
			$inform_user = true;
			$ad_lasts_for = classifieds_get_option( 'ad_lasts_for' );
			$ad_lasts_for = $ad_lasts_for*24*60*60;

			delete_post_meta($post_id, 'ad_expire');
			add_post_meta( $post_id, 'ad_expire', $ad_lasts_for + current_time( 'timestamp' ) );
		}
		update_post_meta( $post_id, 'ad_paid', 'yes' );

		classifieds_make_user_verified( $post->post_author );
		$user = get_user_by( 'id', $post->post_author );

		if( $inform_user ){
	    	$message = classifieds_get_option( 'ad_approve_message' );
	    	$message = str_replace( '%USERNAME%', $user->user_login, $message );
	    	$message = str_replace( '%AD_NAME%', $post->post_title, $message );
	    	$message = str_replace( '%AD_LINK%', get_permalink( $post->ID ), $message );
	    	classifieds_inform_user( $post->post_author, $message, '['.get_bloginfo('name').'] '.esc_html__( 'Ad Approved', 'classifieds' ) );		
	    }
	}

}
add_action( 'save_post', 'classifieds_save_ad_meta', 20, 2 );


function classifieds_delete_ad( $post_id ){
    global $post_type;   
    if ( $post_type != 'ad' ) return;

    $post = get_post( $post_id );
    if( empty( $_GET['is_expired'] ) ){
    	$user = get_user_by( 'id', $post->post_author );
    	$message = classifieds_get_option( 'ad_decline_message' );
    	$message = str_replace( '%USERNAME%', $user->user_login, $message );
    	$message = str_replace( '%AD_NAME%', $post->post_title, $message );
    	classifieds_inform_user( $post->post_author, $message, '['.get_bloginfo('name').'] '.esc_html__( 'Ad Declined', 'classifieds' ) );
    }

}
add_action( 'before_delete_post', 'classifieds_delete_ad', 10, 2 );

function classifieds_empty_old_meta( $post_id ){
	global $wpdb;
	$wpdb->query( $wpdb->prepare( "DELETE postmeta FROM {$wpdb->prefix}custom_fields AS cf LEFT JOIN {$wpdb->postmeta} AS postmeta ON cf.name = postmeta.meta_key WHERE postmeta.post_id = %d", $post_id ) );
}

function classifieds_ajax_fields(){
	$post_id = $_POST['post_id'];
	$cats = !empty($_POST['cats']) ? explode(',', $_POST['cats']) : array();
	$cats_terms = array();
	$html = '';
	if( !empty( $cats ) ){
		classifieds_empty_old_meta( $post_id );
		foreach( $cats as $cat ){
			$cats_terms[] = get_term_by( 'id', $cat, 'ad-category' );
		}
		$html = classifieds_generate_custom_fields_html( $post_id, $cats_terms );
	}
	echo  $html;
	die();

}
add_action('wp_ajax_classifieds_cf', 'classifieds_ajax_fields');
add_action('wp_ajax_nopriv_classifieds_cf', 'classifieds_ajax_fields');


?>