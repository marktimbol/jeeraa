<?php
$show_search_bar = classifieds_get_option( 'show_search_bar' );
if( $show_search_bar == 'yes' ):

$category = '';
if( isset( $_GET[$classifieds_slugs['category']] ) ){
    $category = urldecode( $_GET[$classifieds_slugs['category']] );
}

$location = '';
$longitude = '';
$latitude = '';
if( isset( $_GET[$classifieds_slugs['location']] ) ){
    $location = urldecode( $_GET[$classifieds_slugs['location']] );
    $longitude = urldecode( $_GET[$classifieds_slugs['longitude']] );
    $latitude = urldecode( $_GET[$classifieds_slugs['latitude']] );
}

$keyword = '';
if( isset( $_GET[$classifieds_slugs['keyword']] ) ){
    $keyword = urldecode( $_GET[$classifieds_slugs['keyword']] );
}

$radius = '';
if( isset( $_GET[$classifieds_slugs['radius']] ) ){
    $radius = urldecode( $_GET[$classifieds_slugs['radius']] );
}

$view = '';
if( isset( $_GET[$classifieds_slugs['view']] ) ){
    $view = urldecode( $_GET[$classifieds_slugs['view']] );
}
else{
    $view = classifieds_get_option( 'ads_default_view' );
}

$sortby = '';
if( isset( $_GET[$classifieds_slugs['sortby']] ) ){
    $sortby = urldecode( $_GET[$classifieds_slugs['sortby']] );
}

$radius_default = classifieds_get_option( 'radius_default' );
$radius_search_units = classifieds_get_option( 'radius_search_units' );

$ads_advanced_search = classifieds_get_option( 'ads_advanced_search' );
$page_template = get_page_template_slug();

?>
    <<?php echo !empty( $is_search_page ) ? 'div' : 'section' ?> class="search-bar clearfix">
        <?php echo !empty( $is_search_page ) ? '' : '<div class="container">' ?>
            <form method="get" class="search-form <?php echo $ads_advanced_search == 'yes' && $page_template == 'page-tpl_search_page.php' ? esc_attr( 'advanced-search' ) : '' ?>" action="<?php echo classifieds_get_permalink_by_tpl( 'page-tpl_search_page' ) ?>">
                <input type="hidden" class="view" name="<?php echo esc_attr__( $classifieds_slugs['view'] ) ?>" value="<?php echo esc_attr__( $view ) ?>">
                <input type="hidden" class="sortby" name="<?php echo esc_attr__( $classifieds_slugs['sortby'] ) ?>" value="<?php echo esc_attr__( $sortby ) ?>">
                <ul class="list-unstyled list-inline">
                    <li>
                        <select class="form-control select2 category" name="<?php echo esc_attr__( $classifieds_slugs['category'] ) ?>" data-placeholder="<?php esc_attr_e( 'Category', 'classifieds' ) ?>">
                            <option value="">&nbsp;</option>
                            <?php classifieds_get_taxonomy_select_search( 'ad-category', $category ); ?>
                        </select>
                        <i class="fa fa-bars"></i>                    
                    </li>
                    <li>
                        <input type="text" class="form-control keyword" name="<?php echo esc_attr__( $classifieds_slugs['keyword'] ) ?>" value="<?php echo esc_attr__( $keyword ) ?>" placeholder="<?php esc_attr_e( 'Keyword', 'classifieds' ) ?>">
                        <?php
                        $visibility = '';
                        if( empty( $keyword ) ){
                            $visibility = 'hidden';
                        }
                        echo '<a href="javascript:;" class="clear-input '.esc_attr__( $visibility ).'"></a>';
                        ?>
                        <i class="fa fa-search"></i>
                    </li>
                    <li>
                        <input type="text" class="form-control google-location" name="<?php echo esc_attr__( $classifieds_slugs['location'] ) ?>" value="<?php echo esc_attr__( $location ) ?>" placeholder="<?php esc_attr_e( 'Location', 'classifieds' ) ?>">
                        <input type="hidden" name="<?php echo esc_attr__( $classifieds_slugs['longitude'] ) ?>" class="longitude" value="<?php echo esc_attr__( $longitude ) ?>">
                        <input type="hidden" name="<?php echo esc_attr__( $classifieds_slugs['latitude'] ) ?>" class="latitude" value="<?php echo esc_attr__( $latitude ) ?>">
                        <?php
                        $visibility = '';
                        if( empty( $location ) ){
                            $visibility = 'hidden';
                        }
                        echo '<a href="javascript:;" class="clear-input '.esc_attr__( $visibility ).'"></a>';
                        ?>                        
                        <i class="fa fa-map-marker"></i>
                    </li>
                    <li>
                        <select class="form-control select2 radius" name="<?php echo esc_attr__( $classifieds_slugs['radius'] ) ?>" data-placeholder="<?php esc_attr_e( 'Radius', 'classifieds' ) ?> (<?php echo !empty( $radius_default ) ? esc_attr__( $radius_default ) : esc_attr__( '0' ) ?><?php echo esc_attr__( $radius_search_units ) ?>)">
                            <option value="">&nbsp;</option>
                            <?php classifieds_get_radius_options( $radius, $radius_search_units ); ?>
                        </select>                    
                        <i class="fa fa-bullseye"></i>
                    </li>
                    <li>
                        <a href="javascript:;" class="btn submit-form">
                            <?php esc_html_e( 'Search', 'classifieds' ); ?>
                        </a>
                    </li>
                    <?php 
                    if( $ads_advanced_search == 'yes' && is_page() && $page_template == 'page-tpl_search_page.php' ): ?>
                        <li class="advanced-filter-wrap">
                            <a href="#filters" data-toggle="modal" class="btn disabled advanced-filters" data-filtered="<?php esc_html_e( 'Change Filters', 'classifieds' ); ?>" data-default="<?php esc_html_e( 'Advanced Filters', 'classifieds' ); ?>">
                                <?php esc_html_e( 'Advanced Filters', 'classifieds' ); ?>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="filters-holder hidden"></div>
            </form>
        <?php echo !empty( $is_search_page ) ? '' : '</div>' ?>
    </<?php echo !empty( $is_search_page ) ? 'div' : 'section' ?>>
<?php endif; ?>