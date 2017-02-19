<?php
/*
    Template Name: All Categories
*/
get_header();
the_post();
get_template_part( 'includes/title' );

$ad_cats = classifieds_get_organized( 'ad-category' );
$permalink = classifieds_get_permalink_by_tpl( 'page-tpl_search_page' );
$all_categories_count = classifieds_get_option( 'all_categories_count' );
global $classifieds_slugs;
?>

<section>
    <div class="container">

        <?php 
        $content = get_the_content();
        if( !empty( $content ) ):
        ?>
            <div class="white-block">
                <div class="white-block-content">
                    <div class="page-content clearfix">
                        <?php echo apply_filters( 'the_content', $content ) ?>
                    </div>
                </div>
            </div>
        <?php
        endif;
        ?>
            
        <div class="row masonry">
            <?php
            if( !empty( $ad_cats ) ){
                foreach( $ad_cats as $key => $cat){
                    ?>
                    <div class="col-sm-6 masonry-item">
                        <div class="white-block category-item">
                            <?php
                            $term_meta = get_option( "taxonomy_".$cat->slug );
                            $value = !empty( $term_meta['category_image'] ) ? $term_meta['category_image'] : '';
                            if( !empty( $value ) ){
                                echo wp_get_attachment_image( $value, 'classifieds-ad-box-all' );
                            }
                            ?>                        
                            <div class="clearfix">
                                <div class="category-item-content">
                                    <h4>
                                        <a href="<?php echo esc_url( add_query_arg( array( $classifieds_slugs['category'] => $cat->slug ), $permalink) ); ?>">
                                            <?php echo esc_html( $cat->name ); ?>
                                            <?php echo $all_categories_count == 'yes' ? '('.classifieds_category_count( $cat->slug ).')' : '' ?>
                                        </a>
                                    </h4>
                                    <?php if( !empty( $cat->children ) ){
                                        echo '<div class="category-subs">';
                                            $list = classifieds_display_tree( $cat, 'ad-category', $all_categories_count );
                                            echo join( $list, ', ' );
                                        echo '</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</section>
<?php get_footer(); ?>