<?php

	/**********************************************************************
	***********************************************************************
	COUPON FUNCTIONS
	**********************************************************************/
load_theme_textdomain('classifieds', get_template_directory() . '/languages');


add_action( 'tgmpa_register', 'classifieds_requred_plugins' );
function classifieds_requred_plugins(){
	$plugins = array(
		array(
				'name'                 => esc_html__( 'Redux Options', 'classifieds' ),
				'slug'                 => 'redux-framework',
				'source'               => get_template_directory() . '/lib/plugins/redux-framework.zip',
				'required'             => true,
				'version'              => '',
				'force_activation'     => false,
				'force_deactivation'   => false,
				'external_url'         => '',
		),
		array(
				'name'                 => esc_html__( 'Smeta', 'classifieds' ),
				'slug'                 => 'smeta',
				'source'               => get_template_directory() . '/lib/plugins/smeta.zip',
				'required'             => true,
				'version'              => '',
				'force_activation'     => false,
				'force_deactivation'   => false,
				'external_url'         => '',
		),
		array(
				'name'                 => esc_html__( 'Social Connect', 'classifieds' ),
				'slug'                 => 'social-connect',
				'source'               => get_template_directory() . '/lib/plugins/social-connect.zip',
				'required'             => true,
				'version'              => '',
				'force_activation'     => false,
				'force_deactivation'   => false,
				'external_url'         => '',
		),
		array(
				'name'                 => esc_html__( 'User Avatars', 'classifieds' ),
				'slug'                 => 'wp-user-avatar',
				'source'               => get_template_directory() . '/lib/plugins/wp-user-avatar.zip',
				'required'             => true,
				'version'              => '',
				'force_activation'     => false,
				'force_deactivation'   => false,
				'external_url'         => '',
		),
		array(
				'name'                 => esc_html__( 'Classifieds CPT', 'classifieds' ),
				'slug'                 => 'classifieds-cpt',
				'source'               => get_template_directory() . '/lib/plugins/classifieds-cpt.zip',
				'required'             => true,
				'version'              => '',
				'force_activation'     => false,
				'force_deactivation'   => false,
				'external_url'         => '',
		),
		array(
				'name'                 => esc_html__( 'Envato Market', 'classifieds' ),
				'slug'                 => 'envato-market',
				'source'			   => 'https://envato.github.io/wp-envato-market/dist/envato-market.zip',
				'required'             => false,
				'version'              => '',
				'force_activation'     => false,
				'force_deactivation'   => false,
				'external_url'         => 'https://envato.github.io/wp-envato-market/dist/envato-market.zip',
		),
		array(
				'name'                 => esc_html__( 'Woo Commerce', 'classifieds' ),
				'slug'                 => 'woocommerce',
				'required'             => false,
				'version'              => '',
				'force_activation'     => false,
				'force_deactivation'   => false,
		),
	);

	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
			'domain'           => 'classifieds',
			'default_path'     => '',
			'parent_menu_slug' => 'themes.php',
			'parent_url_slug'  => 'themes.php',
			'menu'             => 'install-required-plugins',
			'has_notices'      => true,
			'is_automatic'     => false,
			'message'          => '',
	);

	tgmpa( $plugins, $config );
}

/*
Check version of the theme and update if neccessary
*/
function classifieds_check_version(){
	$current_version = 12;
	$version = get_option( 'classifieds_version' );
	
	$update_info = true;
	
	if( empty( $version ) ){
		$version = 0;
	}
	if( $version < 12 ){
		/*move meta from postmeta to new table*/
		global $wpdb;

		$table_name = $wpdb->prefix.'custom_fields_meta';
		if( $wpdb->get_var("SHOW TABLES LIKE '{$table_name}'") != $table_name ) {
			if( is_admin() ){
			$update_info = false;
			$message = '<div class="error notice notice-success is-dismissible">
							<p>'.esc_html__( 'You need to reinstall Classifieds Custom Post Types plugin', 'classifieds' ).'</p>
							<button type="button" class="notice-dismiss"><span class="screen-reader-text">'.esc_html__( 'Dismiss this notice.', 'classifieds' ).'</span></button>
						</div>';
			set_transient( 'classifieds_update_notices', $message );
    		}
		}
		else{
			$postmeta_results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}custom_fields as cf LEFT JOIN {$wpdb->postmeta} AS postmeta ON cf.name = postmeta.meta_key WHERE postmeta.meta_key IS NOT NULL" );
			if( !empty( $postmeta_results ) ){
				foreach( $postmeta_results as $postmeta_result ){
					$row = classifieds_add_post_meta( $postmeta_result->post_id, $postmeta_result->meta_key, $postmeta_result->meta_value );
					$wpdb->query( $wpdb->prepare( "DELETE FROM {$wpdb->postmeta} WHERE meta_id = %d", $postmeta_result->meta_id ) );
				}
			}
		}
	}

	if( $update_info ){
		update_option( 'classifieds_version', $current_version );
	}
}
add_action( 'init', 'classifieds_check_version' );


if( !function_exists("classifieds_update_notices") ){
function classifieds_update_notices(){
	echo get_transient( 'classifieds_update_notices' );
	delete_transient( 'classifieds_update_notices' );
}
add_action( 'admin_notices', 'classifieds_update_notices' );
}

function classifieds_check_update_plugins() {
	if( function_exists('sm_init') ):
		$smeta_data = get_plugins( '/smeta' );
	    if( $smeta_data['smeta.php']['Version'] != '1.1' ):
		    ?>
		    <div class="notice notice-success is-dismissible error">
		        <p><?php esc_html_e( 'Reinstall Smeta plugin ( Delete it and theme will offer you to install it again )', 'boston' ); ?></p>
		    </div>
		    <?php
	    endif;
	endif;
}
add_action( 'admin_notices', 'classifieds_check_update_plugins' );

/*
Dashboard stats
*/
add_action( 'wp_dashboard_setup', 'classifieds_dashboard_overview' );
function classifieds_dashboard_overview() {
	add_meta_box('classifieds_stats_overall', esc_html__( 'Classifieds Stats', 'classifieds' ), 'classifieds_stats_overall', 'dashboard', 'side', 'high');
}

function classifieds_stats_overall(){
	global $wpdb;
	$featured = $wpdb->get_results("SELECT COUNT(*) AS count FROM {$wpdb->postmeta} WHERE meta_key = 'ad_featured' AND meta_value = 'yes'" );
	$featured = $featured[0]->count;

	$expired = $wpdb->get_results( $wpdb->prepare( "SELECT COUNT(*) AS count FROM {$wpdb->postmeta} WHERE meta_key = 'ad_expire' AND meta_value < %d", current_time( 'timestamp' ) ) );
	$expired = $expired[0]->count;

	$count_ads = wp_count_posts( 'ad' );
	$pending = $count_ads->draft;
	$approved = $count_ads->publish;
	$basic = $pending + $approved - $featured;

	$basic_ad_price = classifieds_get_option( 'basic_ad_price' );
	$earnings_basic = $basic_ad_price * $basic;

	$featured_ad_price = classifieds_get_option( 'featured_ad_price' );
	$earnings_featured = $featured_ad_price * $featured;

	echo '<ul class="classifieds-stats-list">
		<li>
			<span class="value"><a href="'.esc_url( admin_url( 'edit.php?post_type=ad' ) ).'">'.( $pending + $approved ).'</a></span>
			'.esc_html__( 'Total Ads', 'classifieds' ).'
		</li>
		<li>
			<span class="value">'.classifieds_format_price_number( $earnings_basic + $earnings_featured ).'</span>
			'.esc_html__( 'Total Ads Earnings', 'classifieds' ).'
		</li>
		<li>
			<span class="value"><a href="'.esc_url( admin_url( 'edit.php?post_type=ad&ad_featured=yes' ) ).'">'.$featured.'</a></span>
			'.esc_html__( 'Featured Ads', 'classifieds' ).'
		</li> 
		<li>
			<span class="value">'.classifieds_format_price_number( $earnings_featured ).'</span>
			'.esc_html__( 'Featured Ads Earnings', 'classifieds' ).'
		</li>
		<li>
			<span class="value"><a href="'.esc_url( admin_url( 'edit.php?post_type=ad&ad_featured=no' ) ).'">'.$basic.'</a></span>
			'.esc_html__( 'Not Featured Ads', 'classifieds' ).'
		</li>
		<li>
			<span class="value">'.classifieds_format_price_number( $earnings_basic ).'</span>
			'.esc_html__( 'Not Featured Ads Earnings', 'classifieds' ).'
		</li>
		<li>
			<span class="value"><a href="'.esc_url( admin_url( 'edit.php?post_type=ad&ad_expire=yes' ) ).'">'.$expired.'</a></span>
			'.esc_html__( 'Expired Ads', 'classifieds' ).'
		</li>
		<li>
			<span class="value"><a href="'.esc_url( admin_url( 'edit.php?post_type=ad&post_status=draft' ) ).'">'.$pending.'</a></span>
			'.esc_html__( 'Pending Approval Ads', 'classifieds' ).'
		</li>
	</ul>';
}

/*
Filter ads by custom fields
*/
function classifieds_posts_filter( $query ){
    global $wpdb;
    if ( is_admin() && isset($_GET['post_type']) && $_GET['post_type'] == 'ad') {
    	if( isset( $_GET['ad_featured'] ) ){
    		$query->set('meta_query', array(
    			array( 
    				'key' => 'ad_featured',
    				'value' => $_GET['ad_featured'],
    				'compare' => '='
    			)
    		));
    	}
    	else if( isset( $_GET['ad_expire'] ) ){
    		$query->set('meta_query', array(
    			array( 
    				'key' => 'ad_expire',
    				'value' => current_time('timestamp'),
    				'compare' => '<='
    			)
    		));
    	}
    }
    return $query;
}
add_action( 'pre_get_posts', 'classifieds_posts_filter' );

/*
Add filter to list of ads in the backend
*/
function classifieds_additional_filters_ad($views){
    global $post_type_object, $wpdb;
    $post_type = $post_type_object->name;


	$expired = $wpdb->get_results( $wpdb->prepare( "SELECT COUNT(*) AS count FROM {$wpdb->postmeta} WHERE meta_key = 'ad_expire' AND meta_value < %d", current_time( 'timestamp' ) ) );
	$expired = $expired[0]->count;    

    $views['today'] = '<a href="edit.php?post_type='.esc_attr__( $post_type ).'&ad_expire=yes" class="'.( isset( $_GET['ad_expire'] ) ? 'current' : '' ).'">'.esc_html__('Expired','classifieds').'</a> ('.$expired.')';

    return $views;
}
add_filter( 'views_edit-ad', 'classifieds_additional_filters_ad');


if (!isset($content_width)){
	$content_width = 1920;
}

/*
Add meta box on the side of the ad to show its status
 */
function classifieds_ad_status_meta_box() {
	add_meta_box(
		'classifieds_ad_status',
		esc_html__( 'Ad Status', 'classifieds' ),
		'classifieds_ad_status',
		'ad',
		'side',
		'high'
	);
}
add_action( 'add_meta_boxes', 'classifieds_ad_status_meta_box' );

/*
Print status of the add in the meta box
 */
function classifieds_ad_status( $post ) {
	classifieds_get_ad_status( $post->ID );
}


/*
Create custom submenu item under Products
*/
function classifieds_create_menu_items(){
    add_submenu_page('edit.php?post_type=custom_field', esc_html__('Import / Export','classifieds'), esc_html__('Import / Export','classifieds'), 'edit_posts', 'cf-import', 'classifieds_cf_import_export');
}
add_action('admin_menu', 'classifieds_create_menu_items');

/*
Add import / export feature to custom fields
*/
function classifieds_cf_import_export(){
	include( classifieds_load_path( 'includes/cf-import.php' ) );
}

/*
Export CF values
*/
function classifieds_export_cf_values(){
	global $wpdb;
	$export = array();
	$cfs = get_posts(array(
		'post_type' => 'custom_field',
		'posts_per_page' => -1,
	));

	if( !empty( $cfs ) ){
		$rows = array();
		foreach( $cfs as $cf ){
			$rows['post_'.$cf->ID] = array(
				'cf_meta' => array(
					'post_name' => $cf->post_name,
					'post_title' => $cf->post_title,
					'post_status' => $cf->post_status,
					'fields_for' => get_post_meta( $cf->ID, 'fields_for', true )
				),
				'fields' => array()
			);
			$results = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT * FROM {$wpdb->prefix}custom_fields WHERE post_id = %d",
					$cf->ID
				)
			);
			foreach( $results as $res ){
				$rows['post_'.$cf->ID]['fields'][] = $res;
			}
		}

		$custom_fields_meta = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}custom_fields_meta" );

		$export['custom_fields'] = $rows;
		$export['custom_fields_meta'] = $custom_fields_meta;
	}

	echo '<textarea class="cf-import">'.json_encode( $export ).'</textarea>';
}

/*
Import CF values
*/
function classifieds_import_cf_values(){
	global $wpdb;
	$cf_values = isset( $_POST['cf_values'] ) ? $_POST['cf_values'] : '';
	if( !empty( $cf_values ) ){
		$cf_values = json_decode( stripslashes($cf_values), true );
		if( !empty( $cf_values ) ){
			/* first import custom values */
			$custom_fields = $cf_values['custom_fields'];
			if( !empty( $custom_fields ) ){
				foreach( $custom_fields as $row ){
					$post_id = wp_insert_post(array(
						'post_name' => $row['cf_meta']['post_name'],
						'post_title' => $row['cf_meta']['post_title'],
						'post_status' => $row['cf_meta']['post_status'],
						'post_type' => 'custom_field'
					));
					update_post_meta( $post_id, 'fields_for', $row['cf_meta']['fields_for'] );
					if( !empty( $row['fields'] ) ){
						foreach( $row['fields'] as $field_row ){
							$info = $wpdb->query(
								$wpdb->prepare(
									"INSERT INTO {$wpdb->prefix}custom_fields VALUES( '', %d, %s, %s, %s, %s, %s, %d )",
									$post_id,
									$field_row['name'],
									$field_row['label'],
									$field_row['type'],
									$field_row['field_values'],
									$field_row['child_of_value'],
									$field_row['parent']
								)
							);
						}
					}
				}
			}

			/* import meta values */
			$custom_fields_meta = $cf_values['custom_fields_meta'];
			if( !empty( $custom_fields_meta ) ){
				foreach( $custom_fields_meta as $row ){
					$info = $wpdb->query(
						$wpdb->prepare(
							"INSERT INTO {$wpdb->prefix}custom_fields_meta VALUES( '', %d, %s, %s )",
							$row['post_id'],
							$row['name'],
							$row['val']
						)
					);
				}
			}

			if( !empty( $info ) ){
				?>
				<div class="updated notice notice-success is-dismissible">
					<p><?php esc_html_e( 'Import process finished', 'classifieds' ) ?></p>
					<button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php esc_html_e( 'Dismiss this notice.', 'classifieds' ) ?></span></button>
				</div>
				<?php
			}
			else{
				?>
				<div class="error notice notice-success is-dismissible">
					<p><?php esc_html_e( 'Import process failed', 'classifieds' ) ?></p>
					<button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php esc_html_e( 'Dismiss this notice.', 'classifieds' ) ?></span></button>
				</div>
				<?php
			}			
		}
	}
}


/*
Save meta value for the post in the new table
*/
function classifieds_add_post_meta( $post_id, $meta_key, $meta_value ){
	global $wpdb;
	$return = $wpdb->insert(
		$wpdb->prefix.'custom_fields_meta',
		array(
			'post_id' => $post_id,
			'name' => $meta_key,
			'val' => $meta_value
		),
		array(
			'%d',
			'%s',
			'%s'
		)
	);
}

/*
Read meta from custom table
*/
function classifieds_get_post_meta( $post_id, $name ){
	global $wpdb;
	$res = $wpdb->get_results( $wpdb->prepare( "SELECT val FROM {$wpdb->prefix}custom_fields_meta WHERE post_id = %d AND name = %s", $post_id, $name ) );
	if( !empty( $res[0] ) ){
		return $res[0]->val;
	}
	else{
		return '';
	}
}

/* 
Do shortcodes in the excerpt
*/
add_filter('the_excerpt', 'do_shortcode');

/*
Check if field exists in the child theme and if so load it
*/
function classifieds_load_path( $path ){
	if ( file_exists( get_stylesheet_directory() . '/' . $path )) {
	    return get_stylesheet_directory() . '/' . $path;
	} else {
	    return get_template_directory() . '/' . $path;
	}	
}

/*
Check if field exists in the child theme and if so load it
*/
function classifieds_load_uri_path( $path ){
	if ( file_exists( get_stylesheet_directory_uri() . '/' . $path )) {
	    include( get_stylesheet_directory_uri() . '/' . $path );
	} else {
	    require( get_template_directory_url() . '/' . $path );
	}	
}

/*
Register theme sidebars
*/
function classifieds_widgets_init(){
	
	register_sidebar(array(
		'name' => esc_html__('Blog Sidebar', 'classifieds') ,
		'id' => 'sidebar-blog',
		'before_widget' => '<div class="widget white-block %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
		'description' => esc_html__('Appears on the right side of the blog.', 'classifieds')
	));
	
	register_sidebar(array(
		'name' => esc_html__('Page Sidebar Right', 'classifieds') ,
		'id' => 'sidebar-right',
		'before_widget' => '<div class="widget white-block %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
		'description' => esc_html__('Appears on the right side of the page.', 'classifieds')
	));

	register_sidebar(array(
		'name' => esc_html__('Page Sidebar Left', 'classifieds') ,
		'id' => 'sidebar-left',
		'before_widget' => '<div class="widget white-block %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
		'description' => esc_html__('Appears on the left side of the page.', 'classifieds')
	));

	register_sidebar(array(
		'name' => esc_html__('Search Sidebar', 'classifieds') ,
		'id' => 'sidebar-search',
		'before_widget' => '<div class="widget white-block %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
		'description' => esc_html__('Appears on the left side of the search page.', 'classifieds')
	));	

	register_sidebar(array(
		'name' => esc_html__('Single Ad Sidebar', 'classifieds') ,
		'id' => 'sidebar-ad',
		'before_widget' => '<div class="widget white-block %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
		'description' => esc_html__('Appears on the right side of the single ad page bellow the ad data.', 'classifieds')
	));	
	
	register_sidebar(array(
		'name' => esc_html__('Bottom Sidebar 1', 'classifieds') ,
		'id' => 'sidebar-bottom-1',
		'before_widget' => '<div class="widget white-block %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
		'description' => esc_html__('Appears at the bottom of the page.', 'classifieds')
	));
	
	register_sidebar(array(
		'name' => esc_html__('Bottom Sidebar 2', 'classifieds') ,
		'id' => 'sidebar-bottom-2',
		'before_widget' => '<div class="widget white-block %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
		'description' => esc_html__('Appears at the bottom of the page.', 'classifieds')
	));
	
	register_sidebar(array(
		'name' => esc_html__('Bottom Sidebar 3', 'classifieds') ,
		'id' => 'sidebar-bottom-3',
		'before_widget' => '<div class="widget white-block %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
		'description' => esc_html__('Appears at the bottom of the page.', 'classifieds')
	));

	register_sidebar(array(
		'name' => esc_html__('Shop Sidebar', 'classifieds') ,
		'id' => 'shop-sidebar',
		'before_widget' => '<div class="widget white-block %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
		'description' => esc_html__('Used for the widget area on shop page.', 'classifieds')
	));		

	$mega_menu_sidebars = classifieds_get_option( 'mega_menu_sidebars' );
	if( empty( $mega_menu_sidebars ) ){
		$mega_menu_sidebars = 5;
	}

	for( $i=1; $i <= $mega_menu_sidebars; $i++ ){
		register_sidebar(array(
			'name' => esc_html__('Mega Menu Sidebar ', 'classifieds').$i,
			'id' => 'mega-menu-'.$i,
			'before_widget' => '<li class="widget white-block %2$s">',
			'after_widget' => '</li>',
			'before_title' => '<h4>',
			'after_title' => '</h4>',
			'description' => esc_html__('This will be shown as the dropdown menu in the navigation.', 'classifieds')
		));
	}	
}

add_action('widgets_init', 'classifieds_widgets_init');

/*
Update title of the page on search
*/
function classifieds_wp_title( $title, $sep ) {
	global $paged, $page, $classifieds_slugs;

	if ( is_feed() ){
		return $title;
	}
	if( is_page() && get_page_template_slug( get_the_ID() ) == 'page-tpl_my_profile.php' ){
		return $title;
	}

	$keyword = get_query_var( $classifieds_slugs['keyword'] );
	if( !empty( $keyword ) ){
		$title = str_replace( '_', ' ', urldecode( $keyword ) )." $sep ".$title;
	}

	$location = get_query_var( $classifieds_slugs['location'] );
	if( !empty( $location ) ){
		$title = $location." $sep ".$title;
	}

	$ad_category = get_query_var( $classifieds_slugs['category'] );
	if( !empty( $ad_category ) ){
		$term = get_term_by( 'slug', $ad_category, 'ad-category' );
		$title = $term->name." $sep ".$title;
	}

	return $title;
}
add_filter( 'wp_title', 'classifieds_wp_title', 10, 2 );

/*
Set direction of the site
*/
function classifieds_set_direction() {
	global $wp_locale, $wp_styles;

	$_user_id = get_current_user_id();
	$direction = classifieds_get_option( 'direction' );
	if( empty( $direction ) ){
		$direction = 'ltr';
	}

	if ( $direction ) {
		update_user_meta( $_user_id, 'rtladminbar', $direction );
	} else {
		$direction = get_user_meta( $_user_id, 'rtladminbar', true );
		if ( false === $direction )
			$direction = isset( $wp_locale->text_direction ) ? $wp_locale->text_direction : 'ltr' ;
	}

	$wp_locale->text_direction = $direction;
	if ( ! is_a( $wp_styles, 'WP_Styles' ) ) {
		$wp_styles = new WP_Styles();
	}
	$wp_styles->text_direction = $direction;
}
add_action( 'init', 'classifieds_set_direction' );


/*
Get URL based on the tempalte which is being used
*/
function classifieds_get_permalink_by_tpl( $template_name ){
	$page = get_pages(array(
		'meta_key' => '_wp_page_template',
		'meta_value' => $template_name . '.php'
	));
	if(!empty($page)){
		return get_permalink( $page[0]->ID );
	}
	else{
		return "javascript:;";
	}
}

/*
generate random hash fgor the register
*/
function classifieds_confirm_hash( $length = 100 ) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $random_string = '';
    for ($i = 0; $i < $length; $i++) {
        $random_string .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $random_string;
}

/*
Get list of registered image sizes
*/
function classifieds_get_image_sizes(){
	$list = array();
	$sizes = get_intermediate_image_sizes();
	foreach( $sizes as $size ){
		$list[$size] = $size;
	}

	return $list;
}

/*
Get status of the ad
*/

function classifieds_get_ad_status( $post_id ){
	$ad_expire = get_post_meta( $post_id, 'ad_expire', true );
	$is_expired = false;
	if( current_time( 'timestamp' ) > $ad_expire ){
		$is_expired = true;
	}

	if( get_post_status( $post_id ) == 'draft' ){
		esc_html_e( 'PENDING', 'classifieds' );
	}
	else if( $is_expired ){
		esc_html_e( 'EXPIRED', 'classifieds' );
	}
	else{
		echo esc_html__( 'LIVE UNTIL: ', 'classifieds' ).date( 'M j, Y - H:i', $ad_expire );
	}
}

/*
Add custom columns on the ads listing
*/
function classifieds_custom_offer_columns($columns) {
	$columns = 
		array_slice($columns, 0, count($columns) - 1, true) + 
		array(
			"ad_category" => esc_html__( 'Category', 'classifieds' ),
			"ad_price" => esc_html__( 'Price', 'classifieds' ),
			"ad_views" => esc_html__( 'Views', 'classifieds' ),
			"ad_expire" => esc_html__( 'Status', 'classifieds' ),
		) + 
		array_slice($columns, count($columns) - 1, count($columns) - 1, true) ;	
	return $columns;
}
add_filter( 'manage_edit-ad_columns', 'classifieds_custom_offer_columns' );

