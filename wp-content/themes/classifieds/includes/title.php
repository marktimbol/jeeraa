<?php if( !is_single() && !is_author() ): ?>
<section class="page-title">
	<div class="container">
		<div class="clearfix">
			<div class="pull-left">
				<h1>
					<?php
						if ( is_category() ){
							echo single_cat_title();
						}
						else if( is_404() ){
							esc_html_e( '404 Page Doesn\'t exists', 'classifieds' );
						}
						else if( is_tag() ){
							echo esc_html__('Search results for: ', 'classifieds'). get_query_var('tag'); 
						}
						else if( is_author() ){
							esc_html_e('Posts by ', 'classifieds'); 
							echo get_the_author_meta( 'display_name' );
						}                       
						else if( is_archive() ){
							echo esc_html__('Archive for:', 'classifieds'). single_month_title(' ',false); 
						}
						else if( is_search() ){ 
							echo esc_html__('Search results for: ', 'classifieds').' '. get_search_query();
						}
						else if( is_front_page() || is_home() ){
							if( !class_exists('ReduxFramework') ){
								bloginfo( 'name' );
							}
							else{
								echo get_the_title( get_option('page_for_posts' ) );
							}
						}
						else{
							the_title();
						}						
					?>
				</h1>
			</div>
			<div class="pull-right">
				<?php echo classifieds_get_breadcrumbs(); ?>
			</div>
		</div>
	</div>
</section>
<?php else: ?>
<section class="page-title">
	<div class="container">
		<?php echo classifieds_get_breadcrumbs(); ?>
	</div>
</section>
<?php endif; ?>