<ul class="list-unstyled share-networks animation <?php echo is_singular( 'post' ) ? 'opened' : ''; ?>">
	<li>
		<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode( get_permalink() ) ?>" class="share facebook" target="_blank">
		    <i class="fa fa-facebook"></i>
		</a>
	</li>
	<li>
		<a href="http://twitter.com/intent/tweet?text=<?php echo urlencode( get_permalink() ) ?>" class="share twitter" target="_blank">
		    <i class="fa fa-twitter"></i>
		</a>
	</li>
	<li>
		<a href="https://plus.google.com/share?url=<?php echo urlencode( get_permalink() ) ?>" class="share google-plus" target="_blank">
		    <i class="fa fa-google-plus"></i>
		</a>
	</li>
	<li>
		<a href="mailto:your@friend.com" class="share">
		    <i class="fa fa-envelope"></i>
		</a>
	</li>	
</ul>