/* Populate additional column */
function classifieds_custom_offer_columns_populate( $column, $post_id ) {
	if( $column == 'ad_category' ){
		$list = array();
		$terms = get_the_terms( $post_id, 'ad-category' );
		if( !empty( $terms ) ){
			foreach( $terms as $term ){
				$list[] = $term->name;
			}
		}

		echo join( $list, ', ' );
	}
	else if( $column == 'ad_price' ){
		echo classifieds_get_price( $post_id );
	}
	else if( $column == 'ad_views' ){
		echo get_post_meta( $post_id, 'ad_views', true );
	}
	else if( $column == 'ad_expire' ){
		classifieds_get_ad_status( $post_id );
	}
}
add_action( 'manage_ad_posts_custom_column', 'classifieds_custom_offer_columns_populate', 10, 2 );

/*
Add custom column on the users listing page in the backend
*/
function classifieds_active_column($columns) {
    $columns['active'] = esc_html__( 'Activation Status', 'classifieds' );
    $columns['basic_ads'] = esc_html__( 'Basic Ads', 'classifieds' );
    $columns['featured_ads'] = esc_html__( 'Featured Ads', 'classifieds' );
    return $columns;
}
add_filter('manage_users_columns', 'classifieds_active_column');
 
/* Populate additional column */
function classifieds_active_column_content( $value, $column_name, $user_id ){
	if ( 'active' == $column_name ){
		$usermeta = get_user_meta( $user_id, 'user_active_status', true );
		if( empty( $usermeta ) ||  $usermeta == "active" ){
			return esc_html__( 'Activated', 'classifieds' );
		}
		else{
			return esc_html__( 'Need Confirmation', 'classifieds' );
		}
	}
	else if ( 'basic_ads' == $column_name ){
		$posts = get_posts(array(
			'post_type' => 'ad',
			'posts_per_page' => '-1',
			'author' => $user_id,
			'post_status' => 'publish',
			'meta_query' => array(
				array(
					'key' => 'ad_featured',
					'value' => 'no',
				),
			)
		));
		$basic_ad_price = classifieds_get_option( 'basic_ad_price' );

		$dispaly = sizeof( $posts );
		if( !empty( $basic_ad_price ) ){
			$basic_ad_price = $basic_ad_price * sizeof( $posts );
			$dispaly .= ' - '.classifieds_format_price_number( $basic_ad_price );
		}
		return $dispaly;
	}
	else if ( 'featured_ads' == $column_name ){
		$posts = get_posts(array(
			'post_type' => 'ad',
			'posts_per_page' => '-1',
			'author' => $user_id,
			'post_status' => 'publish',
			'meta_query' => array(
				array(
					'key' => 'ad_featured',
					'value' => 'yes',
				),	        
			)
		));
		$featured_ad_price = classifieds_get_option( 'featured_ad_price' );

		$dispaly = sizeof( $posts );
		if( !empty( $featured_ad_price ) ){
			$featured_ad_price = $featured_ad_price * sizeof( $posts );
			$dispaly .=  ' - '.classifieds_format_price_number( $featured_ad_price );
		}

		return $dispaly;
	}		
    return $value;
}
add_action('manage_users_custom_column',  'classifieds_active_column_content', 10, 3);

/*
Add additional fields on the edit user screen in the backend
*/
function classifieds_edit_user_status( $user ){
	$user_active_status = get_user_meta( $user->ID, 'user_active_status', true );
	$city = get_user_meta( $user->ID, 'city', true );
	$phone_number = get_user_meta( $user->ID, 'phone_number', true );
	$cover_image = get_user_meta( $user->ID, 'cover_image', true );
	$is_verified = classifieds_is_verified( $user->ID );
	$avatar = get_user_meta( $user->ID, 'avatar', true );
	$twitter = get_user_meta( $user->ID, 'twitter', true );
	$linkedin = get_user_meta( $user->ID, 'linkedin', true );
	$instagram = get_user_meta( $user->ID, 'instagram', true );
	$facebook = get_user_meta( $user->ID, 'facebook', true );
	$google = get_user_meta( $user->ID, 'google', true );
    ?>
        <h3><?php esc_html_e( 'User Info', 'classifieds' ) ?></h3>

        <table class="form-table">
            <tr>
                <th><label for="user_active_status"><?php esc_html_e( 'User Status', 'classifieds' ); ?></label></th>
                <td>
                	<select name="user_active_status" id="user_active_status">
                		<option <?php echo !empty( $user_active_status ) && $user_active_status != 'active' ? 'selected="selected"' : '' ?> value="inactive"><?php esc_html_e( 'Inactive', 'classifieds' ) ?></option>
                		<option <?php echo empty( $user_active_status ) || $user_active_status == 'active' ? 'selected="selected"' : '' ?> value="active"><?php esc_html_e( 'Active', 'classifieds' ) ?></option>
                	</select>
                </td>
            </tr>
            <tr>
                <th><label for="is_verified"><?php esc_html_e( 'User Is Verified Poster?', 'classifieds' ); ?></label></th>
                <td>
                	<select name="is_verified" id="is_verified">
                		<option <?php echo !$is_verified  ? esc_attr__( 'selected="selected"' ) : '' ?> value="no"><?php esc_html_e( 'No', 'classifieds' ) ?></option>
                		<option <?php echo $is_verified ? esc_attr__( 'selected="selected"' ) : '' ?> value="yes"><?php esc_html_e( 'Yes', 'classifieds' ) ?></option>
                	</select>
                </td>
            </tr>            
            <tr>
                <th><label for="city"><?php esc_html_e( 'City', 'classifieds' ); ?></label></th>
                <td>
                	<input type="text" name="city" id="city" value="<?php echo esc_attr__( $city ) ?>">
                </td>
            </tr>
            <tr>
                <th><label for="phone_number"><?php esc_html_e( 'Phone Number', 'classifieds' ); ?></label></th>
                <td>
                	<input type="text" name="phone_number" id="phone_number" value="<?php echo esc_attr__( $phone_number ) ?>"/>
                </td>
            </tr>
            <tr>
                <th><label><?php esc_html_e( 'Cover Image', 'classifieds' ); ?></label></th>
                <td>
                    <div class="image-wrap">
                        <?php if( !empty( $cover_image ) ){
                            echo wp_get_attachment_image( $cover_image, 'thumbnail' );
                            echo '<a href="javascript:;" class="button remove-image">X</a>';
                        }?>
                    </div>
                    <a href="javascript:;" class="button set-image"><?php esc_html_e( 'Change Cover', 'classifieds' ) ?></a>
                    <input type="hidden" name="cover_image" id="cover_image" value="<?php echo esc_attr__( $cover_image ) ?>" class="form-control">
                </td>
            </tr>
            <tr>
                <th><label for="twitter"><?php esc_html_e( 'Twitter', 'classifieds' ); ?></label></th>
                <td>
                	<input type="text" name="twitter" id="twitter" value="<?php echo esc_attr__( $twitter ) ?>">
                </td>
            </tr>
            <tr>
                <th><label for="linkedin"><?php esc_html_e( 'Linkedin', 'classifieds' ); ?></label></th>
                <td>
                	<input type="text" name="linkedin" id="linkedin" value="<?php echo esc_attr__( $linkedin ) ?>">
                </td>
            </tr>
            <tr>
                <th><label for="instagram"><?php esc_html_e( 'Instagram', 'classifieds' ); ?></label></th>
                <td>
                	<input type="text" name="instagram" id="instagram" value="<?php echo esc_attr__( $instagram ) ?>">
                </td>
            </tr>
            <tr>
                <th><label for="facebook"><?php esc_html_e( 'Facebook', 'classifieds' ); ?></label></th>
                <td>
                	<input type="text" name="facebook" id="facebook" value="<?php echo esc_attr__( $facebook ) ?>">
                </td>
            </tr>
            <tr>
                <th><label for="google"><?php esc_html_e( 'Google+', 'classifieds' ); ?></label></th>
                <td>
                	<input type="text" name="google" id="google" value="<?php echo esc_attr__( $google ) ?>">
                </td>
            </tr>
        </table>       
    <?php
}
add_action( 'show_user_profile', 'classifieds_edit_user_status' );
add_action( 'edit_user_profile', 'classifieds_edit_user_status' );

/*
Save custom values i the user edit screen on the backend
*/
function classifieds_save_user_meta( $user_id ){
	update_user_meta( $user_id,'user_active_status', sanitize_text_field($_POST['user_active_status']) );
	update_user_meta( $user_id,'city', sanitize_text_field($_POST['city']) );
	update_user_meta( $user_id,'phone_number', sanitize_text_field($_POST['phone_number']) );
	update_user_meta( $user_id,'is_verified', sanitize_text_field($_POST['is_verified']) );
	update_user_meta( $user_id,'cover_image', sanitize_text_field($_POST['cover_image']) );
	update_user_meta( $user_id,'avatar', sanitize_text_field($_POST['avatar']) );
	update_user_meta( $user_id,'twitter', sanitize_text_field($_POST['twitter']) );
	update_user_meta( $user_id,'linkedin', sanitize_text_field($_POST['linkedin']) );
	update_user_meta( $user_id,'instagram', sanitize_text_field($_POST['instagram']) );
	update_user_meta( $user_id,'facebook', sanitize_text_field($_POST['facebook']) );
	update_user_meta( $user_id,'google', sanitize_text_field($_POST['google']) );
}
add_action( 'personal_options_update', 'classifieds_save_user_meta' );
add_action( 'edit_user_profile_update', 'classifieds_save_user_meta' );


/*
Disable admin bar for all users except the admin
*/
function classifieds_remove_admin_bar() {
	$user_ID = get_current_user_id();
	$user_agent = get_user_meta( $user_ID, 'user_agent', true );	
	if (!current_user_can('administrator') && !is_admin() && ( !$user_agent || $user_agent == 'no' ) ) {
		show_admin_bar(false);
	}
}
add_action('after_setup_theme', 'classifieds_remove_admin_bar');


/*
Default values of the theme optins
*/
function classifieds_defaults( $id ){	
	$defaults = array(
		'site_logo' => array( 'url' => '' ),
		'site_logo_padding' => '',
		'site_navigation_padding'=> '',
		'enable_sticky' => 'no',
		'my_profile_looks' => esc_html__( 'My Profile', 'classifieds' ),
		'login_looks' => esc_html__( 'Login', 'classifieds' ),
		'direction' => 'ltr',
		'trans_ad' => 'ad',
		'trans_ad_category' => 'ad-category',
		'trans_ad_tag' => 'ad-tag',
		'trans_category' => 'category',
		'trans_tag' => 'tag',
		'trans_keyword' => 'keyword',
		'trans_location' => 'location',
		'trans_longitude' => 'longitude',
		'trans_latitude' => 'latitude',
		'trans_radius' => 'radius',
		'trans_view' => 'view',
		'trans_sortby' => 'sortby',
		'trans_subpage' => 'subpage',
		'show_search_bar' => 'no',
		'radius_search_units' => 'km',
		'radius_default' => '300',
		'radius_options' => '',
		'empty_search_location' => '',
		'mega_menu_sidebars' => '5',
		'mega_menu_min_height' => '',
		'show_clients' => 'no',
		'footer_copyrights' => '',
		'show_subscribe' => 'no',
		'footer_subscribe_text' => '',
		'footer_subscribe_subtext' => '',
		'show_woocommerce_sidebar' => 'yes',
		'products_per_page' => '9',
		'contact_mail' => 'contact_form_subject',
		'contact_map' => '',
		'contact_map_scroll_zoom' => 'no',
		'contact_map_zoom' => '',
		'all_categories_sortby' => 'name',
		'all_categories_sort' => 'asc',
		'show_map_on_home' => 'no',
		'home_map_cache' => 'yes',
		'home_map_ads' => '',
		'home_map_ads_source' => 'all',
		'home_map_zoom' => '',
		'home_slider' => '',
		'ads_per_page' => '12',
		'author_ads_per_page' => '12',
		'author_profile_ads_per_page' => '12',
		'ads_for_verified' => '10',
		'similar_ads' => '2',
		'ads_default_view' => 'grid',
		'video_image' => '',
		'ads_search_layout' => 'style-top',
		'ads_advanced_search' => 'yes',
		'ads_max_videos' => '10',
		'ads_max_images' => '10',
		'image_placeholder' => '',
		'ad_terms' => '',
		'basic_ad_price' => '0',
		'basic_ad_title' => '',
		'basic_ad_subtitle' => '',
		'featured_ad_price' => '5',
		'featured_ad_title' => '',
		'featured_ad_subtitle' => '',
		'ad_lasts_for' => '30',
		'email_sender' => '',
		'name_sender' => '',
		'new_offer_email' => '',
		'ad_messaging' => '',
		'ad_approve_message' => '',
		'ad_decline_message' => '',
		'registration_message' => '',
		'registration_subject' => '',
		'lost_password_message' => '',
		'lost_password_subject' => '',
		'send_expire_notice' => '',
		'expire_template' => '',
		'ad_expire_subject' => '',
		'unit' => '',
		'main_unit_abbr' => '',
		'unit_position' => '',
		'paypal_mode' => '',
		'paypal_username' => '',
		'paypal_password' => '',
		'paypal_signature' => '',
		'stripe_pk_client_id' => '',
		'stripe_sk_client_id' => '',
		'skrill_owner_mail' => '',
		'skrill_secret_word' => '',
		'bank_account_name' => '',
		'bank_name' => '',
		'bank_account_number' => '',
		'bank_sort_number' => '',
		'bank_iban_number' => '',
		'bank_bic_swift_number' => '',
		'mollie_id' => '',
		'ideal_mode' => 'live',
		'payu_merchant_key' => '',
		'payu_merchant_salt' => '',
		'payu_mode' => '',
		'mail_chimp_api' => '',
		'mail_chimp_list_id' => '',
		'body_links_color' => '#208ee6',
		'theme_font' => 'Montserrat',
		'header_bg_color' => '#1e3843',
		'navigation_font_color' => '#fff',
		'navigation_font_color_hvr' => '#7dcffb',
		'submit_btn_bg_color' => '#208ee6',
		'submit_btn_font_color' => '#fff',
		'submit_btn_bg_color_hvr' => '#177ed0',
		'submit_btn_font_color_hvr' => '#fff',
		'footer_bg_color' => '#273642',
		'footer_font_color' => '#fff',
		'footer_link_color' => '#fff',
		'footer_link_color_hvr' => '#59b453',
		'copyright_bg_color' => '#1d2a34',
		'copyright_font_color' => '#49535b',
		'copyright_link_color' => '#fff',
		'copyright_link_color_hvr' => '#59b453',
		'btn1_bg_color' => '#59b453',
		'btn1_font_color' => '#fff',
		'btn1_bg_color_hvr' => '#4ca247',
		'btn1_font_color_hvr' => '#fff',
		'btn2_bg_color' => '#208ee6',
		'btn2_font_color' => '#fff',
		'btn2_bg_color_hvr' => '#177ed0',
		'btn2_font_color_hvr' => '#fff',
		'expired_badge_bg_color' => '#ebb243',
		'expired_badge_font_color' => '#fff',
		'pending_badge_bg_color' => '#49a3eb',
		'pending_badge_font_color' => '#fff',
		'live_badge_bg_color' => '#78c273',
		'live_badge_font_color' => '#fff',
		'not_paid_badge_bg_color' => '#f66a45',
		'not_paid_badge_font_color' => '#fff',
		'off_badge_bg_color' => '#bbc4cb',
		'off_badge_font_color' => '#fff',
		'ad_form_btn_bg_color' => '#7dcffb',
		'ad_form_btn_font_color' => '#fff',
		'ad_form_btn_bg_color_hvr' => '#5fc4fa',
		'ad_form_btn_font_color_hvr' => '#fff',
		'single_ad_price_size' => '26px',
		'home_map_geolocation' => 'no',
		'all_categories_count' => 'no'
	);
	
	if( isset( $defaults[$id] ) ){
		return $defaults[$id];
	}
	else{
		
		return '';
	}
}

/*
Get theme option based on the ID
*/
function classifieds_get_option($id){
	global $classifieds_options;
	if( isset( $classifieds_options[$id] ) ){
		$value = $classifieds_options[$id];
		if( isset( $value ) ){
			return apply_filters( 'classifieds_get_options', $value, $id );
		}
		else{
			return apply_filters( 'classifieds_get_options', '', $id );
		}
	}
	else{
		return apply_filters( 'classifieds_get_options', classifieds_defaults( $id ), $id );
	}	
}

/*
Basic settigns of the theme
*/
function classifieds_setup(){
	add_theme_support('automatic-feed-links');
	add_theme_support( 'woocommerce' );
	add_theme_support( "title-tag" );
	add_theme_support('html5', array(
		'comment-form',
		'comment-list'
	));
	register_nav_menu('top-navigation', esc_html__('Top Navigation', 'classifieds'));
	
	add_theme_support('post-thumbnails');
	
	set_post_thumbnail_size(848, 477, true);
	if (function_exists('add_image_size')){
		add_image_size( 'classifieds-ad-box', 263, 172, true );
		add_image_size( 'classifieds-ad-box-alt', 110, 110, true );
		add_image_size( 'classifieds-map', 80, 80, true );
		add_image_size( 'classifieds-avatar', 90, 90, true );
		add_image_size( 'classifieds-similar-ads', 100, 100, true );
		add_image_size( 'classifieds-ad-single', 500, 400, true );
		add_image_size( 'classifieds-ad-owl-thumb', 100, 100, true );
		add_image_size( 'classifieds-ad-thumb', 205, 165, true );
		add_image_size( 'classifieds-ad-category-bg-thumb', 555, 250, true );
		add_image_size( 'classifieds-ad-box-bug', 525, 343, true );
		add_image_size( 'classifieds-ad-box-all', 557, 170, true );
	}

	add_theme_support('custom-header');
	add_theme_support('custom-background');
	add_theme_support('post-formats',array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ));
	add_editor_style();
}
add_action('after_setup_theme', 'classifieds_setup');

/*
Load google fonts properly
*/
function classifieds_load_google_font( $font_family ){
   $font_url = '';
    if ( 'off' !== _x( 'on', 'Google font: on or off', 'studio' ) ) {
        $font_url = add_query_arg( 'family', urlencode( $font_family.':100,300,400,700,900,100italic,300italic,400italic,700italic,900italic' ), "//fonts.googleapis.com/css" );
    }
    return $font_url;
}

/*
Enqueue styles and scripts for the theme
*/
function classifieds_scripts_styles(){
	$template_slug = get_page_template_slug();
	$protocol = is_ssl() ? 'https' : 'http';

	wp_enqueue_style( 'classifieds-awesome', get_template_directory_uri() . '/css/font-awesome.min.css' );
	wp_enqueue_style( 'classifieds-bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css' );
	wp_enqueue_style( 'classifieds-carousel', get_template_directory_uri() . '/css/owl.carousel.css' );

	$theme_font = classifieds_get_option( 'theme_font' );

	if( !empty( $theme_font ) ){
		wp_enqueue_style( 'classifieds-navigation-font', classifieds_load_google_font( $theme_font ), array(), '1.0.0' );
	}

	wp_enqueue_script( 'classifieds-googlemap', $protocol.'://maps.googleapis.com/maps/api/js?libraries=places&sensor=false', array('jquery'), false, true );		
	wp_enqueue_script( 'classifieds-bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), false, true );
	wp_enqueue_script( 'classifieds-bootstrap-multilevel-js', get_template_directory_uri() . '/js/bootstrap-dropdown-multilevel.js', array('jquery'), false, true );	

	if( $template_slug == 'page-tpl_my_profile.php' ){
		wp_enqueue_media();
		wp_enqueue_script('classifieds-image-uploads', get_template_directory_uri() . '/js/image-uploader.js', array('jquery'), false, true );
		wp_enqueue_script('classifieds-gmap-submit', get_template_directory_uri() . '/js/gmap.js', array('jquery'), false, true );
		wp_enqueue_script('classifieds-custom-fields', get_template_directory_uri() . '/js/custom-fields.js', array('jquery'), false, true );
		wp_enqueue_script( 'classifieds-stripe', 'https://checkout.stripe.com/checkout.js', false, false, true );

	}
	
	if( $template_slug == 'page-tpl_home_page.php' || $template_slug == 'page-tpl_search_page.php' ){
		wp_enqueue_script( 'classifieds-markerclusterer_compiled',  get_template_directory_uri() . '/js/markerclusterer_compiled.js', array('jquery'), false, true );
		wp_enqueue_script( 'classifieds-infobox',  get_template_directory_uri() . '/js/infobox.js', array('jquery'), false, true );
	}
	
	if (is_singular() && comments_open() && get_option('thread_comments')){
		wp_enqueue_script('comment-reply');
	}
	
	/* OWL CAROUSEL */
	wp_enqueue_script( 'classifieds-carousel',  get_template_directory_uri() . '/js/owl.carousel.min.js', array('jquery'), false, true );
	wp_enqueue_script( 'classifieds-responsive-slides',  get_template_directory_uri() . '/js/responsiveslides.min.js', array('jquery'), false, true );

	/* SELECT 2 */
	wp_enqueue_style( 'classifieds-select2', get_template_directory_uri() . '/js/select2/select2.css' );
	wp_enqueue_script( 'classifieds-select2', get_template_directory_uri() . '/js/select2/select2.min.js', array('jquery'), false, true );	

	/* MASONRY */
	wp_enqueue_script( 'classifieds-imagesloaded', get_template_directory_uri() . '/js/imagesloaded.js', false, false, true );
	wp_enqueue_script( 'classifieds-masonry', get_template_directory_uri() . '/js/masonry.js', false, false, true );	

	/* CACHE */
	wp_enqueue_script( 'classifieds-cache', get_template_directory_uri() . '/js/cache.js', array('jquery'), false, true );

	/* MAGNIFIC POPUP */
	wp_enqueue_style( 'classifieds-magnific-popup', get_template_directory_uri() . '/css/magnific-popup.css' );
	wp_enqueue_script( 'classifieds-magnific-popup', get_template_directory_uri() . '/js/jquery.magnific-popup.min.js', array('jquery'), false, true );		

	//SWEET ALERT
	wp_enqueue_style( 'classifieds-sweetalert', get_template_directory_uri() . '/css/sweetalert.css' );
	wp_enqueue_script( 'classifieds-sweetalert', get_template_directory_uri() . '/js/sweetalert-dev.js', array('jquery'), false, true );
	
	// CUSTOM
	wp_enqueue_script( 'classifieds-custom', get_template_directory_uri() . '/js/custom.js', array('jquery'), false, true );
	wp_localize_script( 'classifieds-custom', 'classifieds_data', array(
		'url' => get_template_directory_uri(),
		'home_map_geolocation' => is_front_page() ? classifieds_get_option( 'home_map_geolocation' ) : 'no',
		'home_map_geo_zoom' => classifieds_get_option( 'home_map_geo_zoom' ),
		'contact_map_zoom' => classifieds_get_option( 'contact_map_zoom' ),
		'restrict_country' => classifieds_get_option( 'restrict_country' ),
		'home_map_zoom' => classifieds_get_option( 'home_map_zoom' ),
		'map_price' => classifieds_get_option( 'home_map_show_price' ),
		'empty_search_location' => classifieds_get_option('empty_search_location'),
		'ads_max_videos' => classifieds_get_option( 'ads_max_videos' ),
		'ads_max_images' => classifieds_get_option( 'ads_max_images' ),
	) );

}
add_action('wp_enqueue_scripts', 'classifieds_scripts_styles', 2 );

/*
Load style based on the theme option settings
*/
function classifieds_load_color_schema(){
	/* LOAD MAIN STYLE */
	wp_enqueue_style('classifieds-style', get_stylesheet_uri() , array());
	ob_start();
	include( classifieds_load_path( 'css/main-color.css.php' ) );
	$custom_css = ob_get_contents();
	ob_end_clean();
	wp_add_inline_style( 'classifieds-style', $custom_css );	
}
add_action('wp_enqueue_scripts', 'classifieds_load_color_schema', 4 );

/*
Load resuorces which are avaialabe in the admin backend
*/
function classifieds_admin_resources(){
	global $post;
	wp_enqueue_style( 'classifieds-awesome', get_template_directory_uri() . '/css/font-awesome.min.css' );
	if( ( isset( $_GET['post_type'] ) && $_GET['post_type'] == 'custom_field' ) || ( isset( $post ) && $post->post_type == 'custom_field' ) ){
		wp_enqueue_script( 'classifieds-admin-custom-fields', get_template_directory_uri() . '/js/admin.js', false, false, true );
	}

	if( ( isset( $_GET['post_type'] ) && $_GET['post_type'] == 'ad' ) || ( isset( $post ) && $post->post_type == 'ad' ) ){
		wp_enqueue_script( 'classifieds-ad-custom-fields', get_template_directory_uri() . '/js/custom-fields.js', false, false, true );
	}

	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker' );
	wp_enqueue_script( 'jquery-ui-sortable' );
	wp_enqueue_script( 'jquery-ui-dialog' );

	wp_enqueue_script( 'classifieds-cache', get_template_directory_uri() . '/js/cache.js', array('jquery'), false, true );

	wp_enqueue_style('classifieds-jquery-ui', get_template_directory_uri() . '/css/jquery-ui.css' );
	wp_enqueue_script('jquery-ui-sortable');
	wp_enqueue_style('classifieds-shortcodes-style', get_template_directory_uri() . '/css/admin.css' );
	wp_enqueue_script('classifieds-multidropdown', get_template_directory_uri() . '/js/multidropdown.js', false, false, true);
	wp_enqueue_script('classifieds-image-uploader', get_template_directory_uri() . '/js/image-uploader.js', false, false, true);
	wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'classifieds_admin_resources' );


/*
Add adminajax url on the page
*/
function classifieds_custom_head(){
	echo '<script type="text/javascript">var ajaxurl = \'' . admin_url('admin-ajax.php') . '\';</script>';
}
add_action('wp_head', 'classifieds_custom_head');

function classifieds_smeta_images( $meta_key, $post_id, $default ){
	if(class_exists('SM_Frontend')){
		global $sm;
		return $result = $sm->sm_get_meta($meta_key, $post_id);
	}
	else{		
		return $default;
	}
}

/*
Get list of the post types
*/
function classifieds_get_custom_list( $post_type, $args = array(), $orderby = '', $direction = 'right' ){
	$post_array = array();
	$args = array( 'post_type' => $post_type, 'post_status' => 'publish', 'posts_per_page' => -1 ) + $args;
	if( !empty( $orderby ) ){
		$args['orderby'] = $orderby;
		$args['order'] = 'ASC';
	}
	$posts = get_posts( $args );
	
	foreach( $posts as $post ){
		if( $direction == 'right' ){
			$post_array[$post->ID] = $post->post_title;
		}
		else{
			$post_array[$post->post_title] = $post->ID;	
		}
	}
	
	return $post_array;
}

/*
Get taxonomy list
*/
function classifieds_get_custom_tax_list( $taxonomy, $direction = 'right', $hide_empty = true, $field = 'slug' ){
	$terms = get_terms( $taxonomy, array( 'hide_empty' => $hide_empty ));
	$term_list = array();
	if( !empty( $terms ) ){
		foreach( $terms as $term ){
			if( $direction == 'right' ){
				$term_list[$term->$field] = $term->name;
			}
			else{
				$term_list[$term->name] = $term->$field;
			}
		}
	}

	return $term_list;
}

/*
Get all custom fields
*/
function classifieds_get_custom_fields( $post_id ){
	global $wpdb;

	$fields = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT * FROM {$wpdb->prefix}custom_fields WHERE post_id = %d AND parent = 0 ORDER BY field_id",
			$post_id
		)
	);	

	return $fields;
}

