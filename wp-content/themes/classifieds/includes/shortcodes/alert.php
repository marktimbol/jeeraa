<?php
function classifieds_alert_func( $atts, $content ){
	extract( shortcode_atts( array(
		'text' => '',
		'border_color' => '',
		'bg_color' => '',
		'font_color' => '',
		'icon' => '',
		'closeable' => 'no',
		'close_icon_color' => '',
		'close_icon_color_hvr' => '',
	), $atts ) );

	$rnd = classifieds_random_string();

	$style_css = '
		<style>
			.'.$rnd.'.alert .close{
				color: '.$close_icon_color.';
			}
			.'.$rnd.'.alert .close:hover{
				color: '.$close_icon_color_hvr.';
			}
		</style>
	';

	return classifieds_shortcode_style( $style_css ).'
	<div class="alert '.$rnd.' alert-default '.( $closeable == 'yes' ? 'alert-dismissible' : '' ).'" role="alert" style=" color: '.$font_color.'; border-color: '.$border_color.'; background-color: '.$bg_color.';">
		'.( !empty( $icon ) && $icon !== 'No Icon' ? '<i class="fa fa-'.$icon.'"></i>' : '' ).'
		'.$text.'
		'.( $closeable == 'yes' ? '<button type="button" class="close" data-dismiss="alert"> <span aria-hidden="true">×</span> <span class="sr-only">'.esc_html__( 'Close', 'classifieds' ).'</span> </button>' : '' ).'
	</div>';
}

add_shortcode( 'alert', 'classifieds_alert_func' );

function classifieds_alert_params(){
	return array(
		array(
			"type" => "textarea",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Text","classifieds"),
			"param_name" => "text",
			"value" => '',
			"description" => esc_html__("Input alert text.","classifieds")
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Border Color","classifieds"),
			"param_name" => "border_color",
			"value" => '',
			"description" => esc_html__("Select border color for the alert box.","classifieds")
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Background Color Color","classifieds"),
			"param_name" => "bg_color",
			"value" => '',
			"description" => esc_html__("Select background color of the alert box.","classifieds")
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Text Color","classifieds"),
			"param_name" => "font_color",
			"value" => '',
			"description" => esc_html__("Select font color for the alert box text.","classifieds")
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Icon","classifieds"),
			"param_name" => "icon",
			"value" => classifieds_awesome_icons_list(),
			"description" => esc_html__("Select icon.","classifieds")
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Closeable","classifieds"),
			"param_name" => "closeable",
			"value" => array(
				esc_html__( 'No', 'classifieds' ) => 'no',
				esc_html__( 'Yes', 'classifieds' ) => 'yes'
			),
			"description" => esc_html__("Enable or disable alert closing.","classifieds")
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Close Icon Color","classifieds"),
			"param_name" => "close_icon_color",
			"value" => '',
			"description" => esc_html__("Select color for the close icon.","classifieds")
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Close Icon Color On Hover","classifieds"),
			"param_name" => "close_icon_color_hvr",
			"value" => '',
			"description" => esc_html__("Select color for the close icon on hover.","classifieds")
		),
	);
}

if( function_exists( 'vc_map' ) ){
	vc_map( array(
	   "name" => esc_html__("Alert", 'classifieds'),
	   "base" => "alert",
	   "category" => esc_html__('Content', 'classifieds'),
	   "params" => classifieds_alert_params()
	) );
}
?>