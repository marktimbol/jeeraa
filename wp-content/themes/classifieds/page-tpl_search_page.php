<?php
/*
    Template Name: Search Page
*/
get_header();
the_post();

global $classifieds_slugs;

$category = !empty( $_GET[$classifieds_slugs['category']] ) ? urldecode( $_GET[$classifieds_slugs['category']] ) : '';
$location = !empty( $_GET[$classifieds_slugs['location']] ) ? urldecode( $_GET[$classifieds_slugs['location']] ) : '';
$longitude = !empty( $_GET[$classifieds_slugs['longitude']] ) ? urldecode( $_GET[$classifieds_slugs['longitude']] ) : '';
$latitude = !empty( $_GET[$classifieds_slugs['latitude']] ) ? urldecode( $_GET[$classifieds_slugs['latitude']] ) : '';
$keyword = !empty( $_GET[$classifieds_slugs['keyword']] ) ? urldecode( $_GET[$classifieds_slugs['keyword']] ) : '';
$radius = !empty( $_GET[$classifieds_slugs['radius']] ) ? urldecode( $_GET[$classifieds_slugs['radius']] ) : '';
$sortby = !empty( $_GET[$classifieds_slugs['sortby']] ) ? urldecode( $_GET[$classifieds_slugs['sortby']] ) : '';
$view = !empty( $_GET[$classifieds_slugs['view']] ) ? urldecode( $_GET[$classifieds_slugs['view']] ) : 'grid';
$tag = !empty( $_GET[$classifieds_slugs['tag']] ) ? urldecode( $_GET[$classifieds_slugs['tag']] ) : '';

$cur_page = 1;
if( get_query_var( 'paged' ) ){
    $cur_page = get_query_var( 'paged' );
}
else if( get_query_var( 'page' ) ){
    $cur_page = get_query_var( 'page' );
}

$ads_per_page = classifieds_get_option( 'ads_per_page' );

