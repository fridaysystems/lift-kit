<?php
/**
 * The template for displaying all single vehicles.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package lift-kit
 */

get_header(); ?>

	<div id="primary" class="content-area cf">

		<main id="main" class="site-main" role="main">

		<?php
		while ( have_posts() ) : the_post();

			get_template_part( 'template-parts/content', 'single_vehicle');

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->
<?php
// vehicle sidebar
if( is_active_sidebar( 'sidebar-single-vehicle-right-column' ) ) {
	?><aside id="secondary" class="sidebar widget-area" role="complementary"><?php
	dynamic_sidebar( 'sidebar-single-vehicle-right-column' );
	?></aside><?php
} else {
	get_sidebar();
}
get_footer();
