<?php
/*
    Template Name: Page Left Sidebar
*/
get_header();
the_post();
get_template_part( 'includes/title' );
?>
<section>
    <div class="container">
        <div class="row">

            <?php get_sidebar('left') ?>

            <div class="col-md-8">
                <div class="white-block">
                    <?php 
                    if( has_post_thumbnail() ){
                        the_post_thumbnail( 'post-thumbnail' );
                    }
                    ?>

                    <div class="white-block-content">
                        <div class="page-content clearfix">
                            <?php the_content() ?>
                        </div>
                    </div>

                </div>

                <?php comments_template( '', true ); ?>
                
            </div>

        </div>
    </div>
</section>
<?php get_footer(); ?>