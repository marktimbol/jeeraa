<?php
$post_meta = get_post_custom();
$post_id = get_the_ID();
$blockquote = get_post_meta( $post_id, 'blockquote', true );
$cite = get_post_meta( $post_id, 'cite', true );
?>
<div class="embed-responsive embed-responsive-16by9">
	<?php the_post_thumbnail( 'post-thumbnail', array( 'class' => 'embed-responsive-item' ) ) ?>
	<div class="link-overlay"></div>
	<div class="media-text-overlay">
		<?php if( !empty( $blockquote ) ): ?>
			<blockquote>
				<h2>
					<a href="<?php the_permalink() ?>">
						<?php echo  $blockquote ?>
					</a>
				</h2>
				<?php if( !empty( $cite ) ): ?>
					<cite class="pull-left">
						<?php echo  $cite; ?>
					</cite>
					<div class="clearfix"></div>
				<?php endif; ?>				
			</blockquote>
		<?php endif; ?>
	</div>
</div>