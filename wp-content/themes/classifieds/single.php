<?php
/*==================
 SINGLE BLOG POST
==================*/

get_header();
the_post();
get_template_part( 'includes/title' );

$post_pages = classifieds_link_pages();
?>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-<?php echo is_active_sidebar( 'sidebar-blog' ) ? '8' : '12' ?>">
                <div class="white-block">
                    <?php
                    if( classifieds_has_media() ){
                        ?>
                        <div class="white-block-media">
                            <?php get_template_part( 'media/media', get_post_format() ); ?>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="white-block-content blog-item-content">
                        <div class="top-meta">
                            <?php the_time( get_option( 'date_format' ) ) ?>
                            <?php esc_html_e( ' by ', 'classifieds' ); the_author_meta( 'display_name' ); ?>
                            <?php
                            $categories = classifieds_categories_list();
                            if( !empty( $categories ) ):
                            ?>
                                <?php esc_html_e( ' in ', 'classifieds' ); echo  $categories; ?>
                            <?php
                            endif;
                            ?>                            
                        </div>

                        <h3 class="blog-title"><?php the_title(); ?></h3>

                        <?php the_content(); ?>
                    </div>

                </div>

                <?php
                if( !empty( $post_pages ) ){
                    ?>
                    <div class="text-center">
                        <ul class="pagination">
                            <?php echo  $post_pages; ?>
                        </ul>
                    </div>
                    <?php
                }
                ?>

                <?php
                $tags = classifieds_tags_list();
                if( !empty( $tags ) ):
                ?>
                    <div class="white-block tags-list">
                        <div class="white-block-content">
                            <i class="fa fa-tags icon-margin"></i>
                            <?php echo  $tags; ?>
                        </div>
                    </div>
                <?php
                endif;
                ?>

                <?php comments_template( '', true ); ?>

            </div>

            <?php  get_sidebar(); ?>

        </div>
    </div>
</section>

<?php
get_footer();
?>