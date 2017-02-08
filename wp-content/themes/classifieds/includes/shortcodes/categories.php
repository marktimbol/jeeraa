<?php
function classifieds_categories_func( $atts, $content ){
	extract( shortcode_atts( array(
		'categories' => '',
		'number' => '',
		'orderby' => 'name',
		'order' => 'ASC',
		'subcategories' => '5',
		'use_slider' => 'yes',
		'style' => 'style1',
		'show_count' => 'no',
	), $atts ) );

	global $classifieds_slugs;

	$categories_args = array(
		'hide_empty' => false,
		'orderby' => $orderby,
		'order' => $order,
	);

	if( !empty( $number ) ){
		if( $number > -1 ){
			$categories_args['number'] = $number;
		}
		$categories_args['parent'] = '0';	
	}
	else{
		$categories = explode( ',', $categories );
		if( !empty( $categories ) ){
			$categories_args['include'] = $categories;
		}
	}

	$categories_array = get_terms( 'ad-category', $categories_args );

	$html = '<div class="'.( $use_slider == 'no' ? esc_attr__( 'row' ) : '' ).'">';
	$counter = 0;
	$permalink = classifieds_get_permalink_by_tpl( 'page-tpl_search_page' );
	$permalink_cats = classifieds_get_permalink_by_tpl( 'page-tpl_all_categories' );
	if( !empty( $categories_array ) ){
		foreach( $categories_array as $category ){
        	$term_meta = get_option( "taxonomy_".$category->slug );
			$value = !empty( $term_meta['category_image'] ) ? $term_meta['category_image'] : '';

			$subcategories_html = array();
			if( !empty( $subcategories ) ){
				$subcategories_array = get_terms( 'ad-category', array(
					'hide_empty' => false,
					'orderby' => $orderby,
					'order' => $order,
					'number' => $subcategories,
					'parent' => $category->term_id
				));

				if( !empty( $subcategories_array ) ){
					foreach( $subcategories_array as $subcategory ){
						$subcategories_html[] = '<a href="'.esc_attr__( add_query_arg( array( $classifieds_slugs['category'] => $subcategory->slug ), $permalink ) ).'">'.$subcategory->name.' '.( $show_count == 'yes' ? '('.classifieds_category_count( $subcategory->slug ).')' : '' ).'</a>';
					}
				}
			}

			if( ( sizeof( $categories_array ) > 2 && $counter == 2 ) || ( sizeof( $categories_array ) <=2 && $counter == 1 ) ){
				$counter = 0;
				$html .= '</div><div class="'.( $use_slider == 'no' ? esc_attr__( 'row' ) : '' ).'">';
			}
			$counter++;
			$html .= '<div class="'.( $use_slider == 'no' ? esc_attr( 'col-md-'.( sizeof( $categories_array ) > 2 ? esc_attr( 6 ) : esc_attr( 12 ) ) ) : '' ).'">';

			if( $style == 'style1' ){
				$html .='<div class="white-block category-item">
					<div clas="clearfix">
						<div class="pull-left">
							<a href="'.esc_attr__( add_query_arg( array( $classifieds_slugs['category'] => $category->slug ), $permalink ) ).'">
								'.wp_get_attachment_image( $value, 'classifieds-ad-thumb' ).'
							</a>
						</div>
						<div class="category-item-content">
							<h4>
								<a href="'.esc_attr__( add_query_arg( array( $classifieds_slugs['category'] => $category->slug ), $permalink ) ).'">
									'.$category->name.' '.( $show_count == 'yes' ? '('.classifieds_category_count( $category->slug ).')' : '' ).'
								</a>
							</h4>
							'.( !empty( $subcategories_html ) ? '<div class="category-subs">'.join( $subcategories_html, ', ' ).'</div>' : '' ).'
							<a href="'.esc_attr__( $permalink_cats ).'" class="category-see-more">
								'.esc_html__( '+ See more', 'classifieds' ).'
							</a>
						</div>
					</div>
				</div>';
			}
			else{
				$image_data = wp_get_attachment_image_src( $value, 'classifieds-ad-category-bg-thumb' );
				$style = '';
				if( !empty( $image_data ) ){
					$style = 'background-image:url('.esc_attr__( $image_data[0] ).')';
				}

				$html .='<div class="white-block category-item category-item-alt" style="'.$style.'">
						<a class="image-clickable" href="'.esc_attr__( add_query_arg( array( $classifieds_slugs['category'] => $category->slug ), $permalink ) ).'">
							<div class="category-item-content">
								<div class="category-item-main-content">
									<h4>
										<a href="'.esc_attr__( add_query_arg( array( $classifieds_slugs['category'] => $category->slug ), $permalink ) ).'">
											'.$category->name.' '.( $show_count == 'yes' ? '('.classifieds_category_count( $category->slug ).')' : '' ).'
										</a>
									</h4>
									'.( !empty( $subcategories_html ) ? '<div class="category-subs">'.join( $subcategories_html, ', ' ).'</div>' : '' ).'
									<a href="'.esc_attr__( $permalink_cats ).'" class="category-see-more">
										'.esc_html__( '+ See more', 'classifieds' ).'
									</a>
								</div>
							</div>
						</a>
						</div>';
			}

			$html .= '</div>';
		}
	}
	$html = $html.'</div>';

	if( $use_slider == 'yes' ){
		$html = '<div class="categories-slider">'.$html.'</div>';
	}

	return $html;
}

add_shortcode( 'categories', 'classifieds_categories_func' );

function classifieds_categories_params(){
	return array(
		array(
			"type" => "multidropdown",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Select Categories","classifieds"),
			"param_name" => "categories",
			"value" => classifieds_get_custom_tax_list( 'ad-category', 'left', false, 'term_id' ),
			"description" => esc_html__("Select categories to show.","classifieds")
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Number of categories ( -1 for all )","classifieds"),
			"param_name" => "number",
			"value" => '',
			"description" => esc_html__("Input hom many categories to display if you do not want to pick them.","classifieds")
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Order By","classifieds"),
			"param_name" => "orderby",
			"value" => array(
				esc_html__( 'Name', 'classifieds' ) => 'name',
				esc_html__( 'Count', 'classifieds' ) => 'count',
			),
			"description" => esc_html__("Select by which field to order categories","classifieds")
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Order","classifieds"),
			"param_name" => "order",
			"value" => array(
				esc_html__( 'ASC', 'classifieds' ) => 'asc',
				esc_html__( 'DESC', 'classifieds' ) => 'desc',
			),
			"description" => esc_html__("Select how to order categories","classifieds")
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Number of subctegories ( -1 for all )","classifieds"),
			"param_name" => "subcategories",
			"value" => '',
			"description" => esc_html__("Input hom many subcategories to display.","classifieds")
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
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Box Style","classifieds"),
			"param_name" => "style",
			"value" => array(
				esc_html__( 'Side Media', 'classifieds' ) => 'style1',
				esc_html__( 'Background Media', 'classifieds' ) => 'style2',
			),
			"description" => esc_html__("Select box style","classifieds")
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Show Count","classifieds"),
			"param_name" => "show_count",
			"value" => array(
				esc_html__( 'No', 'classifieds' ) => 'no',
				esc_html__( 'Yes', 'classifieds' ) => 'yes',
			),
			"description" => esc_html__("Display or hide count of ads per category","classifieds")
		),
	);
}

if( function_exists( 'vc_map' ) ){
	vc_map( array(
	   "name" => esc_html__("categories", 'classifieds'),
	   "base" => "categories",
	   "category" => esc_html__('Content', 'classifieds'),
	   "params" => classifieds_categories_params()
	) );
}
?>