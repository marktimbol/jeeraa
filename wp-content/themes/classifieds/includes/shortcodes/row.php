<?php
function classifieds_row_func( $atts, $content ){

	return '<div class="row">'.do_shortcode( $content ).'</div>';
}

add_shortcode( 'row', 'classifieds_row_func' );

function classifieds_row_params(){
	return array();
}
?>