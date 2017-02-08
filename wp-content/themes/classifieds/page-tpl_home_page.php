<?php
/*
    Template Name: Home Page
*/
get_header();
the_post();

$ad_cats = classifieds_get_organized( 'ad-category' );
$permalink = classifieds_get_permalink_by_tpl( 'page-tpl_search_page' );
$all_categories_count = classifieds_get_option( 'all_categories_count' );
global $classifieds_slugs;
?>

	<div class="Hero--container Flex--center">
	     <div class="Hero__content">
	     	<div class="Hero__title--container Flex--center">
		 		<h2>Give away things you don't need</h2>
		 		<p class="lead">There is something cool for everyone at Jeeraa</p>
	     	</div>
		     <div class="Hero__search">
		            <?php include( classifieds_load_path( 'includes/search-box.php' ) );?>
		     </div>     	
	     </div>
	</div>
<?php
the_content();

get_footer();