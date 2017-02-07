<?php
function classifieds_gap_func( $atts, $content ){
	extract( shortcode_atts( array(
		'height' => '',
	), $atts ) );

	return '<span style="height: '.esc_attr__( $height ).'; display: block;"></span>';
}

add_shortcode( 'gap', 'classifieds_gap_func' );

function classifieds_gap_params(){
	return array(
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Gap Height","classifieds"),
			"param_name" => "height",
			"value" => '',
			"description" => esc_html__("Input gap height.","classifieds")
		),
	);
}

if( function_exists( 'vc_map' ) ){
	vc_map( array(
	   "name" => esc_html__("Gap", 'classifieds'),
	   "base" => "gap",
	   "category" => esc_html__('Content', 'classifieds'),
	   "params" => classifieds_gap_params()
	) );
}
?>