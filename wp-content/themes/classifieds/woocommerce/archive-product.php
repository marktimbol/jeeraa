<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$show_woocommerce_sidebar = classifieds_get_option( 'show_woocommerce_sidebar' );

get_header( 'shop' ); ?>
<div class="container">
	<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

		<div class="clearfix">
			<div class="pull-left">
				<h1 class="page-title"><?php woocommerce_page_title(); ?></h1>
			</div>
			<div class="pull-right">





				<?php  woocommerce_breadcrumb(); ?>
			</div>
		</div>




	<?php endif; ?>
	<div class="row">
		<div class="col-md-<?php echo is_active_sidebar( 'shop-sidebar' ) && $show_woocommerce_sidebar == 'yes' ? esc_attr__( '9 product-3' ) : esc_attr__( '12' ) ?>">
	<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		 remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
		do_action( 'woocommerce_before_main_content' );
	?>


		<?php
			/**
			 * woocommerce_archive_description hook
			 *
			 * @hooked woocommerce_taxonomy_archive_description - 10
			 * @hooked woocommerce_product_archive_description - 10
			 */
			do_action( 'woocommerce_archive_description' );
		?>

		<?php if ( have_posts() ) : ?>
			<div class="white-block woo-count">
				<div class="white-block-content clearfix">
					<?php
						/**
						 * woocommerce_before_shop_loop hook
						 *
						 * @hooked woocommerce_result_count - 20
						 * @hooked woocommerce_catalog_ordering - 30
						 */
						do_action( 'woocommerce_before_shop_loop' );
					?>
				</div>
			</div>			

			<?php woocommerce_product_loop_start(); ?>

				<?php woocommerce_product_subcategories(); ?>


				<?php while ( have_posts() ) : the_post(); ?>

					<?php wc_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>

			<?php
				/**
				 * woocommerce_after_shop_loop hook
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
			?>

		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php wc_get_template( 'loop/no-products-found.php' ); ?>


		<?php endif; ?>

	<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>



		</div>
		<?php if( $show_woocommerce_sidebar == 'yes' ): ?>
			<div class="col-md-3">
				<?php get_sidebar( 'shop' ); ?>
			</div>
		<?php endif; ?>
	</div>
</div>
<?php get_footer( 'shop' ); ?>
