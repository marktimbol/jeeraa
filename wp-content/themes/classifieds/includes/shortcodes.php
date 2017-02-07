<?php

class Shortcodes{
	
	function __construct(){
		add_action( 'init', array( $this, 'shortcode_buttons' ) );
		add_action('wp_ajax_shortcode_call', array( $this, 'shortcode_options' ) );
		add_action('wp_ajax_nopriv_shortcode_call', array( $this, 'shortcode_options' ) );
	}

	function shortcode_buttons(){
		add_filter( "mce_external_plugins", array( $this, "add_buttons" ) );
	    add_filter( 'mce_buttons', array( $this, 'register_buttons' ) );	
	}
	

	function add_buttons( $plugin_array ) {
	    $plugin_array['classifieds'] = get_template_directory_uri() . '/js/shortcodes.js';
	    return $plugin_array;
	}

	function register_buttons( $buttons ) {
	    array_push( $buttons, 'classifiedsgrid', 'classifiedselements' ); 
	    return $buttons;
	}

	function shortcode_options(){
		$shortcode = $_POST['shortcode'];
		if( $shortcode == 'row' || $shortcode == 'pricings' ){
			echo '';
		}
		else{
			$shortcode = 'classifieds_'.$shortcode.'_params';
			echo  $this->render_options( $shortcode() );
		}
		die();
	}


	function render_options( $fields ){
		$fields_html = '';
		foreach( $fields as $field ){
			if( !in_array( $field['type'], array( 'css_editor', 'textarea_html' ) ) ){
				$fields_html .= '<div class="shortcode-option"><label>'.$field['heading'].'</label>';
				switch ( $field['type'] ){
					case 'textfield' : 
						$fields_html .= '<input type="text" class="shortcode-field" name="'.$field['param_name'].'" value="'.$field['value'].'">';
						break;
					case 'dropdown' :
						$options = '';
						if( !empty( $field['value'] ) ){
							foreach( $field['value'] as $option_name => $option_value ){
								$options .= '<option value="'.$option_value.'">'.$option_name.'</option>';
							}
						}
						$fields_html .= '<select name="'.$field['param_name'].'" class="shortcode-field">'.$options.'</select>';
						break;
					case 'multidropdown' :
						$options = '';
						if( !empty( $field['value'] ) ){
							foreach( $field['value'] as $option_name => $option_value ){
								$options .= '<option value="'.$option_value.'">'.$option_name.'</option>';
							}
						}
						$fields_html .= '<select name="'.$field['param_name'].'" class="shortcode-field" multiple>'.$options.'</select>';
						break;
					case 'colorpicker' :
						$fields_html .= '<input type="text" name="'.$field['param_name'].'" class="shortcode-field shortcode-colorpicker" value="'.$field['value'].'" />';
						break;
					case 'attach_image' :
						$fields_html .= '<div class="shortcode-image-holder"></div><div class="clearfix"></div>
										<a href="javascript:;" class="shortcode-add-image button">'.esc_html__( 'Add Image', 'classifieds' ).'</a>
										<input type="hidden" name="'.$field['param_name'].'" class="shortcode-field" valu="'.$field['value'].'">';
						break;	
					case 'attach_images' :
						$fields_html .= '<div class="shortcode-images-holder"></div><div class="clearfix"></div>
										<a href="javascript:;" class="shortcode-add-images button">'.esc_html__( 'Add Images', 'classifieds' ).'</a>
										<input type="hidden" name="'.$field['param_name'].'" class="shortcode-field" value="'.$field['value'].'">';
						break;
					case 'textarea' :					
						$fields_html .= '<textarea name="'.$field['param_name'].'" class="shortcode-field">'.$field['value'].'</textarea>';
						break;
					case 'textarea_raw_html' :					
						$fields_html .= '<textarea name="'.$field['param_name'].'" class="shortcode-field">'.$field['value'].'</textarea>';
						break;						
				}
				$fields_html .= '<div class="description">'.$field['description'].'</div></div>';
			}
		}


		echo  $fields_html.'<a href="javascript:;" class="shortcode-save-options button">'.esc_html__( 'Insert', 'classifieds' ).'</a>';
		die();

	}
}

if( is_admin() ){
	new Shortcodes();
}

?>