<?php

	$pagination_html = '<ul class="group">';

	//previous page link
	$previous_link = get_previous_posts_link();
	if( '' != $previous_link ) {
		$pagination_html .= '<li class="prev left">' . $previous_link . '</li>';
	}

	//clickable page numbers
	$pagination_html .= '<li>' . get_the_posts_pagination( array(
		'mid_size'  => 2,
		'prev_next' => false,
	) ) . '</li>';

	//next page link
	$next_link = get_next_posts_link();
	if( '' != $next_link ) {
		$pagination_html .= '<li class="next right">' . $next_link . '</li>';
	}

	//sentence "Showing 1 to 10 of 99 posts"
	$posts_per_page = $wp_query->query_vars['posts_per_page'];
	$page_number = null == $wp_query->query_vars['paged'] ? 1 : $wp_query->query_vars['paged'];
	$start_index = $page_number * $posts_per_page - ( $posts_per_page - 1);
	$end_index = min( array( $start_index + $posts_per_page - 1, $wp_query->found_posts ) );

	$object_name = 'posts';
	$post_type_name = isset( $wp_query->query_vars['post_type'] ) ? $wp_query->query_vars['post_type'] : '';
	if( '' != $post_type_name ) {
		$post_type = get_post_type_object( $post_type_name );
		$object_name = 	strtolower( $post_type->labels->name );
	}

	$pagination_html .= '</ul><p>'
		. apply_filters( 'invp_pagination_sentence', sprintf( 'Showing %d to %d of %d %s', $start_index, $end_index, $wp_query->found_posts, $object_name ) )
		. '</p>';
?>
<nav class="pagination group"><?php
	echo apply_filters( 'invp_pagination_html', $pagination_html );
?></nav>