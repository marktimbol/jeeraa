<?php
/*==================
 SINGLE DEAL POST
==================*/

get_header();
the_post();
get_template_part( 'includes/title' );
global $classifieds_slugs;

classifieds_increment_views( get_the_ID() );

$ad_images = classifieds_smeta_images( 'ad_images', get_the_ID(), array() ); 
$ad_videos = get_post_meta( get_the_ID(), 'ad_videos' ); 

$first_image = '';
$owl_items = array();
$item_count = 0;
$current_column = 0;
$columns = 0;
$img_counter = 0;

$items_sum = 0;
if( !empty( $ad_images ) ){
    $items_sum += sizeof( $ad_images );
}

if( !empty( $ad_images ) ){
    $items_sum += sizeof( $ad_videos );
}

$columns = ceil( $items_sum / 3 );

if( has_post_thumbnail() ){

    $full_image_data = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_id() ), 'full' );
    $medium_image_data = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_id() ), 'classifieds-ad-single' );

    $first_image .= '<a class="single-ad-image item-'.esc_attr__( $img_counter ).'"  href="'.esc_url( $full_image_data[0] ).'">';
        $first_image .= '<img src="'.esc_url( $medium_image_data[0] ).'" width="'.esc_attr__( $medium_image_data[1] ).'" height="'.esc_attr__( $medium_image_data[2] ).'" alt="">';
    $first_image .= '</a>';

    $columns = ceil( ( sizeof( $ad_images ) + 1 ) / 3 );
    $owl_items[$current_column] = '<div class="img-owl-wrap">'.get_the_post_thumbnail( get_the_ID(), 'classifieds-ad-owl-thumb', array( 'class' => 'single-ad-thumb', 'data-item' => $img_counter ) ).'</div>';
    $item_count++;
}


if( !empty( $ad_images ) ){
    foreach( $ad_images as $ad_image ){
        $img_counter++;

        $full_image_data = wp_get_attachment_image_src( $ad_image, 'full' );
        $medium_image_data = wp_get_attachment_image_src( $ad_image, 'classifieds-ad-single' );

        $first_image .= '<a class="single-ad-image '.( empty( $first_image ) ? '' : 'hidden' ).' item-'.esc_attr__( $img_counter ).'"  href="'.esc_url( $full_image_data[0] ).'">';
            $first_image .= '<img src="'.esc_url( $medium_image_data[0] ).'" width="'.esc_attr__( $medium_image_data[1] ).'" height="'.esc_attr__( $medium_image_data[2] ).'" alt="">';
        $first_image .= '</a>';

        if( $item_count == 3 ){
            $item_count = 0;
            $current_column++;
        }
        $item_count++;

        if( empty( $owl_items[$current_column] ) ){
            $owl_items[$current_column] = '';
        }

        $owl_items[$current_column] .= '<div class="img-owl-wrap">'.wp_get_attachment_image( $ad_image, 'classifieds-ad-owl-thumb', false, array( 'class' => 'single-ad-thumb', 'data-item' => $img_counter ) ).'</div>';

    }
}


if( !empty( $ad_videos ) ){
    foreach( $ad_videos as $ad_video ){
        $img_counter++;

        $video_image = classifieds_get_option( 'video_image' );
        if( empty( $video_image['id'] ) ){
            $medium_image_data = get_template_directory_uri() . '/images/medium-video.jpg';
            $thumb_image_data = get_template_directory_uri() . '/images/small-video.jpg';
        }
        else{
            $img_data = wp_get_attachment_image_src( $video_image['id'], 'classifieds-ad-single' );
            $medium_image_data = $img_data[0];
            $img_data = wp_get_attachment_image_src( $video_image['id'], 'classifieds-ad-owl-thumb' );
            $thumb_image_data = $img_data[0];
        }

        $first_image .= '<a class="video single-ad-image '.( empty( $first_image ) ? '' : 'hidden' ).' item-'.esc_attr__( $img_counter ).'"  href="'.esc_url( $ad_video ).'">';
            $first_image .= '<img src="'.esc_url( $medium_image_data ).'" width="500" height="400" alt="">';
        $first_image .= '</a>';

        if( $item_count == 3 ){
            $item_count = 0;
            $current_column++;
        }
        $item_count++;

        if( empty( $owl_items[$current_column] ) ){
            $owl_items[$current_column] = '';
        }       

        $owl_items[$current_column] .= '<div class="img-owl-wrap"><img src="'.esc_url( $thumb_image_data ).'" alt="" width="100" height="100" class="classifieds-ad-owl-thumb single-ad-thumb" data-item="'.esc_attr__( $img_counter ).'"></div>';

    }
}

