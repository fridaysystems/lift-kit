<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package _dealer
 */

$vehicle = new Inventory_Presser_Vehicle(get_the_ID());

$summary_template = '<div class="vehicle-summary-item"><div class="vehicle-summary-item-label">%s:</div><div class="vehicle-summary-item-value">%s</div></div>';
$vehicle_info_top = '';
$vehicle_info_bottom = '';

// Book Value
if (method_exists($vehicle, 'get_book_value') && ( ! isset( $GLOBALS['_dealer_settings']['price_display_type'] ) || $GLOBALS['_dealer_settings']['price_display_type'] != 'genes' ) ) {
	$book_value = $vehicle->get_book_value();
	if( $book_value > 0  && $book_value > intval($vehicle->price) ) {
		$vehicle_info_top .= sprintf($summary_template,'Book Value','$'.number_format($book_value, 0, '.', ',' ));
	}
}

// MSRP
if (isset( $GLOBALS['_dealer_settings']['msrp_label'] ) && $GLOBALS['_dealer_settings']['msrp_label'] && isset($vehicle->prices['msrp']) && $vehicle->prices['msrp']) {
	$vehicle_info_top .= sprintf($summary_template,$GLOBALS['_dealer_settings']['msrp_label'],number_format($vehicle->prices['msrp'], 0, '.', ',' ));
}
// Odometer
if ($vehicle->odometer( ' ' . apply_filters( 'invp_odometer_word', 'Miles' ) ) && $vehicle->type != 'boat') {
	$vehicle_info_top .= sprintf( $summary_template, apply_filters( 'invp_odometer_word', 'Mileage' ), $vehicle->odometer( ' ' . apply_filters( 'invp_odometer_word', 'Miles' ) ) );
}
// Exterior Color
if ($vehicle->color) {
	$vehicle_info_top .= sprintf($summary_template,'Exterior','<span class="vehicle-content-initcaps">'.strtolower($vehicle->color).'</span>');
}
// Interior Color
if ($vehicle->interior_color) {
	$vehicle_info_top .= sprintf($summary_template,'Interior','<span class="vehicle-content-initcaps">'.strtolower($vehicle->interior_color).'</span>');
}
// stock #
if ($vehicle->stock_number) {
	$vehicle_info_top .= sprintf($summary_template,'Stock',$vehicle->stock_number);
}

//BOTTOM
//Engine
if ($vehicle->fuel || $vehicle->engine) {
	$vehicle_info_bottom .= sprintf($summary_template,'Engine',implode(' ', array($vehicle->fuel,$vehicle->engine)));
}
//Transmission
if ($vehicle->transmission) {
	$vehicle_info_bottom .= sprintf($summary_template,'Transmission','<span class="vehicle-content-initcaps">'.strtolower($vehicle->transmission).'</span>');
}
// drive type
if ($vehicle->drivetype) {
	$vehicle_info_bottom .= sprintf($summary_template,'Drive Type',$vehicle->drivetype);
}
// vin
if ($vehicle->vin) {
	$vehicle_info_bottom .= sprintf($summary_template,'boat' == $vehicle->type ? 'HIN' : 'VIN', $vehicle->vin);
}

//Boat-specific fields
if( 'boat' == $vehicle->type ) {
	//Beam
	if ( $vehicle->beam ) {
		$vehicle_info_bottom .= sprintf($summary_template,'Beam',$vehicle->beam);
	}
	//Length
	if ( $vehicle->length ) {
		$vehicle_info_bottom .= sprintf($summary_template,'Length',$vehicle->length);
	}
	//Hull material
	if ( $vehicle->hull_material ) {
		$vehicle_info_bottom .= sprintf($summary_template,'Hull Material',$vehicle->hull_material);
	}
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post-vehicle'); ?>>

	<div class="vehicle-tbl vehicle-tbl-top">

		<div class="vehicle-row">

			<div class="vehicle-cell">
				<h2 class="post-title hpad">
					<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a>
				</h2>
			</div>
			<div class="vehicle-cell">

				<?php include(locate_template('template-parts/content-vehicle-price.php')); ?>

			</div>
		</div>

	</div>

	<div class="vehicle-tbl vehicle-tbl-bottom">

		<div class="vehicle-row">
			<div class="vehicle-cell vehicle-cell-set">
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
					<?php if ( has_post_thumbnail() ): ?>
						<?php the_post_thumbnail('large'); ?>
					<?php else: ?>
						<img class="no-photo-available" src="<?php echo get_template_directory_uri(); ?>/img/thumb-standard.png" alt="<?php the_title(); ?>" />
					<?php endif; ?>
				</a>
			</div>
			<div class="vehicle-cell vehicle-summary-twocol">
				<div class="vehicle-summary">
					<?php echo $vehicle_info_top ?>
				</div>
			</div>
			<div class="vehicle-cell vehicle-summary-twocol">
				<div class="vehicle-summary">
					<?php echo $vehicle_info_bottom ?>
				</div>
			</div>
			<div class="vehicle-cell vehicle-summary-onecol">
				<div class="vehicle-summary">
					<?php echo $vehicle_info_top ?>
					<?php echo $vehicle_info_bottom ?>
				</div>
			</div>
			<div class="vehicle-cell vehicle-cell-set">
				<?php if ( isset( $GLOBALS['_dealer_settings']['use_carfax'] ) && isset( $GLOBALS['_dealer_settings']['use_carfax'] ) ) { //carfax
					?><div class="carfax-wrapper"><?php
					echo $vehicle->carfax_icon_html();
				?></div><?php
				} ?>

				<?php
				/**
				 * CarGurus
				 * If an add-on plugin "CarGurus Badge" is active, this
				 * shortcode will exist
				 */
				if ( shortcode_exists( 'invp_cargurus_badge' ) ) {
					do_shortcode( '[invp_cargurus_badge]' );
				} ?>

				<a class="_button _button-small _button-block" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">View Details</a>
			</div>
		</div>

	</div>
</article><!--/.post-->
