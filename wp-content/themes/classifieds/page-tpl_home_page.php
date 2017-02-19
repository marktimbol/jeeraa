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
	 		<h2>From good people to good people</h2>
	     </div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<?php include( classifieds_load_path( 'includes/search-box.php' ) );?>
		</div>
	</div>
<?php
the_content();

get_footer();