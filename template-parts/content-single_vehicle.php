<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package _dealer
 */

$vehicle = new Inventory_Presser_Vehicle(get_the_ID());

$image_url_lists = $vehicle->get_images_html_array( array( 'large', 'thumb' ) );

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post-vehicle single-vehicle'); ?>>

	<div class="vehicle-info">

		<div class="post-inner">

			<div class="post-thumbnail">
				<header class="entry-header hpad">
					<?php the_title( '<h1 class="post-title">', '</h1>' ); ?>
				</header><!-- .entry-header -->

				<?php // image display area, uses flexslider 2 http://flexslider.woothemes.com/ ?>
				<div class="vehicle-images">
					<div id="slider-width"></div>

					<div id="slider" class="flexslider">
					  <ul class="slides">
					  	<?php foreach( $image_url_lists['large'] as $image ): ?>
					    <li><?php echo $image ?></li>
					    <?php endforeach; ?>
					  </ul>
					</div>

					<?php if ( count( $image_url_lists['thumb'] ) > 1 ) { ?>
					<div id="carousel" class="flexslider no-preview">
					  <ul class="slides">
					  	<?php foreach( $image_url_lists['thumb'] as $image): ?>
					    <li><?php echo $image ?></li>
					    <?php endforeach; ?>
					  </ul>
					</div>
					<?php } ?>
				</div>

				<div class="hpad">
					<div class="vehicle-content-wrap"><?php the_content(); ?></div>

					<?php // if there's a youtube video associated with this vehicle, embed it
					if ($vehicle->youtube) {
						echo wp_oembed_get('https://www.youtube.com/watch?v='.$vehicle->youtube);
					}
					?>

					<ul class="vehicle-features">
					    <?php // loop through list of vehicle options
					    foreach($vehicle->option_array as $option): ?>
					    <li><?php echo $option ?></li>
					    <?php endforeach; ?>
					</ul>

					<?php
						/**
						 * Maybe show an accordian of content if some
						 * filters add content to this empty array.
						 */
						$acc_arr = apply_filters( 'invp_accordian_content', array(), $vehicle->post_ID );
						if( 0 < sizeof( $acc_arr ) ) {
							echo '<div class="accordion cf"><ul class="accordion__wrapper">';
							foreach( $acc_arr as $title => $content ) {
								echo '<li class="accordion__item">'
									. '<input type="checkbox" checked>'
									. '<span class="dashicons dashicons-arrow-up-alt2"></span>'
									. '<h2>' . $title . '</h2>'
									. '<div class="panel">'
									. '<div class="panel-inner">'
									. $content
									. '</div>'
									. '</div>'
									. '</li>';
							}
							echo '</ul></div>';

							//A disclaimer about third party databases
							echo '<p><small>'
								. 'While every effort has been made to ensure the accuracy of this listing, some of the information this page was sourced from a third party rather than being entered by us as the sellers of this vehicle. ';
							if( $vehicle->is_used ) {
								echo 'Especially since this vehicle is used and could have been modified by a previous owner, it may not include the features or components listed on this page. ';
							}
							echo 'Please verify all statements and features with your sales representative before buying this vehicle.'
								. '</small></p>';
						}
					?>

					<?php
					// widget area, main column below vehicle
					if( is_active_sidebar( 'sidebar-below-single-vehicle' ) ) {
						dynamic_sidebar( 'sidebar-below-single-vehicle' );
					}
					?>
				</div>
			</div><!--/.post-thumbnail-->

			<div class="vehicle-content">

				<?php include(locate_template('template-parts/content-vehicle-price.php')); ?>

				<?php
				// if dealership has multiple locations, display the location of this vehicle
				if ( isset( $invp_lift_kit ) && $invp_lift_kit->have_multiple_locations() && $vehicle->location) {
							$location_msg = __( 'This can be seen at our ' ) . '<strong>' . $vehicle->location . '</strong>' . __( ' location.' );
							echo '<div class="vehicle-location">' . apply_filters( 'invp_vehicle_location_sentence', $location_msg, $vehicle->location ) . '</div>';
					} ?>

				<div class="vehicle-summary">

					<?php
					$summary_template = '<div class="vehicle-summary-item"><div class="vehicle-summary-item-label">%s:</div><div class="vehicle-summary-item-value">%s</div></div>';

					// Book Value
					$book_value = $vehicle->get_book_value();
					if( $book_value > 0  && $book_value > intval( $vehicle->price ) ) {
						echo sprintf( $summary_template, apply_filters( 'invp_label-book_value', 'Book Value' ), '$' . number_format( $book_value, 0, '.', ',' ) );
					}

					// MSRP
					if ( isset( $vehicle->msrp ) && $vehicle->msrp ) {
						$msrp = is_numeric( $vehicle->msrp ) ? number_format( $vehicle->msrp, 0, '.', ',' ) : $vehicle->msrp;
						echo sprintf(
							$summary_template,
							apply_filters( 'invp_label-msrp', 'MSRP' ),
							$msrp
						);
					}

					// Odometer
					if ( $vehicle->odometer( ' ' . apply_filters( 'invp_odometer_word', 'Miles' ) ) && $vehicle->type != 'boat' ) {
						echo sprintf(
							$summary_template,
							apply_filters( 'invp_label-odometer', apply_filters( 'invp_odometer_word', 'Mileage' ) ),
							$vehicle->odometer( ' ' . apply_filters( 'invp_odometer_word', 'Miles' ) )
						);
					}
					// Body style
					if( $vehicle->body_style ) {
						echo sprintf(
							$summary_template,
							apply_filters( 'invp_label-body_style', __( 'Body style', '_dealer' ) ),
							sprintf( '<span class="vehicle-content-initcaps">%s</span>', strtolower( $vehicle->body_style ) )
						);
					}
					// Exterior Color
					if ( $vehicle->color ) {
						echo sprintf(
							$summary_template,
							apply_filters( 'invp_label-color', 'Exterior' ),
							sprintf( '<span class="vehicle-content-initcaps">%s</span>', strtolower( $vehicle->color ) )
						);
					}
					// Interior Color
					if ( $vehicle->interior_color ) {
						echo sprintf(
							$summary_template,
							apply_filters( 'invp_label-interior_color', 'Interior' ),
							sprintf( '<span class="vehicle-content-initcaps">%s</span>', strtolower( $vehicle->interior_color ) )
						);
					}
					//Engine
					if ( $vehicle->fuel || $vehicle->engine ) {
						echo sprintf( $summary_template, apply_filters( 'invp_label-engine', 'Engine' ), implode( ' ', array( $vehicle->fuel, $vehicle->engine ) ) );
					}
					//Transmission
					if ( $vehicle->transmission ) {
						echo sprintf(
							$summary_template,
							apply_filters( 'invp_label-transmission', 'Transmission' ),
							sprintf( '<span class="vehicle-content-initcaps">%s</span>', strtolower( $vehicle->transmission ) )
						);
					}
					// drive type
					if ( $vehicle->drivetype ) {
						echo sprintf( $summary_template, apply_filters( 'invp_label-drivetype', 'Drive Type' ), $vehicle->drivetype );
					}
					// stock #
					if ( $vehicle->stock_number ) {
						echo sprintf( $summary_template, apply_filters( 'invp_label-stock_number', 'Stock' ), $vehicle->stock_number );
					}
					// vin
					if ( $vehicle->vin ) {
						echo sprintf( $summary_template, apply_filters( 'invp_label-vin', 'boat' == $vehicle->type ? 'HIN' : 'VIN' ), $vehicle->vin );
					}
					//Boat-specific fields
					if( 'boat' == $vehicle->type ) {
						//Beam
						if ( $vehicle->beam ) {
							echo sprintf( $summary_template, apply_filters( 'invp_label-beam', 'Beam' ), $vehicle->beam );
						}
						//Length
						if ( $vehicle->length ) {
							echo sprintf( $summary_template, apply_filters( 'invp_label-length', 'Length' ), $vehicle->length );
						}
						//Hull material
						if ( $vehicle->hull_material ) {
							echo sprintf( $summary_template, apply_filters( 'invp_label-hull_material', 'Hull Material' ), $vehicle->hull_material );
						}
					}

					?>
				</div>

				<?php
				// carfax
				$carfax_html = $vehicle->carfax_icon_html();
				if ( $invp_lift_kit->settings['use_carfax'] && '' != $carfax_html ) {
					?><div class="carfax-wrapper"><?php
					echo $carfax_html;
				?></div><?php
				}

				// autocheck icon
				echo do_shortcode( sprintf( '[autocheck_button vin="%s"]', $vehicle->vin ) );
?>
			</div><!--/.post-content-->

		</div><!--/.post-inner-->

	</div>
</article><!--/.post-->