<form method="get" class="search-form" action="<?php echo site_url('/'); ?>">
	<input type="text" class="form-control" id="search" name="s" placeholder="<?php esc_html_e( 'Type search term here...', 'classifieds' ) ?>">
	<a href="javascript:;" class="submit-form">
		<i class="fa fa-search"></i>
	</a>
	<input type="hidden" name="post_type" value="post" />
</form>