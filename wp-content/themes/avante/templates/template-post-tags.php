<?php
 $tg_blog_display_tags = get_theme_mod('tg_blog_display_tags', true);

    if(has_tag() && !empty($tg_blog_display_tags))
    {
?>
    <div class="post-excerpt post-tag">
    	<?php
	    	if( $tags = get_the_tags() ) {
			    foreach( $tags as $tag ) {
			        echo '<a href="' .esc_url(get_term_link($tag, $tag->taxonomy)). '"><i class="far fa-bookmark"></i>'.$tag->name.'</a>';
			    }
			}	
	   	?>
    </div><br class="clear"/>
<?php
    }
?>