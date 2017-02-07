<?php
function classifieds_icon_func( $atts, $content ){
	extract( shortcode_atts( array(
		'icon' => '',
		'color' => '',
		'size' => '',
	), $atts ) );

	return '<span class="fa fa-'.$icon.'" style="color: '.$color.'; font-size: '.$size.'; margin: 0px 2px;"></span>';
}

add_shortcode( 'icon', 'classifieds_icon_func' );

function classifieds_icon_params(){
	return array(
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Select Icon","classifieds"),
			"param_name" => "icon",
			"value" => classifieds_awesome_icons_list(),
			"description" => esc_html__("Select an icon you want to display.","classifieds")
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Icon Color","classifieds"),
			"param_name" => "color",
			"value" => '',
			"description" => esc_html__("Select color of the icon.","classifieds")
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Icon Size","classifieds"),
			"param_name" => "size",
			"value" => '',
			"description" => esc_html__("Input size of the icon.","classifieds")
		),

	);
}

if( function_exists( 'vc_map' ) ){
	vc_map( array(
	   "name" => esc_html__("Icon", 'classifieds'),
	   "base" => "icon",
	   "category" => esc_html__('Content', 'classifieds'),
	   "params" => classifieds_icon_params()
	) );
}

?>