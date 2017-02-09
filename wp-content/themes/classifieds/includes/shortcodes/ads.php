<?php
function classifieds_ads_func( $atts, $content ){
	extract( shortcode_atts( array(
		'top_ads' => 'yes',
		'featured' => 'yes',
		'giveaways'	=> 'yes',
		'requests'	=> 'yes',
		'random' => 'yes',
		'custom_ads_id' => '',
		'ads' => '10',
		'use_slider' => 'yes',
		'style' => 'style1',
		'show_button' => 'yes',
	), $atts ) );

	$is_activated = false;
	$titles = 0;

	$navigation = '<ul class="nav nav-tabs" role="tablist">';
	$content = '<div class="tab-content">';

	if( $top_ads == 'yes' ){
		$navigation .= '<li role="presentation" class="'.( !$is_activated ? 'active' : '' ).'"><a href="#top_cads" aria-controls="top_cads" role="tab" data-toggle="tab">'.esc_html__( 'LATEST ADS', 'classifieds' ).'</a></li>';
		$content .= '<div role="tabpanel" class="tab-pane '.( !$is_activated ? 'active' : '' ).'" id="top_cads"><div class="ads-slider '.( $use_slider == 'no' ? 'no-slider' : '' ).' '.esc_attr__( $style ).'">'.classifieds_ads( 'latest_ads', $ads, $use_slider, $style ).'</div></div>';
		$is_activated = true;
		$titles++;
	}
	if( $giveaways == 'yes' ){
		$navigation .= '<li role="presentation" class="'.( !$is_activated ? 'active' : '' ).'"><a href="#giveaways" aria-controls="featured" role="tab" data-toggle="tab">'.esc_html__( 'GIVEAWAYS', 'classifieds' ). ' &nbsp; <i class="fa fa-gift"></i></a></li>';
		$content .= '<div role="tabpanel" class="tab-pane '.( !$is_activated ? 'active' : '' ).'" id="giveaways"><div class="ads-slider '.( $use_slider == 'no' ? 'no-slider' : '' ).' '.esc_attr__( $style ).'">'.classifieds_ads( 'giveaways', $ads, $use_slider, $style ).'</div></div>';
		$is_activated = true;
		$titles++;
	}
	if( $requests == 'yes' ){
		$navigation .= '<li role="presentation" class="'.( !$is_activated ? 'active' : '' ).'"><a href="#for_requests" aria-controls="random" role="tab" data-toggle="tab">'.esc_html__( 'REQUESTS', 'classifieds' ).' &nbsp; <i class="fa fa-heart"></i></a></li>';
		$content .= '<div role="tabpanel" class="tab-pane '.( !$is_activated ? 'active' : '' ).'" id="for_requests"><div class="ads-slider '.( $use_slider == 'no' ? 'no-slider' : '' ).' '.esc_attr__( $style ).'">'.classifieds_ads( 'for_requests', $ads, $use_slider, $style ).'</div></div>';
		$is_activated = true;
		$titles++;
	}
	if( !empty( $custom_ads_id ) ){
		$navigation .= '<li role="presentation" class="'.( !$is_activated ? 'active' : '' ).'"><a href="#picked" aria-controls="random" role="tab" data-toggle="tab">'.esc_html__( 'PICKED', 'classifieds' ).'</a></li>';
		$content .= '<div role="tabpanel" class="tab-pane '.( !$is_activated ? 'active' : '' ).'" id="picked"><div class="ads-slider '.( $use_slider == 'no' ? 'no-slider' : '' ).' '.esc_attr__( $style ).'">'.classifieds_ads( 'picked', $ads, $use_slider, $style, $custom_ads_id ).'</div></div>';
		$is_activated = true;
		$titles++;
	}
	$content .= '</div>';
	$navigation .= '</ul>';	

	$html = ( $titles > 1 ? '<div class="text-center">'.$navigation.'</div>' : '' ).$content;
	if( $show_button == 'yes' ){
		$html .= '<div class="text-center all-ads"><a href="'.esc_url( classifieds_get_permalink_by_tpl( 'page-tpl_search_page' ) ).'" class="btn">'.esc_html__( 'SEE ALL ADS', 'classifieds' ).'</a></div>';
	}

	return $html;
}

add_shortcode( 'ads', 'classifieds_ads_func' );

