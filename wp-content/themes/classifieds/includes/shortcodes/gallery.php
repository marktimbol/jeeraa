<?php
function classifieds_bg_gallery_func( $atts, $content ){
	extract( shortcode_atts( array(
		'images' => '',
		'thumb_image_size' => 'post-thumbnail',
		'columns' => '3',
	), $atts ) );

	ob_start();
	echo do_shortcode( '[gallery columns="'.$columns.'" ids="'.$images.'" size="'.$thumb_image_size.'"]' );
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}

add_shortcode( 'bg_gallery', 'classifieds_bg_gallery_func' );

function classifieds_bg_gallery_params(){
	return array(
		array(
			"type" => "attach_images",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Select Images","classifieds"),
			"param_name" => "images",
			"value" => '',
			"description" => esc_html__("Select images for the gallery.","classifieds")
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Thumbnail Image Size","classifieds"),
			"param_name" => "thumb_image_size",
			"value" => classifieds_get_image_sizes(),
			"description" => esc_html__("Select image size you want to display for the thumbnails.","classifieds")
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Columns","classifieds"),
			"param_name" => "columns",
			"value" => array(
				'1' => '1',
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'5' => '5',
				'6' => '6',
				'7' => '7',
				'8' => '8',
				'9' => '9',
				'10' => '10',
			),
			"description" => esc_html__("Select number of columns for the thumbnails.","classifieds")
		),
	);
}
if( function_exists( 'vc_map' ) ){
	vc_map( array(
	   "name" => esc_html__("Gallery", 'classifieds'),
	   "base" => "bg_gallery",
	   "category" => esc_html__('Content', 'classifieds'),
	   "params" => classifieds_bg_gallery_params()
	) );
}

?>