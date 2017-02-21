<div class="media">
	<?php
	$author_url = esc_url( add_query_arg( array('post_type' => 'ad'), get_author_posts_url( get_the_author_meta( 'ID' ) ) ) );
	if( isset( $userID ) ){
		$author_url = esc_url( add_query_arg( array('post_type' => 'ad'), get_author_posts_url( $userID ) ) );
	}
	?>
	<a class="pull-left" href="<?php echo $author_url ?>">
		<?php
		$userID = !empty( $userID ) ? $userID : get_the_author_meta('ID');
		$avatar_url = classifieds_get_avatar_url( get_avatar( $userID, 90 ) );
		if( !empty( $avatar_url ) ):
		?>
			<img src="<?php echo esc_url( $avatar_url ) ?>" class="img-responsive" alt="author" width="90" height="90"/>
		<?php
		endif;
		?>
		<?php classifieds_get_verified_badge( $userID ); ?>
	</a>
	<div class="media-body">
		<ul class="list-unstyled">
			<li>
				<i class="fa fa-user"></i> 
				<a href="<?php echo  $author_url ?>">
					<?php the_author_meta( 'display_name', $userID ); ?> <span title="<?php esc_attr_e( 'Posted Ads', 'classifieds' ) ?>">
						<span class="hidden">(<?php echo classifieds_count_ads_by_user( $userID ) ?>)</span>
					</span> 
				</a>
			</li>
			<li>
				<i class="fa fa-gift"></i> 
				<a href="<?=$author_url?>&filter=GIVEAWAY">
					Giveaways <span title="<?php esc_attr_e( 'Giveaway', 'classifieds' ) ?>"></span>
					(<?php echo classified_user_total_giveaways( $userID ) ?>) 
				</a>				
			</li>
			<li>
				<i class="fa fa-heart"></i> 
				<a href="<?=$author_url?>&filter=REQUEST">
					Requests <span title="<?php esc_attr_e( 'Request', 'classifieds' ) ?>"></span> 
					(<?php echo classified_user_total_requests( $userID ) ?>) 					
				</a>							
			</li>						
			<?php
			$city = get_user_meta( $userID, 'city', true );
			if( !empty( $city ) ):
			?>
				<li><i class="fa fa-map-marker"></i> <?php echo  $city ?></li>
			<?php endif; ?>
			<?php
			$phone_number = get_user_meta( $userID, 'phone_number', true );		
			if( is_singular( 'ad' ) ){
				$ad_phone = get_post_meta( get_the_ID(), 'ad_phone', true );
				if( !empty( $ad_phone ) ){
					$phone_number = $ad_phone;
				}
			}
			if( !empty( $phone_number ) ):
			?>
				<li><i class="fa fa-phone"></i>
				<?php 
				if( empty( $my_profile_sidebar ) ){
					echo classifieds_format_phones( $phone_number );
				}
				else{
					echo $phone_number;
				}
				?></li>
			<?php endif; ?>
		</ul>
	</div>
</div>