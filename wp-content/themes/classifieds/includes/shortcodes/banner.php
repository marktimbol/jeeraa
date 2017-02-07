<?php
function classifieds_banner_func( $atts, $content ){
	extract( shortcode_atts( array(
		'bg_image' => '',
		'title' => '',
		'btn_text' => '',
		'btn_link' => '',
	), $atts ) );

	$image = '';
	if( !empty( $bg_image ) ){
		$data = wp_get_attachment_image_src( $bg_image, 'full' );
		if( !empty( $data[0] ) ){
			$image = 'background-image: url( '.esc_url( $data[0] ).' )';
		}
	}

	return '<section style="'.$image.'" class="section-banner">
		<div class="container">
			<div class="banner-content">'.( !empty( $title ) ? '<h3>'.$title.'</h3>' : '' ).''.( !empty( $btn_text ) ? '<a href="'.esc_url( $btn_link ).'" class="btn">'.$btn_text.'</a>' : '' ).'</div>
		</div>
		</section>';

}

add_shortcode( 'banner', 'classifieds_banner_func' );

function classifieds_banner_params(){
	return array(
		array(
			"type" => "attach_image",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Background Image","classifieds"),
			"param_name" => "bg_image",
			"value" => '',
			"description" => esc_html__("Select iamge as background.","classifieds")
		),		
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Title","classifieds"),
			"param_name" => "title",
			"value" => '',
			"description" => esc_html__("Input title.","classifieds")
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Button Text","classifieds"),
			"param_name" => "btn_text",
			"value" => '',
			"description" => esc_html__("Input button text.","classifieds")
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Button Link","classifieds"),
			"param_name" => "btn_link",
			"value" => '',
			"description" => esc_html__("Input button link.","classifieds")
		),
	);
}

if( function_exists( 'vc_map' ) ){
	vc_map( array(
	   "name" => esc_html__("Banner", 'classifieds'),
	   "base" => "banner",
	   "category" => esc_html__('Content', 'classifieds'),
	   "params" => classifieds_banner_params()
	) );
}

?>