/*
Get all custom subfields
*/
function classifieds_get_custom_subfields( $post_id, $field_id ){
	global $wpdb;

	$subfields = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT * FROM {$wpdb->prefix}custom_fields WHERE post_id = %d AND parent = %d ORDER BY field_id",
			$post_id,
			$field_id
		)
	);	

	return $subfields;
}

/*
Create select boxes
*/
function classifieds_generate_select( $field, $selected, $hidden = true ){
	$select = '<li class="'.( $hidden ? 'hidden' : '' ).'"><div class="'.( empty( $field->child_of_value ) ? '' : 'custom-select-wrap '.str_replace('|', '-', $field->child_of_value) ).'">';
		$select .= '<label for="'.esc_attr__( $field->name ).'">'.$field->label.'</label>
					<select name="cf_'.esc_attr__( $field->name ).'" id="'.esc_attr__( $field->name ).'" class="form-control '.( empty( $field->child_of_value ) ? 'custom-select-change' : '' ).'">';
			$select .= '<option value="">'.esc_html__( 'Select', 'classifieds' ).'</option>';
			$values = explode( "\n", $field->field_values );
			if( !empty( $values ) ){
				foreach( $values as $value ){
					if( !empty( $value ) ){
						$temp = explode( "|", $value );
						$select .= '<option value="'.esc_attr__( $temp[0] ).'" '.( $selected == $temp[0] ? 'selected="selected"' : '' ).'>'.$temp[1].'</option>';
					}
				}
			}
		$select .= '</select>';
	$select .= '</div></li>';

	return $select;
}

/*
Create input field
*/
function classifieds_generate_input( $field, $value ){
	return '<label for="'.esc_attr__( $field->name ).'">'.$field->label.'</label>
			<input type="text" name="cf_'.esc_attr__( $field->name ).'" id="'.esc_attr__( $field->name ).'" class="form-control" value="'.( !empty( $value ) ? esc_attr__( $value ) : '' ).'"/>';
}

/*
Add meta box for the custom fields custom post type
*/
function classifieds_add_meta_box_custom_fields() {
	add_meta_box(
		'classifieds_custom_meta',
		esc_html__( 'Custom Fields Data', 'classifieds' ),
		'classifieds_populate_meta_box_custom_fields',
		'custom_field'
	);
}
add_action( 'add_meta_boxes', 'classifieds_add_meta_box_custom_fields' );


/*
Populate meta box for the custom fields custompo st type
*/
function classifieds_populate_meta_box_custom_fields( $post ) {
	global $wpdb;
	$current_fields = '';

	$fields = classifieds_get_custom_fields( $post->ID );
	$counter = 0;
	if( !empty( $fields ) ){
		foreach( $fields as $field ){
			$subfields_html = '';
			if( $field->type == 'select' ){
				$subfields = classifieds_get_custom_subfields( $post->ID, $field->field_id );
				if( !empty( $subfields ) ){
					foreach( $subfields as $subfield ){
						$subgroup_name = $subfield->name;
						$subgroup_label = $subfield->label;						
						$values_args = explode('|', $subfield->child_of_value);
						$subfields_html .= '
							<div class="subgroups_field '.esc_attr__( $values_args[0] ).'">
								<a href="javascript:;" class="remove_subgroup button">X</a>
								<label for="cf_subgroup_label['.$counter.']['.$subfield->child_of_value.']">'.esc_html__( 'Values for', 'classifieds' ).' <span>'.$values_args[1].'</span></label>
								<textarea name="cf_field['.$counter.'][cf_subfield]['.$subfield->child_of_value.']" id="cf_subgroup_label['.$counter.']['.$subfield->child_of_value.']">'.$subfield->field_values.'</textarea>
								<p class="description">'.esc_html__( 'Input values one per line in form VALUE|LABEL. LABEL must not contain spaces,and special signs.', 'classifieds' ).'</p>
							</div>
						';
					}
				}
			}
			$current_fields .= '
				<div class="cf_add_field_block">
					<div class="clearfix">
						<div class="pull-left">
							<div class="cf_title">'.$field->label.'</div>
						</div>
						<div class="pull-right">
							<div class="acf_field_actions">
								<a href="javascript:;" class="button remove-field">
									<i class="fa fa-times"></i>
								</a>
							</div>
						</div>
					</div>
					<div class="cf_body">
						<div class="cf_basic">
							<div class="cf_form_group">
								<label for="cf_name['.$counter.']">'.esc_html__('Field Name', 'classifieds').'</label>
								<input type="text" name="cf_field['.$counter.'][cf_name]" id="cf_name['.$counter.']" value="'.esc_attr__( $field->name ).'" />
								<input type="hidden" name="cf_field['.$counter.'][cf_old_name]" value="'.esc_attr__( $field->name ).'" />
								<p class="description">'.esc_html__( 'Input name of the field. It must not contain empty spaces and special chars.', 'classifieds' ).'</p>
							</div>
							<div class="cf_form_group">
								<label for="cf_label['.$counter.']">'.esc_html__('Field Label', 'classifieds').'</label>
								<input type="text" name="cf_field['.$counter.'][cf_label]" id="cf_label['.$counter.']" value="'.esc_attr__( $field->label ).'" />
								<p class="description">'.esc_html__( 'Input label for the field.', 'classifieds' ).'</p>
							</div>
							<div class="cf_form_group">
								<label for="cf_type['.$counter.']">'.esc_html__('Field Type', 'classifieds').'</label>
								<select name="cf_field['.$counter.'][cf_type]" id="cf_type['.$counter.']">
									<option value="input">'.esc_html__( 'Input Field', 'classifieds' ).'</option>
									<option value="select" '.( ( $field->type == 'select' ) ? 'selected="selected"' : ''  ).'>'.esc_html__( 'Select Field', 'classifieds' ).'</option>
								</select>
								<p class="description">'.esc_html__( 'Select type of the field.', 'classifieds' ).'</p>
							</div>				
						</div>
						<div class="cf_is_input">

						</div>
						<div class="cf_is_select '.( ( $field->type == 'select' ) ? '' : 'hidden'  ).'">

							<label for="cf_select_values">'.esc_html__('Select Box Options', 'classifieds').'</label>
							<textarea name="cf_field['.$counter.'][cf_select_values]" id="cf_field['.$counter.'][cf_select_values]" class="select_values">'.$field->field_values.'</textarea>
							<p class="description">'.esc_html__( 'Input values one per line in form VALUE|LABEL',  'classifieds' ).'</p>

							<a href="javascript:;" class="button create_subgroups '.( empty( $subfields ) ? '' : 'hidden' ).'">'.esc_html__( 'Make Subgroups', 'classifieds' ).'</a>
							<a href="javascript:;" class="button update_subgroups '.( empty( $subfields ) ? 'hidden' : '' ).'">'.esc_html__( 'Update Subgroups', 'classifieds' ).'</a>
							<a href="javascript:;" class="button remove_subgroups"><i class="fa fa-times"></i></a>
							<input type="hidden" class="has_subgroup" name="cf_field['.$counter.'][has_subgroups]" value="'.( !empty( $subfields ) ? '1' : '0' ).'">
							
							<div class="cf_select_subgroup '.( !empty( $subfields ) ? '' : 'hidden' ).'">
								<label for="cf_subgroup_name['.$counter.']">'.esc_html__( 'Subgroup Name', 'classifieds' ).'</label>
								<input type="text" name="cf_field['.$counter.'][cf_subfield_name]" id="cf_subgroup_name['.$counter.']" value="'.esc_attr__( !empty( $subgroup_name ) ? $subgroup_name : '' ).'" />
								<p class="description">'.esc_html__( 'Input name of the subfield. It must not contain empty spaces and special chars.', 'classifieds' ).'</p>

								<input type="hidden" name="cf_field['.$counter.'][cf_subfield_old_name]" value="'.esc_attr__( !empty( $subgroup_name ) ? $subgroup_name : '' ).'" />
								<label for="cf_subgroup_label['.$counter.']">'.esc_html__( 'Subgroup Label', 'classifieds' ).'</label>
								<input type="text" name="cf_field['.$counter.'][cf_subfield_label]" id="cf_subgroup_label['.$counter.']" value="'.esc_attr__( !empty( $subgroup_label ) ? $subgroup_label : '' ).'" />
								<p class="description">'.esc_html__( 'Input label for the subfield.', 'classifieds' ).'</p>

								<div class="subgroups_field hidden">
									<a href="javascript:;" class="remove_subgroup button">X</a>
									<label for="cf_subgroup_label['.$counter.'][valuex]">'.esc_html__( 'Values for', 'classifieds' ).' <span>[labelx]</span></label>
									<textarea name="cf_field['.$counter.'][cf_subfield][valuex]" id="cf_subgroup_label['.$counter.'][valuex]"></textarea>
									<p class="description">'.esc_html__( 'Input values one per line in form VALUE|LABEL. LABEL must not contain spaces,and special signs.', 'classifieds' ).'</p>
								</div>
							</div>

							<div class="subgroups_holder">
								'.$subfields_html.'
							</div>
						</div>			
					</div>
				</div>
			';
			$counter++;
		}
	}

	$basic = '
	<div class="cf_add_field_block hidden">
		<div class="clearfix">
			<div class="pull-left">
				<div class="cf_title"></div>
			</div>
			<div class="pull-right">
				<div class="acf_field_actions">
					<a href="javascript:;" class="button remove-field">
						<i class="fa fa-times"></i>
					</a>
				</div>
			</div>
		</div>
		<div class="cf_body">
			<div class="cf_basic">
				<div class="cf_form_group">
					<label for="cf_name[x]">'.esc_html__('Field Name', 'classifieds').'</label>
					<input type="text" name="cf_field[x][cf_name]" id="cf_name[x]" />
					<p class="description">'.esc_html__( 'Input name of the field. It must not contain empty spaces and special chars.', 'classifieds' ).'</p>
				</div>
				<div class="cf_form_group">
					<label for="cf_label[x]">'.esc_html__('Field Label', 'classifieds').'</label>
					<input type="text" name="cf_field[x][cf_label]" id="cf_label[x]" />
					<p class="description">'.esc_html__( 'Input label for the field.', 'classifieds' ).'</p>
				</div>
				<div class="cf_form_group">
					<label for="cf_type[x]">'.esc_html__('Field Type', 'classifieds').'</label>
					<select name="cf_field[x][cf_type]" id="cf_type[x]">
						<option value="input">'.esc_html__( 'Input Field', 'classifieds' ).'</option>
						<option value="select">'.esc_html__( 'Select Field', 'classifieds' ).'</option>
					</select>
					<p class="description">'.esc_html__( 'Select type of the field.', 'classifieds' ).'</p>
				</div>				
			</div>
			<div class="cf_is_input">

			</div>
			<div class="cf_is_select hidden">

				<label for="cf_select_values">'.esc_html__('Select Box Options', 'classifieds').'</label>
				<textarea name="cf_field[x][cf_select_values]" id="cf_field[x][cf_select_values]" class="select_values"></textarea>
				<p class="description">'.esc_html__( 'Input values one per line in form VALUE|LABEL', 'classifieds' ).'</p>

				<a href="javascript:;" class="button create_subgroups">'.esc_html__( 'Make Subgroups', 'classifieds' ).'</a>
				<a href="javascript:;" class="button update_subgroups hidden">'.esc_html__( 'Update Subgroups', 'classifieds' ).'</a>
				<a href="javascript:;" class="button remove_subgroups"><i class="fa fa-times"></i></a>
				<input type="hidden" class="has_subgroup" name="cf_field[x][has_subgroups]" value="0">
				
				<div class="cf_select_subgroup hidden">
					<label for="cf_subgroup_name[x]">'.esc_html__( 'Subgroup Name', 'classifieds' ).'</label>
					<input type="text" name="cf_field[x][cf_subfield_name]" id="cf_subgroup_name[x]"/>		
					<p class="description">'.esc_html__( 'Input name of the subfield. It must not contain empty spaces and special chars.', 'classifieds' ).'</p>

					<label for="cf_subgroup_label[x]">'.esc_html__( 'Subgroup Label', 'classifieds' ).'</label>
					<input type="text" name="cf_field[x][cf_subfield_label]" id="cf_subgroup_label[x]"/>
					<p class="description">'.esc_html__( 'Input label for the subfield.', 'classifieds' ).'</p>
					
					<div class="subgroups_field hidden">
						<a href="javascript:;" class="remove_subgroup button">X</a>
						<label for="cf_subgroup_label[x][valuex]">'.esc_html__( 'Values for', 'classifieds' ).' <span>[labelx]</span></label>
						<textarea name="cf_field[x][cf_subfield][valuex]" id="cf_subgroup_label[x][valuex]"></textarea>
						<p class="description">'.esc_html__( 'Input values one per line in form VALUE|LABEL. LABEL must not contain spaces,and special signs.', 'classifieds' ).'</p>
					</div>
				</div>

				<div class="subgroups_holder">
				</div>
			</div>			
		</div>
	</div>

	'.$current_fields.'

	<a href="javascript:;" class="button button-primary cf_add_new_field">'.esc_html__( 'Add New Field', 'classifieds' ).'</a>
	';

	echo  $basic;

}

/*
Save custom values
*/
function classifieds_save_custom_fields_meta( $post_id ) {
	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'custom_field' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	/* OK, it's safe for us to save the data now. */
	
	// Make sure that it is set.
	if ( ! isset( $_POST['cf_field'] ) ) {
		return;
	}

	// Sanitize user input.
	$custom_meta = sanitize_text_field( $_POST['classifieds_custom_meta'] );

	// Update the meta field in the database.
	//update_post_meta( $post_id, 'classifieds_custom_meta', $custom_meta );
	global $wpdb;
	$wpdb->query(
		$wpdb->prepare(
			"DELETE FROM {$wpdb->prefix}custom_fields WHERE post_id = %d",
			$post_id
		)
	);


	foreach( $_POST['cf_field'] as $key => $field ){
		if( $key !== 'x' ){
			$wpdb->query(
				$wpdb->prepare(
					"INSERT INTO {$wpdb->prefix}custom_fields VALUES( '', %d, %s, %s, %s, %s, %s, %d )",
					$post_id,
					$field['cf_name'],
					$field['cf_label'],
					$field['cf_type'],
					$field['cf_select_values'],
					'',
					0
				)
			);

			if( $field['has_subgroups'] == '1' ){
				$parent = $wpdb->insert_id;
				foreach( $field['cf_subfield'] as $subkey => $subvalues ){
					if( $subkey !== 'valuex' ){
						$wpdb->query(
							$wpdb->prepare(
								"INSERT INTO {$wpdb->prefix}custom_fields VALUES( '', %d, %s, %s, %s, %s, %s, %d )",
								$post_id,
								$field['cf_subfield_name'],
								$field['cf_subfield_label'],
								'select',
								$subvalues,
								$subkey,
								$parent
							)
						);
					}
				}
			}

			if( !empty( $field['cf_old_name'] ) ){
				$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->prefix}custom_fields_meta SET name = %s WHERE name = %s", $field['cf_name'], $field['cf_old_name'] ) );
			}

			if( !empty( $field['cf_subfield_old_name'] ) ){
				$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->prefix}custom_fields_meta SET name = %s WHERE name = %s", $field['cf_subfield_name'], $field['cf_subfield_old_name'] ) );
			}			
		}
	}
}
add_action( 'save_post', 'classifieds_save_custom_fields_meta' );


function classifieds_delete_custom_fields_meta( $post_id ){
	global $wpdb, $post_type;

	if( $post_type == 'custom_field' ){
		/* delete values from ads */
		$wpdb->query(
			$wpdb->prepare(
				"DELETE postmeta.* FROM {$wpdb->prefix}custom_fields AS cf LEFT JOIN {$wpdb->prefix}custom_fields_meta AS postmeta ON cf.name = postmeta.name WHERE cf.post_id = %d"
			, $post_id )
		);
		/* delete from the custom table */
		$wpdb->query( $wpdb->prepare( "DELETE FROM {$wpdb->prefix}custom_fields WHERE post_id = %d", $post_id ) );
	}
	else if( $post_type == 'ad' ){
		$wpdb->query( $wpdb->prepare( "DELETE FROM {$wpdb->prefix}custom_fields_meta WHERE post_id = %d", $post_id ) );
	}
}
add_action( 'delete_post', 'classifieds_delete_custom_fields_meta' );
/*
Add custom fields to the post types
*/
if( !function_exists('classifieds_custom_meta_boxes') ){
function classifieds_custom_meta_boxes(){
	$post_meta_standard = array(
		array(
			'id' => 'iframe_standard',
			'name' => esc_html__( 'Embed URL', 'classifieds' ),
			'type' => 'text',
			'desc' => esc_html__( 'Input custom URL which will be embeded as the blog post media.', 'classifieds' )
		),
	);
	
	$meta_boxes[] = array(
		'title' => esc_html__( 'Standard Post Information', 'classifieds' ),
		'pages' => 'post',
		'fields' => $post_meta_standard,
	);	
	
	$post_meta_gallery = array(
		array(
			'id' => 'gallery_images',
			'name' => esc_html__( 'Gallery Images', 'classifieds' ),
			'type' => 'image',
			'repeatable' => 1,
			'desc' => esc_html__( 'Add images for the gallery post format. Drag and drop to change their order.', 'classifieds' )
		)
	);

	$meta_boxes[] = array(
		'title' => esc_html__( 'Gallery Post Information', 'classifieds' ),
		'pages' => 'post',
		'fields' => $post_meta_gallery,
	);	
	
	
	$post_meta_audio = array(
		array(
			'id' => 'iframe_audio',
			'name' => esc_html__( 'Audio URL', 'classifieds' ),
			'type' => 'text',
			'desc' => esc_html__( 'Input url to the audio source which will be media for the audio post format.', 'classifieds' )
		),
		
		array(
			'id' => 'audio_type',
			'name' => esc_html__( 'Audio Type', 'classifieds' ),
			'type' => 'select',
			'options' => array(
				'embed' => esc_html__( 'Embed', 'classifieds' ),
				'direct' => esc_html__( 'Direct Link', 'classifieds' )
			),
			'desc' => esc_html__( 'Select format of the audio URL ( Direct Link - for mp3, Embed - for the links from SoundCloud, MixCloud,... ).', 'classifieds' )
		),
	);
	
	$meta_boxes[] = array(
		'title' => esc_html__( 'Audio Post Information', 'classifieds' ),
		'pages' => 'post',
		'fields' => $post_meta_audio,
	);
	
	$post_meta_video = array(
		array(
			'id' => 'video',
			'name' => esc_html__( 'Video URL', 'classifieds' ),
			'type' => 'text',
			'desc' => esc_html__( 'Input url to the video source which will be media for the audio post format.', 'classifieds' )
		),
		array(
			'id' => 'video_type',
			'name' => esc_html__( 'Video Type', 'classifieds' ),
			'type' => 'select',
			'options' => array(
				'remote' => esc_html__( 'Embed', 'classifieds' ),
				'self' => esc_html__( 'Direct Link', 'classifieds' ),				
			),
			'desc' => esc_html__( 'Select format of the video URL ( Direct Link - for ogg, mp4..., Embed - for the links from YouTube, Vimeo,... ).', 'classifieds' )
		),
	);
	
	$meta_boxes[] = array(
		'title' => esc_html__( 'Video Post Information', 'classifieds' ),
		'pages' => 'post',
		'fields' => $post_meta_video,
	);
	
	$post_meta_quote = array(
		array(
			'id' => 'blockquote',
			'name' => esc_html__( 'Input Quotation', 'classifieds' ),
			'type' => 'textarea',
			'desc' => esc_html__( 'Input quote as blog media for the quote post format.', 'classifieds' )
		),
		array(
			'id' => 'cite',
			'name' => esc_html__( 'Input Quoted Person\'s Name', 'classifieds' ),
			'type' => 'text',
			'desc' => esc_html__( 'Input quoted person\'s name for the quote post format.', 'classifieds' )
		),
	);
	
	$meta_boxes[] = array(
		'title' => esc_html__( 'Quote Post Information', 'classifieds' ),
		'pages' => 'post',
		'fields' => $post_meta_quote,
	);	

	$post_meta_link = array(
		array(
			'id' => 'link',
			'name' => esc_html__( 'Input Link', 'classifieds' ),
			'type' => 'text',
			'desc' => esc_html__( 'Input link as blog media for the link post format.', 'classifieds' )
		),
	);
	
	$meta_boxes[] = array(
		'title' => esc_html__( 'Link Post Information', 'classifieds' ),
		'pages' => 'post',
		'fields' => $post_meta_link,
	);

	$clients_meta = array(
		array(
			'id' => 'client_link',
			'name' => esc_html__( 'Input Client Link', 'classifieds' ),
			'type' => 'text',
			'desc' => esc_html__( 'Input link to the clients website.', 'classifieds' )
		),
	);
	
	$meta_boxes[] = array(
		'title' => esc_html__( 'Link Information', 'classifieds' ),
		'pages' => 'client',
		'fields' => $clients_meta,
	);

	$custom_field_meta = array(
		array(
			'id' => 'fields_for',
			'name' => esc_html__( 'Fields For', 'classifieds' ),
			'type' => 'taxonomy_checkboxes',
			'taxonomy' => 'ad-category',
			'desc' => esc_html__( 'Select category for which fields are.', 'classifieds' )
		),
	);
	
	$meta_boxes[] = array(
		'title' => esc_html__( 'Fields Information', 'classifieds' ),
		'pages' => 'custom_field',
		'fields' => $custom_field_meta,
	);

	$ad_field_meta = array(
		array(
			'id' => 'ad_expire',
			'name' => esc_html__( 'Ad Expire Time', 'classifieds' ),
			'type' => 'datetime_unix',
			'desc' => esc_html__( 'This field is auto populated on submit and renew.', 'classifieds' )
		),		
		array(
			'id' => 'ad_price',
			'name' => esc_html__( 'Ad Price', 'classifieds' ),
			'type' => 'text',
			'desc' => esc_html__( 'Input ad price.', 'classifieds' )
		),
		array(
			'id' => 'ad_discounted_price',
			'name' => esc_html__( 'Discounted Ad Price', 'classifieds' ),
			'type' => 'text',
			'desc' => esc_html__( 'Input dicounted ad price.', 'classifieds' )
		),
		array(
			'id' => 'ad_call_for_price',
			'name' => esc_html__( 'Call For Info', 'classifieds' ),
			'type' => 'checkbox',
		),		
		array(
			'id' => 'ad_gmap',
			'name' => esc_html__( 'Ad Location', 'classifieds' ),
			'type' => 'gmap',
			'desc' => esc_html__( 'Set ad marker.', 'classifieds' )
		),
		array(
			'id' => 'ad_videos',
			'name' => esc_html__( 'Ad Videos', 'classifieds' ),
			'type' => 'text',
			'repeatable' => 1,
			'desc' => esc_html__( 'Input links to ad videos.', 'classifieds' )
		),	
		array(
			'id' => 'ad_images',
			'name' => esc_html__( 'Ad Images', 'classifieds' ),
			'type' => 'image',
			'repeatable' => 1,
			'desc' => esc_html__( 'Input ad images.', 'classifieds' )
		),	
		array(
			'id' => 'ad_display_map',
			'name' => esc_html__( 'Ad Display Map?', 'classifieds' ),
			'type' => 'select',
			'options' => array(
				'yes' => esc_html__( 'Yes', 'classifieds' ),
				'no' => esc_html__( 'No', 'classifieds' ),
			),
			'desc' => esc_html__( 'Enable or disable display of the map on the single page.', 'classifieds' )
		),		
		array(
			'id' => 'ad_featured',
			'name' => esc_html__( 'Ad Is Featured?', 'classifieds' ),
			'type' => 'select',
			'options' => array(
				'no' => esc_html__( 'No', 'classifieds' ),
				'yes' => esc_html__( 'Yes', 'classifieds' ),
			),
			'desc' => esc_html__( 'Is ad featured?', 'classifieds' )
		),
		array(
			'id' => 'ad_phone',
			'name' => esc_html__( 'Ad Phone', 'classifieds' ),
			'type' => 'text',
			'desc' => esc_html__( 'Custom phone used only for this ad.', 'classifieds' ),
			'default' => ''
		),
		array(
			'id' => 'ad_views',
			'name' => esc_html__( 'Ad Views', 'classifieds' ),
			'type' => 'text',
			'desc' => esc_html__( 'Number of views of ad single page ( this field is auto incrementd ).', 'classifieds' )
		),		
		array(
			'id' => 'ad_paid',
			'name' => esc_html__( 'Ad Paid', 'classifieds' ),
			'type' => 'select',
			'options' => array(
				'yes' => esc_html__( 'Yes', 'classifieds' ),
				'no' => esc_html__( 'No', 'classifieds' ),
			),
			'desc' => esc_html__( 'Is this ad paid for?', 'classifieds' ),
			'default' => 'no'
		),
		array(
			'id' => 'ad_visibility',
			'name' => esc_html__( 'Ad Visibility', 'classifieds' ),
			'type' => 'select',
			'options' => array(
				'yes' => esc_html__( 'Visible', 'classifieds' ),
				'no' => esc_html__( 'Hidden', 'classifieds' ),
			),
			'desc' => esc_html__( 'Visibility of the ad.', 'classifieds' ),
			'default' => 'yes'
		),		
	);

	$meta_boxes[] = array(
		'title' => esc_html__( 'Ad Information', 'classifieds' ),
		'pages' => 'ad',
		'fields' => $ad_field_meta,
	);

	return $meta_boxes;	
}

add_filter('sm_meta_boxes', 'classifieds_custom_meta_boxes');
}

