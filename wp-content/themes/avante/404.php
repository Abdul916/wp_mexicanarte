<?php
/**
 * The main template file for display error page.
 *
 * @package WordPress
*/


get_header(); 
?>

<!-- Begin content -->

<div id="page-content-wrapper">

    <div class="inner">
    
    	<!-- Begin main content -->
    	<div class="inner-wrapper">
	    	
	    	<h1><?php esc_html_e('Oops! This page can’t befound anywhere.', 'avante' ); ?></h1>
    	
	    	<div class="search-form-wrapper">
		    	<?php esc_html_e( "We're sorry, the page you have looked for does not exist in our content! Perhaps you would like to go to our homepage or try searching below.", 'avante' ); ?>
		    	<br/><br/>
		    	
	    		<form class="searchform" method="get" action="<?php echo esc_url(home_url('/')); ?>">
		    		<p class="input-wrapper">
			    		<input type="text" class="input-effect field searchform-s" name="s" value="<?php the_search_query(); ?>" placeholder="<?php esc_attr_e('Type to search...', 'avante' ); ?>">
						<input type="submit" value="<?php esc_attr_e('Search', 'avante' ); ?>"/>
		    		</p>
			    </form>
    		</div>
	    	
	    	<br/>
	    	
    		</div>
    	</div>
    	
</div>
<br class="clear"/>
<?php get_footer(); ?>