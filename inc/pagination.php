<?php

	$count_inventory = wp_count_posts('inventory_vehicle');
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