<?php
function classifieds_label_func( $atts, $content ){
	extract( shortcode_atts( array(
		'text' => '',
		'bg_color' => '',
		'font_color' => '',
	), $atts ) );

	return '<span class="label label-default" style="color: '.$font_color.'; background-color: '.$bg_color.'">'.$text.'</span>';
}

add_shortcode( 'label', 'classifieds_label_func' );

function classifieds_label_params(){
	return array(
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Text","classifieds"),
			"param_name" => "text",
			"value" => '',
			"description" => esc_html__("Input label text.","classifieds")
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Background Color Color","classifieds"),
			"param_name" => "bg_color",
			"value" => '',
			"description" => esc_html__("Select background color of the label.","classifieds")
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Text Color","classifieds"),
			"param_name" => "font_color",
			"value" => '',
			"description" => esc_html__("Select font color for the label text.","classifieds")
		),

	);
}

if( function_exists( 'vc_map' ) ){
	vc_map( array(
	   "name" => esc_html__("Label", 'classifieds'),
	   "base" => "label",
	   "category" => esc_html__('Content', 'classifieds'),
	   "params" => classifieds_label_params()
	) );
}

?>