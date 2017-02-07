<?php
function classifieds_button_func( $atts, $content ){
	extract( shortcode_atts( array(
		'text' => '',
		'link' => '',
		'target' => '',
		'bg_color' => '',
		'bg_color_hvr' => '',
		'font_color' => '',
		'font_color_hvr' => '',
	), $atts ) );

	$rnd = classifieds_random_string();

	$style_css = '
	<style>
		body a.'.$rnd.'.btn,
		body a.'.$rnd.'.btn:active, 
		body a.'.$rnd.'.btn:visited, 
		body a.'.$rnd.'.btn:focus{
			'.( !empty( $bg_color ) ? 'background-color: '.$bg_color.';' : '' ).'
			'.( !empty( $font_color ) ? 'color: '.$font_color.';' : '' ).'
		}
		body a.'.$rnd.'.btn:hover{
			'.( !empty( $bg_color_hvr ) ? 'background-color: '.$bg_color_hvr.';' : '' ).'
			'.( !empty( $font_color_hvr ) ? 'color: '.$font_color_hvr.';' : '' ).'
		}		
	</style>
	';

	return classifieds_shortcode_style( $style_css ).'
		<a href="'.esc_url( $link ).'" class="btn btn-default '.$rnd.'" target="'.esc_attr__( $target ).'">
			'.$text.'
		</a>';
}

add_shortcode( 'button', 'classifieds_button_func' );

function classifieds_button_params(){
	return array(
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Button Text","classifieds"),
			"param_name" => "text",
			"value" => '',
			"description" => esc_html__("Input button text.","classifieds")
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Button Link","classifieds"),
			"param_name" => "link",
			"value" => '',
			"description" => esc_html__("Input button link.","classifieds")
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Select Window","classifieds"),
			"param_name" => "target",
			"value" => array(
				esc_html__( 'Same Window', 'classifieds' ) => '_self',
				esc_html__( 'New Window', 'classifieds' ) => '_blank',
			),
			"description" => esc_html__("Select window where to open the link.","classifieds")
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Background Color","classifieds"),
			"param_name" => "bg_color",
			"value" => '',
			"description" => esc_html__("Select button background color.","classifieds")
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Background Color On Hover","classifieds"),
			"param_name" => "bg_color_hvr",
			"value" => '',
			"description" => esc_html__("Select button background color on hover.","classifieds")
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Font Color","classifieds"),
			"param_name" => "font_color",
			"value" => '',
			"description" => esc_html__("Select button font color.","classifieds")
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Font Color On Hover","classifieds"),
			"param_name" => "font_color_hvr",
			"value" => '',
			"description" => esc_html__("Select button font color on hover.","classifieds")
		),
	);
}

if( function_exists( 'vc_map' ) ){
	vc_map( array(
	   "name" => esc_html__("Button", 'classifieds'),
	   "base" => "button",
	   "category" => esc_html__('Content', 'classifieds'),
	   "params" => classifieds_button_params()
	) );
}

?>