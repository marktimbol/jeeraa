<?php

/******************************************************** 
Classifieds Subscribe
********************************************************/
class Classifieds_Follow_Us extends WP_Widget{
	function __construct() {
		parent::__construct('classifieds_follow_us', esc_html__('Classifieds Follow Us','classifieds'), array('description' =>esc_html__('Follow us.','classifieds') ));
	}

	function widget($args, $instance) {
		/** This filter is documented in wp-includes/default-widgets.php */
		$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$facebook = !empty( $instance['facebook'] ) ? '<a href="'.esc_url( $instance['facebook'] ).'" target="_blank" class="btn"><span class="fa fa-facebook"></span></a>' : '';
		$twitter = !empty( $instance['twitter'] ) ? '<a href="'.esc_url( $instance['twitter'] ).'" target="_blank" class="btn"><span class="fa fa-twitter"></span></a>' : '';
		$linkedin = !empty( $instance['linkedin'] ) ? '<a href="'.esc_url( $instance['linkedin'] ).'" target="_blank" class="btn"><span class="fa fa-linkedin"></span></a>' : '';
		$google = !empty( $instance['google'] ) ? '<a href="'.esc_url( $instance['google'] ).'" target="_blank" class="btn"><span class="fa fa-google-plus"></span></a>' : '';

		echo  $args['before_widget'];
		
		if ( !empty($instance['title']) ){
			echo  $args['before_title'] . $instance['title'] . $args['after_title'];
		}
		echo '<div class="widget-social">';
			echo  $facebook.$twitter.$linkedin.$google;
		echo '</div>';
		echo  $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( stripslashes($new_instance['title']) );
		$instance['facebook'] = strip_tags( stripslashes($new_instance['facebook']) );
		$instance['twitter'] = strip_tags( stripslashes($new_instance['twitter']) );
		$instance['linkedin'] = strip_tags( stripslashes($new_instance['linkedin']) );
		$instance['google'] = strip_tags( stripslashes($new_instance['google']) );
		return $instance;
	}

