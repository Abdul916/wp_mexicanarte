<?php
add_filter( 'posts_where', 'avante_title_like_posts_where', 10, 2 );
function avante_title_like_posts_where( $where, $wp_query ) {
    global $wpdb;
    if ( $post_title_like = $wp_query->get( 'post_title_like' ) ) {
        $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( $wpdb->esc_like( $post_title_like ) ) . '%\'';
    }
    return $where;
}
	
	
/**
*	Setup AJAX search function
**/
add_action('wp_ajax_avante_ajax_search_result', 'avante_ajax_search_result');
add_action('wp_ajax_nopriv_avante_ajax_search_result', 'avante_ajax_search_result');

function avante_ajax_search_result() 
{
	global $wpdb;
	
	if(!isset($_POST['keyword']))
	{
		$_POST['keyword'] = $_POST['s'];
	}

	if (strlen($_POST['keyword'])>0) {
		$query_string.= $query_string = '&orderby=post_date&order=DESCe&suppress_filters=0&post_status=publish';
		parse_str($query_string, $args);
    
	    if(isset($_POST['keyword']) && !empty($_POST['keyword']))
	    {  
	    	$args['post_title_like'] = $_POST['keyword'];
	    }
	    
	    if(isset($_POST['search_course']) && !empty($_POST['search_course']))
	    {  
	    	$args['post_type'] = 'lp_course';
	    }
	    
	    $args['post_type'] = 'any';
	    $args['orderby'] = 'post_title';
		$args['order'] = 'ASC';
	    $args['posts_per_page'] = 10;

	    query_posts($args);
	    echo '<ul>';
	 	
	 	if (have_posts()) : while (have_posts()) : the_post();
	 		
	 		$course_ID_ID = get_the_ID();
	 		$course_title = get_the_title();
	 		$course_title = avante_highlight_keyword($course_title, $_POST['keyword']);
	 		
			echo '<li>';
			echo '<a href="'.get_permalink($course_ID_ID).'">';
			echo $course_title;
			echo '</a>';
			echo '</li>';
	
		endwhile;
		endif;
		
		echo '</ul>';
	}
	else 
	{
		echo '';
	}
	die();

}
/**
*	End theme custom AJAX calls handler
**/
?>