?>
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-8 col-sm-8">
                        <div class="images-list">
                             <?php 
                             if( !empty( $first_image ) ){
                                    echo  $first_image;
                             } 
                             ?>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="ad-single-thumbs">
                        <?php 
                        if( !empty( $owl_items ) ){
                            foreach( $owl_items as $owl_item ){
                                echo '<div>'.$owl_item.'</div>';
                            }
                        } 
                        ?>  
                        </div>                  
                    </div>
                </div>              
                <div class="white-block">
                    <div class="white-block-content">
                        <?php
                        classifieds_get_featured_badge( get_the_ID() );
                        ?>
                        <div class="top-meta">
                            <?php esc_html_e( 'Posted ', 'classifieds' ); ?>
                            <?php the_time( get_option( 'date_format' ) ) ?>
                            <?php esc_html_e( ' at ', 'classifieds' ); ?>
                            <?php the_time( get_option( 'time_format' ) ) ?>
                            <?php esc_html_e( ' by ', 'classifieds' ); ?>
                            <?php the_author_meta( 'display_name' ); ?>
                            <?php
                            $categories = classifieds_categories_list();
                            if( !empty( $categories ) ):
                            ?>
                                <?php esc_html_e( ' in ', 'classifieds' ); echo  $categories; ?></li>
                            <?php
                            endif;
                            ?>                            
                        </div>

                        <h3 class="blog-title"><?php the_title(); ?></h3>

                        <?php the_content(); ?>

                        <?php
                        // classifieds_list_details();
                        ?>
                        <?php
                        $list = array();
                        $tags = get_the_terms( get_the_ID(), 'ad-tag' );
                        $permalink = classifieds_get_permalink_by_tpl( 'page-tpl_search_page' );
                        if( !empty( $tags ) ){
                            ?>
                            <div class="tag-list hidden">
                                <i class="fa fa-tags icon-margin"></i>
                                <?php
                                foreach( $tags as $tag ){
                                    $list[] = '<a href="'.esc_url( add_query_arg( array( $classifieds_slugs['tag'] => $tag->slug ), $permalink ) ).'">'.$tag->name.'</a>';
                                }
                                echo join( $list, ', ' );
                                ?>
                            </div>
                            <?php
                        }

                        ?> 
                    </div>

                </div>
              

            </div>

            <div class="col-md-4">
                <?php $single_ad_side_position = classifieds_get_option( 'single_ad_side_position' ); ?>
                <?php if( $single_ad_side_position  == 'pos-1') { get_sidebar('ad'); } ?>
                <div class="widget white-block single-ad-author">
                    <h4><i class="fa fa-pencil"></i> <?php esc_html_e( 'Posted by', 'classifieds' ) ?></h4>
                    
                    <?php include( classifieds_load_path( 'includes/author-info.php' ) );; ?>

                    <div class="ad-actions">
                        <ul class="list-inline list-unstyled">
                            <li><a href="javascript:;" class="share-ad" data-toggle="modal" data-target="#share"><i class="fa fa-share-alt"></i><?php esc_html_e( 'Share Ad', 'classifieds' ); ?></a></li>
                            <!-- <li><a href="javascript:;" class="ask-question" data-toggle="modal" data-target="#question"><i class="fa fa-envelope"></i><?php esc_html_e( 'Send Message', 'classifieds' ); ?></a></li> -->
                            <li><a href="javascript:;" class="print-ad"><i class="fa fa-print"></i><?php esc_html_e( 'Print', 'classifieds' ); ?></a></li>
                            <li><a href="javascript:;" class="report-ad" data-toggle="modal" data-target="#report"><i class="fa fa-flag"></i><?php esc_html_e( 'Report Ad', 'classifieds' ); ?></a></li>
                            <li><a href="javascript:;" class="report-ad" data-toggle="modal" data-target="#"><i class="fa fa-shopping-bag"></i><?php esc_html_e( 'Add to Wishlist', 'classifieds' ); ?></a></li>
                        </ul>
                    </div>

                    <div class="price-block Flex--center">
                        <div class="ad-pricing margin-right-20">
                            <?php classifieds_get_price( get_the_ID() ) ?>
                        </div>
                        <a href="javascript:;" class="ask-question btn btn-success" data-toggle="modal" data-target="#question">
                            <?php esc_html_e( 'Send Message', 'classifieds' ); ?>
                        </a>                        
                    </div>
                </div>

                <?php if( $single_ad_side_position  == 'pos-2') { get_sidebar('ad'); } ?>

                <?php
                $ad_display_map = get_post_meta( get_the_ID(), 'ad_display_map', true );
                if( $ad_display_map == 'yes' ):
                    ?>
                    <div class="widget white-block">
                        <h4><i class="fa fa-map-marker"></i> <?php esc_html_e( 'On map', 'classifieds' ) ?></h4>

                        <div id="single-map">
                            <div class="hidden">
                                <?php echo get_post_meta( get_the_ID(), 'ad_gmap_latitude', true ) ?>|<?php echo get_post_meta( get_the_ID(), 'ad_gmap_longitude', true ) ?>|<?php echo classifieds_get_cat_icon() ?>
                            </div>
                        </div>
                    </div>
                <?php
                endif;
                ?>

                <?php if( $single_ad_side_position  == 'pos-3') { get_sidebar('ad'); } ?>

                <?php
                $similar_ads = classifieds_get_option( 'similar_ads' );
                if( !empty( $similar_ads ) ){
                    $cats = get_the_terms( get_the_ID(), 'ad-category' );
                    $cats_list = array();
                    if( !empty( $cats ) ){
                        foreach( $cats as $cat ){
                            $cats_list[] = $cat->slug;
                        }
                    }
                    $args = array(
                        'post_type' => 'ad',
                        'posts_per_page' => $similar_ads,
                        'post__not_in' => array( get_the_ID() ),
                        'post_status' => 'publish',
                        'tax_query' => array(
                            'taxonomy' => 'ad-category',
                            'field' => 'slug',
                            'terms' => $cats_list
                        ),
                        'meta_query' => array(
                            array(
                                'key' => 'ad_expire',
                                'value' => current_time( 'timestamp' ),
                                'compare' => '>='
                            )
                        )
                    );
                    
                    $similar = new WP_Query( $args );
                    if( $similar->have_posts() ){
                        ?>
                        <div class="widget white-block">
                            <h4><i class="fa fa-circle-o"></i> <?php esc_html_e( 'Similar Ads', 'classifieds' ) ?></h4>
                            
                            <ul class="list-unstyled similar-ads">
                            <?php
                                while( $similar->have_posts() ){
                                    $similar->the_post();
                                    ?>
                                    <li>
                                        <div class="white-block ad-box ad-box-alt">
                                            <div class="media">
                                                <a href="<?php the_permalink() ?>" class="pull-left">
                                                    <?php the_post_thumbnail( 'classifieds-similar-ads' ) ?>
                                                </a>
                                                <div class="media-body">
                                                    <a href="<?php the_permalink() ?>">
                                                        <h5><?php the_title(); ?></h5>
                                                    </a>
                                                    <p></p>
                                                    <p><?php classifieds_get_price( get_the_ID() ); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <?php
                                }
                            ?>
                            </ul>
                        </div>                        
                        <?php   
                    }

                    wp_reset_postdata();
                }
                ?>

                <?php if( $single_ad_side_position  == 'pos-4' || empty( $single_ad_side_position ) ) { get_sidebar('ad'); } ?>

            </div>

        </div>
    </div>
</section>
<?php
get_footer();
?>