/*
Transform HEX to RGB color
*/
function classifieds_hex2rgb( $hex ) {
	$hex = str_replace("#", "", $hex);

	$r = hexdec(substr($hex,0,2));
	$g = hexdec(substr($hex,2,2));
	$b = hexdec(substr($hex,4,2));
	return $r.", ".$g.", ".$b; 
}



/* custom walker class to create main top and bottom navigation */
class classifieds_walker extends Walker_Nav_Menu {
  
	/**
	* @see Walker::start_lvl()
	* @since 3.0.0
	*
	* @param string $output Passed by reference. Used to append additional content.
	* @param int $depth Depth of page. Used for padding.
	*/
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "\n$indent<ul role=\"menu\" class=\" dropdown-menu\">\n";
	}

	/**
	* @see Walker::start_el()
	* @since 3.0.0
	*
	* @param string $output Passed by reference. Used to append additional content.
	* @param object $item Menu item data object.
	* @param int $depth Depth of menu item. Used for padding.
	* @param int $current_page Menu item ID.
	* @param object $args
	*/
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		/**
		* Dividers, Headers or Disabled
		* =============================
		* Determine whether the item is a Divider, Header, Disabled or regular
		* menu item. To prevent errors we use the strcasecmp() function to so a
		* comparison that is not case sensitive. The strcasecmp() function returns
		* a 0 if the strings are equal.
		*/
		if ( strcasecmp( $item->attr_title, 'divider' ) == 0 && $depth === 1 ) {
			$output .= $indent . '<li role="presentation" class="divider">';
		} 
		else if ( strcasecmp( $item->title, 'divider') == 0 && $depth === 1 ) {
			$output .= $indent . '<li role="presentation" class="divider">';
		} 
		else if ( strcasecmp( $item->attr_title, 'dropdown-header') == 0 && $depth === 1 ) {
			$output .= $indent . '<li role="presentation" class="dropdown-header">' . esc_attr__( $item->title );
		} 
		else if ( strcasecmp($item->attr_title, 'disabled' ) == 0 ) {
			$output .= $indent . '<li role="presentation" class="disabled"><a href="#">' . esc_attr__( $item->title ) . '</a>';
		} 
		else {

			$mega_menu_custom = get_post_meta( $item->ID, 'mega-menu-set', true );

			$class_names = $value = '';
			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			if( !empty( $mega_menu_custom ) ){
				$classes[] = 'mega_menu_li';
			}
			$classes[] = 'menu-item-' . $item->ID;
			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
			
			if ( $args->has_children ){
				$class_names .= ' dropdown';
			}
			
			$class_names = $class_names ? ' class="' . esc_attr__( $class_names ) . '"' : '';
			$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
			$id = $id ? ' id="' . esc_attr__( $id ) . '"' : '';

			$output .= $indent . '<li' . $id . $value . $class_names .'>';

			$atts = array();
			$atts['title'] = ! empty( $item->attr_title )	? $item->attr_title	: '';
			$atts['target'] = ! empty( $item->target )	? $item->target	: '';
			$atts['rel'] = ! empty( $item->xfn )	? $item->xfn	: '';

			// If item has_children add atts to a.
			$atts['href'] = ! empty( $item->url ) ? $item->url : '';
			if ( $args->has_children ) {
				$atts['data-toggle']	= 'dropdown';
				$atts['class']	= 'dropdown-toggle';
				$atts['data-hover']	= 'dropdown';
				$atts['aria-haspopup']	= 'true';
			} 

			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( ! empty( $value ) ) {
					$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr__( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}

			$item_output = $args->before;

			/*
			* Glyphicons
			* ===========
			* Since the the menu item is NOT a Divider or Header we check the see
			* if there is a value in the attr_title property. If the attr_title
			* property is NOT null we apply it as the class name for the glyphicon.
			*/

			$item_output .= '<a'. $attributes .'>';

			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
			if( !empty( $mega_menu_custom ) ){
				$registered_widgets = wp_get_sidebars_widgets();
				$count = count( $registered_widgets[$mega_menu_custom] );
				$item_output .= '</a>';
				$mega_menu_min_height = classifieds_get_option( 'mega_menu_min_height' );
				$style = '';
				if( !empty( $mega_menu_min_height ) ){
					$style = 'style="height: '.esc_attr__( $mega_menu_min_height ).'"';
				}
				$item_output .= '<ul class="list-unstyled mega_menu col-'.$count.'" '.$style.'>';
				ob_start();
				if( is_active_sidebar( $mega_menu_custom ) ){
					dynamic_sidebar( $mega_menu_custom );
				}
				$item_output .= ob_get_contents();
				ob_end_clean();
				$item_output .= '</ul>';
			}
			else{
				$item_output .= '</a>';
			}
			$item_output .= $args->after;
			
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	}

	/**
	* Traverse elements to create list from elements.
	*
	* Display one element if the element doesn't have any children otherwise,
	* display the element and its children. Will only traverse up to the max
	* depth and no ignore elements under that depth.
	*
	* This method shouldn't be called directly, use the walk() method instead.
	*
	* @see Walker::start_el()
	* @since 2.5.0
	*
	* @param object $element Data object
	* @param array $children_elements List of elements to continue traversing.
	* @param int $max_depth Max depth to traverse.
	* @param int $depth Depth of current element.
	* @param array $args
	* @param string $output Passed by reference. Used to append additional content.
	* @return null Null on failure with no changes to parameters.
	*/
	public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
		if ( ! $element )
			return;

		$id_field = $this->db_fields['id'];

		// Display this element.
		if ( is_object( $args[0] ) ){
		   $args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );
		}

		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}

	/**
	* Menu Fallback
	* =============
	* If this function is assigned to the wp_nav_menu's fallback_cb variable
	* and a manu has not been assigned to the theme location in the WordPress
	* menu manager the function with display nothing to a non-logged in user,
	* and will add a link to the WordPress menu manager if logged in as an admin.
	*
	* @param array $args passed from the wp_nav_menu function.
	*
	*/
	public static function fallback( $args ) {
		if ( current_user_can( 'manage_options' ) ) {

			extract( $args );

			$fb_output = null;

			if ( $container ) {
				$fb_output = '<' . $container;

				if ( $container_id ){
					$fb_output .= ' id="' . $container_id . '"';
				}

				if ( $container_class ){
					$fb_output .= ' class="' . $container_class . '"';
				}

				$fb_output .= '>';
			}

			$fb_output .= '<ul';

			if ( $menu_id ){
				$fb_output .= ' id="' . $menu_id . '"';
			}

			if ( $menu_class ){
				$fb_output .= ' class="' . $menu_class . '"';
			}

			$fb_output .= '>';
			$fb_output .= '<li><a href="' . admin_url( 'nav-menus.php' ) . '">Add a menu</a></li>';
			$fb_output .= '</ul>';

			if ( $container ){
				$fb_output .= '</' . $container . '>';
			}

			echo  $fb_output;
		}
	}
}

/* 
Set sizes for cloud widget
*/
function classifieds_custom_tag_cloud_widget($args) {
	$args['largest'] = 18; //largest tag
	$args['smallest'] = 10; //smallest tag
	$args['unit'] = 'px'; //tag font unit
	return $args;
}
add_filter( 'widget_tag_cloud_args', 'classifieds_custom_tag_cloud_widget' );

/* 
Format wp_link_pages so it has the right css applied to it 
*/
function classifieds_link_pages(){
	$post_pages = wp_link_pages( 
		array(
			'before' 		   => '',
			'after' 		   => '',
			'link_before'      => '<span>',
			'link_after'       => '</span>',
			'next_or_number'   => 'number',
			'nextpagelink'     => esc_html__( '&raquo;', 'classifieds' ),
			'previouspagelink' => esc_html__( '&laquo;', 'classifieds' ),			
			'separator'        => ' ',
			'echo'			   => 0
		) 
	);
	/* format pages that are not current ones */
	$post_pages = str_replace( '<a', '<li><a', $post_pages );
	$post_pages = str_replace( '</span></a>', '</a></li>', $post_pages );
	$post_pages = str_replace( '><span>', '>', $post_pages );
	
	/* format current page */
	$post_pages = str_replace( '<span>', '<li class="active"><a href="javascript:;">', $post_pages );
	$post_pages = str_replace( '</span>', '</a></li>', $post_pages );
	
	return $post_pages;
}

/* 
Create tags list 
*/
function classifieds_tags_list(){
	$tags = get_the_tags();
	$tag_list = array();
	if( !empty( $tags ) ){
		foreach( $tags as $tag ){
			$tag_list[] = '<a href="'.esc_url( get_tag_link( $tag->term_id ) ).'">'.$tag->name.'</a>';
		}
	}
	return join( ', ', $tag_list );
}


/* 
Create categories list 
*/
function classifieds_categories_list(){
	$category_list = get_the_category();
	$categories = array();
	if( !empty( $category_list ) ){
		foreach( $category_list as $category ){
			$categories[] = '<a href="'.esc_url( get_category_link( $category->term_id ) ).'">'.$category->name.'</a>';
		}
	}
	
	return join( ', ', $categories );
}

/* 
Format pagination so it has correct style applied to it 
*/
function classifieds_format_pagination( $page_links ){
	global $classifieds_slugs;
	$list = '';
	if( !empty( $page_links ) ){
		foreach( $page_links as $page_link ){
			if( strpos( $page_link, 'page-numbers current' ) !== false ){
				$page_link = str_replace( "<span class='page-numbers current'>", '<a href="javascript:;">', $page_link );
				$page_link = str_replace( '</span>', '</a>', $page_link );
				$list .= '<li class="active">'.$page_link.'</li>';
			}
			else{
				$list .= '<li>'.$page_link.'</li>';
			}
			
		}
	}
	
	return $list;
}

/*
Generate random string
*/
function classifieds_random_string( $length = 10 ) {
	$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$random = '';
	for ($i = 0; $i < $length; $i++) {
		$random .= $characters[rand(0, strlen($characters) - 1)];
	}
	return $random;
}


/* 
Add the ... at the end of the excerpt 
*/
function classifieds_new_excerpt_more( $more ) {
	return '';
}
add_filter('excerpt_more', 'classifieds_new_excerpt_more');

/* 
Create options for the select box in the category icon select 
*/
function classifieds_icons_list( $value ){
	$icons_list = classifieds_awesome_icons_list();
	
	$select_data = '';
	
	foreach( $icons_list as $key => $label){
		$select_data .= '<option value="'.esc_attr__( $key ).'" '.( $value == $key ? 'selected="selected"' : '' ).'>'.$label.'</option>';
	}
	
	return $select_data;
}

/*
Submit contact form
*/
function classifieds_send_contact(){
	$errors = array();
	$name = isset( $_POST['name'] ) ? esc_sql( $_POST['name'] ) : '';
	$email = isset( $_POST['email'] ) ? esc_sql( $_POST['email'] ) : '';
	$message = isset( $_POST['message'] ) ? esc_sql( $_POST['message'] ) : '';
	if( isset( $_POST['captcha'] ) ){
		if( !empty( $name ) && !empty( $email ) && !empty( $message ) ){
			if( filter_var( $email, FILTER_VALIDATE_EMAIL ) ){
				$email_to = classifieds_get_option( 'contact_mail' );
				$subject = classifieds_get_option( 'contact_form_subject' );
				if( !empty( $email_to ) ){
					$message = "
						".esc_html__( 'Name: ', 'classifieds' )." {$name} \n
						".esc_html__( 'Email: ', 'classifieds' )." {$email} \n
						".esc_html__( 'Message: ', 'classifieds' )."\n {$message} \n
					";
					$info = @wp_mail( $email_to, $subject, $message );
					if( $info ){
						$message = '<div class="alert alert-danger">'.esc_html__( 'Your message was successfully submitted.', 'classifieds' ).'</div>';
					}
					else{
						$message = '<div class="alert alert-danger">'.esc_html__( 'Unexpected error while attempting to send e-mail.', 'classifieds' ).'</div>';
					}
				}
				else{
					$message = '<div class="alert alert-danger">'.esc_html__( 'Message is not send since the recepient email is not yet set.', 'classifieds' ).'</div>';
				}
			}
			else{
				$message = '<div class="alert alert-danger">'.esc_html__( 'Email is not valid.', 'classifieds' ).'</div>';
			}
		}
		else{
			$message = '<div class="alert alert-danger">'.esc_html__( 'All fields are required.', 'classifieds' ).'</div>';
		}
	}
	else{
		$message = '<div class="alert alert-danger">'.esc_html__( 'Captcha is wrong.', 'classifieds' ).'</div>';
	}

	echo json_encode(array(
		'message' => $message
	));
	die();
}
add_action('wp_ajax_contact', 'classifieds_send_contact');
add_action('wp_ajax_nopriv_contact', 'classifieds_send_contact');


/*
Send subscription values to mailchimp
*/
function classifieds_send_subscription(){
	if( isset( $_POST['captcha'] ) ){
	$email = !empty( $_POST["email"] ) ? $_POST["email"] : '';
	$response = array();	
	if( filter_var( $email, FILTER_VALIDATE_EMAIL ) ){
		require_once( classifieds_load_path( 'includes/mailchimp.php' ) );
		$chimp_api = classifieds_get_option("mail_chimp_api");
		$chimp_list_id = classifieds_get_option("mail_chimp_list_id");
		if( !empty( $chimp_api ) && !empty( $chimp_list_id ) ){
			$mc = new MailChimp( $chimp_api );
			$result = $mc->call('lists/subscribe', array(
				'id'                => $chimp_list_id,
				'email'             => array( 'email' => $email )
			));
			
			if( $result === false) {
				$message = '<div class="alert alert-danger">'.esc_html__( 'There was an error contacting the API, please try again.', 'classifieds' ).'</div>';
			}
			else if( isset($result['status']) && $result['status'] == 'error' ){
				$message = '<div class="alert alert-danger">'.json_encode($result).'</div>';
			}
			else{
				$message = '<div class="alert alert-success">'.esc_html__( 'You have successfully subscribed to the newsletter.', 'classifieds' ).'</div>';
			}
			
		}
		else{
			$message = '<div class="alert alert-danger">'.esc_html__( 'API data are not yet set.', 'classifieds' ).'</div>';
		}
	}
	else{
		$message = '<div class="alert alert-danger">'.esc_html__( 'Email is empty or invalid.', 'classifieds' ).'</div>';
	}
	}
	echo json_encode( array(
		'message' => $message
	) );
	die();
}
add_action('wp_ajax_subscribe', 'classifieds_send_subscription');
add_action('wp_ajax_nopriv_subscribe', 'classifieds_send_subscription');

/*
Extract avatar url from the img tag
*/
function classifieds_get_avatar_url( $get_avatar ){
    preg_match("/src='(.*?)'/i", $get_avatar, $matches);
	if( empty( $matches[1] ) ){
		preg_match("/src=\"(.*?)\"/i", $get_avatar, $matches);
	}
    return $matches[1];
}

/*
Add video container arround embeded videos
*/
function classifieds_embed_html( $html ) {
    return '<div class="video-container">' . $html . '</div>';
}
add_filter( 'embed_oembed_html', 'classifieds_embed_html', 10, 3 );
add_filter( 'video_embed_html', 'classifieds_embed_html' ); // Jetpack

/*
List comments
*/
function classifieds_comments( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	$add_below = ''; 
	?>
	<!-- comment-1 -->
	<div class="media <?php echo $depth > 1 ? esc_attr__( 'left-padding' ) : ''; ?>">
		<div class="comment-inner">
			<?php 
			$avatar = classifieds_get_avatar_url( get_avatar( $comment, 90 ) );
			if( !empty( $avatar ) ): ?>
				<a class="pull-left" href="javascript:;">
					<img src="<?php echo esc_url( $avatar ); ?>" class="media-object comment-avatar" title="" alt="">
				</a>
			<?php endif; ?>
			<div class="media-body comment-body">
				<div class="pull-left">
					<h4><?php comment_author(); ?></h4>
					<span><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) . esc_html__( ' ago', 'classifieds' ); ?></span>
				</div>
				<div class="pull-right">
					<?php
						comment_reply_link( 
							array_merge( 
								$args, 
								array( 
									'reply_text' => esc_html__( 'REPLY', 'classifieds' ), 
									'add_below' => $add_below, 
									'depth' => $depth, 
									'max_depth' => $args['max_depth'] 
								) 
							) 
						);
					?>
				</div>
				<div class="clearfix"></div>
				<?php 
				if ($comment->comment_approved != '0'){
				?>
					<p><?php echo get_comment_text(); ?></p>
				<?php 
				}
				else{ ?>
					<p><?php esc_html_e('Your comment is awaiting moderation.', 'classifieds'); ?></p>
				<?php
				}
				?>				
			</div>
		</div>
	</div>
	<!-- .comment-1 -->	
	<?php  
}

/*
Remove ending div on comments
*/
function classifieds_end_comments(){
	return "";
}

/*
Check if blog has media
*/
function classifieds_has_media(){
	$post_format = get_post_format();
	switch( $post_format ){
		case 'aside' : 
			return has_post_thumbnail() ? true : false; break;
			
		case 'audio' :
			$iframe_audio = get_post_meta( get_the_ID(), 'iframe_audio', true );
			if( !empty( $iframe_audio ) ){
				return true;
			}
			else if( has_post_thumbnail() ){
				return true;
			}
			else{
				return false;
			}
			break;
			
		case 'chat' : 
			return has_post_thumbnail() ? true : false; break;
		
		case 'gallery' :
			$post_meta = get_post_custom();
			$gallery_images = classifieds_smeta_images( 'gallery_images', get_the_ID(), array() );		
			if( !empty( $gallery_images ) ){
				return true;
			}
			else if( has_post_thumbnail() ){
				return true;
			}			
			else{
				return false;
			}
			break;
			
		case 'image':
			return has_post_thumbnail() ? true : false; break;
			
		case 'link' :
			$link = get_post_meta( get_the_ID(), 'link', true );
			if( !empty( $link ) ){
				return true;
			}
			else{
				return false;
			}
			break;
			
		case 'quote' :
			$blockquote = get_post_meta( get_the_ID(), 'blockquote', true );
			$cite = get_post_meta( get_the_ID(), 'cite', true );
			if( !empty( $blockquote ) || !empty( $cite ) ){
				return true;
			}
			else if( has_post_thumbnail() ){
				return true;
			}
			else{
				return false;
			}
			break;
		
		case 'status' :
			return has_post_thumbnail() ? true : false; break;
	
		case 'video' :
			$video = get_post_meta( get_the_ID(), 'video', true );
			if( !empty( $video ) ){
				return true;
			}
			else if( has_post_thumbnail() ){
				return true;
			}
			else{
				return false;
			}
			break;
			
		default: 
			$iframe_standard = get_post_meta( get_the_ID(), 'iframe_standard', true );
			if( !empty( $iframe_standard ) ){
				return true;
			}
			else if( has_post_thumbnail() ){
				return true;
			}
			else{
				return false;
			}
			break;
	}	
}

/*
Format price
*/
if( !function_exists('classifieds_format_price_number') ){
	function classifieds_format_price_number( $price ){
		if( !is_numeric( $price ) ){
			return $price;
		}
		$unit_position = classifieds_get_option( 'unit_position' );
		$unit = classifieds_get_option( 'unit' );

		if( $unit_position == 'front' ){
			return $unit.number_format( $price, 2 );
		}
		else{
			return number_format( $price, 2 ).$unit;
		}
	}
}

