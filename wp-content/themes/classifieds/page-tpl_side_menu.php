<?php
/*
    Template Name: Side Menu Template
*/
get_header();
the_post();
get_template_part( 'includes/title' );
?>
<section>
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="text-center">
                    <?php 
                    $page_id = classifieds_top_parent( get_the_ID() );
                    if( has_post_thumbnail( $page_id ) ){
                        echo get_the_post_thumbnail( $page_id, 'full' );
                    }
                    ?>
                </div>
                <div class="white-block">
                    <div class="row ">
                        <div class="col-md-4">
                            <div class="page-side-menu">
                                <ol>
                                    <?php echo classifieds_generate_side_menu(); ?>
                                </ol>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="white-block-content">
                                <div class="page-content clearfix">
                                    <?php the_content() ?>
                                </div>
                            </div>                        
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<?php get_footer(); ?>