<?php
global $classifieds_slugs;
if( $subpage == 'delete_ad' ){
	$ad = wp_delete_post( $_GET['ad_id'], true );
	if( $ad ){
		$mesage = '<div class="alert alert-success">'.esc_html__( 'Ad ', 'classifieds' ).'<strong>'.$ad->post_title.'</strong>'.esc_html__( ' has been deleted.', 'classifieds' ).'</div>';
	}
}

if( get_query_var( 'paged' ) ){
	$cur_page = get_query_var( 'paged' );
}
else if( get_query_var( 'page' ) ){
	$cur_page = get_query_var( 'page' );
}
else{
	$cur_page = 1;
}

$my_ads_args = array(
	'post_type' => 'ad',
	'post_status' => 'publish,draft',
	'post_parent' => '0',
	'author' => $current_user->ID,
	'paged' => $cur_page,
	'posts_per_page' => classifieds_get_option( 'author_profile_ads_per_page' )
);

$filter = !empty( $_GET['filter'] ) ? $_GET['filter'] : '';
if( $filter == 'pending' ){
	$my_ads_args['post_status'] = 'draft';
}
else if( $filter == 'expired' ){
	$my_ads_args['meta_query'] = array(
		array(
			'key' => 'ad_expire',
			'value' => current_time( 'timestamp' ),
			'compare' => '<'
		)
	);
}
else if( $filter == 'active' ){
	$my_ads_args['post_status'] = 'publish';
	$my_ads_args['meta_query'] = array(
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
	);
}
else if( $filter == 'off' ){
	$my_ads_args['meta_query'] = array(
		array(
			'key' => 'ad_visibility',
			'value' => 'no',
			'compare' => '='
		)
	);	
}
else if( $filter == 'not_paid' ){
	$my_ads_args['meta_query'] = array(
		array(
			'key' => 'ad_paid',
			'value' => 'no',
			'compare' => '='
		)
	);	
}

$my_ads = new WP_Query( $my_ads_args );


$page_links_total =  $my_ads->max_num_pages;
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

?>
<div class="white-block">
	<div class="white-block-content">
		<div class="clearfix">
			<div class="pull-left">
				<h4><i class="fa fa-list-alt"></i> <?php esc_html_e( 'My Ads', 'classifieds' ) ?></h4>
			</div>
			<div class="pull-right">
				<div class="search-form">
					<ul class="list-inline list-unstyled">
						<li>
							<a href="<?php echo esc_attr( remove_query_arg( array( 'filter' ), $permalink ) ) ?>" class="my-ads-filter <?php echo empty( $filter ) ? esc_attr__( 'active' ) : '' ?>" data-value=""><?php esc_html_e( 'All', 'classifieds' ) ?></a>
						</li>
						<li>
							<a href="<?php echo esc_attr( add_query_arg( array( 'filter' => 'pending' ), $permalink ) ) ?>" class="my-ads-filter <?php echo $filter == 'pending' ? esc_attr__( 'active' ) : '' ?>" data-value="pending"><?php esc_html_e( 'Pending', 'classifieds' ) ?></a>
						</li>
						<li>
							<a href="<?php echo esc_attr( add_query_arg( array( 'filter' => 'expired' ), $permalink ) ) ?>" class="my-ads-filter <?php echo $filter == 'expired' ? esc_attr__( 'active' ) : '' ?>" data-value="expired"><?php esc_html_e( 'Expired', 'classifieds' ) ?></a>
						</li>
						<li>
							<a href="<?php echo esc_attr( add_query_arg( array( 'filter' => 'active' ), $permalink ) ) ?>" class="my-ads-filter <?php echo $filter == 'active' ? esc_attr__( 'active' ) : '' ?>" data-value="active"><?php esc_html_e( 'Active', 'classifieds' ) ?></a>
						</li>
