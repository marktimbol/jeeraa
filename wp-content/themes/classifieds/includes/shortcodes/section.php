<?php
function classifieds_section_func( $atts, $content ){
	extract( shortcode_atts( array(
		'padding' => '',
		'margin' => '',
		'bg_color' => ''
	), $atts ) );	

	$rnd = classifieds_random_string();


	return '<section class="section '.esc_attr__( $rnd ).'"><style scoped>
		.'.$rnd.'{
			'.( !empty( $bg_color ) ? 'background-color: '.$bg_color.';' : '' ).'
			'.( !empty( $padding ) ? 'padding: '.$padding.';' : '' ).'
			'.( !empty( $margin ) ? 'margin: '.$margin.';' : '' ).'
		}
	</style><div class="container">'.do_shortcode( $content ).'</div></section>';
}

add_shortcode( 'section', 'classifieds_section_func' );

function classifieds_section_params(){
	return array(
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Padding","classifieds"),
			"param_name" => "padding",
			"value" => '',
			"description" => esc_html__("Input padding of the section.","classifieds")
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Margin","classifieds"),
			"param_name" => "margin",
			"value" => '',
			"description" => esc_html__("Input margin of the section.","classifieds")
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Background Color","classifieds"),
			"param_name" => "bg_color",
			"value" => '',
			"description" => esc_html__("Select background Color.","classifieds")
		),		
	);
}
?>