	function form( $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$facebook = isset( $instance['facebook'] ) ? $instance['facebook'] : '';
		$twitter = isset( $instance['twitter'] ) ? $instance['twitter'] : '';
		$linkedin = isset( $instance['linkedin'] ) ? $instance['linkedin'] : '';
		$google = isset( $instance['google'] ) ? $instance['google'] : '';
		?>
		<p>
			<label for="<?php echo esc_attr__( $this->get_field_id('title') ); ?>"><?php esc_html_e('Title:', 'classifieds') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr__( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr__( $this->get_field_name('title') ); ?>" value="<?php echo esc_attr__( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr__( $this->get_field_id('facebook') ); ?>"><?php esc_html_e('Facebook:', 'classifieds') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr__( $this->get_field_id('facebook') ); ?>" name="<?php echo esc_attr__( $this->get_field_name('facebook') ); ?>" value="<?php echo esc_url( $facebook ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr__( $this->get_field_id('twitter') ); ?>"><?php esc_html_e('Twitter:', 'classifieds') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr__( $this->get_field_id('twitter') ); ?>" name="<?php echo esc_attr__( $this->get_field_name('twitter') ); ?>" value="<?php echo esc_url( $twitter ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr__( $this->get_field_id('linkedin') ); ?>"><?php esc_html_e('Linkedin:', 'classifieds') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr__( $this->get_field_id('linkedin') ); ?>" name="<?php echo esc_attr__( $this->get_field_name('linkedin') ); ?>" value="<?php echo esc_url( $linkedin ); ?>" />
		</p>		
		<p>
			<label for="<?php echo esc_attr__( $this->get_field_id('google') ); ?>"><?php esc_html_e('Google +:', 'classifieds') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr__( $this->get_field_id('google') ); ?>" name="<?php echo esc_attr__( $this->get_field_name('google') ); ?>" value="<?php echo esc_url( $google );   ?>" />
		</p>
		<?php
	}
}

class Classifieds_Logo_Text extends WP_Widget{
	function __construct() {
		parent::__construct('classifieds_logo_text', esc_html__('Classifieds Logo Text','classifieds'), array('description' =>esc_html__('Display logo and custom text.','classifieds') ));
	}

	function widget($args, $instance) {
		/** This filter is documented in wp-includes/default-widgets.php */
		$logo_link = $instance['logo_link'];
		$text = $instance['text'];

		echo  $args['before_widget'];
		
		if ( !empty($instance['title']) ){
			echo  $args['before_title'] . $instance['title'] . $args['after_title'];
		}
		echo '<div class="widget-social">';
			echo '<img src="'.esc_url( $logo_link ).'" alt="">';
			echo '<p>'.$text.'</p>';
		echo '</div>';
		echo  $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['logo_link'] = strip_tags( stripslashes($new_instance['logo_link']) );
		$instance['text'] = $new_instance['text'];
		return $instance;
	}

	function form( $instance ) {
		$logo_link = isset( $instance['logo_link'] ) ? $instance['logo_link'] : '';
		$text = isset( $instance['text'] ) ? $instance['text'] : '';
		?>
		<p>
			<label for="<?php echo esc_attr__( $this->get_field_id('logo_link') ); ?>"><?php esc_html_e('Logo Link:', 'classifieds') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr__( $this->get_field_id('logo_link') ); ?>" name="<?php echo esc_attr__( $this->get_field_name('logo_link') ); ?>" value="<?php echo esc_url( $logo_link ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr__( $this->get_field_id('text') ); ?>"><?php esc_html_e('Text:', 'classifieds') ?></label>
			<textarea class="widefat" id="<?php echo esc_attr__( $this->get_field_id('text') ); ?>" name="<?php echo esc_attr__( $this->get_field_name('text') ); ?>" ><?php echo  $text; ?></textarea>
		</p>
		<?php
	}
}


class Classifieds_Text extends WP_Widget{
	function __construct() {
		parent::__construct('classifieds_text', esc_html__('Classifieds Text','classifieds'), array('description' =>esc_html__('Display custom text.','classifieds') ));
	}

	function widget($args, $instance) {
		/** This filter is documented in wp-includes/default-widgets.php */
		$title = $instance['title'];
		$text = $instance['text'];

		echo  $args['before_widget'];
		
		if ( !empty($instance['title']) ){
			echo  $args['before_title'] . $instance['title'] . $args['after_title'];
		}
		echo '<p>'.$text.'</p>';
		echo  $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( stripslashes($new_instance['title']) );
		$instance['text'] = $new_instance['text'];
		return $instance;
	}

	function form( $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$text = isset( $instance['text'] ) ? $instance['text'] : '';
		?>
		<p>
			<label for="<?php echo esc_attr__( $this->get_field_id('title') ); ?>"><?php esc_html_e('Title:', 'classifieds') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr__( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr__( $this->get_field_name('title') ); ?>" value="<?php echo esc_attr__( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr__( $this->get_field_id('text') ); ?>"><?php esc_html_e('Text:', 'classifieds') ?></label>
			<textarea class="widefat" id="<?php echo esc_attr__( $this->get_field_id('text') ); ?>" name="<?php echo esc_attr__( $this->get_field_name('text') ); ?>" ><?php echo  $text; ?></textarea>
		</p>
		<?php
	}
}

class Classifieds_Google_Adsense extends WP_Widget{
	function __construct() {
		parent::__construct('classifieds_adsense', esc_html__('Classifieds Google Adsense','classifieds'), array('description' =>esc_html__('Display HTML of the google adsense.','classifieds') ));
	}

	function widget($args, $instance) {
		/** This filter is documented in wp-includes/default-widgets.php */
		$title = $instance['title'];
		$text = $instance['text'];

		echo  $args['before_widget'];
		
		if ( !empty($instance['title']) ){
			echo  $args['before_title'] . $instance['title'] . $args['after_title'];
		}
		echo $text;
		echo  $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( stripslashes($new_instance['title']) );
		$instance['text'] = $new_instance['text'];
		return $instance;
	}

	function form( $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$text = isset( $instance['text'] ) ? $instance['text'] : '';
		?>
		<p>
			<label for="<?php echo esc_attr__( $this->get_field_id('title') ); ?>"><?php esc_html_e('Title:', 'classifieds') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr__( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr__( $this->get_field_name('title') ); ?>" value="<?php echo esc_attr__( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr__( $this->get_field_id('text') ); ?>"><?php esc_html_e('Text:', 'classifieds') ?></label>
			<textarea class="widefat" id="<?php echo esc_attr__( $this->get_field_id('text') ); ?>" name="<?php echo esc_attr__( $this->get_field_name('text') ); ?>" ><?php echo  $text; ?></textarea>
		</p>
		<?php
	}
}

class Classifieds_Payments extends WP_Widget{
	function __construct() {
		parent::__construct('classifieds_payments', esc_html__('Classifieds Payments','classifieds'), array('description' =>esc_html__('Display payment methiods.','classifieds') ));
	}

	function widget($args, $instance) {
		/** This filter is documented in wp-includes/default-widgets.php */
		$title = $instance['title'];
		$link_1 = !empty( $instance['link_1'] ) ? $instance['link_1'] : '';
		$image_tag_1 = !empty( $instance['image_tag_1'] ) ? $instance['image_tag_1'] : '';
		$link_2 = !empty( $instance['link_2'] ) ? $instance['link_2'] : '';
		$image_tag_2 = !empty( $instance['image_tag_2'] ) ? $instance['image_tag_2'] : '';
		$link_3 = !empty( $instance['link_3'] ) ? $instance['link_3'] : '';
		$image_tag_3 = !empty( $instance['image_tag_3'] ) ? $instance['image_tag_3'] : '';
		$link_4 = !empty( $instance['link_4'] ) ? $instance['link_4'] : '';
		$image_tag_4 = !empty( $instance['image_tag_4'] ) ? $instance['image_tag_4'] : '';
		$link_5 = !empty( $instance['link_5'] ) ? $instance['link_5'] : '';
		$image_tag_5 = !empty( $instance['image_tag_5'] ) ? $instance['image_tag_5'] : '';
		$link_6 = !empty( $instance['link_6'] ) ? $instance['link_6'] : '';
		$image_tag_6 = !empty( $instance['image_tag_6'] ) ? $instance['image_tag_6'] : '';

		echo  $args['before_widget'];
		
		if ( !empty($instance['title']) ){
			echo  $args['before_title'] . $instance['title'] . $args['after_title'];
		}
		echo '<ul class="list-unstyled list-inline">';
			if( !empty( $image_tag_1 ) ){
				echo '<li><a href="'.esc_url( $link_1 ).'"><img src="'.esc_url( get_template_directory_uri() . '/images/small-'.esc_attr__( $image_tag_1 ).'.png' ).'" width="32" height="22" alt="'.esc_attr__( $image_tag_1 ).'"></a></li>';
			} 
			if( !empty( $image_tag_2 ) ){
				echo '<li><a href="'.esc_url( $link_2 ).'"><img src="'.esc_url( get_template_directory_uri() . '/images/small-'.esc_attr__( $image_tag_2 ).'.png' ).'" width="32" height="22" alt="'.esc_attr__( $image_tag_2 ).'"></a></li>';
			} 
			if( !empty( $image_tag_3 ) ){
				echo '<li><a href="'.esc_url( $link_3 ).'"><img src="'.esc_url( get_template_directory_uri() . '/images/small-'.esc_attr__( $image_tag_3 ).'.png' ).'" width="32" height="22" alt="'.esc_attr__( $image_tag_3 ).'"></a></li>';
			} 
			if( !empty( $image_tag_4 ) ){
				echo '<li><a href="'.esc_url( $link_4 ).'"><img src="'.esc_url( get_template_directory_uri() . '/images/small-'.esc_attr__( $image_tag_4 ).'.png' ).'" width="32" height="22" alt="'.esc_attr__( $image_tag_4 ).'"></a></li>';
			} 
			if( !empty( $image_tag_5 ) ){
				echo '<li><a href="'.esc_url( $link_5 ).'"><img src="'.esc_url( get_template_directory_uri() . '/images/small-'.$image_tag_5.'.png' ).'" width="32" height="22" alt="'.esc_attr__( $image_tag_5 ).'"></a></li>';
			} 
			if( !empty( $image_tag_6 ) ){
				echo '<li><a href="'.esc_url( $link_6 ).'"><img src="'.esc_url( get_template_directory_uri() . '/images/small-'.$image_tag_6.'.png' ).'" width="32" height="22" alt="'.esc_attr__( $image_tag_6 ).'"></a></li>';
			} 			
		echo '</ul>';
		echo  $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( stripslashes($new_instance['title']) );
		$instance['link_1'] = $new_instance['link_1'];
		$instance['image_tag_1'] = $new_instance['image_tag_1'];
		$instance['link_2'] = $new_instance['link_2'];
		$instance['image_tag_2'] = $new_instance['image_tag_2'];
		$instance['link_3'] = $new_instance['link_3'];
		$instance['image_tag_3'] = $new_instance['image_tag_3'];
		$instance['link_4'] = $new_instance['link_4'];
		$instance['image_tag_4'] = $new_instance['image_tag_4'];
		$instance['link_5'] = $new_instance['link_5'];
		$instance['image_tag_5'] = $new_instance['image_tag_5'];
		$instance['link_6'] = $new_instance['link_6'];
		$instance['image_tag_6'] = $new_instance['image_tag_6'];		
		return $instance;
	}

	function form( $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$link_1 = isset( $instance['link_1'] ) ? $instance['link_1'] : '';
		$image_tag_1 = isset( $instance['image_tag_1'] ) ? $instance['image_tag_1'] : '';
		$link_2 = isset( $instance['link_2'] ) ? $instance['link_2'] : '';
		$image_tag_2 = isset( $instance['image_tag_2'] ) ? $instance['image_tag_2'] : '';
		$link_3 = isset( $instance['link_3'] ) ? $instance['link_3'] : '';
		$image_tag_3 = isset( $instance['image_tag_3'] ) ? $instance['image_tag_3'] : '';
		$link_4 = isset( $instance['link_3'] ) ? $instance['link_3'] : '';
		$image_tag_4 = isset( $instance['image_tag_4'] ) ? $instance['image_tag_4'] : '';
		$link_5 = isset( $instance['link_5'] ) ? $instance['link_5'] : '';
		$image_tag_5 = isset( $instance['image_tag_5'] ) ? $instance['image_tag_5'] : '';
		$link_6 = isset( $instance['link_6'] ) ? $instance['link_6'] : '';
		$image_tag_6 = isset( $instance['image_tag_6'] ) ? $instance['image_tag_6'] : '';

		$payment_icons = array(
			'' => esc_html__( 'No Icon', 'classifieds' ),
			'skrill' => esc_html__( 'Skrill', 'classifieds' ),
			'paypal' => esc_html__( 'PayPal', 'classifieds' ),
			'ideal' => esc_html__( 'iDEAL', 'classifieds' ),
			'stripe' => esc_html__( 'Stripe', 'classifieds' ),
			'bank' => esc_html__( 'Bank Transfer', 'classifieds' ),
			'payu' => esc_html__( 'PayU Money', 'classifieds' ),
		);

		?>
		<p>
			<label for="<?php echo esc_attr__( $this->get_field_id('title') ); ?>"><?php esc_html_e('Title:', 'classifieds') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr__( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr__( $this->get_field_name('title') ); ?>" value="<?php echo esc_attr__( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr__( $this->get_field_id('link_1') ); ?>"><?php esc_html_e('Link 1:', 'classifieds') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr__( $this->get_field_id('link_1') ); ?>" name="<?php echo esc_attr__( $this->get_field_name('link_1') ); ?>" value="<?php echo esc_attr__( $link_1 ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr__( $this->get_field_id('image_tag_1') ); ?>"><?php esc_html_e('Image tag 1:', 'classifieds') ?></label>
			<select class="widefat" id="<?php echo esc_attr__( $this->get_field_id('image_tag_1') ); ?>" name="<?php echo esc_attr__( $this->get_field_name('image_tag_1') ); ?>">
				<?php
				foreach( $payment_icons as $icon => $label ){
					echo '<option value="'.$icon.'" '.( $icon == $image_tag_1 ? 'selected="selected"' : '' ).'>'.$label.'</option>';
				}
				?> 
			</select>			
		</p>
		<p>
			<label for="<?php echo esc_attr__( $this->get_field_id('link_2') ); ?>"><?php esc_html_e('Link 2:', 'classifieds') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr__( $this->get_field_id('link_2') ); ?>" name="<?php echo esc_attr__( $this->get_field_name('link_2') ); ?>" value="<?php echo esc_attr__( $link_2 ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr__( $this->get_field_id('image_tag_2') ); ?>"><?php esc_html_e('Image tag 2:', 'classifieds') ?></label>
			<select class="widefat" id="<?php echo esc_attr__( $this->get_field_id('image_tag_1') ); ?>" name="<?php echo esc_attr__( $this->get_field_name('image_tag_2') ); ?>">
				<?php
				foreach( $payment_icons as $icon => $label ){
					echo '<option value="'.$icon.'" '.( $icon == $image_tag_2 ? 'selected="selected"' : '' ).'>'.$label.'</option>';
				}
				?> 
			</select>	
		</p>
		<p>
			<label for="<?php echo esc_attr__( $this->get_field_id('link_3') ); ?>"><?php esc_html_e('Link 3:', 'classifieds') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr__( $this->get_field_id('link_3') ); ?>" name="<?php echo esc_attr__( $this->get_field_name('link_3') ); ?>" value="<?php echo esc_attr__( $link_3 ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr__( $this->get_field_id('image_tag_3') ); ?>"><?php esc_html_e('Image tag 3:', 'classifieds') ?></label>
			<select class="widefat" id="<?php echo esc_attr__( $this->get_field_id('image_tag_3') ); ?>" name="<?php echo esc_attr__( $this->get_field_name('image_tag_3') ); ?>">
				<?php
				foreach( $payment_icons as $icon => $label ){
					echo '<option value="'.$icon.'" '.( $icon == $image_tag_3 ? 'selected="selected"' : '' ).'>'.$label.'</option>';
				}
				?> 
			</select>	
		</p>
		<p>
			<label for="<?php echo esc_attr__( $this->get_field_id('link_4') ); ?>"><?php esc_html_e('Link 4:', 'classifieds') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr__( $this->get_field_id('link_4') ); ?>" name="<?php echo esc_attr__( $this->get_field_name('link_4') ); ?>" value="<?php echo esc_attr__( $link_4 ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr__( $this->get_field_id('image_tag_4') ); ?>"><?php esc_html_e('Image tag 4:', 'classifieds') ?></label>
			<select class="widefat" id="<?php echo esc_attr__( $this->get_field_id('image_tag_4') ); ?>" name="<?php echo esc_attr__( $this->get_field_name('image_tag_4') ); ?>">
				<?php
				foreach( $payment_icons as $icon => $label ){
					echo '<option value="'.$icon.'" '.( $icon == $image_tag_4 ? 'selected="selected"' : '' ).'>'.$label.'</option>';
				}
				?> 
			</select>	
		</p>
		<p>
			<label for="<?php echo esc_attr__( $this->get_field_id('link_5') ); ?>"><?php esc_html_e('Link 5:', 'classifieds') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr__( $this->get_field_id('link_5') ); ?>" name="<?php echo esc_attr__( $this->get_field_name('link_5') ); ?>" value="<?php echo esc_attr__( $link_5 ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr__( $this->get_field_id('image_tag_5') ); ?>"><?php esc_html_e('Image tag 5:', 'classifieds') ?></label>
			<select class="widefat" id="<?php echo esc_attr__( $this->get_field_id('image_tag_5') ); ?>" name="<?php echo esc_attr__( $this->get_field_name('image_tag_5') ); ?>">
				<?php
				foreach( $payment_icons as $icon => $label ){
					echo '<option value="'.$icon.'" '.( $icon == $image_tag_5 ? 'selected="selected"' : '' ).'>'.$label.'</option>';
				}
				?> 
			</select>	
		</p>
		<p>
			<label for="<?php echo esc_attr__( $this->get_field_id('link_6') ); ?>"><?php esc_html_e('Link 6:', 'classifieds') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr__( $this->get_field_id('link_6') ); ?>" name="<?php echo esc_attr__( $this->get_field_name('link_6') ); ?>" value="<?php echo esc_attr__( $link_6 ); ?>" />
		</p>		
		<p>
			<label for="<?php echo esc_attr__( $this->get_field_id('image_tag_6') ); ?>"><?php esc_html_e('Image tag 6:', 'classifieds') ?></label>
			<select class="widefat" id="<?php echo esc_attr__( $this->get_field_id('image_tag_6') ); ?>" name="<?php echo esc_attr__( $this->get_field_name('image_tag_6') ); ?>">
				<?php
				foreach( $payment_icons as $icon => $label ){
					echo '<option value="'.$icon.'" '.( $icon == $image_tag_6 ? 'selected="selected"' : '' ).'>'.$label.'</option>';
				}
				?> 
			</select>	
		</p>		
		<?php
	}
}

class Classifieds_Categories extends WP_Widget{
	function __construct() {
		parent::__construct('classifieds_categories', esc_html__('Classifieds Categories','classifieds'), array('description' =>esc_html__('Display categories.','classifieds') ));
	}

	public function widget( $args, $instance ) {
		extract($args);
		global $classifieds_slugs;
		$permalink = classifieds_get_permalink_by_tpl( 'page-tpl_search_page' );
		$title = apply_filters('widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base);
		$categories = !empty( $instance['categories'] ) ? $instance['categories'] : array();
		
		echo  $before_widget;
				if( !empty( $title ) ){
					echo  $before_title.$title.$after_title;
				}
				echo '
				<ul class="list-unstyled">';
				if( !empty( $categories ) )		{
					foreach( $categories as $category ){
						$term = get_term_by( 'slug', $category, 'ad-category' );
						$count = classifieds_category_count( $category );
						echo '<li><a href="'.esc_url( add_query_arg( array( $classifieds_slugs['category'] => $category ), $permalink ) ).'">'.$term->name.'<span class="count">('.$count.')</span></a></li>';
					}				}
		echo	'</ul>'.$after_widget;
	}
 	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'categories' => array() ) );
		
		$title = esc_attr__( $instance['title'] );
		$categories = $instance['categories'];
		
		echo '<p><label for="'.esc_attr__($this->get_field_id('title')).'">'.esc_html__('Title:','classifieds').'</label>';
		echo '<input class="widefat" id="'.esc_attr__($this->get_field_id('title')).'"  name="'.esc_attr__($this->get_field_name('title')).'" type="text" value="'.esc_attr__( $title ).'" /></p>';	

		echo '<p><label for="'.esc_attr__($this->get_field_id('categories')).'">'.esc_html__('Categories:','classifieds').'</label>';
		$categories_list = get_terms( 'ad-category', array( 'hide_empty' => false ) );

		echo '<div class="category-wrap-checkboxes">';
		if( !empty( $categories_list ) && !is_wp_error( $categories_list ) ){
			$terms_organized = array();
			classifieds_sort_terms_hierarchicaly($categories_list, $terms_organized);
			$this->show_checkboxes( $terms_organized, $categories );
		}
		echo '</div>';
	}

	public function show_checkboxes( $cats, $categories ){
		foreach( $cats as $item ){
			?>
			<div class="category-group">
				<div class="category-checkbox">
					<input type="checkbox" id="<?php echo esc_attr__($this->get_field_id('categories')).'-'.esc_attr__( $item->slug ); ?>" name="<?php echo esc_attr__($this->get_field_name('categories')); ?>[]" value="<?php echo esc_attr__( $item->slug ); ?>" <?php echo in_array( $item->slug, (array)$categories ) ? 'checked="checked"' : ''; ?> />
					<label for="<?php echo esc_attr__($this->get_field_id('categories')).'-'.esc_attr__( $item->slug ); ?>">
						<?php echo esc_html( $item->name ); ?>
					</label>
				</div>
				<?php
				if( !empty( $item->children ) ){
					$this->show_checkboxes( $item->children, $categories );
				 }
				?>
			</div>
			<?php
		}
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['categories'] = $new_instance['categories'];
		return $instance;	
	}
}

/********************************************************
Add Classifieds Widgets
********************************************************/
function classifieds_widgets_load(){
	register_widget( 'Classifieds_Follow_Us' );
	register_widget( 'Classifieds_Logo_Text' );
	register_widget( 'Classifieds_Text' );
	register_widget( 'Classifieds_Google_Adsense' );
	register_widget( 'Classifieds_Payments' );
	register_widget( 'Classifieds_Categories' );
}
add_action( 'widgets_init', 'classifieds_widgets_load' );
?>