<!-- 						<li>
							<a href="<?php echo esc_attr( add_query_arg( array( 'filter' => 'off' ), $permalink ) ) ?>" class="my-ads-filter <?php echo $filter == 'off' ? esc_attr__( 'active' ) : '' ?>" data-value="off"><?php esc_html_e( 'Off', 'classifieds' ) ?></a>
						</li>
						<li>
							<a href="<?php echo esc_attr( add_query_arg( array( 'filter' => 'not_paid' ), $permalink ) ) ?>" class="my-ads-filter <?php echo $filter == 'not_paid' ? esc_attr__( 'active' ) : '' ?>" data-value="not_paid"><?php esc_html_e( 'Not Paid', 'classifieds' ) ?></a>
						</li> -->
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="payment-return-info">
    <?php
    if( !empty( $message ) ){
        echo  $message;
    }    
    $message = get_transient( 'classifieds_payment_result' );
    delete_transient( 'classifieds_payment_result' );
    if( !empty( $message ) ){
        echo  $message;
    }
    ?>
</div>

<?php 
if( $my_ads->have_posts() ){
	while( $my_ads->have_posts() ){
		$my_ads->the_post();

		$ad_paid = get_post_meta( get_the_ID(), 'ad_paid', true );

		$ad_visibility = get_post_meta( get_the_ID(), 'ad_visibility', true );

		$ad_lasts_for = classifieds_get_option( 'ad_lasts_for' );
		$ad_expire = get_post_meta( get_the_ID(), 'ad_expire', true );
		$is_expired = false;
		if( current_time( 'timestamp' ) > $ad_expire ){
			$is_expired = true;
		}

		?>
		<div class="white-block ad-box ad-box-alt <?php echo $is_expired ? esc_attr__( 'expired' ) : '' ?>">
			<div class="media">
				<a class="pull-left" href="<?php the_permalink(); ?>" target="blank">
					<?php
					if( has_post_thumbnail() ){
						the_post_thumbnail( 'thumbnail', array( 'class' => 'img-responsive' ) );
					}
					else{
						classifieds_get_placeholder_image( 'thumbnail' );
					}
					?>
					<div class="ad-views">
						<i class="fa fa-eye"></i>
						<?php classifieds_ad_views(); ?>
					</div>
				</a>
				<div class="media-body">
					<a href="<?php the_permalink(); ?>" target="blank">
						<h5><?php the_title() ?></h5>
					</a>

					<?php
					$excerpt = get_the_excerpt();
					if( strlen( $excerpt ) > 123 ){
						$excerpt = substr( $excerpt, 0, 123 ).'...';
					}
					echo '<p>'.$excerpt.'</p>';
					?>

					<p><?php classifieds_get_price( get_the_ID() ) ?></p>

					<a href="<?php echo esc_url( add_query_arg( array( $classifieds_slugs['subpage'] => 'edit_ad', 'ad_id' => get_the_ID(0) ) ) ) ?>">
						<?php esc_html_e( 'Edit ', 'classifieds' ) ?><i class="fa fa-long-arrow-right"></i>
					</a>

					<?php if( get_post_status() == 'draft' && $ad_paid == 'no' ):?>
						<div class="expire-badge pending-payment">
							<?php esc_html_e( 'NOT PAID', 'classifieds' ); ?>
						</div>						
					<?php elseif( get_post_status() == 'draft' ): ?>
						<div class="expire-badge pending-badge">
							<?php esc_html_e( 'PENDING', 'classifieds' ); ?>
						</div>	
					<?php elseif( $is_expired ): ?>
						<div class="expire-badge">
							<?php esc_html_e( 'EXPIRED', 'classifieds' ); ?>
						</div>
					<?php elseif( $ad_visibility == 'no' ): ?>
						<div class="expire-badge off-badge">
							<?php esc_html_e( 'OFF', 'classifieds' ); ?>
						</div>						
					<?php else: ?>
						<div class="expire-badge time-badge">
							<?php echo date_i18n( 'M j, Y - H:i', $ad_expire ); ?>
						</div>
					<?php endif; ?>

				</div>
			</div>
		</div>
		<?php
	}
}
else{
	?>
	<div class="white-block">
		<div class="white-block-content">
			<?php esc_html_e( 'You do not have any created ads to display.', 'classifieds' ); ?>
		</div>
	</div>
	<?php
}
?>

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
wp_reset_postdata();
?>