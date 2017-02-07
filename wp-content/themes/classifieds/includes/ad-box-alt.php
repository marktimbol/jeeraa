<div class="white-block ad-box ad-box-alt">
	<div class="media">
		<a class="pull-left" href="<?php the_permalink(); ?>" target="blank">
			<?php
			echo '<div class="ad-badges">';
				classifieds_get_featured_badge( get_the_ID() );
				classifieds_get_verified_badge( get_the_author_meta( 'ID' ) );

			echo '</div>';
			?>
			<?php 
			if( has_post_thumbnail() ){
				the_post_thumbnail( 'classifieds-ad-box-alt' );
			}
			else{
				classifieds_get_placeholder_image( 'classifieds-ad-box-alt' );
			}
			?>
		</a>
		<div class="media-body">
			<a href="<?php the_permalink() ?>">
				<h5><?php the_title(); ?></h5>
			</a>

			<?php
			$excerpt = get_the_excerpt();
			$excerpt_max = !empty( $excerpt_max ) ? $excerpt_max : 77;
			if( strlen( $excerpt ) > $excerpt_max ){
				$excerpt = substr( $excerpt, 0, $excerpt_max ).'...';
			}
			echo '<p>'.$excerpt.'</p>';
			?>

			<p><?php classifieds_get_price( get_the_ID() ); ?></p>	
		</div>
	</div>
</div>