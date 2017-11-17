<?php
/**
 * The template for displaying archive vehicles.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package _dealer
 */

$_dealer_options['archive_templates'] = array(
		'archive_vehicle' => 'Default',
		'archive_shortwide' => 'Short & Wide',
);

$archive_template = get_theme_mod( 'archive_templates', current(array_keys($_dealer_options['archive_templates'])));

get_header(); ?>

	<div id="primary" class="content-area cf at-<?php echo $archive_template; ?>">

		<main id="main" class="site-main" role="main">

			<header class="entry-header hpad">
				<div class="entry-title">
					<div class="vehicle-archive-header">
						SORT
						<select class="inventory_sort">
							<option data-order="ASC" value="inventory_presser_make">Make A-Z</option>
							<option data-order="DESC" value="inventory_presser_make">Make Z-A</option>
							<option data-order="ASC" value="inventory_presser_price">Price Low</option>
							<option data-order="DESC" value="inventory_presser_price">Price High</option>
							<option data-order="ASC" value="inventory_presser_odometer">Mileage Low</option>
							<option data-order="DESC" value="inventory_presser_odometer">Mileage High</option>
							<option data-order="ASC" value="inventory_presser_year">Year Oldest</option>
							<option data-order="DESC" value="inventory_presser_year">Year Newest</option>
						</select>
					</div>
					<div class="vehicle-archive-header"><?php echo do_shortcode('[posts_per_page_drop_down]'); ?></div>
				</div>
			</header><!-- .entry-header -->

		<?php
		if ( have_posts() ) : ?>

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', $archive_template);

			endwhile;

			get_template_part('inc/pagination');

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
