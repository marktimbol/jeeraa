<?php
get_header();

$post_type = !empty( $_GET['post_type'] ) ? $_GET['post_type'] : '';
$filter = !empty( $_GET['filter'] ) ? $_GET['filter'] : '';
$cur_page = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; //get curent page
$curauth = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));
$userID = $curauth->ID;

if( $post_type == 'ad' ) {
	$author_ads_per_page = classifieds_get_option( 'author_ads_per_page' );

	$ads_query = array(
		'post_type' => 'ad',
		'posts_per_page' => $author_ads_per_page,
		'post_status' => 'publish',
		'paged' => $cur_page,
		'author' => $userID,
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
	        ),	        
		)		
	);

	if( $filter !== '' )
	{
		$ads_query['meta_query'] = array(
			array(
				'key' => 'ad_price',
				'value' => $filter,
			),			
		);
	}

	$ads = new WP_Query($ads_query);

	$page_links_total =  $ads->max_num_pages;
}
else{
	global $wp_query;
	$page_links_total =  $wp_query->max_num_pages;
}

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
		<?php
		if( $post_type == 'ad' ){
				$cover_image = get_user_meta( $userID, 'cover_image', true );
				if( !empty( $cover_image ) ){
					echo wp_get_attachment_image( $cover_image, 'full', array( 'class' => 'cover-image' ) );
				}

				$twitter = get_user_meta( $userID, 'twitter', true );
				$linkedin = get_user_meta( $userID, 'linkedin', true );
				$facebook = get_user_meta( $userID, 'facebook', true );
				$google = get_user_meta( $userID, 'google', true );

				$description = get_user_meta( $userID, 'description', true );				
			?>
			<div class="row">
				<div class="col-md-4">
	                <div class="widget white-block">
	                    <h4><i class="fa fa-pencil"></i> <?php esc_html_e( 'Author', 'classifieds' ); ?></h4>
	                

	                    <?php include( classifieds_load_path( 'includes/author-info.php' ) ); ?>
	                    <?php if( !empty( $twitter ) || !empty( $linkedin ) || !empty( $facebook ) || !empty( $google ) ): ?>
		                    <ul class="list-unstyled list-inline my-networks">
		                        <li><?php esc_html_e( 'Follow me: ', 'classifieds' ); ?></li>
		                        <?php if( !empty( $twitter ) ): ?>
		                            <li><a href="<?php echo esc_url( $twitter ) ?>" class="twitter"><i class="fa fa-twitter"></i></a></li>
		                        <?php endif; ?>
		                        <?php if( !empty( $linkedin ) ): ?>
		                            <li><a href="<?php echo esc_url( $linkedin ) ?>" class="linkedin"><i class="fa fa-linkedin"></i></a></li>
		                        <?php endif; ?>
		                        <?php if( !empty( $facebook ) ): ?>
		                            <li><a href="<?php echo esc_url( $facebook ) ?>" class="facebook"><i class="fa fa-facebook"></i></a></li>
		                        <?php endif; ?>
		                        <?php if( !empty( $google ) ): ?>
		                            <li><a href="<?php echo esc_url( $google ) ?>" class="google-plus"><i class="fa fa-google-plus"></i></a></li>
		                        <?php endif; ?>
		                    </ul>
	                    <?php endif; ?>

	                </div>
				</div>
				<div class="col-md-8">
					<div class="widget white-block">
						<h4><i class="fa fa-user"></i> <?php esc_html_e( 'About', 'classifieds' ); ?></h4>
						<?php echo apply_filters('the_content', $description) ?>
					</div>
				</div>
			</div>


	        <div class="row">
	            <?php
	            $counter = 0;
	            if( $ads->have_posts() ){
	                while( $ads->have_posts() ){
	                    $ads->the_post();
	                    if( $counter == 4 ){
	                        $counter = 0;
	                        echo '</div><div class="row">';
	                    }
	                    $counter++;
	                    ?>
	                    <div class="col-md-3 col-sm-6">
	                        <?php include( classifieds_load_path( 'includes/ad-box.php' ) ); ?>
	                    </div>
	                    <?php
	                }
	            }
	            else{
	            	?>
	            	<div class="col-md-12">
						<div class="white-block">
							<div class="white-block-content">
								<?php esc_html_e( 'Author does not have any created ads to display.', 'classifieds' ); ?>
							</div>
						</div>	            	
	            	</div>
	            	<?php
	            }
	            ?>
	        </div>

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
			<?php
			wp_reset_postdata();
		}
		else{
		?>
			<div class="row">
				<div class="col-md-<?php echo is_active_sidebar( 'sidebar-blog' ) ? '8' : '12' ?> ajax-container">

					<?php
					if( have_posts() ){
						while( have_posts() ){
							the_post();
							$has_media = classifieds_has_media();
							?>
							<div <?php post_class( 'white-block'.( $has_media ? ' has-media' : '' ).''  ) ?>>							
								<?php if( $has_media ): ?>
									<div class="white-block-media">
									<?php get_template_part( 'media/media', get_post_format() ); ?>
									</div>
								<?php endif; ?>
								<div class="white-block-content blog-item-content">
									<?php
									if( is_sticky() ){
										?>
										<div class="sticky-icon">
											<i class="fa fa-paperclip"></i>
										</div>
										<?php
									}								
									?>
									<a href="<?php the_permalink() ?>">
										<h3 class="blog-title"><?php the_title() ?></h3>
									</a>
									<?php the_excerpt() ?>
								</div>
							</div>
							<?php
						}
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
		<?php
		}
		?>
	</div>
</section>

<?php get_footer(); ?>