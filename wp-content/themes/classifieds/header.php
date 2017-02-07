<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

<!-- Favicon -->

<?php wp_head(); ?>
</head>
<body <?php body_class() ?>>
<?php
global $classifieds_slugs;
$mesage = classifieds_payment_result();
if( !empty( $mesage ) ){
    set_transient( 'classifieds_payment_result', $mesage );
}

$enable_sticky = classifieds_get_option( 'enable_sticky' );
?>
<section class="navigation" data-enable_sticky="<?php echo $enable_sticky == 'yes' ? esc_attr__( 'yes' ) : esc_attr__( 'no' ) ?>">
    <div class="container">
        <div class="clearfix">
            <div class="pull-left">
                <?php 
                $site_logo = classifieds_get_option( 'site_logo' );
                if( !empty( $site_logo['url'] ) ): ?>
                    <a href="<?php echo esc_url( home_url('/') ); ?>" class="site-logo">
                        <img src="<?php echo esc_url( $site_logo['url'] ); ?>" title="" alt="" width="<?php echo esc_attr__( $site_logo['width'] ) ?>" height="<?php echo esc_attr__( $site_logo['height'] ) ?>">
                    </a>
                <?php endif; ?>
            </div>
            <div class="pull-right">
                <button class="navigation-toggle">
                    <i class="fa fa-bars"></i>
                </button>
                <div class="navbar navbar-default" role="navigation">
                    <div class="collapse navbar-collapse">
                        <?php
                        if( is_user_logged_in() ){
                            $account_manage = '<a href="'.esc_url( classifieds_get_permalink_by_tpl( 'page-tpl_my_profile' ) ).'" class="login-action">'.classifieds_get_option( 'my_profile_looks' ).'</a>';
                            $submit_ad = add_query_arg( array( $classifieds_slugs['subpage'] => 'submit_ad' ), classifieds_get_permalink_by_tpl('page-tpl_my_profile') );
                            $modal = '';
                        }
                        else{
                            $account_manage = '<a href="#login" data-toggle="modal" class="login-action">'.classifieds_get_option( 'login_looks' ).'</a>';
                            $submit_ad = '#register';
                            $modal = 'data-toggle="modal"';
                        }
                        $locations = get_nav_menu_locations();
                        if ( isset( $locations[ 'top-navigation' ] ) ) {
                            wp_nav_menu( array(
                                'theme_location'    => 'top-navigation',
                                'menu_class'        => 'nav navbar-nav clearfix',
                                'container'         => false,
                                'echo'              => true,
                                'items_wrap'        => '<ul class="%2$s">%3$s',
                                'depth'             => 10,
                                'walker'            => new classifieds_walker,
                            ) );
                        }
                        if(get_option('users_can_register')){
                            echo '<li>'.$account_manage.'</li><li class="submit-add"><a href="'.esc_attr__( $submit_ad ).'" '.$modal.' class="btn">'.esc_html__( 'SUBMIT AD', 'classifieds' ).'</a></li></ul>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
if( is_front_page() ){
    include( classifieds_load_path( 'includes/home-geo-map.php' ) );
}
?>


<?php
$show_map_on_home = classifieds_get_option( 'show_map_on_home' );
$ads_search_layout = classifieds_get_option( 'ads_search_layout' );
$home_slider = classifieds_get_option( 'home_slider' );
$page_template = get_page_template_slug();
if( ( $page_template == 'page-tpl_home_page.php' && $show_map_on_home == 'yes' && empty( $home_slider ) ) || ( $page_template == 'page-tpl_search_page.php' && $ads_search_layout == 'style-top' ) ){
    ?>
    <section class="header-map">
        <div id="map" class="big_map"></div>
    </section>
    <?php
    if( $page_template == 'page-tpl_home_page.php' ){
        $home_map_cache = classifieds_get_option( 'home_map_cache' );
        $home_map_cache = $home_map_cache == 'yes' ? true : false;
        classifieds_generate_marker_info( array(), $home_map_cache );
    }
}

if( !empty( $home_slider ) && is_front_page() ){
    echo do_shortcode( $home_slider );
}

if( $page_template !== 'page-tpl_search_page.php' || ( $page_template !== 'page-tpl_search_page.php'&& $ads_search_layout !== 'style-left' ) ){
    include( classifieds_load_path( 'includes/search-box.php' ) );
}
?>