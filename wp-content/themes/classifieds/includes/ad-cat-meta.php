<?php

/* Custom Meta For Taxonomies */


/* Adding New */
/* icon meta */
function classifieds_category_icon_add() {
	?>
	<div class="form-field">
		<label for="term_meta[category_image]"><?php esc_html_e( 'Image:', 'classifieds' ); ?></label>
		<div class="image-wrap"></div>
		<a href="javascript:;" class="set-image button"><?php esc_html_e( 'Select Image', 'classifieds' ) ?></a>
		<input type="hidden" id="term_meta[category_image]" name="term_meta[category_image]" value="">
		<p class="description"><?php esc_html_e( 'Select category image', 'classifieds' ); ?></p>
	</div>
	<div class="form-field">
		<label for="term_meta[category_marker]"><?php esc_html_e( 'Category Marker', 'classifieds' ); ?></label>
		<div class="marker-holder"></div>
		<a href="javascript:;" class="select-marker button"><?php esc_html_e( 'Select Image', 'classifieds' ) ?></a>
		<input type="hidden" id="term_meta[category_marker]" name="term_meta[category_marker]" value="" class="marker-image-val">
		<p class="description"><?php esc_html_e( 'Select marker icon', 'classifieds' ); ?></p>
	</div>
	<?php
}
add_action( 'ad-category_add_form_fields', 'classifieds_category_icon_add', 10, 2 );

/* Editing */
function classifieds_category_icon_edit( $term ) {
	$term = get_term_by( 'id', $term->term_id, 'ad-category' );
	$term_meta = get_option( "taxonomy_".$term->slug );
	
	$image = !empty( $term_meta['category_image'] ) ? $term_meta['category_image'] : '';
	$marker = !empty( $term_meta['category_marker'] ) ? $term_meta['category_marker'] : '';
	?>
	<table class="form-table">
		<tbody>
			<tr class="form-field form-required">
				<th scope="row"><label for="term_meta[category_image]"><?php esc_html_e( 'Category Image', 'classifieds' ); ?></label></th>
				<td>
				<div class="image-wrap">
					<?php if( !empty( $image ) ): ?>
						<?php echo wp_get_attachment_image( $image, 'classifieds-ad-thumb' ); ?>
						<a href="javascript:;" class="remove-image">X</a>
					<?php endif; ?>
				</div>
				<a href="javascript:;" class="set-image button"><?php esc_html_e( 'Select Image', 'classifieds' ) ?></a>
				<input type="hidden" id="term_meta[category_image]" name="term_meta[category_image]" value="<?php echo esc_attr__( $image ) ?>">
				<p class="description"><?php esc_html_e( 'Select image icon', 'classifieds' ); ?></p></td>
			</tr>
			<tr class="form-field form-required">
				<th scope="row"><label for="term_meta[category_marker]"><?php esc_html_e( 'Category Marker', 'classifieds' ); ?></label></th>
				<td>
				<div class="marker-holder">
					<?php if( !empty( $marker ) ): ?>
						<?php echo wp_get_attachment_image( $marker, 'full' ); ?>
						<a href="javascript:;" class="remove-marker">X</a>
					<?php endif; ?>
				</div>
				<a href="javascript:;" class="select-marker button"><?php esc_html_e( 'Select Image', 'classifieds' ) ?></a>
				<input type="hidden" id="term_meta[category_marker]" name="term_meta[category_marker]" value="<?php echo esc_attr__( $marker ) ?>" class="marker-image-val">
				<p class="description"><?php esc_html_e( 'Select marker icon', 'classifieds' ); ?></p></td>
			</tr>			
		</tbody>
	</table>
	<?php
}
add_action( 'ad-category_edit_form_fields', 'classifieds_category_icon_edit', 10, 2 );

/* Save It */
function classifieds_category_icon_save( $term_id ) {
	if ( isset( $_POST['term_meta'] ) ) {
		$term = get_term_by( 'id', $term_id, 'ad-category' );
		$term_meta = get_option( "taxonomy_".$term->slug );
		$cat_keys = array_keys( $_POST['term_meta'] );
		foreach ( $cat_keys as $key ) {
			if ( isset ( $_POST['term_meta'][$key] ) ) {
				$term_meta[$key] = $_POST['term_meta'][$key];
			}
		}
		// Save the option array.
		update_option( "taxonomy_".$term->slug, $term_meta );
	}
}  
add_action( 'edited_ad-category', 'classifieds_category_icon_save', 10, 2 );  
add_action( 'create_ad-category', 'classifieds_category_icon_save', 10, 2 );

/* Delete meta */
function classifieds_category_icon_delete( $term_id ) {
	$term = get_term_by( 'id', $term_id, 'ad-category' );
	delete_option( "taxonomy_".$term->slug );
}  
add_action( 'delete_ad-category', 'classifieds_category_icon_delete', 10, 2 );

/* Add icon column */
function classifieds_category_column( $columns ) {
    $new_columns = array(
        'cb' => '<input type="checkbox" />',
        'name' => esc_html__('Name', 'classifieds'),
		'description' => esc_html__('Description', 'classifieds'),
        'slug' => esc_html__( 'Slug', 'classifieds' ),
        'posts' => esc_html__( 'Codes', 'classifieds' ),
		'image' => esc_html__( 'Image', 'classifieds' ),
		'marker' => esc_html__( 'Marker', 'classifieds' ),
        );
    return $new_columns;
}
add_filter("manage_edit-ad-category_columns", 'classifieds_category_column'); 

function classifieds_populate_category_column( $out, $column_name, $term_id ){
    switch ( $column_name ) {
        case 'image': 
        	$term = get_term_by( 'id', $term_id, 'ad-category' );
        	$term_meta = get_option( "taxonomy_".$term->slug );
			$value = !empty( $term_meta['category_image'] ) ? $term_meta['category_image'] : '';
			$data = wp_get_attachment_image_src( $value, 'classifieds-ad-thumb' );
			if( !empty( $data[0] ) ){
				return '<img src="'.esc_url( $data[0] ).'" style="width: 60px; height: 60px;">';
			}
			return '';
            break;
         case 'marker': 
         	$term = get_term_by( 'id', $term_id, 'ad-category' );
			$term_meta = get_option( "taxonomy_".$term->slug );
			$value = !empty( $term_meta['category_marker'] ) ? $term_meta['category_marker'] : '';

            $out .= wp_get_attachment_image( $value, 'full' );
            break;
        default:
            break;
    }
    return $out; 
}

add_filter("manage_ad-category_custom_column", 'classifieds_populate_category_column', 10, 3);
?>