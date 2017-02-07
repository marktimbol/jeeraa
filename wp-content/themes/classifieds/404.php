<?php 
	get_header(); 
	get_template_part( 'includes/title' );
?>
<section class="error404">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="white-block top-border">
					<h1><?php esc_html_e( '404', 'classifieds' ) ?></h1>
					<h4><?php esc_html_e( 'Sorry but page you are looking for doesn\'t exist!', 'classifieds' ); ?></h4>
					<form role="search" method="get" class="search-form" action="<?php echo site_url('/'); ?>">
						<input type="text" class="form-control" id="search" name="s" placeholder="<?php esc_html_e( 'Try to search', 'classifieds' ) ?>">
						<input type="hidden" name="post_type" value="post" />
						<a href="javascript:;" class="form-submit btn"><?php esc_html_e( 'GO', 'classifieds' ) ?></a>
					</form>					
				</div>
			</div>
		</div>
	</div>
</section>
<?php get_footer(); ?>