<?php
/*
Plugin Name: Classifieds Custom Post Types
Plugin URI: http://demo.powerthemes.club/themes/classifieds/
Description: Classifieds custom post types and taxonomies
Version: 1.0
Author: pebas
Author URI: http://themeforest.net/user/pebas/
License: GNU General Public License version 3.0
*/

if( !function_exists( 'classifieds_post_types_and_taxonomies' ) ){
	function classifieds_post_types_and_taxonomies(){
		$ad_args = array(
			'labels' => array(
				'name' => __( 'Ads', 'classifieds' ),
				'singular_name' => __( 'Ad', 'classifieds' )
			),
			'public' => true,
			'menu_icon' => 'dashicons-megaphone',
			'has_archive' => false,
			'supports' => array(
				'title',
				'editor',
				'thumbnail',
				'author',
				'excerpt',
				'comments'
			)
		);
		if( function_exists('classifieds_get_option') ){
			$trans_ad = classifieds_get_option( 'trans_ad' );
			if( !empty( $trans_ad ) && $trans_ad !== 'ad' ){
				$ad_args['rewrite'] = array( 'slug' => $trans_ad );
			}
		}
		register_post_type( 'ad', $ad_args );

		register_post_type( 'client', array(
			'labels' => array(
				'name' => __( 'Clients', 'classifieds' ),
				'singular_name' => __( 'Client', 'classifieds' )
			),
			'public' => true,
			'menu_icon' => 'dashicons-groups',
			'has_archive' => false,
			'supports' => array(
				'title',
				'thumbnail',
			)
		));
			
		register_post_type( 'custom_field', array(
			'labels' => array(
				'name' => __( 'Custom Fields', 'classifieds' ),
				'singular_name' => __( 'Custom Field', 'classifieds' )
			),
			'public' => true,
			'menu_icon' => 'dashicons-forms',
			'has_archive' => false,
			'supports' => array(
				'title',
			)
		));
		
		$ad_category_args = array(
			'label' => __( 'Ad Categories', 'classifieds' ),
			'hierarchical' => true,
			'labels' => array(
				'name' 							=> __( 'Ad Categories', 'classifieds' ),
				'singular_name' 				=> __( 'Ad Category', 'classifieds' ),
				'menu_name' 					=> __( 'Ad Category', 'classifieds' ),
				'all_items'						=> __( 'All Ad Categories', 'classifieds' ),
				'edit_item'						=> __( 'Edit Ad Category', 'classifieds' ),
				'view_item'						=> __( 'View Ad Category', 'classifieds' ),
				'update_item'					=> __( 'Update Ad Category', 'classifieds' ),
				'add_new_item'					=> __( 'Add New Ad Category', 'classifieds' ),
				'new_item_name'					=> __( 'New Ad Category Name', 'classifieds' ),
				'parent_item'					=> __( 'Parent Ad Category', 'classifieds' ),
				'parent_item_colon'				=> __( 'Parent Ad Category:', 'classifieds' ),
				'search_items'					=> __( 'Search Ad Categories', 'classifieds' ),
				'popular_items'					=> __( 'Popular Ad Categories', 'classifieds' ),
				'separate_items_with_commas'	=> __( 'Separate ad categories with commas', 'classifieds' ),
				'add_or_remove_items'			=> __( 'Add or remove ad categories', 'classifieds' ),
				'choose_from_most_used'			=> __( 'Choose from the most used ad categories', 'classifieds' ),
				'not_found'						=> __( 'No ad categories found', 'classifieds' ),
			)
		
		);
	
		if( function_exists('classifieds_get_option') ){
			$trans_ad_category = classifieds_get_option( 'trans_ad_category' );
			if( !empty( $trans_ad_category ) && $trans_ad_category !== 'ad-category' ){
				$ad_args['rewrite'] = array( 'slug' => $trans_ad_category );
			}
		}
		register_taxonomy( 'ad-category', array( 'ad' ), $ad_category_args );

		$ad_tag_args = array(
			'label' => __( 'Ad Tags', 'classifieds' ),
			'labels' => array(
				'name' 							=> __( 'Ad Tags', 'classifieds' ),
				'singular_name' 				=> __( 'Ad Tag', 'classifieds' ),
				'menu_name' 					=> __( 'Ad Tag', 'classifieds' ),
				'all_items'						=> __( 'All Ad Tags', 'classifieds' ),
				'edit_item'						=> __( 'Edit Ad Tag', 'classifieds' ),
				'view_item'						=> __( 'View Ad Tag', 'classifieds' ),
				'update_item'					=> __( 'Update Ad Tag', 'classifieds' ),
				'add_new_item'					=> __( 'Add New Ad Tag', 'classifieds' ),
				'new_item_name'					=> __( 'New Ad Tag Name', 'classifieds' ),
				'parent_item'					=> __( 'Parent Ad Tag', 'classifieds' ),
				'parent_item_colon'				=> __( 'Parent Ad Tag:', 'classifieds' ),
				'search_items'					=> __( 'Search Ad Tag', 'classifieds' ),
				'popular_items'					=> __( 'Popular Ad Tag', 'classifieds' ),
				'separate_items_with_commas'	=> __( 'Separate ad tags with commas', 'classifieds' ),
				'add_or_remove_items'			=> __( 'Add or remove ad tags', 'classifieds' ),
				'choose_from_most_used'			=> __( 'Choose from the most used ad tags', 'classifieds' ),
				'not_found'						=> __( 'No ad tags found', 'classifieds' ),
			)
		
		);
	
		if( function_exists('classifieds_get_option') ){
			$trans_ad_tag = classifieds_get_option( 'trans_ad_tag' );
			if( !empty( $trans_ad_tag ) && $trans_ad_tag !== 'ad-tag' ){
				$ad_args['rewrite'] = array( 'slug' => $trans_ad_tag );
			}
		}
		register_taxonomy( 'ad-tag', array( 'ad' ), $ad_tag_args );		
	}

	add_action('init', 'classifieds_post_types_and_taxonomies', 0);
}

/*
Create necessarty additional tables
*/
if( !function_exists( 'classifieds_create_tables' ) ){
	function classifieds_create_tables(){
		global $wpdb;
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE {$wpdb->prefix}custom_fields (
		  field_id mediumint(9) NOT NULL AUTO_INCREMENT,
		  post_id mediumint(9) NOT NULL,
		  name varchar(255)  NOT NULL,
		  label varchar(255) NOT NULL,
		  type varchar(30) DEFAULT '' NOT NULL,
		  field_values text NOT NULL,
		  child_of_value varchar(255) DEFAULT '' NOT NULL,
		  parent int(10) DEFAULT '0' NOT NULL,
		  UNIQUE KEY field_id (field_id)
		) $charset_collate;";
		dbDelta( $sql );

		$sql = "CREATE TABLE {$wpdb->prefix}custom_fields_meta (
		  value_id mediumint(9) NOT NULL AUTO_INCREMENT,
		  post_id mediumint(9) NOT NULL,
		  name varchar(255)  NOT NULL,
		  val text  NOT NULL, 
		  UNIQUE KEY value_id (value_id)
		) $charset_collate;";
		dbDelta( $sql );		
	}
	add_action('init', 'classifieds_create_tables' );
}

?>