# Lift Kit
Lift Kit is a set of inventory listing and vehicle detail files that can be added to any WordPress theme to quickly achieve compatibility with Inventory Presser, a dealership website platform.

## How to use

- Use Lift Kit as a basis for a new child theme by adding a [header comment section](https://developer.wordpress.org/themes/basics/main-stylesheet-style-css/#example) to [style.css](style.css)
- Deploy in an existing theme by combining the contents of [style.css](style.css) and [functions.php](functions.php) with their existing counterparts and adding the remaining files


## Filter hooks

Our custom hooks are prefixed with `invp_`.

### `invp_pagination_html`
The HTML containing paging links at the bottom of vehicle archive pages is passed through this filter. This code sample is the entire contents of [inc/pagination.php](inc/pagination.php)


	<?php

	$count_inventory = wp_count_posts( 'inventory_vehicle' );
	$previous_link = get_previous_posts_link();
	$next_link = get_next_posts_link();

	$pagination_html = '<ul class="group">';
	if( '' != $previous_link ) {
		$pagination_html .= '<li class="prev left">' . $previous_link . '</li>';
	}
	if( '' != $next_link ) {
		$pagination_html .= '<li class="next right">' . $next_link . '</li>';
	}
	$pagination_html .= '</ul>'
		. sprintf( '<p>%d vehicles in inventory</p>', $count_inventory->publish );
	?>
	<nav class="pagination group"><?php
	echo apply_filters( 'invp_pagination_html', $pagination_html );
	?></nav>


### `invp_odometer_word`
Wraps the odometer unit words "Miles" and "Mileage" to allow the support of other units. This filter was introduced simultaneously with our add-on plugin, [Kilometers Instead of Miles](https://inventorypresser.com/products/plugins/kilometers-instead-of-miles/).

`apply_filters( 'invp_odometer_word', 'Miles' )`

### `invp_accordian_content`
Lift Kit's vehicle details page optionally includes a content accordian to display collapsible content. We like to use the accordian for data from third-parties like standard vehicle features or crash test ratings. This filter allows developers to modify content in the accordian.

`apply_filters( 'invp_accordian_content', array(), $vehicle->post_ID )`

### `invp_vehicle_location_sentence`
When there is more than one address in Inventory Presser's location taxonomy, a sentence is included on vehicle details pages identifying where the car is located. This filter wraps that sentence.

	$location_msg = __( 'This can be seen at our ' ) . '<strong>' . $vehicle->location . '</strong>' . __( ' location.' );
	echo '<div class="vehicle-location">' . apply_filters( 'invp_vehicle_location_sentence', $location_msg, $vehicle->location ) . '</div>';