/*
Get price HTMl for the ad
*/
function classifieds_get_price( $post_id ){
	$ad_price = get_post_meta( $post_id, 'ad_price', true );
	$ad_call_for_price = get_post_meta( $post_id, 'ad_call_for_price', true );
	$ad_discounted_price = get_post_meta( $post_id, 'ad_discounted_price', true );

	if( $ad_call_for_price == '1' ){
		echo '<span class="call-price">'.esc_html__( 'Call For Info', 'classifieds' ).'</span>';
	}
	else if( empty( $ad_price ) ){
		echo '<span class="free-price">'.esc_html__( 'Free', 'classifieds' ).'</span>';
	}
	else{
		if( !empty( $ad_price ) ){
			$ad_price = classifieds_format_price_number( $ad_price );
		}
		
		if( !empty( $ad_discounted_price ) ){
			$ad_discounted_price = classifieds_format_price_number( $ad_discounted_price );
			echo  $ad_discounted_price;
			?>
			<span><?php echo  $ad_price; ?></span>
			<?php
		}
		else{
			echo  $ad_price;
		}
	}
}

/*
Get prcing shortcode boxes
*/
function classifieds_pricing_format( $price ){
	$price = number_format( $price, 2 );
	$unit_position = classifieds_get_option( 'unit_position' );
	$unit = classifieds_get_option( 'unit' );
	$price_el = explode('.', $price);
	$main_price = $price_el[0];
	$decimal_price = $price_el[1];
	if( $unit_position == 'back' ){
		$price_html = $main_price.'<span>.'.$decimal_price.'</span><span>'.$unit.'</span>';
	}
	else{
		$price_html = '<span>'.$unit.'</span>'.$main_price.'<span>.'.$decimal_price.'</span>';
	}

	return $price_html;
}

/* 
Custom login messages
*/
function classifieds_login_errors( $message ) {
	global $errors;
 	if( isset( $errors->errors['invalid_username'] ) ){
 		$message = esc_html__( 'Invalid username', 'classifieds' );
 	}
	else if ( isset( $errors->errors['incorrect_password'] ) ){
		$message = esc_html__( 'Invalid password', 'classifieds' );
	}

	return $message;	
}
add_filter( 'login_errors', 'classifieds_login_errors' );

/*
Parse video URLs
*/
function classifieds_parse_url( $url ){
	if( stripos( $url, 'youtube' ) ){
		$temp = explode( '?v=', $url );
		return 'https://www.youtube.com/embed/'.$temp[1];
	}
	else if( stripos( $url, 'vimeo' ) ){
		$temp = explode( 'vimeo.com/', $url );
		return '//player.vimeo.com/video/'.$temp[sizeof( $temp ) - 1];
	}
	else{
		return $url;
	}
}

/*
Create breadcrumbs
*/
function classifieds_get_breadcrumbs(){
	global $offer_type, $offer_cat, $location, $classifieds_slugs;
	$breadcrumb = '';
	if( function_exists( 'is_woocommerce' ) && is_woocommerce() ){
         return false;		
	}
	if( is_front_page() ){
		return '';
	}
	$breadcrumb .= '<ul class="breadcrumb">';
	if( is_home() ){
		$breadcrumb .= '<li><a href="'.home_url().'">'.esc_html__( 'Home', 'classifieds' ).'</a></li><li>'.esc_html__( 'Blog', 'classifieds' ).'</li>';
	}
	else{
		$blog_page = get_option( 'page_for_posts' );
		$blog_url = get_permalink( $blog_page );
		if( !is_home() ){
			$breadcrumb .= '<li><a href="'.home_url().'">'.esc_html__( 'Home', 'classifieds' ).'</a></li>';
		}	
		if( is_category() ){
			$breadcrumb .= '<li><a href="'.esc_url( $blog_url ).'">'.esc_html__( 'Blog', 'classifieds' ).'</a></li>';
			$breadcrumb .= '<li>'.single_cat_title( '', false ).'</li>';
		}
		else if( is_404() ){
			$breadcrumb .= '<li>'.esc_html__( '404 Page Doesn\'t exists', 'classifieds' ).'</li>';
		}
		else if( is_tag() ){
			$breadcrumb .= '<li><a href="'.esc_url( $blog_url ).'">'.esc_html__( 'Blog', 'classifieds' ).'</a></li>';
			$breadcrumb .= '<li>'.esc_html__('Search by tag: ', 'classifieds'). get_query_var('tag').'</li>';
		}
		else if( is_author() ){
			$breadcrumb .= '<li><a href="'.esc_url( $blog_url ).'">'.esc_html__( 'Blog', 'classifieds' ).'</a></li>';
			$breadcrumb .= '<li>'.esc_html__('Posts by ', 'classifieds').''.get_the_author_meta( 'display_name' ).'</li>';
		}
		else if( is_archive() ){
			$breadcrumb .= '<li><a href="'.esc_url( $blog_url ).'">'.esc_html__( 'Blog', 'classifieds' ).'</a></li>';
			$breadcrumb .= '<li>'.esc_html__('Archive for:', 'classifieds'). single_month_title( ' ', false ).'</li>';
		}
		else if( is_search() ){
			$breadcrumb .= '<li><a href="'.esc_url( $blog_url ).'">'.esc_html__( 'Blog', 'classifieds' ).'</a></li>';
			$breadcrumb .= '<li>'.esc_html__('Results for: ', 'classifieds').' '. get_search_query().'</li>';
		}
		else{
			if( is_singular( 'post' ) ){
				$breadcrumb .= '<li><a href="'.esc_url( $blog_url ).'">'.esc_html__( 'Blog', 'classifieds' ).'</a></li>';
			}
			else if( is_singular('ad') ){
				$terms = get_the_terms( get_the_ID(), 'ad-category');
				if( !empty( $terms ) ){
					$terms_organized = array();
					classifieds_sort_terms_hierarchicaly($terms, $terms_organized);
					$permalink = classifieds_get_permalink_by_tpl( 'page-tpl_search_page' );
					if( !empty( $terms_organized ) ){
						$cat = array_pop( $terms_organized );
						$breadcrumb .= '<li><a href="'.esc_url( add_query_arg( array( $classifieds_slugs['category'] => $cat->slug ), $permalink )  ).'">'.$cat->name.'</a></li>';
					}
				}
			}			
			$breadcrumb .= '<li>'.get_the_title().'</li>';
		}
	}
	$breadcrumb .= '</ul>';

	return $breadcrumb;
}


/*
Filter images by author
*/
add_filter( 'ajax_query_attachments_args', 'classifieds_filter_images', 10, 1 );
function classifieds_filter_images($query = array()) {
	$has_memebers_page = classifieds_get_permalink_by_tpl( 'page-tpl_my_profile' );
	if( $has_memebers_page !== 'javascript:;' ){
    	$query['author'] = get_current_user_id();
    }
    return $query;
}

/*
Redirect non administrators
*/
add_action( 'admin_init', 'classifieds_non_admin_users' );
function classifieds_non_admin_users() {
	$user_ID = get_current_user_id();
	$user_agent = get_user_meta( $user_ID, 'user_agent', true );
	if ( ! current_user_can( 'manage_options' ) && !stristr( $_SERVER['PHP_SELF'], 'admin-ajax.php' ) && !stristr( $_SERVER['PHP_SELF'], 'async-upload.php' ) && ( !$user_agent || $user_agent == 'no' )) {
		wp_redirect( home_url() );
		exit;
	}
}

/*
Append style of the shortcode
*/
function classifieds_shortcode_style( $style_css ){
 	$style_css = str_replace( '<style', '<style scoped', $style_css );
 	return $style_css;
}


/*
Rename permalink slugs
*/
global $classifieds_slugs;
$classifieds_slugs = array(
	'category' => 'category',
	'tag' => 'tag',
	'keyword' => 'keyword',
	'location' => 'location',
	'longitude' => 'longitude',
	'latitude' => 'latitude',
	'radius' => 'radius',
	'view' => 'view',
	'sortby' => 'sortby',
	'subpage' => 'subpage'
);


/*
populate slugs with translate values
*/
function classifieds_get_classifieds_slugs(){
	global $classifieds_slugs;
	foreach( $classifieds_slugs as &$slug ){
		$trans = classifieds_get_option( 'trans_'.$slug );
		if( !empty( $trans ) ){
			$slug = $trans;
		}
	}
}
add_action( 'init', 'classifieds_get_classifieds_slugs', 1, 0);


/* generate nicve permalink structure */
function classifieds_append_query_string( $permalink, $include = array(), $exclude = array( 'coupon' ) ){
	global $classifieds_slugs;
	global $wp;
	if ( !$permalink ){
		$permalink = get_permalink();
	}

	// Map endpoint to options
	if ( get_option( 'permalink_structure' ) ) {
		if ( strstr( $permalink, '?' ) ) {
			$query_string = '?' . parse_url( $permalink, PHP_URL_QUERY );
			$permalink    = current( explode( '?', $permalink ) );
		} else {
			$query_string = '';
		}

		$permalink = trailingslashit( $permalink );
		if( !empty( $include ) ){
			foreach( $include as $arg => $value ){
				$permalink .= $classifieds_slugs[$arg].'/'.$value.'/';
			}
		}
		foreach( $classifieds_slugs as $slug => $trans_slug ){
			if( isset( $wp->query_vars[$trans_slug] ) && !isset( $include[$slug] ) && !in_array( $slug, $exclude ) && !in_array( 'all', $exclude ) ){
				$permalink .= $trans_slug.'/'.$wp->query_vars[$trans_slug].'/';
			}
		}
		$permalink .= $query_string;
	} 
	else {
		if( !empty( $include ) ){
			foreach( $include as $arg => $value ){
				$permalink = esc_url( add_query_arg( array( $classifieds_slugs[$arg] => $value ), $permalink ) );
			}
		}
		foreach( $classifieds_slugs as $slug => $trans_slug ){
			if( isset( $wp->query_vars[$trans_slug] ) && !isset( $include[$slug] ) && !in_array( $slug, $exclude ) && !in_array( 'all', $exclude ) ){
				$permalink = esc_url( add_query_arg( array( $trans_slug => $wp->query_vars[$trans_slug] ), $permalink ) );
			}
		}		
		
	}	

	return $permalink;
}

/* 
Rewrite rules
*/
function classifieds_add_rewrite_rules() {
    global $wp_rewrite;
    global $classifieds_slugs;
    $new_rules = array();
    $custom_rules = array();
	for( $i=count( $classifieds_slugs ); $i>=1; $i-- ){
		$key = str_repeat( '('.join('|', $classifieds_slugs).')/(.+?)/', $i );

		$key_1 = '([^/]*)/'.$key.'(page)/(.+?)/?$';
		$key_2 = '([^/]*)/'.$key.'?$';
		$rewrite_to = 'index.php?pagename='.$wp_rewrite->preg_index( 1 );
		
		for( $k=2; $k<=($i*2)+1; $k+=2 ){
			$rewrite_to .= '&' . $wp_rewrite->preg_index( $k ) . '=' . $wp_rewrite->preg_index( $k+1 );
		}

		$custom_rules[$key_1] = $rewrite_to.'&paged='.$wp_rewrite->preg_index( $k+1 );
		$custom_rules[$key_2] = $rewrite_to;

	}

    $wp_rewrite->rules = $custom_rules + $wp_rewrite->rules ;
}
add_action( 'generate_rewrite_rules', 'classifieds_add_rewrite_rules' );

/*
Register  user
*/
function classifieds_register(){
	$username = isset( $_POST['register-username'] ) ? esc_sql( $_POST['register-username'] ) : '';
	$password = isset( $_POST['register-password'] ) ? esc_sql( $_POST['register-password'] ) : '';
	$repeat_password = isset( $_POST['register-password-repeat'] ) ? esc_sql( $_POST['register-password-repeat'] ) : '';
	$email = isset( $_POST['register-email'] ) ? esc_sql( $_POST['register-email'] ) : '';
	$message = '';

    if( isset( $_POST['captcha'] ) ){
        if( !empty( $email ) && !empty( $username ) && !empty( $password ) && !empty( $repeat_password ) ){
            if( filter_var($email, FILTER_VALIDATE_EMAIL) ){
                if( $password ==  $repeat_password ){
                    if( !username_exists( $username ) ){
                        if( !email_exists( $email ) ){
                            $user_id = wp_insert_user(array(
                                'user_login'  => $username,
                                'user_pass'   => $password,
                                'user_email'  => $email
                            ));
                            if( !is_wp_error($user_id) ) {
                                wp_update_user(array(
                                    'ID' => $user_id,
                                    'role' => 'editor'
                                ));
                                $confirmation_hash = classifieds_confirm_hash();
                                update_user_meta( $user_id, 'user_active_status', 'inactive' );
                                update_user_meta( $user_id, 'confirmation_hash', $confirmation_hash );

                                $confirmation_message = classifieds_get_option( 'registration_message' );
                                $confirmation_link = home_url('/');
                                $confirmation_link = add_query_arg( array( 'username' => $username, 'confirmation_hash' => $confirmation_hash ), $confirmation_link );
                                
                                $confirmation_message = str_replace( '%LINK%', $confirmation_link, $confirmation_message );

                                $registration_subject = classifieds_get_option( 'registration_subject' );

                                $email_sender = classifieds_get_option( 'email_sender' );
                                $name_sender = classifieds_get_option( 'name_sender' );
                                $headers   = array();
                                $headers[] = "MIME-Version: 1.0";
                                $headers[] = "Content-Type: text/html; charset=UTF-8"; 
                                $headers[] = "From: ".$name_sender." <".$email_sender.">";

                                $info = wp_mail( $email, $registration_subject, $confirmation_message, $headers );
                                if( $info ){
                                    $message = '<div class="alert alert-success">'.esc_html__( 'Thank you for registering, an email to confirm your email address is sent to your inbox.', 'classifieds' ).'</div>';
                                }
                                else{
                                    $message = '<div class="alert alert-danger">'.esc_html__( 'There was an error trying to send an email', 'classifieds' ).'</div>';  
                                }
                            }
                            else{
                                $message = '<div class="alert alert-danger">'.esc_html__( 'There was an error while trying to register you', 'classifieds' ).'</div>';
                            }
                        }
                        else{
                            $message = '<div class="alert alert-danger">'.esc_html__( 'Email is already registered', 'classifieds' ).'</div>';
                        }
                    }
                    else{
                        $message = '<div class="alert alert-danger">'.esc_html__( 'Username is already registered', 'classifieds' ).'</div>';
                    }
                }
                else{
                    $message = '<div class="alert alert-danger">'.esc_html__( 'Provided passwords do not match', 'classifieds' ).'</div>';    
                }
            }
            else{
                $message = '<div class="alert alert-danger">'.esc_html__( 'Email address is invalid', 'classifieds' ).'</div>';
            }
        }
        else{
            $message = '<div class="alert alert-danger">'.esc_html__( 'All fields are required', 'classifieds' ).'</div>';
        }
    }
    else{
        $message = '<div class="alert alert-danger">'.esc_html__( 'Captcha is wrong', 'classifieds' ).'</div>';
    }

    $response = array(
		'message' => $message,
	);

	if( !empty( $url ) ){
		$response['url'] = $url;
	}

	echo json_encode( $response );
	die();
}
add_action('wp_ajax_register', 'classifieds_register');
add_action('wp_ajax_nopriv_register', 'classifieds_register');

/*
Login user
*/
function classifieds_login(){
	$username = isset( $_POST['login-username'] ) ? esc_sql( $_POST['login-username'] ) : '';
	$password = isset( $_POST['login-password'] ) ? esc_sql( $_POST['login-password'] ) : '';
	$remember = isset( $_POST['login-remember'] ) ? true : false;
	$message = '';

    if( isset( $_POST['captcha'] ) ){
        $user = get_user_by( 'login', $username );
        if( $user ){
            $is_active = get_user_meta( $user->ID, 'user_active_status', true );
            if( empty( $is_active ) || $is_active == 'active' ){
                $user = wp_signon( array(
                    'user_login' => $username,
                    'user_password' => $password,
                    'remember' => isset( $_POST['remember_me'] ) ? true : false
                ), is_ssl() );
                if ( is_wp_error($user) ){
                    switch( $user->get_error_code() ){
                        case 'invalid_username': 
                            $message = esc_html__( 'Invalid username', 'classifieds' ); 
                            break;
                        case 'incorrect_password':
                            $message = esc_html__( 'Invalid password', 'classifieds' ); 
                            break;                    
                    }
                    $message = '<div class="alert alert-danger">'.$message.'</div>';
                }
                else{
                	$message = '<div class="alert alert-success">'.esc_html__( 'You have been logged in.', 'classifieds' ).'</div>';
                	if( !empty( $_POST['redirect'] ) ){
                		$url = $_POST['redirect'];
                	}
                	else{
                		$url = home_url('/');
                	}
                }
            }
            else{
                $message = '<div class="alert alert-danger">'.esc_html__( 'Your account is not activated. Check you mail for the activation link.', 'classifieds' ).'</div>';
            }
        }
        else{
            $message = '<div class="alert alert-danger">'.esc_html__( 'Invalid username', 'classifieds' ).'</div>';
        }
    }
    else{
        $message = '<div class="alert alert-danger">'.esc_html__( 'Captcha is wrong', 'classifieds' ).'</div>';
    }

    $response = array(
		'message' => $message,
	);

	if( !empty( $url ) ){
		$response['url'] = $url;
	}

	echo json_encode( $response );
	die();
}
add_action('wp_ajax_login', 'classifieds_login');
add_action('wp_ajax_nopriv_login', 'classifieds_login');



/*
Recover password
*/
function classifieds_recover_password(){
	if( isset( $_POST['captcha'] ) ){
		$email = !empty( $_POST["recover-email"] ) ? $_POST["recover-email"] : '';
		$response = array();	
		if( filter_var( $email, FILTER_VALIDATE_EMAIL ) ){
	        if( email_exists( $email ) ){
	            $lost_password_message = classifieds_get_option( 'lost_password_message' );
	            $lost_password_subject = classifieds_get_option( 'lost_password_subject' );
	            	
	            $user = get_user_by( 'email', $email );

	            $new_password = classifieds_random_string( 5 );
	            $update_fields = array(
	                'ID'            => $user->ID,
	                'user_pass'     => $new_password,
	            );          

	            $update_id = wp_update_user( $update_fields );                      

	            $lost_password_message = str_replace( '%USERNAME%', $user->user_login, $lost_password_message );
	            $lost_password_message = str_replace( '%PASSWORD%', $new_password, $lost_password_message );

	            $registration_subject = classifieds_get_option( 'registration_subject' );

	            $email_sender = classifieds_get_option( 'email_sender' );
	            $name_sender = classifieds_get_option( 'name_sender' );
	            $headers   = array();
	            $headers[] = "MIME-Version: 1.0";
	            $headers[] = "Content-Type: text/html; charset=UTF-8"; 
	            $headers[] = "From: ".$name_sender." <".$email_sender.">";

	            $info = wp_mail( $email, $lost_password_subject, $lost_password_message, $headers );
	            if( $info ){
	                $message = '<div class="alert alert-success">'.esc_html__( 'Email with new password has been sent to your email address.', 'classifieds' ).'</div>';
	            }
	            else{
	                $message = '<div class="alert alert-danger">'.esc_html__( 'There was an error trying to send an email', 'classifieds' ).'</div>';  
	            }
	        }
	        else{
	            $message = '<div class="alert alert-danger">'.esc_html__( 'This email is not registered', 'classifieds' ).'</div>';
	        }
		}
		else{
			$message = '<div class="alert alert-danger">'.esc_html__( 'Email is empty or invalid.', 'classifieds' ).'</div>';
		}
	}
	else{
		$message = '<div class="alert alert-danger">'.esc_html__( 'Captcha is wrong', 'classifieds' ).'</div>';
	}
	echo json_encode( array(
		'message' => $message
	) );
	die();
}
add_action('wp_ajax_recover', 'classifieds_recover_password');
add_action('wp_ajax_nopriv_recover', 'classifieds_recover_password');

/*

Allow bigger SQL
*/
function classifieds_safe_sql(){
	global $wpdb;
	$wpdb->query( 'SET SESSION SQL_BIG_SELECTS=1' );
}
add_action( 'init', 'classifieds_safe_sql' );

/*
Set taxonomy terms by hierarchy
*/
function classifieds_sort_terms_hierarchicaly(Array &$cats, Array &$into, $parentId = 0){
    foreach ($cats as $i => $cat) {
        if ($cat->parent == $parentId) {
            $into[$cat->term_id] = $cat;
            unset($cats[$i]);
        }
    }
	foreach ($into as $topCat) {
        $topCat->children = array();
    	classifieds_sort_terms_hierarchicaly($cats, $topCat->children, $topCat->term_id);
	}
}

/*
Create select box for the taxonomy
*/
function classifieds_get_taxonomy_select_search( $taxonomy, $selected, $field = "slug" ){
	$list = '';
	$terms = get_terms( $taxonomy, array( 'hide_empty' => false ) );
	$terms_organized = array();
	classifieds_sort_terms_hierarchicaly($terms, $terms_organized);
	$terms =  (array) $terms_organized;	
	$list = '';
	if( !empty( $terms ) ){
		$list = classifieds_get_taxonomy_search_tree( $terms, $selected, $field );
	}

	echo  $list;
}

/*
Create radius options
*/
function classifieds_get_radius_options( $selected, $unit ){
	$radius_options = classifieds_get_option( 'radius_options' );
	$radius_options = explode( "\n", $radius_options );
	if( !empty( $radius_options ) ){
		foreach( $radius_options as $radius ){
			if( !empty( $radius ) ){
				$radius = trim( $radius );
				echo '<option value="'.esc_attr__( $radius ).'" '.( $radius == $selected ? 'selected="selected"' : '' ).'>'.$radius.''.$unit.'</option>';
			}
		}
	}
}

/*
Get option tags for the select in the function before
*/
function classifieds_get_taxonomy_search_tree( $terms, $selected, $field, $depth = 0 ){
	$list = '';
	foreach( $terms as $term ){
		$list .= '<option value="'.$term->$field.'" '.( $selected == $term->$field ? 'selected="selected"' : '' ).' '.( $depth > 0 ? 'class="subitem"' : '' ).'>'.str_repeat( '&nbsp;&nbsp;', $depth ).' '.$term->name.'</option>';
		if( !empty( $term->children ) ){
			$list .= classifieds_get_taxonomy_search_tree( $term->children, $selected, $field, $depth+1 );
		}
	}
	return $list;
}

/*
Get last category from the list of categories
*/
function classifieds_get_last_category( $cats ){
	$last = array_pop( $cats );
	if( !empty( $last->children ) ){
		$last = classifieds_get_last_category( $last->children );
	}
	
	return $last;
}

/*
Display additional details of the ad on the frontend
*/
function classifieds_list_details_find_value( $field, $value ){
	$html = '';
	$values = explode( "\n", $field->field_values );
	if( !empty( $values ) ){
		foreach( $values as $value_item ){
			if( !empty( $value_item ) ){
				$temp = explode( '|', $value_item );
				if( $temp[0] == $value ){
					$html = '<dt>'.$field->label.'</dt><dd>'.$temp[1].'</dd>';
				}
			}
		}
	}

	return $html;
}

/*
Display additional details of the ad on the frontend
*/
function classifieds_list_details( $post_id = '' ){

	global $wpdb;
	if( empty( $post_id ) ){
		$post_id = get_the_ID();
	}

	$cats = wp_get_object_terms( $post_id, 'ad-category' );
	$list = '';

	if( !empty( $cats ) ){

		$terms_organized = array();
		classifieds_sort_terms_hierarchicaly( $cats, $terms_organized );

		$cat = classifieds_get_last_category( $terms_organized );
		if( empty( $cat ) ){
			$cat = array_pop( $cats );
		}		

		$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->postmeta} WHERE meta_key = 'fields_for' AND meta_value LIKE %s", '%"'.$cat->slug.'%' ) );

		if( !empty( $results ) ){
			$list = '<div class="ad-details clearfix"><h3><i class="fa fa-marker"></i>'.esc_html__( 'Details', 'classifieds' ).'</h3><dl class="list-2-col">';
			$list_array = array();

			$fields = classifieds_get_custom_fields( $results[0]->post_id );

			if( !empty( $fields ) ){
				foreach( $fields as $field ){

					$value = classifieds_get_post_meta( $post_id, $field->name );
					
					if( !empty( $value ) ){
						if( $field->type == 'select' ){
							$list_array[] = classifieds_list_details_find_value( $field, $value );
							$subfields = classifieds_get_custom_subfields( $results[0]->post_id, $field->field_id );
							if( !empty( $subfields ) ){
								foreach( $subfields as $subfield ){
									$value = classifieds_get_post_meta( $post_id, $subfield->name );
									if( !empty( $value ) ){
										$list_array[] = classifieds_list_details_find_value( $subfield, $value );
									}
								}
							}
						}
						else{
							$list_array[] = '<dt>'.$field->label.'</dt><dd>'.str_replace( "|", ", ", $value ).'</dd>';
						}
					}

				}
			}

			$values_in_col = ceil( sizeof( $list_array ) / 2 );
			for( $i=0; $i<sizeof( $list_array ); $i++ ){
				$list .= $list_array[$i];
			}

			$list .= '</dl></div>';

			if( empty( $list_array ) ){
				$list = '';
			}
		}

	}

	echo  $list;
}


