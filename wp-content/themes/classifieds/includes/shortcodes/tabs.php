<?php
function classifieds_tabs_func( $atts, $content ){
	extract( shortcode_atts( array(
		'titles' => '',
		'contents' => ''
	), $atts ) );

	$titles = explode( "/n/", $titles );
	$contents = explode( "/n/", $contents );

	$titles_html = '';
	$contents_html = '';

	$random = classifieds_random_string();

	if( !empty( $titles ) ){
		for( $i=0; $i<sizeof( $titles ); $i++ ){
			$titles_html .= '<li role="presentation" class="'.( $i == 0 ? 'active' : '' ).'"><a href="#tab_'.$i.'_'.$random.'" role="tab" data-toggle="tab">'.$titles[$i].'</a></li>';
			$contents_html .= '<div role="tabpanel" class="tab-pane fade '.( $i == 0 ? 'in active' : '' ).'" id="tab_'.$i.'_'.$random.'">'.( !empty( $contents[$i] ) ? apply_filters( 'the_content', $contents[$i] ) : '' ).'</div>';
		}
	}

	return '
	<!-- Nav tabs -->
	<ul class="nav nav-tabs shortcode" role="tablist">
	  '.$titles_html.'
	</ul>

	<!-- Tab panes -->
	<div class="tab-content shortcode">
	  '.$contents_html.'
	</div>';
}

add_shortcode( 'tabs', 'classifieds_tabs_func' );

function classifieds_tabs_params(){
	return array(
		array(
			"type" => "textarea",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Titles","classifieds"),
			"param_name" => "titles",
			"value" => '',
			"description" => esc_html__("Input tab titles separated by /n/.","classifieds")
		),
		array(
			"type" => "textarea_raw_html",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Contents","classifieds"),
			"param_name" => "contents",
			"value" => '',
			"description" => esc_html__("Input tab contents separated by /n/.","classifieds")
		),

	);
}

if( function_exists( 'vc_map' ) ){
	vc_map( array(
	   "name" => esc_html__("Tabs", 'classifieds'),
	   "base" => "tabs",
	   "category" => esc_html__('Content', 'classifieds'),
	   "params" => classifieds_tabs_params()
	) );
}

?>