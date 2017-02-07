<?php
function classifieds_pricings_func( $atts, $content ){
	$basic_ad_price = classifieds_get_option( 'basic_ad_price' );
	$basic_ad_title = classifieds_get_option( 'basic_ad_title' );
	$basic_ad_subtitle = classifieds_get_option( 'basic_ad_subtitle' );
	global $classifieds_slugs;
	$basic_html = '';
	$submit_link = '<a href="#register" data-toggle="modal" class="btn">';
	if( is_user_logged_in() ){
		$submit_link = add_query_arg( array( $classifieds_slugs['subpage'] => 'submit_ad' ), classifieds_get_permalink_by_tpl('page-tpl_my_profile') );
		$submit_link = '<a href="'.esc_url( $submit_link ).'" class="btn">';
	}
	if( ( !empty( $basic_ad_price ) || $basic_ad_price == 0 ) && !empty( $basic_ad_title ) && !empty( $basic_ad_subtitle ) ){
		$basic_html = '
			<div class="pricing-box clearfix">
				<div class="pricing-value">
					'.classifieds_pricing_format( $basic_ad_price ).'
				</div>
				<div class="pricing-info">
					<h4>'.$basic_ad_title.'</h4>
					<p>'.$basic_ad_subtitle.'</p>
					'.$submit_link.'
						'.esc_html__( 'SUBMIT AD', 'classifieds' ).'
					</a>					
				</div>
			</div>
		';
	}

	$featured_ad_price = classifieds_get_option( 'featured_ad_price' );
	$featured_ad_title = classifieds_get_option( 'featured_ad_title' );
	$featured_ad_subtitle = classifieds_get_option( 'featured_ad_subtitle' );
	$featured_html = '';
	if( !empty( $featured_ad_price ) && !empty( $featured_ad_title ) && !empty( $featured_ad_subtitle ) ){

		$featured_html = '
			<div class="pricing-box clearfix">
				<div class="pricing-value">
					'.classifieds_pricing_format( $featured_ad_price ).'
				</div>
				<div class="pricing-info">
					<h4>'.$featured_ad_title.'</h4>
					<p>'.$featured_ad_subtitle.'</p>
					'.$submit_link.'
						'.esc_html__( 'SUBMIT FEATURED AD', 'classifieds' ).'
					</a>					
				</div>
			</div>
		';
	}	

	$pricings_html = '<div class="col-md-12"><div class="row">';
	if( !empty( $basic_html ) ){
		$pricings_html .= '<div class="col-md-'.( !empty( $featured_html ) ? '6' : '12' ).'">'.$basic_html.'</div>';
	}
	if( !empty( $featured_html ) ){
		$pricings_html .= '<div class="col-md-'.( !empty( $basic_html ) ? '6' : '12' ).'">'.$featured_html.'</div>';
	}	
	$pricings_html .= '</div></div>';

	return $pricings_html;
}

add_shortcode( 'pricings', 'classifieds_pricings_func' );

function classifieds_pricings_params(){
	return array();
}
?>