/*
Filter ads by radius
*/
function classifieds_filter_posts_fields( $fields ) {
	global $wpdb, $classifieds_slugs;
	$longitude = isset( $_GET[$classifieds_slugs['longitude']] ) ? $_GET[$classifieds_slugs['longitude']] : 0;
	$latitude = isset( $_GET[$classifieds_slugs['latitude']] ) ? $_GET[$classifieds_slugs['latitude']] : 0;
	if( !empty( $longitude ) && !empty( $latitude ) ){
		$fields .= ", ( 6371000 *
				acos( 
					cos( radians( {$latitude} ) ) * cos( radians( postmeta_lat.meta_value ) ) *
					cos( radians( postmeta_long.meta_value ) - radians( {$longitude} ) ) +
					sin( radians( {$latitude} ) ) * sin( radians( postmeta_lat.meta_value ) )
				) 
		) AS distance";
	}
	return $fields;
}

/*
Add having test for the radius
*/
function classifieds_having_radius( $groupby ){
	global $wpdb, $classifieds_slugs;
    $groupby = " {$wpdb->posts}.ID ";
    $radius = isset( $_GET[$classifieds_slugs['radius']] ) ? esc_sql( $_GET[$classifieds_slugs['radius']] ) : 0;
    
    $radius_search_units = classifieds_get_option( 'radius_search_units' );
    if( $radius_search_units == 'km' ){
    	$radius = $radius * 1000;
    }
    else{
    	$radius = $radius * 1609.34;
    }

	$groupby .= " HAVING distance < ".$radius." ";

	return $groupby;
}

/*
Join additional fields
*/
function classifieds_join_radius( $join ){
	global $wpdb;
	$join .= "LEFT JOIN {$wpdb->prefix}postmeta AS postmeta_long ON $wpdb->posts.ID = postmeta_long.post_id ";
	$join .= "LEFT JOIN {$wpdb->prefix}postmeta AS postmeta_lat ON $wpdb->posts.ID = postmeta_lat.post_id ";
	return $join;
}

/*
Join additional fields for custom fields
*/
function classifieds_join_custom_fields( $join ){
	global $wpdb;
	$counter = 1;
	foreach( $_GET as $key => $value ){
	    $custom_meta_key = substr( $key, 0, 3 );
	    if( $custom_meta_key == 'cf_' ){
			$join .= "LEFT JOIN {$wpdb->prefix}custom_fields_meta AS cf{$counter} ON $wpdb->posts.ID = cf{$counter}.post_id ";
	        $counter++;
	    }
	}
	return $join;
}

/*
Additional WHERE
*/
function classifieds_where( $where ){
	$where .= " AND postmeta_long.meta_key = 'ad_gmap_longitude' AND postmeta_lat.meta_key = 'ad_gmap_latitude'";
	return $where;
}

/*
Additional WHERE for custom fields
*/
function classifieds_where_custom_fields( $where ){
	global $wpdb;
	$counter = 1;
	foreach( $_GET as $key => $value ){
	    $custom_meta_key = substr( $key, 0, 3 );
	    if( $custom_meta_key == 'cf_' ){
	    	$custom_meta_key = str_replace( 'cf_', '', $key );
	    	$where .= ' AND ';
	    	$values = explode( ',', $value );
	    	if( sizeof( $values ) > 0 ){
	    		$where .= '( ';
	    		$value_array = array();
	    			foreach( $values as $value ){
	    				$value_array[] = $wpdb->prepare( "cf{$counter}.name = %s AND cf{$counter}.val = %s", $custom_meta_key, $value );
	    			}
	    		$where .= join( ' OR ', $value_array );
	    		$where .= ' ) ';
	    	}
	    	else{
	    		$where .= $wpdb->prepare( "cf{$counter}.name = %s AND cf{$counter}.val = %s ", $custom_meta_key, $values );
	    	}
			
	        $counter++;
	    }
	}	
	return $where;
}

