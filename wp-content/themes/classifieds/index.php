<?php
get_header();
global $wp_query;
$cur_page = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; //get curent page

$page_links_total =  $wp_query->max_num_pages;
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
get_template_part( 'includes/title' );

?>
<section>
	<div class="container">
		<div class="row">
			<div class="col-md-<?php echo is_active_sidebar( 'sidebar-blog' ) ? '8' : '12' ?> ajax-container">

				<?php
				if( have_posts() ){
					while( have_posts() ){
						the_post();
						$has_media = classifieds_has_media();
						$post_format = get_post_format();
						?>
						<div <?php post_class( 'white-block'.( $has_media ? ' has-media' : '' ).''  ) ?>>
							<?php
							if( is_sticky() && !$has_media ){
								?>
								<div class="sticky-icon sticky-top">
									<i class="fa fa-paperclip"></i>
								</div>
								<?php
							}
							?>
							<?php if( $has_media ): ?>
								<div class="white-block-media">
									<?php get_template_part( 'media/media', $post_format ); ?>
									<?php
									if( is_sticky() ){
										?>
										<div class="sticky-icon">
											<i class="fa fa-paperclip"></i>
										</div>
										<?php
									}
									?>								
								</div>
							<?php endif; ?>
							<?php if( ( $post_format !== 'quote' && $post_format !== 'link' ) || !$has_media ): ?>
								<div class="white-block-content blog-item-content">
									<a href="<?php the_permalink() ?>">
										<h3 class="blog-title"><?php the_title() ?></h3>
									</a>
									<?php the_excerpt() ?>
								</div>
							<?php endif; ?>
						</div>
						<?php
					}
				}
				else{
					?>
					<div class="white-block">
						<div class="white-block-content">
							<?php esc_html_e( 'No posts found which match your search criteria.', 'classifieds' ); ?>
						</div>
					</div>
					<?php
				}
				?>

				<?php
				if( !empty( $pagination ) )	{
					$next = get_next_posts_link();
					if( !empty( $next ) ){
						$temp = explode( "href=\"", $next );
						$temp2 = explode( "\"", $temp[1] );		
					}
					else{
						$temp2[0] = '';
					}
					?> 
					<a href="javascript:;" class="load-more btn" data-next_link="<?php echo esc_url( $temp2[0] ); ?>">
						<?php esc_html_e( 'LOAD MORE POSTS', 'classifieds' ) ?>
					</a>
					<?php
				}
				?>

			</div>

			<?php get_sidebar(); ?>

		</div>
	</div>
</section>

<?php get_footer(); ?>