function classifieds_ads( $source, $ads, $use_slider, $style, $custom_ids = '' ){
	$ads_args = array(
		'post_status' => 'publish',
		'posts_per_page' => $ads,
		'post_type' => 'ad',
		'meta_query' => array(
			array(
				'key' => 'ad_expire',
				'value' => current_time( 'timestamp' ),
				'compare' => '>='
			),
	        array(
	            'key' => 'ad_visibility',
	            'value' => 'yes',
	            'compare' => '='
	        )			
		)
	);
	switch( $source ){
		case 'giveaways':
			$ads_args['meta_query'] = array(
				array(
					'key' => 'ad_price',
					'value' => 'GIVEAWAY',
				),			
			);
			break;
		case 'for_requests':
			$ads_args['meta_query'] = array(
				array(
					'key' => 'ad_price',
					'value' => 'REQUEST',
				),				
			);
			break;
		case 'picked':
			$custom_ids = explode(',', $custom_ids);
			$ads_args['post__in'] = $custom_ids;
			$ads_args['orderby'] = 'post__in';
			break;
	}

	$ads = new WP_Query( $ads_args );

	$list = '';
	$columns = 0;
	$html_container = array();
	if( $ads->have_posts() ){
		$counter = 0;
		if( $use_slider == 'yes' ){
			$columns = ceil( $ads->post_count / 2 );
			$html_container = array();

			while( $ads->have_posts() ){
				$ads->the_post();
				if( $counter == $columns ){
					$counter = 0;
				}			
				$counter++;
				if( empty( $html_container['column'.$counter] ) ){
					$html_container['column'.$counter] = '';
				}
				ob_start();
				if( $style == 'style1' ){
					include( classifieds_load_path( 'includes/ad-box.php' ) );
				}
				else{
					include( classifieds_load_path( 'includes/ad-box-alt.php' ) );	
				}
				$html_container['column'.$counter] .= ob_get_contents();
				ob_end_clean();
			}
			$list .= '</div>';

			for( $i=1; $i<=$columns; $i++ ){
				$html_container['column'.$i] = '<div>'.$html_container['column'.$i].'</div>';
			}
		}
		else{
			$html_container[0] = '<div class="row">';
			while( $ads->have_posts() ){
				$ads->the_post();
				if( $counter == 4 && $style == 'style1' ){
					$counter = 0;
					$html_container[0] .= '</div><div class="row">';
				}
				else if( $counter == 2 && $style == 'style2' ){
					$counter = 0;
					$html_container[0] .= '</div><div class="row">';
				}
				$counter++;
				ob_start();
				if( $style == 'style1' ){
					include( classifieds_load_path( 'includes/ad-box.php' ) );
				}
				else{
					include( classifieds_load_path( 'includes/ad-box-alt.php' ) );
				}
				$html_container[0] .= '<div class="'.( $style == 'style1' ? 'col-sm-6 col-md-3' : 'col-md-6' ).'">'.ob_get_contents().'</div>';
				ob_end_clean();
			}

			$html_container[0] .= '</div>';
		}
	}	
	wp_reset_postdata();

	return join( '', $html_container );	
}

function classifieds_ads_params(){
	return array(
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Show Top Ads","classifieds"),
			"param_name" => "top_ads",
			"value" => array(
				esc_html__( 'Yes', 'classifieds' ) => 'yes',
				esc_html__( 'No', 'classifieds' ) => 'no',
			),
			"description" => esc_html__("Display or hide top ads","classifieds")
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Show Featured Ads","classifieds"),
			"param_name" => "featured",
			"value" => array(
				esc_html__( 'Yes', 'classifieds' ) => 'yes',
				esc_html__( 'No', 'classifieds' ) => 'no',
			),
			"description" => esc_html__("Display or hide featured ads","classifieds")
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Show Random Ads","classifieds"),
			"param_name" => "random",
			"value" => array(
				esc_html__( 'Yes', 'classifieds' ) => 'yes',
				esc_html__( 'No', 'classifieds' ) => 'no',
			),
			"description" => esc_html__("Display or hide random ads","classifieds")
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Ads By Ids","classifieds"),
			"param_name" => "custom_ads_id",
			"value" => '',
			"description" => esc_html__("Input comma separated list of ad ids which you wish to show","classifieds")
		),		
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Use Slider","classifieds"),
			"param_name" => "use_slider",
			"value" => array(
				esc_html__( 'Yes', 'classifieds' ) => 'yes',
				esc_html__( 'No', 'classifieds' ) => 'no',
			),
			"description" => esc_html__("Display or hide slider","classifieds")
		),		
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Number Of Ads","classifieds"),
			"param_name" => "ads",
			"value" => '10',
			"description" => esc_html__("Input number of ads you wish to shiow in each panel","classifieds")
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Box Style","classifieds"),
			"param_name" => "style",
			"value" => array(
				esc_html__( 'Top Media', 'classifieds' ) => 'style1',
				esc_html__( 'Side Media', 'classifieds' ) => 'style2',
			),
			"description" => esc_html__("Select box style","classifieds")
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Show All Ads Link","classifieds"),
			"param_name" => "show_button",
			"value" => array(
				esc_html__( 'Yes', 'classifieds' ) => 'yes',
				esc_html__( 'No', 'classifieds' ) => 'no',
			),
			"description" => esc_html__("Enable or disable dispaly of the See All Ads button","classifieds")
		),		
	);
}
?>