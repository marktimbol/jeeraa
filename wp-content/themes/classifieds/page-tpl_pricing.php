<?php
/*
	Template Name: Pricing
*/
get_header();
the_post();
get_template_part( 'includes/title' );
?>
<?php the_content(); ?>
<section>
    <div class="container">
        <?php echo do_shortcode( '[pricings][/pricings]' ) ?>
    </div>
</section>
<?php get_footer(); ?>