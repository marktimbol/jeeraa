<div class="white-block ad-box">
	<div class="white-block-media">
		<?php
		echo '<div class="ad-badges">';
			classifieds_get_featured_badge( get_the_ID() );
			classifieds_get_verified_badge( get_the_author_meta( 'ID' ) );

		echo '</div>';
		?>
		<a href="<?php the_permalink() ?>">
			<?php 
			$image_size = !empty( $image_size ) ? $image_size : 'classifieds-ad-box';
			if( has_post_thumbnail() ){
				the_post_thumbnail( $image_size );
			}
			else{
				classifieds_get_placeholder_image( $image_size );
			}
			
			?>
		</a>
	</div>
	<div class="white-block-content">
		<a href="<?php the_permalink() ?>">
			<h5><?php the_title(); ?></h5>
		</a>
		<p><?php classifieds_get_price( get_the_ID() ); ?></p>
	</div>
</div>