$ads_args = array(
    'post_status' => 'publish',
    's' => $keyword,
    'post_type' => 'ad',
    'orderby' => array( 'meta_value' => 'DESC', 'date' => 'DESC' ),
    'meta_key' => 'ad_featured',
    'order' => 'DESC',
    'posts_per_page' => $ads_per_page,
    'paged' => $cur_page,
    'tax_query' => array(
        'relation' => 'AND'
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
);

if( !empty( $sortby ) ){
    if( $sortby == 'free' ){
        $ads_args['meta_query'][] = array(
            'key' => 'ad_price',
            'value' => '1',
            'compare' => 'NOT EXISTS'
        );        
    }
    elseif( $sortby == 'call' ){
        $ads_args['meta_query'][] = array(
            'key' => 'ad_call_for_price',
            'value' => '1',
            'compare' => '='
        );
    }
    else if( $sortby == 'discount' ){
        $ads_args['meta_query'][] = array(
            'key' => 'ad_discounted_price',
            'compare' => 'EXISTS'
        );
    }
    else{
        $temp = explode( '-', $sortby );
        $ads_args['orderby'] = 'date';
        $ads_args['meta_key'] = '';
        $ads_args['order'] = $temp[1];
    }
}

if( !empty( $category ) ){
    $ads_args['tax_query'][] = array(
        'taxonomy' => 'ad-category',
        'field' => 'slug',
        'terms' => $category,        
    );
}

if( !empty( $tag ) ){
    $ads_args['tax_query'][] = array(
        'taxonomy' => 'ad-tag',
        'field' => 'slug',
        'terms' => $tag,        
    );
}

if( !empty( $location ) && !empty( $longitude ) && !empty( $latitude ) ){
    if( empty( $radius ) ){
        $_GET[$classifieds_slugs['radius']] = classifieds_get_option( 'radius_default' );
        $radius = classifieds_get_option( 'radius_default' );
    }
    add_filter( 'posts_join', 'classifieds_join_radius');
    add_filter( 'posts_where', 'classifieds_where' );
    add_filter( 'posts_fields', 'classifieds_filter_posts_fields', 10, 1 );
    add_filter( 'posts_groupby', 'classifieds_having_radius', 10, 2 );
}

/* CHECK IF ADVANCED FILTER IS USED */
foreach( $_GET as $key => $value ){
    $custom_meta_key = substr( $key, 0, 3 );
    if( $custom_meta_key == 'cf_' ){
        add_filter( 'posts_join', 'classifieds_join_custom_fields');
        add_filter( 'posts_where', 'classifieds_where_custom_fields');
        break;
    }
}

$ads = new WP_Query( $ads_args );

remove_filter( 'posts_join', 'classifieds_join_radius');
remove_filter( 'posts_join', 'classifieds_join_custom_fields');
remove_filter( 'posts_where', 'classifieds_where' );
remove_filter( 'posts_where', 'classifieds_where_custom_fields');
remove_filter( 'posts_fields', 'classifieds_filter_posts_fields', 10, 1 );
remove_filter( 'posts_groupby', 'classifieds_having_radius', 10, 2 );

$page_links_total = $ads->max_num_pages;
$page_links = paginate_links( 
    array(
        'prev_next' => true,
        'end_size' => 2,
        'mid_size' => 2,
        'total' => $page_links_total,
        'current' => $cur_page, 
        'prev_next' => false,
        'type' => 'array'
    )
);

$pagination = classifieds_format_pagination( $page_links );

$ads_ids = wp_list_pluck( $ads->posts, 'ID' );
if( !empty( $ads_ids ) ){
    classifieds_generate_marker_info( $ads_ids );
}
else{
    echo '<div class="markers hidden"></div>';
    echo '<input type="hidden" class="center-latitude" value="'.( !empty( $_GET[$classifieds_slugs['latitude']] ) ? $_GET[$classifieds_slugs['latitude']] : '' ).'">
          <input type="hidden" class="center-longitude" value="'.( !empty( $_GET[$classifieds_slugs['longitude']] ) ? $_GET[$classifieds_slugs['longitude']] : '' ).'">';
}

$ads_search_layout = classifieds_get_option( 'ads_search_layout' );
if( $ads_search_layout !== 'style-left' ){
    include( classifieds_load_path( 'includes/search-box.php' ) );
}
?>
<section class="search-page <?php echo esc_attr__( $ads_search_layout ); ?>">
    <div class="container<?php echo $ads_search_layout == 'style-left' ? esc_attr__( '-fluid' ) : '' ?>">
        <div class="row">

            <?php if( $ads_search_layout == 'style-left' ): ?>
                <div class="col-sm-5 map-size">
                    <div class="header-map">
                        <div id="map" class="big_map"></div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="col-sm-<?php echo $ads_search_layout == 'style-left' ? esc_attr__( '7 map-left-content' ) : esc_attr__( 12 ) ?>">
                <?php 
                if( $ads_search_layout == 'style-left' ){
                    $is_search_page = true;
                    include( classifieds_load_path( 'includes/search-box.php' ) );
                }
                ?>
                <div class="white-block search-block">
                    <div class="white-block-content">
                        <div class="row">
                            <div class="col-md-9">
                                <p>
                                <?php

                                $end_ad_number = $ads_per_page * $cur_page;
                                $start_ad_number = $end_ad_number - $ads_per_page + 1;
                                if( $end_ad_number > $ads->found_posts ){
                                    $end_ad_number = $ads->found_posts;
                                }

                                if( $ads->found_posts > 0 ){
                                    esc_html_e( 'Showing ', 'classifieds' );
                                    echo  $start_ad_number.' - '.$end_ad_number;
                                    esc_html_e( ' of ', 'classifieds' );
                                    echo  $ads->found_posts;
                                    esc_html_e( ' total ', 'classifieds' );
                                }
                                else{
                                    esc_html_e( 'No', 'classifieds' );
                                }
                                $ads->found_posts == 1 ? esc_html_e( ' ad found', 'classifieds' ) : esc_html_e( ' ads found', 'classifieds' );
                                if( !empty( $category ) ){
                                    $category_term = get_term_by( 'slug', $category, 'ad-category' );
                                    if( !empty( $category_term ) ){
                                        esc_html_e( ' in ', 'classifieds' );
                                        echo "'".$category_term->name."'";
                                    }
                                }
                                if( !empty( $tag ) ){
                                    $tag_term = get_term_by( 'slug', $tag, 'ad-tag' );
                                    if( !empty( $tag_term ) ){
                                        esc_html_e( ' tagged with ', 'classifieds' );
                                        echo "'".$tag_term->name."'";
                                    }
                                }                        
                                if( !empty( $location ) ){
                                    esc_html_e( ' at ', 'classifieds' );
                                    echo stripcslashes( $location );
                                }
                                if( !empty( $radius ) ){
                                    esc_html_e( ' within ', 'classifieds' );
                                    $radius_search_units = classifieds_get_option( 'radius_search_units' );
                                    if( $radius_search_units == 'mi' ){
                                        $radius_word = $radius == 1 ? esc_html__( 'mile', 'classifieds' ) : esc_html__( 'miles', 'classifieds' );
                                    }
                                    else{
                                        $radius_word = $radius == 1 ? esc_html__( 'kilometer', 'classifieds' ) : esc_html__( 'kilometers', 'classifieds' );
                                    }
                                    echo "'".$radius.' '.$radius_word."'";
                                }
                                if( !empty( $keyword ) ){
                                    esc_html_e( ' with ', 'classifieds' );
                                    echo "'".$keyword."' ".esc_html__( 'keyword', 'classifieds' );
                                }
                                ?>
                                </p>
                            </div>
                            <div class="col-md-3 text-right">
                                <a href="javascript:;" class="reset-search">
                                    <i class="fa fa-times-circle"></i> <?php esc_html_e( 'RESET', 'classifieds' ) ?>
                                </a>                        
                            </div>
                        </div>
                    </div>
                </div>

                <div class="search-organizer">
                    <div class="clearfix">
                        <div class="pull-left">
                            <select class="change_sort">
                                <option value="" <?php echo empty( $sortby ) ? 'selected="selected"' : '' ?>><?php esc_html_e( 'Select', 'classifieds' ) ?></option>
                                <option value="date-desc" <?php echo  $sortby == 'date-desc' ? 'selected="selected"' : '' ?> ><?php esc_html_e( 'Newest First', 'classifieds' ) ?></option>
                                <option value="date-asc" <?php echo  $sortby == 'date-asc' ? 'selected="selected"' : '' ?> ><?php esc_html_e( 'Oldest First', 'classifieds' ) ?></option>
                                <option value="free" <?php echo  $sortby == 'free' ? 'selected="selected"' : '' ?> ><?php esc_html_e( 'Free', 'classifieds' ) ?></option>
                                <option value="call" <?php echo  $sortby == 'call' ? 'selected="selected"' : '' ?> ><?php esc_html_e( 'Call For Info', 'classifieds' ) ?></option>
                                <option value="discount" <?php echo  $sortby == 'discount' ? 'selected="selected"' : '' ?> ><?php esc_html_e( 'Discounted', 'classifieds' ) ?></option>
                            </select>
                        </div>
                        <div class="pull-right">
                            <a href="javascript:;" class="change_view <?php echo $view == 'list' ? esc_attr__( 'active' ) : '' ?>" data-value="list">
                                <i class="fa fa-th-list fa-fw"></i>
                            </a>
                            <a href="javascript:;" class="change_view <?php echo $view == 'grid' ? esc_attr__( 'active' ) : '' ?>" data-value="grid">
                                <i class="fa fa-th-large fa-fw"></i>
                            </a>                    
                        </div>
                    </div>
                </div>
                <div class="search-results">
                    <div class="row">
                        <?php
                        $counter_max = 4;
                        $column_size = 'col-sm-6 col-md-3';
                        if( $ads_search_layout == 'style-left' ){
                            $counter_max = 3;
                            $column_size = 'col-sm-6 col-md-4';
                        }                
                        if( $view == 'list' ){
                            $counter_max = 2;
                            $column_size = 'col-md-6';
                            if( $ads_search_layout == 'style-left' ){
                                $counter_max = 1;
                                $column_size = 'col-md-12';
                            }
                        }

                        $counter = 0;
                        if( $ads->have_posts() ){
                            while( $ads->have_posts() ){
                                $ads->the_post();
                                if( $counter == $counter_max ){
                                    $counter = 0;
                                    echo '</div><div class="row">';
                                }
                                $counter++;
                                ?>
                                <div class="<?php echo esc_attr__( $column_size ); ?>">
                                    <?php
                                    if( $view == 'grid' ){
                                        $image_size = 'classifieds-ad-box-bug';
                                        include( classifieds_load_path( 'includes/ad-box.php' ) );
                                    }
                                    else{
                                        $excerpt_max = 154;
                                        include( classifieds_load_path( 'includes/ad-box-alt.php' ) );   
                                    }
                                    ?>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>

                <?php wp_reset_postdata(); ?>

                <?php
                if( !empty( $pagination ) ) {
                    ?>
                    <div class="text-center">
                        <ul class="pagination">
                            <?php echo  $pagination; ?>
                        </ul>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</section>
<?php get_footer(); ?>