/*
Get ad info for the google marker
*/
function classifieds_generate_marker_info( $args, $check_cache = false ){
	//delete_transient( 'classifieds_home_markers' );
    if( $check_cache && get_transient( 'classifieds_home_markers' ) ){
    	echo get_transient( 'classifieds_home_markers' );
    }
    else{
    	global $wpdb;

	    $markers_html = '<div class="markers hidden">';
	    $home_map_ads = classifieds_get_option( 'home_map_ads' );
	    $home_map_ads_source = classifieds_get_option( 'home_map_ads_source' );
    	$counter = 1;
    	$has_rows = true;
    	while( $has_rows ){

    		$limit = 500;
    		if( !empty( $home_map_ads ) ){
    			$limit = min( 500, $home_map_ads );
    		}
    		$offset = ( $counter - 1 ) * $limit;

	    	$markers = $wpdb->get_results(
	    		$wpdb->prepare(
	    			"SELECT postmeta1.meta_value AS longitude, postmeta2.meta_value AS latitude, post_title, ID, post_author FROM {$wpdb->posts} AS posts 
	    			LEFT JOIN {$wpdb->postmeta} AS postmeta1 ON posts.ID = postmeta1.post_id 
	    			LEFT JOIN {$wpdb->postmeta} AS postmeta2 ON postmeta2.post_id = postmeta1.post_id 
	    			LEFT JOIN {$wpdb->postmeta} AS postmeta3 ON postmeta3.post_id = postmeta2.post_id 
	    			LEFT JOIN {$wpdb->postmeta} AS postmeta4 ON postmeta4.post_id = postmeta3.post_id 
	    			".( $home_map_ads_source !== 'all' ? " LEFT JOIN {$wpdb->postmeta} AS postmeta5 ON postmeta5.post_id = postmeta4.post_id " : '' )." 
	    			WHERE post_type = 'ad' AND postmeta1.meta_key = 'ad_gmap_longitude' AND postmeta2.meta_key = 'ad_gmap_latitude' AND 
	    			postmeta3.meta_key = 'ad_expire' AND postmeta3.meta_value > %d AND 
	    			postmeta4.meta_key = 'ad_visibility' AND postmeta4.meta_value = 'yes' 
	    			".( $home_map_ads_source !== 'all' ? " AND postmeta5.meta_key = 'ad_featured' AND postmeta5.meta_value = '".( esc_sql( $home_map_ads_source ) )."' " : '' )." 
	    			".( !empty( $args ) ? ' AND posts.ID IN ( '.join( $args, ',' ).' ) ' : '' )." 
	    			GROUP BY posts.ID LIMIT %d OFFSET %d",
	    			current_time( 'timestamp' ),
	    			$limit,
	    			$offset
	    		)
	    	);

	    	if( !empty( $markers ) ){
	    		$home_map_show_price = classifieds_get_option( 'home_map_show_price' );
	    		foreach( $markers as $marker ){
		            $ad_gmap_longitude = $marker->longitude;
		            $ad_gmap_latitude = $marker->latitude;
		            $permalink = get_permalink( $marker->ID );
		            $title = $marker->post_title;
		            if( strlen( $title > 37 ) ){
		            	$title = substr( $title, 0, 37 ).'...';
		            }
		            if( !empty( $ad_gmap_longitude ) && !empty( $ad_gmap_latitude ) ){
		            	
		            	$icon = '';
		            	$icon = classifieds_get_cat_icon( $marker->ID );
		            	$phone_number = get_post_meta( $marker->ID, 'ad_phone', true );
		            	if( empty( $phone_number ) ){
		            		$phone_number = get_user_meta( $marker->post_author, 'phone_number', true );
		            	}

		            	$markers_html .= '<div class="marker" data-longitude="'.esc_attr__( $ad_gmap_longitude ).'" data-latitude="'.esc_attr__( $ad_gmap_latitude ).'" data-marker-icon="'.esc_attr__( $icon ).'">';
		            		
		            	$info_price = '';
		            	if( $home_map_show_price == 'yes' ){
			            	ob_start();
			            	classifieds_get_price( $marker->ID );		            	
			            	$info_price = '
		            				<div class="info-price">
					                    <div class="price-block">
					                        <div class="ad-pricing">
		            							'.ob_get_contents().'
		            						</div>
		            					</div>
		            				</div>
			            	';
			            	ob_end_clean();
		            	}
		            		$markers_html .= htmlspecialchars('
		            			<div class="info-window clearfix">
		            			'.$info_price.'
	            					<div class="info-image">
	            						<a href="'.esc_url( $permalink ).'" target="_blank">
		            						'.get_the_post_thumbnail( $marker->ID, 'classifieds-map' ).'
	            						</a>
	            					</div>
	            					<div class="info-details">
	            						<a href="'.esc_url( $permalink ).'" target="_blank">'.$title.'</a>
	            						'.( !empty( $phone_number ) ? '<p><i class="fa fa-phone"></i> '.classifieds_format_phones( $phone_number ).'</p>' : '' ).'
	            					</div>
		            			</div>');
		            	$markers_html .= '</div>';
		            }
	    		}
	    	}
	    	else{
	    		$has_rows = false;
	    	}

	    	if( !empty( $home_map_ads ) && ( $counter * $limit ) >= $home_map_ads ){
	    		$has_rows = false;
	    	}

	    	$counter++;

    	}
	    $markers_html .= '</div>';

	    if( $check_cache ){
	    	$home_map_cache_interval = classifieds_get_option( 'home_map_cache_interval' );
	    	set_transient( 'classifieds_home_markers', $markers_html, 60*60*$home_map_cache_interval );
	    }

	    echo  $markers_html;
    }
}

/*
Count ads by the user
*/
function classifieds_count_ads_by_user( $user_id ){
	return count_user_posts( $user_id , 'ad' );
}

/*
* User total Give Away items
*/
function classified_user_total_giveaways($user_id)
{
	$args = array(
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'post_type' => 'ad',
		'author'	=> $user_id,
		'meta_query' => array(
			array(
				'key' => 'ad_price',
				'value' => 'GIVE',
			),				
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

	$ads = new WP_Query($args);
	return $ads->post_count;
}

/*
* User total Requests items
*/
function classified_user_total_requests($user_id)
{
	$args = array(
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'post_type' => 'ad',
		'author'	=> $user_id,
		'meta_query' => array(
			array(
				'key' => 'ad_price',
				'value' => 'REQUEST',
			),				
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

	$ads = new WP_Query($args);
	return $ads->post_count;	
}


/*
Make user verified
*/
function classifieds_make_user_verified( $user_id ){
	$ads_for_verified = classifieds_get_option( 'ads_for_verified' );
	if( !empty( $ads_for_verified ) ){
		if( classifieds_count_ads_by_user( $user_id ) >= $ads_for_verified ){
			update_user_meta( $user_id, 'is_verified', 'yes' );
		}
	}
}

/*
Check if user is verified
*/
function classifieds_is_verified( $user_id ){
	$is_verified = get_user_meta( $user_id, 'is_verified', true );
	if( $is_verified == 'yes' ){
		return true;
	}
	else{
		return false;
	}
}

/*
Check if the Ad is for Give Aways or for Requests
*/
function classifieds_get_type_badge( $post_id ){
	$ad_price = get_post_meta( $post_id, 'ad_price', true );
	if( $ad_price == 'GIVE' )
	{
		echo '<i class="fa fa-gift verified" title="'.esc_attr__( 'Give Aways', 'classifieds' ).'"></i>';
	} else {
		echo '<i class="fa fa-heart featured" title="'.esc_attr__( 'Requests', 'classifieds' ).'"></i>';
	}
}

/*
Get verified badge
*/
function classifieds_get_verified_badge( $user_id ){
	if( classifieds_is_verified( $user_id ) ){
		echo '<i class="fa fa-check verified" title="'.esc_attr__( 'Verified User', 'classifieds' ).'"></i>';
	}
}

/*
Get featured badge
*/
function classifieds_get_featured_badge( $post_id ){
	$ad_featured = get_post_meta( $post_id, 'ad_featured', true );
	if( $ad_featured == 'yes' ){
		echo '<i class="fa fa-star featured" title="'.esc_attr__( 'Featured Ad', 'classifieds' ).'"></i>';
	}
}

/*
Format user phones
*/
function classifieds_format_phones( $phone ){
	if( !empty( $phone ) ){
		$last_3 = substr( $phone, -3);
		$phone = substr_replace( $phone, 'XXX', -3 );

		return '<a href="javascript:;" data-last="'.esc_attr__( $last_3 ).'" class="phone-reveal" title="'.esc_html__( 'Click to reveal number', 'classifieds' ).'">'.$phone.'</a>';
	}
}

/*
Submit ask question form
*/
function classifieds_ask_question(){
	$name = isset( $_POST['name'] ) ? $_POST['name'] : '';
	$email = isset( $_POST['email'] ) ? $_POST['email'] : '';
	$message = isset( $_POST['message'] ) ? $_POST['message'] : '';
	$ad_id = isset( $_POST['ad_id'] ) ? esc_sql( $_POST['ad_id'] ) : '';

    if( isset( $_POST['captcha'] ) ){

    	if( !empty( $name ) && !empty( $email ) && !empty( $message ) ){
    		if( filter_var( $email, FILTER_VALIDATE_EMAIL ) ){
    			$ad = get_post( $ad_id );
    			if( !empty( $ad ) ){
    				$user_data = get_userdata( $ad->post_author );
					$headers[] = 'From: '.$name.' <'.$email.'>';
					$headers[] = 'Reply-To: '.$name.' <'.$email.'>';
					$subject = esc_html__( 'Question About - ', 'classifieds' ).$ad->post_title;
					$message = preg_replace( "!\r?\n!", "\n", $message);
    				$message = $message."\n\n".esc_html__( '--------', 'classifieds' )."\n\n".esc_html__( 'This message is sent using as question form on ', 'classifieds' ).get_bloginfo( 'name' ).esc_html__(' site. You can reply on this message directly.', 'classifieds');
    				$info = @wp_mail( $user_data->user_email, $subject, $message, $headers );
    				if( $info ){
    					$message = '<div class="alert alert-success">'.esc_html__( 'Your question is sent.', 'classifieds' ).'</div>';
    				}
    				else{
    					$message = '<div class="alert alert-danger">'.esc_html__( 'Unable to send the question. Try again..', 'classifieds' ).'</div>';
    				}
    			}
    			else{
    				$message = '<div class="alert alert-danger">'.esc_html__( 'Ad is invalid.', 'classifieds' ).'</div>';
    			}
    		}
    		else{
				$message = '<div class="alert alert-danger">'.esc_html__( 'Email is invalid.', 'classifieds' ).'</div>';
    		}
    	}
    	else{
    		$message = '<div class="alert alert-danger">'.esc_html__( 'All fields are required.', 'classifieds' ).'</div>';
    	}
    }
    else{
        $message = '<div class="alert alert-danger">'.esc_html__( 'Captcha is wrong', 'classifieds' ).'</div>';
    }

    $response = array(
		'message' => $message,
	);

	echo json_encode( $response );
	die();
}
add_action('wp_ajax_ask_question', 'classifieds_ask_question');
add_action('wp_ajax_nopriv_ask_question', 'classifieds_ask_question');

/*
Submit report form
*/
function classifieds_report(){
	$name = isset( $_POST['name'] ) ? $_POST['name'] : '';
	$email = isset( $_POST['email'] ) ? $_POST['email'] : '';
	$message = isset( $_POST['message'] ) ? $_POST['message'] : '';
	$ad_id = isset( $_POST['ad_id'] ) ? esc_sql( $_POST['ad_id'] ) : '';

    if( isset( $_POST['captcha'] ) ){

    	if( !empty( $name ) && !empty( $email ) && !empty( $message ) ){
    		if( filter_var( $email, FILTER_VALIDATE_EMAIL ) ){
    			$ad = get_post( $ad_id );
    			if( !empty( $ad ) ){
                    $headers   = array();
                    $headers[] = "MIME-Version: 1.0";
                    $headers[] = "Content-Type: text/html; charset=UTF-8"; 
                    $subject = esc_html__( 'Report Ad - ', 'classifieds' ).$ad->post_title;

                    $message = preg_replace( "!\r?\n!", "<br />", $message);
    				$message = $message."<br /><br />".esc_html__( '--------', 'classifieds' )."<br /><br />".esc_html__( 'Reporting Ad: ', 'classifieds'). '<a href="'.get_permalink( $ad_id ).'" target="_blank">'.get_the_title( $ad_id ).'</a> '.esc_html__( 'by', 'classifieds' ).' '.$name.' ('.$email.')';

    				$new_offer_email = classifieds_get_option( 'new_offer_email' );

    				$info = @wp_mail( $new_offer_email, $subject, $message, $headers );
    				if( $info ){
    					$message = '<div class="alert alert-success">'.esc_html__( 'Report is sent.', 'classifieds' ).'</div>';
    				}
    				else{
    					$message = '<div class="alert alert-danger">'.esc_html__( 'Unable to send the report. Try again.', 'classifieds' ).'</div>';
    				}
    			}
    			else{
    				$message = '<div class="alert alert-danger">'.esc_html__( 'Ad is invalid.', 'classifieds' ).'</div>';
    			}
    		}
    		else{
				$message = '<div class="alert alert-danger">'.esc_html__( 'Email is invalid.', 'classifieds' ).'</div>';
    		}
    	}
    	else{
    		$message = '<div class="alert alert-danger">'.esc_html__( 'All fields are required.', 'classifieds' ).'</div>';
    	}
    }
    else{
        $message = '<div class="alert alert-danger">'.esc_html__( 'Captcha is wrong', 'classifieds' ).'</div>';
    }

    $response = array(
		'message' => $message,
	);

	echo json_encode( $response );
	die();
}
add_action('wp_ajax_report', 'classifieds_report');
add_action('wp_ajax_nopriv_report', 'classifieds_report');

/*
Get icon of the category
*/
function classifieds_get_cat_icon( $post_id = '' ){
	if( empty( $post_id ) ){
		$post_id = get_the_ID();
	}
	$cats = wp_get_post_terms( $post_id, 'ad-category' );
	if( !empty( $cats ) ){
		foreach( $cats as $cat ){
			if( $cat->parent == 0 ){
				$term_meta = get_option('taxonomy_'.$cat->slug);
				$icon = isset( $term_meta['category_marker'] ) ? $term_meta['category_marker'] : '';
				if( !empty( $icon ) ){
	            	if( !empty( $icon ) ){
	            		$icon_data = wp_get_attachment_image_src( $icon, 'full' );
	            		$icon = $icon_data[0];
	            	}					
					return $icon;
				}
			}
		}
	}	
}

/*
Get amount for the submit of the ad.
*/
function classifieds_ad_payment_amount( $post_id ){
	$ad_featured = get_post_meta( $post_id, 'ad_featured', true );
	$basic_ad_price = classifieds_get_option( 'basic_ad_price' );
	$featured_ad_price = classifieds_get_option( 'featured_ad_price' );

	$amount = 0;

	if( !empty( $basic_ad_price ) ){
		$amount += $basic_ad_price;
	}

	if( !empty( $featured_ad_price ) && $ad_featured == 'yes' ){
		$amount += $featured_ad_price;	
	}

	return $amount;
}

/*
Save changes of the ad.
*/
function classifieds_update_ad(){
	$ad_terms_text = classifieds_get_option( 'ad_terms' );
	if( empty( $ad_terms_text ) ){
		$_POST['ad_terms'] = 1;
	}

	$is_expired = !empty( $_POST['is_expired'] ) ? true : false;
	$ad_title = !empty( $_POST['ad_title'] ) ? $_POST['ad_title'] : '';
	$featured_image = !empty( $_POST['featured_image'] ) ? $_POST['featured_image'] : '';
	$ad_description = !empty( $_POST['ad_description'] ) ? $_POST['ad_description'] : '';
	$ad_tags = !empty( $_POST['ad_tags'] ) ? $_POST['ad_tags'] : '';
	$ad_price = !empty( $_POST['ad_price'] ) ? $_POST['ad_price'] : '';
	$ad_phone = !empty( $_POST['ad_phone'] ) ? $_POST['ad_phone'] : '';
	$ad_discounted_price = !empty( $_POST['ad_discounted_price'] ) ? $_POST['ad_discounted_price'] : '';
	$ad_call_for_price = isset( $_POST['ad_call_for_price'] ) ? 1 : 0;
	$ad_gmap_longitude = !empty( $_POST['ad_gmap_longitude'] ) ? $_POST['ad_gmap_longitude'] : '';
	$ad_gmap_latitude = !empty( $_POST['ad_gmap_latitude'] ) ? $_POST['ad_gmap_latitude'] : '';
	$ad_category = !empty( $_POST['ad_category'] ) ? $_POST['ad_category'] : '';
	$ad_images = !empty( $_POST['ad_images'] ) ? $_POST['ad_images'] : array();
	$ad_videos = !empty( $_POST['ad_videos'] ) ? $_POST['ad_videos'] : array();
	$ad_featured = isset( $_POST['ad_featured'] ) ? 'yes' : 'no';
	$ad_views = isset( $_POST['ad_views'] ) ? $_POST['ad_views'] : 0;
	$ad_visibility = !empty( $_POST['ad_visibility'] ) ? $_POST['ad_visibility'] : 'yes';
	$post_id = !empty( $_POST['post_id'] ) ? $_POST['post_id'] : 0;
	$ad_terms = isset( $_POST['ad_terms']  ) ? true : false;


	if( $ad_terms ){
		if( !empty( $ad_title ) ){
			if( !empty( $ad_description ) ){
				if( !empty( $ad_gmap_longitude ) && !empty( $ad_gmap_longitude ) ){
					if( !empty( $ad_category ) ){
						$post_args = array(
							'post_type' => 'ad',
							'post_title' => $ad_title,
							'post_content' => $ad_description,
							'post_status' => 'draft'
						);

						if( $post_id !== 0 ){

							if( !$is_expired ){
								$post_args['post_parent'] = $post_id;
							}

							$old_drafts = get_posts(array(
								'post_type' => 'ad',
								'posts_per_page' => '-1',
								'post_status' => 'any',
								'post_parent' => $post_id
							));
							if( !empty( $old_drafts ) ){
								foreach( $old_drafts as $old_draft ){
									wp_delete_post( $old_draft->ID, true );
								}
							}
							update_post_meta( $post_id, 'ad_visibility', $ad_visibility );
						}

						$all_cats = array();
						$all_to_assign = get_ancestors( $ad_category, 'ad-category' );
						if( !empty( $all_to_assign ) ){
							$all_cats = $all_to_assign;
						}
						$all_cats[] = $ad_category;
						$post_args['tax_input']['ad-category'] = $all_cats;

						$post_args['tax_input']['ad-tag'] = explode( ',', $ad_tags );

						$post_id = wp_insert_post( $post_args );

						if( $is_expired ){
							delete_post_meta( $_POST['post_id'], 'ad_expire' );
							classifieds_copy_custom_values( $post_id, $_POST['post_id'] );
							wp_delete_post( $_POST['post_id'], true );
							$_POST['post_id'] = 0;
						}

						if( !empty( $featured_image ) ){
							set_post_thumbnail( $post_id, $featured_image );
						}

						update_post_meta( $post_id, 'ad_phone', $ad_phone );
						if( !empty( $ad_price ) ){
							update_post_meta( $post_id, 'ad_price', $ad_price );
						}
						if( !empty( $ad_call_for_price ) ){
							delete_post_meta( $post_id, 'ad_price' );
							update_post_meta( $post_id, 'ad_call_for_price', 1 );
						}
						
						if( !empty( $ad_discounted_price ) ){
							update_post_meta( $post_id, 'ad_discounted_price', $ad_discounted_price );
						}
						update_post_meta( $post_id, 'ad_gmap_longitude', $ad_gmap_longitude );
						update_post_meta( $post_id, 'ad_gmap_latitude', $ad_gmap_latitude );
						update_post_meta( $post_id, 'ad_visibility', $ad_visibility );
						update_post_meta( $post_id, 'ad_views', $ad_views );

						delete_post_meta( $post_id, 'ad_images' );
						if( !empty( $ad_images ) ){
							$ad_images_arranged = array();
							$ad_images_arranged = array();
							$counter = 0;
							foreach ( $ad_images as $ad_image ) {
								$ad_images_arranged['sm-field-'.$counter] = $ad_image;
								$counter++;
							}
							$ad_images = array( serialize( $ad_images_arranged ) );
							update_post_meta( $post_id, 'ad_images', implode( "", $ad_images ) );
						}

						delete_post_meta( $post_id, 'ad_videos' );
						if( !empty( $ad_videos ) ){
							foreach( $ad_videos as $ad_video ){
								if( !empty( $ad_video ) ){
									add_post_meta( $post_id, 'ad_videos', $ad_video );
								}
							}
						}

						update_post_meta( $post_id, 'ad_featured', $ad_featured );

						if( $_POST['post_id'] == 0 ){
							$amount = classifieds_ad_payment_amount( $post_id );
							if( empty( $amount ) ){
								update_post_meta( $post_id, 'ad_paid', 'yes' );
								$response = '<div class="alert alert-success">'.esc_html__( 'Ad has been added to the review queue', 'classifieds' ).'</div>';	
							}
							else{
								update_post_meta( $post_id, 'ad_paid', 'no' );
								$response = classifieds_create_payments( $post_id, $amount );
							}
							classifieds_inform_admin( $post_id, $is_expired );
						}
						else{
							$response = '<div class="alert alert-success">'.esc_html__( 'Ad has been edited successfully', 'classifieds' ).'</div>';
							classifieds_update_parent( $_POST['post_id'], $post_id );
						}

					}
					else{
						$response = '<div class="alert alert-danger">'.esc_html__( 'Category of the add is required', 'classifieds' ).'</div>';	
					}
				}
				else{
					$response = '<div class="alert alert-danger">'.esc_html__( 'Location of the add is required', 'classifieds' ).'</div>';	
				}
			}
			else{
				$response = '<div class="alert alert-danger">'.esc_html__( 'Description of the add is required', 'classifieds' ).'</div>';
			}
		}
		else{
			$response = '<div class="alert alert-danger">'.esc_html__( 'Ad title is required', 'classifieds' ).'</div>';
		}
	}
	else{
		$response = '<div class="alert alert-danger">'.esc_html__( 'You must accept terms and conditions in order to submit your ad.', 'classifieds' ).'</div>';
	}	

	echo json_encode( array( 'message' => $response ) );
	die();
}
add_action('wp_ajax_update_ad', 'classifieds_update_ad');
add_action('wp_ajax_nopriv_update_ad', 'classifieds_update_ad');

/*
on edit publish update main ad
*/
function classifieds_update_parent( $post_parent_id, $post_id ){
	global $wpdb;
	$post = get_post( $post_id );
	$post_parent = get_post( $post_parent_id );
	$post_args = array(
		'ID' => $post_parent_id,
		'post_type' => 'ad',
		'post_title' => $post->post_title,
		'post_content' => $post->post_content,
		'post_date_gmt' => $post_parent->post_date_gmt,
		'post_date' => $post_parent->post_date,
	);

	wp_update_post( $post_args );

	$categories = wp_get_post_terms( $post_id, 'ad-category', array( 'fields' => 'ids' ) );
	wp_set_post_terms( $post_parent_id, $categories, 'ad-category' );

	$tags = wp_get_post_terms( $post_id, 'ad-tag', array( 'fields' => 'ids' ) );
	wp_set_post_terms( $post_parent_id, $tags, 'ad-tag' );

	$wpdb->query( $wpdb->prepare( "DELETE FROM {$wpdb->postmeta} WHERE post_id = %d AND meta_key != 'ad_expire'", $post_parent_id ) );
	classifieds_copy_custom_values( $post_parent_id, $post->ID );

	wp_delete_post( $post->ID, true );
}

/*
Copy custom field values
*/
function classifieds_copy_custom_values( $to, $from ){
	global $wpdb;
	$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->postmeta} SET post_id = %d WHERE post_id = %d", $to, $from ) );
}

/*
Create list of payments for the submit of ad
*/
function classifieds_create_payments( $ad_id, $amount ){
	$payments = '<div class="alert">'.esc_html__( 'Select your payment method:', 'classifieds' ).'</div>';
	$permalink = classifieds_get_permalink_by_tpl( 'page-tpl_my_profile' );
	$currency = classifieds_get_option( 'main_unit_abbr' );
	/* CHECK IF PAYPAL PAYMENT IS AVAILABLE */
	$paypal_username = classifieds_get_option( 'paypal_username' );
	if( !empty( $paypal_username ) ){
		$paypal = new PayPal(array(
			'username' => $paypal_username,
			'password' => classifieds_get_option( 'paypal_password' ),
			'signature' => classifieds_get_option( 'paypal_signature' ),
			'cancelUrl' => add_query_arg( array( 'cancel' => 'yes', 'ad_id' => $ad_id ), $permalink ),
			'returnUrl' => add_query_arg( array( 'payment' => 'paypal', 'ad_id' => $ad_id ), $permalink ),
		));	

		$pdata = array(
			'PAYMENTREQUEST_0_PAYMENTACTION' => "SALE",
			'L_PAYMENTREQUEST_0_NAME0' => esc_html__( 'Ad Submission', 'classifieds' ),
			'L_PAYMENTREQUEST_0_NUMBER0' => uniqid(),
			'L_PAYMENTREQUEST_0_DESC0' => esc_html__( 'Payment for displaying ad on website.', 'classifieds' ),
			'L_PAYMENTREQUEST_0_AMT0' => $amount,
			'L_PAYMENTREQUEST_0_QTY0' => 1,
			'NOSHIPPING' => 1,
			'PAYMENTREQUEST_0_CURRENCYCODE' => $currency,
			'PAYMENTREQUEST_0_AMT' => $amount
		);

		$response = $paypal->SetExpressCheckout( $pdata );
		if( !isset( $response['error'] ) ){
			$payments .=  '<a href="'.esc_url( $response['url'] ).'"><img src="'.get_template_directory_uri().'/images/paypal.png" alt="" /></a>';
		}
	}

	/* CHECK IF STRIPE PAYMENT IS AVAILABLE */
	$stripe_pk_client_id = classifieds_get_option( 'stripe_pk_client_id' );
	if( !empty( $stripe_pk_client_id ) ){
		$site_logo = classifieds_get_option( 'site_logo' );
		$logo_link = '';
		if( !empty( $site_logo['url'] ) ){
			$logo_link = $site_logo['url'];
		}
		$stripe_amount = $amount * 100;

		$payments .= '<a href="javascript:;" class="stripe-payment" data-genearting_string="'.esc_attr__( 'Processing...', 'classifieds' ).'" data-pk="'.esc_attr__( $stripe_pk_client_id ).'" data-ad_id="'.esc_attr__( $ad_id ).'" data-image="'.esc_url( $logo_link ).'" data-name="'.esc_attr__( 'Ad Submission', 'classifieds' ).'" data-description="'.esc_attr__( 'Payment for displaying ad on website.', 'classifieds' ).'" data-amount="'.esc_attr__( $stripe_amount ).'" data-currency="'.esc_attr__( $currency ).'">
			<img src="'.get_template_directory_uri().'/images/stripe.png" alt="" />
		</a>';
	}
	/* CHECK IF SKRILL PAYMENT IS AVAILABLE */
	$skrill_owner_mail = classifieds_get_option( 'skrill_owner_mail' );
	if( !empty( $skrill_owner_mail ) ){
		$payments .= '
			<a href="javascript:;" class="skrill-payment">
				<img src="'.get_template_directory_uri().'/images/skrill.png" alt="" />
			</a>
			<form class="hidden skrill-form" action="https://www.moneybookers.com/app/payment.pl" method="post">
				<input type="hidden" name="pay_to_email" value="'.esc_attr__( $skrill_owner_mail ).'"/>
				<input type="hidden" name="status_url" value="'.add_query_arg( array( 'payment' => 'skrill-verify', 'ad_id' => $ad_id ), home_url( '/index.php' ) ).'"/> 
				<input type="hidden" name="language" value="EN"/>
				<input type="hidden" name="return_url" value="'.add_query_arg( array( 'payment' => 'skrill', 'ad_id' => $ad_id ), $permalink ).'"/>
				<input type="hidden" name="amount" value="'.esc_attr__( $amount ).'"/>
				<input type="hidden" name="currency" value="'.esc_attr__( $currency ).'"/>
				<input type="hidden" name="detail1_text " value="'.esc_attr__( 'Ad Submission', 'classifieds' ).'"/>	
			</form>
		';
	}

	/* CHECK IF BANK TRANSFER PAYMENT IS AVAILABLE */
	$bank_name = classifieds_get_option( 'bank_name' );
	if( !empty( $bank_name ) ){
		$payments .= '
			<a href="'.esc_url( add_query_arg( array( 'payment' => 'bank' ), $permalink ) ).'">
				<img src="'.get_template_directory_uri().'/images/bank.png" alt="" />
			</a>';
	}

	/* CHECK IF PAYU PAYMENT IS AVAILABLE */
	$payu_merchant_key = classifieds_get_option( 'payu_merchant_key' );
	if( !empty( $payu_merchant_key ) ){
		$surl = add_query_arg( array( 'payment' => 'payu', 'ad_id' => $ad_id ), $permalink );
		$payments .= '<a href="javascript:;" class="payu-initiate"><img src="'.get_template_directory_uri().'/images/payu.png" alt="" /></a>'.classifieds_payu_form( $ad_id, $surl );
	}

	/* CHECK IF IDEAL IS AVAILABLE */
	$mollie_id = classifieds_get_option( 'mollie_id' );
	if( !empty( $mollie_id ) ){
		$iDEAL = new Mollie_iDEAL_Payment ( $mollie_id );
		$ideal_mode = classifieds_get_option( 'ideal_mode' );
		if( $ideal_mode == 'test' ){
			$iDEAL->setTestmode(true);
		}

		$bank_array = $iDEAL->getBanks();
		if( $bank_array ){
			$payments .= '<a href="javascript:;" class="submit-ideal-payment"><img src="'.get_template_directory_uri().'/images/ideal.png" alt="" /></a>';
			$payments .= '<form method="post" class="ideal-payment">
				<select name="bank_id">
					<option value="">'.esc_html__( 'Select Your Bank', 'classifieds' ).'</option>';
			foreach( $bank_array as $bank_id => $bank_name ){
				$payments .= '<option value="'.esc_attr__( $bank_id ).'">'.$bank_name.'</option>';
			}
			$payments .= '<input type="hidden" name="ad_id" value="'.esc_attr__( $ad_id ).'"><input type="hidden" name="action" value="ideal_link"></select></form>';
		}	
	}	

	return '<div class="payments">'.$payments.'</div>';

}


function classifieds_payu_form( $ad_id, $surl = '' ){
	
	if( empty( $ad_id ) ){
		$ad_id = $_POST['ad_id'];
	}
	if( empty( $surl ) ){
		$surl = $_POST['surl'];
	}

	$return = '';
	$amount = classifieds_ad_payment_amount( $ad_id );
	if( !empty( $amount ) ){
		$buyer_id = get_current_user_id();
		$first_name = get_user_meta( $buyer_id, 'first_name', true );
		$phone_number = get_user_meta( $buyer_id, 'phone_number', true );

		if( isset( $_POST['payu_name'] ) ){
			$first_name = $_POST['payu_name'];
			update_user_meta( $buyer_id, 'first_name', $first_name );
		}
		if( isset( $_POST['payu_phone'] ) ){
			$phone_number = $_POST['payu_phone'];
			update_user_meta( $buyer_id, 'phone_number', $phone_number );
		}		
		if( empty( $first_name ) || empty( $phone_number ) ){
			$return = '
				<form class="payu-form payu-additional hidden">
					'.( empty( $first_name ) ? '<label for="payu_name">'.esc_html__( 'First Name', 'classifieds' ).'</label><input type="text" id="payu_name" name="payu_name" class="form-control">' : '' ).'
					'.( empty( $phone_number ) ? '<label for="payu_phone">'.esc_html__( 'Phone Number', 'classifieds' ).'</label><input type="text" id="payu_phone" name="payu_phone" class="form-control">' : '' ).'
					<input type="hidden" name="ad_id" value="'.esc_attr__( $ad_id ).'">
					<input type="hidden" name="surl" value="'.$surl.'">
					<input type="hidden" name="action" value="payu_additional" />
					<a href="javascript:;" class="btn payu-additional-info">'.esc_html__( 'Process', 'classifieds' ).'</a>
				</form>
			';
		}
		else{
			$current_user = wp_get_current_user();
			$payu_merchant_key = classifieds_get_option( 'payu_merchant_key' );
			$payu_merchant_salt = classifieds_get_option( 'payu_merchant_salt' );

			$values = array(
				'key' => $payu_merchant_key,
				'txnid' => substr(hash('sha256', mt_rand() . microtime()), 0, 20),
				'amount' => $amount,
				'productinfo' => esc_html__( 'Ad Submission', 'classifieds' ),
				'firstname' => $first_name,
				'email' => $current_user->user_email
			);

			$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
			$hashVarsSeq = explode('|', $hashSequence);
			$hash_string = '';	
			foreach($hashVarsSeq as $hash_var) {
				$hash_string .= isset($values[$hash_var]) ? $values[$hash_var] : '';
				$hash_string .= '|';
			}
			$hash_string .= $payu_merchant_salt;

			$hash = strtolower(hash('sha512', $hash_string));
			$payu_mode = classifieds_get_option( 'payu_mode' );

			$return = '
				<form class="payu-form '.( !empty( $_POST['ad_id'] ) ? 'payu-submit' : 'payu-submit-click' ).'" action="https://'.$payu_mode.'.payu.in/_payment" method="post">
					<input type="hidden" name="amount" value="'.esc_attr__( $values['amount'] ).'" />
					<input type="hidden" name="productinfo" value="'.$values['productinfo'].'" />
					<input type="hidden" name="firstname" value="'.esc_attr__( $values['firstname'] ).'" />
					<input type="hidden" name="email" value="'.esc_attr__( $values['email'] ).'" />
					<input type="hidden" name="surl" value="'.$surl.'" />
					<input type="hidden" name="furl" value="'.$surl.'" />	
					<input type="hidden" name="service_provider" value="payu_paisa" />	
					<input type="hidden" name="key" value="'.esc_attr__( $payu_merchant_key ).'" />
					<input type="hidden" name="hash" value="'.$hash.'"/>
					<input type="hidden" name="txnid" value="'.esc_attr__( $values['txnid'] ).'" />
					<input type="hidden" name="phone" value="'.esc_attr__( $phone_number ).'" />
				</form>
			';
		}
	}
	if( !empty( $_POST['surl'] ) ){
		echo  $return;
		die();
	}
	else{
		return $return;
	}
}
add_action('wp_ajax_payu_additional', 'classifieds_payu_form');
add_action('wp_ajax_nopriv_payu_additional', 'classifieds_payu_form');

/*
Listen for the payment gateways returns
*/
function classifieds_payment_result(){
	$payment = '';
	if( isset( $_GET['payment'] ) ){
		$payment = $_GET['payment'];
	}
	else if( isset( $_POST['payment'] ) ){
		$payment = $_POST['payment'];
	}
	switch( $payment ){
		case 'paypal' : $response = classifieds_pay_with_paypal(); break;
		case 'payu' : $response = classifieds_pay_with_payu(); break;
		case 'skrill' : $response = classifieds_pay_with_skrill(); break;
		case 'skrill-verify' : $response = classifieds_skrill_payment_confirmation(); break;		
		case 'bank' : $response = classifieds_pay_with_bank(); break;
		case 'ideal' : $response = classifieds_pay_with_ideal(); break;
		case 'ideal-verify' : $response = classifieds_ideal_payment_confirmation(); break;		
		default : $response = '';
	}

	return $response;
}

/*
Mark ad as paid after successfull payment check
*/
function classifieds_mark_ad_as_paid( $ad_id ){
	update_post_meta( $ad_id, 'ad_paid', 'yes' );
}


/*
Do PayPal payment processing
*/
function classifieds_pay_with_paypal(){
	if( isset( $_GET['ad_id'] ) ){
		$ad_id = $_GET['ad_id'];
		$amount = classifieds_ad_payment_amount( $ad_id );

		if( !empty( $amount ) ){
			$paypal = new PayPal(array(
				'username' => classifieds_get_option( 'paypal_username' ),
				'password' => classifieds_get_option( 'paypal_password' ),
				'signature' => classifieds_get_option( 'paypal_signature' ),
				'cancelUrl' => add_query_arg( array( 'cancel' => 'yes', 'ad_id' => $ad_id ), classifieds_get_permalink_by_tpl( 'page-tpl_register_store' ) ),
				'returnUrl' => add_query_arg( array( 'payment' => 'paypal', 'ad_id' => $ad_id ), classifieds_get_permalink_by_tpl( 'page-tpl_register_store' ) ),
			));	

			$pdata = array(
				'TOKEN' => $_GET['token'],
				'PAYERID' => $_GET['PayerID'],				
				'PAYMENTREQUEST_0_PAYMENTACTION' => "SALE",
				'L_PAYMENTREQUEST_0_NAME0' => esc_html__( 'Ad Submission', 'classifieds' ),
				'L_PAYMENTREQUEST_0_NUMBER0' => uniqid(),
				'L_PAYMENTREQUEST_0_DESC0' => esc_html__( 'Payment for displaying ad on website.', 'classifieds' ),
				'L_PAYMENTREQUEST_0_AMT0' => $amount,
				'L_PAYMENTREQUEST_0_QTY0' => 1,
				'NOSHIPPING' => 1,
				'PAYMENTREQUEST_0_CURRENCYCODE' => classifieds_get_option( 'main_unit_abbr' ),
				'PAYMENTREQUEST_0_AMT' => $amount
			);
			$response = $paypal->DoExpressCheckoutPayment( $pdata );
			if( !isset( $response['error'] ) && !isset( $response['L_ERRORCODE0'] ) ){
				classifieds_mark_ad_as_paid( $ad_id );
				return '<div class="alert alert-success no-margin">'.esc_html__( 'Your ad is successfully paid. After review you will receive information about it.', 'classifieds' ).'</div>';
			}
			else if( isset( $response['L_ERRORCODE0'] ) && $response['L_ERRORCODE0'] === '11607' ){
				return '<div class="alert alert-danger no-margin">'.esc_html__( 'You have already registered store with this tranaction ID.', 'classifieds' ).'</div>';
			}
			else{
				return '<div class="alert alert-danger no-margin">'.esc_html__( 'There was an error processing yor request. Please contact administration of the site with this error message:', 'classifieds' ).'<br /><strong>'.$response['error'].'</strong></div>';
			}
		}
		else{
			return '<div class="alert alert-danger no-margin">'.esc_html__( 'Wrong ad', 'classifieds' ).'</div>';
		}
	}

}

/*
Process payu payment
*/
function classifieds_pay_with_payu(){
	$status = $_POST["status"];
	$firstname = $_POST["firstname"];
	$amount = (string)$_POST["amount"];
	$txnid = $_POST["txnid"];
	$posted_hash = $_POST["hash"];
	$key = $_POST["key"];
	$productinfo = $_POST["productinfo"];
	$email = $_POST["email"];
	$ad_id = $_GET['ad_id'];
	$salt = classifieds_get_option( 'payu_merchant_salt' );

	$amount_test = classifieds_ad_payment_amount( $ad_id );
	if( !empty( $amount_test ) ){

		$retHashSeq = $salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
		$hash = hash( "sha512", $retHashSeq );

		if ( $hash != $posted_hash ) {
			return '<div class="alert alert-danger">'.esc_html__( 'Invalid Transaction. Please try again', 'classifieds' ).'</strong></div>';
		}
		else {
			classifieds_mark_ad_as_paid( $ad_id );
			return '<div class="alert alert-success no-margin">'.esc_html__( 'Your ad is successfully paid. After review you will receive information about it.', 'classifieds' ).'</div>';
		}
	}
	else{
		return '<div class="alert alert-danger">'.esc_html__( 'Offer is no longer available', 'classifieds' ).'</strong></div>';
	}	
}

/*
Do Stripe payment processing
*/
function classifieds_pay_with_stripe(){
	$token = $_POST['token'];
	$ad_id = $_POST['ad_id'];
	$amount = classifieds_ad_payment_amount( $ad_id );

	if( !empty( $amount ) ){
	    $response = wp_remote_post( 'https://api.stripe.com/v1/charges', array(
	        'method' => 'POST',
	        'timeout' => 45,
	        'redirection' => 5,
	        'httpversion' => '1.0',
	        'blocking' => true,
	        'headers' => array(
	        	'Authorization' => 'Bearer '.classifieds_get_option( 'stripe_sk_client_id' )
	    	),
	        'body' => array(
	            'amount' => $amount*100,
	            'currency' => strtolower( classifieds_get_option( 'main_unit_abbr' ) ),
	            'card' => $token['id'],
	            'receipt_email' => $token['email'],
	        ),
	        'cookies' => array()
	    ));

	    if ( is_wp_error( $response ) ) {
	        $error_message = $response->get_error_message();
	        echo '<div class="alert alert-danger no-margin">'.esc_html__( 'Something went wrong: ', 'classifieds' ).$error_message.'</div>';
	    } 
	    else{           
	        $data = json_decode( $response['body'], true );
	        if( empty( $data['error'] ) ){
	        	classifieds_mark_ad_as_paid( $ad_id );
	            echo '<div class="alert alert-success stripe-complete no-margin">'.esc_html__( 'Your ad is successfully paid. After review you will receive information about it.', 'classifieds' ).'</div>';
	        }
	        else{
	        	echo '<div class="alert alert-danger no-margin">'.json_encode( $data ).'</div>';
	        }
	    }
	}
	else{
		echo '<div class="alert alert-danger no-margin">'.esc_html__( 'Wrong store', 'classifieds' ).'</div>';
	}
	die();
}
add_action('wp_ajax_pay_with_stripe', 'classifieds_pay_with_stripe');
add_action('wp_ajax_nopriv_pay_with_stripe', 'classifieds_pay_with_stripe');

/*
Do iDEAL payment processing
*/
function classifieds_pay_with_ideal_link(){
	$bank_id = $_POST['bank_id'];
	$ad_id = $_POST['ad_id'];
	$amount = classifieds_ad_payment_amount( $ad_id );
	$permalink = classifieds_get_permalink_by_tpl( 'page-tpl_my_profile' );

	if( $amount ){

		$mollie_id = classifieds_get_option( 'mollie_id' );
		$return_url = add_query_arg( array( 'payment' => 'ideal', 'ad_id' => $ad_id ), $permalink );
		$report_url = add_query_arg( array( 'payment' => 'ideal-verify', 'ad_id' => $ad_id ), home_url( '/index.php' ) );
		$iDEAL = new Mollie_iDEAL_Payment ( $mollie_id );
		$ideal_mode = classifieds_get_option( 'ideal_mode' );
		if( $ideal_mode == 'test' ){
			$iDEAL->setTestmode(true);
		}

		$payment = $iDEAL->createPayment( $bank_id, $amount*100, esc_html__( 'Payment for displaying products via feed.', 'classifieds' ), $return_url, $report_url );

		if( $payment ){
			echo  $iDEAL->getBankURL();
		}
		else{
			echo '<div class="alert alert-danger no-margin">'.esc_html__( 'Could not retrive bank URL', 'classifieds' ).' '.$iDEAL->getErrorMessage().'</div>';
		}

	}
	else{
		echo '<div class="alert alert-danger no-margin">'.esc_html__( 'Wrong store', 'classifieds' ).'</div>';
	}
	die();
}
add_action('wp_ajax_ideal_link', 'classifieds_pay_with_ideal_link');
add_action('wp_ajax_nopriv_ideal_link', 'classifieds_pay_with_ideal_link');

/*
Return message for the iDEAL confirmation
*/
function classifieds_pay_with_ideal(){
	return '<div class="alert alert-success clearfix">'.esc_html__( 'Once iDEAL confirms payment ad will be added to review proces. After it you will receive information about it.', 'classifieds' ).'</div>';	
}

/*
Inform user once iDEAL returns result
*/
function classifieds_ideal_payment_confirmation(){
	if( isset( $_GET['ad_id'] ) && isset( $_GET['transaction_id'] ) ){
		global $wpdb;
		$ad_id = $_GET['ad_id'];
		$amount = classifieds_ad_payment_amount( $ad_id );
		if( !empty( $amount ) ){

			$store_contact_email = $store->store_contact_email;
		
			$mollie_id = classifieds_get_option( 'mollie_id' );
			$iDEAL = new Mollie_iDEAL_Payment( $mollie_id );
			$ideal_mode = classifieds_get_option( 'ideal_mode' );
			if( $ideal_mode == 'test' ){
				$iDEAL->setTestmode(true);
			}
			$iDEAL->checkPayment($_GET['transaction_id']);

			if ( $iDEAL->getPaidStatus() ){
				classifieds_mark_store_as_paid( $ad_id );
			}
		}
	}	
}

/*
Return message for the Skrill confirmation
*/
function classifieds_pay_with_skrill(){
	return '<div class="alert alert-success clearfix">'.esc_html__( 'Once Skrill confirms payment ad will be added to review proces. After it you will receive information about it.', 'classifieds' ).'</div>';
}

/*
Inform user once Skrill returns result
*/
function classifieds_skrill_payment_confirmation(){
	if( isset( $_GET['ad_id'] ) ){
		global $wpdb;
		$store_id = $_GET['ad_id'];
		$amount = classifieds_ad_payment_amount( $ad_id );
		if( !empty( $amount ) ){
			if( isset( $_POST['merchant_id'] ) ){
				$skrill_secret_word = classifieds_get_option( 'skrill_secret_word' );
				$concatFields = $_POST['merchant_id']
				    .$_POST['transaction_id']
				    .strtoupper(md5($skrill_secret_word))
				    .$_POST['mb_amount']
				    .$_POST['mb_currency']
				    .$_POST['status'];

				$MBEmail = classifieds_get_option( 'skrill_owner_mail' );

				if ( strtoupper( md5($concatFields) ) == $_POST['md5sig'] && $_POST['status'] == 2 && $_POST['pay_to_email'] == $MBEmail ){
					classifieds_mark_store_as_paid( $ad_id );
				}
			}
		}
	}	
}

/*
Return message for the Bank Transfer
*/
function classifieds_pay_with_bank(){
	$bank_account_name = classifieds_get_option( 'bank_account_name' );
	$bank_name = classifieds_get_option( 'bank_name' );
	$bank_account_number = classifieds_get_option( 'bank_account_number' );
	$bank_sort_number = classifieds_get_option( 'bank_sort_number' );
	$bank_iban_number = classifieds_get_option( 'bank_iban_number' );
	$bank_bic_swift_number = classifieds_get_option( 'bank_bic_swift_number' );
	return '<div class="white-block">
		<div class="white-block-content">
			'.esc_html__( 'Make your payment directly into our bank account. Please use ad title as the payment reference. Your order won’t be processed until the funds have cleared in our account.', 'classifieds' ).'
			<h4>'.esc_html__( 'Our Bank Details', 'classifieds' ).'</h4>
			'.$bank_account_name.' - '.$bank_name.'
			<ul class="list-unstyled list=inline">
				<li>
					'.esc_html__( 'ACCOUNT NUMBER', 'classifieds' ).':
					'.$bank_account_number.'
				</li>
				<li>
					'.esc_html__( 'SORT CODE', 'classifieds' ).':
					'.$bank_sort_number.'
				</li>
				<li>
					'.esc_html__( 'IBAN', 'classifieds' ).':
					'.$bank_iban_number.'
				</li>
				<li>
					'.esc_html__( 'BIC', 'classifieds' ).':
					'.$bank_bic_swift_number.'
				</li>
			</ul>
		</div>
	</div>';
}

/*
Send mail notification to the user about review of the ad
*/
function classifieds_inform_user( $user_id, $message, $subject ){
	$name_sender = classifieds_get_option( 'name_sender' );
	$email_sender = classifieds_get_option( 'email_sender' );
	$user_mail = get_the_author_meta( 'user_email', $user_id );

    $ad_messaging = classifieds_get_option( 'ad_messaging' );
    if( $ad_messaging  == 'yes'){
        $headers   = array();
        $headers[] = "MIME-Version: 1.0";
        $headers[] = "Content-Type: text/html; charset=UTF-8"; 
        $headers[] = "From: ".$name_sender." <".$email_sender.">";

        $info = wp_mail( $user_mail, $subject, $message, $headers );
    }	
}

/*
Send email to admin about new ad being submitted
*/
function classifieds_inform_admin( $post_id, $is_expired = false ){
    $new_offer_email = classifieds_get_option( 'new_offer_email' );
    $name_sender = classifieds_get_option( 'name_sender' );
    $email_sender = classifieds_get_option( 'email_sender' );

    $headers   = array();
    $headers[] = "MIME-Version: 1.0";
    $headers[] = "Content-Type: text/html; charset=UTF-8"; 
    $headers[] = "From: ".$name_sender." <".$email_sender.">";

    if( $is_expired ){
    	$message = esc_html__( 'Ad submited for renewal.', 'classifieds' );
    	$subject = esc_html__( 'Ad Renewal Submited', 'classifieds' );  
    	delete_post_meta( $post_id, 'ad_expire_mark' );
    }
    else{
    	$message = esc_html__( 'New ad has been submited.', 'classifieds' );
    	$subject = esc_html__( 'New Ad Submited', 'classifieds' );
    }
    $message .= '<br/><br/>';
    $message .= esc_html__( 'You can access it on the following link: ', 'classifieds' ).admin_url( 'post.php?post='.$post_id.'&action=edit' );

    $info = wp_mail( $new_offer_email, '['.get_bloginfo( 'name' ).'] '.$subject, $message, $headers );
}

/*
Increment number of views for the ad single
*/
function classifieds_increment_views( $post_id ){
	$views = get_post_meta( $post_id, 'ad_views', true );
	if( empty( $views ) ){
		$views = 0;
	}

	$views++;

	update_post_meta( $post_id, 'ad_views', $views );
}

/*
Dispaly number of views
*/
function classifieds_ad_views(){
	$ad_views = get_post_meta( get_the_ID(), 'ad_views', true );
	if( empty( $ad_views ) ){
		$ad_views = 0;
	}	
	if( $ad_views >= 1000 ){
		$ad_views = round( $ad_views / 100, 1 ).'k';
	}

	echo  $ad_views;
}

/*
Get organized list of custom taxonomy in form parent->child
for the front end listing
*/
function classifieds_get_organized( $taxonomy ){
	$categories = get_terms( $taxonomy, array('hide_empty' => false));
	$taxonomy_organized = array();
	classifieds_sort_terms_hierarchicaly($categories, $taxonomy_organized);
	$taxonomy_organized =  (array) $taxonomy_organized;

	$sortby = classifieds_get_option( 'all_categories_sortby' );
	$sort = classifieds_get_option( 'all_categories_sort' );


	if( $sort == 'asc' ){
		switch( $sortby ){
			case 'name' : usort( $taxonomy_organized, "classifieds_organized_sort_name_asc" ); break;
			case 'slug' : usort( $taxonomy_organized, "classifieds_organized_sort_slug_asc" ); break;
			case 'count' : usort( $taxonomy_organized, "classifieds_organized_sort_count_asc" ); break;
			default : usort( $taxonomy_organized, "classifieds_organized_sort_name_asc" ); break;
		}
		
	}
	else{
		switch( $sortby ){
			case 'name' : usort( $taxonomy_organized, "classifieds_organized_sort_name_desc" ); break;
			case 'slug' : usort( $taxonomy_organized, "classifieds_organized_sort_slug_desc" ); break;
			case 'count' : usort( $taxonomy_organized, "classifieds_organized_sort_count_desc" ); break;
			default : usort( $taxonomy_organized, "classifieds_organized_sort_name_desc" ); break;
		}
	}
	return $taxonomy_organized;

}

/*
Sort taxonomy terms by name ASC
*/
function classifieds_organized_sort_name_asc( $a, $b ){
    return strcmp( $a->name, $b->name );
}

/*
Sort taxonomy terms by name DESC
*/
function classifieds_organized_sort_name_desc( $a, $b ){
    return strcmp( $b->name, $a->name );
}

/*
Sort taxonomy terms by slug ASC
*/
function classifieds_organized_sort_slug_asc( $a, $b ){
    return strcmp( $a->slug, $b->slug );
}

/*
Sort taxonomy terms by slug DESC
*/
function classifieds_organized_sort_slug_desc( $a, $b ){
    return strcmp( $b->slug, $a->slug );
}

/*
Sort taxonomy terms by count ASC
*/
function classifieds_organized_sort_count_asc( $a, $b ){
    return strcmp( $a->count, $b->count );
}

/*
Sort taxonomy terms by count DESC
*/
function classifieds_organized_sort_count_desc( $a, $b ){
    return strcmp( $b->count, $a->count );
}


/*
Display custom taxonomy on their listing pages
All Categories, All Brands
*/
function classifieds_display_tree( $cat, $taxonomy, $all_categories_count = 'no' ){
	$list = array();
	global $classifieds_slugs;
	foreach( $cat->children as $key => $child ){
		$list[] = '<a href="'.esc_url( add_query_arg( array( $classifieds_slugs['category'] => $child->slug ), classifieds_get_permalink_by_tpl( 'page-tpl_search_page' ) ) ).'">'.$child->name.' '.( $all_categories_count == 'yes' ? '('.classifieds_category_count( $child->slug ).')' : '' ).'</a>';
		if( !empty( $child->children ) ){
			$list = array_merge( $list, classifieds_display_tree( $child, $taxonomy, $all_categories_count ) );
		}				
	}

	return $list;
}

/*
Custom products per page
*/
function classifieds_products_per_page(){
	return classifieds_get_option( 'products_per_page' );
}
add_filter( 'loop_shop_per_page', 'classifieds_products_per_page', 20 );

/*
Get page top parent
*/
function classifieds_top_parent( $parent_id ){
	$page = get_post( $parent_id );
	$parent_id = $page->post_parent;
	if( $parent_id > 0 ){
		$parent_id = classifieds_top_parent( $parent_id );
	}
	else{
		$parent_id = $page->ID;
	}

	return $parent_id;
}

/*
Generate side menu for the side menu template
*/
function classifieds_generate_side_menu(){
	$page_id = get_the_ID();
	$parent_id = classifieds_top_parent( $page_id );
	wp_list_pages(array(
		'child_of' => $parent_id,
		'title_li' => false,
		'sort_column' => 'menu_order',
		'sort_order' => 'DESC'
	));
}

/*
Convert nbsp to p with class
*/
function classifieds_nbsp_to_class( $content ){
	$content = str_replace( '<p>&nbsp;</p>' , '<p class="pspace">&nbsp;</p>', $content);
	return $content;
}
add_filter( 'the_content', 'classifieds_nbsp_to_class' );


/*
Send expire notice to author
*/
function classifieds_send_expire_notice(){
	$send_expire_notice = classifieds_get_option('send_expire_notice');
	$last_check = get_option( 'classifieds_expire_check' );
	if( $send_expire_notice == 'yes' ){
		if( ( current_time( 'timestamp' ) - $last_check ) >= 86400 ){
	        global $wpdb;
	        delete_transient( 'classifieds_expire_reminder_data' );
	        $data = array();
	        $has_data = true;
	        $counter = 1;
	        while( $has_data ){
	        	$offset = ( $counter - 1 ) * 500;
	        	$counter++;	        	
	        	$results = $wpdb->get_results( 
	        		$wpdb->prepare(
		        		"SELECT posts.ID AS post_id, user_login, user_email, post_title FROM {$wpdb->posts} AS posts 
		        		LEFT JOIN {$wpdb->postmeta} AS postmeta1 ON (posts.ID = postmeta1.post_id AND postmeta1.meta_key = 'ad_expire_mark' ) 
		        		LEFT JOIN {$wpdb->postmeta} AS postmeta2 ON posts.ID = postmeta2.post_id 
		        		LEFT JOIN {$wpdb->users} AS users ON posts.post_author = users.ID 
		        		WHERE 1=1 
		        		AND ( postmeta1.post_id IS NULL AND ( postmeta2.meta_key = 'ad_expire' AND CAST(postmeta2.meta_value AS CHAR) < %s ) ) 
		        		AND posts.post_type = 'ad' AND posts.post_status = 'publish' 
		        		GROUP BY posts.ID  LIMIT 500 OFFSET %d",
		        		current_time( 'timestamp' ),
		        		$offset	        		
	        		)
	        	);
	        	if( !empty( $results ) ){
	        		foreach( $results AS $result ){
	        			$data[] = array(
	        				'user_login' => $result->user_login,
	        				'user_email' => $result->user_email,
	        				'post_title' => $result->post_title,
	        				'ID' => $result->post_id,
	        			);
	        		}
	        	}
	        	else{
	        		$has_data = false;
	        	}
	        }

	        set_transient( 'classifieds_expire_reminder_data', json_encode( $data ), 60*60*24 );
	        update_option( 'classifieds_expire_check', current_time( 'timestamp' ) );

	    }
	    else{
	    	$data = json_decode( get_transient( 'classifieds_expire_reminder_data' ), true );
	    }

	    if( !empty( $data ) ){
	        $email_sender = classifieds_get_option( 'email_sender' );
	        $name_sender = classifieds_get_option( 'name_sender' );
	        $expire_template = classifieds_get_option('expire_template');
	        $ad_expire_subject = classifieds_get_option( 'ad_expire_subject' );
	        $headers   = array();
	        $headers[] = "MIME-Version: 1.0";
	        $headers[] = "Content-Type: text/html; charset=UTF-8"; 
	        $headers[] = "From: ".$name_sender." <".$email_sender.">";

	        while( !empty( $data ) ){
	        	$item = array_shift( $data );
	    		$message = str_replace( '%USERNAME%', $item['user_login'], $expire_template );
	    		$message = str_replace( '%AD_NAME%', $item['post_title'], $message );
		        $info = wp_mail( $item['user_email'], $ad_expire_subject, $message, $headers );
		        if( $info ){
		        	update_post_meta( $item['ID'], 'ad_expire_mark', '1' );
		        	set_transient( 'classifieds_expire_reminder_data', json_encode( $data ), 60*60*24 );
		        }
	        }
	    }
	}
}
add_action( 'init', 'classifieds_send_expire_notice' );

/*
Allow SVG file format
*/
function classifieds_mime_types($mimes){	
  $mimes['svg'] = 'image/svg+xml';
  if( !current_user_can( 'manage_options' ) ){
  	$mimes = array(
	    'jpg' => 'image/jpg',
  		'jpeg' => 'image/jpeg',
  		'gif' => 'image/gif',
  		'png' => 'image/png',
  	);
  }
  return $mimes;
}
add_filter('upload_mimes', 'classifieds_mime_types');


/*
Add clear cache link to admin bar
*/
function classifieds_admin_bar_clear_cache( $wp_admin_bar ) {
	$args = array(
		'id'    => 'classifieds_clear_cache',
		'title' => esc_html__( 'Clear Map Cache', 'classifieds' ),
		'href'  => 'javascript:;',
		'meta'  => array( 'class' => 'classifieds_clear_cache' )
	);
	$wp_admin_bar->add_node( $args );
}
add_action( 'admin_bar_menu', 'classifieds_admin_bar_clear_cache', 999 );

/*
Clear cache
*/
function classifieds_clear_cache(){
	delete_transient( 'classifieds_home_markers' );
	die();
}
add_action('wp_ajax_classifieds_clear_cache', 'classifieds_clear_cache');


/*Clear single-ad for ad blocker*/
function classifieds_fix_class( $classes ){
    foreach( $classes as &$class ){
    	if( $class == 'single-ad' ){
    		$class = 'single-cad';
    	}
    }
    return $classes;
}
add_filter('body_class', 'classifieds_fix_class');

/* Organize custom fields by name so select box can be displayed easier */
function classifieds_organize_custom_fields( $custom_fields ){
	$organized = array();
	foreach( $custom_fields as $field ){
		if( $field->parent == '0' ){
			if( empty( $organized[$field->field_id] ) ){
				$organized[$field->field_id] = array(
					'field' => $field,
					'values' => array(),
					'children' => array()
				);
			}

			$organized[$field->field_id]['field'] = $field;
			$organized[$field->field_id]['values'][] = $field->val;

		}
		else{
			if( empty( $organized[$field->parent] ) ){
				$organized[$field->parent] = array(
					'children' => array()
				);
			}

			$organized[$field->parent]['children'][$field->field_id]['field'] = $field;	
			$organized[$field->parent]['children'][$field->field_id]['values'][] = $field->val;	
		}
	}

	return $organized;
}

/*Strip special chars for the class*/
function classifieds_clean_class( $class ) {
   $class = str_replace(' ', '', $class);
   return preg_replace( '/[^A-Za-z0-9\-]/', '', $class ); 
}

/* generate select filter for the frontend */
function classifieds_generate_filter_field( $field_data ){
	if( $field_data['field']->type == 'input' ){
		$values = join( '|', $field_data['values'] );
		$values = explode( '|', $values );
	}
	else{
		$values = explode( "\n", $field_data['field']->field_values );
	}

	$conditional = '';
	if( $field_data['field']->parent !== '0' ){
		$temp = explode( '|', $field_data['field']->child_of_value );
		$conditional = 'conditional-hide '.classifieds_clean_class( $temp[0].'-'.$field_data['field']->parent );
	}

	$html = '<select data-field-id = "'.esc_attr( $field_data['field']->field_id ).'" id="'.esc_attr( $field_data['field']->name ).'" name="'.esc_attr( $field_data['field']->name ).''.( $field_data['field']->type == 'input' ? '[]' : '' ).'" class="form-control filter-select '.( esc_attr( $conditional ) ).'" '.( $field_data['field']->type == 'input' ? 'multiple' : '' ).' data-placeholder="'.esc_attr__( 'Select', 'classifieds' ).'">';
	$html .= '<option value=""></option>';
	$added = array();
	if( !empty( $values ) ){
		foreach( $values as $val ){
			if( !empty( $val ) && !in_array( $val, $added ) ){
				$added[] = $val;
				if( $field_data['field']->type == 'input' ){
					$html .= '<option value="'.esc_attr( $val ).'">'.$val.'</option>';
				}
				else{
					$temp = explode( '|', $val );
					$html .= '<option value="'.esc_attr( $temp[0] ).'">'.$temp[1].'</option>';
				}
			}
		}
	}
	$html .= '</select>';

	return $html;
}

/* Generate list of filters based on the category selected on the search page */
function classifieds_custom_filter(){
	global $wpdb, $classifieds_slugs;

	$cats = array();
	
	$category = isset( $_GET[$classifieds_slugs['category']] ) ? $_GET[$classifieds_slugs['category']] : '';
	if( empty( $category ) ){
		$category = isset( $_POST['category'] ) ? $_POST['category'] : '';
	}

	$html = '';

	if( !empty( $category ) ){

		$cat = get_term_by( 'slug', $category, 'ad-category' );

		$post_id = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->postmeta} WHERE meta_key = 'fields_for' AND meta_value LIKE %s", '%\"'.$cat->slug.'\"%' ) );
		if( !empty( $post_id[0] ) ){
			$custom_fields = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}custom_fields AS cf LEFT JOIN {$wpdb->prefix}custom_fields_meta AS meta ON cf.name = meta.name WHERE cf.post_id = %d", $post_id[0]->post_id ) );
			if( !empty( $custom_fields ) ){
				$custom_fields = classifieds_organize_custom_fields( $custom_fields );
				$html .= '<h4>'.esc_html__( 'Filter', 'classifieds' ).' '.$cat->name.'</h4><form class="form-login filter-form"><ul class="list-unstyled">';
				foreach( $custom_fields as $field_data ){
					$html .= '
					<li>
						<label for="'.esc_attr__( $field_data['field']->name ).'">'.esc_attr__( $field_data['field']->label ).'</label>
						'.classifieds_generate_filter_field( $field_data ).'
					</li>';

					if( !empty( $field_data['children'] ) ){
						foreach( $field_data['children'] as $field_child ){
							$html .= '
							<li class="hidden">
								<label for="'.esc_attr__( $field_child['field']->name ).'">'.esc_attr__( $field_child['field']->label ).'</label>
								'.classifieds_generate_filter_field( $field_child ).'
							</li>';							
						}
					}
				}
				$html .= '</ul><a href="javascript:;" class="filter-results" data-dismiss="modal">'.esc_html__( 'Filter', 'classifieds' ).'</a></form>';
			}
		}
	}

	echo $html;
	if( isset( $_POST['action'] ) ){
		die();
	}
}
add_action('wp_ajax_custom_filter', 'classifieds_custom_filter');
add_action('wp_ajax_nopriv_custom_filter', 'classifieds_custom_filter');

/*
Get placeholder image
*/
global $classifieds_placeholder_image;
$classifieds_placeholder_image = '';
function classifieds_get_placeholder_image( $image_size ){
	global $classifieds_placeholder_image, $wpdb;;
	$image_placeholder = classifieds_get_option( 'image_placeholder' );
	if( !empty( $image_placeholder['url'] ) && empty( $classifieds_placeholder_image ) ){
		if( empty( $classifieds_placeholder_image ) ){
			$image_data = $wpdb->get_results( $wpdb->prepare( "SELECT ID FROM {$wpdb->posts} WHERE guid = %s", $image_placeholder['url'] ) );
			if( !empty( $image_data[0] ) ){
				$classifieds_placeholder_image = wp_get_attachment_image( $image_data[0]->ID, $image_size );
			}
		}
	}

	echo $classifieds_placeholder_image;
}

/*
Get category term count of ads
*/
if( !function_exists('classifieds_category_count') ){
function classifieds_category_count( $category ){
	$category_data = get_transient( 'classifieds_category_count_'.$category );
	if( !empty( $category_data ) ){
		$count = $category_data;
	}
	else{
		$posts = get_posts(array(
			'post_type' => 'ad',
			'posts_per_page' => '-1',
		    'tax_query' => array(
		        'relation' => 'AND',
		        array(
					'taxonomy' => 'ad-category',
					'field'    => 'slug',
					'terms'    => $category,
		        )
		    ),
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
		));
		$count = count( $posts );
		set_transient( 'classifieds_category_count_'.$category, $count, 60*60 );
	}

	return $count;
}
}


require_once( classifieds_load_path( 'includes/class-tgm-plugin-activation.php' ) );
require_once( classifieds_load_path( 'includes/google-fonts.php' ) );
require_once( classifieds_load_path( 'includes/awesome-icons.php' ) );
require_once( classifieds_load_path( 'includes/ad-cat-meta.php' ) );
require_once( classifieds_load_path( 'includes/gallery.php' ) );
require_once( classifieds_load_path( 'includes/widgets.php' ) );
require_once( classifieds_load_path( 'includes/paypal.class.php' ) );
require_once( classifieds_load_path( 'includes/mollie.php' ) );
require_once( classifieds_load_path( 'includes/theme-options.php' ) );
require_once( classifieds_load_path( 'includes/menu-extender.php' ) );
require_once( classifieds_load_path( 'includes/custom-ad-fields.php' ) );
require_once( classifieds_load_path( 'includes/radium-one-click-demo-install/init.php' ) );
if( is_admin() ){
	require_once( classifieds_load_path( 'includes/shortcodes.php' ) );
}
foreach ( glob( get_template_directory().'/includes/shortcodes/*.php' ) as $filename ){
	require_once( classifieds_load_path( 'includes/shortcodes/'.basename( $filename ) ) );
}
?>