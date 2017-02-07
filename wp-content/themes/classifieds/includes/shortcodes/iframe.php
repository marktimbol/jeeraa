<?php
function classifieds_iframe_func( $atts, $content ){
	extract( shortcode_atts( array(
		'link' => '',
		'proportion' => '',
	), $atts ) );

	$random = classifieds_random_string();

	return '
		<div class="embed-responsive embed-responsive-'.$proportion.'">
		  <iframe class="embed-responsive-item" src="'.esc_url( $link ).'"></iframe>
		</div>';
}

add_shortcode( 'iframe', 'classifieds_iframe_func' );

function classifieds_iframe_params(){
	return array(
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Iframe link","classifieds"),
			"param_name" => "link",
			"value" => '',
			"description" => esc_html__("Input link you want to embed.","classifieds")
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Iframe Proportion","classifieds"),
			"param_name" => "proportion",
			"value" => array(
				esc_html__( '4 by 3', 'classifieds' ) => '4by3',
				esc_html__( '16 by 9', 'classifieds' ) => '16by9',
			),
			"description" => esc_html__("Select iframe proportion.","classifieds")
		),

	);
}

if( function_exists( 'vc_map' ) ){
	vc_map( array(
	   "name" => esc_html__("Iframe", 'classifieds'),
	   "base" => "iframe",
	   "category" => esc_html__('Content', 'classifieds'),
	   "params" => classifieds_iframe_params()
	) );
}

?>