<?php

/* Custom Meta For Taxonomies */


/* Adding New */
/* icon meta */
function classifieds_location_latlong_add() {
	echo '
	<div class="form-field">
		<label for="term_meta[location_lat]">'.esc_html__( 'Latitude:', 'classifieds' ).'</label>
		<input type="text" name="term_meta[location_lat]">
		<p class="description">'.esc_html__( 'Input location latitude','classifieds' ).'</p>

		<label for="term_meta[location_long]">'.esc_html__( 'Longitude:', 'classifieds' ).'</label>
		<input type="text" name="term_meta[location_long]">
		<p class="description">'.esc_html__( 'Input location longitude','classifieds' ).'</p>		
	</div>';
}
add_action( 'location_add_form_fields', 'classifieds_location_latlong_add', 10, 2 );

/* Editing */
function classifieds_location_latlong_edit( $term ) {
	$term_meta = get_option( "taxonomy_".$term->slug );
	
	$location_lat = !empty( $term_meta['location_lat'] ) ? $term_meta['location_lat'] : '';
	$location_long = !empty( $term_meta['location_long'] ) ? $term_meta['location_long'] : '';
	?>
	<table class="form-table">
		<tbody>
			<tr class="form-field form-required">
				<th scope="row"><label for="term_meta[location_lat]"><?php esc_html_e( 'Location latitude', 'classifieds' ); ?></label></th>
				<td>
					<input type="text" name="term_meta[location_lat]" value="<?php echo esc_attr__( $location_lat ) ?>">
					<p class="description"><?php esc_html_e( 'Input location latitude', 'classifieds' ); ?></p>
				</td>
				<th scope="row"><label for="term_meta[location_long]"><?php esc_html_e( 'Location longitude', 'classifieds' ); ?></label></th>
				<td>
					<input type="text" name="term_meta[location_long]" value="<?php echo esc_attr__( $location_long ) ?>">
					<p class="description"><?php esc_html_e( 'Input location longitude', 'classifieds' ); ?></p>
				</td>				
			</tr>
		</tbody>
	</table>
	<?php
}
add_action( 'location_edit_form_fields', 'classifieds_location_latlong_edit', 10, 2 );

/* Save It */
function classifieds_location_latlong_save( $term_id ) {
	if ( isset( $_POST['term_meta'] ) ) {
		$term = get_term_by( 'id', $term_id, 'location' );
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
add_action( 'edited_location', 'classifieds_location_latlong_save', 10, 2 );  
add_action( 'create_location', 'classifieds_location_latlong_save', 10, 2 );

/* Delete meta */
function classifieds_location_latlong_delete( $term_id ) {
	$term = get_term_by( 'id', $term_id, 'location' );
	delete_option( "taxonomy_".$term->slug );
}  
add_action( 'delete_location', 'classifieds_location_latlong_delete', 10, 2 );
?>